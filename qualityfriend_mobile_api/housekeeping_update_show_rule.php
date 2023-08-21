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
    if(isset($_POST['active_id'])){
        $active_id = $_POST['active_id'];
    }



    $data = array();
    $temp1=array();

    $current_date =   date("Y-m-d");
    //Working

    //getRoomTask Check
    $sql_task="SELECT * FROM `tbl_housekeeping_user_rule` WHERE `hotel_id` = $hotel_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {

        $sql_clean="UPDATE `tbl_housekeeping_user_rule` SET  `show_other` = '$active_id' WHERE `hotel_id` =  $hotel_id";  

    }else{
        $sql_clean=" INSERT INTO `tbl_housekeeping_user_rule`( `hotel_id`, `show_other`) VALUES ('$hotel_id','$active_id')";
    }



    $result = $conn->query($sql_clean);

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