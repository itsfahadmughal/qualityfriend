<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration
    $user_id=$hotel_id=0;
    $alert_type="";
    $last_id = 0;
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['alert_type'])){
        $alert_type='tbl_'.$_POST['alert_type'];
    }
    if(isset($_POST['last_alert_id'])){
        $last_id=$_POST['last_alert_id'];
    }

    $data = array();
    $temp1=array();
    $i=0;
    $department="";
    $involved_person = "";

    if($alert_type != ""){

        if($alert_type == 'tbl_notice'){
            $alert_type = 'tbl_note';
        }


        if($last_id != 0){
            $sql="SELECT * FROM `tbl_alert` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND user_id = $user_id AND `id_table_name` = '$alert_type'  AND `alert_id` < $last_id ORDER BY `tbl_alert`.`priority` DESC,`tbl_alert`.`alert_id` DESC LIMIT 60";

        }else {

            $sql="SELECT * FROM `tbl_alert` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND user_id = $user_id AND `id_table_name` = '$alert_type' ORDER BY `tbl_alert`.`priority` DESC,`tbl_alert`.`alert_id` DESC LIMIT 60";

        }
    }else{
        //        $sql="SELECT * FROM `tbl_alert` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND user_id = $user_id  ORDER BY `tbl_alert`.`priority` DESC,`tbl_alert`.`alert_id` DESC";

        if($last_id != 0){

            $sql="SELECT * FROM `tbl_alert` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND user_id = $user_id
                       AND `alert_id` < $last_id
                        ORDER BY `tbl_alert`.`priority` DESC,`tbl_alert`.`alert_id` DESC  LIMIT 60";  
        }else{
            $sql="SELECT * FROM `tbl_alert` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND user_id = $user_id  ORDER BY `tbl_alert`.`priority` DESC,`tbl_alert`.`alert_id` DESC  LIMIT 60"; 
        }
    }


    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {


            $sql_sub="select * from $row[4] where $row[3] = $row[2]";
            $result_sub = $conn->query($sql_sub);
            $row_sub = mysqli_fetch_array($result_sub);

            $entryid=$row_sub['entrybyid'];


            $sql_sub1="select firstname from tbl_user where user_id = $entryid";
            $result_sub1 = $conn->query($sql_sub1);
            $row_sub1 = mysqli_fetch_array($result_sub1);

            $status="";
            $check_complate ="";
            if($row[4] == "tbl_handover" || $row[4] == "tbl_todolist" || $row[4] == "tbl_repair" ){
                $sql_sub33="SELECT `is_completed` FROM $row[4]".'_recipents '."WHERE `user_id` = $user_id and $row[3] = $row[2]";
                $result_sub33 = $conn->query($sql_sub33);
                $row_sub33 = mysqli_fetch_array($result_sub33);
                if(isset($row_sub33['is_completed'])){
                    $r_is_completed=$row_sub33['is_completed'];
                    if($r_is_completed== 1){
                        $check_complate = "lite_green";
                    }else{
                        $check_complate = "";
                    }
                }


            }


            if(isset($row_sub['status_id'])){
                $st_id=$row_sub['status_id'];
                $sql_sub2="SELECT `status` FROM `tbl_util_status` WHERE `status_id` = $st_id";
                $result_sub2 = $conn->query($sql_sub2);
                $row_sub2 = mysqli_fetch_array($result_sub2);

                if($row_sub2['status'] == 'In Pipeline'){
                    $status = "Pending";
                }else{
                    $status = $row_sub2['status'];
                }

                if($st_id == 8){
                    $check_complate = "lite_green";
                }else{
                    $check_complate = "";
                }


            }else if(isset($row_sub['saved_status'])){
                $status=$row_sub['saved_status'];
            }else{
                if(isset($row_sub['is_completed'])){
                    if($row_sub['is_completed'] == 0){
                        $status = "Pending";
                    }else{
                        $check_complate = "lite_green";
                        $status = "Completed";
                    }
                }else{
                    if(isset($row_sub['status'])){
                        $status = $row_sub['status'];
                    }else{
                        if(isset($row_sub['is_approved_by_employee'])){
                            if($row_sub['is_approved_by_employee'] == 0){
                                $status = "Pending";
                            }else{
                                $check_complate = "lite_green";
                                $status = "Approved";
                            }
                        }else{
                            if(isset($row_sub['is_approved_by_admin'])){
                                if($row_sub['is_approved_by_admin'] == 0){
                                    $status = "Pending";
                                }else{
                                    $check_complate = "lite_green";
                                    $status = "Approved";
                                }
                            }else{
                                $status = "None";
                            }
                        }
                    }
                }
            }

            $table_name_dept=$row[4]."_departments";
            $table_name_recpt=$row[4]."_recipents";

            $sql_sub3="select b.department_name as department_name from $table_name_dept as a INNER JOIN tbl_department as b on a.depart_id=b.depart_id where a.$row[3] = $row[2] ORDER BY RAND() Limit 1";
            $result_sub3 = $conn->query($sql_sub3);

            if(!$result_sub3){
                $department="";
            }else{
                $row_sub3 =mysqli_fetch_array($result_sub3);
                if(isset($row_sub3['department_name'])){
                    $department=$row_sub3['department_name'];
                }
            }

            if($row['id_table_name'] == "tbl_shifts"){
                $sql_sub4="select b.firstname as firstname from tbl_shifts as a INNER JOIN tbl_user as b on a.assign_to=b.user_id where a.$row[3] = $row[2] ORDER BY RAND() Limit 1";
            }else{
                $sql_sub4="select b.firstname as firstname from $table_name_recpt as a INNER JOIN tbl_user as b on a.user_id=b.user_id where a.$row[3] = $row[2] ORDER BY RAND() Limit 1";
            }

            $result_sub4 = $conn->query($sql_sub4);
            if(!$result_sub4){

            }else{
                $row_sub4 =mysqli_fetch_array($result_sub4);

                if(isset($row_sub4['firstname'])){
                    $involved_person = $row_sub4['firstname'];
                }
            }


            $temp['id'] = $row['id'];
            $temp['alert_id'] = $row[0];
            $temp['alert_message'] = $row['alert_message'];

            if($row['id_table_name'] == "tbl_handover"){ $temp['alert_type'] = 'Handover';}else if($row['id_table_name'] == "tbl_repair"){ $temp['alert_type'] = 'Repair';}else if($row['id_table_name'] == "tbl_note"){ $temp['alert_type'] = 'notice';}else if($row['id_table_name'] == "tbl_handbook"){ $temp['alert_type'] = 'Handbook'; }else if($row['id_table_name'] == "tbl_todolist"){ $temp['alert_type'] = 'Todolist'; }else if($row['id_table_name'] == "tbl_applicants_employee"){ $temp['alert_type'] = 'Recruiting'; }else if($row['id_table_name'] == "tbl_create_job"){$temp['alert_type'] = 'Recruiting'; } else if($row['id_table_name'] == "tbl_shifts"){$temp['alert_type'] = 'Schedules'; }  else if($row['id_table_name'] == "tbl_shift_events"){$temp['alert_type'] = 'Events'; }else if($row['id_table_name'] == "tbl_shift_offer"){$temp['alert_type'] = 'Shift Offered'; } else if($row['id_table_name'] == "tbl_shift_trade"){$temp['alert_type'] = 'Shift Trade'; } else if($row['id_table_name'] == "tbl_time_off"){$temp['alert_type'] = 'Off Time'; }   

            $temp['creator'] = $row_sub1['firstname'];

            if(isset($department)){
                $temp['involved_department'] = $department;
            }

            if(isset($involved_person)){
                $temp['involved_person'] = $involved_person;
            }

            $temp['status'] = $status;
            $temp['check_complate'] = $check_complate;

            $temp['date'] = date("d.m.Y", strtotime(substr($row[8],0,10)));
            $temp['time'] = substr($row[8],10);
            $view = $row['is_viewed'];
            $temp['is_viewed'] = $view;

            if($i==0){
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
                $i++;
            }
            array_push($data, $temp);
            unset($temp);
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
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