<?php
add_theme_support('nav-menus');
add_action('init','register_my_menus');

function register_my_menus() {
	register_nav_menus(
		array(
			'super-header' => __( 'Superheader (Black Bar) Menu',THB_THEME_NAME ),
			'top-menu' => __( 'Top Bar Menu',THB_THEME_NAME ),
			'footer-menu' => __( 'Sub Footer Menu',THB_THEME_NAME ),
			'home-slide1' => __( 'Home Slider - 4 Column',THB_THEME_NAME ),
			'home-slide2' => __( 'Home Slider - Hero',THB_THEME_NAME ),
		)
	);
}

?>