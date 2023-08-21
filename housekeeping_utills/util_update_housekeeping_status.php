
<?php
include '../util_config.php';
include '../util_session.php';

$rms_id = $rmrs_id = $Urgent =0;
$room_status = $presence_status ="";
$check_diff = "0" ;
$do_need_to_clean = 0;
if(isset($_POST['rms_id'])){
    $rms_id = $_POST['rms_id'];
}
if(isset($_POST['rmrs_id'])){
    $rmrs_id = $_POST['rmrs_id'];
}
if(isset($_POST['room_status'])){
    $room_status = $_POST['room_status'];
}
if(isset($_POST['presence_status'])){
    $presence_status = $_POST['presence_status'];
}
if(isset($_POST['Urgent'])){
    $Urgent = $_POST['Urgent'];
}
if(isset($_POST['check_diff'])){
    $check_diff = $_POST['check_diff'];
}
if(isset($_POST['breakfast'])){
    $is_breakfast = $_POST['breakfast'];
}
if(isset($_POST['do_need_to_clean'])){
    $do_need_to_clean = $_POST['do_need_to_clean'];
}

$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entryby_time=date("Y-m-d H:i:s");;
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");
$sql = "";
$result1 = false;

$current_date = date("Y-m-d");




$created_date = date("Y-m-d H:i:s");

//unassigned
if($room_status == "Unassigned"){
    $sql_only_assign_to="UPDATE `tbl_housekeeping` SET  `room_status`='Unassigned', `assign_to`='0' WHERE `room_id` = '$rms_id'";
    $conn->query($sql_only_assign_to);
}




//SELECT a.*, b.cleaning_frequency,b.cleaning_day FROM `tbl_rooms` as a INNER JOIN tbl_room_category as b ON a.`room_cat_id` = b.room_cat_id WHERE a.`rms_id` =  2
if($check_diff == "1" ) {
    $sql="UPDATE `tbl_housekeeping` SET  `room_status`='$room_status',`presence_status`='$presence_status',`is_urgent`='$Urgent', `is_breakfast`='$is_breakfast',`is_breakfast_time` = '$created_date',`do_need_to_clean` = '$do_need_to_clean',  
    `last_cleaning_date`='$current_date',
    `lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";
}else {


    $sql="UPDATE `tbl_housekeeping` SET  `room_status`='$room_status',`presence_status`='$presence_status',`is_urgent`='$Urgent', `is_breakfast`='$is_breakfast', `is_breakfast_time` = '$created_date',`do_need_to_clean` = '$do_need_to_clean',   `lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";

}

$result1 = $conn->query($sql);
if($result1){
    
   
    //clean
    $sql_clean = "";
    if($room_status == "Clean"){
        $sql_clean="UPDATE `tbl_housekeeping`  SET `room_status`='Clean',`presence_status`='0',`is_urgent`='0', `is_breakfast`='0' WHERE `room_id` = '$rms_id' ";
        $result2 =  $conn->query($sql_clean);
        if($result2){

        }else {

        }
    }
}else{
    echo "error";
}

?>