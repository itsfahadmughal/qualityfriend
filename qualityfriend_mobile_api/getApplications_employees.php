<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $status_id="";
    $load = "";
    $application_id = 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["load"])){
        $load = $_POST["load"];
    }

    if(isset($_POST["load"])){
        $load = $_POST["load"];
    }
    if(isset($_POST["application_id"])){
        $application_id = $_POST["application_id"];
    }

    $data = array();
    $temp1=array();
    $sql = "";
    //Working
    if($load == "applicant"){

        if($application_id == 0){

            $sql = "SELECT * FROM `tbl_applicants_employee` WHERE  (`status_id` = 5 OR `status_id` = 6) and is_delete = 0 and  hotel_id = $hotel_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC";  
        }
        else {
            $sql = "SELECT * FROM `tbl_applicants_employee` WHERE is_delete = 0 and  hotel_id = $hotel_id and tae_id = $application_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC"; 
        }


    }
    if($load == "archived_applicant"){
        if($application_id == 0){

            $sql = "SELECT * FROM `tbl_applicants_employee` WHERE `status_id` = 3 and is_delete = 0 and  hotel_id = $hotel_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC";  

        }
        else {
            $sql = "SELECT * FROM `tbl_applicants_employee` WHERE   hotel_id = $hotel_id and tae_id = $application_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC"; 
        }

    }
    if($load == "employee"){

        if($application_id == 0){

            $sql = "SELECT * FROM `tbl_applicants_employee`  WHERE `status_id` = 4 and is_delete= 0 and  hotel_id = $hotel_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC";  

        }
        else {
            $sql = "SELECT * FROM `tbl_applicants_employee` WHERE  hotel_id = $hotel_id and tae_id = $application_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC"; 
        }
    }
    if($load == "retired_employee"){
        if($application_id == 0){
            $sql = "SELECT * FROM `tbl_applicants_employee`  WHERE `status_id` = 7 and is_delete= 0 and  hotel_id = $hotel_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC"; 
        }
        else {
            $sql = "SELECT * FROM `tbl_applicants_employee` WHERE  hotel_id = $hotel_id and tae_id = $application_id ORDER BY `tbl_applicants_employee`.`tae_id` DESC"; 
        }
    }
    if($load == ""){
        $temp1['flag'] = 1;
        $temp1['message'] = "Error!!!";
    }else{


        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $employee_id = $row['tae_id'];
                $temp['tae_id'] = $row['tae_id'];
                $temp['job_id'] = $row['crjb_id'];
                $temp['hotel_id'] = $row['hotel_id'];
                $temp['title'] = $row['title'];
                $temp['name'] = $row['name'];
                $temp['surname'] = $row['surname'];
                $temp['email'] = $row['email'];
                $temp['phone'] = $row['phone'];


                $temp['resume_url'] = $row['resume_url'];
                $temp['image_url'] = $row['image_url'];




                //Hide one 

                if ($application_id != 0 ){

                    $temp['message'] = $row['message'];
                    $temp['dob'] = $row['dob'];
                    $temp['dob_place'] = $row['dob_place'];
                    $temp['tax_number'] = $row['tax_number'];

                    $temp['start_working_time'] = $row['start_working_time'];
                    $temp['end_working_time'] = $row['end_working_time'];

                }
                $temp['application_time'] = $row['application_time'];
                $temp['depart_id_app'] = $row['depart_id_app'];
                $depart_id=$row['depart_id_app'];
                $sql2="SELECT * FROM `tbl_department` WHERE depart_id = $depart_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp['department_name'] = $row2['department_name'];
                        $temp['department_name_it'] = $row2['department_name_it'];
                        $temp['department_name_de'] = $row2['department_name_de'];
                    }
                }

                $temp['depart_id_emp'] = $row['depart_id_emp'];
                $depart_id_emp=$row['depart_id_emp'];
                $sql2="SELECT * FROM `tbl_department` WHERE depart_id = $depart_id_emp";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp['department_name_emp'] = $row2['department_name'];
                        $temp['department_name_emp_it'] = $row2['department_name_it'];
                        $temp['department_name_emp_de'] = $row2['department_name_de'];
                    }
                }
                $temp['status_id'] = $row['status_id'];
                $status_id = $row['status_id'];
                $sql2="SELECT * FROM `tbl_util_status` WHERE status_id = $status_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp['status'] = $row2['status'];
                        $temp['status_it'] = $row2['status_it'];
                        $temp['status_de'] = $row2['status_de'];
                    }
                }

                //Hide one 
                if ($application_id != 0 ){

                    $temp['tags'] = $row['tags'];
                    $temp['comments'] = $row['comments'];
                }
                $creater_id = $row['entrybyid'];
                $creater="";
                $sql_c="SELECT firstname FROM `tbl_user` WHERE user_id = $creater_id";
                $result_c = $conn->query($sql_c);
                if ($result_c && $result_c->num_rows > 0) {
                    while($row_c = mysqli_fetch_array($result_c)) {
                        $creater = $row_c['firstname'];
                    }
                }
                $temp['creater'] = $creater;

                $temp['entrytime'] = $row['entrytime'];
                $temp['entrybyid'] = $row['entrybyid'];
                $temp['entrybyip'] = $row['entrybyip'];
                $temp['edittime'] = $row['edittime'];
                $temp['editbyid'] = $row['editbyid'];
                $temp['editbyip'] = $row['editbyip'];


                if( $row['is_active_user'] == 1){
                    $temp['is_active_user'] = "Yes";
                }else {
                    $temp['is_active_user'] = "No";
                }

                if( $row['is_delete'] == 1){
                    $temp['is_delete'] = "Yes";
                }else {
                    $temp['is_delete'] = "No";
                }









                //Hide one 
                if ($application_id != 0 ){

                    $sql1="SELECT * FROM `tbl_applicants_ratings` WHERE `tae_id` = $employee_id";
                    $result1 = $conn->query($sql1);
                    if ($result1 && $result1->num_rows > 0) {
                        while($row1 = mysqli_fetch_array($result1)) {
                            $SocialCompetence = $row1['social_competence'];
                            $MethodicalCompetence = $row1['methodical_competence'];
                            $PersonalCompetence = $row1['personal_competence'];
                            $ProfractionalCompetence = $row1['professional_competence'];
                            $GeneralCompetence = $row1['general_impression'];


                            $temp['SocialCompetence'] = (string) $SocialCompetence;
                            $temp['MethodicalCompetence'] = (string) $MethodicalCompetence;
                            $temp['PersonalCompetence'] = (string) $PersonalCompetence;
                            $temp['ProfractionalCompetence'] = $ProfractionalCompetence;
                            $temp['GeneralCompetence'] = $GeneralCompetence;


                        }

                    }else{
                        $temp['SocialCompetence'] = (string) "0";
                        $temp['MethodicalCompetence'] = (string) "0";
                        $temp['PersonalCompetence'] = (string) "0";
                        $temp['ProfractionalCompetence'] = (string) "0";
                        $temp['GeneralCompetence'] = (string) "0";
                    }

                }
                $cam_id = 0;
                $cam_id = $row['cam_id'];
                if ($cam_id != 0 ){
                    $sql12="SELECT * FROM `tbl_job_ad_campaign` WHERE `id` = $cam_id";
                    $result12 = $conn->query($sql12);
                    if ($result12 && $result12->num_rows > 0) {
                        while($row12 = mysqli_fetch_array($result12)) {
                            $temp['genreted_url'] = $row12['genreted_url'];
                            $temp['name_is'] = $row12['name'];
                            $temp['sorce'] = $row12['sorce'];
                            $temp['team'] = $row12['team'];

                        }
                    }
                }else {

                    $temp['genreted_url'] = '';
                    $temp['name_is'] = '';
                    $temp['sorce'] = '';
                    $temp['team'] = '';

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
    }
    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>