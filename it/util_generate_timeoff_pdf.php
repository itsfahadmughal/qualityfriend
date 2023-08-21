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
    $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as fullname,concat(c.firstname,' ',c.lastname) as fullname_approved FROM `tbl_time_off` as a LEFT OUTER JOIN tbl_user as b on a.request_by = b.user_id INNER JOIN tbl_user as c on a.editbyid = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.is_delete = 0 AND a.is_active = 1 AND a.hotel_id = $hotel_id AND a.request_by = $employee ORDER BY 1 DESC";
}else{
    $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as fullname,concat(c.firstname,' ',c.lastname) as fullname_approved FROM `tbl_time_off` as a LEFT OUTER JOIN tbl_user as b on a.request_by = b.user_id INNER JOIN tbl_user as c on a.editbyid = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.is_delete = 0 AND a.is_active = 1 AND a.hotel_id = $hotel_id ORDER BY 1 DESC";
}

$res = $conn->query($sql);
$n=1;

$temp1 = "<table>
        <thead>
            <tr>
              <th>No</th>
                <th>RICHIESTA DA</th>
                <th>CATEGORIA</th>
                <th>DURATA</th>
                <th>DATE</th>
                <th>INIZIO</th>
                <th>FINE</th>
                <th>ORE TOTALI</th>
                <th>ROTTURA (MIN)</th>
                <th>STATO</th>
                <th>APPROVATO/RIFIUTATO DA</th>
                <th>TEMPO DI APPROVAZIONE/RIFIUTO</th>
            </tr>
        </thead>
        <tbody>";
$temp2="";
while ($row = mysqli_fetch_array($res)) {
    if($row['status'] == "PENDING"){
        $row['fullname_approved'] = "";
        $row['edittime'] = "";
    }
    if($row['request_by'] == 0){
        $row['fullname'] = "Tutti gli impiegati";
    }
    $temp2 .= '
    <tr>
                <td>'.$n.'</td>
                <td>'.$row['fullname'].'</td>
                <td>'.$row['category'].'</td>
                <td>'.$row['duration'].'</td>
                <td>'.$row['date'].'</td>
                <td>'.$row['start_time'].'</td>
                <td>'.$row['end_time'].'</td>
                <td>'.$row['total_hours'].'</td>
                <td>'.$row['shift_break'].'</td>
                <td>'.$row['status'].'</td>
                <td>'.$row['fullname_approved'].'</td>
                <td>'.$row['edittime'].'</td>
</tr>';

    $n++;
}

$temp3=" </tbody>
    </table>";

$temp4 = $temp1.$temp2.$temp3;


// Load HTML content 
$dompdf->loadHtml($temp4); 

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A3', 'landscape'); 

// Render the HTML as PDF 
$dompdf->render(); 

// Output the generated PDF to Browser 
$dompdf->stream();

?>