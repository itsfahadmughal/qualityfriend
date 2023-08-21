
<?php
include '../util_config.php';
include '../util_session.php';
$id = $_POST['id'];
$from = $_POST['from'];
if($from == "floor"){
      $sql="UPDATE `tbl_floors` SET `is_delete`= 1 WHERE `floor_id` = $id";
}else if ($from == "category"){
     $sql="UPDATE `tbl_room_category` SET `is_delete`= 1 WHERE `room_cat_id` = $id";
}else if ($from == "room"){
    $sql="UPDATE `tbl_rooms` SET `is_delete`= 1 WHERE `rms_id` = $id";
}else if ($from == "extra_jobs"){
    $sql="UPDATE `tbl_ housekeeping_extra_jobs` SET `is_delete`= 1 WHERE `hkej_id` = $id";
}
$result1 = $conn->query($sql);
if($result1){
    echo "done";
}else {
    echo "error";
}
?>