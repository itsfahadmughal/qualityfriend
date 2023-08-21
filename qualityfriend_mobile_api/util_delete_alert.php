<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $alert_id = 0;
    if(isset($_POST['alert_id'])){
        $alert_id = $_POST["alert_id"];
    }

    $data = array();
    $temp1=array();

    //Working
    $sql = "UPDATE `tbl_alert` SET `is_delete`='1' WHERE `alert_id` = '$alert_id'";
    if ($result = $conn->query($sql)) {
        $temp1['flag'] = 1;
        $temp1['message'] = "Alert Deleted...";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Alert not Deleted!!!";
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