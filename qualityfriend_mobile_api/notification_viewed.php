<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $user_id= 0;
    $hotel_id = $_POST['hotel_id'];
    $user_id = $_POST['user_id'];
    $tablename = $_POST['tablename'];
    $id = $_POST['id'];
    $entry_time=date("Y-m-d H:i:s");


    $data = array();
    $temp1=array();
    //Working  


    $sql_alert="UPDATE `tbl_alert` SET `is_viewed`='1' WHERE `user_id` = $user_id AND `id_table_name` = '$tablename' AND id=$id";
    $result_alert = $conn->query($sql_alert);

    if ($result_alert) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }




    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>