<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $user_id= 0;
    $token = "";
    $login_as ="";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
     if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["token"])){
        $token = $_POST["token"];
    }
    if(isset($_POST["login_as"])){
        $login_as = $_POST["login_as"];
    }
    
    
    $data = array();
    $temp1=array();
    //Working

    $sql = "UPDATE `tbl_user` SET `user_token` = '$token',`login_as`='$login_as' WHERE `user_id` = $user_id";
    $result = $conn->query($sql);

    if ($result) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Not Successfull";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>