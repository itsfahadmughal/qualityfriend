<?php
include 'util_config.php';
include 'util_session.php';
$mrtitle="";
$first_name="";
$last_name="";
$email="";
$phone="";
$department_id="";
$job_id="";
$message="";
$application_time =date("Y-m-d H:i:s");
$start_working_time = "";
$end_working_time = "";
$status_id = 0;
$is_active_user = 2;
$is_delete = 0;
$tags = "";
$comments = "";
$dob = "";
$dob_place = "";
$tax_number = "";
$img_url= "";
$cv_url= "";
$sql="";
$filename="";
$filepath="";
$filenamecv="";
$filepathcv="";
$SocialCompetence = "";
$MethodicalCompetence = "";
$PersonalCompetence = "";
$ProfractionalCompetencee = "";
$GeneralCompetence = "";
$employee_id = "";
$employee = -1;
$pre_cv_url = "";
$pre_img_url = "";


if(isset($_POST['pre_img_url'])){
    $pre_img_url=$_POST['pre_img_url'];
}
if(isset($_POST['pre_cv_url'])){
    $pre_cv_url=$_POST['pre_cv_url'];
}

if(isset($_POST['mrtitle'])){
    $mrtitle=$_POST['mrtitle'];
}
if(isset($_POST['first_name'])){
    $first_name=$_POST['first_name'];
}
if(isset($_POST['last_name'])){
    $last_name=$_POST['last_name'];
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
if(isset($_POST['message'])){
    $message=$_POST['message'];
}
if(isset($_POST['end_working_time'])){
    $end_working_time=$_POST['end_working_time'];
}
if(isset($_POST['status_id'])){
    $status_id=$_POST['status_id'];
}
if(isset($_POST['start_working_time'])){
    $start_working_time=$_POST['start_working_time'];
}
if(isset($_POST['end_working_time'])){
    $end_working_time=$_POST['end_working_time'];
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
    $tax_number=$_POST['tax_number'];
}
if(isset($_POST['employee'])){
    $employee=$_POST['employee'];
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
if(isset($_POST['employee_id'])){
    $employee_id = $_POST['employee_id'];
}
$rep_firstname = str_replace(" ","_",$first_name);
//For Image
if(isset($_FILES['file']['name'])){
    $filename=$_FILES['file']['name'];
    $filepath=$_FILES['file']['tmp_name'];
}
if($filename == "") {
    $img_url= $pre_img_url;
}
if($filename != "" && $pre_img_url !="") {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $url=explode(".",$pre_img_url);
    $target_dir=".".$url[1].".".$ext;
    $image_path=$target_dir;
    move_uploaded_file($filepath, $image_path);
    $img_url=(string) $target_dir;
}
if($filename != "" && $pre_img_url == "") {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $target_dir="./images/recruiting/".$rep_firstname."-applicant-".time()."-".$hotel_id.".".$ext;
    $image_path=$target_dir;
    move_uploaded_file($filepath, $image_path);
    $img_url=(string) $target_dir;
}

//For Cv
if(isset($_FILES['filescv']['name'])){
    $filenamecv=$_FILES['filescv']['name'];
    $filepathcv=$_FILES['filescv']['tmp_name'];
}
if($filenamecv == "") {
    $cv_url= $pre_cv_url;
}if($filenamecv != "" && $pre_cv_url !="") {
    $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
    $url1=explode(".",$pre_cv_url);
    $target_dircv=".".$url1[1].".".$extcv;
    $image_pathcv=$target_dircv;
    move_uploaded_file($filepathcv, $image_pathcv);
    $cv_url=(string) $target_dircv;
}
if($filenamecv != "" && $pre_cv_url == "") {
    $extcv = pathinfo($filenamecv, PATHINFO_EXTENSION);
    $target_dircv="./images/recruiting/".$rep_firstname."-applicant-Cv-".time()."-".$hotel_id.".".$extcv;
    $image_pathcv=$target_dircv;
    move_uploaded_file($filepathcv, $image_pathcv);
    $cv_url=(string) $target_dircv;
}
if($employee == 1){
    $q1="UPDATE `tbl_applicants_employee` SET `tags`='$tags',`comments`='$comments',`title`='$mrtitle',`name`='$first_name',`surname`='$last_name',`email`='$email',
`phone`='$phone',`resume_url`='$cv_url',`image_url`='$img_url',`message`='$message',`depart_id_emp`='$department_id',
`dob`='$dob',`dob_place`='$dob_place',`tax_number`='$tax_number' ,`start_working_time` = '$start_working_time' WHERE `tae_id` = $employee_id";
}else if($employee == 0){

    $q1="UPDATE `tbl_applicants_employee` SET `tags`='$tags',`comments`='$comments',`title`='$mrtitle',`name`='$first_name',`surname`='$last_name',`email`='$email',
`phone`='$phone',`resume_url`='$cv_url',`image_url`='$img_url',`message`='$message',`depart_id_app`='$department_id' WHERE `tae_id` = $employee_id";
}
else{
    $q1 = "Error";
}
$stmt=$conn->query($q1);
if($stmt)
{
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$first_name Employee Updated','$hotel_id','$application_time')";
    $result_log = $conn->query($sql_log);
    
    $sql1="SELECT * FROM `tbl_applicants_ratings` WHERE `tae_id` = $employee_id";
    $result1 = $conn->query($sql1);
    if ($result1 && $result1->num_rows > 0) {
        $q="UPDATE `tbl_applicants_ratings` SET `general_impression`=$GeneralCompetence,`social_competence`=    $SocialCompetence,`methodical_competence`=$MethodicalCompetence,`personal_competence`=$PersonalCompetence,`professional_competence`=$ProfractionalCompetencee 
         WHERE `tae_id` = $employee_id";
        $stmt=$conn->query($q);
        if($stmt)
        { 
            echo "rating_updated";
        }else{
            echo "rating_updated_error";
        }
    }
    else {
        $sql="INSERT INTO `tbl_applicants_ratings`( `tae_id`, `general_impression`, `social_competence`, `methodical_competence`, `personal_competence`, `professional_competence`) VALUES ($employee_id,$GeneralCompetence,$SocialCompetence,$MethodicalCompetence,$PersonalCompetence,$ProfractionalCompetencee)";
        $result1 = $conn->query($sql);
        if($result1){
            echo "rating_updated";    
        }else{
            echo "rating_updated_error";
        }
    }
}else{ 
    echo $q;
}
?>