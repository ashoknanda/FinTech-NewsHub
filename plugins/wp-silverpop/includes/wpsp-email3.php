<?php
require_once('../../../../wp-blog-header.php');
header('HTTP/1.1 200 OK');


include ('api/SilverpopAPI.php');
define('SILVERPOP_ENDPOINT', 'http://'.get_option('spop_engage').'.silverpop.com/XMLAPI');
define('SILVERPOP_USERNAME', get_option('spop_name'));
define('SILVERPOP_PASSWORD', get_option('spop_password'));
$recipientId=$_POST['RecipientId'];


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

$xml = '<PROGRAM_ID>175505</PROGRAM_ID>
<CONTACT_ID>'.$recipientId.'</CONTACT_ID>';

  $silverpop_api->build('AddContactToProgram', $xml);

    $response = $silverpop_api->execute();
            
    $xml = new SimpleXMLElement($response);
    //echo '<pre>';
    //print_r($xml);

    $status=$xml->Body->RESULT->SUCCESS;
    //echo $status; 
    if($status=='false'){

        $status_code= $xml->Body->Fault->detail->error->errorid;
        // print_r($status_code);
        if($status_code[0]=='120'){
          echo 'Invalid email address';
        }else if($status_code[0]=='651'){
          echo 'We already have you on our list, thanks for your interest.';
        }else{
          echo 'Invalid email address';
        }
    }else{
      echo '1';      
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