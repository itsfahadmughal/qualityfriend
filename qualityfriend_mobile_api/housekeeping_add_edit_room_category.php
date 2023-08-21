<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $room_cat_id = 0;

    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }


    //caregory
    if(isset($_POST['room_cat_id'])){
        $room_cat_id = $_POST['room_cat_id'];
    }
    if(isset($_POST['cat_en'])){
        $cat_en = $_POST['cat_en'];
    }

    if(isset($_POST['cat_it'])){
        $cat_it = $_POST['cat_it'];
    }
    if(isset($_POST['cat_de'])){
        $cat_de = $_POST['cat_de'];
    }
    if(isset($_POST['time_to_cn'])){
        $time_to_cn = $_POST['time_to_cn'];
    }

    if(isset($_POST['time_to_cd'])){
        $time_to_cd = $_POST['time_to_cd'];
    }
    if(isset($_POST['time_to_fc'])){
        $time_to_fc = $_POST['time_to_fc'];
    }
    if(isset($_POST['time_to_ec'])){
        $time_to_ec = $_POST['time_to_ec'];
    }
    if(isset($_POST['cleaning'])){
        $cleaning = $_POST['cleaning'];
    }
    if(isset($_POST['cleaning_day'])){
        $cleaning_day = $_POST['cleaning_day'];
    }
    if(isset($_POST['laundry'])){
        $laundry = $_POST['laundry'];
    }
    if(isset($_POST['laundry_days'])){
        $laundry_days = $_POST['laundry_days'];
    }
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entryby_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $current_date=date("Y-m-d");

    $data = array();
    $temp1=array();
    //Working   
    if($room_cat_id == 0){
        $sql=" INSERT INTO `tbl_room_category`( `category_name`, `category_name_it`, `category_name_de`, `hotel_id`, `time_to_CN`, `time_to_CD`, `time_to_FC`,`time_to_EC`, `cleaning_frequency`, `cleaning_day`, `laundry_frequency`, `laundry_day`, `time`, `is_active`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$cat_en','$cat_it','$cat_de','$hotel_id','$time_to_cn','$time_to_cd','$time_to_fc','$time_to_ec','$cleaning','$cleaning_day','$laundry','$laundry_days','','1','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
    }else{
        $sql="UPDATE `tbl_room_category` SET `category_name`='$cat_en',`category_name_it`='$cat_it',`category_name_de`='$cat_de',`time_to_CN`='$time_to_cn',`time_to_CD`='$time_to_cd',`time_to_FC`='$time_to_fc',`time_to_EC`='$time_to_ec', `cleaning_frequency`='$cleaning',`cleaning_day`='$cleaning_day',`laundry_frequency`='$laundry',`laundry_day`='$laundry_days',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`= '$last_editby_ip' WHERE `room_cat_id` = $room_cat_id";
    }

    $result1 = $conn->query($sql);
    if($result1){
        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Error!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>