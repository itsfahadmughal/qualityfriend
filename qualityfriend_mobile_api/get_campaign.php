<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $saved_status="";
    $job_id_is =  0 ;
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }



    $data = array();
    $temp1=array();

    //Working



    $sql = "SELECT * FROM `tbl_job_ad_campaign` WHERE `hotel_id` =  $hotel_id AND `is_delete` =  0  ORDER BY `id` DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            
            $id_is = $row['id'];
            $temp['id'] =  $row['id'];
            $sql_count_users = "SELECT count(*) as total from tbl_job_ad_campaign_count where `campaign_id` =  $id_is";
            $result_count_users = $conn->query($sql_count_users);
            $row_count_users=mysqli_fetch_array($result_count_users);
            $count = $row_count_users['total'];
            $temp['visitor'] =   $count;
            $temp['name'] =   $row['name'];;
            $temp['sorce'] =   $row['sorce'];
            $temp['team'] =  $row['team'];
            $temp['genreted_url'] =  $row['genreted_url'].'&id='.$row['id'];


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