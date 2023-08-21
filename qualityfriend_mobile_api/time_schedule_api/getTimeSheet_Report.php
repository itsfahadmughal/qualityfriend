<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $from_date = $to_date = $employee = "";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['from_date'])){
        $from_date=$_POST['from_date'];
    }
    if(isset($_POST['to_date'])){
        $to_date=$_POST['to_date'];
    }
    if(isset($_POST['employee'])){
        $employee=$_POST['employee'];
    }

    if($employee == ""){
        $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 ORDER BY 1 DESC";
    }else{
        $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.assign_to = $employee ORDER BY 1 DESC";
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
                $completed = "";
                if($row['is_completed'] == 1){
                    $completed = "Yes";
                }else{
                    $completed = "No";
                }

                $temp['request_by'] =   $row['firstname'].' '.$row['lastname'];
                $temp['department'] =   $row['department_name'];
                $temp['shift_title'] =   $row['title'];
                $temp['date'] =   $row['date'];
                $temp['start_time'] =   $row['start_time'];
                $temp['end_time'] =   $row['end_time'];
                $temp['total_hours'] =   $row['total_hours'];
                $temp['break'] =   $row['shift_break'];
                $temp['shift_completed'] =   $completed;
                $temp['wage_per_hour'] =   $row['wage'];
                $temp['wage_type'] =   $row['wage_type'];
                $temp['total_wage'] =   $row['wage']*$row['total_hours'];

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