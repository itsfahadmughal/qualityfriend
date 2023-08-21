<?php

if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    $id = $user_id = $hotel_id = 0;
    if(isset($_POST['shift_pool_id'])){
        $id = $_POST["shift_pool_id"];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }
    $last_edit_time=date("Y-m-d H:i:s");
    $last_editby_ip=getIPAddress();
    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $id == 0 || $id == "" || $user_id == 0 || $user_id == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id and Shift Pool id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{
        //Working
        $sql = "UPDATE `tbl_shift_offer` SET `is_delete_admin`='1', lasteditid = $user_id, lastedittime = '$last_edit_time', lasteditip = '$last_editby_ip' WHERE `sftou_id` = '$id' and hotel_id = $hotel_id";
    
        if ($result = $conn->query($sql)) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Shift Pool Request Deleted...";

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Shift Pool Request Not Deleted!!!";
        }


        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }
}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>