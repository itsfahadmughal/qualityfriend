<?php 
include 'util_config.php';
include '../util_session.php';

$date = "";
$start_time="";
$end_time = "";
$message = "";
$id = 0;
$hours_diff = "";
$title="";

if(isset($_POST['date'])){
    $date = date("Y-m-d", strtotime($_POST['date']));
}
if(isset($_POST['title'])){
    $title = $_POST['title'];
}
if(isset($_POST['description'])){
    $message = $_POST['description'];
}
if(isset($_POST['start_time'])){
    $start_time = $_POST['start_time'];
}
if(isset($_POST['end_time'])){
    $end_time = $_POST['end_time'];
}
if(isset($_POST['hours_diff'])){
    $hours_diff = $_POST['hours_diff'];
}
if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");



$sql="UPDATE `tbl_shift_events` SET `date`='$date',`title`='$title',`description`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `svnts_id` = $id";  
$result = $conn->query($sql);

if($result){

    $last_id = $id;
    $alert_msg = $title." Evento aggiornato.";

    $sql_users_alerts = "SELECT * FROM `tbl_user` WHERE hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0";

    $result_users_alerts = $conn->query($sql_users_alerts);
    while ($row_inner = mysqli_fetch_array($result_users_alerts)) {
        $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$row_inner[0]','$last_id','svnts_id','tbl_shift_events','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
        $result_alert = $conn->query($sql_alert);
    }


    echo '1';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Evento aggiornato','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}

?>