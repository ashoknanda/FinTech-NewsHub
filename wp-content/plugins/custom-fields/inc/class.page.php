<?php
class CF_Page_Field extends Functions{
	
	private $pt;
        
	function __construct() {
	}

        function setter( $options, $objects ) {
            foreach( $options as $name => &$opt )
                $this->{$name} = &$opt;
            foreach( $objects as $name => &$obj )
                    $this->{$name} = &$obj;

            //if( !defined('DOING_AJAX') ){
                add_action( 'admin_menu', array(&$this, 'submenu' ) );
            //}
	}

	function submenu() {
		add_submenu_page( $this->id_menu, __('Fields', 'custom_fields'), __('Fields', 'custom_fields'), 'manage_options', 'custom_fields-' . $this->post_type, array(&$this, 'displayAdminFormFields') );
	}
	
	function displayAdminFormFields() {
		global $current_screen;
		$this->get_var('sidebars_fields');
		include( SCF_DIR . '/inc/admin.tpl.php' );
	}
	
	function cf_get_field_defaults() {
		$defaults = array();
	
		foreach ( (array) $this->cf_registered_fields as $index => $sidebar )
			$defaults[$index] = array();
	
		return $defaults;
	}
	
	function retrieve_fields() {
		//global $cf_registered_field_updates;
		$_sidebars_fields = array();
		$sidebars = array_keys($this->cf_registered_sidebars);
		unset( $this->sidebars_fields['array_version'] );
		$old = array_keys($this->sidebars_fields);
		sort($old);
		sort($sidebars);

		//if ( $old == $sidebars || count($sidebars) > count($old))
		//	return;
	
		// Move the known-good ones first
		foreach ( $sidebars as $id ) {
			if ( array_key_exists( $id, $this->sidebars_fields ) ) {
				$_sidebars_fields[$id] = $this->sidebars_fields[$id];
				unset($this->sidebars_fields[$id], $sidebars[$id]);
			}
		}
	
		// if new theme has less sidebars than the old theme
		if ( !empty($this->sidebars_fields) ) {
			foreach ( $this->sidebars_fields as $val ) {
				if ( is_array($val) && isset($_sidebars_fields['cf_inactive_fields']) )
					$_sidebars_fields['cf_inactive_fields'] = array_merge( (array) $_sidebars_fields['cf_inactive_fields'], $val );
				elseif ( is_array($val) )
					$_sidebars_fields['cf_inactive_fields'] = $val;
			}
		}
		
		// discard invalid, theme-specific fields from sidebars
		$shown_fields = array();
		foreach ( $_sidebars_fields as $sidebar => $fields ) {
			if ( !is_array($fields) )
				continue;
	
			$_fields = array();
			foreach ( $fields as $field ) {
				if ( isset($this->cf_registered_fields[$field]) )
					$_fields[] = $field;
			}
			$_sidebars_fields[$sidebar] = $_fields;
			$shown_fields = array_merge($shown_fields, $_fields);
		}

		$this->sidebars_fields = $_sidebars_fields;
		unset($_sidebars_fields, $_fields);
		
		// find hidden/lost multi-field instances
		$lost_fields = array();
		foreach ( $this->cf_registered_fields as $key => $val ) {
			if ( in_array($key, $shown_fields, true) )
				continue;
	
			$number = preg_replace('/.+?-([0-9]+)$/', '$1', $key);
	
			if ( 2 > (int) $number )
				continue;
	
			//$lost_fields[] = $key;
		}
		$this->sidebars_fields['cf_inactive_fields'] = array_merge($lost_fields, (array) $this->sidebars_fields['cf_inactive_fields']);
				
		$this->cf_set_sidebars_fields($this->sidebars_fields);
	}
}