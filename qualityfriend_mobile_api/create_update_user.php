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

    $first_name="";
    $last_name="";
    $email_from="";
    $is_active="";
    $department_id="";
    $user_type_id="";
    $saved_status = "";
    $admin_email = "";
    $time_schedule_status = "";
    $image_url = "";
    //more
    $employee_id = 0;
    $edit_user_id = 0;
    //all
    $user_id=0;
    $hotel_id=0;
    $data = array();
    $temp1=array();
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['saved_status'])){
        $saved_status=$_POST['saved_status'];
    }
    if(isset($_POST['first_name'])){
        $first_name=str_replace("'","`",$_POST['first_name']);
    }
    if(isset($_POST['last_name'])){
        $last_name=str_replace("'","`",$_POST['last_name']);
    }
    if(isset($_POST['email'])){
        $email_from=$_POST['email'];
    }
    if(isset($_POST['is_active'])){
        $is_active=$_POST['is_active'];
    }
    if(isset($_POST['department_id'])){
        $department_id=$_POST['department_id'];
    }
    if(isset($_POST['user_type_id'])){
        $user_type_id=$_POST['user_type_id'];
    }
    if(isset($_POST['employee_id'])){
        $employee_id=$_POST['employee_id'];
    }
    if(isset($_POST['time_schedule_status'])){
        $time_schedule_status=$_POST['time_schedule_status'];
    }
    if(isset($_POST['admin_email'])){
        $admin_email=$_POST['admin_email'];
    }
    if(isset($_POST['edit_user_id'])){
        $edit_user_id=$_POST['edit_user_id'];
    }
    if(isset($_POST['image_url'])){
        $image_url=$_POST['image_url'];
    }
    $password = md5("qualityfriend_123");
    $password_email = "qualityfriend_123";
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        //create_update_user.php
        if($saved_status=='CREATE'){
            $sql1="SELECT * FROM `tbl_user` WHERE `email` = '$email_from' And is_delete = 0";
            $result1 = $conn->query($sql1);
            if ($result1 && $result1->num_rows > 0 ) {
                $temp1['flag'] = -1;
                $temp1['message'] = "Email Already Exist";    
            }else{
                //create new user 
                $sql="INSERT INTO `tbl_user`( `usert_id`, `firstname`, `lastname`, `email`, `password`, `address`, `tag`, `depart_id`, `state`, `country_id`, `hotel_id`, `tae_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$user_type_id','$first_name','$last_name','$email_from','$password','$image_url','','$department_id','','','$hotel_id','$employee_id','$is_active','0','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
                $result = $conn->query($sql);
                if($result){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                    $text_log = "New User ".$first_name." Created";
                    $to      = $email_from;
                    $subject = 'QualityFriend';
                    $message = 'Here is your Password: '.$password_email.' for qualityfriend login.';
                    $headers = 'From: noReply@qualityfriend.solutions'       . "\r\n" .
                        'Reply-To: noReply@qualityfriend.solutions' . "\r\n";
                    // mail($to, $subject, $message, $headers);
                    
                      smtp_mailer($to,$subject, $message);
                    
                    $to      = $admin_email;
                    $subject = 'New User Added in QualityFriend';
                    $message = 'New user Email: '.$email_from.' and Password: '.$password_email;
                    $headers = 'From: noReply@qualityfriend.solutions'       . "\r\n" .
                        'Reply-To: noReply@qualityfriend.solutions' . "\r\n";
                    // mail($to, $subject, $message, $headers);
                      smtp_mailer($to,$subject, $message);

                    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$text_log','$hotel_id','$entry_time')";
                    $result_log = $conn->query($sql_log);
                    if($employee_id != 0){
                        $sql_employee="UPDATE `tbl_applicants_employee` SET `is_active_user`= 1 WHERE `tae_id` = $employee_id";
                        $result_employee = $conn->query($sql_employee);

                    }

                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Something Bad Happend!!!";
                }
            }
        }else{
            $sql1="SELECT * FROM `tbl_user` WHERE `email` = '$email_from' And user_id != $edit_user_id  And is_delete = 0" ;
            $result1 = $conn->query($sql1);
            if ($result1 && $result1->num_rows > 0 ) {
                $temp1['flag'] = -2;
                $temp1['message'] = "Email Already Exist";
            }else{
                $sql="UPDATE `tbl_user` SET `usert_id`='$user_type_id',`firstname`='$first_name',`lastname`='$last_name',`email`='$email_from',`depart_id`='$department_id',`is_active`='$is_active',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`address` = '$image_url',enable_for_schedules = '$time_schedule_status' WHERE `user_id` = $edit_user_id"; 
                $text_log = "User ".$first_name." Updated";
                $result = $conn->query($sql);
                if($result){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$text_log','$hotel_id','$entry_time')";
                    $result_log = $conn->query($sql_log);
                    if($employee_id != 0){
                        $sql_employee="UPDATE `tbl_applicants_employee` SET `is_active_user`= 1 WHERE `tae_id` = $employee_id";
                        $result_employee = $conn->query($sql_employee);

                    }
                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Something Bad Happend!!!";
                }


            }

        }  

    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>