<?php
/*
Template Name: X-Force List
*/
?>
<?php 
get_header(); 

$post_list = XforceStaticFunctions::get_posts();
$consequences = XforceStaticFunctions::get_consequences();
$base_score_range = XforceStaticFunctions::get_base_score_range();
$base_score_min = round($base_score_range->base_score_min);
$base_score_max = round($base_score_range->base_score_max);
$families = XforceStaticFunctions::get_last_families('7');

$types = '';
$consequence = '';
$cvss_from = '';
$cvss_to = '';
$search = '';
$propagation = '';


if ($_GET) {
  $types = $_GET['xfff-type'];
  $consequence = $_GET['xfff-consequences'];
  $cvss_from = $_GET['xfff-cvss-from'];
  $cvss_to = $_GET['xfff-cvss-to'];
  $search = $_GET['xfff-search'];
  $propagation = $_GET['xfff-propagation'];
}

?>
<div class="row xfc-list">
	<section class="nine columns">
		<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
			<article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
				<div class="post-content">
					<?php the_content(); ?>
				</div>
				<div class="row">
					<div class="mobile-four eight columns chart-column">
						<h2 class="vendors-title">Current Vulnerabilities by Vendor</h2>
						<div id="xforce-chart"></div>
					</div>
					<div class="mobile-four four columns line-divider">
						<div class="latest-families">
							<p>Latest Malware Families</p>
							<ol>
								<li>Dyre</li>
								<li>Neverquest</li>
								<li>Bugat</li>
								<li>Zeus v2</li>
								<li>Gozi</li>
								<li>Bandook</li>
								<li>Tinba</li>
								<li>Ramnit</li>
								<li>Necurs</li>
								<!--<?php foreach ($families as $family) { ?>
									<li><?php echo $family; ?></li>
								<?php } ?>-->
							</ol>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="mobile-four twelve columns filter-description">
						<p>The following list shows all notifications by publication date. To see a list of only vulnerabilities, malware or general advisories, please use the filter.</p>
					</div>
				</div>
				
				
				<!-- BEGIN: Filter -->
				<div class="xforce-filter">
					<div class="xff-head">
						<a href="#" class="xffh-filter xff-toggle" title="Filter Results">Filters</a>
						<a href="#" class="xfhh-close xff-toggle open" title="Close Filter">Close</a>
					</div>
					<div class="xff-content open">
						<div class="xffc-wrapper">
							<form class="xff-form" method="get" onsubmit="return false;">
								<fieldset>
									<div class="xfff-left">
										<div class="xfff-row">
											<input type="text" class="xfff-search" name="xfff-search" id="xfff-search" placeholder="Search" value="<?php echo $search; ?>">
										</div>
										<div class="xfff-header">Types</div>
										<div class="xfff-row">
											<div class="xfff-check">
												<input type="checkbox" name="xfff-type[]" id="xfff-type1" value="ibm_vulnerabilities"<?php if (is_array($types) && in_array('ibm_vulnerabilities', $types)){echo ' checked="checked"';}?>>
												<label for="xfff-type1">Vulnerability</label>
												<div class="clear"></div>
											</div>
											<div class="xfff-check">
												<input type="checkbox" name="xfff-type[]" id="xfff-type2" value="ibm_general_advisory"<?php if (is_array($types) && in_array('ibm_general_advisory', $types)){echo ' checked="checked"';}?>>
												<label for="xfff-type2">General Advisory</label>
												<div class="clear"></div>
											</div>
											<div class="xfff-check">
												<input type="checkbox" name="xfff-type[]" id="xfff-type3" value="ibm_malware"<?php if (is_array($types) && in_array('ibm_malware', $types)){echo ' checked="checked"';}?>>
												<label for="xfff-type3">Malware</label>
												<div class="clear"></div>
											</div>
										</div>
									</div>
									<div class="xfff-right">
										<div class="xfff-header">Additional Filters</div>
										<div class="xfff-row">
											<div class="xfffr-left">
												<label for="xfff-propagation">Propagation Technique</label>
												<select name="xfff-propagation" id="xfff-propagation">
													<option value="">Select</option>
													<option value="Remote Exploit">Remote Exploit</option>
													<option value="Malware C&amp;C">Malware C&amp;C</option>
													<option value="Botnet">Botnet</option>
													<option value="Point of sale intrusions">Point of sale intrusions</option>
													<option value="Denial of service attacks">Denial of service attacks</option>
													<option value="Privilege escalation">Privilege escalation</option>
													<option value="Web app exploit">Web app exploit</option>
												</select>
											</div>
											<div class="xfffr-right xfff-cvss">
												<label for="xfff-cvss-from">CVSS</label>
												<select name="xfff-cvss-from" id="xfff-cvss-from">
													<option value="">Select</option>
													<?php for ($i = $base_score_min; $i <= $base_score_max; $i++){ ?>
													<option value="<?php echo $i?>"<?php if (!empty($cvss_from) && $cvss_from == $i){echo ' selected="selected"';}?>><?php echo $i; ?></option>
													<?php } ?>
												</select>
												<div class="xfff-cvss-sep">To</div>
												<select name="xfff-cvss-to" id="xfff-cvss-to">
													<option value="">Select</option>
													<?php for ($i = $base_score_min; $i <= $base_score_max; $i++){ ?>
													<option value="<?php echo $i?>"<?php if (!empty($cvss_to) && $cvss_to == $i){echo ' selected="selected"';}?>><?php echo $i; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="clear"></div>
										</div>
										<div class="xfff-row">
											<div class="xfffr-left">
												<label for="xfff-consequences">Vuln Consequences</label>
												<select name="xfff-consequences" id="xfff-consequences">
													<option value="">Select</option>
													<?php foreach($consequences as $value) { ?>
													<option value="<?php echo $value?>"<?php if ($consequence == $value){echo ' selected="selected"';}?>><?php echo $value; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="xfffr-right">
												<input type="button" name="xfff-reset" class="xfff-reset" value="Reset Filters">
											</div>
											<div class="clear"></div>
										</div>
									</div>
									<div class="clear"></div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<!-- END: Filter -->


				<!-- BEGIN: Listings Table -->
				<div class="xforce-table">				
					<div class="xft-row xft-head">
						<div class="row1">Title</div>
						<div class="row2">Notification Type</div>
						<div class="row3">Publication Date</div>
						<div class="clear"></div>
					</div>
					<?php
					if ( $post_list ) {					
						foreach ($post_list as $post) { 
						switch($post['category_type']) {
			                case 'ibm_vulnerabilities':
			                    $tooltip_text = "Provides information about one or more critical vulnerabilities that were discovered by X-Force and for which X-Force has released or will be releasing security content coverage via the IBM Security family of products. Vulnerabilities are coordinated with the affected vendor(s) for disclosures unless there is active exploitation in the wild.";
			                break;
			                case 'ibm_general_advisory':
			                    $tooltip_text = "Provides information and references related to high-profile attacks or threats.";
			                break;
			                case 'ibm_malware':
			                    $tooltip_text = "Provides information about high-profile or novel malware threats that are active in the wild or have received significant media coverage.";
			                break;
			            }
			            $post_name = $post['name'];
			            if (empty($post_name)) {
			            	$post_name = '-';
			            }
					?>

					<div class="xft-row xft-item">
						<div class="row1"><span>Title: </span><a href="<?php echo $post['url']; ?>" target="_blank"><?php echo $post_name; ?></a></div>
						<div class="row2">
							<div class="type">
								<span>Notification Type: </span>
								<?php echo $post['type']; ?>
								<div class="tooltip"><div class="arrow"></div><?php echo $tooltip_text; ?></div>
							</div>
						</div>
						<div class="row3"><span>Publication Date: </span><?php echo $post['date']; ?></div>
						<div class="clear"></div>
					</div>
							<?php
						}					
					}
					?>
					<div class="xft-more">
						<a id="loadmore" href="#" data-loading="<?php _e( 'Loading ...', THB_THEME_NAME ); ?>" data-more="<?php _e( 'Load More', THB_THEME_NAME ); ?>" data-nomore="<?php _e( 'No More Posts to Show', THB_THEME_NAME ); ?>" data-count="10" data-action="xforce_loadmore_ajax"><?php _e( 'Load More', THB_THEME_NAME ); ?></a>
						<p class="no-post">NO MORE POSTS TO SHOW</p>
					</div>
				</div>
				<!-- END: Listings Table -->

			</article>
		<?php endwhile; else : endif; ?>
	</section>
	<?php get_sidebar('x-force-center'); ?>
</div>

<?php get_footer(); ?>