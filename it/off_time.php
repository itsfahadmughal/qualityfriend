<?php
include 'util_config.php';
include '../util_session.php';

$emp = '';
$sts = '';
$sub_sql = "";
if(isset($_GET['employee'])){
    $emp = $_GET['employee'];

    $sub_sql = "AND a.request_by = ".$emp;

}
if(isset($_GET['status'])){
    $sts = $_GET['status'];

    $sub_sql .= " AND a.status = '".$sts."'";

}

$sql_alert="UPDATE `tbl_alert` SET `is_viewed`='1' WHERE `user_id` = $user_id AND `id_table_name` = 'tbl_time_off'";
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
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Assenze</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />


        <!-- Multiple Select -->
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/time_schedule.css" rel="stylesheet">

        <!--        Tabs-->
        <link href="../dist/css/pages/tab-page.css" rel="stylesheet">


        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.css" rel="stylesheet">

        <style>

            #calendar {
                width: 100%;
            }

            .fc-header-title > h2{
                font-size: 1.2rem;
                color: black;
                margin-bottom: 0px;
            }
            .fc-header-left{
                border-right: 0px;
                padding: 15px !important;
            }
            .fc-header-center{
                border-right: 0px;
                border-left: 0px;
            }
            .fc-header-right{
                border-left: 0px;
            }
            .fc-header .fc-button{
                margin-bottom: 0px;
            }
            .fc-event{
                background-color: rgb(54,190,166,0.1);
                border: 0px;
                color: black !important;
            }
            .fc-event-title:before {
                content:"• ";
                color: #36bea6;
            }

            #snackbar {
                visibility: hidden;
                min-width: 250px;
                margin-left: -125px;
                background-color: #252c35;
                color: #fff;
                text-align: center;
                border-radius: 2px;
                padding: 16px;
                position: fixed;
                z-index: 1;
                left: 50%;
                bottom: 30px;
                font-size: 17px;
            }
            #snackbar.show {
                visibility: visible;
                -webkit-animation: fadein 1.0s, fadeout 1.0s 2.5s;
                animation: fadein 1.0s, fadeout 1.0s 2.5s;
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
                <p class="loader__label">Assenze</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Assenze</h4>
                        </div>

                        <?php  if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                        <div class="col-md-9 text-right">
                            <label class="btn btn-dark">
                                <input type="checkbox" 
                                       <?php $sql_check = "SELECT * FROM `tbl_time_schedule_rules` WHERE hotel_id = $hotel_id AND is_time_off_enable = 0";
                                                                                   $result_check = $conn->query($sql_check);
                                                                                   if($result_check && $result_check->num_rows > 0){ echo ''; }else{ echo 'checked'; } ?>
                                       onchange="shift_rule_change();" id="md_checkbox_22" class="filled-in chk-col-light-blue">
                                <label class="mb-0" for="md_checkbox_22">&nbsp;Abilita tempo di inattività per gli utenti</label>
                            </label>
                        </div>
                        <?php } ?>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body pm-0">
                                <div class="vtabs customvtab">
                                    <ul class="nav nav-tabs tabs-vertical" role="tablist">
                                        <li class="nav-item w-150-custom"> <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-pool"></i></span> <span class="hidden-xs-down">Richiesta</span> </a> </li>
                                        <li class="nav-item w-150-custom" onclick="showCalendar();"> <a class="nav-link" data-toggle="tab" href="#profile3" role="tab"><span class="hidden-sm-up"><i class="fas fa-hand-holding"></i></span> <span class="hidden-xs-down">Calendario</span></a> </li><?php   if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                                        <li class="nav-item w-150-custom"> <a class="nav-link" data-toggle="tab" href="#messages3" role="tab"><span class="hidden-sm-up"><i class="fas fa-dollar-sign"></i></span> <span class="hidden-xs-down">Vacanze</span></a> </li> <?php } ?>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content w-100 pm-1rem">
                                        <div class="tab-pane active" id="home3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>

                                                <div class="col-lg-10 pm-0">
                                                    <h3 class="mb-5 mbm-20"><b>Richieste</b><button type="button" onclick="location.href = 'add_time_off.php';" class="btn btn-success f-right"><i class="fas fa-plus"></i> <?php   if ($Create_view_schedules == 1 || $usert_id == 1) {echo 'Aggiungi';}else{echo 'Richiesta';} ?> assenza</button></h3>

                                                    <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { }else{?>
                                                    <div class="row mb-3 p-3 border-timeoff">
                                                        <div class="col-lg-4 text-center">
                                                            <h3>Permesso non retribuito</h3>

                                                            <h2 class="display-inline"><?php
    $sql_unpaid = "SELECT SUM(total_hours) as th FROM `tbl_time_off` WHERE category = 'UNPAID' AND status = 'APPROVED' AND request_by = $user_id";
    $result_unpaid = $conn->query($sql_unpaid);

    if ($result_unpaid && $result_unpaid->num_rows > 0) {
        while($row = mysqli_fetch_array($result_unpaid)) {
            if($row['th'] == null){echo '0';}else{echo $row['th'];}
        }
    }?></h2> <h5 class="display-inline">ore</h5>
                                                            <p class="mb-0">Approvato (YTD)</p>
                                                        </div>
                                                        <div class="col-lg-4 text-center">
                                                            <h3>Permesso retribuito</h3>
                                                            <h2 class="display-inline"><?php
    $sql_paid = "SELECT SUM(total_hours) as th FROM `tbl_time_off` WHERE category = 'PAID' AND status = 'APPROVED' AND request_by = $user_id";
    $result_paid = $conn->query($sql_paid);

    if ($result_paid && $result_paid->num_rows > 0) {
        while($row = mysqli_fetch_array($result_paid)) {
            if($row['th'] == null){echo '0';}else{echo $row['th'];}
        }
    }?></h2> <h5 class="display-inline">ore</h5>
                                                            <p class="mb-0">Approvato (YTD)</p>
                                                        </div>
                                                        <div class="col-lg-4 text-center">
                                                            <h3>Congedo per malattia retribuito</h3>
                                                            <h2 class="display-inline"><?php
    $sql_paidsick = "SELECT SUM(total_hours) as th FROM `tbl_time_off` WHERE category = 'PAID_SICK' AND status = 'APPROVED' AND request_by = $user_id";
    $result_paidsick = $conn->query($sql_paidsick);

    if ($result_paidsick && $result_paidsick->num_rows > 0) {
        while($row = mysqli_fetch_array($result_paidsick)) {
            if($row['th'] == null){echo '0';}else{echo $row['th'];}
        }
    }?></h2> <h5 class="display-inline">ore</h5>
                                                            <p class="mb-0">Approvato (YTD)</p>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="row mb-3">
                                                        <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                                                        <div class="col-lg-6">
                                                            <select id="select1" onchange="apply_filter('employee');" class="form-control custom-select wm-250px">
                                                                <option value="0">Tutti i collaboratori</option>
                                                                <?php 
    $sql="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            if($row[2] != ""){
                $username = $row[2];
            } ?>
                                                                <option <?php if($emp == $row[0]){echo 'selected';}else{echo '';} ?> value='<?php echo $row[0]; ?>'><?php echo $username; ?></option>

                                                                <?php     
        }   
    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="col-lg-6 mtm-10">
                                                            <select id="select3" onchange="apply_filter('status');" class="form-control custom-select wm-250px">
                                                                <option value="0">All Statuses</option>
                                                                <option value='APPROVED' <?php if($sts == 'APPROVED'){echo 'selected';}else{echo '';} ?> >Approvato</option>
                                                                <option value='DECLINE' <?php if($sts == 'DECLINE'){echo 'selected';}else{echo '';} ?>>Declino</option>
                                                                <option value='PENDING' <?php if($sts == 'PENDING'){echo 'selected';}else{echo '';} ?>>In attesa</option>
                                                            </select>
                                                        </div>
                                                    </div>





                                                    <?php 
                                                    $calend = 0;
                                                    $year_e=array();
                                                    $month_e=array();
                                                    $day_e=array();
                                                    $name_e=array();
                                                    $nn=0;
                                                    if ($Create_view_schedules == 1 || $usert_id == 1) { 
                                                        $sql="SELECT a.*,b.address,b.firstname,b.lastname FROM `tbl_time_off` as a INNER JOIN `tbl_user` as b on a.request_by = b.user_id where a.hotel_id = $hotel_id ".$sub_sql." AND a.is_active = 1 AND a.is_delete = 0 AND a.category != 'HOLIDAY' ORDER BY a.tmeo_id DESC";
                                                    }else{
                                                        $sql="SELECT a.*,b.address,b.firstname,b.lastname FROM `tbl_time_off` as a INNER JOIN `tbl_user` as b on a.request_by = b.user_id where a.hotel_id = $hotel_id ".$sub_sql." AND a.is_active = 1 AND a.is_delete = 0 AND a.category != 'HOLIDAY' AND a.request_by = $user_id ORDER BY a.tmeo_id DESC";
                                                    }
                                                    $result = $conn->query($sql);
                                                    if ($result && $result->num_rows > 0) {
                                                        $calend = 1;
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="shift_pool_tables wm-100 table table-bordered table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">Collaboratore</th>
                                                                    <th class="">Data della richiesta</th>
                                                                    <th class="">Categoria</th>
                                                                    <th class="">Data Assenza</th>
                                                                    <th class="text-center">Stato</th>
                                                                    <th class="text-center ">Eliminare</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $year_e[$nn] = date("Y", strtotime($row['date']));
                                                            $month_e[$nn] = date("m", strtotime($row['date']));
                                                            $day_e[$nn] = date("d", strtotime($row['date']));
                                                            $name_e[$nn] = $row['firstname'].' '.$row['lastname'];

                                                            $nn++;
                                                                ?>
                                                                <tr>
                                                                    <td class="text-left">
                                                                        <img src="<?php echo $row['address']; ?>" onerror="this.src='../assets/images/users/user.png'"  alt="user" width="40" height="40" class="mr-2 rounded-circle"  /><?php echo $row['firstname']; ?>
                                                                    </td>
                                                                    <td><?php echo date("m-d-Y", strtotime($row['entrytime'])); ?></td>
                                                                    <td><?php if($row['category'] == "PAID"){echo "Vacanza";}elseif($row['category'] == "UNPAID"){echo "Vacanza non pagati";}elseif($row['category'] == "PAID_SICK"){echo "Malattia";} ?><br>
                                                                        <small><?php echo $row['total_hours']; ?> ore approvate(YTD)</small></td>
                                                                    <td><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                                                                        <div class="btn-group">
                                                                            <span id="offtime_status_<?php echo $row['tmeo_id'];  ?>" class="dropdown-toggle label label-table label-<?php if($row['status'] == "APPROVED"){echo 'success';}else if($row['status'] == "DECLINE"){echo 'danger';}else{ echo 'warning';} ?> pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if($row['status'] == 'APPROVED'){echo 'Approvato';}else if($row['status'] == "DECLINE"){echo 'Declino';}else if($row['status'] == "PENDING"){echo 'In attesa';} ?></span>
                                                                            <div class="dropdown-menu animated flipInY">
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="update_status('APPROVED',<?php echo $row['tmeo_id'];  ?>,'<?php echo $row['status'];  ?>');">Approvato</a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="update_status('DECLINE',<?php echo $row['tmeo_id'];  ?>,'<?php echo $row['status'];  ?>');">Declino</a>
                                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="update_status('PENDING',<?php echo $row['tmeo_id'];  ?>,'<?php echo $row['status'];  ?>');">In attesa</a>
                                                                            </div>
                                                                        </div>
                                                                        <?php }else{ ?>
                                                                        <span class="btn w-100 btn-<?php if($row['status'] == "APPROVED"){echo 'success';}else if($row['status'] == "DECLINE"){echo 'danger';}else{ echo 'secondary';} ?> d-lg-block "><?php if($row['status'] == 'APPROVED'){echo 'Approvato';}else if($row['status'] == "DECLINE"){echo 'Declino';}else if($row['status'] == "PENDING"){echo 'In attesa';} ?></span>
                                                                        <?php } ?>
                                                                    </td>

                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a href="javascript:void(0)" onclick="delete_off_time(<?php echo $row['tmeo_id'] ?>);" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                                                    </td>

                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="../assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Nessuna richiesta trovata</b></h5>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="profile3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>

                                                <div class="col-lg-10 pm-0">
                                                    <h3 class="mb-5"><button type="button" onclick="location.href = 'add_time_off.php';" class="btn btn-success f-right"><i class="fas fa-plus"></i> <?php   if ($Create_view_schedules == 1 || $usert_id == 1) {echo 'Aggiungi';}else{echo 'Richiesta';} ?> assenza</button></h3>
                                                    <?php if($calend==1){ ?>
                                                    <div class="m-t-30">
                                                        <div id="calendar">

                                                        </div>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="../assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Nessun turno offerto</b></h5>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="messages3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>
                                                <?php 
                                                $sql_block="SELECT a.* FROM `tbl_time_off` as a where a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category = 'HOLIDAY' ORDER BY a.tmeo_id DESC";
                                                ?>
                                                <div class="col-lg-10 pm-0">
                                                    <h3><b>Vacanze</b><button onclick="location.href = 'add_blocked_day.php';" type="button" class="btn btn-info f-right"><i class="fas fa-plus"></i> Aggiungi vacanza</button></h3>
                                                    <?php  $result = $conn->query($sql_block);
                                                    if ($result && $result->num_rows > 0) { ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="shift_pool_tables wm-100 table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Data</th>
                                                                    <th class="" >Titolo</th>
                                                                    <th class="" >Ora di inizio</th>
                                                                    <th class="" >Tempo scaduto</th>
                                                                    <th class="" >Tipo di vacanza</th>
                                                                    <th class="text-center">Azione</th>
                                                                    <th class="text-center ">Eliminare</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                        while ($row = mysqli_fetch_array($result)) {

                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo date("D F d, Y", strtotime($row['date'])); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['title']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['start_time']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['end_time']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['duration']; ?>
                                                                    </td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a  class="black_color" href="edit_blocked_day.php?id=<?php echo $row['tmeo_id']; ?>"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                                                    </td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a href="javascript:void(0)" onclick="delete_off_time(<?php echo $row['tmeo_id'] ?>);" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="../assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Nessuna richiesta trovata</b></h5>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="snackbar">Some text message..</div>
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


        <!-- Select2 Multi Select -->
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>


        <!--        Full Calendar View-->

        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js"></script>


        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <script>
            $("#select1").select2();
            $("#select2").select2();
            $("#select3").select2();
        </script>


        <script>

            var d_ = <?php echo json_encode($day_e); ?>;
            var m_ = <?php echo json_encode($month_e); ?>;
            var y_ = <?php echo json_encode($year_e); ?>;
            var n_ = <?php echo json_encode($name_e); ?>;


            var $calendar = $("#calendar");


            $calendar.fullCalendar({

                header: {
                    left: ' today,prev,next,  title',
                    right:'',
                },
                weekends: true,
                allDaySlot: true,
                droppable: true, 
                eventRender: function(event, e){
                    currentView = $('#calendar').fullCalendar('getView').name; 
                },dayClick: function(date, jsEvent, view) { 

                },
                eventClick: function(calEvent, jsEvent, view) {
                    console.log("===== eventClick =====");
                }
            });

            for(i=0;i<d_.length;i++){
                var newEvent = {
                    title: n_[i],
                    start: new Date(y_[i], m_[i], d_[i], 10),
                    end: new Date(y_[i], m_[i], d_[i], 15),
                    editable: true
                };

                $('#calendar').fullCalendar( 'renderEvent', newEvent , 'stick');
            }

            function showCalendar(){
                setTimeout(function() {
                    $('#calendar').fullCalendar('render');

                }, 1);
            }

        </script>

        <script>
            function delete_off_time(id){
                console.log(id);
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
                            data:{ tablename:"tbl_time_off", idname:"tmeo_id", id:id, statusid:1,statusname: "is_delete"},
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
                                            location.replace("off_time.php?slug=flag");
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

            function update_status(status,id,prev_status){
                console.log(status);
                var remove_class = "";
                var add_class = "";
                if(prev_status == "APPROVED"){
                    remove_class = "label-success";
                }
                if(prev_status == "DECLINE"){
                    remove_class = "label-danger";
                }
                if(prev_status == "PENDING"){
                    remove_class = "label-warning";
                }

                if(status == "APPROVED"){
                    add_class = "label-success";
                }
                if(status == "DECLINE"){
                    add_class = "label-danger";
                }
                if(status == "PENDING"){
                    add_class = "label-warning";
                }

                var id_ = '#offtime_status_'+id;

                $.ajax({
                    url:'util_update_status.php',
                    method:'POST',
                    data:{ tablename:"tbl_time_off", idname:"tmeo_id", id:id, statusid:status,statusname: "status"},
                    success:function(response){
                        console.log(response);
                        if(response == "Updated"){
                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            x.innerHTML="Il tuo stato è stato aggiornato con successo.";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);

                            $(id_).removeClass(remove_class);
                            $(id_).addClass(add_class);
                            $(id_).text(status);
                        }else{

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });

            }

            function apply_filter(flag){
                var value_="";
                var currentUrlWithoutParams = "";
                let params = (new URL(window.location.href)).searchParams;

                if(flag == 'status'){
                    value_ = $("#select3").val();
                    var temp = window.location.href.split("&status=");
                    if(value_ == '0'){
                        currentUrlWithoutParams = temp[0];
                    }else{
                        currentUrlWithoutParams = temp[0]+"&status=" + value_;
                    }
                }else if(flag == 'employee'){
                    value_ = $("#select1").val();
                    var temp = window.location.href.split("&employee=");
                    if(value_ == '0'){
                        currentUrlWithoutParams = temp[0];
                    }else{
                        currentUrlWithoutParams = temp[0]+"&employee=" + value_;
                    }
                }

                window.location.href = currentUrlWithoutParams;
                console.log(flag,value_);
            }

            function shift_rule_change(){
                var pool_rule_check = 0;
                if($('#md_checkbox_22:checked').val() == "on"){
                    pool_rule_check = 1;
                }else{
                    pool_rule_check = 0;
                }

                $.ajax({
                    url:'util_update_schedule_rule.php',
                    method:'POST',
                    data:{ slug:"off_time", rule_flag:pool_rule_check},
                    success:function(response){
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }


            function myFunction(x) {
                if (x.matches) { // If media query matches
                    $(".nav-tabs").addClass("customvtab");
                    $(".nav-tabs").removeClass("tabs-vertical");
                    $("div").removeClass("customvtab");
                    $("div").removeClass("vtabs");
                } else {
                    $(".card-body > div").addClass("customvtab");
                    $(".card-body > div").addClass("vtabs");

                    $(".nav-tabs").addClass("tabs-vertical");
                    $(".nav-tabs").removeClass("customvtab");
                }
            }

            var x = window.matchMedia("(max-width: 700px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction) // Attach listener function on state changes

        </script>
    </body>

</html>