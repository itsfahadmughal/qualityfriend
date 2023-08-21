<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }

    $data = array();
    $temp1=array();

    //Working   
    $sql = "SELECT * FROM `tbl_usertype` WHERE (`hotel_id` = $hotel_id OR `hotel_id` = 0) and is_delete = '0'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['usert_id'] =   $row['usert_id'];
            $temp['user_type'] =   $row['user_type'];
            $creater_id = $row['entrybyid'];
            $creater="";
            $sql_c="SELECT firstname FROM `tbl_user` WHERE user_id = $creater_id";
            $result_c = $conn->query($sql_c);
            if ($result_c && $result_c->num_rows > 0) {
                while($row_c = mysqli_fetch_array($result_c)) {
                    $creater = $row_c['firstname'];
                }
            }
            $temp['creater'] = $creater;

            $temp['entrytime'] = $row['entrytime'];
            $temp['entrybyid'] = $row['entrybyid'];
            $temp['entrybyip'] = $row['entrybyip'];
            $temp['edittime'] = $row['edittime'];
            $temp['editbyid'] = $row['editbyid'];
            $temp['editbyip'] = $row['editbyip'];

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