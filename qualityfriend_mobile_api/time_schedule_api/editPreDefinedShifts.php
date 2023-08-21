<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $from_time = "";
    $to_time = "";
    $msg = "";
    $hourDiff = "";
    $shift_name = "";
    $break_mints = $pre_shift_id = 0;
    $depart_id = "";

    
    if(isset($_POST['pre_shift_id'])){
        $pre_shift_id = $_POST['pre_shift_id'];
    }
    if(isset($_POST['shift_name'])){
        $shift_name = $_POST['shift_name'];
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
    if(isset($_POST['total_hours'])){
        $hourDiff = $_POST['total_hours'];
    }
    if(isset($_POST['break_mints'])){
        $break_mints = $_POST['break_mints'];
    }
    if(isset($_POST['depart_id'])){
        $depart_id = $_POST['depart_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }


    $data = array();
    $temp1=array();

    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $last_id = 0;

    if($hotel_id == "" || $hotel_id == 0 || $depart_id == 0 || $depart_id == "" || $user_id == 0 || $user_id == "" || $from_time == ""|| $to_time == "" || $hourDiff == "" || $hourDiff == 0 || $pre_shift_id == "" || $pre_shift_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Pass Required Parameters.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql="UPDATE `tbl_shifts_pre_defined` SET `shift_name`='$shift_name',`title`='$msg',`start_time`='$from_time',`end_time`='$to_time',`shift_break`='$break_mints',`total_hours`='$hourDiff', `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' ,`depart_id`='$depart_id' WHERE `sfspd_id` = $pre_shift_id";  
        $result = $conn->query($sql);
        
        
        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Pre-Defined Shift Updated Successful.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$msg Pre-Defined Shift Updated','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Pre-Defined Shift Not Updated!";
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