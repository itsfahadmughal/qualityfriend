<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $housekeeping = 0;
    $usert_id = 0;
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
    $data = array();
    $temp1=array();

    //Working



    $sql="SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id  ORDER BY `tbl_user`.`user_id` DESC";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();
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



                $current_date = date("Y-m-d");
                $sql_housekeeping_extra_job = "SELECT  a.hkej_id,a.job_title,b.time,c.`is_completed`,c.id as complate_id FROM `tbl_ housekeeping_extra_jobs` AS a INNER JOIN tb_time_interval as b ON a.`time_to_complate` =  b.ti_id INNER JOIN `tbl_ housekeeping_extra_jobs_completed_check` as c ON a.`hkej_id` = c.extra_job_id Where   c.assign_to =  $user_id_a AND a.is_delete = 0 AND c.assign_date = '$current_date'";

                $extra_completed = 0;
                $totel_extra_time = 0 ;
                $totl_extra_completed_time = 0;
                $extra_job_time_array =  array();
                $extra_title_array =  array();
                $extra_completed_array =  array();

                $extra_job_detail =  array();

                $result_extra_job = $conn->query($sql_housekeeping_extra_job);
                if ($result_extra_job && $result_extra_job->num_rows > 0) {
                    while($row_extra_job = mysqli_fetch_array($result_extra_job)) {



                        $extra_time = $row_extra_job['time'];
                        $extra_completed = $row_extra_job['is_completed'];
                        $job_title       = $row_extra_job["job_title"]; 


                        $temp_2 = array();
                        $temp_2['time'] = $extra_time;
                        $temp_2['is_completed'] = $extra_completed;
                        $temp_2['job_title'] = $job_title;
                        array_push($extra_job_detail, $temp_2);




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
                $temp['this_user'] =   $user_id_a;
                $temp['image_url'] =   $image_url;
                $temp['firstname'] =   $firstname;
                $temp['percentage_completed'] =   $percentage_completed;
                $temp['total_completed_time'] =   $total_completed_time;
                $temp['total_time'] =   $total_time;
                $temp['room_number_array'] =   $room_number_array;
                $temp['time_to_CN_array'] = $time_to_CN_array;

                $temp['extra_job_detail'] =   $extra_job_detail;


                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";

            }






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