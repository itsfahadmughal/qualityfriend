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

    $sql = "SELECT * FROM `tbl_room_category` WHERE hotel_id = $hotel_id AND `is_active` = 1 AND `is_delete` = 0  ORDER BY `tbl_room_category`.`room_cat_id` ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['room_cat_id'] =   $row['room_cat_id'];
            $temp['category_name'] =   $row['category_name'];
            $temp['category_name_it'] =   $row['category_name_it'];
            $temp['category_name_de'] =   $row['category_name_de'];
            $temp['hotel_id'] =   $row['hotel_id'];
            $temp['time_to_CN'] =   $row['time_to_CN'];
            $temp['time_to_CD'] = $row['time_to_CD'];
            $temp['time_to_FC'] = $row['time_to_FC'];
            $temp['time_to_EC'] = $row['time_to_EC'];
            $temp['cleaning_frequency'] = $row['cleaning_frequency'];
            $temp['cleaning_day'] = $row['cleaning_day'];



            $temp['laundry_frequency'] =   $row['laundry_frequency'];
            $temp['laundry_day'] =   $row['laundry_day'];
            $temp['time'] = $row['time'];
            $temp['entrytime'] = $row['entrytime'];
            $temp['is_active'] = $row['is_active'];


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