<!--- Right side bar beginning-->
<div class="data social-margin nh-sidebar">
  <script>
    console.log("Collection group id passed in sidebar is : <?php echo $collection_group_id; ?>"); 
  </script>
  <?php 
  if(isset($collection_group_id)){ ?>
  <?php
    echo nh_render_ad($collection_group_id);   
  ?>
         
  <?php }  ?>   
  <div class="ibm-card ccre-placeholder">
    <?php echo do_shortcode('[do_widget id=ccre_widget-2]') ?>
  </div>       
</div>