<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $shift_id = "";
    $offer_to = "";
    $message = "";
    $hotel_id = $user_id = 0;

    if(isset($_POST['shift_id'])){
        $shift_id = $_POST['shift_id'];
    }
    if(isset($_POST['offer_to'])){
        $offer_to = $_POST['offer_to'];
    }
    if(isset($_POST['message'])){
        $message = $_POST['message'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }

    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $user_id == 0 || $user_id == "" || $shift_id == 0 || $shift_id == "" || $offer_to == 0 || $offer_to == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id, Offer to and Shift id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql="INSERT INTO `tbl_shift_offer`(`shift_offered`, `offer_by`, `offer_to`, `title`, `title_it`, `title_de`, `is_approved_by_employee`, `is_approved_by_admin`, `is_active`, `is_delete_user`, `is_delete_admin`, `hotel_id`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditid`, `lasteditip`) VALUES ('$shift_id','$user_id','$offer_to','$message','','','0','0','1','0','0','$hotel_id','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";  
        $result = $conn->query($sql);

        if($result){

            $last_id = mysqli_insert_id($conn);
            $alert_msg = $message." Shift Offered To You.";

            $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$offer_to','$last_id','sftou_id','tbl_shift_offer','$alert_msg','CREATE','$hotel_id','$entry_time',0)";
            $result_alert = $conn->query($sql_alert);

            $temp1['flag'] = 1;
            $temp1['message'] = "Shift Offered.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$message Shift Offered','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Shift Not Offered!!!";
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