
<?php
include '../util_config.php';
include '../util_session.php';

$id = 0;
$check =0;
$from = "";
if(isset($_POST['id'])){
    $id = $_POST['id'];
}
if(isset($_POST['check'])){
    $check = $_POST['check'];
}
if(isset($_POST['from'])){
    $from = $_POST['from'];
}


if($from == ""){
    $sql_clean="UPDATE `tbl_room_check` SET  `is_completed` = '$check' WHERE `room_check_id` =  $id";
}else{
    $sql_clean="UPDATE `tbl_room__arrival_check` SET  `is_completed` = '$check' WHERE `rac_id` =  $id";  
}
$result2 =  $conn->query($sql_clean);
if($result2){
echo $sql_clean;
//    echo "done";
}else {
    echo "error";
}

?>