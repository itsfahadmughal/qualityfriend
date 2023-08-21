<?php
include 'util_config.php';
include '../util_session.php';
include 'read_xml.php';
include '../housekeeping_utills/util_auto_run.php';
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
        <title>Housekeeping</title>
        <!-- Footable CSS -->
        <link href="../assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/housekeeping.css" rel="stylesheet">

        <!--        for chart-->
        <link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">

        <link href="../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

        <style>
            .dis{
                display: none; 
            }
            .top_height{
                height: 20px;
            }

            .main_height{
                height: 30px;
            }
            .main_bottom{
                height: 20px;
            }
            .disabled-link {
                pointer-events: none;
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
                <p class="loader__label">Haushaltsführung</p>
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
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles mobile-container-padding heading_style">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Housekeeping</h4>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-3 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Housekeeping</a></li>
                                    <li class="breadcrumb-item text-success">Housekeeping</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row pr-4 mobile-container-padding">
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background-active text-center padding-top-8" onclick="redirect_url('housekeeping.php');">
                                <img src="../dist/images/housekeeping.png" />
                                <h6 class="text-white pt-2">Housekeeping</h6>
                            </div>
                        </div>
                        <?php if($housekeeping_admin == 1){ ?> 
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('cleaning.php');">
                                <img src="../dist/images/dailyplan.png" />
                                <h6 class="text-white pt-2">Tagespläne</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('housekeeping_settings.php');">
                                <img src="../dist/images/settings.png" />
                                <h6 class="text-white pt-2">Einstellungen</h6>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->


                    <div class="row">


                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pm-0">
                                    <div class="row mtm-10">
                                        <div class="col-lg-4 wm-80">
                                            <div class="input-group">
                                                <input type="text" style="border:1px solid #00BCEB" id="date_is" class="form-control" value="<?php echo date("l j F Y"); ?>" >
                                                <div class="input-group-append">
                                                    <span  class="input-group-text" style="background-color:#00BCEB;border:1px solid #00BCEB" ><i class="icon-calender" style="background-color:white"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 wm-20">
                                            <button id="submit"  type="button" onclick="filter()" class="btn btn-secondary">Filter</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div id="morris-donut-chart"></div>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <div class="row mt-5 pt-5 mtm-0">
                                                <div  id="" class="col-lg-4  col-md-4 wm-50">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_unassigned"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Nicht zugewiesen</b></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div  id="" class="col-lg-4  col-md-4 wm-50">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_dirty"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Schmutzig</b></span>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div  id="" class="col-lg-4  col-md-4 wm-50 mtm-20">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_clean"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Sauber</b></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div  id="" class="col-lg-4  col-md-4 wm-50 mt-3">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_cleaning_in_progress"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Säuberung im Gange</b></span>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div  id="" class="col-lg-4  col-md-4 wm-50 mt-3">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_inspection_in_progress"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Inspektion läuft</b></span>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div  id="" class="col-lg-4  col-md-4 wm-50 mt-3">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_inspected"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Inspiziert</b></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div  id="" class="col-lg-4  col-md-4 wm-50 mt-3">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_no_cleaning_desired"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>Keine Reinigung erwünscht</b></span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div  id="" class="col-lg-4  col-md-4 wm-50 mt-3">
                                                    <div class="row">
                                                        <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                            <div class="box_no_cleaning_today"></div>
                                                        </div>
                                                        <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                            <span><b>NEC-Express</b></span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row pl-3 pr-3 heading_style pt-3 pb-3">
                        <div id="room_checks" class="col-lg-11">
                            <h4><b>Housekeeping</b></h4>
                        </div>
                    </div>

                    <div id="rooms_list" class="row pl-3 pr-3 heading_style pt-3 pb-3 mbm-20">
                        <?php include 'housekeeping_filter.php'; ?>
                    </div>
                    <?php 

                    if($housekeeping == 1){
                        $sql="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0";
                        $result = $conn->query($sql);
                        $i = 0;
                        if ($result && $result->num_rows > 0) { ?>

                    <div class="row pl-3 pr-3 heading_style pt-3 pb-3 mbm-20">


                        <div class="col-lg-12  col-md-12">
                            <h3 class="mt-3">Heute zusätzliche Jobs</h3> 
                            <div class="row" >
                                <?php

                            while($row = mysqli_fetch_array($result)) { 
                                $hkej_id                = $row["hkej_id"];
                                $time_to_complate       = $row["time_to_complate"];
                                $job_title              = $row["job_title"];
                                $is_completed = 0;
                                $sql12="SELECT * FROM `tbl_ housekeeping_extra_jobs_completed_check` WHERE `assign_to` =  $user_id AND assign_date = '$current_date' AND extra_job_id = $hkej_id";
                                $result12 = $conn->query($sql12);
                                if ($result12 && $result12->num_rows > 0) {
                                    while($row12 = mysqli_fetch_array($result12)) {
                                        $is_id                = $row12["id"];
                                        $is_completed         = $row12["is_completed"];
                                        $assgin_date          = $row["assgin_date"]; 
                                        $complate_date        = $row["complate_date"];


                                    }}else{
                                    continue;
                                }


                                if($is_completed == 0){
                                    $is_completed = "";
                                }else{
                                    $is_completed = "checked";
                                }

                                ?>
                                <div  id="" class="col-lg-4  col-md-4">
                                    <div class="row div-white-background  room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
                                        <div  class="col-lg-9">
                                            <span><?php echo $job_title; ?></span>
                                        </div>
                                        <div class="col-lg-3">
                                            <input <?php echo $is_completed; ?> onchange="completed_extra_job('<?php
                                echo $is_id ?>','<?php echo "completed_check_".$is_id; ?>')" id="completed_check_<?php echo $is_id; ?>" type="checkbox" class="checkbox-size-20 pt-2">
                                        </div>


                                    </div>

                                </div>
                                <?php }?>

                            </div>


                        </div>




                    </div>
                    <?php } }?>

                    <?php  


                    $show_other = 0 ;
                    $sql_task="SELECT * FROM `tbl_housekeeping_user_rule` WHERE `hotel_id` = $hotel_id";
                    $result_task = $conn->query($sql_task);
                    if ($result_task && $result_task->num_rows > 0) {
                        while($row_task = mysqli_fetch_array($result_task)) {
                            $show_other = $row_task['show_other'];

                        } 

                    }

                    if( $show_other == 1){


                    ?>


                    <div id="housekeeping_cleaner" class="col-lg-12  col-md-12 pr-4 mt-4 mbm-20">
                        <div class="row div-background pt-3 pb-4" >
                            <div  id="" class="col-lg-12  col-md-12">
                                <h3>Alle Zusatzaufgaben</h3>
                            </div>
                            <?php 
                        $div_id =0;
                        $sql="SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id and user_id != $user_id  ORDER BY `tbl_user`.`user_id` DESC";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            $i=1;
                            while($row = mysqli_fetch_array($result)) {

                                $user_id_a =   $row['user_id'];
                                $firstname =   $row['firstname'];
                                $lastname =   $row['lastname'];
                                $email = $row['email'];

                                $usert_id_ = $row['usert_id'];
                                $current_date =   date("Y-m-d");

                                $user_type = "";
                                $depart_name = "";
                                $sql2="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id and usert_id = $usert_id_ and is_delete = 0) OR `hotel_id` =  0";
                                $result2 = $conn->query($sql2);
                                if ($result2 && $result2->num_rows > 0) {
                                    while($row2 = mysqli_fetch_array($result2)) {
                                        $user_type = $row2['user_type'];
                                    }
                                }
                                $housekeeping_assign = 0;
                                $user_type_id = $row['usert_id'];
                                $sql12="SELECT * FROM `tbl_rules`  WHERE `usert_id` = $user_type_id";
                                $result12 = $conn->query($sql12);
                                if ($result12 && $result12->num_rows > 0) {
                                    while($row12 = mysqli_fetch_array($result12)) {
                                        $housekeeping_assign =$row12['rule_13'];
                                    } 
                                }
                                if($housekeeping_assign == 1 && $usert_id_ != 1 ){



                            ?>

                            <div  id="" class="col-lg-12  col-md-6">

                                <div class="row div-white-background pointer room_text_center pt-3 pb-3 ml-1 mr-1 mt-2 divacb"  accesskey=""
                                     >
                                    <div align="left" class="col-12">
                                        <h4>
                                            <b><?php echo $firstname; ?></b>
                                        </h4>
                                    </div>





                                    <?php


                                    $sql_20="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0";
                                    $result_20 = $conn->query($sql_20);
                                    $i = 0;
                                    if ($result_20 && $result_20->num_rows > 0) {






                                        while($row20 = mysqli_fetch_array($result_20)) { 


                                            $hkej_id                = $row20["hkej_id"];
                                            $time_to_complate       = $row20["time_to_complate"];
                                            $job_title              = $row20["job_title"];
                                            $is_completed = 0;
                                            $sql12="SELECT * FROM `tbl_ housekeeping_extra_jobs_completed_check` WHERE `assign_to` =  $user_id_a AND assign_date = '$current_date' AND extra_job_id = $hkej_id";
                                            $result12 = $conn->query($sql12);
                                            if ($result12 && $result12->num_rows > 0) {
                                                while($row12 = mysqli_fetch_array($result12)) {
                                                    $is_id                = $row12["id"];
                                                    $is_completed         = $row12["is_completed"];
                                                    $assgin_date          = $row20["assgin_date"]; 
                                                    $complate_date        = $row20["complate_date"];


                                                }}else{
                                                continue;
                                            }


                                            if($is_completed == 0){
                                                $is_completed = "";
                                            }else{
                                                $is_completed = "checked";
                                            }
                                    ?>
                                    <div  id="" class="col-lg-4  col-md-4">
                                        <div class="row div-white-background  room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
                                            <div  class="col-lg-9">
                                                <span><?php echo $job_title; ?></span>
                                            </div>
                                            <div class="col-lg-3">
                                                <input disabled <?php echo $is_completed; ?> onchange="completed_extra_job('<?php
                                            echo $is_id ?>','<?php echo "completed_check_".$is_id; ?>')" id="completed_check_<?php echo $is_id; ?>" type="checkbox" class="checkbox-size-20 pt-2">
                                            </div>


                                        </div>

                                    </div>
                                    <?php }?>









                                    <?php }?>






                                </div>
                            </div>
                            <?php 


                                }
                            }
                        }
                            ?>

                        </div>
                    </div>


                    <?php }?>


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
            </div>
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

        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
        <script src="../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <!--Morris JavaScript -->
        <script src="../assets/node_modules/raphael/raphael.min.js"></script>
        <script src="../assets/node_modules/morrisjs/morris.js"></script>
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
        <script>
            var checks_array = <?php echo json_encode($room_checklist_array); ?>;
            var checks_array_id = <?php echo json_encode($room_id_checklist_array); ?>;
            var inner_checks = document.getElementById("room_checks");
            for (let i = 0; i < checks_array.length; i++) {
                console.log(checks_array[i]);
                inner_checks.innerHTML += "<h5>"+checks_array[i]+" <b onclick='check_listfa("+checks_array_id[i]+")' id='"+checks_array_id[i] +"'class='pointer' style='color:red;'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  x  </b></h5> ";
            }
            function check_listfa(id) {
                $.ajax({
                    url:'../housekeeping_utills/utill_update_room_checklist.php',
                    method:'POST',
                    data:{ id:id,check:1,from:"from"},
                    success:function(response){
                        console.log(response);
                        location.reload('housekeeping.php');
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }

        </script>
        <script>
            $('#date_is').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY',time: false, date: true });            

            var    total_unassign_room = <?php echo $total_assign_room;  ?>;
            var    total_dirty_room = <?php echo $total_dirty_room;  ?>;
            var    total_cleaning_in_progress_room = <?php echo $total_cleaning_in_progress_room;  ?>;
            var    total_clean_room = <?php echo $total_clean_room;  ?>;
            var    total_inspection_in_progress_room = <?php echo $total_inspection_in_progress_room;  ?>;
            var    total_inspected_room = <?php echo $total_inspected_room;  ?>;
            var    total_no_cleaning_desired_room = <?php echo $total_no_cleaning_desired_room;  ?>;
            var not_required_to_clean = <?php echo $total_dirty_room_not_required_to_clean; ?>;
            Morris.Donut({
                element: 'morris-donut-chart',
                data: [{
                    label: "",
                    value: total_unassign_room,

                }, {
                    label: "",
                    value: total_dirty_room
                }, {
                    label: "",
                    value: total_clean_room
                },{
                    label: "",
                    value: total_cleaning_in_progress_room,

                }, {
                    label: "",
                    value: total_inspection_in_progress_room
                }, {
                    label: "",
                    value: total_inspected_room
                },{
                    label: "",
                    value: total_no_cleaning_desired_room
                },{
                    label: "NEC-Express",
                    value: not_required_to_clean
                }],
                resize: true,
                colors:['#fad12f', '#ff0000', '#2799fc','#83cdfd', '#9cdeba', '#4ac382','#B2BEB5','#ff8800']
            });
        </script>
        <script>

            var abc ;
            $('#inner').on('click', function (ev) { 
                abc = ev ;
            });
            function open_model(task_list){
                abc.stopPropagation(); 
                let text = task_list;
                const task_Array = text.split(",");
                console.log(task_Array[1]);
                $('#open_model').modal('show');
                var inner_task = document.getElementById("inner_task");
                inner_task.innerHTML = "";
                for (let i = 0; i < task_Array.length; i++) {
                    inner_task.innerHTML += "<h6>"+task_Array[i]+"</h6>";
                }
            }
            function doubleclick(el, onsingle, ondouble) {
                if (el.getAttribute("data-dblclick") == null) {
                    el.setAttribute("data-dblclick", 1);
                    setTimeout(function () {
                        if (el.getAttribute("data-dblclick") == 1) {
                            onsingle();
                        }
                        el.removeAttribute("data-dblclick");
                    }, 300);
                } else {
                    el.removeAttribute("data-dblclick");
                    ondouble();
                }
            }
        </script>

        <script>

            // jQuery 1.7+ 
            function filter() {
                let date_is=document.getElementById("date_is").value;
                $.ajax({
                    url:'housekeeping_filter.php',
                    method:'POST',
                    data:{ date_is:date_is},
                    success:function(response){
                        document.getElementById("rooms_list").innerHTML = response;  
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }


            function open_tast() {

                console.log("jjjd");

            }

            function redirect_url(url) {
                window.location.href = url;
            }
            function completed_extra_job(is_id,input_id) {
                var completed = document.getElementById(input_id).checked;

                if(completed == false){
                    completed = 0;
                }else{
                    completed = 1  ;
                }


                $.ajax({
                    url:'../housekeeping_utills/utill_housekeeping_extra_jobs.php',
                    method:'POST',
                    data:{ is_id:is_id, completed:completed},
                    success:function(response){
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }


        </script>

        <script>
            jQuery(document).ready(function() {
                // Switchery
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                $('.js-switch').each(function() {
                    new Switchery($(this)[0], $(this).data());
                });
                // For select 2
                $(".select2").select2();
                $('.selectpicker').selectpicker();
                //Bootstrap-TouchSpin
                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }
                $("input[name='tch1']").TouchSpin({
                    min: 0,
                    max: 100,
                    step: 0.1,
                    decimals: 2,
                    boostat: 5,
                    maxboostedstep: 10,
                    postfix: '%'
                });
                $("input[name='tch2']").TouchSpin({
                    min: -1000000000,
                    max: 1000000000,
                    stepinterval: 50,
                    maxboostedstep: 10000000,
                    prefix: '$'
                });
                $("input[name='tch3']").TouchSpin();
                $("input[name='tch3_22']").TouchSpin({
                    initval: 40
                });
                $("input[name='tch5']").TouchSpin({
                    prefix: "pre",
                    postfix: "post"
                });
                // For multiselect
                $('#pre-selected-options').multiSelect();
                $('#optgroup').multiSelect({
                    selectableOptgroup: true
                });
                $('#public-methods').multiSelect();
                $('#select-all').click(function() {
                    $('#public-methods').multiSelect('select_all');
                    return false;
                });
                $('#deselect-all').click(function() {
                    $('#public-methods').multiSelect('deselect_all');
                    return false;
                });
                $('#refresh').on('click', function() {
                    $('#public-methods').multiSelect('refresh');
                    return false;
                });
                $('#add-option').on('click', function() {
                    $('#public-methods').multiSelect('addOption', {
                        value: 42,
                        text: 'test 42',
                        index: 0
                    });
                    return false;
                });
                $(".ajax").select2({
                    ajax: {
                        url: "https://api.github.com/search/repositories",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function(data, params) {
                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;
                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1,
                    // templateResult: formatRepo, // omitted for brevity, see the source of this page
                    //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
                });
            });
        </script>
        <!-- jQuery peity -->
        <script src="../assets/node_modules/tablesaw/dist/tablesaw.jquery.js"></script>
        <script src="../assets/node_modules/tablesaw/dist/tablesaw-init.js"></script>
    </body>
</html>