<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $edit_floor_id = 0;

    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }

    //floor
    if(isset($_POST['floor_number'])){
        $floor_number = $_POST['floor_number'];
    }

    if(isset($_POST['edit_floor_id'])){
        $edit_floor_id = $_POST['edit_floor_id'];
    }
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entryby_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $current_date=date("Y-m-d");

    $data = array();
    $temp1=array();
    //Working   
    if($edit_floor_id == 0){
        $sql="INSERT INTO `tbl_floors`( `floor_num`, `floor_name`, `floor_name_it`, `floor_name_de`, `hotel_id`, `category_id`, `is_active`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$floor_number','Ground','Ground','Ground','$hotel_id','1','1','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
    }else{
        $sql="UPDATE `tbl_floors` SET `floor_num`='$floor_number',`hotel_id`='$hotel_id',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `floor_id` = $edit_floor_id";
    }

    $result1 = $conn->query($sql);
    if($result1){
        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Error!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>