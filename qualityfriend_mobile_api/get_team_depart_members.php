<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $id=0;
    $users_list = "";
    $users_ids = array();
    $by = "";


    //all
    $user_id = 0;
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
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        if($by == "team"){
            $new_array =  array();
            $sql12="SELECT `user_id` as this_user_id FROM `tbl_team_map` WHERE`team_id` = $id ORDER BY user_id";
            $result12 = $conn->query($sql12);
            if ($result12 && $result12->num_rows > 0) {
                while($row12 = mysqli_fetch_array($result12)) {
                    array_push($new_array, $row12['this_user_id']);
                } 
            }
            $len = sizeof($new_array);
            $sql = "SELECT * FROM `tbl_user`  WHERE  is_active = 1 and is_delete = 0 and  hotel_id = $hotel_id";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $temp = array();
                    $temp['checked'] =   0;
                    $get_user_id =   $row['user_id'];
                    for ($x = 0; $x < $len; $x++) {
                        if($get_user_id == $new_array[$x]){
                            $temp['checked'] =   1;
                            break;  
                        }else{  
                        }
                    }
                    $temp['user_id'] =   $row['user_id'];
                    $temp['firstname'] =   $row['firstname'];
                    $temp['lastname'] =   $row['lastname'];
                    $temp['email'] = $row['email'];
                    $temp['usert_id'] = $row['usert_id'];
                    $temp['depart_id'] = $row['depart_id'];
                    $usert_id_ = $row['usert_id'];
                    if( $row['is_active'] == 1){
                        $temp['status'] = "Active";
                    }else {
                        $temp['status'] = "Deactive";
                    }
                    $sql2="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id and usert_id = $usert_id_ and is_delete = 0) OR `hotel_id` =  0";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp['roll'] = $row2['user_type'];
                        }
                    }
                    array_push($data, $temp);
                    unset($temp);
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successfull";
                }

            }
        }else if($by == "department"){
            $sql = "SELECT * FROM `tbl_user`  WHERE is_active = 1 and is_delete = 0 and  hotel_id = $hotel_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $temp = array();
                    $temp['checked'] =   0;
                    $get_department_id =   $row['depart_id'];
                    if($get_department_id == $id){
                        $temp['checked'] =   1;
                    }
                    $temp['user_id'] =   $row['user_id'];
                    $temp['firstname'] =   $row['firstname'];
                    $temp['lastname'] =   $row['lastname'];
                    $temp['email'] = $row['email'];
                    $temp['usert_id'] = $row['usert_id'];
                    $temp['depart_id'] = $row['depart_id'];
                    $usert_id_ = $row['usert_id'];
                    if( $row['is_active'] == 1){
                        $temp['status'] = "Active";
                    }else {
                        $temp['status'] = "Deactive";
                    }
                    $sql2="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id and usert_id = $usert_id_ and is_delete = 0) OR `hotel_id` =  0";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp['roll'] = $row2['user_type'];
                        }
                    }
                    array_push($data, $temp);
                    unset($temp);
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successfull";
                }

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