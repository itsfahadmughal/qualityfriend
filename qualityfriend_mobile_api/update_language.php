<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $hotel_id = 0;
    $language = "";
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['language'])){
        $language = $_POST["language"];
    }

    $data = array();
    $temp1=array();
    if($hotel_id == 0 || $language == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";
    }else{
        //Working
        $sql = "UPDATE `tbl_hotel` SET `hotel_language`='$language' WHERE `hotel_id` = '$hotel_id'";

        if ($result = $conn->query($sql)) {
            $temp1['flag'] = 1;
            $temp1['message'] = "Hotel Language Changed...";

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Hotel Language not Changed!!!";
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