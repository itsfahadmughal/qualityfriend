<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $shift_id = $shift_start_time = "";
    $hotel_id = $user_id = 0;

    if(isset($_POST['shift_id'])){
        $shift_id = $_POST['shift_id'];
    }
    if(isset($_POST['shift_start_time'])){
        $shift_start_time = $_POST['shift_start_time'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }

    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $data = array();
    $temp1=array();


    if($hotel_id == "" || $hotel_id == 0 || $user_id == 0 || $user_id == "" || $shift_id == 0 || $shift_id == "" || $shift_start_time == 0 || $shift_start_time == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id, Shift Start Time and Shift id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql="INSERT INTO `tbl_shifts_working_hours`( `sfs_id`, `shift_start_time`, `hotel_id`, `edittime`, `editbyid`, `editbyip`) VALUES ('$shift_id','$shift_start_time','$hotel_id','$last_edit_time','$last_editby_id','$last_editby_ip')";  
        $result = $conn->query($sql);

        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Shift Started Successfully.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Shift Started','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Shift Not Started Successfully!";
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