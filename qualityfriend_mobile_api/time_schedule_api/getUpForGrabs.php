<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = $user_id = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }

    $sql = "SELECT a.*,b.*,d.date,d.start_time,d.end_time,e.department_name,e.department_name_it,e.department_name_de,c.firstname as name FROM `tbl_shift_offer` as a INNER JOIN tbl_user as b on a.offer_by = b.user_id INNER JOIN tbl_user as c on a.offer_to = c.user_id INNER JOIN tbl_shifts as d on a.shift_offered = d.sfs_id INNER JOIN tbl_department as e on c.depart_id = e.depart_id WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete_user = 0 AND a.offer_to = $user_id";

    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $user_id == "" || $user_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();

                $temp['sftou_id'] =   $row['sftou_id'];

                $temp['shift_being_offered_image'] =   $row['address'];
                $temp['shift_being_offered_name'] =   $row['firstname'];

                $temp['shift_offered_id'] =   $row['shift_offered'];

                $temp['offering_to_user_id'] =   $row['offer_to'];
                $temp['offering_to_name'] =   $row['name'];
                $temp['title'] =   $row['title'];

                $temp['time'] =   date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time'];
                $temp['department_name'] =   $row['department_name'];
                $temp['department_name_it'] =   $row['department_name_it'];
                $temp['department_name_de'] =   $row['department_name_de'];
                $temp['is_approved_by_employee'] =   $row['is_approved_by_employee'];
                $temp['is_approved_by_admin'] =   $row['is_approved_by_admin'];


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