<?php
include 'util_config.php';
include '../util_session.php';

if(isset($_GET['id'])){
    $employee_id=$_GET['id'];
//    $sql="SELECT a.*,b.curr_id as  mcurr_id FROM tbl_treatment as a INNER JOIN tbl_hotel as b ON a.hotel_id=b.hotel_id WHERE a.`hotel_id` =  $hotel_id and a.isactive= 1 and a.wb_id = $s_item_id";
//    $result = $conn->query($sql);
//    if ($result && $result->num_rows > 0) {
//        while($row = mysqli_fetch_array($result)) {
//            $title=$row['title'];
//            $dis=$row['description']; 
//            $price =$row['price'];
//            $currency_id =$row['mcurr_id'];
//            $url_image = $row['image_url'];
//            $discount  = $row['discount'];
//            $duration  = $row['duration'];
//
//        }
//    }
//    //$image_urls = array_filter($image_urls, '');
//
//    //Curancy
//    $sql4="SELECT * FROM `tbl_currency` WHERE `curr_id` =  $currency_id";
//    $result4 = $conn->query($sql4);       
//    if ($result4 && $result4->num_rows > 0) {
//        while($row1 = mysqli_fetch_array($result4)) {
//            $symbol = $row1['symbol'];
//        }}
}
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
        <title>Working Time</title>
        <!-- page CSS -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="../assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Working Time</p>
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
                    <div class="row page-titles">
                        <div class="col-md-2 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Working Time</h4>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" placeholder="Search By" class="form-control">
                                <div class="input-group-append"><span class="input-group-text"><i class="ti-search"></i></span></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group">
                                <i id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" class="mdi mdi-dots-vertical pointer font-size-title"></i>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuReference" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="#">Save</a>
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
                    <!-- Row -->
                    <div class="row">
                        <div class="col-lg-1 col-xlg-1 col-md-1">

                           <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                <option value='0'>Month</option>
                                <?php 
                                $sql="SELECT * FROM tbl_months";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-1 col-xlg-1 col-md-1">
                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                <option value='0'>Week</option>
                                <?php 
                                $sql="SELECT * FROM tbl_weeks";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-8 col-xlg-8 col-md-8 text-center">
                            <h3>Working Time Schedule</h3>
                        </div>
                        <div class="col-lg-2 col-xlg-2 col-md-2">
                            <input type="submit" href="#" value="save" class="btn btn-secondary w-20">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-lg-2 col-xlg-2 col-md-2">
                        </div>
                        <div class="col-lg-8 col-xlg-8 col-md-8">
                            <div class="table-responsive">
                                <table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sunday</td>
                                            <td>12:30</td>
                                            <td>22:50</td>

                                        </tr>
                                        <tr>
                                            <td>Monday</td>
                                            <td>12:30</td>
                                            <td>13:30</td>

                                        </tr>
                                        <tr>
                                            <td>Tuesday</td>
                                            <td>12:30</td>
                                            <td>1:30</td>

                                        </tr>
                                        <tr>
                                            <td>Wednesday</td>
                                            <td>5:30</td>
                                            <td>2:30</td>

                                        </tr>
                                        <tr>
                                            <td>Thursday</td>
                                            <td>2:30</td>
                                            <td>12:30</td>

                                        </tr>
                                        <tr>
                                            <td>Friday</td>
                                            <td>dubble tap to add time</td>
                                            <td>dubble tap to add time</td>
                                        </tr>
                                        <tr>
                                            <td>saturday</td>
                                            <td>dubble tap to add time</td>
                                            <td>dubble tap to add time</td>

                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <div class="col-lg-2 col-xlg-2 col-md-2">
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
        <!--stickey kit -->
        <script src="../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="../dist/js/custom.min.js"></script>
        <!-- ============================================================== -->



        <!-- Editable -->
        <script src="../assets/node_modules/jquery-datatables-editable/jquery.dataTables.js"></script>
        <script src="../assets/node_modules/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="../assets/node_modules/tiny-editable/mindmup-editabletable.js"></script>
        <script src="../assets/node_modules/tiny-editable/numeric-input-example.js"></script>
        <script>
            $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
            $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
            $(function() {
                $('#editable-datatable').DataTable();
            });
        </script>


        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script>
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
        <script type="text/javascript" src="../assets/node_modules/multiselect/js/jquery.multi-select.js"></script>
        <script>
            jQuery(document).ready(function() {
                // Switchery
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                $('.js-switch').each(function() {
                    new Switchery($(this)[0], $(this).data());
                });
                // For select 2
                $(".select2").select2();
                $('.selectpicker').selectpicker();
                //Bootstrap-TouchSpin
                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }
                $("input[name='tch1']").TouchSpin({
                    min: 0,
                    max: 100,
                    step: 0.1,
                    decimals: 2,
                    boostat: 5,
                    maxboostedstep: 10,
                    postfix: '%'
                });
                $("input[name='tch2']").TouchSpin({
                    min: -1000000000,
                    max: 1000000000,
                    stepinterval: 50,
                    maxboostedstep: 10000000,
                    prefix: '$'
                });
                $("input[name='tch3']").TouchSpin();
                $("input[name='tch3_22']").TouchSpin({
                    initval: 40
                });
                $("input[name='tch5']").TouchSpin({
                    prefix: "pre",
                    postfix: "post"
                });
                // For multiselect
                $('#pre-selected-options').multiSelect();
                $('#optgroup').multiSelect({
                    selectableOptgroup: true
                });
                $('#public-methods').multiSelect();
                $('#select-all').click(function() {
                    $('#public-methods').multiSelect('select_all');
                    return false;
                });
                $('#deselect-all').click(function() {
                    $('#public-methods').multiSelect('deselect_all');
                    return false;
                });
                $('#refresh').on('click', function() {
                    $('#public-methods').multiSelect('refresh');
                    return false;
                });
                $('#add-option').on('click', function() {
                    $('#public-methods').multiSelect('addOption', {
                        value: 42,
                        text: 'test 42',
                        index: 0
                    });
                    return false;
                });
                $(".ajax").select2({
                    ajax: {
                        url: "https://api.github.com/search/repositories",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function(data, params) {
                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;
                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1,
                    // templateResult: formatRepo, // omitted for brevity, see the source of this page
                    //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
                });
            });
        </script>
    </body>

</html>