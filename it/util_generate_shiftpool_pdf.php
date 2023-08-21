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
if(isset($_GET['employee2'])){
    $employee2=$_GET['employee2'];
}
if(isset($_GET['hotel_id'])){
    $hotel_id=$_GET['hotel_id'];
}

if($employee != "0"){
    $sql = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time,concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_offer` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_by = $employee AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";

    $sql_t = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time, e.title as t, e.title_it as t_it, e.title_de as t_de,e.date as dt,e.start_time as st,e.end_time as et, concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_trade` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id INNER JOIN tbl_shifts as e on a.shift_to = e.sfs_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_by = $employee AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";
}else if($employee2 != "0"){
    $sql = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time,concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_offer` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_to = $employee2 AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";

    $sql_t = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time, e.title as t, e.title_it as t_it, e.title_de as t_de,e.date as dt,e.start_time as st,e.end_time as et, concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_trade` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id INNER JOIN tbl_shifts as e on a.shift_to = e.sfs_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND a.offer_to = $employee2 AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";
}else{
    $sql = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time,concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_offer` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";

    $sql_t = "SELECT a.*, b.title, b.title_it, b.title_de,b.date,b.start_time,b.end_time, e.title as t, e.title_it as t_it, e.title_de as t_de,e.date as dt,e.start_time as st,e.end_time as et, concat(c.firstname,' ',c.lastname) as offer_by, concat(d.firstname,' ',d.lastname) as offer_to FROM `tbl_shift_trade` as a INNER JOIN tbl_shifts as b on a.shift_offered = b.sfs_id INNER JOIN tbl_user as c on a.offer_by = c.user_id INNER JOIN tbl_user as d on a.offer_to = d.user_id INNER JOIN tbl_shifts as e on a.shift_to = e.sfs_id WHERE a.is_active = 1 AND a.hotel_id = $hotel_id AND (b.entrytime BETWEEN '$from_date' AND '$to_date') ORDER BY 1 DESC";
}

$res = $conn->query($sql);
$res2 = $conn->query($sql_t);
$n=1;

$temp11 = "
<h2>Turni offerti</h2>
<table>
        <thead>
            <tr>
                <th>No</th>
                <th>OFFERTA DI</th>
                <th>DATA OFFERTA</th>
                <th>OFFRIRE A</th>
                <th>TITOLO</th>
                <th>DATA DEL TURNO</th>
                <th>ORARIO INIZIO TURNO</th>
                <th>ORA FINE TURNO</th>
                <th>APPROVATO DAL DIPENDENTE</th>
                <th>APPROVATO DALL'ADMIN</th>
            </tr>
        </thead>
        <tbody>";
$temp22="";
while ($row = mysqli_fetch_array($res)) {
   if($row['is_approved_by_employee'] == "1"){
            $row['is_approved_by_employee'] = "SÌ";
        }else{
            $row['is_approved_by_employee'] = "NO";
        }
        if($row['is_approved_by_admin'] == "1"){
            $row['is_approved_by_admin'] = "SÌ";
        }else{
            $row['is_approved_by_admin'] = "NO";
        }
    $temp22 .= '
    <tr>
                <td>'.$n.'</td>
                <td>'.$row['offer_by'].'</td>
                <td>'.$row['entrytime'].'</td>
                <td>'.$row['offer_to'].'</td>
                <td>'.$row['title'].'</td>
                <td>'.$row['date'].'</td>
                <td>'.$row['start_time'].'</td>
                <td>'.$row['end_time'].'</td>
                <td>'.$row['is_approved_by_employee'].'</td>
                <td>'.$row['is_approved_by_admin'].'</td>
</tr>';

    $n++;
}

$n=1;
$temp33=" </tbody>
    </table> <br><br>";


$temp1 = "
<h2>Turni commerciali</h2>
<table>
        <thead>
            <tr>
                <th>No</th>
                <th>OFFERTA DI</th>
                <th>DATA OFFERTA</th>
                <th>TURNO OFFERTO</th>
                <th>DATA OFFERTA DEL TURNO</th>
                <th>TURNO OFFERTO ORA DI INIZIO</th>
                <th>ORARIO DI FINE DEL TURNO OFFERTO</th>
                <th>OFFRIRE A</th>
                <th>CAMBIO TURNO CON</th>
                <th>DATA DEL TURNO</th>
                <th>ORARIO INIZIO TURNO</th>
                <th>ORA FINE TURNO</th>
                <th>APPROVATO DAL DIPENDENTE</th>
                <th>APPROVATO DALL'ADMIN</th>
            </tr>
        </thead>
        <tbody>";
$temp2="";
while ($row2 = mysqli_fetch_array($res2)) {
    if($row2['is_approved_by_employee'] == "1"){
        $row2['is_approved_by_employee'] = "SÌ";
    }else{
        $row2['is_approved_by_employee'] = "NO";
    }
    if($row2['is_approved_by_admin'] == "1"){
        $row2['is_approved_by_admin'] = "SÌ";
    }else{
        $row2['is_approved_by_admin'] = "NO";
    }
    $temp2 .= '
    <tr>
                <td>'.$n.'</td>
                <td>'.$row2['offer_by'].'</td>
                <td>'.$row2['entrytime'].'</td>
                <td>'.$row2['title'].'</td>
                <td>'.$row2['date'].'</td>
                <td>'.$row2['start_time'].'</td>
                <td>'.$row2['end_time'].'</td>
                <td>'.$row2['offer_to'].'</td>
                <td>'.$row2['t'].'</td>
                <td>'.$row2['dt'].'</td>
                <td>'.$row2['st'].'</td>
                <td>'.$row2['et'].'</td>
                <td>'.$row2['is_approved_by_employee'].'</td>
                <td>'.$row2['is_approved_by_admin'].'</td>
</tr>';

    $n++;
}

$temp3=" </tbody>
    </table>";

$temp4 = $temp11.$temp22.$temp33.$temp1.$temp2.$temp3;


// Load HTML content 
$dompdf->loadHtml($temp4); 

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A3', 'landscape'); 

// Render the HTML as PDF 
$dompdf->render(); 

// Output the generated PDF to Browser 
$dompdf->stream();

?>