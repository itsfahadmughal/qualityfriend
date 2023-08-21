
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
        <title>Lavori extra compiuti</title>
        <!-- Footable CSS -->
        <link href="../assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">

        <link href="../assets/node_modules/tablesaw/dist/tablesaw.css" rel="stylesheet">

    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Lavori extra compiuti</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">
                                Lavori extra compiuti</h4>
                        </div>
                        <div class="col-md-6 mtm-10">
                            <div class="input-group">
                                <input type="text" id="searchInput" placeholder="Search By" class="form-control">
                                <div class="input-group-append"><span class="input-group-text"><i class="ti-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-3 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Housekeeping</a></li>
                                    <li class="breadcrumb-item text-success">Lavori extra compiuti</li>
                                </ol>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <div class="row pl-3 pr-3">
                    <?php
                    if($housekeeping_admin == 1 || $usert_id == 1){
                        $sql="SELECT b.hkej_id,b.job_title,c.time,a.assign_date,a.complete_date,a.assign_to,a.is_completed FROM `tbl_ housekeeping_extra_jobs_completed_check` AS a INNER JOIN `tbl_ housekeeping_extra_jobs` as b ON a.`extra_job_id` = b.hkej_id INNER JOIN `tb_time_interval` as c ON b.time_to_complate = c.ti_id WHERE a.`is_completed` = 1 AND b.hotel_id = $hotel_id ORDER BY a.`complete_date`";
                    } else{
                        $sql="SELECT b.hkej_id,b.job_title,c.time,a.assign_date,a.complete_date,a.assign_to,a.is_completed FROM `tbl_ housekeeping_extra_jobs_completed_check` AS a INNER JOIN `tbl_ housekeeping_extra_jobs` as b ON a.`extra_job_id` = b.hkej_id INNER JOIN `tb_time_interval` as c ON b.time_to_complate = c.ti_id WHERE a.`is_completed` = 1 AND a.`assign_to` = $user_id And b.hotel_id = $hotel_id ORDER BY a.`complete_date`";
                    }

                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                    ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pm-0 small-screen-pr-0 mobile-container-pl-60">
                                <div class="table-responsive">
                                    <table id="myTable" class=" tablesaw table-bordered table-hover table no-wrap" data-tablesaw-mode="stack"
                                           data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap
                                           data-tablesaw-mode-switch>
                                        <thead>
                                            <tr>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border text-center"><b>Lavoro extra</b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                                    data-tablesaw-priority="3" class="border text-center"><b> Utente completato</b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" class="border text-center"><b>stato</b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border text-center"><b>Tempo </b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border text-center"><b>Assegna data</b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5" class="border text-center"><b>Data di completamento</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        while($row = mysqli_fetch_array($result)) {

                            $hkej_id =$row['hkej_id'];
                            $job_title =$row['job_title'];
                            $is_completed =$row['is_completed'];
                            $assgin_date =$row['assign_date'];
                            $complate_date =$row['complete_date'];
                            $time =$row['time'];
                            $user_id_this = $row['assign_to'];
                            $sql_sub="select firstname from tbl_user where user_id = $user_id_this";
                            $result_sub = $conn->query($sql_sub);
                            $row_sub = mysqli_fetch_array($result_sub);


                                            ?>
                                            <tr>    
                                                <td class="text-center"><b><?php echo $job_title; ?></b><br><div class="label pl-4 pr-4 label-table btn-info cursor-pointer" onclick="redirect_url('handover_detail.php?id=<?php echo $row[0]; ?>');">Housekeeping</div></td>

                                                <td class="text-center"><b><?php echo $row_sub['firstname']; ?></b></td>

                                                <td class="text-center"><div class="label p-2 label-table label-success">Job Completed</div></td>
                                                <td class="text-center">
                                                    <span><?php echo $time; ?></span>
                                                </td>

                                                <td class="text-center">
                                                    <span><?php echo $assgin_date; ?></span>
                                                </td>

                                                <td class="text-center"><span>  <?php echo $complate_date; ?> </span></td>
                                            </tr>
                                            <?php

                        }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }else{
                    ?>
                    <div class="col-lg-12 col-xlg-12 col-md-12 mt-5">
                        <h1 class="text-center pt-5 pb-5">Nesson lavoro extra trovatoo</h1>
                    </div>
                    <?php
                    }
                    ?>
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

        <script>


            function redirect_url(url) {
                window.location.href = url;
            }

            $(document).ready(function(){
                $("#searchInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tbody tr").filter(function() {
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