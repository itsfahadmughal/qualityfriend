<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $shift_id = $shift_end_time = "";
    $hotel_id = $user_id = $total_hours = $worked_hours_id = 0;


    if(isset($_POST['worked_hours_id'])){
        $worked_hours_id = $_POST['worked_hours_id'];
    }
    if(isset($_POST['shift_id'])){
        $shift_id = $_POST['shift_id'];
    }
    if(isset($_POST['shift_end_time'])){
        $shift_end_time = $_POST['shift_end_time'];
    }
    if(isset($_POST['total_hours'])){
        $total_hours = $_POST['total_hours'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }

    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $data = array();
    $temp1=array();


    if($hotel_id == "" || $hotel_id == 0 || $user_id == 0 || $user_id == "" || $shift_id == 0 || $shift_id == "" || $shift_end_time == 0 || $shift_end_time == "" || $worked_hours_id == 0 || $worked_hours_id == "" || $total_hours == 0 || $total_hours == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id, Shift Start Time and Shift id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql="UPDATE `tbl_shifts_working_hours` SET `shift_end_time`='$shift_end_time',`total_hours`='$total_hours',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `sfswh_id` = $worked_hours_id AND `sfs_id` = $shift_id AND hotel_id = $hotel_id";  
        $result = $conn->query($sql);

        if($result){

            $sql = "UPDATE `tbl_shifts` SET `is_completed`='1', editbyid = $user_id, edittime = '$last_edit_time', editbyip = '$last_editby_ip' WHERE `sfs_id` = '$shift_id' and hotel_id = $hotel_id";

            $result_completed = $conn->query($sql);

            $temp1['flag'] = 1;
            $temp1['message'] = "Shift Ended Successfully.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Shift Started','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Shift Not Ended Successfully!";
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