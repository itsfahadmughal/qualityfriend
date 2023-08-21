<?php 
include 'util_config.php';
include '../util_session.php';

$shift_id = "";
$user_offer_id = "";
$slug1 = "";
$offer_to = "";
$shift_to = "";
$offer_by = 0;

if(isset($_POST['shift_id'])){
    $shift_id = $_POST['shift_id'];
}
if(isset($_POST['shift_trade_id'])){
    $shift_trade_id = $_POST['shift_trade_id'];
}
if(isset($_POST['slug'])){
    $slug1 = $_POST['slug'];
}
if(isset($_POST['offer_to'])){
    $offer_to = $_POST['offer_to'];
}
if(isset($_POST['shift_to'])){
    $shift_to = $_POST['shift_to'];
}
if(isset($_POST['offer_by'])){
    $offer_by = $_POST['offer_by'];
}

$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");
$slug = 0;
$result_update1="";
$result_update2="";

$last_id = 0;
$msg= "";

$sql_2 = "SELECT * FROM `tbl_shifts` WHERE sfs_id = $shift_id AND is_completed = 1";
$result_2 = $conn->query($sql_2);
if ($result_2 && $result_2->num_rows > 0) {
    $slug = 1;
}else{
    if($slug1 == 'user'){
        $sql_update1="UPDATE `tbl_shift_trade` SET `is_approved_by_employee`='1', `lastedittime`='$last_edit_time',`lasteditid`='$last_editby_id',`lasteditip`='$last_editby_ip' WHERE hotel_id = $hotel_id AND `sfttrd_id` = $shift_trade_id";
        $slug = 3;
    }else{
        $sql_update1="UPDATE `tbl_shift_trade` SET `is_approved_by_admin`='1', `lastedittime`='$last_edit_time',`lasteditid`='$last_editby_id',`lasteditip`='$last_editby_ip' WHERE hotel_id = $hotel_id AND `sfttrd_id` = $shift_trade_id";

        $sql_update2 = "UPDATE `tbl_shifts` SET `assign_to`='$offer_to', `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `sfs_id` = $shift_id";
        $result_update2 = $conn->query($sql_update2);

        $sql_update3 = "UPDATE `tbl_shifts` SET `assign_to`='$offer_by', `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `sfs_id` = $shift_to";
        $result_update3 = $conn->query($sql_update3);

        $slug = 2;
    }

    $sql_ = "SELECT * FROM `tbl_shift_trade` WHERE sfttrd_id = $shift_trade_id AND is_active = 1";
    $result_inner = $conn->query($sql_);
    if ($result_inner && $result_inner->num_rows > 0) {
        while ($row_inner = mysqli_fetch_array($result_inner)) {
            $offer_by = $row_inner['offer_by'];
            $last_id = $row_inner['sfttrd_id'];
            $msg = $row_inner['title'];
        }
    }

    $result_update1 = $conn->query($sql_update1);
}



if($slug == 3){

    $alert_msg = $msg." Der Handel wurde vom Arbeitnehmer akzeptiert, Sie stornieren ihn jedoch.";

    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$offer_by','$last_id','sfttrd_id','tbl_shift_trade','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
    $result_alert = $conn->query($sql_alert);

    echo 'success';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Shift Taken By User','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else if($slug == 1){
    echo 'unsuccess';
}else if($slug == 2){
    $alert_msg = $msg." Ihre Schicht wurde vom Administrator gegen einen neuen Mitarbeiter ausgetauscht.";

    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$offer_by','$last_id','sftou_id','tbl_shift_offer','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
    $result_alert = $conn->query($sql_alert);

    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$offer_to','$last_id','sftou_id','tbl_shift_offer','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
    $result_alert = $conn->query($sql_alert);


    echo 'adminsuccess';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Dem Benutzer zugewiesene Schicht','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}

?>