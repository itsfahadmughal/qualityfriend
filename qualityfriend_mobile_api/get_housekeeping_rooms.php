<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $room_cat_id_is = 0;
    $floor_id_is = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }

    if(isset($_POST["floor_id_is"])){
        $floor_id_is = $_POST["floor_id_is"];
    }
    if(isset($_POST["room_cat_id_is"])){
        $room_cat_id_is = $_POST["room_cat_id_is"];
    }




    $data = array();
    $temp1=array();

    //Working

    $sql = "SELECT * FROM `tbl_rooms` WHERE `hotel_id` =  $hotel_id  AND `is_delete` = 0 ORDER BY `room_num` ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();
            $rms_id = $row['rms_id'];
            $floor_id = $row['floor_id'];
            $room_cat_id = $row['room_cat_id'];    

            $temp['rms_id'] =   $row['rms_id'];
            $temp['room_num'] =   $row['room_num'];
            $temp['room_name'] =   $row['room_name'];
            $temp['room_name_it'] =   $row['room_name_it'];
            $temp['room_name_de'] =   $row['room_name_de'];
            $temp['floor_id'] =   $floor_id;
            $temp['room_cat_id'] = $room_cat_id;
            $temp['entrytime'] = $row['entrytime'];
            $temp['entrybyid'] = $row['entrybyid'];
            $temp['entrybyip'] = $row['entrybyip'];

            if($floor_id_is != 0){
                if( $floor_id_is == $floor_id){
                    $temp['color'] = "blue";
                }else{
                    $temp['color'] = "";
                }
            }else{

            }

            if($room_cat_id_is != 0){
                if( $room_cat_id_is == $room_cat_id){
                    $temp['color'] = "blue";
                }else{
                    $temp['color'] = "";
                }
            }else{

            }


            $room_checks =  "";
            $checklist =  "";
            $temp_department = array();
            $sql_checks="SELECT * FROM `tbl_room_check` WHERE `room_id` =  $rms_id";
            $result_checks = $conn->query($sql_checks);
            if ($result_checks && $result_checks->num_rows > 0) {
                while($row_checks = mysqli_fetch_array($result_checks)) {
                    $temp2 = array();
                    $temp2['checklist']      = $row_checks["checklist"];
                    $temp2['room_check_id']      = $row_checks["room_check_id"];

                    array_push($temp_department, $temp2);



                }}else{

            }

            $room_checks_arrival =  "";
            $checklist_arrival =  "";
            $temp_department_arrival = array();
            $sql_checks="SELECT * FROM `tbl_room__arrival_check` WHERE `room_id` =  $rms_id";
            $result_checks = $conn->query($sql_checks);
            if ($result_checks && $result_checks->num_rows > 0) {
                while($row_checks = mysqli_fetch_array($result_checks)) {
                    $temp2 = array();
                    $temp2['checklist']      = $row_checks["checklist"];
                    $temp2['room_check_id']      = $row_checks["rac_id"];

                    array_push($temp_department_arrival, $temp2);



                }}else{

            }



            $temp['checklist_details'] = $temp_department;
            $temp['checklist_details_arrival'] = $temp_department_arrival;

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>