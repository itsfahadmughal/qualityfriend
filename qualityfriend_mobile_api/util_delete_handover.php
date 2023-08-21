<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $hdo_id = 0;
    if(isset($_POST['handover_id'])){
        $hdo_id = $_POST["handover_id"];
    }

    $data = array();
    $temp1=array();

    //Working
    $sql = "UPDATE `tbl_handover` SET `is_delete`='1' WHERE `hdo_id` = '$hdo_id'";
    if ($result = $conn->query($sql)) {
        $temp1['flag'] = 1;
        $temp1['message'] = "Handover Deleted...";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Handover not Deleted!!!";
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