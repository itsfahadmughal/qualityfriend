<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $depart_id = 0;
    if(isset($_POST['depart_id'])){
        $depart_id = $_POST["depart_id"];
    }

    $data = array();
    $temp1=array();
    //Working
    $sql = "UPDATE `tbl_department` SET `is_delete`='1' WHERE `depart_id` = '$depart_id'";
    if ($result = $conn->query($sql)) {
        $temp1['flag'] = 1;
        $temp1['message'] = "Department Deleted...";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Department not Deleted!!!";
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