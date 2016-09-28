<?php

// Main Styles
function main_styles() {	
		 
		 // Register 
		 wp_register_style('foundation', get_template_directory_uri() . '/assets/css/foundation.css');
		 wp_register_style('flex', get_template_directory_uri() . '/assets/css/flexslider.css');
		wp_register_style("font-awesome", get_stylesheet_directory_uri() . "/assets/css/font-awesome.min.css");
		 wp_register_style("weather-icons", get_stylesheet_directory_uri() . "/assets/css/weather-icons.min.css");
		 wp_register_style("hint", get_stylesheet_directory_uri() . "/assets/css/hint.min.css");
		 wp_register_style("app", get_stylesheet_directory_uri() . "/assets/css/app.css");
		 wp_register_style('selection', get_template_directory_uri() . '/assets/css/selection.php');
		 wp_register_style("ie8", get_template_directory_uri() . "/assets/css/ie8.css");
		 wp_register_style("mp", get_template_directory_uri() . "/assets/css/magnific-popup.css");
		 wp_register_style("fancybox", get_template_directory_uri() . "/assets/css/fancybox/jquery.fancybox.css");
		 
		 // Enqueue
		 wp_enqueue_style('foundation'); 
		 wp_enqueue_style('flex');
		 wp_enqueue_style('font-awesome');
		 wp_enqueue_style('weather-icons');
		 wp_enqueue_style('hint');
		 wp_enqueue_style('app');
		 wp_enqueue_style('selection');
		 wp_enqueue_style('ie8'); 
		 wp_enqueue_style('mp'); 
		 wp_enqueue_style('fancybox'); 
		 
		 //IE 
		 global $wp_styles;
		 $wp_styles->add_data("ie8", 'conditional', 'lt IE 9');
}

add_action('wp_print_styles', 'main_styles');

// Main Scripts
function register_js() {
	
	if (!is_admin()) {
	
		// Register 
		wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.foundation.js', 'jquery');
		wp_register_script('fastclick', get_template_directory_uri() . '/assets/js/fastclick.js', 'jquery', null, TRUE);
		wp_register_script('supersubs', get_template_directory_uri() . '/assets/js/jquery.supersubs.js', 'jquery', null, TRUE);
		wp_register_script('superfish', get_template_directory_uri() . '/assets/js/jquery.superfish.js', 'jquery', null, TRUE);
		wp_register_script('foundation', get_template_directory_uri() . '/assets/js/jquery.foundation.plugins.js', 'jquery', null, TRUE);
		wp_register_script('flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', 'jquery', null, TRUE);
		wp_register_script('isotope', get_template_directory_uri() . '/assets/js/jquery.isotope.min.js', 'jquery', null, TRUE);
		wp_register_script('gmapdep', '//maps.google.com/maps/api/js?sensor=false', false, null, true);
		wp_register_script('gmap', get_template_directory_uri() . '/assets/js/jquery.gmap.min.js', 'jquery', null, TRUE);
		wp_register_script('carousel', get_template_directory_uri() . '/assets/js/jquery.owl.carousel.min.js', 'jquery', null, TRUE);
		wp_register_script('mp', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', 'jquery', null, TRUE);
		wp_register_script('parsley', get_template_directory_uri() . '/assets/js/jquery.parsley.min.js', 'jquery', null, TRUE);
		wp_register_script('sharrre', get_template_directory_uri() . '/assets/js/jquery.sharrre.min.js', 'jquery', null, TRUE);
		wp_register_script('cookie', get_template_directory_uri() . '/assets/js/jquery.cookie.js', 'jquery', null, TRUE);
		wp_register_script('forms', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', 'jquery', null, TRUE);
		wp_register_script('endbox', get_template_directory_uri() . '/assets/js/jquery.endpage-box.min.js', 'jquery', null, TRUE);
		wp_register_script('marquee', get_template_directory_uri() . '/assets/js/jquery.marquee.min.js', 'jquery', null, TRUE);

		wp_register_script('tooltip', get_template_directory_uri() . '/assets/js/jquery.tooltip.js', 'jquery', null, TRUE);
		wp_register_script('widgets-ui', get_template_directory_uri() . '/assets/js/jquery-ui-1.10.4.min.js', 'jquery', null, TRUE);
		wp_register_script('fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.js', 'jquery', null, TRUE);
		wp_register_script('addthisevent', '//addthisevent.com/libs/1.6.0/ate.min.js', 'jquery', null, TRUE);

		wp_register_script('stickynav', get_template_directory_uri() . '/assets/js/rpg.stickynav.js', 'jquery', null, TRUE);
		wp_register_script('app', get_template_directory_uri() . '/assets/js/app.js', 'jquery', null, TRUE);
		wp_register_script('ibm-reporting', get_template_directory_uri() . '/assets/js/report.js', 'jquery', null, TRUE);
		wp_register_script('fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', 'jquery', null, TRUE); // https://github.com/davatron5000/FitVids.js
		wp_register_script('rpg-ajax-news-count', get_template_directory_uri() . '/assets/js/rpg-ajax-news-count.js', 'jquery', null, TRUE);

		wp_register_script('jquery-dateFormat', get_template_directory_uri() . '/assets/js/jquery-dateFormat.min.js', 'jquery', null, TRUE);
		wp_register_script('jstz', get_template_directory_uri() . '/assets/js/jstz.js', 'jquery', null, TRUE);
		wp_register_script('timezone', get_template_directory_uri() . '/assets/js/timezone.js', array('jquery', 'jstz'), null, TRUE);

		wp_register_script('masonry', get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js', 'jquery', null, TRUE);
		wp_register_script('highcharts', get_template_directory_uri() . '/assets/js/highcharts.js', 'jquery', null, TRUE);
		wp_register_script('charttheme', get_template_directory_uri() . '/assets/js/chart-theme.js', 'jquery', null, TRUE);

		// Enqueue
		wp_enqueue_script('modernizr');
		wp_enqueue_script('fastclick');
		wp_enqueue_script('jquery');
		wp_enqueue_script('superfish');
		wp_enqueue_script('supersubs');
		wp_enqueue_script('flexslider');
		wp_enqueue_script('foundation');
		wp_enqueue_script('carousel');
		wp_enqueue_script('mp');
		wp_enqueue_script('forms');
		wp_enqueue_script('marquee');
		wp_enqueue_script('tooltip');
		wp_enqueue_script('widgets-ui');
		wp_enqueue_script('fancybox');
		wp_enqueue_script('addthisevent');
		wp_enqueue_script('stickynav');
		wp_enqueue_script('app');
		wp_enqueue_script('ibm-reporting');
		wp_enqueue_script('fitvids');
		wp_enqueue_script('rpg-ajax-news-count');
		wp_enqueue_script('jquery-dateFormat');						
		wp_enqueue_script('jstz');	
		wp_enqueue_script('timezone');	
		wp_enqueue_script('masonry');
		wp_enqueue_script('highcharts');
		wp_enqueue_script('charttheme');
	}
}
add_action('init', 'register_js');

// Admin Scripts
function thb_admin_scripts() {
	global $pagenow;
	if(in_array( $pagenow, array( 'post.php', 'post-new.php') )) {
		wp_register_script('thb-admin-meta', get_template_directory_uri() .'/assets/js/admin-meta.js', array('jquery'));
		wp_enqueue_script('thb-admin-meta');
		
		wp_register_style("thb-admin-css", get_template_directory_uri() . "/assets/css/admin.css");
		wp_enqueue_style('thb-admin-css'); 

		wp_register_script('jstz', get_template_directory_uri() . '/assets/js/jstz.js', 'jquery', null, TRUE);
		wp_enqueue_script('jstz');	

		wp_register_script('timezone', get_template_directory_uri() .'/assets/js/timezone.js', array('jquery', 'jstz'));
		wp_enqueue_script('timezone');
	}
}
add_action('admin_enqueue_scripts', 'thb_admin_scripts');

function single_scripts() {
	if (is_singular(array( 'post', 'ibm_event', 'ibm_media' ))) {
		wp_enqueue_script('sharrre');
		wp_enqueue_script('cookie');
		wp_enqueue_script('endbox');
	}
}
add_action('wp_print_scripts', 'single_scripts');

function isotope_scripts() {
	if (is_archive() || is_search() || is_page(1846)) {
		wp_enqueue_script('isotope');
	}
}
add_action('wp_print_scripts', 'isotope_scripts');


function contact_scripts() {
	if (is_page_template('template-contact.php')) {
		wp_enqueue_script('gmapdep');
		wp_enqueue_script('gmap');
	}
}
add_action('wp_print_scripts', 'contact_scripts');

// De-register Contact Form 7 styles
remove_action( 'wp_enqueue_scripts', 'wpcf7_enqueue_styles' ); // Prevents the styles from loading on all pages
?>
