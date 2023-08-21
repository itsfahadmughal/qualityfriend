<?php
include 'util_config.php';

$id=0;
$source="";
$user_id = 0;


$data = array();
$temp1=array();

if(isset($_POST['id'])){
    $id=$_POST['id'];
}
if(isset($_POST['type'])){
    $source=$_POST['type'];
}

if(isset($_POST['user_id'])){
    $user_id=$_POST['user_id'];
}


if($source == "handover"){

    $sql = "SELECT * FROM `tbl_handover_recipents`  WHERE  hdo_id= $id and  user_id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            if( $row['is_completed'] == 1){
                $temp['status'] = "Completed";
            }else {
                $temp['status'] = "Un Completed";
            }

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }
}

if($source == "repair"){
    
    $sql = "SELECT * FROM `tbl_repair_recipents`  WHERE  rpr_id= $id and  user_id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            if( $row['is_completed'] == 1){
                $temp['status'] = "Completed";
            }else {
                $temp['status'] = "Un Completed";
            }

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }
}

echo json_encode(array('Status' => $temp1,'Data' => $data));

?>