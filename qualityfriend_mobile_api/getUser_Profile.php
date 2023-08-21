<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $user_id= 0;

    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }

    $data = array();
    $temp1=array();

    //Working

    $sql = "SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  user_id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();
            $temp2 = array();
            $temp_team = array();

            $temp['user_id'] =   $row['user_id'];
            $temp['usert_id'] = $row['usert_id'];
            $temp['firstname'] =   $row['firstname'];
            $temp['lastname'] =   $row['lastname'];
            $temp['email'] = $row['email'];
            $temp['address'] = $row['address'];
            $temp['tag'] = $row['tag'];

            $usert_id_ = $row['usert_id'];
            $depart_id_ = $row['depart_id'];

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
            $temp['depart_id'] = $depart_id_; 
            $sql3="SELECT * FROM `tbl_department` Where depart_id = $depart_id_ and is_delete = 0";
            $result3 = $conn->query($sql3);
            if ($result3 && $result3->num_rows > 0) {
                while($row3 = mysqli_fetch_array($result3)) {
                    $temp['department_name'] = $row3['department_name']; 
                    $temp['department_name_it'] = $row3['department_name_it'];
                    $temp['department_name_de'] = $row3['department_name_de'];
                }
            }

            $sql2="SELECT b.* FROM `tbl_team_map` as a INNER JOIN tbl_team as b on a.team_id = b.team_id Where a.user_id = $user_id and b.is_delete = 0";
            $result2 = $conn->query($sql2);
            if ($result2 && $result2->num_rows > 0) {
                while($row2 = mysqli_fetch_array($result2)) {
                    $temp2['team_name'] = $row2['team_name'];
                    $temp2['team_name_it'] = $row2['team_name_it'];
                    $temp2['team_name_de'] = $row2['team_name_de'];

                    array_push($temp_team, $temp2);
                }
            }

            $temp['Teams'] = $temp_team;
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