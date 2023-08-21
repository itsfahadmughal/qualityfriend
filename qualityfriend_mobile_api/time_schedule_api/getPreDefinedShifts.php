<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }

    $sql = "SELECT a.*,b.department_name FROM `tbl_shifts_pre_defined` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.hotel_id = $hotel_id AND a.is_delete = 0 ORDER BY b.depart_id ASC";

    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "All Parameters Are Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['pre_shift_id'] =   $row['sfspd_id'];

                $temp['shift_name'] =   $row['shift_name'];
                $temp['shift_message'] =   $row['title'];

                $temp['start_time'] =   $row['start_time'];
                $temp['end_time'] =   $row['end_time'];
                $temp['shift_break'] =   $row['shift_break'];
                $temp['total_hours'] =   $row['total_hours'];

                $temp['depart_id'] =   $row['depart_id'];
                $temp['department_name'] =   $row['department_name'];

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