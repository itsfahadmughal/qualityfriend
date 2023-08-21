<?php
include('smtp/PHPMailerAutoload.php');
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
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
//        echo $mail->ErrorInfo;
    }else{
//        echo 'Sent';
    }
}
    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    $email = "";
    if(isset($_POST['email'])){
        $email = $_POST["email"];
    }

    $password = random_password();
    $password_e = md5($password);

    $user = array();
    $temp1=array();

    $sql_check="SELECT * FROM `tbl_user` WHERE email ='$email'";
    $result_check = $conn->query($sql_check);

    if($result_check && $result_check->num_rows > 0){
        //Working
        $sql = "UPDATE `tbl_user` SET `password`='$password_e' WHERE `email` = '$email'";
        if ($result = $conn->query($sql)) {

            // Set the email subject.
            $subject = "Qualityfriend Password";

            // Build the email headers.
            $email_headers = "From: QualityFriend";

            $email_content = "Your new password is : ".$password;

            // Send the email.
            // mail($email, $subject, $email_content, $email_headers);
            
             smtp_mailer($email,$subject, $email_content);

            $temp1['flag'] = 1;
            $temp1['message'] = "New password sent to your email...";

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Not Updated!!!";
        }
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Email not exist!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $user));

}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $user));
}
$conn->close();
?>