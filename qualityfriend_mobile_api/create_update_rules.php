<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $type_name="";
    $type_id=0;
    //all
    $user_id = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();
    if(isset($_POST['type_name'])){
        $type_name=$_POST['type_name'];
    }
    if(isset($_POST['usert_id'])){
        $type_id=$_POST['usert_id'];
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
        if($type_id== 0){
            $sql="INSERT INTO `tbl_usertype`( `user_type`, `hotel_id`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$type_name','$hotel_id','0','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
            $result = $conn->query($sql);
            if($result){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','New User Type $type_name Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
        }else{

            $sql="UPDATE `tbl_usertype` SET `user_type`='$type_name',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `usert_id` = '$type_id'";
            $result = $conn->query($sql);
            if($result){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Update User Type $type_name','$hotel_id','$entry_time')";
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