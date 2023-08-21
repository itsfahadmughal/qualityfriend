<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    date_default_timezone_set('Europe/Amsterdam');

    $user_id = $hotel_id= 0;
    $log_text = "";
    // Declaration
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["log_text"])){
        $log_text = $_POST["log_text"];
    }
    $entry_time=date("Y-m-d H:i:s");

    $data = array();
    $temp1 = array();

    if($user_id == "" || $log_text == "" || $hotel_id == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "All parameters must be required.";

    }else{
        // Working
        $sql = "INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$log_text','$hotel_id','$entry_time')";

        if ($conn->query($sql) === TRUE) {
            $temp = array();
            $temp['user_id'] = $user_id;
            $temp['hotel_id'] = $hotel_id;
            $temp['log_text'] = $log_text;
            $temp['entrytime'] = $entry_time;

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Failed! Try Again.";
        }
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>