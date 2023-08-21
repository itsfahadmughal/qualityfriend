<?php 
include 'util_config.php';
include '../util_session.php';

$employee = "";
$type = "";


if(isset($_POST['employee'])){
    $employee = $_POST['employee'];
}
if(isset($_POST['type'])){
    $type = $_POST['type'];
}

$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");


if($employee == 0){
    $sql_outer="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
    $result_outer = $conn->query($sql_outer);
    if ($result_outer && $result_outer->num_rows > 0) {
        while($row = mysqli_fetch_array($result_outer)) {
            $sql_inner="SELECT * FROM `tbl_shift_button_visiblity` WHERE `hotel_id` = $hotel_id AND employee_id = $row[0]";
            $result_inner = $conn->query($sql_inner);
            if ($result_inner && $result_inner->num_rows > 0) {
                $sql = "UPDATE `tbl_shift_button_visiblity` SET `visible_type`='$type',`editbyid`='$last_editby_id',`edittime`='$last_edit_time',`editbyip`='$last_editby_ip' WHERE hotel_id = $hotel_id AND employee_id = $row[0]";
                $result = $conn->query($sql);
            }else{
                $sql = "INSERT INTO `tbl_shift_button_visiblity`(`employee_id`, `hotel_id`, `visible_type`, `editbyid`, `edittime`, `editbyip`) VALUES ('$row[0]','$hotel_id','$type','$last_editby_id','$last_edit_time','$last_editby_ip')";
                $result = $conn->query($sql);
            }
        }   
    }
}else{
    $sql_inner="SELECT * FROM `tbl_shift_button_visiblity` WHERE `hotel_id` = $hotel_id AND employee_id = $employee";
    $result_inner = $conn->query($sql_inner);
    if ($result_inner && $result_inner->num_rows > 0) {
        $sql = "UPDATE `tbl_shift_button_visiblity` SET `visible_type`='$type',`editbyid`='$last_editby_id',`edittime`='$last_edit_time',`editbyip`='$last_editby_ip' WHERE hotel_id = $hotel_id AND employee_id = $employee";
        $result = $conn->query($sql);
    }else{
        $sql = "INSERT INTO `tbl_shift_button_visiblity`(`employee_id`, `hotel_id`, `visible_type`, `editbyid`, `edittime`, `editbyip`) VALUES ('$employee','$hotel_id','$type','$last_editby_id','$last_edit_time','$last_editby_ip')";
        $result = $conn->query($sql);
    }
}



if($result){
    echo 'success';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Schedule Admin Modificate le impostazioni di visibilità dei pulsanti Shift','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}

?>