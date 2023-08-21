<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $nte_id = 0;
    $status = 2;
    if(isset($_POST['notice_id'])){
        $nte_id = $_POST["notice_id"];
    }
    if(isset($_POST['status'])){
        $status = $_POST["status"];
    }


    $data = array();
    $temp1=array();
    if($nte_id == 0 || $status == 2){
        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";
    }else{

        $sql = "UPDATE `tbl_note` SET `is_active`='$status' WHERE `nte_id` = '$nte_id' ";

        if ($result = $conn->query($sql)) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Status Updated...";

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Status Not Updated!!!";
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