<?php

include_once(__DIR__.'/../../../themes/ibmNorthstar-child/_includes/NH_renderArticleSource.function.php');
include_once __DIR__.'/../../../themes/ibmNorthstar-child/_includes/NH_trim_text.function.php';
include_once __DIR__.'/../../../themes/ibmNorthstar-child/_includes/NH_getCardBgColor.function.php';

class WMP_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'wmp_widget', 'WP Most Popular', array( 'description' => 'Display your most popular blog posts on your sidebar' ) );
	}

	public function form( $instance ) {
		$defaults = $this->default_options( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $defaults['title']; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show:</label><br />
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $defaults['number']; ?>" size="3">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>">Choose post type:</label><br />
			<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<option value="all">All post types</option>
				<?php
				$post_types = get_post_types( array( 'public' => true ), 'names' );
				foreach ($post_types as $post_type ) {
					// Exclude attachments
					if ( $post_type == 'attachment' ) continue;
					$defaults['post_type'] == $post_type ? $sel = " selected" : $sel = "";
					echo '<option value="' . $post_type . '"' . $sel . '>' . $post_type . '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'timeline' ); ?>">Timeline:</label><br />
			<select id="<?php echo $this->get_field_id( 'timeline' ); ?>" name="<?php echo $this->get_field_name( 'timeline' ); ?>">
				<option value="all_time"<?php if ( $defaults['timeline'] == 'all_time' ) echo "selected"; ?>>All time</option>
				<option value="monthly"<?php if ( $defaults['timeline'] == 'monthly' ) echo "selected"; ?>>Past month</option>
				<option value="weekly"<?php if ( $defaults['timeline'] == 'weekly' ) echo "selected"; ?>>Past week</option>
				<option value="daily"<?php if ( $defaults['timeline'] == 'daily' ) echo "selected"; ?>>Today</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>">Show thumbnail:</label><br />
			<select id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>">
				<option value="none"<?php if ( $defaults['thumbnail'] == 'none' ) echo "selected"; ?>>Do not show</option>
				<option value="before_title"<?php if ( $defaults['thumbnail'] == 'before_title' ) echo "selected"; ?>>Before title</option>
				<option value="after_title"<?php if ( $defaults['thumbnail'] == 'after_title' ) echo "selected"; ?>>After title</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumbnail_size' ); ?>">Thumbnail size:</label><br />
			<input id="<?php echo $this->get_field_id( 'thumbnail_size' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_size' ); ?>" type="text" value="<?php echo $defaults['thumbnail_size']; ?>">
			<br><small>Image size name or 100x100 for custom size</small>
		</p>
		<?php
	}

	private function default_options( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
			$options['title'] = esc_attr( $instance[ 'title' ] );
		else
			$options['title'] = 'Trending';

		if ( isset( $instance[ 'number' ] ) )
			$options['number'] = (int) $instance[ 'number' ];
		else
			$options['number'] = 5;

		if ( isset( $instance[ 'post_type' ] ) )
			$options['post_type'] = esc_attr( $instance[ 'post_type' ] );
		else
			$options['post_type'] = 'all';

		if ( isset( $instance[ 'timeline' ] ) )
			$options['timeline'] = esc_attr( $instance[ 'timeline' ] );
		else
			$options['timeline'] = 'all_time';
			
		if ( isset( $instance[ 'thumbnail' ] ) )
			$options['thumbnail'] = esc_attr( $instance[ 'thumbnail' ] );
		else
			$options['thumbnail'] = 'none';

		if ( isset( $instance[ 'thumbnail_size' ] ) )
			$options['thumbnail_size'] = esc_attr( $instance[ 'thumbnail_size' ] );
		else
			$options['thumbnail_size'] = 'thumbnail';

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

		if ( $defaults['post_type'] != 'all' ) {
			$options['post_type'] = $defaults['post_type'];
		}

		$posts			= wp_most_popular_get_popular( $options );
		$thumbnail_size	= preg_match("/\d{1,}x\d{1,}/", $defaults['thumbnail_size']) === 1 ? explode('x', $defaults['thumbnail_size']):  $defaults['thumbnail_size'];

		// Display the widget
		echo $before_widget;
		if ( $defaults['title'] ) echo $before_title . $defaults['title'] . $after_title;
		echo apply_filters( 'wp_most_popular_list_before', '<ul class="wp-most-popular tagged-list">' );
		global $post;
		foreach ( $posts as $post ):
			do_action( 'wp_most_popular_list_item', $post, $defaults );
		endforeach;
		echo apply_filters( 'wp_most_popular_list_after', '</ul>' );
		echo $after_widget;

		// Reset post data
		wp_reset_postdata();
	}

	public static function list_items( $post, $defaults ) {
		setup_postdata( $post );
		$post_id				= get_the_ID();
		$title					= get_the_title() ? get_the_title() : $post_id;
		$post_class			= implode(get_post_class());
		  $postsource = null;
		  $postauthor = null;
		  $authID = $post->post_author;
		  $userdata = get_userdata($authID);
		  $postauthor =  $userdata->user_nicename; //Setting author to post author set in WP if Newscred nc-author does not exist. 
		  $custom_fields = get_post_custom($post->ID);

		  $nc_author = $custom_fields['nc-author']?$custom_fields['nc-author']:"";
		  $nc_source = $custom_fields['nc-source']?$custom_fields['nc-source']:array();
		  $nc_source_group = $custom_fields['nc-source-group'] ? $custom_fields['nc-source-group'] : array();
		  $nc_source_abbrev = 'T';
		  
		  if(isset($nc_author)){
		    foreach ( $nc_author as $key => $value ) {
		      $postauthor = $value;
		    }    
		  }

		$postsource = isset($nc_source_group[0]) == true ? $nc_source_group[0] : (isset($nc_source[0])==true ? $nc_source[0] : 'THINK Marketing');

		if(strcasecmp ( $postsource , "ibm commerce" ) == 0){
			$postsource = 'THINK Marketing';
			$nc_source_abbrev = 'T';
		}else{
			$cleaned_nc_source = str_replace('the', "", $postsource);
			$nc_source_abbrev = $cleaned_nc_source[0];
		}		

		  // if(isset($nc_source)){
		  //   foreach ( $nc_source as $key => $value ) {
		  //     $postsource = $value;
		  //   }
		  // }

// 		  $postsource = 'THINK Marketing';
// 


// if(isset($nc_source)){

//   foreach ( $nc_source as $key => $value ) {
//     $postsource = $value;

//     if(strcasecmp ( $value , "ibm commerce" ) == 0){
//       $postsource = 'THINK Marketing';
//     }
//     // $nc_source_abbrev = abbreviate($postsource, 3);
//     $cleaned_nc_source = str_replace('the', "", $postsource);
//     $nc_source_abbrev = $cleaned_nc_source[0];
//   }

// }else{

//   $postsource = 'THINK Marketing';
//   $nc_source_abbrev = 'T';

// }

		$permalink			= get_permalink();
		$pre_thumbnail	= (has_post_thumbnail() && $defaults['thumbnail'] == 'before_title') ? get_the_post_thumbnail(get_the_ID(), $thumbnail_size) : '';
		$post_thumbnail	= (has_post_thumbnail() && $defaults['thumbnail'] == 'after_title') ? get_the_post_thumbnail(get_the_ID(), $thumbnail_size) : '';

		$pimg = get_field('card_image');
        
        // $imageToshow = '<img width="30" align="left" height="30" alt="" style="background: #DEDEDE;" src="thumb" />';
        // if(get_field('card_image') && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never")) { 
        // 	$imageToshow = '<img align="left" src="'.$pimg['sizes']['large'].'" alt="thumb" />';
        // }

        $bgColor = NH_getCardBgColor();

		$imageToshow = '<div class="custom_post_list_image" style="background-color:'.$bgColor.';background-image:url('.$pimg["sizes"]["large"].');">
                      </div>';
		$insidePostURL = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large_size' );
// print_r($insidePostURL);
        if(!empty($insidePostURL)){
        	$imageToshow = '<div class="custom_post_list_image" style="background-image:url('.$insidePostURL[0].');">
                      </div>';
        }

		$item						= '
			<li class="' . $post_class . '">
				<div class="custom_post_list_image" style="background-color:'.$bgColor.';">' . 
					$imageToshow . 
				'</div> 
				<div class="custom_post_list_content"><a class="ibm-textcolor-gray-80 ibm-bold custom_post_label nh-right-rail-list-ellipsis" href="' . $permalink . '" title="' . $title . '">
					' . trim_text($title, 60, true, false)  . '</a>
					<div class="meta ibm-small ibm-textcolor-gray-50 ">'.NH_renderArticleSource($post, 'right-rail').'</div>
				</div>
			</li>
		';
		$item						= apply_filters('wp_most_popular_list_item_single', $item, $post_id, $title, $post_class, $permalink);
		echo $item;
	}
}

