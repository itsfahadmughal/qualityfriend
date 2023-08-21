<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $from_date = $to_date = $employee = $employee2 = "";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['from_date'])){
        $from_date=$_POST['from_date'];
    }
    if(isset($_POST['to_date'])){
        $to_date=$_POST['to_date'];
    }
    if(isset($_POST['offered_by'])){
        $employee=$_POST['offered_by'];
    }
    if(isset($_GET['offered_to'])){
        $employee2=$_GET['offered_to'];
    }

    if($employee != ""){
        $sql = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time,concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_offer` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_by = $employee AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";

        $sql_t = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time, e.title as t, e.title_it as t_it, e.title_de as t_de,e.date as dt,e.start_time as st,e.end_time as et, concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_trade` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id INNER JOIN tbl_shifts as e on a.shift_to = e.sfs_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_by = $employee AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";
    }else if($employee2 != ""){
        $sql = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time,concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_offer` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_to = $employee2 AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";

        $sql_t = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time, e.title as t, e.title_it as t_it, e.title_de as t_de,e.date as dt,e.start_time as st,e.end_time as et, concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_trade` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id INNER JOIN tbl_shifts as e on a.shift_to = e.sfs_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_to = $employee2 AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";
    }else{
        $sql = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time,concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_offer` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";

        $sql_t = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time, e.title as t, e.title_it as t_it, e.title_de as t_de,e.date as dt,e.start_time as st,e.end_time as et, concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_trade` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id INNER JOIN tbl_shifts as e on a.shift_to = e.sfs_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";
    }

    $data = array();
    $data2 = array();
    $temp1=array();
    $temp2=array();

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
                if($row['is_approved_by_employee'] == "1"){
                    $row['is_approved_by_employee'] = "YES";
                }else{
                    $row['is_approved_by_employee'] = "NO";
                }
                if($row['is_approved_by_admin'] == "1"){
                    $row['is_approved_by_admin'] = "YES";
                }else{
                    $row['is_approved_by_admin'] = "NO";
                }

                $temp['offer_by'] =   $row['offer_by'];
                $temp['offered_date'] =   $row['entrytime'];
                $temp['offer_to'] =   $row['offer_to'];
                $temp['shift_offered'] =   $row['title'];
                $temp['shift_date'] =   $row['date'];
                $temp['shift_start_time'] =   $row['start_time'];
                $temp['shift_end_time'] =   $row['end_time'];
                $temp['approved_by_employee'] =   $row['is_approved_by_employee'];
                $temp['approved_by_admin'] =   $row['is_approved_by_admin'];

                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp2['title'] = "Offered Shifts";
                $temp1['message'] = "Successful";
            }
        } else {
            $temp1['flag'] = 0;
            $temp2['title'] = "Offered Shifts";
            $temp1['message'] = "Data not Found!!!";
        }

        $fields2 = array('No', 'OFFER BY','OFFERED DATE', 'SHIFT OFFERED', 'SHIFT OFFERED DATE', 'SHIFT OFFERED START TIME', 'SHIFT OFFERED END TIME', 'OFFER TO', 'SHIFT EXCHANGE WITH', 'SHIFT DATE', 'SHIFT START TIME', 'SHIFT END TIME', 'APPROVED BY EMPLOYEE', 'APPROVED BY ADMIN'); 
        //Working
        $result_t = $conn->query($sql_t);

        if ($result_t && $result_t->num_rows > 0) {
            while($row = mysqli_fetch_array($result_t)) {
                $temp = array();
                if($row['is_approved_by_employee'] == "1"){
                    $row['is_approved_by_employee'] = "YES";
                }else{
                    $row['is_approved_by_employee'] = "NO";
                }
                if($row['is_approved_by_admin'] == "1"){
                    $row['is_approved_by_admin'] = "YES";
                }else{
                    $row['is_approved_by_admin'] = "NO";
                }

                $temp['offer_by'] =   $row['offer_by'];
                $temp['offered_date'] =   $row['entrytime'];
                $temp['shift_offered'] =   $row['title'];
                $temp['shift_offered_date'] =   $row['date'];
                $temp['shift_offered_start_time'] =   $row['start_time'];
                $temp['shift_offered_end_time'] =   $row['end_time'];
                $temp['offer_to'] =   $row['offer_to'];
                $temp['shift_exchange_time'] =   $row['t'];
                $temp['shift_date'] =   $row['dt'];
                $temp['shift_start_time'] =   $row['st'];
                $temp['shift_end_time'] =   $row['et'];
                $temp['approved_by_employee'] =   $row['is_approved_by_employee'];
                $temp['approved_by_admin'] =   $row['is_approved_by_admin'];

                array_push($data2, $temp);
                unset($temp);
                $temp2['flag'] = 1;
                $temp2['title'] = "Trade Shifts";
                $temp2['message'] = "Successful";
            }
        } else {
            $temp2['flag'] = 0;
            $temp2['title'] = "Trade Shifts";
            $temp2['message'] = "Data not Found!!!";
        }

        echo json_encode(array('Status_Offered_Shifts' => $temp1,'Data_Offered_Shifts' => $data,'Status_Trade_Shifts' => $temp2,'Data_Trade_Shifts' => $data2));
    }
}else{
    $temp1['flag'] = 0;
    $temp2['title'] = "Connection Failed!";
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>