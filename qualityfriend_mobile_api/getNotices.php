<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= $usert_id= $depart_id= $Create_edit_notices= $notice_id=0;
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
        $Create_edit_notices = $_POST["create_edit_rule"];
    }
    if(isset($_POST["notice_id"])){
        $notice_id = $_POST["notice_id"];
    }
    if(isset($_POST["saved_status"])){
        $saved_status = $_POST["saved_status"];
    }

    $data = array();
    $temp1=array();

    //Working
    if($hotel_id != 0){
        if($notice_id == 0){
            if($Create_edit_notices == 1 || $usert_id == 1){
                $sql="SELECT * FROM `tbl_note` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND saved_status = '$saved_status' ORDER BY 1 DESC";
            } else{
                $sql="SELECT DISTINCT a.* FROM `tbl_note` as a LEFT OUTER JOIN tbl_note_recipents as b ON a.nte_id=b.nte_id LEFT OUTER JOIN tbl_note_departments as c on a.nte_id=c.nte_id WHERE a.`hotel_id` = $hotel_id AND a.is_delete = 0 AND a.saved_status = 'CREATE' AND a.is_active = 1 AND (b.user_id=$user_id OR c.depart_id = $depart_id) ORDER BY 1 DESC"; 
            }
        }else{
            $sql="SELECT * FROM `tbl_note` WHERE  `is_delete` = 0 AND `hotel_id` = $hotel_id AND nte_id = $notice_id ORDER BY 1 DESC";
        }
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp4 = array();
                $temp2 = array();
                $temp3 = array();

                $temp_attachment = array();
                $temp_department = array();
                $temp_recipient = array();

                $temp['nte_id'] = $row['nte_id'];
                $nte_id= $row['nte_id'];
                $temp['title'] = trim($row['title']);
                $temp['title_it'] = trim($row['title_it']);
                $temp['title_de'] = trim($row['title_de']);



                //Hide one
                if ($notice_id != 0 || $saved_status == 'TEMPLATE' ){

                    $temp['description'] = trim($row['description']);
                    $temp['description_it'] = trim($row['description_it']);
                    $temp['description_de'] = trim($row['description_de']);
                    $temp['comment'] = trim($row['comment']);
                    $temp['comment_it'] = trim($row['comment_it']);
                    $temp['comment_de'] = trim($row['comment_de']);
                    $temp['tags'] = $row['tags'];


                }


                $temp['saved_status'] = $row['saved_status'];
                $temp['hotel_id'] = $row['hotel_id'];
                $temp['visibility_status'] = $row['visibility_status'];

                $creater_id = $row['entrybyid'];
                $creater="";
                $creator_url="";
                $sql_c="SELECT * FROM `tbl_user` WHERE user_id = $creater_id";
                $result_c = $conn->query($sql_c);
                if ($result_c && $result_c->num_rows > 0) {
                    while($row_c = mysqli_fetch_array($result_c)) {
                        $creater = $row_c['firstname'];
                        $creator_url = $row_c['address'];
                    }
                }


                $temp['creater'] = $creater;
                $temp['creator_url'] = $creator_url;

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



                $sql2="SELECT * FROM `tbl_note_attachment` WHERE nte_id = $nte_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp4['attachment_id'] = $row2['ntea_id'];
                        $temp4['attachment_url'] = $row2['attachment_url'];
                        array_push($temp_attachment, $temp4);
                    }
                }

                $sql2="SELECT b.* FROM `tbl_note_departments` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.nte_id = $nte_id";
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

                $sql2="SELECT a.*, b.* FROM `tbl_note_recipents` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.nte_id = $nte_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp3['user_id'] = $row2['user_id'];
                        $temp3['firstname'] = $row2['firstname'];
                        $temp3['lastname'] = $row2['lastname'];

                        array_push($temp_recipient, $temp3);
                    }
                }


                $temp['Attachements'] = $temp_attachment;
                $temp['Departments'] = $temp_department;
                $temp['Recipients'] = $temp_recipient;


                $flag = "0";

                $sql2="SELECT * FROM `tbl_note_recipents` WHERE `nte_id` = $nte_id AND `user_id` = $user_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp['priority'] = $row2['priority'];
                    }

                    $flag = "1";
                }else{
                    $flag = "0";
                    $temp['priority'] = "0";
                }
                $temp['flag']=$flag;


                $flag_department = 0;
                $sql1="SELECT a.*,b.depart_id,b.department_name,b.icon FROM `tbl_note_departments` as a INNER JOIN  tbl_department as b ON a.`depart_id` = b.`depart_id`  WHERE `nte_id` =  $nte_id";
                $result1 = $conn->query($sql1);
                if ($result1 && $result1->num_rows > 0) {
                    while($row1 = mysqli_fetch_array($result1)) {
                        if($row1['depart_id'] == $depart_id) {
                            $flag_department = 1;
                        }
                    }
                }

                $temp['flag_department'] = $flag_department; 


                array_push($data, $temp);

                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
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