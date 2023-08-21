<?php
include 'util_config.php';
include 'util_session.php';

$repeat_type = 0;
$repeat_until_date = "";
$id = 0;
$apply_on=0;

if(isset($_POST['id'])){
    $id=$_POST['id'];
}
if(isset($_POST['repeat_type'])){
    $repeat_type=$_POST['repeat_type'];
}
if(isset($_POST['repeat_until_date'])){
    $repeat_until_date = date("Y-m-d", strtotime($_POST['repeat_until_date']));
}
if(isset($_POST['apply_on'])){
    $apply_on=$_POST['apply_on'];
}


if($repeat_type == 1){
    $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE `sfs_id` = $id AND hotel_id = $hotel_id";  
    $stmt=$conn->query($q);
    if($stmt){
        echo "Updated";
    }
}else if($repeat_type == 2){

    $query = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
    $result = $conn->query($query);
    while ($row = mysqli_fetch_array($result)) {

        $date = $row['date'];
        $assign_to = $row['assign_to'];

        for($i=0;$i<=50;$i++){
            $str = ' + '.(7*($i)).' days';
            $new_date = date('Y-m-d', strtotime($date. $str)); 

            if($apply_on == 1){
                $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE `date` = '$new_date' AND assign_to = $assign_to AND hotel_id = $hotel_id";  
                $stmt=$conn->query($q);
            }else{
                $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE `date` = '$new_date' AND hotel_id = $hotel_id";  
                $stmt=$conn->query($q);
            }

        }

        if($stmt){
            echo "Updated";
        }

    }


}else{
    $query = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
    $result = $conn->query($query);
    while ($row = mysqli_fetch_array($result)) {
        $date = $row['date'];
        $assign_to = $row['assign_to'];

        if($apply_on == 1){
            $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE (`date` between '$date' AND '$repeat_until_date') AND assign_to = $assign_to AND hotel_id = $hotel_id";  
            $stmt=$conn->query($q);
        }else{
            $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE (`date` between '$date' AND '$repeat_until_date') AND hotel_id = $hotel_id";  
            $stmt=$conn->query($q);
        }

        if($stmt){
            echo "Updated";
        }

    }
}

$entry_time=date("Y-m-d H:i:s");
$sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Shift Deleted By the Admin','$hotel_id','$entry_time')";
$result_log = $conn->query($sql_log);

mysqli_close($conn); 
?>