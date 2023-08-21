    <?php
    include 'util_config.php';
    include 'util_session.php';
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
            <title>Employees</title>
            <!-- Footable CSS -->
            <link href="./assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
            <link href="./assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
            <!-- Custom CSS -->
            <link href="dist/css/style.min.css" rel="stylesheet">
            <link rel="stylesheet" href="./assets/node_modules/dropify/dist/css/dropify.min.css">
            <link href="./assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
            <style>
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
                    <p class="loader__label">Employees</p>
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
                                <h5 class="text-themecolor font-weight-title font-size-title mb-0">Employees</h5>
                            </div>
                            <div class="col-md-6 mtm-5px">
                                <div class="input-group">
                                    <input type="text" id="searchInput" placeholder="Search By" class="form-control">
                                    <div class="input-group-append"><span class="input-group-text"><i class="ti-search"></i></span></div>
                                </div>
                            </div>
                            <div class="col-md-3 align-self-center text-right">
                                <div class="d-flex justify-content-end align-items-center">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Recruiting</a></li>
                                        <li class="breadcrumb-item text-success">Employees</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- End Bread crumb and right sidebar toggle -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Start Page Content -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body pm-0 small-screen-pr-0 mobile-container-pl-60">
                                        <h4 class="card-title">Emplyees List</h4>
                                        <h6 class="card-subtitle"></h6>
                                        <button type="button" class="btn btn-secondary m-t-10 mb-2 float-right" data-toggle="modal" data-target="#add-contact">Add Employee</button>



                                        <!-- Add Contact Popup Model -->
                                        <div id="add-user" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Create user</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 m-b-20 mt-2">
                                                                        <input type="text" disabled hidden class="form-control" id="m_employee_id" placeholder=""> </div>
                                                                    <div class="col-md-12 m-b-20 mt-2">
                                                                        <div  id="div_first_name_c" class="form-group ">
                                                                            <input onkeyup="error_handle_c('first_name')" type="text" class="form-control" id="first_name_m" placeholder="First Name*"> 
                                                                            <small id="error_msg_first_name_c" class="form-control-feedback display_none">First name is required</small>
                                                                        </div>


                                                                    </div>
                                                                    <div class="col-md-12 m-b-20">
                                                                        <div  id="div_last_name_c" class="form-group ">
                                                                            <input onkeyup="error_handle_c('last_name')" type="text" class="form-control form-control-danger" id="last_name_m"  placeholder="Last Name*" >
                                                                            <small id="error_msg_last_name_c" class="form-control-feedback display_none">Last name is required</small>
                                                                        </div>


                                                                    </div>
                                                                    <div class="col-md-12 m-b-20">

                                                                        <div  id="div_email_c" class="form-group ">
                                                                            <input  onkeyup="error_handle_c('email')" type="email" class="form-control form-control-danger" id="email_m"  placeholder="Email*"> 

                                                                            <small id="error_msg_email_c" class="form-control-feedback display_none">Email is required</small>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-12 m-b-20">
                                                                        <select  name="status" id="status_m"  class="form-control" >
                                                                            <option value="" disabled selected>Select Status</option>
                                                                            <option value="1">Active</option>
                                                                            <option value="0">InActive</option>

                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12 m-b-20">
                                                                        <div id="div_department_c" class="form-group ">
                                                                            <select onchange="error_handle_c('department')"   name="department" id="department_m"  class="form-control" >
                                                                                <option value="0">Select Department</option>
                                                                                <?php 
                                                                                $sql="SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                                                                                $result = $conn->query($sql);
                                                                                if ($result && $result->num_rows > 0) {
                                                                                    while($row = mysqli_fetch_array($result)) {
                                                                                        echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <small id="error_msg_department_c" class="form-control-feedback display_none"> Department is required</small> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 m-b-20">
                                                                        <div id="div_role_c" class="form-group ">
                                                                            <select  onchange="error_handle_c('role')"    name="user_type" id="user_type_m"  class="form-control" >
                                                                                <option value="0">Select Role</option>
                                                                                <?php 
                                                                                $sql="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id OR `hotel_id` =  0 ) and is_delete = 0";
                                                                                $result = $conn->query($sql);
                                                                                if ($result && $result->num_rows > 0) {
                                                                                    while($row = mysqli_fetch_array($result)) {
                                                                                        echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <small id="error_msg_role_c" class="form-control-feedback display_none"> Role is required</small> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </from>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info waves-effect"  onclick="adduser()">Save</button>
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- Add Contact Popup Model -->
                                        <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Add Employee</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                                            <div class="form-group">
                                                                <h4 class="display-inline">Select Title: </h4>
                                                                <div class="custom-control custom-radio inline-div ml-2">
                                                                    <input value="Mr" type="radio" value="Mr" id="customRadio1" name="customRadio" class="custom-control-input" checked>
                                                                    <label class="custom-control-label" for="customRadio1">Mr.</label>
                                                                </div>
                                                                <div class="custom-control custom-radio inline-div ml-2">
                                                                    <input value="Mrs" type="radio" value="Mrs" id="customRadio2" name="customRadio" class="custom-control-input">
                                                                    <label class="custom-control-label" for="customRadio2">Mrs.</label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-12 m-b-20 mt-2">

                                                                        <div  id="div_first_name" class="form-group ">
                                                                            <input onkeyup="error_handle('first_name')" type="text" class="form-control form-control-danger" id="first_name" placeholder="First Name">
                                                                            <small id="error_msg_first_name" class="form-control-feedback display_none">First name is required</small> </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 m-b-20">
                                                                    <div id="div_last_name" class="form-group ">
                                                                        <input onkeyup="error_handle('last_name')" type="text" class="form-control form-control-danger" id="last_name"  placeholder="Last Name*"> 

                                                                        <small id="error_msg" class="form-control-feedback display_none">Last name is required</small> </div>
                                                                </div>
                                                                <div class="col-md-12 m-b-20">
                                                                    <div id="div_email" class="form-group ">

                                                                        <input onkeyup="error_handle('email')" type="text" class="form-control" id="email"  placeholder="Email" class="form-control form-control-danger" > 

                                                                        <small id="error_msg_email" class="form-control-feedback display_none">Email is required</small></div>

                                                                </div>


                                                                <div class="col-md-12 m-b-20">

                                                                    <div id="div_phane_name" class="form-group ">

                                                                        <input onkeyup="error_handle('phone')" type="text" id="phone" class="form-control form-control-danger" placeholder="Phone"> 

                                                                        <small id="error_msg_phone" class="form-control-feedback display_none">Phone is required</small> </div>
                                                                </div>
                                                                <div class="col-md-12 m-b-20">
                                                                    <div id="div_department" class="form-group ">

                                                                        <select onchange="error_handle('department')"  name="department" id="department"  class="form-control" >
                                                                            <option value="0">Select Department</option>
                                                                            <?php 
                                                                            $sql="SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                                                                            $result = $conn->query($sql);
                                                                            if ($result && $result->num_rows > 0) {
                                                                                while($row = mysqli_fetch_array($result)) {
                                                                                    echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <small id="error_msg_department" class="form-control-feedback display_none">Department is required</small> </div>
                                                                </div>
                                                                <div class="col-md-12 m-b-20">

                                                                    <div  id="div_date_of_birth" class="form-group ">


                                                                        <small  class="text-muted">Date of Birth</small>
                                                                        <input onchange="error_handle('dob')" onkeyup="error_handle('dob')" id="dob" type="date" class="form-control form-control-danger" placeholder="Date of Birth"> 

                                                                        <small id="error_msg_date_of_birth" class="form-control-feedback display_none">D.O.B is required</small> </div>

                                                                </div>
                                                                <div class="col-md-12 m-b-20">
                                                                    <div  id="div_place_of_birth" class="form-group ">

                                                                        <input onkeyup="error_handle('pob')" type="text" id="dob_place" class="form-control form-control-danger" placeholder="Place Of Birth"> 

                                                                        <small id="error_msg_place_of_birth" class="form-control-feedback display_none">Place of birth is required</small> </div>
                                                                </div>


                                                                <div class="col-md-12 m-b-20">
                                                                    <div  id="div_tax" class="form-group ">
                                                                        <input onkeyup="error_handle('tax')" type="text" class="form-control form-control-danger" id="tax_number" placeholder="Tax Number"> 
                                                                        <small id="error_msg_tax" class="form-control-feedback display_none">Tax Number is required</small> </div>


                                                                </div>
                                                                <div class="col-md-12 m-b-20">
                                                                    <div  id="div_date_of_joining" class="form-group ">
                                                                        <small  class="text-muted">Date Of Joining</small>
                                                                        <input onchange="error_handle('doj')" type="date" id="start_working_time" class="form-control" placeholder="Date of joining"> 
                                                                        <small id="error_date_of_joining" class="form-control-feedback display_none">Date Of Joining is required</small> </div>

                                                                </div>
                                                                <div class="col-md-12 m-b-20">
                                                                    <h5>Upload Picture</h5>
                                                                    <input type="file" name="file" id="pic_id"  accept="image/png, image/jpeg"  class="dropify" data-max-file-size="2M"  /> 
                                                                </div>
                                                            </div>

                                                        </from>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info waves-effect"  onclick="addapplicant()">Save</button>
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!--                                    edit-->


                                        <!--                                    edit-->


                                        <!--                                    Start-->
                                        <div class="table-responsive">
                                            <table id="demo-foo-addrow" class="shift_pool_tables table table-bordered m-t-30 table-hover contact-list" data-paging="true" data-paging-size="25">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Department</th>
                                                        <th>STATUS <small class="text-muted">(As An User)</small></th>
                                                        <th>STATUS <small class="text-muted">(As An Employee)</small></th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql="SELECT * FROM `tbl_applicants_employee`  WHERE `status_id` = 4 and is_delete= 0 and  hotel_id = $hotel_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC";
                                                    $result = $conn->query($sql);
                                                    if ($result && $result->num_rows > 0) {
                                                        $i=1;
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $applicant_id =   $row['tae_id'];
                                                            $deparment_id =   $row['depart_id_app'];
                                                            $deparment =   "";
                                                            $sql1="SELECT * FROM `tbl_department` WHERE `depart_id` =$deparment_id";
                                                            $result1 = $conn->query($sql1);
                                                            if ($result1 && $result1->num_rows > 0) {
                                                                while($row1 = mysqli_fetch_array($result1)) {
                                                                    $deparment =   $row1['department_name'];
                                                                }
                                                            }
                                                            $status_id = $row['status_id'];
                                                            $status =   "";
                                                            $sql5="SELECT * FROM `tbl_util_status` WHERE `status_id` =$status_id";
                                                            $result5 = $conn->query($sql5);
                                                            if ($result5 && $result5->num_rows > 0) {
                                                                while($row5 = mysqli_fetch_array($result5)) {
                                                                    $status =   $row5['status'];
                                                                }
                                                            }
                                                            $is_active_user_id = $row['is_active_user'];
                                                            $is_active_user =   "";
                                                            $sql5="SELECT * FROM `tbl_util_status` WHERE `status_id` =$is_active_user_id";
                                                            $result5 = $conn->query($sql5);
                                                            if ($result5 && $result5->num_rows > 0) {
                                                                while($row5 = mysqli_fetch_array($result5)) {
                                                                    $is_active_user =   $row5['status'];
                                                                }
                                                            }
                                                    ?>
                                                    <tr class="">
                                                        <td><?php 
                                                            echo $i?></td>
                                                        <td>
                                                            <img onerror="this.src='./assets/images/users/user.png'" src="<?php echo $row['image_url'] ?>" alt="user" width="40" height="40" class="rounded-circle" />&nbsp;&nbsp;<?php echo $row['name']." ".$row['surname'] ?>
                                                        </td>
                                                        <td><?php echo $row['email'] ?></td>
                                                        <td><?php echo $row['phone'] ?></td>
                                                        <td><?php echo $deparment; ?></td>
                                                        <td class="text-center"><div  
                                                                                     <?php if ($is_active_user_id == 2 && $Edit_users_teams_departments == 1){  ?>
                                                                                     onclick="open_model('<?php echo $row['tae_id']?>','<?php echo $row['name']?>','<?php echo $row['surname']?>','<?php echo $row['email']?>','<?php echo $row['depart_id_app']?>')" 
                                                                                     <?php
                                                                                                                                                         }  ?>
                                                                                     class="label p-2 label-table label-success <?php if ($is_active_user_id == 2  && $Edit_users_teams_departments){ echo "pointer" ;
                                                        }  ?>"><?php echo $is_active_user; ?></div></td>

                                                        <td><div class="btn-group">
                                                            <span id="thisstatus<?php echo $i; ?>" class="dropdown-toggle label
                                                                                                          <?php if($status_id == 4){ echo "label-success";  }
                                                                                                          ?> pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <?php   echo "Currently Working"; ?>

                                                            </span>

                                                            <div class="dropdown-menu animated flipInY">
                                                                <?php 
                                                            $sql2="SELECT * FROM `tbl_util_status` WHERE    `status_id` = 6 OR `status_id` = 7";
                                                            $result2 = $conn->query($sql2);
                                                            if ($result2 && $result2->num_rows > 0) {
                                                                while($row2 = mysqli_fetch_array($result2)) {
                                                                ?>
                                                                <a class="dropdown-item" onclick="updatestatus(<?php echo $row2['status_id']; ?>,<?php echo $applicant_id; ?>,<?php echo $i; ?>)" href="javascript:void(0)">
                                                                    <?php
                                                                    $mstatus = $row2['status'];
                                                                    if($mstatus == "In Pipeline"){
                                                                        $mstatus = "Take Back";
                                                                    }
                                                                    echo $mstatus; ?></a>
                                                                <?php
                                                                }
                                                            }
                                                                ?>
                                                            </div>
                                                            </div></td>
                                                        <td class="font-size-subheading  text-center">
                                                            <a href="employees_detail.php?id=<?php echo $applicant_id ?>&open=edit"><i class="fas fa-pencil-alt"></i></a>	&nbsp;	&nbsp;
                                                            <a onclick="d('<?php echo $applicant_id;?>')" href="javascript:void(0)"><i class="fas fa-trash-alt"></i></a>&nbsp;	&nbsp;
                                                            <a  href="employees_detail.php?id=<?php echo $applicant_id ?>"
                                                               ><i class="ti-eye">
                                                                </i></a>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                                    $i++;
                                                        }
                                                    }
                                                    ?>
                                                    <div id="snackbar">Some text some message..</div>
                                                </tbody>
                                            </table>
                                        </div>


                                        <!--                                    //end-->
                                    </div>
                                </div>




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
            <!--Custom JavaScript -->
            <script src="dist/js/custom.min.js"></script>
            <!-- Footable -->
            <script src="./assets/node_modules/moment/moment.js"></script>
            <script src="./assets/node_modules/footable/js/footable.min.js"></script>

            <script src="./assets/node_modules/dropify/dist/js/dropify.min.js"></script>
            <!-- Sweet-Alert  -->
            <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
            <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

            <script>

                var div_last_name_c = document.getElementById("div_last_name_c");
                var div_first_name_c = document.getElementById("div_first_name_c");
                var div_email_c = document.getElementById("div_email_c");
                var div_department_c = document.getElementById("div_department_c");
                var div_role_c = document.getElementById("div_role_c");
                //            small text
                var lastname_error_msg_c = document.getElementById("error_msg_last_name_c");
                var first_error_msg_c = document.getElementById("error_msg_first_name_c");
                var email_error_msg_c = document.getElementById("error_msg_email_c");
                var department_error_msg_c = document.getElementById("error_msg_department_c");
                var role_error_msg_c = document.getElementById("error_msg_role_c");
                function error_handle_c(run) {
                    var first_name = document.getElementById('first_name_m').value;
                    var last_name = document.getElementById('last_name_m').value;
                    var email = document.getElementById('email_m').value;
                    var department_id = document.getElementById('department_m').value;
                    var user_type_id = document.getElementById('user_type_m').value;
                    if(run == "last_name"){
                        if(last_name.trim() == ""){
                            div_last_name_c.classList.add("has-danger");
                            lastname_error_msg_c.classList.add("display_inline");
                        }else{
                            div_last_name_c.classList.remove("has-danger");
                            lastname_error_msg_c.classList.remove("display_inline");
                            lastname_error_msg_c.classList.add("display_none");

                        }
                    }
                    if(run == "first_name"){
                        if(first_name.trim() == ""){
                            div_first_name_c.classList.add("has-danger");
                            first_error_msg_c.classList.add("display_inline");
                        }else{
                            div_first_name_c.classList.remove("has-danger");
                            first_error_msg_c.classList.remove("display_inline");
                            first_error_msg_c.classList.add("display_none");
                        }
                    }
                    if(run == "email"){
                        if(email.trim() == ""){
                            div_email_c.classList.add("has-danger");
                            email_error_msg_c.classList.add("display_inline");
                        }else{

                            div_email_c.classList.remove("has-danger");
                            email_error_msg_c.classList.remove("display_inline");
                            email_error_msg_c.classList.add("display_none");

                        }
                    }
                    if(run == "department"){
                        if(department_id == 0){
                            div_department_c.classList.add("has-danger");
                            department_error_msg_c.classList.add("display_inline");
                        }else{

                            div_department_c.classList.remove("has-danger");
                            department_error_msg_c.classList.remove("display_inline");
                            department_error_msg_c.classList.add("display_none");
                        }
                    }
                    if(run == "role"){
                        if(user_type_id == 0){
                            div_role_c.classList.add("has-danger");
                            role_error_msg_c.classList.add("display_inline");
                        }else{

                            div_role_c.classList.remove("has-danger");
                            role_error_msg_c.classList.remove("display_inline");
                            role_error_msg_c.classList.add("display_none");

                        }
                    }
                }

            </script>


            <script>
                //                div
                var last_name_div = document.getElementById("div_last_name");
                var first_name_div = document.getElementById("div_first_name");
                var email_div = document.getElementById("div_email");
                var phone_div = document.getElementById("div_phane_name");
                var department_div = document.getElementById("div_department");

                var div_date_of_birth = document.getElementById("div_date_of_birth");
                var div_place_of_birth = document.getElementById("div_place_of_birth");
                var div_tax = document.getElementById("div_tax");
                var div_date_of_joining = document.getElementById("div_date_of_joining");


                //            small text
                var lastname_error_msg = document.getElementById("error_msg");
                var first_error_msg = document.getElementById("error_msg_first_name");
                var email_error_msg = document.getElementById("error_msg_email");
                var phone_error_msg = document.getElementById("error_msg_phone");
                var department_error_msg = document.getElementById("error_msg_department");
                var dob_error_msg = document.getElementById("error_msg_date_of_birth");
                var pob_error_msg = document.getElementById("error_msg_place_of_birth");
                var tax_error_msg = document.getElementById("error_msg_tax");
                var doj_error_msg = document.getElementById("error_date_of_joining");
                function error_handle(run) {
                    var first_name = document.getElementById('first_name').value;
                    var last_name = document.getElementById('last_name').value;
                    var email = document.getElementById('email').value;
                    var phone = document.getElementById('phone').value;
                    var department_id = document.getElementById('department').value;
                    var dob = document.getElementById('dob').value;
                    var dob_place = document.getElementById('dob_place').value;
                    var tax_number = document.getElementById('tax_number').value;
                    var date_of_joining = document.getElementById('start_working_time').value;
                    if(run == "last_name"){
                        if(last_name.trim() == ""){
                            last_name_div.classList.add("has-danger");
                            lastname_error_msg.classList.add("display_inline");
                        }else{
                            last_name_div.classList.remove("has-danger");
                            lastname_error_msg.classList.remove("display_inline");
                            lastname_error_msg.classList.add("display_none");

                        }
                    }
                    if(run == "first_name"){
                        if(first_name.trim() == ""){
                            first_name_div.classList.add("has-danger");
                            first_error_msg.classList.add("display_inline");
                        }else{
                            first_name_div.classList.remove("has-danger");
                            first_error_msg.classList.remove("display_inline");
                            first_error_msg.classList.add("display_none");
                        }
                    }
                    if(run == "email"){
                        if(email.trim() == ""){
                            email_div.classList.add("has-danger");
                            email_error_msg.classList.add("display_inline");
                        }else{

                            email_div.classList.remove("has-danger");
                            email_error_msg.classList.remove("display_inline");
                            email_error_msg.classList.add("display_none");

                        }
                    }
                    if(run == "phone"){
                        if(phone.trim() == ""){
                            phone_div.classList.add("has-danger");
                            phone_error_msg.classList.add("display_inline");
                        }else{

                            phone_div.classList.remove("has-danger");
                            phone_error_msg.classList.remove("display_inline");
                            phone_error_msg.classList.add("display_none");
                        }
                    }
                    if(run == "department"){
                        if(department_id == 0){
                            department_div.classList.add("has-danger");
                            department_error_msg.classList.add("display_inline");
                        }else{
                            department_div.classList.remove("has-danger");
                            department_error_msg.classList.remove("display_inline");
                            department_error_msg.classList.add("display_none");
                        }
                    }
                    if(run == "dob"){
                        if(dob.trim() == ""){
                            div_date_of_birth.classList.add("has-danger");
                            dob_error_msg.classList.add("display_inline");
                        }else{
                            div_date_of_birth.classList.remove("has-danger");
                            dob_error_msg.classList.remove("display_inline");
                            dob_error_msg.classList.add("display_none");
                        }
                    }
                    if(run == "pob"){
                        if(dob_place.trim() == ""){
                            div_place_of_birth.classList.add("has-danger");
                            pob_error_msg.classList.add("display_inline");
                        }else{
                            div_place_of_birth.classList.remove("has-danger");
                            pob_error_msg.classList.remove("display_inline");
                            pob_error_msg.classList.add("display_none");
                        }
                    }
                    if(run == "tax"){
                        if(tax_number.trim() == ""){
                            div_tax.classList.add("has-danger");
                            tax_error_msg.classList.add("display_inline");
                        }else{
                            div_tax.classList.remove("has-danger");
                            tax_error_msg.classList.remove("display_inline");
                            tax_error_msg.classList.add("display_none");
                        }
                    }
                    if(run == "doj"){
                        if(date_of_joining.trim() == ""){
                            div_date_of_joining.classList.add("has-danger");
                            doj_error_msg.classList.add("display_inline");
                        }else{
                            div_date_of_joining.classList.remove("has-danger");
                            doj_error_msg.classList.remove("display_inline");
                            doj_error_msg.classList.add("display_none");
                        }
                    }



                }



            </script>
            <script>
                //            delete employee
                function d(employee_id) {
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
                                data:{ tablename:"tbl_applicants_employee", idname:"tae_id", id:employee_id, statusid:1,statusname: "is_delete"},
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
                                                location.replace("employees.php");
                                            }
                                        })
                                    }
                                    else{
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
                                    l
                                },
                            });
                        }
                    })
                }
                function formatDate(date) {
                    var d = new Date(date),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();

                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                        day = '0' + day;

                    return [year, month, day].join('-');
                }
                $(document).ready(function(){
                    $("#searchInput").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#demo-foo-addrow tbody tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });


                function open_model(id,name,surname,email,dep) {
                    $("#add-user").modal();
                    $('#department_m').val(dep);
                    $('#status_m').val(1);
                    document.getElementById('m_employee_id').value = id;
                    document.getElementById('first_name_m').value = name;
                    document.getElementById('last_name_m').value = surname;
                    document.getElementById('email_m').value = email;
                }
                function adduser() {
                    var first_name = document.getElementById('first_name_m').value;
                    var last_name = document.getElementById('last_name_m').value;
                    var email = document.getElementById('email_m').value;
                    var status = document.getElementById('status_m').value;
                    var department_id = document.getElementById('department_m').value;
                    var user_type_id = document.getElementById('user_type_m').value;
                    var employee_id = document.getElementById('m_employee_id').value;
                    if(first_name.trim() != '' && last_name.trim() != '' && email.trim() != '' && status != '' && department_id != 0 && user_type_id != 0)
                    {
                        var fd = new FormData();
                        fd.append('first_name',first_name);
                        fd.append('last_name',last_name);
                        fd.append('email',email);
                        fd.append('status',status);
                        fd.append('department_id',department_id); 
                        fd.append('user_type_id',user_type_id);
                        fd.append('employee_id',employee_id);


                        $.ajax({
                            url:'util_create_user.php',
                            type: 'post',
                            data:fd,
                            processData: false,
                            contentType: false,
                            success:function(response){
                                console.log(response);
                                if(response == "EXIT"){
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Email Already Exist!!!',
                                        footer: ''
                                    });
                                }
                                else if(response == "CREATE"){
                                    Swal.fire({
                                        title: 'User Created',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.href = "employees.php";
                                        }
                                    })
                                }
                                else if(response == "UPDATE"){
                                    Swal.fire({
                                        title: 'User Updated',
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

                    }else {


                        if(last_name.trim() == ""){
                            div_last_name_c.classList.add("has-danger");
                            lastname_error_msg_c.classList.add("display_inline");
                        }else{
                            div_last_name_c.classList.remove("has-danger");
                            lastname_error_msg_c.classList.remove("display_inline");
                            lastname_error_msg_c.classList.add("display_none");

                        }


                        if(first_name.trim() == ""){
                            div_first_name_c.classList.add("has-danger");
                            first_error_msg_c.classList.add("display_inline");
                        }else{
                            div_first_name_c.classList.remove("has-danger");
                            first_error_msg_c.classList.remove("display_inline");
                            first_error_msg_c.classList.add("display_none");
                        }


                        if(email.trim() == ""){
                            div_email_c.classList.add("has-danger");
                            email_error_msg_c.classList.add("display_inline");
                        }else{

                            div_email_c.classList.remove("has-danger");
                            email_error_msg_c.classList.remove("display_inline");
                            email_error_msg_c.classList.add("display_none");

                        }


                        if(department_id == 0){
                            div_department_c.classList.add("has-danger");
                            department_error_msg_c.classList.add("display_inline");
                        }else{

                            div_department_c.classList.remove("has-danger");
                            department_error_msg_c.classList.remove("display_inline");
                            department_error_msg_c.classList.add("display_none");
                        }
                        if(user_type_id == 0){
                            div_role_c.classList.add("has-danger");
                            role_error_msg_c.classList.add("display_inline");
                        }else{

                            div_role_c.classList.remove("has-danger");
                            role_error_msg_c.classList.remove("display_inline");
                            role_error_msg_c.classList.add("display_none");

                        }




                    }
                }

            </script>
            <script>
                function updatestatus1(status,applicantid,i) {
                    $.ajax({
                        url:'util_update_status.php',
                        method:'POST',
                        data:{ tablename:"tbl_applicants_employee", idname:"tae_id", id:applicantid, statusid:status,statusname: "is_active_user"},
                        success:function(response){
                            if(response == "Updated"){
                                var x = document.getElementById("snackbar");
                                x.className = "show";
                                x.innerHTML="Your Change Successfully Saved.";
                                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                document.getElementById("mthisstatus"+i).classList.remove("label-success");
                                document.getElementById("mthisstatus"+i).classList.remove("label-info");
                                document.getElementById("mthisstatus"+i).classList.remove("label-danger");
                                if(status == 1){
                                    var thisstatus = "Active";
                                    document.getElementById("mthisstatus"+i).classList.add("label-success");

                                } else if(status == 2){
                                    var thisstatus = "Deactive";
                                    document.getElementById("mthisstatus"+i).classList.add("label-danger");
                                }
                                document.getElementById("mthisstatus"+i).innerHTML = thisstatus;
                            }
                            else if (response == "Not Updated"){
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            l
                        },
                    });
                }
                function updatestatus(status,applicantid,i) {
                    $.ajax({
                        url:'util_update_status.php',
                        method:'POST',
                        data:{ tablename:"tbl_applicants_employee", idname:"tae_id", id:applicantid, statusid:status,statusname: "status_id"},
                        success:function(response){
                            if(response == "Updated"){
                                var x = document.getElementById("snackbar");
                                x.className = "show";
                                x.innerHTML="Your Change Successfully Saved.";
                                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                                document.getElementById("thisstatus"+i).classList.remove("label-success");
                                document.getElementById("thisstatus"+i).classList.remove("label-info");
                                document.getElementById("thisstatus"+i).classList.remove("label-danger");
                                if(status == 7){
                                    var thisstatus = "Retired";
                                    document.getElementById("thisstatus"+i).classList.add("label-danger");
                                    const d = new Date();  
                                    var m = formatDate(d);
                                    console.log(m);
                                    $.ajax({
                                        url:'util_update_status.php',
                                        method:'POST',
                                        data:{ tablename:"tbl_applicants_employee", idname:"tae_id", id:applicantid, statusid:m,statusname: "end_working_time"},
                                        success:function(response){
                                            console.log(response);
                                            if(response == "Updated"){
                                            }
                                            else{
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(error);
                                            l
                                        },
                                    });
                                }
                                else if(status == 6){
                                    var thisstatus = "Take Back";
                                    document.getElementById("thisstatus"+i).classList.add("label-info");
                                }
                                document.getElementById("thisstatus"+i).innerHTML = thisstatus;
                            }
                            else if (response == "Not Updated"){
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            l
                        },
                    });
                }


                function addapplicant() {
                    console.log("Saved");
                    var mrtitle ;
                    var radios = document.getElementsByName('customRadio');
                    for (var radio of radios)
                    {
                        if (radio.checked) {
                            mrtitle = radio.value;
                        }
                    }
                    var first_name = document.getElementById('first_name').value;
                    var last_name = document.getElementById('last_name').value;
                    var email = document.getElementById('email').value;
                    var phone = document.getElementById('phone').value;
                    var department_id = document.getElementById('department').value;
                    var dob = document.getElementById('dob').value;
                    var dob_place = document.getElementById('dob_place').value;
                    var tax_number = document.getElementById('tax_number').value;
                    var start_working_time = document.getElementById('start_working_time').value;
                    var hotel_id = <?php echo $hotel_id; ?>;
                    var fd = new FormData();
                    var files = $('#pic_id')[0].files;

                    if(last_name.trim() != "" && first_name.trim() != "" &&  email.trim() != "" && phone.trim() != "" && dob.trim() != "" && dob_place.trim() != "" && tax_number.trim() != ""  && start_working_time.trim() != "" && department_id != 0 ){
                        if(department_id == 0){
                        }else{
                            fd.append('file',files[0]);
                            fd.append('mrtitle',mrtitle);
                            fd.append('first_name',first_name);
                            fd.append('last_name',last_name);
                            fd.append('email',email);
                            fd.append('phone',phone);
                            fd.append('department_id',department_id); 
                            fd.append('dob',dob);
                            fd.append('dob_place',dob_place);
                            fd.append('tax_number',tax_number);
                            fd.append('start_working_time',start_working_time);
                            fd.append('hotel_id',hotel_id);
                            fd.append('status_id',4);
                            $.ajax({
                                url:'util_save_applicant.php',
                                type: 'post',
                                data:fd,
                                processData: false,
                                contentType: false,
                                success:function(response){
                                    console.log(response);
                                    if(response == "CREATE"){
                                        Swal.fire({
                                            title: 'Employee Created',
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
                    }else{
                        if(last_name.trim() == ""){
                            last_name_div.classList.add("has-danger");
                            lastname_error_msg.classList.add("display_inline");
                        }else{
                            last_name_div.classList.remove("has-danger");
                            lastname_error_msg.classList.remove("display_inline");
                            lastname_error_msg.classList.add("display_none");

                        }
                        if(first_name.trim() == ""){
                            first_name_div.classList.add("has-danger");
                            first_error_msg.classList.add("display_inline");
                        }else{

                            first_name_div.classList.remove("has-danger");
                            first_error_msg.classList.remove("display_inline");
                            first_error_msg.classList.add("display_none");

                        }
                        if(email.trim() == ""){
                            email_div.classList.add("has-danger");
                            email_error_msg.classList.add("display_inline");
                        }else{

                            email_div.classList.remove("has-danger");
                            email_error_msg.classList.remove("display_inline");
                            email_error_msg.classList.add("display_none");

                        }
                        if(phone.trim() == ""){
                            phone_div.classList.add("has-danger");
                            phone_error_msg.classList.add("display_inline");
                        }else{

                            phone_div.classList.remove("has-danger");
                            phone_error_msg.classList.remove("display_inline");
                            phone_error_msg.classList.add("display_none");
                        }
                        if(department_id == 0){
                            department_div.classList.add("has-danger");
                            department_error_msg.classList.add("display_inline");
                        }else{
                            department_div.classList.remove("has-danger");
                            department_error_msg.classList.remove("display_inline");
                            department_error_msg.classList.add("display_none");
                        }


                        if(dob.trim() == ""){
                            div_date_of_birth.classList.add("has-danger");
                            dob_error_msg.classList.add("display_inline");
                        }else{
                            div_date_of_birth.classList.remove("has-danger");
                            dob_error_msg.classList.remove("display_inline");
                            dob_error_msg.classList.add("display_none");
                        }
                        if(dob_place.trim() == ""){
                            div_place_of_birth.classList.add("has-danger");
                            pob_error_msg.classList.add("display_inline");
                        }else{
                            div_place_of_birth.classList.remove("has-danger");
                            pob_error_msg.classList.remove("display_inline");
                            pob_error_msg.classList.add("display_none");
                        }

                        if(tax_number.trim() == ""){
                            div_tax.classList.add("has-danger");
                            tax_error_msg.classList.add("display_inline");
                        }else{
                            div_tax.classList.remove("has-danger");
                            tax_error_msg.classList.remove("display_inline");
                            tax_error_msg.classList.add("display_none");
                        }
                        if(start_working_time.trim() == ""){
                            div_date_of_joining.classList.add("has-danger");
                            doj_error_msg.classList.add("display_inline");
                        }else{
                            div_date_of_joining.classList.remove("has-danger");
                            doj_error_msg.classList.remove("display_inline");
                            doj_error_msg.classList.add("display_none");
                        }


                    }

                }
            </script>
            <script>
                $(document).ready(function() {
                    // Basic
                    $('.dropify').dropify();

                    // Translated
                    $('.dropify-fr').dropify({
                        messages: {
                            default: 'Glissez-déposez un fichier ici ou cliquez',
                            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                            remove: 'Supprimer',
                            error: 'Désolé, le fichier trop volumineux'
                        }
                    });
                    // Used events
                    var drEvent = $('#input-file-events').dropify();

                    drEvent.on('dropify.beforeClear', function(event, element) {
                        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                    });

                    drEvent.on('dropify.afterClear', function(event, element) {
                        alert('File deleted');
                    });

                    drEvent.on('dropify.errors', function(event, element) {
                        console.log('Has Errors');
                    });

                    var drDestroy = $('#input-file-to-destroy').dropify();
                    drDestroy = drDestroy.data('dropify')
                    $('#toggleDropify').on('click', function(e) {
                        e.preventDefault();
                        if (drDestroy.isDropified()) {
                            drDestroy.destroy();
                        } else {
                            drDestroy.init();
                        }
                    })
                });
            </script>
        </body>
    </html>