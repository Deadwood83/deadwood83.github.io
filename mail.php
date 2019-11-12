<?php
header( 'Content-Type: text/html; charset=utf-8' );

if(true) {
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "muyiwa@victorytravels-ng.com";
    $email_subject = "Holy Pilgrimage with Daddy G.O Registration";
    
	$error="";
     
    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $zip = $_POST['zip']; // not required
    $address = $_POST['address']; // not required
    $price = (isset($_POST['price'])) ? $_POST['price'] : ''; // required
     
    $error_message = "";
    $error_classes = array();
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    $error_classes['make_a_reservation_input_1'] = 'et-input-error';
  }
    $string_exp = "/^[A-Za-zА-Я .'-а-я]+$/";
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
    $error_classes['make_a_reservation_input_2'] = 'et-input-error';
  }
  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
      $error_classes['make_a_reservation_input_3'] = 'et-input-error';
  }
  if(strlen($price) < 2) {
    $error_message .= 'The Price is not selected.<br />';
      $error_classes['label'] = 'et-input-error';
  }
  
  if(strlen($error_message) > 0) {
	$valid=false; 
	$msg=$error_message;
    $return_array = array('valid' => $valid, "msg" => $msg, 'error_classes' => $error_classes);
	echo json_encode($return_array);
	
  } else {
    send_mail($email_to, $email_subject, $first_name, $last_name, $email_from, $telephone, $zip, $address, $price);
	$valid=true; 
	$msg="Message was sent succesfully"; 
    $return_array = array('valid' => $valid, "msg" => $msg);
	echo json_encode($return_array);
  }

} 


function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
}
     
function send_mail($email_to, $email_subject, $first_name, $last_name, $email_from, $telephone, $passport_id, $address, $price){
    $email_message = "Form details below.\n\n";
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Passport ID: ".clean_string($zip)."\n";
    $email_message .= "Address: ".clean_string($address)."\n";
    $email_message .= "Price: ".clean_string($price)."\n";
     
	// create email headers
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers); 
}




?>
 