<?php
$current_date = date("Y-m-d");
//update only for today 
$next_day = new DateTime($current_date);
$next_day->modify('-1 day');
$next_day =     $next_day->format('Y-m-d');
$sql_room_assign="UPDATE `tbl_housekeeping` SET `assign_to`='',`assgin_time`='',`cleaning_day`='',`cleaning_date`='' WHERE `assgin_date` = '' AND `assgin_type` = 'One_Day'";
$result_room_assign = $conn->query($sql_room_assign);


//set all cleaning dates
//del cleanings
$sql="DELETE FROM `tbl_housekeeping_clraning_dates` WHERE `hotel_id`  = $hotel_id";
$result1 = $conn->query($sql);
//del lundry
$sql="DELETE FROM `tbl_housekeeping_laundry_dates` WHERE `hotel_id`  = $hotel_id";
$result1 = $conn->query($sql);

$current_date = date("Y-m-d");


function getBetweenDates($startDate, $endDate) {
    $rangArray = [];

    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

$sql_check="SELECT * FROM `tbl_room_reservation`  WHERE `hotel_id` = '$hotel_id'";
$result_check = $conn->query($sql_check);
if ($result_check && $result_check->num_rows > 0) {
    while($row_ = mysqli_fetch_array($result_check)) {


        $rmrs_id =$row_['rmrs_id'];
        $rms_id =$row_['room_id'];
        $arrival =$row_['arrival'];
        $departure =$row_['departure'];



        $sql_check12="SELECT a.`room_num`,b.cleaning_frequency,b.cleaning_day,b.laundry_frequency,b.laundry_day FROM `tbl_rooms` as a INNER JOIN tbl_room_category as b ON a.`room_cat_id` = b.room_cat_id WHERE a.`rms_id` = $rms_id";

        $result_check12 = $conn->query($sql_check12);
        if ($result_check12 && $result_check12->num_rows > 0) {
            while($row12 = mysqli_fetch_array($result_check12)) {
                $room_num =  $row12['room_num'];
                $cleaning_frequency =  $row12['cleaning_frequency'];
                $cleaning_day =  $row12['cleaning_day'];
                $laundry_frequency =  $row12['laundry_frequency'];
                $laundry_day =  $row12['laundry_day'];


            }}





        if($cleaning_frequency == "DAILY"){


            $modify_departure = date('Y-m-d', strtotime($departure . ' +1 day'));
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                $sql="INSERT INTO `tbl_housekeeping_clraning_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                $result1 = $conn->query($sql);
                if($result1){

                }

            }
        }else if ($cleaning_frequency == "EVERY_SECOUND_DAY"){


            $modify_departure = date('Y-m-d', strtotime($departure . ' +1 day'));
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('2 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                $sql="INSERT INTO `tbl_housekeeping_clraning_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                $result1 = $conn->query($sql);
                if($result1){

                }

            }



        }else if ($cleaning_frequency == "EVERY_THIRD_DAY"){

            $modify_departure = date('Y-m-d', strtotime($departure . ' +1 day'));
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('3 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                $sql="INSERT INTO `tbl_housekeeping_clraning_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                $result1 = $conn->query($sql);
                if($result1){

                }

            }


        }else if ($cleaning_frequency == "EVERY_FOURTH_DAY") {

            $modify_departure = date('Y-m-d', strtotime($departure . ' +1 day'));
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('4 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                $sql="INSERT INTO `tbl_housekeeping_clraning_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                $result1 = $conn->query($sql);
                if($result1){

                }

            }

        }else if ($cleaning_frequency == "EVERY_FIFTH_DAY"){

            $modify_departure = date('Y-m-d', strtotime($departure . ' +1 day'));
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('5 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                $sql="INSERT INTO `tbl_housekeeping_clraning_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                $result1 = $conn->query($sql);
                if($result1){

                }

            }

        }else if ($cleaning_frequency == "EVERY_WEEK"){

            $modify_departure = date('Y-m-d', strtotime($departure . ' +1 day'));
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('7 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                $sql="INSERT INTO `tbl_housekeeping_clraning_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                $result1 = $conn->query($sql);
                if($result1){

                }

            }

        }else if ($cleaning_frequency == "SPECIFIC_DAY"){
            //do later

        }




        //For laundry


        if($laundry_frequency == "DAILY"){

            $modify_departure =$departure ;

            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";



            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");
                if($new_cleaning_date != $arrival){

                    $sql="INSERT INTO `tbl_housekeeping_laundry_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                    $result1 = $conn->query($sql);
                    if($result1){

                    }

                }
            }


        }else if ($laundry_frequency == "EVERY_SECOUND_DAY"){



            $modify_departure = $departure ;
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('2 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");
                if($new_cleaning_date != $arrival){
                    $sql="INSERT INTO `tbl_housekeeping_laundry_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                    $result1 = $conn->query($sql);
                    if($result1){

                    }

                }

            }

        }else if ($laundry_frequency == "EVERY_THIRD_DAY"){

            $modify_departure = $departure ;
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('3 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                if($new_cleaning_date != $arrival){

                    $sql="INSERT INTO `tbl_housekeeping_laundry_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                    $result1 = $conn->query($sql);
                    if($result1){

                    }
                }



            }



        }else if ($laundry_frequency == "EVERY_FOURTH_DAY"){


            $modify_departure = $departure ;
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('4 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");

                if($new_cleaning_date != $arrival){
                    $sql="INSERT INTO `tbl_housekeeping_laundry_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                    $result1 = $conn->query($sql);
                    if($result1){

                    }

                }


            }

        }else if ($laundry_frequency == "EVERY_FIFTH_DAY"){

            $modify_departure = $departure ;
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('5 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");
                if($new_cleaning_date != $arrival){
                    $sql="INSERT INTO `tbl_housekeeping_laundry_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                    $result1 = $conn->query($sql);
                    if($result1){

                    }

                }

            }

        }else if ($laundry_frequency == "EVERY_WEEK"){


            $modify_departure =$departure ;
            $begin = new DateTime($arrival);
            $end = new DateTime($modify_departure);
            $interval = DateInterval::createFromDateString('7 day');
            $period = new DatePeriod($begin, $interval, $end);

            $new_cleaning_date = "";
            foreach ($period as $dt) {

                $new_cleaning_date = $dt->format("Y-m-d");
                if($new_cleaning_date != $arrival){
                    $sql="INSERT INTO `tbl_housekeeping_laundry_dates`( `rms_id`, `date`, `rmrs_id`,`hotel_id`) VALUES ('$rms_id','$new_cleaning_date','$rmrs_id','$hotel_id')";
                    $result1 = $conn->query($sql);
                    if($result1){

                    }
                }

            }
        }
        else if ($laundry_frequency == "SPECIFIC_DAY"){

        }




    }}

//Breakfast reset

$now_time_date = date("Y-m-d H:i:s");

$sql2="SELECT `is_breakfast_time`,`hskp_id` FROM `tbl_housekeeping`  WHERE `is_breakfast` = 1";
$result2 = $conn->query($sql2);
if ($result2 && $result2->num_rows > 0) {
    while($row2 = mysqli_fetch_array($result2)) {
        $is_breakfast_name = $row2['is_breakfast_time'];

        $hskp_id = $row2['hskp_id'];
        $datetime_1 = $is_breakfast_name; 
        $datetime_2 = $now_time_date; 
        $start_datetime = new DateTime($datetime_1); 
        $diff = $start_datetime->diff(new DateTime($datetime_2)); 
        $days = $diff->days;
        $minutes = $diff->i;
        $hours = $diff->h;
        if($days > 0 || $minutes >= 30 || $hours >= 1  ){
            $sql="UPDATE `tbl_housekeeping` SET `is_breakfast`= 0,`is_breakfast_time` = '' WHERE   `hskp_id` =  $hskp_id";
            $result1 = $conn->query($sql);
        }else{

        }
    }
}
?>