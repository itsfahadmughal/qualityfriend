<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $saved_status="";
    $language="";
    $crjb_id=0;
    $title="";
    $title_it="";
    $title_de="";
    $department="";
    $creation_date="";
    $description="";
    $description_it="";
    $description_de="";
    $location="";
    $location_it="";
    $location_de="";
    $job_pic="";
    $cv_required="";
    $whatsapp_required="";
    $wp_num="";
    $img_url= "";
    $sql="";
    $user_id=0;
    $hotel_id=0;
    $data = array();
    $temp1=array();

    if(isset($_POST['job_id'])){
        $crjb_id=$_POST['job_id'];
    }
    if(isset($_POST['saved_status'])){
        $saved_status=$_POST['saved_status'];
    }
    if(isset($_POST['language'])){
        $language=$_POST['language'];
    }
    if(isset($_POST['title'])){
        $title=str_replace("'","`",$_POST['title']);
    }
    if(isset($_POST['title_it'])){
        $title_it=str_replace("'","`",$_POST['title_it']);
    }
    if(isset($_POST['title_de'])){
        $title_de=str_replace("'","`",$_POST['title_de']);
    }
    if(isset($_POST['department'])){
        $department=$_POST['department'];
    }
    if(isset($_POST['creation_date'])){
        $creation_date=$_POST['creation_date'];
    }
    if(isset($_POST['description'])){
        $description=trim(str_replace("'","`",$_POST['description']));
    }
    if(isset($_POST['description_it'])){
        $description_it=trim(str_replace("'","`",$_POST['description_it']));
    }
    if(isset($_POST['description_de'])){
        $description_de=trim(str_replace("'","`",$_POST['description_de']));
    }
    if(isset($_POST['location'])){
        $location=$_POST['location'];
    }
    if(isset($_POST['location_it'])){
        $location_it=$_POST['location_it'];
    }
    if(isset($_POST['location_de'])){
        $location_de=$_POST['location_de'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['image_path'])){
        $img_url=$_POST['image_path'];
    }
    if(isset($_POST['cv_required'])){
        if($_POST['cv_required']== 'true'){
            $cv_required=1;
        }else{
            $cv_required=0;
        }

    }
    if(isset($_POST['whatsapp_isactive'])){
        if($_POST['whatsapp_isactive']== 'true'){
            $whatsapp_required=1;
        }else{
            $whatsapp_required=0;
        }
    }
    if(isset($_POST['whatsapp_number'])){
        $wp_num = $_POST['whatsapp_number'];
    }



    //new update 2023-08-12
    $jobs_funnel = 0;
    if(isset($_POST['jobs_funnel'])){
        $jobs_funnel=$_POST['jobs_funnel'];
    }

    $question_1 = "";
    $question_2 = "";
    $is_funnel = 0;
    if(isset($_POST['is_funnel'])){
        if($_POST['is_funnel']== 'true'){
            $is_funnel=1;
        }else{
            $is_funnel=0;
        }
    }
    $img_url1 = "";
    if(isset($_POST['logo_path'])){
        $img_url1 = $_POST['logo_path'];
    }
    $auto_msg = "";
    if(isset($_POST['auto_msg'])){
        $auto_msg=trim(str_replace("'","`",$_POST['auto_msg']));
    }
    $userbenifits_array = array();
    if(isset($_POST['userbenifits_array'])){

        if($_POST['userbenifits_array'] != ""){

            $userbenifits_array=$_POST['userbenifits_array'];

            $userbenifits_array =   (array)explode(",",$userbenifits_array);

        }

    }


    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");

    $generated_link="preview_job.php?lang=".$language."&slug=".time().rand();

    if($user_id == 0 || $hotel_id == 0){

        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{

        if($language=='english'){
            $sql="INSERT INTO `tbl_create_job`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `location`, `location_it`, `location_de`, `job_image`,`logo_image`, `generated_link`,`creation_date`, `depart_id`, `hotel_id`, `is_cv_required`,`is_funnel`,`step_1_q`, `step_2_q`, `saved_status`, `is_active`, `whatsapp`, `whatsapp_isactive`,`auto_msg`,`job_funnel`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$title','','','$description','','','$location','','','$img_url','$img_url1','$generated_link','$creation_date','$department','$hotel_id',$cv_required,'$is_funnel','$question_1','$question_2','$saved_status',1,'$wp_num','$whatsapp_required','$auto_msg','$jobs_funnel','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
        }elseif($language=='italian'){
            $generated_link="it/preview_job.php?lang=".$language."&slug=".time().rand();

            $sql="INSERT INTO `tbl_create_job`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `location`, `location_it`, `location_de`, `job_image`,`logo_image`, `generated_link`, `creation_date`, `depart_id`, `hotel_id`, `is_cv_required`,`is_funnel`,`step_1_q`, `step_2_q`, `saved_status`, `is_active`, `whatsapp`, `whatsapp_isactive`,`auto_msg`,`job_funnel`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('','$title','','','$description','','','$location','','$img_url','$img_url1','$generated_link','$creation_date','$department','$hotel_id',$cv_required,'$is_funnel','$question_1','$question_2','$saved_status',1,'$wp_num','$whatsapp_required','$auto_msg','$jobs_funnel','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
        }elseif($language=='german'){
            $generated_link="de/preview_job.php?lang=".$language."&slug=".time().rand();

            $sql="INSERT INTO `tbl_create_job`(`title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `location`, `location_it`, `location_de`, `job_image`,`logo_image`, `generated_link`, `creation_date`, `depart_id`, `hotel_id`, `is_cv_required`,`is_funnel`,`step_1_q`, `step_2_q`, `saved_status`, `is_active`, `whatsapp`, `whatsapp_isactive`,`auto_msg`,`job_funnel`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('','','$title','','','$description','','','$location','$img_url','$img_url1','$generated_link','$creation_date','$department','$hotel_id',$cv_required,'$is_funnel','$question_1','$question_2','$saved_status',1,'$wp_num','$whatsapp_required','$auto_msg','$jobs_funnel','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
        }else{
            if($img_url=="" &&  $img_url1 == "" ){
                $sql="UPDATE `tbl_create_job` SET `title`='$title',`title_it`='$title_it',`title_de`='$title_de',`description`='$description',`description_it`='$description_it',`description_de`='$description_de',`location`='$location',`location_it`='$location_it',`location_de`='$location_de',`creation_date`='$creation_date',`depart_id`='$department',`is_cv_required`='$cv_required',`is_funnel`='$is_funnel',`step_1_q`='$question_1',`step_2_q`='$question_2',`saved_status`='$saved_status',`whatsapp`='$wp_num',`whatsapp_isactive`='$whatsapp_required',`auto_msg`='$auto_msg',`job_funnel`='$jobs_funnel',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE crjb_id = $crjb_id";
            }else if ($img_url !="" &&  $img_url1 == "" ){
                $sql="UPDATE `tbl_create_job` SET `title`='$title',`title_it`='$title_it',`title_de`='$title_de',`description`='$description',`description_it`='$description_it',`description_de`='$description_de',`location`='$location',`location_it`='$location_it',`location_de`='$location_de',`job_image`='$img_url',`creation_date`='$creation_date',`depart_id`='$department',`is_cv_required`='$cv_required',`is_funnel`='$is_funnel',`step_1_q`='$question_1',`step_2_q`='$question_2',`saved_status`='$saved_status',`whatsapp`='$wp_num',`whatsapp_isactive`='$whatsapp_required',`auto_msg`='$auto_msg',`job_funnel`='$jobs_funnel',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE crjb_id = $crjb_id";
            }else if ($img_url =="" &&  $img_url1 != "" ){
                $sql="UPDATE `tbl_create_job` SET `title`='$title',`title_it`='$title_it',`title_de`='$title_de',`description`='$description',`description_it`='$description_it',`description_de`='$description_de',`location`='$location',`location_it`='$location_it',`location_de`='$location_de',`logo_image`='$img_url1',`creation_date`='$creation_date',`depart_id`='$department',`is_cv_required`='$cv_required',`is_funnel`='$is_funnel',`step_1_q`='$question_1',`step_2_q`='$question_2',`saved_status`='$saved_status',`whatsapp`='$wp_num',`whatsapp_isactive`='$whatsapp_required',`auto_msg`='$auto_msg',`job_funnel`='$jobs_funnel',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE crjb_id = $crjb_id";
            }else {
                $sql="UPDATE `tbl_create_job` SET `title`='$title',`title_it`='$title_it',`title_de`='$title_de',`description`='$description',`description_it`='$description_it',`description_de`='$description_de',`location`='$location',`location_it`='$location_it',`location_de`='$location_de',`job_image`='$img_url',`logo_image`='$img_url1',`creation_date`='$creation_date',`depart_id`='$department',`is_cv_required`='$cv_required',`is_funnel`='$is_funnel',`step_1_q`='$question_1',`step_2_q`='$question_2',`saved_status`='$saved_status',`whatsapp`='$wp_num',`whatsapp_isactive`='$whatsapp_required',`auto_msg`='$auto_msg',`job_funnel`='$jobs_funnel',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE crjb_id = $crjb_id";
            }
        }

        $result = $conn->query($sql);

        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";

            if($language == "english" || $language == "italian" || $language == "german"){
                $job_id = $conn->insert_id;
            }else {
                $job_id = $crjb_id;
                $sql_d = "DELETE FROM `tbl_job_benefits` WHERE `job_id` = $job_id";
                $result_d = $conn->query($sql_d);
            }

            for ($x = 0; $x < sizeof($userbenifits_array); $x++) {
                $sql_user="INSERT INTO `tbl_job_benefits`(`job_id`, `text`) VALUES ('$job_id','$userbenifits_array[$x]')";
                $result_user = $conn->query($sql_user);
            }

            if($saved_status=="CREATE"){
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Job Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }else{
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Job Update','$hotel_id','$entry_time')";
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