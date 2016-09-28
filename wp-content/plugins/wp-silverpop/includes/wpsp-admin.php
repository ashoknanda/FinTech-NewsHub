<?php
function wpsp_admin_option(){
  if(isset($_GET['act']) && $_GET['act']=='wpsp_save_option'){
    
    $chk=wpsp_check_email($_POST['spop_name'], $_POST['spop_password'], $_POST['spop_list_id']);
    if($chk==1){
      
      echo '<div class="updated">Information Updated</div>';
      update_wpsp_option();
    }else{
      echo '<div class="wpsp_error">Please Provide Valid Sliverpop info</div>';
    }   
  }
?>
  <div class="wrap">		
  <div id="poststuff" class="metabox-holder has-right-sidebar">
  <div id="post-body"><div id="post-body-content"><div id="namediv2" class="stuffbox">
  <h3>Silverpop Setting</h3>
  <div class="inside">
  <form name="wpsp_add_form" id="wpsp_admin_form" method="post" enctype="multipart/form-data" action="admin.php?page=wp-silverpop/includes/wpsp-init.php&act=wpsp_save_option">
  <table>
    <tr>
      <td>Silverpop Username:</td>
      <td> <input type="text" name="spop_name" id="spop_name" size="60" value="<?php echo get_option('spop_name')?>" /></td>
    </tr>
    <tr>
      <td>Silverpop password:</td>
      <td><input type="password" name="spop_password" id="spop_password" size="60"  value="<?php echo get_option('spop_password')?>" /> </td>
    </tr>
    <tr>
      <td>Silverpop Engage:</td>
      <td>        
        <select name="spop_engage">
          <option value="api1" <?php if(get_option('spop_engage')=='api1'){echo 'selected=selected';} ?>>Engage 1</option>
          <option value="api2" <?php if(get_option('spop_engage')=='api2'){echo 'selected=selected';} ?>>Engage 2</option>
          <option value="api3" <?php if(get_option('spop_engage')=='api3'){echo 'selected=selected';} ?>>Engage 3</option>
          <option value="api4" <?php if(get_option('spop_engage')=='api4'){echo 'selected=selected';} ?>>Engage 4</option>
          <option value="api5" <?php if(get_option('spop_engage')=='api5'){echo 'selected=selected';} ?>>Engage 5</option>
          <option value="api6" <?php if(get_option('spop_engage')=='api6'){echo 'selected=selected';} ?>>Engage 6</option>
        </select>
      </td>      
    </tr>
    <tr>
      <td>Silverpop List Id:</td>
      <td><input type="text" name="spop_list_id" id="spop_list_id" size="60" value="<?php echo get_option('spop_list_id')?>" /> [Database id]</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><input type="submit" value="Save" class="button-primary" style="width:100px; border:none;" />
      </td>
    </tr>

  </table>
  </form>    
  </div>
  </div></div></div>
  </div>
  </div>
<?php
}

function update_wpsp_option(){
   update_option('spop_name', $_POST['spop_name']);   
   update_option('spop_password', $_POST['spop_password']);
   update_option('spop_list_id', $_POST['spop_list_id']);
   update_option('spop_engage', $_POST['spop_engage']);
}
?>