<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $user_id = 0;
    $old_password="";
    $new_password="";
    $email="";

    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST['email'])){
        $email = $_POST["email"];
    }

    if(isset($_POST['old_password'])){
        $old_password= md5($_POST['old_password']);
    }
    if(isset($_POST['new_password'])){
        $new_password= md5($_POST['new_password']);
        $new_password_email= $_POST['new_password'];

    }

    $data = array();
    $temp1=array();
    if($old_password == "" || $new_password == "" || $user_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";
    }else{
        //Working
        $sql_old="SELECT * FROM tbl_user Where password='$old_password' and user_id=$user_id";
        $result_old = $conn->query($sql_old);
        if ($result_old && $result_old->num_rows > 0) {	 
            $sql="UPDATE `tbl_user` SET `password`='$new_password' WHERE user_id=$user_id";
            $result = $conn->query($sql);
            if($result){

                $to      = $email;
                $subject = 'QualityFriend';
                $message = 'Your new Password: '.$new_password_email.' for qualityfriend login.';
                $headers = 'From: noReply@qualityfriend.solutions'       . "\r\n" .
                    'Reply-To: noReply@qualityfriend.solutions' . "\r\n";

                mail($to, $subject, $message, $headers);

                $temp1['flag'] = 1;
                $temp1['message'] = "Password Changed.";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend. Try Again!";
            }
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Old Password is wrong. Try Again!";
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