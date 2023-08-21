<?php 
include 'util_config.php';
include '../util_session.php';


$shift_id = 0;
$assign_to = 0;
$date = "";

$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entry_time=date("Y-m-d H:i:s");
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");

if(isset($_POST['shift_id'])){
    $shift_id = $_POST['shift_id'];
}
if(isset($_POST['assigned_to'])){
    $assign_to = $_POST['assigned_to'];
}
if(isset($_POST['date'])){
    $date = $_POST['date'];
}


$sql = "INSERT INTO `tbl_shifts`(`date`, `assign_to`, `title`, `title_it`, `title_de`, `start_time`, `end_time`, `total_hours`, `till_closing`, `till_business_decline`, `is_active`, `is_delete`, `hotel_id`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`, `shift_break`)
SELECT '$date', '$assign_to', `title`, `title_it`, `title_de`, `start_time`, `end_time`, `total_hours`, `till_closing`, `till_business_decline`, `is_active`, `is_delete`, `hotel_id`, '$entry_time', '$entryby_id', '$entryby_ip', '$last_edit_time', '$last_editby_id', '$last_editby_ip', `shift_break` FROM tbl_shifts
WHERE sfs_id='$shift_id' and hotel_id = $hotel_id";

$result = $conn->query($sql);

if($result){
    $last_id = mysqli_insert_id($conn);

    $alert_msg = "Nuovo turno creato";

    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$assign_to','$last_id','sfs_id','tbl_shifts','$alert_msg','CREATE','$hotel_id','$entry_time','0')";
    $result_alert = $conn->query($sql_alert);

    echo '1';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Nuovo turno creato','$hotel_id','$entry_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}


?>