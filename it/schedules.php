<?php
include 'util_config.php';
include '../util_session.php';

$date_selected = date("m/d/Y");
$view_departments = "";
$view_departments_array = array();
$view_filter_selected="";
$scroll = 0;
if (isset($_GET['date'])) {
    $date_selected = $_GET['date'];
}
if (isset($_GET['scroll'])) {
    $scroll = $_GET['scroll'];
}
if (isset($_GET['filter'])) {
    $view_filter_selected = $_GET['filter'];
}
if (isset($_GET['departments'])) {
    $view_departments = $_GET['departments'];
    $view_departments_array = explode(",",$_GET['departments']);
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


$days_translated = array("Mon" => "Lun", "Tue" => "Mar", "Wed" => "Mer", "Thu" => "Gio", "Fri" => "Ven", "Sat" => "Sab", "Sun" => "Do");
$month_translated = array("Jan" => "Genn", "Febbr" => "Feb", "Mar" => "März", "Apr" => "Apr", "May" => "Magg", "Jun" => "Giugno", "Jul" => "Luglio", "Aug" => "Ag", "Sep" => "Sett", "Oct" => "Ott", "Nov" => "Nov", "Dec" => "Dic");

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
        <title>Gestione turni</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />

        <!-- Date picker plugins css -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

        <!-- Multiple Select -->
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />


        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/time_schedule.css" rel="stylesheet">

        <style>
            ul > .right-side-toggle{
                display: none;
            }
        </style>

    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Gestione turni</p>
            </div>
        </div>

        <div id="responsive-modal-schedule" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="display-inline text-left" id="candidate_name"></h3>
                        <button type="button" class="close" data-dismiss="modal" onclick="dismiss_modal();" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-2">
                                <select class="form-control" id="pre_defined_shifts" onchange="pre_defined_selected();">
                                    <option value="0">Selezionare Predefinito Spostare</option>
                                    <?php
                                    $sql = "SELECT * FROM `tbl_shifts_pre_defined` WHERE hotel_id = $hotel_id AND is_delete = 0";
                                    $result = $conn->query($sql);
                                    if ($result && $result->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['sfspd_id']; ?>"><?php echo $row['shift_name'] .' ('.$row['start_time'].' - '.$row['end_time'].')'; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <input type="time" class="form-control display-inline w-30 wm-38" value="09:00" onchange="set_time();" id="from_time">
                                <i class="fas fa-arrow-right pl-3 pr-3"></i>
                                <input type="time" class="form-control display-inline w-30 wm-38" value="17:00" onchange="set_time();" id="to_time">

                                <label for="message-text" class="control-label ml-1 mtm-10">Pausa <small>(min)</small></label>
                                <input type="number" style="width:80px;" class="form-control display-inline mtm-10 w-30" min="0" max="240" id="break_mint" />

                            </div>
                            <div class="form-group mb-2 ml-1">
                                <label for="message-text" class="control-label mr-2"><i class="far fa-clock"></i> <span id="hours_from_to">8</span> Ore</label>

                                <label class="custom-control custom-checkbox display-inline ml-5 mm-0 plm-0">
                                    <button onclick="redirect_to_off_time();" type="button" class="btn w-100 schedule_buttons_font_ btn-secondary">Aggiungi orario di riposo</button>
                                </label>
                                <label class="custom-control custom-checkbox display-inline">
                                    <button onclick="redirect_to_blocked_day();" type="button" class="btn w-100 schedule_buttons_font_ btn-success">Aggiungi vacanza</button>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label ml-1">Applicare a</label>
                                <div class="display_flex_div">
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[0])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[0]; ?>','day_<?php echo date('D', strtotime($array_week_dates[0])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[0]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[1])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[1]; ?>','day_<?php echo date('D', strtotime($array_week_dates[1])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[1]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[2])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[2]; ?>','day_<?php echo date('D', strtotime($array_week_dates[2])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[2]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[3])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[3]; ?>','day_<?php echo date('D', strtotime($array_week_dates[3])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[3]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[4])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[4]; ?>','day_<?php echo date('D', strtotime($array_week_dates[4])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[4]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[5])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[5]; ?>','day_<?php echo date('D', strtotime($array_week_dates[5])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[5]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="day_<?php echo date('D', strtotime($array_week_dates[6])); ?>" onclick="setDayWeek('<?php echo $array_week_dates[6]; ?>','day_<?php echo date('D', strtotime($array_week_dates[6])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[6]))]; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="control-label ml-1">Ripetizione turni (Opzionale)</label>
                                <input type="date" class="form-control display-inline w-30 wm-43" id="repeat_until">
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" placeholder="Nota sul turno" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" onclick="dismiss_modal();" data-dismiss="modal">Cancella</button>
                        <button onclick="save_shift();" type="button" class="btn btn-success waves-effect waves-light">Salva</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="responsive-modal-schedule-event" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="display-inline text-left">Crea Evento</h3>
                        <button type="button" class="close" data-dismiss="modal" onclick="dismiss_modal_event();" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-group">
                                <input class="form-control" placeholder="Title" id="title-event" />
                            </div>

                            <div class="form-group mb-2">
                                <input type="time" class="form-control display-inline w-30" value="09:00" onchange="set_time_event();" id="from_time_event">
                                <i class="fas fa-arrow-right pl-3 pr-3"></i>
                                <input type="time" class="form-control display-inline w-30" value="17:00" onchange="set_time_event();" id="to_time_event">
                                <label for="message-text" class="control-label ml-2"><i class="far fa-clock"></i> <span id="hours_from_to_event">8</span> Ore</label>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="control-label ml-1"><b>Seleziona Evento di più giorni</b></label>
                                <div class="display_flex_div">
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[0])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[0]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[0])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[0]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[1])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[1]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[1])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[1]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[2])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[2]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[2])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[2]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[3])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[3]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[3])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[3]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[4])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[4]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[4])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[4]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[5])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[5]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[5])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[5]))]; ?></span>
                                    </div>
                                    <div>
                                        <span id="event_day_<?php echo date('D', strtotime($array_week_dates[6])); ?>" onclick="setDayWeekEvent('<?php echo $array_week_dates[6]; ?>','event_day_<?php echo date('D', strtotime($array_week_dates[6])); ?>');" class="month_name_style"><?php echo $days_translated[date('D', strtotime($array_week_dates[6]))]; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Descrizione (facoltativa)" id="message-text-event"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" onclick="dismiss_modal_event();" data-dismiss="modal">Cancella</button>
                        <button onclick="save_event();" type="button" class="btn btn-primary waves-effect waves-light">Salva</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="responsive-modal-delete-shift" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="display-inline text-left">Cancellare turno</h3>
                        <button type="button" class="close" data-dismiss="modal" onclick="dismiss_modal_delete_shift();" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <select class="form-control" id="delete_shift_select" onchange="hide_show_until_date_delete();">
                                    <option value="1">Elimina solo questo turno</option>
                                    <option value="2">Elimina tutti i turni negli stessi giorni della settimana successivi</option>
                                    <option value="3">Elimina tutti i turni fino a una certa data</option>
                                </select>
                            </div>
                            <div class="form-group" id="delete_shift_date_form" style="display:none;">
                                <label for="message-text" class="control-label ml-1"><b>Elimina fino a</b></label>
                                <input type="date" class="form-control" id="delete_shift_date" />
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="delete_shift_select_apply_users">
                                    <option value="1">Utente selezionato</option>
                                    <option value="2">Tutti gli utenti</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" onclick="dismiss_modal_delete_shift();" data-dismiss="modal">Indietro</button>
                        <button onclick="delete_schedule();" type="button" class="btn btn-danger waves-effect waves-light">Eliminare</button>
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

                <div id="header-fixed-1">
                    <!-- ============================================================== -->
                    <!-- Container fluid  -->
                    <!-- ============================================================== -->
                    <div class="container-fluid pb-0 mobile-container-padding">
                        <!-- ============================================================== -->
                        <!-- Bread crumb and right sidebar toggle -->
                        <!-- ============================================================== -->
                        <div class="row page-titles heading_style">
                            <div class="col-lg-3 align-self-center">
                                <h3>Gestione turni</h3>
                            </div>
                            <div class="col-lg-1 align-self-center text-right">
                                <button onclick="backwardDate();" class="btn w-100 btn-info d-lg-block "><i class="ti-angle-double-left"></i> Indietro</button>
                            </div>
                            <div class="col-lg-3 align-self-center text-right mtm-10">
                                <div class="input-group">
                                    <input type="text" value="<?php echo $date_selected; ?>" onchange="date_changed();" class="form-control " id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                    <input type="text" disabled class="form-control bg-white" value="<?php echo $end_date; ?>" id="endDate" placeholder="mm/dd/yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-1 align-self-center text-right mtm-10">
                                <button onclick="forwardDate();" class="btn w-100 btn-info d-lg-block ">Inoltrare <i class="ti-angle-double-right"></i></button>
                            </div>
                            <div class="col-lg-1 align-self-center text-right mtm-10">
                                <button onclick="todayDate();" class="btn w-100 btn-secondary d-lg-block ">Oggi</button>
                            </div>

                            <div class="col-lg-3 align-self-center text-right mtm-10 mobile_text_center">
                                <span id="all_filter" onclick="show_schedule_filter('all');" class="ml-3 mr-3 <?php if($view_filter_selected == "all" || $view_filter_selected == ""){ echo 'active_filter_schedule'; }else{echo '';} ?> cursor-pointer"><b>Tutto</b></span>
                                <span id="upcomming_filter" onclick="show_schedule_filter('upcomming');" class="ml-3 mr-3 <?php if($view_filter_selected == "upcomming"){ echo 'active_filter_schedule'; }else{echo '';} ?> cursor-pointer"><b>In arrivo</b></span>
                                <span id="done_filter" onclick="show_schedule_filter('done');" class="ml-3 mr-3 <?php if($view_filter_selected == "done"){ echo 'active_filter_schedule'; }else{echo '';} ?> cursor-pointer"><b>Fatto</b></span>
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
                        <div class="col-lg-2">

                            <select class="selectpicker" onchange="get_selected_val();" id="depart_select" multiple data-style="form-control btn-secondary mt-1">
                                <?php
                                $sql = "SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row[0]; ?>" <?php if(in_array($row[0], $view_departments_array)){echo 'selected';} ?>> <?php if($row[2] != ""){ echo $row[2]; }else if($row[1] != ""){ echo $row[1]; }else{ echo $row[3]; } ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>


                        <div class="col-lg-10 align-self-center mobile_text_left mtm-10 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu animated lightSpeedIn">
                                    <a class="dropdown-item" href="javascript:void()" onclick="print_schedule();"><i class="fas fa-print"></i> Stampa</a>
                                    <a class="dropdown-item" href="schedule_settings.php"><i class="mdi mdi-settings"></i> Impostazioni</a>
                                    <a class="dropdown-item" href="pre_defined_shifts.php"><i class="fas fa-calendar-check"></i> Turni predifiniti</a>
                                </div>
                            </div>

                            <span class="schedule_buttons_font_">
                                <?php 
                                $s_date = date("Y-m-d", strtotime($date_selected));
                                $e_date = date("Y-m-d", strtotime($end_date));

                                if($view_departments == ""){
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $sql_publish_status = "SELECT * FROM `tbl_shifts` WHERE `date` BETWEEN '$s_date' AND '$e_date' AND is_published = 0 AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";  
                                    }else if($view_filter_selected == "upcomming"){
                                        $sql_publish_status = "SELECT * FROM `tbl_shifts` WHERE `date` BETWEEN '$s_date' AND '$e_date' AND is_published = 0 AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0";  
                                    }else if($view_filter_selected == "done"){
                                        $sql_publish_status = "SELECT * FROM `tbl_shifts` WHERE `date` BETWEEN '$s_date' AND '$e_date' AND is_published = 0 AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1";  
                                    }
                                }else{
                                    if($view_filter_selected == "" || $view_filter_selected == "all"){
                                        $sql_publish_status = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` BETWEEN '$s_date' AND '$e_date' AND a.is_published = 0 AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments)";
                                    }else if($view_filter_selected == "upcomming"){
                                        $sql_publish_status = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` BETWEEN '$s_date' AND '$e_date' AND a.is_published = 0 AND a.is_active = 1 AND a.is_completed = 0 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments)"; 
                                    }else if($view_filter_selected == "done"){
                                        $sql_publish_status = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` BETWEEN '$s_date' AND '$e_date' AND a.is_published = 0 AND a.is_active = 1 AND a.is_completed = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments)";
                                    }
                                }



                                $result_status = $conn->query($sql_publish_status);
                                if ($result_status && $result_status->num_rows > 0) {
                                    echo 'Inedito';
                                }else{
                                    echo 'Pubblicato';
                                }
                                ?>
                            </span>


                            <button type="button" onclick="notify_changes('<?php echo $s_date; ?>','<?php echo $e_date; ?>');" id="publish_changes_btn" class="mlm-04 schedule_buttons_font_ btn btn-success ml-3"><i class="far fa-paper-plane"></i> Pubblica modifiche</button>

                            <button type="button" class="mlm-04 schedule_buttons_font_ btn btn-secondary ml-3 right-side-toggle">Turni predifiniti</button>

                        </div>


                    </div>
                </div>

                <div id="header-fixed-2"></div>

                <div class="col-lg-12 mt-3 mb-4">


                    <table id="schedule-week-view">
                        <thead>
                            <tr>
                                <th class="empty_w"></th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[0]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[0]))] . ' ' . date('d', strtotime($array_week_dates[0])); ?></h5>
                                    <?php
                                    if($view_departments == ""){
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql0 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to"; 
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql0 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to"; 
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql0 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 GROUP BY assign_to"; 
                                        }
                                    }else{
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql0 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[0]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql0 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[0]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql0 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[0]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to";
                                        }
                                    }

                                    $result_inner0 = $conn->query($inner_sql0);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner0->num_rows; ?></span></span>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[1]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[1]))] . ' ' . date('d', strtotime($array_week_dates[1])); ?></h5>
                                    <?php
                                    if($view_departments == ""){

                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql1 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql1 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql1 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 GROUP BY assign_to";
                                        }

                                    }else{

                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql1 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[1]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql1 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[1]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql1 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[1]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to";
                                        }

                                    }
                                    $result_inner1 = $conn->query($inner_sql1);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner1->num_rows; ?></span></span>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[2]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[2]))] . ' ' . date('d', strtotime($array_week_dates[2])); ?></h5>
                                    <?php
                                    if($view_departments == ""){

                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql2 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to";  
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql2 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to";  
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql2 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id  AND is_completed = 1 GROUP BY assign_to";  
                                        }

                                    }else{

                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql2 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[2]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql2 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[2]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to"; 
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql2 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[2]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to"; 
                                        }

                                    }
                                    $result_inner2 = $conn->query($inner_sql2);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner2->num_rows; ?></span></span>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[3]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[3]))] . ' ' . date('d', strtotime($array_week_dates[3])); ?></h5>
                                    <?php
                                    if($view_departments == ""){
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql3 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql3 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql3 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 GROUP BY assign_to";
                                        }
                                    }else{
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql3 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[3]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql3 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[3]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql3 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[3]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to";
                                        }
                                    }
                                    $result_inner3 = $conn->query($inner_sql3);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner3->num_rows; ?></span></span>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[4]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[4]))] . ' ' . date('d', strtotime($array_week_dates[4])); ?></h5>
                                    <?php
                                    if($view_departments == ""){
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql4 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql4 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql4 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 GROUP BY assign_to";
                                        }
                                    }else{
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql4 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[4]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql4 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[4]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql4 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[4]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to";
                                        }
                                    }
                                    $result_inner4 = $conn->query($inner_sql4);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner4->num_rows; ?></span></span>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[5]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[5]))] . ' ' . date('d', strtotime($array_week_dates[5])); ?></h5>
                                    <?php
                                    if($view_departments == ""){
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql5 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql5 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql5 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 GROUP BY assign_to";
                                        }
                                    }else{
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql5 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[5]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql5 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[5]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql5 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[5]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to";
                                        }
                                    }
                                    $result_inner5 = $conn->query($inner_sql5);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner5->num_rows; ?></span></span>
                                </th>
                                <th class="days_w">
                                    <h3><?php echo $days_translated[date('D', strtotime($array_week_dates[6]))]; ?></h3>
                                    <h5><?php echo $month_translated[date('M', strtotime($array_week_dates[6]))] . ' ' . date('d', strtotime($array_week_dates[6])); ?></h5>
                                    <?php
                                    if($view_departments == ""){
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql6 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id GROUP BY assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql6 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 0 GROUP BY assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql6 = "SELECT * FROM `tbl_shifts` WHERE `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id AND is_completed = 1 GROUP BY assign_to";
                                        }
                                    }else{
                                        if($view_filter_selected == "" || $view_filter_selected == "all"){
                                            $inner_sql6 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[6]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "upcomming"){
                                            $inner_sql6 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[6]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 0 GROUP BY a.assign_to";
                                        }else if($view_filter_selected == "done"){
                                            $inner_sql6 = "SELECT a.* FROM `tbl_shifts`as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.`date` = '$array_week_dates[6]' AND a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND b.depart_id IN ($view_departments) AND a.is_completed = 1 GROUP BY a.assign_to";
                                        }
                                    }
                                    $result_inner6 = $conn->query($inner_sql6);
                                    ?>
                                    <span class="f-right"><i class="mdi mdi-account"></i><span><?php echo $result_inner6->num_rows; ?></span></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $d1=$d2=$d3=$d4=$d5=$d6=$d7=0; ?>
                            <tr>
                                <td class="empty_w padding-event-8"><a href="#">Eventi</a></td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[0]; ?>','<?php echo date('D', strtotime($array_week_dates[0])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d1 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[1]; ?>','<?php echo date('D', strtotime($array_week_dates[1])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d2 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[2]; ?>','<?php echo date('D', strtotime($array_week_dates[2])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d3 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[3]; ?>','<?php echo date('D', strtotime($array_week_dates[3])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d4 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[4]; ?>','<?php echo date('D', strtotime($array_week_dates[4])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d5 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[5]; ?>','<?php echo date('D', strtotime($array_week_dates[5])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d6 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                                <td class="cursor-pointer insert_schedule_symbol padding-event-8" onclick="insert_event('<?php echo $array_week_dates[6]; ?>','<?php echo date('D', strtotime($array_week_dates[6])); ?>');">
                                    <?php
                                    $event_sql = "SELECT * FROM `tbl_shift_events` WHERE `date` = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";
                                    $result_event = $conn->query($event_sql);
                                    if ($result_event && $result_event->num_rows > 0) {
                                        while ($row_event = mysqli_fetch_array($result_event)) {
                                            $d7 = 1;
                                    ?>
                                    <div class="row m-0">
                                        <div class="col-lg-12 pl-0 pr-0 text-right">
                                            <a href="javascript:void(0)" onclick="delete_event('<?php echo $row_event['svnts_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                            <a  class="text-info" href="javascript:void(0)" onclick="edit_event(<?php echo $row_event['svnts_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </div>
                                    <span class="dot_blue"></span> <span class="event_font"> <?php echo date('h:ia', strtotime($row_event['start_time'])); ?> <b><?php echo $row_event['title']; ?> <?php if($row_event['description'] != ""){ echo "(".$row_event['description'].")"; } ?></b></span>
                                    <?php } } ?>
                                </td>
                            </tr>

                            <?php
                            if($view_departments == ""){
                                $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 AND a.enable_for_schedules = 1 and b.is_delete = 0 ORDER BY b.department_name ASC";  
                            }else{
                                $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 AND a.enable_for_schedules = 1 and b.is_delete = 0 AND b.depart_id IN ($view_departments) ORDER BY b.department_name ASC";
                            }

                            $depart_name = "";
                            $full_name="";
                            $n=1;
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while ($row = mysqli_fetch_array($result)) {


                                    if($n == 1){
                                        $depart_name = $row['department_name'];
                            ?>
                            <tr>
                                <td colspan="8" class="depart_w">
                                    <h6 class="mb-0"><?php  if($row['department_name_it'] != ""){
                                echo $row['department_name_it'];
                            }else if($row['department_name'] != ""){
                                echo $row['department_name'];
                            }else{
                                echo $row['department_name_de'];
                            } ?></h6>
                                </td>
                            </tr>
                            <?php
                                    }

                                    if($depart_name != $row['department_name']){
                            ?>
                            <tr>
                                <td colspan="8" class="depart_w">
                                    <h6 class="mb-0"><?php  if($row['department_name_it'] != ""){
                                echo $row['department_name_it'];
                            }else if($row['department_name'] != ""){
                                echo $row['department_name'];
                            }else{
                                echo $row['department_name_de'];
                            } ?></h6>
                                </td>
                            </tr>
                            <?php
                                        $depart_name = $row['department_name'];
                                    }

                                    $full_name = $row['firstname'].' '.$row['lastname'];
                                    $userid_inner = $row['user_id'];
                                    $usertype_inner = $row['user_type'];
                            ?>

                            <tr>
                                <td>
                                    <div class="user_table_design">
                                        <div class="circle circle-color-<?php echo  mt_rand(1,15); ?>"><?php echo ucfirst(substr($row['firstname'],0,1)); ?></div>
                                        <div class="pt-1">
                                            <h6 class="mb-0"><b><?php echo $full_name; ?></b></h6>
                                            <small>
                                                <?php
                                    $sql_working_hours_incomp = "SELECT SUM(total_hours) as working_hours FROM `tbl_shifts` WHERE (date BETWEEN '$array_week_dates[0]' AND '$array_week_dates[6]') AND assign_to = $userid_inner";
                                    $sql_working_hours_comp = "SELECT SUM(total_hours) as working_hours FROM `tbl_shifts` WHERE (date BETWEEN '$array_week_dates[0]' AND '$array_week_dates[6]') AND assign_to = $userid_inner AND is_completed = 1";
                                    $result_whi = $conn->query($sql_working_hours_incomp);
                                    $result_whc = $conn->query($sql_working_hours_comp);
                                    if ($result_whi && $result_whi->num_rows > 0) {
                                        while ($row_whi = mysqli_fetch_array($result_whi)) {
                                            $row_whc = mysqli_fetch_array($result_whc);

                                            if($row_whc['working_hours'] != ""){ echo $row_whc['working_hours']; }else{echo '0.00';}
                                            echo ' / ';
                                            if($row_whi['working_hours'] != ""){ echo $row_whi['working_hours']; }else{echo '0.00';}
                                        } }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <!--                               Start Column one Day 1 of the Week-->
                                <?php

                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d1 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[0]; ?>','<?php echo date('D', strtotime($array_week_dates[0])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[0]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d1 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[0]; ?>','<?php echo date('D', strtotime($array_week_dates[0])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>

                                <td <?php if($d1 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[0]; ?>','<?php echo date('D', strtotime($array_week_dates[0])); ?>');" <?php } ?>  >
                                    <?php if($d1 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[0]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">
                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>


                                    <?php
                                                }
                                            }
                                    ?>
                                </td>

                                <?php 
                                        }


                                    } 
                                ?>
                                <!--                               End Column one Day 1 of the Week-->
                                <!--                               Start Column two Day 2 of the Week-->

                                <?php
                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d2 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[1]; ?>','<?php echo date('D', strtotime($array_week_dates[1])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[1]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d2 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[1]; ?>','<?php echo date('D', strtotime($array_week_dates[1])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>

                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>


                                <td <?php if($d2 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[1]; ?>','<?php echo date('D', strtotime($array_week_dates[1])); ?>');" <?php } ?> >
                                    <?php if($d2 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[1]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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


                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">
                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                }
                                            }
                                    ?>
                                </td>

                                <?php 
                                        }


                                    } 
                                ?>

                                <!--                               End Column two Day 2 of the Week-->
                                <!--                               Start Column three Day 3 of the Week-->

                                <?php
                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d3 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[2]; ?>','<?php echo date('D', strtotime($array_week_dates[2])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[2]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d3 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[2]; ?>','<?php echo date('D', strtotime($array_week_dates[2])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 
                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>
                                <td <?php if($d3 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[2]; ?>','<?php echo date('D', strtotime($array_week_dates[2])); ?>');" <?php } ?> >
                                    <?php if($d3 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[2]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                }
                                            }
                                    ?>
                                </td>
                                <?php 
                                        }
                                    } 
                                ?>

                                <!--                               End Column three Day 3 of the Week-->
                                <!--                               Start Column four Day 4 of the Week-->

                                <?php
                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d4 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[3]; ?>','<?php echo date('D', strtotime($array_week_dates[3])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[3]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d4 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[3]; ?>','<?php echo date('D', strtotime($array_week_dates[3])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>
                                <td <?php if($d4 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[3]; ?>','<?php echo date('D', strtotime($array_week_dates[3])); ?>');" <?php } ?>>
                                    <?php if($d4 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[3]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                }
                                            }
                                    ?>
                                </td>

                                <?php 
                                        }
                                    } 
                                ?>

                                <!--                               End Column four Day 4 of the Week-->
                                <!--                               Start Column fifth Day 5 of the Week-->

                                <?php
                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d4 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[5]; ?>','<?php echo date('D', strtotime($array_week_dates[5])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[4]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d5 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[4]; ?>','<?php echo date('D', strtotime($array_week_dates[4])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 
                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>
                                <td <?php if($d5 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[4]; ?>','<?php echo date('D', strtotime($array_week_dates[4])); ?>');" <?php } ?>>
                                    <?php if($d5 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[4]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                }
                                            }
                                    ?>
                                </td>

                                <?php 
                                        }
                                    } 
                                ?>

                                <!--                               End Column fifth Day 5 of the Week-->
                                <!--                               Start Column sixth Day 6 of the Week-->
                                <?php
                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d6 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[5]; ?>','<?php echo date('D', strtotime($array_week_dates[5])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[5]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d6 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[5]; ?>','<?php echo date('D', strtotime($array_week_dates[5])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>

                                <td <?php if($d6 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[5]; ?>','<?php echo date('D', strtotime($array_week_dates[5])); ?>');" <?php } ?> >
                                    <?php if($d6 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[5]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                }
                                            }
                                    ?>
                                </td>

                                <?php 
                                        }
                                    } 
                                ?>

                                <!--                               End Column sixth Day 6 of the Week-->
                                <!--                               Start Column seven Day 7 of the Week-->

                                <?php
                                    $sql_block_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category = 'HOLIDAY' AND request_by IN ($userid_inner,0)";
                                    $result_block_day = $conn->query($sql_block_day);
                                    if ($result_block_day && $result_block_day->num_rows > 0) {
                                ?><td><?php
                                        while ($row_block_day = mysqli_fetch_array($result_block_day)) {
                                            if($row_block_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-success"><b>Vacanza completa</b></h5>
                                <?php
                                            }else{
                                ?>
                                <span <?php if($d7 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[6]; ?>','<?php echo date('D', strtotime($array_week_dates[6])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-success"><b>VACANZA PARZIALE</b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>

                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                        $time1 = strtotime($row_inner['end_time']);
                                                        $time2 = strtotime($row_inner['start_time']);
                                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                                        echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 

                                    <?php
                                                    }
                                                }
                                    ?>
                                </span>
                                <?php
                                            }
                                        }
                                ?>
                                </td>
                                <?php
                                        //                                        End of Blocked Day
                                    }else{
                                        $sql_leave_day = "SELECT * FROM `tbl_time_off` WHERE date = '$array_week_dates[6]' AND is_active = 1 AND is_delete = 0 AND status = 'APPROVED' AND hotel_id = $hotel_id AND category in ('UNPAID','PAID','PAID_SICK') AND request_by = $userid_inner";
                                        $result_leave_day = $conn->query($sql_leave_day);
                                        if ($result_leave_day && $result_leave_day->num_rows > 0) {
                                ?><td><?php
                                            while ($row_leave_day = mysqli_fetch_array($result_leave_day)) {
                                                if($row_leave_day['duration'] == 'FULL'){
                                ?>
                                <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Pieno";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Pieno";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Pieno";} ?></b></h5>
                                <?php
                                                }else{
                                ?>
                                <span <?php if($d7 != 1){ ?> class="cursor-pointer insert_schedule_symbol_leave" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[6]; ?>','<?php echo date('D', strtotime($array_week_dates[6])); ?>');" <?php } ?> >
                                    <h5 class="font-0-8 text-danger"><b><?php if($row_leave_day['category'] == "PAID"){echo "Vacanza Parziale";}elseif($row_leave_day['category'] == "UNPAID"){echo "Vacanza non pagati Parziale";}elseif($row_leave_day['category'] == "PAID_SICK"){echo "Malattia Parziale";} ?></b></h5>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                            $time1 = strtotime($row_inner['end_time']);
                                                            $time2 = strtotime($row_inner['start_time']);
                                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                                        }
                                                    }
                                    ?>
                                </span>
                                <?php
                                                }
                                            }
                                ?>
                                </td>
                                <?php
                                        }else{
                                ?>

                                <td <?php if($d7 != 1){ ?> class="cursor-pointer insert_schedule_symbol" onclick="insert_schedule('<?php echo $full_name; ?>','<?php echo $row['user_id']; ?>','<?php echo $array_week_dates[6]; ?>','<?php echo date('D', strtotime($array_week_dates[6])); ?>');" <?php } ?> >
                                    <?php if($d7 != 1){ ?>
                                    <a href="javascript:void(0)" onclick="paste_shift('<?php echo $userid_inner; ?>','<?php echo $array_week_dates[6]; ?>')" class="green_icon_ paste_icon_position"><i class="fas fa-paste"></i></a>
                                    <?php } ?>
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
                                    <div class="text-left background-shadow-div <?php if($row_inner['is_completed'] == 1){echo 'bg-completed';} ?>">

                                        <div class="row m-0">
                                            <div class="col-lg-7 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row_inner['title']; ?></h5>
                                            </div>
                                            <div class="col-lg-5 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_shift('<?php echo $row_inner['sfs_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_modal_user('<?php echo $row_inner['sfs_id']; ?>')" class="red_icon_"><i class="fas fa-trash-alt"></i></a>
                                                <a  class="text-info" href="javascript:void(0)" onclick="edit_schedule(<?php echo $row_inner['sfs_id']; ?>);"><i class="fas fa-pencil-alt"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row_inner['start_time'] . ' - ' . $row_inner['end_time']; ?></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                                    $time1 = strtotime($row_inner['end_time']);
                                                    $time2 = strtotime($row_inner['start_time']);
                                                    $difference = round(abs($time2 - $time1) / 3600,2);
                                                    echo $difference;

                                            ?>
                                            </span></h4>
                                    </div> 
                                    <?php
                                                }
                                            }
                                    ?>
                                </td>

                                <?php 
                                        }
                                    } 
                                ?>
                                <!--                               End Column Seventh Day 7 of the Week-->

                            </tr>

                            <?php
                                    $n++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>

                    <table id="header-fixed-table"></table>
                    <div id="snackbar">Some text some message..</div>
                </div>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> <b>Turni predifiniti</b> <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                    $sql = "SELECT a.*,b.department_name FROM `tbl_shifts_pre_defined` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.hotel_id = $hotel_id AND a.is_delete = 0 ORDER BY b.depart_id ASC";

                                    $result = $conn->query($sql);
                                    if ($result && $result->num_rows > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <div class="text-left background-shadow-div mb-2">

                                        <div class="row m-0">
                                            <div class="col-lg-11 pr-0 pl-0">
                                                <h5 class="font-0-8"><?php echo $row['shift_name']; ?> (<?php echo $row['title']; ?>)</h5>
                                            </div>
                                            <div class="col-lg-1 pl-0 pr-0 text-right">
                                                <a href="javascript:void(0)" onclick="copy_pre_shift('<?php echo $row['sfspd_id']; ?>')" class="orange_icon_"><i class="fas fas fa-copy"></i></a>
                                            </div>
                                        </div>


                                        <h4 style="display:flex;justify-content: space-between;font-size: 0.8rem;" class="mb-0"><b><?php echo $row['start_time'] . ' - ' . $row['end_time']; ?> <span class="bg-success p-1 text-white"> <?php echo $row['department_name']; ?></span></b> <span class="custom_design_label_persons font-0-7">
                                            <?php 
                                            $time1 = strtotime($row['end_time']);
                                            $time2 = strtotime($row['start_time']);
                                            $difference = round(abs($time2 - $time1) / 3600,2);
                                            echo $difference;

                                            ?>
                                            </span></h4>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <script>

            //fixed header
            var tableOffset1 = $("#header-fixed-1").offset().top;
            var $header1 = $("#header-fixed-1 > div").clone();
            var $fixedHeader1 = $("#header-fixed-2").append($header1);

            var scroll_position = '<?php echo $scroll; ?>';

            $(window).bind("scroll", function() {
                var offset = $(this).scrollTop();
                scroll_position = offset;
                let width = screen.width;
                if(width > 1630){
                    width = width-85;
                }else{
                    width = width-65;
                }
                $fixedHeader1.css({'width': width});

                if (offset >= tableOffset1 && $fixedHeader1.is(":hidden")) {
                    $fixedHeader1.show();
                    $("#items_id").css({'top': '135px'});
                } else if (offset < tableOffset1) {
                    $fixedHeader1.hide();
                    $("#items_id").css({'top': '220px'});
                }
            });
            //fixed header

            //fixed header
            var tableOffset = $("#schedule-week-view").offset().top;
            var $header = $("#schedule-week-view > thead").clone();
            var $fixedHeader = $("#header-fixed-table").append($header);


            $(window).bind("scroll", function() {
                var offset = $(this).scrollTop();

                let width = screen.width;
                if(width > 1630){
                    width = width-97;
                }else{
                    width = width-80;
                }
                $('#header-fixed-table').css({'width': width});

                if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
                    $fixedHeader.show();
                } else if (offset < tableOffset) {
                    $fixedHeader.hide();
                }
            });
            //fixed header


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

            var filter_view = '<?php echo $view_filter_selected; ?>';

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
                window.location.href = "schedules.php?scroll="+scroll_position+"&date=" + dateString1;
            }

            function date_changed() {
                var date = document.getElementById('datepicker-autoclose').value;
                var changedDate = new Date(date);
                changedDate.setDate(changedDate.getDate() + 6);
                temp = moment(changedDate).format('MM/DD/YYYY');
                document.getElementById('endDate').value = temp;
                window.location.href = "schedules.php?scroll="+scroll_position+"&date=" + date;
            }


            //            var checkList = document.getElementById('list1');
            //            checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
            //                if (checkList.classList.contains('visible'))
            //                    checkList.classList.remove('visible');
            //                else
            //                    checkList.classList.add('visible');
            //            }

            function get_selected_val() {
                var departslist = [];
                var currentUrlWithoutParams = "";
                var i = 0;

                var brands = $('#depart_select option:selected');
                $(brands).each(function(index, brand){
                    departslist.push($(this).val());
                });

                let params = (new URL(window.location.href)).searchParams;
                var temp = window.location.href.split("&departments=");

                if(params.get('date') || params.get('filter')){
                    currentUrlWithoutParams = temp[0]+"&departments=" + departslist;
                }else{
                    currentUrlWithoutParams = "?departments=" + departslist;
                }

                window.location.href = currentUrlWithoutParams;
            }
        </script>
        <script>
            var is_delete_flag = 0;
            var is_delete_flag_event = 0;
            var fullname = "";
            var user_id = "";
            var date = "";
            var day = "";
            var from_time = "";
            var to_time = "";
            var selected_day_modal = "";
            var selected_dates_array = [];
            var hourDiff = "";
            var copied_id = 0;
            var copied_pre_id = 0;
            function insert_schedule(fullname_, user_id_, date_, day_){
                if(is_delete_flag == 0){
                    fullname = fullname_;
                    user_id = user_id_;
                    date = date_;
                    day = day_;

                    selected_day_modal = document.getElementById("day_"+day);
                    console.log(selected_day_modal);
                    selected_day_modal.classList.remove('month_name_style');
                    selected_day_modal.classList.add('month_name_style_active');
                    selected_dates_array.push(date);

                    $('#candidate_name').text(fullname);
                    $('#responsive-modal-schedule').show();
                }else{
                    is_delete_flag = 0;
                }
            }


            var selected_day_modal_event = "";
            var selected_dates_array_event = [];
            var date_event = "";
            var day_event = "";
            var from_time_event = "";
            var to_time_event = "";
            function insert_event(date_, day_){
                if(is_delete_flag_event == 0){
                    date_event = date_;
                    day_event = day_;

                    selected_day_modal_event = document.getElementById("event_day_"+day_event);
                    console.log(selected_day_modal_event);
                    selected_day_modal_event.classList.remove('month_name_style');
                    selected_day_modal_event.classList.add('month_name_style_active');
                    selected_dates_array_event.push(date_event);

                    $('#responsive-modal-schedule-event').show();
                }else{
                    is_delete_flag_event = 0;
                }
            }

            function dismiss_modal(){
                selected_day_modal.classList.add('month_name_style');
                selected_day_modal.classList.remove('month_name_style_active');
                $('#responsive-modal-schedule').hide();
                selected_dates_array = [];
            }

            function dismiss_modal_event(){
                selected_day_modal_event.classList.add('month_name_style');
                selected_day_modal_event.classList.remove('month_name_style_active');
                $('#responsive-modal-schedule-event').hide();
                selected_dates_array_event = [];
            }

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
                    document.getElementById("to_time").value = "";
                    $('#hours_from_to').text(0);
                }
            }

            function set_time_event(){
                from_time_event = document.getElementById("from_time_event").value;
                to_time_event = document.getElementById("to_time_event").value;

                if(from_time_event < to_time_event){
                    var timeStart = new Date("01/01/2007 " +from_time_event);
                    var timeEnd = new Date("01/01/2007 " +to_time_event);

                    hourDiff = timeEnd - timeStart;   
                    hourDiff = (hourDiff / 60 / 60 / 1000).toFixed(2);

                    $('#hours_from_to_event').text(hourDiff);
                }else{
                    document.getElementById("to_time_event").value = "";
                    $('#hours_from_to_event').text(0);
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

            function setDayWeekEvent(selectedDate,ID){
                var selectedDaySpan = document.getElementById(ID);

                if(selectedDaySpan.classList.contains("month_name_style")){
                    selectedDaySpan.classList.remove('month_name_style');
                    selectedDaySpan.classList.add('month_name_style_active');
                    selected_dates_array_event.push(selectedDate);
                }else if(selectedDaySpan.classList.contains("month_name_style_active")){
                    selectedDaySpan.classList.add('month_name_style');
                    selectedDaySpan.classList.remove('month_name_style_active');
                    var index = selected_dates_array_event.indexOf(selectedDate);
                    selected_dates_array_event.splice(index, 1);
                }

            }

            function pre_defined_selected(){
                var pre_id = $("#pre_defined_shifts").val();

                var fd = new FormData();
                fd.append('pre_id',pre_id);

                $.ajax({
                    url:'util_get_pre_shifts.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        console.log(response);
                        if(pre_id == 0){
                            $("#message-text").val('');
                            $("#from_time").val('09:00');
                            $("#to_time").val('17:00');
                            $("#break_mint").val('');
                            $("#hours_from_to").val('8');
                        }else{
                            const myArray = response.split(",");

                            $("#message-text").val(myArray[0]);
                            $("#from_time").val(myArray[1]);
                            $("#to_time").val(myArray[2]);
                            $("#break_mint").val(myArray[3]);
                            $("#hours_from_to").val(myArray[4]);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }

            function save_shift(){
                var repeat_until = $("#repeat_until").val();
                var msg = $("#message-text").val();
                from_time = $("#from_time").val();
                to_time = $("#to_time").val();
                var timeStart = new Date("01/01/2007 " +from_time);
                var timeEnd = new Date("01/01/2007 " +to_time);

                var break_mint = $("#break_mint").val();
                var new_break_mint = 0;
                if(break_mint != 0){
                    new_break_mint = break_mint/60;
                }

                hourDiff = timeEnd - timeStart;   
                hourDiff = ((hourDiff / 60 / 60 / 1000) - new_break_mint).toFixed(2);

                if(user_id == "" || from_time == "" || to_time == "" || hourDiff == "" || selected_dates_array.length === 0){
                    alert("Seleziona tutti i campi tranne le note di turno.");
                }else{
                    const temp = String(selected_dates_array);
                    var fd = new FormData();
                    fd.append('dates',temp);
                    fd.append('assign_to',user_id);
                    fd.append('message',msg);
                    fd.append('repeat_until',repeat_until);
                    fd.append('start_time',from_time);
                    fd.append('break_mints',break_mint);
                    fd.append('end_time',to_time);
                    fd.append('total_hours',hourDiff);
                    fd.append('till_closing',0);
                    fd.append('till_business_decline',0);

                    $.ajax({
                        url:'util_save_shift.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            if(response == "1"){
                                dismiss_modal();
                                Swal.fire({
                                    title: 'Turno salvato.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            }else{
                                alert("Turni non salvati.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });

                }

            }

            function save_event(){

                var msg = $("#message-text-event").val();
                var title = $("#title-event").val();
                from_time = $("#from_time_event").val();
                to_time = $("#to_time_event").val();
                var timeStart = new Date("01/01/2007 " +from_time);
                var timeEnd = new Date("01/01/2007 " +to_time);

                hourDiff = timeEnd - timeStart;   
                hourDiff = (hourDiff / 60 / 60 / 1000).toFixed(2);

                if(from_time == "" || to_time == "" || hourDiff == "" || title == "" || selected_dates_array_event.length === 0){
                    alert("Seleziona Tutti i campi.");
                }else{
                    const temp = String(selected_dates_array_event);
                    var fd = new FormData();
                    fd.append('dates',temp);
                    fd.append('message',msg);
                    fd.append('start_time',from_time);
                    fd.append('end_time',to_time);
                    fd.append('total_hours',hourDiff);
                    fd.append('title',title);

                    $.ajax({
                        url:'util_save_shift_event.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            if(response == "1"){
                                dismiss_modal_event();
                                Swal.fire({
                                    title: 'Evento salvato.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.reload();
                                    }
                                });
                            }else{
                                alert("Evento non salvato.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });

                }

            }


            function notify_changes(s1,s2){
                var fd1 = new FormData();
                fd1.append('start_date',s1);
                fd1.append('end_date',s2);

                $.ajax({
                    url:'util_notify_shift_changes.php',
                    type: 'post',
                    data:fd1,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        console.log(response);
                        if(response == "1"){
                            Swal.fire({
                                title: 'Sposta le modifiche notifica agli utenti.',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            });
                        }else{
                            alert("Modifiche già notificate.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }


            function show_schedule_filter(slug_flag){

                let params = (new URL(window.location.href)).searchParams;

                var temp = window.location.href.split("&filter=");

                if(params.get('date') || params.get('departments')){
                    currentUrlWithoutParams = temp[0]+"&filter=" + slug_flag;
                }else{
                    currentUrlWithoutParams = "?filter=" + slug_flag;
                }


                window.location.href = currentUrlWithoutParams;
            }


            function hide_show_until_date_delete(){

                var selected_value_flag_delete_shift = $("#delete_shift_select").val();

                if(selected_value_flag_delete_shift == 3){
                    $("#delete_shift_date_form").show();
                }else{
                    $("#delete_shift_date_form").hide();
                }
            }

            function dismiss_modal_delete_shift(){
                $('#responsive-modal-delete-shift').hide();
            }


            var global_shift_delete_id=0;
            function delete_modal_user(id){
                global_shift_delete_id = id;
                is_delete_flag = 1;


                $('#responsive-modal-delete-shift').show();

            }

            function delete_schedule(){

                $('#responsive-modal-delete-shift').hide();
                is_delete_flag = 1;
                var selected_value_flag_delete_shift_date = "";
                var selected_value_flag_delete_shift = $("#delete_shift_select").val();
                var delete_shift_select_apply_users_ = $("#delete_shift_select_apply_users").val();
                if(selected_value_flag_delete_shift == 3){
                    selected_value_flag_delete_shift_date = $("#delete_shift_date").val();
                }

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Non sarai in grado di ripristinare questo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, eliminalo!',
                    cancelButtonText: 'Annulla'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_delete_shifts_lib.php',
                            method:'POST',
                            data:{ repeat_type:selected_value_flag_delete_shift, repeat_until_date:selected_value_flag_delete_shift_date, id:global_shift_delete_id, apply_on:delete_shift_select_apply_users_ },
                            success:function(response){
                                console.log(response);
                                if(response == "Updated"){
                                    Swal.fire({
                                        title: 'Eliminato',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    })
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Qualcosa è andato storto!',
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

            function edit_schedule(id){
                is_delete_flag = 1;
                window.location.href = "edit_schedule.php?id="+id;
            }

            function delete_event(id){
                is_delete_flag_event = 1;

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Non sarai in grado di ripristinare questo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, eliminalo!',
                    cancelButtonText: 'Annulla'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_update_status.php',
                            method:'POST',
                            data:{ tablename:"tbl_shift_events", idname:"svnts_id", id:id, statusid:1,statusname: 'is_delete'},
                            success:function(response){
                                console.log(response);
                                if(response == "Updated"){
                                    Swal.fire({
                                        title: 'Eliminato',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    })
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Qualcosa è andato storto!',
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

            function edit_event(id){
                is_delete_flag_event = 1;
                window.location.href = "edit_schedule_event.php?id="+id;
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

            function redirect_to_off_time(){
                from_time = $("#from_time").val();
                to_time = $("#to_time").val();
                var timeStart = new Date("01/01/2007 " +from_time);
                var timeEnd = new Date("01/01/2007 " +to_time);

                hourDiff = timeEnd - timeStart;   
                hourDiff = (hourDiff / 60 / 60 / 1000).toFixed(2);
                window.location.href = "add_time_off.php?user="+user_id+"&date="+date+"&hours="+hourDiff;
            }
            function redirect_to_blocked_day(){
                from_time = $("#from_time").val();
                to_time = $("#to_time").val();
                window.location.href = "add_blocked_day.php?user="+user_id+"&date="+date+"&from="+from_time+"&to="+to_time;
            }

            function forwardDate(){
                var date = document.getElementById('datepicker-autoclose').value;
                var changedDate = new Date(date);
                changedDate.setDate(changedDate.getDate() + 6);
                temp = moment(changedDate).format('MM/DD/YYYY');
                document.getElementById('endDate').value = temp;
                window.location.href = "schedules.php?scroll="+scroll_position+"&date=" + temp;
            }
            function backwardDate(){
                var date = document.getElementById('datepicker-autoclose').value;
                var changedDate = new Date(date);
                changedDate.setDate(changedDate.getDate() - 6);
                temp = moment(changedDate).format('MM/DD/YYYY');
                document.getElementById('endDate').value = temp;
                window.location.href = "schedules.php?scroll="+scroll_position+"&date=" + temp;
            }


            function copy_shift(shift_id_){
                is_delete_flag = 1;
                copied_id = shift_id_;
                copied_pre_id = 0;
                document.cookie = "copied_id_shift="+copied_id;
                document.cookie = "copied_id_pre_shift="+copied_pre_id;
                var x = document.getElementById("snackbar");
                x.className = "show";
                x.innerHTML="Maiusc copiato.";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
            }

            function paste_shift(user_id_,selected_date_){
                is_delete_flag = 1;

                copied_id = getCookie("copied_id_shift");
                copied_pre_id = getCookie("copied_id_pre_shift");

                if(copied_pre_id != 0){
                    $.ajax({
                        url:'util_copy_pre_defined_shift.php',
                        method:'POST',
                        data:{ pre_shift_id:copied_pre_id, assigned_to:user_id_, date:selected_date_ },
                        success:function(response){
                            console.log(response);
                            if(response == "1"){
                                Swal.fire({
                                    title: 'Turni predifiniti Incollato!',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Qualcosa è andato storto!',
                                    footer: ''
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else if(copied_id != 0){
                    $.ajax({
                        url:'util_copy_shift.php',
                        method:'POST',
                        data:{ shift_id:copied_id, assigned_to:user_id_, date:selected_date_ },
                        success:function(response){
                            console.log(response);
                            if(response == "1"){
                                Swal.fire({
                                    title: 'Maiusc Incollato!',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Qualcosa è andato storto!',
                                    footer: ''
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else{
                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    x.innerHTML="Niente copiato.";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
                }

                console.log(user_id_,selected_date_);
            }

            function copy_pre_shift(id_pre){
                console.log(id_pre);
                copied_pre_id = id_pre;
                copied_id = 0;
                document.cookie = "copied_id_shift="+copied_id;
                document.cookie = "copied_id_pre_shift="+copied_pre_id;
                var x = document.getElementById("snackbar");
                x.className = "show";
                x.innerHTML="Turni predifiniti copiato.";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
            }

            function getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for(let i = 0; i <ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return 0;
            }

            $("html").scrollTop(scroll_position);
        </script>
    </body>

</html>