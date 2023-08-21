<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = $user_id = 0;
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }

    $pre_date  = date('Y-m-d', strtotime(' -10 day'));
    $sql = "SELECT a.*,b.user_id,concat(b.firstname,' ',b.lastname) as fullname FROM `tbl_shifts` as a INNER JOIN tbl_user as b on a.assign_to = b.user_id WHERE a.is_active = 1 AND a.is_delete = 0 AND a.hotel_id = $hotel_id AND a.assign_to = $user_id AND date > '$pre_date'";


    $data = array();
    $temp1=array();
    if($hotel_id == "" || $hotel_id == 0 || $user_id == 0 || $user_id == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & Dates are Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['shift_id'] =   $row['sfs_id'];
                $shift_id = $row['sfs_id'];
                $temp['title'] =   $row['title'];
                $temp['assign_to_user_id'] =   $row['user_id'];
                $temp['assign_to_user_name'] =   $row['fullname'];
                $temp['date'] =   $row['date'];
                $temp['date_modified'] =   date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time'];
                $temp['day'] =   date('D', strtotime($row['date']));
                $temp['start_time'] =   $row['start_time'];
                $temp['end_time'] = $row['end_time'];

                $time1 = strtotime($row['end_time']);
                $time2 = strtotime($row['start_time']);
                $difference = round(abs($time2 - $time1) / 3600,2);
                $temp['difference'] =   $difference;

                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }

        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }
}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>