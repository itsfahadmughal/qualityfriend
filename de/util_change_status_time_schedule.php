<?php
include 'util_config.php';
include '../util_session.php';

$id=0;
$title="";
if(isset($_POST['id'])){
    $id=$_POST['id'];
}

if(isset($_POST['title'])){
    $title=$_POST['title'];
}

$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");
$entry_time = date("Y-m-d H:i:s");
$priority = 0; 


$sql_update="UPDATE `tbl_shifts` SET `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`is_completed`='1' WHERE `sfs_id` = $id AND hotel_id = $hotel_id";
$result_update = $conn->query($sql_update);

if($result_update){

    echo 'success';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Schicht vom Benutzer abgeschlossen','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);

}else{
    echo '0';
}
?>