<?php 
include 'util_config.php';
include 'util_session.php';


$staff_name_ = "";
$year_staffing_ = 0;
$gross_salary_ = 0;
$net_salary_ = 0;
$department_staffing_ = 0;
$staffings_id_ = 0;
$sql = "";
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");

if(isset($_POST['staff_name_'])){
    $staff_name_ = $_POST['staff_name_'];
}
if(isset($_POST['year_staffing_'])){
    $year_staffing_ = $_POST['year_staffing_'];
}
if(isset($_POST['gross_salary_'])){
    $gross_salary_ = $_POST['gross_salary_'];
}
if(isset($_POST['net_salary_'])){
    $net_salary_ = $_POST['net_salary_'];
}
if(isset($_POST['department_staffing_'])){
    $department_staffing_ = $_POST['department_staffing_'];
}
if(isset($_POST['staffings_id_'])){
    $staffings_id_ = $_POST['staffings_id_'];
}



if($staffings_id_ == 0){
    $sql="INSERT INTO `tbl_forecast_staffing_cost`( `frcstfd_id`, `staff_name`, `gross_salary`, `net_salary`, `year`, `hotel_id`, `lastedittime`, `lasteditbyip`, `lasteditbyid`) VALUES ('$department_staffing_','$staff_name_','$gross_salary_','$net_salary_','$year_staffing_','$hotel_id','$last_edit_time','$last_editby_ip','$last_editby_id')";
}else{
    $sql="UPDATE `tbl_forecast_staffing_cost` SET `frcstfd_id`='$department_staffing_',`staff_name`='$staff_name_',`gross_salary`='$gross_salary_',`net_salary`='$net_salary_',`year`='$year_staffing_',`lastedittime`='$last_edit_time',`lasteditbyip`='$last_editby_ip',`lasteditbyid`='$last_editby_id' WHERE `hotel_id` = $hotel_id AND `frcstfct_id` = $staffings_id_";
}
$result = $conn->query($sql);


if($result){
    echo 'success';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Forecast Staffing Cost Saved.','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo 'unsuccess';
}



?>