<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $usert_id= 0;

    if(isset($_POST["usert_id"])){
        $usert_id = $_POST["usert_id"];
    }

    $data = array();
    $temp1=array();

    //Working

    $sql = "SELECT * FROM `tbl_rules`  WHERE `usert_id` = $usert_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $Create_edit_job_ad=$row['rule_9'];
            $Create_view_edit_applications=$row['rule_10'];
            $Create_view_edit_employees=$row['rule_11'];

            $Create_edit_working_time=$row['rule_12'];

            $Create_edit_handovers=$row['rule_5'];
            $Create_edit_handbooks=$row['rule_2'];
            $Create_edit_todo_checklist=$row['rule_1'];
            $Create_edit_notices=$row['rule_4'];
            $Create_edit_repairs=$row['rule_3'];

            $Edit_users_teams_departments=$row['rule_6'];
            $Edit_rules=$row['rule_8'];
            $Send_Receive_messages=$row['rule_7'];

            $Create_view_schedules=$row['rule_12'];
            $housekeeping =$row['rule_13'];
            $housekeeping_admin =$row['rule_14'];
            $wage_admin =$row['rule_15'];

            $temp['Create_edit_job_ad'] = $Create_edit_job_ad; 
            $temp['Create_view_edit_applications'] = $Create_view_edit_applications;
            $temp['Create_view_edit_employees'] = $Create_view_edit_employees;

            $temp['Create_edit_working_time'] = $Create_edit_working_time;

            $temp['Create_edit_handovers'] = $Create_edit_handovers;
            $temp['Create_edit_handbooks'] = $Create_edit_handbooks;
            $temp['Create_edit_todo_checklist'] = $Create_edit_todo_checklist;
            $temp['Create_edit_notices'] = $Create_edit_notices;
            $temp['Create_edit_repairs'] = $Create_edit_repairs;

            $temp['Edit_users_teams_departments'] = $Edit_users_teams_departments;
            $temp['Edit_rules'] = $Edit_rules;
            $temp['Send_Receive_messages'] = $Send_Receive_messages;

            $temp['housekeeping'] = $housekeeping;
            $temp['housekeeping_admin'] = $housekeeping_admin;

            $temp['Create_view_schedules'] = $Create_view_schedules;
            $temp['wage_admin'] = $wage_admin;

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