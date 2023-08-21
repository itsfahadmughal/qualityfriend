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

    $sql = "SELECT a.*,b.*,d.date,d.start_time,d.end_time,x.date as dd,x.start_time as ss,x.end_time as ee,c.firstname as name FROM `tbl_shift_trade` as a INNER JOIN tbl_user as b on a.offer_by = b.user_id INNER JOIN tbl_user as c on a.offer_to = c.user_id INNER JOIN tbl_shifts as d on a.shift_offered = d.sfs_id INNER JOIN tbl_shifts as x on a.shift_to = x.sfs_id WHERE a.hotel_id = $hotel_id AND a.is_active = 1 AND a.is_delete_user = 0 AND a.offer_to = $user_id";

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


                $temp['sfttrd_id'] =   $row['sfttrd_id'];

                $temp['shift_being_offered_image'] =   $row['address'];
                $temp['shift_being_offered_name'] =   $row['firstname'];


                $temp['shift_offered'] =   date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time'];
                $temp['shift_offered_to_name'] =   $row['name'];
                $temp['offer_message'] =   $row['title'];
                $temp['offered_with'] =   date("D, M d, Y", strtotime($row['dd'])).' '.$row['ss'].' - '.$row['ee'];


                $temp['shift_offered_id'] =   $row['shift_offered'];
                $temp['shift_offer_by_id'] =   $row['offer_by'];
                $temp['shift_offer_to_id'] =   $row['offer_to'];
                $temp['shift_to_id'] =   $row['shift_to'];

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