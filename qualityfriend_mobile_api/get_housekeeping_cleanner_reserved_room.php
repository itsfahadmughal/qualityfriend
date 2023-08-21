<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $housekeeping = 0;
    $usert_id = 0;
    $cleaner_id = 0;
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["usert_id"])){
        $usert_id = $_POST["usert_id"];
    }
    if(isset($_POST["housekeeping"])){
        $housekeeping = $_POST["housekeeping"];
    }
    if(isset($_POST["housekeeping_admin"])){
        $housekeeping_admin = $_POST["housekeeping_admin"];
    }
    if(isset($_POST["cleaner_id"])){
        $cleaner_id = $_POST["cleaner_id"];
    }


    $data = array();
    $temp1=array();
    $temp_department_2 = array();

    //Working


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
        $temp = array();
        $floor_no =   $unique_floor_number[$x]; 
        $floor_id =   $unique_floor_id[$x]; 
        $temp['floor_id'] =   $floor_id;
        $temp['floor_no'] =   $floor_no;

        $temp_department = array();
        $sql="SELECT * FROM `tbl_rooms`  WHERE `floor_id` = $unique_floor_id[$x] AND `hotel_id` = $hotel_id and `is_active` = 1 and is_delete = 0 ORDER BY `tbl_rooms`.`room_num` ASC";
        $result = $conn->query($sql);

        $ii = 0;
        $jj = 0;
        $i = 0;
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp2 = array();
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
                    //only when cleanner id
                    $assigned = "";
                    $check_user = 0;
                    if($cleaner_id != 0){

                        $sql_check="SELECT assign_to FROM tbl_housekeeping WHERE room_id = $rms_id";
                        $result_check = $conn->query($sql_check);
                        if ($result_check && $result_check->num_rows > 0) {
                            while($row_check = mysqli_fetch_array($result_check)) {
                                $check_user  = $row_check[0];
                            }
                        }
                        if($check_user == $cleaner_id){
                            $assigned = "assign_background_blue";
                            $jj = $jj + 1;
                        }else if($check_user == 0) {
                            $assigned = "";

                        }else{
                            $assigned = "assign_background_lite_blue";   
                        }
                        $ii = $ii + 1;
                    }


                    $temp90 = array();
                    $temp90['rms_id'] = $rms_id;
                    $temp90['room_num'] = $room_num;
                    $temp90['assigned_background'] =   $assigned;

                    array_push($temp_department, $temp90);


                }} 

            $floor_assigned = "";


            if($cleaner_id != 0 ){
                if($ii == $jj){
                    $floor_assigned = "assign_background";
                }

            }
            $temp['floor_background'] = $floor_assigned;
            $temp['Rooms_detail'] = $temp_department;



        }else{
            $temp['floor_background'] = "";
            $temp['Rooms_detail'] = $temp_department_2;   
        }

        array_push($data, $temp);
        unset($temp);
        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";

    }             

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>