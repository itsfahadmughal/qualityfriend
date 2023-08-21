<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $hotel_id = $job_id = 0;
    $status = 2;
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['job_id'])){
        $job_id = $_POST["job_id"];
    }
    if(isset($_POST['status'])){
        if($_POST["status"] == 'Archived'){   //Archived or Unarchived
            $status = 0;
        }else{
            $status = 1;
        }
    }


    $data = array();
    $temp1=array();
    if($hotel_id == 0 || $job_id == 0 || $status == 2){
        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";
    }else{
        //Working
        $sql = "UPDATE `tbl_create_job` SET `is_active`='$status' WHERE `hotel_id` = '$hotel_id' and crjb_id = '$job_id' ";

        if ($result = $conn->query($sql)) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Status Updated...";

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Status Not Updated!!!";
        }
    }
    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>