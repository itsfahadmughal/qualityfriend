<?php
include 'util_config.php';
include '../util_session.php';

$from_date = "";
$to_date = "";
$employee = "";
$employee2 = "";
$export_type = "";

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
if(isset($_GET['export_type'])){
    $export_type=$_GET['export_type'];
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

$fields = array('NEIN', 'ANGEBOT DURCH','ANGEBOTENES DATUM','ANGEBOT FÜR', 'Schicht angeboten', 'SCHICHTDATUM', 'STARTZEIT DER SCHICHT', 'SCHICHTENDZEIT', 'VOM MITARBEITER GENEHMIGT', 'VOM ADMIN GENEHMIGT'); 

$fields2 = array('NEIN', 'ANGEBOT DURCH','ANGEBOTENES DATUM', 'Schicht angeboten', 'VERSCHIEBUNG DES ANGEBOTENEN TERMINS', 'Schicht angebotene Startzeit', 'ENDZEIT DER ANGEBOTENEN SCHICHT', 'ANGEBOT FÜR', 'Schichtwechsel mit', 'SCHICHTDATUM', 'STARTZEIT DER SCHICHT', 'SCHICHTENDZEIT', 'VOM MITARBEITER GENEHMIGT', 'VOM ADMIN GENEHMIGT'); 
$empty = array('SHIFT TRADE UNTEN', ' ',' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '); 

if($export_type == "CSV"){

    $filename = "employee-timeoff_" . $from_date . " - ". $to_date. " _ ". strtotime("now") .".csv"; 
    $delimiter = ","; 
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // Set column headers 
    fputcsv($f, $fields, $delimiter); 

    $n=1;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            if($row['is_approved_by_employee'] == "1"){
                $row['is_approved_by_employee'] = "JA";
            }else{
                $row['is_approved_by_employee'] = "NEIN";
            }
            if($row['is_approved_by_admin'] == "1"){
                $row['is_approved_by_admin'] = "JA";
            }else{
                $row['is_approved_by_admin'] = "NEIN";
            }
            $lineData = array($n, $row['offer_by'],$row['entrytime'], $row['offer_to'], $row['title'], $row['date'], $row['start_time'], $row['end_time'], $row['is_approved_by_employee'], $row['is_approved_by_admin']); 

            $n++;
            fputcsv($f, $lineData, $delimiter); 
        }
    }
    fputcsv($f, $empty, $delimiter); 

    fputcsv($f, $fields2, $delimiter); 

    $n=1;
    $result2 = $conn->query($sql_t);
    if ($result2 && $result2->num_rows > 0) {
        while($row2 = mysqli_fetch_array($result2)) {
            if($row2['is_approved_by_employee'] == "1"){
                $row2['is_approved_by_employee'] = "JA";
            }else{
                $row2['is_approved_by_employee'] = "NEIN";
            }
            if($row2['is_approved_by_admin'] == "1"){
                $row2['is_approved_by_admin'] = "JA";
            }else{
                $row2['is_approved_by_admin'] = "NEIN";
            }
            $lineData = array($n, $row2['offer_by'],$row2['entrytime'], $row2['title'], $row2['date'], $row2['start_time'], $row2['end_time'], $row2['offer_to'], $row2['t'], $row2['dt'], $row2['st'], $row2['et'], $row2['is_approved_by_employee'], $row2['is_approved_by_admin']); 

            $n++;
            fputcsv($f, $lineData, $delimiter); 
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
    $file = "employee-timeoff_file.txt";
    $F = fopen($file , 'w');   // open for write
    $delim = "\t";   // set delim, eg tab
    $res = $conn->query($sql);
    fwrite($F, join($delim, $fields) . "\n\n");
    $n=1;
    while ($row = mysqli_fetch_array($res)) {
        if($row['is_approved_by_employee'] == "1"){
            $row['is_approved_by_employee'] = "JA";
        }else{
            $row['is_approved_by_employee'] = "NEIN";
        }
        if($row['is_approved_by_admin'] == "1"){
            $row['is_approved_by_admin'] = "JA";
        }else{
            $row['is_approved_by_admin'] = "NEIN";
        }
        $lineData = array($n, $row['offer_by'],$row['entrytime'], $row['offer_to'], $row['title'], $row['date'], $row['start_time'], $row['end_time'], $row['is_approved_by_employee'], $row['is_approved_by_admin']); 

        fwrite($F, join($delim, $lineData) . "\n");
        $n++;
    }

    fwrite($F, "\n\n\n".join($delim, $empty) . "\n");
    fwrite($F, join($delim, $fields2) . "\n\n");
    $n=1;
    $res2 = $conn->query($sql_t);
    while ($row2 = mysqli_fetch_array($res2)) {
        if($row2['is_approved_by_employee'] == "1"){
            $row2['is_approved_by_employee'] = "JA";
        }else{
            $row2['is_approved_by_employee'] = "NEIN";
        }
        if($row2['is_approved_by_admin'] == "1"){
            $row2['is_approved_by_admin'] = "JA";
        }else{
            $row2['is_approved_by_admin'] = "NEIN";
        }
        $lineData = array($n, $row2['offer_by'],$row2['entrytime'], $row2['title'], $row2['date'], $row2['start_time'], $row2['end_time'], $row2['offer_to'], $row2['t'], $row2['dt'], $row2['st'], $row2['et'], $row2['is_approved_by_employee'], $row2['is_approved_by_admin']); 

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
    $vExcelFileName="employee-timeoff". ".doc"; //replace your file name from here.

    header("Content-type: application/x-ms-download"); //#-- build header to download the word file 
    header("Content-Disposition: attachment; filename=$vExcelFileName"); 
    header('Cache-Control: public'); 

    $res = $conn->query($sql);
    $lineData[] = array("OFFERED SHIFTS" => 'JA');
    $n=1;
    while ($row = mysqli_fetch_array($res)) {
        if($row['is_approved_by_employee'] == "1"){
            $row['is_approved_by_employee'] = "JA";
        }else{
            $row['is_approved_by_employee'] = "NEIN";
        }
        if($row['is_approved_by_admin'] == "1"){
            $row['is_approved_by_admin'] = "JA";
        }else{
            $row['is_approved_by_admin'] = "NEIN";
        }

        $lineData[] = array('No' => $n,'OFFER BY' => $row['offer_by'],'OFFERED DATE' => $row['entrytime'],'OFFER TO' => $row['offer_to'],'TITLE' => $row['title'],'DATE' => $row['date'],'START TIME' => $row['start_time'],'END TIME' => $row['end_time'],'APPROVED BY EMPLOYEE' => $row['is_approved_by_employee'], 'APPROVED BY ADMIN' => $row['is_approved_by_admin']);

        $n++;
    }
    $lineData[] = array("TRADE SHIFTS" => 'JA');
    $res2 = $conn->query($sql_t);
    $n=1;
    while ($row2 = mysqli_fetch_array($res2)) {
        if($row2['is_approved_by_employee'] == "1"){
            $row2['is_approved_by_employee'] = "JA";
        }else{
            $row2['is_approved_by_employee'] = "NEIN";
        }
        if($row2['is_approved_by_admin'] == "1"){
            $row2['is_approved_by_admin'] = "JA";
        }else{
            $row2['is_approved_by_admin'] = "NEIN";
        }
        $lineData[] = array('No' => $n,'OFFER BY' => $row2['offer_by'],'OFFERED DATE' => $row2['entrytime'],'SHIFT OFFERED' => $row2['title'],'SHIFT OFFERED DATE' => $row2['date'],'SHIFT OFFERED START TIME' => $row2['start_time'],'SHIFT OFFERED END TIME' => $row2['end_time'],'OFFER TO' => $row2['offer_to'],'SHIFT EXCHANGE WITH' => $row2['t'],'SHIFT DATE' => $row2['dt'],'SHIFT START TIME' => $row2['st'],'SHIFT END TIME' => $row2['et'],'APPROVED BY EMPLOYEE' => $row2['is_approved_by_employee'], 'APPROVED BY ADMIN' => $row2['is_approved_by_admin']);

        $n++;
    }

    $json = json_encode($lineData, JSON_PRETTY_PRINT);
    echo $json;
    exit;
}else if($export_type == "WEB"){
    $res = $conn->query($sql);
    $res2 = $conn->query($sql_t);
    $n=1;

?>

<link href="./dist/css/time_schedule.css" rel="stylesheet">
<div class="table-responsive">
    <h3 class="display_flex_div pr-3 pl-3 pt-3"><b style="cursor:pointer;" onclick="location.href = 'reports.php';">Zurück</b><button type="button" onclick="window.print();" class="btn btn-success f-right"><i class="fas fa-plus"></i> Drucken</button></h3>
     <h3>Angebotene Schichten</h3>
    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
        <thead>
            <tr>
                <th class="">NEIN</th>
                <th class="">ANGEBOT DURCH</th>
                <th class="">ANGEBOTENES DATUM</th>
                <th class="">ANGEBOT FÜR</th>
                <th class="">TITEL</th>
                <th class="">SCHICHTDATUM</th>
                <th class="">STARTZEIT DER SCHICHT</th>
                <th class="">SCHICHTENDZEIT</th>
                <th class="">VOM MITARBEITER GENEHMIGT</th>
                <th class="">VOM ADMIN GENEHMIGT</th>
            </tr>
        </thead>
        <tbody>
            <?php
    while ($row = mysqli_fetch_array($res)) {
        if($row['is_approved_by_employee'] == "1"){
            $row['is_approved_by_employee'] = "JA";
        }else{
            $row['is_approved_by_employee'] = "NEIN";
        }
        if($row['is_approved_by_admin'] == "1"){
            $row['is_approved_by_admin'] = "JA";
        }else{
            $row['is_approved_by_admin'] = "NEIN";
        }
            ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row['offer_by']; ?></td>
                <td><?php echo $row['entrytime']; ?></td>
                <td><?php echo $row['offer_to']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['start_time']; ?></td>
                <td><?php echo $row['end_time']; ?></td>
                <td><?php echo $row['is_approved_by_employee']; ?></td>
                <td><?php echo $row['is_approved_by_admin']; ?></td>
            </tr>
            <?php 
        $n++;
    }    
    $n=1;
            ?>
        </tbody>
    </table>
</div>
<br>
<br>
<div class="table-responsive">
    <h3>Handelsverschiebungen</h3>
    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
        <thead>
            <tr>
                <th class="">NEIN</th>
                <th class="">ANGEBOT DURCH</th>
                <th class="">ANGEBOTENES DATUM</th>
                <th class="">Schicht angeboten</th>
                <th class="">VERSCHIEBUNG DES ANGEBOTENEN TERMINS</th>
                <th class="">Schicht angebotene Startzeit</th>
                <th class="">ENDZEIT DER ANGEBOTENEN SCHICHT</th>
                <th class="">ANGEBOT FÜR</th>
                <th class="">Schichtwechsel mit</th>
                <th class="">SCHICHTDATUM</th>
                <th class="">STARTZEIT DER SCHICHT</th>
                <th class="">SCHICHTENDZEIT</th>
                <th class="">VOM MITARBEITER GENEHMIGT</th>
                <th class="">VOM ADMIN GENEHMIGT</th>
            </tr>
        </thead>
        <tbody>
            <?php
    while ($row2 = mysqli_fetch_array($res2)) {
        if($row2['is_approved_by_employee'] == "1"){
            $row2['is_approved_by_employee'] = "JA";
        }else{
            $row2['is_approved_by_employee'] = "NEIN";
        }
        if($row2['is_approved_by_admin'] == "1"){
            $row2['is_approved_by_admin'] = "JA";
        }else{
            $row2['is_approved_by_admin'] = "NEIN";
        }
            ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row2['offer_by']; ?></td>
                <td><?php echo $row2['entrytime']; ?></td>
                <td><?php echo $row2['title']; ?></td>
                <td><?php echo $row2['date']; ?></td>
                <td><?php echo $row2['start_time']; ?></td>
                <td><?php echo $row2['end_time']; ?></td>
                <td><?php echo $row2['offer_to']; ?></td>
                <td><?php echo $row2['t']; ?></td>
                <td><?php echo $row2['dt']; ?></td>
                <td><?php echo $row2['st']; ?></td>
                <td><?php echo $row2['et']; ?></td>
                <td><?php echo $row2['is_approved_by_employee']; ?></td>
                <td><?php echo $row2['is_approved_by_admin']; ?></td>
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
    header("Location: util_generate_shiftpool_pdf.php?from_date=".$from_date."&to_date=".$to_date."&employee=".$employee."&employee2=".$employee2."&hotel_id=".$hotel_id);
}
?>