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
    $sql = "SELECT * FROM `tbl_hotel` WHERE hotel_id = $hotel_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();
            $temp['data_protection']            =   $row['data_protection'];
            $temp['data_protection_it']         =   $row['data_protection_it'];
            $temp['data_protection_de']         =   $row['data_protection_de'];
            $temp['privacy_policy']             =   $row['privacy_policy'];
            $temp['privacy_policy_it']          =   $row['privacy_policy_it'];
            $temp['privacy_policy_de']          =   $row['privacy_policy_de'];
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