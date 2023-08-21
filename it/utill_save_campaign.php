<?php 
include 'util_config.php';
include '../util_session.php';

$team_name="";
$department="";
$url = "";
$url_id = 0;
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
$entry_time=date("Y-m-d H:i:s");
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");


$genrated_url = $url."&source=".$source.'&name='.$name.'&team='.$team;
if($url_id == 0){
    $sql="INSERT INTO `tbl_job_ad_campaign`(`org_url`, `genreted_url`, `name`, `sorce`, `team`, `is_delete`,`hotel_id`, `entrybyid`, `entrybytime`) VALUES ('$url','$genrated_url','$name','$source','$team','0','$hotel_id','$entryby_id','$entry_time')";
    $result = $conn->query($sql);
    if($result){
        echo '1';
        $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Admin Created new job-Ad tracking campaign','$hotel_id','$entry_time')";
        $result_log = $conn->query($sql_log);
    }else{
        echo "0";
    }


}
else if($department != ""){


}
else{
    echo "Error";
}
?>