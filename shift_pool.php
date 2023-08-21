<?php
include 'util_config.php';
include 'util_session.php';

$sql_alert="UPDATE `tbl_alert` SET `is_viewed`='1' WHERE `user_id` = $user_id AND (`id_table_name` = 'tbl_shift_offer' OR `id_table_name` = 'tbl_shift_trade') ";
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
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
        <title>Shift Pool</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />


        <!-- Multiple Select -->
        <link href="./assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


        <link href="./dist/css/style.min.css" rel="stylesheet">
        <link href="./dist/css/time_schedule.css" rel="stylesheet">

        <!--        Tabs-->
        <link href="./dist/css/pages/tab-page.css" rel="stylesheet">


    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Shift Pool</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Shift Pool</h4>
                        </div>
                        <?php  if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                        <div class="col-md-9 text-right">
                            <label class="btn btn-dark">
                                <input type="checkbox" 
                                       <?php $sql_check = "SELECT * FROM `tbl_time_schedule_rules` WHERE hotel_id = $hotel_id AND 	is_shift_pool_enable = 0";
                                                                                   $result_check = $conn->query($sql_check);
                                                                                   if($result_check && $result_check->num_rows > 0){ echo ''; }else{ echo 'checked'; } ?>
                                       onchange="shift_rule_change();" id="md_checkbox_22" class="filled-in chk-col-light-blue">
                                <label class="mb-0" for="md_checkbox_22">&nbsp;Enable Shift Pool For Users</label>
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
                                        <?php  if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                                        <li class="nav-item w-150-custom"> <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-pool"></i></span> <span class="hidden-xs-down">Shift Pool Request</span> </a> </li>
                                        <?php } ?>
                                        <li class="nav-item w-150-custom"> <a class="nav-link <?php  if ($Create_view_schedules == 1 || $usert_id == 1) { }else{echo 'active';}?>" data-toggle="tab" href="#profile3" role="tab"><span class="hidden-sm-up"><i class="fas fa-hand-holding"></i></span> <span class="hidden-xs-down">Up for grabs</span></a> </li>
                                        <?php  if ($Create_view_schedules == 1 || $usert_id == 1) { ?>
                                        <li class="nav-item w-150-custom"> <a class="nav-link" data-toggle="tab" href="#messages3" role="tab"><span class="hidden-sm-up"><i class="fas fa-dollar-sign"></i></span> <span class="hidden-xs-down">Trade Request</span></a> </li>
                                        <?php } ?>
                                        <li class="nav-item w-150-custom"> <a class="nav-link" data-toggle="tab" href="#mytrade3" role="tab"><span class="hidden-sm-up"><i class="far fa-money-bill-alt"></i></span> <span class="hidden-xs-down">My Trade</span></a> </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content w-100 pm-1rem">
                                        <div class="tab-pane <?php  if ($Create_view_schedules == 1 || $usert_id == 1) { echo 'active'; }?>" id="home3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>

                                                <div class="col-lg-10 pm-0">
                                                    <h3><b>Shift pool requests</b></h3>
                                                    <?php
                                                    $sql_up_for = "SELECT a.*,b.*,d.date,d.start_time,d.end_time,e.department_name,e.department_name_it,e.department_name_de,c.firstname as name FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_by = b.user_id INNER JOIN tbl_user as c on a.offer_to = c.user_id INNER JOIN tbl_shifts as d on a.shift_offered = d.sfs_id INNER JOIN tbl_department as e on c.depart_id = e.depart_id WHERE a.hotel_id = $hotel_id AND a.is_approved_by_employee = 1 AND a.is_active = 1 AND a.is_delete_admin = 0";

                                                    $result_up_for = $conn->query($sql_up_for);
                                                    if ($result_up_for && $result_up_for->num_rows > 0) {
                                                    ?>

                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="shift_pool_tables wm-100 table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">

                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Shift being offered</th>
                                                                    <th class="" >Offering to</th>
                                                                    <th class="" >Time</th>
                                                                    <th class="" >Department</th>
                                                                    <th class="text-center">Action</th>
                                                                    <th class="text-center ">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_up_for)) {
                                                                ?>
                                                                <tr class="">
                                                                    <td class="text-left">
                                                                        <img src="<?php echo $row['address']; ?>" onerror="this.src='./assets/images/users/user.png'"  alt="user" width="40" height="40" class="mr-2 rounded-circle"  /><?php echo $row['firstname']; ?>
                                                                    </td>
                                                                    <td ><?php echo $row['name']; if($row['title'] != ""){ echo '<br><small>('.$row['title'].')</small>'; } ?></td>
                                                                    <td><?php echo date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time']; ?></td>
                                                                    <td><?php if($row['department_name'] != ""){ echo $row['department_name']; }else if($row['department_name_it'] != ""){ echo $row['department_name_it'];  }else{ echo $row['department_name_de']; } ?></td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <button <?php if($row['is_approved_by_admin'] == 1){ echo 'disabled'; } ?> onclick="take_shift(<?php echo $row['offer_to']; ?>,'admin',<?php echo $row['shift_offered']; ?>,<?php echo $row['sftou_id']; ?>)" class="btn w-100 btn-success d-lg-block "><?php if($row['is_approved_by_admin'] == 1){ echo 'Accepted'; }else{echo 'Accept';} ?></button>
                                                                    </td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a href="javascript:void(0)" onclick="delete_offer('admin','<?php echo $row['sftou_id']; ?>')" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>

                                                                <?php 
                                                        } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No requests found</b></h5>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane <?php  if ($Create_view_schedules == 1 || $usert_id == 1) {}else{echo 'active';} ?>" id="profile3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>

                                                <div class="col-lg-10 pm-0">
                                                    <h3><b>Up for grabs</b></h3>
                                                    <?php 
                                                    $sql_up_for = "SELECT a.*,b.*,d.date,d.start_time,d.end_time,e.department_name,e.department_name_it,e.department_name_de,c.firstname as name FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_by = b.user_id INNER JOIN tbl_user as c on a.offer_to = c.user_id INNER JOIN tbl_shifts as d on a.shift_offered = d.sfs_id INNER JOIN tbl_department as e on c.depart_id = e.depart_id WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete_user = 0 AND a.offer_to = $user_id";

                                                    $result_up_for = $conn->query($sql_up_for);
                                                    if ($result_up_for && $result_up_for->num_rows > 0) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="shift_pool_tables wm-100 table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Shift being offered</th>
                                                                    <th class="" >Offering to</th>
                                                                    <th class="" >Time</th>
                                                                    <th class="" >Department</th>
                                                                    <th class="text-center">Action</th>
                                                                    <th class="text-center ">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_up_for)) {
                                                                ?>

                                                                <tr class="">
                                                                    <td class="text-left">
                                                                        <img src="<?php echo $row['address']; ?>" onerror="this.src='./assets/images/users/user.png'"  alt="user" width="40" height="40" class="mr-2 rounded-circle"  /><?php echo $row['firstname']; ?>
                                                                    </td>
                                                                    <td ><?php echo $row['name']; if($row['title'] != ""){ echo '<br><small>('.$row['title'].')</small>'; } ?></td>
                                                                    <td><?php echo date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time']; ?></td>
                                                                    <td><?php if($row['department_name'] != ""){ echo $row['department_name']; }else if($row['department_name_it'] != ""){ echo $row['department_name_it'];  }else{ echo $row['department_name_de']; } ?></td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <button <?php if($row['is_approved_by_employee'] == 1){ echo 'disabled'; } ?> onclick="take_shift(<?php echo $row['offer_to']; ?>,'user',<?php echo $row['shift_offered']; ?>,<?php echo $row['sftou_id']; ?>)" class="btn w-100 btn-secondary d-lg-block "><?php if($row['is_approved_by_admin'] == 1){ echo 'Assigned By Admin'; }else if($row['is_approved_by_employee'] == 1){ echo 'Shift Taken'; }else{echo 'Take Shift';} ?></button>
                                                                    </td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a href="javascript:void(0)" onclick="delete_offer('user','<?php echo $row['sftou_id']; ?>')" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>

                                                                <?php  
                                                        } ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No shifts being offered up</b></h5>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="messages3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>

                                                <div class="col-lg-10 pm-0">
                                                    <h3><b>Trade requests</b></h3>
                                                    <?php
                                                    $sql_up_for = "SELECT a.*,b.*,d.date,d.start_time,d.end_time,x.date as dd,x.start_time as ss,x.end_time as ee,c.firstname as name FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_by = b.user_id INNER JOIN tbl_user as c on a.offer_to = c.user_id INNER JOIN tbl_shifts as d on a.shift_offered = d.sfs_id INNER JOIN tbl_shifts as x on a.shift_to = x.sfs_id WHERE a.hotel_id = $hotel_id AND a.is_approved_by_employee = 1 AND a.is_active = 1 AND a.is_delete_admin = 0";
                                                    $result_up_for = $conn->query($sql_up_for);
                                                    if ($result_up_for && $result_up_for->num_rows > 0) { ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="shift_pool_tables wm-100 table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">Offering By</th>
                                                                    <th class="">Shift offered</th>
                                                                    <th class="">Offered to</th>
                                                                    <th class="">Offered with</th>
                                                                    <th class="text-center">Action</th>
                                                                    <th class="text-center ">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                        while ($row = mysqli_fetch_array($result_up_for)) {
                                                                ?>

                                                                <tr class="">
                                                                    <td class="text-left">
                                                                        <img src="<?php echo $row['address']; ?>" onerror="this.src='./assets/images/users/user.png'"  alt="user" width="40" height="40" class="mr-2 rounded-circle"  /><?php echo $row['firstname']; ?>
                                                                    </td>
                                                                    <td><?php echo date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time']; ?></td>
                                                                    <td ><?php echo $row['name']; if($row['title'] != ""){ echo '<br><small>('.$row['title'].')</small>'; } ?></td>
                                                                    <td><?php echo date("D, M d, Y", strtotime($row['dd'])).' '.$row['ss'].' - '.$row['ee']; ?></td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <button <?php if($row['is_approved_by_admin'] == 1){ echo 'disabled'; } ?> onclick="accept_shift(<?php echo $row['offer_to']; ?>,'admin',<?php echo $row['shift_offered']; ?>,<?php echo $row['sfttrd_id']; ?>,<?php echo $row['shift_to']; ?>,<?php echo $row['offer_by']; ?>)" class="btn w-100 btn-success d-lg-block "><?php if($row['is_approved_by_admin'] == 1){ echo 'Approved'; }else{echo 'Approve';} ?></button>
                                                                    </td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a href="javascript:void(0)" onclick="delete_trade('admin','<?php echo $row['sfttrd_id']; ?>')" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php  
                                                        } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No requests found</b></h5>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="mytrade3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-1"></div>

                                                <div class="col-lg-10 pm-0">
                                                    <h3><b>Trades</b></h3>
                                                    <?php     $sql_up_for = "SELECT a.*,b.*,d.date,d.start_time,d.end_time,x.date as dd,x.start_time as ss,x.end_time as ee,c.firstname as name FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_by = b.user_id INNER JOIN tbl_user as c on a.offer_to = c.user_id INNER JOIN tbl_shifts as d on a.shift_offered = d.sfs_id INNER JOIN tbl_shifts as x on a.shift_to = x.sfs_id WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete_user = 0 AND a.offer_to = $user_id";
                                                    $result_up_for = $conn->query($sql_up_for);
                                                    if ($result_up_for && $result_up_for->num_rows > 0) { ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="shift_pool_tables wm-100 table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">Offering By</th>
                                                                    <th class="">Shift offered</th>
                                                                    <th class="">Offered to</th>
                                                                    <th class="">Offered with</th>
                                                                    <th class="text-center">Action</th>
                                                                    <th class="text-center ">Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_up_for)) {
                                                                ?>

                                                                <tr class="">
                                                                    <td class="text-left">
                                                                        <img src="<?php echo $row['address']; ?>" onerror="this.src='./assets/images/users/user.png'"  alt="user" width="40" height="40" class="mr-2 rounded-circle"  /><?php echo $row['firstname']; ?>
                                                                    </td>
                                                                    <td><?php echo date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time']; ?></td>
                                                                    <td ><?php echo $row['name']; if($row['title'] != ""){ echo '<br><small>('.$row['title'].')</small>'; } ?></td>
                                                                    <td><?php echo date("D, M d, Y", strtotime($row['dd'])).' '.$row['ss'].' - '.$row['ee']; ?></td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <button <?php if($row['is_approved_by_employee'] == 1){ echo 'disabled'; } ?> onclick="accept_shift(<?php echo $row['offer_to']; ?>,'user',<?php echo $row['shift_offered']; ?>,<?php echo $row['sfttrd_id']; ?>,<?php echo $row['shift_to']; ?>,<?php echo $row['offer_by']; ?>)" class="btn w-100 btn-secondary d-lg-block "><?php if($row['is_approved_by_admin'] == 1){ echo 'Assigned By Admin'; }else if($row['is_approved_by_employee'] == 1){ echo 'Trade Accepted'; }else{echo 'Accept Trade';} ?></button>
                                                                    </td>
                                                                    <td class="font-size-subheading  text-center black_color">
                                                                        <a href="javascript:void(0)" onclick="delete_trade('user','<?php echo $row['sfttrd_id']; ?>')" class="black_color"><i class="fas fa-trash-alt"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No requests found</b></h5>
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

        <!-- Sweet-Alert  -->
        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

        <script>
            function delete_offer(slug,id){
                console.log(slug,id);
                var stsname="";
                if(slug == 'user'){
                    stsname = "is_delete_user";
                }else{
                    stsname = "is_delete_admin";
                }

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
                            data:{ tablename:"tbl_shift_offer", idname:"sftou_id", id:id, statusid:1,statusname: stsname},
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
                });
            }

            function delete_trade(slug,id){
                console.log(slug,id);
                var stsname="";
                if(slug == 'user'){
                    stsname = "is_delete_user";
                }else{
                    stsname = "is_delete_admin";
                }

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
                            data:{ tablename:"tbl_shift_trade", idname:"sfttrd_id", id:id, statusid:1,statusname: stsname},
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
                                            location.reload();
                                        }
                                    });
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
                });
            }


            function take_shift(offer_to,slug,shift_id,id){
                console.log(id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept now!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_take_shift.php',
                            method:'POST',
                            data:{ shift_offer_id:id, shift_id:shift_id, slug:slug, offer_to:offer_to},
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Shift Taken.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else if(response == "adminsuccess"){
                                    Swal.fire({
                                        title: 'Shift Accepted And Assigned.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else if(response == "unsuccess"){
                                    Swal.fire({
                                        type: 'warning',
                                        title: 'Oops...',
                                        text: 'Shift Already Completed!',
                                        footer: ''
                                    });
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
                });

            }


            function accept_shift(offer_to,slug,shift_id,id,shift_to,offer_by){
                console.log(id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept now!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_accept_shift.php',
                            method:'POST',
                            data:{shift_trade_id:id, shift_id:shift_id, slug:slug, offer_to:offer_to, shift_to:shift_to, offer_by:offer_by},
                            success:function(response){
                                console.log(response);
                                if(response == "success"){
                                    Swal.fire({
                                        title: 'Shift Taken.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else if(response == "adminsuccess"){
                                    Swal.fire({
                                        title: 'Shift Accepted And Assigned.',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    });
                                }else if(response == "unsuccess"){
                                    Swal.fire({
                                        type: 'warning',
                                        title: 'Oops...',
                                        text: 'Shift Already Completed!',
                                        footer: ''
                                    });
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
                });

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
                    data:{ slug:"shift_pool", rule_flag:pool_rule_check},
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