<?php

if (get_option('wpsp_popup_active')=='1'){

  add_action('wp_footer', 'wpsp_popup_to_body');

}



function wpsp_popup_to_body(){

  $width=get_option('wpsp_popup_w');  

  $height=get_option('wpsp_popup_h');

  $margin=$width/2;

  $txt_width=get_option('wpsp_popup_txt_width');

  $btn_width=get_option('wpsp_popup_btn_width');

  /*

    $width=360;

    $height=330;

    $margin=($width/2)+10;

    $txt_width=270;*/	

  



 

  if($_COOKIE["wpsp_cookie"]){

    return false;

  }

  

  if(get_option("wpsp_popup_required")==1){

    ?>

          <script type="text/javascript">

            jQuery(document).ready(function(){

              required_wpmcup();    

            });

          </script>

          <?php

  }

    if(get_option("wpsp_popup_position")==1){

      //if(is_home()):

	  if(is_home() || is_front_page()):

      ?>

      <script type="text/javascript">

        jQuery(document).ready(function(){

          load_wpmcup();    

        });

      </script>

      <?php 

        endif;

    }



    elseif(get_option("wpsp_popup_position")==2){

      if(is_page()):

        ?>

      <script type="text/javascript">

        jQuery(document).ready(function(){

          load_wpmcup();    

        });

      </script>

      <?php

        endif;					

    }



    elseif(get_option("wpsp_popup_position")==3){

      if(is_single()):

        ?>

      <script type="text/javascript">

        jQuery(document).ready(function(){

          load_wpmcup();    

        });

      </script>

      <?php

      endif;					

    }



    elseif(get_option("wpsp_popup_position")==4){

      if(is_archive()):

        ?>

        <script type="text/javascript">

          jQuery(document).ready(function(){

            load_wpmcup();    

          });

        </script>

        <?php

        endif;					

    }

    elseif(get_option("wpsp_popup_position")==0){

      ?>

      <script type="text/javascript">

        jQuery(document).ready(function(){

          load_wpmcup();    

        });

      </script>

      <?php					

    }	

        

        

   ?>

<script type="text/javascript">

  

  function load_wpmcup(){

    var wpsp_popup_delay_time=<?php echo get_option('wpsp_popup_delay_time'); ?>*1000;    

    setTimeout(function(){ 

        loadPopup(); 

      }, wpsp_popup_delay_time); // .5 second

    return false;

  }

  function wpsp_close_popup(){

    disablePopup();    

  }

    /* event for close the popup */

	jQuery("div.close").hover(

					function() {

						jQuery('span.ecs_tooltip').show();

					},

					function () {

    					jQuery('span.ecs_tooltip').hide();

  					}

				);

	

	jQuery(this).keyup(function(event) {

		if (event.which == 27) { // 27 is 'Ecs' in the keyboard

			disablePopup();  // function close pop up

		}  	

	});

	

	jQuery("div#wpsp_backgroundPopup").click(function() {

		disablePopup();  // function close pop up

	});

	

	jQuery('a.livebox').click(function() {		

    jQuery("#wpsp_toPopup").fadeOut("normal");  

			jQuery("#wpsp_backgroundPopup").fadeOut("normal");  

			popupStatus = 0;

	return false;

	});

	



	 /************** start: functions. **************/

	function loading() {

		jQuery("div.loader").show();  

	}

	function closeloading() {

		jQuery("div.loader").fadeOut('normal');  

	}

	

	var popupStatus = 0; // set value

	

	function loadPopup() { 

		if(popupStatus == 0) { // if value is 0, show popup

			closeloading(); // fadeout loading

			jQuery("#wpsp_toPopup").fadeIn(0500); // fadein popup div

			jQuery("#wpsp_backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8

			jQuery("#wpsp_backgroundPopup").fadeIn(0001); 

			popupStatus = 1; // and set value to 1

		}	

	}

		

	function disablePopup() {    

		if(popupStatus == 1) { // if value is 1, close popup

			jQuery("#wpsp_toPopup").fadeOut("normal");  

			jQuery("#wpsp_backgroundPopup").fadeOut("normal");  

			popupStatus = 0;  // and set value to 0

		}

	}

  

  //custom

  function required_wpmcup(){

     jQuery("#wpsp_close").hide();

     jQuery(document).keyup(function(e) {

        if (e.keyCode == 27) {return false }

      });

  }



	/************** end: functions. **************/

</script>

<style>

  #wpsp_backgroundPopup {

    <?php

      echo 'background:#'.get_option('wpsp_popup_overlay_color').';';

     ?>

  }

  #wpsp_toPopup {

    <?php    

    

    //echo 'background:#'.get_option('wpsp_popup_bg_color').';';

    if(get_option('wpsp_popup_bg_image')!=''){

      echo 'background:linear-gradient(to bottom, #'.get_option('wpsp_popup_bg_color1').' 0%, #'.get_option('wpsp_popup_bg_color').' 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);';

      echo 'background:url('.get_option('wpsp_popup_bg_image').');';

    }else{

      echo 'background:linear-gradient(to bottom, #'.get_option('wpsp_popup_bg_color1').' 0%, #'.get_option('wpsp_popup_bg_color').' 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);';

    }

    

    echo 'border:solid 8px #'.get_option('wpsp_popup_border_color').';';

    echo 'width:'.$width.'px;';

    echo 'min-height:'.$height.'px;';

    echo 'margin-left:-'.$margin.'px;';

   echo ' border-radius: '.get_option('wpsp_popup_radius_top_l').'px '.get_option('wpsp_popup_radius_top_r').'px '.get_option('wpsp_popup_radius_btm_r').'px '.get_option('wpsp_popup_radius_btm_l').'px;';

    

    ?>

  }

  .wpsp_btn input[type="button"].button2{

    border: 0 none;

    font-size: 13px;

    font-weight: bold;

    height: 36px;

    margin-top: 5px;        

    background:blueviolet;

    text-align:centet;

    <?php

    echo 'width:'.$btn_width.'px;';

    ?>

  }

  .wpsp_btn input[type="button"].button2{    

    <?php

    echo 'background:linear-gradient(to bottom, #'.get_option('wpsp_popup_btn_color1').' 0%, #'.get_option('wpsp_popup_btn_color').' 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);';

    echo 'color:#'.get_option('wpsp_popup_btn_text_color').';';

    echo 'border-radius:'.get_option('wpsp_popup_btn_radius').'px;';

    ?>   

  }  

  .wpsp_btn input[type="button"].button2:hover{    

    <?php

    echo 'background:linear-gradient(to bottom, #'.get_option('wpsp_popup_btn_ol_color1').' 0%, #'.get_option('wpsp_popup_btn_ol_color').' 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);';

    echo 'color:#'.get_option('wpsp_popup_btn_ol_text_color').';';

    echo 'border-radius:'.get_option('wpsp_popup_btn_radius').'px;';

    ?>

  }

  .wpsp_area{

    <?php

    echo 'width:'.($txt_width+30).'px;';

    if(get_option('wpsp_popup_bottom_content')==0){

      echo 'margin:0;';

    }else if(get_option('wpsp_popup_bottom_content')==2){

      echo 'float:right;';

    }else{

      echo 'margin:auto;';

    }

    ?>

  } 

  .wpsp_txt input{

    <?php

    echo 'width:'.$txt_width.'px;';

    echo 'color:#'.get_option('wpsp_popup_txt_color').';';

    ?>

    margin:0px 0px 7px 0px;    

  }

 .wpsp_txt input[type="text"], textarea {

   <?php    

    echo 'background:#'.get_option('wpsp_popup_txt_bg_color').';';

    echo 'border:solid 1px #'.get_option('wpsp_popup_txt_border_color').';';

    echo 'border-radius:'.get_option('wpsp_popup_txt_border_radius').'px;';

    ?>

   padding:5px;

 }

 .wpsp_con_2{

    display:none;    

  }

 @media only screen and (max-width: 48em) {

  #wpsp_toPopup {

    width:270px;

    margin-left:-145px;

    min-height:200px;

    max-height:700px;

  }

  .wpsp_btn input[type="button"].button2{

    width:180px;

    margin-bottom:3px;

  }

  .wpsp_area{

    width:210px;

    margin:auto;

  }

  .wpsp_txt input{

    width:180px;

  }

  .wpsp_con{

    display:none;    

  }

  .wpsp_con_2{

    display:block;    

  }

}

 

</style>



    <script> 

    function check_wpsp_popup_email(){      

      jQuery("#error5").hide();

      $email=jQuery('#popup_user_email').val();

      $path=jQuery('#hdval_path').val();

      $path+='/wp-silverpop/includes/wpsp-email2.php';      

      $ftype=jQuery('#hdval_form_type').val();

      

      $name='';

      $fname='';

      $lname='';

      if($ftype==2){

        $name=jQuery('#popup_user_fname').val();

      }else if($ftype==3){

        $fname=jQuery('#popup_user_fname').val();

        $lname=jQuery('#popup_user_lname').val();

      }  

     

      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

      

      if( !emailReg.test( $email ) ) {        

        jQuery("#error5").show();

        jQuery('#error5').text('invalid email');

      } else {        

        jQuery("#error5").hide();

          check_popup_email($email, $path, $name, $fname, $lname, $ftype);

      }        

    }

      

   function check_popup_email(email, path, name, fname, lname, ftype){

     var success_msg=jQuery('#hdval_mcpop_scc_msg').val();

      jQuery(".loading2").show();

			jQuery.ajax({

				type: "POST",

				url: path,

				data: {email: email, name:name, fname:fname, lname:lname, ftype:ftype},

				success: function(msg){

          //alert(msg);

          

          if(msg==1){

            jQuery("#error5").hide();

            jQuery("#success5").show();

            jQuery('#success5').text(success_msg);

            setTimeout(wpsp_close_popup,4000);

          }else{

          

            jQuery("#error5").show();

            jQuery('#error5').text(msg);            

          }

          jQuery(".loading2").hide();

				}

			});					

		}

    

  function ClearPlaceHolder2 (input) {

		if (input.value == input.defaultValue) {

			input.value = "";

		}

	}

  

	function SetPlaceHolder2 (input) {    

		if (input.value == "") {

			input.value = input.defaultValue;

		}

	}    

  </script>



<div id="wpsp_toPopup">

    <div class="wpsp_close" id="wpsp_close" style="display:block;" onclick="wpsp_close_popup()"></div>       	

		<div id="popup_content"> <!--your content start-->

      

      <div class="wpsp_con">

        <?php echo get_option('wpsp_text') ?>

      </div>

      <div class="wpsp_con_2">

        <?php echo get_option('wpsp_text_2') ?>

      </div>

      <form id="registerForm">

      <input type="hidden" id="hdval_path" value="<?php echo plugins_url(); ?>" />

      <input type="hidden" id="hdval_mcpop_scc_msg" value="<?php echo get_option('wpsp_success_message'); ?>" />

      <input type="hidden" id="hdval_form_type" value="<?php echo get_option('wpsp_popup_form_type'); ?>" />      

      <div class="wpsp_area">

        <div class="wpsp_txt">

          <?php

            if(get_option('wpsp_popup_form_type')==2){

              echo '<input type="text" value="Name" name="popup_user_fname" id="popup_user_fname" class="textfield" onFocus="ClearPlaceHolder2 (this)" onBlur="SetPlaceHolder2 (this)" />';

            }else if(get_option('wpsp_popup_form_type')==3){

              echo '<input type="text" value="First Name" name="popup_user_fname" id="popup_user_fname" class="textfield" onFocus="ClearPlaceHolder2 (this)" onBlur="SetPlaceHolder2 (this)" />';

              echo '<input type="text" value="Last Name" name="popup_user_lname" id="popup_user_lname" class="textfield" onFocus="ClearPlaceHolder2 (this)" onBlur="SetPlaceHolder2 (this)" />';

            }

            ?>

            <input type="text" value="Email Address" name="popup_user_email" id="popup_user_email" class="textfield email" onFocus="ClearPlaceHolder2 (this)" onBlur="SetPlaceHolder2 (this)" />

            

          </div>

        <div class="error" id="error5" style="display:none;"></div>

        <div class="success5" id="success5" style="display:none;"></div>

        

        <div class="loading_img">        

          <div class="loading2" style="display: none;"></div>

        </div>

        <div class="wpsp_btn">      

          <input type="button" value="<?php echo get_option('wpsp_popup_button_text'); ?>" onclick="check_wpsp_popup_email()" class="button2" name="Submit">

        </div>

      </div>

      </form>           

    </div> <!--your content end-->

    

    </div> <!--wpsp_toPopup end-->    

	

   	<div id="wpsp_backgroundPopup"></div>

<?php

}

?>