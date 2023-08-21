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
    $data = array();
    $temp1=array();
    //Working

    $sql = "SELECT * FROM `tbl_team` WHERE hotel_id = $hotel_id and is_delete = 0 and is_active = 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $team_id = $row['team_id'];
            $temp = array();

            $sql_team_check = "SELECT `team_id` as maped_team_id,`user_id` as maped_userid FROM `tbl_team_map` WHERE `team_id` = $team_id AND `user_id` = $user_id";
            $result_team_check = $conn->query($sql_team_check);
            $one_time  = 0;
            if ($result_team_check && $result_team_check->num_rows > 0) {

                $chat_count = 0;
                $sql_count= "SELECT COUNT(*) FROM `tbl_team_msg_view`WHERE `user_id` =  $user_id AND `team_id` =  $team_id AND `view` =  0";
                $result1 = $conn->query($sql_count);
                $row1 = mysqli_fetch_row($result1);
                $chat_count = $row1[0];
                $temp['team_id'] =   $row['team_id'];
                $temp['team_name'] =   $row['team_name'];
                $temp['team_name_it'] =   $row['team_name_it'];
                $temp['team_name_de'] =   $row['team_name_de'];
                $temp['chat_count'] =   $chat_count;
                array_push($data, $temp);

            }else{

            }
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";

        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>