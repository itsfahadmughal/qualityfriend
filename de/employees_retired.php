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
        <title>Augeschiedene Mitarbeiter</title>
        <!-- Footable CSS -->
        <link href="../assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
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
                <p class="loader__label">Augeschiedene Mitarbeiter</p>
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
                            <h5 class="text-themecolor font-weight-title font-size-title mb-0">Augeschiedene Mitarbeiter</h5>
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
                                    <li class="breadcrumb-item text-success">Augeschiedene Mitarbeiter</li>
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
                                    <h4 class="card-title">Liste Mistarbeiter</h4>

                                    <!-- Add Contact Popup Model -->

                                    <!--                                    Start-->
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="shift_pool_tables table table-bordered m-t-30 table-hover contact-list" data-paging="true" data-paging-size="25">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Telefon</th>
                                                    <th>Abteilung</th>
                                                    <th>STATUS <small class="text-muted">(Als Mitarbeiter)</small></th>
                                                    <th class="text-center">Aktionen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sql="SELECT * FROM `tbl_applicants_employee`  WHERE `status_id` = 7 and is_delete= 0 and  hotel_id = $hotel_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC";
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
                                                                $status =   $row5['status_de'];
                                                            }
                                                        }
                                                ?>
                                                <tr class="">
                                                    <td><?php echo $i?></td>
                                                    <td>
                                                        <img onerror="this.src='../assets/images/users/user.png'"src="<?php echo '../'.$row['image_url'] ?>" alt="user" width="40" height="40" class="rounded-circle" /> <?php echo $row['name']." ".$row['surname'] ?>
                                                    </td>
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['phone'] ?></td>
                                                    <td><?php echo $deparment; ?></td>
                                                    <td><div class="btn-group">
                                                        <span id="thisstatus<?php echo $i; ?>" class="dropdown-toggle label
                                                                                                      <?php if($status_id == 7){ echo "label-danger";  }
                                                                                                      ?> pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <?php  echo $status; ?>

                                                        </span>

                                                        <div class="dropdown-menu animated flipInY">
                                                            <?php 
                                                        $sql2="SELECT * FROM `tbl_util_status` WHERE `status_id` = 4     ";
                                                        $result2 = $conn->query($sql2);
                                                        if ($result2 && $result2->num_rows > 0) {
                                                            while($row2 = mysqli_fetch_array($result2)) {
                                                            ?>
                                                            <a class="dropdown-item" onclick="updatestatus(<?php echo $row2['status_id']; ?>,<?php echo $applicant_id; ?>,<?php echo $i; ?>)" href="javascript:void(0)">
                                                                <?php
                                                                $mstatus = $row2['status'];
                                                                if($mstatus == "Accept"){
                                                                    $mstatus = "Zurücknehmen";
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
        <!--FooTable init-->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
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
        <script>

            function d(employee_id) {
                Swal.fire({
                    title: 'Bist du dir sicher?',
                    text: "Sie können dies nicht rückgängig machen!",
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
                                        title: 'Gelöscht',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.replace("employees_retired.php");
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
                })
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
                            x.innerHTML="Ihre Änderung wurde erfolgreich gespeichert.";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
                            document.getElementById("thisstatus"+i).classList.remove("label-success");
                            document.getElementById("thisstatus"+i).classList.remove("label-info");
                            document.getElementById("thisstatus"+i).classList.remove("label-danger");
                            if(status == 4){
                                var thisstatus = "Zurücknehmen";
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
        </script>
    </body>
</html>