<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $data = array();
    $temp1=array();
    $hotel_id = $_POST['hotel_id'];
    $user_id = $_POST['user_id'];
    $tablename = $_POST['tablename'];
    $idname = $_POST['idname'];
    $id = $_POST['id'];
    $entry_time=date("Y-m-d H:i:s");


    $q="UPDATE ".$tablename." SET `is_delete`= 1 WHERE   ".$idname." = $id";
    $stmt=$conn->query($q);
    if($stmt){

        $text_log = 'Comment is Deleted';

        $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$text_log','$hotel_id','$entry_time')";
        $result_log = $conn->query($sql_log);

        $temp1=array();
        $temp1['flag'] = 1;
        $temp1['message'] = "Deleted";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{ 
        $temp1=array();
        $temp1['flag'] = 0;
        $temp1['message'] = "Not Save";
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