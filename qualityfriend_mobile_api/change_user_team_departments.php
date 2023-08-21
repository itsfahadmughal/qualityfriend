<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $id=0;
    $users_list = "";
    $user_id = 0;
    $by = "";
    //all
    $result1 = null;
    $user_id_c = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();
    if(isset($_POST['id'])){
        $id =$_POST['id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['by'])){
        $by=$_POST['by'];
    }
    if(isset($_POST['user_id_custom'])){
        $user_id_c=$_POST['user_id_custom'];
    }
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        if($by == "team"){
            $sql_check="SELECT * FROM tbl_team_map WHERE `team_id` = $id and `user_id` = $user_id_c";
            $result_check = $conn->query($sql_check);

            if ($result_check && $result_check->num_rows > 0) {
                $sql1="DELETE FROM `tbl_team_map` WHERE `team_id` = $id and `user_id` = $user_id_c";
                $result1 = $conn->query($sql1);
            }else{
                $sql1="INSERT INTO `tbl_team_map`(`team_id`, `user_id`) VALUES ('$id','$user_id_c')";
                $result1 = $conn->query($sql1);
            }

            if($result1){
                $team_name = "";
                $sql_user="SELECT * FROM tbl_team WHERE team_id = $id";
                $result_user = $conn->query($sql_user);
                if ($result_user && $result_user->num_rows > 0) {
                    while($row = mysqli_fetch_array($result_user)) {
                        if(isset($row['team_name'])){
                            $team_name = $row['team_name'];    
                        }

                    }
                }
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Update Team
            $team_name member','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";

            }

        }else if($by == "department"){

            $sql_check="SELECT * FROM tbl_user WHERE `depart_id` = $id and `user_id` = $user_id_c";
            $result_check = $conn->query($sql_check);

            if ($result_check && $result_check->num_rows > 0) {
                $sql1="UPDATE `tbl_user` SET `depart_id`='0' WHERE  `user_id` = $user_id_c ";
                $result1 = $conn->query($sql1);
            }else{
                $sql1="UPDATE `tbl_user` SET `depart_id`='$id' WHERE  `user_id` = $user_id_c ";
                $result1 = $conn->query($sql1);
            }



            if($result1){

                $department_name = "";
                $sql_user="SELECT * FROM tbl_department WHERE depart_id = $id";
                $result_user = $conn->query($sql_user);
                if ($result_user && $result_user->num_rows > 0) {
                    while($row = mysqli_fetch_array($result_user)) {
                        if(isset($row['department_name'])){
                            $department_name = $row['department_name'];    
                        }

                    }
                }

                //Log
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Update Department $department_name member','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);

                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
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