<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $usertype_id=0;
    //all
    $user_id = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();

    if(isset($_POST['usertype_id'])){
        $usertype_id =$_POST['usertype_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{


        $sql="SELECT * FROM `tbl_rules` where usert_id = $usertype_id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $i=1;
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp['rule_1'] =    $row['rule_1'];
                $temp['rule_2'] =    $row['rule_2'];
                $temp['rule_3'] =    $row['rule_3'];
                $temp['rule_4'] =     $row['rule_4'];
                $temp['rule_5'] =    $row['rule_5'];
                $temp['rule_6'] =    $row['rule_6'];
                $temp['rule_7'] =     $row['rule_7'];
                $temp['rule_8'] =    $row['rule_8'];
                $temp['rule_9']   =    $row['rule_9'];
                $temp['rule_10']  =   $row['rule_10'];
                $temp['rule_11'] =   $row['rule_11'];
                $temp['rule_12'] =   $row['rule_12'];
                $temp['rule_13'] =   $row['rule_13'];
                $temp['rule_14'] =   $row['rule_14'];
                $temp['rule_15'] =   $row['rule_15'];
                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            } 
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