<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $edit_extra_id = 0;

    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }

    //extra job
    if(isset($_POST['clean_extra'])){
        $clean_extra = $_POST['clean_extra'];
    }
    if(isset($_POST['extra_job'])){
        $extra_job = $_POST['extra_job'];
    }
    if(isset($_POST['edit_extra_id'])){
        $edit_extra_id = $_POST['edit_extra_id'];
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
    if($edit_extra_id == 0){
        $sql="INSERT INTO `tbl_ housekeeping_extra_jobs`( `time_to_complate`, `job_title`, `hotel_id`) VALUES ('$clean_extra','$extra_job','$hotel_id')";
    }else{        
        $sql="UPDATE `tbl_ housekeeping_extra_jobs` SET `time_to_complate`='$clean_extra',`job_title`='$extra_job' WHERE `hkej_id` = '$edit_extra_id'";
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