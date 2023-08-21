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

    $sql = "SELECT * FROM `tbl_hotel_welcome_note` WHERE hotel_id = $hotel_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['hwn_id'] = $row['hwn_id'];
            $temp['hotel_id'] = $row['hotel_id'];

            $temp['monday_text'] = $row['monday_text'];
            $temp['monday_text_it'] = $row['monday_text_it'];
            $temp['monday_text_de'] = $row['monday_text_de'];

            $temp['tuesday_text'] = $row['tuesday_text'];
            $temp['tuesday_text_it'] = $row['tuesday_text_it'];
            $temp['tuesday_text_de'] = $row['tuesday_text_de'];

            $temp['wednesday_text'] = $row['wednesday_text'];
            $temp['wednesday_text_it'] = $row['wednesday_text_it'];
            $temp['wednesday_text_de'] = $row['wednesday_text_de'];

            $temp['thursday_text'] = $row['thursday_text'];
            $temp['thursday_text_it'] = $row['thursday_text_it'];
            $temp['thursday_text_de'] = $row['thursday_text_de'];

            $temp['friday_text'] = $row['friday_text'];
            $temp['friday_text_it'] = $row['friday_text_it'];
            $temp['friday_text_de'] = $row['friday_text_de'];

            $temp['saturday_text'] = $row['saturday_text'];
            $temp['saturday_text_it'] = $row['saturday_text_it'];
            $temp['saturday_text_de'] = $row['saturday_text_de'];
            
            $temp['sunday_text'] = $row['sunday_text'];
            $temp['sunday_text_it'] = $row['sunday_text_it'];
            $temp['sunday_text_de'] = $row['sunday_text_de'];

            $temp['editbytime'] = $row['editbytime'];
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