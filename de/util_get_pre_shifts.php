<?php 
include 'util_config.php';
include '../util_session.php';

$id = 0;

if(isset($_POST['pre_id'])){
    $id = $_POST['pre_id'];
}

$title = "";
$start_time = "";
$end_time = "";
$shift_break = "";
$total_hours = "";


if($id != 0){

    $sql_up_for = "SELECT * FROM `tbl_shifts_pre_defined` WHERE `hotel_id` = $hotel_id  and `is_delete` = 0 and `sfspd_id` = $id";

    $result_up_for = $conn->query($sql_up_for);
    if ($result_up_for && $result_up_for->num_rows > 0) {
        while ($row = mysqli_fetch_array($result_up_for)) {
            $title = $row['title'];
            $start_time = $row['start_time'];
            $end_time = $row['end_time'];
            $shift_break = $row['shift_break'];
            $total_hours = $row['total_hours'];
            
            echo $title.','.$start_time.','.$end_time.','.$shift_break.','.$total_hours;
        }
    }

}

?>