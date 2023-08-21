<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }



    $data = array();
    $temp1=array();

    //Working

    $sql = "SELECT * FROM `tbl_floors` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0 ORDER BY `tbl_floors`.`floor_num` ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['floor_id'] =   $row['floor_id'];
            $temp['floor_num'] =   $row['floor_num'];
            $temp['floor_name'] =   $row['floor_name'];
            $temp['floor_name_it'] =   $row['floor_name_it'];
            $temp['floor_name_de'] =   $row['floor_name_de'];
            $temp['is_active'] =   $row['is_active'];
            
            $temp['entrytime'] = $row['entrytime'];
            $temp['entrybyid'] = $row['entrybyid'];
            $temp['entrybyip'] = $row['entrybyip'];

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>