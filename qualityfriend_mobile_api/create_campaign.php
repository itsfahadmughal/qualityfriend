<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{


    $user_id=0;
    $hotel_id=0;
    $data = array();
    $temp1=array();


    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if(isset($_POST['url'])){
        $url=$_POST['url'];
    }
    if(isset($_POST['source'])){
        $source=$_POST['source'];
    }
    if(isset($_POST['name'])){
        $name=$_POST['name'];
    }
    if(isset($_POST['team'])){
        $team=$_POST['team'];
    }


    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");

    $genrated_url = $url."&source=".$source.'&name='.$name.'&team='.$team;
    if($user_id == 0 || $hotel_id == 0){

        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{

        $sql="INSERT INTO `tbl_job_ad_campaign`(`org_url`, `genreted_url`, `name`, `sorce`, `team`, `is_delete`,`hotel_id`, `entrybyid`, `entrybytime`) VALUES ('$url','$genrated_url','$name','$source','$team','0','$hotel_id','$entryby_id','$entry_time')";
        $result = $conn->query($sql);

        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";

            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Admin Created new job-Ad tracking campaign','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);

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