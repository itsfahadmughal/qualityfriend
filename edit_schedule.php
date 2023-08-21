<?php
include 'util_config.php';
include 'util_session.php';

$id = 0;

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

$date = "";
$message = "";
$start_time = "";
$end_time = "";
$total_hours = "";
$till_closing = "";
$till_business_decline = "";
$assign_to=0;
$break_min=0;

$sql = "SELECT * FROM `tbl_shifts` WHERE sfs_id = $id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $date = $row['date'];
        $assign_to = $row['assign_to'];
        $message = $row['title'];
        $start_time = $row['start_time'];
        $end_time = $row['end_time'];
        $total_hours = $row['total_hours'];
        $till_closing = $row['till_closing'];
        $till_business_decline = $row['till_business_decline'];
        $break_min = $row['shift_break'];
    }
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
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
        <title>Edit Shift</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />


        <!-- Multiple Select -->
        <link href="./assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


        <link href="./dist/css/style.min.css" rel="stylesheet">
        <link href="./dist/css/time_schedule.css" rel="stylesheet">

        <!--        Tabs-->
        <link href="./dist/css/pages/tab-page.css" rel="stylesheet">

        <!-- Date picker plugins css -->
        <link href="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />


    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Edit Shift</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Edit Shift</h4>
                        </div>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row mt-5 mtm-0">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 pm-2rem">
                        <span class="cursor-pointer" onclick="history.back();"><i class="fas fa-chevron-left pr-1"></i> Schedules</span>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <label class="control-label display-inline w-30"><strong>Start Time</strong></label>
                                    <i class="fas pl-1-8 pr-3"></i>
                                    <label class="control-label display-inline w-30"><strong>End Time</strong></label>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="time" class="form-control display-inline w-30 wm-38" value="<?php echo $start_time; ?>" onchange="set_time();" id="from_time">
                                    <i class="fas fa-arrow-right pl-3 pr-3"></i>
                                    <input type="time" class="form-control display-inline w-30 wm-38" value="<?php echo $end_time; ?>" onchange="set_time();" id="to_time">

                                    <label for="message-text" class="control-label ml-1">Break <small>(min)</small></label>
                                    <input type="number" style="width:80px;" value="<?php echo $break_min; ?>" class="form-control display-inline w-30" min="0" max="240" id="break_mint" />
                                </div>
                                <div class="form-group ml-1 mb-0 mt-1">
                                    <label for="message-text" class="control-label mb-0"><i class="far fa-clock"></i> <span id="hours_from_to"><?php echo round($total_hours+($break_min/60),2); ?></span> Hours</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label class="control-label"><strong>Date</strong></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker-autoclose1" placeholder="<?php echo date("m/d/Y"); ?>" value="<?php echo date("m/d/Y", strtotime($date)); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div>
                                    <select class="form-control" id="edit_shift_select" onchange="hide_show_until_date_edit();">
                                        <option value="1">Edit Only This Shift</option>
                                        <option value="2">Edit All Shifts On the Following Same Weekdays</option>
                                        <option value="3">Edit All Shifts Till Certain Date</option>
                                    </select>
                                </div>
                                <div class="mt-3" id="edit_shift_date_form" style="display:none;">
                                    <label for="message-text" class="control-label ml-1"><b>Edit Until</b></label>
                                    <input type="date" class="form-control" id="edit_shift_date" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="control-label"><strong>Shift Notes</strong></label>
                            <textarea rows="4" class="form-control" id="message_"><?php echo $message; ?></textarea>
                        </div>

                        <div class="mt-3 mb-5 pb-5">
                            <input type="button" onclick="submit_shift();" class="btn mt-4 w-20 btn-info" value="Save">
                        </div>

                    </div>

                    <div class="col-lg-3"></div>
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

        <!-- Date Picker Plugin JavaScript -->
        <script src="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <script>
            // Date Picker
            jQuery('.mydatepicker, #datepicker').datepicker();
            jQuery('#datepicker-autoclose1').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            jQuery('#datepicker-autoclose2').datepicker({
                autoclose: true,
                todayHighlight: true
            });
        </script>


        <script> 
            var hourDiff = 0;
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


            function hide_show_until_date_edit(){

                var selected_value_flag_edit_shift = $("#edit_shift_select").val();

                if(selected_value_flag_edit_shift == 3){
                    $("#edit_shift_date_form").show();
                }else{
                    $("#edit_shift_date_form").hide();
                }
            }

            var date="";
            var start_time="";
            var end_time="";
            var till_closing=0;
            var till_bd=0;
            var message="";
            var id = '<?php echo $id; ?>';
            var assign_to = '<?php echo $assign_to; ?>';

            function submit_shift(){

                $('#responsive-modal-edit-shift').hide();
                var selected_value_flag_edit_shift_date = "";
                var selected_value_flag_edit_shift = $("#edit_shift_select").val();
                if(selected_value_flag_edit_shift == 3){
                    selected_value_flag_edit_shift_date = $("#edit_shift_date").val();
                }

                message = $("#message_").val();
                start_time = $("#from_time").val();
                end_time = $("#to_time").val();
                till_closing = 0;
                till_bd = 0;
                date =  document.getElementById("datepicker-autoclose1").value;

                var break_mint = $("#break_mint").val();
                var new_break_mint = 0;
                if(break_mint != 0){
                    new_break_mint = break_mint/60;
                }
                var timeStart = new Date("01/01/2007 " +start_time);
                var timeEnd = new Date("01/01/2007 " +end_time);

                hourDiff = timeEnd - timeStart;   
                hourDiff = ((hourDiff / 60 / 60 / 1000) - new_break_mint).toFixed(2);

                var fd1 = new FormData();
                fd1.append('date',date);
                fd1.append('start_time',start_time);
                fd1.append('end_time',end_time);
                fd1.append('hours_diff',hourDiff);
                fd1.append('break_mints',break_mint);
                fd1.append('till_closing',till_closing);
                fd1.append('till_bd',till_bd);
                fd1.append('message',message);
                fd1.append('id',id);
                fd1.append('repeat_type',selected_value_flag_edit_shift);
                fd1.append('repeat_until_date',selected_value_flag_edit_shift_date);
                fd1.append('assign_to',assign_to);

                if(date == "" || start_time == "" || end_time == ""){
                    alert("All Fields Must be Filled Except Shift Notes");
                }else{
                    $.ajax({
                        url:'util_edit_schedule.php',
                        type: 'post',
                        data:fd1,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            console.log(response);
                            if(response == "1"){
                                Swal.fire({
                                    title: 'Shift Saved.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.href = "schedules.php";
                                    }
                                });
                            }else{
                                alert("Something went wrong!");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }
            }
        </script>

    </body>

</html>