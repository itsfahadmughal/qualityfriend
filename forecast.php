<?php
include 'util_config.php';
include 'util_session.php';
//include 'forecast_utils/read_xml_forecast.php';

$year_ = date("Y");

require './forecast_utills/sales-forecasting/vendor/autoload.php';
use Cozy\ValueObjects\Matrix;

function forecast_prediction($conn,$input_data_,$date_forecast_,$i_){


    // EXTRACT PHASE
    $date_forecast = $date_forecast_;
    $input_data = $input_data_;
    $i = $i_;

    //$sql="SELECT ROUND(SUM(`accommodation_sale`),2) as total_sale, DATE_FORMAT(`date`, '%m/%d/%Y') as date_final FROM `tbl_forecast_reservations_rooms` WHERE `hotel_id` = 1 GROUP BY MONTH(`date`), YEAR(`date`) ORDER By `date` ASC";
    //    $sql="SELECT costs_of_ancillary_goods, DATE_FORMAT(`date`, '%m/%d/%Y') as date_final FROM `tbl_forecast_expenses` WHERE `hotel_id` = 1 AND YEAR(`date`) >= 2022 ORDER BY `date` ASC";
    //
    //    $result = $conn->query($sql);
    //    if ($result && $result->num_rows > 0) {
    //        while($row = mysqli_fetch_array($result)) {
    //            $input_data[$i] = [
    //                'period' => $i,
    //                'date' => $row['date_final'],
    //                'sales' => $row['costs_of_ancillary_goods'],
    //            ];
    //            $date_forecast = $row['date_final'];
    //            $i++;
    //        }
    //    }


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


    $new_result = array();
    for($j=0;$j<sizeof($result);$j++){
        $compy = strtotime($result[$j]['date']);
        if(date("Y") == date("Y", $compy)){
            array_push($new_result,$result[$j]['forecast']);
        }
    }

    return $new_result;
    //    print_r($new_result);
    //    exit;

}



//forecast_prediction($conn);



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
        <title>Budget &amp; Forecast</title>
        <!-- Footable CSS -->
        <link href="./assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="./assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

        <link href="./dist/css/style.min.css" rel="stylesheet">
        <link href="./dist/css/forecast.css" rel="stylesheet">

        <link href="./assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

        <link href="./assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="./assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Budget &amp; Forecast</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">

            <div id="responsive-modal-department" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="display-inline text-left">Staffing Departments</h3>
                            <button type="button" class="close" data-dismiss="modal" onclick="dismiss_modal_delete_department();" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group" id="delete_shift_date_form">
                                    <label for="message-text" class="control-label ml-1"><b>Staff Department Title</b></label>

                                    <input type="text" class="form-control w-80" placeholder="e.g. Reception, Mgmt/Adm, Kitchen..." id="depart_title_modal" />
                                    <input type="button" onclick="add_department();" class="btn w-18 btn-success" value="Add">

                                </div>
                                <div class="form-group">
                                    <div class="p-2 h-400px" id="reload_departments">
                                        <div class="form-group mb-0">
                                            <label class="control-label display-inline w-80 wm-50"><strong>Staff Department Title</strong></label>
                                            <label class="control-label display-inline w-18 wm-50"><strong>Action</strong></label>
                                        </div>
                                        <?php
                                        $sql_depart = "SELECT * FROM `tbl_forecast_staffing_department` WHERE hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 ORDER BY 1 DESC";

                                        $result_depart = $conn->query($sql_depart);
                                        if ($result_depart && $result_depart->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result_depart)) {
                                        ?>
                                        <div class="form-group mb-0 border_bottom_1px_black p-2">
                                            <label class="control-label display-inline w-80 wm-50"><?php echo $row['title']; ?></label>
                                            <label class="control-label display-inline w-18 wm-50 mt-1"> <a href="javascript:void(0)" onclick="delete_depart('<?php echo $row['frcstfd_id']; ?>')"><i class="fas fa-trash font-size-subheading text-right"></i></a></label>
                                        </div>

                                        <?php 
                                            } 
                                        }
                                        ?>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" onclick="dismiss_modal_delete_department();" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <?php include 'util_header.php'; ?>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <?php include 'util_side_nav.php'; ?>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles mobile-container-padding heading_style">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Budget &amp; Forecast</h4>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-3 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                    <li class="breadcrumb-item text-success">Budget &amp; Forecast</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-0 pt-1">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home5" role="tab" aria-controls="home5" aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Dashboard</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Budget Effective</span></a></li>
                                        <li class="nav-item"> <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Budget Forecast</span></a></li>
                                        <li class="nav-item"> <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Working</span></a></li>
                                        <li class="nav-item"> <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#profile1" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Yearly Forecast</span></a></li>
                                        <li class="nav-item"> <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#profile5" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Staffing</span></a></li>
                                        <li class="nav-item"> <a class="nav-link" id="profile-tab6" data-toggle="tab" href="#profile6" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Goods Purchasings</span></a></li>
                                        <!--                                        <li class="nav-item"> <a class="nav-link" id="profile-tab7" data-toggle="tab" href="#profile7" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Forecast Effective Sale</span></a></li>-->

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false">
                                                <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Settings</span>
                                            </a>
                                            <div class="dropdown-menu"> 
                                                <a class="dropdown-item" id="dropdown1-tab" href="#dropdown1" role="tab" data-toggle="tab" aria-controls="dropdown1">Revenues</a> 
                                                <a class="dropdown-item" id="dropdown2-tab" href="#dropdown2" role="tab" data-toggle="tab" aria-controls="dropdown2">Expenses</a> 
                                                <a class="dropdown-item" id="dropdown3-tab" href="#dropdown3" role="tab" data-toggle="tab" aria-controls="dropdown3">Key Facts</a>
                                                <a class="dropdown-item" id="dropdown4-tab" href="#dropdown4" role="tab" data-toggle="tab" aria-controls="dropdown4">Staffing</a> 
                                                <a class="dropdown-item" id="dropdown5-tab" href="#dropdown5" role="tab" data-toggle="tab" aria-controls="dropdown5">Goods Purchasings</a> 
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="tab-content tabcontent-border p-20 pl-0 pr-0" id="myTabContent">
                                        <div role="tabpanel" class="tab-pane fade show active" id="home5" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 class="forecast_main_color p-3">BUDGET PREVIEW [FORECAST VS EFFECTIVE]</h3>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="table-responsive text-center">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" colspan="2">Select Month</th>
                                                                    <th class="forecast_secondary_color">Total</th>
                                                                </tr>
                                                                <tr class="forecast_gray_color">
                                                                    <th>Description</th>
                                                                    <th>Forecast</th>
                                                                    <th>Effective</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="forecast_main_color">
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                </tr>
                                                                <tr class="">
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="table-responsive text-center">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-left" colspan="14">Budget Overview</th>
                                                                </tr>
                                                                <tr class="forecast_main_color">
                                                                    <th>Month</th>
                                                                    <th>Total</th>
                                                                    <th>Jan</th>
                                                                    <th>Feb</th>
                                                                    <th>Mar</th>
                                                                    <th>Apr</th>
                                                                    <th>May</th>
                                                                    <th>Jun</th>
                                                                    <th>Jul</th>
                                                                    <th>Aug</th>
                                                                    <th>Sep</th>
                                                                    <th>Oct</th>
                                                                    <th>Nov</th>
                                                                    <th>Dec</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="">
                                                                    <td><?php echo 'Betriebserlöse Forecast'; ?></td>
                                                                    <td class="forecast_secondary_color"><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                    <td><?php echo 'abewadsaec'; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <h4 class="card-title">Doughnut Chart</h4>
                                                            <div id="doughnut-chart" style="width:100%; height:400px;"></div>
                                                            <h4 class="card-title">Bar chart 3</h4>
                                                            <div id="bar-chart3" style="width:100%; height:50%;"></div>
                                                        </div>
                                                        <div class="col-lg-6">

                                                            <h4 class="card-title">Line chart</h4>
                                                            <div id="main" style="width:100%; height:300px;"></div>

                                                            <h4 class="card-title">Line chart 2</h4>
                                                            <div id="main2" style="width:100%; height:300px;"></div>

                                                            <h4 class="card-title">Bar chart</h4>
                                                            <div id="bar-chart" style="width:100%; height:300px;"></div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <h4 class="card-title">Bar chart 2</h4>
                                                            <div id="bar-chart2" style="width:100%; height:97%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                                            <div class="row"> 
                                                <div class="col-lg-12">
                                                    <h3 class="forecast_main_color p-3 text-center">Budget Preview (Effective)</h3>
                                                </div>

                                                <?php $months_arr=$staffing_arr=$goods_cost_arr=$stay_capacity_arr=$acc_balance_arr=$accomodation_sale_arr=$anicillary_sale_arr=$total_stay_arr=$spa_sale_arr=$anicillary_arr=$spa_arr=$t_opr_cost_arr=$adm_cost_arr=$marketing_arr=$taxes_arr=$bank_charges_arr=$total_loan_arr=$other_costs_arr=$date_cost=array();
                                                $sql_cost_effective = "SELECT * FROM `tbl_forecast_expenses` WHERE `hotel_id` = $hotel_id AND YEAR(`date`) = $year_ ORDER BY `date` ASC";
                                                $result_cost_effective = $conn->query($sql_cost_effective);
                                                if ($result_cost_effective && $result_cost_effective->num_rows > 0) {
                                                    while ($row = mysqli_fetch_array($result_cost_effective)) {
                                                        array_push($anicillary_arr,$row['costs_of_ancillary_goods']);
                                                        array_push($spa_arr,$row['costs_of_spa_products']);
                                                        array_push($t_opr_cost_arr,$row['total_operating_cost']);
                                                        array_push($adm_cost_arr,$row['administration_cost']);
                                                        array_push($marketing_arr,$row['marketing']);
                                                        array_push($taxes_arr,$row['taxes']);
                                                        array_push($bank_charges_arr,$row['bank_charges']);
                                                        array_push($total_loan_arr,$row['total_loan']);
                                                        array_push($other_costs_arr,$row['other_costs']);
                                                        array_push($date_cost,$row['date']);

                                                        $time=strtotime($row['date']);
                                                        $month=date("m",$time);
                                                        array_push($months_arr,$month);
                                                        $year=date("Y",$time);

                                                        $sql_inner_1="SELECT ROUND(SUM(`accommodation_sale`),2) AS acc_sale, ROUND(SUM(`additionalServices_sale`+`extras_sale`),2) AS ancill_sale, ROUND(SUM(`spa_sale`),2) AS spa_sale, COUNT(frcrrm_id) as total_stay FROM `tbl_forecast_reservations_rooms` WHERE `status` != 'cancelled' AND hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_1 = $conn->query($sql_inner_1);
                                                        if ($result_inner_1 && $result_inner_1->num_rows > 0) {
                                                            while ($row_inner_1 = mysqli_fetch_array($result_inner_1)) {
                                                                array_push($accomodation_sale_arr,$row_inner_1['acc_sale']);
                                                                array_push($anicillary_sale_arr,$row_inner_1['ancill_sale']);
                                                                array_push($spa_sale_arr,$row_inner_1['spa_sale']);
                                                                array_push($total_stay_arr,$row_inner_1['total_stay']);
                                                            }
                                                        }else{
                                                            array_push($accomodation_sale_arr,0);
                                                            array_push($anicillary_sale_arr,0);
                                                            array_push($spa_sale_arr,0);
                                                            array_push($total_stay_arr,0);
                                                        }


                                                        $sql_inner_2="SELECT `bank_account_balance` FROM `tbl_forecast_revenues` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_2 = $conn->query($sql_inner_2);
                                                        if ($result_inner_2 && $result_inner_2->num_rows > 0) {
                                                            while ($row_inner_2 = mysqli_fetch_array($result_inner_2)) { array_push($acc_balance_arr,$row_inner_2['bank_account_balance']);
                                                                                                                       }
                                                        }else{
                                                            array_push($acc_balance_arr,0);
                                                        }

                                                        $sql_inner_3="SELECT `total_stay_capacity` FROM `tbl_forecast_keyfacts` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_3 = $conn->query($sql_inner_3);
                                                        if ($result_inner_3 && $result_inner_3->num_rows > 0) {
                                                            while ($row_inner_3 = mysqli_fetch_array($result_inner_3)) { array_push($stay_capacity_arr,$row_inner_3['total_stay_capacity']);
                                                                                                                       }
                                                        }else{
                                                            array_push($stay_capacity_arr,0);
                                                        }

                                                        $sql_inner_4="SELECT SUM(`total_cost`) as total_cost_t FROM `tbl_forecast_goods_cost` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_4 = $conn->query($sql_inner_4);
                                                        if ($result_inner_4 && $result_inner_4->num_rows > 0) {
                                                            while ($row_inner_4 = mysqli_fetch_array($result_inner_4)) { array_push($goods_cost_arr,$row_inner_4['total_cost_t']);
                                                                                                                       }
                                                        }else{
                                                            array_push($goods_cost_arr,0);
                                                        }

                                                        $sql_inner_5="SELECT SUM(`gross_salary`) as salary FROM `tbl_forecast_staffing_cost` WHERE hotel_id = $hotel_id AND `year` = $year";
                                                        $result_inner_5 = $conn->query($sql_inner_5);
                                                        if ($result_inner_5 && $result_inner_5->num_rows > 0) {
                                                            while ($row_inner_5 = mysqli_fetch_array($result_inner_5)) { array_push($staffing_arr,$row_inner_5['salary']);
                                                                                                                       }
                                                        }else{
                                                            array_push($staffing_arr,0);
                                                        }

                                                    }
                                                ?>

                                                <div class="col-lg-12">
                                                    <div class="table-responsive text-center">
                                                        <table class="table">
                                                            <thead>
                                                                <tr class="forecast_gray_color">
                                                                    <th></th>
                                                                    <th>Total</th>
                                                                    <th>Jan</th>
                                                                    <th>Feb</th>
                                                                    <th>Mar</th>
                                                                    <th>Apr</th>
                                                                    <th>May</th>
                                                                    <th>Jun</th>
                                                                    <th>Jul</th>
                                                                    <th>Aug</th>
                                                                    <th>Sep</th>
                                                                    <th>Oct</th>
                                                                    <th>Nov</th>
                                                                    <th>Dec</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Auslastung der ÖT in % /Occupancy rate in %'; ?></td>

                                                                    <td><?php echo round((array_sum($total_stay_arr)*100)/array_sum($stay_capacity_arr)).'%'; ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo round(($total_stay_arr[$i]*100)/$stay_capacity_arr[$i],2).'%'; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo '0.00%'; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?> 

                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr><td class="text-left" colspan="14"><b><?php echo 'Betriebserlöse /Operating Revenue'; ?></b></td></tr>

                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Logisumsätze Netto / Hotel Revenues Net'; ?></td>
                                                                    <td><?php echo array_sum($accomodation_sale_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $accomodation_sale_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Nebenerlöse Netto / Ancillary Revenues Net'; ?></td>
                                                                    <td><?php echo array_sum($anicillary_sale_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $anicillary_sale_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Spa-Umsätze (22%) Netto/Spa Revenues Net'; ?></td>
                                                                    <td><?php echo array_sum($spa_sale_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $spa_sale_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="forecast_light_gray_color">
                                                                    <td class="text-left"><?php echo 'Gesamt'; ?></td>
                                                                    <td><?php echo array_sum($accomodation_sale_arr)+array_sum($anicillary_sale_arr)+array_sum($spa_sale_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $accomodation_sale_arr[$i]+$spa_sale_arr[$i]+$anicillary_sale_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>


                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr><td class="text-left" colspan="14"><b><?php echo 'Betriebsaufwände/Operating Costs'; ?></b></td></tr>
                                                                <tr><td class="text-left" colspan="14"><?php echo 'Wareneinsätze'; ?></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Wes Hp /Costs Of Goods Halfboard'; ?></td>
                                                                    <td><?php echo array_sum($goods_cost_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $goods_cost_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Wes Nebenerlöse /Costs Of Ancillary Goods'; ?></td>
                                                                    <td><?php echo array_sum($anicillary_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $anicillary_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Wes Spa /Costs Of Spa Products'; ?></td>
                                                                    <td><?php echo array_sum($spa_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $spa_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="forecast_light_gray_color">
                                                                    <td class="text-left"><?php echo 'Gesamt'; ?></td>
                                                                    <td><?php echo array_sum($spa_arr)+array_sum($anicillary_arr)+array_sum($goods_cost_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $spa_arr[$i]+$anicillary_arr[$i]+$goods_cost_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>




                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Mitarbeiter/Staffing'; ?></td>
                                                                    <td><?php echo array_sum($staffing_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $staffing_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Betriebskosten Gesamt/Total Cost'; ?></td>
                                                                    <td><?php echo array_sum($t_opr_cost_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $t_opr_cost_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Verwaltungskosten /Administration Costs'; ?></td>
                                                                    <td><?php echo array_sum($adm_cost_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $adm_cost_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Marketing/Marketing'; ?></td>
                                                                    <td><?php echo array_sum($marketing_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $marketing_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Steuern Und Gebühren/Taxes'; ?></td>
                                                                    <td><?php echo array_sum($taxes_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $taxes_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Bankspesen, Kk-Gebühren/Bank Charges'; ?></td>
                                                                    <td><?php echo array_sum($bank_charges_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $bank_charges_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Sonst. Aufwände /Other Costs'; ?></td>
                                                                    <td><?php echo array_sum($other_costs_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $other_costs_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="forecast_light_gray_color">
                                                                    <td class="text-left"><?php echo 'Betriebsaufwände /Total Costs'; ?></td>
                                                                    <td><?php echo array_sum($other_costs_arr)+array_sum($bank_charges_arr)+array_sum($taxes_arr)+array_sum($marketing_arr)+array_sum($adm_cost_arr)+array_sum($t_opr_cost_arr)+array_sum($staffing_arr)+array_sum($goods_cost_arr)+array_sum($anicillary_arr)+array_sum($spa_arr); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo $other_costs_arr[$i]+$bank_charges_arr[$i]+$taxes_arr[$i]+$marketing_arr[$i]+$adm_cost_arr[$i]+$t_opr_cost_arr[$i]+$staffing_arr[$i]+$goods_cost_arr[$i]+$anicillary_arr[$i]+$spa_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="forecast_light_gray2_color">
                                                                    <td class="text-left"><?php echo 'Gross Operating Profit (Be1)'; ?></td>
                                                                    <td><?php echo (array_sum($accomodation_sale_arr)+array_sum($anicillary_sale_arr)+array_sum($spa_sale_arr))-(array_sum($other_costs_arr)+array_sum($bank_charges_arr)+array_sum($taxes_arr)+array_sum($marketing_arr)+array_sum($adm_cost_arr)+array_sum($t_opr_cost_arr)+array_sum($staffing_arr)+array_sum($goods_cost_arr)+array_sum($anicillary_arr)+array_sum($spa_arr)); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                                    ?>
                                                                    <td><?php echo ($accomodation_sale_arr[$i]+$spa_sale_arr[$i]+$anicillary_sale_arr[$i])-($other_costs_arr[$i]+$bank_charges_arr[$i]+$taxes_arr[$i]+$marketing_arr[$i]+$adm_cost_arr[$i]+$t_opr_cost_arr[$i]+$staffing_arr[$i]+$goods_cost_arr[$i]+$anicillary_arr[$i]+$spa_arr[$i]); ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Total BankKonto'; ?></td>
                                                                    <td><?php 
                                                    $Total_Acc_Balance_Temp = 0;
                                                    if(isset($acc_balance_arr[0])){ echo $acc_balance_arr[0];
                                                                                   $Total_Acc_Balance_Temp = $acc_balance_arr[0];
                                                                                  }else{echo 0;} ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i]) && $i == 0){
                                                                    ?>
                                                                    <td><?php echo $acc_balance_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Total Loan'; ?></td>
                                                                    <td><?php
                                                    $Total_Loan_Temp = 0;
                                                    if(isset($total_loan_arr[0])){ echo $total_loan_arr[0];
                                                                                  $total_Loan_Temp = $total_loan_arr[0];
                                                                                 }else{echo 0;} ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i]) && $i == 0){
                                                                    ?>
                                                                    <td><?php echo $total_loan_arr[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>

                                                                <tr class="forecast_main_color">
                                                                    <td class="text-left"><?php echo 'Liquidität /Liquidity'; ?></td>
                                                                    <td><?php echo (array_sum($accomodation_sale_arr)+array_sum($anicillary_sale_arr)+array_sum($spa_sale_arr)+$Total_Acc_Balance_Temp)-(array_sum($other_costs_arr)+array_sum($bank_charges_arr)+array_sum($taxes_arr)+array_sum($marketing_arr)+array_sum($adm_cost_arr)+array_sum($t_opr_cost_arr)+array_sum($staffing_arr)+array_sum($goods_cost_arr)+array_sum($anicillary_arr)+array_sum($spa_arr)+$Total_Loan_Temp); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($months_arr[$i])){
                                                            if($i == 0){
                                                                    ?>
                                                                    <td><?php echo ($accomodation_sale_arr[$i]+$spa_sale_arr[$i]+$anicillary_sale_arr[$i]+$Total_Acc_Balance_Temp)-($other_costs_arr[$i]+$bank_charges_arr[$i]+$taxes_arr[$i]+$marketing_arr[$i]+$adm_cost_arr[$i]+$t_opr_cost_arr[$i]+$staffing_arr[$i]+$goods_cost_arr[$i]+$anicillary_arr[$i]+$spa_arr[$i]+$Total_Loan_Temp); ?></td>
                                                                    <?php
                                                            }else{
                                                                    ?>
                                                                    <td><?php echo ($accomodation_sale_arr[$i]+$spa_sale_arr[$i]+$anicillary_sale_arr[$i])-($other_costs_arr[$i]+$bank_charges_arr[$i]+$taxes_arr[$i]+$marketing_arr[$i]+$adm_cost_arr[$i]+$t_opr_cost_arr[$i]+$staffing_arr[$i]+$goods_cost_arr[$i]+$anicillary_arr[$i]+$spa_arr[$i]); ?></td>
                                                                    <?php
                                                            }
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php }else{ ?>
                                                <div class="col-lg-12 text-center">
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No Data found.</b></h5>
                                                </div>
                                                <?php } ?>


                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                            <div class="row"> 
                                                <div class="col-lg-12">
                                                    <h3 class="forecast_main_color p-3 text-center">Budget Preview (Forecast)</h3>
                                                </div>

                                                <?php $months_arr1=$staffing_arr1=$goods_cost_arr1=$stay_capacity_arr1=$acc_balance_arr1=$accomodation_sale_arr1=$anicillary_sale_arr1=$total_stay_arr1=$spa_sale_arr1=$anicillary_arr1=$spa_arr1=$t_opr_cost_arr1=$adm_cost_arr1=$marketing_arr1=$taxes_arr1=$bank_charges_arr1=$total_loan_arr1=$other_costs_arr1=$date_cost1=array();
                                                $pre_year_3 = $year_-3;
                                                $index_forecast_data=0;
                                                $date_forecast_last = "";


                                                $sql_cost_forecast = "SELECT *, DATE_FORMAT(`date`, '%m/%d/%Y') as date_final FROM `tbl_forecast_expenses` WHERE `hotel_id` = $hotel_id AND YEAR(`date`) > $pre_year_3 ORDER BY `date` ASC";
                                                $result_cost_forecast = $conn->query($sql_cost_forecast);
                                                if ($result_cost_forecast && $result_cost_forecast->num_rows > 14) {
                                                    while ($row = mysqli_fetch_array($result_cost_forecast)) {

                                                        $anicillary_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['costs_of_ancillary_goods'],
                                                        ];
                                                        $spa_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['costs_of_spa_products'],
                                                        ];
                                                        $t_opr_cost_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['total_operating_cost'],
                                                        ];
                                                        $adm_cost_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['administration_cost'],
                                                        ];
                                                        $marketing_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['marketing'],
                                                        ];
                                                        $taxes_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['taxes'],
                                                        ];
                                                        $bank_charges_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['bank_charges'],
                                                        ];

                                                        array_push($total_loan_arr1,$row['total_loan']);

                                                        $other_costs_arr1[$index_forecast_data] = [
                                                            'period' => $index_forecast_data,
                                                            'date' => $row['date_final'],
                                                            'sales' => $row['other_costs'],
                                                        ];

                                                        array_push($date_cost1,$row['date']);

                                                        $time=strtotime($row['date']);
                                                        $month=date("m",$time);
                                                        array_push($months_arr1,$month);
                                                        $year=date("Y",$time);

                                                        $sql_inner_1="SELECT ROUND(SUM(`accommodation_sale`),2) AS acc_sale, ROUND(SUM(`additionalServices_sale`+`extras_sale`),2) AS ancill_sale, ROUND(SUM(`spa_sale`),2) AS spa_sale, COUNT(frcrrm_id) as total_stay FROM `tbl_forecast_reservations_rooms` WHERE `status` != 'cancelled' AND hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_1 = $conn->query($sql_inner_1);
                                                        if ($result_inner_1 && $result_inner_1->num_rows > 0) {
                                                            while ($row_inner_1 = mysqli_fetch_array($result_inner_1)) {
                                                                $accomodation_sale_arr1[$index_forecast_data] = [
                                                                    'period' => $index_forecast_data,
                                                                    'date' => $row['date_final'],
                                                                    'sales' => $row_inner_1['acc_sale'],
                                                                ];
                                                                $anicillary_sale_arr1[$index_forecast_data] = [
                                                                    'period' => $index_forecast_data,
                                                                    'date' => $row['date_final'],
                                                                    'sales' => $row_inner_1['ancill_sale'],
                                                                ];
                                                                $spa_sale_arr1[$index_forecast_data] = [
                                                                    'period' => $index_forecast_data,
                                                                    'date' => $row['date_final'],
                                                                    'sales' => $row_inner_1['spa_sale'],
                                                                ];
                                                                $total_stay_arr1[$index_forecast_data] = [
                                                                    'period' => $index_forecast_data,
                                                                    'date' => $row['date_final'],
                                                                    'sales' => $row_inner_1['total_stay'],
                                                                ];
                                                            }
                                                        }else{
                                                            $accomodation_sale_arr1[$index_forecast_data] = [
                                                                'period' => $index_forecast_data,
                                                                'date' => $row['date_final'],
                                                                'sales' => 0,
                                                            ];
                                                            $anicillary_sale_arr1[$index_forecast_data] = [
                                                                'period' => $index_forecast_data,
                                                                'date' => $row['date_final'],
                                                                'sales' => 0,
                                                            ];
                                                            $spa_sale_arr1[$index_forecast_data] = [
                                                                'period' => $index_forecast_data,
                                                                'date' => $row['date_final'],
                                                                'sales' => 0,
                                                            ];
                                                            $total_stay_arr1[$index_forecast_data] = [
                                                                'period' => $index_forecast_data,
                                                                'date' => $row['date_final'],
                                                                'sales' => 0,
                                                            ];
                                                        }

                                                        $sql_inner_3="SELECT `total_stay_capacity` FROM `tbl_forecast_keyfacts` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_3 = $conn->query($sql_inner_3);
                                                        if ($result_inner_3 && $result_inner_3->num_rows > 0) {
                                                            while ($row_inner_3 = mysqli_fetch_array($result_inner_3)) {
                                                                $stay_capacity_arr1[$index_forecast_data] = [
                                                                    'period' => $index_forecast_data,
                                                                    'date' => $row['date_final'],
                                                                    'sales' => $row_inner_3['total_stay_capacity'],
                                                                ];
                                                            }
                                                        }else{
                                                            $stay_capacity_arr1[$index_forecast_data] = [
                                                                'period' => $index_forecast_data,
                                                                'date' => $row['date_final'],
                                                                'sales' => 1,
                                                            ];
                                                        }

                                                        $sql_inner_4="SELECT SUM(`total_cost`) as total_cost_t FROM `tbl_forecast_goods_cost` WHERE hotel_id = $hotel_id AND MONTH(`date`) = $month AND YEAR(`date`) =  $year";
                                                        $result_inner_4 = $conn->query($sql_inner_4);
                                                        if ($result_inner_4 && $result_inner_4->num_rows > 0) {
                                                            while ($row_inner_4 = mysqli_fetch_array($result_inner_4)) {
                                                                $goods_cost_arr1[$index_forecast_data] = [
                                                                    'period' => $index_forecast_data,
                                                                    'date' => $row['date_final'],
                                                                    'sales' => $row_inner_4['total_cost_t'],
                                                                ];
                                                            }
                                                        }else{
                                                            $goods_cost_arr1[$index_forecast_data] = [
                                                                'period' => $index_forecast_data,
                                                                'date' => $row['date_final'],
                                                                'sales' => 0,
                                                            ];
                                                        }




                                                        $date_forecast_last = $row['date_final'];
                                                        $index_forecast_data++;

                                                    }

                                                    $sql_inner_2="SELECT `bank_account_balance` FROM `tbl_forecast_revenues` WHERE hotel_id = $hotel_id AND YEAR(`date`) =  $year_ ORDER BY date ASC";
                                                    $result_inner_2 = $conn->query($sql_inner_2);
                                                    if ($result_inner_2 && $result_inner_2->num_rows > 0) {
                                                        while ($row_inner_2 = mysqli_fetch_array($result_inner_2)) {
                                                            array_push($acc_balance_arr1,$row_inner_2['bank_account_balance']);
                                                        }
                                                    }else{
                                                        array_push($acc_balance_arr1,0);
                                                    }

                                                    $sql_inner_5="SELECT SUM(`gross_salary`) as salary FROM `tbl_forecast_staffing_cost` WHERE hotel_id = $hotel_id AND `year` = $year_";
                                                    $result_inner_5 = $conn->query($sql_inner_5);
                                                    $n=0;
                                                    if ($result_inner_5 && $result_inner_5->num_rows > 0) {
                                                        $row_inner_5 = mysqli_fetch_array($result_inner_5);
                                                        while($n < 12) {
                                                            array_push($staffing_arr1,$row_inner_5['salary']);
                                                            $n++;
                                                        }
                                                    }else{
                                                        while($n < 12) {
                                                            array_push($staffing_arr1,0);
                                                            $n++;
                                                        }
                                                    }
                                                ?>

                                                <div class="col-lg-12">
                                                    <div class="table-responsive text-center">
                                                        <table class="table">
                                                            <thead>
                                                                <tr class="forecast_gray_color">
                                                                    <th></th>
                                                                    <th>Total</th>
                                                                    <th>Jan</th>
                                                                    <th>Feb</th>
                                                                    <th>Mar</th>
                                                                    <th>Apr</th>
                                                                    <th>May</th>
                                                                    <th>Jun</th>
                                                                    <th>Jul</th>
                                                                    <th>Aug</th>
                                                                    <th>Sep</th>
                                                                    <th>Oct</th>
                                                                    <th>Nov</th>
                                                                    <th>Dec</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Auslastung der ÖT in % /Occupancy rate in %'; ?></td>
                                                                    <?php 
                                                    $total_stay_arr2 = forecast_prediction($conn,$total_stay_arr1,$date_forecast_last,$index_forecast_data);
                                                    $stay_capacity_arr2 = forecast_prediction($conn,$stay_capacity_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>

                                                                    <td><?php echo round((array_sum($total_stay_arr2)*100)/array_sum($stay_capacity_arr2)).'%'; ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($total_stay_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo round(($total_stay_arr2[$i]*100)/$stay_capacity_arr2[$i],2).'%'; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo '0.00%'; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?> 
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr><td class="text-left" colspan="14"><b><?php echo 'Betriebserlöse /Operating Revenue'; ?></b></td></tr>

                                                                <tr class="">
                                                                    <?php 
                                                    $accomodation_sale_arr2 = forecast_prediction($conn,$accomodation_sale_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>

                                                                    <td class="text-left"><?php echo 'Logisumsätze Netto / Hotel Revenues Net'; ?></td>
                                                                    <td><?php echo array_sum($accomodation_sale_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($accomodation_sale_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $accomodation_sale_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Nebenerlöse Netto / Ancillary Revenues Net'; ?></td>
                                                                    <?php 
                                                    $anicillary_sale_arr2 = forecast_prediction($conn,$anicillary_sale_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>

                                                                    <td><?php echo array_sum($anicillary_sale_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($anicillary_sale_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $anicillary_sale_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Spa-Umsätze (22%) Netto/Spa Revenues Net'; ?></td>
                                                                    <?php 
                                                    $spa_sale_arr2 = forecast_prediction($conn,$spa_sale_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($spa_sale_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($spa_sale_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $spa_sale_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="forecast_light_gray_color">
                                                                    <td class="text-left"><?php echo 'Gesamt'; ?></td>
                                                                    <td><?php echo array_sum($accomodation_sale_arr2)+array_sum($anicillary_sale_arr2)+array_sum($spa_sale_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($spa_sale_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $accomodation_sale_arr2[$i]+$spa_sale_arr2[$i]+$anicillary_sale_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>


                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr><td class="text-left" colspan="14"><b><?php echo 'Betriebsaufwände/Operating Costs'; ?></b></td></tr>
                                                                <tr><td class="text-left" colspan="14"><?php echo 'Wareneinsätze'; ?></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Wes Hp /Costs Of Goods Halfboard'; ?></td>
                                                                    <?php 
                                                    $goods_cost_arr2 = forecast_prediction($conn,$goods_cost_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($goods_cost_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($goods_cost_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $goods_cost_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Wes Nebenerlöse /Costs Of Ancillary Goods'; ?></td>
                                                                    <?php 
                                                    $anicillary_arr2 = forecast_prediction($conn,$anicillary_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($anicillary_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($anicillary_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $anicillary_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Wes Spa /Costs Of Spa Products'; ?></td>
                                                                    <?php 
                                                    $spa_arr2 = forecast_prediction($conn,$spa_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($spa_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($spa_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $spa_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="forecast_light_gray_color">
                                                                    <td class="text-left"><?php echo 'Gesamt'; ?></td>
                                                                    <td><?php echo array_sum($spa_arr2)+array_sum($anicillary_arr2)+array_sum($goods_cost_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($spa_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $spa_arr2[$i]+$anicillary_arr2[$i]+$goods_cost_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>


                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Mitarbeiter/Staffing'; ?></td>
                                                                    <td><?php echo array_sum($staffing_arr1); ?></td>
                                                                    <?php
                                                    for($i=0;$i<sizeof($staffing_arr1);$i++){
                                                        if(isset($staffing_arr1[$i])){
                                                                    ?>
                                                                    <td><?php echo $staffing_arr1[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Betriebskosten Gesamt/Total Cost'; ?></td>
                                                                    <?php 
                                                    $t_opr_cost_arr2 = forecast_prediction($conn,$t_opr_cost_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($t_opr_cost_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($t_opr_cost_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $t_opr_cost_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Verwaltungskosten /Administration Costs'; ?></td>
                                                                    <?php 
                                                    $adm_cost_arr2 = forecast_prediction($conn,$adm_cost_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($adm_cost_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($adm_cost_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $adm_cost_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Marketing/Marketing'; ?></td>
                                                                    <?php 
                                                    $marketing_arr2 = forecast_prediction($conn,$marketing_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($marketing_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($marketing_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $marketing_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Steuern Und Gebühren/Taxes'; ?></td>
                                                                    <?php 
                                                    $taxes_arr2 = forecast_prediction($conn,$taxes_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($taxes_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($taxes_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $taxes_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Bankspesen, Kk-Gebühren/Bank Charges'; ?></td>
                                                                    <?php 
                                                    $bank_charges_arr2 = forecast_prediction($conn,$bank_charges_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($bank_charges_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($bank_charges_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $bank_charges_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Sonst. Aufwände /Other Costs'; ?></td>
                                                                    <?php 
                                                    $other_costs_arr2 = forecast_prediction($conn,$other_costs_arr1,$date_forecast_last,$index_forecast_data);
                                                                    ?>
                                                                    <td><?php echo array_sum($other_costs_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($other_costs_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $other_costs_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr class="forecast_light_gray_color">
                                                                    <td class="text-left"><?php echo 'Betriebsaufwände /Total Costs'; ?></td>
                                                                    <td><?php echo array_sum($other_costs_arr2)+array_sum($bank_charges_arr2)+array_sum($taxes_arr2)+array_sum($marketing_arr2)+array_sum($adm_cost_arr2)+array_sum($t_opr_cost_arr2)+array_sum($staffing_arr1)+array_sum($goods_cost_arr2)+array_sum($anicillary_arr2)+array_sum($spa_arr2); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($spa_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo $other_costs_arr2[$i]+$bank_charges_arr2[$i]+$taxes_arr2[$i]+$marketing_arr2[$i]+$adm_cost_arr2[$i]+$t_opr_cost_arr2[$i]+$staffing_arr1[$i]+$goods_cost_arr2[$i]+$anicillary_arr2[$i]+$spa_arr2[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="forecast_light_gray2_color">
                                                                    <td class="text-left"><?php echo 'Gross Operating Profit (Be1)'; ?></td>
                                                                    <td><?php echo (array_sum($accomodation_sale_arr2)+array_sum($anicillary_sale_arr2)+array_sum($spa_sale_arr2))-(array_sum($other_costs_arr2)+array_sum($bank_charges_arr2)+array_sum($taxes_arr2)+array_sum($marketing_arr2)+array_sum($adm_cost_arr2)+array_sum($t_opr_cost_arr2)+array_sum($staffing_arr1)+array_sum($goods_cost_arr2)+array_sum($anicillary_arr2)+array_sum($spa_arr2)); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($spa_arr2[$i])){
                                                                    ?>
                                                                    <td><?php echo ($accomodation_sale_arr2[$i]+$spa_sale_arr2[$i]+$anicillary_sale_arr2[$i])-($other_costs_arr2[$i]+$bank_charges_arr2[$i]+$taxes_arr2[$i]+$marketing_arr2[$i]+$adm_cost_arr2[$i]+$t_opr_cost_arr2[$i]+$staffing_arr1[$i]+$goods_cost_arr2[$i]+$anicillary_arr2[$i]+$spa_arr2[$i]); ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Total BankKonto'; ?></td>
                                                                    <td><?php 
                                                    $Total_Acc_Balance_Temp = 0;
                                                    if(isset($acc_balance_arr1[0])){ echo $acc_balance_arr1[0];
                                                                                    $Total_Acc_Balance_Temp = $acc_balance_arr1[0];
                                                                                   }else{echo 0;} ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($acc_balance_arr1[$i]) && $i == 0){
                                                                    ?>
                                                                    <td><?php echo $acc_balance_arr1[$i]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo 'Total Loan'; ?></td>
                                                                    <td>
                                                                        <?php
                                                    $full_date_loan = date("Y")."-1-28";

                                                    $index_desired=array_search($full_date_loan,$date_cost1);
                                                    $Total_Loan_Temp = 0;
                                                    if(isset($total_loan_arr1[$index_desired])){ echo $total_loan_arr1[$index_desired];
                                                                                                $total_Loan_Temp = $total_loan_arr1[$index_desired];
                                                                                               }else{echo 0;} ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if(isset($total_loan_arr1[$index_desired]) && $i == 0){
                                                                    ?>
                                                                    <td><?php echo $total_loan_arr1[$index_desired]; ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo 0; ?></td>
                                                                    <?php 
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>
                                                                <tr><td class="custom_td_padding" colspan="14"></td></tr>

                                                                <tr class="forecast_main_color">
                                                                    <td class="text-left"><?php echo 'Liquidität /Liquidity'; ?></td>
                                                                    <td><?php echo (array_sum($accomodation_sale_arr2)+array_sum($anicillary_sale_arr2)+array_sum($spa_sale_arr2)+$Total_Acc_Balance_Temp)-(array_sum($other_costs_arr2)+array_sum($bank_charges_arr2)+array_sum($taxes_arr2)+array_sum($marketing_arr2)+array_sum($adm_cost_arr2)+array_sum($t_opr_cost_arr2)+array_sum($staffing_arr1)+array_sum($goods_cost_arr2)+array_sum($anicillary_arr2)+array_sum($spa_arr2)+$Total_Loan_Temp); ?></td>
                                                                    <?php
                                                    for($i=0;$i<12;$i++){
                                                        if($i == 0){
                                                                    ?>
                                                                    <td><?php echo ($accomodation_sale_arr2[$i]+$spa_sale_arr2[$i]+$anicillary_sale_arr2[$i]+$Total_Acc_Balance_Temp)-($other_costs_arr2[$i]+$bank_charges_arr2[$i]+$taxes_arr2[$i]+$marketing_arr2[$i]+$adm_cost_arr2[$i]+$t_opr_cost_arr2[$i]+$staffing_arr1[$i]+$goods_cost_arr2[$i]+$anicillary_arr2[$i]+$spa_arr2[$i]+$Total_Loan_Temp); ?></td>
                                                                    <?php
                                                        }else{
                                                                    ?>
                                                                    <td><?php echo ($accomodation_sale_arr2[$i]+$spa_sale_arr2[$i]+$anicillary_sale_arr2[$i])-($other_costs_arr2[$i]+$bank_charges_arr2[$i]+$taxes_arr2[$i]+$marketing_arr2[$i]+$adm_cost_arr2[$i]+$t_opr_cost_arr2[$i]+$staffing_arr1[$i]+$goods_cost_arr2[$i]+$anicillary_arr2[$i]+$spa_arr2[$i]); ?></td>
                                                                    <?php
                                                        }
                                                    }
                                                                    ?>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php }else{ ?>
                                                <div class="col-lg-12 text-center">
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Minimum previous 15 months record required please add first.</b></h5>
                                                </div>
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                                            <div class="table-responsive text-center">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-bold text-left">Monthly</th>
                                                            <th class="">Total</th>
                                                            <th class="" colspan="5"></th>
                                                        </tr>
                                                        <tr class="">
                                                            <th></th>
                                                            <th>Forecast</th>
                                                            <th>Effective</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Effective</th>
                                                            <th>Forecast</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="forecast_light_gray_color">
                                                            <td><?php echo 'Betriebserlöse /Operating Revenue'; ?></td>
                                                            <td><?php echo 'abc'; ?></td>
                                                            <td><?php echo 'abc'; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="">
                                                            <td><?php echo 'Betriebserlöse /Operating Revenue'; ?></td>
                                                            <td><?php echo 'abc'; ?></td>
                                                            <td><?php echo 'abc'; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?php echo 'Logisumsätze Netto / Hotel Revenues Net'; ?></td>
                                                            <td><?php echo 'abc'; ?></td>
                                                            <td><?php echo ''; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile-tab1">
                                            <div class="row"> 
                                                <div class="col-lg-12">
                                                    <h3 class="forecast_main_color p-3 text-center">Yearly Budget forecast and effective</h3>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="pb-3 goods_table_responsive table table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr class="forecast_pink_color text-center">
                                                                    <th class=""></th>
                                                                    <th class="">Jan Forecast</th>
                                                                    <th class="">Jan Effective</th>
                                                                    <th class="">Feb Forecast</th>
                                                                    <th class="">Feb Forecast</th>
                                                                    <th class="">Mar Forecast</th>
                                                                    <th class="">Mar Forecast</th>
                                                                    <th class="">Apr Forecast</th>
                                                                    <th class="">Apr Forecast</th>
                                                                    <th class="">May Forecast</th>
                                                                    <th class="">May Forecast</th>
                                                                    <th class="">Jun Forecast</th>
                                                                    <th class="">Jun Forecast</th>
                                                                    <th class="">Jul Forecast</th>
                                                                    <th class="">Jul Forecast</th>
                                                                    <th class="">Aug Forecast</th>
                                                                    <th class="">Aug Forecast</th>
                                                                    <th class="">Sep Forecast</th>
                                                                    <th class="">Sep Forecast</th>
                                                                    <th class="">Oct Forecast</th>
                                                                    <th class="">Oct Forecast</th>
                                                                    <th class="">Nov Forecast</th>
                                                                    <th class="">Nov Forecast</th>
                                                                    <th class="">Dec Forecast</th>
                                                                    <th class="">Dec Forecast</th>
                                                                    <th class="">Total</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>AUSGANGSLAGE /Key Facts</th>
                                                                    <th colspan="25"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <tr>
                                                                    <td>Gästezimmer /Rooms</td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'abc'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                    <td><?php echo 'acv'; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="profile5" role="tabpanel" aria-labelledby="profile-tab5">
                                            <div class="row"> 
                                                <div class="col-lg-12">
                                                    <h3 class="forecast_main_color p-3 text-center">Staffing</h3>
                                                </div>
                                                <?php
                                                $total_gross=$total_net=$total12x_net=0;
                                                $sql_staffing_data = "SELECT DISTINCT a.* FROM `tbl_forecast_staffing_department` as a INNER JOIN tbl_forecast_staffing_cost as b on a.frcstfd_id = b.frcstfd_id WHERE a.`hotel_id` = $hotel_id AND a.`is_active` = 1 AND a.`is_delete` = 0 AND b.year = $year_";
                                                $result_staffing_data = $conn->query($sql_staffing_data);
                                                if ($result_staffing_data && $result_staffing_data->num_rows > 0) {
                                                ?>

                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="pb-3 table table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr class="text-bold">
                                                                    <th class="text-bold"></th>
                                                                    <th class="text-bold">net</th>
                                                                    <th class="text-bold">gross</th>
                                                                    <th class="text-bold">Jan</th>
                                                                    <th class="text-bold">Feb</th>
                                                                    <th class="text-bold">Mar</th>
                                                                    <th class="text-bold">Apr</th>
                                                                    <th class="text-bold">May</th>
                                                                    <th class="text-bold">Jun</th>
                                                                    <th class="text-bold">Jul</th>
                                                                    <th class="text-bold">Aug</th>
                                                                    <th class="text-bold">Sep</th>
                                                                    <th class="text-bold">Oct</th>
                                                                    <th class="text-bold">Nov</th>
                                                                    <th class="text-bold">Dec</th>
                                                                    <th class="text-bold">Total Payroll</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-right">

                                                                <?php
                                                    while ($row = mysqli_fetch_array($result_staffing_data)) {
                                                        $doc_id = $row['frcstfd_id'];
                                                                ?>
                                                                <tr class="forecast_pink_color">
                                                                    <td class="text-bold text-left"><?php echo $row['title']; ?></td>
                                                                    <td colspan="15"></td>
                                                                </tr>
                                                                <?php 
                                                        $sql_inner = "SELECT * FROM `tbl_forecast_staffing_cost` WHERE `hotel_id` = $hotel_id AND `frcstfd_id` = $doc_id AND `year` = $year_";
                                                        $result_inner = $conn->query($sql_inner);
                                                        if ($result_inner && $result_inner->num_rows > 0) {
                                                            while ($row_inner = mysqli_fetch_array($result_inner)) {
                                                                $total_gross += $row_inner['gross_salary'];
                                                                $total_net += $row_inner['net_salary'];
                                                                $total12x_net += $row_inner['net_salary']*12;
                                                                ?>
                                                                <tr class="">
                                                                    <td class="text-left"><?php echo $row_inner['staff_name']; ?></td>
                                                                    <td><?php echo number_format($row_inner['gross_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']); ?> €</td>
                                                                    <td><?php echo number_format($row_inner['net_salary']*12); ?> €</td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                                ?>
                                                                <tr class="forecast_gray_color text-bold">
                                                                    <td class="text-left">Payroll</td>
                                                                    <td><?php echo number_format($total_gross); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total_net); ?> €</td>
                                                                    <td><?php echo number_format($total12x_net); ?> €</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php }else{ ?>
                                                <div class="col-lg-12 text-center">
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No Data found.</b></h5>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>





                                        <div class="tab-pane fade" id="profile6" role="tabpanel" aria-labelledby="profile-tab6">
                                            <div class="row"> 
                                                <div class="col-lg-12">
                                                    <h3 class="forecast_main_color p-3 text-center">GOODS PURCHASING FOR THE KITCHEN</h3>
                                                </div>
                                                <?php
                                                $sql_goods_data = "SELECT * FROM `tbl_forecast_goods_cost` WHERE `hotel_id` = $hotel_id ORDER BY date DESC";
                                                $result_goods_data = $conn->query($sql_goods_data);
                                                if ($result_goods_data && $result_goods_data->num_rows > 0) {
                                                ?>    

                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="pb-3 table text-right table table-bordered table-hover table-striped">
                                                            <thead>
                                                                <tr class="text-bold">
                                                                    <th class="text-bold"></th>
                                                                    <th class="text-bold text-success">Meat</th>
                                                                    <th class="text-bold text-success">Fruit Vegetable</th>
                                                                    <th class="text-bold text-success">Bread</th>
                                                                    <th class="text-bold text-success">Frozen Goods</th>
                                                                    <th class="text-bold text-success">Dairy Products</th>
                                                                    <th class="text-bold text-success">Cons Earliest</th>
                                                                    <th class="text-bold text-success">Minus</th>
                                                                    <th class="text-bold text-success">Tea</th>
                                                                    <th class="text-bold text-success">Coffee</th>
                                                                    <th class="text-bold text-success">Cheese</th>
                                                                    <th class="text-bold text-success">Eggs</th>
                                                                    <th class="text-bold">Total Cost</th>
                                                                    <th class="text-bold">Nights</th>
                                                                    <th class="text-bold">WES</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                    $exit=1; $meat_total=$fruit_total=$bread_total=$frozen_total=$dairy_total=$cons_total=$minus_total=$tea_total=$coffee_total=$cheese_total=$eggs_total=$total_cost_total=$total_nights_total=$Pre_Year_Check=0; 

                                                    while ($row = mysqli_fetch_array($result_goods_data)) {
                                                        $time=strtotime($row['date']);
                                                        $Year_check = date("Y",$time);
                                                        if($exit == 1){
                                                            $Pre_Year_Check = date("Y",$time);
                                                                ?>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><?php echo $row['Meat_Supplier']; ?></td>
                                                                    <td><?php echo $row['Fruit_Vegetable_Supplier']; ?></td>
                                                                    <td><?php echo $row['Bread_Supplier']; ?></td>
                                                                    <td><?php echo $row['Frozen_Goods_Supplier']; ?></td>
                                                                    <td><?php echo $row['Dairy_Products_Supplier']; ?></td>
                                                                    <td><?php echo $row['Cons_Earliest_Supplier']; ?></td>
                                                                    <td></td>
                                                                    <td><?php echo $row['Tea_Supplier']; ?></td>
                                                                    <td><?php echo $row['Coffee_Supplier']; ?></td>
                                                                    <td><?php echo $row['Cheese_Supplier']; ?></td>
                                                                    <td><?php echo $row['Eggs_Supplier']; ?></td>
                                                                    <td class="text-bold"><?php echo 'Per Month (€)'; ?></td>
                                                                    <td></td>
                                                                    <td class="text-bold"><?php echo 'Per Night (€)'; ?></td>
                                                                </tr>
                                                                <?php 
                                                            $exit++; }
                                                        if($Pre_Year_Check != $Year_check){
                                                                ?>
                                                                <tr class="forecast_gray_color">
                                                                    <td class="text-bold"><?php echo 'Total '.$Pre_Year_Check; ?></td>
                                                                    <td><?php echo $meat_total; ?></td>
                                                                    <td><?php echo $fruit_total; ?></td>
                                                                    <td><?php echo $bread_total; ?></td>
                                                                    <td><?php echo $frozen_total; ?></td>
                                                                    <td><?php echo $dairy_total; ?></td>
                                                                    <td><?php echo $cons_total; ?></td>
                                                                    <td><?php echo $minus_total; ?></td>
                                                                    <td><?php echo $tea_total; ?></td>
                                                                    <td><?php echo $coffee_total; ?></td>
                                                                    <td><?php echo $cheese_total; ?></td>
                                                                    <td><?php echo $eggs_total; ?></td>
                                                                    <td><?php echo $total_cost_total; ?></td>
                                                                    <td><?php echo $total_nights_total; ?></td>
                                                                    <td><?php if($total_nights_total != 0){ echo round($total_cost_total/$total_nights_total,2);}else{echo $total_cost_total;} ?></td>
                                                                </tr>
                                                                <?php $meat_total=$fruit_total=$bread_total=$frozen_total=$dairy_total=$cons_total=$minus_total=$tea_total=$coffee_total=$cheese_total=$eggs_total=$total_cost_total=$total_nights_total=0;
                                                            $Pre_Year_Check = date("Y",$time);
                                                        }


                                                        $meat_total+=$row['Meat'];
                                                        $fruit_total+=$row['Fruit_Vegetable'];
                                                        $bread_total+=$row['Bread'];
                                                        $frozen_total+=$row['Frozen_Goods'];
                                                        $dairy_total+=$row['Dairy_Products'];
                                                        $cons_total+=$row['Cons_Earliest'];
                                                        $minus_total+=$row['Minus'];
                                                        $tea_total+=$row['Tea'];
                                                        $coffee_total+=$row['Coffee'];
                                                        $cheese_total+=$row['Cheese'];
                                                        $eggs_total+=$row['Eggs'];
                                                        $total_cost_total+=$row['total_cost'];
                                                                ?>

                                                                <tr class="">
                                                                    <td class="text-bold"><?php echo date("F",$time).' '.$Year_check; ?></td>
                                                                    <td><?php echo $row['Meat']; ?></td>
                                                                    <td><?php echo $row['Fruit_Vegetable']; ?></td>
                                                                    <td><?php echo $row['Bread']; ?></td>
                                                                    <td><?php echo $row['Frozen_Goods']; ?></td>
                                                                    <td><?php echo $row['Dairy_Products']; ?></td>
                                                                    <td><?php echo $row['Cons_Earliest']; ?></td>
                                                                    <td><?php echo $row['Minus']; ?></td>
                                                                    <td><?php echo $row['Tea']; ?></td>
                                                                    <td><?php echo $row['Coffee']; ?></td>
                                                                    <td><?php echo $row['Cheese']; ?></td>
                                                                    <td><?php echo $row['Eggs']; ?></td>
                                                                    <td><?php echo $row['total_cost']; ?></td>
                                                                    <td><?php 
                                                        $sql_inner = 'SELECT count(*) as num FROM `tbl_forecast_reservations_rooms` WHERE `hotel_id` = '.$hotel_id.' AND MONTH(`date`) = '.date("m",$time).' AND YEAR(`date`) = '.date("Y",$time);
                                                        $result_inner = $conn->query($sql_inner);
                                                        $total_nights = 0;
                                                        if ($result_inner && $result_inner->num_rows > 0) {
                                                            while ($row_inner = mysqli_fetch_array($result_inner)) {
                                                                $total_nights = $row_inner['num'];
                                                            }
                                                        }else{
                                                            $total_nights = 0;
                                                        }
                                                        $total_nights_total += $total_nights;
                                                        echo $total_nights; ?></td>
                                                                    <td><?php if($total_nights != 0){ echo round($row['total_cost']/$total_nights,2);}else{echo $row['total_cost'];} ?></td>
                                                                </tr>





                                                                <?php } ?>

                                                                <tr class="forecast_gray_color">
                                                                    <td class="text-bold"><?php echo 'Total '.$Pre_Year_Check; ?></td>
                                                                    <td><?php echo $meat_total; ?></td>
                                                                    <td><?php echo $fruit_total; ?></td>
                                                                    <td><?php echo $bread_total; ?></td>
                                                                    <td><?php echo $frozen_total; ?></td>
                                                                    <td><?php echo $dairy_total; ?></td>
                                                                    <td><?php echo $cons_total; ?></td>
                                                                    <td><?php echo $minus_total; ?></td>
                                                                    <td><?php echo $tea_total; ?></td>
                                                                    <td><?php echo $coffee_total; ?></td>
                                                                    <td><?php echo $cheese_total; ?></td>
                                                                    <td><?php echo $eggs_total; ?></td>
                                                                    <td><?php echo $total_cost_total; ?></td>
                                                                    <td><?php echo $total_nights_total; ?></td>
                                                                    <td><?php if($total_nights_total != 0){ echo round($total_cost_total/$total_nights_total,2);}else{echo $total_cost_total;} ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <?php }else{ ?>
                                                <div class="col-lg-12 text-center">
                                                    <div class="text-center"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>No Data found.</b></h5>
                                                </div>
                                                <?php } ?>


                                            </div>
                                        </div>



                                        <!--
<div class="tab-pane fade" id="profile7" role="tabpanel" aria-labelledby="profile-tab7">
<p>N/A. 7</p>
</div>
-->



                                        <!--                                        Settings Screens-->

                                        <!--                                        Start Revenues-->
                                        <div class="tab-pane fade" id="dropdown1" role="tabpanel" aria-labelledby="dropdown1-tab">

                                            <div class="row mtm-0">
                                                <div class="col-lg-4 right-border-div pr-5">

                                                    <div class="mt-4">
                                                        <h3>Add Revenues</h3>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-lg-12">


                                                            <div class="form-group mb-0">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Hotel Revenues Net</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Ancillary Revenues Net</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="hotel_revenues">
                                                                <input step="any" type="number" class="form-control display-inline ml-2 w-47 wm-50" id="ancillary_revenues">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Spa Revenues Net (22%)</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Other Revenues Net</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="spa_revenues">
                                                                <input step="any" type="number" class="form-control display-inline ml-2 w-47 wm-50" id="other_revenues">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Account Balance (Jan Only)</strong></label>
                                                                <label class="control-label display-inline ml-2 w-20 wm-50"><strong>Month</strong></label>
                                                                <label class="control-label display-inline ml-2 w-20 wm-50"><strong>Year</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" step="any" class="form-control display-inline w-47 wm-50" id="account_balance">
                                                                <input type="number" min="1" max="12" placeholder="Month" class="form-control display-inline ml-2 w-20 wm-50" id="date_month">
                                                                <input type="number" min="1980" max="2050" placeholder="Year" class="form-control display-inline ml-2 w-20 wm-50" id="date_year">
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                                                        <input type="button" onclick="save_revenue();" class="btn mt-4 w-100 btn-info" value="Save Revenue">
                                                    </div>


                                                </div>

                                                <div class="col-lg-8 pl-5" id="reload_revenues">
                                                    <div class="mt-4">
                                                        <h3>Revenues</h3>
                                                    </div>

                                                    <?php
                                                    $sql_revenues = "SELECT * FROM `tbl_forecast_revenues` WHERE `hotel_id` = $hotel_id ORDER BY date DESC";

                                                    $result_revenues = $conn->query($sql_revenues);
                                                    if ($result_revenues && $result_revenues->num_rows > 0) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Hotel Revenue</th>
                                                                    <th class="" >Ancillary Revenue</th>
                                                                    <th class="" >Spa Revenue 22%</th>
                                                                    <th class="" >Other Reveneus</th>
                                                                    <th class="" >Account Balance</th>
                                                                    <th class="" >Date</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_revenues)) {
                                                                ?>
                                                                <tr class="">
                                                                    <td><?php echo $row['Hotel_Revenues_Net']; ?></td>
                                                                    <td><?php echo $row['Ancillary_Revenues_Net']; ?></td>
                                                                    <td class=""><?php echo $row['Spa_Revenues_Net_22']; ?></td>
                                                                    <td class=""><?php echo $row['other_reveneus']; ?></td>
                                                                    <td class=""><?php echo $row['bank_account_balance']; ?></td>
                                                                    <td class=""><?php echo $row['date']; ?></td>

                                                                    <td class="font-size-subheading text-center black_color">
                                                                        <a  class="black_color" href="javascript:void(0)" onclick="edit_revenue('<?php echo $row['frcrvs_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Revenues Not Found.</b></h5>
                                                    <?php } ?>

                                                </div>
                                            </div>

                                        </div>
                                        <!--                                        End Revenues-->

                                        <div class="tab-pane fade" id="dropdown2" role="tabpanel" aria-labelledby="dropdown2-tab">

                                            <div class="row mtm-0">
                                                <div class="col-lg-4 right-border-div pr-5">

                                                    <div class="mt-4">
                                                        <h3>Add Expenses</h3>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-lg-12">

                                                            <div class="form-group mb-0">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Ancillary Goods Cost</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Spa Products Cost</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="ancillary_goods_cost">
                                                                <input step="any" type="number" class="form-control display-inline ml-2 w-47 wm-50" id="spa_products_cost">
                                                            </div>

                                                            <div class="form-group mb-0">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Total Operating Cost</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Administration Cost</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="total_operating_cost">
                                                                <input step="any" type="number" class="form-control display-inline ml-2 w-47 wm-50" id="administration_cost">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Marketing</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Taxes</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="marketing">
                                                                <input step="any" type="number" class="form-control display-inline ml-2 w-47 wm-50" id="taxes">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Bank Charges</strong></label>
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Total Loan (Jan Only)</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" step="any" class="form-control display-inline w-47 wm-50" id="bank_charges">
                                                                <input type="number" step="any" class="form-control display-inline w-47 wm-50" id="total_loan">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Other Costs</strong></label>
                                                                <label class="control-label display-inline ml-2 w-20 wm-50"><strong>Month</strong></label>
                                                                <label class="control-label display-inline ml-2 w-20 wm-50"><strong>Year</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" step="any" class="form-control display-inline w-47 wm-50" id="other_costs">
                                                                <input type="number" min="1" max="12" placeholder="Month" class="form-control display-inline ml-2 w-20 wm-50" id="date_month_cost">
                                                                <input type="number" min="1980" max="2050" placeholder="Year" class="form-control display-inline ml-2 w-20 wm-50" id="date_year_cost">
                                                            </div>


                                                        </div>
                                                    </div>



                                                    <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                                                        <input type="button" onclick="save_cost();" class="btn mt-4 w-100 btn-info" value="Save Expense">
                                                    </div>


                                                </div>

                                                <div class="col-lg-8 pl-5" id="reload_expenses">
                                                    <div class="mt-4">
                                                        <h3>Expenses</h3>
                                                    </div>

                                                    <?php
                                                    $sql_expenses = "SELECT * FROM `tbl_forecast_expenses` WHERE `hotel_id` = $hotel_id ORDER BY date DESC";

                                                    $result_expenses = $conn->query($sql_expenses);
                                                    if ($result_expenses && $result_expenses->num_rows > 0) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Ancillary Cost</th>
                                                                    <th class="" >Spa Cost</th>
                                                                    <th class="" >Operating Cost</th>
                                                                    <th class="" >Administration Cost</th>
                                                                    <th class="" >Marketing</th>
                                                                    <th class="" >Taxes</th>
                                                                    <th class="" >Bank Charges</th>
                                                                    <th class="" >Total Loan</th>
                                                                    <th class="" >Other Costs</th>
                                                                    <th class="" >Date</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_expenses)) {
                                                                ?>
                                                                <tr class="">
                                                                    <td><?php echo $row['costs_of_ancillary_goods']; ?></td>
                                                                    <td><?php echo $row['costs_of_spa_products']; ?></td>
                                                                    <td><?php echo $row['total_operating_cost']; ?></td>
                                                                    <td><?php echo $row['administration_cost']; ?></td>
                                                                    <td class=""><?php echo $row['marketing']; ?></td>
                                                                    <td class=""><?php echo $row['taxes']; ?></td>
                                                                    <td class=""><?php echo $row['bank_charges']; ?></td>
                                                                    <td class=""><?php echo $row['total_loan']; ?></td>
                                                                    <td class=""><?php echo $row['other_costs']; ?></td>
                                                                    <td class=""><?php echo $row['date']; ?></td>
                                                                    <td class="font-size-subheading text-center black_color">
                                                                        <a  class="black_color" href="javascript:void(0)" onclick="edit_expense('<?php echo $row['frcex_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Expenses Not Found.</b></h5>
                                                    <?php } ?>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="dropdown3" role="tabpanel" aria-labelledby="dropdown3-tab">

                                            <div class="row mtm-0">
                                                <div class="col-lg-4 right-border-div pr-5">

                                                    <div class="mt-4">
                                                        <h3>Add Key Facts</h3>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-lg-12">


                                                            <div class="form-group mb-0">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Rooms</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Beds</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" class="form-control display-inline w-47 wm-50" id="rooms">
                                                                <input type="number" class="form-control display-inline ml-2 w-47 wm-50" id="beds">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Opening Days</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Total Stay Capacity</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" class="form-control display-inline w-47 wm-50" id="opening_days">
                                                                <input type="number" class="form-control display-inline ml-2 w-47 wm-50" id="total_capacity">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Month</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Year</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" min="1" max="12" placeholder="Month" class="form-control display-inline ml-2 w-47 wm-50" id="date_month_key">
                                                                <input type="number" min="1980" max="2050" placeholder="Year" class="form-control display-inline ml-2 w-47 wm-50" id="date_year_key">
                                                            </div>


                                                        </div>
                                                    </div>



                                                    <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                                                        <input type="button" onclick="save_facts();" class="btn mt-4 w-100 btn-info" value="Save Key Facts">
                                                    </div>


                                                </div>

                                                <div class="col-lg-8 pl-5" id="reload_facts">
                                                    <div class="mt-4">
                                                        <h3>Key Facts</h3>
                                                    </div>

                                                    <?php
                                                    $sql_facts = "SELECT * FROM `tbl_forecast_keyfacts` WHERE `hotel_id` = $hotel_id ORDER BY date DESC";

                                                    $result_facts = $conn->query($sql_facts);
                                                    if ($result_facts && $result_facts->num_rows > 0) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Available Rooms</th>
                                                                    <th class="" >Available Beds</th>
                                                                    <th class="" >Opening Days</th>
                                                                    <th class="" >Total Stay Capacity</th>
                                                                    <th class="" >Date</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_facts)) {
                                                                ?>
                                                                <tr class="">
                                                                    <td><?php echo $row['rooms']; ?></td>
                                                                    <td><?php echo $row['beds']; ?></td>
                                                                    <td class=""><?php echo $row['opening_days']; ?></td>
                                                                    <td class=""><?php echo $row['total_stay_capacity']; ?></td>
                                                                    <td class=""><?php echo $row['date']; ?></td>
                                                                    <td class="font-size-subheading text-center black_color">
                                                                        <a  class="black_color" href="javascript:void(0)" onclick="edit_facts('<?php echo $row['frckfs_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Key Facts Not Found.</b></h5>
                                                    <?php } ?>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="dropdown4" role="tabpanel" aria-labelledby="dropdown4-tab">

                                            <div class="row mtm-0">
                                                <div class="col-lg-4 right-border-div pr-5">

                                                    <div class="mt-4">
                                                        <h3>Add Staffing Cost</h3>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-lg-12">


                                                            <div class="form-group mb-0">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Staff Name</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Year</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control display-inline w-47 wm-50" id="staff_name" placeholder="e.g. Reception 1, Operation Mgr, Kitchen 1...">
                                                                <input type="number" min="1980" max="2050" placeholder="e.g. 2023, 2024, 2025..." class="form-control display-inline ml-2 w-47 wm-50" id="year_staffing">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Gross Salary/Month (€)</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Net Salary/Month (€)</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" step="any" class="form-control display-inline w-47 wm-50" id="gross_salary">
                                                                <input type="number" step="any" class="form-control display-inline ml-2 w-47 wm-50" id="net_salary">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Staffing Department</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <select class="form-control display-inline w-47 wm-50" id="department_staffing">
                                                                    <option value="0">Select Staffing Department</option>
                                                                    <?php
                                                                    $sql_depart = "SELECT * FROM `tbl_forecast_staffing_department` WHERE hotel_id = $hotel_id AND is_active = 1 AND is_delete = 0 ORDER BY 1 DESC";

                                                                    $result_depart = $conn->query($sql_depart);
                                                                    if ($result_depart && $result_depart->num_rows > 0) {
                                                                        while ($row = mysqli_fetch_array($result_depart)) {
                                                                    ?>
                                                                    <option value="<?php echo $row['frcstfd_id']; ?>"><?php echo $row['title']; ?></option>   
                                                                    <?php 
                                                                        } 
                                                                    }
                                                                    ?> 
                                                                </select>
                                                                <input type="button" onclick="add_staff_depart();" class="btn w-47 ml-2 btn-secondary" value="Add Staff Department">
                                                            </div>


                                                        </div>
                                                    </div>



                                                    <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                                                        <input type="button" onclick="save_staff_cost();" class="btn mt-4 w-100 btn-info" value="Save Staff Cost">
                                                    </div>


                                                </div>

                                                <div class="col-lg-8 pl-5" id="reload_staffing">
                                                    <div class="mt-4">
                                                        <h3>Staffing Cost</h3>
                                                    </div>

                                                    <?php
                                                    $sql_staffing = "SELECT a.*,b.* FROM `tbl_forecast_staffing_cost` as a INNER JOIN tbl_forecast_staffing_department as b ON a.frcstfd_id = b.frcstfd_id WHERE a.`hotel_id` = $hotel_id ORDER BY a.year DESC";

                                                    $result_staffing = $conn->query($sql_staffing);
                                                    if ($result_staffing && $result_staffing->num_rows > 0) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Staff Title</th>
                                                                    <th class="" >Staff Department</th>
                                                                    <th class="" >Gross Salary (€)</th>
                                                                    <th class="" >Net Salary (€)</th>
                                                                    <th class="" >Year</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_staffing)) {
                                                                ?>
                                                                <tr class="">
                                                                    <td><?php echo $row['staff_name']; ?></td>
                                                                    <td><?php echo $row['title']; ?></td>
                                                                    <td class=""><?php echo $row['gross_salary']; ?></td>
                                                                    <td class=""><?php echo $row['net_salary']; ?></td>
                                                                    <td class=""><?php echo $row['year']; ?></td>
                                                                    <td class="font-size-subheading text-center black_color">
                                                                        <a  class="black_color" href="javascript:void(0)" onclick="edit_staff_cost('<?php echo $row['frcstfct_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Staff Cost Not Found.</b></h5>
                                                    <?php } ?>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="tab-pane fade" id="dropdown5" role="tabpanel" aria-labelledby="dropdown5-tab">
                                            <div class="row mtm-0">
                                                <div class="col-lg-4 right-border-div pr-5">

                                                    <div class="mt-4">
                                                        <h3>Add Goods Cost</h3>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-lg-12">


                                                            <div class="form-group mb-0">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Meat Cost</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Meat Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="meat_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="meat_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Fruits &amp; Vegetables</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Fruits &amp; Vegetables Supp</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="fruit_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="fruit_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Bread</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Bread Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="bread_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="bread_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Frozen Goods</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Frozen Goods Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="frozen_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="frozen_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Dairy Products</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Dairy Products Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="dairy_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="dairy_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Cons Earliast</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Cons Earliast Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="cons_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="cons_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Tea</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Tea Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="tea_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="tea_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Coffee</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Coffee Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="coffee_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="coffee_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Cheese</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Cheese Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="cheese_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="cheese_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Eggs</strong></label>
                                                                <label class="control-label display-inline ml-2 w-47 wm-50"><strong>Eggs Supplier</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input step="any" type="number" class="form-control display-inline w-47 wm-50" id="eggs_cost">
                                                                <input type="text" class="form-control display-inline ml-2 w-47 wm-50" id="eggs_supplier">
                                                            </div>

                                                            <div class="form-group mb-0 mt-3 mt-3">
                                                                <label class="control-label display-inline w-47 wm-50"><strong>Minus</strong></label>
                                                                <label class="control-label display-inline ml-2 w-20 wm-50"><strong>Month</strong></label>
                                                                <label class="control-label display-inline ml-2 w-20 wm-50"><strong>Year</strong></label>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="number" step="any" class="form-control display-inline w-47 wm-50" id="minus_costs">
                                                                <input type="number" min="1" max="12" placeholder="Month" class="form-control display-inline ml-2 w-20 wm-50" id="date_month_goods">
                                                                <input type="number" min="1980" max="2050" placeholder="Year" class="form-control display-inline ml-2 w-20 wm-50" id="date_year_goods">
                                                            </div>


                                                        </div>
                                                    </div>



                                                    <div class="mt-3 mb-5 pb-5 pbm-0 mbm-0">
                                                        <input type="button" onclick="save_goods_cost();" class="btn mt-4 w-100 btn-info" value="Save Goods Purchasing">
                                                    </div>


                                                </div>

                                                <div class="col-lg-8" id="reload_goods">
                                                    <div class="mt-4">
                                                        <h3>Goods Cost</h3>
                                                    </div>

                                                    <?php
                                                    $sql_goods = "SELECT * FROM `tbl_forecast_goods_cost` WHERE `hotel_id` = $hotel_id ORDER BY date DESC";

                                                    $result_goods = $conn->query($sql_goods);
                                                    if ($result_goods && $result_goods->num_rows > 0) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="goods_table_responsive table table-bordered m-t-30 table-hover contact-list table-striped" data-paging="true" data-paging-size="25">
                                                            <thead>
                                                                <tr>
                                                                    <th class="" >Meat</th>
                                                                    <th class="" >Fruit Vegetable</th>
                                                                    <th class="" >Bread</th>
                                                                    <th class="" >Frozen Goods</th>
                                                                    <th class="" >Dairy Products</th>
                                                                    <th class="" >Cons Earliest</th>
                                                                    <th class="" >Tea</th>
                                                                    <th class="" >Coffee</th>
                                                                    <th class="" >Cheese</th>
                                                                    <th class="" >Eggs</th>
                                                                    <th class="" >Minus</th>
                                                                    <th class="" >Total</th>
                                                                    <th class="" >Date</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php

                                                        while ($row = mysqli_fetch_array($result_goods)) {
                                                                ?>
                                                                <tr class="">
                                                                    <td><?php echo $row['Meat']; ?></td>
                                                                    <td><?php echo $row['Fruit_Vegetable']; ?></td>
                                                                    <td class=""><?php echo $row['Bread']; ?></td>
                                                                    <td class=""><?php echo $row['Frozen_Goods']; ?></td>
                                                                    <td class=""><?php echo $row['Dairy_Products']; ?></td>
                                                                    <td class=""><?php echo $row['Cons_Earliest']; ?></td>
                                                                    <td class=""><?php echo $row['Tea']; ?></td>
                                                                    <td class=""><?php echo $row['Coffee']; ?></td>
                                                                    <td class=""><?php echo $row['Cheese']; ?></td>
                                                                    <td class=""><?php echo $row['Eggs']; ?></td>
                                                                    <td class=""><?php echo $row['Minus']; ?></td>
                                                                    <td class=""><?php echo $row['total_cost']; ?></td>
                                                                    <td class=""><?php echo $row['date']; ?></td>
                                                                    <td class="font-size-subheading text-center black_color">
                                                                        <a  class="black_color" href="javascript:void(0)" onclick="edit_goods('<?php echo $row['frcgct_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                        } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <?php }else{ ?>
                                                    <div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
                                                    <h5 class="text-center"><b>Goods Cost Not Found.</b></h5>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <!-- ============================================================== -->
                    <!-- End Page Content -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Right sidebar -->
                    <!-- ============================================================== -->
                    <!-- .right-sidebar -->
                    <?php include 'util_right_nav.php'; ?>
                    <!-- ============================================================== -->
                    <!-- End Right sidebar -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include 'util_footer.php'; ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="./assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="./assets/node_modules/popper/popper.min.js"></script>
        <script src="./assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
        <!--Wave Effects -->
        <script src="dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>
        <!-- Footable -->
        <script src="./assets/node_modules/moment/moment.js"></script>
        <script src="./assets/node_modules/footable/js/footable.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="./assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="./assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
        <script src="./assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

        <script src="./assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

        <!-- Chart JS -->
        <script src="./assets/node_modules/echarts/echarts-all.js"></script>


        <script>
            // ============================================================== 
            // Bar chart option
            // ============================================================== 
            var myChart = echarts.init(document.getElementById('bar-chart'));

            // specify chart configuration item and data
            option = {
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['Site A','Site B']
                },
                toolbox: {
                    show : true,
                    feature : {

                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#55ce63", "#009efb"],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'Site A',
                        type:'bar',
                        data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'Max'},
                                {type : 'min', name: 'Min'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: 'Average'}
                            ]
                        }
                    },
                    {
                        name:'Site B',
                        type:'bar',
                        data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                        markPoint : {
                            data : [
                                {name : 'The highest year', value : 182.2, xAxis: 7, yAxis: 183, symbolSize:18},
                                {name : 'Year minimum', value : 2.3, xAxis: 11, yAxis: 3}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'}
                            ]
                        }
                    }
                ]
            };


            // use configuration item and data specified to show chart
            myChart.setOption(option, true), $(function() {
                function resize() {
                    setTimeout(function() {
                        myChart.resize()
                    }, 100)
                }
                $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
            });

            // ============================================================== 
            // Bar chart 2 option
            // ============================================================== 
            var myChart2 = echarts.init(document.getElementById('bar-chart2'));

            // specify chart configuration item and data
            option = {
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['Site A','Site B']
                },
                toolbox: {
                    show : true,
                    feature : {

                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#55ce63", "#009efb"],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'Site A',
                        type:'bar',
                        data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'Max'},
                                {type : 'min', name: 'Min'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: 'Average'}
                            ]
                        }
                    },
                    {
                        name:'Site B',
                        type:'bar',
                        data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                        markPoint : {
                            data : [
                                {name : 'The highest year', value : 182.2, xAxis: 7, yAxis: 183, symbolSize:18},
                                {name : 'Year minimum', value : 2.3, xAxis: 11, yAxis: 3}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'}
                            ]
                        }
                    }
                ]
            };


            // use configuration item and data specified to show chart
            myChart2.setOption(option, true), $(function() {
                function resize() {
                    setTimeout(function() {
                        myChart2.resize()
                    }, 100)
                }
                $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
            });


            // ============================================================== 
            // Bar chart 3 option
            // ============================================================== 
            var myChart3 = echarts.init(document.getElementById('bar-chart3'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 60,
                    x2: 40,
                    y: 45,
                    y2: 25
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    data: ['2012']
                },

                // Add custom colors
                color: ['#666EE8'],

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.01]
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    data: ['Apple', 'Samsung', 'HTC', 'Nokia', 'Sony', 'LG']
                }],

                // Add series
                series : [
                    {
                        name:'2012',
                        type:'bar',
                        data:[780, 689, 468, 174, 436, 482]
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart3.setOption(chartOptions);


            // Resize chart
            // ------------------------------

            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart3.resize();
                    }, 200);
                }
            });


            // ============================================================== 
            // Line chart
            // ============================================================== 
            var dom = document.getElementById("main");
            var mytempChart = echarts.init(dom);
            var app = {};
            option = null;
            option = {

                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['max temp','min temp']
                },
                toolbox: {
                    show : true,
                    feature : {
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#55ce63", "#009efb"],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',

                        boundaryGap : false,
                        data : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value} °C'
                        }
                    }
                ],

                series : [
                    {
                        name:'max temp',
                        type:'line',
                        color:['#000'],
                        data:[11, 11, 15, 13, 12, 13, 10],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'Max'},
                                {type : 'min', name: 'Min'}
                            ]
                        },
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    shadowColor : 'rgba(0,0,0,0.3)',
                                    shadowBlur: 10,
                                    shadowOffsetX: 8,
                                    shadowOffsetY: 8 
                                }
                            }
                        },        
                        markLine : {
                            data : [
                                {type : 'average', name: 'Average'}
                            ]
                        }
                    },
                    {
                        name:'min temp',
                        type:'line',
                        data:[1, -2, 2, 5, 3, 2, 0],
                        markPoint : {
                            data : [
                                {name : 'Week minimum', value : -2, xAxis: 1, yAxis: -1.5}
                            ]
                        },
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    shadowColor : 'rgba(0,0,0,0.3)',
                                    shadowBlur: 10,
                                    shadowOffsetX: 8,
                                    shadowOffsetY: 8 
                                }
                            }
                        }, 
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'}
                            ]
                        }
                    }
                ]
            };

            if (option && typeof option === "object") {
                mytempChart.setOption(option, true), $(function() {
                    function resize() {
                        setTimeout(function() {
                            mytempChart.resize()
                        }, 100)
                    }
                    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
                });
            }


            // ============================================================== 
            // Line chart 2
            // ============================================================== 
            var dom2 = document.getElementById("main2");
            var mytempChart2 = echarts.init(dom2);
            var app = {};
            option = null;
            option = {

                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['max temp','min temp']
                },
                toolbox: {
                    show : true,
                    feature : {
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#55ce63", "#009efb"],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',

                        boundaryGap : false,
                        data : ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value} °C'
                        }
                    }
                ],

                series : [
                    {
                        name:'max temp',
                        type:'line',
                        color:['#000'],
                        data:[11, 11, 15, 13, 12, 13, 10],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'Max'},
                                {type : 'min', name: 'Min'}
                            ]
                        },
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    shadowColor : 'rgba(0,0,0,0.3)',
                                    shadowBlur: 10,
                                    shadowOffsetX: 8,
                                    shadowOffsetY: 8 
                                }
                            }
                        },        
                        markLine : {
                            data : [
                                {type : 'average', name: 'Average'}
                            ]
                        }
                    },
                    {
                        name:'min temp',
                        type:'line',
                        data:[1, -2, 2, 5, 3, 2, 0],
                        markPoint : {
                            data : [
                                {name : 'Week minimum', value : -2, xAxis: 1, yAxis: -1.5}
                            ]
                        },
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    shadowColor : 'rgba(0,0,0,0.3)',
                                    shadowBlur: 10,
                                    shadowOffsetX: 8,
                                    shadowOffsetY: 8 
                                }
                            }
                        }, 
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'}
                            ]
                        }
                    }
                ]
            };

            if (option && typeof option === "object") {
                mytempChart2.setOption(option, true), $(function() {
                    function resize() {
                        setTimeout(function() {
                            mytempChart2.resize()
                        }, 100)
                    }
                    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
                });
            }

            // ============================================================== 
            // doughnut chart option
            // ============================================================== 
            var doughnutChart = echarts.init(document.getElementById('doughnut-chart'));

            // specify chart configuration item and data

            option = {
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c}<br/>({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['Item A','Item B','Item C']
                },
                toolbox: {
                    show : true,
                    feature : {
                        dataView : {show: true, readOnly: false},
                        magicType : {
                            show: true, 
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '70%',
                                    funnelAlign: 'center',
                                    max: 1548
                                }
                            }
                        },
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#f62d51", "#009efb", "#55ce63"],
                calculable : true,
                series : [
                    {
                        name:'Source',
                        type:'pie',
                        radius : ['0%', '90%'],
                        itemStyle : {
                            normal : {
                                label : {
                                    show : false
                                },
                                labelLine : {
                                    show : false
                                }
                            },
                            emphasis : {
                                label : {
                                    show : true,
                                    position : 'center',
                                    textStyle : {
                                        fontSize : '30',
                                        fontWeight : 'bold'
                                    }
                                }
                            }
                        },
                        data:[
                            {value:335, name:'Item A'},
                            {value:310, name:'Item B'},
                            {value:234, name:'Item C'},
                        ]
                    }
                ]
            };



            // use configuration item and data specified to show chart
            doughnutChart.setOption(option, true), $(function() {
                function resize() {
                    setTimeout(function() {
                        doughnutChart.resize()
                    }, 100)
                }
                $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
            });

        </script>


        <script>
            var rev_id = 0;

            function edit_revenue(revenue_id){

                var fd = new FormData();
                fd.append('revenue_id_',revenue_id);
                $.ajax({
                    url:'util_forecast_revenue_get.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        if(response != ''){
                            const myArray = response.split(",");
                            $("#hotel_revenues").val(myArray[0]);
                            $("#ancillary_revenues").val(myArray[1]);
                            $("#spa_revenues").val(myArray[2]);
                            $("#other_revenues").val(myArray[3]);
                            $("#account_balance").val(myArray[4]);
                            $("#date_year").val(myArray[5]);
                            $("#date_month").val(myArray[6]);
                            rev_id = revenue_id;
                        }else{
                            alert("Revenues not Get.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }

            function save_revenue(){
                var hotel_rev=$("#hotel_revenues").val();
                var ancillary_rev=$("#ancillary_revenues").val();
                var spa_rev=$("#spa_revenues").val();
                var other_rev=$("#other_revenues").val();
                var account_bal=$("#account_balance").val();
                var month=$("#date_month").val();
                var year=$("#date_year").val();

                if(month <= 0 || month > 12){
                    alert("Enter Correct Month Number.");
                }else{
                    var fd = new FormData();
                    fd.append('hotel_rev_',hotel_rev);
                    fd.append('ancillary_rev_',ancillary_rev);
                    fd.append('spa_rev_',spa_rev);
                    fd.append('other_rev_',other_rev);
                    fd.append('account_bal_',account_bal);
                    fd.append('month_',month);
                    fd.append('year_',year);
                    fd.append('revenue_id_',rev_id);

                    $.ajax({
                        url:'util_forecast_revenue_save_update.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            if(response == 'success'){
                                $("#hotel_revenues").val(null);
                                $("#ancillary_revenues").val(null);
                                $("#spa_revenues").val(null);
                                $("#other_revenues").val(null);
                                $("#account_balance").val(null);
                                $("#date_month").val(null);
                                $("#date_year").val(null);
                                rev_id = 0;
                                $("#reload_revenues").load("util_forecast_revenue_reload.php");
                            }else{
                                alert("Revenues not saved.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                }
            }



            var expense_id = 0;

            function edit_expense(cost_id){

                var fd = new FormData();
                fd.append('expense_id_',cost_id);
                $.ajax({
                    url:'util_forecast_expense_get.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        if(response != ''){
                            const myArray = response.split(",");
                            $("#total_operating_cost").val(myArray[0]);
                            $("#administration_cost").val(myArray[1]);
                            $("#marketing").val(myArray[2]);
                            $("#taxes").val(myArray[3]);
                            $("#bank_charges").val(myArray[4]);
                            $("#total_loan").val(myArray[5]);
                            $("#other_costs").val(myArray[6]);
                            $("#date_year_cost").val(myArray[7]);
                            $("#date_month_cost").val(myArray[8]);
                            $("#ancillary_goods_cost").val(myArray[9]);
                            $("#spa_products_cost").val(myArray[10]);
                            expense_id = cost_id;
                        }else{
                            alert("Expenses not Get.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }

            function save_cost(){
                var total_operating_cost=$("#total_operating_cost").val();
                var administration_cost=$("#administration_cost").val();
                var marketing=$("#marketing").val();
                var taxes=$("#taxes").val();
                var bank_charges=$("#bank_charges").val();
                var total_loan=$("#total_loan").val();
                var other_costs=$("#other_costs").val();
                var date_month_cost=$("#date_month_cost").val();
                var date_year_cost=$("#date_year_cost").val();
                var ancillary_goods_cost=$("#ancillary_goods_cost").val();
                var spa_products_cost=$("#spa_products_cost").val();


                if(date_month_cost <= 0 || date_month_cost > 12){
                    alert("Enter Correct Month Number.");
                }else{
                    var fd = new FormData();
                    fd.append('ancillary_goods_cost_',ancillary_goods_cost);
                    fd.append('spa_products_cost_',spa_products_cost);
                    fd.append('total_operating_cost_',total_operating_cost);
                    fd.append('administration_cost_',administration_cost);
                    fd.append('marketing_',marketing);
                    fd.append('taxes_',taxes);
                    fd.append('bank_charges_',bank_charges);
                    fd.append('total_loan_',total_loan);
                    fd.append('other_costs_',other_costs);
                    fd.append('date_month_cost_',date_month_cost);
                    fd.append('date_year_cost_',date_year_cost);
                    fd.append('expense_id_',expense_id);

                    $.ajax({
                        url:'util_forecast_expense_save_update.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            if(response == 'success'){
                                $("#ancillary_goods_cost").val(null);
                                $("#spa_products_cost").val(null);
                                $("#total_operating_cost").val(null);
                                $("#administration_cost").val(null);
                                $("#marketing").val(null);
                                $("#taxes").val(null);
                                $("#bank_charges").val(null);
                                $("#total_loan").val(null);
                                $("#other_costs").val(null);
                                $("#date_month_cost").val(null);
                                $("#date_year_cost").val(null);
                                expense_id = 0;
                                $("#reload_expenses").load("util_forecast_expense_reload.php");
                            }else{
                                alert("Expenses not saved.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });


                }



            }



            var facts_id = 0;

            function edit_facts(fact_id){

                var fd = new FormData();
                fd.append('facts_id_',fact_id);
                $.ajax({
                    url:'util_forecast_facts_get.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        if(response != ''){
                            const myArray = response.split(",");
                            $("#rooms").val(myArray[0]);
                            $("#beds").val(myArray[1]);
                            $("#opening_days").val(myArray[2]);
                            $("#total_capacity").val(myArray[3]);
                            $("#date_year_key").val(myArray[4]);
                            $("#date_month_key").val(myArray[5]);
                            facts_id = fact_id;
                        }else{
                            alert("Key Facts not Get.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }


            function save_facts(){
                var rooms=$("#rooms").val();
                var beds=$("#beds").val();
                var opening_days=$("#opening_days").val();
                var total_capacity=$("#total_capacity").val();
                var date_month_key=$("#date_month_key").val();
                var date_year_key=$("#date_year_key").val();

                if(date_month_cost <= 0 || date_month_cost > 12){
                    alert("Enter Correct Month Number.");
                }else{
                    var fd = new FormData();
                    fd.append('rooms_',rooms);
                    fd.append('beds_',beds);
                    fd.append('opening_days_',opening_days);
                    fd.append('total_capacity_',total_capacity);
                    fd.append('date_month_key_',date_month_key);
                    fd.append('date_year_key_',date_year_key);
                    fd.append('facts_id_',facts_id);

                    $.ajax({
                        url:'util_forecast_facts_save_update.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            if(response == 'success'){
                                $("#rooms").val(null);
                                $("#beds").val(null);
                                $("#opening_days").val(null);
                                $("#total_capacity").val(null);
                                $("#date_month_key").val(null);
                                $("#date_year_key").val(null);
                                facts_id = 0;
                                $("#reload_facts").load("util_forecast_facts_reload.php");
                            }else{
                                alert("Key Facts not saved.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });


                }
            }

            var goods_id = 0;

            function edit_goods(good_id){

                var fd = new FormData();
                fd.append('goods_id_',good_id);
                $.ajax({
                    url:'util_forecast_goods_get.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){

                        if(response != ''){
                            const myArray = response.split(",");

                            $("#meat_cost").val(myArray[0]);
                            $("#meat_supplier").val(myArray[1]);
                            $("#fruit_cost").val(myArray[2]);
                            $("#fruit_supplier").val(myArray[3]);
                            $("#bread_cost").val(myArray[4]);
                            $("#bread_supplier").val(myArray[5]);
                            $("#frozen_cost").val(myArray[6]);
                            $("#frozen_supplier").val(myArray[7]);
                            $("#dairy_cost").val(myArray[8]);
                            $("#dairy_supplier").val(myArray[9]);
                            $("#cons_cost").val(myArray[10]);
                            $("#cons_supplier").val(myArray[11]);
                            $("#tea_cost").val(myArray[12]);
                            $("#tea_supplier").val(myArray[13]);
                            $("#coffee_cost").val(myArray[14]);
                            $("#coffee_supplier").val(myArray[15]);
                            $("#cheese_cost").val(myArray[16]);
                            $("#cheese_supplier").val(myArray[17]);
                            $("#eggs_cost").val(myArray[18]);
                            $("#eggs_supplier").val(myArray[19]);
                            $("#minus_costs").val(myArray[20]);
                            $("#date_year_goods").val(myArray[21]);
                            $("#date_month_goods").val(myArray[22]);

                            goods_id = good_id;
                        }else{
                            alert("Goods Cost not Get.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }

            function save_goods_cost(){
                var meat_cost=$("#meat_cost").val();
                var meat_supplier=$("#meat_supplier").val();
                var fruit_cost=$("#fruit_cost").val();
                var fruit_supplier=$("#fruit_supplier").val();
                var bread_cost=$("#bread_cost").val();
                var bread_supplier=$("#bread_supplier").val();
                var frozen_cost=$("#frozen_cost").val();
                var frozen_supplier=$("#frozen_supplier").val();
                var dairy_cost=$("#dairy_cost").val();
                var dairy_supplier=$("#dairy_supplier").val();
                var cons_cost=$("#cons_cost").val();
                var cons_supplier=$("#cons_supplier").val();
                var tea_cost=$("#tea_cost").val();
                var tea_supplier=$("#tea_supplier").val();
                var coffee_cost=$("#coffee_cost").val();
                var coffee_supplier=$("#coffee_supplier").val();
                var cheese_cost=$("#cheese_cost").val();
                var cheese_supplier=$("#cheese_supplier").val();
                var eggs_cost=$("#eggs_cost").val();
                var eggs_supplier=$("#eggs_supplier").val();
                var minus_costs=$("#minus_costs").val();
                var date_month_goods=$("#date_month_goods").val();
                var date_year_goods=$("#date_year_goods").val();


                if(date_month_goods <= 0 || date_month_goods > 12){
                    alert("Enter Correct Month Number.");
                }else{
                    var fd = new FormData();
                    fd.append('meat_cost_',meat_cost);
                    fd.append('meat_supplier_',meat_supplier);
                    fd.append('fruit_cost_',fruit_cost);
                    fd.append('fruit_supplier_',fruit_supplier);
                    fd.append('bread_cost_',bread_cost);
                    fd.append('bread_supplier_',bread_supplier);
                    fd.append('frozen_cost_',frozen_cost);
                    fd.append('frozen_supplier_',frozen_supplier);
                    fd.append('dairy_cost_',dairy_cost);
                    fd.append('dairy_supplier_',dairy_supplier);
                    fd.append('cons_cost_',cons_cost);
                    fd.append('cons_supplier_',cons_supplier);
                    fd.append('tea_cost_',tea_cost);
                    fd.append('tea_supplier_',tea_supplier);
                    fd.append('coffee_cost_',coffee_cost);
                    fd.append('coffee_supplier_',coffee_supplier);
                    fd.append('cheese_cost_',cheese_cost);
                    fd.append('cheese_supplier_',cheese_supplier);
                    fd.append('eggs_cost_',eggs_cost);
                    fd.append('eggs_supplier_',eggs_supplier);
                    fd.append('minus_costs_',minus_costs);
                    fd.append('date_month_goods_',date_month_goods);
                    fd.append('date_year_goods_',date_year_goods);
                    fd.append('goods_id_',goods_id);

                    $.ajax({
                        url:'util_forecast_goods_save_update.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){

                            if(response == 'success'){
                                $("#meat_cost").val(null);
                                $("#meat_supplier").val(null);
                                $("#fruit_cost").val(null);
                                $("#fruit_supplier").val(null);
                                $("#bread_cost").val(null);
                                $("#bread_supplier").val(null);
                                $("#frozen_cost").val(null);
                                $("#frozen_supplier").val(null);
                                $("#dairy_cost").val(null);
                                $("#dairy_supplier").val(null);
                                $("#cons_cost").val(null);
                                $("#cons_supplier").val(null);
                                $("#tea_cost").val(null);
                                $("#tea_supplier").val(null);
                                $("#coffee_cost").val(null);
                                $("#coffee_supplier").val(null);
                                $("#cheese_cost").val(null);
                                $("#cheese_supplier").val(null);
                                $("#eggs_cost").val(null);
                                $("#eggs_supplier").val(null);
                                $("#minus_costs").val(null);
                                $("#date_month_goods").val(null);
                                $("#date_year_goods").val(null);

                                goods_id = 0;
                                $("#reload_goods").load("util_forecast_goods_reload.php");
                            }else{
                                alert("Goods Cost not saved.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });


                }
            }


            function dismiss_modal_delete_department(){
                $('#responsive-modal-department').hide();
            }

            function add_staff_depart(){
                $('#responsive-modal-department').show();
            }


            function add_department(){
                var depart_title=$("#depart_title_modal").val();

                var fd = new FormData();
                fd.append('depart_title',depart_title);
                $.ajax({
                    url:'util_forecast_staffing_departs_save.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        if(response == "success"){
                            $("#depart_title_modal").val(null);
                            $("#reload_departments").load("util_forecast_departments_reload.php");
                            $("#department_staffing").load("util_forecast_dropdown_department_reload.php");
                        }else{
                            alert("Staff Department not Saved.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }

            function delete_depart(id){
                $.ajax({
                    url:'util_update_status.php',
                    method:'POST',
                    data:{ tablename:"tbl_forecast_staffing_department", idname:"frcstfd_id ", id:id, statusid:1,statusname: "is_delete"},
                    success:function(response){
                        console.log(response);
                        if(response == "Updated"){
                            Swal.fire({
                                title: 'Deleted',
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => { 
                                if (result.value) {
                                    $("#reload_departments").load("util_forecast_departments_reload.php");
                                    $("#department_staffing").load("util_forecast_dropdown_department_reload.php");
                                }
                            })
                        }
                        else{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                footer: ''
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }


            var staffings_id = 0;

            function edit_staff_cost(staffing_id){

                var fd = new FormData();
                fd.append('staffings_id_',staffing_id);
                $.ajax({
                    url:'util_forecast_staffing_get.php',
                    type: 'post',
                    data:fd,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        if(response != ''){
                            const myArray = response.split(",");
                            $("#staff_name").val(myArray[0]);
                            $("#year_staffing").val(myArray[1]);
                            $("#gross_salary").val(myArray[2]);
                            $("#net_salary").val(myArray[3]);
                            $("#department_staffing").val(myArray[4]).change();
                            staffings_id = staffing_id;
                        }else{
                            alert("Staff Cost not Get.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });


            }


            function save_staff_cost(){
                var staff_name=$("#staff_name").val();
                var year_staffing=$("#year_staffing").val();
                var gross_salary=$("#gross_salary").val();
                var net_salary=$("#net_salary").val();
                var department_staffing=$("#department_staffing").val();



                if(year_staffing <= 0){
                    alert("Enter Correct Month Number.");
                }else{
                    var fd = new FormData();
                    fd.append('staff_name_',staff_name);
                    fd.append('year_staffing_',year_staffing);
                    fd.append('gross_salary_',gross_salary);
                    fd.append('net_salary_',net_salary);
                    fd.append('department_staffing_',department_staffing);
                    fd.append('staffings_id_',staffings_id);

                    $.ajax({
                        url:'util_forecast_staffing_save_update.php',
                        type: 'post',
                        data:fd,
                        processData: false,
                        contentType: false,
                        success:function(response){
                            if(response == 'success'){
                                $("#staff_name").val(null);
                                $("#year_staffing").val(null);
                                $("#gross_salary").val(null);
                                $("#net_salary").val(null);
                                $("#department_staffing").val(null).change();
                                staffings_id = 0;
                                $("#reload_staffing").load("util_forecast_staffing_reload.php");
                            }else{
                                alert("Staff Cost not saved.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });


                }
            }
        </script>

    </body>
</html>