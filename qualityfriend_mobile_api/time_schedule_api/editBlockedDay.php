<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    $date = "";
    $from_t = "";
    $to_t = "";
    $hours_diff = "";
    $message = "";
    $holiday_type = "";
    $id = $user_id = $hotel_id = 0;
    $data = array();
    $temp1=array();

    if(isset($_POST['date'])){
        $date = date("Y-m-d", strtotime($_POST['date']));
    }
    if(isset($_POST['message'])){
        $message = $_POST['message'];
    }
    if(isset($_POST['blocked_day_id'])){
        $id = $_POST['blocked_day_id'];
    }
    if(isset($_POST['from_time'])){
        $from_t = $_POST['from_time'];
    }
    if(isset($_POST['to_time'])){
        $to_t = $_POST['to_time'];
    }
    if(isset($_POST['holiday_type'])){
        $holiday_type = $_POST['holiday_type'];
    }
    if(isset($_POST['request_by'])){
        $request_by = $_POST['request_by'];
    }
    if(isset($_POST['hoursdiff'])){
        $hours_diff = $_POST['hoursdiff'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }

    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");

    if($hotel_id == "" || $hotel_id == 0 || $user_id == "" || $user_id == 0 || $id == "" || $id == 0 || $date == "" || $message == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id, User Id, Message, Date and Blocked Day Id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql="UPDATE `tbl_time_off` SET `title`='$message', `duration`='$holiday_type', `start_time`='$from_t', `end_time`='$to_t', `total_hours`='$hours_diff', `request_by`='$request_by', `date`='$date', `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `tmeo_id` = $id";  
        $result = $conn->query($sql);

        if($result){

            $last_id = $id;
            $alert_msg = $message." Holiday Updated.";

            $sql_users_alerts = "SELECT * FROM `tbl_user` WHERE hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0";

            $result_users_alerts = $conn->query($sql_users_alerts);
            while ($row_inner = mysqli_fetch_array($result_users_alerts)) {
                $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$row_inner[0]','$last_id','tmeo_id','tbl_time_off','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
                $result_alert = $conn->query($sql_alert);
            }

            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$message Holiday Updated','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Blocked Day Not Edited!!!";
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