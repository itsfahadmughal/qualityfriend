<?php
include 'util_config.php';
include 'util_session.php';

$from_date = "";
$to_date = "";
$filter_value = "";
$slug = "";
$export_type = "";
$completed_status = 1;

if(isset($_GET['from_date'])){
    $from_date=date("Y-m-d", strtotime($_GET['from_date']));
}
if(isset($_GET['to_date'])){
    $to_date=date("Y-m-d", strtotime($_GET['to_date']));
}
if(isset($_GET['filter_value'])){
    $filter_value=$_GET['filter_value'];
}
if(isset($_GET['slug'])){
    $slug=$_GET['slug'];
}
if(isset($_GET['export_type'])){
    $export_type=$_GET['export_type'];
}
if(isset($_GET['hotel_id'])){
    $hotel_id=$_GET['hotel_id'];
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

$fields = array('No', 'EMPLOYEE NAME','DEPARTMENT', 'SHIFT TITLE', 'DATE', 'START TIME', 'END TIME', 'TOTAL HOURS', 'BREAK (MIN)', 'WAGE PER HOUR','WAGE TYPE', 'TOTAL WAGE'); 

if($export_type == "CSV"){

    $filename = "employee-timesheet_" . $from_date . " - ". $to_date. " _ ". strtotime("now") .".csv"; 
    $delimiter = ","; 
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    fputcsv($f, array("Worked Hours Report"), $delimiter); 
    fputcsv($f, array(), $delimiter); 
    $days = array();


    if($slug == "department" && $filter_value != ""){
        $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.`depart_id` = $filter_value AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
    }else if($slug == "role" && $filter_value != ""){
        $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.`usert_id` = $filter_value AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
    }else if($slug == "employee" && $filter_value != ""){
        $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.`user_id` = $filter_value AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
    }else{
        $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
    }

    $result_employee = $conn->query($sql_employee);

    $nk = 0;
    if ($result_employee && $result_employee->num_rows > 0) {
        while($row_employee = mysqli_fetch_array($result_employee)) {
            $worked_hours = array();
            $paid_holiday = array();
            $unpaid_holiday = array();
            $sick = array();

            $worked_hours_t = 0;
            $paid_holiday_t = 0;
            $unpaid_holiday_t = 0;
            $sick_t = 0;
            $employe_name = $row_employee['firstname'].' '.$row_employee['lastname'];
            $employe_id = $row_employee['user_id'];

            $period = new DatePeriod(
                new DateTime($from_date),
                new DateInterval('P1D'),
                new DateTime($to_date)
            );

            foreach ($period as $key => $value) {                
                $date_search = $value->format('Y-m-d');

                $sql_sub="";
                $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE `employee_id` = $employe_id AND `visible_type` IN ('NOT_VISIBLE_ALL','TRADE_ONLY','OFFER_UP_ONLY') AND hotel_id = $hotel_id";
                $result_visibility = $conn->query($sql_visibility);
                if ($result_visibility && $result_visibility->num_rows > 0) {
                }else{
                    $sql_sub = "AND `is_completed` =  1";
                }

                $sql_worked = "SELECT SUM(`total_hours`) as hours FROM `tbl_shifts` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 ".$sql_sub." AND assign_to = $employe_id";
                $result_worked = $conn->query($sql_worked);
                if ($result_worked && $result_worked->num_rows > 0) {
                    while($row_worked = mysqli_fetch_array($result_worked)) {
                        array_push($worked_hours,$row_worked['hours']);

                        $worked_hours_t +=$row_worked['hours'];
                    }
                }else{
                    array_push($worked_hours,0);
                }

                $sql_paid = "SELECT SUM(`total_hours`) as hours FROM `tbl_time_off` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 AND `request_by` = $employe_id AND `status` = 'APPROVED' AND `category` IN ('PAID','HOLIDAY')";
                $result_paid = $conn->query($sql_paid);
                if ($result_paid && $result_paid->num_rows > 0) {
                    while($row_paid = mysqli_fetch_array($result_paid)) {
                        array_push($paid_holiday,$row_paid['hours']);
                        $paid_holiday_t +=$row_paid['hours'];
                    }
                }else{
                    array_push($paid_holiday,0);
                }

                $sql_unpaid = "SELECT SUM(`total_hours`) as hours FROM `tbl_time_off` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 AND `request_by` = $employe_id AND `status` = 'APPROVED' AND `category` IN ('UNPAID')";
                $result_unpaid = $conn->query($sql_unpaid);
                if ($result_unpaid && $result_unpaid->num_rows > 0) {
                    while($row_unpaid = mysqli_fetch_array($result_unpaid)) {
                        array_push($unpaid_holiday,$row_unpaid['hours']);
                        $unpaid_holiday_t +=$row_unpaid['hours'];
                    }
                }else{
                    array_push($unpaid_holiday,0);
                }

                $sql_sick = "SELECT SUM(`total_hours`) as hours FROM `tbl_time_off` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 AND `request_by` = $employe_id AND `status` = 'APPROVED' AND `category` IN ('PAID_SICK')";
                $result_sick = $conn->query($sql_sick);
                if ($result_sick && $result_sick->num_rows > 0) {
                    while($row_sick = mysqli_fetch_array($result_sick)) {
                        array_push($sick,$row_sick['hours']);
                        $sick_t +=$row_sick['hours'];
                    }
                }else{
                    array_push($sick,0);
                }

                array_push($days,$value->format('d F'));
            }

            if($nk == 0){
                array_push($days,"Total");
                $lineData = array_merge(array("No.","Name",""),$days);
                fputcsv($f, $lineData, $delimiter); 

            }

            array_push($worked_hours,$worked_hours_t);
            array_push($paid_holiday,$paid_holiday_t);
            array_push($unpaid_holiday,$unpaid_holiday_t);
            array_push($sick,$sick_t);


            $lineData = array_merge(array(($nk+1),$employe_name,"Worked Hours"),$worked_hours);
            fputcsv($f, $lineData, $delimiter); 
            $lineData = array_merge(array("Department",$row_employee['department_name'],"Paid holiday"),$paid_holiday);
            fputcsv($f, $lineData, $delimiter); 
            $lineData = array_merge(array("Wage Type",$row_employee['wage_type'],"Unpaid holiday"),$unpaid_holiday);
            fputcsv($f, $lineData, $delimiter); 
            $lineData = array_merge(array("Wage:",$row_employee['wage'],"Sick"),$sick);
            fputcsv($f, $lineData, $delimiter); 


            unset($worked_hours);
            unset($paid_holiday);
            unset($unpaid_holiday);
            unset($sick);

            $nk++;
        }
    }

    // Move back to beginning of file 
    fseek($f, 0); 

    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 

    //output all remaining data on a file pointer 
    fpassthru($f);


    exit;

}else if($export_type == "TXT"){
    $file = "employee-timesheet_file.txt";
    $F = fopen($file , 'w');   // open for write
    $delim = "\t";   // set delim, eg tab
    $res = $conn->query($sql);
    fwrite($F, join($delim, $fields) . "\n\n");
    $n=1;
    while ($row = mysqli_fetch_array($res)) {
        $lineData = array($n, $row['firstname'].' '.$row['lastname'], $row['department_name'], $row['title'], $row['date'], $row['start_time'], $row['end_time'], $row['total_hours'], $row['shift_break'], $row['wage'], $row['wage_type'], $row['wage']*$row['total_hours']);

        fwrite($F, join($delim, $lineData) . "\n");
        $n++;
    }
    fclose($F);

    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    header("Content-Type: text/plain");
    readfile($file);

    exit;
}else if($export_type == "WORD"){
    $vExcelFileName="employee-timesheet". ".doc"; //replace your file name from here.

    header("Content-type: application/x-ms-download"); //#-- build header to download the word file 
    header("Content-Disposition: attachment; filename=$vExcelFileName"); 
    header('Cache-Control: public'); 

    $res = $conn->query($sql);

    $n=1;
    while ($row = mysqli_fetch_array($res)) {

        $lineData[] = array('No' => $n,'EMPLOYEE NAME' => $row['firstname'].' '.$row['lastname'],'DEPARTMENT' => $row['department_name'],'SHIFT TITLE' => $row['title'],'DATE' => $row['date'],'START TIME' => $row['start_time'],'END TIME' => $row['end_time'],'TOTAL HOURS' => $row['total_hours'],'BREAK (MIN)' => $row['shift_break'],'WAGE PER HOUR' => $row['wage'],'WAGE TYPE' => $row['wage_type'],'TOTAL WAGE' => $row['wage']*$row['total_hours']);

        $n++;
    }
    $json = json_encode($lineData, JSON_PRETTY_PRINT);
    echo $json;
    exit;
}else if($export_type == "WEB"){
    $res = $conn->query($sql);
    $n=1;

?>

<link href="./dist/css/time_schedule.css" rel="stylesheet">
<div class="table-responsive">
    <h3 class="display_flex_div pr-3 pl-3 pt-3"><b style="cursor:pointer;" onclick="location.href = 'reports.php';">Back</b><button type="button" onclick="window.print();" class="btn btn-success f-right"><i class="fas fa-plus"></i> Print</button></h3>
    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
        <thead>
            <tr>
                <th class="">No</th>
                <th class="">EMPLOYEE NAME</th>
                <th class="">DEPARTMENT</th>
                <th class="">SHIFT TITLE</th>
                <th class="">DATE</th>
                <th class="">START TIME</th>
                <th class="">END TIME</th>
                <th class="">TOTAL HOURS</th>
                <th class="">BREAK (MIN)</th>
                <th class="">WAGE PER HOUR</th>
                <th class="">WAGE TYPE</th>
                <th class="">TOTAL WAGE</th>
            </tr>
        </thead>
        <tbody>
            <?php
    while ($row = mysqli_fetch_array($res)) {
            ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
                <td><?php echo $row['department_name']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['start_time']; ?></td>
                <td><?php echo $row['end_time']; ?></td>
                <td><?php echo $row['total_hours']; ?></td>
                <td><?php echo $row['shift_break']; ?></td>
                <td><?php echo $row['wage']; ?></td>
                <td><?php echo $row['wage_type']; ?></td>
                <td><?php echo $row['wage']*$row['total_hours']; ?></td>
            </tr>
            <?php 
        $n++;
    }    
            ?>
        </tbody>
    </table>
</div>
<?php
}else if($export_type == "PDF"){
    header("Location: util_generate_worked_hour_pdf.php?from_date=".$from_date."&to_date=".$to_date."&filter_value=".$filter_value."&slug=".$slug."&hotel_id=".$hotel_id);
}
?>