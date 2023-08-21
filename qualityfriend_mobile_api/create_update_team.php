<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $team_name="";
    $team_id=0;
    //all
    $user_id = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();
    if(isset($_POST['team_name'])){
        $team_name=$_POST['team_name'];
    }
    if(isset($_POST['team_id'])){
        $team_id=$_POST['team_id'];
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
        if($team_id== 0){
            $sql="INSERT INTO `tbl_team`( `team_name`, `team_name_it`, `team_name_de`, `hotel_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$team_name','$team_name','$team_name','$hotel_id','1','0','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
            $result = $conn->query($sql);
            if($result){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','New Team $team_name Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
        }else{

            $sql="UPDATE `tbl_team` SET `team_name`='$team_name',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `team_id` = '$team_id'";
            $result = $conn->query($sql);
            if($result){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Update Team $team_name','$hotel_id','$entry_time')";
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