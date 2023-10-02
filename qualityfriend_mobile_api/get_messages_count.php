<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $user_id= 0;
    $user_list = "";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    $data = array();
    $temp1=array();

    //Working

    $sql_chat= "SELECT * FROM `tbl_chat` WHERE `user_id_r` = $user_id AND `for_what`= 'user' AND `hotel_id` = $hotel_id AND `is_view` = 0 ORDER BY 1 DESC";
    $result_chat = $conn->query($sql_chat);

    $count_1 = $result_chat->num_rows;

    $sql_chat_team= "SELECT a.*,b.view as team_view FROM tbl_chat as a INNER JOIN tbl_team_msg_view as b ON a.chat_id = b.chat_id WHERE b.user_id = $user_id AND b.view = 0 ORDER BY 1 DESC ";
    $result_chat_team = $conn->query($sql_chat_team);
    $count_2 = $result_chat_team->num_rows;
    $final_count = $count_1 + $count_2;
    $temp = array();

    $temp['count'] =   $final_count;

    array_push($data, $temp);
    unset($temp);
    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";



    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>