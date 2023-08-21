<?php
if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    // Declaration

    $hotel_id = 0;
    $departments = "";
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["departments_comma_separated"])){
        $departments = $_POST["departments_comma_separated"];
    }

    if($departments == "" || $departments == 0 || $departments == null){
        $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 AND a.enable_for_schedules = 1 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 ORDER BY b.department_name ASC";  
    }else{
        $sql = "SELECT a.*, b.*, c.user_type FROM `tbl_user` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id INNER JOIN tbl_usertype as c on a.usert_id = c.usert_id WHERE a.hotel_id = $hotel_id and a.is_delete = 0 AND a.enable_for_schedules = 1 and a.is_active = 1 and a.depart_id != 0 and b.is_active = 1 and b.is_delete = 0 AND b.depart_id IN ($departments) ORDER BY b.department_name ASC";
    }

    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{
        $circle_font_color = ['#8dc3b9','#f3a097','#e1f3ef','#f7faf2','#9ea9d3','#f4f6fc','#a98146','#bbca94','#fbebe6','#aa6589','#f2dcbd','#f4f6fc','#9ea9d3','#f7faf2','#aa6589'];
        $circle_color = ['#e1f3ef','#fbebe6','#8dc3b9','#bbca94','#f4f6fc','#aa6589','#f2dcbd','#f7faf2','#f3a097','#ead3e3','#a98146','#9ea9d3','#f4f6fc','#a9814d','#f4f6fc'];

        //Working
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $random = mt_rand(0,14);
                $temp['fullname'] =   $row['firstname'].' '.$row['lastname'];
                $temp['first_letter_color'] =   $circle_font_color[$random];
                $temp['first_letter'] =  ucfirst(substr($temp['fullname'], 0, 1));
                $temp['letter_circle_color'] =   $circle_color[$random];
                $temp['user_id'] =   $row['user_id'];
                $temp['usertype'] =   $row['user_type'];
                $temp['department_id'] = $row['depart_id'];
                $temp['department_name'] = $row['department_name'];
                $temp['department_name_it'] = $row['department_name_it'];
                $temp['department_name_de'] = $row['department_name_de'];

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