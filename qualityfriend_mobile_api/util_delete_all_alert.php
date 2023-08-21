<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $alert_list = 0;
    if(isset($_POST['alert_id'])){
        if($_POST['alert_id'] != ""){
            $alert_list= (array) explode(",",$_POST['alert_id']);
        }else {
            $alert_list = array();
        }
    }

    $data = array();
    $temp1=array();

    //Working

    $alert_list_size = sizeof($alert_list);
    for ($x = 0; $x < $alert_list_size; $x++) {
        $q="UPDATE `tbl_alert` SET `is_delete`= 1  WHERE `alert_id` = $alert_list[$x]";  
        $stmt=$conn->query($q);
    }
    if ($stmt) {
        $temp1['flag'] = 1;
        $temp1['message'] = "Alert Deleted";

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