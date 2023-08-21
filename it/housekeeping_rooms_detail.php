<?php
include 'util_config.php';
include '../util_session.php';

$rms_id = 0;
$rmrs_id = 0;
//room;
$room_number = "";
$room_name = "";
//task
$room_task_array = array ();
$room_checklist_array =  array();
$room_checklist_completed_array =  array();
$room_checklist_id_array =  array();
$size_of_task = 0;


$room_arrival_checklist_array =  array();
$room_arrival_checklist_completed_array =  array();
$room_arrival_checklist_id_array =  array();
//housekeeping
$assign_to = "";
$room_status = "Unassigned";
$presence_status = "None";
$cleaning_frequency = "None";
$cleaning_day = "";
$cleaning_date ="";
$is_completed = "";
$is_urgent = 0;
$is_breakfast = 0;
$is_presence_status = 0;
$assgin_date = "";
$last_cleaning_date = "";
//reservation
$arrival =    "N/A";
$departure = "N/A";
$days = 0;
$num_of_people = 0;
$vip = "N/A";
$k1_0_3 = 0;
$k2_3_8 = 0;
$k3_8_14 = 0;
$note = "";
$note_it = "";
$note_de = "";
$current_date =  date('Y-m-d');
$today_is = "";


$vip = "";
$stays = "";
$booking_group = "";
$offer = "";
$annotation = "";
$guest_language = "N/A";
$days_between = "N/A";

//guest
$guest_name_array =  array  ();
$guest_dob_array =  array  ();
$size_of_guest_name = 0;



if(isset($_GET['id'])){
    $rms_id = $_GET['id'];

    if(isset($_GET['rmrs_id'])){
        $rmrs_id = $_GET['rmrs_id'];
    }
    //getRoomDetail
    $sql_room="SELECT * FROM `tbl_rooms` WHERE `rms_id` =  $rms_id";
    $result_room = $conn->query($sql_room);
    if ($result_room && $result_room->num_rows > 0) {
        while($row_room = mysqli_fetch_array($result_room)) {
            $room_number = $row_room['room_num'];
        }
    }
    //getRoomTask
    $sql_task="SELECT * FROM `tbl_housekeeping_task` WHERE `room id` = $rms_id AND `hotel_id` = $hotel_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $task_name = $row_task['task'];
            array_push($room_task_array,$task_name);

        }
    }
    $size_of_task = sizeof($room_task_array);






    //getRoomChecks
    $sql_task="SELECT * FROM `tbl_room_check`  WHERE `room_id`= $rms_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $room_check_id = $row_task['room_check_id'];
            $checklist = $row_task['checklist'];
            $complate = $row_task['is_completed'];
            array_push($room_checklist_id_array,$room_check_id);
            array_push($room_checklist_array,$checklist);
            array_push($room_checklist_completed_array,$complate);
        }
    }
    $size_of_checklist = sizeof($room_checklist_array);


    //getRoomArrivalChecks
    $sql_task="SELECT * FROM `tbl_room__arrival_check`  WHERE `room_id`= $rms_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $room_check_id = $row_task['rac_id'];
            $checklist = $row_task['checklist'];
            $complate = $row_task['is_completed'];
            array_push($room_arrival_checklist_id_array,$room_check_id);
            array_push($room_arrival_checklist_array,$checklist);
            array_push($room_arrival_checklist_completed_array,$complate);
        }
    }

    $size_of_arrival_checklist = sizeof($room_arrival_checklist_array);








    //gethousekeepingdata
    $sql_housekeeping="SELECT * FROM `tbl_housekeeping` WHERE `room_id` = $rms_id AND `hotel_id` =  $hotel_id";
    $result_housekeeping = $conn->query($sql_housekeeping);
    if ($result_housekeeping && $result_housekeeping->num_rows > 0) {
        while($row_housekeeping = mysqli_fetch_array($result_housekeeping)) {            
            $assign_to =    $row_housekeeping['assign_to'];
            $room_status = $row_housekeeping['room_status'];
            $presence_status = $row_housekeeping['presence_status'];
            $cleaning_frequency = $row_housekeeping['cleaning_frequency'];
            $cleaning_day = $row_housekeeping['cleaning_day'];
            $cleaning_date = $row_housekeeping['cleaning_date'];
            $is_completed = $row_housekeeping['is_completed'];
            $is_urgent = $row_housekeeping['is_urgent'];
            $is_breakfast = $row_housekeeping['is_breakfast'];
            $do_need_to_clean = $row_housekeeping['do_need_to_clean'];



            $do_need_to_clean_save =  $do_need_to_clean;
            
            if($do_need_to_clean == 0){
                $do_need_to_clean = "";
            }else{
                $do_need_to_clean = "checked";
            }
            if($presence_status == 0){
                $is_presence_status = "";
            }else{
                $is_presence_status = "checked";
            }


            if($is_breakfast == 0){
                $is_breakfast = "";
            }else{
                $is_breakfast = "checked";
            }

            if($is_urgent == 0){
                $is_urgent = "";
            }else{
                $is_urgent = "checked";
            }
            $assgin_date = $row_housekeeping['assgin_date'];
            $last_cleaning_date = $row_housekeeping['last_cleaning_date'];





            $is_breakfast_a      =    $row_housekeeping["is_breakfast"];
            if($room_status == "Dirty"){

                if($do_need_to_clean_save == 1){

                    $room_is = "room_dirty";
                }else{
                    $current_date =   date("Y-m-d");


                    //                            get today clean

                    $sql_housekeeping="SELECT * FROM `tbl_housekeeping_clraning_dates` WHERE  `rmrs_id` = '$rmrs_id' AND `date` = '$current_date'";
                    $result_housekeeping = $conn->query($sql_housekeeping);
                    $i = 0;
                    $room_is = "";


                    if ($result_housekeeping && $result_housekeeping->num_rows > 0) {
                        while($row_housekeeping = mysqli_fetch_array($result_housekeeping)) {
                        }

                        $room_is = "room_dirty";

                    }else {


                        $room_is = "room_no_cleaning_today";
                    }
                }
            }else  if($room_status == "Clean"){

                $room_is = "room_clean";
            }else  if($room_status == "Unassigned"){

                $room_is = "room_unassigned";
            }else  if($room_status == "Cleaning_in_progress"){

                $room_is = "room_cleaning_in_progress";
            }else  if($room_status == "Inspection_in_progress"){

                $room_is = "room_inspection_in_progress";
            }else  if($room_status == "Inspected"){

                $room_is = "room_inspected";
            }else  if($room_status == "No_cleaning_desired"){

                $room_is = "room_no_cleaning_desired";
            }

            //            if($is_breakfast_a == 1) {
            //                $room_is = "breakfast"; 
            //            }
        }
    }

    $guest_language = "N/A";
    $days_between = "N/A";
    //get_reservation
    $sql_reservation = "SELECT * FROM `tbl_room_reservation`  WHERE `rmrs_id` = $rmrs_id and `hotel_id` = $hotel_id";
    $result_reservation = $conn->query($sql_reservation);
    if ($result_reservation && $result_reservation->num_rows > 0) {
        while($row_reservation = mysqli_fetch_array($result_reservation)) {            
            $arrival =    $row_reservation['arrival'];
            $departure = $row_reservation['departure'];

            $arrival_date = date('Y-m-d', strtotime($arrival));
            $departure_date = date('Y-m-d', strtotime($departure));

            $start = strtotime($arrival_date);
            $end = strtotime($departure_date);

            $days_between = ceil(abs($end - $start) / 86400);

            if($arrival_date == $current_date){
                $today_is ="arrival";
            }else{

            }


            $num_of_people = $row_reservation['num_of_people'];
            $vip = $row_reservation['vip'];
            $k1_0_3 = $row_reservation['k1_0_3'];
            $k2_3_8 = $row_reservation['k2_3_8'];
            $k3_8_14 = $row_reservation['k3_8_14'];
            $note = $row_reservation['birthday_note'];
            $note_it = $row_reservation['birthday_note_it'];
            $note_de = $row_reservation['birthday_note_de'];
            $days = $row_reservation['days'];



            $vip = $row_reservation['vip'];
            $stays = $row_reservation['stays'];
            $booking_group = $row_reservation['booking_group'];
            $offer = $row_reservation['offer'];
            $annotation = $row_reservation['annotation'];

            if($guest_language != ""){
                $guest_language = $row_reservation['language']; 

            }





        }
    }


    $current_date =   date("Y-m-d"); 
    //get_guest
    $sql_guest = "SELECT * FROM `tbl_housekeeping_guest` WHERE  `room_id` =  $rms_id and `rmrs_id` = $rmrs_id";
    $result_guest = $conn->query($sql_guest);
    if ($result_guest && $result_guest->num_rows > 0) {
        while($row_guest = mysqli_fetch_array($result_guest)) {            
            $guest_name =    $row_guest['name'];
            $guest_dob =    $row_guest['dob'];
            array_push($guest_name_array,$guest_name);


            $guest_dob_onlymonth=date('m-d', strtotime($guest_dob));
            $arrival_date = date('Y-m-d', strtotime($arrival));
            $departure_date = date('Y-m-d', strtotime($departure));

            $arrival_date_only_month = date('m-d', strtotime($arrival));
            $departure_date_only_month = date('m-d', strtotime($departure));








            if (($guest_dob_onlymonth >= $arrival_date_only_month) && ($guest_dob_onlymonth <= $departure_date_only_month)){
                array_push($guest_dob_array,$guest_name." : ".$guest_dob);
            }else{

            }
        }
    }

}
$size_of_guest_name = sizeof($guest_name_array);
$size_of_guest_dob = sizeof($guest_dob_array);

$totel_person = $num_of_people +  $k1_0_3 + $k2_3_8 + $k3_8_14 ;



//get assign user details
$cleanner_image_url =  "";
$cleanner_user_id_a =   "";
$cleanner_firstname =   "Not Assigned";
$cleanner_lastname =   "";
$sql_user="SELECT * FROM `tbl_user`  WHERE  user_id = '$assign_to'";
$result_user = $conn->query($sql_user);

if ($result_user && $result_user->num_rows > 0) {
    $i=1;
    while($row = mysqli_fetch_array($result_user)) {

        $cleanner_image_url =   $row['address'];
        $cleanner_user_id_a =   $row['user_id'];
        $cleanner_firstname =   $row['firstname'];
        $cleanner_lastname =   $row['lastname'];
    }}
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
        <title>Housekeeping Dettaglio</title>
        <!-- Footable CSS -->
        <link href="../assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/switchery/dist/switchery.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="../assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
        <link href="../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="../assets/node_modules/summernote/dist/summernote.css" rel="stylesheet" />
        <link href="../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <!-- Dropzone css -->
        <link href="../assets/node_modules/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="../assets/node_modules/dropify/dist/css/dropify.min.css">


        <link href="styles/multiselect.css" rel="stylesheet"/>
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/housekeeping.css" rel="stylesheet">
        <script src="multiselect.min.js"></script>

    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Housekeeping Dettaglio</p>
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
                    <div class=" row page-titles mobile-container-padding heading_style">
                        <div class="col-md-4 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Housekeeping Dettaglio</h4>
                        </div>
                        <div align="center" class="col-md-4">
                            <h2><b><?php echo $room_number;?></b></h2>
                        </div>
                        <div class="col-md-4 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Faccende domestiche</a></li>
                                    <li class="breadcrumb-item text-success">Particolare della stanza delle pulizie</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->

                    <div  class="row div-white-background pointer room_text_center pt-3 pb-3 ml-1 mr-1 mt-2 divacb"  accesskey="">

                        <div align="left" class="col-12">
                            <h4><img src="<?php echo '../'.$cleanner_image_url; ?>" onerror="this.src='../assets/images/users/user.png'"  alt="user" width="35" height="35" class="rounded-circle"  /> 
                                &nbsp;&nbsp; <b><?php echo $cleanner_firstname; ?></b>
                            </h4>
                        </div>
                        <div align="left" class="col-3">
                            <span>Cleaner</span>
                        </div>
                    </div>
                    <div id="color_change" class="row heading_style pt-2 pb-2 <?php echo $room_is; ?> white_text">
                        <div class="col-lg-2  col-sm-2 " > 
                            <div class="checkbox checkbox-success mt-2">
                                <input   <?php echo $is_breakfast;?>  onchange="update_room_status('breakfast')" id="breakfast" type="checkbox" class="checkbox-size-20 pt-2">
                                <label class="font-weight-title pl-2 mb-2">Colazione</label>
                            </div>
                        </div>
                        <div class="col-lg-2  col-sm-2 " > 
                            <div class="checkbox checkbox-success mt-2">
                                <input   <?php echo $is_urgent;?>  onchange="update_room_status('active_id')" id="active_id" type="checkbox" class="checkbox-size-20 pt-2">
                                <label class="font-weight-title pl-2 mb-2">Urgente</label>
                            </div>

                        </div>
                        <div class="col-lg-4  col-sm-4"  >
                            <select  onchange="update_room_status('room_status')" id="room_status" class="form-control custom-select" style="width: 100%">
                                <option value="Unassigned"  >Non assegnato</option>
                                <option value="Dirty" >Sporca</option>
                                <option value="Cleaning_in_progress">Pulizia in corso</option>
                                <option value="Clean" >Pulita</option>
                                <option value="Inspection_in_progress" >Ispezione in corso</option>
                                <option value="Inspected" >Ispezionata</option>
                                <option value="No_cleaning_desired" >Nessuna pulizia desiderata</option>
                            </select>
                        </div>
                        <div class="col-lg-2  col-sm-2 " >
                            <div class="checkbox checkbox-success mt-2">
                                <input   <?php echo $is_presence_status;?>  onchange="update_room_status('presence_status')" id="presence_status" type="checkbox" class="checkbox-size-20 pt-2">
                                <label class="font-weight-title pl-2 mb-2">Non disturbare</label>
                            </div>
                        </div>


                        <div class="col-lg-2  col-sm-2 " >
                            <div class="checkbox checkbox-success mt-2">
                                <input   <?php echo $do_need_to_clean;?>  onchange="update_room_status('do_need_to_clean')" id="do_need_to_clean" type="checkbox" class="checkbox-size-20 pt-2">
                                <label class="font-weight-title pl-2 mb-2">Everyday Cleaned</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="col-lg-4  col-sm-4  " >
                            <div class="row room_detail_box mt-2 p-3" >
                                <div class="col-lg-2 black_text center_div center_div1" >
                                    <img src="../assets/images/Todo.png" onerror="this.src='../assets/images/Todo.png'"  alt="user" width="35" height="35" />   
                                </div>
                                <div  align="left" class="col-lg-10 center_div1 room_task_header minus_padding" >
                                    <?php if($today_is == "arrival"){
    echo "Checks arrivi";
}else{

    echo "Checks rimanenti";
} ?>
                                </div>

                                <?php if($today_is == "arrival"){
                                ?>

                                <?php if($size_of_arrival_checklist == 0){
                                ?>
                                <div class="col-lg-12 black_text pt-1 pl-3" >
                                    None
                                </div>
                                <?php }  else {

                                    for ($x = 0; $x < $size_of_arrival_checklist; $x++) {
                                ?>
                                <div class="col-lg-11 black_text pt-1 pl-3" >
                                    <?php echo $room_arrival_checklist_array[$x]; ?>
                                </div>
                                <div class="col-lg-1 col-xlg-1 col-md-1"> 
                                    <div class="checkbox checkbox-success">
                                        <input name="lineup2"  onclick="check_listfa('<?php echo $room_arrival_checklist_id_array[$x]; ?>','<?php echo"check_list_arrival_".$x ?>')" id="check_list_arrival_<?php echo $x; ?>" type="checkbox" class="checkbox-size-20 check_box_c" <?php if($room_arrival_checklist_completed_array[$x] == 1 ) {
                                    echo "checked";
                                }?> >
                                    </div>
                                </div>
                                <?php } }?>



                                <?php


}else{
                                ?>
                                <?php if($size_of_checklist == 0){
                                ?>
                                <div class="col-lg-12 black_text pt-1 pl-3" >
                                    None
                                </div>
                                <?php }  else {

                                    for ($x = 0; $x < $size_of_checklist; $x++) {
                                ?>
                                <div class="col-lg-11 black_text pt-1 pl-3" >
                                    <?php echo $room_checklist_array[$x]; ?>
                                </div>
                                <div class="col-lg-1 col-xlg-1 col-md-1"> 
                                    <div class="checkbox checkbox-success">
                                        <input name="lineup2"  onclick="check_listf('<?php echo $room_checklist_id_array[$x]; ?>','<?php echo"check_list_".$x ?>')" id="check_list_<?php echo $x; ?>" type="checkbox" class="checkbox-size-20 check_box_c" <?php if($room_checklist_completed_array[$x] == 1 ) {
                                    echo "checked";
                                }?> >
                                    </div>
                                </div>
                                <?php } }?>


                                <?php
} ?>


                            </div>
                        </div>
                        <div class="col-lg-4  col-sm-4 " >
                            <div class="row room_detail_box mt-2 p-3" >
                                <div class="col-lg-2 black_text center_div center_div1" >
                                    <img src="../assets/images/geast_bad.png" onerror="this.src='../assets/images/geast_bad.png'"  alt="user" width="35" height="35" />   
                                </div>
                                <div class="col-lg-10 center_div1 room_task_header minus_padding" >
                                    Rimanere
                                </div>
                                <div class="line pt-2"></div>
                                <div class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6>Arrivo</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6><?php echo $arrival; ?></h6>
                                </div>
                                <div class="line"></div>

                                <div class="col-lg-6 black_text  pt-2" >
                                    <h6>Partenza</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $departure; ?></h6>
                                </div>
                                <div class="line"></div>
                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>Pernottamenti</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $days_between; ?></h6>
                                </div>
                                <div class="line"></div>
                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>Movimenti quotidiani</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6>Today 12:00</h6>
                                </div>

                            </div>
                            <div class="row room_detail_box p-3 mt-1" >
                                <div class="col-lg-2 black_text center_div center_div1" >
                                    <img src="../assets/images/people.png" onerror="this.src='../assets/images/people.png'"  alt="user" width="35" height="35" />   
                                </div>
                                <div class="col-lg-10 center_div1 room_task_header minus_padding" >
                                    Persone 
                                </div>
                                <div class="line pt-2"></div>
                                <div class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6>Ad</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6><?php echo $num_of_people; ?></h6>
                                </div>

                                <div class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6>0-3</h6>
                                </div>
                                <div align="right" class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6><?php echo $k1_0_3; ?></h6>
                                </div>

                                <div class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6>3-8</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6><?php echo $k2_3_8; ?></h6>
                                </div>

                                <div class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6>8-14</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6><?php echo $k3_8_14; ?></h6>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4  col-sm-4 " >
                            <div class="row room_detail_box mt-2 p-3" >
                                <div class="col-lg-2 black_text center_div center_div1" >
                                    <img src="../assets/images/person.png" onerror="this.src='../assets/images/person.png'"  alt="user" width="35" height="35" />   
                                </div>
                                <div class="col-lg-10 center_div1 room_task_header minus_padding" >
                                    Ospite
                                </div>
                                <div class="line pt-2"></div>
                                <div class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6>Nome</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text div_v_a mt-2" >
                                    <h6><?php if($size_of_guest_name != 0 ){
    echo $guest_name_array[0]; } else {echo "N/A";} ?></h6>
                                </div>
                                <div class="line"></div>

                                <div class="col-lg-6 black_text  pt-2" >
                                    <h6>Lingua</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $guest_language; ?></h6>
                                </div>
                                <div class="line"></div>
                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>VIP</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php  echo $vip; ?></h6>
                                </div>
                                <div class="line"></div>
                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>Soggiorni</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $stays; ?></h6>
                                </div>
                                <div class="line"></div>

                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>Gruppo di prenotazione</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $booking_group; ?></h6>
                                </div>
                                <div class="line"></div>
                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>Offerta</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $offer; ?></h6>
                                </div>
                                <div class="line"></div>
                                <div class="col-lg-6 black_text pt-2" >
                                    <h6>Annotazione</h6>

                                </div>
                                <div align="right" class="col-lg-6 black_text pt-2" >
                                    <h6><?php echo $annotation; ?></h6>
                                </div>

                            </div>
                            <div class="row room_detail_box p-3 mt-1 mbm-20" >
                                <div class="col-lg-2 black_text center_div center_div1" >
                                    <img src="../assets/images/birthday.png" onerror="this.src='../assets/images/birthday.png'"  alt="user" width="35" height="35" />   
                                </div>
                                <div class="col-lg-10 center_div1 room_task_header minus_padding" >
                                    Compleanni 
                                </div>
                                <div class="line pt-2"></div>
                                <?php if($size_of_guest_dob == 0){ ?>
                                <div class="col-lg-12 black_text div_v_a mt-2" >
                                    <h6>Nessun compleanno in questo soggiorno</h6>

                                </div>
                                <?php }else {  for ($x = 0; $x < $size_of_guest_dob; $x++) {?>
                                <div class="col-lg-12 black_text div_v_a mt-2" >
                                    <h6><?php echo $guest_dob_array[$x]; ?></h6>

                                </div>
                                <?php } }?>
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
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script>
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
        <script src="../assets/node_modules/summernote/dist/summernote.min.js"></script>


        <!--Custom dropzone -->
        <script src="../assets/node_modules/dropzone-master/dist/dropzone.js"></script>


        <script src="../assets/node_modules/dropify/dist/js/dropify.min.js"></script>
        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
        <script src="./assets/node_modules/moment/moment.js"></script>
        <script src=".../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

        <script>
            var rms_id = <?php echo $rms_id; ?>; 
            var rmrs_id = <?php echo $rmrs_id; ?>; 
            var room_status_select = '<?php echo $room_status; ?>'; 
            $('#room_status').val(room_status_select);


            function check_listf(id,view_id) {

                console.log(view_id);

                let get_id = document.getElementById(view_id).checked;
                var check = 0;
                if(get_id == true){
                    check = 1;
                }else {
                    check = 0;
                }

                let active_id=document.getElementById("active_id").checked;
                var priority = 0;
                if(active_id == true){
                    priority = 1;
                }else {
                    priority = 0;
                }
                $.ajax({
                    url:'../housekeeping_utills/utill_update_room_checklist.php',
                    method:'POST',
                    data:{ id:id,check:check},
                    success:function(response){
                        console.log(response);

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }


            function check_listfa(id,view_id) {

                console.log(view_id);

                let get_id = document.getElementById(view_id).checked;
                var check = 0;
                if(get_id == true){
                    check = 1;
                }else {
                    check = 0;
                }


                $.ajax({
                    url:'../housekeeping_utills/utill_update_room_checklist.php',
                    method:'POST',
                    data:{ id:id,check:check,from:"from"},
                    success:function(response){
                        console.log(response);

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }



            function update_room_status(call) {
                var color_change  = document.getElementById('color_change');
                var room_status =     document.getElementById('room_status').value;
                var presence_status =  document.getElementById("presence_status").checked;
                var Urgent= document.getElementById("active_id").checked;
                var breakfast=document.getElementById("breakfast").checked;

                var do_need_to_clean =  document.getElementById("do_need_to_clean").checked;
                if(do_need_to_clean == false){
                    do_need_to_clean = 0;
                }else{
                    do_need_to_clean = 1  ;
                }

                var   room_is  = '<?php echo $room_is; ?>';
                if(breakfast == false){
                    breakfast = 0;
                }else{
                    breakfast = 1  ;
                }

                color_change.classList.remove('room_unassigned');
                color_change.classList.remove('room_dirty');
                color_change.classList.remove('room_clean');
                color_change.classList.remove('room_inspection_in_progress');
                color_change.classList.remove('room_inspected');
                color_change.classList.remove('room_no_cleaning_desired');
                color_change.classList.remove('breakfast');

                if(room_status == "Unassigned" ){
                    color_change.classList.add('room_unassigned');
                } else if (room_status == "Dirty"){
                    color_change.classList.add('room_dirty');
                }
                else if (room_status == "Cleaning_in_progress"){
                    color_change.classList.add('room_cleaning_in_progress');
                }
                else if (room_status == "Clean"){
                    color_change.classList.add('room_clean');

                }else if (room_status == "Inspection_in_progress") {
                    color_change.classList.add('room_inspection_in_progress');
                }else if (room_status == "Inspected") {
                    color_change.classList.add('room_inspected');
                }else if (room_status == "No_cleaning_desired") {
                    color_change.classList.add('room_no_cleaning_desired');
                }
                //
                var check_diff = "0";
                if(room_status_select == room_status ){
                    check_diff  = "0" ;
                }else {
                    if(room_status == "Clean" ){
                        check_diff  = "1" ;
                    }else {
                        check_diff  = "0" ;
                    }
                }
                if(Urgent == false){
                    Urgent = 0;
                }else{
                    Urgent = 1  ;
                }

                if(presence_status == false){
                    presence_status = 0;
                }else{
                    presence_status = 1;
                }
                console.log(presence_status);
                $.ajax({
                    url:'../housekeeping_utills/util_update_housekeeping_status.php',
                    method:'POST',
                    data:{ rms_id:rms_id,check_diff:check_diff, rmrs_id:rmrs_id,room_status:room_status,presence_status:presence_status,Urgent:Urgent,breakfast:breakfast,do_need_to_clean,do_need_to_clean},
                    success:function(response){
                        console.log(response);
                        location.reload();

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


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
    </body>
</html>