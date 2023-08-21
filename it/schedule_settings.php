<?php
include 'util_config.php';
include '../util_session.php';

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
        <title>Impostazioni gestione turni</title>
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
                <p class="loader__label">Impostazioni gestione turni</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Impostazioni gestione turni</h4>
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
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4 pm-2rem">
                        <span class="cursor-pointer" onclick="history.back();"><i class="fas fa-chevron-left pr-1"></i> Turni</span>

                        <div class="mt-4">
                            <h3>Impostazioni Visualizzazione</h3>
                        </div>

                        <div class="mt-3">
                            <label class="control-label"><strong>Dipendenti</strong></label>
                            <select id="select1" onchange="show_value();" class="form-control custom-select">
                                <option value="0">Tutti i dipendenti</option>
                                <?php 
                                $sql="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($row[2] != ""){
                                            $username = $row[2];
                                        }
                                        echo '<option value='.$row[0].'>'.$username.'</option>';
                                    }   
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="control-label"><strong>Tipo visualizzazione</strong></label>
                            <select id="select2" onchange="type_changed();" class="form-control custom-select">
                                <option value="SELF">Singolo Dipendente</option>
                                <option value="DEPARTMENT">Dipartimento</option>
                                <option value="TEAM">Team</option>
                                <option value="OTHERS">Altro</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="control-label"><strong>Dipartimento</strong></label>
                            <select id="select3" disabled class="form-control custom-select">
                                <option value="0">Tutti i Dipartimenti</option>
                                <?php 
                                $sql="SELECT * FROM `tbl_department` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                    }   
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-4">
                            <label class="control-label"><strong>Team</strong></label>
                            <select id="select4" disabled class="form-control custom-select">
                                <option value="0">Tutte le squadre</option>
                                <?php 
                                $sql="SELECT * FROM `tbl_team` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                    }   
                                }
                                ?>
                            </select>
                        </div>


                        <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                            <input type="button" id="save_schedule_visible" onclick="save_schedule_visible();" class="btn mt-4 w-20 btn-secondary" value="Salva">
                        </div>

                    </div>
                    <div class="col-lg-1 right-border-div"></div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4 pm-2rem">
                        <div class="mt-5 mtm-0">
                            <h3>Impostazioni buttons dipendenti</h3>
                        </div>
                        <div class="mt-3">
                            <label class="control-label"><strong>Dipendenti</strong></label>
                            <select id="1select1" onchange="show_value2();" class="form-control custom-select">
                                <option value="0">Tutti i dipendenti</option>
                                <?php 
                                $sql="SELECT * FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($row[2] != ""){
                                            $username = $row[2];
                                        }
                                        echo '<option value='.$row[0].'>'.$username.'</option>';
                                    }   
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="control-label"><strong>Tipo visualizzazione</strong></label>
                            <select id="2select2" class="form-control custom-select">
                                <option value="VISIBLE_ALL">Tutti i pulsanti visibili</option>
                                <option value="START_END_BTN_ONLY">Inizio &amp; Solo pulsante Fine</option>
                                <option value="COMPLETE_ONLY">Offri turno visibile</option>
                                <option value="OFFER_UP_ONLY">Prendi turno visibile</option>
                                <option value="TRADE_ONLY">Nessun pulsante visibile</option>
                                <option value="NOT_VISIBLE_ALL">Non visibili tutti i pulsanti</option>
                            </select>
                        </div>

                        <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                            <input type="button" id="save_control" onclick="save_control_buttons();" class="btn mt-4 w-20 btn-secondary" value="Salva">
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
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
            $("#1select1").select2();
            $("#2select2").select2();
            $("#select1").select2();
            $("#select2").select2();
            $("#select3").select2();
            $("#select4").select2();

            $('#select3').val("").trigger('change');
            $('#select4').val("").trigger('change');
        </script>


        <script>
            var employee = 0;
            var type = "SELF";
            var depart = "";
            var team = "";

            var employee2 = 0;
            var visible_type = "VISIBLE_ALL";

            function show_value(){
                employee =  $('#select1').val();
                if(employee != 0){
                    $.ajax({
                        url:'util_get_schedule_visibility_settings.php',
                        method:'POST',
                        data:{ employee:employee },
                        success:function(response){
                            if(response != "unsuccess"){
                                console.log(response);
                                const myArray = response.split(",");
                                $('#select2').val(myArray[0]).trigger('change');
                                $('#select3').val(myArray[1]).trigger('change');
                                $('#select4').val(myArray[2]).trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else{
                    $('#select2').val("SELF").trigger('change');
                    $('#select3').val("").trigger('change');
                    $('#select4').val("").trigger('change');
                }

            }

            function type_changed(){
                type = $('#select2').val();
                if(type == "OTHERS"){
                    $( "#select3" ).removeAttr('disabled');
                    $( "#select4" ).removeAttr('disabled');
                    $('#select3').val("0").trigger('change');
                    $('#select4').val("").trigger('change');
                }else{
                    $('#select3').attr('disabled','');
                    $('#select4').attr('disabled','');
                    $('#select3').val("").trigger('change');
                    $('#select4').val("").trigger('change');
                }
            }

            function save_schedule_visible(){
                employee =  $('#select1').val();
                type =  $('#select2').val();
                depart =  $('#select3').val();
                team =  $('#select4').val();

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Non sarai in grado di ripristinare questo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, salvalo!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_save_schedule_visibility_settings.php',
                            method:'POST',
                            data:{ employee:employee, type:type, depart:depart, team:team },
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Salvato con successo',
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


            function save_control_buttons(){
                var employee2 = $('#1select1').val();
                var visible_type = $('#2select2').val();

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Non sarai in grado di ripristinare questo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, salvalo!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_save_shift_buttons_visibility_settings.php',
                            method:'POST',
                            data:{ employee:employee2, type:visible_type },
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Salvato con successo',
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

            function show_value2(){
                employee =  $('#1select1').val();
                if(employee != 0){
                    $.ajax({
                        url:'util_get_shift_buttons_visibility_settings.php',
                        method:'POST',
                        data:{ employee:employee },
                        success:function(response){
                            if(response != "unsuccess"){
                                console.log(response);
                                $('#2select2').val(response).trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else{
                    $('#2select2').val("VISIBLE_ALL").trigger('change');
                }

            }

        </script>

    </body>

</html>