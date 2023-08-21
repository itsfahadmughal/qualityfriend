<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = $user_id = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }

    if($user_id == "" || $user_id == 0){
        $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as request_by_name,b.address as image FROM `tbl_time_off` as a INNER JOIN tbl_user as b ON a.request_by = b.user_id WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category != 'HOLIDAY' ORDER BY 1 DESC";
    }else{
        $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as request_by_name,b.address as image FROM `tbl_time_off` as a INNER JOIN tbl_user as b ON a.request_by = b.user_id WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete = 0 AND a.category != 'HOLIDAY' AND request_by = $user_id ORDER BY 1 DESC";
    }

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

                $temp['tmeo_id'] =   $row['tmeo_id'];
                $temp['title'] =   $row['title'];
                $temp['category'] =   $row['category'];
                $temp['duration'] =   $row['duration'];
                $temp['date'] =   $row['date'];
                $temp['total_hours'] =   $row['total_hours'];
                $temp['status'] =   $row['status'];
                $temp['request_by_id'] =   $row['request_by'];
                $temp['request_by_name'] =   $row['request_by_name'];
                $temp['request_by_profile'] =   $row['image'];
                $temp['entrytime'] =   $row['entrytime'];
                $temp['edittime'] =   $row['edittime'];

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