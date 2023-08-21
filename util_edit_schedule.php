<?php 
include 'util_config.php';
include 'util_session.php';

$result="";
$date = "";
$start_time="";
$end_time = "";
$message = "";
$till_closing = 0;
$till_bd=0;
$break_mints = 0;
$id = 0;
$hours_diff = "";
$assign_to=0;
$repeat_type = 0;
$repeat_until_date = "";

if(isset($_POST['date'])){
    $date = date("Y-m-d", strtotime($_POST['date']));
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
if(isset($_POST['break_mints'])){
    $break_mints = $_POST['break_mints'];
}
if(isset($_POST['hours_diff'])){
    $hours_diff = $_POST['hours_diff'];
}
if(isset($_POST['till_closing'])){
    $till_closing = $_POST['till_closing'];
}
if(isset($_POST['till_bd'])){
    $till_bd = $_POST['till_bd'];
}
if(isset($_POST['id'])){
    $id = $_POST['id'];
}
if(isset($_POST['repeat_type'])){
    $repeat_type=$_POST['repeat_type'];
}
if(isset($_POST['repeat_until_date'])){
    $repeat_until_date = date("Y-m-d", strtotime($_POST['repeat_until_date']));
}
if(isset($_POST['assign_to'])){
    $assign_to = $_POST['assign_to'];
}

$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");



if($repeat_type == 1){

    $sql1="UPDATE `tbl_shifts` SET `date`='$date',`title`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`till_closing`='$till_closing',`till_business_decline`='$till_bd',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' WHERE `sfs_id` = $id";  
    $result1 = $conn->query($sql1);

}else if($repeat_type == 2){

    $sql = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {

            $date = $row['date'];
            $assign_to = $row['assign_to'];

            for($i=0;$i<=50;$i++){
                $str = ' + '.(7*($i)).' days';
                $new_date = date('Y-m-d', strtotime($date. $str)); 

                $sql1="UPDATE `tbl_shifts` SET `title`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`till_closing`='$till_closing',`till_business_decline`='$till_bd',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' WHERE `date` = '$new_date' AND assign_to = $assign_to AND hotel_id = $hotel_id";  
                $result1 = $conn->query($sql1);
            }
        }
    }

}else{
    $sql = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $date = $row['date'];
            $assign_to = $row['assign_to'];

            $sql1="UPDATE `tbl_shifts` SET `title`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`till_closing`='$till_closing',`till_business_decline`='$till_bd',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' WHERE (`date` between '$date' AND '$repeat_until_date') AND assign_to = $assign_to AND hotel_id = $hotel_id";  
            $result1 = $conn->query($sql1);

        }
    }
}

if($result1){

    $last_id = $id;
    $alert_msg = $message." Shift Updated.";


    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('assign_to','$last_id','sfs_id','tbl_shifts','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
    $result_alert = $conn->query($sql_alert);


    echo '1';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$message Shift Updated','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}

?>