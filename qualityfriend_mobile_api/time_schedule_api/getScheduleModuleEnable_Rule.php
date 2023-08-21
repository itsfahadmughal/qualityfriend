<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $module_type = "";
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }

    $sql = "SELECT * FROM `tbl_time_schedule_rules` WHERE `hotel_id` = $hotel_id";


    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['tsrs_id'] =   $row['tsrs_id'];
                $temp['is_shift_pool_enable'] =   $row['is_shift_pool_enable'];
                $temp['is_time_off_enable'] =   $row['is_time_off_enable'];
                $temp['hotel_id'] =   $row['hotel_id'];
                $temp['edittime'] =   $row['edittime'];
                $temp['editbyid'] =   $row['editbyid'];
                $temp['editbyip'] =   $row['editbyip'];

                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successful";
            }
        } else {
            $temp = array();

            $temp['tsrs_id'] =   0;
            $temp['is_shift_pool_enable'] =   1;
            $temp['is_time_off_enable'] =   1;
            $temp['hotel_id'] =   $hotel_id;
            $temp['edittime'] =   "";
            $temp['editbyid'] =   0;
            $temp['editbyip'] =   "";

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";
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