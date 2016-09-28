<?php

$cminds_plugin_config = array(
	'plugin-is-pro'				 => TRUE,
	'plugin-has-addons'			 => TRUE,
	'plugin-addons'				 => array(
		array(
			'title' => 'Anonymous User Posting Add-On',
			'description' => 'Anonymous User Posting adds the option for non logged-in users to post questions, answers and comments in the CM Answer discussion board.',
			'link' => 'https://www.cminds.com/store/cm-answer-anonymous-user-posting-cm-plugins-store/',
			'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=15029&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1'
		),
		array(
			'title' => 'Import and Export Add-On',
			'description' => 'Allow mass imports of questions and moving content between sites.',
			'link' => 'https://www.cminds.com/store/cm-answers-import-and-export-add-on-for-wordpress/',
			'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=45056&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1'
		),
		array(
			'title' => 'Anspress Import AddOn',
			'description' => 'Import all questions, answers and categories from AnsPress to the CM Answers WordPress Plugin.',
			'link' => 'https://www.cminds.com/store/answers-anspress-import-addon-for-wordpress-by-creativeminds/',
			'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=64521&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1'
		),
		array(
			'title' => 'Ask the Expert',
			'description' => 'Ask the experts and get quick answers system for WordPress. Ask a question and get an answer in Wordpress from a verified Expert.',
			'link' => 'https://www.cminds.com/store/ask-the-expert-wordpress-plugin-by-creativeminds/',
			'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=74773&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1'
		),
		array(
			'title' => 'Idea feedback and Stimulator',
			'description' => 'Idea feedback and stimulation management system. The Idea management tool support the creative process of generating, developing, and communicating new ideas. It supports employee-driven innovation systems and is also good as a teaching and learning assessment tool.',
			'link' => 'https://www.cminds.com/store/cm-answers-idea-stimulator-ideations-addon/',
			'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=66202&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1'
		),
		array(
			'title' => 'MicroPayment Platform Plugin',
			'description' => 'Adds a virtual money and virtual currency micropayments to support in-site transactions for posting and answering questions in CM Answers Pro. Supports WooCommerce and Easy Digital Downloads.',
			'link' => 'https://www.cminds.com/store/micropayments/',
			'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=11388&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1'
		),
	),
	'plugin-show-shortcodes'	 => TRUE,
	'plugin-shortcodes'			 => '<p>You can use the following available shortcodes.</p>',
	'plugin-shortcodes-action'	 => 'cma_display_available_shortcodes',
	'plugin-is-addon'			 => FALSE,
	'plugin-version'			 => CMA::version(),
	'plugin-abbrev'				 => 'cma',
	'plugin-parent-abbrev'		 => 'cma',
	'plugin-settings-url'		 => admin_url( 'admin.php?page=CMA_admin_settings' ),
	'plugin-show-guide'			 => FALSE,
	'plugin-guide-text'			 => '<p>
	The description of the plugin goes here
	</p>',
	'plugin-guide-video-height'	 => 180,
	'plugin-guide-videos'		 => array(
		array( 'title' => 'Video #1 title', 'video_id' => '134490629' ),
		array( 'title' => 'Video #2 title', 'video_id' => '134490629' ),
		array( 'title' => 'Video #3 title', 'video_id' => '134490629' ),
	),
	'plugin-file'				 => CMA_PLUGIN_FILE,
	'plugin-dir-path'			 => plugin_dir_path( CMA_PLUGIN_FILE ),
	'plugin-dir-url'			 => plugin_dir_url( CMA_PLUGIN_FILE ),
	'plugin-basename'			 => plugin_basename( CMA_PLUGIN_FILE ),
	'plugin-icon'				 => '',
	'plugin-name'				 => 'CM Answers Pro',
	'plugin-license-name'		 => 'CM Answers Pro',
	'plugin-slug'				 => '',
	'plugin-short-slug'			 => 'cm-answers',
	'plugin-parent-short-slug'	 => 'cm-answers',
	'plugin-menu-item'			 => CMA_Thread::ADMIN_MENU,
	'plugin-textdomain'			 => 'cm-answers-pro',
	'plugin-userguide-key'		 => '7-cm-answers',
	'plugin-store-url'			 => 'https://www.cminds.com/store/answers/',
	'plugin-support-url'		 => 'https://www.cminds.com/wordpress-plugin-customer-support-ticket/',
	'plugin-review-url'			 => 'https://wordpress.org/support/view/plugin-reviews/cm-answers',
	'plugin-changelog-url'		 => 'https://answers.cminds.com/release-notes/',
	'plugin-licensing-aliases'	 => array( 'CM Answers Pro' ),
);
