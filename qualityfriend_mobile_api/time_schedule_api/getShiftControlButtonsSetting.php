<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = $user_id = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["employee_id"])){
        $user_id = $_POST["employee_id"];
    }

    $sql = "SELECT * FROM `tbl_shift_button_visiblity` WHERE hotel_id = $hotel_id AND employee_id = $user_id";

    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $user_id == 0 || $user_id == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "All Parameters Are Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['sbvy_id'] =   $row['sbvy_id'];

                $temp['employee_id'] =   $row['employee_id'];
                $temp['hotel_id'] =   $row['hotel_id'];
                $temp['visible_type'] =   $row['visible_type'];
                $temp['editbyid'] =   $row['editbyid'];
                $temp['edittime'] =   $row['edittime'];
                $temp['editbyip'] =   $row['editbyip'];

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