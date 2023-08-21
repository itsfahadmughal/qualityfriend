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

    $sql = "SELECT * FROM `tbl_qualityfriend_modules` WHERE hotel_id_qf = $hotel_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            if( $row['recruiting'] == 1){
                $temp['recruiting'] = "Enable";
            }else {
                $temp['recruiting'] = "Disable";
            }
            if( $row['handover'] == 1){
                $temp['handover'] = "Enable";
            }else {
                $temp['handover'] = "Disable";
            }
            if( $row['handbook'] == 1){
                $temp['handbook'] = "Enable";
            }else {
                $temp['handbook'] = "Disable";
            }
            if( $row['checklist'] == 1){
                $temp['checklist'] = "Enable";
            }else {
                $temp['checklist'] = "Disable";
            }
            if( $row['notices'] == 1){
                $temp['notices'] = "Enable";
            }else {
                $temp['notices'] = "Disable";
            }
            if( $row['repairs'] == 1){
                $temp['repairs'] = "Enable";
            }else {
                $temp['repairs'] = "Disable";
            }
            if( $row['housekeeping'] == 1){
                $temp['housekeeping'] = "Enable";
            }else {
                $temp['housekeeping'] = "Disable";
            }
            if( $row['time_schedule'] == 1){
                $temp['time_schedule'] = "Enable";
            }else {
                $temp['time_schedule'] = "Disable";
            }
            if( $row['chat'] == 1){
                $temp['chat'] = "Enable";
            }else {
                $temp['chat'] = "Disable";
            }



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