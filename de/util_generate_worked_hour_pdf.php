<?php
include 'util_config.php';
include '../util_session.php';
// Include autoloader 
require_once '../assets/dompdf/autoload.inc.php'; 

// Reference the Dompdf namespace 
use Dompdf\Dompdf; 

// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

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
    $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.`depart_id` = $filter_value AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
}else if($slug == "role" && $filter_value != ""){
    $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.`usert_id` = $filter_value AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
}else if($slug == "employee" && $filter_value != ""){
    $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.`user_id` = $filter_value AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
}else{
    $sql_employee = "SELECT a.*,b.wage_type,b.wage,d.department_name FROM `tbl_user` as a INNER JOIN tbl_department as d on a.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as b on a.user_id = b.user_id  WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0";
}


$nk = 0;
$days = "";
$sick = "";
$unpaid_holiday = "";
$paid_holiday = "";
$worked_hours = "";
$row_table="";

$result_employee = $conn->query($sql_employee);
if ($result_employee && $result_employee->num_rows > 0) {
    while($row_employee = mysqli_fetch_array($result_employee)) {
        $sick = "";
        $unpaid_holiday = "";
        $paid_holiday = "";
        $worked_hours = "";

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
                    $worked_hours .= "<td>".$row_worked['hours']."</td>";
                    $worked_hours_t +=$row_worked['hours'];
                }
            }else{
                $worked_hours .= "<td>0</td>";
            }

            $sql_paid = "SELECT SUM(`total_hours`) as hours FROM `tbl_time_off` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 AND `request_by` = $employe_id AND `status` = 'APPROVED' AND `category` IN ('PAID','HOLIDAY')";
            $result_paid = $conn->query($sql_paid);
            if ($result_paid && $result_paid->num_rows > 0) {
                while($row_paid = mysqli_fetch_array($result_paid)) {
                    $paid_holiday .= "<td>".$row_paid['hours']."</td>";
                    $paid_holiday_t +=$row_paid['hours'];
                }
            }else{
                $paid_holiday .= "<td>0</td>";
            }

            $sql_unpaid = "SELECT SUM(`total_hours`) as hours FROM `tbl_time_off` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 AND `request_by` = $employe_id AND `status` = 'APPROVED' AND `category` IN ('UNPAID')";
            $result_unpaid = $conn->query($sql_unpaid);
            if ($result_unpaid && $result_unpaid->num_rows > 0) {
                while($row_unpaid = mysqli_fetch_array($result_unpaid)) {
                    $unpaid_holiday .= "<td>".$row_unpaid['hours']."</td>";
                    $unpaid_holiday_t +=$row_unpaid['hours'];
                }
            }else{
                $unpaid_holiday .= "<td>0</td>";
            }

            $sql_sick = "SELECT SUM(`total_hours`) as hours FROM `tbl_time_off` WHERE `date` = '$date_search' AND `is_active` = 1 AND `is_delete` = 0 AND `request_by` = $employe_id AND `status` = 'APPROVED' AND `category` IN ('PAID_SICK')";
            $result_sick = $conn->query($sql_sick);
            if ($result_sick && $result_sick->num_rows > 0) {
                while($row_sick = mysqli_fetch_array($result_sick)) {
                    $sick .= "<td>".$row_sick['hours']."</td>";
                    $sick_t +=$row_sick['hours'];
                }
            }else{
                $sick .= "<td>0</td>";
            }


            if($nk == 0){
                $days .= "<th>".$value->format('d F')."</th>";
            }
        }


        $row_table .= "<tr style='background-color:#c5c6d0;'><td><b>".($nk+1)."</b></td>"."<td><b>".$employe_name."</b></td>"."<td><b>Geleistete Stunden</b></td>".$worked_hours."<td><b>".$worked_hours_t."</b></td></tr>";

        $row_table .= "<tr><td><b>Abteilung</b></td>"."<td><b>".$row_employee['department_name']."</b></td>"."<td><b>Bezahlter Urlaub</b></td>".$paid_holiday."<td><b>".$paid_holiday_t."</b></td></tr>";

        $row_table .= "<tr><td><b>Löhne Typ</b></td>"."<td><b>".$row_employee['wage_type']."</b></td>"."<td><b>Unbezahlter Urlaub</b></td>".$unpaid_holiday."<td><b>".$unpaid_holiday_t."</b></td></tr>";

        $row_table .= "<tr><td><b>Löhne:</b></td>"."<td>".$row_employee['wage']."</td>"."<td><b>Krank<b></td>".$sick."<td><b>".$sick_t."</b></td></tr>";


        $nk++;
    }
}

$days = "<th>Nr.</th><th>Name</th><th></th>".$days."<th>Gesamt</th>";

$temp1 = "

<style>
table, th, td{
    border: 1px solid black;
    border-collapse: collapse;
    padding:5px;
}
</style>

<h3>Worked Hours Report</h3> <br>
<table>
        <thead>
            <tr>".$days."</tr>
        </thead>
        <tbody>";

$temp2=$row_table;

$temp3=" </tbody>
    </table>";

$temp4 = $temp1.$temp2.$temp3;

//echo $temp4;

// Load HTML content 
$dompdf->loadHtml($temp4); 

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'landscape'); 

// Render the HTML as PDF 
$dompdf->render(); 

// Output the generated PDF to Browser 
$dompdf->stream();

?>