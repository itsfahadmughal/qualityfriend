<?php 
require_once 'util_config.php';
require_once '../util_session.php';

//get current funnel

$id="";
$funnel_code  = "";
$pages = "";
$funnel_name  = "";
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
$sql="SELECT * FROM `tbl_funnel_info` where f_id = $id and hotel_id = $hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $funnel_code = $row['code'];
        $pages = $row['pages_array'];
        $funnel_name = $row['name'];
    }
    $pages = json_decode($pages);
    $funnel_code =  str_replace('xxx$#','"',$funnel_code);
    $funnel_code =  str_replace("xxxn4$#","'",$funnel_code);
    $funnel_code =  str_replace("./assets","../assets",$funnel_code);
    $funnel_code =  str_replace("./images","../images",$funnel_code);
    $funnel_code = str_replace('src="images', 'src="../images', $funnel_code);
    $funnel_code =  str_replace('src="funnel_php/','src="../funnel_php/',$funnel_code);

//    $funnel_code =  str_replace("/funnel_php/","../funnel_php/",$funnel_code);
}else {

?>
<script type="text/javascript">window.location.href = 'dashboard.php';</script>

<?php
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
        <title>QualityFriend - Funnel</title>
        <!-- This page CSS -->
        <!-- chartist CSS -->
        <link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">
        <!--c3 plugins CSS -->
        <link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/pages/tab-page.css" rel="stylesheet">
        <link href="../dist/css/funnel.css" rel="stylesheet">

        <link href="../assets/node_modules/tablesaw/dist/tablesaw.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <!-- Emoji Mart CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-mart@latest/css/emoji-mart.css">
        <link rel="stylesheet" href="../assets/node_modules/dropify/dist/css/dropify.min.css">
        <style>
            .red_color {
                color: red;
            }
        </style>

        <style>
            /* Style for the left icons */
            #leftIconGrid i {
                font-size: 30px;
                height: 30px;
                line-height: 30px;
                margin: 4px;
                padding: 5px;

                color: black;
                cursor: pointer;
            }
            #leftIconGrid i:hover {

                transform: scale(1.3);
            }

            .leftIconGrid i {
                font-size: 30px;
                height: 30px;
                line-height: 30px;
                margin: 4px;
                padding: 5px;

                color: black;
                cursor: pointer;
            }
            .leftIconGrid i:hover {

                transform: scale(1.3);
            }

            .leftIconGrid_multiple i {
                font-size: 30px;
                height: 30px;
                line-height: 30px;
                margin: 4px;
                padding: 5px;

                color: black;
                cursor: pointer;
            }
            .leftIconGrid_multiple i:hover {

                transform: scale(1.3);
            }
            .icons_div{
                height: 305px;
                overflow-y: auto;
            }
        </style>

    </head>

    <body class="skin-default-dark fixed-layout fixed-height-element">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">QualityFriend</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper ">
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
            <div class="page-wrapper ">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid m-0 p-0">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!--
<div class="mobile-container-padding">
<div class="row page-titles mb-3 heading_style">
<div class="col-md-5 align-self-center">
<h5 class="text-themecolor font-weight-title font-size-title mb-0">Recruiting</h5>
</div>
<div class="col-md-7 align-self-center text-right">
<div class="d-flex justify-content-end align-items-center">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
<li class="breadcrumb-item text-success">Funnel</li>
</ol>
</div>
</div>
</div>
</div>
-->
                    <div class="row margen_non padding_non">
                        <!-- Add page Popup Model -->
                        <div id="add-page" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h4 class="modal-title" id="myModalLabel">Add Page</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                            <div class="row">
                                                <div class="col-lg-12 col-xlg-12 col-md-12">
                                                    <input type="text" class="form-control" id="add_page" placeholder="Enter page"> 
                                                </div>

                                            </div>

                                        </from>
                                    </div>
                                    <div class="modal-footer">

                                        <button onclick="add_new_page()" type="button" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="col-lg-6 col-xlg-6 col-md-6 mt-3 ">

                            <input onkeyup=""  value="<?php echo $funnel_name;?>"  type="text" class="form-control" id="funnel_name"  placeholder="Name*">


                        </div>
                        <div class="col-lg-6 col-xlg-6 col-md-6 mt-3 ">
                            <button onclick="save_me()" class="btn btn-info d-lg-block " >Save</button>
                        </div>
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="row ">
                                <div id="left_pages" class="left_pafe_height col-lg-3 col-xlg-3 col-md-3 ">
                                    <div class="question-list">
                                        <div class="row margen_non">
                                            <div class="col-lg-11 col-xlg-11 col-md-1">
                                                <h3>Pages</h3>
                                            </div>
                                            <div class="col-lg-1 col-xlg-1 col-md-1 font-size-title">
                                                <a data-toggle="modal" data-target="#add-page" href="javascript:void(0)"><i class="mdi mdi-plus-circle"></i></a>

                                            </div>
                                        </div>

                                        <ul id="my_pages" >
                                            <!--
<li  onclick="showAnswer(1)" class="active ">


<div class="row margen_non padding_non">
<div class="col-lg-11 col-xlg-11 col-md-11">
<span>Question 1 </span>
</div>
<div class="col-lg-1 col-xlg-1 col-md-1">

<button  id='w' onclick='update_page_list(i)' type='button' class='close close-center1'  aria-hidden='true'>×</button>
</div>

</div>



</li>
-->

                                            <!--

<li onclick="showAnswer(2)">

<span>Question 2</span>
</li>
<li onclick="showAnswer(3)">

<span>Question 3</span>
</li>
-->
                                            <!-- Add more questions here -->
                                        </ul>



                                        <ul id="myfixed_pages" >
                                            <li  onclick="showAnswer('thanks')" class="">
                                                <div class="row margen_non padding_non">
                                                    <div class="col-lg-11 col-xlg-11 col-md-11">
                                                        <span>Thank you page</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li  onclick="showAnswer('disqualification')" class="">
                                                <div class="row margen_non padding_non">
                                                    <div class="col-lg-11 col-xlg-11 col-md-11">
                                                        <span>disqualification page</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div id="left_tools" class="left_pafe_height display_none col-lg-3 col-xlg-3 col-md-3 padding_non">

                                    <div class="row margen_non padding_non">
                                        <div class="col-lg-12 col-xlg-12 col-md-12">
                                            <a href="javascript:void(0)"><i onclick="hide_tools()" class="fa fa-arrow-left"></i></a>
                                        </div>
                                        <div class="col-lg-12 col-xlg-12 col-md-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs customtab" role="tablist">
                                                <li class="nav-item"> <a id="ideas_h" class="nav-link active" data-toggle="tab" href="#ideas" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Ideas</span></a> </li>

                                                <li onclick="hide_all()" class="nav-item"> <a id="elements_h" class="nav-link" data-toggle="tab" href="#element" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Elements</span></a></li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content margen_non ">
                                                <div class="tab-pane active" id="ideas" role="tabpanel">

                                                    <!--For Text-->
                                                    <div class="display_none all_tools" id="for_only_text" >
                                                        <h5 class="mt-1 mb-1" id="" >Background color</h5>
                                                        <div class="">
                                                            <input class="background_all"  type="color" id="" name="" value="#ff0000">
                                                        </div>


                                                        <h5 class="mt-1 mb-1" id="" >Emoji</h5>
                                                        <div class="">
                                                            <button id="emoji-picker" class="btn btn-info">😀</button>
                                                        </div>
                                                        <?php include '../funnel_php/size.php'; ?>
                                                        <div class="pt-20">
                                                            <h3>text</h3>
                                                            <h4>color</h4>
                                                            <input  type="color" id="favcolor" name="favcolor" value="#ff0000"><br><br>
                                                        </div>
                                                        <?php include '../funnel_php/bold_text.php'; ?>

                                                        <?php include '../funnel_php/alignments.php'; ?>






                                                    </div>
                                                    <!--For Icon-->

                                                    <div class="display_none all_tools" id="for_only_icon" >

                                                        <div class="pt-20">
                                                            <h3>Icon</h3>
                                                            <h4>color</h4>
                                                            <input  type="color" id="favcolor_icon" name="favcolor" value="#ff0000"><br><br>
                                                        </div>
                                                        <?php include '../funnel_php/icon_size.php'; ?>

                                                        <?php include '../funnel_php/alignments.php'; ?>

                                                        <input type="text" id="iconSearch" class="form-control mt-4" placeholder="Search for icons...">
                                                        <div class="row icons_div heading_style text-center">
                                                            <div class="col-md-12" id="leftIconGrid">
                                                                <!-- Add icons using JavaScript (see script section below) -->
                                                            </div>

                                                        </div>


                                                    </div>

                                                    <!--For Buton-->
                                                    <div class="display_none all_tools" id="for_only_buuton" >
                                                        <div class="pt-20">
                                                            <h3>Button</h3>
                                                            <br>
                                                            <h4>Button color</h4>
                                                            <input  type="color" id="favcolor_button" name="favcolor" value="#ff0000"><br><br>
                                                            <h4>Text color</h4>
                                                            <input  type="color" id="favcolor_button_text" name="favcolor" value="#ff0000"><br><br>
                                                        </div>
                                                        <?php include '../funnel_php/alignments.php'; ?>
                                                        <h4 class="mt-3">Next page</h4>
                                                        <?php include '../funnel_php/gotonext.php'; ?>


                                                    </div>


                                                    <!--For Image-->
                                                    <div class="display_none all_tools" id="for_only_image" >
                                                        <div class="pt-20">
                                                            <h3>Image</h3>
                                                            <br>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Image</h4>
                                                                    <input   type="file" name="file" id="imageInput"  accept="image/png, image/jpeg"  class="dropify" data-max-file-size="2M"   />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php include '../funnel_php/alignments.php'; ?>


                                                    </div>
                                                    <!--For AUdio-->
                                                    <div class="display_none all_tools" id="for_only_audio" >
                                                        <div class="pt-20">
                                                            <h3 class="mt-3" >Voice message</h3>
                                                            <br>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Image</h4>
                                                                    <input   type="file" name="file" id="audio_imageInput"  accept="image/png, image/jpeg"  class="dropify"    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pt-20">

                                                            <br>

                                                            <form action="../upload.php" method="POST" enctype="multipart/form-data">
                                                                <input type="file" accept=".mp3" name="audio" id="audio-upload" style="display: none;">
                                                                <label class="btn btn-info" for="audio-upload" id="upload-label">
                                                                    <i class="fas fa-upload"></i> Upload Audio
                                                                </label>
                                                            </form>
                                                            <div class="audio-player">
                                                                <audio controls id="audio-element">
                                                                    Your browser does not support the audio element.
                                                                </audio>
                                                                <i class="fas fa-trash delete-icon"></i>
                                                            </div>

                                                        </div>
                                                        <br>
                                                        <?php include '../funnel_php/alignments.php'; ?>

                                                        <br> <br>
                                                    </div>




                                                    <!--For Video-->
                                                    <div class="display_none all_tools" id="for_only_video" >
                                                        <div class="pt-20">
                                                            <h3 class="mt-3" >Vedio</h3>
                                                            <br>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <label for="videoUrl" class="form-label">Enter Video URL</label>
                                                                    <input type="text" class="form-control" id="videoUrl" placeholder="Paste YouTube or Vimeo URL here">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!--For Single selection-->
                                                    <div class="display_none all_tools" id="for_only_single_selection" >
                                                        <div class="pt-20">
                                                            <h3 class="mt-3" >selection card</h3>
                                                            <h5 class="mt-1 mb-1" id="" >Emoji</h5>
                                                            <div class="">
                                                                <button id="emoji-picker_s" class="btn btn-info">😀</button>
                                                            </div>
                                                            <h4 class="mt-3">Next page</h4>
                                                            <?php include '../funnel_php/gotonext.php'; ?>

                                                            <input type="text" id="" class="iconSearch form-control mt-2" placeholder="Search for icons...">
                                                            <div class="row icons_div heading_style text-center">
                                                                <div class="col-md-12 leftIconGrid" id="">
                                                                    <!-- Add icons using JavaScript (see script section below) -->
                                                                </div>

                                                            </div>
                                                            <br>

                                                        </div>

                                                    </div>

                                                    <!--For Single selection-->
                                                    <div class="display_none all_tools" id="for_only_multi_selection" >
                                                        <div class="pt-20">
                                                            <h3 class="mt-3" >selection card</h3>
                                                            <h5 class="mt-1 mb-1" id="" >Emoji</h5>
                                                            <div class="">
                                                                <button id="emoji-picker_m" class="btn btn-info">😀</button>
                                                            </div>

                                                            <input type="text" id="" class="iconSearch_multiple form-control mt-2" placeholder="Search for icons...">
                                                            <div class="row icons_div heading_style text-center">
                                                                <div class="col-md-12 leftIconGrid_multiple" id="">
                                                                    <!-- Add icons using JavaScript (see script section below) -->
                                                                </div>

                                                            </div>
                                                            <br>

                                                        </div>

                                                    </div>

                                                    <!--For Cv selection-->
                                                    <div class="display_none all_tools" id="for_only_cv" >
                                                        <div class="pt-20">
                                                            <h3>Cv</h3>
                                                            <br>
                                                            <h4>Button color</h4>
                                                            <input  type="color" id="favcolor_button_cv" name="favcolor" value="#ff0000"><br><br>
                                                            <h4>Text color</h4>
                                                            <input  type="color" id="favcolor_button_text_cv" name="favcolor" value="#ff0000"><br><br>
                                                        </div>

                                                        <h4 class="mt-3">Next page</h4>
                                                        <?php include '../funnel_php/gotonext.php'; ?>

                                                    </div>


                                                    <!--For Form selection-->
                                                    <div class="display_none all_tools" id="for_only_form" >
                                                        <div class="pt-20">
                                                            <h3>Form</h3>
                                                            <br>
                                                            <h4>Button color</h4>
                                                            <input  type="color" id="favcolor_button_form" name="favcolor" value="#ff0000"><br><br>
                                                            <h4>Text color</h4>
                                                            <input  type="color" id="favcolor_button_text_form" name="favcolor" value="#ff0000"><br><br>
                                                        </div>

                                                        <h4 class="mt-3">Next page</h4>
                                                        <?php include '../funnel_php/gotonext.php'; ?>

                                                    </div>


                                                    <!--For Form selection-->
                                                    <div class="display_none all_tools" id="for_only_footer" >
                                                        <div class="pt-20">
                                                            <h3>Footer</h3>
                                                            <br>
                                                            <label for="impressum_url" class="form-label">Enter Impressum URL</label>
                                                            <input type="text" class="form-control" id="impressum_url" placeholder="Enter Impressum URL">
                                                            <label for="data_url" class="form-label">Datenschutzerklärung URL</label>
                                                            <input type="text" class="form-control" id="data_url" placeholder="Datenschutzerklärung URL">
                                                        </div>



                                                    </div>




                                                </div>
                                                <div class="tab-pane   margen_non" id="element" role="tabpanel">

                                                    <?php include '../funnel_php/all_element.php'; ?>

                                                </div>



                                            </div>




                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-9 col-xlg-9 col-md-9 pb-4">
                                    <?php echo $funnel_code; ?>
                                    <div class="drop-indicator"></div>
                                </div>
                            </div>



                        </div>

                    </div>

                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
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
        <script src="../assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
        <!--c3 JavaScript -->
        <script src="../assets/node_modules/d3/d3.min.js"></script>
        <script src="../assets/node_modules/c3-master/c3.min.js"></script>


        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
        <!-- Emoji Mart JS -->
        <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

        <script src="../assets/node_modules/dropify/dist/js/dropify.min.js"></script>
        <script>
            function rgbToHex(rgb) {
                const [r, g, b] = rgb.match(/\d+/g);
                return `#${Number(r).toString(16).padStart(2, '0')}${Number(g).toString(16).padStart(2, '0')}${Number(b).toString(16).padStart(2, '0')}`;
            }
            function all_the_backgroubd(){
                var elementToGetBackgroundColor = document.getElementById('all_the_anwer');
                var background_all_q = document.querySelector('.background_all');
                var backgroundColor = window.getComputedStyle(elementToGetBackgroundColor).backgroundColor;
                background_all_q.value =  rgbToHex(backgroundColor);
            }

            all_the_backgroubd();

            var elementToGetBackgroundColor = document.getElementById('all_the_anwer');
            var background_all = document.getElementsByClassName("background_all");

            for (var i = 0; i < background_all.length; i++) {
                background_all[i].addEventListener("input", function() {
                    var newColor = this.value;
                    elementToGetBackgroundColor.style.backgroundColor = newColor;

                    // Convert newColor to RGB for conversion to hex
                    var rgbColor = newColor;
                    if (!rgbColor.startsWith("rgb")) {
                        // Convert hex color to RGB format
                        rgbColor = rgbToHex(newColor);
                    }

                    // Update the value of the color input with the converted RGB color
                    this.value = rgbColor;

                    console.log(this.value);

                    all_the_backgroubd();
                });
            }

        </script>
        <script>
            function save_me(){
                const answerContainers = document.querySelectorAll(".answer");
                if (answerContainers.length > 0) {
                    answerContainers.forEach(function (container) {
                        container.classList.remove("active");
                    });
                    const selectedAnswer = document.getElementById('answer-1');
                    if (selectedAnswer) {
                        selectedAnswer.classList.add('active');
                    }else{
                        const selectedAnswer = document.getElementById(`thanks`);
                        selectedAnswer.classList.add("active");
                    }

                }
                const divElement = document.getElementById('all_the_anwer');
                const divContent = divElement.outerHTML;
                // Create a FormData object to send the data

                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = divContent;
                //                // Get all elements with class "single_plus" within the temporary div
                //                var singlePlusElements = tempDiv.getElementsByClassName('single_plus');
                //                // Convert the HTMLCollection to an array to avoid potential issues
                //                var singlePlusArray = Array.from(singlePlusElements);
                //                // Loop through the array and remove each "single_plus" element
                //                singlePlusArray.forEach(function(element) {
                //                    element.parentNode.removeChild(element);
                //                });
                //                // Get all elements with class "multi_plus" within the temporary div
                //                var multiPlusElements = tempDiv.getElementsByClassName('multi_plus');
                //
                //                // Convert the HTMLCollection to an array to avoid potential issues
                //                var multiPlusArray = Array.from(multiPlusElements);
                //
                //                // Loop through the array and remove each "multi_plus" element
                //                multiPlusArray.forEach(function(element) {
                //                    element.parentNode.removeChild(element);
                //                });
                // The updated HTML content without the "single_plus" and "multi_plus" elements
                var updatedDivContent = tempDiv.innerHTML;
                var originalFunnelCode = updatedDivContent;

                originalFunnelCode = originalFunnelCode.replace(/src="\.\.\/images/g, 'src="images');
                originalFunnelCode = originalFunnelCode.replace(/src="..\/assets/g, 'src="./assets');
                originalFunnelCode = originalFunnelCode.replace(/src="..\/images/g, 'src="./images');





                var id = <?php echo $id; ?>;

                console.log(pages);
                const funnel_name = document.getElementById('funnel_name').value;
                const formData = new FormData();
                formData.append('code', originalFunnelCode);
                formData.append('pages', JSON.stringify(pages));
                formData.append('id', id);
                formData.append('funnel_name', funnel_name);

                // Fetch request to send data to the server
                fetch('utill_save_funnel_code.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(result => {
                    if(result != "error"){

                        console.log(result);
                        window.location.href = 'funnel_edit.php?id='+result;
                    }else{
                        console.log(result);
                    }
                })
                    .catch(error => {
                    console.error('Error:', error);
                });

            } 

        </script>
        <script src="../funnel_js/handle_del_and_darg_and_drop.js"></script>
        <script>
            //for emoji
            var picker;
            var selected_text_id = "";
            var selected_page = 1;
        </script>
        <script src="../funnel_js/emoji_define.js"></script>
        <script>

            var    left_page = document.getElementById("left_pages");
            var    left_tool = document.getElementById("left_tools");
            var    ideas_h = document.getElementById("ideas_h");
            var    elements_h = document.getElementById("elements_h");
            var    ideas_o = document.getElementById("ideas");
            var    elements_o = document.getElementById("element");




            //Handel Tools
            function hide_tools(){
                if (picker && picker.parentNode) {
                    picker.parentNode.removeChild(picker);
                }
                left_tool.classList.add("display_none");
                left_tool.classList.remove("display_block");
                left_page.classList.remove("display_none");
                left_page.classList.add("display_block");
            }


            function hide_all() {
                if (picker && picker.parentNode) {
                    picker.parentNode.removeChild(picker);
                }

            }

            function open_ideal() {
                ideas_h.classList.add("active");

                elements_h.classList.remove("active");

                ideas_o.classList.add("active");

                elements_o.classList.remove("active");
            }



            //Get all ideal div
            var    for_only_text_div = document.getElementById("for_only_text");
            var    for_only_icon_div = document.getElementById("for_only_icon");
            var    for_only_buuton = document.getElementById("for_only_buuton");
            var    for_only_image = document.getElementById("for_only_image");
            var    for_only_audio = document.getElementById("for_only_audio");
            var    for_only_video = document.getElementById("for_only_video"); 
            var    for_only_single_selection = document.getElementById("for_only_single_selection"); 
            var    for_only_multi_selection = document.getElementById("for_only_multi_selection"); 
            var    for_only_cv = document.getElementById("for_only_cv"); 
            var    for_only_form = document.getElementById("for_only_form"); 
            var    for_only_footer = document.getElementById("for_only_footer");



            function alltools(targetDivId){
                const divs = document.querySelectorAll('.all_tools');
                divs.forEach(div => {
                    if (div.id === targetDivId) {
                        document.getElementById(div.id).classList.add("display_block");
                    } else {
                        document.getElementById(div.id).classList.remove("display_block");
                        document.getElementById(div.id).classList.add("display_none");
                    }
                });

            }

            function just_hide_leftpage(){
                left_page.classList.add("display_none");
                left_page.classList.remove("display_block");
                left_tool.classList.remove("display_none");
                left_tool.classList.add("display_block");
            }

            function chnage_alignment(what){

                const align_left_1 = document.querySelectorAll('.align_left_1');
                const align_center1 = document.querySelectorAll('.align_center1');
                const align_right_1 = document.querySelectorAll('.align_right_1');



                var selected_text_id_is = document.getElementById(selected_text_id);

                if(what == "align_center"){

                    console.log("run1");
                    align_center1.forEach(element => {
                        element.classList.add('selected_alignment');
                    });



                    align_left_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    align_right_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });


                    selected_text_id_is.style.textAlign = 'center';


                }else  if(what == "align_right"){


                    console.log("run2");
                    align_right_1.forEach(element => {
                        element.classList.add('selected_alignment');
                    });



                    align_left_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    align_center1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });;

                    selected_text_id_is.style.textAlign = 'right';

                }else if(what == "align_left"){


                    console.log("run3");
                    align_left_1.forEach(element => {
                        element.classList.add('selected_alignment');
                    });



                    align_center1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    align_right_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    selected_text_id_is.style.textAlign = 'left';
                }else{


                    console.log("run4");
                }

            }
            function get_alignment(textAlign){


                const align_left_1 = document.querySelectorAll('.align_left_1');
                const align_center1 = document.querySelectorAll('.align_center1');
                const align_right_1 = document.querySelectorAll('.align_right_1');




                if(textAlign == "center"){

                    console.log("run1");
                    align_center1.forEach(element => {
                        element.classList.add('selected_alignment');
                    });



                    align_left_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    align_right_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });


                }else  if(textAlign == "right"){


                    console.log("run2");
                    align_right_1.forEach(element => {
                        element.classList.add('selected_alignment');
                    });



                    align_left_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    align_center1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });;


                }else if(textAlign == "left"){


                    console.log("run3");
                    align_left_1.forEach(element => {
                        element.classList.add('selected_alignment');
                    });



                    align_center1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });

                    align_right_1.forEach(element => {
                        element.classList.remove('selected_alignment');
                    });
                }else{


                    console.log("run4");
                }
            }
        </script>
        <!--        FOR_TEXT-->
        <script src="../funnel_js/text_control.js"></script>
        <!--FOR_ICON        -->
        <script src="../funnel_js/icon_control.js"></script>
        <!--FOR_Button        -->
        <script src="../funnel_js/button_control.js"></script>
        <!--FOR_Image        -->
        <script src="../funnel_js/image_control.js"></script>
        <!--For Audio        -->
        <script src="../funnel_js/audio_control.js"></script>
        <!--For video        -->
        <script src="../funnel_js/video_control.js"></script>
        <!--        icons define-->
        <script src="../funnel_js/icon_define.js"></script>
        <!--         About page question-->
        <script>
            var pages = <?php echo json_encode($pages); ?>;
        </script>
        <script src="../funnel_js/page_questions_and_answer.js"></script>
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

        <script src="../funnel_js/single_selection.js"></script>
        <script src="../funnel_js/multiple_selection.js"></script>
        <script src="../funnel_js/gotonextpage.js"></script>
        <script src="../funnel_js/cv_control.js"></script>
        <script src="../funnel_js/form_control.js"></script>
        <script src="../funnel_js/footer_control.js"></script>




    </body>

</html>