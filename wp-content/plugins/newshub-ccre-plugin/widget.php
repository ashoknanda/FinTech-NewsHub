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
			<div class="ccre_widget">
				<div class="ccre_widget_head">
					<h4 class="ibm-h4 ibm-bold postgrid-title">Watson suggests these related products and courses</h4>
					<div><img width="" height="" src="<?php echo plugins_url( 'img/watson_logo.png', __FILE__ ) ?>" alt="watson-logo" />  </div>
				</div>
				<p class="ibm-h4 ccre_widget_loader"><span class="ibm-spinner"></span>
				<ul class="ccre_widget_entries ibm-small">

				</ul>
			</div>

		<?php	

		wp_reset_postdata();
	}	
}
	