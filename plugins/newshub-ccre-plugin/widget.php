<?php
class CCRE_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'ccre_widget', 'CCRE Related Posts', array( 'description' => 'Display related products &  blog posts on your sidebar' ) );
	}


	public function form( $instance ) {
		$defaults = $this->default_options( $instance );


	}

	private function default_options( $instance ) {

		return $options;
	}

	public function update( $new, $old ) {
		$instance = wp_parse_args( $new, $old );
		return $instance;
	}

	public function widget( $args, $instance ) {
		// Find default args
		extract( $args );

		// Get our posts
		$defaults			= $this->default_options( $instance );
		$options['limit']	= (int) $defaults[ 'number' ];
		$options['range']	= $defaults['timeline'];	

		?>
			<div class="ccre_widget nh-watson-articles ibm-card__content ibm-link-list nh-custom_post_list">
				<div class="ccre_widget_head">
						<svg width="37px" height="34px" viewBox="1068 587 37 34" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					    <!-- Generator: Sketch 40.3 (33839) - http://www.bohemiancoding.com/sketch -->
						    <desc>Watson</desc>
						    <defs></defs>
						    <g id="Watson-Logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(1069.000000, 588.000000)" stroke-linecap="round" stroke-linejoin="round">
						        <path d="M23.6176269,9.40306154 C29.4720885,12.7180256 31.4779346,20.0617307 28.0981654,25.8039363 C24.7173769,31.5461418 17.2311269,33.513527 11.3766654,30.1985629" id="Stroke-1" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M14.3787077,8.19064042 C17.3915538,7.41188379 20.7060923,7.75477663 23.6180346,9.40326148" id="Stroke-3" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M11.3766654,30.198463 C8.34751154,28.4829991 6.3488,25.6898719 5.59253077,22.5978382" id="Stroke-5" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M0.104788462,9.95189003 L3.55182692,11.9042799" id="Stroke-7" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M7.45568462,2.74194314 L9.44624231,6.1228866" id="Stroke-9" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M17.4971462,0.102967823 L17.4971462,4.00674789" id="Stroke-11" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M27.5386077,2.74194314 L25.54805,6.1228866" id="Stroke-13" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M34.8894019,9.95189003 L31.4423635,11.9042799" id="Stroke-15" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M11.3776846,30.1965636 C8.76743462,28.7180256 9.39120385,22.8658544 12.7709731,17.1246485 C16.1497231,11.382443 21.0063577,7.92652296 23.6166077,9.40506092" id="Stroke-17" stroke="#000000" stroke-width="1.50841953"></path>
						        <path d="M28.0429231,25.8915089 C25.9086538,29.5173758 19.4334808,29.7702968 13.5800385,26.4553327 C7.72659615,23.1403686 4.71171154,17.5141268 6.84598077,13.8882599 C8.08536538,11.7829178 10.7883654,10.8152202 13.9826346,11.0221556" id="Stroke-19" stroke="#000000" stroke-width="1.50841953"></path>
						    </g>
						</svg>  
					<h4 class="ibm-h4 ibm-bold postgrid-title">Watson suggests</h4>
				</div>
				<p class="ibm-h4 ccre_widget_loader"><span class="ibm-spinner"></span>
				<div class="ccre_widget_entries ibm-small tagged-list">

				</div>
			</div>

		<?php	

		wp_reset_postdata();
	}	
}
	