<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $date = "";
    $start_time="";
    $end_time = "";
    $message = "";
    $till_closing = 0;
    $till_bd=0;
    $id = $hotel_id = $user_id = 0;
    $hours_diff = "";
    $repeat_count = 0;
    $assign_to=0;
    $repeat_type = 0;
    $repeat_until_date = "";

    if(isset($_POST['date'])){
        $date = date("Y-m-d", strtotime($_POST['date']));
    }
    if(isset($_POST['message'])){
        $message = $_POST['message'];
    }
    if(isset($_POST['start_time'])){
        $start_time = $_POST['start_time'];
    }
    if(isset($_POST['end_time'])){
        $end_time = $_POST['end_time'];
    }
    if(isset($_POST['total_hours'])){
        $hours_diff = $_POST['total_hours'];
    }
    if(isset($_POST['break_mints'])){
        $break_mints = $_POST['break_mints'];
    }
    if(isset($_POST['till_closing'])){
        $till_closing = $_POST['till_closing'];
    }
    if(isset($_POST['till_business_decline'])){
        $till_bd = $_POST['till_business_decline'];
    }
    if(isset($_POST['shift_id'])){
        $id = $_POST['shift_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }
    if(isset($_POST['edit_type'])){
        $repeat_type=$_POST['edit_type'];
    }
    if(isset($_POST['edit_until_date'])){
        $repeat_until_date = date("Y-m-d", strtotime($_POST['edit_until_date']));
    }


    $data = array();
    $temp1=array();
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");

    if($hotel_id == "" || $hotel_id == 0 || $id == "" || $id == 0 || $user_id == 0 || $user_id == "" || $start_time == "" || $end_time == "" || $hours_diff == "" || $hours_diff == 0 || $date == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Pass Required Parameters.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        if($repeat_type == 1){

            $sql1="UPDATE `tbl_shifts` SET `date`='$date',`title`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`till_closing`='$till_closing',`till_business_decline`='$till_bd',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' WHERE `sfs_id` = $id";  
            $result1 = $conn->query($sql1);

        }else if($repeat_type == 2){

            $sql = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {

                    $date = $row['date'];
                    $assign_to = $row['assign_to'];

                    for($i=0;$i<=50;$i++){
                        $str = ' + '.(7*($i)).' days';
                        $new_date = date('Y-m-d', strtotime($date. $str)); 

                        $sql1="UPDATE `tbl_shifts` SET `title`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`till_closing`='$till_closing',`till_business_decline`='$till_bd',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' WHERE `date` = '$new_date' AND assign_to = $assign_to AND hotel_id = $hotel_id";  
                        $result1 = $conn->query($sql1);
                    }
                }
            }

        }else{
            $sql = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $date = $row['date'];
                    $assign_to = $row['assign_to'];

                    $sql1="UPDATE `tbl_shifts` SET `title`='$message',`start_time`='$start_time',`end_time`='$end_time',`total_hours`='$hours_diff',`till_closing`='$till_closing',`till_business_decline`='$till_bd',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip',`shift_break`='$break_mints' WHERE (`date` between '$date' AND '$repeat_until_date') AND assign_to = $assign_to AND hotel_id = $hotel_id";  
                    $result1 = $conn->query($sql1);

                }
            }
        }


        if($result){

            $last_id = $id;
            $alert_msg = $message." Shift Updated.";


            $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('assign_to','$last_id','sfs_id','tbl_shifts','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
            $result_alert = $conn->query($sql_alert);

            $temp1['flag'] = 1;
            $temp1['message'] = "Shift Updated Successful.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$message Shift Updated','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Shift Not Updated!";
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