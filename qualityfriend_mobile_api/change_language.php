<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $hotel_id = 0;
    $user_id =0;
    $hotel_language = "";
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST['hotel_language'])){
        $hotel_language = $_POST["hotel_language"];
    }
    $data = array();
    $temp1=array();

    //Working
     $sql="UPDATE `tbl_hotel` SET `hotel_language`='$hotel_language' WHERE hotel_id = $hotel_id";
    if ($result = $conn->query($sql)) {
        $temp1['flag'] = 1;
        $temp1['message'] = "successful...";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Unsuccessful!!!";
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