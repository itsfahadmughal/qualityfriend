<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $housekeeping = 0;
    $usert_id = 0;
    $cleaner_id = 0;
    $filter_date = "";
    $room_id = 0;
    $room_number = $cleaner_id = $extra_job_id= $floor_id = $room_id =0;


    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["usert_id"])){
        $usert_id = $_POST["usert_id"];
    }
    if(isset($_POST["housekeeping"])){
        $housekeeping = $_POST["housekeeping"];
    }
    if(isset($_POST["housekeeping_admin"])){
        $housekeeping_admin = $_POST["housekeeping_admin"];
    }
    if(isset($_POST['room_id'])){
        $room_id = $_POST['room_id'];
    }
    if(isset($_POST['cleaner_id'])){
        $cleaner_id = $_POST['cleaner_id'];
    }
    if(isset($_POST['extra_job_id'])){
        $extra_job_id = $_POST['extra_job_id'];
    }
    if(isset($_POST['floor_id'])){
        $floor_id = $_POST['floor_id'];
    }
    if(isset($_POST['permanently'])){
        $permanently = $_POST['permanently'];
    }
    if(isset($_POST['extra_job_date'])){
        $extra_job_date = $_POST['extra_job_date'];
    }

    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entryby_time=date("Y-m-d H:i:s");;
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $current_date=date("Y-m-d");



    $data = array();
    $temp1=array();
    //Working   
    if($room_id != 0){
        $sql="UPDATE `tbl_housekeeping` SET  `room_status`='Dirty', `assgin_type`='$permanently',`cleaning_day`='',`cleaning_date`='$current_date',`is_completed`=0,`assgin_date`='$current_date',`assign_to`='$cleaner_id',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `room_id` = '$room_id'";
        $result1 = $conn->query($sql);
        if($result1){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }else {


            $temp1['flag'] = 0;
            $temp1['message'] = "Error";
        }
    }
    else if ($floor_id != 0){
        $sql_a="SELECT * FROM `tbl_rooms`  WHERE `floor_id` = $floor_id";
        $result_a = $conn->query($sql_a);
        while($row = mysqli_fetch_array($result_a)) {
            $rms_id         = $row["rms_id"];
            //Reservation
            $current_date =   date("Y-m-d");
            $arrival = "";
            $arrival_date = "";
            $departure = "";
            $departure_date = "";
            $rmrs_id = 0;
            $sql_reservation="SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  `arrival` <= '$current_date' AND `departure`   >= '$current_date'";
            $result_reservation = $conn->query($sql_reservation);
            if ($result_reservation && $result_reservation->num_rows > 0) {
                while($row_reservation = mysqli_fetch_array($result_reservation)) {
                    $rmrs_id = $row_reservation["rmrs_id"];
                    $arrival = "Arrival";
                    $arrival_date = $row_reservation["arrival"];
                    $departure = "Departure";
                    $departure_date = $row_reservation["departure"];
                }
            }
            if($arrival != ""){
                $sql="UPDATE `tbl_housekeeping` SET `room_status`='Dirty' ,`assgin_type`='$permanently',`cleaning_day`='',`cleaning_date`='$current_date',`is_completed`=0,`assgin_date`='$current_date',`assign_to`='$cleaner_id',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `room_id` = '$rms_id'";
                $result1 = $conn->query($sql);
            }
        }
        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";

    }else if ($extra_job_id != 0){
        $sql="UPDATE `tbl_ housekeeping_extra_jobs` SET  `user_id`= '$cleaner_id',`is_completed`='0',`assgin_date`='$extra_job_date',`complate_date`='' WHERE `hkej_id` = $extra_job_id";
        $result1 = $conn->query($sql);
        if($result1){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }else {


            $temp1['flag'] = 0;
            $temp1['message'] = "Error";
        }
    }else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Something is Wrong!!!";

    }






    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>