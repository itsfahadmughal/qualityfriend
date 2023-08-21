<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $housekeeping = 0;
    $usert_id = 0;
    $cleaner_id = 0;
    $filter_date = "";
    $room_id = 0;
    $room_number = $cleaner_id = $extra_job_id= $floor_id = $room_id =0;
    $checklist ="" ;
    $checklist_arrival ="" ;
    $edit_room_id = 0;

    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }

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

    if(isset($_POST['checklist'])){
        $checklist = $_POST['checklist'];
    }
    if($checklist != "" ){
        $str = "$checklist";
        $checklist = (explode(",",$str));

    }else{
        $checklist = array(); 
    }

    if(isset($_POST['checklist_arrival'])){
        $checklist_arrival = $_POST['checklist_arrival'];
    }
    if($checklist_arrival != "" ){
        $str = "$checklist_arrival";
        $checklist_arrival = (explode(",",$str));

    }else{
        $checklist_arrival = array(); 
    }


    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entryby_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $current_date=date("Y-m-d");

    $data = array();
    $temp1=array();
    //Working   

    if($edit_room_id == 0 )   { 
        $sql="INSERT INTO `tbl_rooms`( `room_num`, `room_name`, `room_name_it`, `room_name_de`, `floor_id`, `room_cat_id`, `hotel_id`, `is_active`, `entrytime`, `entrybyid`, `entrybyip`, `lastedittime`, `lasteditbyid`, `lasteditbyip`) VALUES ('$room_number','$room_name_en','$room_name_it','$room_name_de','$select_floor_id','$room_cat_id_rooms','$hotel_id','1','$entryby_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
    }else{
        $sql="UPDATE `tbl_rooms` SET `room_num`='$room_number',`room_name`='$room_name_en',`room_name_it`='$room_name_it',`room_name_de`='$room_name_de',`floor_id`='$select_floor_id',`room_cat_id`='$room_cat_id_rooms',`lastedittime`='$last_edit_time',`lasteditbyid`='$last_editby_id',`lasteditbyip`='$last_editby_ip' WHERE `rms_id` = $edit_room_id";
    } 

    $result1 = $conn->query($sql);
    if($result1){

        if($edit_room_id == 0){
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
        $temp1['flag'] = 1;
        $temp1['message'] = "Successfull";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Error!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>