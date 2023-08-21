<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $departments = $to_date = $from_date = $view_filter_selected = "";
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["departments_comma_separated"])){
        $departments = $_POST["departments_comma_separated"];
    }
    if(isset($_POST["filter"])){
        $view_filter_selected = $_POST["filter"];
    }
    if(isset($_POST["from_date"])){
        $from_date = $_POST["from_date"];
    }
    if(isset($_POST["to_date"])){
        $to_date = $_POST["to_date"];
    }

    if($departments == "" || $departments == 0 || $departments == null){
        if($view_filter_selected == "" || $view_filter_selected == "all"){
            $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE a.`date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id ORDER BY a.start_time ASC";
        }else if($view_filter_selected == "upcomming"){
            $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE a.`date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND a.is_completed = 0 ORDER BY a.start_time ASC";
        }else if($view_filter_selected == "done"){
            $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE a.`date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND a.is_completed = 1 ORDER BY a.start_time ASC";
        }
    }else{
        if($view_filter_selected == "" || $view_filter_selected == "all"){
            $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE a.`date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($departments) ORDER BY a.start_time ASC";
        }else if($view_filter_selected == "upcomming"){
            $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE a.`date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($departments) AND a.is_completed = 0 ORDER BY a.start_time ASC";
        }else if($view_filter_selected == "done"){
            $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE a.`date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($departments) AND a.is_completed = 1 ORDER BY a.start_time ASC";
        }
    }

    $data = array();
    $data2 = array();
    $temp1=array();
    if($hotel_id == "" || $hotel_id == 0 || $from_date == "" || $to_date == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & Dates are Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['shift_id'] =   $row['sfs_id'];
                $temp['title'] =   $row['title'];
                $temp['assign_to_user_id'] =   $row['user_id'];
                $temp['assign_to_user_name'] =   $row['fullname'];
                $temp['date'] =   $row['date'];
                $temp['day'] =   date('D', strtotime($row['date']));
                $temp['start_time'] =   $row['start_time'];
                $temp['end_time'] = $row['end_time'];

                $time1 = strtotime($row['end_time']);
                $time2 = strtotime($row['start_time']);
                $difference = round(abs($time2 - $time1) / 3600,2);
                $temp['difference'] = $difference;
                $temp['shift_break'] = $row['shift_break'];
                $temp['is_completed'] = $row['is_completed'];
                $temp['department_id'] = $row['depart_id'];
                $temp['department_name'] = $row['department_name'];
                $temp['department_name_it'] = $row['department_name_it'];
                $temp['department_name_de'] = $row['department_name_de'];

                $temp['off_time'] = $data2;

                array_push($data, $temp);

                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }



        $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE `date` between '$from_date' AND '$to_date' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK','HOLIDAY') ORDER BY date ASC";
        $result_block_day = $conn->query($sql_block_day);
        if ($result_block_day && $result_block_day->num_rows > 0) {
            while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                $temp2 = array();
                $temp2['off_time_id'] = $row_block_day['tmeo_id'];
                if($row_block_day['request_by'] == 0){
                    $temp2['assigned_to'] = 'all';
                }else{
                    $temp2['assigned_to'] = $row_block_day['request_by'];
                }
                $temp2['title'] = $row_block_day['title'];
                $temp2['duration'] = $row_block_day['duration'];
                $temp2['category'] = $row_block_day['category'];
                $temp2['start_time'] = $row_block_day['start_time'];
                $temp2['end_time'] = $row_block_day['end_time'];
                $temp2['date'] = $row_block_day['date'];
                $temp2['total_hours'] = $row_block_day['total_hours'];
                array_push($data2, $temp2);
            }
        }



        echo json_encode(array('Status' => $temp1,'Data' => $data,'Off_time' => $data2));
    }
}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>