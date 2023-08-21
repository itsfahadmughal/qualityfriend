<?php 
include 'util_config.php';
include '../util_session.php';

$from_time = "";
$to_time = "";
$msg = "";
$hourDiff = "";
$c_check = "";
$bd_check = "";
$repeat_until = "";
$repeat_count = 0;
$break_mints = 0;
$dates = "";
$assign_to = "";

$entryby_id=$user_id;
$entryby_ip=getIPAddress();
$entry_time=date("Y-m-d H:i:s");
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");

if(isset($_POST['dates'])){
    $dates = $_POST['dates'];
}
if(isset($_POST['start_time'])){
    $from_time = $_POST['start_time'];
}
if(isset($_POST['end_time'])){
    $to_time = $_POST['end_time'];
}
if(isset($_POST['message'])){
    $msg = $_POST['message'];
}
if(isset($_POST['repeat_until'])){
    $repeat_until = $_POST['repeat_until'];
}
if(isset($_POST['break_mints'])){
    $break_mints = $_POST['break_mints'];
}
if(isset($_POST['total_hours'])){
    $hourDiff = $_POST['total_hours'];
}
if(isset($_POST['till_closing'])){
    $c_check = $_POST['till_closing'];
}
if(isset($_POST['till_business_decline'])){
    $bd_check = $_POST['till_business_decline'];
}
if(isset($_POST['assign_to'])){
    $assign_to = $_POST['assign_to'];
}

$split = explode(",",$dates);
$last_id = 0;

usort($split, function($a, $b) {
    $dateTimestamp1 = strtotime($a);
    $dateTimestamp2 = strtotime($b);

    return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
});


$d1 = new DateTime($split[0]);
$d2 = new DateTime($repeat_until);
$interval = $d1->diff($d2);
$diffInDays    = $interval->format("%a");

$repeat_count = ceil($diffInDays/7);


for($k=0;$k<=$repeat_count;$k++){

    for($i=0;$i<sizeof($split);$i++){

        if($k >= 1){
            $str = ' + '.(7*($k)).' days';
            $new_date = date('Y-m-d', strtotime($split[$i]. $str)); 
        }else{
            $new_date = $split[$i];
            $last_id = mysqli_insert_id($conn);
        }

        if ($repeat_until > $new_date || $repeat_until == "" ){
            $sql="INSERT INTO `tbl_shifts`(`date`, `assign_to`, `title`, `title_it`, `title_de`, `start_time`, `end_time`, `total_hours`, `till_closing`, `till_business_decline`, `is_active`, `is_delete`, `hotel_id`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`, `shift_break`) VALUES ('$new_date','$assign_to','$msg','','','$from_time','$to_time','$hourDiff','$c_check','$bd_check','1','0','$hotel_id','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip','$break_mints')";

            $result = $conn->query($sql);
        }else{
            break;
        }
    }

}

if($result){

    echo '1';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$msg Shift Created','$hotel_id','$entry_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo '0';
}






?>