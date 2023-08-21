<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $rms_id = 0;
    $rmrs_id = 0;
    $date_is = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST['rms_id'])){
        $rms_id = $_POST['rms_id'];
    }
    if(isset($_POST['rmrs_id'])){
        $rmrs_id = $_POST['rmrs_id'];
    }
    if(isset($_POST['date_is'])){
        $date_is = $_POST['date_is'];
    }

    $data = array();
    $temp1=array();

    $current_date =   date("Y-m-d");
    //Working


    //getRoomDetail
    $room_number = "";
    $sql_room="SELECT * FROM `tbl_rooms` WHERE `rms_id` =  $rms_id";
    $result_room = $conn->query($sql_room);
    if ($result_room && $result_room->num_rows > 0) {
        while($row_room = mysqli_fetch_array($result_room)) {
            $room_number = $row_room['room_num'];
        }
    }

    $temp_room_check_list = array();
    //getRoomChecks
    $sql_task="SELECT * FROM `tbl_room_check`  WHERE `room_id`= $rms_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $temp_a1 = array();
            $room_check_id = $row_task['room_check_id'];
            $checklist = $row_task['checklist'];
            $complate = $row_task['is_completed'];

            $temp_a['room_check_id'] =   $room_check_id;
            $temp_a['checklist'] =   $checklist;
            $temp_a['complate'] =   $complate;
            $temp_a['room_check_id'] =   $room_check_id;

            array_push($temp_room_check_list, $temp_a);


        }
    }
    $temp_room_check_list_arrival = array();
    //getRoomArrivalChecks
    $sql_task="SELECT * FROM `tbl_room__arrival_check`  WHERE `room_id`= $rms_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $temp_a = array();
            $room_check_id = $row_task['rac_id'];
            $checklist = $row_task['checklist'];
            $complate = $row_task['is_completed'];

            $temp_a['room_check_id'] =   $room_check_id;
            $temp_a['checklist'] =   $checklist;
            $temp_a['complate'] =   $complate;
            $temp_a['room_check_id'] =   $room_check_id;

            array_push($temp_room_check_list_arrival, $temp_a);
        }
    }


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
            $assgin_date = $row_housekeeping['assgin_date'];
            $last_cleaning_date = $row_housekeeping['last_cleaning_date'];

        }
    }

    //check_nec


    $room_is = "";
    if($room_status == "Dirty"){


        if($do_need_to_clean == 1){

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


                $room_is = "nec_cleaning";
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


            $guest_language = $row_reservation['language']; 







        }
    }



    //get_guest
    $guest_array = array();
    $sql_guest = "SELECT * FROM `tbl_housekeeping_guest` WHERE  `room_id` =  $rms_id and `rmrs_id` = $rmrs_id";
    $result_guest = $conn->query($sql_guest);
    if ($result_guest && $result_guest->num_rows > 0) {
        while($row_guest = mysqli_fetch_array($result_guest)) {            
            $guest_name =    $row_guest['name'];
            $guest_dob =    $row_guest['dob'];

            $temp_a = array();

            $temp_a['guest_name'] =   $guest_name;
            $temp_a['guest_dob'] =   $guest_dob;


            array_push($guest_array, $temp_a);

        }
    }
    //assign_user
    $sql_user="SELECT * FROM `tbl_user`  WHERE  user_id = '$assign_to'";
    $result_user = $conn->query($sql_user);

    if ($result_user && $result_user->num_rows > 0) {
        $i=1;
        while($row = mysqli_fetch_array($result_user)) {

            $cleanner_image_url =   $row['address'];

            $cleanner_firstname =   $row['firstname'];
            $cleanner_lastname =   $row['lastname'];
        }}else{
        $cleanner_image_url =   "";

        $cleanner_firstname =   "";
        $cleanner_lastname =   "";
    }


    $temp['room_number'] =   $room_number;
    $temp['assign_to'] =   $assign_to;
    $temp['cleanner_image_url'] =   $cleanner_image_url;
    $temp['cleanner_firstname'] =   $cleanner_firstname;
    $temp['cleanner_lastname'] =   $cleanner_lastname;

    $temp['room_status'] =   $room_status;
    $temp['presence_status'] =   $presence_status;
    $temp['cleaning_frequency'] =   $cleaning_frequency;
    $temp['cleaning_day'] =   $cleaning_day;
    $temp['cleaning_date'] =   $cleaning_date;
    $temp['is_completed'] =   $is_completed;
    $temp['is_urgent'] =   $is_urgent;
    $temp['is_breakfast'] =   $is_breakfast;
    $temp['do_need_to_clean'] =   $do_need_to_clean;
    $temp['assgin_date'] =   $assgin_date;
    $temp['last_cleaning_date'] =   $last_cleaning_date;


    $temp['room_check_list'] =   $temp_room_check_list;
    $temp['room_check_list_arrival'] =   $temp_room_check_list_arrival;




    $temp['arrival'] =   $arrival;
    $temp['departure'] =   $departure;
    $temp['days_between'] =   $days_between;
    $temp['num_of_people'] =   $num_of_people;
    $temp['k1_0_3'] =   $k1_0_3;
    $temp['k2_3_8'] =   $k2_3_8;
    $temp['k3_8_14'] =   $k3_8_14;

    $temp['guests_details'] =   $guest_array;

    $temp['note'] =   $note;
    $temp['note_it'] =   $note_it;
    $temp['note_de'] =   $note_de;

    $temp['vip'] =   $vip;
    $temp['stays'] =   $stays;
    $temp['booking_group'] =   $booking_group;
    $temp['offer'] =   $offer;
    $temp['annotation'] =   $annotation;
    $temp['room_is'] =   $room_is;


    $temp['guest_language'] =   $guest_language; 









    array_push($data, $temp);
    unset($temp);

    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>