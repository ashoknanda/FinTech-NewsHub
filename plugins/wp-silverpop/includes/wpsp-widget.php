<?php
class Wpsp_Widget extends WP_Widget {
  public function __construct() {
      // widget actual processes
      parent::__construct('wpsp_widget','Silverpop', array('description' => 'Wordpress Silverpop Subscription Widget'));
  }

  public function form( $instance ) {
  // outputs the options form on admin
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }else {
      $title = __( 'New title', 'text_domain' );
    }
    if(isset($instance['wpsp_title_position'])){
      $wpsp_title_position = $instance['wpsp_title_position'];
    }else{
      $wpsp_title_position = 'left';
    }
    
    if(isset($instance['wpsp_title_color'])){
      $wpsp_title_color = $instance['wpsp_title_color'];
    }else{
      $wpsp_title_color = '#CCCCCC';
    }
    if(isset($instance['wpsp_text_color'])){
      $wpsp_text_color = $instance['wpsp_text_color'];
    }else{
      $wpsp_text_color = '#000000';
    }
    
     if(isset($instance['wpsp_text'])){
      $wpsp_text = $instance['wpsp_text'];
    }else{
      $wpsp_text = 'Sign up to receive update';
    }
    
    if(isset($instance['wpsp_button_text'])){
      $wpsp_button_text = $instance['wpsp_button_text'];
    }else{
      $wpsp_button_text = 'Submit';
    }
    
    if(isset($instance['wpsp_form_type'])){
      $wpsp_form_type = $instance['wpsp_form_type'];
    }else{
      $wpsp_form_type = '1';
    }


    ?>
    <p>
    <h3><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> </h3>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <h3><label for="<?php echo $this->get_field_id( 'wpsp_title_position' ); ?>"><?php _e( 'Title Position:' ); ?></label></h3>
      <select id="<?php echo $this->get_field_id( 'wpsp_title_position' ); ?>" name="<?php echo $this->get_field_name( 'wpsp_title_position' ); ?>" >
        <option value="center" <?php if($wpsp_title_position=='center') echo 'selected="selected"'; ?> >Center</option>
        <option value="left" <?php if($wpsp_title_position=='left') echo 'selected="selected"'; ?> >Left</option>
        <option value="right" <?php if($wpsp_title_position=='right') echo 'selected="selected"'; ?> >Right</option>        
      </select>
    </p>



    <div style="padding: 10px 0 10px 0;">
    <h3>
      Select Form type: 
    </h3>    
    <p>
      <label>
        <input type="radio" name="<?php echo $this->get_field_name('wpsp_form_type'); ?>" <?php if($wpsp_form_type=='1'): ?>checked="checked"<?php endif ;?> value="1" /> Email
      </label>
    </p>
    <p>
      <label>
        <input type="radio" name="<?php echo $this->get_field_name('wpsp_form_type'); ?>" <?php if($wpsp_form_type=='2'): ?>checked="checked"<?php endif;?> value="2" />  Name and Email
      </label>
       &emsp; [Create a silverpop database field[Name] for use this option]
    </p>
    <p>
      <label>
        <input type="radio" name="<?php echo $this->get_field_name('wpsp_form_type'); ?>" <?php if($wpsp_form_type=='3'): ?>checked="checked"<?php endif;?> value="3" />  First name, Last name and Email
      </label>
       &emsp; [Create silverpop database fields[FirstName and LastName] for use this option]</p>
    </div>

    <script type="text/javascript">     
        jQuery(document).ready(function()
        {         
          jQuery('.cw-color-picker').each(function(){
            var $this = jQuery(this),
              id = $this.attr('rel');
            $this.farbtastic('#' + id);
          }); 
        });     
    </script>
    <p>
      <h3><label for="<?php echo $this->get_field_id( 'wpsp_title_color' ); ?>"><?php _e( 'Title Color:' ); ?></label> </h3>
      <input class="widefat" id="<?php echo $this->get_field_id( 'wpsp_title_color' ); ?>" name="<?php echo $this->get_field_name( 'wpsp_title_color' ); ?>" type="text" value="<?php echo $wpsp_title_color;?>" />
      <div class="cw-color-picker" rel="<?php echo $this->get_field_id('wpsp_title_color'); ?>"></div>
    </p>
    <p>
      <h3><label for="<?php echo $this->get_field_id( 'wpsp_text_color' ); ?>"><?php _e( 'Text Color:' ); ?></label>      </h3>
      <input class="widefat" id="<?php echo $this->get_field_id( 'wpsp_text_color' ); ?>" name="<?php echo $this->get_field_name( 'wpsp_text_color' ); ?>" type="text" value="<?php echo $wpsp_text_color;?>" />
      <div class="cw-color-picker" rel="<?php echo $this->get_field_id('wpsp_text_color'); ?>"></div>
    </p>  
    
    <p>
    <h3><label for="<?php echo $this->get_field_id( 'wpsp_text' ); ?>"><?php _e( 'text:' ); ?></label> </h3>
    <input class="widefat" id="<?php echo $this->get_field_id( 'wpsp_text' ); ?>" name="<?php echo $this->get_field_name( 'wpsp_text' ); ?>" type="text" value="<?php echo $wpsp_text;?>" />
    </p>
    <p>
    <h3><label for="<?php echo $this->get_field_id( 'wpsp_button_text' ); ?>"><?php _e( 'Button text:' ); ?></label> </h3>
    <input class="widefat" id="<?php echo $this->get_field_id( 'wpsp_button_text' ); ?>" name="<?php echo $this->get_field_name( 'wpsp_button_text' ); ?>" type="text" value="<?php echo $wpsp_button_text;?>" />
    </p>
    <?php 
  }

  public function update( $new_instance, $old_instance ) {
    // processes widget options to be saved
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['wpsp_title_position'] = strip_tags( $new_instance['wpsp_title_position']);
    $instance['wpsp_title_color'] = strip_tags( $new_instance['wpsp_title_color']);
    $instance['wpsp_text_color'] = strip_tags( $new_instance['wpsp_text_color']);
    $instance['wpsp_text'] = strip_tags( $new_instance['wpsp_text']);   
    $instance['wpsp_button_text'] = strip_tags( $new_instance['wpsp_button_text']);  
    $instance['wpsp_form_type'] = strip_tags( $new_instance['wpsp_form_type']);  
    return $instance;
  }

  public function widget( $args, $instance ) {
    // outputs the content of the widget
        extract( $args );
        // print_r($args);
        // print_r($args['widget_id']);
        $title = apply_filters( 'widget_title', $instance['title'] );
        $form_type = $args['formtype'] ? $args['formtype'] : $instance['wpsp_form_type'];
        $front_data = array(
            'wpsp_title_position' => $instance['wpsp_title_position'] ,
            'wpsp_title_color' => $instance['wpsp_title_color'] ,
            'wpsp_text_color' => $instance['wpsp_text_color'] ,
            'wpsp_text' => $instance['wpsp_text'] ,
            'wpsp_button_text' => $instance['wpsp_button_text'] ,
            'wpsp_form_type' => $form_type,
            'category' => $args['category'],
            'widget_id' => $args['widget_id']
            );
        echo $before_widget;
        if ( ! empty( $title ) ){
            echo $before_title . $title . $after_title;
        }
        $this->wpsp_widget($front_data);
        echo $after_widget;
  }
 
  public function wpsp_widget($front_data){
   ?>
    <style type="text/css">
    .widget_wpsp_widget h3.widget-title{      
    <?php
          if(isset($front_data['wpsp_title_color'])){
            echo 'color:'.$front_data['wpsp_title_color'].';';
          }else{echo 'color:#FFFFFF;';}          
          
          if(isset($front_data['wpsp_title_position'])){
            echo 'text-align:'.$front_data['wpsp_title_position'].';';
          }else{echo 'text-align:center;';}
    ?>      
    }
    .wpsp_title_view{
       <?php
          if(isset($front_data['wpsp_text_color'])){
            echo 'color:'.$front_data['wpsp_text_color'].';';
          }else{echo 'color:#000000;';}
       ?>
    }
    .wpsp_des_view{
      <?php
          if(isset($front_data['wpsp_news_des_color'])){
            echo 'color:'.$front_data['wpsp_news_des_color'].';';
          }else{echo 'color:#000000;';}
       ?>     
    }    
    </style>
    
    <link rel='stylesheet'  href='<?php echo WPSP_BASE_URL.'/css/wpsp-style.css'; ?>' type='text/css' />      
    <?php 
    wp_enqueue_script('jquery');
    
    ?>
    <script> 

    /*
      
      umesh@us.ibm.com - Umesh Kumar/Watson/Contr/IBM: 
3:16:54 PM:             $("#story-space-2[data-widget='masonry']").masonry("reloadItems");
            $("#story-space-2[data-widget='masonry']").imagesLoaded(function(){
                $("#story-space-2[data-widget='masonry']").masonry();
            });

    */

      function NH_show_state(state){
        console.log('NH_show_state...'+state);

        window.newshub.subscriptionBar.showState(state);
        
      }

      function check_wpsp_email(e){
        console.log("inside check email", e);
        var $widgetContainer = $(e).closest('.wpsp_subs');
        $ftype=$widgetContainer.find('#hdval_form_type').val();
        $category=$widgetContainer.find('#sub_cat').val();
        $path=$widgetContainer.find('#hdval_path').val(); 
        $path+='/wp-silverpop/includes/wpsp-email2.php'; 
        $path2 = $widgetContainer.find('#hdval_path').val()+'/wp-silverpop/includes/wpsp-email3.php'; 
        

        var $formContainer = $(e).closest('form');
        $email=$formContainer.find('#user_email').val();
        $name=$formContainer.find('#user_name').val();
        $fname=$formContainer.find('#user_fname').val();
        $lname=$formContainer.find('#user_lname').val();
        
        $wid = $(e).closest("aside").attr("id");

        var errObj = $widgetContainer.find('.wpsp_display_error');
        var chk=wpsp_validateEmail($email);

        console.log('errObj===',errObj.length);
         if(chk==false){    
           errObj.show();
           errObj.text('invalid email');
           NH_show_state('error');
         }else{           
           wpsp_check_email_wg(e, $email, $path, $name, $fname, $lname, $ftype, $category, $path2);
         }
      }
      
   function wpsp_check_email_wg(obj, email, path, name, fname, lname, ftype, category, path2){
     var $widgetContainer = $(obj).closest('.wpsp_subs');
     var $formContainer = $(obj).closest('form');
     // $wid = $(obj).closest("aside").attr("id");

     var sp_lsource = $widgetContainer.find('#sp_lsource').val();
     var sp_marketing_news = $widgetContainer.find('#sp_marketing_news').val();


     // $formContainer.find(".wpsp_display_success").hide();
     // $formContainer.find(".wpsp_display_error").hide();
     var datatobesent = {email: email, ftype:ftype, fname:fname, lname:lname, category:category, source:sp_lsource, sp_marketing_news:sp_marketing_news};
     var buttonTextVal = $formContainer.find(".formsubmitbutton").text();
     $formContainer.find(".formsubmitbutton").attr("disabled",true);
     $formContainer.find(".formsubmitbutton").text("Subscribing...");

     // $formContainer.find(".spinner-wrapper").show();
     NH_show_state('loading');
      jQuery.ajax({
        type: "POST",
        url: path,
        data: datatobesent,
        success: function(msg){
          
          //If valid JSON
          try {
            msg = JSON.parse(msg);
          } catch (e) {
              
          }
            // msg = jQuery.parseJSON(msg);  
          
          if((msg.SUCCESS && msg.SUCCESS == 'TRUE')){

            NH_show_state('Phase 1 : success');
                  // NH_show_state('success');

                  // var successContainer = $widgetContainer.find(".wpsp_display_success");
                  // var height = $formContainer.height();            
            call_double_optin(msg, path2, $widgetContainer, $formContainer, buttonTextVal);
            // var successContainer = $widgetContainer.find(".wpsp_display_success");
            // var height = $formContainer.height(); 

          }else{
            // NEWSHUB_CUSTOM_CODE: dispatch an event so that page knows what just happened.
            NH_show_state('error');

            var errorContainer = $widgetContainer.find(".wpsp_display_error");
            errorContainer.show();
            errorContainer.text(msg);    
            $formContainer.find(".formsubmitbutton").removeAttr("disabled");
            $formContainer.find(".formsubmitbutton").text(buttonTextVal);        
          }          
        }
      });         
    } 

    function call_double_optin(msg, path2, $widgetContainer, $formContainer, buttonTextVal){
      
      jQuery.ajax({
        type: "POST",
        url: path2,
        data: msg,
        success: function(msg){
          if(msg==1){
            NH_show_state('success');

            var successContainer = $widgetContainer.find(".wpsp_display_success");
            var height = $formContainer.height();
          }else{
            NH_show_state('error');

            var errorContainer = $widgetContainer.find(".wpsp_display_error");
            errorContainer.show();
            errorContainer.text(msg);  
          }
          // $formContainer.find(".spinner-wrapper").hide();
          $formContainer.find(".formsubmitbutton").removeAttr("disabled");
          $formContainer.find(".formsubmitbutton").text(buttonTextVal);                  
        }
      });      
    }
      
    function wpsp_validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if( !emailReg.test( $email ) ) {
        return false;
      } else {
        return true;
      }
    } 

  function ClearPlaceHolder (input) {
    if (input.value == input.defaultValue) {
      input.value = "";
    }
  }
  
  function SetPlaceHolder (input) {
    if (input.value == "") {
      input.value = input.defaultValue;
    }
  }
  </script>
  
  <?php

    if (isset($_GET['sp_lsource'])) {
      $sp_lsource = filter_input( INPUT_GET, 'sp_lsource', FILTER_SANITIZE_URL );
      $sp_lsource = htmlspecialchars($sp_lsource, ENT_QUOTES);
    }
    if (isset($_GET['sp_marketing_news'])) {
      $sp_marketing_news = filter_input( INPUT_GET, 'sp_marketing_news', FILTER_SANITIZE_URL );
      $sp_marketing_news = htmlspecialchars($sp_marketing_news, ENT_QUOTES);
    }    
    echo '<div class="wpsp_subs" style="height:'.($front_data['scn_height']).'px; overflow:hidden;">';
  ?>
    <!-- Hidden fields -->
    <input type="hidden" value="<?php if(isset($front_data['category'])) {echo $front_data['category'];}else{ echo 'All';}  ?>" name="sub_cat" id="sub_cat" />   
    <input type="hidden" id="sp_lsource" value="<?php echo isset($sp_lsource)?$sp_lsource:'think_marketing_site'; ?>" /> 
    <input type="hidden" id="sp_marketing_news" value="<?php echo isset($sp_marketing_news)?$sp_marketing_news:'Yes'; ?>" /> 
    <input type="hidden" id="hdval_path" value="<?php echo plugins_url(); ?>" />    
    <input type="hidden" id="hdval_form_type" value="<?php if(isset($front_data['wpsp_form_type'])){ echo $front_data['wpsp_form_type'];} ?>" /> 
    <form id="registerForm" class="ibm-column-form">
          
        <p><span class="ibm-h4 ibm-bold ibm-center" style="margin:0;padding:0.9em;">Subscribe to our newsletter for all things marketing.</span></p>
          <!-- <p> -->
        
    <!--         <span>
                <input type="text" value="Enter e-Mail" id="user_email" name="user_email"><span class="ibm-required" onFocus="ClearPlaceHolder (this)" onBlur="SetPlaceHolder (this)" >*</span>
            </span>
          </p> -->

          <p class="input-wrap">
        <input type="text" value="Enter email address" name="user_email" id="user_email" class="textfield email" onFocus="ClearPlaceHolder (this)" onBlur="SetPlaceHolder (this)" />
        </p>

        <?php if(isset($front_data['wpsp_form_type']) && $front_data['wpsp_form_type'] == "2"): ?>
          <p class="input-wrap">    
            <input type="text" value="Name" name="user_name" id="user_name" class="textfield" onFocus="ClearPlaceHolder (this)" onBlur="SetPlaceHolder (this)" />
          </p>
        <?php endif; ?>

        <?php if(isset($front_data['wpsp_form_type']) && $front_data['wpsp_form_type'] == "3"): ?>
          <p class="input-wrap">    
            <input type="text" value="First Name" name="user_fname" id="user_fname" class="textfield" onFocus="ClearPlaceHolder (this)" onBlur="SetPlaceHolder (this)" />
          </p>
          <p class="input-wrap">     
            <input type="text" value="Last Name" name="user_lname" id="user_lname" class="textfield" onFocus="ClearPlaceHolder (this)" onBlur="SetPlaceHolder (this)" />
          </p>
        <?php endif; ?>
        <!-- <p class="spinner-wrapper"><span class="ibm-spinner"></span>Subscribing ..</p> -->
        <!-- <div class="loading" style="display: none;"></div> -->
        <button name="Submit" class="ibm-btn-pri formsubmitbutton ibm-btn-blue-50" onclick="check_wpsp_email(this); return false;"><?php echo $front_data['wpsp_button_text']; ?></button>
        <div class="register-message-wrapper">
          <p class="error-message-wrap">
            <span id="wpsp_display_error<?php if(isset($front_data['widget_id'])) {echo '_'.$front_data['widget_id'];} ?>" class="wpsp_display_error ibm-item-note ibm-alert-link"></span>
          </p>
          
          <div id="wpsp_display_success<?php if(isset($front_data['widget_id'])) {echo '_'.$front_data['widget_id'];} ?>" class="wpsp_display_success">
            <p><span class="ibm-bold">Success!</span> Thanks for subscribing to the THINK Marketing monthly newsletter.</p>
          </div>
        </div>     
    </form>
    <?php
    echo '</div>';
  }
}

function wpsp_color_picker_script(){
  wp_enqueue_script('farbtastic');
}
function wpsp_color_picker_style(){
  wp_enqueue_style('farbtastic'); 
}

add_action('admin_print_scripts-widgets.php', 'wpsp_color_picker_script');
add_action('admin_print_styles-widgets.php', 'wpsp_color_picker_style');
?>