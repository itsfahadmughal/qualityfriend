<?php

if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    $user_id = $hotel_id = 0;
    $sql = $module_type = $enable_flag = "";
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST['enable_flag'])){
        $enable_flag = $_POST["enable_flag"];
    }
    if(isset($_POST['module_type'])){
        $module_type = $_POST["module_type"];
    }
    $last_edit_time=date("Y-m-d H:i:s");
    $last_editby_ip=getIPAddress();
    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $user_id == 0 || $user_id == "" || $enable_flag == "" || $module_type == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id, Enable Flag and Module Type is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql_check = "SELECT * FROM `tbl_time_schedule_rules` WHERE hotel_id = $hotel_id";
        $result_check = $conn->query($sql_check);
        if ($result_check && $result_check->num_rows > 0) {
            if($module_type == 'shift_pool'){
                $sql = "UPDATE `tbl_time_schedule_rules` SET `is_shift_pool_enable`='$enable_flag',`edittime`='$last_edit_time',`editbyid`='$user_id',`editbyip`='$last_editby_ip' WHERE hotel_id = $hotel_id";
            }else{
                $sql = "UPDATE `tbl_time_schedule_rules` SET `is_time_off_enable`='$enable_flag',`edittime`='$last_edit_time',`editbyid`='$user_id',`editbyip`='$last_editby_ip' WHERE hotel_id = $hotel_id";
            }
        }else{
            if($module_type == 'shift_pool'){
                $sql = "INSERT INTO `tbl_time_schedule_rules`(`is_shift_pool_enable`, `hotel_id`, `edittime`, `editbyid`, `editbyip`) VALUES ('$enable_flag','$hotel_id','$last_edit_time','$user_id','$last_editby_ip')";
            }else{
                $sql = "INSERT INTO `tbl_time_schedule_rules`(`is_time_off_enable`, `hotel_id`, `edittime`, `editbyid`, `editbyip`) VALUES ('$enable_flag','$hotel_id','$last_edit_time','$user_id','$last_editby_ip')";
            }
        }

        //Working
        if ($result = $conn->query($sql)) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Rule Status Changed...";

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Rule Status Not Changed!!!";
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