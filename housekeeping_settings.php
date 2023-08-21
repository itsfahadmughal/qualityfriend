<?php
include 'util_config.php';
include 'util_session.php';


//get
$show_other = "";
$sql_task="SELECT * FROM `tbl_housekeeping_user_rule` WHERE `hotel_id` = $hotel_id";
$result_task = $conn->query($sql_task);
if ($result_task && $result_task->num_rows > 0) {
    while($row_task = mysqli_fetch_array($result_task)) {
        $show_other = $row_task['show_other'];

    } 

    
    if($show_other == 1 ){
        $show_other = "checked";
    }else{
       $show_other = ""; 
    }
}
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
        <title>Housekeeping</title>
        <!-- Footable CSS -->
        <link href="./assets/node_modules/footable/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="./assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

        <link href="dist/css/style.min.css" rel="stylesheet">
        <link href="dist/css/housekeeping.css" rel="stylesheet">
        <style>
            #div_cleaning_day {
                /*                visibility: hidden;*/
                display: none;
            }
            #div_laundry_day {
                /*                visibility: hidden;*/
                display: none;
            }

        </style>

    </head>
    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Housekeeping</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
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
                            <h4 class="text-themecolor font-weight-title font-size-title">Housekeeping</h4>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-3 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Housekeeping</a></li>
                                    <li class="breadcrumb-item text-success">Housekeeping</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->





                    <div class="row pr-4 mobile-container-padding">
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('housekeeping.php');">
                                <img src="dist/images/housekeeping.png" />
                                <h6 class="text-white pt-2">Housekeeping</h6>
                            </div>
                        </div>
                        <?php if($housekeeping_admin == 1){ ?> 
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background text-center padding-top-8" onclick="redirect_url('cleaning.php');">
                                <img src="dist/images/dailyplan.png" />
                                <h6 class="text-white pt-2">Daily Plans</h6>
                            </div>
                        </div>
                        <div class="col-lg-2 pr-0">
                            <div  class="list-background-active text-center padding-top-8" onclick="redirect_url('housekeeping_settings.php');">
                                <img src="dist/images/settings.png" />
                                <h6 class="text-white pt-2">Settings</h6>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->

                    <div class="row pl-3 pr-3">
                        <div class="col-lg-2 col-md-3 mt-2 mb-3 prm-0px plm-0">
                            <a  onclick="set_floor('Add Floor','<?php echo ""; ?>','<?php echo "" ?>')" data-toggle="modal"  data-target="#add-floor" data-dismiss="modal" href="JavaScript:void(0)" class="btn w-100 btn-secondary d-lg-block "><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp;&nbsp; Add Floor</a>
                        </div>
                        <div class="col-lg-2 col-md-3 mt-2 mb-3 prm-0px plm-0">
                            <a  onclick="set_room_category('Add Room Category','','','','','0','0','0','0','NONE','','NONE','')" data-toggle="modal"  data-target="#add-category" data-dismiss="modal" href="JavaScript:void(0)" class="btn w-100 btn-secondary d-lg-block "><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp;&nbsp;Add Room Categories</a>
                        </div>
                        <div class="col-lg-2 col-md-3 mt-2 mb-3 prm-0px plm-0">
                            <a onclick="set_room('Add Rooms','','','','','0','0','','','')"  data-toggle="modal"  data-target="#add-room" data-dismiss="modal" href="JavaScript:void(0)" class="btn w-100 btn-secondary d-lg-block "><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp;&nbsp;Add Room
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 mt-2 mb-3 prm-0px plm-0">
                            <a onclick="set_extra_jobs('Add cleaning Extra Jobs','','0','')" data-toggle="modal"  data-target="#add-extra" data-dismiss="modal" href="JavaScript:void(0)" class="btn w-100 btn-secondary d-lg-block "><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp;&nbsp;Add cleaning Extra Jobs</a>
                        </div>


                    </div>

                    <div class="row pl-3 pr-3 heading_style pt-3 pb-3">


                        <div id="add-extra" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="title_extra_jobs">Add cleaning Extra Jobs</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                            <div class="form-group">

                                                <div class="col-md-12 m-b-20 mt-2">
                                                    <div  id="" class="form-group ">
                                                        <input onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="extra_job"  placeholder="Cleaning Extra Jobs" required> 
                                                        <input hidden type="text" class="form-control" id="edit_extra_id">
                                                        <small id="error_msg_name_en_sub_cat" class="form-control-feedback display_none">Name is required</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 m-b-20 mt-2" >
                                                    <label class="control-label"><strong>Time To Clean</strong></label>
                                                    <div id="div_exta" class="form-group mt-2">
                                                        <select onchange="error_handle_sub('cat')" id="clean_extra" class="form-control custom-select">
                                                            <option value="0">Select Time</option>
                                                            <?php 
    $sql="SELECT * FROM `tb_time_interval`";
                               $result = $conn->query($sql);
                               if ($result && $result->num_rows > 0) {
                                   while($row = mysqli_fetch_array($result)) {
                                       $sc = "";
                                       $sc  = $row[1]." Minutes";

                                                            ?>
                                                            <option value="<?php echo $row[0];?>">
                                                                <?php echo $sc; ?></option>; 
                                                            <?php
                                   }
                               }
                                                            ?>
                                                        </select>
                                                        <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                    </div>

                                                </div>


                                            </div> 

                                        </from>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info waves-effect"  onclick="add_extra_job()">Save</button>
                                        <button type="submit" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div id="add-category" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!--                                                    Add Template Category-->
                                        <h4 class="modal-title" id="title_category">Add Room Category</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <ul class=" nav nav-tabs profile-tab" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#en" role="tab">English</a> </li>
                                        <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#it" role="tab">Italian</a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#de" role="tab">German </a> </li>
                                    </ul>
                                    <div class="modal-body">
                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="en" role="tabpanel">
                                                    <div class="form-group">

                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <div  id="div_name_en_sub_cat" class="form-group ">
                                                                <input onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="cat_name_en"  placeholder="Name" required> 
                                                                <input hidden type="text" class="form-control" id="edit_room_category_id">
                                                                <small id="error_msg_name_en_sub_cat" class="form-control-feedback display_none">Name is required</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-2" >

                                                            <label class="control-label"><strong>Time To Express Cleaning</strong></label>
                                                            <div id="div_normal" class="form-group mt-2">
                                                                <select onchange="error_handle_sub('cat')" id="time_to_ec" class="form-control custom-select">
                                                                    <option value="0">Select Time</option>
                                                                    <?php 
                                                                    $sql="SELECT * FROM `tb_time_interval`";
                                                                    $result = $conn->query($sql);
                                                                    if ($result && $result->num_rows > 0) {
                                                                        while($row = mysqli_fetch_array($result)) {
                                                                            $sc = "";
                                                                            $sc  = $row[1]." Minutes";

                                                                    ?>
                                                                    <option value="<?php echo $row[0];?>">
                                                                        <?php echo $sc; ?></option>; 
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12 m-b-20 mt-2" >

                                                            <label class="control-label"><strong>Time To Clean Normal</strong></label>
                                                            <div id="div_normal" class="form-group mt-2">
                                                                <select onchange="error_handle_sub('cat')" id="time_to_cn" class="form-control custom-select">
                                                                    <option value="0">Select Time</option>
                                                                    <?php 
                                                                    $sql="SELECT * FROM `tb_time_interval`";
                                                                    $result = $conn->query($sql);
                                                                    if ($result && $result->num_rows > 0) {
                                                                        while($row = mysqli_fetch_array($result)) {
                                                                            $sc = "";
                                                                            $sc  = $row[1]." Minutes";

                                                                    ?>
                                                                    <option value="<?php echo $row[0];?>">
                                                                        <?php echo $sc; ?></option>; 
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                            </div>

                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-2" >
                                                            <label class="control-label"><strong>Time To Clean Departure</strong></label>
                                                            <div id="div_departure" class="form-group mt-2">
                                                                <select onchange="error_handle_sub('cat')" id="time_to_cd" class="form-control custom-select">
                                                                    <option value="0">Select Time</option>
                                                                    <?php 
                                                                    $sql="SELECT * FROM `tb_time_interval`";
                                                                    $result = $conn->query($sql);
                                                                    if ($result && $result->num_rows > 0) {
                                                                        while($row = mysqli_fetch_array($result)) {
                                                                            $sc = "";
                                                                            $sc  = $row[1]." Minutes";

                                                                    ?>
                                                                    <option value="<?php echo $row[0];?>">
                                                                        <?php echo $sc; ?></option>; 
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                            </div>

                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-2" >

                                                            <label class="control-label"><strong>Time To Final Clean</strong></label>
                                                            <div id="div_final" class="form-group mt-2">
                                                                <select onchange="error_handle_sub('cat')" id="time_to_fc" class="form-control custom-select">
                                                                    <option value="0">Select Time</option>
                                                                    <?php 
                                                                    $sql="SELECT * FROM `tb_time_interval`";
                                                                    $result = $conn->query($sql);
                                                                    if ($result && $result->num_rows > 0) {
                                                                        while($row = mysqli_fetch_array($result)) {
                                                                            $sc = "";
                                                                            $sc  = $row[1]." Minutes";

                                                                    ?>
                                                                    <option value="<?php echo $row[0];?>">
                                                                        <?php echo $sc; ?></option>; 
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                            </div>

                                                        </div>


                                                        <div class="col-md-12 m-b-20 mt-2" >

                                                            <label class="control-label"><strong>Cleaning frequency</strong></label>
                                                            <div id="div_cleaning" class="form-group mt-2">
                                                                <select onchange="error_handle_sub('cat')" id="cleaning" class="form-control custom-select">
                                                                    <option value="NONE" >None</option>
                                                                    <option value="DAILY" >Daily</option>
                                                                    <option value="EVERY_SECOUND_DAY">Every Second Day</option>
                                                                    <option value="EVERY_THIRD_DAY" >Every Third Day</option>
                                                                    <option value="EVERY_FOURTH_DAY">Every Fourth Day</option>
                                                                    <option value="EVERY_FIFTH_DAY" >Every Fifth Day</option>
                                                                    <option value="EVERY_WEEK">Every Week</option>
                                                                    <option value="SPECIFIC_DAY">Specific Day</option> 
                                                                </select>
                                                            </div>

                                                        </div>


                                                        <div id="div_cleaning_day" class="col-md-12 m-b-20" >    
                                                            <div class="row" >
                                                                <div class="col-md-3" > 
                                                                    <div class="custom-control custom-radio inline-div  mr-3">
                                                                        <input  type="radio" value="MONDAY" id="c_monday" name="cleaning_day" class="custom-control-input btn-info" checked >
                                                                        <label class="custom-control-label" for="c_monday">Monday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" > 
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="TUESDAY" id="c_tuesday" name="cleaning_day" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="c_tuesday">Tuesday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" > 
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="WEDNESDAY" id="c_wednesday" name="cleaning_day" class="custom-control-input btn-info"  >
                                                                        <label class="custom-control-label" for="c_wednesday">Wednesday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >   
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="THURSDAY" id="c_thursday" name="cleaning_day" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="c_thursday">Thursday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="FRIDAY" id="c_friday" name="cleaning_day" class="custom-control-input btn-info"  >
                                                                        <label class="custom-control-label" for="c_friday">Friday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >   
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="SATURDAY" id="c_saturday" name="cleaning_day" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="c_saturday">Saturday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >   
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="SUNDAY" id="c_sunday" name="cleaning_day" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="c_sunday">Sunday</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>



                                                        <div class="col-md-12 m-b-20 mt-2" >

                                                            <label class="control-label"><strong>Laundry change frequency</strong></label>
                                                            <div id="div_laundry" class="form-group mt-2">
                                                                <select onchange="error_handle_sub('cat')" id="laundry" class="form-control custom-select">
                                                                    <option value="NONE" >None</option>
                                                                    <option value="DAILY" >Daily</option>
                                                                    <option value="EVERY_SECOUND_DAY">Every Second Day</option>
                                                                    <option value="EVERY_THIRD_DAY" >Every Third Day</option>
                                                                    <option value="EVERY_FOURTH_DAY">Every Fourth Day</option>
                                                                    <option value="EVERY_FIFTH_DAY" >Every Fifth Day</option>
                                                                    <option value="EVERY_WEEK">Every Week</option>
                                                                    <option value="SPECIFIC_DAY">Specific Day</option> 
                                                                </select>
                                                            </div>

                                                        </div>


                                                        <div id="div_laundry_day" class="col-md-12 m-b-20" >    
                                                            <div class="row" >
                                                                <div class="col-md-3" > 
                                                                    <div class="custom-control custom-radio inline-div  mr-3">
                                                                        <input  type="radio" value="MONDAY" id="l_monday" name="laundry_days" class="custom-control-input btn-info" checked >
                                                                        <label class="custom-control-label" for="l_monday">Monday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" > 
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="TUESDAY" id="l_tuesday" name="laundry_days" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="l_tuesday">Tuesday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" > 
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="WEDNESDAY" id="l_wednesday" name="laundry_days" class="custom-control-input btn-info"  >
                                                                        <label class="custom-control-label" for="l_wednesday">Wednesday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >   
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="THURSDAY" id="l_thursday" name="laundry_days" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="l_thursday">Thursday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="FRIDAY" id="l_friday" name="laundry_days" class="custom-control-input btn-info"  >
                                                                        <label class="custom-control-label" for="l_friday">Friday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >   
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="SATURDAY" id="l_saturday" name="laundry_days" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="l_saturday">Saturday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3" >   
                                                                    <div class="custom-control custom-radio inline-div mr-3">
                                                                        <input  type="radio" value="SUNDAY" id="l_sunday" name="laundry_days" class="custom-control-input btn-info" >
                                                                        <label class="custom-control-label" for="l_sunday">Sunday</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>




                                                    </div> 
                                                </div>
                                                <div class="tab-pane" id="it" role="tabpanel">
                                                    <div class="form-group">

                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <div  id="div_name_it_sub_cat" class="form-group ">
                                                                <input   onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="cat_name_it"  placeholder="Name">
                                                                <small id="error_msg_name_it_sub_cat" class="form-control-feedback display_none">Category Name is required</small>
                                                            </div>
                                                        </div>
                                                    </div> 

                                                </div>
                                                <div class="tab-pane" id="de" role="tabpanel">
                                                    <div class="form-group">

                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <div  id="div_name_de_sub_cat" class="form-group ">
                                                                <input  onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="cat_name_de" placeholder="Name"> 
                                                                <small id="error_msg_name_de_sub_cat" class="form-control-feedback display_none">Category Name is required</small>
                                                            </div></div>
                                                    </div> 

                                                </div>
                                            </div>
                                        </from>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info waves-effect"  onclick="add_room_category()">Save</button>
                                        <button type="submit" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>


                        <div id="add-room" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="title_room">Add Room</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <ul class=" nav nav-tabs profile-tab" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#en_r" role="tab">English</a> </li>
                                        <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#it_r" role="tab">Italian</a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#de_r" role="tab">German </a> </li>
                                    </ul>
                                    <div class="modal-body">
                                        <from class="form-horizontal" onsubmit="event.preventDefault();">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="en_r" role="tabpanel">
                                                    <div class="form-group">

                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <div  id="" class="form-group ">
                                                                <input onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="room_name_en"  placeholder="Room Name" required> 
                                                                <small id="error_msg_name_en_sub_cat" class="form-control-feedback display_none">Name is required</small>


                                                                <input hidden type="text" class="form-control" id="edit_room_id">
                                                            </div>
                                                            <div  id="" class="form-group ">
                                                                <input onkeyup="error_handle_sub('id')"  min="1" type="number" class="form-control" id="room_number"  placeholder="Room Number" required> 
                                                                <small id="" class="form-control-feedback display_none">Name is required</small>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12 m-b-20 mt-2" >

                                                            <label class="control-label"><strong>Room Category</strong></label>
                                                            <div id="div_category" class="form-group">
                                                                <select onchange="error_handle_sub('cat')" id="room_cat_id_rooms" class="form-control custom-select">
                                                                    <option value="0">Select Category</option>
                                                                    <?php 
                                                                    $sql="SELECT * FROM `tbl_room_category` WHERE hotel_id = $hotel_id AND `is_active` = 1 AND `is_delete` = 0  ORDER BY `tbl_room_category`.`room_cat_id` ASC";
                                                                    $result = $conn->query($sql);
                                                                    if ($result && $result->num_rows > 0) {
                                                                        while($row = mysqli_fetch_array($result)) {
                                                                            $sc = "";
                                                                            $sc  = $row[1];

                                                                    ?>
                                                                    <option value="<?php echo $row[0];?>">
                                                                        <?php echo $sc; ?></option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                            </div>

                                                        </div>
                                                        <div class="col-md-12 m-b-20" >

                                                            <label class="control-label"><strong>Floor</strong></label>
                                                            <div id="" class="form-group">
                                                                <select onchange="error_handle_sub('cat')" id="select_floor_id" class="form-control custom-select">
                                                                    <option value="0">Select Floor</option>
                                                                    <?php 
                                                                    $sql="SELECT * FROM `tbl_floors` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0 ORDER BY `tbl_floors`.`floor_num` ASC";
                                                                    $result = $conn->query($sql);
                                                                    if ($result && $result->num_rows > 0) {
                                                                        while($row = mysqli_fetch_array($result)) {
                                                                            $sc = "";

                                                                            $sc  = $row[1];

                                                                    ?>
                                                                    <option value="<?php echo $row[0];?>">
                                                                        <?php echo $sc; ?></option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small id="error_msg_category" class="form-control-feedback display_none"> Category is required</small> 
                                                            </div>

                                                        </div>



                                                        <div id="refrash" class="col-md-12 m-b-20">
                                                            <label class="control-label"><strong>Add Room Checks</strong></label>
                                                            <div class="row">
                                                                <div class="col-lg-10 col-xlg-10 col-md-10">
                                                                    <input type="text" class="form-control" id="add_check_list_item" placeholder="Enter text"> 
                                                                </div>
                                                                <div class ="col-lg-2 col-xlg-2 col-md-2 font-size-title"style="text-align: center; display: flex; justify-content: center;align-items: center;" >
                                                                    <a onclick="add_list()" href="javascript:void(0)"><i class="mdi mdi-plus-circle"></i></a>
                                                                </div>
                                                            </div>
                                                            <div id="checklists" class="mt-2 row">

                                                            </div>

                                                        </div>


                                                        <div id="refrash1" class="col-md-12 m-b-20">
                                                            <label class="control-label"><strong>Add Room Arrival Checks</strong></label>
                                                            <div class="row">
                                                                <div class="col-lg-10 col-xlg-10 col-md-10">
                                                                    <input type="text" class="form-control" id="add_check_list_item_a" placeholder="Enter text"> 
                                                                </div>
                                                                <div class ="col-lg-2 col-xlg-2 col-md-2 font-size-title"style="text-align: center; display: flex; justify-content: center;align-items: center;" >
                                                                    <a onclick="add_list_a()" href="javascript:void(0)"><i class="mdi mdi-plus-circle"></i></a>
                                                                </div>
                                                            </div>
                                                            <div id="checklists_arrival" class="mt-2 row">

                                                            </div>

                                                        </div>








                                                    </div> 
                                                </div>
                                                <div class="tab-pane" id="it_r" role="tabpanel">
                                                    <div class="form-group">

                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <div  id="" class="form-group ">
                                                                <input   onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="room_name_it"  placeholder="Room Name">
                                                                <small id="" class="form-control-feedback display_none">Category Name is required</small>
                                                            </div>
                                                        </div>
                                                    </div> 

                                                </div>
                                                <div class="tab-pane" id="de_r" role="tabpanel">
                                                    <div class="form-group">

                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <div  id="" class="form-group ">
                                                                <input  onkeyup="error_handle_sub('name')"  type="text" class="form-control" id="room_name_de"placeholder="Room Name"> 
                                                                <small id="" class="form-control-feedback display_none">Category Name is required</small>
                                                            </div></div>



                                                    </div> 

                                                </div>
                                            </div>
                                        </from>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info waves-effect"  onclick="add_rooms()">Save</button>
                                        <button type="submit" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>







                        <div id="add-floor" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="title_floor">Add Floor</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>

                                    <div class="modal-body">
                                        <from class="form-horizontal" onsubmit="event.preventDefault();">

                                            <div class="tab-pane "  >
                                                <div class="form-group">

                                                    <div class="col-md-12 m-b-20 mt-2">
                                                        <div  id="div_name_en" class="form-group ">
                                                            <input onkeyup="error_handle('name_en')" type="text" class="form-control" id="floor_number" placeholder="Floor Number"> 


                                                            <input hidden type="text" class="form-control" id="edit_floor_id">

                                                            <small id="error_msg_name_en" class="form-control-feedback display_none"></small>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </from>
                                    </div>
                                    <div class="modal-footer">
                                        <a type="submit" class="btn btn-info waves-effect"  onclick="add_floor()"  data-toggle="modal"   href="">Save</a>
                                        <a class="btn btn-default waves-effect" data-toggle="modal"  data-target="#add-contact" href="" data-dismiss="modal">Cancel</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <!--StartMain-->
                        <div class="col-lg-12  col-md-12">
                            <div class='row' >
                                <div class="col-lg-12  col-md-12">
                                    <div class="checkbox checkbox-success mt-2">
                                        <input  <?php echo $show_other; ?>    onchange="update_status()" id="active_id" type="checkbox" class="checkbox-size-20 pt-2">
                                        <label class="font-weight-title pl-2 mb-2"><b><h4>Show all users jobs</h4></b></label>
                                    </div>
                                </div>
                            </div>

                            <div class='row' >
                                <div class='col-lg-12 col-xlg-12 col-md-12'>
                                    <h4><b>Floors</b></h4>
                                </div>
                                <?php
                                $sql="SELECT * FROM `tbl_floors` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0 ORDER BY `tbl_floors`.`floor_num` ASC";
                                $result = $conn->query($sql);
                                $i = 0;
                                $div_id =0;
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        $floor_id       = $row["floor_id"];
                                        $floor_name    = $row["floor_name"];
                                        $floor_num    = $row["floor_num"];
                                ?>
                                <div  class='col-lg-3 col-xlg-3 col-md-3 mt-3 '>
                                    <div id="<?php echo "div_floor_".$div_id ?>" onclick='selected_divs(this,<?php echo $floor_id ?>,"floor")' class='divacb div-department-height div-white-background '>
                                        <div class='row pt-4' >
                                            <div class='col-lg-8 col-xlg-8 col-md-8 wm-70'>
                                                <p class='font-size-subheading ml-3'>
                                                    &nbsp;&nbsp;&nbsp;<?php echo   $floor_num; ?>
                                                </p>
                                            </div>
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                <a data-toggle="modal"  data-target="#add-floor" data-dismiss="modal"  onclick="set_floor('Edit Floor',<?php echo $floor_num; ?>,<?php echo $floor_id ?>)" href="javascript:void(0)"
                                                   > <img width="30" height="30"  class='' src="./assets/images/edit.png" alt="Girl in a jacket"></a>
                                            </div> 
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15 plm-5px'>
                                                <img onclick="delete_items('floor','<?php echo $floor_id; ?>')" width="30" height="30" id=''  type='button' class='' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">
                                            </div> 
                                        </div>

                                    </div>
                                </div>
                                <?php 

                                        $div_id = $div_id + 1;

                                    }}?>
                            </div>



                            <div class='row mt-3' >
                                <div class='col-lg-12 col-xlg-12 col-md-12'>
                                    <h4><b>Room Categories</b></h4>
                                </div>
                                <?php
                                $sql="SELECT * FROM `tbl_room_category` WHERE hotel_id = $hotel_id AND `is_active` = 1 AND `is_delete` = 0  ORDER BY `tbl_room_category`.`room_cat_id` ASC";
                                $result = $conn->query($sql);
                                $i = 0;
                                $div_id_catehory = 0;
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {

                                        $room_cat_id          =  $row["room_cat_id"];
                                        $category_name          = $row["category_name"];
                                        $category_name_s =  str_replace('"',"-",$category_name);
                                        $category_name_it       = $row["category_name_it"];
                                        $category_name_it_s =  str_replace('"',"-",$category_name_it);
                                        $category_name_de       = $row["category_name_de"];
                                        $category_name_de_s    =  str_replace('"',"-",$category_name_de);

                                        $category_name_show = "";
                                        if($category_name_s != ""){
                                            $category_name_show = $category_name_s; 
                                        }else if($category_name_de_s != ""){
                                            $category_name_show = $category_name_de_s; 
                                        }else if($category_name_it_s != ""){
                                            $category_name_show = $category_name_it_s; 
                                        }




                                        $time_to_CN             = $row["time_to_CN"];
                                        $time_to_CD             = $row["time_to_CD"];
                                        $time_to_FC             = $row["time_to_FC"];
                                        $time_to_EC             = $row["time_to_EC"];

                                        $cleaning_frequency     = $row["cleaning_frequency"];
                                        $cleaning_day         = $row["cleaning_day"]; 

                                        $laundry_frequency      = $row["laundry_frequency"]; 
                                        $laundry_day            = $row["laundry_day"]; 




                                ?>
                                <div class='col-lg-3 col-xlg-3 col-md-3 mt-3'>


                                    <div id="<?php echo "div_category_".$div_id_catehory; ?>" onclick='selected_divs(this,<?php echo $room_cat_id ?>,"category")' class='divacb div-white-background pointer'>
                                        <div class='row pt-4' >
                                            <div class='col-lg-8 col-xlg-8 col-md-8 wm-70'>
                                                <p class='font-size-subheading ml-3'>
                                                    &nbsp;&nbsp;&nbsp;<?php echo   $category_name_show; ?>
                                                </p>
                                            </div>
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                <a 
                                                   data-toggle="modal" data-target="#add-category" href="javascript:void(0)"

                                                   onclick='set_room_category("Edit Room Category",
                                                            "<?php echo $room_cat_id;?>",
                                                            "<?php echo $category_name_s; ?>",
                                                            "<?php echo $category_name_it_s; ?>",
                                                            "<?php echo $category_name_de_s; ?>",
                                                            "<?php echo $time_to_CN; ?>",
                                                            "<?php echo $time_to_CD; ?>",
                                                            "<?php echo $time_to_FC; ?>",
                                                            "<?php echo $time_to_EC; ?>",
                                                            "<?php echo $cleaning_frequency; ?>",
                                                            "<?php echo $cleaning_day; ?>",
                                                            "<?php echo $laundry_frequency; ?>",
                                                            "<?php echo $laundry_day; ?>")'

                                                   > <img width="30" height="30"  class='' src="./assets/images/edit.png" alt="Girl in a jacket"></a>
                                            </div> 
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15 plm-5px'>
                                                <img onclick="delete_items('category','<?php echo $room_cat_id; ?>')"  width="30" height="30" id=''  type='button' class='' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">
                                            </div> 
                                        </div>

                                    </div>
                                </div>
                                <?php 
                                        $div_id_catehory = $div_id_catehory + 1;
                                    }}?>
                            </div>
                            <div  id="rooms_list"  class='row mt-3' >
                                <div class='col-lg-12 col-xlg-12 col-md-12'>
                                    <h4><b>Rooms</b></h4>
                                </div>
                                <?php
                                $sql="SELECT * FROM `tbl_rooms` WHERE `hotel_id` =  $hotel_id  AND `is_delete` = 0 ORDER BY `room_num` ASC";
                                $result = $conn->query($sql);
                                $i = 0;
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {

                                        $rms_id           = $row["rms_id"];
                                        $room_num         = $row["room_num"];
                                        $room_name        = $row["room_name"];
                                        $room_name_it     = $row["room_name_it"];
                                        $room_name_de     = $row["room_name_de"];
                                        $floor_id         = $row["floor_id"];
                                        $room_cat_id      = $row["room_cat_id"];

                                        $room_checks =  "";
                                        $checklist =  "";
                                        $sql_checks="SELECT * FROM `tbl_room_check` WHERE `room_id` =  $rms_id";
                                        $result_checks = $conn->query($sql_checks);
                                        if ($result_checks && $result_checks->num_rows > 0) {
                                            while($row_checks = mysqli_fetch_array($result_checks)) {
                                                $checklist      = $row_checks["checklist"];
                                                if($room_checks == ""){

                                                    $room_checks= $checklist;
                                                }else {
                                                    $room_checks= $room_checks."-".$checklist;
                                                }


                                            }}else{

                                        }


                                        $room_checks_arrival =  "";
                                        $checklist =  "";
                                        $sql_checks="SELECT * FROM `tbl_room__arrival_check` WHERE `room_id` =  $rms_id";
                                        $result_checks = $conn->query($sql_checks);
                                        if ($result_checks && $result_checks->num_rows > 0) {
                                            while($row_checks = mysqli_fetch_array($result_checks)) {
                                                $checklist      = $row_checks["checklist"];
                                                if($room_checks_arrival == ""){

                                                    $room_checks_arrival= $checklist;
                                                }else {
                                                    $room_checks_arrival= $room_checks_arrival."-".$checklist;
                                                }


                                            }}else{

                                        }




                                ?>
                                <div class='col-lg-3 col-xlg-3 col-md-3 mt-2'>
                                    <div class='pt-3 pb-3 div-white-background pointer'>
                                        <div class='row ' >
                                            <div class='col-lg-8 col-xlg-8 col-md-8 pl-4 wm-70'>
                                                <h5><?php echo "Room Number : ".$room_num ;?></h5>
                                            </div>
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                <a   onclick="set_room('Edit Rooms',
                                                              '<?php echo $room_num; ?>',
                                                              '<?php echo $room_name; ?>',
                                                              '<?php echo $room_name_it; ?>',
                                                              '<?php echo $room_name_de; ?>',
                                                              '<?php echo $room_cat_id; ?>',
                                                              '<?php echo $floor_id; ?>',
                                                              '<?php echo $rms_id; ?>',
                                                              '<?php echo $room_checks; ?>',
                                                              '<?php echo $room_checks_arrival; ?>'



                                                              )" data-toggle="modal"  data-target="#add-room" data-dismiss="modal" href="JavaScript:void(0)"

                                                   > <img width="30" height="30"  class='' src="./assets/images/edit.png" alt="Girl in a jacket"></a>
                                            </div> 
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15 plm-5px'>
                                                <img onclick="delete_items('room','<?php echo $rms_id; ?>')"  width="30" height="30" id=''  type='button' class='' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">
                                            </div> 
                                        </div>

                                    </div>
                                </div>
                                <?php }}?>
                            </div>
                            <div class='row mt-3' >
                                <div class='col-lg-12 col-xlg-12 col-md-12'>
                                    <h4><b>Add cleaning Extra Jobs</b></h4>
                                </div>
                                <?php
                                $sql="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` =  $hotel_id AND `is_delete` = 0";
                                $result = $conn->query($sql);
                                $i = 0;
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {


                                        $hkej_id       = $row["hkej_id"];
                                        $time_to_complate       = $row["time_to_complate"];
                                        $job_title       = $row["job_title"];

                                ?>
                                <div class='col-lg-3 col-xlg-3 col-md-3 mt-3'>
                                    <div class=' div-white-background '>
                                        <div class='row pt-4' >
                                            <div class='col-lg-8 col-xlg-8 col-md-8 wm-70'>
                                                <p class='font-size-subheading ml-3'>
                                                    &nbsp;&nbsp;&nbsp;<?php echo    $job_title; ?>
                                                </p>
                                            </div>
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                                                <a onclick="set_extra_jobs('Edit cleaning Extra Jobs',
                                                            '<?php echo $job_title; ?>',
                                                            '<?php echo $time_to_complate; ?>',
                                                            '<?php echo $hkej_id; ?>')" data-toggle="modal"  data-target="#add-extra" data-dismiss="modal" href="JavaScript:void(0)"

                                                   > <img width="30" height="30"  class='' src="./assets/images/edit.png" alt="Girl in a jacket"></a>
                                            </div> 
                                            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15 plm-5px'>
                                                <img  onclick="delete_items('extra_jobs','<?php echo $hkej_id; ?>')" width="30" height="30" id=''  type='button' class='' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">
                                            </div> 


                                        </div>

                                    </div>
                                </div>
                                <?php }}?>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
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

        <script>

            function update_status() {
                var active_id= document.getElementById("active_id").checked;
                if(active_id == false){
                    active_id = 0;
                }else{
                    active_id = 1  ;
                }
                $.ajax({
                    url:"housekeeping_utills/utill_user_show.php",
                    method:'POST',
                    data:{ active_id:active_id},
                    success:function(response){

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });

            }

            var checklist = [];
            var checklist_arrival = [];

            function add_list() {
                var add_check_list_item = document.getElementById('add_check_list_item').value;
                checklist.push(add_check_list_item);
                for (let i = 0; i < checklist.length; i++) {
                    console.log(checklist[i]);
                }
                load_list(checklist);
                document.getElementById('add_check_list_item').value='';
            }
            function add_list_a() {
                var add_check_list_item_a = document.getElementById('add_check_list_item_a').value;
                checklist_arrival.push(add_check_list_item_a);
                for (let i = 0; i < checklist_arrival.length; i++) {
                    console.log(checklist_arrival[i]);
                }
                load_list_a(checklist_arrival);
                document.getElementById('add_check_list_item_a').value='';
            }
            function load_list(checklist) {
                //                document.getElementById(load_div).innerHTML = "";
                $.ajax({
                    url:"housekeeping_room_check_reload.php",
                    method:'POST',
                    data:{ checklist:checklist},
                    success:function(response){
                        document.getElementById('checklists').innerHTML = response;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }
            function load_list_a(checklist_arrival) {

                $.ajax({
                    url:"housekeeping_room_check_arrivle_reload.php",
                    method:'POST',
                    data:{ checklist_arrival:checklist_arrival},
                    success:function(response){
                        document.getElementById('checklists_arrival').innerHTML = response;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            }
            function update_list(newdep_list){ 
                console.log(newdep_list);
                var removed = checklist.splice(newdep_list,1);
                load_list(checklist);
            }
            function update_list_a(newdep_list){ 
                console.log(newdep_list);
                console.log(checklist_arrival);
                var removed = checklist_arrival.splice(newdep_list,1);
                load_list_a(checklist_arrival);
            }


        </script>
        <script>
            $('#cleaning').on('change',function(){
                var div_cleaning_day =    document.getElementById('div_cleaning_day');
                var cleaning = document.getElementById("cleaning").value;
                console.log(cleaning);
                if(cleaning == 'SPECIFIC_DAY'){

                    div_cleaning_day.style.display = 'block';
                }else{

                    div_cleaning_day.style.display = 'none';

                }
            });
            $('#laundry').on('change',function(){
                var div_laundry_day =    document.getElementById('div_laundry_day');
                var laundry = document.getElementById("laundry").value;
                if(laundry == 'SPECIFIC_DAY'){
                    div_laundry_day.style.display = 'block';
                }else{

                    div_laundry_day.style.display = 'none';

                }
            });
        </script>
        <script>
            function selected_divs(elem,selected_id,name){
                var id = $(elem).attr("id");
                $(".divacb").removeClass("selected_div");
                document.getElementById(id).classList.add('selected_div');
                $.ajax({
                    url:'housekeeping_setting_room_reload.php',
                    method:'POST',
                    data:{name:name,selected_id:selected_id,name:name},
                    success:function(response){
                        document.getElementById("rooms_list").innerHTML = response;        
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    },
                });
            } 
        </script>
        <script>
            function addroom_on(name_of,id_of,room_id){
                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_added.php',
                    method:'POST',
                    data:{ name_of:name_of,id_of:id_of,room_id:room_id},
                    success:function(response){
                        console.log(response);
                        if(response == "done"){
                            $.ajax({
                                url:'housekeeping_setting_room_reload.php',
                                method:'POST',
                                data:{name:name_of,selected_id:id_of},
                                success:function(response){
                                    document.getElementById("rooms_list").innerHTML = response;        
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                },
                            });
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

            function set_floor(title,floor_number,floor_id){
                document.querySelector("#title_floor").textContent = title;
                document.getElementById('floor_number').value = floor_number;
                document.getElementById('edit_floor_id').value = floor_id;

            }
            function set_room_category (title,room_cat_id,category_name,category_name_it,category_name_de,
                                         time_to_CN,time_to_CD,time_to_FC,time_to_EC,cleaning_frequency,cleaning_day,laundry_frequency,laundry_day){
                var div_cleaning_day =    document.getElementById('div_cleaning_day');
                var div_laundry_day =    document.getElementById('div_laundry_day');
                document.querySelector("#title_category").textContent = title;
                document.getElementById('cat_name_en').value = category_name;
                document.getElementById('cat_name_it').value = category_name_it;
                document.getElementById('cat_name_de').value = category_name_de;
                document.getElementById('edit_room_category_id').value = room_cat_id;
                $('#time_to_cn').val(time_to_CN);
                $('#time_to_cd').val(time_to_CD);
                $('#time_to_fc').val(time_to_FC);

                $('#time_to_ec').val(time_to_EC);




                console.log(cleaning_frequency);
                $('#cleaning').val(cleaning_frequency);

                if(cleaning_frequency == 'SPECIFIC_DAY'){

                    div_cleaning_day.style.display = 'block';
                }else{

                    div_cleaning_day.style.display = 'none';

                }
                var radios_cleaning_day = document.getElementsByName('cleaning_day');
                for (var radio of radios_cleaning_day)
                {
                    if ('MONDAY'== cleaning_day) {
                        document.getElementById("c_monday").checked = true; 
                    }
                    else if ('TUESDAY' == cleaning_day) {  
                        document.getElementById("c_tuesday").checked = true;
                    }
                    else if ('WEDNESDAY' == cleaning_day) {  
                        document.getElementById("c_wednesday").checked = true;

                    }
                    else if ('THURSDAY' == cleaning_day) {  
                        document.getElementById("c_thursday").checked = true;

                    }
                    else if ('FRIDAY' == cleaning_day) {  
                        document.getElementById("c_friday").checked = true;  

                    }
                    else if ('SATURDAY' == cleaning_day) {  
                        document.getElementById("c_saturday").checked = true;

                    }
                    else if ('SUNDAY' == cleaning_day) {  
                        document.getElementById("c_sunday").checked = true;  
                    }
                }
                $('#laundry').val(laundry_frequency);
                if(laundry_frequency == 'SPECIFIC_DAY'){

                    div_laundry_day.style.display = 'block';
                }else{

                    div_laundry_day.style.display = 'none';

                }
                var radioslaundry_days = document.getElementsByName('laundry_days');
                for (var radio of radioslaundry_days)
                {
                    if ('MONDAY'== laundry_day) {
                        document.getElementById("l_monday").checked = true; 
                    }
                    else if ('TUESDAY' == laundry_day) {  
                        document.getElementById("l_tuesday").checked = true;
                    }
                    else if ('WEDNESDAY' == laundry_day) {  
                        document.getElementById("l_wednesday").checked = true;

                    }
                    else if ('THURSDAY' == laundry_day) {  
                        document.getElementById("l_thursday").checked = true;

                    }
                    else if ('FRIDAY' == laundry_day) {  
                        document.getElementById("l_friday").checked = true;  

                    }
                    else if ('SATURDAY' == laundry_day) {  
                        document.getElementById("l_saturday").checked = true;

                    }
                    else if ('SUNDAY' == laundry_day) {  
                        document.getElementById("l_sunday").checked = true;  
                    }
                }
            }
            function set_room(title,room_number,room_name_en,room_name_it,room_name_de,category_id,select_floor_id,room_id,
                               checks, check_arrival){

                if(checks != ""){
                    const checkArray = checks.split("-");
                    checklist = checkArray;
                    load_list(checklist);
                }else{
                    checklist = [];
                    load_list(checklist);

                }


                if(check_arrival != ""){
                    const checkArray = check_arrival.split("-");
                    checklist_arrival = checkArray;
                    load_list_a(checklist_arrival);
                }else{
                    checklist_arrival = [];
                    load_list_a(checklist_arrival);

                }

                document.querySelector("#title_room").textContent = title;
                document.getElementById('room_number').value = room_number;
                document.getElementById('room_name_en').value = room_name_en;
                document.getElementById('room_name_it').value = room_name_it;
                document.getElementById('room_name_de').value = room_name_de;
                $('#room_cat_id_rooms').val(category_id); 
                $('#select_floor_id').val(select_floor_id); 
                document.getElementById('edit_room_id').value = room_id;

                console.log(check_arrival);



            }   
            function set_extra_jobs(title,extra_job,clean_extra,edit_extra_id){
                document.querySelector("#title_extra_jobs").textContent = title;
                document.getElementById('extra_job').value = extra_job;
                $('#clean_extra').val(clean_extra); 
                document.getElementById('edit_extra_id').value = edit_extra_id;

            }   


            function add_floor(){
                var title =  document.querySelector("#title_floor").textContent;
                if(title == "Add Floor"){
                    var add_or_edit = "Add";
                }else{
                    var add_or_edit = "Edit";
                }
                let floor_number=document.getElementById("floor_number").value;
                var edit_floor_id=document.getElementById("edit_floor_id").value;
                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_added.php',
                    method:'POST',
                    data:{ from:"floor", floor_number:floor_number,add_or_edit:add_or_edit,edit_floor_id,edit_floor_id,
                          add_or_edit :add_or_edit },
                    success:function(response){
                        console.log(response);
                        if(response == "done"){
                            location.replace("housekeeping_settings.php");
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

            function add_rooms(){
                var title =  document.querySelector("#title_room").textContent;
                if(title == "Add Rooms"){
                    var add_or_edit = "Add";
                }else{
                    var add_or_edit = "Edit";
                }
                var  room_number          =    document.getElementById('room_number').value ;
                var  room_name_en         =   document.getElementById('room_name_en').value ;
                var  room_name_it         =   document.getElementById('room_name_it').value ;
                var  room_name_de         =    document.getElementById('room_name_de').value;
                var  room_cat_id_rooms    = document.getElementById("room_cat_id_rooms").value;
                var  select_floor_id      = document.getElementById("select_floor_id").value;
                checklist = [];

                var get_id = document.getElementsByClassName("get-id");
                for (let i = 0; i < get_id.length; i++) {
                    let r = document.getElementById("checklist_"+i).value;
                    checklist.push(r);
                }


                checklist_arrival = [];

                var get_id_a = document.getElementsByClassName("get-id_a");
                for (let i = 0; i < get_id_a.length; i++) {
                    let r = document.getElementById("checklist_arrival_"+i).value;
                    checklist_arrival.push(r);
                }



                var edit_room_id=document.getElementById("edit_room_id").value;


                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_added.php',
                    method:'POST',
                    data:{ from:"rooms", room_number:room_number,room_name_en:room_name_en,room_name_it:room_name_it,room_name_de:room_name_de,room_cat_id_rooms:room_cat_id_rooms,select_floor_id:select_floor_id,add_or_edit:add_or_edit,edit_room_id:edit_room_id,checklist:checklist,checklist_arrival:checklist_arrival},
                    success:function(response){
                        console.log(response);
                        if(response == "done"){
                            location.replace("housekeeping_settings.php");
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

            function add_task(){

                var add_or_edit = "Add";
                var  task =    document.getElementById('task').value;
                var select_room_id     = document.getElementById("select_room_id").value;
                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_added.php',
                    method:'POST',
                    data:{ from:"task", task:task,select_room_id:select_room_id,add_or_edit:add_or_edit},
                    success:function(response){
                        console.log(response);
                        if(response == "done"){
                            location.replace("housekeeping_settings.php");
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

            function add_extra_job(){
                var title =  document.querySelector("#title_extra_jobs").textContent;
                if(title == "Add cleaning Extra Jobs"){
                    var add_or_edit = "Add";
                }else{
                    var add_or_edit = "Edit";
                }
                var  extra_job =    document.getElementById('extra_job').value;
                var clean_extra     = document.getElementById("clean_extra").value;
                var edit_extra_id     = document.getElementById("edit_extra_id").value;
                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_added.php',
                    method:'POST',
                    data:{ from:"extra_job", extra_job:extra_job,clean_extra:clean_extra,edit_extra_id:edit_extra_id,add_or_edit:add_or_edit},
                    success:function(response){
                        console.log(response);
                        if(response == "done"){
                            location.replace("housekeeping_settings.php");
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



            function add_room_category(){
                var title =  document.querySelector("#title_category").textContent;
                if(title == "Add Room Category"){
                    var add_or_edit = "Add";
                }else{
                    var add_or_edit = "Edit";
                }
                var room_cat_id =  document.getElementById('edit_room_category_id').value ;
                var cat_en = document.getElementById('cat_name_en').value ; 
                var cat_it =    document.getElementById('cat_name_it').value ;
                var cat_de = document.getElementById('cat_name_de').value;

                var time_to_cn = document.getElementById("time_to_cn").value;
                var time_to_cd = document.getElementById("time_to_cd").value;
                var time_to_fc = document.getElementById("time_to_fc").value;
                var time_to_ec = document.getElementById("time_to_ec").value;
                var cleaning = document.getElementById("cleaning").value;


                var cleaning_day ;
                var radios = document.getElementsByName('cleaning_day');
                for (var radio of radios)
                {
                    if (radio.checked) {
                        cleaning_day = radio.value;
                    }
                }
                var laundry = document.getElementById("laundry").value;
                var laundry_days ;
                var radios = document.getElementsByName('laundry_days');
                for (var radio of radios)
                {
                    if (radio.checked) {
                        laundry_days = radio.value;
                    }
                }

                if(cleaning == 'SPECIFIC_DAY'){


                }else{
                    cleaning_day = "NONE";
                }
                if(laundry == 'SPECIFIC_DAY'){


                }else{
                    laundry_days = "NONE";
                }
                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_added.php',
                    method:'POST',
                    data:{ from:"category", room_cat_id:room_cat_id,cat_en:cat_en,cat_it:cat_it,cat_de:cat_de,time_to_cn:time_to_cn,
                          time_to_cd:time_to_cd,time_to_fc:time_to_fc,time_to_ec:time_to_ec,cleaning:cleaning,cleaning_day:cleaning_day,
                          laundry:laundry,laundry_days:laundry_days,add_or_edit:add_or_edit},
                    success:function(response){
                        console.log(response);
                        if(response == "done"){
                            location.replace("housekeeping_settings.php");
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

            function delete_items(from,id){
                $.ajax({
                    url:'housekeeping_utills/utill_housekeeping_delete.php',
                    method:'POST',
                    data:{ from:from, id:id},
                    success:function(response){
                        location.replace("housekeeping_settings.php");


                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                    },
                });
            }
        </script>






        <script>
            function doubleclick(el, onsingle, ondouble) {
                if (el.getAttribute("data-dblclick") == null) {
                    el.setAttribute("data-dblclick", 1);
                    setTimeout(function () {
                        if (el.getAttribute("data-dblclick") == 1) {
                            onsingle();
                        }
                        el.removeAttribute("data-dblclick");
                    }, 300);
                } else {
                    el.removeAttribute("data-dblclick");
                    ondouble();
                }
            }


        </script>

        <script>

            function redirect_url(url) {
                window.location.href = url;
            }


        </script>
        <!-- jQuery peity -->
        <script src="./assets/node_modules/tablesaw/dist/tablesaw.jquery.js"></script>
        <script src="./assets/node_modules/tablesaw/dist/tablesaw-init.js"></script>
    </body>
</html>