<?php
include('smtp/PHPMailerAutoload.php');
echo smtp_mailer('talhasahi86@gmail.com','subject','msg');
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	//$mail->SMTPDebug=3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.hostinger.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "noreply@qualityfriend.solutions";
	$mail->Password = 'Pakistan@143';
	$mail->SetFrom("noreply@qualityfriend.solutions");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		echo 'Sent';
	}
}

//smtp_mailer("talhasahi86@gmail.com","Subject", "this is my message")


?>