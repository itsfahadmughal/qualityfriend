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

    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    if(isset($_POST['rms_id'])){
        $rms_id = $_POST['rms_id'];
    }
    if(isset($_POST['from'])){
        $from = $_POST['from'];
    }


    $data = array();
    $temp1=array();

    $current_date =   date("Y-m-d");
    //Working



    if($from == "floor"){
        $sql="UPDATE `tbl_rooms` SET `floor_id`='$id' WHERE `rms_id` = $rms_id";

    }else{
        $sql="UPDATE `tbl_rooms` SET `room_cat_id`='$id' WHERE `rms_id` = $rms_id";
    }
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