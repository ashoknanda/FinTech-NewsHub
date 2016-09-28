<?php
/*
Plugin Name: EI IBM OpenID Connect
Description:  Connect to OpenID Connect IdP with Authorization Code Flow
Version: 1.0
Author: Yaser Doleh
License: GPLv2 Copyright (c) 2014 shirounagi
Text Domain: ei-ibm-openid-connect
Domain Path: /language
*/

class EIIBMOpenIDConnect {

	/* Plugin identifer */
	const PLUGIN_ID = 'ei_ibm_openid_con';

	/* config parameters on admin page. */
	static $ADMIN_PARAMETERS = array(
		'admin_host'    => 'Admin Host',
		'admin_enable_sso'    => 'Enable SSO',
		'admin_ep_login'      => 'Login Endpoint URL',
		'admin_ep_token'      => 'Token Validation Endpoint URL',
		'admin_ep_userinfo'   => 'Userinfo Endpoint URL',
		'admin_redirect'      => 'Redirect URL',
		'admin_no_sslverify'  => 'Disable SSL Verify',
		'admin_client_id'     => 'Client ID',
		'admin_client_secret' => 'Client Secret Key',
		'admin_scope'         => 'OpenID Scope',
		'admin_identity_key'  => 'Identity Key',
		'admin_allowed_regex' => ''
	);
	static $PUBLIC_PARAMETERS = array(
		'pub_host'    => 'Public Host',
		'pub_enable_sso'    => 'Enable SSO',
		'pub_ep_login'      => 'Login Endpoint URL',
		'pub_ep_token'      => 'Token Validation Endpoint URL',
		'pub_ep_userinfo'   => 'Userinfo Endpoint URL',
		'pub_redirect'      => 'Redirect URL',
		'pub_no_sslverify'  => 'Disable SSL Verify',
		'pub_client_id'     => 'Client ID',
		'pub_client_secret' => 'Client Secret Key',
		'pub_scope'         => 'OpenID Scope',
		'pub_identity_key'  => 'Identity Key',
		'pub_allowed_regex' => ''
	);

	static $ERR_MES = array(
		1  => 'Cannot get authorization response',
		2  => 'Cannot get token response',
		3  => 'Cannot get user claims',
		4  => 'Cannot get valid token',
		5  => 'Cannot get user key',
		6  => 'Cannot create authorized user',
		7  => 'User creation failed',
		99 => 'Unknown error'
	);

	public function __construct() {
	    add_action( 'login_form', array( &$this, 'login_form' ) );
            add_action('init', array ( &$this, 'output_buffer'));
            add_action('pre_get_posts', array( &$this, 'sso_auth_user'));
		if ( is_admin() ) {
			//AJAX stuff
			add_action( 'wp_ajax_openidconn-callback', array( $this, 'callback' ) );
			add_action( 'wp_ajax_nopriv_openidconn-callback', array( $this, 'callback' ) );
			
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		foreach ( self::$PUBLIC_PARAMETERS as $key => $val ) {
			$this->$key = get_option( self::PLUGIN_ID . '_' .$key );
		}
		foreach ( self::$ADMIN_PARAMETERS as $key => $val ) {
			$this->$key = get_option( self::PLUGIN_ID . '_' . $key );
		}
//		$this->redirect_url = admin_url( 'admin-ajax.php?action=openidconn-callback' );
	}

	public function output_buffer() {
		ob_start();
	}

	public function sso_auth_user() {
	    if ( is_user_logged_in() ) { 
		if ( $_SERVER['HTTP_HOST'] == $this->pub_host && !isset($_COOKIE['PD-ID']) ) {
		    wp_clear_auth_cookie();
		    wp_redirect ( $_SERVER['REQUEST_URI'] );
		    ob_flush();
		    exit;
		}
		return; 
	    }
	    if ( !isset($_COOKIE['PD-ID'])) { return; }
	    if ( isset($_GET['code'])) {
		$this->callback();
		ob_flush();
		exit;
	    }
	    if ( $this->pub_enable_sso && $_SERVER['HTTP_HOST'] == $this->pub_host ) { 
	    wp_redirect( $this->pub_ep_login . '?scope=' . urlencode( $this->pub_scope ) . '&response_type=code&client_id=' . urlencode( $this->pub_client_id ) . '&state=' . $_SERVER['REQUEST_URI'] . '&redirect_uri=' . urlencode( $this->pub_redirect ));
	    return;
            }
	}
	/**
	 * handles the callback and authenticates against OpenID Connect API.
	 * 
	 * performed by wp_ajax*_callback action
	 *
	 */
	public function callback() {
		if ( !isset( $_GET['code'] ) ) {
			$this->error_redirect(1);
		} elseif ( isset( $_GET['error'] ) ) {
			$this->error_redirect(99);
		}

		$ep_token = $_SERVER['HTTP_HOST'] == $this->admin_host ? $this->admin_ep_token : $this->pub_ep_token;
		$client_id = $_SERVER['HTTP_HOST'] == $this->admin_host ? $this->admin_client_id : $this->pub_client_id;
		$client_secret = $_SERVER['HTTP_HOST'] == $this->admin_host ? $this->admin_client_secret : $this->pub_client_secret;
		$redirect_uri = $_SERVER['HTTP_HOST'] == $this->admin_host ? $this->admin_redirect : $this->pub_redirect;

		$token_result = wp_remote_post(
			$ep_token,
			$this->get_wp_request_parameter(array(
				'body' => array(
					'code'          => $_GET['code'],
					'client_id'     => $client_id,
					'client_secret' => $client_secret,
					'redirect_uri'  => $redirect_uri,
					'grant_type'    => 'authorization_code'
				)
			)
		));

		if ( is_wp_error( $token_result ) ) {
			$this->error_redirect(2);
		}
		$token_response = json_decode( $token_result['body'], true );
		if ( isset( $token_response['id_token'] ) ) {
			$jwt_arr = explode('.', $token_response['id_token'] );
			$user_claim = json_decode( base64_decode($jwt_arr[1] ), true );

// code to work around ibm w3 bug auth sending corrupt data. 

			if ( ! isset($user_claim) ) {
			    $ibm_temp = base64_decode($jwt_arr[1]);
			    $ibm_pos = strpos($ibm_temp, ',"blueGroups":' );
			    $ibm_temp = substr($ibm_temp, 0, $ibm_pos) . '}';
			    $user_claim = json_decode($ibm_temp, true);
			}
		} elseif ( isset( $token_response['access_token'] ) ){
			$user_claim_result = wp_remote_get(
				$this->ep_userinfo . '?access_token=' . $token_response['access_token'],
				$this->get_wp_request_parameter( array() )
			);
			$user_claim = json_decode($user_claim_result['body'], true);

// code to work around ibm w3 bug auth sending corrupt data. 

			if ( ! isset($user_claim) ) {
			    $ibm_temp = $user_claim_result['body'];
			    $ibm_pos = strpos($ibm_temp, ',"blueGroups":' );
			    $ibm_temp = substr($ibm_temp, 0, $ibm_pos) . '}';
			    $user_claim = json_decode($ibm_temp, true);
			}
			if( is_wp_error($user_claim_result)) {
				$this->error_redirect(3);
			}
		} else {
			$this->error_redirect(4);
		}
		$user_id='';
		$fname='';
		$lname='';
		$a_email='';
		$user_email='';
		if ( $_SERVER['HTTP_HOST'] == $this->admin_host ) {
		    $user_id   = $user_claim[$this->admin_identity_key];
		    $fname = $user_claim['firstName'];
                    $lname = $user_claim['lastName'];
		    $a_email = $user_claim['emailAddress'];
		} else {
		    $user_id   = $user_claim[$this->pub_identity_key];
		    $fname = $user_claim['given_name'];
                    $lname = $user_claim['family_name'];
		    $a_email = $user_claim['email'];
		}
		if ( is_array($a_email) ) {
		    $user_email = current($a_email);
		} else {
		    $user_email = $a_email;
		}
		if ( strlen($user_id) == 0 ) {
			$this->error_redirect(5);
		}

		$oauth_expiry = $token_response['expires_in'] + current_time( 'timestamp', true );
		$user = get_user_by( 'login', $user_id );
		if ( ! isset ($user->ID )) { 
		    $user = get_user_by( 'email', $user_email);
		}
		if (! isset( $user->ID ) ) {
			// challenge user create
			$allowed_regex = $_SERVER['HTTP_HOST'] == $this->admin_host ? $this->admin_allowed_regex : $this->pub_allowed_regex;
			if ( strlen( $allowed_regex ) > 0 && preg_match( $allowed_regex, $user_id ) ===  1) {
				$uid = wp_create_user( $user_id, wp_generate_password( 12, false ), $user_email );
		    		$uid_up = wp_update_user( array( 'ID' => $uid, 'first_name' => $fname, 'last_name' => $lname, 'user_email' => $user_email ) );
				$user = get_user_by( 'id', $uid );
			} else {
				$this->error_redirect(6, $user_id);
			}
			if (! isset( $user->ID ) ) {
				$this->error_redirect(7, $user_id);
			}
		} else {
		    $uid_up = wp_update_user( array( 'ID' => $user->ID, 'first_name' => $fname, 'last_name' => $lname, 'user_email' => $user_email ) );
		    if ( ! isset($uid_up->ID) ) {
		    	error_log('Failed to update user: ' . $uid);
		    }
		}
		wp_set_auth_cookie( $user->ID, false );
		if (isset( $_GET['state'])) {
		    wp_redirect( $_GET['state'] );
		    return;
		}
		if ( $_SERVER['HTTP_HOST'] == $this->admin_host ) {
		    wp_redirect(admin_url());
		} else {
		    wp_redirect(site_url());
		}
	}

	private function get_wp_request_parameter($args) {
		if ( $this->no_sslverify ) {
			$args['sslverify'] = false;
		}
		return $args;
    }

	private function error_redirect($errno, $authed_username='') {
		print ('Login Failed: error=' . $errno . ' Username=' . $authed_username );
		exit;
	}

	/**
	 * check_option - used by launchkey_page_init
	 * @return array
	 */
	public function pub_check_option( $input ) {
		$options = array();
		foreach ( array_keys( self::$PUBLIC_PARAMETERS ) as $key ) {
			if ( in_array($key, array( 'pub_enable_sso', 'pub_no_sslverify') ) ) {
				$value = isset( $input[$key] );
				$this->update_option_item( $key, $value );
				array_push( $options, $value );
			} else {
				array_push( $options, $this->check_option_item($key, $input) );
			}
		}
		return $options;
	}
	public function admin_check_option( $input ) {
		$option = array();
		foreach ( array_keys( self::$ADMIN_PARAMETERS ) as $key ) {
			if ( in_array($key, array( 'admin_enable_sso', 'admin_no_sslverify') ) ) {
				$value = isset( $input[$key] );
				$this->update_option_item( $key, $value );
				array_push( $options, $value );
			} else {
				array_push( $options, $this->check_option_item($key, $input) );
			}
		}
		return $options;
	}

	private function check_option_item( $key, &$input ) {
		if ( isset( $input[$key] ) ) {
			$value = trim( $input[$key] );
			$this->update_option_item( $key, trim( $value ) );
		} else {
			$value = '';
		}
		return $value;
	}

	private function update_option_item($key, $value) {
		if ( get_option( self::PLUGIN_ID . '_' . $key ) === FALSE ) {
			add_option( self::PLUGIN_ID . '_' . $key , $value );
		} else {
			update_option( self::PLUGIN_ID . '_' . $key , $value );
		}
	}

	/**
	 * create_admin_menu - used by launchkey_plugin_page
	 */
	public function create_admin_menu_admin() {
		echo '<div class="wrap">';
		screen_icon();
		echo '    <h2>EI IBM Open ID Admin</h2>';
		echo '    <form method="post" action="options.php">';
		settings_fields( 'ibm_openid_connect_option_admin' );
		do_settings_sections( 'ibm-openid-connect-setting-admin' );
		submit_button();
		echo '    </form>';
		echo '</div>';
	}

	public function create_admin_menu_public() {
		echo '<div class="wrap">';
		screen_icon();
		echo '    <h2>EI IBM Open ID Pubic</h2>';
		echo '    <form method="post" action="options.php">';
		settings_fields( 'ibm_openid_connect_option_public' );
		do_settings_sections( 'ibm-openid-connect-setting-public' );
		submit_button();
		echo '    </form>';
		echo '</div>';
	}

	public function pub_print_text_field($args) {
		list($key, $css_class, $add_opt) = $args;
		echo '<input type="text" id="' . $key . '" class="' . $css_class . '" name=' . self::PLUGIN_ID . '_pub_array_key[' . $key . ']" value="' . $this->$key . '" ' . $add_opt . '>';
    }
	public function admin_print_text_field($args) {
		list($key, $css_class, $add_opt) = $args;
		echo '<input type="text" id="' . $key . '" class="' . $css_class . '" name=' . self::PLUGIN_ID . '_admin_array_key[' . $key . ']" value="' . $this->$key . '" ' . $add_opt . '>';
    }
    	public function admin_print_bool_field($key) {
		echo '<input type="checkbox" id="' . $key . '" name="' . self::PLUGIN_ID . '_admin_array_key[' . $key . ']" value="1" ' . ($this->$key == '1' ? 'checked="checked"' : '' ) . '>';
    }
    	public function pub_print_bool_field($key) {
		echo '<input type="checkbox" id="' . $key . '" name="' . self::PLUGIN_ID . '_pub_array_key[' . $key . ']" value="1" ' . ($this->$key == '1' ? 'checked="checked"' : '' ) . '>';
    }
	/**
	 * wp-login.php with openid connect
	 *
	 * @access public
	 * @return void
	 */
	public function login_form() {
	    if ( isset($_GET['loggedout']) && $_GET['loggedout'] == 'true' ) {
		wp_redirect('https://w3id.tap.ibm.com/pkmslogout');
		return;
	    }
	    if ( isset($_GET['use_sso']) && $_GET['use_sso'] == 'false' ) {
		return;
	    }
    	    $w3id_url = '';
/*	    if ($_SERVER['HTTP_HOST'] == $this->admin_host ) {
		$w3id_url = $w3id_url . $this->admin_ep_login . '?scope=' . urlencode( $this->admin_scope ) . '&response_type=code&client_id=' . urlencode( $this->admin_client_id ) . '&state=' . admin_url( 'admin-ajax.php?action=openidconn-callback') . '&redirect_uri=' . urlencode( $this->admin_redirect );
	        echo '<div style="text-align: center;">' . '<a href=' . $w3id_url . '> Click here to login with w3id </a> </div>';
	    } 
*/
	    if ( $this->admin_enable_sso && $_SERVER['HTTP_HOST'] == $this->admin_host ) {
	        wp_redirect( $this->admin_ep_login . '?scope=' . urlencode( $this->admin_scope ) . '&response_type=code&client_id=' . urlencode( $this->admin_client_id ) . '&state=' . admin_url( 'admin-ajax.php?action=openidconn-callback') . '&redirect_uri=' . urlencode( $this->admin_redirect ));
	    }

	    if ( $this->pub_enable_sso && $_SERVER['HTTP_HOST'] == $this->pub_host ) {
	        wp_redirect( $this->pub_ep_login . '?scope=' . urlencode( $this->pub_scope ) . '&response_type=code&client_id=' . urlencode( $this->pub_client_id ) . '&state=' . admin_url( 'admin-ajax.php?action=openidconn-callback' ) . '&redirect_uri=' . urlencode( $this->pub_redirect ) );
	    }
	    return;
	}

	/**
	 * admin_init
	 * 
	 * Invoked by admin_init action
	 */
	public function admin_init() {
		$this->admin_side_init();
		$this->public_side_init();
	}
	private function admin_side_init() {
		register_setting( 'ibm_openid_connect_option_admin', self::PLUGIN_ID . '_admin_array_key', array( $this, 'admin_check_option' ) );
		
		add_settings_section( 'admin_setting_section_id', 'EI IBM Open Connect Admin Settings', array( $this, 'openid_connect_section_info'), 'ibm-openid-connect-setting-admin');

		foreach ( self::$ADMIN_PARAMETERS as $key => $description ) {
			if ( in_array( $key, array( 'admin_enable_sso',  'admin_no_sslverify' ) ) ) {
				add_settings_field( $key, $description, array( $this, 'admin_print_bool_field' ), 'ibm-openid-connect-setting-admin', 'admin_setting_section_id', $key );
			} elseif ( $key == 'admin_allowed_regex' ) {
				continue;
			} else {
				add_settings_field( $key, $description, array( $this, 'admin_print_text_field' ), 'ibm-openid-connect-setting-admin', 'admin_setting_section_id', array( $key, 'large-text', '' ));
			}
		}

		add_settings_section( 'app_setting_section_id', 'Authorization Settings', array( 
				$this, 
				'openid_connect_app_settings_section_info' 
			), 'ibm-openid-connect-setting-admin');

		add_settings_field( 'admin_allowed_regex', 'Admin Allowed regex', array( $this, 'admin_print_text_field' ),
			'ibm-openid-connect-setting-admin', 'app_setting_section_id', array( 'admin_allowed_regex', 'large-text', '' ));
	}

	private function public_side_init() {
		register_setting( 'ibm_openid_connect_option_public', self::PLUGIN_ID . '_pub_array_key', array( $this, 'pub_check_option' ) );
		
		add_settings_section( 'public_setting_section_id', 'EI IBM Open Connect Public Settings', array( $this, 'openid_connect_section_info'), 'ibm-openid-connect-setting-public');

		foreach ( self::$PUBLIC_PARAMETERS as $key => $description ) {
			if ( in_array( $key, array( 'pub_enable_sso',  'pub_no_sslverify' ) ) ) {
				add_settings_field( $key, $description, array( $this, 'pub_print_bool_field' ), 'ibm-openid-connect-setting-public', 'public_setting_section_id', $key );
			} elseif ( $key == 'pub_allowed_regex' ) {
				continue;
			} else {
				add_settings_field( $key, $description, array( $this, 'pub_print_text_field' ), 'ibm-openid-connect-setting-public', 'public_setting_section_id', array( $key, 'large-text', '' ));
			}
		}

		add_settings_section( 'app_setting_section_id', 'Authorization Settings', array( 
				$this, 
				'openid_connect_app_settings_section_info' 
			), 'ibm-openid-connect-setting-public');

		add_settings_field( 'pub_allowed_regex', 'Admin Allowed regex', array( $this, 'pub_print_text_field' ),
			'ibm-openid-connect-setting-public', 'app_setting_section_id', array( 'pub_allowed_regex', 'large-text', '' ));
	}

	/**
	 * admin_menu
	 * 
	 * this function is invoked by admin_menu action
	 */
	public function admin_menu() {
		// Plugin Settings page and menu item
		add_options_page( 'IBM OpenID Connect Admin', 'IBM OpenID Connect Admin', 'manage_options', 'ibm-openid-connect-setting-admin', array( $this, 'create_admin_menu_admin' ) );
		add_options_page( 'IBM OpenID Connect Public', 'IBM OpenID Connect Public', 'manage_options', 'ibm-openid-connect-setting-public', array( $this, 'create_admin_menu_public' ) );
	}

	public function openid_connect_section_info() {
		echo '<p>Enter IBM OpenID Connect Idp settings</p>';
	}

	public function openid_connect_app_settings_section_info() {
		echo 'Limit account names to allow authorization by regex';
	}

}

new EIIBMOpenIDConnect();
?>
