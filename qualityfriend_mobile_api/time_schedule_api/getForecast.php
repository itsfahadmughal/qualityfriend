<?php

require '../../forecast_utills/sales-forecasting/vendor/autoload.php';
use Cozy\ValueObjects\Matrix;

if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration
    $year_ = date("Y");
    $hotel_id= 0;
    $user_id= 0;
    $today = date("Y-m-d");
    $months_name_array = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $rooms=$beds=$opening_days=$stay_capacity_arr=$accomodation_sale_arr=$anicillary_sale_arr=$total_stay_arr=$spa_sale_arr=0;

    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }



    function forecast_prediction($conn,$input_data_,$date_forecast_,$i_,$current_year_working){


        // EXTRACT PHASE
        $date_forecast = $date_forecast_;
        $input_data = $input_data_;
        $i = $i_;

        $split = explode("/",$date_forecast);
        $n =   intval($split[0]);
        $slug = 12 - (intval($split[0]));
        for($k=0;$k<$slug;$k++){
            $n++;
            $input_data[$i] = [
                'period' => $i,
                'date' => $n.'/'.$split[1].'/'.$split[2],
                'sales' => '',
            ];
            $i++;
        }

        // TRANSFORM PHASE

        $dependent_var = [];
        $independent_vars = [];
        $future_independent_vars = [];
        $result = [];

        foreach ($input_data as $datum) {
            $dt = new DateTimeImmutable($datum['date']);

            $vars = [
                1, // β₀
                $datum['period'],
            ];

            if ($dt->format('m') === '01') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '02') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '03') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '04') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '05') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '06') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '07') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '08') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '09') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '10') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            if ($dt->format('m') === '11') {
                $vars[] = 1;
            } else {
                $vars[] = 0;
            }

            // Prepare the observable variables with existent data sales revenue
            if ($datum['sales']) {
                $dependent_var[] = [(float)$datum['sales']];
                $independent_vars[] = $vars;
            }

            $result[$datum['period']] = [
                'date' => $datum['date'],
                'month' => $dt->format('M Y'),
                'sales' => $datum['sales'] ? (float)$datum['sales'] : null,
                'forecast' => null,
                'error_rate' => null,
                'independent_vars' => $vars,
            ];
        }


        // SUPERVISED TRAINING PHASE

        $X = new Matrix($independent_vars);
        $y = new Matrix($dependent_var);

        $B = $X
            ->transpose()
            ->multiply($X)
            ->inverse()
            ->multiply($X->transpose()->multiply($y));

        // Get the coefficient vector of the least-squares hyperplane
        $coefficients = $B->getColumnValues(1);


        // PREDICTION PHASE

        $error_rates = [];

        foreach ($result as $period => $data) {
            $forecast = 0;
            foreach ($coefficients as $index => $coefficient) {
                $forecast += round($coefficient * $data['independent_vars'][$index], 3);
            }

            $result[$period]['forecast'] = $forecast;

            if ($data['sales']) {
                $error_rate = round(($data['sales'] - $forecast) / $data['sales'], 3);
                $error_rates[] = $result[$period]['error_rate'] = $error_rate * 100;
            }

            unset($result[$period]['independent_vars']);
        }

        $average_error_rate = round(array_sum($error_rates) / count($error_rates), 1);


        $new_result = 0;
        $time=strtotime(date("Y-m-d"));
        $month_current=date("m",$time);
        for($j=0;$j<sizeof($result);$j++){
            $compy = strtotime($result[$j]['date']);
            if($current_year_working == date("Y", $compy) && $month_current >= date("m", $compy)){
                $new_result += $result[$j]['forecast'];
            }
        }

        return $new_result;
        //        print_r($result);
        //    exit;

    }


    //Working
    $time=strtotime(date("Y-m-d"));
    $month_current=date("m",$time);

    $sql_inner_1="SELECT SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN ((adults+infants+children) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1)) ELSE (adults+infants+children) * (DATEDIFF(`departure`, `arrival`) + 1) END) as stay_off, SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN (`accommodation_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1) + (`additionalServices_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1) ELSE `accommodation_sale`+`additionalServices_sale` END) as acc_sale FROM `tbl_forecast_reservations_rooms` WHERE hotel_id = $hotel_id AND MONTH(`arrival`) = $month_current AND YEAR(`arrival`) = $year_ AND `status` IN ('reserved','roomFixed','departed','occupied')";
    $result_inner_1 = $conn->query($sql_inner_1);

    $sql_inner_11="SELECT SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN ((adults+infants+children) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1)) ELSE 0 END) as stay_off , SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN (`accommodation_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1) + (`additionalServices_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1) ELSE 0 END) as acc_sale FROM `tbl_forecast_reservations_rooms` WHERE hotel_id = $hotel_id AND MONTH(`departure`) = $month_current AND YEAR(`departure`) = $year_ AND `status` IN ('reserved','roomFixed','departed','occupied')";
    $result_inner_11 = $conn->query($sql_inner_11);

    $sale_off=0;
    $stay_off=0;
    $sale_off1=0;
    $stay_off1=0;
    if ($result_inner_11 && $result_inner_11->num_rows > 0) {
        while ($row_inner_11 = mysqli_fetch_array($result_inner_11)) {
            $sale_off1 = $row_inner_11['acc_sale'];
            $stay_off1 = $row_inner_11['stay_off'];
        }
    }else{
        $sale_off1 = 0;
        $stay_off1 = 0;
    }

    if ($result_inner_1 && $result_inner_1->num_rows > 0) {
        while ($row_inner_1 = mysqli_fetch_array($result_inner_1)) {
            $sale_off = $row_inner_1['acc_sale'];
            $stay_off = $row_inner_1['stay_off'];

            $accomodation_sale_arr = $sale_off+$sale_off1;
            $total_stay_arr = $stay_off+$stay_off1;
        }
    }else{
        $accomodation_sale_arr = $sale_off+$sale_off1;
        $total_stay_arr = $stay_off+$stay_off1;
    }




    $sql_inner_2="SELECT Ancillary_Revenues_Net,Spa_Revenues_Net_22 FROM `tbl_forecast_revenues` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month_current AND YEAR(`date`) =  $year_";

    $result_inner_2 = $conn->query($sql_inner_2);
    if ($result_inner_2 && $result_inner_2->num_rows > 0) {
        while ($row_inner_2 = mysqli_fetch_array($result_inner_2)) { 
            $anicillary_sale_arr=$row_inner_2['Ancillary_Revenues_Net'];
            $spa_sale_arr=$row_inner_2['Spa_Revenues_Net_22'];
        }
    }else{
        $anicillary_sale_arr = 0;
        $spa_sale_arr = 0;
    }

    $sql_inner_3="SELECT * FROM `tbl_forecast_keyfacts` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month_current AND YEAR(`date`) =  $year_";
    $result_inner_3 = $conn->query($sql_inner_3);
    if ($result_inner_3 && $result_inner_3->num_rows > 0) {
        while ($row_inner_3 = mysqli_fetch_array($result_inner_3)) { 
            $stay_capacity_arr = $row_inner_3['total_stay_capacity'];
            $rooms = $row_inner_3['rooms'];
            $beds = $row_inner_3['beds'];
            $opening_days = $row_inner_3['opening_days'];
        }
    }else{
        $stay_capacity_arr = 0;
        $rooms = 0;
        $beds = 0;
        $opening_days = 0;
    }


    $last_day = date('Y-m-d', strtotime(' -1 day'));
    $sql_inner_last_day="SELECT SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN ((adults+infants+children) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1)) ELSE (adults+infants+children) * (DATEDIFF(`departure`, `arrival`) + 1) END) as stay_off, SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN (`accommodation_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1) + (`additionalServices_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1) ELSE `accommodation_sale`+`additionalServices_sale` END) as acc_sale FROM `tbl_forecast_reservations_rooms` WHERE hotel_id = $hotel_id AND `arrival` = '$last_day' AND `status` IN ('reserved','roomFixed','departed','occupied')";
    $result_inner_last_day = $conn->query($sql_inner_last_day);

    $sql_inner_last_day1="SELECT SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN ((adults+infants+children) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1)) ELSE 0 END) as stay_off , SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN (`accommodation_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1) + (`additionalServices_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1) ELSE 0 END) as acc_sale FROM `tbl_forecast_reservations_rooms` WHERE hotel_id = $hotel_id AND `arrival` = '$last_day' AND `status` IN ('reserved','roomFixed','departed','occupied')";
    $result_inner_last_day1 = $conn->query($sql_inner_last_day1);

    $sale_off_last_day=0;
    $sale_off_last_day1=0;
    $accomodation_sale_arr_last_day= 0;

    if ($result_inner_last_day1 && $result_inner_last_day1->num_rows > 0) {
        while ($row_inner_11 = mysqli_fetch_array($result_inner_last_day1)) {
            $sale_off_last_day1 = $row_inner_11['acc_sale'];
        }
    }else{
        $sale_off_last_day1 = 0;
    }

    if ($result_inner_last_day && $result_inner_last_day->num_rows > 0) {
        while ($row_inner_1 = mysqli_fetch_array($result_inner_last_day)) {
            $sale_off_last_day = $row_inner_1['acc_sale'];

            $accomodation_sale_arr_last_day = $sale_off_last_day+$sale_off_last_day1;
        }
    }else{
        $accomodation_sale_arr_last_day = $sale_off_last_day+$sale_off_last_day1;
    }


    $accomodation_sale_arr1=$anicillary_sale_arr1=$spa_sale_arr1=array();
    $pre_year_3 = $year_-3;
    $index_forecast_data=0;
    $date_forecast_last = "";

    $sql_cost_forecast = "SELECT *, DATE_FORMAT(`date`, '%m/%d/%Y') as date_final FROM `tbl_forecast_expenses` WHERE `hotel_id` = $hotel_id AND YEAR(`date`) > $pre_year_3 and YEAR(`date`) <= $year_ ORDER BY `date` ASC";
    $result_cost_forecast = $conn->query($sql_cost_forecast);
    if ($result_cost_forecast && $result_cost_forecast->num_rows > 13) {
        while ($row = mysqli_fetch_array($result_cost_forecast)) {

            $time=strtotime($row['date']);
            $month=date("m",$time);
            $year=date("Y",$time);



            $sql_inner_1="SELECT SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN ((adults+infants+children) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1)) ELSE (adults+infants+children) * (DATEDIFF(`departure`, `arrival`) + 1) END) as stay_off, SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN (`accommodation_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1) + (`additionalServices_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( LAST_DAY(`arrival`), `arrival`) + 1) ELSE `accommodation_sale`+`additionalServices_sale` END) as acc_sale FROM `tbl_forecast_reservations_rooms` WHERE hotel_id = $hotel_id AND MONTH(`arrival`) = $month AND YEAR(`arrival`) = $year AND `status` IN ('reserved','roomFixed','departed','occupied')";
            $result_inner_1 = $conn->query($sql_inner_1);

            $sql_inner_11="SELECT SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN ((adults+infants+children) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1)) ELSE 0 END) as stay_off , SUM(CASE WHEN MONTH(`arrival`) != MONTH(`departure`) THEN (`accommodation_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1) + (`additionalServices_sale` / (DATEDIFF(`departure`, `arrival`) + 1)) * (DATEDIFF( `departure`,DATE_SUB(`departure`,INTERVAL DAYOFMONTH(`departure`)-1 DAY)) + 1) ELSE 0 END) as acc_sale FROM `tbl_forecast_reservations_rooms` WHERE hotel_id = $hotel_id AND MONTH(`departure`) = $month AND YEAR(`departure`) = $year AND `status` IN ('reserved','roomFixed','departed','occupied')";
            $result_inner_11 = $conn->query($sql_inner_11);

            $sale_off=1;
            $sale_off1=1;
            if ($result_inner_11 && $result_inner_11->num_rows > 0) {
                while ($row_inner_11 = mysqli_fetch_array($result_inner_11)) {
                    if($row_inner_11['acc_sale'] == 0){ $sale_off1 = 1; }else{ $sale_off1 =  $row_inner_11['acc_sale']; };
                }
            }else{
                $sale_off1 = 1;
                $stay_off1 = 1;
            }

            if ($result_inner_1 && $result_inner_1->num_rows > 0) {
                while ($row_inner_1 = mysqli_fetch_array($result_inner_1)) {

                    if($row_inner_1['acc_sale'] == 0){ $sale_off = 1; }else{ $sale_off =  $row_inner_1['acc_sale']; };

                    $accomodation_sale_arr1[$index_forecast_data] = [
                        'period' => $index_forecast_data,
                        'date' => $row['date_final'],
                        'sales' => ($sale_off+$sale_off1),
                    ];
                }
            }else{
                $accomodation_sale_arr1[$index_forecast_data] = [
                    'period' => $index_forecast_data,
                    'date' => $row['date_final'],
                    'sales' => 1,
                ];
            }



            $sql_inner_2="SELECT `Ancillary_Revenues_Net`,`Spa_Revenues_Net_22` FROM `tbl_forecast_revenues` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
            $result_inner_2 = $conn->query($sql_inner_2);
            if ($result_inner_2 && $result_inner_2->num_rows > 0) {
                while ($row_inner_2 = mysqli_fetch_array($result_inner_2)) {

                    if($row_inner_2['Ancillary_Revenues_Net'] == 0){
                        $row_inner_2['Ancillary_Revenues_Net'] = 1;
                    }
                    if($row_inner_2['Spa_Revenues_Net_22'] == 0){
                        $row_inner_2['Spa_Revenues_Net_22'] = 1;
                    }
                    $anicillary_sale_arr1[$index_forecast_data] = [
                        'period' => $index_forecast_data,
                        'date' => $row['date_final'],
                        'sales' => $row_inner_2['Ancillary_Revenues_Net'],
                    ];
                    $spa_sale_arr1[$index_forecast_data] = [
                        'period' => $index_forecast_data,
                        'date' => $row['date_final'],
                        'sales' => $row_inner_2['Spa_Revenues_Net_22'],
                    ];
                }
            }else{
                $anicillary_sale_arr1[$index_forecast_data] = [
                    'period' => $index_forecast_data,
                    'date' => $row['date_final'],
                    'sales' => 1,
                ];
                $spa_sale_arr1[$index_forecast_data] = [
                    'period' => $index_forecast_data,
                    'date' => $row['date_final'],
                    'sales' => 1,
                ];
            }



            $date_forecast_last = $row['date_final'];
            $index_forecast_data++;

        }
    }else{
        $accomodation_sale_arr1=$anicillary_sale_arr1=$spa_sale_arr1=array(0);
    }




    $temp = array();
    $data1 = array();
    $temp1=array();

    $temp['total_sale_this_month'] =   number_format(round($accomodation_sale_arr + $anicillary_sale_arr + $spa_sale_arr,2), 1, ',', '.').' €';
    if($total_stay_arr != 0 && $stay_capacity_arr != 0){
        $temp['occupancy_rate_this_month'] =   number_format(round(($total_stay_arr*100)/$stay_capacity_arr,2), 1, ',', '.').'%';
    }else{
        $temp['occupancy_rate_this_month'] =   number_format(round(0,2), 1, ',', '.').' %';
    }
    $temp['average_sale_per_night'] =   number_format(round((($spa_sale_arr*1.22)+($anicillary_sale_arr*1.1)+($accomodation_sale_arr*1.1))/$total_stay_arr,2), 1, ',', '.').' €';
    $temp['yesterday_sale'] = number_format(round($accomodation_sale_arr_last_day,2), 1, ',', '.').' €';

    if(sizeof($accomodation_sale_arr1) > 13 && $accomodation_sale_arr1 != null){
        $temp['total_sale_forecast_till_today_this_year'] =   number_format(round(forecast_prediction($conn,$accomodation_sale_arr1,$date_forecast_last,$index_forecast_data,$year_),2), 1, ',', '.').' €';
        $temp['total_sale_forecast_till_today_last_year'] =   number_format(round(forecast_prediction($conn,$accomodation_sale_arr1,$date_forecast_last,$index_forecast_data,($year_-1)),2), 1, ',', '.').' €';
    }else{
        $temp['total_sale_forecast_till_today_this_year'] =   number_format(round(0,2), 1, ',', '.').' €';
        $temp['total_sale_forecast_till_today_last_year'] =   number_format(round(0,2), 1, ',', '.').' €';
    }

    array_push($data1, $temp);
    unset($temp);
    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";

    echo json_encode(array('Status' => $temp1,'Data' => $data1));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data1));
}
$conn->close();

?>