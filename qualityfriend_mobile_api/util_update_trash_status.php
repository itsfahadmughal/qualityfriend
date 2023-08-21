<?php
include 'util_config.php';

$tablename = $_POST['tablename'];
$id = $_POST['id'];
$hotel_id = $_POST['hotel_id'];
$idname = $_POST['idname'];
$user_id = $_POST['user_id'];
$statusid = 0;
$statusname = 'is_delete';

if($tablename == "tbl_create_job"){
    $statusname = "is_active";
    $statusid = 1;
}

$data = array();
$entry_time=date("Y-m-d H:i:s");

if($tablename == "tbl_user" || $tablename == "tbl_create_job" || $tablename == "tbl_handbook" || $tablename == "tbl_handover" || $tablename == "tbl_note" || $tablename == "tbl_repair" || $tablename == "tbl_todolist" || $tablename == "tbl_applicants_employee"){

    if($tablename == "tbl_handover" || $tablename == "tbl_note" || $tablename == "tbl_repair"){
        $q="UPDATE ".$tablename." SET ".$statusname." = '$statusid', `lastedittime`='$entry_time' WHERE ".$idname." = $id";
    }else{
        $q="UPDATE ".$tablename." SET ".$statusname." = '$statusid', `edittime`='$entry_time' WHERE ".$idname." = $id";
    }

}else{
    $q="UPDATE ".$tablename." SET ".$statusname." = '$statusid' WHERE ".$idname." = $id";    
}

$stmt=$conn->query($q);

if($stmt)
{ 
    //Log
    $title = "";
    $sql_user="SELECT * FROM $tablename WHERE $idname = $id";
    $result_user = $conn->query($sql_user);
    if ($result_user && $result_user->num_rows > 0) {
        while($row = mysqli_fetch_array($result_user)) {
            if(isset($row['title'])){
                $title = $row['title'];    
            }else if(isset($row['firstname'])){
                $title = $row['firstname'];   
            }else{
                $title = "";
            }

        }
    }
    $tablename = explode("_",$tablename);
    $text_log = "";
    if($statusname == 'is_delete'){
        $text_log = $title.' '.ucfirst($tablename[1]).' Deleted';
    }
    else{
        $text_log = $title.' '.ucfirst($tablename[1]).' Updated';
    }
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$text_log','$hotel_id','$entry_time')";
    $result_log = $conn->query($sql_log);

    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";
}else{ 
    $temp1['flag'] = 0;
    $temp1['message'] = "UnSuccessfull!!!";
} 
echo json_encode(array('Status' => $temp1,'Data' => $data));
mysqli_close($conn); 
?>