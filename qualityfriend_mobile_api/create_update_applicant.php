<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $mrtitle="";
    $mrtitle="";
    $first_name="";
    $last_name="";
    $email="";
    $phone="";
    $department_id="";
    $job_id="";
    $application_time =date("Y-m-d H:i:s");
    $img_url= "";
    $cv_url= "";
    $sql="";
    $hotel_id = 0;
    $user_id = 0;
    $saved_status = "";
    $load = "";
    $status_id = 0;
    $is_active_user = 2;
    $is_delete = 0;
    $log = "";
    $id = 0;

    // more options
    $message = "";
    $dob = "";
    $dob_place ="";
    $tax_number ="";
    $start_working_time ="";
    $end_working_time ="";
    $tags = "";
    $comments = "";
    //arrays
    $data = array();
    $temp1=array();

    //
    $SocialCompetence = "";
    $MethodicalCompetence = "";
    $PersonalCompetence = "";
    $ProfractionalCompetencee = "";
    $GeneralCompetence = "";




    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['mrtitle'])){
        $mrtitle=$_POST['mrtitle'];
    }
    if(isset($_POST['first_name'])){
        $first_name=str_replace("'","`",$_POST['first_name']);
    }
    if(isset($_POST['last_name'])){
        $last_name=str_replace("'","`",$_POST['last_name']);
    }
    if(isset($_POST['email'])){
        $email=$_POST['email'];
    }
    if(isset($_POST['phone'])){
        $phone=$_POST['phone'];
    }
    if(isset($_POST['department_id'])){
        $department_id=$_POST['department_id'];
    }
    if(isset($_POST['job_id'])){
        $job_id=$_POST['job_id'];
    }
    if(isset($_POST['img_url'])){
        $img_url=$_POST['img_url'];
    }
    if(isset($_POST['cv_url'])){
        $cv_url=$_POST['cv_url'];
    }

    $cv_url =      str_replace("'","-",$cv_url);

    if(isset($_POST['saved_status'])){
        $saved_status=$_POST['saved_status'];
    }
    if(isset($_POST['load'])){
        $load=$_POST['load'];
    }
    if(isset($_POST['status_id'])){
        $status_id=$_POST['status_id'];
    }
    //more
    if(isset($_POST['message'])){
        $message=$_POST['message'];
    }
    if(isset($_POST['tags'])){
        $tags=$_POST['tags'];
    }
    if(isset($_POST['comments'])){
        $comments=$_POST['comments'];
    }

    if(isset($_POST['dob'])){
        $dob=$_POST['dob'];
    }
    if(isset($_POST['dob_place'])){
        $dob_place=$_POST['dob_place'];
    }
    if(isset($_POST['tax_number'])){
        $tax_number = $_POST['tax_number'];
    }
    if(isset($_POST['start_working'])){
        $start_working_time = $_POST['start_working'];
    }
    //For Star
    if(isset($_POST['SocialCompetence'])){
        $SocialCompetence = $_POST['SocialCompetence'];
    }
    if(isset($_POST['MethodicalCompetence'])){
        $MethodicalCompetence = $_POST['MethodicalCompetence'];
    }
    if(isset($_POST['PersonalCompetence'])){
        $PersonalCompetence = $_POST['PersonalCompetence'];
    }
    if(isset($_POST['ProfractionalCompetence'])){
        $ProfractionalCompetencee = $_POST['ProfractionalCompetence'];
    }
    if(isset($_POST['GeneralCompetence'])){
        $GeneralCompetence = $_POST['GeneralCompetence'];
    }



    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }

    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{

        if($saved_status=='CREATE'){
            $sql="INSERT INTO `tbl_applicants_employee`( `hotel_id`,`crjb_id`, `title`, `name`, `surname`, `email`, `phone`, `resume_url`, `image_url`, `message`, `depart_id_app`, `depart_id_emp`, `dob`, `dob_place`, `tax_number`, `application_time`, `start_working_time`, `end_working_time`, `status_id`, `is_active_user`, `is_delete`, `tags`, `comments`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$hotel_id','$job_id','$mrtitle','$first_name','$last_name','$email','$phone','$cv_url','$img_url','$message','$department_id','$department_id','$dob','$dob_place','$tax_number','$application_time','$start_working_time','$end_working_time','$status_id','$is_active_user','$is_delete','$tags','$comments','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
        }else{
            if($load == "employee"){
                $sql="UPDATE `tbl_applicants_employee` SET `tags`='$tags',`comments`='$comments',`title`='$mrtitle',`name`='$first_name',`surname`='$last_name',`email`='$email',`phone`='$phone',`resume_url`='$cv_url',`image_url`='$img_url',`message`='$message',`depart_id_emp`='$department_id',`dob`='$dob',`dob_place`='$dob_place',`tax_number`='$tax_number' ,`start_working_time` = '$start_working_time' WHERE `tae_id` = $id";
            }else if($load == "applicant"){
                $sql="UPDATE `tbl_applicants_employee` SET `tags`='$tags',`comments`='$comments',`title`='$mrtitle',`name`='$first_name',`surname`='$last_name',`email`='$email',`phone`='$phone',`resume_url`='$cv_url',`image_url`='$img_url',`message`='$message',`depart_id_app`='$department_id' WHERE `tae_id` = $id";
            }
        }
        $result = $conn->query($sql);
        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";
            if($saved_status=="CREATE"){
                if($status_id = 6 ){
                    $log = $first_name." Applicant Created";
                }else if($status_id = 4){ 
                    $log =  $first_name." Employee Created";
                }
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$log','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }else{

                $sql1="SELECT * FROM `tbl_applicants_ratings` WHERE `tae_id` = $id";
                $result1 = $conn->query($sql1);
                if ($result1 && $result1->num_rows > 0) {
                    $q="UPDATE `tbl_applicants_ratings` SET `general_impression`=$GeneralCompetence,`social_competence`=    $SocialCompetence,`methodical_competence`=$MethodicalCompetence,`personal_competence`=$PersonalCompetence,`professional_competence`=$ProfractionalCompetencee 
                     WHERE `tae_id` = $id";
                    $stmt=$conn->query($q);
                }else {
                    $sql="INSERT INTO `tbl_applicants_ratings`( `tae_id`, `general_impression`, `social_competence`, `methodical_competence`, `personal_competence`, `professional_competence`) VALUES ($id,$GeneralCompetence,$SocialCompetence,$MethodicalCompetence,$PersonalCompetence,$ProfractionalCompetencee)";
                    $result1 = $conn->query($sql);
                }
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$first_name Applicant Updated','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }

        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Something Bad Happend!!!";
        }

    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>