<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $message="";
    $sender_id="";
    $type="";
    $last_msg_id = "";
    //all
    $user_id = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();
    $for_what = "user"; 
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['sender_id'])){
        $sender_id=$_POST['sender_id'];
    }
    if(isset($_POST['last_msg_id'])){
        $last_msg_id = $_POST['last_msg_id'];
    }

    if(isset($_POST['for_what'])){
        $for_what = $_POST['for_what'];
    }


    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        if($for_what == "user"){
            $sql_count= "UPDATE `tbl_chat` SET `is_view`= 1  WHERE `user_id_s` = $sender_id AND `user_id_r` = $user_id AND `for_what` = '$for_what' AND `hotel_id` = $hotel_id";
        }else{
            $sql_count= "UPDATE `tbl_team_msg_view` SET `view`= '1' WHERE `user_id` = $user_id AND `team_id` = $sender_id";
        }


        $result1 = $conn->query($sql_count);
        if($last_msg_id != ""){

            if($for_what =="user"){
                $sql="SELECT * FROM (select a.`msg_id`,a.text,a.type,a.time,a.url,b.user_id_s,b.user_id_r,b.is_view from tbl_message as a  INNER JOIN  tbl_chat as b ON a.`msg_id` = b.msg_id WHERE ((b.user_id_s = $sender_id AND b.user_id_r = $user_id AND b.`for_what`= 'user') OR   (b.user_id_s = $user_id AND b.user_id_r = $sender_id AND b.`for_what`= 'user'))
    AND a.msg_id <  $last_msg_id
    ORDER BY a.`msg_id` DESC   limit 10) tmp order by tmp.msg_id asc";
            }else if ($for_what =="team"){

                //        here use sender id as team id
                $team_id = $sender_id;
                $sql="SELECT * FROM (select a.`msg_id`,a.text,a.type,a.time,a.url,b.user_id_s,b.user_id_r,b.is_view from tbl_message as a  INNER JOIN  tbl_chat as b ON a.`msg_id` = b.msg_id WHERE b.user_id_r = $team_id AND b.`for_what`= 'team' AND a.msg_id <  $last_msg_id
       ORDER BY a.`msg_id` DESC   limit 10) tmp order by tmp.msg_id asc";
            }

        }else {

            if($for_what =="user"){

                $sql="SELECT * FROM (select a.`msg_id`,a.text,a.type,a.time,a.url,b.user_id_s,b.user_id_r,b.is_view from tbl_message as a  INNER JOIN  tbl_chat as b ON a.`msg_id` = b.msg_id WHERE (b.user_id_s = $sender_id AND b.user_id_r = $user_id) OR   (b.user_id_s = $user_id AND b.user_id_r = $sender_id) ORDER BY a.`msg_id` DESC   limit 10) tmp order by tmp.msg_id asc";  
            }else if ($for_what =="team"){
                //        here use sender id as team id
                $team_id = $sender_id;
                $sql="SELECT * FROM (select a.`msg_id`,a.text,a.type,a.time,a.url,b.user_id_s,b.user_id_r,b.is_view from tbl_message as a  INNER JOIN  tbl_chat as b ON a.`msg_id` = b.msg_id WHERE b.user_id_r = $team_id AND b.`for_what`= 'team' ORDER BY a.`msg_id` DESC   limit 10) tmp order by tmp.msg_id asc";

            }


        }
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                if($for_what == "user"){
                    $temp['is_view'] = $row['is_view'];

                }else if($for_what == "team"){
                    $sql10="SELECT `view` FROM `tbl_team_msg_view` WHERE `user_id` = $user_id AND `team_id` = $team_id";
                    $result10 = $conn->query($sql10);
                    if ($result10 && $result10->num_rows > 0) {
                        while($row10 = mysqli_fetch_array($result10)) {
                            $temp['is_view'] =   $row10['view'];

                        }}
                }



                $temp['msg_id'] = $row['msg_id'];
                $temp['text'] = $row['text'];
                $temp['type'] = $row['type'];
                $temp['time'] = $row['time'];
                $temp['url'] = $row['url'];
                $user_id_s = $row['user_id_s'];
                $temp['user_id_s'] = $row['user_id_s'];
                $temp['user_id_r'] = $row['user_id_r'];

                if($for_what == "user"){

                    $sql1="SELECT `firstname` , `lastname` FROM `tbl_user`  WHERE `user_id` = $user_id_s";
                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                        while($row1 = mysqli_fetch_array($result1)) {
                            $reciver_name =   $row1['firstname'];
                            $temp['reciver_name'] = $reciver_name;
                        }}
                }else if($for_what == "team") {




                    $sql1="SELECT * FROM `tbl_team` WHERE hotel_id = $hotel_id and team_id = $sender_id";
                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                        while($row1 = mysqli_fetch_array($result1)) {
                            $reciver_name =   $row1['team_name'];
                            $temp['reciver_name'] = $reciver_name;
                        }}

                }



                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
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