<?php 
include 'util_config.php';
include 'util_session.php';

$employee = "";
$res = "";

if(isset($_POST['employee'])){
    $employee = $_POST['employee'];
}

if($employee != 0){
    $sql_outer="SELECT * FROM `tbl_schedule_setting_visibility` WHERE hotel_id = $hotel_id AND employee_id = $employee";
    $result_outer = $conn->query($sql_outer);
    if ($result_outer && $result_outer->num_rows > 0) {
        while($row = mysqli_fetch_array($result_outer)) {
            $res = $row[3].','.$row[4].','.$row[5];
        }   
        echo $res;
    }else{
        echo "unsuccess";
    }
}

?>