<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $shift_id = "";
    $shift_trade_id = "";
    $offer_to = "";
    $shift_to = "";
    $offer_by = "";
    $data = array();
    $temp1=array();
    $hotel_id = $user_id = $offer_by = 0;
    if(isset($_POST['shift_id'])){
        $shift_id = $_POST['shift_id'];
    }
    if(isset($_POST['shift_trade_id'])){
        $shift_trade_id = $_POST['shift_trade_id'];
    }
    if(isset($_POST['offer_to'])){
        $offer_to = $_POST['offer_to'];
    }
    if(isset($_POST['shift_to'])){
        $shift_to = $_POST['shift_to'];
    }
    if(isset($_POST['offer_by'])){
        $offer_by = $_POST['offer_by'];
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
    $slug = 0;
    $result_update1="";
    $result_update2="";

    $last_id = 0;
    $msg= "";

    if($hotel_id == "" || $hotel_id == 0 || $shift_id == 0 || $shift_id == "" || $user_id == 0 || $user_id == "" || $shift_trade_id == 0 || $shift_trade_id == "" || $offer_to == 0 || $offer_to == "" || $shift_to == 0 || $shift_to == "" || $offer_by == 0 || $offer_by == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "All Parameters are Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql_2 = "SELECT * FROM `tbl_shifts` WHERE sfs_id = $shift_id AND is_completed = 1";
        $result_2 = $conn->query($sql_2);
        if ($result_2 && $result_2->num_rows > 0) {
            $slug = 1;
        }else{

            $sql_update1="UPDATE `tbl_shift_trade` SET `is_approved_by_employee`='1', `lastedittime`='$last_edit_time',`lasteditid`='$last_editby_id',`lasteditip`='$last_editby_ip' WHERE hotel_id = $hotel_id AND `sfttrd_id` = $shift_trade_id";
            $slug = 2;


            $sql_ = "SELECT * FROM `tbl_shift_trade` WHERE sfttrd_id = $shift_trade_id AND is_active = 1";
            $result_inner = $conn->query($sql_);
            if ($result_inner && $result_inner->num_rows > 0) {
                while ($row_inner = mysqli_fetch_array($result_inner)) {
                    $offer_by = $row_inner['offer_by'];
                    $last_id = $row_inner['sfttrd_id'];
                    $msg = $row_inner['title'];
                }
            }

            $result_update1 = $conn->query($sql_update1);
        }



        if($slug == 2){

            $alert_msg = $msg." Trade Accepted By Worker Still You Cancel It.";

            $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$offer_by','$last_id','sfttrd_id','tbl_shift_trade','$alert_msg','UPDATE','$hotel_id','$last_edit_time',0)";
            $result_alert = $conn->query($sql_alert);

            $temp1['flag'] = 1;
            $temp1['message'] = $msg." (Trade Accepted By Worker Still You Cancel It.)";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Shift Taken By User','$hotel_id','$last_edit_time')";
            $result_log = $conn->query($sql_log);
        }else if($slug == 1){
            $temp1['flag'] = 1;
            $temp1['message'] = "Offered Shift Already Completed By User.";
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Status Not Changed!";
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