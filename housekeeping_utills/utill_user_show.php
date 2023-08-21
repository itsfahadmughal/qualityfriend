
<?php
include '../util_config.php';
include '../util_session.php';

$id = 0;
$check =0;
$from = "";
if(isset($_POST['active_id'])){
    $active_id = $_POST['active_id'];
}



//getRoomTask Check
$sql_task="SELECT * FROM `tbl_housekeeping_user_rule` WHERE `hotel_id` = $hotel_id";
$result_task = $conn->query($sql_task);
if ($result_task && $result_task->num_rows > 0) {

    $sql_clean="UPDATE `tbl_housekeeping_user_rule` SET  `show_other` = '$active_id' WHERE `hotel_id` =  $hotel_id";  

}else{
    $sql_clean=" INSERT INTO `tbl_housekeeping_user_rule`( `hotel_id`, `show_other`) VALUES ('$hotel_id','$active_id')";
}
$result2 =  $conn->query($sql_clean);
if($result2){

    echo "done";
}else {
    echo "error";
}

?>