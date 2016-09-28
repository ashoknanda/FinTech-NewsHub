<?php
function wpsp_check_email($name, $pass, $lid){

  include ('api/SilverpopAPI.php');
  define('SILVERPOP_ENDPOINT', 'http://'.$_POST['spop_engage'].'.silverpop.com/XMLAPI');
  define('SILVERPOP_USERNAME', $_POST['spop_name']);
  define('SILVERPOP_PASSWORD', $_POST['spop_password']);

  $email='test020@test.com';

  try {
    $silverpop_api = new SilverpopAPI(
      SILVERPOP_ENDPOINT,
      SILVERPOP_USERNAME,
      SILVERPOP_PASSWORD
    );    

    $xml = '<LIST_ID>'.$_POST['spop_list_id'].'</LIST_ID>         
            <EMAIL>'.$email.'</EMAIL>';   
    
    $silverpop_api->build('SelectRecipientData', $xml);
    $response = $silverpop_api->execute();
            
    $xml = new SimpleXMLElement($response);    

    $status=$xml->Body->RESULT->SUCCESS;

    if($status=='false'){
        return 1;
    }else{
      return 0;
    }
  }
  
  catch (SilverpopConnectionException $e) {
    //die($e);
	return 0;
    // Handle connection exceptions.
  }
  catch (SilverpopDataException $e) {
    ///die($e);
	return 0;
    // Handle malformed XML exceptions.
  }
}
  ?>