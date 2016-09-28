<?php get_header(); ?>
<div class="postview advisory">
	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>

	<!-- top section -->
	<div class="row collapse">
		<div class="phone-four six columns post posthead">
			<div class="post-title">
			  	<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>


	<section class="row advisory-section">

		<div class="phone-four twelve columns">
			<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">

				<div class="row post-details">

					<div class="phone-four six columns metas post-details">
						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_notification_type", true ) ) { ?>
						<div class="row">
							<div class="mobile-four four columns"><p>NOTIFICATION TYPE: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_notification_type", true )); ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_notification_type", true ));  ?></span></p></div>
						</div>
						<?php } ?>

						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_notification_date", true ) ) { ?>
							<?php
							$publication_date = date_create(esc_html(get_post_meta($post->ID, "_ibm_general_advisory_notification_date", true)));
							$publication_date = date_format($publication_date, "M d, Y");
							?>
						<div class="row">
							<div class="mobile-four four columns"><p>PUBLICATION DATE: <span class="blue-text hide-on-desktops"><?php echo  $publication_date; ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  $publication_date; ?></span></p></div>
						</div>
						<?php } ?>

						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_disclosure", true ) ) { ?>
							<?php
							$disclosure_date = date_create(esc_html(get_post_meta($post->ID, "_ibm_general_advisory_disclosure", true)));
							$disclosure_date = date_format($disclosure_date, "M d, Y");
							?>
						<div class="row">
							<div class="mobile-four four columns"><p>PUBLIC DISCLOSURE /IN THE WILD DATE: <span class="blue-text hide-on-desktops"><?php echo  $disclosure_date; ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  $disclosure_date; ?></span></p></div>
						</div>
						<?php } ?>

						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_notification_version", true ) ) { ?>
						<div class="row">
							<div class="mobile-four four columns"><p>NOTIFICATION VERSION: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_notification_version", true )); ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_notification_version", true )); ?></span></p></div>
						</div>
						<?php } ?>

						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_aliases", true ) ) { ?>
						<div class="row">
							<div class="mobile-four four columns"><p>ALIASES: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_aliases", true )); ?><span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_aliases", true )); ?><span></p></div>
						</div>
						<?php } ?>

						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_cve", true ) ) { ?>
						<div class="row">
							<div class="mobile-four four columns"><p>CVE: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_cve", true )); ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_cve", true )); ?></span></p></div>
						</div>
						<?php } ?>
							
						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_vendor", true ) ) { ?>
						<div class="row">
							<div class="mobile-four four columns"><p>VENDOR: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_vendor", true )); ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_vendor", true )); ?></span></p></div>
						</div>
						<?php } ?>
							
						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_product", true ) ) { ?>
						<div class="row">
							<div class="mobile-four four columns"><p>PRODUCT: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_product", true )); ?></span></p></div>
							<div class="mobile-two eight columns hide-on-phones"><p><span class="blue-text"><?php echo  esc_html(get_post_meta( $post->ID, "_ibm_general_advisory_product", true )); ?></span></p></div>
						</div>
						<?php } ?>
					</div>
																		
					<div class="phone-four six columns">
						<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_business_impact", true ) ) { ?>
							<h2>BUSINESS IMPACT</h2>
							<p><?php echo  XforceStaticFunctions::remove_bad_tags(get_post_meta( $post->ID, "_ibm_general_advisory_business_impact", true )); ?></p>
						<?php } ?>
							<?php
							$images = get_post_meta($post->ID, "_ibm_general_advisory_image_list", false);
							if (count($images) > 0) {
								?>
								<div id="carousel_container">
									<div class="carousel owl row" data-navigation="true"
										 data-autoplay="false">
										<?php
										foreach ($images as $key => $value) {
											$img_gallery = wp_get_attachment_image_src($key, 'full');
											$img_gallery = $img_gallery[0];
											?>
											<div class="vuln-item"
												 style="background-image: url('<?php echo $img_gallery?>');">
												<a class="fancybox" rel="gallery1" href="<?php echo  $value; ?>">
												</a>
											</div>
										<?php } ?>
									</div>
									<div class="clear"></div>
								</div>
							<?php } ?>						
					</div>

				</div>

				<div class="row post-details">
					<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_description", true ) ) { ?>
					<div class="phone-four six columns">
						<h2>Description</h2>
						<p><?php echo  XforceStaticFunctions::remove_bad_tags(get_post_meta( $post->ID, "_ibm_general_advisory_description", true )); ?></p>
					</div>
					<?php } ?>
				</div>

				<div class="row">
					<div class="phone-four twelve  columns">
					<?php if ( get_post_meta( $post->ID, "_ibm_general_advisory_technical_description", true ) ) { ?>

						<h2>TECHNICAL DESCRIPTION</h2>
						<p><?php echo  XforceStaticFunctions::remove_bad_tags(get_post_meta( $post->ID, "_ibm_general_advisory_technical_description", true )); ?></p>
					<?php } ?>					

							<?php
							$images = get_post_meta($post->ID, "_ibm_general_advisory_technical_description_image_list", false);
							if (count($images) > 0) {
								?>
								<div id="carousel_container">
									<div class="carousel owl row" data-navigation="true"
										 data-autoplay="false">
										<?php
										foreach ($images as $key => $value) {
											$img_gallery = wp_get_attachment_image_src($key, 'full');
											$img_gallery = $img_gallery[0];
											?>
											<div class="vuln-item"
												 style="background-image: url('<?php echo $img_gallery; ?>');">
												<a class="fancybox" rel="gallery1" href="<?php echo  $value; ?>">
												</a>
											</div>
										<?php } ?>
									</div>
									<div class="clear"></div>
								</div>
							<?php } ?>


					</div>
				</div>
			
  			</article>

		</div>

	</section>

<!--Info list-->
	<?php 
	$affected_products = get_post_meta( $post->ID, "_ibm_general_advisory_affected_products", false );
		if(!is_array($affected_products) || empty($affected_products)){
			$affected_products = array();
		}else{
			if(is_array($affected_products[0])){
				$affected_products = $affected_products[0];
			}else{
				$affected_products = array();
			}

		}
  ?>

	<div class="row info-list collapse short">

		<div class="mobile-one one columns main">
		  	<span><?php echo count($affected_products); ?></span>
		  	<p>Affected<br/> Products</p>
		  	<?php 
			  	if(count($affected_products) > 4){
			  		?>
			  		<a href="#" class="product_btn" title="View All">View All</a>
			 <?php }?> 
			  	
		  	
		  	
		</div>

	  	<div class="mobile-three eleven columns">
	  		<div class="phone-four twelve columns">
	  			<strong>Affected Products</strong>
	  		</div>
	  		<?php
	  		if (count($affected_products) > 0) {
	  		?>
	  		<?php foreach($affected_products as $affected_product){ ?>
	  		<div class="phone-four twelve columns product">
	  			<?php echo $affected_product; ?>
	  		</div>
	  		<?php } ?>
	  		<?php }else { ?>
	  		<div class="phone-four twelve columns product">
	  			<strong>None Found</strong>
	  		</div>
	  		<?php } ?>
		</div>
	</div>

<!--Dependet list-->
  <?php 
  $dependent_products = get_post_meta( $post->ID, "_ibm_general_advisory_dependent_products", false );
		if(!is_array($dependent_products) || empty($dependent_products)){
			$dependent_products = array();
		}else{
			if(is_array($dependent_products[0])){
				$dependent_products = $dependent_products[0];
			}else{
				$dependent_products = array();
			}

		}
  ?>

	<div class="row info-list collapse short">
		<div class="mobile-one one columns main">
		  	<span><?php echo count($dependent_products); ?></span>
		  	<p>Dependent <br/>Products</p>
		  	<?php 
			  	if(count($dependent_products) > 4){
			  		?>
			  		<a href="#" class="product_btn" title="View All">View All</a>
			 <?php }?> 
		</div>

	  	<div class="mobile-three eleven columns">
			<div class="phone-four twelve columns">
	  			<strong>Dependent Products</strong>
	  		</div>
	  		<?php
	  		if (count($dependent_products) > 0) {
	  		?>
	  		<?php foreach($dependent_products as $dependent_product){ ?>
	  		<div class="phone-four twelve columns product">
	  			<?php echo $dependent_product; ?>
	  		</div>
	  		<?php } ?>
	  		<?php }else { ?>
	  		<div class="phone-four twelve columns product">
	  			<strong>None Found</strong>
	  		</div>
	  		<?php } ?>
		</div>
	</div>

<!--References list-->
  <?php 
  $references = get_post_meta( $post->ID, "_ibm_general_advisory_references", false );
		if(!is_array($references)  || empty($references[0])){
			$references = array();
		}else{
			if(is_array($references[0][0])){
				if(array_filter($references[0][0])) {
					$references = $references[0];
				}else{
					$references = array();
				}
			}else{
				if(!empty($references[0])){
					$references = explode(PHP_EOL,$references[0]);

					foreach($references as $key => $value){
						$reference_array = explode(':',$value);
						$references[$key] = array(
							'_ibm_vulnerabilities_reference_text'	=> $reference_array[0],
							'_ibm_vulnerabilities_reference_url'	=> $reference_array[1].":".$reference_array[2]
						);
					}
				}else{
					$references = $references[0];
				}
			}

		}
  ?>
	<div class="row info-list collapse short">
		<div class="mobile-one one columns main">
		  	<span><?php echo count($references);?></span>
		  	<p>References</p>
		  	<?php 
			  	if(count($references) > 4){
			  		?>
			  		<a href="#" class="product_btn" title="View All">View All</a>
			 <?php }?> 
		</div>

	  	<div class="mobile-three eleven columns">
			<div class="phone-four twelve columns">
	  			<strong>External Links</strong>
	  		</div>
	  		<?php
	  		if (count($references) > 0) {
	  		?>
	  		<?php foreach($references as $reference){ ?>	  		
	  		<div class="phone-four twelve columns">
	  			<?php
		  		if ($reference['_ibm_general_advisory_reference_url']) {
		  		?>
	  			<a href="<?php echo $reference['_ibm_general_advisory_reference_url']; ?>" target="_blank"><?php echo $reference['_ibm_general_advisory_reference_text']; ?></a>
	  		<?php }else { ?>
	  		<?php echo $reference['_ibm_general_advisory_reference_text']; ?>
	  		<?php } ?>
	  		</div>
	  		<?php } ?>
	  		<?php }else { ?>
	  		<div class="phone-four twelve columns product">
	  			<strong>None Found</strong>
	  		</div>
	  		<?php } ?>
		</div>
	</div>

<!--Revision History-->
  <?php 
  $revision_history = get_post_meta( $post->ID, "_ibm_general_advisory_revision_history", true ); 
  if (!empty($revision_history)) {
  ?>
	<div class="row last-module">
		<div class="phone-four twelve columns post-details">
			<h2 class="history">Revision History</h2>			
			<p><?php echo nl2br($revision_history); ?></p>
		</div>
	</div>
	<?php } ?>
	<?php endwhile; ?>
  	<?php else : ?>
    	<p><?php _e( 'Please add posts from your WordPress admin page.', THB_THEME_NAME ); ?></p>
  	<?php endif; ?>
</div>
<?php get_footer(); ?>
