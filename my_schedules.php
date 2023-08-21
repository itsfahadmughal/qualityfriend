<?php
include 'util_config.php';
include 'util_session.php';

$date_selected = date("m/d/Y");
$view_selected = "";
$view_filter_selected="";
if (isset($_GET['date'])) {
    $date_selected = $_GET['date'];
}
if (isset($_GET['slug'])) {
    $view_selected = $_GET['slug'];
}
if (isset($_GET['filter'])) {
    $view_filter_selected = $_GET['filter'];
}

$date_ = strtotime($date_selected);
$date_ = strtotime("+7 day", $date_);
$end_date = date('m/d/Y', $date_);

$array_week_dates = array();

$Variable1 = strtotime($date_selected);
$Variable2 = strtotime($end_date);

$period = new DatePeriod(
    new DateTime($date_selected),
    new DateInterval('P1D'),
    new DateTime($end_date)
);

foreach ($period as $key => $value) {
    $array_week_dates[] = $value->format('Y-m-d');      
}


$sql_alert="UPDATE `tbl_alert` SET `is_viewed`='1' WHERE `user_id` = $user_id AND (`id_table_name` = 'tbl_shifts' OR `id_table_name` = 'tbl_shift_events') ";
$result_alert = $conn->query($sql_alert);

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
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
        <title>Schedules</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />



        <!-- Date picker plugins css -->
        <link href="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

        <!-- Multiple Select -->
        <link href="./assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />



        <link href="dist/css/style.min.css" rel="stylesheet">
        <link href="./dist/css/time_schedule.css" rel="stylesheet">



    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Schedules</p>
            </div>
        </div>

        <div id="responsive-modal-offer_up" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="display-inline text-left text-dark">Offer up shift</h3>
                        <button type="button" class="close" data-dismiss="modal" onclick="dismiss_modal();" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-3">
                                <span class="text-dark"><b>Offer up shift</b></span>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select id="select1" style="width:565px;" class="form-control custom-select">
                                            <option value="0">Select Employee</option>
                                            <?php 
                                            $sql="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                            $result = $conn->query($sql);
                                            if ($result && $result->num_rows > 0) {
                                                while($row = mysqli_fetch_array($result)) {
                                                    if($row[0] != $user_id){
                                                        $username = $row[2];
                                            ?>
                                            <option value='<?php echo $row[0]; ?>'><?php echo $username; ?></option>
                                            <?php     
                                                    }
                                                }   
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="text-dark"><b>Message to employee (optional)</b></span>
                                <textarea class="form-control" placeholder="Message" id="message-text"></textarea>
                            </div>
                            <div class="form-group">
                                <span>You will be notified when another co-worker takes your shift and its been approved by a manager. Until then, it is still your shift.</span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" onclick="dismiss_modal();" data-dismiss="modal">Cancel</button>
                        <button onclick="offer_shift_save();" type="button" class="btn btn-success waves-effect waves-light">Offer up</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="responsive-modal-trade" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="display-inline text-left text-dark">Trade shift</h3>
                        <button type="button" class="close" data-dismiss="modal" onclick="dismiss_modal_trade();" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-3">
                                <span class="text-dark"><b>Trade shift</b></span>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select id="select2" onchange="show_shifts_selected();" style="width:565px;" class="form-control custom-select">
                                            <option value="0">Select Employee</option>
                                            <?php 
                                            $sql="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                            $result = $conn->query($sql);
                                            if ($result && $result->num_rows > 0) {
                                                while($row = mysqli_fetch_array($result)) {
                                                    if($row[0] != $user_id){
                                                        $username = $row[2];
                                            ?>
                                            <option value='<?php echo $row[0]; ?>'><?php echo $username; ?></option>
                                            <?php     
                                                    }
                                                }   
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-4" id="result_shifts">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="text-dark"><b>Message to employee (optional)</b></span>
                                <textarea class="form-control" placeholder="Message" id="message-text-trade"></textarea>
                            </div>
                            <div class="form-group">
                                <span>You will be notified when another co-worker takes your shift and its been approved by a manager. Until then, it is still your shift.</span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" onclick="dismiss_modal_trade();" data-dismiss="modal">Cancel</button>
                        <button onclick="trade_shift_save();" type="button" class="btn btn-info waves-effect waves-light">Trade Shift</button>
                    </div>
                </div>
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
                <div id="my-header-fixed-1">
                    <!-- ============================================================== -->
                    <!-- Container fluid  -->
                    <!-- ============================================================== -->
                    <div class="container-fluid pb-0 mobile-container-padding">
                        <!-- ============================================================== -->
                        <!-- Bread crumb and right sidebar toggle -->
                        <!-- ============================================================== -->
                        <div class="row page-titles heading_style">
                            <div class="col-lg-5 align-self-center">
                                <h3>My Schedule</h3>
                            </div>

                            <div class="col-lg-3 align-self-center text-right">
                                <div class="input-group">
                                    <input type="text" value="<?php echo $date_selected; ?>" onchange="date_changed();" class="form-control " id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                    <input type="text" disabled class="form-control bg-white" value="<?php echo $end_date; ?>" id="endDate" placeholder="mm/dd/yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-1 align-self-center text-right mtm-10">
                                <button onclick="todayDate();" class="btn w-100 btn-secondary d-lg-block ">Today</button>
                            </div>

                            <div class="col-lg-3 align-self-center text-right mtm-10 mobile_text_center">
                                <div class="btn-group">
                                    <button type="button" onclick="print_schedule();" class="btn btn-lg" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                                <span id="all_filter" onclick="show_schedule_filter('all');" class="ml-3 mr-3 <?php if($view_filter_selected == "all" || $view_filter_selected == ""){ echo 'active_filter_schedule'; }else{echo '';} ?> cursor-pointer"><b>All</b></span>
                                <span id="upcomming_filter" onclick="show_schedule_filter('upcomming');" class="ml-3 mr-3 <?php if($view_filter_selected == "upcomming"){ echo 'active_filter_schedule'; }else{echo '';} ?> cursor-pointer"><b>Upcoming</b></span>
                                <span id="done_filter" onclick="show_schedule_filter('done');" class="ml-3 mr-3 <?php if($view_filter_selected == "done"){ echo 'active_filter_schedule'; }else{echo '';} ?> cursor-pointer"><b>Done</b></span>
                            </div>
                        </div>

                    </div>

                </div>

                <div id="my-header-fixed-2"></div>

                <div class="col-lg-12 mt-3 mb-4">


                    <table id="schedule-week-view">
                        <thead>
                            <tr>
                                <th class="empty_w"><h4 class="text-dark">Employees</h4></th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[0])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[0])) . ' ' . date('d', strtotime($array_week_dates[0])); ?></h5>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[1])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[1])) . ' ' . date('d', strtotime($array_week_dates[1])); ?></h5>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[2])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[2])) . ' ' . date('d', strtotime($array_week_dates[2])); ?></h5>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[3])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[3])) . ' ' . date('d', strtotime($array_week_dates[3])); ?></h5>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[4])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[4])) . ' ' . date('d', strtotime($array_week_dates[4])); ?></h5>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[5])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[5])) . ' ' . date('d', strtotime($array_week_dates[5])); ?></h5>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo date('D', strtotime($array_week_dates[6])); ?></h3>
                                    <h5><?php echo date('M', strtotime($array_week_dates[6])) . ' ' . date('d', strtotime($array_week_dates[6])); ?></h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="empty_w">Events</td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td>
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                    ?>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                            </tr>

                            <?php

                            $sql_visible_employees = "SELECT * FROM `tbl_schedule_setting_visibility` WHERE hotel_id = $hotel_id AND employee_id = $user_id";
                            $type_="";
                            $depart_="";
                            $team_="";
                            $result_visible_employees = $conn->query($sql_visible_employees);
                            if ($result_visible_employees && $result_visible_employees->num_rows > 0) {
                                while ($row_visible = mysqli_fetch_array($result_visible_employees)) {
                                    $type_=$row_visible[3];
                                    $depart_=$row_visible[4];
                                    $team_=$row_visible[5];
                                }

                                if($type_ == "SELF"){
                                    $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 AND a.enable_for_schedules = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 AND a.user_id = $user_id ORDER BY b.department_name ASC"; 
                                }else if($type_ == "DEPARTMENT"){
                                    $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 AND a.enable_for_schedules = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 AND a.depart_id = (select depart_id from tbl_user where user_id = $user_id ) ORDER BY b.department_name ASC";
                                }else if($type_ == "TEAM"){
                                    $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id INNER JOIN tbl_team_map as t on a.user_id = t.user_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 AND a.enable_for_schedules = 1 and b.is_delete = 0 AND t.team_id = (select team_id from tbl_user usr INNER JOIN tbl_team_map as tt on usr.user_id = tt.user_id where tt.user_id = $user_id LIMIT 1) ORDER BY b.department_name ASC";
                                }else if($type_ == "OTHERS"){

                                    if($team_ == "0" || $team_ == ""){
                                        $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 AND a.enable_for_schedules = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 ORDER BY b.department_name ASC"; 
                                    }else{
                                        $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id INNER JOIN tbl_team_map as tm on a.user_id = tm.user_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 AND a.enable_for_schedules = 1 and b.is_delete = 0 AND tm.team_id IN ($team_) ORDER BY b.department_name ASC";
                                    }

                                    if($depart_ == "0" || $depart_ == "" && $team_ == ""){
                                        $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 AND a.enable_for_schedules = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 ORDER BY b.department_name ASC"; 
                                    }else if($team_ == ""){
                                        $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 AND a.enable_for_schedules = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 AND b.depart_id IN ($depart_) ORDER BY b.department_name ASC";
                                    }


                                }else{
                                    $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 and a.depart_id != 0 AND a.enable_for_schedules = 1 and b.is_active = 1 and b.is_delete = 0 ORDER BY b.department_name ASC"; 
                                }

                            }else{
                                $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 AND a.enable_for_schedules = 1 and b.is_delete = 0 ORDER BY b.department_name ASC"; 
                            }

                            $depart_name = "";
                            $full_name="";
                            $n=1;
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {

                                    $full_name = $row['firstname'].' '.$row['lastname'];
                                    $userid_inner = $row['user_id'];
                                    $usertype_inner = $row['user_type'];
                            ?>

                            <tr>
                                <td>
                                    <div class="user_table_design">
                                        <div class="pt-1">
                                            <h6 class="mb-0"><b><?php echo $full_name; ?></b></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php

                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }

                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>

                                        <?php
                                            } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }
                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>


                                        <?php } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }
                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>


                                        <?php } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }
                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>


                                        <?php } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }
                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>


                                        <?php } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }
                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>


                                        <?php } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "upcomming"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 ORDER BY start_time ASC";
                                    }else if($view_filter_selected == "done"){
                                        $inner_sql = "SELECT * FROM `tbl_shifts` WHERE `assign_to` = $userid_inner AND `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 ORDER BY start_time ASC";
                                    }
                                    $result_inner = $conn->query($inner_sql);
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while ($row_inner = mysqli_fetch_array($result_inner)) {
                                    ?>
                                    <div class="text-left background-shadow-div2">
                                        <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                        <h4><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b></h4>

                                        <?php  
                                            $sql_visibility = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = ".$row_inner['assign_to'];
                                            $result_visibility = $conn->query($sql_visibility);
                                            $button_visibility = "";
                                            if ($result_visibility && $result_visibility->num_rows > 0) {
                                                while ($row_visibility = mysqli_fetch_array($result_visibility)) {
                                                    $button_visibility = $row_visibility['visible_type'];
                                                }
                                            }


                                            if($user_id == $row_inner['assign_to']){
                                                if($row_inner['is_completed'] == 1){
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-success font-0-8 slot-btn-p w-100 mb-2" disabled>Completed</button>
                                        <?php
                                                    }
                                                }else{
                                                    if($button_visibility == "COMPLETE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-dark font-0-8 slot-btn-p w-100 mb-2" onclick="change_status_complete(<?php echo $row_inner['sfs_id']; ?>,'<?php echo $row_inner['title']; ?>');">Mark as Complete</button>
                                        <?php 
                                                    }
                                                    $sql_offer = "SELECT * FROM `tbl_shift_offer` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                    $result_offer = $conn->query($sql_offer);
                                                    if ($result_offer && $result_offer->num_rows > 0) {
                                                        if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="take_back('<?php echo $row_inner['sfs_id']; ?>');">Take Back</button>
                                        <?php 
                                                        }
                                                    }else{

                                                        $sql_trade = "SELECT * FROM `tbl_shift_trade` WHERE shift_offered = $row_inner[0] AND is_active = 1 AND is_delete_user = 0 AND is_delete_admin = 0 AND is_approved_by_admin = 0";        
                                                        $result_trade = $conn->query($sql_trade);
                                                        if ($result_trade && $result_trade->num_rows > 0) {
                                                            if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100" onclick="cancel_trade('<?php echo $row_inner['sfs_id']; ?>');">Cancel Trade</button>
                                        <?php
                                                            }
                                                        }else{
                                                            if($button_visibility == "OFFER_UP_ONLY" || $button_visibility == "VISIBLE_ALL"){
                                        ?>

                                        <button class="btn btn-secondary font-0-8 slot-btn-p w-100" onclick="offer_up_shift('<?php echo $row_inner['sfs_id']; ?>');">Offer up shift</button>
                                        <?php }     if($button_visibility == "TRADE_ONLY" || $button_visibility == "VISIBLE_ALL"){ ?>
                                        <button class="btn btn-primary font-0-8 slot-btn-p w-100 mt-2" onclick="trade_shift('<?php echo $row_inner['sfs_id']; ?>');">Trade</button>
                                        <?php } } } } ?>


                                        <?php } 
                                        ?>
                                    </div> 
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                                    $n++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>

                    <table id="my-header-fixed-table"></table>
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
        <script src="./assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <script src="./assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="./assets/node_modules/popper/popper.min.js"></script>
        <script src="./assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
        <!--Wave Effects -->
        <script src="dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>
        <!-- Footable -->
        <script src="./assets/node_modules/moment/moment.js"></script>
        <script src="./assets/node_modules/footable/js/footable.min.js"></script>


        <!-- Date range picker -->
        <script src="./assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <!-- Clock Plugin JavaScript -->
        <script src="./assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
        <!-- Color Picker Plugin JavaScript -->
        <script src="./assets/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
        <script src="./assets/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
        <script src="./assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
        <!-- Date Picker Plugin JavaScript -->
        <script src="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>


        <!-- Select2 Multi Select -->
        <script src="./assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

        <!-- Sweet-Alert  -->
        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <script>

            //fixed header
            var tableOffset1 = $("#my-header-fixed-1").offset().top;
            var $header1 = $("#my-header-fixed-1 > div").clone();
            var $fixedHeader1 = $("#my-header-fixed-2").append($header1);


            $(window).bind("scroll", function() {
                var offset = $(this).scrollTop();

                let width = screen.width;
                if(width > 1630){
                    width = width-85;
                }else{
                    width = width-65;
                }
                $fixedHeader1.css({'width': width});

                if (offset >= tableOffset && $fixedHeader1.is(":hidden")) {
                    $fixedHeader1.show();
                } else if (offset < tableOffset) {
                    $fixedHeader1.hide();
                }
            });
            //fixed header


            //fixed header
            var tableOffset = $("#schedule-week-view").offset().top;
            var $header = $("#schedule-week-view > thead").clone();
            var $fixedHeader = $("#my-header-fixed-table").append($header);


            $(window).bind("scroll", function() {
                var offset = $(this).scrollTop();

                let width = screen.width;
                if(width > 1630){
                    width = width-97;
                }else{
                    width = width-80;
                }
                $('#my-header-fixed-table').css({'width': width});

                if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
                    $fixedHeader.show();
                } else if (offset < tableOffset) {
                    $fixedHeader.hide();
                }
            });
            //fixed header


            $("#select1").select2();
            $("#select2").select2();
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
            var filter_view = '<?php echo $view_filter_selected; ?>';

            function change_sort(slug) {
                var day = document.getElementById("day_sort_btn").classList;
                var week = document.getElementById("week_sort_btn").classList;
                slug_table_view = slug;
                if(filter_view != ""){
                    slug_table_view += "&filter="+filter_view;
                }
                if (slug == "day") {
                    day.remove("btn-light-red");
                    day.add("btn-secondary-red");
                    week.remove("btn-secondary-red");
                    week.add("btn-light-red");
                    $('#schedule-day-view').show();
                    $('#schedule-week-view').hide();
                    $('#endDate').hide();
                } else if (slug == "week") {
                    week.remove("btn-light-red");
                    week.add("btn-secondary-red");
                    day.remove("btn-secondary-red");
                    day.add("btn-light-red");
                    $('#schedule-day-view').hide();
                    $('#schedule-week-view').show();
                    $('#endDate').show();
                }
            }

            var nowDate = new Date();
            var dateString1 = moment(nowDate).format('MM/DD/YYYY');
            var endDate = new Date();
            endDate.setDate(endDate.getDate() + 6);
            var dateString2 = moment(endDate).format('MM/DD/YYYY');

            function setTodayDate() {
                console.log("Today");
                document.getElementById('datepicker-autoclose').value = dateString1;
                document.getElementById('endDate').value = dateString2;
            }

            function todayDate() {
                setTodayDate();
                window.location.href = "my_schedules.php?date=" + dateString1 + "&slug=" + slug_table_view;
            }

            function date_changed() {
                var date = document.getElementById('datepicker-autoclose').value;
                var changedDate = new Date(date);
                changedDate.setDate(changedDate.getDate() + 6);
                temp = moment(changedDate).format('MM/DD/YYYY');
                document.getElementById('endDate').value = temp;
                window.location.href = "my_schedules.php?date=" + date + "&slug=" + slug_table_view;
            }

            if (slug_table_view == 'week') {
                change_sort('week');
            } else if (slug_table_view == 'day') {
                change_sort('day');
            } else {
                change_sort('week');
            }

            var checkList = document.getElementById('list1');
            checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
                if (checkList.classList.contains('visible'))
                    checkList.classList.remove('visible');
                else
                    checkList.classList.add('visible');
            }

            function get_selected_val() {
                var departslist = [];
                var currentUrlWithoutParams = "";
                var i = 0;
                $('input[name="chklist"]:checked').each(function() {
                    var n = this.value.split('id_');
                    departslist[i] = n[1];
                    i++;
                });

                let params = (new URL(window.location.href)).searchParams;
                var temp = window.location.href.split("&departments=");

                if(params.get('date') || params.get('slug') || params.get('filter')){
                    currentUrlWithoutParams = temp[0]+"&departments=" + departslist;
                }else{
                    currentUrlWithoutParams = "?departments=" + departslist;
                }

                window.location.href = currentUrlWithoutParams;
            }
        </script>
        <script>
            var fullname = "";
            var user_id = "";
            var date = "";
            var day = "";
            var from_time = "";
            var to_time = "";
            var selected_day_modal = "";
            var selected_dates_array = [];
            var hourDiff = "";

            function set_time(){
                from_time = document.getElementById("from_time").value;
                to_time = document.getElementById("to_time").value;

                if(from_time < to_time){
                    var timeStart = new Date("01/01/2007 " +from_time);
                    var timeEnd = new Date("01/01/2007 " +to_time);

                    hourDiff = timeEnd - timeStart;   
                    hourDiff = (hourDiff / 60 / 60 / 1000).toFixed(2);

                    $('#hours_from_to').text(hourDiff);
                }else{
                    alert("Select End Time Greater.");
                    document.getElementById("to_time").value = "";
                    $('#hours_from_to').text(0);
                }
            }

            function setDayWeek(selectedDate,ID){
                var selectedDaySpan = document.getElementById(ID);

                if(selectedDaySpan.classList.contains("month_name_style")){
                    selectedDaySpan.classList.remove('month_name_style');
                    selectedDaySpan.classList.add('month_name_style_active');
                    selected_dates_array.push(selectedDate);
                }else if(selectedDaySpan.classList.contains("month_name_style_active")){
                    selectedDaySpan.classList.add('month_name_style');
                    selectedDaySpan.classList.remove('month_name_style_active');
                    var index = selected_dates_array.indexOf(selectedDate);
                    selected_dates_array.splice(index, 1);
                }

            }


            function show_schedule_filter(slug_flag){

                let params = (new URL(window.location.href)).searchParams;

                var temp = window.location.href.split("&filter=");

                if(params.get('date') || params.get('slug') || params.get('departments')){
                    currentUrlWithoutParams = temp[0]+"&filter=" + slug_flag;
                }else{
                    currentUrlWithoutParams = "?filter=" + slug_flag;
                }


                window.location.href = currentUrlWithoutParams;
            }


            function change_status_complete(id,title){

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change status!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_change_status_time_schedule.php',
                            method:'POST',
                            data:{id:id,title:title},
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Completed Successfully.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    })
                                }
                                else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        footer: ''
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            },
                        });
                    }
                });

            }
        </script>

        <script>
            var shift = "";
            var offer_to_shift = "";
            function offer_up_shift(shift_id){
                shift = shift_id;
                $('#responsive-modal-offer_up').show();
            }

            function dismiss_modal(){
                $('#responsive-modal-offer_up').hide();
                $("#message-text").val("");
                $("#select1").val(0).trigger("change");
            }
            function dismiss_modal_trade(){
                $('#responsive-modal-trade').hide();
                $("#message-text-trade").val("");
                $("#select2").val(0).trigger("change");
                $("#result_shifts").empty();
                offer_to_shift = "";
            }

            function trade_shift(shift_id){
                shift = shift_id;
                $('#responsive-modal-trade').show();
            }

            function offer_shift_save(){
                var employee = $("#select1").val();
                var message = $("#message-text").val();

                console.log(shift,employee,message);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to offer shift!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_offer_shift.php',
                            method:'POST',
                            data:{shift_id:shift,offer_to:employee,message:message},
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Offered Successfully.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }
                                else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        footer: ''
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            },
                        });
                    }
                });
            }

            function take_back(shift_){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to take back shift!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_take_back.php',
                            method:'POST',
                            data:{shift_id:shift_},
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Taken Back Successfully.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else if(response == "unsuccess"){
                                    Swal.fire({
                                        type: 'warning',
                                        title: 'Oops...',
                                        text: 'Shift already completed, You can`t take back.',
                                        footer: ''
                                    });
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        footer: ''
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            },
                        });
                    }
                });
            }

            function radioselected(selected_shift_id){
                offer_to_shift = selected_shift_id;
            }

            function show_shifts_selected(){
                var emp_id  = $("#select2").val();
                $("#result_shifts").empty();
                if(emp_id != 0){
                    console.log(emp_id);

                    $.ajax({
                        url:'util_get_shifts.php',
                        method:'POST',
                        data:{emp_id:emp_id},
                        success:function(response){
                            $('#result_shifts').append(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });

                }
            }

            function trade_shift_save(){
                var employee_trade = $("#select2").val();
                var message_trade = $("#message-text-trade").val();
                if(offer_to_shift != ""){

                    $.ajax({
                        url:'util_trade_shift.php',
                        method:'POST',
                        data:{shift_id:shift,offer_to:employee_trade,shift_to:offer_to_shift,message:message_trade},
                        success:function(response){
                            console.log(response);
                            if(response == "success"){
                                Swal.fire({
                                    title: 'Offer Sent Successfully.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                });
                            }else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    footer: ''
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });

                }else{
                    alert("Shift Not Selected For Trade.");
                }
            }


            function cancel_trade(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to cancel trade!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_cancel_trade.php',
                            method:'POST',
                            data:{shift_id:id},
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Cancel Successfully.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else if(response == "unsuccess"){
                                    Swal.fire({
                                        type: 'warning',
                                        title: 'Oops...',
                                        text: 'Shift already completed, You can`t cancel.',
                                        footer: ''
                                    });
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        footer: ''
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            },
                        });
                    }
                });
            }


            function print_schedule(){
                var divToPrint = document.getElementById('schedule-week-view');
                var htmlToPrint = '' +
                    '<style type="text/css">' +
                    'body{'+
                    'font-family: Arial;'+
                    'font-size: 10pt; }'+
                    'table{' +
                    'border: 1px dotted #ccc;' +
                    'border-collapse: collapse;' +
                    '}' +
                    'table th{'+
                    'background-color: #F7F7F7;'+
                    'color: #333;}'+
                    'table th, table td{'+
                    'padding: 5px;'+
                    'border: 1px dotted #ccc;'+
                    '}'+
                    'button, span, i, small, .circle, .text-success, .text-danger{' +
                    'display:none;' +
                    '}' + '.event_font{' +
                    'display:block; !important' +
                    '}' +
                    '</style>';
                htmlToPrint += divToPrint.outerHTML;
                newWin = window.open("");
                newWin.document.write('<html><head><title>' + document.title  + '</title>');
                newWin.document.write('</head><body >');
                newWin.document.write('<h1>' + document.title  + '</h1>');
                newWin.document.write(htmlToPrint);
                newWin.document.write('</body></html>');
                newWin.print();
                newWin.close();
            }
        </script>
    </body>

</html>