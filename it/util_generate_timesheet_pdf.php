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
if(isset($_GET['employee'])){
    $employee=$_GET['employee'];
}
if(isset($_GET['hotel_id'])){
    $hotel_id=$_GET['hotel_id'];
}

if($employee != "0"){
    $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.assign_to = $employee ORDER BY 1 DESC";
}else{
    $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 ORDER BY 1 DESC";
}

$res = $conn->query($sql);
$n=1;

$temp1 = "<table>
        <thead>
            <tr>
                <th>No</th>
                <th>NOME DIPENDENTE</th>
                <th>DIPARTIMENTO</th>
                <th>TITOLO DEL CAMBIO</th>
                <th>DATE</th>
                <th>ORA DI INIZIO</th>
                <th>TEMPO SCADUTO</th>
                <th>ORE TOTALI</th>
                <th>ROTTURA (MIN)</th>
                <th>TURNO COMPLETATO</th>
                <th>SALARIO ORARIO</th>
                <th>TIPO DI SALARIO</th>
                <th>SALARIO TOTALE</th>
            </tr>
        </thead>
        <tbody>";
$temp2="";
while ($row = mysqli_fetch_array($res)) {
    if($row['is_completed'] == 1){
        $completed = "SÌ";
    }else{
        $completed = "No";
    }
    $temp2 .= '
    <tr>
        <td>'.$n.'</td>
                <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                <td>'.$row['department_name'].'</td>
                <td>'.$row['title'].'</td>
                <td>'.$row['date'].'</td>
                <td>'.$row['start_time'].'</td>
                <td>'.$row['end_time'].'</td>
                <td>'.$row['total_hours'].'</td>
                <td>'.$row['shift_break'].'</td>
                <td>'.$completed.'</td>
                <td>'.$row['wage'].'</td>
                <td>'.$row['wage_type'].'</td>
                <td>'.$row['wage']*$row['total_hours'].'</td>
</tr>';

    $n++;
}

$temp3=" </tbody>
    </table>";

$temp4 = $temp1.$temp2.$temp3;


// Load HTML content 
$dompdf->loadHtml($temp4); 

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'landscape'); 

// Render the HTML as PDF 
$dompdf->render(); 

// Output the generated PDF to Browser 
$dompdf->stream();

?>