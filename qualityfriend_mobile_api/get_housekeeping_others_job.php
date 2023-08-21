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

    $data = array();
    $temp1=array();

    //Working


    $show_other = 0 ;
    $sql_task="SELECT * FROM `tbl_housekeeping_user_rule` WHERE `hotel_id` = $hotel_id";
    $result_task = $conn->query($sql_task);
    if ($result_task && $result_task->num_rows > 0) {
        while($row_task = mysqli_fetch_array($result_task)) {
            $show_other = $row_task['show_other'];

        } 

    }

    if( $show_other == 1){

        $sql="SELECT * FROM `tbl_user`  WHERE  is_delete= 0 and  hotel_id = $hotel_id and user_id != $user_id  ORDER BY `tbl_user`.`user_id` DESC";

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $extra_completed = 0;
                $image_url =   $row['address'];
                $user_id_a =   $row['user_id'];
                $firstname =   $row['firstname'];
                $lastname =   $row['lastname'];
                $email = $row['email'];
                $tag = $row['tag'];
                $depart_id = $row['depart_id'];
                $state = $row['state'];
                $usert_id_ = $row['usert_id'];
                $is_active = $row['is_active'];
                $current_date =   date("Y-m-d");
                if( $is_active == 1){
                    $active = "Active";
                }else {
                    $active = "Deactive";
                }
                $user_type = "";
                $depart_name = "";
                $sql2="SELECT * FROM `tbl_usertype` WHERE (`hotel_id` =  $hotel_id and usert_id = $usert_id_ and is_delete = 0) OR `hotel_id` =  0";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $user_type = $row2['user_type'];
                    }
                }
                $housekeeping_assign = 0;
                $user_type_id = $row['usert_id'];
                $sql12="SELECT * FROM `tbl_rules`  WHERE `usert_id` = $user_type_id";
                $result12 = $conn->query($sql12);
                if ($result12 && $result12->num_rows > 0) {
                    while($row12 = mysqli_fetch_array($result12)) {
                        $housekeeping_assign =$row12['rule_13'];
                    } 
                }
                if($housekeeping_assign == 1 && $usert_id_ != 1 ){

                    $extra_job_detail =  array();

                    $sql_20="SELECT * FROM `tbl_ housekeeping_extra_jobs` WHERE `hotel_id` = $hotel_id AND `is_delete` = 0";
                    $result_20 = $conn->query($sql_20);
                    $i = 0;
                    if ($result_20 && $result_20->num_rows > 0) {






                        while($row20 = mysqli_fetch_array($result_20)) { 


                            $hkej_id                = $row20["hkej_id"];
                            $time_to_complate       = $row20["time_to_complate"];
                            $job_title              = $row20["job_title"];
                            $is_completed = 0;
                            $sql12="SELECT * FROM `tbl_ housekeeping_extra_jobs_completed_check` WHERE `assign_to` =  $user_id_a AND assign_date = '$current_date' AND extra_job_id = $hkej_id";
                            $result12 = $conn->query($sql12);
                            if ($result12 && $result12->num_rows > 0) {
                                while($row12 = mysqli_fetch_array($result12)) {
                                    $is_id                = $row12["id"];
                                    $is_completed         = $row12["is_completed"];
                                    $assgin_date          = $row20["assgin_date"]; 
                                    $complate_date        = $row20["complate_date"];




                                }}else{
                                continue;
                            }

                            $temp_2 = array();

                            $temp_2['is_completed'] = $is_completed;
                            $temp_2['job_title'] = $job_title;


                            array_push($extra_job_detail, $temp_2);



                        }
                    }





                    $temp['firstname'] =   $firstname;


                    $temp['extra_job_detail'] =   $extra_job_detail;


                    array_push($data, $temp);
                    unset($temp);
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successfull";

                }






            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }



    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Show None";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>