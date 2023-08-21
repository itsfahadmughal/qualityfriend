<?php
include '../util_config.php';
include '../util_session.php';

$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entryby_time=date("Y-m-d H:i:s");;
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();

$current_date = date("Y-m-d");

$hkej_id = 0;
$completed = 0;

//extra_job_completed
if(isset($_POST['is_id'])){
    $is_id = $_POST['is_id'];
}
if(isset($_POST['completed'])){
    $completed = $_POST['completed'];
}
$sql ="";
$sql="UPDATE `tbl_ housekeeping_extra_jobs_completed_check` SET `complete_date`='$current_date' ,`is_completed`='$completed' WHERE `id` = '$is_id' ";

$result1 = $conn->query($sql);
    if($result1){
    echo "done";
}else {
    echo "error";
}
?>