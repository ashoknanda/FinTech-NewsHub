<?php
require_once('../../../../wp-blog-header.php');
header('HTTP/1.1 200 OK');


include ('api/SilverpopAPI.php');
define('SILVERPOP_ENDPOINT', 'http://'.get_option('spop_engage').'.silverpop.com/XMLAPI');
define('SILVERPOP_USERNAME', get_option('spop_name'));
define('SILVERPOP_PASSWORD', get_option('spop_password'));
$email=$_POST['email'];
$source=$_POST['source'];
$sp_marketing_news=$_POST['sp_marketing_news'];


try {
  $silverpop_api = new SilverpopAPI(
    SILVERPOP_ENDPOINT,
    SILVERPOP_USERNAME,
    SILVERPOP_PASSWORD
  );    

$ftype=get_option('wpsp_popup_form_type');
if(isset($_POST['ftype'])){
  $ftype=$_POST['ftype'];
}

  if($ftype== 2){
      $xml = '<LIST_ID>'.get_option('spop_list_id').'</LIST_ID>   
      <SYNC_FIELDS>
        <SYNC_FIELD> 
          <NAME>EMAIL</NAME> 
          <VALUE>'.$email.'</VALUE>
        </SYNC_FIELD>
      </SYNC_FIELDS>            
      <COLUMN>
        <NAME>EMAIL</NAME>
        <VALUE>'.$email.'</VALUE>
      </COLUMN>
      <COLUMN>
        <NAME>Category</NAME>
        <VALUE>'.$_POST['category'].'</VALUE>
      </COLUMN>      
      <COLUMN>
          <NAME>Name</NAME>
          <VALUE>'.$_POST['name'].'</VALUE>
      </COLUMN>';
  }else if($ftype== 3){
      $xml = '<LIST_ID>'.get_option('spop_list_id').'</LIST_ID>         
      <SYNC_FIELDS>
        <SYNC_FIELD> 
          <NAME>EMAIL</NAME> 
          <VALUE>'.$email.'</VALUE>
        </SYNC_FIELD>
      </SYNC_FIELDS>       
      <COLUMN>
        <NAME>EMAIL</NAME>
        <VALUE>'.$email.'</VALUE>
      </COLUMN>
      <COLUMN>
          <NAME>First_Name</NAME>
          <VALUE>'.$_POST['fname'].'</VALUE>
      </COLUMN>
      <COLUMN>
        <NAME>Category</NAME>
        <VALUE>'.$_POST['category'].'</VALUE>
      </COLUMN>       
      <COLUMN>
          <NAME>Last_Name</NAME>
          <VALUE>'.$_POST['lname'].'</VALUE>
      </COLUMN>';
  }else{
      $xml = '<LIST_ID>'.get_option('spop_list_id').'</LIST_ID>   
    <SYNC_FIELDS>
      <SYNC_FIELD> 
        <NAME>EMAIL</NAME> 
        <VALUE>'.$email.'</VALUE>
      </SYNC_FIELD>
    </SYNC_FIELDS>        
    <UPDATE_IF_FOUND>TRUE</UPDATE_IF_FOUND>     
    <COLUMN>
      <NAME>EMAIL</NAME>
      <VALUE>'.$email.'</VALUE>
    </COLUMN>
    <COLUMN>
        <NAME>Category</NAME>
        <VALUE>ALL</VALUE>
    </COLUMN> 
    <COLUMN>
    <NAME>sp_marketing_news</NAME>
      <VALUE>'.$sp_marketing_news.'</VALUE>
    </COLUMN>    
    <COLUMN>
    <NAME>sp_lsource</NAME>
      <VALUE>'.$source.'</VALUE>
    </COLUMN>    
    ';
  }
  
  $silverpop_api->build('AddRecipient', $xml);
    $response = $silverpop_api->execute();
            
    $xml = new SimpleXMLElement($response);
    
    //echo '<pre>';

    $status=$xml->Body->RESULT->SUCCESS;
    // echo $status; 
    if($status=='false'){
        $status_code= $xml->Body->Fault->detail->error->errorid;
        if($status_code=='120'){
          echo 'Invalid email address';
        }else if($status_code=='122'){
          echo 'You have already subscribed, thank you';
        }else{
          echo 'Invalid email address';
        }
    }else{
      // echo '1';   
      $retVal = json_encode($xml->Body->RESULT); 
      echo  $retVal;
    }    
    //echo '<pre>';
    //print_r($silverpop_api);    
  }
  catch (SilverpopConnectionException $e) {
    die($e);
    // Handle connection exceptions.
  }
  catch (SilverpopDataException $e) {
    die($e);
    // Handle malformed XML exceptions.
  }
          

         

?>