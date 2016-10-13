<?php
function wpsp_reset(){
      update_option('wpsp_popup_active',1);
      update_option('wpsp_popup_required',0);      
			update_option('wpsp_popup_cookie',0);
      update_option('wpsp_popup_delay_time',2);
			update_option('wpsp_popup_w','523');
			update_option('wpsp_popup_h','290');		
			update_option('wpsp_popup_position','1');
      update_option('wpsp_popup_form_type','2');
      update_option('wpsp_popup_bg_color','C3D3F7');
      update_option('wpsp_popup_bg_color1','C3D3F7');
      update_option('wpsp_popup_bg_image','');      
			update_option('wpsp_popup_border_color','FFFFFF');		
			update_option('wpsp_popup_overlay_color','8C8C8C'); 
                  
      $wpsp_con='<div style="width:100%; height:135px; padding-top:5px; margin-bottom:0px; background-color:#C3D3F7;">
  <div style="width:100%; height:40px; background:#03607F; font-weight:bold; text-align:center; font-size:20px; color:#FFFFFF; padding-top:5px;">Subscribe for Newsletter</div><br />
  <div style="width:80px; float:left; margin-left:10px;"><img src="http://solvercircle.com/logo/message-icon2.png" alt="message-icon2" width="60" height="39" class="alignnone size-full wp-image-282" /></div>
  <div style="width:350px; float:left;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</div></div>';
  
      $wpsp_con_2='<div style="width:240px; height:25px; text-align:center; font-size:15px; font-weight:bold; padding:10px;">SUBSCRIBE TO OUR NEWSLETTER</div>';
              
      update_option('wpsp_text',$wpsp_con);
      update_option('wpsp_text_2',$wpsp_con_2);
      update_option('wpsp_popup_button_text','Sign Up');
      update_option('wpsp_success_message','Successfully subscribed');
      
      update_option('wpsp_popup_radius_top_l','5');
      update_option('wpsp_popup_radius_top_r','5');
      update_option('wpsp_popup_radius_btm_l','5');
      update_option('wpsp_popup_radius_btm_r','5');
      
      update_option('wpsp_popup_txt_width','300');
      update_option('wpsp_popup_txt_color','666666');
      update_option('wpsp_popup_txt_bg_color','FFFFFF');
      update_option('wpsp_popup_txt_border_color','CCCCCC');
      update_option('wpsp_popup_txt_border_radius','2');
      
      update_option('wpsp_popup_btn_width','220');
      
      update_option('wpsp_popup_btn_color','1E8CBE');
      update_option('wpsp_popup_btn_color1','27B8FA');
      update_option('wpsp_popup_btn_text_color','FFFFFF');
      update_option('wpsp_popup_btn_ol_color','5D5AB8');
      update_option('wpsp_popup_btn_ol_color1','27BCFF');
      update_option('wpsp_popup_btn_ol_text_color','EBEBEB');
      update_option('wpsp_popup_btn_radius','2');
      
      update_option('wpsp_popup_bottom_content','1');      
      
			echo '<div id="message" class="updated fade"><p>Your settings were reset !</p></div>';
}


function wpsp_popup_setting(){
  
  ?>
<script>
  function wpsp_popup_bg_upload(){
    formfield = jQuery('#wpsp_popup_bg_image').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		window.send_to_editor = function(html) {
      //alert(html);
			imgurl = jQuery('img',html).attr('src');
			jQuery('#wpsp_popup_bg_image').val(imgurl);
			tb_remove();
		}
		return false;
  }
</script>
  <?php
		if($_POST['wpsp_status_submit']==1){			
			update_option('wpsp_popup_active',$_POST['wpsp_popup_active']);
      update_option('wpsp_popup_required',$_POST['wpsp_popup_required']);      
			update_option('wpsp_popup_cookie',intval($_POST['wpsp_popup_cookie']));
      update_option('wpsp_popup_delay_time',$_POST['wpsp_popup_delay_time']);
			update_option('wpsp_popup_w',intval($_POST['wpsp_popup_w']));
			update_option('wpsp_popup_h',intval($_POST['wpsp_popup_h']));			
			update_option('wpsp_popup_position',intval($_POST['wpsp_popup_position']));
      update_option('wpsp_popup_form_type',intval($_POST['wpsp_popup_form_type']));      
      update_option('wpsp_popup_bg_color',$_POST['wpsp_popup_bg_color']);
      update_option('wpsp_popup_bg_color1',$_POST['wpsp_popup_bg_color1']);
      update_option('wpsp_popup_bg_image',$_POST['wpsp_popup_bg_image']);      
			update_option('wpsp_popup_border_color',$_POST['wpsp_popup_border_color']);			
			update_option('wpsp_popup_overlay_color',$_POST['wpsp_popup_overlay_color']);      
      update_option('wpsp_text',stripslashes($_POST['wpsp_text']));
      update_option('wpsp_text_2',stripslashes($_POST['wpsp_text_2']));      
      update_option('wpsp_popup_button_text',$_POST['wpsp_popup_button_text']);      
      update_option('wpsp_success_message',stripslashes($_POST['wpsp_success_message']));
			      
      update_option('wpsp_popup_radius_top_l',$_POST['wpsp_popup_radius_top_l']);
      update_option('wpsp_popup_radius_top_r',$_POST['wpsp_popup_radius_top_r']);
      update_option('wpsp_popup_radius_btm_l',$_POST['wpsp_popup_radius_btm_l']);
      update_option('wpsp_popup_radius_btm_r',$_POST['wpsp_popup_radius_btm_r']);      
      update_option('wpsp_popup_txt_width',$_POST['wpsp_popup_txt_width']);
      update_option('wpsp_popup_txt_color',$_POST['wpsp_popup_txt_color']);
      
      update_option('wpsp_popup_txt_bg_color',$_POST['wpsp_popup_txt_bg_color']);
      update_option('wpsp_popup_txt_border_color',$_POST['wpsp_popup_txt_border_color']);
      update_option('wpsp_popup_txt_border_radius',$_POST['wpsp_popup_txt_border_radius']);     
      
      update_option('wpsp_popup_btn_width',$_POST['wpsp_popup_btn_width']);
      update_option('wpsp_popup_btn_color',$_POST['wpsp_popup_btn_color']);
      update_option('wpsp_popup_btn_color1',$_POST['wpsp_popup_btn_color1']);
      update_option('wpsp_popup_btn_text_color',$_POST['wpsp_popup_btn_text_color']);
      update_option('wpsp_popup_btn_ol_color',$_POST['wpsp_popup_btn_ol_color']);
      update_option('wpsp_popup_btn_ol_color1',$_POST['wpsp_popup_btn_ol_color1']);
      update_option('wpsp_popup_btn_ol_text_color',$_POST['wpsp_popup_btn_ol_text_color']);
      update_option('wpsp_popup_btn_radius',$_POST['wpsp_popup_btn_radius']);      
      
      update_option('wpsp_popup_bottom_content',$_POST['wpsp_popup_bottom_content']);      
      
      echo '<div id="message" class="updated fade"><p>Your settings were saved !</p></div>';
		}
    
		if($_POST['wpsp_status_submit']==2){
			wpsp_reset();
		}
	?>
	<h2>Popup Setting</h2>
	<form method="post" id="wpsp_options">	
    	<input type="hidden" name="wpsp_status_submit" id="wpsp_status_submit" value="2"  />
		<table width="100%" cellspacing="2" cellpadding="5" class="editform">
			<tr valign="top"> 
				<td width="150" scope="row">Active plugin:</td>
				<td>
            <select name="wpsp_popup_active">
                <option value="1"<?php if (get_option('wpsp_popup_active')=='1'):?> selected="selected"<?php endif;?>>Yes</option>
                <option value="0"<?php if (get_option('wpsp_popup_active')=='0'):?> selected="selected"<?php endif;?>>No</option>                
            </select>
				</td>
			</tr>
      
      <tr valign="top"> 
				<td width="150" scope="row">Required:</td>
				<td>
            <select name="wpsp_popup_required">
                <option value="1"<?php if (get_option('wpsp_popup_required')=='1'):?> selected="selected"<?php endif;?>>Yes</option>
                <option value="0"<?php if (get_option('wpsp_popup_required')=='0'):?> selected="selected"<?php endif;?>>No</option>
            </select>
				</td>
			</tr>
      
       <tr valign="top"> 
				<td width="150" scope="row">Delay Time Before Popup Display:</td>
				<td>
            <select name="wpsp_popup_delay_time">
              <?php for($i=0; $i<=100; $i++){?>
                <option value="<?php echo $i?>"<?php if (get_option('wpsp_popup_delay_time')==$i):?> selected="selected"<?php endif;?>><?php echo $i;?></option>
              <?php }?>
            </select> [Second]
				</td>
			</tr>
      
      <tr valign="top"> 
				<td width="150" valign="top" scope="row">Display popup:</td>
				<td>
            <select name="wpsp_popup_cookie">
                <option value="0"<?php if (get_option('wpsp_popup_cookie')=='0'):?> selected="selected"<?php endif;?>>1 Min</option>
                <option value="1"<?php if (get_option('wpsp_popup_cookie')=='1'):?> selected="selected"<?php endif;?>>1 Day</option>
                <option value="7"<?php if (get_option('wpsp_popup_cookie')=='7'):?> selected="selected"<?php endif;?>>1 Week</option>
                <option value="30"<?php if (get_option('wpsp_popup_cookie')=='30'):?> selected="selected"<?php endif;?>>1 Month</option>
                <option value="90"<?php if (get_option('wpsp_popup_cookie')=='90'):?> selected="selected"<?php endif;?>>3 Month</option>
                <option value="180"<?php if (get_option('wpsp_popup_cookie')=='180'):?> selected="selected"<?php endif;?>>6 Month</option>
                <option value="365"<?php if (get_option('wpsp_popup_cookie')=='365'):?> selected="selected"<?php endif;?>>1 Year</option>
            </select>
				</td> 
			</tr>
      <tr valign="top"> 
				<td width="150" scope="row" valign="top" valign="middle">Display option:</td>
				<td>
                	<p><label><input type="radio" name="wpsp_popup_position" <?php if (get_option('wpsp_popup_position')=='1'):?> checked="checked"<?php endif;?> value="1" /> Home</label></p>
                   
                    <p><label><input type="radio" name="wpsp_popup_position" <?php if (get_option('wpsp_popup_position')=='2'):?> checked="checked"<?php endif;?> value="2" /> Pages only</label></p>
                    
                    <p><label><input type="radio" name="wpsp_popup_position" <?php if (get_option('wpsp_popup_position')=='3'):?> checked="checked"<?php endif;?> value="3" /> Single post only</label></p>
                    
                    <p><label><input type="radio" name="wpsp_popup_position" <?php if (get_option('wpsp_popup_position')=='4'):?> checked="checked"<?php endif;?> value="4" /> Archives only</label></p>
                   
                    <p><label><input type="radio" name="wpsp_popup_position" <?php if (get_option('wpsp_popup_position')=='0'):?> checked="checked"<?php endif;?> value="0" /> All</label></p>
				</td> 
			</tr>
      
      <tr valign="top"> 
				<td width="150" scope="row" valign="top" valign="middle">Form Fields:</td>
				<td>
                	<p><label><input type="radio" name="wpsp_popup_form_type" <?php if (get_option('wpsp_popup_form_type')=='1'):?> checked="checked"<?php endif;?> value="1" /> Email</label></p>
                   
                    <p><label><input type="radio" name="wpsp_popup_form_type" <?php if (get_option('wpsp_popup_form_type')=='2'):?> checked="checked"<?php endif;?> value="2" /> Name and Email</label>&emsp; [Create a silverpop database field[Name] for use this option]</p>
                    
                    <p><label><input type="radio" name="wpsp_popup_form_type" <?php if (get_option('wpsp_popup_form_type')=='3'):?> checked="checked"<?php endif;?> value="3" /> First name, Last name and Email</label> &emsp; [Create silverpop database fields[FirstName and LastName] for use this option]</p>
                    
                    
				</td> 
			</tr>      
            
     <tr valign="top"> 
				<td  scope="row">Popup width:<br /></td> 
				<td scope="row">			
					<input name="wpsp_popup_w" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_w'));?>" /> px (number only)
				</td> 
			</tr>
      <tr valign="top"> 
				<td  scope="row">Popup height:<br /></td> 
				<td scope="row">			
					<input name="wpsp_popup_h" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_h'));?>" /> px (number only)
				</td> 
			</tr>      
      <tr>
        <td>Popup background Color:</td>
      <td> <input type="text" name="wpsp_popup_bg_color" size="5" id="wpsp_popup_bg_color" class="color" value="<?php echo get_option('wpsp_popup_bg_color')?>" />
        <input type="text" name="wpsp_popup_bg_color1" size="5" id="wpsp_popup_bg_color1" class="color" value="<?php echo get_option('wpsp_popup_bg_color1')?>" />[gradient color]
        </td>
      </tr>
      <tr>
        <td scope="row">Popup background Image</td>
        <td>
          <input type="text" name="wpsp_popup_bg_image" id="wpsp_popup_bg_image" value="<?php echo get_option('wpsp_popup_bg_image')?>" />
        <input id="wpsp_popup_bg_upload_button" class="button" onclick="wpsp_popup_bg_upload();" type="button" value="Upload Image" />
        </td>
      </tr>
      <tr>
        <td>Popup border Color:</td>
        <td>
          <input type="text" name="wpsp_popup_border_color" size="10" id="wpsp_popup_border_color" class="color" value="<?php echo get_option('wpsp_popup_border_color')?>" /> 
        </td>
      </tr>
      <tr>
        <td>Popup overlay Color:</td>
        <td>
          <input type="text" name="wpsp_popup_overlay_color" size="10" id="wpsp_popup_overlay_color" class="color" value="<?php echo get_option('wpsp_popup_overlay_color')?>" /> 
        </td>
      </tr>
      
      <tr>
        <td>Popup Text:</td>
        <td>
          <?php
          wp_editor(html_entity_decode(get_option('wpsp_text')),'wpsp_text', array('textarea_rows'=>6,'textarea_name'=> 'wpsp_text'));
          ?>
        </td>
      </tr>
      <tr>
        <td>Popup Text (Mobile Device):</td>
        <td>
          <?php
          wp_editor(html_entity_decode(get_option('wpsp_text_2')),'wpsp_text_2', array('textarea_rows'=>6,'textarea_name'=> 'wpsp_text_2'));
          ?>
        </td>
      </tr>
      
      <tr>
        <td>button text:</td>
        <td>
          <input type="text" name="wpsp_popup_button_text" id="wpsp_popup_button_text" value="<?php echo get_option('wpsp_popup_button_text')?>" /> 
        </td>
      </tr>
      
      <tr>
        <td>Subscription Success Message:</td>
        <td>
          <?php
          wp_editor(html_entity_decode(get_option('wpsp_success_message')),'wpsp_success_message', array('textarea_rows'=>3,'textarea_name'=> 'wpsp_success_message'));
          ?>
        </td>
      </tr>
      
      <tr>
        <td valign="top">Container Border Radius:</td>
        <td>
          <table>
          <td>
            Top Left<br />
            <input name="wpsp_popup_radius_top_l" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_radius_top_l'));?>" /> px
          </td>
          <td>
            Top Right<br />
            <input name="wpsp_popup_radius_top_r" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_radius_top_r'));?>" /> px
          </td>
          <td>
            Bottom Left<br />
            <input name="wpsp_popup_radius_btm_l" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_radius_btm_l'));?>" /> px
          </td>
          <td>
            Bottom Right<br />
            <input name="wpsp_popup_radius_btm_r" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_radius_btm_r'));?>" /> px [number only]
          </td>
        </table> 
        </td>
      </tr>
      <tr>
        <td valign="top">Subscription Text Box Option:</td>
        <td>
          <table>
            <tr>
              <td>Width</td>
              <td>
                <input name="wpsp_popup_txt_width" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_txt_width'));?>" /> px (number only)
              </td>
            </tr>
            <tr>
              <td>Font Color</td>
              <td>
                <input type="text" name="wpsp_popup_txt_color" size="4" id="wpsp_popup_txt_color" class="color" value="<?php echo get_option('wpsp_popup_txt_color')?>" />
              </td>
            </tr>
            <tr>
              <td>Background Color </td>
              <td>
                <input type="text" name="wpsp_popup_txt_bg_color" size="4" id="wpsp_popup_txt_bg_color" class="color" value="<?php echo get_option('wpsp_popup_txt_bg_color')?>" />
              </td>
            </tr>
            <tr>
              <td>Border Color </td>
              <td>
                <input type="text" name="wpsp_popup_txt_border_color" size="4" id="wpsp_popup_txt_border_color" class="color" value="<?php echo get_option('wpsp_popup_txt_border_color')?>" />
              </td>
            </tr>
       <tr valign="top"> 
				<td width="150" scope="row">Border Radius:</td>
				<td>
            <select name="wpsp_popup_txt_border_radius">
                <option value="0" <?php if (get_option('wpsp_popup_txt_border_radius')==0):?> selected="selected"<?php endif;?>>0</option>
                <option value="1" <?php if (get_option('wpsp_popup_txt_border_radius')==1):?> selected="selected"<?php endif;?>>1</option>
                <option value="2" <?php if (get_option('wpsp_popup_txt_border_radius')==2):?> selected="selected"<?php endif;?>>2</option>
                <option value="3" <?php if (get_option('wpsp_popup_txt_border_radius')==3):?> selected="selected"<?php endif;?>>3</option>
                <option value="4" <?php if (get_option('wpsp_popup_txt_border_radius')==4):?> selected="selected"<?php endif;?>>4</option>
                <option value="5" <?php if (get_option('wpsp_popup_txt_border_radius')==5):?> selected="selected"<?php endif;?>>5</option>                
            </select>
				</td>
			</tr>      
          </table>
          
        </td>
      </tr>
      <tr>
        <td valign="top">Subscription Button Design:</td>
        <td>
        <table>
          <tr>
            <td>Button Width</td>
            <td colspan="3">
              <input name="wpsp_popup_btn_width" size="4" maxlength="4" value="<?php echo (get_option('wpsp_popup_btn_width'));?>" /> px (number only)
            </td>
          </tr>
          <tr>
            <td>Button Radius</td>
            <td colspan="3">
              <select name="wpsp_popup_btn_radius">
                <option value="0" <?php if (get_option('wpsp_popup_btn_radius')==0):?> selected="selected"<?php endif;?>>0</option>
                <option value="1" <?php if (get_option('wpsp_popup_btn_radius')==1):?> selected="selected"<?php endif;?>>1</option>
                <option value="2" <?php if (get_option('wpsp_popup_btn_radius')==2):?> selected="selected"<?php endif;?>>2</option>
                <option value="3" <?php if (get_option('wpsp_popup_btn_radius')==3):?> selected="selected"<?php endif;?>>3</option>
                <option value="4" <?php if (get_option('wpsp_popup_btn_radius')==4):?> selected="selected"<?php endif;?>>4</option>
                <option value="5" <?php if (get_option('wpsp_popup_btn_radius')==5):?> selected="selected"<?php endif;?>>5</option> 
                <option value="6" <?php if (get_option('wpsp_popup_btn_radius')==6):?> selected="selected"<?php endif;?>>6</option>
                <option value="7" <?php if (get_option('wpsp_popup_btn_radius')==7):?> selected="selected"<?php endif;?>>7</option> 
                <option value="8" <?php if (get_option('wpsp_popup_btn_radius')==8):?> selected="selected"<?php endif;?>>8</option>
                <option value="9" <?php if (get_option('wpsp_popup_btn_radius')==9):?> selected="selected"<?php endif;?>>9</option>
                <option value="10" <?php if (get_option('wpsp_popup_btn_radius')==10):?> selected="selected"<?php endif;?>>10</option>
                <option value="15" <?php if (get_option('wpsp_popup_btn_radius')==15):?> selected="selected"<?php endif;?>>15</option>
                <option value="20" <?php if (get_option('wpsp_popup_btn_radius')==20):?> selected="selected"<?php endif;?>>20</option>
                <option value="25" <?php if (get_option('wpsp_popup_btn_radius')==25):?> selected="selected"<?php endif;?>>25</option>
                <option value="30" <?php if (get_option('wpsp_popup_btn_radius')==30):?> selected="selected"<?php endif;?>>30</option>
            </select>
            </td>
          </tr>
          <tr>
            <td>Button Color</td>
            <td>
              <input type="text" name="wpsp_popup_btn_color" size="4" id="wpsp_popup_btn_color" class="color" value="<?php echo get_option('wpsp_popup_btn_color')?>" /> 
              <input type="text" name="wpsp_popup_btn_color1" size="4" id="wpsp_popup_btn_color1" class="color" value="<?php echo get_option('wpsp_popup_btn_color1')?>" />[gradient color]
            </td>
            <td>&emsp;Button Text Color</td>
            <td>
              <input type="text" name="wpsp_popup_btn_text_color" size="4" id="wpsp_popup_btn_text_color" class="color" value="<?php echo get_option('wpsp_popup_btn_text_color')?>" />         
            </td>
          </tr>
          <tr>
            <td>Button Hover Color</td>
            <td>
              <input type="text" name="wpsp_popup_btn_ol_color" size="4" id="wpsp_popup_btn_ol_color" class="color" value="<?php echo get_option('wpsp_popup_btn_ol_color')?>" />
              <input type="text" name="wpsp_popup_btn_ol_color1" size="4" id="wpsp_popup_btn_ol_color1" class="color" value="<?php echo get_option('wpsp_popup_btn_ol_color1')?>" />[gradient color]
            </td>
            <td>&emsp;Button Text Hover Color</td>
            <td>
              <input type="text" name="wpsp_popup_btn_ol_text_color" size="4" id="wpsp_popup_btn_ol_text_color" class="color" value="<?php echo get_option('wpsp_popup_btn_ol_text_color')?>" /> 
            </td>
          </tr>
        </table>
        </td>
      </tr>
      
      <tr valign="top"> 
				<td width="150" scope="row">Bottom Content position:</td>
				<td>
            <select name="wpsp_popup_bottom_content">
                <option value="0"<?php if (get_option('wpsp_popup_bottom_content')=='0'):?> selected="selected"<?php endif;?>>Left</option>
                <option value="1"<?php if (get_option('wpsp_popup_bottom_content')=='1'):?> selected="selected"<?php endif;?>>Center</option> 
                <option value="2"<?php if (get_option('wpsp_popup_bottom_content')=='2'):?> selected="selected"<?php endif;?>>Right</option>               
            </select>
				</td>
			</tr>
                        
      <tr valign="top">
				<td colspan="2" scope="row">			
					<input type="button" name="save" onclick="document.getElementById('wpsp_status_submit').value='1'; document.getElementById('wpsp_options').submit();" value="Save setting" class="button-primary" />
          <input type="button" name="reset" onclick="document.getElementById('wpsp_status_submit').value='2'; document.getElementById('wpsp_options').submit();" value="Reset to default setting" class="button-primary" />
				</td> 
			</tr>
		</table>        
	</form>	
	<?php
}
?>