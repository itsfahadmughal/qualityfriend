<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration
    $user_id=$hotel_id=0;
    $alert_type="";
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }

    $data = array();
    $temp1=array();
    $i=0;
    $department="";


    $sql_not="SELECT * FROM `tbl_alert` where user_id = $user_id and is_viewed=0 ORDER BY 1 DESC limit 4";
    $result_not = $conn->query($sql_not);

    if ($result_not && $result_not->num_rows > 0) {
        while($row_not = mysqli_fetch_array($result_not)) {
            $temp = array();
            $temp['alert_id'] = $row_not['alert_id'];
            $temp['id'] = $row_not['id'];
            $temp['alert_message'] = $row_not['alert_message'];
            if($row_not['id_table_name'] == "tbl_handover"){ $temp['alert_type'] = 'Handover';}else if($row_not['id_table_name'] == "tbl_repair"){ $temp['alert_type'] = 'Repair';}else if($row_not['id_table_name'] == "tbl_note"){ $temp['alert_type'] = 'notice';}else if($row_not['id_table_name'] == "tbl_handbook"){ $temp['alert_type'] = 'Handbook'; }else if($row_not['id_table_name'] == "tbl_todolist"){ $temp['alert_type'] = 'Todolist'; }else if($row_not['id_table_name'] == "tbl_applicants_employee"){ $temp['alert_type'] = 'Recruiting'; }else if($row_not['id_table_name'] == "tbl_create_job"){$temp['alert_type'] = 'Recruiting'; }

            $temp['id_name'] = $row_not['id_name'];
            $temp['entrytime'] = $row_not['entrytime'];

            $sql_sub_not="Select * from $row_not[4] Where $row_not[3] = $row_not[2]";
            $result_sub_not = $conn->query($sql_sub_not);
            $row_sub_not = mysqli_fetch_array($result_sub_not);
            if(isset($row_sub_not['title'])){
                $temp['title'] = $row_sub_not['title'];
            }


            array_push($data, $temp);
            unset($temp);
        }
        $temp1['flag'] = 1;
        $temp1['number_of_notification'] = $result_not->num_rows;
        $temp1['message'] = "Successfull";
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