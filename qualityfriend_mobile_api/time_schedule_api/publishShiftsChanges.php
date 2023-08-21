<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{


    $s_date="";
    $e_date="";


    if(isset($_POST['start_date'])){
        $s_date = $_POST['start_date'];
    }
    if(isset($_POST['end_date'])){
        $e_date = $_POST['end_date'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }
    $data = array();
    $temp1=array();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");

    if($hotel_id == "" || $hotel_id == 0 || $s_date == "" || $e_date == "" || $user_id == 0 || $user_id == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id and start & end date is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql_publish_status = "SELECT * FROM `tbl_shifts` WHERE `date` BETWEEN '$s_date' AND '$e_date' AND is_published = 0 AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
        $result_status = $conn->query($sql_publish_status);
        if ($result_status && $result_status->num_rows > 0) {
            while ($row_inner = mysqli_fetch_array($result_status)) {

                $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$row_inner[2]','$row_inner[0]','sfs_id','tbl_shifts','$row_inner[3] Shift Created','CREATE','$hotel_id','$entry_time')";
                $result_alert = $conn->query($sql_alert);

            }
            if($result_alert){
                $sql_update = "UPDATE `tbl_shifts` SET `is_published`='1', `edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `date` BETWEEN '$s_date' AND '$e_date' AND is_published = 0 AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                $result_update = $conn->query($sql_update);
                if($result_update){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "All Changes Published!";
                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Changes Not Published!";
                }
            }
        }else{
            $temp1['flag'] = 1;
            $temp1['message'] = "All Changes Already Published!";
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