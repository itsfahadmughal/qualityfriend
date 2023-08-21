<?php
include '../util_config.php';
include '../util_session.php';

$room_number = $cleaner_id = $extra_job_id= $floor_id = $room_id = $newcleaner_id =0;

$extra_job_date = "";
$type = "";
if(isset($_POST['room_number'])){
    $room_id = $_POST['room_number'];
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

if(isset($_POST['type'])){
    $type = $_POST['type'];
}
if(isset($_POST['cleaner_id_v2'])){
    $newcleaner_id = $_POST['cleaner_id_v2'];
}

$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entryby_time=date("Y-m-d H:i:s");;
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");
$current_date=date("Y-m-d");
$today = date("D"); 
$sql = "";
$result1 = true;
if($room_id != 0){
    $sql="UPDATE `tbl_housekeeping` SET  `room_status`='Dirty', `assgin_type`='$permanently',`cleaning_day`='',`is_completed`=0,`assgin_date`='$current_date',`assign_to`='$cleaner_id',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `room_id` = '$room_id'";
    $result1 = $conn->query($sql);
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
            $sql="UPDATE `tbl_housekeeping` SET `room_status`='Dirty' ,`assgin_type`='$permanently',`cleaning_day`='',`is_completed`=0,`assgin_date`='$current_date',`assign_to`='$cleaner_id',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `room_id` = '$rms_id'";
            $result1 = $conn->query($sql);
        }
    }
}
else if ($extra_job_id != 0){
    $sql_reservation="SELECT * FROM `tbl_ housekeeping_extra_jobs_completed_check` WHERE `assign_date` = '$extra_job_date' AND `extra_job_id` = '$extra_job_id' AND `assign_to` = '$newcleaner_id'";
    $result_reservation = $conn->query($sql_reservation);
    if ($result_reservation && $result_reservation->num_rows > 0) {
        $sql="UPDATE `tbl_ housekeeping_extra_jobs_completed_check` SET  `assign_to`='$cleaner_id',`is_completed`= '0' WHERE `assign_date` = '$extra_job_date' AND `extra_job_id` = '$extra_job_id' AND `assign_to` = '$newcleaner_id' ";
        $result1 = $conn->query($sql);
    }else{
        $sql="INSERT INTO `tbl_ housekeeping_extra_jobs_completed_check`( `extra_job_id`, `assign_date`, `complete_date`, `assign_to`, `is_completed`) VALUES ('$extra_job_id','$extra_job_date','','$cleaner_id','0')";
        $result1 = $conn->query($sql);

    }

}else {

}
if($result1){
    echo "done";
}else {
    echo "error";
}

?>