<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= $usert_id= $depart_id= $Create_edit_handovers= $handover_id=0;
    $saved_status="";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["usert_id"])){
        $usert_id = $_POST["usert_id"];
    }
    if(isset($_POST["depart_id"])){
        $depart_id = $_POST["depart_id"];
    }
    if(isset($_POST["create_edit_rule"])){
        $Create_edit_handovers = $_POST["create_edit_rule"];
    }
    if(isset($_POST["handover_id"])){
        $handover_id = $_POST["handover_id"];
    }
    if(isset($_POST["saved_status"])){
        $saved_status = $_POST["saved_status"];
    }
    $data = array();
    $temp1=array();

    $check_one = 0;

    //Working
    if($hotel_id != 0){
        if($handover_id == 0){
            if($Create_edit_handovers == 1 || $usert_id == 1){
                $sql="SELECT * FROM `tbl_handover` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND status_id = 8 AND saved_status = '$saved_status' ORDER BY 1 DESC";
            } else{
                $sql="SELECT DISTINCT a.* FROM `tbl_handover` as a LEFT OUTER JOIN tbl_handover_recipents as b on a.hdo_id=b.hdo_id LEFT OUTER JOIN tbl_handover_departments as c on a.hdo_id= c.hdo_id WHERE a.`hotel_id` = $hotel_id AND a.is_delete = 0 AND a.is_active=1 AND a.saved_status = 'CREATE' AND (a.`visibility_status` = 'PUBLIC' OR b.user_id = $user_id OR c.depart_id = $depart_id) ORDER BY 1 DESC";
            }
        }else{
            $sql="SELECT * FROM `tbl_handover` WHERE is_active=1 AND `is_delete` = 0 AND `hotel_id` = $hotel_id AND hdo_id = $handover_id ORDER BY 1 DESC";
        }
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp2 = array();
                $temp3 = array();
                $temp4 = array();
                $temp_attachment = array();
                $temp_department = array();
                $temp_recipient = array();


                $hdo_id =$row['hdo_id'];
                $status_id_org =$row['status_id'];
                $is_completed = 0;
                $sql_ = "SELECT * FROM `tbl_handover_recipents`   WHERE `user_id` = $user_id AND `hdo_id` = $hdo_id";
                $result_ = $conn->query($sql_);
                if ($result_ && $result_->num_rows > 0) {
                    while($row_ = mysqli_fetch_array($result_)) {
                        $is_completed = $row_['is_completed'];
                    }
                }

                $temp['my_is_completed'] = $is_completed;

                if($is_completed == 1 || $status_id_org == 8 ){
                    $check_one = 1;
                    $temp['hdo_id'] = $row['hdo_id'];
                    $hdo_id= $row['hdo_id'];
                    $temp['title'] = trim($row['title']);
                    $temp['title_it'] = trim($row['title_it']);
                    $temp['title_de'] = trim($row['title_de']);
                
                                          
                    $temp['visibility_status'] = $row['visibility_status'];
                    $temp['saved_status'] = $row['saved_status'];
                    $temp['hotel_id'] = $row['hotel_id'];

                    $creater_id = $row['entrybyid'];
                    $creater="";
                    $sql_c="SELECT firstname FROM `tbl_user` WHERE user_id = $creater_id";
                    $result_c = $conn->query($sql_c);
                    if ($result_c && $result_c->num_rows > 0) {
                        while($row_c = mysqli_fetch_array($result_c)) {
                            $creater = $row_c['firstname'];
                        }
                    }
                    $temp['creater'] = $creater;

                    $temp['entrytime'] = $row['entrytime'];
                    $temp['entrybyid'] = $row['entrybyid'];


                    $temp['entrybyip'] = $row['entrybyip'];
                    $temp['lastedittime'] = $row['lastedittime'];
                    $temp['lasteditbyid'] = $row['lasteditbyid'];
                    $temp['lasteditbyip'] = $row['lasteditbyip'];


                    if( $row['is_active'] == 1){
                        $temp['is_active'] = "Yes";
                    }else {
                        $temp['is_active'] = "No";
                    }

                    if( $row['is_delete'] == 1){
                        $temp['is_delete'] = "Yes";
                    }else {
                        $temp['is_delete'] = "No";
                    }
              

                    $sql2="SELECT b.* FROM `tbl_handover_departments` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.hdo_id = $hdo_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp2['depart_id'] = $row2['depart_id'];
                            $temp2['department_name'] = $row2['department_name'];
                            $temp2['department_name_it'] = $row2['department_name_it'];
                            $temp2['department_name_de'] = $row2['department_name_de'];

                            array_push($temp_department, $temp2);
                        }
                    }

                    $sql2="SELECT a.*, b.* FROM `tbl_handover_recipents` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.hdo_id = $hdo_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp4['user_id'] = $row2['user_id'];
                            $temp4['firstname'] = $row2['firstname'];
                            $temp4['lastname'] = $row2['lastname'];

                            if($row2['is_completed'] == 1){
                                $temp4['is_completed'] = "Yes";
                            }else{
                                $temp4['is_completed'] = "No";
                            }

                            array_push($temp_recipient, $temp4);
                        }
                    }

                    $temp['status_id'] = $row['status_id'];
                    $status_id = $row['status_id'];
                    $sql2="SELECT * FROM `tbl_util_status` WHERE status_id = $status_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp['status'] = $row2['status'];
                            $temp['status_it'] = $row2['status_it'];
                            $temp['status_de'] = $row2['status_de'];
                        }
                    }

                    $temp['Departments'] = $temp_department;
                    $temp['Recipients'] = $temp_recipient;




                    $flag = "0";
                    $sql2="SELECT * FROM `tbl_handover_recipents` WHERE `hdo_id` = $hdo_id AND `user_id` = $user_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp['priority']=$row2['priority'];
                        }
                        $flag = "1";
                    }else{
                        $temp['priority']="0";
                        $flag = "0";
                    }



                    $flag_department = 0;
                    $sql1="SELECT a.*,b.depart_id,b.department_name,b.icon FROM `tbl_handover_departments` as a INNER JOIN  tbl_department as b ON a.`depart_id` = b.`depart_id`  WHERE `hdo_id` =  $hdo_id";
                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                        while($row1 = mysqli_fetch_array($result1)) {
                            if($row1['depart_id'] == $depart_id) {
                                $flag_department = 1;
                            }
                        }
                    }

                    $temp['flag_department'] = $flag_department;

                    $temp['flag']=$flag;
                    array_push($data, $temp);

                    unset($temp);
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successfull";



                } else {
                    if( $check_one == 0){
                        $temp1['flag'] = 0;
                        $temp1['message'] = "Data not Found!!!";
                    }
                }


            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id Required!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>