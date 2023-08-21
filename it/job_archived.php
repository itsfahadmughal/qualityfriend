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
        <title>Annunci - Archiviati</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/elegant-admin/" />
        <!-- Footable CSS -->
        <link href="../assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

        <link href="../dist/css/style.min.css" rel="stylesheet">

    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Annunci archiviati</p>
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
                            <h5 class="text-themecolor font-weight-title font-size-title mb-0">Annunci archiviati</h5>
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
                                    <li class="breadcrumb-item text-success">Annunci archiviati</li>
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
                                    <h4 class="card-title">Lista degli annunci attivi</h4>
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="shift_pool_tables table table-bordered m-t-30 table-hover contact-list" data-paging="true" data-paging-size="25">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Titolo</th>
                                                    <th>Posizione</th>
                                                    <th>Dipartimento</th>
                                                    <th>CV richiesto</th>
                                                    <th>Stato</th>
                                                    <th class="text-center">Modificare</th>
                                                    <th class="text-center">Anteprima</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sql="SELECT a.*,b.* FROM `tbl_create_job` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.saved_status = 'CREATE' AND a.is_active = 0 AND a.hotel_id = $hotel_id ORDER BY a.`crjb_id` DESC";
                                                $result = $conn->query($sql);
                                                if ($result && $result->num_rows > 0) {
                                                    $i=1;
                                                    while($row = mysqli_fetch_array($result)) { ?>

                                                <tr id="<?php echo $i; ?>">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php if($row['title_it'] != ""){echo $row['title_it'];}else if($row['title_de'] != ""){echo $row['title_de'];}else if($row['title'] != ""){echo $row['title'];} ?></td>
                                                    <td>
                                                        <?php echo $row['location']; ?>
                                                    </td>
                                                    <td><?php echo $row['department_name']; ?></td>
                                                    <td><?php if($row['is_cv_required']==1){echo 'Yes';}else{echo 'No';} ?></td>
                                                    <td><div class="btn-group">
                                                        <span id="status_row<?php echo $i; ?>" class="dropdown-toggle label label-danger pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Archiviato
                                                        </span>
                                                        <div class="dropdown-menu animated flipInY">
                                                            <a class="dropdown-item" href="javascript:void()" onclick="updatestatus(<?php echo $row['crjb_id']; ?>,<?php echo $i; ?>)">Non archiviato</a>
                                                        </div>
                                                        </div></td>
                                                    <td class="font-size-subheading text-center"><a href="edit_job.php?crjb_id=<?php echo $row['crjb_id']; ?>"><i class="far fa-edit"></i></a></td>
                                                    <td class="font-size-subheading text-center"><a target="_blank" href="<?php echo $baseurl.$row['generated_link']; ?>"><i class="ti-eye">
                                                        </i></a></td>
                                                </tr>

                                                <?php $i++; } } ?>

                                            </tbody>
                                        </table>
                                        <div id="snackbar">Qualche testo, qualche messaggio..</div>
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
                    data:{ tablename:"tbl_create_job", idname:"crjb_id", id:job_id, statusid:1,statusname: "is_active"},
                    success:function(response){
                        if(response == "Updated"){

                            document.getElementById("status_row"+n).innerHTML = "UnArchived";
                            document.getElementById("status_row"+n).classList.remove("label-danger");
                            document.getElementById("status_row"+n).classList.add("label-success");

                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            x.innerHTML="La tua modifica è stata salvata con successo.";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                        }else if(response == "Not Updated"){
                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            x.innerHTML="La tua modifica non è stata salvata.";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        l
                    },
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

    </body>
</html>