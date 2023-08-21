<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $housekeeping = 0;
    $usert_id = 0;
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["usert_id"])){
        $usert_id = $_POST["usert_id"];
    }
    if(isset($_POST["housekeeping"])){
        $housekeeping = $_POST["housekeeping"];
    }
    if(isset($_POST["housekeeping_admin"])){
        $housekeeping_admin = $_POST["housekeeping_admin"];
    }


    $data = array();
    $temp1=array();

    //Working

    if($housekeeping_admin == 1 || $usert_id == 1){
        $sql="SELECT b.hkej_id,b.job_title,c.time,a.assign_date,a.complete_date,a.assign_to,a.is_completed FROM `tbl_ housekeeping_extra_jobs_completed_check` AS a INNER JOIN `tbl_ housekeeping_extra_jobs` as b ON a.`extra_job_id` = b.hkej_id INNER JOIN `tb_time_interval` as c ON b.time_to_complate = c.ti_id WHERE a.`is_completed` = 1 AND b.hotel_id = $hotel_id ORDER BY a.`complete_date`";
    } else{
        $sql="SELECT b.hkej_id,b.job_title,c.time,a.assign_date,a.complete_date,a.assign_to,a.is_completed FROM `tbl_ housekeeping_extra_jobs_completed_check` AS a INNER JOIN `tbl_ housekeeping_extra_jobs` as b ON a.`extra_job_id` = b.hkej_id INNER JOIN `tb_time_interval` as c ON b.time_to_complate = c.ti_id WHERE a.`is_completed` = 1 AND a.`assign_to` = $user_id And b.hotel_id = $hotel_id ORDER BY a.`complete_date`";
    }
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();


            $hkej_id =$row['hkej_id'];
            $job_title =$row['job_title'];
            $is_completed =$row['is_completed'];
            $assgin_date =$row['assign_date'];
            $complate_date =$row['complete_date'];
            $time =$row['time'];
            $user_id_this = $row['assign_to'];
            $sql_sub="select firstname from tbl_user where user_id = $user_id_this";
            $result_sub = $conn->query($sql_sub);
            $row_sub = mysqli_fetch_array($result_sub);
            $name = $row_sub['firstname'];


            $temp['hkej_id'] =    $hkej_id;
            $temp['job_title'] =   $job_title;
            $temp['is_completed'] =   $is_completed;
            $temp['assgin_date'] =    $assgin_date;
            $temp['complate_date'] =   $complate_date;
            $temp['time'] =   $time;
            $temp['name'] =   $name;


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