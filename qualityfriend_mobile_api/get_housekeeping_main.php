<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration



    $hotel_id= 0;
    $user_id = 0;
    $housekeeping_admin = 0;
    $date_is = 0;
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }

    $check_apk = "api";
//    //auto call
//    include '../housekeeping_utills/util_auto_run.php';
//    include '../housekeeping_utills/read_xml.php';


    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["housekeeping_admin"])){
        $housekeeping_admin = $_POST["housekeeping_admin"];
    }
    if(isset($_POST['date_is'])){
        $date_is=$_POST['date_is'];
    }
    $data = array();
    $temp1=array();
    //Working

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
    if ($result1 && $result1->num_rows > 0) {
        while($row = mysqli_fetch_array($result1)) {
            array_push($unique_floor_id,$row['floor_id']);
            array_push($unique_floor_number,$row['floor_num']);
        }}else{

    }
    $floor_array_lenth = sizeof($unique_floor_id);


    if($floor_array_lenth != 0){
        for ($x = 0; $x < $floor_array_lenth; $x++) {

            $temp = array();


            $temp['floor_id'] =   $unique_floor_id[$x];
            $temp['floor_num'] =   $unique_floor_number[$x];

            $temp_room = array();
            if(  $housekeeping_admin == 1 || $show_other == 1){

                $sql="SELECT * FROM `tbl_rooms`  WHERE `floor_id` = $unique_floor_id[$x] AND `hotel_id` = $hotel_id and `is_active` = 1 and is_delete = 0 ORDER BY `tbl_rooms`.`room_num` ASC";
            }else { 
                $sql="SELECT a.* FROM `tbl_rooms` AS a INNER JOIN tbl_housekeeping AS b ON a.`rms_id` = b.room_id WHERE a.`floor_id` = $unique_floor_id[$x] AND a.`hotel_id` = $hotel_id and a.`is_active` = 1 and a.is_delete = 0 AND b.assign_to = $user_id ORDER BY a.`room_num` ASC";
            }
            $result = $conn->query($sql);
            $i = 0;
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    //room_detail
                    $temp_room_detail = array();
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

                            $cleaning_date     =       $row_housekeeping["cleaning_date"];


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

                                        $room_is = "room_dirty";
                                    }else{
                                        $current_date =   date("Y-m-d");

                                        $sql_housekeeping="SELECT * FROM `tbl_housekeeping_clraning_dates` WHERE  `rmrs_id` = '$rmrs_id' AND `date` = '$current_date'";
                                        $result_housekeeping = $conn->query($sql_housekeeping);
                                        $i = 0;
                                        $room_is = "";
                                        $room_status ="";

                                        if ($result_housekeeping && $result_housekeeping->num_rows > 0) {
                                            while($row_housekeeping = mysqli_fetch_array($result_housekeeping)) {
                                            }

                                            $room_is = "room_dirty";

                                        }else {


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

                                            $room_is = "room_dirty";
                                        }

                                    }else {


                                        if($room_status == "Inspected" && $arrival == "Arrival"  ){

                                            $total_inspected_room = $total_inspected_room + 1;
                                            $room_is = "room_inspected";

                                        }else{

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





                    $temp_room_detail['rms_id'] = $rms_id;
                    $temp_room_detail['room_num'] = $room_num;
                    $temp_room_detail['room_name'] =   $room_name;
                    $temp_room_detail['rmrs_id'] = $rmrs_id;
                    $temp_room_detail['arrival'] = $arrival;



                    if(in_array("departed", $status_arr)){ 
                        $status_is = 'departed';
                    } else if(in_array("occupied", $status_arr)){
                        $status_is = 'occupied';   
                    }


                    $temp_room_detail['status_is'] = $status_is;
                    $temp_room_detail['departure'] =   $departure;
                    $temp_room_detail['annotation'] =   $annotation;
                    $temp_room_detail['room_is'] =   $room_is;
                    $temp_room_detail['breakfast'] =   $breakfast;
                    $temp_room_detail['urgent'] =   $urgent;
                    $temp_room_detail['presence_status'] =   $presence_status;
                    $temp_room_detail['assign_to'] =   $cleanner_firstname;
                    $temp_room_detail['laundry'] =   $laundry;
                    $temp_room_detail['from'] =   $from_;
                    $temp_room_detail['to'] =   $to_;

                    array_push($temp_room, $temp_room_detail);



                }
            } 

            $temp['room_detail'] =   $temp_room;

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }


    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Floor Not Found";   
    }
    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>