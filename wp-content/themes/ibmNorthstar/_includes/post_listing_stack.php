<?php
$pimages = get_field('card_image');
$pcategories = get_the_category();

$categories = array();
foreach($pcategories as $pcategory)
{
  if($pcategory->name !== 'Featured Carousel' && $pcategory->name !== 'Uncategorized') {
    array_push($categories, $pcategory);
  }
}
?>

<div class="ibm-columns">
<?php
if(get_field('card_image') && (get_option('post_listing_image_visibility') !== "post_listing_image_visibility_never"))
{
?>
  <div class="ibm-col-6-1">
    <a href="<?php the_permalink() ?>">
      <img class="ibm-downsize ibm-padding-top-1" src="<?php echo $pimages['sizes']['large']; ?>" alt="" />
    </a>
  </div>
  <div class="ibm-col-6-5 post <?php echo $post->post_type; ?>" data-post-id-"<?php the_ID(); ?>">

<?php
}
else
{
  if((get_option('post_listing_image_visibility') == "post_listing_image_visibility_if_available") or (get_option('post_listing_image_visibility') == "post_listing_image_visibility_never"))
  {
    ?>
      <div class="ibm-col-1-1 post <?php echo $post->post_type; ?>" data-post-id-"<?php the_ID(); ?>">
    <?php
  }
  //default choice when the blog is new - post_listing_image_visibility_if_available
  else if(get_option('post_listing_image_visibility') == "")
  {
    ?>
      <div class="ibm-col-1-1 post <?php echo $post->post_type; ?>" data-post-id-"<?php the_ID(); ?>">
    <?php
  }
  else
  {
    ?>
    <div class="ibm-col-6-1">
      <a href="<?php the_permalink() ?>">
        <img class="ibm-downsize ibm-padding-top-1" src="<?php echo get_template_directory_uri(); ?>/assets/img/default-card-380x190.jpg" alt="" />
      </a>
    </div>
    <div class="ibm-col-6-5 post <?php echo $post->post_type; ?>" data-post-id-"<?php the_ID(); ?>">
    <?php
  }
}
?>
    <h4 class="ibm-h4 ibm-padding-top-1"><a class="ibm-blog__header-link" href= "<?php the_permalink() ?>"><span class="ibm-textcolor-default"><?php the_title(); ?></span></a></h4>
    <h4 class="ibm-small">
      <?php
      echo "Written by <a href='".get_author_posts_url(get_the_author_meta('ID'))."' target='_self'>".get_the_author()."</a> &#124; ".get_the_date();
      ?>
      <?php
      if(!empty($categories)):
        echo "&#124; ";
        $str = '';
        $i = 0;
        foreach($categories as $category)
        {
          if($i < 3)
          {
            $i++;
            $str .= '<a href="'.get_category_link($category->cat_ID).'">'.$category->name.'</a>, ';
          }
          else
          {
            $str = rtrim(trim($str),",");
            $str .= "...";
            break;
          }
        }
        echo rtrim(trim($str),",");
      endif; ?>
    </h4>

    <p class="ibm-small ibm-padding-bottom-1"><?php
      echo trim(preg_replace("/<p[^>]*><\\/p[^>]*>/", '', str_replace("[&hellip;]","",(get_option("post_listing_choice_show_full_article") === "post_listing_choice_show_full_article_full" ? get_the_content() : get_the_excerpt() ))));

      if(get_option("post_listing_choice_show_full_article") !== "post_listing_choice_show_full_article_full")
      {
        echo "<a href='".get_permalink()."' target='_self'> ..."; //removing empty paragrahps from excerpt
        $my_theme = wp_get_theme();
        _e("read more", $my_theme->get( 'Name' ));
        echo "</a>";
      }

      ?>
      </p>
      <?php
      /*
    <p class="ibm-ind-link ibm-padding-bottom-2">
      <a class="ibm-forward-link" href="<?php the_permalink() ?>"><?php $my_theme = wp_get_theme(); _e("Continue reading", $my_theme->get( 'Name' )); ?>
      </a>
    </p>
    */
    ?>
  </div>
</div>
<div class="ibm-rule"><hr></div>

