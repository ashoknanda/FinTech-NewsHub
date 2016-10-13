<?php if (!function_exists('renderCardWrap')) {
	function renderCardWrap($post, $postId, $card_count, $is_editor_pick, $background_attributes, $content, $nc_source_abbrev, $nc_source, $permalink, $title, $byAndDate, $excerpt, $categories){ ?>
		<div class="ibm-x-col-6-2 post nh-card-wrap nh-card-wrap-height <?php echo $post->post_type; ?>" data-post-id="<?php echo the_ID(); ?>" data-post-count="<?php echo($card_count); ?>">
			<div class="ibm-card nh-card <?php if($is_editor_pick) { echo 'nh-editors-pick'; };?> <?php if($background_attributes !=''){echo 'nh-background-loaded';} ?> <?php echo add_content_type_class($post->ID); ?>" <?php echo $background_attributes; ?> >
				<div class="ibm-card__content">
					<div class="nh-card-content">
						<?php renderCardContent($nc_source_abbrev, $nc_source, $permalink, $title, $byAndDate, $excerpt, $categories); ?>
					</div>
				</div>
			</div>
		</div>
<?php } } ?>

<?php if(!function_exists('renderCardContent')){
	function renderCardContent($nc_source_abbrev, $nc_source, $permalink, $title, $byAndDate, $excerpt, $categories){ ?>
		<div class="nh-source">
          <div class="logo-mark-wrap"><div class="logo-mark ibm-bold"><?php echo($nc_source_abbrev); ?></div></div>
          <div class="title ibm-small"><?php echo($nc_source); ?></div>
        </div>

        <h3 class="nh-title ibm-h3 ibm-bold ibm-textcolor-white"><a class="ibm-blog__header-link" href= "<?php the_permalink() ?>"><span class=""><?php the_title(); ?></span></a></h3>

        <div class="nh-author ibm-textcolor-white nh-card-meta-data"><?php echo($byAndDate);?></div>

        <div class="nh-excerpt ibm-small ibm-light ibm-textcolor-gray-60"><?php  the_excerpt(); ?></div>

        <div class="nh-tags nh-card-meta-color-changer nh-card-meta-data">
          <?php if(!empty($categories)){
          $catcountvalue = 0; 
          foreach($categories as $key => $value) {
            if($value->name != '' && $value->name != 'uncategorized'){
              if($catcountvalue > 0){
                echo('<span>,</span>');
              } ?>
              <a style="display:inline-block;" class="nh-tag ibm-textcolor-gray-60" href="<?php echo get_category_link($value->cat_ID); ?>"><?php echo($value->name); ?></a>
              <?php
                  $catcountvalue +=1;
                  if($catcountvalue >= 3){
                    break;
                  }
                }
              }
          } ?>
        </div>
	<?php }
}?>