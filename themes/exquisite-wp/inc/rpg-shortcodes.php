<?php
// Shortcode used on old site, rewritten to utilize Foundation alert dialogs
function alert_func( $atts, $content = null ) {

	$type = $atts['type'];
	$types_array = array(
		'error' => 'error',
		'info' => 'information'
	);

	return "
		<div class=\"notification-box $types_array[$type]\">
			<div class=\"icon-holder\">
				<i class=\"fa fa-info-circle\"></i>
			</div>
			<h6>Note:</h6>
			<div class=\"text cf\">
				<p>$content</p>
			</div>
			<a href=\"\" class=\"close\">×</a>
		</div>
	";
}
add_shortcode( 'alert', 'alert_func' );


// Video embed shortcode used on old site, rewritten to utilize wp_oembed
function video_func( $atts, $content = null ) {
	$type = esc_attr( $atts['type'] );
	$id = esc_attr( $atts['id'] );
	switch ( $type ) {
		case 'youtube':
			return wp_oembed_get( 'http://www.youtube.com/watch?v=' . $id );
			break;
		case 'vimeo':
			return wp_oembed_get( 'http://vimeo.com/' . $id );
			break;
	}
}
add_shortcode( 'video', 'video_func' );


// Shortcode used on old site-- just strip the shortcode and return the content
function responsive_func( $atts, $content = null ){
	return $content;
}
add_shortcode( 'responsive', 'responsive_func' );


// Shortcode used on old site-- just strip the shortcode and return the content
function custom_table_func( $atts, $content = null ){
	return $content;
}
add_shortcode( 'custom_table', 'custom_table_func' );


// Shortcode used on old site-- return nothing
function hr_func( $atts ){
	return "";
}
add_shortcode( 'hr', 'hr_func' );
?>