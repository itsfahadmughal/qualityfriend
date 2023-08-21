<?php
include 'util_config.php';
include '../util_session.php';

$sql_alert="UPDATE `tbl_alert` SET `is_viewed`='1' WHERE `user_id` = $user_id AND `id_table_name` = 'tbl_create_job'";
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
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Stellenanzeigen - Aktiviert</title>
        <!-- Footable CSS -->
        <link href="../assets/n  ode_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <!-- page css -->
    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Aktive Stellenanzeigen</p>
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
                    <div class="mobile-container-padding">

                        <div class="row page-titles mb-3 heading_style">
                            <div class="col-md-3 align-self-center">
                                <h5 class="text-themecolor font-weight-title font-size-title mb-0">Aktive Stellenanzeigen</h5>
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
                                        <li class="breadcrumb-item text-success">Aktive Stellenanzeigen</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->

                    <div class="row pr-4 mobile-container-padding">
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background-active text-center padding-top-8" onclick="redirect_url('jobs.php');">
                                <img src="../dist/images/icon-recruitment.png" />
                                <h6 class="text-white pt-2">Recruiting</h6>
                            </div>
                        </div>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('handover.php');">
                                <img src="../dist/images/icon-list.png" />
                                <h6 class="text-white pt-2">Übergaben</h6>
                            </div>
                        </div>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('handbook.php');">
                                <img src="../dist/images/icon-book.png" />
                                <h6 class="text-white pt-2">Handbuch</h6>
                            </div>
                        </div>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('todo_check_list.php');">
                                <img src="../dist/images/icon-checklist.png" />
                                <h6 class="text-white pt-2">Todo/Checklist</h6>
                            </div>
                        </div>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background icon text-center padding-top-8" onclick="redirect_url('notices.php');">
                                <img src="../dist/images/icon-notification.png" />
                                <h6 class="text-white pt-2">Notizen</h6>
                            </div>
                        </div>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('repairs.php');">
                                <img src="../dist/images/icon-repair.png" />
                                <h6 class="text-white pt-2">Reparaturen</h6>
                            </div>
                        </div>



                        <?php if($housekeeping_admin == 1 || $housekeeping == 1){ ?> 
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background icon text-center padding-top-8" onclick="redirect_url('housekeeping.php');">
                                <img src="../dist/images/housekeeping.png" />
                                <h6 class="text-white pt-2">Housekeeping</h6>
                            </div>
                        </div>
                        <?php }?>
                        <div class="col-lg-12-custom pr-0">
                            <div  class="list-background icon text-center padding-top-8" onclick="redirect_url('#');">
                                <img src="../dist/images/time_schedule.png" />
                                <h6 class="text-white pt-2">Dienstplanung</h6>

                            </div>
                        </div>

                    </div>

                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pm-0 small-screen-pr-0 mobile-container-pl-60">
                                    <h4 class="card-title inline-div mtm-10 mbm-0">Liste Stellenanzeigen</h4>

                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="shift_pool_tables table table-bordered m-t-30 table-hover contact-list" data-paging="true">
                                            <thead>
                                                <tr>
                                                    <th>Nr.</th>
                                                    <th>Titel</th>
                                                    <th>Ort</th>
                                                    <th>Abteilung</th>
                                                    <th>CV erforderlich</th>
                                                    <?php if($Create_edit_job_ad == 1 || $usert_id == 1){ ?>  <th>Status</th>
                                                    <th class="text-center">Bearbeiten</th>
                                                    <?php } ?>
                                                    <th class="text-center">Vorschau</th>
                                                    <th class="text-center">Job-Link kopieren</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sql="SELECT a.*,b.* FROM `tbl_create_job` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.saved_status = 'CREATE' AND a.is_active = 1 AND a.hotel_id = $hotel_id ORDER BY a.`crjb_id` DESC";
                                                $result = $conn->query($sql);
                                                if ($result && $result->num_rows > 0) {
                                                    $i=1;
                                                    while($row = mysqli_fetch_array($result)) { 
                                                        $department_name = "";
                                                        $depart_id = $row['depart_id'];
                                                        if($depart_id == 0){
                                                            $department_name = "N/A";
                                                        }else{

                                                            $department_name = $row['department_name'];
                                                        }


                                                ?>

                                                <tr id="<?php echo $i; ?>">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php if($row['title_de'] != ""){echo $row['title_de'];}else if($row['title_it'] != ""){echo $row['title_it'];}else if($row['title'] != ""){echo $row['title'];} ?></td>
                                                    <td>
                                                        <?php if($row['location_de'] != ""){echo $row['location_de'];}else if($row['location_it'] != ""){echo $row['location_it'];}else if($row['location'] != ""){echo $row['location'];} ?>
                                                    </td>
                                                    <td><?php echo $department_name; ?></td>
                                                    <td><?php if($row['is_cv_required']==1){echo 'Ja';}else{echo 'Nein';} ?></td>
                                                    <?php if($Create_edit_job_ad == 1 || $usert_id == 1){ ?>
                                                    <td><div class="btn-group">
                                                        <span id="status_row<?php echo $i; ?>" class="dropdown-toggle label label-success pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Aktiv
                                                        </span>
                                                        <div class="dropdown-menu animated flipInY">
                                                            <a class="dropdown-item" href="javascript:void()" onclick="updatestatus(<?php echo $row['crjb_id']; ?>,<?php echo $i; ?>)">Archiviert</a>
                                                        </div>
                                                        </div></td>
                                                    <td class="font-size-subheading text-center"><a href="edit_job.php?crjb_id=<?php echo $row['crjb_id']; ?>"><i class="far fa-edit"></i></a></td>
                                                    <?php } ?>

                                                    <td class="font-size-subheading text-center"><a target="_blank" href="<?php echo $baseurl.$row['generated_link']; ?>"><i class="ti-eye">
                                                        </i></a></td>
                                                    <td class="font-size-subheading text-center"><a onclick="copy('<?php echo $row['generated_link']; ?>')" href="javascript:void()"><i class="far fa-copy">
                                                        </i></a></td>
                                                </tr>

                                                <?php $i++; } } ?>

                                            </tbody>
                                        </table>
                                        <div id="snackbar">Irgendeine SMS, eine Nachricht..</div>
                                    </div>
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


        <script>

            function updatestatus(job_id,n){
                $.ajax({
                    url:'util_update_status.php',
                    method:'POST',
                    data:{ tablename:"tbl_create_job", idname:"crjb_id", id:job_id, statusid:0,statusname: "is_active"},
                    success:function(response){
                        if(response == "Updated"){

                            document.getElementById("status_row"+n).innerHTML = "Archived";
                            document.getElementById("status_row"+n).classList.remove("label-success");
                            document.getElementById("status_row"+n).classList.add("label-danger");

                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            x.innerHTML="Ihre Änderung wurde erfolgreich gespeichert.";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                        }else if(response == "Not Updated"){
                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            x.innerHTML="Ihre Änderung nicht gespeichert.";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        l
                    },
                });
            }

            function copy(text){
                var copyText = text;
                var baseurl="<?php echo $baseurl; ?>";

                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(baseurl+copyText).select();
                document.execCommand("copy");
                $temp.remove();
                /* Copy the text inside the text field */
                //                navigator.clipboard.writeText(baseurl+copyText);
                var x = document.getElementById("snackbar");
                x.className = "show";
                x.innerHTML="Link kopiert!";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
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

            function redirect_url(url){
                window.location.href = url;
            }
        </script>
    </body>
</html>