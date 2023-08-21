<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $to_date = $from_date = "";
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["from_date"])){
        $from_date = $_POST["from_date"];
    }
    if(isset($_POST["to_date"])){
        $to_date = $_POST["to_date"];
    }

    $sql = "SELECT * FROM `tbl_shift_events` WHERE (`date` between '$from_date' AND '$to_date') AND is_active = 1 AND is_delete = 0 AND hotel_id = $hotel_id";

    $data = array();
    $temp1=array();
    if($hotel_id == "" || $hotel_id == 0 || $from_date == "" || $to_date == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & Dates are Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['event_id'] =   $row['svnts_id'];
                $temp['title'] =   $row['title'];
                $temp['description'] =   $row['description'];
                $temp['date'] =   $row['date'];
                $temp['start_time'] =   $row['start_time'];
                $temp['end_time'] = $row['end_time'];
                $temp['total_hours'] =   $row['total_hours'];
                $temp['hotel_id'] = $row['hotel_id'];
                $temp['entrytime'] = $row['entrytime'];
                $temp['edittime'] = $row['edittime'];

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