<?php
include '../util_config.php';
include '../util_session.php';
$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entryby_time=date("Y-m-d H:i:s");;
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");





$room_cat_id = 0;
$cat_en = "";
$cat_it = "";
$cat_de = "";
$time_to_cn = 0;
$time_to_cd = 0;
$time_to_fc = 0;
$cleaning = "NONE";
$cleaning_day = "NONE";
$laundry = "NONE";
$laundry_days ="NONE";





$from = "";
$floor_number = "";
$add_or_edit = "";
$edit_floor_id = "";

//update_rooms_floor_category
$name_of = "";
$id_of = "";
$room_id = "";

$checklist =  array();
$checklist_arrival =  array();

if(isset($_POST['name_of'])){
    $name_of = $_POST['name_of'];
}
if(isset($_POST['id_of'])){
    $id_of = $_POST['id_of'];
}

if(isset($_POST['room_id'])){
    $room_id = $_POST['room_id'];
}
if(isset($_POST['room_id'])){
    $room_id = $_POST['room_id'];
}




if(isset($_POST['from'])){
    $from = $_POST['from'];
}
if(isset($_POST['add_or_edit'])){
    $add_or_edit = $_POST['add_or_edit'];
}

//floor
if(isset($_POST['floor_number'])){
    $floor_number = $_POST['floor_number'];
}

if(isset($_POST['edit_floor_id'])){
    $edit_floor_id = $_POST['edit_floor_id'];
}

//caregory
if(isset($_POST['room_cat_id'])){
    $room_cat_id = $_POST['room_cat_id'];
}
if(isset($_POST['cat_en'])){
    $cat_en = $_POST['cat_en'];
}

if(isset($_POST['cat_it'])){
    $cat_it = $_POST['cat_it'];
}
if(isset($_POST['cat_de'])){
    $cat_de = $_POST['cat_de'];
}
if(isset($_POST['time_to_cn'])){
    $time_to_cn = $_POST['time_to_cn'];
}

if(isset($_POST['time_to_cd'])){
    $time_to_cd = $_POST['time_to_cd'];
}
if(isset($_POST['time_to_fc'])){
    $time_to_fc = $_POST['time_to_fc'];
}
if(isset($_POST['time_to_ec'])){
    $time_to_ec = $_POST['time_to_ec'];
}
if(isset($_POST['cleaning'])){
    $cleaning = $_POST['cleaning'];
}
if(isset($_POST['cleaning_day'])){
    $cleaning_day = $_POST['cleaning_day'];
}
if(isset($_POST['laundry'])){
    $laundry = $_POST['laundry'];
}
if(isset($_POST['laundry_days'])){
    $laundry_days = $_POST['laundry_days'];
}
if(isset($_POST['checklist'])){
    $checklist = $_POST['checklist'];
}
if(isset($_POST['checklist_arrival'])){
    $checklist_arrival = $_POST['checklist_arrival'];
}

//rooms
$room_number = 0;
$room_name_en ="";
$room_name_it = "";
$room_name_de = "";
$room_cat_id_rooms = "";
$select_floor_id = "";
$edit_room_id = 0;
if(isset($_POST['room_number'])){
    $room_number = $_POST['room_number'];
}
if(isset($_POST['room_name_en'])){
    $room_name_en = $_POST['room_name_en'];
}

if(isset($_POST['room_name_it'])){
    $room_name_it = $_POST['room_name_it'];
}
if(isset($_POST['room_name_de'])){
    $room_name_de = $_POST['room_name_de'];
}
if(isset($_POST['room_cat_id_rooms'])){
    $room_cat_id_rooms = $_POST['room_cat_id_rooms'];
}

if(isset($_POST['select_floor_id'])){
    $select_floor_id = $_POST['select_floor_id'];
}
if(isset($_POST['edit_room_id'])){
    $edit_room_id = $_POST['edit_room_id'];
}
//task


if(isset($_POST['task'])){
    $task = $_POST['task'];
}
if(isset($_POST['select_room_id'])){
    $select_room_id = $_POST['select_room_id'];
}
//extra job
if(isset($_POST['clean_extra'])){
    $clean_extra = $_POST['clean_extra'];
}
if(isset($_POST['extra_job'])){
    $extra_job = $_POST['extra_job'];
}
if(isset($_POST['edit_extra_id'])){
    $edit_extra_id = $_POST['edit_extra_id'];
}

$sql ="";
if($from == "floor"){

    if($add_or_edit == "Add"){
        $sql="INSERT INTO `tbl_floors`( `floor_num`, `floor_name`, `floor_name_it`, `floor_name_de`, `hotel_id`, `category_id`, `is_active`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$floor_number','Ground','Ground','Ground','$hotel_id','1','1','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
    }else{
        $sql="UPDATE `tbl_floors` SET `floor_num`='$floor_number',`hotel_id`='$hotel_id',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `floor_id` = $edit_floor_id";
    }

}else if ($from == "category") {
    if($add_or_edit == "Add"){
        $sql=" INSERT INTO `tbl_room_category`( `category_name`, `category_name_it`, `category_name_de`, `hotel_id`, `time_to_CN`, `time_to_CD`, `time_to_FC`,`time_to_EC`, `cleaning_frequency`, `cleaning_day`, `laundry_frequency`, `laundry_day`, `time`, `is_active`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$cat_en','$cat_it','$cat_de','$hotel_id','$time_to_cn','$time_to_cd','$time_to_fc','$time_to_ec','$cleaning','$cleaning_day','$laundry','$laundry_days','','1','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
    }else{
        $sql="UPDATE `tbl_room_category` SET `category_name`='$cat_en',`category_name_it`='$cat_it',`category_name_de`='$cat_de',`time_to_CN`='$time_to_cn',`time_to_CD`='$time_to_cd',`time_to_FC`='$time_to_fc',`time_to_EC`='$time_to_ec', `cleaning_frequency`='$cleaning',`cleaning_day`='$cleaning_day',`laundry_frequency`='$laundry',`laundry_day`='$laundry_days',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`= '$last_editby_ip' WHERE `room_cat_id` = $room_cat_id";
    }  
}else if ($from == "rooms")  {
    if($add_or_edit == "Add"){
        $sql="INSERT INTO `tbl_rooms`( `room_num`, `room_name`, `room_name_it`, `room_name_de`, `floor_id`, `room_cat_id`, `hotel_id`, `is_active`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$room_number','$room_name_en','$room_name_it','$room_name_de','$select_floor_id','$room_cat_id_rooms','$hotel_id','1','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";



    }else{
        $sql="UPDATE `tbl_rooms` SET `room_num`='$room_number',`room_name`='$room_name_en',`room_name_it`='$room_name_it',`room_name_de`='$room_name_de',`floor_id`='$select_floor_id',`room_cat_id`='$room_cat_id_rooms',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `rms_id` = $edit_room_id";
    } 





}else if ($from == "task")  {
    if($add_or_edit == "Add"){
        $sql="INSERT INTO `tbl_housekeeping_task`( `task`, `room id`,`hotel_id`) VALUES ('$task','$select_room_id','$hotel_id')";
    }else{

    } 
}
else if ($from == "extra_job")  {
    if($add_or_edit == "Add"){
        $sql="INSERT INTO `tbl_ housekeeping_extra_jobs`( `time_to_complate`, `job_title`, `hotel_id`) VALUES ('$clean_extra','$extra_job','$hotel_id')";
    }else{        
        $sql="UPDATE `tbl_ housekeeping_extra_jobs` SET `time_to_complate`='$clean_extra',`job_title`='$extra_job' WHERE `hkej_id` = '$edit_extra_id'";
    } 
}
else if ($name_of != "" && $id_of != "")  {
    if($name_of == "floor"){
        $sql="UPDATE `tbl_rooms` SET `floor_id`='$id_of',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `rms_id` = $room_id";
    }else{        
        $sql="UPDATE `tbl_rooms` SET `room_cat_id`='$id_of',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `rms_id` = $room_id";
    } 
}



$result1 = $conn->query($sql);
if($result1){
    if($from == "rooms"){

        if($add_or_edit == "Add"){
            $room_id = $conn->insert_id;
            //add housekeeping
            $sql_housekeeping="INSERT INTO `tbl_housekeeping`( `room_id`, `assign_to`, `assgin_time`, `room_status`, `presence_status`, `cleaning_frequency`, `cleaning_day`, `cleaning_date`, `is_completed`, `is_urgent`, `note`, `note_it`, `note_de`, `hotel_id`, `assgin_date`, `assgin_type`, `last_cleaning_date`, `next_cleaning_date`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$room_id','0','','Unassigned','None','','','','','','','','','$hotel_id','','','','','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
            $result_housekeeping = $conn->query($sql_housekeeping);


            for ($x = 0; $x < sizeof($checklist); $x++) {

                $sql_check="INSERT INTO `tbl_room_check`( `room_id`, `checklist`, `checklist_it`, `checklist_de`, `is_completed`) VALUES ('$room_id','$checklist[$x]','$checklist[$x]','$checklist[$x]',0)";
                $result_check = $conn->query($sql_check);
            }
            for ($x = 0; $x < sizeof($checklist_arrival); $x++) {

                $sql_check="INSERT INTO `tbl_room__arrival_check`( `room_id`, `checklist`, `checklist_it`, `checklist_de`, `is_completed`) VALUES ('$room_id','$checklist_arrival[$x]','$checklist_arrival[$x]','$checklist_arrival[$x]',0)";
                $result_check = $conn->query($sql_check);
            }

        }else {


            $sql_d = "DELETE FROM `tbl_room_check` WHERE `room_id` = $edit_room_id";
            $result_d = $conn->query($sql_d);

            for ($x = 0; $x < sizeof($checklist); $x++) {

                $sql_check="INSERT INTO `tbl_room_check`( `room_id`, `checklist`, `checklist_it`, `checklist_de`, `is_completed`) VALUES ('$edit_room_id','$checklist[$x]','$checklist[$x]','$checklist[$x]',0)";
                $result_check = $conn->query($sql_check);
            }

            $sql_d = "DELETE FROM `tbl_room__arrival_check` WHERE `room_id` = $edit_room_id";
            $result_d = $conn->query($sql_d);

            for ($x = 0; $x < sizeof($checklist_arrival); $x++) {

                $sql_check="INSERT INTO `tbl_room__arrival_check`( `room_id`, `checklist`, `checklist_it`, `checklist_de`, `is_completed`) VALUES ('$edit_room_id','$checklist_arrival[$x]','$checklist_arrival[$x]','$checklist_arrival[$x]',0)";
                $result_check = $conn->query($sql_check);
            }




        }









    }
    echo "done";
}else {
    echo "error";
}
?>