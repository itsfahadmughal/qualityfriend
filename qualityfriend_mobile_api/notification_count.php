<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    $user_id = $_POST['user_id'];
    $data = array();
    $temp1=array();
    //Working  
    $sql_checklist = "SELECT COUNT(*) as checklist_count FROM `tbl_alert` WHERE `id_table_name` = 'tbl_todolist' AND (alert_type = 'CREATE' OR alert_type = 'UPDATE') AND is_viewed = 0 AND user_id = $user_id and is_delete = 0";

    $sql_handover = "SELECT COUNT(*) as handover_count FROM `tbl_alert` WHERE `id_table_name` = 'tbl_handover' AND (alert_type = 'CREATE' OR alert_type = 'UPDATE') AND is_viewed = 0 AND user_id = $user_id and is_delete = 0";

    $sql_repair = "SELECT COUNT(*) as repair_count FROM `tbl_alert` WHERE `id_table_name` = 'tbl_repair' AND (alert_type = 'CREATE' OR alert_type = 'UPDATE') AND is_viewed = 0 AND user_id = $user_id and is_delete = 0";

    $sql_handbook = "SELECT COUNT(*) as handbook_count FROM `tbl_alert` WHERE `id_table_name` = 'tbl_handbook' AND (alert_type = 'CREATE' OR alert_type = 'UPDATE') AND is_viewed = 0 AND user_id = $user_id and is_delete = 0";

    $sql_workinghour = "SELECT COUNT(*) as workinghour_count FROM `tbl_alert` WHERE `id_table_name` = 'tbl_time_schedule' AND (alert_type = 'CREATE' OR alert_type = 'UPDATE') AND is_viewed = 0 AND user_id = $user_id and is_delete = 0";

    $sql_onboarding = "SELECT COUNT(*) as onboarding_count FROM `tbl_alert` WHERE (`id_table_name` = 'tbl_applicants_employee' OR `id_table_name` = 'tbl_create_job') AND (alert_type = 'CREATE' OR alert_type = 'UPDATE') AND is_viewed = 0 AND user_id = $user_id and is_delete = 0";

    $result = $conn->query($sql_checklist);
    $row = mysqli_fetch_row($result);
    $count_checklist = $row[0];
    $temp['count_checklist'] = $count_checklist;


    $result1 = $conn->query($sql_handover);
    $row1 = mysqli_fetch_row($result1);
    $count_handover = $row1[0];
    $temp['count_handover'] = $count_handover;

    $result2 = $conn->query($sql_repair);
    $row2 = mysqli_fetch_row($result2);
    $count_repair = $row2[0];
    $temp['count_repair'] = $count_repair;

    $result3 = $conn->query($sql_handbook);
    $row3 = mysqli_fetch_row($result3);
    $count_handbook = $row3[0];
    $temp['count_handbook'] = $count_handbook;

    $result4 = $conn->query($sql_workinghour);
    $row4 = mysqli_fetch_row($result4);
    $count_workinghour = $row4[0];

    $result5 = $conn->query($sql_onboarding);
    $row5 = mysqli_fetch_row($result5);
    $count_onboarding = $row5[0];

    array_push($data, $temp);
    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";


    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>