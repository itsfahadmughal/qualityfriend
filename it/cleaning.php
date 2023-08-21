<?php
include 'util_config.php';
include '../util_session.php';
$unique_floor_id = array();
$unique_floor_number = array();
$sql="SELECT * FROM `tbl_floors` WHERE `hotel_id` =  $hotel_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($unique_floor_id,$row['floor_id']);
    array_push($unique_floor_number,$row['floor_num']);
}
$floor_array_lenth = sizeof($unique_floor_id);
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
        <title>Housekeepinge</title>
        <!-- Footable CSS -->
        <link href="../assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <link href="../dist/css/housekeeping.css" rel="stylesheet">
        <link href="../assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Pulizia</p>
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
                <div class="container-fluid" id="mcontainer">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles mobile-container-padding heading_style">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Piani giornalieri</h4>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-3 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Faccende domestiche</a></li>
                                    <li class="breadcrumb-item text-success">Piani giornalieri</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row pr-4 mobile-container-padding">
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('housekeeping.php');">
                                <img src="../dist/images/housekeeping.png" />
                                <h6 class="text-white pt-2">Housekeeping</h6>
                            </div>
                        </div>
                        <?php if($housekeeping_admin == 1){ ?> 
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background-active text-center padding-top-8" onclick="redirect_url('cleaning.php');">
                                <img src="../dist/images/dailyplan.png" />
                                <h6 class="text-white pt-2">Piani giornalieri</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('housekeeping_settings.php');">
                                <img src="../dist/images/settings.png" />
                                <h6 class="text-white pt-2">Impostazioni</h6>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->



                    <div class="row pl-3 pr-3  pt-3 pb-3">

                        <!--                        For date-->



                        <!-- Add Contact Popup Model -->
                        <div id="add-datepicker" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Assegna data</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <div class="col-md-12 m-b-20 mt-2">
                                                        <div  id="" class="form-group ">
                                                            <input value="<?php echo date("Y-m-d"); ?>"  type="date" class="form-control" id="extra_job_date" placeholder="">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 m-b-20 mt-2">
                                                        <div  id="" class="form-group ">
                                                            <input hidden type="text" class="form-control" id="h_cleaner_id" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 m-b-20 mt-2">
                                                        <div  id="" class="form-group ">
                                                            <input hidden  type="text" class="form-control" id="h_extra_job_id" placeholder=""> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 m-b-20 mt-2">
                                                        <div  id="" class="form-group ">
                                                            <input hidden  type="text" class="form-control" id="h_div_id" placeholder=""> 
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </from>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info waves-effect"  onclick="extrajob_add()" data-dismiss="modal">Salva</button>
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Annulla</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>





                        <div  id="permanently_div" class="col-lg-12  col-md-12  display_none">
                            <div class="row div-white-background p-3 mb-3" >
                                <div  id="" class="col-lg-4  col-md-4  pt-2">
                                    <h4>Vuoi assegnare una stanza all'addetto alle pulizie in modo permanente?</h4>
                                </div>
                                <div id="" class="col-lg-3  col-md-3  pt-2">
                                    <div class="custom-control custom-radio inline-div mr-3 b-cancle">
                                        <input value="Permanently" type="radio"  id="yes" name="permanently" class="custom-control-input btn-info"  checked>
                                        <label class="custom-control-label" for="yes">SÌ.</label>
                                    </div>
                                    <div class="custom-control custom-radio inline-div mr-3 b-cancle">
                                        <input value="One_Day" type="radio"  id="for_toay" name="permanently" class="custom-control-input btn-info"  >
                                        <label class="custom-control-label" for="for_toay">Solo per oggi</label>
                                    </div>
                                </div>
                                <div class="col-lg-1 pt-2">
                                    <h4>Lavoro extra</h4>
                                </div>
                                <div class="col-lg-2 pt-1 wm-80">
                                    <div class="input-group">
                                        <input type="text" style="border:1px solid #00BCEB" id="date_is" class="form-control" value="<?php echo date("l j F Y"); ?>" >
                                        <div class="input-group-append">
                                            <span  class="input-group-text" style="background-color:#00BCEB;border:1px solid #00BCEB" ><i class="icon-calender" style="background-color:white"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 pt-1 wm-20" >

                                    <button id="submit"  type="button" onclick="filter()" class="btn btn-secondary">Filtro</button>
                                    <div  id="" class="form-group ">
                                        <input  hidden type="text" class="form-control" id="h_selected_user" placeholder=""> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="housekeeping_cleaner" class="col-lg-6  col-md-6 pr-4 prm-10px">
                            <div class="row div-background pt-3 pb-4" >
                                <div  id="" class="col-lg-12  col-md-12">
                                    <h3>Housekeeper</h3>
                                </div>
                                <?php 
                                $div_id =0;
                                $sql="SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id  ORDER BY `tbl_user`.`user_id` DESC";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    $i=1;
                                    while($row = mysqli_fetch_array($result)) {
                                        $extra_completed = 0;
                                        $image_url =   $row['address'];
                                        $user_id_a =   $row['user_id'];
                                        $firstname =   $row['firstname'];
                                        $lastname =   $row['lastname'];
                                        $email = $row['email'];
                                        $tag = $row['tag'];
                                        $depart_id = $row['depart_id'];
                                        $state = $row['state'];
                                        $usert_id_ = $row['usert_id'];
                                        $is_active = $row['is_active'];
                                        $current_date =   date("Y-m-d");
                                        if( $is_active == 1){
                                            $active = "Active";
                                        }else {
                                            $active = "Deactive";
                                        }
                                        $user_type = "";
                                        $depart_name = "";
                                        $sql2="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id and usert_id = $usert_id_ and is_delete = 0) OR `hotel_id` =  0";
                                        $result2 = $conn->query($sql2);
                                        if ($result2 && $result2->num_rows > 0) {
                                            while($row2 = mysqli_fetch_array($result2)) {
                                                $user_type = $row2['user_type'];
                                            }
                                        }
                                        $housekeeping_assign = 0;
                                        $user_type_id = $row['usert_id'];
                                        $sql12="SELECT * FROM `tbl_rules`  WHERE `usert_id` = $user_type_id";
                                        $result12 = $conn->query($sql12);
                                        if ($result12 && $result12->num_rows > 0) {
                                            while($row12 = mysqli_fetch_array($result12)) {
                                                $housekeeping_assign =$row12['rule_13'];
                                            } 
                                        }
                                        if($housekeeping_assign == 1 && $usert_id_ != 1 ){
                                            //                                            $sql_housekeeping_extra_job = "SELECT  a.*,b.time FROM `tbl_ housekeeping_extra_jobs` AS a INNER JOIN tb_time_interval as b ON a.`time_to_complate` =  b.ti_id Where   a.user_id =  $user_id_a AND a.is_delete = 0";

                                            $current_date = date("Y-m-d");
                                            $sql_housekeeping_extra_job = "SELECT  a.hkej_id,a.job_title,b.time,c.`is_completed`,c.id as complate_id FROM `tbl_ housekeeping_extra_jobs` AS a INNER JOIN tb_time_interval as b ON a.`time_to_complate` =  b.ti_id INNER JOIN `tbl_ housekeeping_extra_jobs_completed_check` as c ON a.`hkej_id` = c.extra_job_id Where   c.assign_to =  $user_id_a AND a.is_delete = 0 AND c.assign_date = '$current_date'";

                                            $extra_completed = 0;
                                            $totel_extra_time = 0 ;
                                            $totl_extra_completed_time = 0;
                                            $extra_job_time_array =  array();
                                            $extra_title_array =  array();
                                            $extra_completed_array =  array();
                                            $result_extra_job = $conn->query($sql_housekeeping_extra_job);
                                            if ($result_extra_job && $result_extra_job->num_rows > 0) {
                                                while($row_extra_job = mysqli_fetch_array($result_extra_job)) {
                                                    $extra_time = $row_extra_job['time'];
                                                    $extra_completed = $row_extra_job['is_completed'];
                                                    $job_title       = $row_extra_job["job_title"]; 
                                                    array_push($extra_job_time_array,$extra_time);
                                                    array_push($extra_title_array,$job_title);

                                                    array_push($extra_completed_array,$extra_completed);




                                                    $totel_extra_time = $totel_extra_time + $extra_time;
                                                    if($extra_completed == 1){
                                                        $totl_extra_completed_time = $totl_extra_completed_time + $extra_time;
                                                    }

                                                }}


                                            $time_to_CN = $time_to_CD = $time_to_FC =0;
                                            $total_time = $totel_extra_time;
                                            $total_completed_time = $totl_extra_completed_time;
                                            $percentage_completed = 0;
                                            $room_number_array = array();
                                            $time_to_CN_array = array();
                                            $sql2="SELECT b.room_status,a.rms_id,b.cleaning_date,b.do_need_to_clean, a.room_cat_id,a.room_num,c.time_to_CN,c.time_to_CD,
                                            c.time_to_FC,c.time_to_EC FROM tbl_rooms as a INNER JOIN tbl_housekeeping as b ON a.`rms_id`= b.`room_id` INNER JOIN tbl_room_category as c ON a.room_cat_id = c.room_cat_id WHERE b.assign_to = $user_id_a and a.is_delete = 0 ORDER BY a.`room_num` ASC";
                                            $result2 = $conn->query($sql2);
                                            if ($result2 && $result2->num_rows > 0) {
                                                while($row2 = mysqli_fetch_array($result2)) {
                                                    $room_status = $row2['room_status'];
                                                    $rms_id = $row2['rms_id'];
                                                    $cleaning_date = $row2['cleaning_date'];
                                                    $do_need_to_cleand = $row2['do_need_to_clean'];
                                                    $arrival = "";
                                                    $sql_reservation="SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  `arrival` <= '$current_date' AND `departure`   >= '$current_date'";
                                                    $result_reservation = $conn->query($sql_reservation);
                                                    if ($result_reservation && $result_reservation->num_rows > 0) {
                                                        while($row_reservation = mysqli_fetch_array($result_reservation)) {
                                                            $rmrs_id = $row_reservation["rmrs_id"];
                                                            $arrival = "Arrival";
                                                            $arrival_date = $row_reservation["arrival"];
                                                            $departure = "Departure";
                                                            $departure_date = $row_reservation["departure"];
                                                        }
                                                    }
                                                    if($arrival != ""){
                                                        $current_date = date("Y-m-d");
                                                        $time_to_CN = $row2['time_to_CN'];
                                                        $time_to_CD = $row2['time_to_CD'];
                                                        $time_to_FC = $row2['time_to_FC'];
                                                        $time_to_EC = $row2['time_to_EC'];

                                                        if($do_need_to_cleand == 1){

                                                        }else{
                                                            $current_date =   date("Y-m-d");


                                                            //                            get today clean

                                                            $sql_housekeeping="SELECT * FROM `tbl_housekeeping_clraning_dates` WHERE  `rmrs_id` = '$rmrs_id' AND `date` = '$current_date'";
                                                            $result_housekeeping = $conn->query($sql_housekeeping);
                                                            $i = 0;
                                                            $room_is = "";
                                                            $room_status ="";

                                                            if ($result_housekeeping && $result_housekeeping->num_rows > 0) {
                                                                while($row_housekeeping = mysqli_fetch_array($result_housekeeping)) {
                                                                }
                                                            }else {

                                                                $time_to_CN =  $time_to_EC;
                                                            }
                                                        }


                                                        $departure_date12 = "";
                                                        $sql_reservation12="SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND `departure` = '$current_date'";
                                                        $result_reservation12 = $conn->query($sql_reservation12);
                                                        if ($result_reservation12 && $result_reservation12->num_rows > 0) {
                                                            while($row_reservation12 = mysqli_fetch_array($result_reservation12)) {

                                                                $departure_date12 = $row_reservation12["departure"];
                                                            }
                                                        }



                                                        if($departure_date12 == $current_date ){
                                                            $time_to_CN =  $time_to_CD; 
                                                        }else{

                                                        }



                                                        //                                                  $time_type = $row2['time_type'];
                                                        $room_number = $row2['room_num'];
                                                        array_push($room_number_array,$room_number);
                                                        $time_to_CN_value = 0;

                                                        $sql_time="SELECT * FROM `tb_time_interval`  WHERE `ti_id` = $time_to_CN";
                                                        $result_time = $conn->query($sql_time);
                                                        if ($result_time && $result_time->num_rows > 0) {
                                                            while($row_time = mysqli_fetch_array($result_time)) {
                                                                $time_to_CN_value = $row_time['time'];
                                                                $time_to_CD_value = $row_time['time'];
                                                                $time_to_FC_value = $row_time['time'];
                                                                array_push($time_to_CN_array,$time_to_CN_value);
                                                                $total_time = $total_time+$time_to_CN_value;

                                                                if($room_status == 'Clean'){
                                                                    $total_completed_time = $total_completed_time+ $time_to_CN_value;
                                                                }


                                                            }
                                                        }else {
                                                            array_push($time_to_CN_array,0);
                                                        }


                                                    }
                                                }
                                            }
                                            if($total_completed_time != 0 && $total_time != 0){
                                                $percentage_completed = ($total_completed_time/$total_time) * 100;
                                            }

                                ?>

                                <div  id="" class="col-lg-6  col-md-6 mtm-5px">

                                    <div id="<?php echo "div_".$div_id ?>" class="row div-white-background pointer room_text_center pt-3 pb-3 ml-1 mr-1 mt-2 divacb"  accesskey=""
                                         onclick='selected_divs(this,<?php echo $user_id_a ?>)'
                                         >
                                        <div align="left" class="col-12">
                                            <h4><img src="<?php echo '../'.$image_url; ?>" onerror="this.src='../assets/images/users/user.png'"  alt="user" width="35" height="35" class="rounded-circle"  /> 
                                                &nbsp;&nbsp; <b><?php echo $firstname; ?></b>
                                            </h4>
                                        </div>
                                        <div class="col-3 center_div1">
                                            <span>Tempo di lavoro</span>
                                        </div>
                                        <div class="col-6 center_div1">
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage_completed; ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-3 mintus_font center_div1">
                                            <span><?php echo $total_completed_time; ?>/<?php echo $total_time; ?> min</span>
                                        </div>

                                        <div align="" class="col-12">
                                            <hr>
                                        </div>
                                        <div  class="col-12 ">
                                            <div class="row  ml-2 mr-2 " >

                                                <?php

                                            for ($x = 0; $x < sizeof($room_number_array); $x++) {


                                                ?>

                                                <div align="" class="col-1  center_div1">
                                                    <span><b><?php echo $room_number_array[$x]; ?></b></span>
                                                </div>
                                                <div class="col-2 pl-4" >
                                                    <img src="../assets/images/dubblebad.png" onerror="this.src='../assets/images/geast_bad.png'"  alt="user" width="26" height="25" />  
                                                </div>
                                                <div align="" class="col-6">

                                                </div>
                                                <div align="" class="col-3  ">
                                                    <span><b><?php echo $time_to_CN_array[$x]; ?> min</b></span>
                                                </div>
                                                <?php } ?>

                                                <?php

                                            for ($x = 0; $x < sizeof($extra_job_time_array); $x++) {


                                                ?>

                                                <div align="" class="col-1  center_div1 mt-2">
                                                    <span><b><?php echo "Extra"; ?></b></span>
                                                </div>
                                                <div class="col-2 pl-4 mt-2" >
                                                    <img src="../assets/images/extra_time.png" onerror="this.src='../assets/images/extra_time.png'"  alt="user" width="26" height="25" />  
                                                </div>
                                                <div align="left" class="col-6  mt-2">
                                                    <small><?php if($extra_completed_array[$x] == 1){ echo $extra_title_array[$x]; } else { echo
                                                    $extra_title_array[$x]."";;                                                                                                          }
                                                        ?></small>
                                                </div>
                                                <div align="" class="col-3  mt-2">
                                                    <span><b><?php echo $extra_job_time_array[$x]; ?> mins</b></span>
                                                </div>
                                                <?php } ?>




                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <?php 

                                            $div_id = $div_id + 1;
                                        }
                                    }}?>

                            </div>
                        </div>
                        <div  id="rooms_and_extra_job" class="col-lg-6  col-md-6 pl-4 mtm-10 plm-10px">
                            <div id="rooms_list" class="row div-background pt-3 pb-4" >
                                <div  id="" class="col-lg-4  col-md-4">

                                    <h3>Camere prenotate</h3>
                                </div>
                                <div  id="" class="col-lg-8  col-md-8">

                                    <div class="row">
                                        <div  id="" class="col-lg-4  col-md-4 wm-50">
                                            <div class="row">
                                                <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                    <div class="box_assign"></div>
                                                </div>
                                                <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                    <small>Assegnato a questo housekeeper</small>
                                                </div>
                                            </div>


                                        </div>
                                        <div  id="" class="col-lg-4  col-md-4 wm-50">
                                            <div class="row">
                                                <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                    <div class="box_other_user_assign"></div>
                                                </div>
                                                <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                    <small>Asseganto ad un’ altro housekeeper</small>
                                                </div>
                                            </div>


                                        </div>
                                        <div  id="" class="col-lg-4  col-md-4 wm-50">
                                            <div class="row">
                                                <div  id="" class="col-lg-2  col-md-2 center_div1 wm-20">
                                                    <div class="box_unassign"></div>
                                                </div>
                                                <div  id="" class="col-lg-10  col-md-10 wm-80">
                                                    <small>Non assegnato</small>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <?php

                                $unique_floor_id = array();
                                $unique_floor_number = array();
                                $sql="SELECT * FROM `tbl_floors` WHERE `hotel_id` =  $hotel_id and is_delete = 0 ORDER BY `tbl_floors`.`floor_num` ASC";
                                $result1 = $conn->query($sql);
                                while($row = mysqli_fetch_array($result1)) {
                                    array_push($unique_floor_id,$row['floor_id']);
                                    array_push($unique_floor_number,$row['floor_num']);
                                }
                                $floor_array_lenth = sizeof($unique_floor_id);

                                for ($x = 0; $x < $floor_array_lenth; $x++) {
                                ?>
                                <div  id="" class="col-lg-12  col-md-12">
                                    <div class="row" >
                                        <div  id="" class="col-lg-2  col-md-2">
                                        </div>
                                        <div  id="" class="col-lg-8  col-md-8">
                                            <div class="row div-white-background pointer room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
                                                <div  class="col-lg-12">
                                                    <span><b>Piano<?php echo $unique_floor_number[$x]; ?></b></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div  id="" class="col-lg-2  col-md-2">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    $sql="SELECT * FROM `tbl_rooms`  WHERE `floor_id` = $unique_floor_id[$x] AND `hotel_id` = $hotel_id and `is_active` = 1 and is_delete = 0 ORDER BY `tbl_rooms`.`room_num` ASC";
                                    $result = $conn->query($sql);
                                    $i = 0;
                                    if ($result && $result->num_rows > 0) {
                                        while($row = mysqli_fetch_array($result)) {

                                            $rms_id         = $row["rms_id"];
                                            $room_num       = $row["room_num"];
                                            $room_name      = $row["room_name"];
                                            $room_name_it   = $row["room_name_it"];
                                            $room_name_de   = $row["room_name_de"];
                                            $floor_id       = $row["floor_id"];
                                            $room_cat_id    = $row["room_cat_id"];
                                            //Reservation
                                            $current_date =   date("Y-m-d");
                                            $arrival = "";
                                            $arrival_date = "";
                                            $departure = "";
                                            $departure_date = "";
                                            $rmrs_id = 0;
                                            $sql_reservation="SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  `arrival` <= '$current_date' AND `departure`   >= '$current_date'";
                                            $result_reservation = $conn->query($sql_reservation);
                                            if ($result_reservation && $result_reservation->num_rows > 0) {
                                                while($row_reservation = mysqli_fetch_array($result_reservation)) {
                                                    $rmrs_id = $row_reservation["rmrs_id"];
                                                    $arrival = "Arrival";
                                                    $arrival_date = $row_reservation["arrival"];
                                                    $departure = "Departure";
                                                    $departure_date = $row_reservation["departure"];
                                                }
                                            }
                                            if($arrival != ""){


                                ?>
                                <div  id="" class="col-lg-2  col-md-2">
                                    <div class="row div-white-background pointer room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
                                        <div  class="col-lg-12">
                                            <span><?php echo $room_num ?></span>
                                        </div>


                                    </div>

                                </div>
                                <?php }} }

                                }
                                ?>

                            </div>
                            <div class="row div-background pt-3 pb-4 mt-3" >
                                <div  id="job_list" class="col-lg-12  col-md-12">
                                    <h3>Assegna lavori extra del housekeeping</h3>
                                </div>

                                <?php
                                $current_date = date("Y-m-d");
                                $sql="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0 ";
                                $result = $conn->query($sql);
                                $i = 0;
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {

                                        $hkej_id       = $row["hkej_id"];
                                        $time_to_complate       = $row["time_to_complate"];
                                        $job_title       = $row["job_title"]; 

                                ?>
                                <div  id="" class="col-lg-4  col-md-4">
                                    <div class="row div-white-background pointer room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
                                        <div  class="col-lg-12">
                                            <span><?php echo $job_title ?></span>
                                        </div>


                                    </div>

                                </div>
                                <?php }}?>

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

        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
        <script src="../assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

        <script>
            $('#date_is').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY',time: false, date: true }); 

            var temp_div_id ; 
            function selected_divs(elem,cleaner_id){
                var id = $(elem).attr("id");
                temp_div_id = id;
                $(".divacb").removeClass("selected_div");
                document.getElementById(id).classList.add('selected_div');
                $("#permanently_div").removeClass("display_none");
                $("#permanently_div").addClass("display_block");
                document.getElementById("h_selected_user").value = cleaner_id;
                let dateFormat1 = moment().format('dddd DD MMMM YYYY');
                document.getElementById("date_is").value = dateFormat1;
                reload_room_assign(cleaner_id);

            }
            function room_assign_update(div_id,room_number,cleaner_id) {

                var   newcleaner_id = cleaner_id;
                var id = $(div_id).attr("id");
                var get_element = document.getElementById(id);
                var permanently ;
                var radios = document.getElementsByName('permanently');
                for (var radio of radios)
                {
                    if (radio.checked) {
                        permanently = radio.value;
                    }
                }

                if(get_element.classList.contains('assign_background2') ) { 
                    get_element.classList.remove("assign_background2");
                }

                if(get_element.classList.contains('assign_background') ) { 
                    get_element.classList.remove("assign_background");
                    cleaner_id = 0;
                }else{
                    get_element.classList.add("assign_background");
                }
                var element = document.getElementById("mcontainer");
                element.classList.add("disabled");
                $.ajax({
                    url:'../housekeeping_utills/utill_update_assign_room.php',
                    method:'POST',
                    data:{room_number:room_number,cleaner_id:cleaner_id,permanently:permanently},
                    success:function(response){
                        console.log(response);
                        var delayInMilliseconds = 600; //1 second
                        setTimeout(function() {
                            element.classList.remove("disabled");
                        }, delayInMilliseconds); 
                        console.log(response);
                        if(response == "done"){
                            $.ajax({
                                url:'housekeeping_reload_rooms_assign.php',
                                method:'POST',
                                data:{cleaner_id:newcleaner_id},
                                success:function(response){
                                    document.getElementById("rooms_and_extra_job").innerHTML = response;

                                    //                                    this_one
                                    reload_cleanner(cleaner_id);
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                },
                            });
                        }else{
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



            function floor_assign_update(div_id,floor_id,cleaner_id) {
                if(floor_id != 0){
                    var   newcleaner_id = cleaner_id;
                    var id = $(div_id).attr("id");
                    var get_element = document.getElementById(id);
                    if(get_element.classList.contains('assign_background2') ) { 
                        get_element.classList.remove("assign_background2");
                    }

                    if(get_element.classList.contains('assign_background') ) { 
                        get_element.classList.remove("assign_background");
                        cleaner_id = 0;
                    }else{
                        get_element.classList.add("assign_background");
                    }
                    var element = document.getElementById("mcontainer");


                    var permanently ;
                    var radios = document.getElementsByName('permanently');
                    for (var radio of radios)
                    {
                        if (radio.checked) {
                            permanently = radio.value;
                        }
                    }
                    element.classList.add("disabled");
                    $.ajax({
                        url:'../housekeeping_utills/utill_update_assign_room.php',
                        method:'POST',
                        data:{floor_id:floor_id,cleaner_id:cleaner_id,permanently:permanently},
                        success:function(response){
                            console.log(response);
                            var delayInMilliseconds = 600; //1 second
                            setTimeout(function() {
                                element.classList.remove("disabled");
                            }, delayInMilliseconds); 
                            console.log(response);
                            if(response == "done"){
                                $.ajax({
                                    url:'housekeeping_reload_rooms_assign.php',
                                    method:'POST',
                                    data:{cleaner_id:newcleaner_id},
                                    success:function(response){
                                        document.getElementById("rooms_and_extra_job").innerHTML = response;    

                                        //                                        this_one
                                        reload_cleanner(cleaner_id);
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error);
                                    },
                                });
                            }else{
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

                }else{
                    console.log("ddd");
                }

            }

            function extra_job_assign_update(div_id,extra_job_id,cleaner_id,is_assigned) {

                var id = $(div_id).attr("id");
                document.getElementById("h_div_id").value = id ;
                document.getElementById("h_extra_job_id").value = extra_job_id ;
                document.getElementById("h_cleaner_id").value = cleaner_id;

                if(is_assigned == 0){
                    $('#add-datepicker').modal('show');

                }else{
                    document.getElementById("extra_job_date").value = "<?php echo date("Y-m-d"); ?>";

                    extrajob_add();
                    console.log(is_assigned);
                }


            }


            function  extrajob_add(){
                var extra_job_date =  document.getElementById("extra_job_date").value ;
                var div_id =  document.getElementById("h_div_id").value ;
                var extra_job_id =  document.getElementById("h_extra_job_id").value;
                var cleaner_id =  document.getElementById("h_cleaner_id").value;
                extra_job_assign_update2(div_id,extra_job_id,cleaner_id,extra_job_date);

            }
            function extra_job_assign_update2(div_id,extra_job_id,cleaner_id,extra_job_date) {
                var cleaner_id_v2 = cleaner_id;
                var id = div_id;
                var get_element = document.getElementById(id);
                if(get_element.classList.contains('assign_background2') ) { 
                    //                    get_element.classList.remove("assign_background2");
                }

                if(get_element.classList.contains('assign_background') ) { 
                    //                    get_element.classList.remove("assign_background");
                    cleaner_id = 0;

                }else{
                    //                    get_element.classList.add("assign_background");
                }
                var element = document.getElementById("mcontainer");
                element.classList.add("disabled");
                $.ajax({
                    url:'../housekeeping_utills/utill_update_assign_room.php',
                    method:'POST',
                    data:{extra_job_id:extra_job_id,cleaner_id:cleaner_id,extra_job_date:extra_job_date,
                          cleaner_id_v2:cleaner_id_v2},
                    success:function(response){
                        console.log(response);
                        var delayInMilliseconds = 600; //1 second
                        setTimeout(function() {
                            element.classList.remove("disabled");
                        }, delayInMilliseconds); 
                        console.log(response);
                        if(response == "done"){
                            //                            this_one
                            console.log("i am reloading")
                            reload_cleanner(cleaner_id_v2);
                            reload_room_assign(cleaner_id_v2)
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
            function redirect_url(url) {
                window.location.href = url;
            }

            function reload_cleanner(cleaner_id) {
                $.ajax({
                    url:'housekeeping_reload_houskeeping_cleaner.php',
                    method:'POST',
                    data:{cleaner_id:cleaner_id},
                    success:function(response1){
                        document.getElementById("housekeeping_cleaner").innerHTML = response1;   
                        $(".divacb").removeClass("selected_div");
                        document.getElementById(temp_div_id).classList.add('selected_div');
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }
            function reload_room_assign(cleaner_id) {
                $.ajax({
                    url:'housekeeping_reload_rooms_assign.php',
                    method:'POST',
                    data:{cleaner_id:cleaner_id},
                    success:function(response){
                        document.getElementById("rooms_and_extra_job").innerHTML = response;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }
            function filter(){
                let filter_date =document.getElementById("date_is").value;
                let cleaner_id   =  document.getElementById("h_selected_user").value ;
                console.log(filter_date);
                $.ajax({
                    url:'housekeeping_reload_rooms_assign.php',
                    method:'POST',
                    data:{cleaner_id:cleaner_id,filter_date:filter_date},
                    success:function(response){
                        document.getElementById("rooms_and_extra_job").innerHTML = response;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }
        </script>
        <!-- jQuery peity -->
        <script src="../assets/node_modules/tablesaw/dist/tablesaw.jquery.js"></script>
        <script src="../assets/node_modules/tablesaw/dist/tablesaw-init.js"></script>
    </body>
</html>