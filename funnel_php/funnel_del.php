<?php
include '../util_config.php';
include '../util_session.php';

$id = 0;
if(isset($_POST['id'])){
    $id=$_POST['id'];
}


$sql_d = "DELETE FROM `tbl_funnel_info` WHERE `f_id` = $id";
$result_d = $conn->query($sql_d);

if($result_d){
    echo 'Updated';
}else {
    echo 'error'; 
}

?>