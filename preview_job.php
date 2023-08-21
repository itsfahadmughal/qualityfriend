<?php
include 'util_config.php';
include 'util_session.php';

$time_stamp="";
$lang="";

if(isset($_GET['slug'])){
    $time_stamp=$_GET['slug'];
}
if(isset($_GET['lang'])){
    $lang=$_GET['lang'];
}

//for campaign
$source = "";
$team = "";
$team = "";
$cam_id = 0;
if(isset($_GET['source'])){
    $source=$_GET['source'];
}
if(isset($_GET['name'])){
    $team=$_GET['name'];
}
if(isset($_GET['team'])){
    $team=$_GET['team'];
}
if(isset($_GET['id'])){
    $cam_id=$_GET['id'];
}

$entryby_ip=getIPAddress();
$entry_time=date("Y-m-d H:i:s");


if(isset($_GET['id'])){
    $sql="INSERT INTO `tbl_job_ad_campaign_count`( `campaign_id`, `entrybyip`, `endtime`) VALUES ('$cam_id','$entryby_ip','$entry_time')";
    $result = $conn->query($sql);
    if($result){

    }else{

    }

}


$image_link="";
$title="";
$description="";
$crjb_id="";
$hotel_id="";
$is_cv_required="";
$is_whatsapp_required="";
$wp_num="";
$location = "";
$auto_msg = "";
$logo_link = "./assets/images/favicon.png";
$sql="SELECT * FROM `tbl_create_job` WHERE `generated_link` LIKE '%$time_stamp%'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $i=1;
    while($row = mysqli_fetch_array($result)) {
        $is_funnel = $row['is_funnel'];
        $step_1_q = $row['step_1_q'];
        $step_2_q = $row['step_2_q'];

        $test1 =  trim($row['auto_msg']," ");


        if($test1 != ""){
            $auto_msg = $test1;
        }
        $is_cv_required=$row['is_cv_required'];
        $is_whatsapp_required=$row['whatsapp_isactive'];
        $wp_num=$row['whatsapp'];
        $depart_id=$row['depart_id'];
        if($lang=="english"){
            $crjb_id=$row['crjb_id'];
            if($row['title'] != ""){
                $title=$row['title'];
            }else if($row['title_it'] != ""){
                $title=$row['title_it'];
            }else if($row['title_de'] != ""){
                $title=$row['title_de'];
            }

            if($row['description'] != ""){
                $description=$row['description'];
            }else if($row['description_it'] != ""){
                $description=$row['description_it'];
            }else if($row['description_de'] != ""){
                $description=$row['description_de'];
            } 

            if($row['location'] != ""){
                $location=$row['location'];
            }else if($row['location_it'] != ""){
                $location=$row['location_it'];
            }else if($row['location_de'] != ""){
                $location=$row['location_de'];
            } 




            $image_link=$row['job_image'];

            if($row['logo_image'] != ""){
                $logo_link=$row['logo_image'];
            }
            $hotel_id=$row['hotel_id'];
        }elseif($lang=="italian"){
            $crjb_id=$row['crjb_id'];
            if($row['title_it'] != ""){
                $title=$row['title_it'];
            }else if($row['title'] != ""){
                $title=$row['title'];
            }else if($row['title_de'] != ""){
                $title=$row['title_de'];
            }

            if($row['description_it'] != ""){
                $description=$row['description_it'];
            }else if($row['description'] != ""){
                $description=$row['description'];
            }else if($row['description_de'] != ""){
                $description=$row['description_de'];
            } 

            if($row['location_it'] != ""){
                $location=$row['location_it'];
            }else if($row['location'] != ""){
                $location=$row['location'];
            }else if($row['location_de'] != ""){
                $location=$row['location_de'];
            }
            $image_link=$row['job_image'];
            if($row['logo_image'] != ""){
                $logo_link=$row['logo_image'];
            }
            $hotel_id=$row['hotel_id'];
        }elseif($lang=="german"){
            $crjb_id=$row['crjb_id'];
            if($row['title_de'] != ""){
                $title=$row['title_de'];
            }else if($row['title_it'] != ""){
                $title=$row['title_it'];
            }else if($row['title'] != ""){
                $title=$row['title'];
            }

            if($row['description_de'] != ""){
                $description=$row['description_de'];
            }else if($row['description_it'] != ""){
                $description=$row['description_it'];
            }else if($row['description'] != ""){
                $description=$row['description'];
            } 
            if($row['location_de'] != ""){
                $location=$row['location_de'];
            }else if($row['location'] != ""){
                $location=$row['location'];
            }else if($row['location_de'] != ""){
                $location=$row['location_de'];
            }
            $image_link=$row['job_image'];
            if($row['logo_image'] != ""){
                $logo_link=$row['logo_image'];
            }
            $hotel_id=$row['hotel_id'];
        }
    } 
}

$data_protection = "";
$privacy_policy  = "";

$sql="SELECT * FROM `tbl_hotel` WHERE hotel_id = $hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        if($row['data_protection'] != "")
        {
            $data_protection = $row['data_protection'];
        }else if ($row['data_protection_it'] != ""){
            $data_protection = $row['data_protection_it'];
        }else if ($row['data_protection_de'] != ""){
            $data_protection = $row['data_protection_de'];
        }


        if($row['privacy_policy'] != "")
        {
            $privacy_policy = $row['privacy_policy'];
        }else if ($row['privacy_policy_it'] != ""){
            $privacy_policy = $row['privacy_policy_it'];
        }else if ($row['privacy_policy_de'] != ""){
            $privacy_policy = $row['privacy_policy_de'];
        }

        if($row['hotel_name'] != "")
        {
            $hotel_name = $row['hotel_name'];
        }else if ($row['hotel_name_it'] != ""){
            $hotel_name = $row['hotel_name_it'];
        }else if ($row['hotel_name_de'] != ""){
            $hotel_name = $row['hotel_name_de'];
        }
    } 
}


if($depart_id !=  0 ){
    $dis = "disabled";
}else {
    $dis = "";
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
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
        <title>Preview Job</title>
        <link href="dist/css/style.min.css" rel="stylesheet">
        <link href="dist/css/recruiting.css" rel="stylesheet">
        <link rel="stylesheet" href="./assets/node_modules/dropify/dist/css/dropify.min.css">
        <link href="./assets/node_modules/summernote/dist/summernote.css" rel="stylesheet" />
        <link href="./assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="dist/css/pages/file-upload.css" rel="stylesheet">
        <link href="./assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

        <!-- Add intl-tel-input CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" rel="stylesheet">
        <style>
            /* Custom styles for the header */
            .fixed-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background-color: #fff; /* Replace with your desired background color */
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                z-index: 1000; /* Ensure the header is above other elements */
            }
            .auto_msg{
                display: none;
            }
            .logo-text {
                /*
                font-weight: bold;
                font-size: 24px;
                margin-left: 10px;
                */
            }
            .action-buttons {
                display: flex;
                align-items: center;
            }
            .action-buttons button {
                margin-left: 10px;
            }

            .text-black {
                color: black;
            }
            .whatsapp-button img {
                width: 50px;
                height: 50px;
                margin-right: 15px; /* Added margin to the right of the WhatsApp image */
                margin-left: 15px; 
            }

            .header_margen{

                padding-top: 110px ; 
                padding-left: 70px;
                padding-right: 70px;
            }
            .size_location{
                font-size: 1.7em;
                color: rgba(59, 59, 59, 1);
            }
            .benifits_{
                margin-top:  60px;
            }

            .custom-input {
                width: 100% !important;
            }
            .iti {

                display: inherit!important;
            }

            .page-wrapper {
                background: #F3F3F3!important;
            }
            .apply_button{
                height: 50px;
                width: 150px;
                font-size: 20px;
            }
            .logo_is{
                height: 80px;
            }

            .color_is{
                color: #3d5158;
            }
            .text_center_{
                text-align: center;
            }

            .image-container {
                position: relative;
            }

            .bottom-right-text {
                position: absolute;
                bottom: 5px; /* Adjust the margin from the bottom */
                right: 5px; /* Adjust the margin from the right */
                background-color: rgba(0, 0, 0, 0.7);
                color: #fff;
                padding: 8px;
                font-size: 14px;
                opacity: 0.8; /* Adjust the opacity */
                padding-left: 30px;
                padding-right: 40px;
                padding-bottom: 20px;
                padding-top: 20px;
            }
            .div_radius{
                border-radius: 15px;
            }
            .icopn_size{
                font-size: 60px;
            }
            @media (max-width: 1000px) {
                .logo_is{
                    max-width: 140px;
                }
                .whatsapp-button {
                    position: fixed;
                    bottom: 15px;
                    right: 15px;
                    z-index: 1001; /* Ensure the button is above the header */
                }
                .scroll-button {
                    /*                    display: none;*/
                }
                .benifites_gone{
                    /*                    display: none;*/
                    font-size: 10px;
                    padding-left: 5px;
                    padding-right: 5px;
                    padding-bottom: 5px;
                    padding-top: 5px;
                }
                .header_margen_mobile{
                    padding-left: 5px;
                    padding-right: 5px;
                }
                .benifits_mobile{
                    margin-top:  50px;
                }

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
                <p class="loader__label">Preview Job</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->

            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper m-0 p-0">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!--
<div class="row page-titles pb-0">
<div class="col-md-2 align-self-center">

</div>
<div class="col-md-9">

</div>
<div class="col-md-1 mobile-align-right">
<div class="btn-group">

<i id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" class="mdi mdi-dots-vertical pointer font-size-title"></i>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuReference" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
<a class="dropdown-item" href="#">Change Language</a>
<a class="dropdown-item" href="< ?php echo $baseurl; ?>preview_job.php?lang=english&slug=< ?php echo $time_stamp; ?>">English</a>
<a class="dropdown-item" href="< ?php echo $baseurl; ?>it/preview_job.php?lang=italian&slug=< ?php echo $time_stamp; ?>">Italian</a>
<a class="dropdown-item" href="< ?php echo $baseurl; ?>de/preview_job.php?lang=german&slug=< ?php echo $time_stamp; ?>">German</a>
</div>
</div>
</div>
</div>
-->


                    <!-- Add Contact Popup Model -->
                    <div id="datapro" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog custom_modal_dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Data Protection Policy</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <p> <?php echo $data_protection; ?></p>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>


                    <div id="privicy_model" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog custom_modal_dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Privacy policy</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <p> <?php echo $privacy_policy; ?></p>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>



                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <!-- Row -->
                    <div id = "all_views" >
                        <header class="fixed-header">
                            <div class="logo-text">
                                <img class="logo_is" onerror="./assets/images/favicon.png" src="<?php echo $logo_link; ?>"  />
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-secondary scroll-button apply_button" onclick="scrollToDiv()">Apply now</button>
                                <?php if($is_whatsapp_required==1){ ?>
                                <div class="whatsapp-button">  
                                    <a href="https://wa.me/<?php echo $wp_num; ?>" target="_blank"><img src="./assets/images/whatsappp.png"  /></a>
                                </div>
                                <?php } ?>
                            </div>
                        </header>
                        <!-- Your website content here -->
                        <div class="row header_margen header_margen_mobile"  >
                            <!-- Content -->

                            <div class="col-lg-12 col-xlg-12 col-md-12">

                                <?php if($image_link != ""){ ?>
                                <div class="row benifits_">
                                    <div class="col-lg-12 col-xlg-12 col-md-12 ">
                                        <div class="image-container">
                                            <img src="<?php echo $image_link; ?>" class="w-100  shadow-radius image-style-cover " />
                                            <?php $sql1="SELECT * FROM `tbl_job_benefits` where job_id = $crjb_id";
                                                            $result1 = $conn->query($sql1);
                                                            if ($result1 && $result1->num_rows > 0) { ?>
                                            <div class="bottom-right-text benifites_gone">
                                                <span><b>Unsere Benefits</b></span>
                                                <br>

                                                <?php 
                                                                while($row = mysqli_fetch_array($result1)) {
                                                                    $text = $row['text'];
                                                                    $id = $row['id'];
                                                ?>
                                                <i class="mdi  mdi-check"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span><?php echo $text; ?></span><br>

                                                <?php }  ?>

                                            </div>
                                            <?php }else{
                                                            }?>
                                        </div>

                                    </div>
                                </div>
                                <?php }else { ?>

                                <div class="user_benefits_div mb-3 benifits_mobile benifits_ " >
                                    <h4>Unsere Benefits</h4>

                                    <?php

    $sql="SELECT * FROM `tbl_job_benefits` where job_id = $crjb_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $x=1;
        while($row = mysqli_fetch_array($result)) {
            $text = $row['text'];
            $id = $row['id'];
                                    ?>
                                    <i class="mdi  mdi-check"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span><?php echo $text; ?></span><br>

                                    <?php } } ?>
                                </div>


                                <?php } ?>
                            </div>
                            <div id="auto_msg" class= " p-4 col-lg-12 col-xlg-12 col-md-12  text_center_ display_none">
                                <div class=" row " >
                                    <div id="" class= "p-4 col-lg-4 col-xlg-4 col-md-4  ">
                                    </div>

                                    <div id="" class= "heading_style p-4 col-lg-4 col-xlg-4 col-md-4  text_center_ div_radius">

                                        <?php 

                                        $auto_msg =   trim($auto_msg," ");

                                        if( $auto_msg == ""){
                                        ?>

                                        <h1 class="icopn_size" ><i style="color: #18d82e;" class="mdi mdi-check"></i></h1>

                                        <h1>Thanks You</h1>

                                        <h6>Hotel has received your application we will respond as soon as possible.</h6>

                                        <?php }else{ ?>




                                        <?php echo $auto_msg."d"; } ?>

                                    </div>

                                    <div id="" class= "p-4 col-lg-4 col-xlg-4 col-md-4   ">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <?php if($title != "" && $description != ""){ ?>
                                <div class="row mpt-25 <?php if($image_link != ""){echo 'pt-5';} ?>" >   
                                    <div class="col-lg-12 col-xlg-12 col-md-12">
                                        <div class="shadow-radius pt-4 pl-4 pr-4 pb-4">

                                            <h1 class="font-weight-title text-center"><?php echo $title; ?></h1>

                                            <p><?php echo $description; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                            <?php if($location != ""){  ?>
                            <div class="col-lg-12 col-xlg-12 col-md-12 text-right size_location mt-4">
                                <i class="fas fa-map-marker-alt mr-2" ></i><span class="" ><?php echo $location; ?></span>
                            </div>
                            <?php }?>



                            <div id="application" class="col-lg-12 col-xlg-12 col-md-12 mt-4">
                                <div class="row " >
                                    <div class="col-lg-9 col-xlg-9 col-md-9 ">
                                        <div class="row " >
                                            <div class="col-lg-12 col-xlg-12 col-md-12 ">
                                                <h3>Application</h3>
                                            </div>


                                            <div class="col-lg-12 col-xlg-12 col-md-12 ">
                                                <h4 class="font-weight-title inline-div mt-4 mr-3 text-black">Select Title: </h4>
                                                <div class="custom-control custom-radio inline-div mr-3">
                                                    <input type="radio" value="Mr" id="customRadio1" checked name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio1">Mr.</label>
                                                </div>
                                                <div class="custom-control custom-radio inline-div">
                                                    <input type="radio" value="Mrs" id="customRadio2" name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio2">Mrs.</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6  mt-2">
                                                <label class="label_f text-black" >First Name*</label>
                                                <div id="div_first_name" class="form-group ">

                                                    <input onkeyup="error_handle('first_name')" name="first_name" id="first_name" placeholder="First Name*" class="form-control form-control-danger"  >
                                                    <small id="error_msg_first_name" class="form-control-feedback display_none">First name is required</small> 
                                                </div>
                                            </div>

                                            <div class="col-md-6  mt-2">
                                                <label class="text-black" >Last Name*</label>
                                                <div id="div_last_name" class="form-group ">
                                                    <input onkeyup="error_handle('last_name')"  name="last_name" 
                                                           id="last_name" placeholder="Last Name*" class="form-control form-control-danger" >
                                                    <small id="error_msg" class="form-control-feedback display_none">Last name is required</small> </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="text-black" >Email*</label>
                                                <div id="div_email" class="form-group ">
                                                    <input onkeyup="error_handle('email')"  type="email" class="form-control" name="email" id="email" placeholder="Email" class="form-control form-control-danger" >
                                                    <small id="error_msg_email" class="form-control-feedback display_none">Email is required</small> 
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="text-black" >D.O.B</label>
                                                <div id="div_dob" class="form-group ">
                                                    <input type="date" id="dob" class="form-control" placeholder="">
                                                    <small id="error_msg_email" class="form-control-feedback display_none">D.O.B</small> 
                                                </div>
                                            </div>

                                            <div class="col-md-6 ">
                                                <label class="text-black" >Phone*</label>
                                                <div id="div_phane_name" class="form-group ">
                                                    <input onkeyup="error_handle('phone')"  type="tel" class="form-control" name="phone" id="phone" class="form-control form-control-danger" >
                                                    <small id="error_msg_phone" class="form-control-feedback display_none">Phone is required</small> </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="text-black" >Upload CV</label>
                                                <div id="div_cv" class="form-group ">
                                                    <div class="fileinput fileinput-new input-group form-control-danger" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename">Upload CV</span>
                                                        </div>
                                                        <span class="input-group-append btn btn-default btn-file"> 
                                                            <span class="fileinput-new">Select File</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input onchange="error_handle('cv')" type="file" id="cv_id" name="resume" accept="application/msword,application/pdf">
                                                        </span>
                                                        <a href="javascript:void(0)" class="input-group-append btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>

                                                    <small id="error_msg_cv" class="form-control-feedback display_none">CV is required</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xlg-6 col-md-6 ">
                                                <label class="text-black" >Select Department*</label>
                                                <div id="div_department" class="form-group ">
                                                    <select  onchange="error_handle('department')" name="department" id="department" <?php echo $dis; ?>  class="form-control" >
                                                        <option value="0">Select Department</option>
                                                        <?php 
                                                        $sql="SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0 and LOWER(department_name) != 'admin'  ";
                                                        $result = $conn->query($sql);
                                                        if ($result && $result->num_rows > 0) {
                                                            while($row = mysqli_fetch_array($result)) {
                                                                if($row[0]==$depart_id){
                                                        ?>
                                                        <option  value='<?php echo $row[0]; ?>' selected><?php echo $row[1]; ?></option>
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
                                                    <small id="error_msg_department" class="form-control-feedback display_none"> Department is required</small> 
                                                </div>
                                            </div>

                                            <div class="col-md-6" >
                                                <label class="text-black" >Upload Image</label>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput">
                                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename">Profile Image</span>
                                                    </div>
                                                    <span class="input-group-append btn btn-default btn-file"> 
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="pic_id" name="profile_pic" accept="image/jpeg , image/png">
                                                    </span>
                                                    <a href="javascript:void(0)" class="input-group-append btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>

                                            </div>
                                            <div class="col-md-12" >
                                                <label class="text-black" >Message</label>
                                                <textarea class="form-control" id="message_id" rows="5" placeholder="Message...."></textarea>

                                            </div>
                                            <div class="col-md-12" >
                                                <div id="div_d1" class="form-group ">

                                                    <div class="checkbox checkbox-success mt-4">
                                                        <input onchange="error_handle('d1')" class="has-danger" required id="submit_required" type="checkbox">
                                                        <label class="d-inline" for="submit_required">I confirm that I have read and understood the   <a  class="color_is" onclick="dataprotection()" href="JavaScript:void(0);" ><u>data protection notice for applicants.</u></a></label>
                                                    </div>

                                                    <small  id="error_msg_d1" class="form-control-feedback display_none">Accept the data policy</small>

                                                </div>

                                            </div>
                                            <div class="col-md-12" >
                                                <div id="div_d2" class="form-group ">
                                                    <div class="checkbox checkbox-success ">
                                                        <input onchange="error_handle('d2')" required id="submit_required2" type="checkbox">
                                                        <label class="d-inline" for="submit_required2"> In the event of an unsuccessful application,my application data may be taken into account for other job opennings. You can find the specific duration  
                                                            <a class="color_is"  onclick="event_privacy()" href="JavaScript:void(0);" ><u>
                                                                here.</u></a></label>
                                                    </div>
                                                    <small id="error_msg_d2" class="form-control-feedback display_none">Accept the data policy</small>

                                                </div>
                                            </div>
                                            <div class="col-md-12" >
                                                <input type="submit" onclick="addapplicant();" class="wm-100 btn w-20 btn-secondary" value="Apply">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xlg-3 col-md-3 ">



                                    </div>
                                </div>
                            </div>



                        </div>






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
        <!--stickey kit -->
        <script src="./assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="./assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>

        <script src="./assets/node_modules/dropify/dist/js/dropify.min.js"></script>
        <script src="./assets/node_modules/summernote/dist/summernote.min.js"></script>
        <script src="./assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>


        <script src="./assets/node_modules/moment/moment.js"></script>
        <script src="./assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <!-- Clock Plugin JavaScript -->
        <script src="./assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
        <!-- Color Picker Plugin JavaScript -->
        <script src="./assets/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
        <script src="./assets/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
        <script src="./assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
        <!-- Date Picker Plugin JavaScript -->
        <script src="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- Date range Plugin JavaScript -->
        <script src="./assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="./assets/node_modules/daterangepicker/daterangepicker.js"></script>

        <script src="dist/js/pages/jasny-bootstrap.js"></script>

        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>


        <!-- Add intl-tel-input JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>


        <!-- JavaScript to handle scrolling to the specific div -->
        <script>
            function scrollToDiv() {
                const targetDiv = document.getElementById('application');
                if (targetDiv) {
                    const headerHeight = document.querySelector('.fixed-header').offsetHeight;
                    const targetDivPosition = targetDiv.getBoundingClientRect().top;
                    window.scrollBy({ top: targetDivPosition - headerHeight, behavior: 'smooth' });
                }
            }
        </script>


        <script>

            //            const phoneInput = document.querySelector("#phone");
            //            const iti = window.intlTelInput(phoneInput, {
            //                separateDialCode: true,
            //                initialCountry: "de", // Set the initial country to Germany (country code "de")
            //                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            //            });

            //                div
            var last_name_div = document.getElementById("div_last_name");
            var first_name_div = document.getElementById("div_first_name");
            var email_div = document.getElementById("div_email");
            var phone_div = document.getElementById("div_phane_name");
            var department_div = document.getElementById("div_department");
            var div_d1 = document.getElementById("div_d1");
            var div_d2 = document.getElementById("div_d2");
            var div_cv = document.getElementById("div_cv");





            //            small text
            var lastname_error_msg = document.getElementById("error_msg");
            var first_error_msg = document.getElementById("error_msg_first_name");
            var email_error_msg = document.getElementById("error_msg_email");
            var phone_error_msg = document.getElementById("error_msg_phone");
            var department_error_msg = document.getElementById("error_msg_department");
            var error_msg_d1 = document.getElementById("error_msg_d1");
            var error_msg_d2 = document.getElementById("error_msg_d2");

            var error_msg_cv = document.getElementById("error_msg_cv");

            let submit_d1=document.getElementById("submit_required").checked;
            let submit_d2=document.getElementById("submit_required2").checked;

            function error_handle(run) {

                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('email').value;
                var phone = document.getElementById('phone').value;
                var department_id = document.getElementById('department').value;

                if(run == "last_name"){
                    if(last_name.trim() == ""){
                        last_name_div.classList.add("has-danger");
                        lastname_error_msg.classList.add("display_inline");
                    }else{
                        last_name_div.classList.remove("has-danger");
                        lastname_error_msg.classList.remove("display_inline");
                        lastname_error_msg.classList.add("display_none");

                    }
                }
                if(run == "first_name"){

                    if(first_name.trim() == ""){
                        first_name_div.classList.add("has-danger");
                        first_error_msg.classList.add("display_inline");
                    }else{

                        first_name_div.classList.remove("has-danger");
                        first_error_msg.classList.remove("display_inline");
                        first_error_msg.classList.add("display_none");
                    }

                }
                if(run == "email"){
                    if(email.trim() == ""){
                        email_div.classList.add("has-danger");
                        email_error_msg.classList.add("display_inline");
                    }else{

                        email_div.classList.remove("has-danger");
                        email_error_msg.classList.remove("display_inline");
                        email_error_msg.classList.add("display_none");
                    }
                }
                if(run == "phone"){
                    if(phone.trim() == ""){
                        phone_div.classList.add("has-danger");
                        phone_error_msg.classList.add("display_inline");
                    }else{

                        phone_div.classList.remove("has-danger");
                        phone_error_msg.classList.remove("display_inline");
                        phone_error_msg.classList.add("display_none");
                    }
                }
                if(run == "department"){
                    if(department_id == 0){
                        department_div.classList.add("has-danger");
                        department_error_msg.classList.add("display_inline");
                    }else{
                        department_div.classList.remove("has-danger");
                        department_error_msg.classList.remove("display_inline");
                        department_error_msg.classList.add("display_none");
                    }
                }

                if(run == "d1"){

                    if (submit_d1.checked == false){
                        div_d1.classList.add("has-danger");
                        error_msg_d1.classList.add("display_inline");
                    }else{
                        div_d1.classList.remove("has-danger");
                        error_msg_d1.classList.remove("display_inline");
                        error_msg_d1.classList.add("display_none");
                    }
                }
                if(run == "d2"){
                    if (submit_d2.checked == false){
                        div_d2.classList.add("has-danger");
                        department_error_msg.classList.add("display_inline");
                    }else{
                        div_d2.classList.remove("has-danger");
                        error_msg_d2.classList.remove("display_inline");
                        error_msg_d2.classList.add("display_none");
                    }
                }
                var cv_required = <?php echo $is_cv_required; ?>;
                if(run == "cv"){
                    if(document.getElementById("cv_id").value == "" && cv_required == 1) {
                        div_cv.classList.add("has-danger");
                        error_msg_cv.classList.add("display_inline");
                    }else{
                        div_cv.classList.remove("has-danger");
                        error_msg_cv.classList.remove("display_inline");
                        error_msg_cv.classList.add("display_none");
                    }
                }

                console.log(run);

            }


        </script>




        <script>
            function dataprotection() {
                $('#datapro').modal('show');
            }
            function event_privacy() {
                $('#privicy_model').modal('show');
            }
        </script>
        <script>



            var uploadField = document.getElementById("pic_id");
            uploadField.onchange = function() {
                if(this.files[0].size > 1097152){
                    alert("Image size is too big!");
                    this.value = "";
                };
            };

            function addapplicant() {
                var mrtitle ;
                var radios = document.getElementsByName('customRadio');
                for (var radio of radios)
                {
                    if (radio.checked) {
                        mrtitle = radio.value;
                    }
                }
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('email').value;
                var phone_is = document.getElementById('phone').value;

                var  phone =  phone_is;
                var dob = document.getElementById('dob').value;
                var department_id = document.getElementById('department').value;
                var message = document.getElementById('message_id').value;
                let submit_required=document.getElementById("submit_required").checked;
                let submit_required2=document.getElementById("submit_required2").checked;
                var job_id = <?php echo $crjb_id; ?>;
                var hotel_id = <?php echo $hotel_id; ?>;
                var cv_required = <?php echo $is_cv_required; ?>;

                var cam_id  = '<?php echo $cam_id; ?>';
                var hotel_name  = '<?php echo $hotel_name; ?>';
                var mail_msg  = '<?php echo json_decode($auto_msg); ?>';
                var fd = new FormData();
                var files = $('#pic_id')[0].files;
                var filescv = "";
                filescv = $('#cv_id')[0].files;



                if(document.getElementById("cv_id").value == "" && cv_required == 1) {
                    div_cv.classList.add("has-danger");
                    error_msg_cv.classList.add("display_inline");
                }
                else{
                    if(last_name.trim() != "" && first_name.trim() != "" && email.trim() != "" && phone_is.trim() != "" && department_id != 0  && submit_required == true &&  submit_required2 == true ){
                        $("#all_views *").attr("disabled", "disabled").off('click');
                        fd.append('filescv',filescv[0]);
                        fd.append('file',files[0]);
                        fd.append('mrtitle',mrtitle);
                        fd.append('first_name',first_name);
                        fd.append('last_name',last_name);
                        fd.append('email',email);
                        fd.append('phone',phone);
                        fd.append('dob',dob);
                        fd.append('department_id',department_id);
                        fd.append('message',message);
                        fd.append('job_id',job_id);
                        fd.append('hotel_id',hotel_id);
                        fd.append('hotel_name',hotel_name);
                        fd.append('mail_msg',mail_msg);
                        fd.append('status_id',6);
                        fd.append('cam_id',cam_id);
                        $.ajax({
                            url:'util_save_applicant.php',
                            type: 'post',
                            data:fd,
                            processData: false,
                            contentType: false,
                            success:function(response){
                                console.log(response);
                                if(response == "CREATE"){
                                    $("#all_views *").removeAttr('disabled');
                                    var appication = document.getElementById('application');
                                    appication.classList.add("display_none");
                                    var auto_msg =  document.getElementById('auto_msg');
                                    auto_msg.classList.remove("display_none");


                                    if (auto_msg) {
                                        const headerHeight = document.querySelector('.fixed-header').offsetHeight;
                                        const targetDivPosition = auto_msg.getBoundingClientRect().top;
                                        window.scrollBy({ top: targetDivPosition - headerHeight, behavior: 'smooth' });
                                    }
                                }else{
                                    $("#all_views *").removeAttr('disabled');
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
                    else{
                        if(last_name.trim() == ""){
                            last_name_div.classList.add("has-danger");
                            lastname_error_msg.classList.add("display_inline");
                        }
                        if(first_name.trim() == ""){
                            first_name_div.classList.add("has-danger");
                            first_error_msg.classList.add("display_inline");
                        }
                        if(email.trim() == ""){
                            email_div.classList.add("has-danger");
                            email_error_msg.classList.add("display_inline");
                        }
                        if(phone_is.trim() == ""){
                            phone_div.classList.add("has-danger");
                            phone_error_msg.classList.add("display_inline");
                        }
                        if(department_id == 0){
                            department_div.classList.add("has-danger");
                            department_error_msg.classList.add("display_inline");
                        }
                        if(submit_required == false){
                            div_d1.classList.add("has-danger");
                            error_msg_d1.classList.add("display_inline");
                        }
                        if(submit_required2 == ""){
                            div_d2.classList.add("has-danger");
                            error_msg_d2.classList.add("display_inline");
                        }
                    }   
                }

            }

            // MAterial Date picker    
            $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
            $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
            $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

            $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });
            // Clock pickers
            $('#single-input').clockpicker({
                placement: 'bottom',
                align: 'left',
                autoclose: true,
                'default': 'now'
            });
            $('.clockpicker').clockpicker({
                donetext: 'Done',
            }).find('input').change(function() {
                console.log(this.value);
            });
            $('#check-minutes').click(function(e) {
                // Have to stop propagation here
                e.stopPropagation();
                input.clockpicker('show').clockpicker('toggleView', 'minutes');
            });
            // Colorpicker
            $(".colorpicker").asColorPicker();
            $(".complex-colorpicker").asColorPicker({
                mode: 'complex'
            });
            $(".gradient-colorpicker").asColorPicker({
                mode: 'gradient'
            });
            // Date Picker
            jQuery('.mydatepicker, #datepicker').datepicker();
            jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            jQuery('#date-range').datepicker({
                toggleActive: true
            });
            jQuery('#datepicker-inline').datepicker({
                todayHighlight: true
            });
            // Daterange picker
            $('.input-daterange-datepicker').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse'
            });
            $('.input-daterange-timepicker').daterangepicker({
                timePicker: true,
                format: 'MM/DD/YYYY h:mm A',
                timePickerIncrement: 30,
                timePicker12Hour: true,
                timePickerSeconds: false,
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse'
            });
            $('.input-limit-datepicker').daterangepicker({
                format: 'MM/DD/YYYY',
                minDate: '06/01/2015',
                maxDate: '06/30/2015',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse',
                dateLimit: {
                    days: 6
                }
            });
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