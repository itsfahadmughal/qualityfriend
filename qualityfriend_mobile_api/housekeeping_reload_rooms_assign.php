<?php 
include 'util_config.php';
include 'util_session.php';

$cleaner_id="";
$div_id = 0;

$filter_date = "";
if(isset($_POST['cleaner_id'])){
    $cleaner_id=$_POST['cleaner_id'];
}
if(isset($_POST['filter_date'])){
    $filter_date=$_POST['filter_date'];
}
?>

<div id="rooms_list" class="row div-background pt-3 pb-4" >
    <div  id="" class="col-lg-4  col-md-4">
        <h3>Reserved Rooms</h3>
    </div>
    <div  id="" class="col-lg-8  col-md-8">
        <div class="row">

            <div  id="" class="col-lg-4  col-md-4">
                <div class="row">
                    <div  id="" class="col-lg-2  col-md-2 center_div1">
                        <div class="box_assign"></div>
                    </div>
                    <div  id="" class="col-lg-10  col-md-10">
                        <small>Assign to this user</small>
                    </div>
                </div>
            </div>
            <div  id="" class="col-lg-4  col-md-4">
                <div class="row">
                    <div  id="" class="col-lg-2  col-md-2 center_div1">
                        <div class="box_other_user_assign"></div>
                    </div>
                    <div  id="" class="col-lg-10  col-md-10">
                        <small>Assign to other user</small>
                    </div>
                </div>
            </div>
            <div  id="" class="col-lg-4  col-md-4">
                <div class="row">
                    <div  id="" class="col-lg-2  col-md-2 center_div1">
                        <div class="box_unassign"></div>
                    </div>
                    <div  id="" class="col-lg-10  col-md-10">
                        <small>Unassigned</small>
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
        $sql="SELECT * FROM `tbl_rooms`  WHERE `floor_id` = $unique_floor_id[$x] AND `hotel_id` = $hotel_id and `is_active` = 1 and is_delete = 0 ORDER BY `tbl_rooms`.`room_num` ASC";
        $result = $conn->query($sql);
        $ii = 0;
        $jj = 0;
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {

                $rms_id         = $row["rms_id"];
                $assigned = "";
                $check_user = 0;
                $sql_check="SELECT assign_to FROM tbl_housekeeping WHERE room_id = $rms_id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        $check_user  = $row_check[0];
                    }
                }
                $current_date =   date("Y-m-d");
                $sql_reservation = "SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  `arrival` <= '$current_date' AND `departure`   >= '$current_date'";
                $result_reservation = $conn->query($sql_reservation);
                if ($result_reservation && $result_reservation->num_rows > 0) {
                    while($row_reservation = mysqli_fetch_array($result_reservation)) {

                        if($check_user == $cleaner_id){
                            $assigned = "assign_background";
                            $jj = $jj + 1;
                        }
                        $ii = $ii + 1;
                    }
                }
            }
        }
        $floor_assigned = "";
        if($ii != 0){
            if($ii == $jj){
                $floor_assigned = "assign_background";
            }
        }
    ?>
    <div  id="" class="col-lg-12  col-md-12">
        <div class="row" >
            <div  id="" class="col-lg-2  col-md-2">
            </div>
            <div  id="" class="col-lg-8  col-md-8">
                <div  id="<?php echo "floor_".$div_id ?>" onclick ="floor_assign_update(this,<?php echo $unique_floor_id[$x];?>,<?php echo $cleaner_id;?>)" class="<?php echo $floor_assigned; ?> row div-white-background pointer room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
                    <div  class="col-lg-12">
                        <span><b>Floor <?php echo $unique_floor_number[$x]; ?></b></span>
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
        $ii = 0;
        $jj = 0;
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {


                $rms_id         = $row["rms_id"];
                $room_num       = $row["room_num"];
                $room_name      = $row["room_name"];
                $room_name_it   = $row["room_name_it"];
                $room_name_de   = $row["room_name_de"];
                $floor_id       = $row["floor_id"];
                $room_cat_id    = $row["room_cat_id"]; 
                $assigned = "";
                $check_user = 0;
                $sql_check="SELECT assign_to FROM tbl_housekeeping WHERE room_id = $rms_id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        $check_user  = $row_check[0];
                    }
                }
                if($check_user == $cleaner_id){
                    $assigned = "assign_background";
                    $jj = $jj + 1;
                }else if($check_user == 0) {
                    $assigned = "";

                }else{
                    $assigned = "assign_background2";   
                }
                //Reservation
                $current_date =   date("Y-m-d");
                $arrival = "";
                $arrival_date = "";
                $departure = "";
                $departure_date = "";
                $rmrs_id = 0;
                $sql_reservation = "SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  `arrival` <= '$current_date' AND `departure`   >= '$current_date'";
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
        <div onclick ="room_assign_update(this,<?php echo $rms_id;?>,<?php echo $cleaner_id;?>)" id="<?php echo "single_".$div_id ?>"  class="row <?php echo $assigned; ?> div-white-background pointer room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
            <div  class="col-lg-12">
                <span><?php echo $room_num; ?></span>
            </div>


        </div>

    </div>
    <?php

                    $div_id = $div_id + 1;
                    $ii = $ii + 1;
                }} }
    }
    ?>


    <?php   
    ?>
</div>
<div class="row div-background pt-3 pb-4 mt-3" >
    <div  id="job_list" class="col-lg-12  col-md-12">
        <h3>Assign Cleaning extra jobs</h3>
        <h6><?php if($filter_date != ""){echo $filter_date;} ?></h6>
    </div>
    <?php

    if($filter_date == ""){
        $filter_date = date("Y-m-d");
    }else{
        $filter_date = new DateTime($filter_date);
        $filter_date = date_format($filter_date,"Y-m-d");
    }



    $sql="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0 AND (`assgin_date` = '$filter_date' OR `assgin_date` = '') ";
    $result = $conn->query($sql);
    $ii = 0;
    $j = 0 ;
    $job_div_id = 0;
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {


            $is_assigned = 0;
            $hkej_id                = $row["hkej_id"];
            $time_to_complate       = $row["time_to_complate"];
            $job_title              = $row["job_title"];
            $assign_user_id         = $row["user_id"];
            $is_completed         = $row["is_completed"];
            if($assign_user_id == $cleaner_id){
                $is_assigned = 1;
                $assigned_jobs = "assign_background";

                if($is_completed == 1){
                    $assigned_jobs = "assign_background_completed";
                }else{


                }



            }else if($assign_user_id == 0) {
                $assigned_jobs = "";

            }else{
                $assigned_jobs = "assign_background2";


            }
    ?>
    <div   id="" class="col-lg-4  col-md-4">
        <div  onclick ="extra_job_assign_update(this,<?php echo $hkej_id;?>,<?php echo $cleaner_id;?>,<?php echo $is_assigned;?>)" id="<?php echo "single_job_".$job_div_id ?>" class="row div-white-background <?php echo $assigned_jobs; ?> pointer room_text_center pt-2 pb-2 ml-1 mr-1 mt-2">
            <div  class="col-lg-12">
                <span><?php echo $job_title ?></span>
            </div>


        </div>

    </div>
    <?php
        $job_div_id = $job_div_id + 1;
        }}?>

</div>




