<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $rpr_id = 0;
    $status_type = "";
    $status = 2;
    $recipient_id = 0;
    if(isset($_POST['repair_id'])){
        $rpr_id = $_POST["repair_id"];
    }
    if(isset($_POST['status_type'])){
        $status_type = $_POST["status_type"];
    }
    if(isset($_POST['status'])){
        $status = $_POST["status"];
    }
    if(isset($_POST['recipient_id'])){
        $recipient_id = $_POST["recipient_id"];
    }


    $data = array();
    $temp1=array();
    if($rpr_id == 0 || $status_type == "" || $status == 2){
        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";
    }else{

        if($status_type == "active"){

            $sql = "UPDATE `tbl_repair` SET `is_active`='$status' WHERE `rpr_id` = '$rpr_id' ";

        }else if($status_type == "complete"){
            if($recipient_id == 0){
                if($status == 1){
                    $status = 8;
                }else{
                    $status = 6;
                }
                $sql = "UPDATE `tbl_repair` SET `status_id`='$status' WHERE `rpr_id` = '$rpr_id' ";    
            }else{
                $sql = "UPDATE `tbl_repair_recipents` SET `is_completed`='$status' WHERE `rpr_id` = '$rpr_id' and user_id = '$recipient_id' ";
            }

        }

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