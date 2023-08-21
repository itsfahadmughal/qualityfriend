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
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["user_list"])){
        $user_list = $_POST["user_list"];
    }

    $data = array();
    $temp1=array();

    //Working

    if($user_list == "user_list"){
        $sql = "SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id ORDER BY `tbl_user`.`user_id` DESC";
    }else {
        $sql = "SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id and  is_active = 1 ORDER BY `tbl_user`.`user_id` DESC";
    }
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['user_id'] =   $row['user_id'];
            $user_ids =   $row['user_id'];
            $temp['firstname'] =   $row['firstname'];

            $temp['lastname'] =   $row['lastname'];
            $temp['email'] = $row['email'];
            $temp['image_url'] =   $row['address'];
            $temp['usert_id'] = $row['usert_id'];
            $temp['depart_id'] = $row['depart_id'];
            $dep_id = $row['depart_id'];
            $usert_id_ = $row['usert_id'];
            if( $row['is_active'] == 1){
                $temp['status'] = "Active";
            }else {
                $temp['status'] = "Deactive";
            }
            if( $row['enable_for_schedules'] == 1){
                $temp['enable_for_schedules'] = "Active";
            }else {
                $temp['enable_for_schedules'] = "Deactive";
            }
            $sql2="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id and usert_id = $usert_id_ and is_delete = 0) OR `hotel_id` =  0";
            $result2 = $conn->query($sql2);
            if ($result2 && $result2->num_rows > 0) {
                while($row2 = mysqli_fetch_array($result2)) {
                    $temp['roll'] = $row2['user_type'];
                }
            }

            $sql3="SELECT * FROM `tbl_department`  WHERE `depart_id` = $dep_id";
            $result3 = $conn->query($sql3);
            if ($result3 && $result3->num_rows > 0) {
                while($row3 = mysqli_fetch_array($result3)) {
                    $temp['department_name'] = $row3['department_name'];
                }
            }

            $sql3="SELECT `rule_7` FROM `tbl_rules` WHERE `usert_id` = $usert_id_";
            $result3 = $conn->query($sql3);
            if ($result3 && $result3->num_rows > 0) {
                while($row3 = mysqli_fetch_array($result3)) {
                    $temp['send_Receive_messages'] = $row3['rule_7'];
                }
            }

            //count_messagess
            $chat_count = 0;
            $sql_count= "SELECT COUNT(*) as chat_count FROM `tbl_chat` WHERE `user_id_s` = $user_ids AND `user_id_r` = $user_id AND `hotel_id` = $hotel_id AND `is_view` = 0";
            $result1 = $conn->query($sql_count);
            $row1 = mysqli_fetch_row($result1);
            $chat_count = $row1[0];
            $temp['count_messages'] = $chat_count;




            array_push($data, $temp);
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