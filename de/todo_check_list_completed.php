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
        <title>Todo/Checklist Abgeschlossen</title>
        <!-- This page CSS -->
        <!-- chartist CSS -->
        <link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">
        <!--Toaster Popup message CSS -->
        <link href="../assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
        <!--c3 plugins CSS -->
        <link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">

        <link href="../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="../assets/node_modules/tablesaw/dist/tablesaw.css" rel="stylesheet">

        <style>
            .hided-div{
                display: none;

            }
            .visible-div{
                display:block;
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
                <p class="loader__label">Todo/Checklist Abgeschlossen</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Todo/Checklist Abgeschlossen</h4>
                        </div>
                        <div class="col-md-6 align-self-center text-right mtm-10">

                            <div class="input-group">
                                <input type="text" id="searchInput" placeholder="Search By" class="form-control">
                                <div class="input-group-append"><span class="input-group-text"><i class="ti-search"></i></span></div>
                            </div>

                        </div>

                        <div class="col-md-3 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Todo/Checklisten</a></li>
                                    <li class="breadcrumb-item text-success">Todo/Checklist Abgeschlossen</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <div class="row pr-4 mobile-container-padding">
                        <?php  if($recruiting_flag  == 1){ ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('jobs.php');">
                                <img src="../dist/images/icon-recruitment.png" />
                                <h6 class="text-white pt-2">Recruiting</h6>
                            </div>
                        </div>
                        <?php }
                        if($handover_flag == 1){
                        ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('handover.php');">
                                <img src="../dist/images/icon-list.png" />
                                <h6 class="text-white pt-2">Übergaben</h6>
                            </div>
                        </div>
                        <?php }
                        if($handbook_flag == 1){
                        ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background-active text-center padding-top-8" onclick="redirect_url('handbook.php');">
                                <img src="../dist/images/icon-book.png" />
                                <h6 class="text-white pt-2">Handbuch</h6>
                            </div>
                        </div>
                        <?php }
                        if($checklist_flag == 1){
                        ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('todo_check_list.php');">
                                <img src="../dist/images/icon-checklist.png" />
                                <h6 class="text-white pt-2">Todo/Checklist</h6>
                            </div>
                        </div>
                        <?php }
                        if($notices_flag == 1){
                        ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background icon text-center padding-top-8" onclick="redirect_url('notices.php');">
                                <img src="../dist/images/icon-notification.png" />
                                <h6 class="text-white pt-2">Notizen</h6>
                            </div>
                        </div>
                        <?php }
                        if($repairs_flag  == 1){
                        ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('repairs.php');">
                                <img src="../dist/images/icon-repair.png" />
                                <h6 class="text-white pt-2">Reparaturen</h6>
                            </div>
                        </div>
                        <?php
                        }
                        if($housekeeping_flag == 1){
                            if($housekeeping_admin == 1 || $housekeeping == 1){ ?> 
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background icon text-center padding-top-8" onclick="redirect_url('housekeeping.php');">
                                <img src="../dist/images/housekeeping.png" />
                                <h6 class="text-white pt-2">Housekeeping</h6>
                            </div>
                        </div>
                        <?php } }
                        if($time_schedule_flag == 1){ ?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background icon text-center padding-top-8" onclick="redirect_url('my_schedules.php');">
                                <img src="../dist/images/time_schedule.png" />
                                <h6 class="text-white pt-2">Dienstplanung</h6>

                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="row">

                        <div class="col-12">



                            <?php 
                            if($Create_edit_todo_checklist  == 1 || $usert_id == 1){
                            ?>


                            <div class="col-lg-9 col-xlg-9 col-md-9 mt-3 mb-3"> 
                                <div class="custom-control custom-radio inline-div mr-3 b-cancle">
                                    <input  type="radio" value="Admin" id="admin_completed" name="select_one" checked class="custom-control-input btn-info" >
                                    <label class="custom-control-label" for="admin_completed">Admin Completed</label>
                                </div>
                                <div class="custom-control custom-radio inline-div mr-3 b-cancle">
                                    <input  type="radio" value="User" id="user_completed" name="select_one" class="custom-control-input btn-info" >
                                    <label class="custom-control-label" for="user_completed">User Completed</label>
                                </div>
                            </div>
                            <?php }?>

                        </div>

                        <div id="div_1" class="col-12 hided-div">
                            <?php 

                            ?>
                            <div class="card">
                                <div class="card-body pm-0 small-screen-pr-0 mobile-container-pl-60">
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class=" tablesaw table-bordered table-hover table no-wrap" data-tablesaw-mode="stack"
                                               data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap
                                               data-tablesaw-mode-switch>
                                            <thead class="text-center">
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border text-center"><b> Title</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                                        data-tablesaw-priority="3" class="border text-center"><b>Creator</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" class="border text-center"><b>Completed By</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border text-center"><b>Status</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5" class="border text-center"><b> Date</b></th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">


                                                <?php
                                                $sql="SELECT a.*,b.title,b.title_it,b.title_de,b.status_id,b.entrytime,b.hotel_id,b.entrybyid FROM `tbl_todolist_recipents` as a INNER JOIN tbl_todolist as b ON a.`tdl_id` =  b.tdl_id WHERE a.`is_completed` = 1 AND  b.hotel_id =  $hotel_id";

                                                $result = $conn->query($sql);
                                                if ($result && $result->num_rows > 0) {
                                                    while($row = mysqli_fetch_array($result)) {

                                                        $tdl_id =$row['tdl_id'];
                                                        $firstname =$row['entrybyid'];
                                                        $sql1="SELECT firstname FROM `tbl_user` WHERE `user_id` =  $firstname";
                                                        $result1 = $conn->query($sql1);
                                                        if ($result1 && $result1->num_rows > 0) {
                                                            while($row1 = mysqli_fetch_array($result1)) {
                                                                $firstname = $row1['firstname'];
                                                            }}

                                                        //completed user Id

                                                        $completed_user_id = $row['user_id'];
                                                        $completed_user_name = "";
                                                        $sql1="SELECT firstname FROM `tbl_user` WHERE `user_id` =  $completed_user_id";
                                                        $result1 = $conn->query($sql1);
                                                        if ($result1 && $result1->num_rows > 0) {
                                                            while($row11 = mysqli_fetch_array($result1)) {
                                                                $completed_user_name = $row11['firstname'];
                                                            }}

                                                        $status_id =$row['status_id'];
                                                        $status_id_org =$row['status_id'];
                                                        $sql1="SELECT * FROM `tbl_util_status` WHERE `status_id` =  $status_id";
                                                        $result1 = $conn->query($sql1);
                                                        if ($result1 && $result1->num_rows > 0) {
                                                            while($row1 = mysqli_fetch_array($result1)) {
                                                                $status_id = $row1['status'];
                                                            }}
                                                        $entrytime =$row['entrytime'];
                                                        $date_time =  explode(" ",$entrytime);
                                                        $date=  $date_time[0];
                                                        $time = $date_time[1];
                                                        $time = substr($time,0,5);
                                                        if($row['title'] != ""){
                                                            $title =$row['title'];
                                                        }
                                                        else    if($row['title_it'] != ""){
                                                            $title =$row['title_it']; 
                                                        }
                                                        else if($row['title_de'] != ""){
                                                            $title =$row['title_de'];
                                                        }
                                                        else{
                                                            $title = "";
                                                        }
                                                ?>
                                                <tr>
                                                    <td class="text-center"><b><?php echo $title; ?></b><br><div onclick="go(<?php echo $tdl_id; ?>)" class="label pl-4 pr-4 label-table btn-info cursor-pointer ">Todo/Checklist</div></td>
                                                    <td class="text-center"> <b><?php echo $firstname; ?></b></td>
                                                    <td class="text-center">

                                                        <div class="label p-2 m-1 label-table label-inverse"><?php
                                                        echo  $completed_user_name;   ?></div>
                                                    </td>
                                                    <td class="text-center"><div class="label p-2 label-table label-success"><?php
                                                        echo $status_id;?></div></td>

                                                    <td class="text-center"><b><?php echo date("d.m.Y", strtotime(substr($date,0,10))); ?></b><br><span class="label-light-gray"><?php echo $time ; ?></span></td>

                                                </tr>
                                                <?php

                                                    }
                                                }else{
                                                ?>

                                                <?php
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div id="div_2" class="col-12 visible-div">

                            <?php  
                            if($Create_edit_todo_checklist  == 1 || $usert_id == 1){
                                $sql="SELECT a.* FROM `tbl_todolist` AS a  WHERE a.`hotel_id` = $hotel_id AND (status_id = 8 OR status_id = 9) AND a.is_delete = 0 and a.saved_status = 'CREATE' ORDER BY a.`entrytime` DESC";
                            } else{
                                $sql="SELECT DISTINCT a.* FROM `tbl_todolist` as a LEFT OUTER JOIN tbl_todolist_recipents as b on a.tdl_id=b.tdl_id  WHERE  a.`hotel_id` = $hotel_id AND a.is_delete = 0 AND a.is_active=1 AND a.saved_status = 'CREATE' AND (a.`visibility_status` = 'PUBLIC' OR b.user_id = $user_id) ORDER BY a.`entrytime` DESC";
                            }
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                            ?>
                            <div class="card">
                                <div class="card-body pm-0 small-screen-pr-0 mobile-container-pl-60">
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class=" tablesaw table-bordered table-hover table no-wrap" data-tablesaw-mode="stack"
                                               data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap
                                               data-tablesaw-mode-switch>
                                            <thead class="text-center">
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border text-center"><b> Titel</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                                        data-tablesaw-priority="3" class="border text-center"><b>Autor</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" class="border text-center"><b> Beteiligt</b></th>

                                                    <?php if($Create_edit_todo_checklist  == 1 || $usert_id == 1){?>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border text-center"><b> Status</b></th>
                                                    <?php }?>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4" class="border text-center"><b>Aktion</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5" class="border text-center"><b>Datum</b></th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">


                                                <?php
                                while($row = mysqli_fetch_array($result)) {

                                    if($row['visibility_status'] == "PRIVATE"){
                                        if($usert_id == 1 || $user_id == $row['entrybyid']){

                                        }else{
                                            continue;    
                                        }
                                    }

                                    $tdl_id =$row['tdl_id'];
                                    $firstname =$row['entrybyid'];

                                    $sql1="SELECT firstname FROM `tbl_user` WHERE `user_id` =  $firstname";
                                    $result1 = $conn->query($sql1);
                                    if ($result1 && $result1->num_rows > 0) {
                                        while($row1 = mysqli_fetch_array($result1)) {
                                            $firstname = $row1['firstname'];
                                        }}
                                    $sql_sub1="select b.department_name from tbl_todo_departments as a INNER JOIN tbl_department as b on a.depart_id=b.depart_id where a.tdl_id = $row[0] Limit 1";
                                    $result_sub1 = $conn->query($sql_sub1);

                                    $status_id =$row['status_id'];
                                    $status_id_org =$row['status_id'];

                                    $sql1="SELECT * FROM `tbl_util_status` WHERE `status_id` =  $status_id";
                                    $result1 = $conn->query($sql1);
                                    if ($result1 && $result1->num_rows > 0) {
                                        while($row1 = mysqli_fetch_array($result1)) {
                                            $status_id = $row1['status_de'];
                                        }}
                                    $entrytime =$row['entrytime'];
                                    $date_time =  explode(" ",$entrytime);
                                    $date=  $date_time[0];
                                    $time = $date_time[1];
                                    $time = substr($time,0,5);
                                    if($row['title_de'] != ""){
                                        $title =$row['title_de'];
                                    }
                                    else    if($row['title'] != ""){
                                        $title =$row['title']; 
                                    }
                                    else if($row['title_it'] != ""){
                                        $title =$row['title_it'];
                                    }
                                    else{
                                        $title = "";
                                    }


                                    $is_completed = 0;
                                    $sql_ = "SELECT * FROM `tbl_todolist_recipents`  WHERE `user_id` = $user_id AND `tdl_id` = $tdl_id";
                                    $result_ = $conn->query($sql_);
                                    if ($result_ && $result_->num_rows > 0) {
                                        while($row_ = mysqli_fetch_array($result_)) {
                                            $is_completed = $row_['is_completed'];
                                        }
                                    }

                                    if($is_completed == 1 || $status_id_org == 8 || $status_id_org == 9 ){
                                                ?>
                                                <tr>
                                                    <td class="text-center"><b><?php echo $title; ?></b><br><div onclick="go(<?php echo $tdl_id; ?>)" class="label pl-4 pr-4 label-table btn-info cursor-pointer ">Aufgaben/Checkliste</div></td>
                                                    <td class="text-center"> <b><?php echo $firstname; ?></b></td>
                                                    <td class="text-center">

                                                        <?php if($result_sub1 && $result_sub1->num_rows > 0){
                                                    $row_sub1 = mysqli_fetch_array($result_sub1);
                                                        ?>

                                                        <div class="label p-2 m-1 label-table label-inverse"><?php echo $row_sub1['department_name']; ?></div>
                                                        <?php
                                                }
                                                        ?>

                                                        <?php 
                                        $sql1="SELECT b.* FROM `tbl_todolist_recipents` AS a INNER JOIN tbl_user as b ON a.`user_id` = b.user_id WHERE a.`tdl_id` = $tdl_id  LIMIT 3";
                                        $result1 = $conn->query($sql1);
                                        if ($result1 && $result1->num_rows > 0) {
                                            while($row1 = mysqli_fetch_array($result1)) {
                                                        ?>
                                                        <div class="label p-2 m-1 label-table label-inverse"><?php
                                                echo  $row1['firstname'];   ?></div>
                                                        <?php 
                                            }}
                                                        ?>
                                                    </td>
                                                    <td class="text-center"><div class="label p-2 label-table label-success"><?php
                                        echo $status_id;?></div></td>
                                                    <?php if($Create_edit_todo_checklist  == 1 || $usert_id == 1){?>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <span id="thisstatus" class="dropdown-toggle label label-table label-danger pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aktionen</span>

                                                            <div class="dropdown-menu animated flipInY">
                                                                <a class="dropdown-item" onclick="d(<?php echo $tdl_id; ?>)" href="javascript:void(0)">Löschen</a>
                                                                <a class="dropdown-item" onclick="duplicate(<?php echo $tdl_id; ?>)" href="javascript:void(0)">Duplizieren</a>
                                                                <a class="dropdown-item" href="todo_check_list_detail.php?id=<?php echo $row['tdl_id']; ?>">Preview</a>
                                                                <a class="dropdown-item" href="edittodo_check_list.php?id=<?php echo $row['tdl_id']; ?>">Bearbeiten</a>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php }?>
                                                    <td class="text-center"><b><?php echo date("d.m.Y", strtotime(substr($date,0,10))); ?></b><br><span class="label-light-gray"><?php echo $time ; ?></span></td>

                                                </tr>
                                                <?php
                                    }
                                }
                            }else{
                                                ?>
                                                <div class="col-lg-12 col-xlg-12 col-md-12 mt-5">
                                                    <h1 class="text-center pt-5 pb-5">
                                                        Kein Todo/Checkliste gefunden
                                                    </h1>
                                                </div>
                                                <?php
                            }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





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
        <!-- Bootstrap popper Core JavaScript -->
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
        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <!--morris JavaScript -->
        <script src="../assets/node_modules/raphael/raphael.min.js"></script>
        <script src="../assets/node_modules/morrisjs/morris.min.js"></script>
        <script src="../.assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
        <!--c3 JavaScript -->
        <script src="../assets/node_modules/d3/d3.min.js"></script>
        <script src="../assets/node_modules/c3-master/c3.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

        <script>
            var  div_1= document.getElementById("div_1");
            var  div_2 = document.getElementById("div_2");

            $('input[type=radio][name=select_one]').change(function() {
                if (this.value == 'User') {

                    div_1.classList.add("visible-div");
                    div_1.classList.remove("hided-div");
                    div_2.classList.add("hided-div");
                    div_2.classList.remove("visible-div");
                }
                else if (this.value == 'Admin') {
                    div_1.classList.add("hided-div");
                    div_1.classList.remove("visible-div");

                    div_2.classList.add("visible-div");
                    div_2.classList.remove("hided-div");

                }
            }); 

        </script>

        <script>
            function redirect_url(url){
                window.location.href = url;
            }
            function go(id){
                window.location.href = "todo_check_list_detail.php?id="+id+"&page=complate";
            }
            function duplicate(id){
                $.ajax({
                    url:'util_duplicate.php',
                    method:'POST',
                    data:{ id:id,name: "todo"},
                    success:function(response){
                        if(response == "1"){
                            location.replace("todo_check_list.php");
                        } else{
                            console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        l
                    },
                });
            }

            function d(id) {
                Swal.fire({
                    title: 'Bist du sicher?',
                    text: "Sie können dies nicht rückgängig machen!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, löschen!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'util_update_status.php',
                            method:'POST',
                            data:{ tablename:"tbl_todolist", idname:"tdl_id", id:id, statusid:1,statusname: "is_delete"},
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
                                            location.replace("todo_check_list_completed.php");
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
        </script>
        <script>
            $(document).ready(function(){
                $("#searchInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#demo-foo-addrow tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
        <!-- jQuery peity -->
        <script src="../assets/node_modules/tablesaw/dist/tablesaw.jquery.js"></script>
        <script src="../assets/node_modules/tablesaw/dist/tablesaw-init.js"></script>
    </body>

</html>