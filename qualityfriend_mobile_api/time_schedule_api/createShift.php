<?php 
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{

    $from_time = "";
    $to_time = "";
    $msg = "";
    $hourDiff = "";
    $c_check = 0;
    $bd_check = 0;
    $dates = "";
    $break_mints = 0;
    $repeat_until = "";
    $repeat_count = 0;
    $assign_to = "";

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
    if(isset($_POST['total_hours'])){
        $hourDiff = $_POST['total_hours'];
    }
    if(isset($_POST['break_mints'])){
        $break_mints = $_POST['break_mints'];
    }
    if(isset($_POST['assign_to'])){
        $assign_to = $_POST['assign_to'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }
    if(isset($_POST['repeat_until'])){
        $repeat_until = $_POST['repeat_until'];
    }

    $data = array();
    $temp1=array();
    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $last_id = 0;

    $split = explode(",",$dates);

    usort($split, function($a, $b) {
        $dateTimestamp1 = strtotime($a);
        $dateTimestamp2 = strtotime($b);

        return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
    });


    $d1 = new DateTime($split[0]);
    $d2 = new DateTime($repeat_until);
    $interval = $d1->diff($d2);
    $diffInDays    = $interval->d;

    $repeat_count = ceil($diffInDays/7);

    if($hotel_id == "" || $hotel_id == 0 || $assign_to == 0 || $assign_to == "" || $user_id == 0 || $user_id == "" || $from_time == ""|| $to_time == "" || $hourDiff == "" || $hourDiff == 0 || $dates == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Pass Required Parameters.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

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

            $temp1['flag'] = 1;
            $temp1['message'] = "Shift Created Successful.";
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$msg Shift Created','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Shift Not Created!";
        }

        echo json_encode(array('Status' => $temp1,'Data' => $data));

    }

}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>