<?php
include 'util_config.php';
include '../util_session.php';

$from_date = "";
$to_date = "";
$employee = "";
$export_type = "";
$completed = "";

if(isset($_GET['from_date'])){
    $from_date=date("Y-m-d", strtotime($_GET['from_date']));
}
if(isset($_GET['to_date'])){
    $to_date=date("Y-m-d", strtotime($_GET['to_date']));
}
if(isset($_GET['employee'])){
    $employee=$_GET['employee'];
}
if(isset($_GET['export_type'])){
    $export_type=$_GET['export_type'];
}
if(isset($_GET['hotel_id'])){
    $hotel_id=$_GET['hotel_id'];
}

if($employee != "0"){
    $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.assign_to = $employee ORDER BY b.firstname ASC, a.assign_to";
}else{
    $sql = "SELECT a.*,b.firstname,b.lastname,c.wage_type,c.wage,d.department_name,d.department_name_it,d.department_name_de FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id INNER JOIN tbl_department as d on b.depart_id = d.depart_id LEFT OUTER JOIN tbl_employee_additional_data as c on a.assign_to = c.user_id WHERE (a.date BETWEEN '$from_date' AND '$to_date') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 ORDER BY b.firstname ASC, a.assign_to";
}

$fields = array('No', 'NOME DIPENDENTE','DIPARTIMENTO', 'TITOLO DEL CAMBIO', 'DATE', 'ORA DI INIZIO', 'TEMPO SCADUTO', 'ORE TOTALI','ROTTURA (MIN)', 'TURNO COMPLETATO', 'SALARIO ORARIO','TIPO DI SALARIO', 'SALARIO TOTALE'); 

if($export_type == "CSV"){

    $filename = "employee-timesheet_" . $from_date . " - ". $to_date. " _ ". strtotime("now") .".csv"; 
    $delimiter = ","; 
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // Set column headers 
    fputcsv($f, $fields, $delimiter); 

    $n=1;
    $grand_total_hours = 0;
    $grand_total_wage = 0;
    $prev_id = 0;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            if($row['is_completed'] == 1){
                $completed = "SÌ";
            }else{
                $completed = "No";
            }
            $lineData = array($n, $row['firstname'].' '.$row['lastname'], $row['department_name'], $row['title'], $row['date'], $row['start_time'], $row['end_time'], $row['total_hours'], $row['shift_break'],$completed, $row['wage'], $row['wage_type'], $row['wage']*$row['total_hours']); 

            if($n == 1){
                $prev_id = $row['assign_to'];
            }
            if($prev_id != $row['assign_to']){
                $lineData = array("","", "", "", "", "", "Grand Total", $grand_total_hours,"", "", "", $grand_total_wage);

                fputcsv($f, $lineData, $delimiter); 

                $lineData = array($n, $row['firstname'].' '.$row['lastname'], $row['department_name'], $row['title'], $row['date'], $row['start_time'], $row['end_time'], $row['total_hours'],$row['shift_break'], $completed, $row['wage'], $row['wage_type'], $row['wage']*$row['total_hours']); 

                $grand_total_hours = 0;
                $grand_total_wage = 0;
                $prev_id = $row['assign_to'];
            }
            $grand_total_hours +=  $row['total_hours'];
            $grand_total_wage +=  $row['wage']*$row['total_hours'];

            $n++;
            fputcsv($f, $lineData, $delimiter); 
        }
        $lineData = array("","", "", "", "", "", "Somma totale", $grand_total_hours, "", "","", $grand_total_wage);

        fputcsv($f, $lineData, $delimiter); 
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
        if($row['is_completed'] == 1){
            $completed = "SÌ";
        }else{
            $completed = "No";
        }
        $lineData = array($n, $row['firstname'].' '.$row['lastname'], $row['department_name'], $row['title'], $row['date'], $row['start_time'], $row['end_time'], $row['total_hours'],$row['shift_break'], $completed, $row['wage'], $row['wage_type'], $row['wage']*$row['total_hours']);

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
        if($row['is_completed'] == 1){
            $completed = "SÌ";
        }else{
            $completed = "No";
        }

        $lineData[] = array('No' => $n,'NOME DIPENDENTE' => $row['firstname'].' '.$row['lastname'],'DIPARTIMENTO' => $row['department_name'],'TITOLO DEL CAMBIO' => $row['title'],'DATE' => $row['date'],'ORA DI INIZIO' => $row['start_time'],'TEMPO SCADUTO' => $row['end_time'],'ORE TOTALI' => $row['total_hours'],'ROTTURA (MIN)' =>$row['shift_break'], 'TURNO COMPLETATO' => $completed,'SALARIO ORARIO' => $row['wage'],'TIPO DI SALARIO' => $row['wage_type'],'SALARIO TOTALE' => $row['wage']*$row['total_hours']);

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
    <h3 class="display_flex_div pr-3 pl-3 pt-3"><b style="cursor:pointer;" onclick="location.href = 'reports.php';">Indietro</b><button type="button" onclick="window.print();" class="btn btn-success f-right"><i class="fas fa-plus"></i> Stampa</button></h3>
    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
        <thead>
            <tr>
                <th class="">No</th>
                <th class="">NOME DIPENDENTE</th>
                <th class="">DIPARTIMENTO</th>
                <th class="">TITOLO DEL CAMBIO</th>
                <th class="">DATE</th>
                <th class="">ORA DI INIZIO</th>
                <th class="">TEMPO SCADUTO</th>
                <th class="">ORE TOTALI</th>
                <th class="">ROTTURA (MIN)</th>
                <th class="">TURNO COMPLETATO</th>
                <th class="">SALARIO ORARIO</th>
                <th class="">TIPO DI SALARIO</th>
                <th class="">SALARIO TOTALE</th>
            </tr>
        </thead>
        <tbody>
            <?php
    while ($row = mysqli_fetch_array($res)) {
        if($row['is_completed'] == 1){
            $completed = "SÌ";
        }else{
            $completed = "No";
        }
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
                <td><?php echo $completed; ?></td>
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
    header("Location: util_generate_timesheet_pdf.php?from_date=".$from_date."&to_date=".$to_date."&employee=".$employee."&hotel_id=".$hotel_id);
}
?>