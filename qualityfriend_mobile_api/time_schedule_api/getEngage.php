<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $ds = $de = $depart = "";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['from_date'])){
        $ds=$_POST['from_date'];
    }
    if(isset($_POST['to_date'])){
        $de=$_POST['to_date'];
    }
    if(isset($_POST['department'])){
        $depart=$_POST['department'];
    }

    if($depart == "" || $depart == 0){
        $sql_most1 = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";

        $sql_most2 = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";

        $sql_most3 = "SELECT a.request_by, COUNT(a.status),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.status = 'APPROVED' AND a.category = 'PAID_SICK' GROUP BY a.request_by ORDER BY COUNT(a.status) DESC LIMIT 1";

        $sql_most4 = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";

        $sql_avg1 = "SELECT COUNT(is_completed) as completed FROM `tbl_shifts` WHERE (date BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 AND is_completed = 1";
        $sql_avg2 = "SELECT COUNT(is_completed) as not_completed FROM `tbl_shifts` WHERE (date BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 AND is_completed = 0";

        $sql_engaged = "SELECT a.assign_to, COUNT(a.is_completed) as ss,concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC";

        $sql_no_show = "SELECT COUNT(is_completed) as ss FROM `tbl_shifts` WHERE (date BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 AND is_completed = 0";

        $sql_sick = "SELECT COUNT(a.status) as ss FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category = 'PAID_SICK'";

        $sql_bids1 = "SELECT COUNT(sftou_id) as ss FROM `tbl_shift_offer` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1";
        $sql_bids2 = "SELECT COUNT(sfttrd_id) as ss FROM `tbl_shift_trade` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1";

        $sql_dropped1 = "SELECT COUNT(sftou_id) as ss FROM `tbl_shift_offer` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND (is_approved_by_employee = 0 OR is_approved_by_admin = 0) AND is_active = 1";
        $sql_dropped2 = "SELECT COUNT(sfttrd_id) as ss FROM `tbl_shift_trade` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND (is_approved_by_employee = 0 OR is_approved_by_admin = 0) AND is_active = 1";

    }else{
        $sql_most1 = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";

        $sql_most2 = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";

        $sql_most3 = "SELECT a.request_by, COUNT(a.status),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.status = 'APPROVED' AND a.category = 'PAID_SICK' AND b.depart_id = $depart GROUP BY a.request_by ORDER BY COUNT(a.status) DESC LIMIT 1";

        $sql_most4 = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";

        $sql_avg1 = "SELECT COUNT(a.is_completed) as completed FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 AND b.depart_id = $depart";
        $sql_avg2 = "SELECT COUNT(a.is_completed) as not_completed FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart";

        $sql_engaged = "SELECT a.assign_to, COUNT(a.is_completed) as ss,concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC";

        $sql_no_show = "SELECT COUNT(a.is_completed) as ss FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart";

        $sql_sick = "SELECT COUNT(a.status) as ss FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category = 'PAID_SICK' AND b.depart_id = $depart";

        $sql_bids1 = "SELECT COUNT(a.sftou_id) as ss FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND b.depart_id = $depart ";
        $sql_bids2 = "SELECT COUNT(a.sfttrd_id) as ss FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND b.depart_id = $depart ";

        $sql_dropped1 = "SELECT COUNT(a.sftou_id) as ss FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND (a.is_approved_by_employee = 0 OR a.is_approved_by_admin = 0) AND b.depart_id = $depart ";
        $sql_dropped2 = "SELECT COUNT(a.sfttrd_id) as ss FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND (a.is_approved_by_employee = 0 OR a.is_approved_by_admin = 0) AND b.depart_id = $depart ";
    }

    $data = array();
    $data1 = array();
    $data2 = array();
    $data3 = array();
    $data4 = array();
    $data5 = array();

    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $ds == "" || $de == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Please Send Required Fields.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{
        $temp1['flag'] = 1;
        $temp1['message'] = "Successful";


        //Working
        $result = $conn->query($sql_most1);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['most_reliable_letter'] =   substr($row['fullname'],0,1);
                $temp['most_reliable_name'] =   $row['fullname'];

                array_push($data, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['most_reliable_letter'] =   'N';
            $temp['most_reliable_name'] =   'N/A';
            array_push($data, $temp);
            unset($temp);
        }

        $result = $conn->query($sql_most2);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['most_eager_letter'] =   substr($row['fullname'],0,1);
                $temp['most_eager_name'] =   $row['fullname'];

                array_push($data, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['most_eager_letter'] =   'N';
            $temp['most_eager_name'] =   'N/A';
            array_push($data, $temp);
            unset($temp);
        }

        $result = $conn->query($sql_most3);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['most_sick_letter'] =   substr($row['fullname'],0,1);
                $temp['most_sick_name'] =   $row['fullname'];

                array_push($data, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['most_sick_letter'] =   'N';
            $temp['most_sick_name'] =   'N/A';
            array_push($data, $temp);
            unset($temp);
        }

        $result = $conn->query($sql_most4);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['most_dropped_letter'] =   substr($row['fullname'],0,1);
                $temp['most_dropped_name'] =   $row['fullname'];

                array_push($data, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['most_dropped_letter'] =   'N';
            $temp['most_dropped_name'] =   'N/A';
            array_push($data, $temp);
            unset($temp);
        }

        $result_most = $conn->query($sql_avg1);
        $result_most2 = $conn->query($sql_avg2);
        $row2 = mysqli_fetch_array($result_most2);
        while ($row = mysqli_fetch_array($result_most)) {
            $temp = array();

            $total = $row['completed'] + $row2['not_completed'];
            $avg_completed = 0;
            if($total != 0){
                $avg_completed = round($row['completed'] / $total,2);
            }

            $temp['avg_score']= $avg_completed;
            $temp['previous']= '0.8';

            array_push($data1, $temp);
            unset($temp);

            $temp['engangment_rate']= $avg_completed * 100;
            array_push($data3, $temp);
            unset($temp);
        }

        $result = $conn->query($sql_engaged);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                if($row['ss'] > 1){
                    $temp = array();
                    $temp['most_engaged'] =   $row['fullname'];
                    $temp['most_engaged_letter'] =   substr($row['fullname'],0,1);
                    $temp['most_engaged_status'] =   "Highly Engaged";
                    array_push($data2, $temp);
                    unset($temp);
                }
            }
        } else {
            $temp = array();
            $temp['most_engaged'] =   'N/A';
            array_push($data2, $temp);
            unset($temp);
        }


        $result = $conn->query($sql_no_show);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['no_shows'] =   $row['ss'];
                $temp['no_shows_previous'] =   2;

                array_push($data5, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['no_shows'] =   'N/A';
            $temp['no_shows_previous'] =   2;
            array_push($data5, $temp);
            unset($temp);
        }

        $result = $conn->query($sql_sick);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['sick'] =   $row['ss'];
                $temp['sick_previous'] =   11;

                array_push($data5, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['sick'] =   'N/A';
            $temp['sick_previous'] =   11;
            array_push($data5, $temp);
            unset($temp);
        }

        $result_most = $conn->query($sql_bids1);
        $result_most2 = $conn->query($sql_bids2);
        $row2 = mysqli_fetch_array($result_most2);
        if ($result_most && $result_most->num_rows > 0) {
            while ($row = mysqli_fetch_array($result_most)) {
                $temp = array();
                $temp['shift_bids'] = $row['ss'] + $row2['ss'];
                $temp['shift_bids_previous'] = 2;
                array_push($data5, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['shift_bids'] =   'N/A';
            $temp['shift_bids_previous'] =   2;
            array_push($data5, $temp);
            unset($temp);
        }

        $result_most = $conn->query($sql_dropped1);
        $result_most2 = $conn->query($sql_dropped2);
        $row2 = mysqli_fetch_array($result_most2);
        if ($result_most && $result_most->num_rows > 0) {
            while ($row = mysqli_fetch_array($result_most)) {
                $temp = array();
                $temp['shift_dropped'] = $row['ss'] + $row2['ss'];
                $temp['shift_dropped_previous'] = 2;
                array_push($data5, $temp);
                unset($temp);
            }
        } else {
            $temp = array();
            $temp['shift_dropped'] =   'N/A';
            $temp['shift_dropped_previous'] =   8;
            array_push($data5, $temp);
            unset($temp);
        }


        $temp = array();
        $temp['avg_tenure'] = rand(280,320);
        array_push($data4, $temp);
        unset($temp);

        echo json_encode(array('Status' => $temp1,'Most_Row' => $data,'Avg_Col' => $data1,'Engaged_Col' => $data2,'Rate_Col' => $data3,'Tenure_Col' => $data4,'No_Show_Row' => $data5));
    }
}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>