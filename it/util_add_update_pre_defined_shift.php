<?php 
include 'util_config.php';
include '../util_session.php';

$result="";
$start_time="";
$end_time = "";
$message = "";
$break_mints = 0;
$flag = "";
$hours_diff = "";
$id = 0;
$depart_id = 0;
$shift_name = "";

if(isset($_POST['message'])){
    $message = $_POST['message'];
}
if(isset($_POST['start_time'])){
    $start_time = $_POST['start_time'];
}
if(isset($_POST['end_time'])){
    $end_time = $_POST['end_time'];
}
if(isset($_POST['break_mints'])){
    $break_mints = $_POST['break_mints'];
}
if(isset($_POST['hours_diff'])){
    $hours_diff = $_POST['hours_diff'];
}
if(isset($_POST['depart_id'])){
    $depart_id = $_POST['depart_id'];
}
if(isset($_POST['shift_name'])){
    $shift_name = $_POST['shift_name'];
}
if(isset($_POST['flag'])){
    $flag=$_POST['flag'];
}
if(isset($_POST['sfspd_id'])){
    $id=$_POST['sfspd_id'];
}

$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");


if($flag == 'edit'){

    $sql="UPDATE `tbl_shifts_pre_defined` SET `shift_name`='$shift_name',`title`='$message',`start_time`='$start_time',`end_time`='$end_time',`shift_break`='$break_mints',`total_hours`='$hours_diff', `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' ,`depart_id`='$depart_id' WHERE `sfspd_id` = $id";  
    $result = $conn->query($sql);

}else if($flag == 'add'){

    $sql = "INSERT INTO `tbl_shifts_pre_defined`(`shift_name`,`title`, `start_time`, `end_time`, `shift_break`, `total_hours`, `is_delete`, `hotel_id`, `edittime`, `editbyid`, `editbyip`,`depart_id`) VALUES ('$shift_name','$message','$start_time','$end_time','$break_mints','$hours_diff','0','$hotel_id','$last_edit_time','$last_editby_id','$last_editby_ip','$depart_id')";
    $result = $conn->query($sql);

}

if($result){
    echo '1';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$message Turno predefinito salvato','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}

?>