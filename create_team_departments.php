<?php
include 'util_config.php';
include 'util_session.php';
$title ="";
$description = "";
$tags = "";
$saved_status = "";
$category_name ="";
$subcat_name ="";
$category_id =0;
$subcat_id =0;
$department_list= array();
$department_list_id =  array();
$team_list= array();
$team_listt_id  = array();
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
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
        <title>Manage Teams/Departments</title>
        <!-- page CSS -->
        <link href="./assets/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
        <link href="./assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="./assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="./assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="./assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="dist/css/style.min.css" rel="stylesheet">
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
            .icon_width{
                height: 70%;
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
                <p class="loader__label">Manage Teams/Departments</p>
            </div>
        </div>

        <div id="loading1"  class="d-flex justify-content-center mcenter">
            <div class="spinner-border text-info" role="status">
                <span class="sr-only">Loading...</span>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Manage Teams &amp; Departments</h4>
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
                    <div class="row">
                        <div class="col-lg-12 col-xlg-12 col-md-12">

                            <form id="create_job_form" action="">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <!-- Add Contact Popup Model -->
                                    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!--Add Team-->
                                                    <h4 class="modal-title" id="myModalLabel">Add Team</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active"  role="tabpanel">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 m-b-20 mt-2">
                                                                        <div  id="div_team_add" class="form-group ">
                                                                            <input  onkeyup="error_handle_add_team()" type="text" class="form-control" id="team_name"  placeholder="Enter Team Name" required>
                                                                            <small id="error_msg_team_add" class="form-control-feedback display_none">Required Field</small> 
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect"  onclick="save_team()">Save</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
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
                                                    <h4 class="modal-title" id="myModalLabel">Edit Team</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active"  role="tabpanel">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 m-b-20 mt-2">

                                                                        <div  id="div_team_edit" class="form-group ">

                                                                            <input onkeyup="error_handle_team_edit()"  type="text" class="form-control" id="team_name_edit"  placeholder="Enter Team Name" required> 
                                                                            <small id="error_msg_team_edit" class="form-control-feedback display_none">Required Field</small> </div>
                                                                        <input type="text" hidden class="form-control" id="team_id_edit"  placeholder="Enter Team Name" required>
                                                                    </div>

                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect"  onclick="save_edit_team()">Save</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <div id="edit-department" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!--Add Team-->
                                                    <h4 class="modal-title" id="myModalLabel">Edit Department</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active"  role="tabpanel">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 m-b-20 mt-2">
                                                                        <div  id="div_department_edit" class="form-group ">
                                                                            <input onkeyup="error_handle_department_edit()"  type="text" class="form-control" id="department_name_edit"  placeholder="Enter Department Name" required> 
                                                                            <small id="error_msg_department_edit" class="form-control-feedback display_none">Required Field</small> </div>


                                                                        <input  type="text" hidden class="form-control" id="department_id_edit"  placeholder="Enter Team Name" required>
                                                                    </div>

                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect"  onclick="edit_departments()" >Save</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- Add Contact Popup Model -->
                                    <div id="add-contact1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Add Department</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" role="tabpanel">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 m-b-20 mt-2">
                                                                        <div  id="div_department_add" class="form-group ">
                                                                            <input onkeyup="error_handle_add_department()" type="text" class="form-control" id="department_name" placeholder="Enter Department Name">  <small id="error_msg_department_add" class="form-control-feedback display_none">Required Field</small> </div>

                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-info waves-effect"  onclick="save_department()"  data-toggle="modal" href="" data->Save</a>
                                                    <a class="btn btn-default waves-effect" data-toggle="modal"  data-target="" href="" data-dismiss="modal">Cancel</a>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <div class="tab-pane active" role="tabpanel" id="list">
                                        <div class="row pt-4 ptm-0">
                                            <div class="col-lg-6 col-xlg-6 col-md-6 wm-96">
                                                <div class="row">
                                                    <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                                                        <div class="row div-background p-4">
                                                            <div class ="col-lg-10 col-xlg-10 col-md-10" id="refrash">
                                                                <label class="control-label"><strong>Team's</strong></label>
                                                            </div>
                                                            <div class ="col-lg-2 col-xlg-2 col-md-2 font-size-title fsm-2rem" style="text-align: center; display: flex; justify-content: center;align-items: center;" >
                                                                <a class= "green_color" data-toggle="modal" data-target="#add-contact" href=""><i class="mdi mdi-plus-circle"></i></a>
                                                            </div>
                                                            <div class="col-lg-12 col-xlg-12 col-md-12  pb-1 ">
                                                                <div  id="team-list"  class="row">
                                                                    <?php
                                                                    $sql1="SELECT * FROM `tbl_team` WHERE `hotel_id` = $hotel_id AND `is_active` = 1 AND `is_delete` = 0";
                                                                    $result1 = $conn->query($sql1);
                                                                    if ($result1 && $result1->num_rows > 0) {
                                                                        while($row1 = mysqli_fetch_array($result1)) {
                                                                            array_push($team_list,$row1['team_name']);
                                                                            array_push($team_listt_id,$row1['team_id']);
                                                                        }
                                                                    }
                                                                    $temp = 0;
                                                                    if(sizeof($team_list) != 0){
                                                                        for ($x = 0; $x < sizeof($team_list); $x++) {
                                                                    ?>
                                                                    <div id="<?php echo "div_".$div_id ?>" class='divacb col-lg-5 col-xlg-5 col-md-12 mt-2 div-white-background  ' onclick='selected_divs(this,"team",<?php echo $team_listt_id[$x] ?>)'>
                                                                        <div class='div-department-height pointer'>
                                                                            <div class='row pt-4' >
                                                                                <div class='col-lg-8 col-xlg-8 col-md-8 wm-70'>
                                                                                    <p class='font-size-subheading ml-3'>
                                                                                        &nbsp;&nbsp;&nbsp;<?php echo   $team_list[$x]; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                                                    <a  data-toggle="modal" data-target="#edit-contact" href=""
                                                                                       onclick='edit_team("<?php echo $team_list[$x]; ?>","<?php echo $team_listt_id[$x]; ?>")'
                                                                                       > <img  class='icon_width' src="./assets/images/edit.png" alt="Girl in a jacket"></a>
                                                                                </div> 

                                                                                <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                                                    <img id='$x' onclick='update_list(<?php echo $x ;?>,"team","<?php echo $team_listt_id[$x]; ?>")' type='button' class='icon_width' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">
                                                                                </div> 
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                            if($temp == 0){
                                                                                echo "<div class=' col-lg-1 col-xlg-1 col-md-1'></div> ";
                                                                                $temp = 1;
                                                                            }
                                                                            else{
                                                                                $temp = 0;
                                                                            }
                                                                            $div_id = $div_id + 1;
                                                                        }

                                                                    }
                                                                    else{
                                                                        echo"";
                                                                    }

                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class ="col-lg-10 col-xlg-10 col-md-10" id="refrash">
                                                                <label class="control-label mt-4"><strong>Department's</strong></label>
                                                            </div>
                                                            <div class ="col-lg-2 col-xlg-2 col-md-2 font-size-title fsm-2rem" style="text-align: center; display: flex; justify-content: center;align-items: center;" >
                                                                <a  class= "green_color" data-toggle="modal" data-target="#add-contact1" href=""><i class="mdi mdi-plus-circle"></i></a>
                                                            </div>
                                                            <div class="col-lg-12 col-xlg-12 col-md-12  pb-1 ">
                                                                <div  id="team-list"  class="row">
                                                                    <?php
                                                                    $sql1="SELECT * FROM `tbl_department` WHERE `hotel_id` = $hotel_id AND `is_active` = 1 AND `is_delete` = 0";
                                                                    $result2 = $conn->query($sql1);
                                                                    if ($result2 && $result2->num_rows > 0) {
                                                                        while($row1 = mysqli_fetch_array($result2)) {
                                                                            array_push($department_list,$row1['department_name']);
                                                                            array_push($department_list_id,$row1['depart_id']);
                                                                        }
                                                                    }
                                                                    $temp = 0;
                                                                    if(sizeof($department_list) != 0){
                                                                        for ($x = 0; $x < sizeof($department_list); $x++) {
                                                                    ?>
                                                                    <div id="<?php echo "div_".$div_id ?>" class='divacb col-lg-5 col-xlg-5 col-md-12 mt-2 div-white-background pointer'  onclick='selected_divs(this,"department",<?php
                                                                        echo $department_list_id[$x] ?>)'>
                                                                        <div class='div-department-height'>
                                                                            <div class='row pt-4' >
                                                                                <div class='col-lg-8 col-xlg-8 col-md-8 wm-70'>
                                                                                    <p class='font-size-subheading ml-3'>
                                                                                        &nbsp;&nbsp;&nbsp;<?php echo   $department_list[$x]; ?>
                                                                                    </p>
                                                                                </div>
                                                                                <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                                                    <a data-toggle="modal" data-target="#edit-department" href=""
                                                                                       onclick='edit_department("<?php echo $department_list[$x]; ?>","<?php echo $department_list_id[$x]; ?>")'
                                                                                       > <img  class="icon_width" src="./assets/images/edit.png" alt="Girl in a jacket"></a>
                                                                                </div> 

                                                                                <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>

                                                                                    <img class="icon_width" id='$x' onclick='update_list(<?php echo $x ;?>,"department","<?php echo $department_list_id[$x]; ?>")' type='button' class='close close-center' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">

                                                                                </div>
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                            if($temp == 0){
                                                                                echo "<div class=' col-lg-1 col-xlg-1 col-md-1'></div> ";
                                                                                $temp = 1;
                                                                            }
                                                                            else{
                                                                                $temp = 0;
                                                                            }
                                                                            $div_id = $div_id +1;
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
                                                        <div class="row div-background p-4">
                                                            <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                                                                <label class="control-label"><strong>Employees</strong></label>
                                                            </div>

                                                            <div class="col-lg-12 col-xlg-12 col-md-12 pl-4 pr-4 pb-4">
                                                                <div class="row div-white-background">
                                                                    <div class="col-lg-4 col-xlg-4 col-md-4 pt-4 pb-3">
                                                                        <h5><strong>Name</strong></h5>
                                                                    </div>
                                                                </div>
                                                                <?php 
                                                                $sql="SELECT `firstname` ,`usert_id` FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
                                                                $result = $conn->query($sql);
                                                                if ($result && $result->num_rows > 0) {
                                                                    while($row = mysqli_fetch_array($result)) {
                                                                ?>
                                                                <div class="row div-white-background mt-3">
                                                                    <div class="col-lg-10 col-xlg-10 col-md-10 pt-4 pb-3 wm-80">
                                                                        <h5 > <?php echo $row['firstname']; ?></h5>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xlg-2 col-md-2 pt-4 pb-3 wm-20">
                                                                        <div class="checkbox checkbox-success">
                                                                            <input  id="active_id" type="checkbox" 
                                                                                   class="checkbox-size-20"  >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    }   
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


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
        <!--stickey kit -->
        <script src="./assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="./assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="./assets/node_modules/switchery/dist/switchery.min.js"></script>
        <script src="./assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="./assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="./assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
        <!-- Sweet-Alert  -->
        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <!--        Team-->
        <script>
            var div_team_add = document.getElementById("div_team_add");
            //            small text
            var error_msg_team_add = document.getElementById("error_msg_team_add");
            function error_handle_add_team() {
                let team_name = document.getElementById("team_name").value;
                if(team_name.trim() == ""){
                    div_team_add.classList.add("has-danger");
                    error_msg_team_add.classList.add("display_inline");
                }else{
                    div_team_add.classList.remove("has-danger");
                    error_msg_team_add.classList.remove("display_inline");
                    error_msg_team_add.classList.add("display_none");

                }
            }

        </script>
        <script>
            var div_team_edit = document.getElementById("div_team_edit");
            //            small text
            var error_msg_team_edit = document.getElementById("error_msg_team_edit");
            function error_handle_team_edit() {
                var team_name = document.getElementById("team_name_edit").value ;
                if(team_name.trim() == ""){
                    div_team_edit.classList.add("has-danger");
                    error_msg_team_edit.classList.add("display_inline");
                }else{
                    div_team_edit.classList.remove("has-danger");
                    error_msg_team_edit.classList.remove("display_inline");
                    error_msg_team_edit.classList.add("display_none");

                }
            }

        </script>
        <!--Department-->

        <script>
            var div_department_add = document.getElementById("div_department_add");
            //            small text
            var error_msg_department_add = document.getElementById("error_msg_department_add");
            function error_handle_add_department() {
                let department=document.getElementById("department_name").value;
                if(department.trim() == ""){
                    div_department_add.classList.add("has-danger");
                    error_msg_department_add.classList.add("display_inline");
                }else{
                    div_department_add.classList.remove("has-danger");
                    error_msg_department_add.classList.remove("display_inline");
                    error_msg_department_add.classList.add("display_none");

                }
            }

        </script>
        <script>


            var div_department_edit = document.getElementById("div_department_edit");
            //            small text
            var error_msg_department_edit = document.getElementById("error_msg_department_edit");
            function error_handle_department_edit() {
                var departments_name = document.getElementById("department_name_edit").value ;
                if(departments_name.trim() == ""){
                    div_department_edit.classList.add("has-danger");
                    error_msg_department_edit.classList.add("display_inline");
                }else{
                    div_department_edit.classList.remove("has-danger");
                    error_msg_department_edit.classList.remove("display_inline");
                    error_msg_department_edit.classList.add("display_none");

                }
            }

        </script>




        <script>
            var dep_array = [];
            var dep_array_id = [];
            var team_array = [];
            var team_array_id = [];
            team_array = <?php echo json_encode($team_list); ?>;
            team_array_id = <?php echo json_encode($team_listt_id); ?>;
            dep_array = <?php echo json_encode($department_list); ?>;
            dep_array_icon = <?php echo json_encode($department_list_id); ?>;
            function team_update(team_id) {
                var element = document.getElementById("mcontainer");
                element.classList.add("disabled");
                document.getElementById("loading1").style.visibility = "visible";
                var users_ids = [];
                var x = document.getElementsByClassName("check_box_i");
                for (var i = 0; i < x.length; i++) {
                    var a =     document.getElementById("active_"+i).value;
                    let active=document.getElementById("active_"+i).checked;
                    if(active == true){
                        users_ids.push(a);
                    }else {

                    }
                }
                $.ajax({    
                    url:'util_depmartment_user_update.php',
                    method:'POST',
                    data:{team_id:team_id,ids:users_ids,base:"team"},
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
            function department_update(dep_id) {
                var element = document.getElementById("mcontainer");
                element.classList.add("disabled");

                document.getElementById("loading1").style.visibility = "visible";
                var users_ids = [];
                var x = document.getElementsByClassName("check_box_d");
                for (var i = 0; i < x.length; i++) {
                    var a =     document.getElementById("actived_"+i).value;
                    let active=document.getElementById("actived_"+i).checked;
                    if(active == true){
                        users_ids.push(a);
                    }else {

                    }
                }     
                $.ajax({
                    url:'util_depmartment_user_update.php',
                    method:'POST',
                    data:{team_id:dep_id,ids:users_ids,base:"department"},
                    success:function(response){
                        var delayInMilliseconds = 600; //1 second
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
            function edit_team(team_name,team_id) {
                document.getElementById("team_name_edit").value =team_name ;
                document.getElementById("team_id_edit").value =team_id ;
            }
            function selected_divs(elem,name,ids){
                var id = $(elem).attr("id");
                $(".divacb").removeClass("selected_div");
                document.getElementById(id).classList.add('selected_div');
                if(name == "team"){
                    $.ajax({
                        url:'util_depmartment_employee_reload.php',
                        method:'POST',
                        data:{name:name,ids:ids},
                        success:function(response){
                            document.getElementById("employe").innerHTML = response;        
                        },
                        error: function(xhr, status, error) {
                            console.log(error);

                        },
                    });
                }else if (name == "department"){
                    $.ajax({
                        url:'util_depmartment_employee_reload.php',
                        method:'POST',
                        data:{name:name,ids:ids},
                        success:function(response){
                            document.getElementById("employe").innerHTML = response;          
                        },
                        error: function(xhr, status, error) {
                            console.log(error);

                        },
                    });

                }
            }
            function save_edit_team(){
                var team_name = document.getElementById("team_name_edit").value ;
                var team_id = document.getElementById("team_id_edit").value ;
                if(team_name.trim() != ""){
                    $.ajax({
                        url:'utill_edit_save_team.php',
                        method:'POST',
                        data:{ team_name:team_name,team_id:team_id},
                        success:function(response){
                            if(response == '1' ){  
                                $("#list").load(location.href + " #list");
                                $('#edit-contact').modal('hide');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else{
                    if(team_name.trim() == ""){
                        div_team_edit.classList.add("has-danger");
                        error_msg_team_edit.classList.add("display_inline");
                    }else{
                        div_team_edit.classList.remove("has-danger");
                        error_msg_team_edit.classList.remove("display_inline");
                        error_msg_team_edit.classList.add("display_none");

                    }
                }
            }
            function edit_department(department_name,department_id) {
                document.getElementById("department_name_edit").value =department_name ;
                document.getElementById("department_id_edit").value =department_id ;
            }
            function  edit_departments() {
                var departments_name = document.getElementById("department_name_edit").value ;
                var departments_id = document.getElementById("department_id_edit").value ;
                if(departments_name.trim() != ""){
                    $.ajax({
                        url:'utill_edit_save_team.php',
                        method:'POST',
                        data:{ departments_name:departments_name,departments_id:departments_id},
                        success:function(response){
                            console.log(response);
                            if(response == '1' ){  
                                $("#list").load(location.href + " #list");
                                $('#edit-department').modal('hide');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else{
                    if(departments_name.trim() == ""){
                        div_department_edit.classList.add("has-danger");
                        error_msg_department_edit.classList.add("display_inline");
                    }else{
                        div_department_edit.classList.remove("has-danger");
                        error_msg_department_edit.classList.remove("display_inline");
                        error_msg_department_edit.classList.add("display_none");

                    }
                }
            }
            function del(name,id_name,id) {
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
                            data:{ tablename:name, idname:id_name, id:id, statusid:1,statusname: "is_delete"},
                            success:function(response){
                                console.log(response);
                                if(response == "Updated"){
                                    Swal.fire({
                                        title: 'Deleted',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            $("#list").load(location.href + " #list");  
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
                                l
                            },
                        });
                    }
                });
            }
            function update_list(index,name,id) {

                if(name=="team"){
                    var removed = team_array.splice(index,1);
                    var removed = dep_array_id.splice(index,1);
                    del("tbl_team","team_id",id);
                }
                else if(name == "department"){
                    var removed = dep_array.splice(index,1);
                    var removed = dep_array_icon.splice(index,1);
                    del("tbl_department","depart_id",id);
                }
            }
            function save_team() {
                let team_name = document.getElementById("team_name").value;
                if(team_name.trim() != ""){
                    document.getElementById("team_name").value = '';
                    $.ajax({
                        url:'utill_save_team.php',
                        method:'POST',
                        data:{ team_list:team_name},
                        success:function(response){
                            $("#list").load(location.href + " #list"); 
                            $('#add-contact').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }else{


                    if(team_name.trim() == ""){
                        div_team_add.classList.add("has-danger");
                        error_msg_team_add.classList.add("display_inline");
                    }else{
                        div_team_add.classList.remove("has-danger");
                        error_msg_team_add.classList.remove("display_inline");
                        error_msg_team_add.classList.add("display_none");

                    }
                }
            }
            function save_department() {
                let department=document.getElementById("department_name").value;
                if(department.trim() != ""){
                    document.getElementById("department_name").value = '';
                    let icon_class='';
                    $.ajax({
                        url:'utill_save_team.php',
                        method:'POST',
                        data:{ department:department,icon_class:icon_class},
                        success:function(response){
                            $("#list").load(location.href + " #list");  
                            $('#add-contact1').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            console.log(error);

                        },
                    });
                }else{
                    if(department.trim() == ""){
                        div_department_add.classList.add("has-danger");
                        error_msg_department_add.classList.add("display_inline");
                    }else{
                        div_department_add.classList.remove("has-danger");
                        error_msg_department_add.classList.remove("display_inline");
                        error_msg_department_add.classList.add("display_none");

                    }
                }
            }
            $('#create_job_form').submit(function () { return false; });      

        </script>

    </body>

</html>