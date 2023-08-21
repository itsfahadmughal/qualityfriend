<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $department_name="";
    $department_id=0;
    $icon_class = "";
    //all
    $user_id = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();
    if(isset($_POST['department_name'])){
        $department_name=$_POST['department_name'];
    }
    if(isset($_POST['department_id'])){
        $department_id=$_POST['department_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        if($department_id== 0){
            $sql="INSERT INTO `tbl_department`( `department_name`, `department_name_it`, `department_name_de`, `hotel_id`, `is_active`, `is_delete`, `icon`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$department_name','$department_name','$department_name','$hotel_id','1','0','$icon_class','$entry_time','$entry_time','$entryby_id','$last_edit_time','','')";
            $result = $conn->query($sql);
            if($result){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','New Department $department_name Created','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
        }else{

            $sql="UPDATE `tbl_department` SET `department_name`='$department_name',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `depart_id` = '$department_id'";
            $result = $conn->query($sql);
            if($result){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Update Department $department_name','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
        }
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));
}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>