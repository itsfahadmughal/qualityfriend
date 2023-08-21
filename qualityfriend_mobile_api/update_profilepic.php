<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $image_url = "";
    //all
    $user_id=0;
    $hotel_id=0;
    $name = "";
    $data = array();
    $temp1=array();
    $entry_time=date("Y-m-d H:i:s");
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['image_url'])){
        $image_url=$_POST['image_url'];
    }

    if(isset($_POST['name'])){
        $name=$_POST['name'];
    }
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        $sql="UPDATE `tbl_user` SET `address` = '$image_url' WHERE `user_id` = $user_id"; 
        $text_log = $name." Updated his profile pic";
        $result = $conn->query($sql);
        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$text_log','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Something Bad Happend!!!";
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