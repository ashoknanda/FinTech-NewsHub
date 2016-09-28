<?php get_header(); ?>
<div class="postview">
	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>

		<!-- top section -->
		<div class="row collapse">
			<div class="phone-four one columns">
				<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_base_score", true)) { ?>
					<div class="cvss-score text-center">
						<span>CVSS</span>
						<?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_base_score", true)); ?>
					</div>
					<div class="tip" title="CVSS is owned by FIRST.Org, Inc. and used by permission.">
						?
					</div>
				<?php } ?>
			</div>

			<div class="phone-four eleven columns post posthead">
				<div class="post-title">
					<h1><?php the_title(); ?></h1>
				</div>
			</div>
		</div>


		<section class="row">

			<div class="phone-four eleven offset-by-one columns">
				<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">

					<div id="container-grid" class="row">

						<div class="phone-four six columns">

							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_notification_type", true)) { ?>
									<?php
									$notification_date = date_create(esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_notification_date", true)));
									$notification_date = date_format($notification_date, "M d, Y");
									?>
								<div class="mobile-four four columns">
									<p>NOTIFICATION TYPE: <span class="blue-text hide-on-desktops"><?php echo  $notification_date; ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  $notification_date; ?></span></p>
								</div>
								<?php } ?>
							</div>


							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_notification_date", true)) { ?>
									<?php
									$notification_date = date_create(esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_notification_date", true)));
									$notification_date = date_format($notification_date, "M d, Y");
									?>
								<div class="mobile-four four columns">

									<p>NOTIFICATION DATE: <span class="blue-text hide-on-desktops"><?php echo $notification_date; ?></span></p>
								</div>

								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  $notification_date; ?></span></p>
								</div>
								<?php } ?>
							</div>



							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_disclosure", true)) { ?>
									<?php
									$disclosure_date = date_create(esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_disclosure", true)));
									$disclosure_date = date_format($disclosure_date, "M d, Y");
									?>
								<div class="mobile-four four columns">
									<p>PUBLIC DISCLOSURE /IN THE WILD DATE: <span class="blue-text hide-on-desktops"><?php echo  $disclosure_date; ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  $disclosure_date; ?></span></p>
								</div>
								<?php } ?>
							</div>


							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_cve", true)) { ?>
								<div class="mobile-four four columns">
									<p>CVE: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_cve", true)); ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_cve", true)); ?></span></p>
								</div>
								<?php } ?>
							</div>


							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_notification_version", true)) { ?>
								<div class="mobile-four four columns">
									<p>VERSION: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_notification_version", true)); ?><span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_notification_version", true)); ?><span></p>
								</div>
								<?php } ?>
							</div>


							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_aliases", true)) { ?>
								<div class="mobile-four four columns">
									<p>ALIASES: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_aliases", true)); ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_aliases", true)); ?></span></p>
								</div>
								<?php } ?>
							</div>


							<div class="row metas">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_discoverer", true)) { ?>
								<div class="mobile-four four columns">
									<p>RESEARCHER: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_discoverer", true)); ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_discoverer", true)); ?></span></p>
								</div>
								<?php } ?>
							</div>

							<div class="row">
								<div class="phone-four twelve  columns post-details description-details">
									<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_description", false)) { ?>
									<h2>Description</h2>
									<p><?php echo  XforceStaticFunctions::remove_bad_tags(get_post_meta($post->ID, "_ibm_vulnerabilities_description", false)); ?></p>
									<?php } ?>
								</div>
							</div>

							<div class="row">
								<div class="phone-four twelve columns post-details">
									<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_technical_description", true)) { ?>
										<h2>TECHNICAL DESCRIPTION</h2>
										<p><?php echo  XforceStaticFunctions::remove_bad_tags(get_post_meta($post->ID, "_ibm_vulnerabilities_technical_description", true)); ?></p>
									<?php } ?>
									<?php
									$images = get_post_meta($post->ID, "_ibm_vulnerabilities_technical_description_image_list", true);
									if (is_array($images) && count($images) > 0) {
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

							<div class="row">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_techniques_product", true)) { ?>
									<div class="phone-four twelve  columns post-details consequences">
										<h2>PROPAGATION TECHNIQUE</h2>
										<p><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_techniques_product", true)); ?></p>
									</div>
								<?php } ?>
							</div>

							<div class="row">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_consequences", true)) { ?>
								<div class="phone-four twelve  columns post-details consequences">
									<h2>CONSEQUENCES</h2>
										<p><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_consequences", true)); ?></p>
								</div>
								<?php } ?>
							</div>

							<div class="row">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_remediation", true)) { ?>
								<div class="phone-four twelve  columns post-details">
									<h2>REMEDY</h2>
										<p><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_remediation", true)); ?></p>
								</div>
								<?php } ?>
							</div>

						</div>

						<div class="phone-four six columns metas">

							<div class="row">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_vendor", true)) { ?>
								<div class="mobile-four four columns">
									<p>VENDOR: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_vendor", true)); ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_vendor", true)); ?></span></p>
								</div>
								<?php } ?>
							</div>


							<div class="row">
								<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_product", true)) { ?>
								<div class="mobile-four four columns">
									<p>PRODUCT: <span class="blue-text hide-on-desktops"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_product", true)); ?></span></p>
								</div>
								<div class="mobile-two eight columns hide-on-phones">
									<p><span class="blue-text"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_product", true)); ?></span></p>
								</div>
								<?php } ?>
							</div>

						</div>


						<div class="phone-four six columns post-details">
							<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_business_impact", true)) { ?>
								<h2>BUSINESS IMPACT</h2>
								<p><?php echo  XforceStaticFunctions::remove_bad_tags(get_post_meta($post->ID, "_ibm_vulnerabilities_business_impact", true)); ?></p>
							<?php } ?>
							<?php
							$images = get_post_meta($post->ID, "_ibm_vulnerabilities_image_list", true);
							if (is_array($images) && count($images) > 0) {
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

						<div class="phone-four six columns post-details">
							<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_base_score", true)) { ?>
							<h2>CVSS 2.0 BASE SCORE</h2>

							<p class="score"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_base_score", true)); ?></p>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_access_vector", true)); ?>
									<div class="mobile-four four columns">
										<p>Access Vector  <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_access_complexity", true)); ?>
									<div class="mobile-four four columns">
										<p>Access Complexity  <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_authentication", true)); ?>
									<div class="mobile-four four columns">
										<p>Authentication  <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_confidentiality_impact", true)); ?>
									<div class="mobile-four four columns">
										<p>Confidentiality Impact <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_integrity_impact", true)); ?>
									<div class="mobile-four four columns">
										<p>Integrity Impact <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_availability_impact", true)); ?>
									<div class="mobile-four four columns">
										<p>Availability Impact <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>


							<?php } ?>
						</div>


						<?php if (get_post_meta($post->ID, "_ibm_vulnerabilities_adjusted_temporal_score", true)) { ?>
							<div class="phone-four six columns post-details">
								<h2>CVSS 2.0 TEMPORAL SCORE</h2>

								<p class="score"><?php echo  esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_adjusted_temporal_score", true)); ?></p>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_exploitability", true)); ?>
									<div class="mobile-four four columns">
										<p>Exploitability <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_remediation_level", true)); ?>
									<div class="mobile-four four columns">
										<p>Remediation Level <span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>

								<div class="row metas">
									<?php $var = esc_html(get_post_meta($post->ID, "_ibm_vulnerabilities_report_confidence", true)); ?>
									<div class="mobile-four four columns">
										<p>Report Confidence<span class="blue-text hide-on-desktops"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
									<div class="mobile-two eight columns hide-on-phones">
										<p><span class="blue-text"><?php echo  ( $var == '' ? 'N/A' : $var ); ?></span></p>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</article>

			</div>

		</section>

		<!--Info list-->
		<?php
		$coverages = get_post_meta($post->ID, "_ibm_vulnerabilities_coverage", false);

		if(!is_array($coverages)  || empty($coverages[0])){
			$coverages = array();
		}else{
			if(array_filter($coverages[0][0])){
				$coverages = $coverages[0];
			}else{
				$coverages = array();
			}

		}
		?>
			<div class="row info-list collapse short">
				<div class="mobile-one one columns main">
					<span><?php echo  count($coverages); ?></span>
					<p>IBM Security<br/> Protection</p>
					<?php
				  	if(count($coverages) > 4){
				  		?>
				  		<a href="#" class="product_btn" title="View All">View All</a>
				 	<?php }?>
				</div>
				<div class="mobile-three eleven columns">
					<div class="phone-four six columns">
						<strong>Coverage</strong>
					</div>
					<div class="phone-four hide six columns">
						<strong>Date</strong>
					</div>
						<?php
				  		if (count($coverages) > 0) {
				  		?>
							<?php foreach ($coverages as $coverage) { ?>
						<?php
						$date = $coverage['_ibm_vulnerabilities_coverage_date'];
						$date = date_create($date);
						$date = date_format($date, "M d, Y");
						?>
						<div class="phone-four six columns product">
			  			<?php if ($coverage['_ibm_vulnerabilities_coverage_url']) { ?>
				  			<a href="<?php echo $coverage['_ibm_vulnerabilities_coverage_url']; ?>" target="_blank"><?php echo $coverage['_ibm_vulnerabilities_coverage_name']; ?></a>
				  		<?php }else { ?>
								<span class="blue-text"><?php echo  $coverage['_ibm_vulnerabilities_coverage_name']; ?></span>
				  		<?php } ?>

							<span class="date"><?php echo  $date; ?></span>
						</div>
						<div class="hide phone-four six columns">
							<span><?php echo  $date; ?></span>
						</div>
						<?php } ?>
						<?php }else { ?>
				  		<div class="phone-four twelve columns product">
				  			<strong>None Found</strong>
				  		</div>
				  		<?php } ?>
				</div>
			</div>

		<!-- affected products-->
		<?php
		$affected_products = get_post_meta($post->ID, "_ibm_vulnerabilities_affected_products", false);

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
					<span><?php echo  count($affected_products); ?></span>
					<p>Affected <br/>Products</p>
					<?php
					  	if(count($affected_products) > 4){
					  		?>
					  		<a href="#" class="product_btn" title="View All">View All</a>
					 <?php }?>
				</div>

				<div class="mobile-three eleven columns">
					<?php
			  		if (count($affected_products) > 0) {
			  		?>
					<?php foreach($affected_products as $affected_product){ ?>
			  		<div class="phone-four twelve columns product">
			  			<?php echo $affected_product; ?>
			  		</div>
			  		<?php } ?>
					<?php }else { ?>
			  		<div class="phone-four twelve columns product none-found">
			  			<strong>None Found</strong>
			  		</div>
			  		<?php } ?>
				</div>
			</div>


		<!--Dependent list-->
		  <?php

		$dependent_products = get_post_meta($post->ID, "_ibm_vulnerabilities_dependent_products", false);

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
	  $references = get_post_meta( $post->ID, "_ibm_vulnerabilities_references", false );

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
					$references = explode(PHP_EOL, $references[0]);

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
		<div class="row info-list collapse short references-list">
			<div class="mobile-one one columns main">
			  	<span><?php echo count($references); ?></span>
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
		  		<?php
		  		$count_extenal_links = 0;
		  		foreach($references as $reference){
		  		?>
		  		<div class="phone-four twelve columns" data-row-count="<?php echo $count_extenal_links; ?>">
		  			<?php
			  		if ($reference['_ibm_vulnerabilities_reference_url']) {
			  		?>
		  			<a href="<?php echo $reference['_ibm_vulnerabilities_reference_url']; ?>" target="_blank"><?php echo $reference['_ibm_vulnerabilities_reference_text']; ?></a>
		  		<?php }else { ?>
		  		<?php echo $reference['_ibm_vulnerabilities_reference_text']; ?>
		  		<?php } ?>
		  		</div>
		  		<?php } ?>
		  		<?php
		  			$count_extenal_links += 1;
		  		}else {
		  		?>
		  		<div class="phone-four twelve columns product">
		  			<strong>None Found</strong>
		  		</div>
		  		<?php
		  		}
		  		?>
			</div>
		</div>

		<?php
		$revision_history = get_post_meta($post->ID, "_ibm_vulnerabilities_revision_history", true);
		if (!empty($revision_history)) {
			?>
			<div class="row last-module">
				<div class="phone-four twelve columns post-details">
					<h2 class="history">Revision History</h2>
					<p><?php echo  nl2br($revision_history); ?></p>
				</div>
			</div>
		<?php } ?>
	<?php endwhile; ?>
	<?php else : ?>
		<p><?php _e('Please add posts from your WordPress admin page.', THB_THEME_NAME); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
