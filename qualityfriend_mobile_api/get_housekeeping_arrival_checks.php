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
    $temp_room = array();
    $unique_floor_id = array();
    $unique_floor_number = array();
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

            if(  $housekeeping_admin == 1){

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
                    //Reservation
                    $current_date =   date("Y-m-d");
                    $arrival = "";
                    $arrival_date = "";
                    $departure = "";
                    $departure_date = "";
                    $rmrs_id = 0;
                    $annotation = "";
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
                            if($date_is == 0){
                                if($arrival_date == $current_date ){
                                    $arrival = "Arrival";
                                }
                                if($departure_date == $current_date){
                                    $departure = "Departure";
                                }
                            }else{
                                if($arrival_date == $date_is ){
                                    $arrival = "Arrival";
                                }
                                if($departure_date == $date_is){
                                    $departure = "Departure";
                                }
                            }





                        }
                    }
                    if($departure_date == "" && $arrival_date == "" ){
                        continue;
                    }else{

                    }


                    if($arrival == "Arrival" ){
                        //getRoomArivalChecks
                        $sql_task="SELECT * FROM `tbl_room__arrival_check`  WHERE `room_id`= $rms_id and is_completed = 0";
                        $result_task = $conn->query($sql_task);
                        if ($result_task && $result_task->num_rows > 0) {
                            while($row_task = mysqli_fetch_array($result_task)) {
                                $rac_id = $row_task['rac_id'];
                                $checklist = $row_task['checklist'];
                                $complate = $row_task['is_completed'];
                                $temp_check_detail = array();

                                $temp_check_detail['rac_id'] = $rac_id;
                                $temp_check_detail['checklist'] = $checklist." is missing in Room ".$room_num;
                                $temp_check_detail['complate'] =   $complate;


                                array_push($temp_room,$temp_check_detail);
                            }
                        }

                    }

                }
            } 


        }
        $temp['arrival_checks'] =   $temp_room;
        array_push($data, $temp);
        unset($temp);
        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";

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