
<?php 
include 'util_config.php';
include '../util_session.php';

?>

<div class="row div-background pt-3 pb-4" >
    <div  id="" class="col-lg-12  col-md-12">
        <h3>Reinigungskraft</h3>
    </div>

    <?php 
    $div_id =0;
    $sql="SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id  ORDER BY `tbl_user`.`user_id` DESC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $i=1;
        while($row = mysqli_fetch_array($result)) {
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
                $current_date =   date("Y-m-d");
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

                            if($total_completed_time != 0) {
                                $percentage_completed = ($total_completed_time/$total_time) * 100;


                            }

                        }



                    }
                }

    ?>
    <div  id="" class="col-lg-6  col-md-6 mtm-5px">

        <div id="<?php echo "div_".$div_id ?>" class="row div-white-background pointer room_text_center pt-3 pb-3 ml-1 mr-1 mt-2 divacb"  accesskey=""
             onclick='selected_divs(this,<?php echo $user_id_a ?>)'
             >
            <div align="left" class="col-12">
                <h4><img src="<?php echo $image_url; ?>" onerror="this.src='../assets/images/users/user.png'"  alt="user" width="35" height="35" class="rounded-circle"  /> 
                    &nbsp;&nbsp; <b><?php echo $firstname; ?></b>
                </h4>
            </div>
            <div class="col-3 center_div1">
                <span>Arbeitszeit</span>
            </div>
            <div class="col-6 center_div1">
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php

                if($total_completed_time != 0) {
                    $percentage_completed = ($total_completed_time/$total_time) * 100;
                }
                echo $percentage_completed; ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <span><b>Extra</b></span>
                    </div>
                    <div class="col-2 pl-4 mt-2" >
                        <img src="../assets/images/extra_time.png" onerror="this.src='../assets/images/extra_time.png'"  alt="user" width="26" height="25" />  
                    </div>
                    <div align="left" class="col-6 pl-3 mt-2">
                        <small><?php if($extra_completed_array[$x] == 1){ echo $extra_title_array[$x]; } else { echo
                        $extra_title_array[$x]."";;                                                                                                          }
                            ?></small>
                    </div>
                    <div align="" class="col-3  mt-2  ">
                        <span><b><?php echo $extra_job_time_array[$x]; ?> min</b></span>
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