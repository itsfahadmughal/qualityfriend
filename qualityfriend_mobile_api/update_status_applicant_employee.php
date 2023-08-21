<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $hotel_id = $applicant_employee_id = 0;
    $status_id = 0;
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['applicant_employee_id'])){
        $applicant_employee_id = $_POST["applicant_employee_id"];
    }
    if(isset($_POST['status_id'])){
         //Archived or Unarchived
            $status_id = $_POST['status_id'];
       
    }
    $data = array();
    $temp1=array();
    if($hotel_id == 0 || $applicant_employee_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";
    }else{
        //Working
        $sql = "UPDATE `tbl_applicants_employee` SET `status_id`='$status_id' WHERE `hotel_id` = '$hotel_id' and tae_id = '$applicant_employee_id' ";

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