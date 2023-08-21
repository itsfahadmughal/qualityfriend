<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = $user_id = 0;
    $departments = $to_date = $from_date = $view_filter_selected = "";
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
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


    if($view_filter_selected == "" || $view_filter_selected == "all"){
        $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE `date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id ORDER BY a.start_time ASC";
    }else if($view_filter_selected == "upcomming"){
        $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE `date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND a.is_completed = 0 ORDER BY a.start_time ASC";
    }else if($view_filter_selected == "done"){
        $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname,c.* FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as c on b.depart_id = c.depart_id WHERE `date` between '$from_date' AND '$to_date' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND a.is_completed = 1 ORDER BY a.start_time ASC";
    }


    $data = array();
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
                $shift_id = $row['sfs_id'];
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
                $temp['difference'] =   $difference;
                $temp['department_id'] = $row['depart_id'];
                $temp['department_name'] = $row['department_name'];
                $temp['department_name_it'] = $row['department_name_it'];
                $temp['department_name_de'] = $row['department_name_de'];

                $temp['Buttons_Visible_Type'] = "NOT_VISIBLE_ALL";

                if($user_id == $row['assign_to']){
                    $temp['is_completed'] = $row['is_completed'];
                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $shift_id AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";
                    $result_offer = $conn->query($sql_offer);
                    if ($result_offer && $result_offer->num_rows > 0) {
                        $temp['Offer_Up_Text'] = "Take Back";
                        $temp['Offer_Up_Shift_id'] = $shift_id;
                    }else{
                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $shift_id AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                        $result_trade = $conn->query($sql_trade);
                        if ($result_trade && $result_trade->num_rows > 0) {
                            $temp['Trade_Text'] = "Cancel Trade";
                            $temp['Trade_Shift_id'] = $shift_id;
                        }else{
                            $temp['Offer_Up_Text'] = "Offer up shift";
                            $temp['Trade_Text'] = "Trade";
                            $temp['Offering_Shift_id'] = $shift_id;
                        }
                    }

                    $sql_button_visible = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = $user_id";
                    $result_button_visible = $conn->query($sql_button_visible);
                    if ($result_button_visible && $result_button_visible->num_rows > 0) {
                        while($row_button_visible = mysqli_fetch_array($result_button_visible)) {
                            $temp['Buttons_Visible_Type'] = $row_button_visible['visible_type'];
                        }
                    }

                }

                $sql_inner = "SELECT * FROM `tbl_shifts_working_hours` WHERE `sfs_id` = $shift_id AND hotel_id = $hotel_id"; 
                $result_inner = $conn->query($sql_inner);
                if ($result_inner && $result_inner->num_rows > 0) {
                    while($row_inner = mysqli_fetch_array($result_inner)) {
                        $temp['worked_hours_id'] = $row_inner['sfswh_id'];
                        $temp['user_shift_started_time'] = $row_inner['shift_start_time'];
                        $temp['user_shift_ended_time'] = $row_inner['shift_end_time'];
                    }
                }else{
                    $temp['worked_hours_id'] =0;
                    $temp['user_shift_started_time'] = "";
                    $temp['user_shift_ended_time'] = "";
                }

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