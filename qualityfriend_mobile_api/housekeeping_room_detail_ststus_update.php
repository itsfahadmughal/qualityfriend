<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $rms_id  = 0;
    $rmrs_id = 0;
    $room_status = "";
    $presence_status ="";
    $Urgent = "";
    $is_breakfast = "";
    $do_need_to_clean ="";
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }

    if(isset($_POST['rms_id'])){
        $rms_id = $_POST['rms_id'];
    }
    if(isset($_POST['rmrs_id'])){
        $rmrs_id = $_POST['rmrs_id'];
    }



    if(isset($_POST['room_status'])){
        $room_status = $_POST['room_status'];
    }
    if(isset($_POST['presence_status'])){
        $presence_status = $_POST['presence_status'];
    }
    if(isset($_POST['Urgent'])){
        $Urgent = $_POST['Urgent'];
    }
    if(isset($_POST['breakfast'])){
        $is_breakfast = $_POST['breakfast'];
    }
    if(isset($_POST['do_need_to_clean'])){
        $do_need_to_clean = $_POST['do_need_to_clean'];
    }

    $data = array();
    $temp1=array();

    $current_date =   date("Y-m-d");
    //Working



    //unassigned
    if($room_status == "Unassigned"){
        $sql_only_assign_to="UPDATE `tbl_housekeeping` SET  `room_status`='Unassigned', `assign_to`='0' WHERE `room_id` = '$rms_id'";
        $conn->query($sql_only_assign_to);
    }
    $sql ="";

    if($room_status != ""){
        $sql="UPDATE `tbl_housekeeping` SET  `room_status`='$room_status' ,`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";


    }
    if($presence_status != ""){
        $sql="UPDATE `tbl_housekeeping` SET  `presence_status`='$presence_status',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";
    }
    if($Urgent != ""){
        $sql="UPDATE `tbl_housekeeping` SET  `is_urgent`='$Urgent',   `lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";
    }
    if($is_breakfast != ""){
        $created_date = date("Y-m-d H:i:s");
        $sql="UPDATE `tbl_housekeeping` SET  `is_breakfast`='$is_breakfast', `is_breakfast_time` = '$created_date', `lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";
    }
    if($do_need_to_clean != ""){
        $sql="UPDATE `tbl_housekeeping` SET  `do_need_to_clean` = '$do_need_to_clean',   `lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE   `room_id` =  $rms_id";
    }
    $result = $conn->query($sql);

    if($result){


        //clean
        $sql_clean = "";
        if($room_status == "Clean"){
            $sql_clean="UPDATE `tbl_housekeeping`  SET `room_status`='Clean',`presence_status`='0',`is_urgent`='0', `is_breakfast`='0' WHERE `room_id` = '$rms_id' ";
            $result2 =  $conn->query($sql_clean);
            if($result2){

            }else {

            }
        }

        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Unsuccessfull";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>