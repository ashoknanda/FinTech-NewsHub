<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta http-equiv="cleartype" content="on">
	<meta name="HandheldFriendly" content="True">
	<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/45dc63b2-d17c-46e3-b348-372cc3304fa9.css">
	<?php if(ot_get_option('favicon')){ ?>
	<link rel="shortcut icon" href="<?php echo ot_get_option('favicon'); ?>">
	<?php } ?>
	<?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
	<?php
		if(ot_get_option('boxed') == 'yes') {
			$class[0] = 'boxed';
	 	} else { $class[1] = ''; }
	?>
	<?php wp_localize_script( 'app', 'themeajax', array( 'url' => admin_url( 'admin-ajax.php' ) ) ); ?>
	<!-- BEGIN COREMETRICS -->
	<script type="text/javascript">
	  (function ibmSIAuto(){
	  if (String(document.cookie).match(/(^| )(w3ibmProfile|w3_sauid|PD-W3-SSO-|OSCw3Session|IBM_W3SSO_ACCESS)=/)) {
	   var ibmCMCoreTagSplitSecond = 'New_IBMER';
	  }
	  else {
	   var ibmCMCoreTagSplitSecond = 'SECURITYINTELLIGENCE';
	  }
	     digitalData = {
	      page: {
	       pageInfo: {
	        ibm: {
	         siteID: ibmCMCoreTagSplitSecond,
	        }
	       },
			<?php print get_coremetric_category() ?>
	      }
	     };
	  }());
	</script>
	<script src="//www.ibm.com/common/stats/ida_production.js" type="text/javascript"></script>
	<!-- END COREMETRICS -->
	<script type="ibm/report">{"attr":"ISM0484","ct":"SWG","cmp":"IBMSocial","cm":"h","cr":"Security","ccy":"US"}</script>
</head>
<body <?php body_class($class); ?> data-url="<?php echo home_url(); ?>">
<?php
if ($_SERVER['REQUEST_URI'] == '/events/qradar-investment-2016/') {
	echo '<script src="//cdn.optimizely.com/js/3692941844.js"></script>';
}
?>
<div id="wrapper">
<?php get_template_part('template-header-webinar-banner'); ?>
<!-- Start Subheader -->
<div id="subheader">
	<div class="row">
		<div class="twelve columns hide-for-small">
			<ul>
				<li>Brought to you by</li>
			</ul>
			<a href="http://ibm.com/security" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer-logo.png" alt="IBM - Security Intelligence"></a>
			<?php if(has_nav_menu('super-header')) { ?>
			  <?php wp_nav_menu( array( 'theme_location' => 'super-header', 'depth' => 1, 'container' => false ) ); ?>
			<?php } ?>
		</div>
		<div class="eight mobile-one columns show-for-small">
			<i class="fa fa-reorder" id="mobile-toggle"></i>
		</div>
		<div class="four mobile-three columns social">
			<?php if (ot_get_option('fb_link')) { ?>
			<a href="<?php echo ot_get_option('fb_link'); ?>" class="boxed-icon facebook icon-1x rounded"><i class="fa fa-facebook"></i></a>
			<?php } ?>
			<?php if (ot_get_option('pinterest_link')) { ?>
			<a href="<?php echo ot_get_option('pinterest_link'); ?>" class="boxed-icon pinterest icon-1x rounded"><i class="fa fa-pinterest"></i></a>
			<?php } ?>
			<?php if (ot_get_option('twitter_link')) { ?>
			<a href="<?php echo ot_get_option('twitter_link'); ?>" class="boxed-icon twitter icon-1x rounded"><i class="fa fa-twitter"></i></a>
			<?php } ?>
			<?php if (ot_get_option('googleplus_link')) { ?>
			<a href="<?php echo ot_get_option('googleplus_link'); ?>" class="boxed-icon google-plus icon-1x rounded"><i class="fa fa-google-plus"></i></a>
			<?php } ?>
			<?php if (ot_get_option('linkedin_link')) { ?>
			<a href="<?php echo ot_get_option('linkedin_link'); ?>" class="boxed-icon linkedin icon-1x rounded"><i class="fa fa-linkedin"></i></a>
			<?php } ?>
			<?php if (ot_get_option('instragram_link')) { ?>
			<a href="<?php echo ot_get_option('instragram_link'); ?>" class="boxed-icon instagram icon-1x rounded"><i class="fa fa-instagram"></i></a>
			<?php } ?>
			<?php if (ot_get_option('xing_link')) { ?>
			<a href="<?php echo ot_get_option('xing_link'); ?>" class="boxed-icon xing icon-1x rounded"><i class="fa fa-xing"></i></a>
			<?php } ?>
			<?php if (ot_get_option('tumblr_link')) { ?>
			<a href="<?php echo ot_get_option('tumblr_link'); ?>" class="boxed-icon tumblr icon-1x rounded"><i class="fa fa-tumblr"></i></a>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End Subheader -->
<!-- Start Mobile Menu -->
<div id="mobile-menu">
	<?php get_search_form(); ?>
	<?php if(has_nav_menu('top-menu')) { ?>
	  <?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'depth' => 3, 'container' => false ) ); ?>
	<?php } else { ?>
		<ul class="sf-menu">
			<li><a href="">No menu assigned!</a></li>
		</ul>
	<?php } ?>
</div>
<!-- End Mobile Menu -->
<!-- Start Header -->
<?php if (isset($_GET['header_style'])) { $header_style = htmlspecialchars($_GET['header_style']); } else { $header_style = ''; }  ?>
<?php if(ot_get_option('header_style', 'style2') == 'style2' || $header_style == 'style2' ) {  ?>
<header id="header" class="style2">
	<div class="row">
		<div class="four columns logo">
			<?php if (ot_get_option('logo_text') == 'yes') { ?>
				<h1><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1></li>
			<?php } else { ?>
				<?php if (ot_get_option('logo')) { $logo = ot_get_option('logo'); } else { $logo = get_template_directory_uri(). '/assets/img/logo.png'; } ?>

				<a href="<?php echo home_url(); ?>" <?php if(ot_get_option('logo_mobile')) { ?>class="hide-logo"<?php } ?>><img src="<?php echo $logo; ?>" class="logoimg" alt="<?php bloginfo('name'); ?>" /></a>
				<?php if(ot_get_option('logo_mobile')) { ?>
					<a href="<?php echo home_url(); ?>" class="show-logo"><img src="<?php echo ot_get_option('logo_mobile'); ?>" alt="<?php bloginfo('name'); ?>" /></a>
				<?php } ?>
			<?php } ?>
			<?php echo '<br><time>'. date_i18n( __( 'F d, Y' ), time() ).'</time>'; ?>
		</div>
		<div class="eight columns">
			<?php if(ot_get_option('disableads') != 'yes') { ?>
			<aside class="advertisement">
				<?php
					if(ot_get_option('ads_header')) {
						echo ot_get_option('ads_header');
					} else {
					?>
						<div class="placeholder"><a href="<?php echo ot_get_option('ads_default', '#'); ?>"><?php _e( 'Advertise', THB_THEME_NAME ); ?></a></div>
					<?php
					}
				 ?>
			</aside>
			<?php }?>
		</div>
	</div>
</header>
<?php } else {  ?>
<header id="header">
	<div class="row">
		<div class="nine columns logo">
			<h1><a href="<?php echo home_url(); ?>" title="Security Intelligence">Security Intelligence</a></h1>
			<div class="hi_mom">Analysis and Insight for Information Security Professionals</div>
		</div>
		<div class="three columns hide-for-small">
			<ul id="headerSocial">
				<li class="subscribe"><a href="http://feeds.feedburner.com/SecurityIntelligence" target="_blank" title="RSS">Subscribe +</a></li>
				<li class="icon"><a href="http://www.twitter.com/ibmsecurity" target="_blank" class="twitter" title="Twitter">&#xf099;</a></li>
				<li class="icon"><a href="http://facebook.com/ibmsecurity" target="_blank" class="facebook" title="Facebook">&#xf09a;</a></li>
				<li class="icon"><a href="https://www.youtube.com/c/IBMSecurity " target="_blank" class="youtube" title="YouTube">&#xf03d;</a></li>
				<li class="icon"><a href="http://www.linkedin.com/company/ibm-security" target="_blank" class="linkedin" title="LinkedIn">&#xf0e1;</a></li>
				<li class="icon"><a href="http://slideshare.net/ibmsecurity" target="_blank" class="slideshare" title="SlideShare">&#xf0c0;</a></li>
				<!--<li class="icon"><a href="" target="_blank" class="gplus" title="Google+">&#xf0d5;</a></li>-->
			</ul>
			<?php get_search_form(); ?>
		</div>
	</div>
</header>
<?php }  ?>
<!-- End Header -->
<!-- Start Navigation -->
<div id="nav" class="hide-for-small">
	<div class="row">
		<div class="twelve columns">
			<nav>
				<?php get_template_part('template-megamenu'); ?>
			</nav>
		</div>
	</div>
</div>
<!-- End Navigation -->

<?php // get_template_part('template-breaking-news'); ?>
<?php get_template_part('template-headline'); ?>
<?php get_template_part('template-breadcrumbs'); ?>
<!-- Start Content -->
<div role="main">
