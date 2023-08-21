<?php
include 'util_config.php';
include '../util_session.php';
$break_min = 0;
$message = "";
$start_time = "10:00";
$end_time = "18:00";
$total_hours = 8;
$pre_define_name = "";
$depart_id = 0;

$id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $inner_sql = "SELECT * FROM `tbl_shifts_pre_defined` WHERE sfspd_id = $id";
    $result_inner = $conn->query($inner_sql);
    if ($result_inner && $result_inner->num_rows > 0) {
        while ($row_inner = mysqli_fetch_array($result_inner)) {
            $pre_define_name = $row_inner['shift_name'];
            $break_min = $row_inner['shift_break'];
            $message = $row_inner['title'];
            $start_time = $row_inner['start_time'];
            $end_time = $row_inner['end_time'];
            $total_hours = $row_inner['total_hours'];
            $depart_id = $row_inner['depart_id'];
        }
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
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Schichtvorlagen</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />


        <!-- Multiple Select -->
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/time_schedule.css" rel="stylesheet">

        <!--        Tabs-->
        <link href="../dist/css/pages/tab-page.css" rel="stylesheet">

        <!-- Date picker plugins css -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />


    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Schichtvorlagen</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Schichtvorlagen</h4>
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



                    <div class="col-lg-6 right-border-div pr-5 pl-5">
                        <span class="cursor-pointer" onclick="history.back();"><i class="fas fa-chevron-left pr-1"></i> Zeitpläne</span>

                        <div class="mt-4">
                            <h3>Schichtvorlage erstellen</h3>
                        </div>



                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <label class="control-label display-inline w-30"><strong>Name</strong></label>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control display-inline w-100" value="<?php echo $pre_define_name; ?>"  id="pre_name">
                                </div>
                                <div class="form-group mb-3">
                                    <select class="form-control" id="depart_select" data-style="form-control btn-secondary mt-1">
                                        <option value="0">Wählen Abteilung</option>
                                        <?php
                                        $sql = "SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                                        $result = $conn->query($sql);
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option value="<?php echo $row[0]; ?>" <?php if($row[0] == $depart_id){echo 'selected';} ?> ><?php if($row[1] != ""){ echo $row[1]; }else{ echo $row[2]; } ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="control-label display-inline w-30 wm-38"><strong>Startzeit</strong></label>
                                    <i class="fas pl-1-8 pr-3"></i>
                                    <label class="control-label display-inline w-30 wm-38"><strong>Endzeit</strong></label>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="time" class="form-control display-inline w-30 wm-38" value="<?php echo $start_time; ?>" onchange="set_time();" id="from_time">
                                    <i class="fas fa-arrow-right pl-3 pr-3"></i>
                                    <input type="time" class="form-control display-inline w-30 wm-38" value="<?php echo $end_time; ?>" onchange="set_time();" id="to_time">

                                    <label class="control-label ml-1 mtm-10">Pause <small>(min)</small></label>
                                    <input type="number" style="width:65px;" value="<?php echo $break_min; ?>" class="mtm-10 form-control display-inline w-30" min="0" max="240" id="break_mint" />
                                </div>
                                <div class="form-group ml-1 mb-0 mt-1">
                                    <label class="control-label mb-0"><i class="far fa-clock"></i> <span id="hours_from_to"><?php echo round($total_hours+($break_min/60),2); ?></span> Std</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="control-label"><strong>Schichtnotizen</strong></label>
                            <textarea rows="4" class="form-control" id="message_"><?php echo $message; ?></textarea>
                        </div>

                        <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                            <input type="button" onclick="submit_pre_defined_shift();" class="btn mt-4 w-100 btn-info" value="Speichern">
                        </div>


                    </div>

                    <div class="col-lg-6 pr-5 pl-5">
                        <div class="mt-5">
                            <h3>Schichtvorlagen</h3>
                        </div>

                        <?php
                        $sql_up_for = "SELECT a.*,b.department_name FROM `tbl_shifts_pre_defined` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.`hotel_id` = $hotel_id  and a.is_delete = 0 ORDER BY 1 DESC";

                        $result_up_for = $conn->query($sql_up_for);
                        if ($result_up_for && $result_up_for->num_rows > 0) {
                        ?>
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                <thead>
                                    <tr>
                                        <th class="" >Vordefinieren Schicht Name</th>
                                        <th class="" >Schichtzeit</th>
                                        <th class="mobile_display_none" >Brechen (Min)</th>
                                        <th class="mobile_display_none" >Arbeitszeit</th>
                                        <th class="mobile_display_none" >Anmerkungen</th>
                                        <th class="mobile_display_none" >Abteilung</th>
                                        <th class="text-center">Aktion</th>
                                        <th class="text-center ">Löschen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                            while ($row = mysqli_fetch_array($result_up_for)) {
                                    ?>
                                    <tr class="">
                                        <td><?php echo $row['shift_name']; ?></td>
                                        <td><?php echo $row['start_time'].' - '.$row['end_time']; ?></td>
                                        <td class="mobile_display_none"><?php echo $row['shift_break']; ?></td>
                                        <td class="mobile_display_none"><?php echo $row['total_hours']; ?></td>
                                        <td class="mobile_display_none"><?php if($row['title'] != ""){ echo $row['title']; } ?></td>
                                        <td class="mobile_display_none"><?php if($row['department_name'] != ""){ echo $row['department_name']; } ?></td>
                                        <td class="font-size-subheading text-center black_color">
                                            <a  class="black_color" href="javascript:void()" onclick="edit_shift('<?php echo $row['sfspd_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                        </td>
                                        <td class="font-size-subheading  text-center black_color">
                                            <a href="javascript:void(0)" onclick="delete_shift('<?php echo $row['sfspd_id']; ?>')" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>

                                    <?php 
                            } ?>
                                </tbody>
                            </table>
                        </div>

                        <?php }else{ ?>
                        <div class="text-center mt-5 pt-4"><img src="../assets/images/no-results-cookie.png" width="250" /></div>
                        <h5 class="text-center"><b>Schichten nicht gefunden.</b></h5>
                        <?php } ?>

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


        <!-- Select2 Multi Select -->
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

        <!-- Date Picker Plugin JavaScript -->
        <script src="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


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
                    alert("Wählen Sie „Endzeit größer“ aus.");
                    document.getElementById("to_time").value = "";
                    $('#hours_from_to').text(0);
                }
            }


            function submit_pre_defined_shift(){
                var shift_id  = '<?php echo $id; ?>';


                var shift_name = $("#pre_name").val();
                var start_time = $("#from_time").val();
                var end_time = $("#to_time").val();
                var message = $("#message_").val();
                var depart_id_ = $("#depart_select").val();
                var hourDiff = 0;
                var break_mint = $("#break_mint").val();
                var new_break_mint = 0;
                if(break_mint != 0){
                    new_break_mint = break_mint/60;
                }

                var timeStart = new Date("01/01/2007 " +start_time);
                var timeEnd = new Date("01/01/2007 " +end_time);

                hourDiff = timeEnd - timeStart;   
                hourDiff = ((hourDiff / 60 / 60 / 1000) - new_break_mint).toFixed(2);

                var flag = '';
                if(shift_id != 0){
                    flag = 'edit';
                }else{
                    flag = 'add';
                }

                var fd1 = new FormData();
                fd1.append('start_time',start_time);
                fd1.append('end_time',end_time);
                fd1.append('hours_diff',hourDiff);
                fd1.append('break_mints',break_mint);
                fd1.append('message',message);
                fd1.append('shift_name',shift_name);
                fd1.append('depart_id',depart_id_);
                fd1.append('flag',flag);
                fd1.append('sfspd_id',shift_id);

                if(shift_name = "" || start_time == "" || end_time == "" || depart_id_ == 0){
                    alert("Alle Felder außer Schichtnotizen müssen ausgefüllt werden.");
                }else{
                    $.ajax({
                        url:'util_add_update_pre_defined_shift.php',
                        type: 'post',
                        data:fd1,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            console.log(response);
                            if(response == "1"){
                                Swal.fire({
                                    title: 'Vordefiniert Schicht gespeichert.',
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Gespeichert'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.href = "pre_defined_shifts.php";
                                    }
                                });
                            }else{
                                alert("Etwas ist schief gelaufen!");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }

            }

            function delete_shift(id){
                console.log(id);

                Swal.fire({
                    title: 'Bist du dir sicher?',
                    text: "Sie können dies nicht rückgängig machen!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, löschen Sie es!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_update_status.php',
                            method:'POST',
                            data:{ tablename:"tbl_shifts_pre_defined", idname:"sfspd_id", id:id, statusid:1,statusname: 'is_delete'},
                            success:function(response){
                                console.log(response);
                                if(response == "Updated"){
                                    Swal.fire({
                                        title: 'Gelöscht',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Gespeichert'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Etwas ist schief gelaufen!',
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


            function edit_shift(id){
                window.location.href = "pre_defined_shifts.php?id="+id;
            }
        </script>

    </body>

</html>