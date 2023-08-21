<?php
include 'util_config.php';
include 'util_session.php';

$user_selected = "";
$date_selected = "";
$hours_selected = "";

if(isset($_GET['user'])){
    $user_selected = $_GET['user'];
}
if(isset($_GET['date'])){
    $date_selected = date("m/d/Y", strtotime($_GET['date']));
}
if(isset($_GET['hours'])){
    $hours_selected = $_GET['hours'];
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
        <title>Time off</title>
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
                <p class="loader__label">Time off</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Time off</h4>
                        </div>
                    </div>

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row mt-5">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4 pm-2rem ptm-0">
                        <span class="cursor-pointer" onclick="history.back();"><i class="fas fa-chevron-left pr-1"></i> Requests</span>
                        <div class="mt-4">
                            <label class="control-label"><strong>Category</strong></label>
                            <select id="select1" class="form-control custom-select">
                                <option value="PAID">Paid Time Off</option>
                                <option value="PAID_SICK">Paid Sick Time Off</option>
                                <option value="UNPAID">Unpaid Time Off</option>
                            </select>
                        </div>
                        <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                        <div class="mt-4">
                            <label class="control-label"><strong>Employee</strong></label>
                            <select id="select3" class="form-control custom-select">
                                <option value="0">Select Employee</option>
                                <?php 
    $sql="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            if($row[0] == $user_selected){
                echo '<option selected value='.$row[0].'>'.$row[2].' '.$row[3].'</option>';
            }else{
                echo '<option value='.$row[0].'>'.$row[2].' '.$row[3].'</option>';
            }
        }   
    }
                                ?>
                            </select>
                        </div>
                        <?php } ?>
                        <div class="mt-3">
                            <label class="control-label"><strong>Duration</strong></label>
                            <select onchange="to_offtime_date();" id="select2" class="form-control custom-select">
                                <option value="FULL" >Full Day(s)</option>
                                <option value="PARTIAL" <?php if($hours_selected < 8){echo 'selected';} ?> >Partial Day</option>
                            </select>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <label class="control-label"><strong>From</strong></label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $date_selected; ?>" onchange="to_offtime_date();" class="form-control" id="datepicker-autoclose1" placeholder="<?php echo date("m/d/Y"); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label"><strong>To</strong></label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $date_selected; ?>" onchange="to_offtime_date();" class="form-control" id="datepicker-autoclose2" placeholder="">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="amount" class="mt-3">
                            <label class="control-label"><strong>Amount</strong></label>
                            <div class="p-3 border-timeoff amount_div" id="append_amount_el">

                            </div>

                        </div>

                        <div class="mt-3">
                            <label class="control-label"><strong>Comment</strong></label>
                            <textarea rows="4" class="form-control" id="message_"></textarea>
                            <span class="mt-1">Please provide a reason with your time off request.</span>
                        </div>

                        <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                            <input type="button" id="submit_off_time" onclick="submit_offtime()" class="btn mt-4 w-20 btn-info" value="Submit">
                        </div>

                    </div>
                    <div class="col-lg-4 p-5 ptm-0">
                        <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { }else{?>
                        <div class="border-timeoff p-4">
                            <span><i class="far fa-clock mr-2 f-timeoff"></i> <strong> Unpaid Time Off</strong></span><br><br>
                            <span class="ml-4"><?php
    $sql_unpaid = "SELECT SUM(total_hours) as th FROM `tbl_time_off` WHERE category = 'UNPAID' AND status = 'APPROVED' AND request_by = $user_id";
    $result_unpaid = $conn->query($sql_unpaid);

    if ($result_unpaid && $result_unpaid->num_rows > 0) {
        while($row = mysqli_fetch_array($result_unpaid)) {
            if($row['th'] == null){echo '0';}else{echo $row['th'];}
        }
    }?> hours approved(YTD)</span><br><br>
                            <span><i class="mdi mdi-cash mr-2 f-timeoff"></i> <strong> Paid Time Off</strong></span><br><br>
                            <span class="ml-4"><?php
    $sql_paid = "SELECT SUM(total_hours) as th FROM `tbl_time_off` WHERE category = 'PAID' AND status = 'APPROVED' AND request_by = $user_id";
    $result_paid = $conn->query($sql_paid);

    if ($result_paid && $result_paid->num_rows > 0) {
        while($row = mysqli_fetch_array($result_paid)) {
            if($row['th'] == null){echo '0';}else{echo $row['th'];}
        }
    }?> hours approved(YTD)</span><br><br>
                            <span><i class="fas fa-notes-medical mr-2 f-timeoff"></i> <strong> Paid Sick Time Off</strong></span><br><br>
                            <span class="ml-4"><?php
    $sql_paidsick = "SELECT SUM(total_hours) as th FROM `tbl_time_off` WHERE category = 'PAID_SICK' AND status = 'APPROVED' AND request_by = $user_id";
    $result_paidsick = $conn->query($sql_paidsick);

    if ($result_paidsick && $result_paidsick->num_rows > 0) {
        while($row = mysqli_fetch_array($result_paidsick)) {
            if($row['th'] == null){echo '0';}else{echo $row['th'];}
        }
    }?> hours approved(YTD)</span>
                        </div>

                        <?php } ?>
                    </div>
                    <div class="col-lg-2"></div>
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


        <!-- Select2 Multi Select -->
        <script src="./assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

        <!-- Date Picker Plugin JavaScript -->
        <script src="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <script>
            $("#select1").select2();
            $("#select2").select2();
            $("#select3").select2();
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
            var n_global_amount = 0;
            var duration = '';
            $("#amount").hide();
            var dates=[];
            var dates_simple=[];
            var hours=[];
            var from_d="";
            var to_d="";
            var message="";
            var category="";
            var employee=0;
            to_offtime_date();

            function to_offtime_date(){
                $("#append_amount_el").empty();
                n_global_amount = 0;
                from_d = document.getElementById("datepicker-autoclose1").value;
                to_d = document.getElementById("datepicker-autoclose2").value;
                duration = $("#select2").val();
                dates=[];
                dates_simple=[];
                if(to_d >= from_d){
                    var myDate_to = new Date(to_d);
                    var myDate_from = new Date(from_d);

                    const date = new Date(myDate_from.getTime());

                    while (date <= myDate_to) {
                        dates.push(moment(date).format('MMM D, YYYY'));
                        dates_simple.push(moment(date).format('YYYY-MM-DD'));
                        date.setDate(date.getDate() + 1);

                        var temp = "<div class='p-2'><span><i class='icon-calender'></i> <span class='mr-5 pr-5' id='amount_date_"+(n_global_amount+1)+"'>"+dates[n_global_amount]+"</span> <input type='number' value='1' min='1' id='hours_"+(n_global_amount+1)+"' class='w-10' /> hours</span></div>";

                        $("#append_amount_el").append(temp);
                        n_global_amount++;
                    }
                    if(duration == 'PARTIAL'){
                        $("#amount").show();
                    }else{
                        $("#append_amount_el").empty();
                    }

                    console.log(dates);

                }else{
                    alert("To Date Always be Greater.");
                    $("#datepicker-autoclose2").val("");
                }

            }

            var hours = "<?php echo $hours_selected; ?>";
            if(hours != ""){
                to_offtime_date();
                $("#hours_1").val(hours);
            }

            function submit_offtime(){
                message = $("#message_").val();
                category = $("#select1").val();
                employee = $("#select3").val();

                hours=[];
                if(document.getElementById("hours_1")){
                    for(var i = 0; i < n_global_amount; i++ ){
                        var tempid = 'hours_'+(i+1);
                        var temp = document.getElementById(tempid).value;
                        hours.push(temp);
                    }
                }
                var check_flag= '<?php echo $user_selected; ?>';
                var fd1 = new FormData();
                fd1.append('dates',dates_simple);
                fd1.append('hours',hours);
                fd1.append('from_date',from_d);
                fd1.append('to_date',to_d);
                fd1.append('duration',duration);
                fd1.append('message',message);
                fd1.append('category',category);
                fd1.append('employee',employee);

                if(dates.length === 0 || from_d == "" || to_d == "" || duration == "" || message == "" || category == "" || employee == "0"){
                    alert("All Fields Must be Filled.");
                }else{

                    $.ajax({
                        url:'util_save_off_time.php',
                        type: 'post',
                        data:fd1,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            console.log(response);
                            if(response == "1"){
                                Swal.fire({
                                    title: 'Off Time Added.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        if(check_flag != ""){
                                            window.location.href = "schedules.php";
                                        }else{
                                            window.location.href = "off_time.php?slug=flag";
                                        }
                                    }
                                });
                            }else if(response == "2"){
                                alert("Off Time Already Requested, Try Different Dates!");
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