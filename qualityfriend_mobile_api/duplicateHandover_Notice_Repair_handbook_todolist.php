<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $id=$user_id=$hotel_id=0;
    $source="";
    $data = array();
    $temp1=array();

    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }
    if(isset($_POST['source'])){
        $source=$_POST['source'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }

    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");


    if($hotel_id == 0 || $user_id == "" || $id == 0 || $source == ""){

        $temp1['flag'] = 0;
        $temp1['message'] = "All fields must be required...";

    }else{

        if($source != "" && $source == "handover"){
            $sql="INSERT INTO `tbl_handover`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `comment`, `comment_it`, `comment_de`, `tags`, `visibility_status`, `saved_status`, `hotel_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`, `status_id`) SELECT `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `comment`, `comment_it`, `comment_de`, `tags`, `visibility_status`, `saved_status`, `hotel_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`, `status_id` FROM `tbl_handover` WHERE `hdo_id` = $id";
            $result = $conn->query($sql);
            if($result){
                $last_id_= $conn->insert_id;
                $sql_update = "UPDATE `tbl_handover` SET `entrytime`='$entry_time',`entrybyid`='$entryby_id',`entrybyip`='$entryby_ip',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `hdo_id` = $last_id_";
                $result_update = $conn->query($sql_update);
                if($result_update){
                    $sql_depart="SELECT * FROM `tbl_handover_departments` WHERE `hdo_id` = $id";
                    $result_depart = $conn->query($sql_depart);
                    if($result_depart && $result_depart->num_rows > 0){
                        while($row_depart = mysqli_fetch_array($result_depart)) {
                            $sql_depart_add="INSERT INTO `tbl_handover_departments`(`hdo_id`, `depart_id`) VALUES ('$last_id_','$row_depart[2]')";
                            $result_depart_add = $conn->query($sql_depart_add);
                        }
                    }

                    $sql_recipient="SELECT * FROM `tbl_handover_recipents` WHERE `hdo_id` = $id";
                    $result_recipient = $conn->query($sql_recipient);
                    if($result_recipient && $result_recipient->num_rows > 0){
                        while($row_recipient = mysqli_fetch_array($result_recipient)) {
                            $sql_recipient_add="INSERT INTO `tbl_handover_recipents`( `hdo_id`, `user_id`) VALUES ('$last_id_','$row_recipient[2]')";
                            $result_recipient_add = $conn->query($sql_recipient_add);
                        }
                    }

                    $sql_attachments="SELECT * FROM `tbl_handover_attachment` WHERE `hdo_id` = $id";
                    $result_attachments = $conn->query($sql_attachments);
                    if($result_attachments && $result_attachments->num_rows > 0){
                        while($row_attachments = mysqli_fetch_array($result_attachments)) {
                            $sql_attachments_add="INSERT INTO `tbl_handover_attachment`(`attachment_url`, `hdo_id`, `user_id`) VALUES  ('$row_attachments[1]','$last_id_','$user_id')";
                            $result_attachments_add = $conn->query($sql_attachments_add);
                        }
                    }

                    $temp1['flag'] = 1;
                    $temp1['message'] = "Duplicated...";

                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Not Duplicated...";
                }

            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Not Duplicated...";
            }

            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id',' Handover Duplicated','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);


        }

        if($source != "" && $source == "notice"){
            $sql="INSERT INTO `tbl_note`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `tags`, `saved_status`, `hotel_id`, `is_active`, `is_delete`, `comment`, `comment_it`, `comment_de`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) SELECT `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `tags`, `saved_status`, `hotel_id`, `is_active`, `is_delete`, `comment`, `comment_it`, `comment_de`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip` FROM `tbl_note` WHERE `nte_id` = $id";
            $result = $conn->query($sql);
            if($result){
                $last_id_= $conn->insert_id;
                $sql_update = "UPDATE `tbl_note` SET `entrytime`='$entry_time',`entrybyid`='$entryby_id',`entrybyip`='$entryby_ip',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `nte_id` = $last_id_";
                $result_update = $conn->query($sql_update);
                if($result_update){
                    $sql_depart="SELECT * FROM `tbl_note_departments` WHERE `nte_id` = $id";
                    $result_depart = $conn->query($sql_depart);
                    if($result_depart && $result_depart->num_rows > 0){
                        while($row_depart = mysqli_fetch_array($result_depart)) {
                            $sql_depart_add="INSERT INTO `tbl_note_departments`(`nte_id`, `depart_id`) VALUES ('$last_id_','$row_depart[2]')";
                            $result_depart_add = $conn->query($sql_depart_add);
                        }
                    }

                    $sql_recipient="SELECT * FROM `tbl_note_recipents` WHERE `nte_id` = $id";
                    $result_recipient = $conn->query($sql_recipient);
                    if($result_recipient && $result_recipient->num_rows > 0){
                        while($row_recipient = mysqli_fetch_array($result_recipient)) {
                            $sql_recipient_add="INSERT INTO `tbl_note_recipents`( `nte_id`, `user_id`) VALUES ('$last_id_','$row_recipient[2]')";
                            $result_recipient_add = $conn->query($sql_recipient_add);
                        }
                    }

                    $sql_attachments="SELECT * FROM `tbl_note_attachment` WHERE `nte_id` = $id";
                    $result_attachments = $conn->query($sql_attachments);
                    if($result_attachments && $result_attachments->num_rows > 0){
                        while($row_attachments = mysqli_fetch_array($result_attachments)) {
                            $sql_attachments_add="INSERT INTO `tbl_note_attachment`(`attachment_url`, `nte_id`, `user_id`) VALUES  ('$row_attachments[1]','$last_id_','$user_id')";
                            $result_attachments_add = $conn->query($sql_attachments_add);
                        }
                    }

                    $temp1['flag'] = 1;
                    $temp1['message'] = "Duplicated...";

                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Not Duplicated...";
                }

            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Not Duplicated...";
            }

            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id',' Notice Duplicated','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);

        }


        if($source != "" && $source == "repair"){
            $sql="INSERT INTO `tbl_repair`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `status_id`, `tags`, `saved_status`, `hotel_id`, `is_active`, `is_delete`, `comment`, `comment_it`, `comment_de`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) SELECT `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `status_id`, `tags`, `saved_status`, `hotel_id`, `is_active`, `is_delete`, `comment`, `comment_it`, `comment_de`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip` FROM `tbl_repair` WHERE `rpr_id` = $id";
            $result = $conn->query($sql);
            if($result){
                $last_id_= $conn->insert_id;
                $sql_update = "UPDATE `tbl_repair` SET `entrytime`='$entry_time',`entrybyid`='$entryby_id',`entrybyip`='$entryby_ip',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `rpr_id` = $last_id_";
                $result_update = $conn->query($sql_update);
                if($result_update){
                    $sql_depart="SELECT * FROM `tbl_repair_departments` WHERE `rpr_id` = $id";
                    $result_depart = $conn->query($sql_depart);
                    if($result_depart && $result_depart->num_rows > 0){
                        while($row_depart = mysqli_fetch_array($result_depart)) {
                            $sql_depart_add="INSERT INTO `tbl_repair_departments`(`rpr_id`, `depart_id`) VALUES ('$last_id_','$row_depart[2]')";
                            $result_depart_add = $conn->query($sql_depart_add);
                        }
                    }

                    $sql_recipient="SELECT * FROM `tbl_repair_recipents` WHERE `rpr_id` = $id";
                    $result_recipient = $conn->query($sql_recipient);
                    if($result_recipient && $result_recipient->num_rows > 0){
                        while($row_recipient = mysqli_fetch_array($result_recipient)) {
                            $sql_recipient_add="INSERT INTO `tbl_repair_recipents`( `rpr_id`, `user_id`) VALUES ('$last_id_','$row_recipient[2]')";
                            $result_recipient_add = $conn->query($sql_recipient_add);
                        }
                    }

                    $temp1['flag'] = 1;
                    $temp1['message'] = "Duplicated...";

                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Not Duplicated...";
                }

            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Not Duplicated...";
            }
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Repair Duplicated','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);

        }

        if($source != "" && $source == "handbook"){
            $sql ="INSERT INTO `tbl_handbook`( `hdbsc_id`, `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `tags`, `saved_status`, `hotel_id`, `is_active`, `is_delete`) 
 SELECT `hdbsc_id`,`title`,`title_it`,`title_de`,`description`,`description_it`,`description_de`,`tags`,`saved_status`,`hotel_id`,`is_active`,`is_delete` FROM  tbl_handbook WHERE `hdb_id` = $id";
            $result = $conn->query($sql);
            if($result){
                $last_id = $conn->insert_id;
                $sql ="UPDATE `tbl_handbook` SET `entrytime`='$entry_time',`entrybyid`='$entryby_id',`entrybyip`='$entryby_ip',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `hdb_id` =$last_id";
                $result = $conn->query($sql);
                if($result){
                    $sql2 ="SELECT * FROM `tbl_handbook_cat_depart_map` WHERE `hdb_id` = $id";
                    $result2= $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $a = $row['depart_id'];
                            $sql1="INSERT INTO `tbl_handbook_cat_depart_map`(`depart_id`, `hdb_id`) VALUES ('$a','$last_id')";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    $sql_attachments="SELECT * FROM `tbl_handbook_attachment` WHERE `hdb_id` = $id";
                    $result_attachments = $conn->query($sql_attachments);
                    if($result_attachments && $result_attachments->num_rows > 0){
                        while($row_attachments = mysqli_fetch_array($result_attachments)) {
                            $sql_attachments_add="INSERT INTO `tbl_handbook_attachment`(`attachment_url`, `hdb_id`, `user_id`) VALUES  ('$row_attachments[2]','$last_id','$user_id')";
                            $result_attachments_add = $conn->query($sql_attachments_add);
                        }
                    }


                    $temp1['flag'] = 1;
                    $temp1['message'] = "Duplicated...";

                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Not Duplicated...";
                }

                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','New Handbook Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);

            }
        }

        if($source != "" && $source == "todolist"){
            $recipent_list_array = array();
            $inserted_check_list_array = array();
            $inserted_inspection_array = array();
            $inserted_tour_array = array();
            $sql="INSERT INTO `tbl_todolist` (`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `visibility_status`, `assign_recipient_status`, `due_date`, `repeat_status`, `day`, `repeat_until`, `no_of_repeat`, `tags`, `hotel_id`, `saved_status`, `status_id`, `is_active`, `is_delete`) SELECT `title`,`title_it`,`title_de`,`description`,`description_it`,`description_de`,`visibility_status`,`assign_recipient_status`,`due_date`,`repeat_status`,`day`,`repeat_until`,`no_of_repeat`,`tags`,`hotel_id`,`saved_status`,`status_id`,`is_active`,`is_delete` FROM`tbl_todolist`  WHERE `tdl_id` = $id";
            $result = $conn->query($sql);
            if($result){
                $last_id = $conn->insert_id;
                $sql ="UPDATE `tbl_todolist` SET `entrytime`='$entry_time',`entrybyid`='$entryby_id',`entrybyip`='$entryby_ip',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE `tdl_id` =$last_id";
                $result = $conn->query($sql);
                if($result){
                    //Recipent
                    $sql2 ="SELECT * FROM `tbl_todolist_recipents` WHERE `tdl_id` = $id";
                    $result2= $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $a = $row['user_id'];
                            array_push($recipent_list_array,$a);
                            $sql1="INSERT INTO `tbl_todolist_recipents`(`tdl_id`, `user_id`) VALUES ('$last_id','$a')";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    $lenth_recipent = sizeof($recipent_list_array);

                    //Comment
                    $sql2 ="SELECT * FROM `tbl_todolist_comments` WHERE `tdl_id` = $id";
                    $result2= $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $a = $row['comment'];
                            array_push($recipent_list_array,$a);
                            $sql1="INSERT INTO `tbl_todolist_comments`(`tdl_id`, `comment`) VALUES ('$last_id','$a')";
                            $result1 = $conn->query($sql1);
                        }
                    }

                    //checklist
                    $sql2 ="SELECT * FROM `tbl_todolist_checklist` WHERE `tdl_id` = $id";
                    $result2= $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $c1 = $row['checklist'];
                            $c2 = $row['checklist_it'];
                            $c3 = $row['checklist_de'];
                            $sql1="INSERT INTO `tbl_todolist_checklist`( `tdl_id`, `checklist`, `checklist_it`, `checklist_de`) VALUES ('$last_id','$c1','$c2','$c3')";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    $sql_check="SELECT `tdlclt_id` FROM `tbl_todolist_checklist` WHERE `tdl_id` = $last_id";
                    $result_check = $conn->query($sql_check);
                    if ($result_check && $result_check->num_rows > 0) {
                        while($row_check = mysqli_fetch_array($result_check)) {
                            array_push($inserted_check_list_array,$row_check['tdlclt_id']);

                        }
                    }
                    for ($r = 0; $r < $lenth_recipent; $r++) {
                        for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                            $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$recipent_list_array[$r]','$last_id',0)";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    //inspection
                    $sql2 ="SELECT * FROM `tbl_todolist_inspection` WHERE `tdl_id` = $id";
                    $result2= $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $c1 = $row['inspection'];
                            $c2 = $row['inspection_it'];
                            $c3 = $row['inspection_de'];
                            $sql1="INSERT INTO `tbl_todolist_inspection` ( `tdl_id`, `inspection`, `inspection_it`, `inspection_de`) VALUES ('$last_id','$c1','$c2','$c3')";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    $sql_check="SELECT `tdlin_id` FROM `tbl_todolist_inspection` WHERE `tdl_id` = $last_id";
                    $result_check = $conn->query($sql_check);
                    if ($result_check && $result_check->num_rows > 0) {
                        while($row_check = mysqli_fetch_array($result_check)) {
                            array_push($inserted_inspection_array,$row_check['tdlin_id']);

                        }
                    }
                    for ($r = 0; $r < $lenth_recipent; $r++) {
                        for ($c = 0; $c < sizeof($inserted_inspection_array); $c++) {
                            $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_inspection_array[$c]','$recipent_list_array[$r]','$last_id',0)";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    //Tour
                    $sql2 ="SELECT * FROM `tbl_todolist_tour` WHERE `tdl_id` = $id";
                    $result2= $conn->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $c1 = $row['tour'];
                            $c2 = $row['tour_it'];
                            $c3 = $row['tour_de'];
                            $sql1="INSERT INTO `tbl_todolist_tour`( `tdl_id`, `tour`, `tour_it`, `tour_de`) VALUES ('$last_id','$c1','$c2','$c3')";
                            $result1 = $conn->query($sql1);
                        }
                    }
                    $sql_check="SELECT `tdltr_id` FROM `tbl_todolist_tour` WHERE `tdl_id` = $last_id";
                    $result_check = $conn->query($sql_check);
                    if ($result_check && $result_check->num_rows > 0) {
                        while($row_check = mysqli_fetch_array($result_check)) {
                            array_push($inserted_tour_array,$row_check['tdltr_id']);

                        }
                    }
                    for ($r = 0; $r < $lenth_recipent; $r++) {
                        for ($c = 0; $c < sizeof($inserted_tour_array); $c++) {
                            $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$c]','$recipent_list_array[$r]','$last_id',0)";
                            $result1 = $conn->query($sql1);
                        }
                    }

                    $sql_attachments="SELECT * FROM `tbl_todolist_attachment` WHERE `tdl_id` = $id";
                    $result_attachments = $conn->query($sql_attachments);
                    if($result_attachments && $result_attachments->num_rows > 0){
                        while($row_attachments = mysqli_fetch_array($result_attachments)) {
                            $sql_attachments_add="INSERT INTO `tbl_todolist_attachment`(`attachment_url`, `tdl_id`, `user_id`) VALUES  ('$row_attachments[1]','$last_id','$user_id')";
                            $result_attachments_add = $conn->query($sql_attachments_add);
                        }
                    }


                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Not Duplicated...";
                }

                $temp1['flag'] = 1;
                $temp1['message'] = "Duplicated...";

            }else{
                echo $sql;
            }
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','New Todo/Checklist Create','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);
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