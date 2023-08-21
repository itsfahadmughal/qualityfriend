<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $from_time = "";
    $to_time = "";
    $msg = "";
    $title = "";
    $hourDiff = "";
    $dates = "";
    $priority = 0; 

    if(isset($_POST['dates'])){
        $dates = $_POST['dates'];
    }
    if(isset($_POST['start_time'])){
        $from_time = $_POST['start_time'];
    }
    if(isset($_POST['end_time'])){
        $to_time = $_POST['end_time'];
    }
    if(isset($_POST['message'])){
        $msg = $_POST['message'];
    }
    if(isset($_POST['title'])){
        $title = $_POST['title'];
    }
    if(isset($_POST['total_hours'])){
        $hourDiff = $_POST['total_hours'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }

    $data = array();
    $temp1=array();
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $last_id = 0;

    $split = explode(",",$dates);
    if($hotel_id == "" || $hotel_id == 0 || $title == "" || $user_id == 0 || $user_id == "" || $from_time == ""|| $to_time == "" || $hourDiff == "" || $hourDiff == 0 || $dates == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Pass Required Parameters.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        for($i=0;$i<sizeof($split);$i++){
            $sql="INSERT INTO `tbl_shift_events`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `start_time`, `end_time`, `total_hours`, `date`, `hotel_id`, `is_active`, `is_delete`, `is_published`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$title','','','$msg','','','$from_time','$to_time','$hourDiff','$split[$i]','$hotel_id','1','0','0','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";

            $result = $conn->query($sql);
            $last_id = mysqli_insert_id($conn);
        }

        if($result){

            $alert_msg = $title." Event Created.";

            $sql_users_alerts = "SELECT * FROM `tbl_user` WHERE hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0";

            $result_users_alerts = $conn->query($sql_users_alerts);
            while ($row_inner = mysqli_fetch_array($result_users_alerts)) {
                $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$row_inner[0]','$last_id','svnts_id','tbl_shift_events','$alert_msg','CREATE','$hotel_id','$entry_time',$priority)";
                $result_alert = $conn->query($sql_alert);
            }

            $temp1['flag'] = 1;
            $temp1['message'] = "Event Created Successful.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$msg Event Created','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Event Not Created!";
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