<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $completed_status = 1;
    $from_date = $to_date = $filter_value = $slug = "";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['from_date'])){
        $from_date=$_POST['from_date'];
    }
    if(isset($_POST['to_date'])){
        $to_date=$_POST['to_date'];
    }
    if(isset($_POST['filter_type'])){
        $slug=$_POST['filter_type'];
    }
    if(isset($_POST['filter_id'])){
        $filter_value=$_POST['filter_id'];
    }


    if($slug == "department" && $filter_value != ""){

        $sql_completed="SELECT a.* FROM `tbl_shift_button_visiblity` as a INNER JOIN tbl_user as b on a.employee_id = b.user_id WHERE a.visible_type IN ('OFFER_UP_ONLY','TRADE_ONLY','NOT_VISIBLE_ALL') AND a.hotel_id = $hotel_id AND b.depart_id = $filter_value";
        $result_comp = $conn->query($sql_completed);
        if ($result_comp && $result_comp->num_rows > 0) {
            $completed_status = 0;
        }

        $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = $completed_status AND b.depart_id = $filter_value ORDER BY b.firstname ASC, a.assign_to";

    }else if($slug == "role" && $filter_value != ""){
        $sql_completed="SELECT a.* FROM `tbl_shift_button_visiblity` as a INNER JOIN tbl_user as b on a.employee_id = b.user_id WHERE a.visible_type IN ('OFFER_UP_ONLY','TRADE_ONLY','NOT_VISIBLE_ALL') AND a.hotel_id = $hotel_id AND b.usert_id = $filter_value";
        $result_comp = $conn->query($sql_completed);
        if ($result_comp && $result_comp->num_rows > 0) {
            $completed_status = 0;
        }

        $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = $completed_status AND b.usert_id = $filter_value ORDER BY b.firstname ASC, a.assign_to";

    }else if($slug == "employee" && $filter_value != ""){
        $sql_completed="SELECT * FROM `tbl_shift_button_visiblity` WHERE `visible_type` IN ('OFFER_UP_ONLY','TRADE_ONLY','NOT_VISIBLE_ALL') AND hotel_id = $hotel_id AND employee_id = $filter_value";
        $result_comp = $conn->query($sql_completed);
        if ($result_comp && $result_comp->num_rows > 0) {
            $completed_status = 0;
        }

        $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = $completed_status AND a.assign_to = $filter_value ORDER BY b.firstname ASC, a.assign_to";
    }else{
        $sql_completed="SELECT * FROM `tbl_shift_button_visiblity` WHERE `visible_type` IN ('OFFER_UP_ONLY','TRADE_ONLY','NOT_VISIBLE_ALL') AND hotel_id = $hotel_id";
        $result_comp = $conn->query($sql_completed);
        if ($result_comp && $result_comp->num_rows > 0) {
            $completed_status = 0;
        }

        $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = $completed_status ORDER BY b.firstname ASC, a.assign_to";
    }


    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $from_date == "" || $to_date == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Please Select Required Fields.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['employee_name'] =   $row['firstname'].' '.$row['lastname'];
                $temp['department'] =   $row['department_name'];
                $temp['shift_title'] =   $row['title'];
                $temp['date'] =   $row['date'];
                $temp['start_time'] =   $row['start_time'];
                $temp['end_time'] =   $row['end_time'];
                $temp['total_hours'] =   $row['total_hours'];
                $temp['break'] =   $row['shift_break'];
                $temp['wage_per_hour'] =   $row['wage'];
                $temp['wage_type'] =   $row['wage_type'];
                $temp['total_wage'] =   $row['wage']*$row['total_hours'];
                $temp['hotel_id'] =   $row['hotel_id'];

                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }

        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }
}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>