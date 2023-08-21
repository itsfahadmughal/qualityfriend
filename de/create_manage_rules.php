<?php
include 'util_config.php';
include '../util_session.php';
$user_type_array= array();
$usert_id_array  = array();
$div_id =0;
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
        <title>Regeln verwalten</title>
        <!-- page CSS -->
        <link href="../assets/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <style>
            .btn-delete{
                display: none ;
            }
            select{
                font-family: fontAwesome
            }
            .m-width{
                width: 100%;
                height: 33px;
            }
            #loading1{
                visibility: hidden;
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
                <p class="loader__label">Regeln verwalten</p>
            </div>
        </div>
        <div id="loading1"  class="d-flex justify-content-center mcenter">
            <div class="spinner-border text-info" role="status">
                <span class="sr-only">Wird geladen...</span>
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
                <div class="container-fluid mobile-container-pl-75 pr-0" id="mcontainer">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles pb-0">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Regeln verwalten</h4>
                        </div>
                        <div class="col-md-7">

                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <!-- Row -->
                    <div class="row" >
                        <div class="col-lg-12 col-xlg-12 col-md-12">

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Add Contact Popup Model -->
                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <!--Add Team-->
                                                <h4 class="modal-title" id="myModalLabel">Benutzertyp hinzufügen</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active"  role="tabpanel">
                                                            <div class="form-group">
                                                                <div class="col-md-12 m-b-20 mt-2">

                                                                    <div  id="div_add" class="form-group ">
                                                                        <input onkeyup="error_handle()" type="text" class="form-control" id="user_type_name"  placeholder="Geben Sie den Benutzertyp ein" required>

                                                                        <small id="error_msg_add" class="form-control-feedback display_none">Pflichtfeld</small> </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect"  onclick="save_user_type()" >Speichern</button>
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Abbrechen</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="edit-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <!--Add Team-->
                                                <h4 class="modal-title" id="myModalLabel">Benutzertyp bearbeiten</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active"  role="tabpanel">
                                                            <div class="form-group">
                                                                <div class="col-md-12 m-b-20 mt-2">
                                                                    <div  id="div_edit" class="form-group ">
                                                                        <input  onkeyup="error_handle_edit()"  type="text" class="form-control" id="user_type_name_edit"  placeholder="Geben Sie den Benutzertyp ein" required> 
                                                                        <small id="error_msg_edit" class="form-control-feedback display_none">Pflichtfeld</small> </div>

                                                                    <input type="text" hidden class="form-control" id="type_id_edit"  placeholder="" required>
                                                                </div>

                                                            </div> 
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect"  onclick="save_edit_user_type()">Speichern</button>
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Abbrechen</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Add Contact Popup Model -->

                                <div class="tab-pane active" role="tabpanel" id="list" >
                                    <div class="row pt-4">
                                        <div class="col-lg-6 col-xlg-6 col-md-6 wm-96">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-xlg-12 col-md-12" >
                                                    <div class="row div-background p-4">
                                                        <div class ="col-lg-10 col-xlg-10 col-md-10" id="">
                                                            <label class="control-label"><strong>Rollen anlegen</strong></label>
                                                        </div>
                                                        <div class ="col-lg-2 col-xlg-2 col-md-2 font-size-title fsm-2rem" style="text-align: center; display: flex; justify-content: center;align-items: center;" >
                                                            <a class= "green_color" data-toggle="modal" data-target="#add-contact" href=""><i class="mdi mdi-plus-circle"></i></a>
                                                        </div>
                                                        <div id="reloadreload" class="col-lg-12 col-xlg-12 col-md-12 pl-4 pr-4 pb-1 pm-0">
                                                            <div    class="row">
                                                                <?php
                                                                $sql1="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` = $hotel_id OR `hotel_id` = 0) and is_delete = '0'";
                                                                $result1 = $conn->query($sql1);
                                                                if ($result1 && $result1->num_rows > 0) {
                                                                    while($row1 = mysqli_fetch_array($result1)) {
                                                                        array_push($user_type_array,$row1['user_type']);
                                                                        array_push($usert_id_array,$row1['usert_id']);
                                                                    }
                                                                }
                                                                $temp = 0;
                                                                if(sizeof($user_type_array) != 0){
                                                                    for ($x = 0; $x < sizeof($user_type_array); $x++) {
                                                                ?>
                                                                <div id="<?php echo "div_".$div_id ?>" class='divacb col-lg-12 col-xlg-12 col-md-12 mt-2 div-white-background  ' onclick='selected_divs(this,<?php echo $usert_id_array[$x] ?>)'>
                                                                    <div class='div-department-height pointer'>
                                                                        <div class='row ' >
                                                                            <div class='col-lg-9 col-xlg-9 col-md-8 pt-4 wm-70'>
                                                                                <p class='font-size-subheading ml-3'>
                                                                                    &nbsp;&nbsp;&nbsp;<?php echo   $user_type_array[$x]; ?>
                                                                                </p>
                                                                            </div>
                                                                            <?php if($usert_id_array[$x] != 1){?>
                                                                            <div class='col-lg-1 col-xlg-1 col-md-2 pt-3 wm-15'>
                                                                                <a  data-toggle="modal" data-target="#edit-contact" href=""
                                                                                   onclick='edit_usertype("<?php echo $user_type_array[$x]; ?>","<?php echo $usert_id_array[$x]; ?>")' >
                                                                                    <img class="mw-40p" src="../assets/images/edit.png" alt="">
                                                                                </a>
                                                                            </div> 
                                                                            <div class='col-lg-1 col-xlg-1 col-md-2 pt-3 wm-15 plm-5px'>
                                                                                <img id='$x' class="mw-40p" onclick='del("<?php echo $usert_id_array[$x]; ?>")' type='button' class='' data-dismiss='modal' aria-hidden='true' src="../assets/images/cross.png" alt="">
                                                                            </div> 
                                                                            <?php }?>
                                                                        </div>
                                                                        <?php if($usert_id_array[$x] != 1){?>

                                                                        <?php }?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                        $div_id = $div_id + 1;
                                                                    }
                                                                }
                                                                else{
                                                                    echo"";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="employe" class="col-lg-6 col-xlg-6 col-md-6 pl-5 wm-96 plm-10px">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                                                    <div class="row div-background p-4 pm-1rem">
                                                        <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                                                            <label class="control-label"><strong>Regeln</strong></label>
                                                        </div>
                                                        <div class="form-group col-lg-12 col-xlg-12 col-md-12 div-white-background">
                                                            <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                                                                <label class="control-label pt-2"><strong>Quality Management</strong></label>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Todo und Checklisten anlegen und  bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="active_id" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Handbücher anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Reparaturen anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Notizen anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Übergaben anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="active_id" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>User,Teams,Abteilungen anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Mitteilungen senden und empfangen</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Regeln anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Verwalten Sie Zeitpläne</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Lohnadministrator</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>




                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Housekeeping</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Housekeeping Admin</h5>
                                                                </div>


                                                            </div>

                                                        </div>
                                                        <div class="form-group col-lg-12 col-xlg-12 col-md-12 div-white-background">
                                                            <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                                                                <label class="control-label pt-2"><strong>Recruiting</strong></label>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="active_id" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Stellenanzeige anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="active_id" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Bewerbungen anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="active_id" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Mitarbeiter anlegen und bearbeiten</h5>
                                                                </div>
                                                                <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                                                                    <div class="checkbox checkbox-success">
                                                                        <input  id="active_id" type="checkbox" 
                                                                               class="checkbox-size-20">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                                                                    <h5>Arbeitszeit anlegen und bearbeiten</h5>
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



                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Row -->
                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <?php include 'util_right_nav.php'; ?>
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
        <!--stickey kit -->
        <script src="../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="../dist/js/custom.min.js"></script>
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script>
        <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>


        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>




        <script>
            var div_add = document.getElementById("div_add");
            //            small text
            var error_msg_add = document.getElementById("error_msg_add");
            function error_handle() {
                let user_type_name = document.getElementById("user_type_name").value;
                if(user_type_name.trim() == ""){
                    div_add.classList.add("has-danger");
                    error_msg_add.classList.add("display_inline");
                }else{
                    div_add.classList.remove("has-danger");
                    error_msg_add.classList.remove("display_inline");
                    error_msg_add.classList.add("display_none");

                }


            }

        </script>

        <script>
            var div_edit = document.getElementById("div_edit");
            //            small text
            var error_msg_edit = document.getElementById("error_msg_edit");
            function error_handle_edit() {
                var user_type_name = document.getElementById("user_type_name_edit").value ;
                if(user_type_name.trim() == ""){
                    div_edit.classList.add("has-danger");
                    error_msg_edit.classList.add("display_inline");
                }else{
                    div_edit.classList.remove("has-danger");
                    error_msg_edit.classList.remove("display_inline");
                    error_msg_edit.classList.add("display_none");

                }


            }

        </script>
        <script>
            var type_array = [];
            var type_array_id = [];
            type_array = <?php echo json_encode($user_type_array); ?>;
            type_array_id = <?php echo json_encode($usert_id_array); ?>;
        </script>
        <script>
            function type_update(type_id) {
                var element = document.getElementById("mcontainer");
                element.classList.add("disabled");

                document.getElementById("loading1").style.visibility = "visible";
                var rule1=document.getElementById("rule1").checked;
                if(rule1 == true){
                    rule1 = 1;
                }else{
                    rule1 = 0;
                }
                var rule2=document.getElementById("rule2").checked;
                if(rule2 == true){
                    rule2 = 1;
                }else{
                    rule2 = 0;
                }
                var rule3=document.getElementById("rule3").checked;
                if(rule3 == true){
                    rule3 = 1;
                }else{
                    rule3 = 0;
                }
                var rule4=document.getElementById("rule4").checked;
                if(rule4 == true){
                    rule4 = 1;
                }else{
                    rule4 = 0;
                }
                var rule5=document.getElementById("rule5").checked;
                if(rule5 == true){
                    rule5 = 1;
                }else{
                    rule5 = 0;
                }
                var rule6=document.getElementById("rule6").checked;
                if(rule6 == true){
                    rule6 = 1;
                }else{
                    rule6 = 0;
                }
                var rule7=document.getElementById("rule7").checked;
                if(rule7 == true){
                    rule7 = 1;
                }else{
                    rule7 = 0;
                }
                var rule8=document.getElementById("rule8").checked;
                if(rule8 == true){
                    rule8 = 1;
                }else{
                    rule8 = 0;
                }
                var rule9=document.getElementById("rule9").checked;
                if(rule9 == true){
                    rule9 = 1;
                }else{
                    rule9 = 0;
                }
                var rule10=document.getElementById("rule10").checked;
                if(rule10 == true){
                    rule10 = 1;
                }else{
                    rule10 = 0;
                }
                var rule11=document.getElementById("rule11").checked;
                if(rule11 == true){
                    rule11 = 1;
                }else{
                    rule11 = 0;
                }
                var rule12=document.getElementById("rule12").checked;
                if(rule12 == true){
                    rule12 = 1;
                }else{
                    rule12 = 0;
                }
                var rule13=document.getElementById("rule13").checked;
                if(rule13 == true){
                    rule13 = 1;
                }else{
                    rule13 = 0;
                }
                var rule14 = document.getElementById("rule14").checked;
                if(rule14 == true){
                    rule14 = 1;
                }else{
                    rule14 = 0;
                }
                var rule15 = document.getElementById("rule15").checked;
                if(rule15 == true){
                    rule15 = 1;
                }else{
                    rule15 = 0;
                }
                $.ajax({
                    url:'util_user_type_update.php',
                    method:'POST',
                    data:{type_id:type_id,rule1:rule1,rule2:rule2,rule3:rule3,rule4:rule4,rule5:rule5,rule6:rule6,
                          rule7:rule7,rule8:rule8,rule9:rule9,rule10:rule10,rule11:rule11,rule12:rule12,
                          rule13:rule13,rule14:rule14,rule15:rule15},
                    success:function(response){
                        var delayInMilliseconds = 500; 
                        setTimeout(function() {
                            document.getElementById("loading1").style.visibility = "hidden";
                            element.classList.remove("disabled");
                        }, delayInMilliseconds);  
                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                    },
                });

            }
            function selected_divs(elem,type_id){
                var id = $(elem).attr("id");
                $(".divacb").removeClass("selected_div");
                document.getElementById(id).classList.add('selected_div');
                $.ajax({
                    url:'util_rule_reload.php',
                    method:'POST',
                    data:{type_id:type_id},
                    success:function(response){
                        document.getElementById("employe").innerHTML = response;        
                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                    },
                });

            }
            function del(type_id) { 
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_update_status.php',
                            method:'POST',
                            data:{ tablename:"tbl_usertype", idname:"usert_id", id:type_id, statusid:1,statusname: "is_delete"},
                            success:function(response){
                                console.log(response);
                                if(response == "Updated"){
                                    Swal.fire({
                                        title: 'Gelöscht',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'In Ordnung'
                                    }).then((result) => {
                                        if (result.value) {
                                            $(" #list").load(location.href + " #list");  
                                        }
                                    })
                                }
                                else{
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
                                l
                            },
                        });
                    }
                });
            }
            function save_user_type() {
                let user_type_name = document.getElementById("user_type_name").value;


                if(user_type_name != ""){

                    $.ajax({
                        url:'utill_save_user_type.php',
                        method:'POST',
                        data:{ typelist:user_type_name},
                        success:function(response){
                            $('#add-contact').modal('hide');
                            $(" #list").load(location.href + " #list");
                            document.getElementById("user_type_name").value = '';
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else {
                    if(user_type_name.trim() == ""){
                        div_add.classList.add("has-danger");
                        error_msg_add.classList.add("display_inline");
                    }else{
                        div_add.classList.remove("has-danger");
                        error_msg_add.classList.remove("display_inline");
                        error_msg_add.classList.add("display_none");

                    }
                }

            }
            function save_edit_user_type(){
                var user_type_name = document.getElementById("user_type_name_edit").value ;
                var type_id = document.getElementById("type_id_edit").value ;
                if(user_type_name != ""){
                    $.ajax({
                        url:'utill_edit_save_user_type.php',
                        method:'POST',
                        data:{user_type_name:user_type_name,type_id:type_id},
                        success:function(response){
                            if(response == '1' ){  
                                $('#edit-contact').modal('hide');
                                $(" #list").load(location.href + " #list");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else {
                    if(user_type_name.trim() == ""){
                        div_edit.classList.add("has-danger");
                        error_msg_edit.classList.add("display_inline");
                    }else{
                        div_edit.classList.remove("has-danger");
                        error_msg_edit.classList.remove("display_inline");
                        error_msg_edit.classList.add("display_none");

                    }
                }
            }
            function edit_usertype(user_type_name,type_id) {
                document.getElementById("user_type_name_edit").value =user_type_name ;
                document.getElementById("type_id_edit").value =type_id ;
            }
        </script>
    </body>

</html>