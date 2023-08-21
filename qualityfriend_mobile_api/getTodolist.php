<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= $usert_id= $depart_id= $Create_edit_todo_checklist= $checklist_id = $last_id =0;
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
        $Create_edit_todo_checklist = $_POST["create_edit_rule"];
    }
    if(isset($_POST["checklist_id"])){
        $checklist_id = $_POST["checklist_id"];
    }
    if(isset($_POST["saved_status"])){
        $saved_status = $_POST["saved_status"];
    }
    if(isset($_POST["last_id"])){
        $last_id = $_POST["last_id"];
    }

    $data = array();
    $temp1=array();
    $check_one = 0;

    //Working
    if($hotel_id != 0){
        if($checklist_id == 0){
            if($Create_edit_todo_checklist  == 1 || $usert_id == 1){

                if($last_id != 0 ){
                    $sql="SELECT a.* FROM `tbl_todolist` AS a  WHERE a.`hotel_id` = $hotel_id AND status_id = 6 AND a.is_delete = 0 and a.saved_status = '$saved_status' AND tdl_id < $last_id  ORDER BY a.`entrytime` DESC  LIMIT 20"; 
                }else{
                    $sql="SELECT a.* FROM `tbl_todolist` AS a  WHERE a.`hotel_id` = $hotel_id AND status_id = 6 AND a.is_delete = 0 and a.saved_status = '$saved_status' ORDER BY a.`entrytime` DESC  LIMIT 20";   
                }


            }else{
                if($last_id != 0 ){
                    $sql="SELECT DISTINCT a.* FROM `tbl_todolist` as a LEFT OUTER JOIN tbl_todolist_recipents as b on a.tdl_id=b.tdl_id LEFT OUTER JOIN tbl_todo_departments as c on a.tdl_id=c.tdl_id WHERE a.`status_id` = 6 AND a.`hotel_id` = $hotel_id  AND a.is_delete = 0 AND a.is_active=1 AND a.saved_status = 'CREATE' AND (a.`visibility_status` = 'PUBLIC' OR (b.user_id=$user_id OR c.depart_id = $depart_id)) AND tdl_id < $last_id ORDER BY a.`entrytime` DESC  LIMIT 20";
                }else {
                    $sql="SELECT DISTINCT a.* FROM `tbl_todolist` as a LEFT OUTER JOIN tbl_todolist_recipents as b on a.tdl_id=b.tdl_id LEFT OUTER JOIN tbl_todo_departments as c on a.tdl_id=c.tdl_id WHERE a.`status_id` = 6 AND a.`hotel_id` = $hotel_id  AND a.is_delete = 0 AND a.is_active=1 AND a.saved_status = 'CREATE' AND (a.`visibility_status` = 'PUBLIC' OR (b.user_id=$user_id OR c.depart_id = $depart_id)) ORDER BY a.`entrytime` DESC LIMIT 20";
                }
            }
        }else{
            if($last_id != 0 ){
                $sql="SELECT * FROM `tbl_todolist` WHERE  `is_delete` = 0 AND `hotel_id` = $hotel_id AND tdl_id = $checklist_id ORDER BY 1 DESC";
            }else {

                $sql="SELECT * FROM `tbl_todolist` WHERE  `is_delete` = 0 AND `hotel_id` = $hotel_id AND tdl_id = $checklist_id ORDER BY 1 DESC";


            }
        }
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {

            while($row = mysqli_fetch_array($result)) {

                $temp = $temp2 = $temp3 = $temp4 = $temp5 = $temp6 = $temp7 = $temp8 = $temp9 =   $temp90 =array();

                $temp_attachment = array();
                $temp_recipient = array();

                $temp_inspection_recipient = array();
                $temp_tour_recipient = array();

                $temp_checklist = array();
                $temp_comments = array();
                $temp_inspection = array();
                $temp_tour = array();

                $tdl_id =$row['tdl_id'];

                $is_completed = 0;
                $sql_ = "SELECT * FROM `tbl_todolist_recipents`   WHERE `user_id` = $user_id AND `tdl_id` = $tdl_id";
                $result_ = $conn->query($sql_);
                if ($result_ && $result_->num_rows > 0) {
                    while($row_ = mysqli_fetch_array($result_)) {
                        $is_completed = $row_['is_completed'];
                    }
                }

                if($is_completed == 0 || $checklist_id != 0 ){
                    $check_one = 1;
                    $temp['tdl_id'] = $row['tdl_id'];
                    $tdl_id = $row['tdl_id'];
                    $temp['title'] = trim($row['title']);
                    $temp['title_it'] = trim($row['title_it']);
                    $temp['title_de'] = trim($row['title_de']);

                    //Hide one
                    if ($checklist_id != 0 || $saved_status == 'TEMPLATE' ){

                        $temp['description'] = trim($row['description']);
                        $temp['description_it'] = trim($row['description_it']);
                        $temp['description_de'] = trim($row['description_de']);
                    }
                    $temp['visibility_status'] = trim($row['visibility_status']);
                    $temp['assign_recipient_status'] = trim($row['assign_recipient_status']);

                    //Hide one
                    if ($checklist_id != 0 || $saved_status == 'TEMPLATE' ){
                        $temp['due_date'] = trim($row['due_date']);
                        $temp['repeat_status'] = $row['repeat_status'];
                        $temp['day'] = $row['day'];
                        $temp['repeat_until'] = $row['repeat_until'];
                        $temp['no_of_repeat'] = $row['no_of_repeat'];

                        $temp['tags'] = $row['tags'];
                    }
                    $temp['hotel_id'] = $row['hotel_id'];
                    $temp['saved_status'] = $row['saved_status'];

                    $creater_id = $row['entrybyid'];
                    $creater="";
                    $sql_c="SELECT firstname,address FROM `tbl_user` WHERE user_id = $creater_id";
                    $result_c = $conn->query($sql_c);
                    if ($result_c && $result_c->num_rows > 0) {
                        while($row_c = mysqli_fetch_array($result_c)) {
                            $creater = $row_c['firstname'];
                            $creater_image = $row_c['address'];
                        }
                    }
                    $temp['creater'] = $creater;
                    $temp['creator_url'] = $creater_image;

                    $temp['entrytime'] = $row['entrytime'];
                    $temp['entrybyid'] = $row['entrybyid'];
                    $temp['entrybyip'] = $row['entrybyip'];



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


                    $flag_department = '0';
                    $temp_department = array();
                    $sql2="SELECT b.* FROM `tbl_todo_departments` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.tdl_id = $row[0]";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $flag_department = '1';
                            $temp90 = array();
                            $temp90['depart_id'] = $row2['depart_id'];
                            $temp90['department_name'] = $row2['department_name'];
                            $temp90['department_name_it'] = $row2['department_name_it'];
                            $temp90['department_name_de'] = $row2['department_name_de'];
                            array_push($temp_department, $temp90);
                        }
                    }
                    $temp['Departments'] = $temp_department;

                    $flag_checklist = '0';
                    $sql2="SELECT * FROM `tbl_todolist_checklist` WHERE tdl_id = $tdl_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {

                            $temp_checklist_recipient = array();
                            $temp2['tdlclt_id'] = $row2['tdlclt_id'];
                            $temp2['checklist'] = $row2['checklist'];
                            $temp2['checklist_it'] = $row2['checklist_it'];
                            $temp2['checklist_de'] = $row2['checklist_de'];
                            $tdlclt_id = $row2['tdlclt_id'];
                            $temp3 = array();
                            $sql3="SELECT a.*,b.* FROM `tbl_todolist_checklist_user_map` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.tdl_id = $tdl_id and a.user_id = $user_id and a.tdlclt_id = $tdlclt_id";
                            $result3 = $conn->query($sql3);
                            if ($result3 && $result3->num_rows > 0) {
                                $temp3 = array();
                                $row3 = mysqli_fetch_array($result3);
                                $temp_checklist_recipient = array();

                                $flag_checklist = '1';
                                $temp3['ctum_id'] = $row3['ctum_id'];
                                $temp3['user_id'] = $row3['user_id'];
                                $temp3['firstname'] = $row3['firstname'];

                                if($row3['is_completed'] == 1){
                                    $temp3['is_completed'] = "Yes";
                                }else{
                                    $temp3['is_completed'] = "No";
                                }
                                array_push($temp_checklist_recipient, $temp3);
                            }

                            $temp2['checklist_recipients'] = $temp_checklist_recipient;

                            array_push($temp_checklist, $temp2);

                            unset($temp2);



                        }
                    }



                    $sql2="SELECT * FROM `tbl_todolist_comments` WHERE tdl_id = $tdl_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp6['comment'] = $row2['comment'];
                            array_push($temp_comments, $temp6);
                        }
                    }

                    $flag_inspection = '0';
                    $sql2="SELECT * FROM `tbl_todolist_inspection` WHERE tdl_id = $tdl_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp_inspection_recipient = array();
                            $temp4 = array();
                            $temp7['tdlin_id'] = $row2['tdlin_id'];
                            $temp7['inspection'] = $row2['inspection'];
                            $temp7['inspection_it'] = $row2['inspection_it'];
                            $temp7['inspection_de'] = $row2['inspection_de'];

                            $tdlin_id = $row2['tdlin_id'];

                            $sql3="SELECT a.*,b.* FROM `tbl_todolist_inspection_user_map` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.tdl_id = $tdl_id and a.tdlin_id = $tdlin_id and a.user_id = $user_id";
                            $result3 = $conn->query($sql3);
                            if ($result3 && $result3->num_rows > 0) {
                                while($row3 = mysqli_fetch_array($result3)) {
                                    $flag_inspection = '1';
                                    $temp_inspection_recipient = array();
                                    $temp4 = array();
                                    $temp4['cium_id'] = $row3['cium_id'];
                                    $temp4['user_id'] = $row3['user_id'];
                                    $temp4['firstname'] = $row3['firstname'];
                                    $temp4['lastname'] = $row3['lastname'];

                                    if($row3['is_completed'] == 1){
                                        $temp4['is_completed'] = "Yes";
                                    }else{
                                        $temp4['is_completed'] = "No";
                                    }

                                    array_push($temp_inspection_recipient, $temp4);
                                }
                            }

                            $temp7['inspection_recipients'] = $temp_inspection_recipient;
                            array_push($temp_inspection, $temp7);
                        }
                    }

                    $flag_tour = '0';
                    $sql2="SELECT * FROM `tbl_todolist_tour` WHERE tdl_id = $tdl_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp_tour_recipient = array();
                            $temp5 = array();
                            $temp8['tdltr_id'] = $row2['tdltr_id'];
                            $temp8['tour'] = $row2['tour'];
                            $temp8['tour_it'] = $row2['tour_it'];
                            $temp8['tour_de'] = $row2['tour_de'];

                            $tdltr_id = $row2['tdltr_id'];



                            $sql3=" SELECT a.*,b.* FROM `tbl_todolist_tour_user_map` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.tdltr_id = $tdltr_id and a.user_id = $user_id";
                            $result3 = $conn->query($sql3);
                            if ($result3 && $result3->num_rows > 0) {
                                while($row3 = mysqli_fetch_array($result3)) {
                                    $temp_tour_recipient = array();
                                    $temp5 = array();
                                    $flag_tour = '1';
                                    $temp5['ttum_id'] = $row3['ttum_id'];
                                    $temp5['user_id'] = $row3['user_id'];
                                    $temp5['firstname'] = $row3['firstname'];
                                    $temp5['lastname'] = $row3['lastname'];

                                    if($row3['is_completed'] == 1){
                                        $temp5['is_completed'] = "Yes";
                                    }else{
                                        $temp5['is_completed'] = "No";
                                    }

                                    array_push($temp_tour_recipient, $temp5);
                                }
                            }

                            $temp8['tour_recipients'] = $temp_tour_recipient;
                            array_push($temp_tour, $temp8);
                        }
                    }





                    $sql2="SELECT a.*, b.* FROM `tbl_todolist_recipents` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.tdl_id = $tdl_id and a.user_id = $user_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp9['user_id'] = $row2['user_id'];
                            $temp9['firstname'] = $row2['firstname'];
                            $temp9['lastname'] = $row2['lastname'];

                            if($temp9['is_completed'] == 1){
                                $temp9['is_completed'] = "Yes";
                            }else{
                                $temp9['is_completed'] = "No";
                            }

                            array_push($temp_recipient, $temp9);
                        }
                    }else {

                        $temp9['user_id'] = "N/A";
                        $temp9['firstname'] = "N/A";
                        $temp9['lastname'] = "N/A";


                        $temp9['is_completed'] = "No";


                        array_push($temp_recipient, $temp9);
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



                    $sql2="SELECT * FROM `tbl_todolist_attachment` WHERE tdl_id = $tdl_id";
                    $result2 = $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row2 = mysqli_fetch_array($result2)) {
                            $temp3['attachment_id'] = $row2['tdla_id'];
                            $temp3['attachment_url'] = $row2['attachment_url'];
                            array_push($temp_attachment, $temp3);
                        }
                    }

                    $temp_all_res =  array();
                    $sql1="SELECT a.*, b.* FROM `tbl_todolist_recipents` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.tdl_id = $tdl_id";
                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                        while($row1 = mysqli_fetch_array($result1)) {
                            $temp100['user_id'] = $row1['user_id'];
                            $temp100['firstname'] = $row1['firstname'];
                            $temp100['lastname'] = $row1['lastname'];

                            if($row1['is_completed'] == 1){
                                $temp100['is_completed'] = "Yes";
                            }else{
                                $temp100['is_completed'] = "No";
                            }
                            array_push($temp_all_res,$temp100);                        
                        }
                    }else{ 

                    }


                    //Hide one
                    if ($checklist_id != 0 || $saved_status == 'TEMPLATE' ){
                        $temp['Attachements'] = $temp_attachment;
                    }
                    $temp['Recipients'] = $temp_recipient;
                    $temp['All_Recipients'] = $temp_all_res;
                    //Hide one
                    if ($checklist_id != 0 || $saved_status == 'TEMPLATE' ){
                        $temp['Comments'] = $temp_comments;
                    }
                    //Hide one
                    if ($checklist_id != 0 || $saved_status == 'TEMPLATE' ){
                        $temp['Checklists'] = $temp_checklist;
                        $temp['Inspection'] = $temp_inspection;
                        $temp['Tour'] = $temp_tour;
                    }

                    //flag

                    $flag = 0;
                    $sql1="SELECT * FROM `tbl_todolist_recipents` WHERE `tdl_id` = $tdl_id and `user_id` = $user_id";
                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                        while($row = mysqli_fetch_array($result1)) {

                            $is_complete_admin = $row['is_completed'];
                            $temp['is_complete_recipent'] = $is_complete_admin;
                            $temp['priority'] = $row['priority'];

                        }
                        $is_allow = 1;
                        $temp['is_allow'] = "1";
                    }
                    else{
                        $temp['is_allow'] = "0";
                        $temp['priority'] = "0";
                    }
                    $temp['flag_department'] = $flag_department;
                    $temp['flag_checklist'] = $flag_checklist;
                    $temp['flag_inspection'] = $flag_inspection;
                    $temp['flag_tour'] = $flag_tour;

                    array_push($data, $temp);

                    unset($temp);
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successfull";


                }else{
                    if($check_one == 0){
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