<?php
include 'util_config.php';
include '../util_session.php';

$title = "";
$name = "";
$surname = "";
$email = "";
$phone = "";
$resume_url = "";
$image_url = "";
$message = "";
$depart_id_app = "";
$depart_id_emp = "";
$dob = "";
$dob_place = "";
$tax_number   = "";
$application_time = "";
$status_id = "";
$status = "";
$tags = "";
$comments = "";
$department_name = "";
$start_working_time = "";
$end_working_time = "";
$SocialCompetence = 0;
$MethodicalCompetence = 0;
$PersonalCompetence = 0;
$ProfractionalCompetence = 0;
$GeneralCompetence = 0;
$genrated_url = "";
$name_cam = "";
$sorce_cam = "";
$team_cam = "";
$open = "";
if(isset($_GET['id'])){
    $employee_id=$_GET['id'];
    if(isset($_GET['open'])){
        $open = $_GET['open'];
    }
    $sql="SELECT a.*,b.department_name,c.status,c.status_it FROM `tbl_applicants_employee` AS a INNER JOIN tbl_department as b on a.`depart_id_app` = b.depart_id
INNER JOIN tbl_util_status as c ON a.`status_id` = c.status_id WHERE a.`tae_id` = $employee_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $title =$row['title'];
            $name =$row['name'];
            $surname = $row['surname'];
            $email = $row['email'];
            $phone = $row['phone'];
            $resume_url =$row['resume_url'];
            $image_url = $row['image_url'];
            $message = $row['message'];
            $depart_id_app = $row['depart_id_app'];
            $depart_id_emp = $row['depart_id_emp'];
            $dob =$row['dob'];
            $dob_place = $row['dob_place'];
            $tax_number   = $row['tax_number'];
            $application_time = $row['application_time'];
            $status_id = $row['status_id'];
            $tags = $row['tags'];
            $comments = $row['comments'];
            $status = $row['status_it'];
            $department_name =$row['department_name'];
            $start_working_time = $row['start_working_time'];
            $end_working_time = $row['end_working_time'];

            $cam_id = $row['cam_id'];

            $crjb_id = $row['crjb_id'];

            $answer_array = $row['awnser_array'];

            $answer_array =  json_decode($answer_array);
            $question_array = $row['question_array'];

            $question_array =  json_decode($question_array);
            $type_array = $row['type_array'];

            $type_array =  json_decode($type_array);
        }
    }
    $sql1="SELECT * FROM `tbl_applicants_ratings` WHERE `tae_id` = $employee_id";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result1)) {
            $SocialCompetence = $row1['social_competence'];
            $MethodicalCompetence = $row1['methodical_competence'];
            $PersonalCompetence = $row1['personal_competence'];
            $ProfractionalCompetence = $row1['professional_competence'];
            $GeneralCompetence = $row1['general_impression'];
        }
    }


    $sql1="SELECT * FROM `tbl_job_ad_campaign` WHERE `id` = $cam_id";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result1)) {
            $genrated_url = $row1['genreted_url'];
            $name_cam = $row1['name'];
            $sorce_cam = $row1['sorce'];
            $team_cam = $row1['team'];

        }
    }



    $sql1="SELECT b.pages_array FROM `tbl_create_job` as a INNER JOIN tbl_funnel_info as b ON a.`job_funnel` = b.f_id WHERE a.crjb_id = $crjb_id ";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result1)) {
            $pages_array = $row1['pages_array'];
            $pages_array =  json_decode($pages_array);

        }
    }

    $questions  = [];


    if($question_array != ""){
        foreach ($question_array as $question) {
            // Extract the index from the question, e.g., "answer-3" becomes "3"
            $index = intval(str_replace("answer-", "", $question)) - 1;

            // Check if the index is within the range of the $pages_array
            if ($index >= 0 && $index < count($pages_array)) {
                // Add the corresponding page to the new array
                $questions [] = $pages_array[$index];
            } else {
                $questions [] = "Invalid index";
            }
        }
    }else {

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
        <title>Dettaglio richiedente</title>
        <!-- page CSS -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">



        <link rel="stylesheet" href="../assets/node_modules/dropify/dist/css/dropify.min.css">
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <style>
            /*          For star rating*/
            .php{
                margin-top:10px;
                width:20%;
                float:left;

            }
        </style>
        <style>
            @media print{
                body * {
                    visibility: hidden;
                }
                .print-container , .print-container *{
                    visibility: visible;
                }
            }
            .edit-show{
                display: none ;

            }
            .b-cancle{
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
                <p class="loader__label">Dettaglio richiedente</p>
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
                <div class="container-fluid mobile-container-pl-75 pr-0">

                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Dettaglio richiedentes</h4>
                        </div>

                    </div>

                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <!-- Row -->
                    <div class="print-container">
                        <div class="row">
                            <div class="col-lg-1 col-xlg-1 col-md-1">

                            </div>
                            <div class="col-lg-7 col-xlg-7 col-md-7">

                                <h5 class="font-weight-title mr-3 edit-show">Seleziona Titolo: </h5>
                                <div class="custom-control custom-radio inline-div mr-3 b-cancle">
                                    <input value="Mr" type="radio" value="Mr" id="customRadio1" name="customRadio" class="custom-control-input" <?php if($title == "Mr"){ echo "checked";}?> >
                                    <label class="custom-control-label" for="customRadio1">Sig.</label>
                                </div>
                                <div class="custom-control custom-radio inline-div b-cancle">
                                    <input value="Mrs" type="radio" value="Mrs" id="customRadio2" name="customRadio" class="custom-control-input" <?php if($title == "Mrs"){ echo "checked";}?>>
                                    <label class="custom-control-label" for="customRadio2">Sig.ra.</label>
                                </div><br class="edit-show">
                                <small class="text-muted">Name</small>
                                <br>
                                <h4 class="text-show"><?php echo $title.". ".$name." ".$surname; ?></h4> 
                                <input   type="text" id="first_name" value="<?php  echo $name; ?>" class="form-control w-30 edit-show"  placeholder="First Name">
                                <input   type="text" id="last_name" value="<?php  echo $surname; ?>" class="form-control w-30 edit-show"  placeholder="Last Name"><br class="edit-show">
                                <small class="text-muted">Email address</small>
                                <br>
                                <h4 class="text-show"><?php echo $email; ?></h4> 
                                <input type="text" id="email" class="form-control w-30 edit-show" value="<?php  echo $email; ?>" placeholder="Email address">
                                <small class="text-muted p-t-30 db">Telefono</small>
                                <h4 class="text-show"><?php echo $phone ?></h4>
                                <input type="text" id="phone" class="form-control w-30 edit-show"  value="<?php  echo $phone; ?>" placeholder="Phone">
                                <small class="text-muted p-t-30 db">Dipartimento richiesto</small>
                                <br>
                                <h4 class="text-show"><?php echo $department_name ?></h4>

                                <select  name="department" id="department"  class="form-control w-30 edit-show" >
                                    <option>Seleziona Dipartimento</option>
                                    <?php 
    $sql="SELECT * FROM `tbl_department` WHERE `hotel_id` =  $hotel_id and is_delete = 0 and is_active = 1 and depart_id != 0";
                                    $result = $conn->query($sql);
                                    if ($result && $result->num_rows > 0) {
                                        while($row = mysqli_fetch_array($result)) {

                                            if($row[0]==$depart_id_app){
                                                echo '<option selected  value='.$row[0].'>'.$row[1].'</option>';
                                            }else{
                                                echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                <small class="text-muted p-t-30 db">Messaggio</small>
                                <textarea id="message" type="date" class="form-control  edit-show"  placeholder="Message"><?php echo $message; ?></textarea>
                                <div class="row text-show" >
                                    <div class="col-lg-8 col-xlg-8 col-md-8">
                                        <p>
                                            <?php if($message == ""){ echo "N/A";}else{echo $message;} ?>
                                        </p> 
                                    </div>
                                </div>
                                <small class="text-muted p-t-30 db">Data dell' applicazione</small>
                                <h4><?php echo $application_time;?></h4>
                                <small class="text-muted p-t-30 db">Stato</small>
                                <h4><?php echo $status;?></h4>
                            </div>
                            <div class="col-lg-3 col-xlg-3 col-md-3 text-right text-show">
                                <img src="<?php echo '.'.$image_url; ?>" onerror="this.src='../images/recruiting/no-pic.jpg'"  alt="user" width="100%" height="350" class="shadow-radius"  />
                                <br>
                                <br>
                                <a type="button" onclick="window.print();" href="javascript:void(0)" 
                                   class="btn btn-secondary">
                                    <i class="mdi mdi-printer"></i>Stampa</a>
                            </div>
                            <div class="col-lg-3 col-xlg-3 col-md-3 text-right edit-show">
                                <input type="file" data-default-file="<?php echo '.'.$image_url; ?>" accept="image/png, image/jpeg" id="pic_id" width="100%" height="350" data-show-remove="false" class="dropify" data-max-file-size="2M" />
                            </div>
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>

                            <?php if($resume_url != ""){ ?>
                            <div class="col-lg-11 col-xlg-11 col-md-11 text-show">
                                <a type="button" target="_blank" href="<?php echo '.'.$resume_url ?>" class="btn btn-secondary"><i class="fas fa-arrow-down"></i>Scarica CV</a>
                            </div>
                            <?php }?>
                            <div class="col-lg-11 col-xlg-11 col-md-11 edit-show">
                                <small class="text-muted p-t-30 db">Carica CV</small>
                                <br>
                                <input value ="Upload VC"  accept="application/pdf"  type="file" id="cv_id"  class="upload" name="cv_id" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>
                            <div class="col-lg-5 col-xlg-5 col-md-5">
                                <div class="form-group">
                                    <label class="control-label"><strong>Aggiungi commenti</strong></label>
                                    <textarea type="text" name="comments" id="comments" rows="3" class="form-control" placeholder="Commenti"><?php echo $comments ;?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-5 col-xlg-5 col-md-5">
                                <div class="form-group">
                                    <label class="control-label"><strong>Aggiungere Tags</strong></label>
                                    <div class="tags-default" >
                                        <input type="text" name="tags" id="tags" class="form-control" data-role="tagsinput" placeholder="Tag" value="<?php echo $tags; ?>" > 
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>
                        </div>

                        <?php if($genrated_url != ""){ ?>
                        <div class="row ">
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>
                            <div class="col-lg-10 col-xlg-10 col-md-10">
                                <div class="row heading_style pt-4 pb-4">
                                    <div class="col-lg-12 col-xlg-12 col-md-12 text-center">
                                        <h2 >Job-Ad</h2>
                                    </div>
                                    <div class="col-lg-12 col-xlg-12 col-md-12 ">
                                        <small class="text-muted" >Campaign Name</small>
                                        <br>
                                        <h6><?php echo $name_cam ?></h6>
                                        <small>Source</small>
                                        <br>
                                        <h6><?php echo $sorce_cam ?></h6>
                                        <small>Team</small>
                                        <br>
                                        <h6><?php echo $team_cam ?></h6>
                                        <small>Url</small>
                                        <br>
                                        <h6><?php echo $genrated_url.'&id'.$cam_id ?></h6>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>

                        </div>
                        <?php }?>



                        <div class="row ">
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>
                            <div class="col-lg-10 col-xlg-10 col-md-10 p-4">
                                <div class="container heading_style p-4">
                                    <h1>Funnel</h1>
                                    <?php for ($i = 0; $i < count($questions); $i++) { ?>
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <strong><?php echo $questions[$i]; ?></strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php



                                                                                      $answers = explode('$xvx@', $answer_array[$i]);
                                                                                      if (count($answers) > 1) {
                                                                                          for ($j = 1; $j < count($answers); $j++) {
                                                                                              if (strpos($answers[$j], 'uploads/') !== false) {
                                                                                                  $base_is = '';
                                                                                                  //                                                                                                  $base_is = 'http://localhost/qualityfriend/';
                                                                                                  $base_is = 'https://qualityfriend.solutions/';


                                                                                                  $base_is = $base_is.$answers[$j];
                                                                                                  echo "<a target='_blank' href='$base_is'>
                                                                                                  $base_is</a>";



                                                                                              } else {
                                                                                                  echo '<p>' . $answers[$j] . '</p>';
                                                                                              }


                                                                                          }
                                                                                      } else {
                                                                                          echo '<p>N/A</p>';
                                                                                      }
                                            ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="col-lg-1 col-xlg-1 col-md-1">
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-2 col-xlg-2 col-md-2">

                            </div>


                            <div class="col-lg-2 col-xlg-2 col-md-2">
                                <!-- Rating -->
                                <div class="div">
                                    <label class="control-label"><strong>Competenza sociale</strong></label>
                                    <br>
                                    <?php 
                                    $temp = $SocialCompetence;
                                    for($i =1;$i<=5;$i++){
                                    ?>
                                    <input type="hidden" id="php<?php echo $i?>_hidden" value="<?php echo $i ;?>">
                                    <img src="<?php if($temp <= 0){ echo "../assets/images/star1.png"; }else{ echo "../assets/images/star2.png" ; } ?>" onclick="change(this.id);" id="php<?php echo $i ;?>" class="php">
                                    <?php
                                        $temp = $temp - 1;
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="phprating" id="phprating" value="0">
                            </div>


                            <div class="col-lg-2 col-xlg-2 col-md-2">
                                <!-- Rating -->
                                <div class="div">
                                    <label class="control-label"><strong>Competenza metodica</strong></label>
                                    <br>
                                    <?php 
                                    $temp = $MethodicalCompetence;
                                    for($i =1;$i<=5;$i++){
                                    ?>
                                    <input type="hidden" id="pphp<?php echo $i?>_hidden" value="<?php echo $i ;?>">
                                    <img src="<?php if($temp <= 0){ echo "../assets/images/star1.png"; }else{ echo "../assets/images/star2.png" ; } ?>" onclick="change1(this.id);" id="pphp<?php echo $i ;?>" class="php">
                                    <?php
                                        $temp = $temp - 1;
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="pphprating1" id="pphprating1" value="0">
                            </div>
                            <div class="col-lg-2 col-xlg-2 col-md-2">
                                <!-- Rating -->
                                <div class="div">
                                    <label class="control-label"><strong>Competenza personale</strong></label>
                                    <br>
                                    <?php 
                                    $temp = $PersonalCompetence;
                                    for($i =1;$i<=5;$i++){
                                    ?>
                                    <input type="hidden" id="2php<?php echo $i?>_hidden" value="<?php echo $i ;?>">
                                    <img src="<?php if($temp <= 0){ echo "../assets/images/star1.png"; }else{ echo "../assets/images/star2.png" ; } ?>" onclick="change2(this.id);" id="2php<?php echo $i ;?>" class="php">
                                    <?php
                                        $temp = $temp - 1;
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="2phprating2" id="2phprating2" value="0">
                            </div>
                            <div class="col-lg-1 col-xlg-1 col-md-1">

                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-2 col-xlg-2 col-md-2">
                            </div>
                            <div class="col-lg-2 col-xlg-2 col-md-2">
                                <!-- Rating -->
                                <div class="div">
                                    <label class="control-label"><strong>Competenza Professionale</strong></label>
                                    <br>


                                    <?php 
                                    $temp = $ProfractionalCompetence;
                                    for($i =1;$i<=5;$i++){
                                    ?>
                                    <input type="hidden" id="3php<?php echo $i?>_hidden" value="<?php echo $i ;?>">
                                    <img src="<?php if($temp <= 0){ echo "../assets/images/star1.png"; }else{ echo "../assets/images/star2.png" ; } ?>" onclick="change3(this.id);" id="3php<?php echo $i ;?>" class="php">
                                    <?php
                                        $temp = $temp - 1;
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="3phprating3" id="3phprating3" value="0">
                            </div>
                            <div class="col-lg-2 col-xlg-2 col-md-2">
                                <!-- Rating -->
                                <div class="div">
                                    <label class="control-label"><strong>Competenza generale</strong></label>
                                    <br>
                                    <?php 
                                    $temp = $GeneralCompetence;
                                    for($i =1;$i<=5;$i++){
                                    ?>
                                    <input type="hidden" id="4php<?php echo $i?>_hidden" value="<?php echo $i ;?>">
                                    <img src="<?php if($temp <= 0){ echo "../assets/images/star1.png"; }else{ echo "../assets/images/star2.png" ; } ?>" onclick="change4(this.id);" id="4php<?php echo $i ;?>" class="php">
                                    <?php
                                        $temp = $temp - 1;
                                    }
                                    ?>            
                                </div>
                                <input type="hidden" name="4phprating4" id="4phprating4" value="0">
                            </div>
                            <div class="col-lg-1 col-xlg-1 col-md-1">

                            </div>
                        </div>
                        <!--                        here-->
                        <br>
                    </div>

                    <br>  

                    <div class="row">
                        <div class="col-lg-1 col-xlg-1 col-md-1">
                        </div>
                        <div class="col-lg-10 col-xlg-10 col-md-10">
                            <?php if($status_id != 3){ ?>
                            <input type="submit" onclick="save()"  value="Save" class="btn btn-secondary w-10">
                            <a type="button" onclick="updatestatus(4)" href="javascript:void(0)" class="btn btn-info w-10 ml-3 b-show">Accettare</a>
                            <a type="button" onclick="updatestatus(5)" href="javascript:void(0)" class="btn btn-info w-10 ml-3 b-show">Rifiutare</a>
                            <?php
}
                            ?>
                            <a type="button"  onclick="d()" href="javascript:void(0)" class="btn btn-info w-10 ml-3 b-show">Eliminare</a>
                            <?php if($status_id != 3){ ?>
                            <a onclick="edit()" type="button" href="javascript:void(0)" class="b-show btn btn-info w-10 ml-3">Modificare</a>
                            <a onclick="cancel()" type="button" href="javascript:void(0)" class="btn btn-info w-10 ml-3   b-cancle">Annulla</a>
                            <?php
}
                            ?>
                        </div>
                        <div class="col-lg-1 col-xlg-1 col-md-1">
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

        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script>
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>

        <script src="../assets/node_modules/dropify/dist/js/dropify.min.js"></script>
        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

        <script>

            function edit() {
                var temp = document.getElementsByClassName("edit-show");
                var temp1 = document.getElementsByClassName("text-show");
                var bshow = document.getElementsByClassName("b-show");
                var cancle = document.getElementsByClassName("b-cancle");
                for (let i = 0; i < temp.length; i++) {
                    if(i==0 || i==2 || i==3){
                        temp[i].style.display="inline-block";
                    }else{
                        temp[i].style.display="block";
                    }

                }
                for (let i = 0; i < temp1.length; i++) {
                    temp1[i].style.display="none";
                }
                for (let i = 0; i < bshow.length; i++) {
                    bshow[i].style.display="none";

                }
                for (let i = 0; i < cancle.length; i++) {
                    cancle[i].style.display="inline-block";
                }
            }

            var open = '<?php echo  $open; ?>';

            if(open=="edit"){
                edit();
            }else{

            }

            function cancel() {
                var temp = document.getElementsByClassName("edit-show");
                var temp1 = document.getElementsByClassName("text-show");
                var bshow = document.getElementsByClassName("b-show");
                var cancle = document.getElementsByClassName("b-cancle");
                for (let i = 0; i < temp.length; i++) {
                    temp[i].style.display="none";
                }
                for (let i = 0; i < temp1.length; i++) {
                    temp1[i].style.display="block";
                }
                for (let i = 0; i < bshow.length; i++) {
                    bshow[i].style.display="inline-block";

                }
                for (let i = 0; i < cancle.length; i++) {
                    cancle[i].style.display="none";
                }
            }

        </script>



        <script type="text/javascript">
            function updatestatus(status) {
                var employee_id = <?php echo $employee_id;?>;
                $.ajax({
                    url:'util_update_status.php',
                    method:'POST',
                    data:{ tablename:"tbl_applicants_employee", idname:"tae_id", id:employee_id, statusid:status,statusname: "status_id"},
                    success:function(response){
                        if(response == "Updated"){
                            var message = "";
                            if(status == 4){
                                message = "Accettata"; 
                                Swal.fire({
                                    title: message,
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.replace("employees.php");
                                    }
                                });
                            }
                            if(status == 5){
                                message = "Respinto"; 
                                Swal.fire({
                                    title: message,
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        window.location.replace("applications.php");
                                    }
                                });
                            }

                        }
                        else if (response == "Not Updated"){
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Qualcosa è andato storto!',
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



            function d() {
                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Non sarai in grado di ripristinarlo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, eliminalo!'
                }).then((result) => {
                    if (result.value) {
                        var employee_id = <?php echo $employee_id;?>;
                        $.ajax({
                            url:'util_update_status.php',
                            method:'POST',
                            data:{ tablename:"tbl_applicants_employee", idname:"tae_id", id:employee_id, statusid:1,statusname: "is_delete"},
                            success:function(response){
                                console.log(response);
                                if(response == "Updated"){
                                    Swal.fire({
                                        title: 'Eliminato',
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.replace("applications.php");
                                        }
                                    })
                                }
                                else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Qualcosa è andato storto!',
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

            var SocialCompetencer = <?php echo $SocialCompetence; ?>;
            var MethodicalCompetencer = <?php echo $MethodicalCompetence; ?>;
            var PersonalCompetencer = <?php echo $PersonalCompetence; ?>;
            var ProfractionalCompetencer = <?php echo $ProfractionalCompetence; ?>;
            var GeneralCompetencer = <?php echo $GeneralCompetence; ?>;

            if(SocialCompetencer !=0 ){

                var rating_=SocialCompetencer;
            }else{
                var rating_="0";
            }
            if(MethodicalCompetencer !=0 ){

                var rating1_=MethodicalCompetencer;
            }else{
                var rating1_="0";
            }
            if(PersonalCompetencer !=0 ){

                var rating2_=PersonalCompetencer;
            }else{
                var rating2_="0";
            }
            if(ProfractionalCompetencer !=0 ){

                var rating3_=ProfractionalCompetencer;
            }else{
                var rating3_="0";
            }

            if(GeneralCompetencer !=0 ){

                var rating4_=GeneralCompetencer;
            }else{
                var rating4_="0";
            }
            function change(id)
            {

                rating_="1";
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating_=rating;
                document.getElementById(cname+"rating").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById(cname+i).src="../assets/images/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById(cname+j).src="../assets/images/star1.png";
                }
            }

            function change1(id)
            {
                rating1_="1";
                var cname=document.getElementById(id).className; //php1
                var rating=document.getElementById(id+"_hidden").value; //php2
                rating1_=rating;
                document.getElementById("p"+cname+"rating1").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("p"+cname+i).src="../assets/images/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("p"+cname+j).src="../assets/images/star1.png";
                }
            }

            function change2(id)
            {
                rating2_="1";
                var cname=document.getElementById(id).className; //php2
                var rating=document.getElementById(id+"_hidden").value;
                rating2_=rating;
                document.getElementById("2"+cname+"rating2").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("2"+cname+i).src="../assets/images/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("2"+cname+j).src="../assets/images/star1.png";
                }
            }

            function change3(id)
            {
                rating3_="1";
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating3_=rating;
                document.getElementById("3phprating3").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("3"+cname+i).src="../assets/images/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("3"+cname+j).src="../assets/images/star1.png";
                }
            }
            function change4(id)
            {
                rating4_="1"
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating4_=rating;
                document.getElementById("4phprating4").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("4"+cname+i).src="../assets/images/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("4"+cname+j).src="../assets/images/star1.png";
                }
            }
            function save(){ 
                var mrtitle ;
                var radios = document.getElementsByName('customRadio');
                for (var radio of radios)
                {
                    if (radio.checked) {
                        mrtitle = radio.value;
                    }
                }
                var pre_img_url = <?php echo json_encode($image_url);?>;
                var pre_cv_url = <?php echo json_encode($resume_url);?>;
                var files = $('#pic_id')[0].files;
                var filescv = $('#cv_id')[0].files;

                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('email').value;
                var phone = document.getElementById('phone').value;
                var department_id = document.getElementById('department').value;
                var comments = document.getElementById("comments").value;
                var tags = document.getElementById("tags").value;
                var message = document.getElementById("message").value;
                var SocialCompetence = rating_;
                var MethodicalCompetence = rating1_;
                var PersonalCompetence = rating2_;
                var ProfractionalCompetence = rating3_;
                var GeneralCompetence = rating4_;
                var employee_id = <?php echo $employee_id;?>;
                var status_id = <?php echo $status_id;?>;

                var employee = 0;
                var fd = new FormData();
                var files = $('#pic_id')[0].files;
                var filescv = $('#cv_id')[0].files;
                fd.append('filescv',filescv[0]);
                fd.append('file',files[0]);
                fd.append('mrtitle',mrtitle);
                fd.append('first_name',first_name);
                fd.append('last_name',last_name);
                fd.append('email',email);
                fd.append('phone',phone);
                fd.append('department_id',department_id);
                fd.append('comments',comments);
                fd.append('tags',tags);
                fd.append('message',message);
                fd.append('SocialCompetence',SocialCompetence);
                fd.append('MethodicalCompetence',MethodicalCompetence);
                fd.append('PersonalCompetence',PersonalCompetence);
                fd.append('ProfractionalCompetence',ProfractionalCompetence);
                fd.append('GeneralCompetence',GeneralCompetence);
                fd.append('employee',employee);
                fd.append('status_id',status_id);
                fd.append('pre_img_url',pre_img_url);
                fd.append('pre_cv_url',pre_cv_url);
                fd.append('employee_id',employee_id);
                $.ajax({
                    url:'employeesave.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        console.log(response);
                        if(response == "rating_updated"){
                            Swal.fire({
                                title: 'Il tuo lavoro è stato salvato',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.value) {
                                    location.replace("applications.php");
                                }
                            })
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Qualcosa è andato storto!',
                                footer: ''
                            });

                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
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
                var drEvent = $('#pic_id1').dropify();

                drEvent.on('dropify.beforeClear', function(event, element) {
                    console.log("File deleted");
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });
                drEvent.on('dropify.afterClear', function(event, element) {
                    alert('File deleted');
                    console.log("File deleted");
                });
                drEvent.on('dropify.errors', function(event, element) {
                    console.log('Has Errors');

                });
                var drDestroy = $('#pic_id1').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e) {
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        console.log("File deleted");
                        drDestroy.destroy();
                    } else {
                        console.log("File deleted");    
                        drDestroy.init();
                    }
                })
            });
        </script>





    </body>

</html>