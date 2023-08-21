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
        $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as fullname,concat(c.firstname,' ',c.lastname) as fullname_approved FROM `tbl_time_off` as a LEFT OUTER JOIN tbl_user as b on a.request_by = b.user_id INNER JOIN tbl_user as c on a.editbyid = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.is_delete = 0 AND a.is_active = 1 AND a.hotel_id = $hotel_id ORDER BY 1 DESC";
    }else{
        $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as fullname,concat(c.firstname,' ',c.lastname) as fullname_approved FROM `tbl_time_off` as a LEFT OUTER JOIN tbl_user as b on a.request_by = b.user_id INNER JOIN tbl_user as c on a.editbyid = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.is_delete = 0 AND a.is_active = 1 AND a.hotel_id = $hotel_id AND a.request_by = $employee ORDER BY 1 DESC";
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

                if($row['request_by'] == 0){
                    $row['fullname'] = "All Employees";
                }
                $temp['request_by'] =   $row['fullname'];
                $temp['category'] =   $row['category'];
                $temp['duration'] =   $row['duration'];
                $temp['date'] =   $row['date'];
                $temp['total_hours'] =   $row['total_hours'];
                $temp['break'] =   $row['shift_break'];
                $temp['status'] =   $row['status'];
                $temp['approved_or_decline_by'] =   $row['fullname_approved'];
                $temp['approved_or_decline_time'] =   $row['edittime'];

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