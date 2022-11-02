<?php 

include('class.phpmailer.php');
include('class.smtp.php');

function send(){
	$name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];
  if($name == ''){
    echo json_encode("failed");
  }else if($email == ''){
    echo json_encode("failed");
  }else if($phone == '')
  {
    echo json_encode("failed");
  }else if($message == ''){
    echo json_encode("failed");
  }else{
    $mail             = new PHPMailer();
    $body             = "<h1>Contact from Chinbunn.com</h1><hr><p><h2>Name:</h2> ".$name."</p><p><h2>Email:</h2> ".$email."</p><p><h2>Tel:</h2> ".$phone."</p></p><h2>Message:</h2> ".$message."</p>";
    $mail->SMTPDebug  = 2;                                                                                             
    $mail->SMTPAuth   = true;              
    $mail->SMTPSecure = "ssl";                 
    $mail->Host       = "smtp.gmail.com" ;
    $mail->Port       = 465;                 
    $mail->Username   = "info.chinbunn@gmail.com"; 
    $mail->Password   = "1129900217851";           
    $mail->SetFrom('info.chinbunn@gmail.com', 'Administrator');
    $mail->Subject    = "Contact from Chinbunn.com"; 
    $mail->MsgHTML($body);
    $address = "jibunnag@hotmail.com";
    // $address = "bu.suphavit_st@tni.ac.th";
    $mail->AddAddress($address, "Administrator");
    if(!$mail->Send()) {
      echo json_encode("failed");
    } else {
      echo json_encode("success");
    }
  }
}

send() ;

?>