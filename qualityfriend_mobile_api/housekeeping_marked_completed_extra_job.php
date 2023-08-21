<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }

    if(isset($_POST['hkej_id'])){
        $hkej_id = $_POST['hkej_id'];
    }
    if(isset($_POST['completed'])){
        $completed = $_POST['completed'];
    }
    if(isset($_POST['is_id'])){
        $is_id = $_POST['is_id'];
    }

    $data = array();
    $temp1=array();

    $current_date =   date("Y-m-d");
    //Working

    $sql ="";
    $sql="UPDATE `tbl_ housekeeping_extra_jobs_completed_check` SET `complete_date`='$current_date' ,`is_completed`='$completed' WHERE `id` = '$is_id' ";
    $result = $conn->query($sql);

    if($result){
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