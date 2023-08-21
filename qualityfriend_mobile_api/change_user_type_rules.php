<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $rule1 = "";
    $rule2 =  "";
    $rule3 =  "";
    $rule4 =  "";
    $rule5 =  "";
    $rule6 =  "";
    $rule7 =  "";
    $rule8 =  "";
    $rule9 = "";
    $rule10 = "";
    $rule11 =  "";
    $rule12 = "";

    $rule13 = 0;
    $rule14 =  0;
    $rule15 = 0;
    //all
    $user_id = 0;
    $hotel_id = 0;
    $data = array();
    $temp1=array();


    $type_id = 0;
    if(isset($_POST['type_id'])){
        $type_id = $_POST['type_id'];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }

    if(isset($_POST['rule1'])){
        $rule1 = $_POST['rule1'];
    }
    if(isset($_POST['rule2'])){
        $rule2 = $_POST['rule2'];
    }
    if(isset($_POST['rule3'])){
        $rule3 = $_POST['rule3'];
    }
    if(isset($_POST['rule4'])){
        $rule4 = $_POST['rule4'];
    }
    if(isset($_POST['rule5'])){
        $rule5 = $_POST['rule5'];
    }
    if(isset($_POST['rule6'])){
        $rule6 = $_POST['rule6'];
    }
    if(isset($_POST['rule7'])){
        $rule7 = $_POST['rule7'];
    }
    if(isset($_POST['rule8'])){
        $rule8 = $_POST['rule8'];
    }
    if(isset($_POST['rule9'])){
        $rule9 = $_POST['rule9'];
    }
    if(isset($_POST['rule10'])){
        $rule10 = $_POST['rule10'];
    }
    if(isset($_POST['rule11'])){
        $rule11 = $_POST['rule11'];
    }
    if(isset($_POST['rule12'])){
        $rule12 = $_POST['rule12'];
    }

    if(isset($_POST['rule13'])){
        $rule13 = $_POST['rule13'];
    }
    if(isset($_POST['rule14'])){
        $rule14 = $_POST['rule14'];
    }
    if(isset($_POST['rule15'])){
        $rule15 = $_POST['rule15'];
    }


    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    if($user_id == 0 || $hotel_id == 0){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{
        $sql1="DELETE FROM `tbl_rules` WHERE  `usert_id` = $type_id";
        $result1 = $conn->query($sql1);
        $sql1="INSERT INTO `tbl_rules`( `usert_id`, `rule_1`, `rule_2`, `rule_3`, `rule_4`, `rule_5`, `rule_6`, `rule_7`, `rule_8`,`rule_9`, `rule_10`,`rule_11`, `rule_12`,`rule_13`, `rule_14`, `rule_15`) VALUES ('$type_id','$rule1','$rule2','$rule3','$rule4','$rule5','$rule6','$rule7','$rule8','$rule9','$rule10','$rule11','$rule12','$rule13','$rule14','$rule15')";
        $result1 = $conn->query($sql1);
        if($result1){
            $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Update Rules','$hotel_id','$entry_time')";
            $result_log = $conn->query($sql_log);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";
        }else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Something Bad Happend!!!";
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