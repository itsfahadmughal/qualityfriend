<?php
include 'util_config.php';
include '../util_session.php';
$title ="";
$description = "";
$tags = "";
$saved_status = "";
$category_name ="";
$subcat_name ="";
$category_id =0;
$subcat_id =0;
$dep_id_array = array();
$dep_array = array();
$hdb_id = 0;
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
        <title>Job-ad Tracking-Kampagne</title>
        <!-- page CSS -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/select2/../dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/switchery/../dist/switchery.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-tagsinput/../dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-touchspin/../dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/sweetalert2/../dist/sweetalert2.min.css" rel="stylesheet">
        <link href="../assets/node_modules/summernote/../dist/summernote.css" rel="stylesheet" />


        <link rel="stylesheet" href="../assets/node_modules/dropify/../dist/css/dropify.min.css">
        <!-- Dropzone css -->
        <link href="../assets/node_modules/dropzone-master/../dist/dropzone.css" rel="stylesheet" type="text/css" />
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">


        <style>
            .btn-delete{
                display: none ;

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
                <p class="loader__label">Tracking-Kampagne</p>
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
                <div class="container-fluid mobile-container-pl-75 ">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles heading_style">
                        <div class="col-md-5 align-self-center">
                            <h5 class="text-themecolor font-weight-title font-size-title mb-0">Job-ad Tracking-Kampagne</h5>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Recruiting</a></li>
                                    <li class="breadcrumb-item text-success">Job-ad Tracking-Kampagne</li>
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
                    <!-- Row -->
                    <div class="row">




                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" role="tabpanel">
                                    <div class="row pt-4 small-screen-mr-16">
                                        <div class="col-lg-12 col-xlg-12 col-md-12 ">
                                            <div class="row ">
                                                <div class="col-lg-7 col-xlg-7 col-md-7 ">
                                                    <div class="div-background  mt-4 p-4">
                                                        <h4 class="font-weight-title"> URL</h4>
                                                        <input  type="text" id="url" class="form-control" placeholder="" required>
                                                        <h4 class="font-weight-title mt-3"> Kampagne Source</h4>
                                                        <input  type="text" id="source" class="form-control" placeholder="Kampagne Source" required>
                                                        <h4 class="font-weight-title mt-3"> Kampagne Name</h4>
                                                        <input  type="text" id="name" class="form-control" placeholder="Kampagne Name" required>
                                                        <h4 class="font-weight-title mt-3"> Kampagne Team</h4>
                                                        <input  type="text" id="team" class="form-control" placeholder="Kampagne Team" required>


                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mbm-20">
                                            <div class="col-lg-12 col-xlg-12 col-md-12 pt-4"> 
                                                <input type="button" id="" onclick="save_campaign();" class="btn mt-4 btn-secondary" value="Kampagne erstellen">

                                            </div>
                                        </div>


                                    </div>

                                </div>



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
            <script src="../assets/node_modules/sticky-kit-master/ist/sticky-kit.min.js"></script>
            <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
            <!--Custom JavaScript -->
            <script src="../dist/js/custom.min.js"></script>
            <!-- This page plugins -->
            <!-- ============================================================== -->
            <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script>
            <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
            <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
            <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
            <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
            <script src="../assets/node_modules/summernote/dist/summernote.min.js"></script>

            <script src="../assets/node_modules/dropify/dist/js/dropify.min.js"></script>
            <!-- Sweet-Alert  -->
            <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
            <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
            <script src="../assets/node_modules/dropzone-master/dist/dropzone.js"></script>
            <script>
                function save_campaign(){


                    let url=document.getElementById("url").value;
                    let source=document.getElementById("source").value;
                    let name=document.getElementById("name").value;
                    let team=document.getElementById("team").value;
                    if(url.trim() != "" && source.trim() && name.trim() && team.trim()){
                        $.ajax({
                            url:'utill_save_campaign.php',
                            method:'POST',
                            data:{ url:url,source:source,name:name,team:team},
                            success:function(response){
                                console.log(response);
                                  window.location.href = "campaign.php";

                            },
                            error: function(xhr, status, error) {
                                console.log(error);

                            },
                        });

                    } else{
                        Swal.fire({
                            title: 'Alle Felder sind erforderlich',
                            type: 'basic',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                }       

            </script>
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
            <script>
                jQuery(document).ready(function() {

                    $('.summernote').summernote({
                        height: 350, // set editor height
                        minHeight: null, // set minimum height of editor
                        maxHeight: null, // set maximum height of editor
                        focus: false // set focus to editable area after initializing summernote
                    });

                    $('.inline-editor').summernote({
                        airMode: true
                    });

                });

                window.edit = function() {
                    $(".click2edit").summernote()
                },
                    window.save = function() {
                    $(".click2edit").summernote('destroy');
                }
            </script>
            </body>

        </html>