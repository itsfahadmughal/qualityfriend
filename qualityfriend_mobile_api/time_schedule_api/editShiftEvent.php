<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $date = "";
    $start_time="";
    $end_time = "";
    $message = "";
    $id = $hotel_id = $user_id = 0;
    $hours_diff = "";
    $title="";

    if(isset($_POST['date'])){
        $date = date("Y-m-d", strtotime($_POST['date']));
    }
    if(isset($_POST['title'])){
        $title = $_POST['title'];
    }
    if(isset($_POST['message'])){
        $message = $_POST['message'];
    }
    if(isset($_POST['start_time'])){
        $start_time = $_POST['start_time'];
    }
    if(isset($_POST['end_time'])){
        $end_time = $_POST['end_time'];
    }
    if(isset($_POST['total_hours'])){
        $hours_diff = $_POST['total_hours'];
    }
    if(isset($_POST['event_id'])){
        $id = $_POST['event_id'];
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

    if($hotel_id == "" || $hotel_id == 0 || $id == "" || $id == 0 || $user_id == 0 || $user_id == "" || $start_time == "" || $end_time == "" || $hours_diff == "" || $hours_diff == 0 || $date == "" || $title == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Pass Required Parameters.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql="UPDATE `tbl_shift_events` SET `date`='$date',`title`='$title',`description`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `svnts_id` = $id";  
        $result = $conn->query($sql);

        if($result){

            $last_id = $id;
            $alert_msg = $title." Event Updated.";

            $sql_users_alerts = "SELECT * FROM `tbl_user` WHERE hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0";

            $result_users_alerts = $conn->query($sql_users_alerts);
            while ($row_inner = mysqli_fetch_array($result_users_alerts)) {
                $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$row_inner[0]','$last_id','svnts_id','tbl_shift_events','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
                $result_alert = $conn->query($sql_alert);
            }

            $temp1['flag'] = 1;
            $temp1['message'] = "Event Updated Successful.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Event Updated','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Event Not Updated!";
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