<?php
include 'util_config.php';
include '../util_session.php';

$crjb_id="";

if(isset($_GET['crjb_id'])){
    $crjb_id=$_GET['crjb_id'];
}


$title="";
$title_it="";
$title_de="";
$description="";
$description_it="";
$description_de="";
$image_link="";
$depart_id="";
$logo_link = "";
$creation_date="";
$cv_required="";
$whatsapp_required="";
$wp_num="";
$location="";
$location_it="";
$location_de="";
$is_active="";
$auto_msg = "";
$job_funnel = 0;
$sql="SELECT * FROM `tbl_create_job` where crjb_id = $crjb_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $i=1;
    while($row = mysqli_fetch_array($result)) {
        $job_funnel = $row['job_funnel'];
        $title=$row['title'];
        $title_it=$row['title_it'];
        $title_de=$row['title_de'];
        $description=$row['description'];
        $description_it=$row['description_it'];
        $description_de=$row['description_de'];
        $image_link=$row['job_image'];
        $logo_link=$row['logo_image'];
        $depart_id=$row['depart_id'];
        $is_funnel=$row['is_funnel'];
        $auto_msg =$row['auto_msg'];

        $creation_date=$row['creation_date'];
        $cv_required=$row['is_cv_required'];
        $whatsapp_required=$row['whatsapp_isactive'];
        $wp_num=$row['whatsapp'];
        $location=$row['location'];
        $location_it=$row['location_it'];
        $location_de=$row['location_de'];
        $is_active=$row['is_active'];
    } 
}


$userbenifits_array = array();
$sql1="SELECT * FROM `tbl_job_benefits` WHERE `job_id` =    $crjb_id";
$result1 = $conn->query($sql1);
if ($result1 && $result1->num_rows > 0) {
    while($row2 = mysqli_fetch_array($result1)) {
        array_push($userbenifits_array,$row2['text']);

    }
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
        <title>Modifica annuncio di lavoro</title>
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/node_modules/dropify/dist/css/dropify.min.css">
        <link href="../assets/node_modules/summernote/dist/summernote.css" rel="stylesheet" />
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

        <link
              rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
              />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Modifica annuncio di lavoro</p>
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
                <div class="container-fluid mobile-container-pl-75">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!--                    <div class="row page-titles pb-0">-->
                    <!--
<div class="col-md-3 align-self-center">
<h4 class="text-themecolor font-weight-title font-size-title">Modifica annuncio di lavoro</h4>
</div>
-->
                    <!--                    </div>-->



                    <div class="row page-titles mb-3 heading_style">
                        <div class="col-md-5 align-self-center">
                            <h5 class="text-themecolor font-weight-title font-size-title mb-0">Modifica annuncio di lavoro</h5>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Recruiting</a></li>
                                    <li class="breadcrumb-item text-success">Modifica annuncio di lavoro</li>
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

                    <div id="whatsapp_popup" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel"><i class="fas fa-phone"></i> Crea numero Whatsapp</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <from class="form-horizontal" onsubmit="event.preventDefault();">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="col-md-12 m-b-20">
                                                    <h4 class="font-weight-title">Inserisci il tuo numero whatsapp:</h4>
                                                    <input id="wp_num_id" type="tel" name="phone" placeholder="123" value="<?php echo $wp_num; ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </from>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info waves-effect"  data-dismiss="modal">Salva</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- Row -->
                    <div class="row">
                        <div id="add-deepl" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog custom_modal_dialog">
                                <div id="live_tranlator" class="modal-content">

                                    <div id="loading1"  class="d-flex justify-content-center mcenter">
                                        <div class="spinner-border text-info" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Traduttore dal vivo</h5>

                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <from id ="reset1">
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <h5 class="pt-1"><b>Inserisci il tuo testo</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <select onchange="deepl_call()" id="deepl_language_id" class=" form-control custom-select">
                                                        <option value="DE">German</option>
                                                        <option value="IT">Italian</option>
                                                        <option value="en-US">English(American)</option>
                                                        <option value="EN-GB">English(British)</option>
                                                        <option value="BG">Bulgarian</option>
                                                        <option value="CS">Czech</option>
                                                        <option value="DA">Danish</option>
                                                        <option value="EL">Greek</option>
                                                        <option value="ES">Spanish</option>
                                                        <option value="ET">Estonian</option>
                                                        <option value="FI">Finnish</option>
                                                        <option value="FR">French</option>
                                                        <option value="HU">Hungarian</option>
                                                        <option value="ID">Indonesian</option>
                                                        <option value="JA">Japanese</option>
                                                        <option value="LT">Lithuanian</option>
                                                        <option value="LV">Latvian</option>
                                                        <option value="NL">Dutch</option>
                                                        <option value="PL">Polish</option>
                                                        <option value="PT-BR">Portuguese (Brazilian)</option>
                                                        <option value="PT-PT">Portuguese (all Portuguese varieties excluding Brazilian Portuguese)</option>
                                                        <option value="RO">Romanian</option>
                                                        <option value="RU">Russian</option>
                                                        <option value="SK">Slovak</option>
                                                        <option value="SL">Slovenian</option>
                                                        <option value="SV">Swedish</option>
                                                        <option value="RU">Russian</option>
                                                        <option value="TR">Turkish</option>
                                                        <option value="UK">Ukrainian</option>
                                                        <option value="ZH">Chinese</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row pt-2">
                                                <div class="col-md-6">
                                                    <textarea onkeyup="deepl_call()"  type="text" rows="13" name="input_deepl" id="input_deepl" class="form-control" placeholder="Scrivi il tuo testo..." ></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea  type="text" rows="13" name="output_deepl" id="output_deepl" class="form-control" placeholder="Produzione" ></textarea>
                                                </div>
                                            </div>

                                        </from>

                                    </div>
                                    <div class="modal-footer">

                                        <button onclick="cleared()" type="button" class="btn btn-info ">Chiara</button>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div>
                                <!-- Nav tabs -->
                                <ul class=" nav nav-tabs profile-tab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#english" role="tab">English</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#italian" role="tab">Italian</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#german" role="tab">German </a> </li>
                                </ul>
                                <form id="create_job_form" action="dashboard.php">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="english" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-9 col-xlg-9 col-md-9 pt-4"> 
                                                    <h4 class="font-weight-title">Titolo dell annuncio</h4>
                                                    <input id="title_id" type="text" value="<?php echo $title; ?>" class="form-control" placeholder="Titolo">
                                                    <div class="row pt-4">
                                                        <div class="col-lg-6 col-xlg-6 col-md-6">
                                                            <h4 class="font-weight-title">Seleziona Dipartimento*</h4>
                                                            <select id="department_id" class="select2 form-control custom-select">
                                                                <option>Selezionare</option>
                                                                <?php 
                                                                $sql="SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                                                                $result = $conn->query($sql);
                                                                if ($result && $result->num_rows > 0) {
                                                                    while($row = mysqli_fetch_array($result)) {
                                                                        if($row[0]==$depart_id){
                                                                ?>
                                                                <option value='<?php echo $row[0]; ?>' selected><?php echo $row[1]; ?></option>
                                                                <?php
                                                                        }else{
                                                                ?>
                                                                <option value='<?php echo $row[0]; ?>'><?php echo $row[1]; ?></option>
                                                                <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 col-xlg-6 col-md-6">
                                                            <h4 class="font-weight-title">Creation Date</h4>
                                                            <div class="input-group">
                                                                <input id="creation_date_id" type="text" value="<?php echo $creation_date; ?>" style="border:1px solid #00BCEB" id="date-format" class="form-control" placeholder="Saturday 24 June 2017">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" style="background-color:#00BCEB;border:1px solid #00BCEB" ><i class="icon-calender" style="background-color:white"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>




                                                    <div class="row pt-4 ">
                                                        <div class="col-lg-10 col-xlg-10 col-md-10">
                                                            <h4 class="font-weight-title ">Descrizione dettagliata</h4>
                                                        </div> 
                                                        <div  class="col-lg-1 col-xlg-1 col-md-1 deel_font ">
                                                            <a  data-toggle="modal"  data-target="#add-deepl" data-dismiss="modal" href="JavaScript:void(0)" class=""> <i class="fas fa-object-ungroup   pointer index_z "></i></a>


                                                        </div> 
                                                        <div  class="col-lg-1 col-xlg-1 col-md-1 deel_font ">
                                                            <a id="searchBtn"  href="JavaScript:void(0)" class=""> <i class=" fas fa-search   pointer  "></i></a>


                                                        </div> 




                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <div id="description_id" class="summernote">
                                                                <?php echo $description; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row heading_style pt-4 pb-4">
                                                        <div class="col-lg-12 col-xlg-12 col-md-12 ">
                                                            <h4 >Unsere Benefits</h4>
                                                        </div>

                                                        <div class="col-lg-10 col-xlg-10 col-md-10 mt-2">
                                                            <input type="text" class="form-control" id="ussr_benifits" placeholder="Enter">  
                                                        </div>





                                                        <div class ="col-lg-2 col-xlg-2 col-md-2 font-size-title"style="text-align: center; display: flex; justify-content: center;align-items: center;" >
                                                            <a onclick="add_userbenifits()" href="javascript:void(0)"><i class="mdi mdi-plus-circle"></i></a>
                                                        </div>


                                                        <div id="usesbenifitslist" class="col-lg-12 col-xlg-12 col-md-12 mt-2"></div>
                                                    </div>

                                                    <h4 class="font-weight-title pt-4">Aggiungi dove si trova il posto</h4>
                                                    <input id="location_id" type="text" value="<?php echo $location; ?>" class="form-control" placeholder="Location">


                                                    <h4 class="font-weight-title ">Auto message candidati</h4>
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <div id="message" class="summernote">
                                                                <?php echo $auto_msg; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-3 col-xlg-3 col-md-3 pt-4"> 
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title">Aggiungi foto per annuncio di lavoro</h4>
                                                            <input id="job_pic_id" type="file" data-default-file="../<?php echo $image_link; ?>" accept="image/png, image/jpeg" id="input-file-max-fs" data-show-remove="false" class="dropify" data-max-file-size="2M" />
                                                        </div>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title">Logo <small></small></h4>
                                                            <input type="file" id ="job_logo_id" name="job_logo_id" data-default-file="<?php echo '../'.$logo_link; ?>" accept="image/png, image/jpeg" id="input-file-max-fs" data-show-remove="false" class="dropify" data-max-file-size="2M"  />
                                                        </div>
                                                    </div>

                                                    <div class="checkbox checkbox-success pl-4">
                                                        <input id="cv_required_id" <?php if($cv_required==1){echo "checked";} ?> type="checkbox" class="checkbox-size-20">
                                                        <label for="checkbox35" class="font-weight-title font-22 pl-1">CV richiesto</label>
                                                    </div>

                                                    <div class="checkbox checkbox-success pl-4">
                                                        <input id="whatsapp_required_id" <?php if($whatsapp_required==1){echo "checked";} ?> type="checkbox" class="checkbox-size-20" onclick="whatsapp_modal();">
                                                        <label for="checkbox35" style="display:inline;" class="font-weight-title font-22 pl-1"><small>(se desideri ricevere direttamente le domande sul tuo Account Whatsapp)</small></label>
                                                    </div>

                                                    <div class="checkbox checkbox-success pl-4">
                                                        <input <?php if($is_funnel==1){echo "checked";} ?> id="is_funnel" type="checkbox" class="checkbox-size-20">
                                                        <label for="checkbox35" class="font-weight-title font-22 pl-1">Add Funnel</label>
                                                    </div>


                                                    <select id="jobs_funnel" class="select2 form-control custom-select">
                                                        <option value="0">Select Any Funnel</option>
                                                        <?php 
                                                        $sql="SELECT * FROM `tbl_funnel_info` WHERE `hotel_id` = $hotel_id";
                                                        $result = $conn->query($sql);
                                                        if ($result && $result->num_rows > 0) {
                                                            while($row = mysqli_fetch_array($result)) {
                                                                if($row[0]==$job_funnel){
                                                        ?>
                                                        <option value='<?php echo $row[0]; ?>' selected><?php echo $row['name']; ?></option>
                                                        <?php
                                                                }else{
                                                        ?>
                                                        <option value='<?php echo $row[0]; ?>'><?php echo $row['name']; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>



                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="italian" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-9 col-xlg-9 col-md-9 pt-4"> 
                                                    <h4 class="font-weight-title">Titolo dell annuncio</h4>
                                                    <input id="title_it_id" type="text" value="<?php echo $title_it; ?>" class="form-control" placeholder="Titolo">



                                                    <div class="row pt-4 ">
                                                        <div class="col-lg-10 col-xlg-10 col-md-10">
                                                            <h4 class="font-weight-title ">Descrizione del lavoro</h4>
                                                        </div> 
                                                        <div  class="col-lg-1 col-xlg-1 col-md-1 deel_font ">
                                                            <a  data-toggle="modal"  data-target="#add-deepl" data-dismiss="modal" href="JavaScript:void(0)" class=""> <i class="fas fa-object-ungroup   pointer index_z "></i></a>


                                                        </div> 
                                                        <div  class="col-lg-1 col-xlg-1 col-md-1 deel_font ">
                                                            <a id="searchBtn2"  href="JavaScript:void(0)" class=""> <i class=" fas fa-search   pointer  "></i></a>


                                                        </div> 




                                                    </div>
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <div id="description_it_id" class="summernote">
                                                                <?php echo $description_it; ?>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <h4 class="font-weight-title pt-4">Aggiungi dove si trova il posto</h4>
                                                    <input id="location_it_id" type="text" value="<?php echo $location_it; ?>" class="form-control" placeholder="Posizione">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="german" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-9 col-xlg-9 col-md-9 pt-4"> 
                                                    <h4 class="font-weight-title">Titolo dell annuncio</h4>
                                                    <input id="title_de_id" type="text" value="<?php echo $title_de; ?>" class="form-control" placeholder="Titolo">


                                                    <div class="row pt-4 ">
                                                        <div class="col-lg-10 col-xlg-10 col-md-10">
                                                            <h4 class="font-weight-title ">Descrizione del lavoro</h4>
                                                        </div> 
                                                        <div  class="col-lg-1 col-xlg-1 col-md-1 deel_font ">
                                                            <a  data-toggle="modal"  data-target="#add-deepl" data-dismiss="modal" href="JavaScript:void(0)" class=""> <i class="fas fa-object-ungroup   pointer index_z "></i></a>


                                                        </div> 
                                                        <div  class="col-lg-1 col-xlg-1 col-md-1 deel_font ">
                                                            <a id="searchBtn3"  href="JavaScript:void(0)" class=""> <i class=" fas fa-search   pointer  "></i></a>


                                                        </div> 




                                                    </div>
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <div id="description_de_id" class="summernote">
                                                                <?php echo $description_de; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h4 class="font-weight-title pt-4">Aggiungi dove si trova il posto</h4>
                                                    <input id="location_de_id" type="text" value="<?php echo $location_de; ?>" class="form-control" placeholder="Posizione">

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-xlg-12 col-md-12 pt-4"> 
                                            <input type="button" onclick="save_job('DRAFT');" class="btn mt-4 w-20 btn-secondary" value="Salva come bozza">
                                            <input type="submit" onclick="save_job('CREATE');" class="btn mt-4 ml-3 w-20 btn-info" value="Salvare le modifiche">
                                        </div>
                                    </div>

                                </form>

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
        <script src="../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="../dist/js/custom.min.js"></script>

        <script src="../assets/node_modules/dropify/dist/js/dropify.min.js"></script>
        <script src="../assets/node_modules/summernote/dist/summernote.min.js"></script>
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

        <script src="../assets/node_modules/moment/moment.js"></script>
        <script src="../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

        <script type="text/javascript">
            const searchBtn = document.getElementById("searchBtn");

            searchBtn.addEventListener("click", function () {
                const search = prompt("Search");
                const searchResult = window.find(search);
            });
        </script>


        <script type="text/javascript">
            const searchBtn2 = document.getElementById("searchBtn2");

            searchBtn2.addEventListener("click", function () {
                const search2 = prompt("Search");
                const searchResult2 = window.find(search2);
            });
        </script>


        <script>

            var userbenifits_array = [];

            userbenifits_array = <?php echo json_encode($userbenifits_array); ?>;

            load_userbenifits(userbenifits_array);
            //        for    add_userbenifits
            function add_userbenifits() {
                let ussr_benifits = document.getElementById("ussr_benifits").value;
                userbenifits_array.push(ussr_benifits);
                load_userbenifits(userbenifits_array);
            }
            function load_userbenifits(load_array) {
                $.ajax({
                    url:"utill_reload_user_benifit.php",
                    method:'POST',
                    data:{ user_benifits_array:load_array},
                    success:function(response){
                        console.log(response);
                        let bring_option = document.getElementById("ussr_benifits").value = '';
                        document.getElementById('usesbenifitslist').innerHTML = response;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }
            function update_user_benifits(newdep_list){


                var removed = userbenifits_array.splice(newdep_list,1);
                load_userbenifits(userbenifits_array);


            }
        </script>

        <script type="text/javascript">
            const searchBtn3 = document.getElementById("searchBtn3");

            searchBtn3.addEventListener("click", function () {
                const search3 = prompt("Search");
                const searchResult = window.find(search3);
            });
        </script>



        <script>
            function cleared() {
                $("#reset1").trigger('reset');
                document.getElementById("input_deepl").value = "";

                document.getElementById("output_deepl").value = "";


            }

            function deepl_call() {

                var  input_deepl =   document.getElementById("input_deepl").value;
                var  deepl_language =   document.getElementById("deepl_language_id").value;
                if(input_deepl.trim() != ""){

                    document.getElementById("loading1").style.visibility = "visible";

                    //                    document.getElementById("live_tranlator").classList.add("disabled");
                    $.ajax({
                        url:'utill_deepl_call.php',
                        method:'POST',
                        data:{input_deepl:input_deepl, deepl_language:deepl_language},
                        success:function(response){

                            document.getElementById("loading1").style.visibility = "hidden";

                            //                            document.getElementById("live_tranlator").classList.remove("disabled");
                            document.getElementById("output_deepl").value = response;
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            document.getElementById("loading1").style.visibility = "hidden";

                        },
                    });
                }
            }



        </script>


        <script>

            const phoneInputField = document.querySelector("#wp_num_id");
            const phoneInput = window.intlTelInput(phoneInputField, {
                utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            $('#create_job_form').submit(function () { return false; });

            function whatsapp_modal(){
                let whatsapp_required_=document.getElementById("whatsapp_required_id").checked;

                if(whatsapp_required_ == true){
                    $("#whatsapp_popup").modal();
                }
            }


            function save_job(create_as){

                let is_active_ = '<?php echo $is_active; ?>';
                let title_=document.getElementById("title_id").value;
                let title_it_=document.getElementById("title_it_id").value;
                let title_de_=document.getElementById("title_de_id").value;
                let department_=document.getElementById("department_id").value;
                let creation_date_=document.getElementById("creation_date_id").value;
                let description_=$('#description_id').summernote('code');
                let description_it_=$('#description_it_id').summernote('code');
                let description_de_=$('#description_de_id').summernote('code');
                let location_=document.getElementById("location_id").value;
                let location_it_=document.getElementById("location_it_id").value;
                let location_de_=document.getElementById("location_de_id").value;
                let cv_required_=document.getElementById("cv_required_id").checked;
                let message=  $('#message').summernote('code');
                let is_funnel=document.getElementById("is_funnel").checked;

                let jobs_funnel = document.getElementById("jobs_funnel").value;

                let whatsapp_required_=document.getElementById("whatsapp_required_id").checked;
                let wp_num= phoneInput.getNumber();

                let crjb_id_= <?php echo $crjb_id ?>;
                var fd = new FormData();
                var files = $('#job_pic_id')[0].files;
                var files1 = $('#job_logo_id')[0].files;

                if(title_.trim() != "" || title_it_.trim() != "" || title_de_.trim() != ""){
                    if(department_ == 0){
                        Swal.fire({
                            title: 'Il dipartimento è obbligatorio',
                            type: 'basic',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }else{
                        fd.append('file',files[0]);
                        fd.append('file1',files1[0]);
                        fd.append('saved_status',create_as);
                        fd.append('title',title_);
                        fd.append('title_it',title_it_);
                        fd.append('title_de',title_de_);
                        fd.append('department',department_);
                        fd.append('creation_date',creation_date_);
                        fd.append('description',description_);
                        fd.append('description_it',description_it_);
                        fd.append('description_de',description_de_);
                        fd.append('location',location_);
                        fd.append('location_it',location_it_);
                        fd.append('location_de',location_de_);
                        fd.append('cv_required',cv_required_);
                        fd.append('whatsapp_required',whatsapp_required_);
                        fd.append('wp_num',wp_num)
                        fd.append('crjb_id',crjb_id_);
                        fd.append('is_active',is_active_);
                        fd.append('auto_msg',message);
                        fd.append('is_funnel',is_funnel);
                        fd.append('userbenifits_array',userbenifits_array);

                        fd.append('jobs_funnel',jobs_funnel);


                        $.ajax({
                            url:'util_save_job.php',
                            type: 'post',
                            data:fd,
                            processData: false,
                            contentType: false,
                            success:function(response){

                                console.log(response);

                                if(response == '1'){
                                    Swal.fire({
                                        title: 'Lavoro salvato con successo',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.href = "jobs.php";
                                        }
                                    })
                                }else if(response == '2'){
                                    Swal.fire({
                                        title: 'Lavoro salvato con successo',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.href = "job_drafted.php";
                                        }
                                    })
                                }else if(response == '3'){
                                    Swal.fire({
                                        title: 'Lavoro salvato con successo',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.href = "job_archived.php";
                                        }
                                    })
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Qualcosa è andato storto!!!',
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
                    Swal.fire({
                        title: 'Il titolo è obbligatorio',
                        type: 'basic',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }


            }       

            // MAterial Date picker    
            $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
            $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
            $('#creation_date_id').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY' });

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