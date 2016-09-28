<?php
/*
Template Name: Search Page
*/
get_header();
?>

<?php
get_template_part('_includes/v18_content_main_start');
?>
    <div id="content">
<?php

 ?>
<div class="ibm-band ibm-background-white-core">
<div class="ibm-columns">
</div></div>
<div id="story-space">
  <div class="ibm-columns">
    <?php
    global $query_string;

    $query_args = explode("&", $query_string);
    $search_query = array();

    if( strlen($query_string) > 0 ) {
    	foreach($query_args as $key => $string) {
    		$query_split = explode("=", $string);
    		$search_query[$query_split[0]] = urldecode($query_split[1]);
    	} // foreach
    } //if

    $search = new WP_Query($search_query);
    ?>

    <?php
global $wp_query;
$total_results = $wp_query->found_posts;
?>


<p>
My Site features articles about
<a title="WordPress Articles" href="/category/wordpress/">WordPress</a>,
<a title="Web Design Articles" href="/category/web-design/">web page design</a>,
<a title="Development Articles" href="/category/website-development/">website development</a>,
and <a title="CSS Articles" href="/category/css/">CSS</a>.
</p>
<p>To search my website, please use the form below.</p>

<?php get_search_form(); ?>


  </div>


</div> <!-- .ibm-columns -->


</div> <!-- #content -->

<!-- pagination here -->



	<?php
get_template_part('_includes/v18_content_main_end');
?>

<?php
get_footer();
?>
