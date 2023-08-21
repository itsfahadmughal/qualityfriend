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
        <title>Handbook Drafts</title>
        <!-- Footable CSS -->
        <link href="./assets/n  ode_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="./assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="dist/css/style.min.css" rel="stylesheet">
    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Handbook Drafts</p>
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Handbook Drafts</h4>
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
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Handbook</a></li>
                                    <li class="breadcrumb-item text-success">Handbook Drafts</li>
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
                                    <h4 class="card-title inline-div mm-0">Handbook List</h4>
                                    <div class="table-responsive">
                                        <table style="display:inline-table;" id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list" data-paging="true" data-paging-size="25">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sql="SELECT a.* FROM `tbl_handbook` as a WHERE a.`hotel_id` = $hotel_id and a.is_delete = 0 and a.saved_status = 'DRAFT'";
                                                $result = $conn->query($sql);
                                                if ($result && $result->num_rows > 0) {
                                                    $i=1;
                                                    while($row = mysqli_fetch_array($result)) { 
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
                                                        if($row['description'] != ""){
                                                            $description = $row['description'];
                                                        }
                                                        else if($row['description_it'] != ""){
                                                            $description = $row['description_it'];
                                                        }
                                                        else if($row['description_de'] != ""){
                                                            $description = $row['description_de'];
                                                        } 
                                                        else {
                                                            $description = "";
                                                        }
                                                        $is_active_user_id = $row['is_active'];
                                                        $hdb_id =   $row['hdb_id'];
                                                        $is_active_user =   "";
                                                        $sql5="SELECT * FROM `tbl_util_status` WHERE `status_id` =$is_active_user_id";
                                                        $result5 = $conn->query($sql5);
                                                        if ($result5 && $result5->num_rows > 0) {
                                                            while($row5 = mysqli_fetch_array($result5)) {
                                                                $is_active_user =   $row5['status'];
                                                            }
                                                        }
                                                ?>
                                                <tr id="<?php echo $i; ?>">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $title; ?></td>
                                                    <td>
                                                        <?php echo $description; ?>
                                                    </td>
                                                    <td class="font-size-subheading text-center"><a href="edit_handbook.php?id=<?php echo $row['hdb_id']; ?>"><i class="fas fa-pencil-alt"></i></a></td>
                                                </tr>

                                                <?php $i++; } } ?>

                                            </tbody>
                                        </table>
                                        <div id="snackbar">Some text some message..</div>
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
            function updatestatus1(status,hdb_id,i) {
                $.ajax({
                    url:'util_update_status.php',
                    method:'POST',
                    data:{ tablename:"tbl_handbook", idname:"hdb_id", id:hdb_id, statusid:status,statusname: "is_active"},
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