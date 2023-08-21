<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{


    $s_date="";
    $e_date="";


    if(isset($_POST['start_date'])){
        $s_date = $_POST['start_date'];
    }
    if(isset($_POST['end_date'])){
        $e_date = $_POST['end_date'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    
    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $s_date == "" || $e_date == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, start and end date is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        $sql_publish_status = "SELECT * FROM `tbl_shifts` WHERE `date` BETWEEN '$s_date' AND '$e_date' AND is_published = 0 AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
        $result_status = $conn->query($sql_publish_status);
        if ($result_status && $result_status->num_rows > 0) {
            $temp1['flag'] = 0;
            $temp1['message'] = "Changes Not Published!";
        }else{
            $temp1['flag'] = 1;
            $temp1['message'] = "All Changes Already Published!";
        }
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }
}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();

?>