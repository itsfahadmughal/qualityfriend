<?php
include 'util_config.php';
include '../util_session.php';

$date_selected = date('m/d/Y');

$view_selected = "";
$depart = "";
if (isset($_GET['date'])) {
    $date_selected = $_GET['date'];
}
if (isset($_GET['slug'])) {
    $view_selected = $_GET['slug'];
}
if (isset($_GET['department'])) {
    $depart = $_GET['department'];
}

$date_ = strtotime($date_selected);


if($view_selected == "week"){
    $date_ = strtotime("+6 day", $date_);
}else if($view_selected == "month"){
    $date_ = strtotime("+30 day", $date_);
}else{
    $temp = strtotime("-30 day", strtotime($date_selected));
    $date_selected = date('m/d/Y', $temp);
    $date_ = $date_;
}
$end_date = date('m/d/Y', $date_);


$array_week_dates = array();

$Variable1 = strtotime($date_selected);
$Variable2 = strtotime($end_date);

for (
    $currentDate = $Variable1;
    $currentDate <= $Variable2;
    $currentDate += (86400)
) {

    $Store = date('Y-m-d', $currentDate);
    $array_week_dates[] = $Store;
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Statistiche</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />



        <!-- Date picker plugins css -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

        <!-- Multiple Select -->
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/time_schedule.css" rel="stylesheet">



    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Statistiche</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <?php include 'util_header.php'; ?>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <?php include 'util_side_nav.php'; ?>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid pb-0 mobile-container-padding">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles heading_style">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Statistiche</h4>
                        </div>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row pl-4 pr-4">

                    <div class="col-lg-3 align-self-center">
                        <div class="input-group">
                            <input type="text" value="<?php echo $date_selected; ?>" onchange="date_changed();" class="form-control " id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                            <input type="text" disabled class="form-control bg-white" value="<?php echo $end_date; ?>" id="endDate" placeholder="mm/dd/yyyy">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-calender"></i></span>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-3 mtm-10">

                        <select id="template" onchange="depart_changed();" class="select2 form-control custom-select">
                            <option value="0">Tutti i Dipartimenti</option>
                            <?php
                            $sql = "SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($row[2] != "") {
                                        $title = $row[2];
                                    }else if($row[1] != ""){
                                        $title = $row[1];
                                    }else{
                                        $title = $row[3];
                                    }

                            ?>
                            <option <?php if($depart == $row[0]){echo 'selected';}else{echo '';} ?> value='<?php echo $row[0]; ?>'><?php echo $title; ?></option>
                            <?php
                                }
                            }
                            ?>

                        </select>

                    </div>

                    <div class="col-lg-3"></div>

                    <div class="col-lg-3 align-self-center text-right mtm-10">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="week_sort_btn" onclick="change_sort('week');" class="btn btn-<?php if($view_selected == 'week'){echo 'secondary';}else{echo 'light';} ?>">Settimana</button>
                            <button type="button" id="day_sort_btn" onclick="change_sort('month');" class="btn btn-<?php if($view_selected == 'month'){echo 'secondary';}else if($view_selected == ""){ echo 'secondary'; }else{echo 'light';} ?>">Mese</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-4">

                    <div class="row pm-2rem">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10 border_style_engage">
                            <div class="text-center w-24 wm-50 pt-4 pb-4 display-inline">
                                <?php
                                $ds = date("Y-m-d", strtotime($date_selected));
                                $de = date("Y-m-d", strtotime($end_date));

                                if($depart == 0){
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";
                                }else{
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";
                                }
                                $result_most = $conn->query($sql_most);
                                if ($result_most && $result_most->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result_most)) {
                                ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-1 text-uppercase"><?php echo substr($row['fullname'],0,1); ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-success"><b>Più affidabile </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee with the best weekly shift coverage. This employee has the least 'no shows' and is the most punctual for given time period."></i></h4>
                                <span><?php echo $row['fullname']; ?></span>
                                <?php } }else{ ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-1 text-uppercase"><?php echo 'N'; ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-success"><b>Più affidabile </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee with the best weekly shift coverage. This employee has the least 'no shows' and is the most punctual for given time period."></i></h4>
                                <span><?php echo 'N/A'; ?></span>
                                <?php } ?>
                            </div>
                            <div class="text-center w-25 wm-50 pt-3 pb-3 display-inline">
                                <?php
                                if($depart == 0){
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";
                                }else{
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";
                                }
                                $result_most = $conn->query($sql_most);
                                if ($result_most && $result_most->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result_most)) {
                                ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-6 text-uppercase"><?php echo substr($row['fullname'],0,1); ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-danger"><b>Molto desideroso </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee who has bid on the most shifts in the Shift Pool for the given time period."></i></h4>
                                <span><?php echo $row['fullname']; ?></span>
                                <?php } }else{ ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-6 text-uppercase"><?php echo 'N'; ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-danger"><b>Molto desideroso </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee who has bid on the most shifts in the Shift Pool for the given time period."></i></h4>
                                <span><?php echo 'N/A'; ?></span>
                                <?php } ?>
                            </div>
                            <div class="text-center w-25 wm-50 pt-3 pb-3 display-inline">
                                <?php
                                if($depart == 0){
                                    $sql_most = "SELECT a.request_by, COUNT(a.status),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.status = 'APPROVED' AND a.category = 'PAID_SICK' GROUP BY a.request_by ORDER BY COUNT(a.status) DESC LIMIT 1";
                                }else{
                                    $sql_most = "SELECT a.request_by, COUNT(a.status),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.status = 'APPROVED' AND a.category = 'PAID_SICK' AND b.depart_id = $depart GROUP BY a.request_by ORDER BY COUNT(a.status) DESC LIMIT 1";
                                }

                                $result_most = $conn->query($sql_most);
                                if ($result_most && $result_most->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result_most)) {
                                ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-7 text-uppercase"><?php echo substr($row['fullname'],0,1); ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-warning"><b>La maggior parte dei giorni di malattia </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee with the most Sick flags on a location's schedule for the given time period."></i></h4>
                                <span><?php echo $row['fullname']; ?></span>
                                <?php } }else{ ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-7 text-uppercase"><?php echo 'N'; ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-warning"><b>La maggior parte dei giorni di malattia </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee with the most Sick flags on a location's schedule for the given time period."></i></h4>
                                <span><?php echo 'N/A'; ?></span>
                                <?php } ?>
                            </div>
                            <div class="text-center w-25 wm-50 pt-3 pb-3 display-inline">
                                <?php
                                if($depart == 0){
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";
                                }else{
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed),concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC LIMIT 1";
                                }
                                $result_most = $conn->query($sql_most);
                                if ($result_most && $result_most->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result_most)) {
                                ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-12"><?php echo substr($row['fullname'],0,1); ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-dark"><b>La maggior parte dei turni abbandonati </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee who has dropped the most shifts in the given time period."></i></h4>
                                <span><?php echo $row['fullname']; ?></span>
                                <?php } }else{ ?>
                                <div class="w-100">
                                    <div class="circle-engage circle-color-12"><?php echo 'N'; ?></div>
                                </div>
                                <h4 class="mt-2 mb-0 text-dark"><b>La maggior parte dei turni abbandonati </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The employee who has dropped the most shifts in the given time period."></i></h4>
                                <span><?php echo 'N/A'; ?></span>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-2 pl-0 prm-0px">
                            <div class="mt-3 border_style_engage p-3">
                                <h4 class="mt-2 mb-0 text-dark"><b>Media Sposta il punteggio </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The average Score collected from Shift Feedback surverys."></i></h4>

                                <?php
                                if($depart == 0){
                                    $sql_most = "SELECT COUNT(is_completed) as completed FROM `tbl_shifts` WHERE (date BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 AND is_completed = 1";
                                    $sql_most2 = "SELECT COUNT(is_completed) as not_completed FROM `tbl_shifts` WHERE (date BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 AND is_completed = 0";
                                }else{
                                    $sql_most = "SELECT COUNT(a.is_completed) as completed FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 AND b.depart_id = $depart";

                                    $sql_most2 = "SELECT COUNT(a.is_completed) as not_completed FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart";
                                }
                                $result_most = $conn->query($sql_most);
                                $result_most2 = $conn->query($sql_most2);
                                $row2 = mysqli_fetch_array($result_most2);
                                while ($row = mysqli_fetch_array($result_most)) { 
                                    $total = $row['completed'] + $row2['not_completed'];
                                    $avg_completed = 0;
                                    if($total != 0){
                                        $avg_completed = round($row['completed'] / $total,2);
                                    }
                                    if($avg_completed > 4){
                                ?>
                                <i class="fas fa-smile emoji-color"></i>
                                <?php 
                                    }else{
                                ?>
                                <i class="fas fa-frown emoji-color emoji-size"></i>
                                <?php } ?>
                                <h2 class="display-inline pl-2">
                                    <?php echo $avg_completed; ?>
                                </h2>
                                <?php
                                }
                                ?>
                                <br>
                                <small>
                                    <i class="fas fa-long-arrow-alt-down text-danger"></i>
                                    <!-- <i class="fas fa-long-arrow-alt-up text-success"></i>  -->
                                    0.8 precedente</small>
                                <br><br>
                                <a href="my_schedules.php">Visualizza Turni</a>

                            </div>

                            <div class="mt-5 border_style_engage p-3">
                                <h4 class="mt-2 text-dark"><b>Media Possesso </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The average time collected from Shift Feedback surverys."></i></h4>

                                <i class="far fa-calendar-alt emoji-size"></i>
                                <h1 class="display-inline pl-2 text-success"><?php
                                    echo rand(280,320);
                                    ?> </h1>
                                <h3 class="display-inline text-success">Giorni</h3>

                            </div>

                        </div>
                        <div class="col-lg-4 mb-3 prlm-0px">
                            <div class="mt-3 border_style_engage h-100">
                                <h4 class="mt-2 mb-0 p-3 text-dark"><b>I più impegnati </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="These are your most engaged employees, determined by several factors including punctuality, shift bids, and dropped shifts."></i></h4>

                                <?php
                                if($depart == 0){
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed) as ss,concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC";
                                }else{
                                    $sql_most = "SELECT a.assign_to, COUNT(a.is_completed) as ss,concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 1 AND b.depart_id = $depart GROUP BY a.assign_to ORDER BY COUNT(a.is_completed) DESC";
                                }
                                $result_most = $conn->query($sql_most);
                                if ($result_most && $result_most->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result_most)) {
                                        if($row['ss'] > 1){
                                ?>
                                <div class="pt-2 pb-2 border-top-engaged row ml-0 mr-0">
                                    <div class="col-lg-6">
                                        <div class="circle circle-color-3"><?php echo substr($row['fullname'],0,1); ?></div>
                                        <h4 class="mt-2"><?php echo $row['fullname']; ?></h4>
                                    </div>
                                    <div class="col-lg-6 text-right mt-2"><span class="text-success">Highly Engaged</span></div>
                                </div>
                                <?php } } }else{ echo '<h2 class="text-dark ml-5 mt-2">N/A</h2>'; } ?>
                            </div>
                        </div>
                        <div class="col-lg-4 pr-0 mb-3 plm-0">
                            <div class="mt-3 border_style_engage h-100">
                                <h4 class="mt-2 mb-0 p-3 text-dark"><b>Tasso di coinvolgimento </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="These are your least enganged employees, determined by several factors including punctuality, shift bids, and dropped shifts."></i></h4>

                                <div class="text-center">
                                    <input data-plugin="knob" data-width="220" data-height="220" data-linecap=round data-fgColor="#01c0c8" value="<?php echo $avg_completed*100; ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".3" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>

                    <div class="row mt-4 mb-5 pm-2rem mtm-0 mbm-0">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10 border_style_engage">
                            <div class="text-center w-24 wm-50 pt-4 pb-4 display-inline">
                                <h4 class="mt-2 text-dark"><b>Niente spettacoli </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The number of occurences where an employee was scheduled for a shift and did not show up."></i></h4>
                                <h1><?php
                                    if($depart == 0){
                                        $sql_most = "SELECT COUNT(is_completed) as ss FROM `tbl_shifts` WHERE (date BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 AND is_completed = 0";
                                    }else{
                                        $sql_most = "SELECT COUNT(a.is_completed) as ss FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.is_completed = 0 AND b.depart_id = $depart";
                                    }
                                    $result_most = $conn->query($sql_most);
                                    if ($result_most && $result_most->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_most)) { 
                                            echo $row['ss'];
                                        }
                                    }
                                    ?></h1>
                                <small>
                                    <i class="fas fa-long-arrow-alt-down text-danger"></i>
                                    <!-- <i class="fas fa-long-arrow-alt-up text-success"></i>  -->
                                    2 precedente</small>
                            </div>
                            <div class="text-center w-25 wm-50 pt-3 pb-3 display-inline">
                                <h4 class="mt-2 text-warning"><b>Malattia </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The number of shifts in the given time period where the `Sick` shift flag was applied."></i></h4>
                                <h1><?php
                                    if($depart == 0){
                                        $sql_most = "SELECT COUNT(a.status) as ss FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category = 'PAID_SICK'";
                                    }else{
                                        $sql_most = "SELECT COUNT(a.status) as ss FROM `tbl_time_off` as a INNER JOIN tbl_user as b on a.request_by = b.user_id WHERE (a.date BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category = 'PAID_SICK' AND b.depart_id = $depart";
                                    }
                                    $result_most = $conn->query($sql_most);
                                    if ($result_most && $result_most->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_most)) {
                                            echo $row['ss'];
                                        } 
                                    }
                                    ?></h1>
                                <small>
                                    <!-- <i class="fas fa-long-arrow-alt-down text-danger"></i> -->
                                    <i class="fas fa-long-arrow-alt-up text-success"></i>
                                    11 precedente
                                </small>
                            </div>
                            <div class="text-center w-25 wm-50 pt-3 pb-3 display-inline">
                                <h4 class="mt-2 text-cyan"><b>Shift Bids </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The total number of shift bids that occurred in the shift Pool over the given time period."></i></h4>
                                <h1><?php
                                    if($depart == 0){
                                        $sql_most = "SELECT COUNT(sftou_id) as ss FROM `tbl_shift_offer` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1";
                                        $sql_most2 = "SELECT COUNT(sfttrd_id) as ss FROM `tbl_shift_trade` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND is_active = 1";
                                    }else{
                                        $sql_most = "SELECT COUNT(a.sftou_id) as ss FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND b.depart_id = $depart ";
                                        $sql_most2 = "SELECT COUNT(a.sfttrd_id) as ss FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND b.depart_id = $depart ";
                                    }
                                    $result_most = $conn->query($sql_most);
                                    $result_most2 = $conn->query($sql_most2);
                                    $row2 = mysqli_fetch_array($result_most2);
                                    if ($result_most && $result_most->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_most)) {
                                            echo $row['ss'] + $row2['ss'];
                                        }
                                    }
                                    ?></h1>
                                <small>
                                    <!-- <i class="fas fa-long-arrow-alt-down text-danger"></i> -->
                                    <i class="fas fa-long-arrow-alt-up text-success"></i>
                                    2 precedente
                                </small>
                            </div>
                            <div class="text-center w-25 wm-50 pt-3 pb-3 display-inline">
                                <h4 class="mt-2 text-danger"><b>Dropped Shifts </b><i class="far fa-question-circle" data-toggle="tooltip" data-original-title="The total number of shifts dropped in the Shift Pool over the given time period."></i></h4>
                                <h1><?php
                                    if($depart == 0){
                                        $sql_most = "SELECT COUNT(sftou_id) as ss FROM `tbl_shift_offer` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND (is_approved_by_employee = 0 OR is_approved_by_admin = 0) AND is_active = 1";
                                        $sql_most2 = "SELECT COUNT(sfttrd_id) as ss FROM `tbl_shift_trade` WHERE (entrytime BETWEEN '$ds' AND '$de') AND hotel_id = $hotel_id AND (is_approved_by_employee = 0 OR is_approved_by_admin = 0) AND is_active = 1";
                                    }else{
                                        $sql_most = "SELECT COUNT(a.sftou_id) as ss FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND (a.is_approved_by_employee = 0 OR a.is_approved_by_admin = 0) AND b.depart_id = $depart ";
                                        $sql_most2 = "SELECT COUNT(a.sfttrd_id) as ss FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_to = b.user_id WHERE (a.entrytime BETWEEN '$ds' AND '$de') AND a.hotel_id = $hotel_id AND a.is_active = 1 AND (a.is_approved_by_employee = 0 OR a.is_approved_by_admin = 0) AND b.depart_id = $depart ";
                                    }
                                    $result_most = $conn->query($sql_most);
                                    $result_most2 = $conn->query($sql_most2);
                                    $row2 = mysqli_fetch_array($result_most2);
                                    if ($result_most && $result_most->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result_most)) {
                                            echo $row['ss'] + $row2['ss'];
                                        }
                                    }
                                    ?></h1>
                                <small>
                                    <i class="fas fa-long-arrow-alt-down text-danger"></i>
                                    <!-- <i class="fas fa-long-arrow-alt-up text-success"></i>  -->
                                    8 precedente</small>
                            </div>

                        </div>
                        <div class="col-lg-1"></div>
                    </div>


                </div>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php include 'util_right_nav.php'; ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include 'util_footer.php'; ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="../assets/node_modules/popper/popper.min.js"></script>
        <script src="../assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="../dist/js/perfect-scrollbar.jquery.min.js"></script>
        <!--Wave Effects -->
        <script src="../dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="../dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="../dist/js/custom.min.js"></script>
        <!-- Footable -->
        <script src="../assets/node_modules/moment/moment.js"></script>
        <script src="../assets/node_modules/footable/js/footable.min.js"></script>


        <!-- Date range picker -->
        <script src="../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <!-- Clock Plugin JavaScript -->
        <script src="../assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
        <!-- Color Picker Plugin JavaScript -->
        <script src="../assets/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
        <script src="../assets/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
        <script src="../assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
        <!-- Date Picker Plugin JavaScript -->
        <script src="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>


        <!-- Select2 Multi Select -->
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>


        <script>
            $(".select2").select2();
            // Date Picker
            jQuery('.mydatepicker, #datepicker').datepicker();
            jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            jQuery('#date-range').datepicker({
                toggleActive: true
            });
            jQuery('#datepicker-inline').datepicker({
                todayHighlight: true
            });

            var slug_table_view = '<?php echo $view_selected; ?>';
            if(slug_table_view == ''){
                slug_table_view = 'month';
            }

            function change_sort(slug) {
                var day = document.getElementById("day_sort_btn").classList;
                var week = document.getElementById("week_sort_btn").classList;
                slug_table_view = slug;
                if (slug == "month") {
                    day.remove("btn-light");
                    day.add("btn-secondary");
                    week.remove("btn-secondary");
                    week.add("btn-light");
                    $('#engage-month-view').show();
                    $('#engage-week-view').hide();
                } else if (slug == "week") {
                    week.remove("btn-light");
                    week.add("btn-secondary");
                    day.remove("btn-secondary");
                    day.add("btn-light");
                    $('#engage-month-view').hide();
                    $('#engage-week-view').show();
                }
                setTodayDate();
            }

            function setTodayDate() {

                var date = document.getElementById('datepicker-autoclose').value;

                var depart = $("#template").val();

                window.location.href = "engage.php?date=" + date + "&slug=" + slug_table_view + "&department="+depart;
            }

            function date_changed() {
                var date = document.getElementById('datepicker-autoclose').value;

                var depart = $("#template").val();

                window.location.href = "engage.php?date=" + date + "&slug=" + slug_table_view + "&department="+depart;
            }

            function depart_changed(){
                var date = document.getElementById('datepicker-autoclose').value;

                var depart = $("#template").val();

                window.location.href = "engage.php?date=" + date + "&slug=" + slug_table_view + "&department="+depart;
            }


        </script>

        <script src="../assets/node_modules/knob/jquery.knob.js"></script>
        <script>
            $(function() {
                $('[data-plugin="knob"]').knob();
            });
        </script>
    </body>

</html>