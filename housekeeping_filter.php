<?php 
$filter_by = 0;
$date_is = 0;
if(isset($_POST['date_is'])){
    include 'util_config.php';
    include 'util_session.php';
    $date_is=$_POST['date_is'];
    $date_is = new DateTime($date_is);
    $date_is = date_format($date_is,"Y-m-d");
}
$room_checklist_array =  array();
$room_id_checklist_array =  array();

?>
<div class="col-lg-12  col-md-12 ml-5 mr-5 mlm-0 mrm-0">
    <?php  
    $unique_floor_id = array();
    $unique_floor_number = array();


    $show_other = 0 ;
    $sql_task="SELECT * FROM `tbl_housekeeping_user_rule` WHERE `hotel_id` = $hotel_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $show_other = $row_task['show_other'];

        } 

    }
    $sql="SELECT * FROM `tbl_floors` WHERE `hotel_id` =  $hotel_id and is_delete = 0 ORDER BY `tbl_floors`.`floor_num` ASC";
    $result1 = $conn->query($sql);
    while($row = mysqli_fetch_array($result1)) {
        array_push($unique_floor_id,$row['floor_id']);
        array_push($unique_floor_number,$row['floor_num']);
    }
    $floor_array_lenth = sizeof($unique_floor_id);
    $total_assign_room = 0;
    $total_dirty_room = 0;
    $total_dirty_room_not_required_to_clean = 0;
    $total_cleaning_in_progress_room = 0;
    $total_clean_room = 0;
    $total_inspection_in_progress_room = 0;
    $total_inspected_room = 0;
    $total_no_cleaning_desired_room = 0;
    for ($x = 0; $x < $floor_array_lenth; $x++) {
    ?>
    <h6 class="mt-3">Floor <?php echo $unique_floor_number[$x]; ?></h6> 
    <div class="row" >
        <?php
        if($housekeeping_admin == 1 || $show_other == 1){

            $sql="SELECT * FROM `tbl_rooms`  WHERE `floor_id` = $unique_floor_id[$x] AND `hotel_id` = $hotel_id and `is_active` = 1 and is_delete = 0 ORDER BY `tbl_rooms`.`room_num` ASC";
        }else {
            $sql="SELECT a.* FROM `tbl_rooms` AS a INNER JOIN tbl_housekeeping AS b ON a.`rms_id` = b.room_id WHERE a.`floor_id` = $unique_floor_id[$x] AND a.`hotel_id` = $hotel_id and a.`is_active` = 1 and a.is_delete = 0 AND b.assign_to = $user_id ORDER BY a.`room_num` ASC";
        }
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


                //getcleanner
                //check_task

                //Reservation
                $current_date =   date("Y-m-d");
                $arrival = "";
                $arrival_date = "";
                $departure = "";
                $departure_date = "";
                $rmrs_id = 0;
                $annotation = "";
                $status_is = "";
                $status_arr = array();
                $from_ = "";
                $to_= "";
                if($date_is == 0){
                    $sql_reservation="SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  `arrival` <= '$current_date' AND `departure`   >= '$current_date'";
                }
                else {
                    $sql_reservation="SELECT * FROM `tbl_room_reservation` WHERE `room_id` = $rms_id AND  (`arrival` <= '$date_is' AND `departure`    >= '$date_is')";
                }           
                $result_reservation = $conn->query($sql_reservation);
                if ($result_reservation && $result_reservation->num_rows > 0) {
                    while($row_reservation = mysqli_fetch_array($result_reservation)) {

                        $rmrs_id = $row_reservation["rmrs_id"];
                        $annotation = $row_reservation["annotation"];
                        $arrival_date = $row_reservation["arrival"];
                        $departure_date = $row_reservation["departure"];

                        $status_is = $row_reservation["status_is"];

                        $from_ = $row_reservation["from_"];
                        $to_ = $row_reservation["to_"];

                        array_push($status_arr,$status_is);

                        if($date_is == 0){

                            if($arrival_date == $current_date ){
                                $arrival = "Arrival";

                            }else {
                                $from_ = ""; 
                            }

                            if($departure_date == $current_date){
                                $departure = "Departure";

                            }else {
                                $to_ = ""; 
                            }

                        }else{

                            if($arrival_date == $date_is ){
                                $arrival = "Arrival";

                            }else {
                                $from_ = "";
                            }

                            if($departure_date == $date_is){
                                $departure = "Departure";

                            }else {
                                $to_ = "";
                            }
                        }

                    }
                }
                if($departure_date == "" && $arrival_date == "" ){
                    continue;
                }else{


                    //                    //getRoomChecks
                    //                    $sql_task="SELECT * FROM `tbl_room_check`  WHERE `room_id`= $rms_id and is_completed = 0";
                    //                    $result_task = $conn->query($sql_task);
                    //                    if ($result_task && $result_task->num_rows > 0) {
                    //                        while($row_task = mysqli_fetch_array($result_task)) {
                    //                            $room_check_id = $row_task['room_check_id'];
                    //                            $checklist = $row_task['checklist'];
                    //                            $complate = $row_task['is_completed'];
                    //                            array_push($room_checklist_array,"'".$checklist."' is missing in Room ".$room_num);
                    //                        }
                    //                    }

                    if($arrival == "Arrival" ){
                        //getRoomArivalChecks
                        $sql_task="SELECT * FROM `tbl_room__arrival_check`  WHERE `room_id`= $rms_id and is_completed = 0";
                        $result_task = $conn->query($sql_task);
                        if ($result_task && $result_task->num_rows > 0) {
                            while($row_task = mysqli_fetch_array($result_task)) {
                                $rac_id = $row_task['rac_id'];
                                $checklist = $row_task['checklist'];
                                $complate = $row_task['is_completed'];
                                array_push($room_checklist_array,"'".$checklist."' is missing in Room ".$room_num."  ");


                                array_push($room_id_checklist_array,$rac_id);
                            }
                        }
                    }
                    //housekeeping
                    $sql_housekeeping="SELECT * FROM `tbl_housekeeping` WHERE `room_id` =  $rms_id";
                    $result_housekeeping = $conn->query($sql_housekeeping);
                    $i = 0;
                    $room_is = "";
                    $room_status ="";
                    $assign_to = "";
                    if ($result_housekeeping && $result_housekeeping->num_rows > 0) {
                        while($row_housekeeping = mysqli_fetch_array($result_housekeeping)) {

                            $is_breakfast      =    $row_housekeeping["is_breakfast"];
                            $assign_to        =       $row_housekeeping["assign_to"];
                            $room_status      =       $row_housekeeping["room_status"];
                            $presence_status        =       $row_housekeeping["presence_status"];
                            $is_urgent      =       $row_housekeeping["is_urgent"];

                            $do_need_to_clean      =       $row_housekeeping["do_need_to_clean"];

                            $laundry = "";
                            if($date_is == 0){




                                $current_date =   date("Y-m-d");

                                //get today laundry
                                $sql_housekeeping_abc = "SELECT * FROM `tbl_housekeeping_laundry_dates` WHERE  `rmrs_id` = '$rmrs_id' AND `date` = '$current_date'";
                                $result_housekeeping_abc = $conn->query($sql_housekeeping_abc);
                                if ($result_housekeeping_abc && $result_housekeeping_abc->num_rows > 0) {
                                    $laundry = "Yes";
                                }else{

                                    $laundry = "No";

                                }



                                if($room_status == "Dirty"){
                                    if($do_need_to_clean == 1){
                                        $total_dirty_room = $total_dirty_room + 1;
                                        $room_is = "room_dirty";
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
                                            $total_dirty_room = $total_dirty_room + 1;
                                            $room_is = "room_dirty";

                                        }else {

                                            $total_dirty_room_not_required_to_clean = $total_dirty_room_not_required_to_clean + 1;
                                            $room_is = "room_no_cleaning_today";
                                        }



                                    }

                                }else  if($room_status == "Clean"){
                                    $total_clean_room = $total_clean_room + 1;
                                    $room_is = "room_clean";
                                }else  if($room_status == "Unassigned"){
                                    $total_assign_room = $total_assign_room + 1;
                                    $room_is = "room_unassigned";
                                }else  if($room_status == "Cleaning_in_progress"){
                                    $total_cleaning_in_progress_room = $total_cleaning_in_progress_room + 1;
                                    $room_is = "room_cleaning_in_progress";
                                }else  if($room_status == "Inspection_in_progress"){
                                    $total_inspection_in_progress_room = $total_inspection_in_progress_room + 1;
                                    $room_is = "room_inspection_in_progress";
                                }else  if($room_status == "Inspected"){
                                    $total_inspected_room = $total_inspected_room + 1;
                                    $room_is = "room_inspected";
                                }else  if($room_status == "No_cleaning_desired"){
                                    $total_no_cleaning_desired_room = $total_no_cleaning_desired_room + 1;
                                    $room_is = "room_no_cleaning_desired";
                                }



                            }else{


                                //get today laundry
                                $sql_housekeeping_abc = "SELECT * FROM `tbl_housekeeping_laundry_dates` WHERE  `rmrs_id` = '$rmrs_id' AND `date` = '$date_is'";
                                $result_housekeeping_abc = $conn->query($sql_housekeeping_abc);
                                if ($result_housekeeping_abc && $result_housekeeping_abc->num_rows > 0) {
                                    $laundry = "Yes";
                                }else{

                                    $laundry = "No";

                                }



                                if($do_need_to_clean == 1){
                                    $total_dirty_room = $total_dirty_room + 1;
                                    $room_is = "room_dirty";
                                }else{



                                    //                            get today clean

                                    $sql_housekeeping="SELECT * FROM `tbl_housekeeping_clraning_dates` WHERE  `rmrs_id` = '$rmrs_id' AND `date` = '$date_is'";
                                    $result_housekeeping = $conn->query($sql_housekeeping);
                                    $i = 0;
                                    $room_is = "";


                                    if ($result_housekeeping && $result_housekeeping->num_rows > 0) {
                                        while($row_housekeeping = mysqli_fetch_array($result_housekeeping)) {
                                        }

                                        if($room_status == "Inspected" && $arrival == "Arrival" ){

                                            $total_inspected_room = $total_inspected_room + 1;
                                            $room_is = "room_inspected";

                                        }else{
                                            $total_dirty_room = $total_dirty_room + 1;
                                            $room_is = "room_dirty";
                                        }

                                    }else {


                                        if($room_status == "Inspected" && $arrival == "Arrival"  ){

                                            $total_inspected_room = $total_inspected_room + 1;
                                            $room_is = "room_inspected";

                                        }else{
                                            $total_dirty_room_not_required_to_clean = $total_dirty_room_not_required_to_clean + 1;
                                            $room_is = "room_no_cleaning_today";
                                        }
                                    }
                                }

                            }

                            if($is_breakfast == 1) {
                                //                                $room_is = "breakfast"; 
                                $breakfast = "Breakfast";
                            }else{
                                $breakfast = "";
                            }


                            if($is_urgent == 1) {
                                $urgent = "Urgent"; 
                            }else{
                                $urgent = ""; 
                            }
                            //

                            if($presence_status == 1) {
                                $presence_status = "Do Not Disturb"; 
                            }else{
                                $presence_status = "";
                            }

                        }}
                    //get assign user details
                    $cleanner_image_url =  "";
                    $cleanner_user_id_a =   "";
                    $cleanner_firstname =   "";
                    $cleanner_lastname =   "";
                    if($assign_to != ""){

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

                    }

                }


        ?>
        <div id="<?php echo $rms_id ?>" class="wm-50 my_rooms col-lg-2 col-md-2  col-sm-2 pt-2 " onclick="doubleclick(this, function(){ window.location.href = 'housekeeping_rooms_detail.php?id='+id+'&rmrs_id=<?php echo $rmrs_id; ?>';}, function(){window.location.href = 'housekeeping_rooms_detail.php?id='+id+'&rmrs_id=<?php echo $rmrs_id; ?>';})">
            <div class="room_box_height <?php echo $room_is; ?> room_box room_box_text pointer row">
                <div  class="col-md-8 wm-50  room_box_fix  room_padding_top" >
                    <?php 
                    ?>
                    <h6 class="room_box_cleanner_font"><?php echo $cleanner_firstname; ?></h6>
                    <?php ?>
                </div>
                <div id="inner" class="col-md-4 wm-50 room_box_fix  room_text_right room_padding_top" >
                    <?php 

                if($annotation != "" ){
                    ?>
                    <i class="mdi mdi-message-alert a_icon"></i>
                    <?php }?>
                </div>
                <div class="col-md-4 wm-50 pt-2" >

                    <?php if($laundry == "Yes"){ ?>
                    <img src="./assets/images/laundry.png" alt="homepage" width="26" />
                    <?php }?>
                </div>
                <div class="col-md-4 wm-50 padding_top_none" >

                    <h6 class="room_text_center room_box_fix1 room_no_font pt-3"><?php echo $room_num; ?></h6>
                </div>
                <div class="col-md-4 wm-50 pt-2" >
                    <?php if($from_ != ""){ ?>

                    <i class="mdi mdi-arrow-left a_icon_1 pt-4"><?php echo $from_ ?></i>
                    <?php }else if($to_ != ""){?>
                    <i class="mdi mdi-arrow-right a_icon_1 pt-4"><?php echo $to_ ?></i>
                    <?php } ?>

                </div>
                <div class="col-md-12 wm-50 pt-1" >
                    <h6 class="room_text_center room_box_fix room_box_ststus_font pt-1"><?php echo $breakfast; ?></h6>
                </div>
                <div class="col-md-12  wm-50" >
                    <h6 class="room_text_center room_box_fix room_box_ststus_font pt-1"><?php echo $urgent; ?></h6>
                </div>
                <div class="col-md-5 wm-50 room_box_fix3  room_text_left" >
                    <h6 class="room_box_p_status_font"><?php echo $presence_status; ?></h6>
                </div>
                <div class="col-md-3 wm-50  " >
                    <?php if(in_array("departed", $status_arr)){ ?>

                    <img src="./assets/images/checkout.png" alt="homepage" width="14" />
                    <?php } else if(in_array("occupied", $status_arr)){ ?>
                    <img src="./assets/images/checkin.png" alt="homepage" width="14" />
                    <?php }?>

                </div>
                <div class="col-md-4 wm-50 room_box_fix3  room_text_right" >


                    <h6 class="room_text_small"><?php echo $arrival; ?></h6>

                </div>

                <div class="col-md-12 wm-100 room_box_fix3  room_text_right" >
                    <h6 class="room_text_small"><?php echo $departure; ?></h6>
                </div>
            </div>
        </div>
        <div>
        </div>

        <?php }}?>

    </div>

    <?php }?>
</div>