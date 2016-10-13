<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
    <head>
        <meta charset="utf-8">

        <?php include('_includes/v18_head.php'); ?>

        <?php wp_head(); ?>

    </head>

    <body  onload= "loadmenu()" id="ibm-com" <?php 
    $bodyClasses = get_body_class();
    $classStr = "";
    foreach($bodyClasses as $classes) {
      $classStr .= $classes . " ";
    }
    $classStr = rtrim($classStr," ");
    $temp = strtolower(substr(get_option('meta_country'), 0, strpos(get_option('meta_country'), "-")));
    if($temp == "" || $temp == "en")
    {
      $classStr .= " " . "ibm-type";
    }
    echo 'class="' . $classStr . '"';

     ?> itemscope itemtype="http://schema.org/WebPage">


        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div id="ibm-top" class="ibm-landing-page <?php echo (is_page()) ? get_queried_object()->post_name . '-page' : 'page' ?>">

            <?php include('_includes/v18_header.php'); ?>

            

