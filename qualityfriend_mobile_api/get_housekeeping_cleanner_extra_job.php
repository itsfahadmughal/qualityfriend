<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $housekeeping = 0;
    $usert_id = 0;
    $cleaner_id = 0;
    $filter_date = "";
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
    if(isset($_POST["cleaner_id"])){
        $cleaner_id = $_POST["cleaner_id"];
    }
    if(isset($_POST['filter_date'])){
        $filter_date=$_POST['filter_date'];
    }
    if($filter_date == ""){
        $filter_date = date("Y-m-d");
    }else{
        $filter_date = new DateTime($filter_date);
        $filter_date = date_format($filter_date,"Y-m-d");
    }
    $data = array();
    $temp1=array();
    //Working   
    $current_date = date("Y-m-d");
    $sql="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $hkej_id       = $row["hkej_id"];



            $sql12="SELECT * FROM `tbl_ housekeeping_extra_jobs_completed_check` WHERE `extra_job_id` =  $hkej_id AND assign_date = '$filter_date' AND `assign_to` = '$cleaner_id'";
            $result12 = $conn->query($sql12);
            $ii = 0;
            $j = 0 ;
            $assign_user_id = 0;
            $is_completed = 0;
            if ($result12 && $result12->num_rows > 0) {
                while($row12 = mysqli_fetch_array($result12)) {

                    $is_completed         = $row12["is_completed"];
                    $assign_user_id         = $row12["assign_to"];
                }}
            $time_to_complate       = $row["time_to_complate"];
            $job_title       = $row["job_title"]; 



            $assigned_jobs_bacground = "";

            if($cleaner_id != 0 ){

                if($assign_user_id == $cleaner_id){
                    $is_assigned = 1;
                    $assigned_jobs_bacground = "assign_background_blue";

                }else if($assign_user_id == 0) {
                    $assigned_jobs_bacground = "";

                }else{
                    $assigned_jobs_bacground = "assign_background_lite_blue";


                }
            }
            $temp['hkej_id'] =   $hkej_id;
            $temp['time_to_complate'] =   $time_to_complate;
            $temp['job_title'] =   $job_title;
            $temp['assign_user_id'] =   $assign_user_id;
            $temp['is_completed'] =   $is_completed;
            $temp['assigned_jobs_bacground'] =   $assigned_jobs_bacground;


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