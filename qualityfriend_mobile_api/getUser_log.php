<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $user_id = $hotel_id= 0;

    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    $last_id = 0;

    if(isset($_POST["last_id"])){
        $last_id = $_POST["last_id"];
    }
    $data = array();
    $temp1=array();

    //Working

    if($user_id == 0){
         if($last_id != 0 ){
        $sql = "SELECT a.*,b.firstname FROM `tbl_log` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.hotel_id = $hotel_id and  a.log_id < $last_id  ORDER BY 1 DESC LIMIT 20";
         }else{
             
              $sql = "SELECT a.*,b.firstname FROM `tbl_log` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.hotel_id = $hotel_id ORDER BY 1 DESC LIMIT 20";
         }
    }else{
        if($last_id != 0 ){  
        $sql = "SELECT a.*,b.firstname FROM `tbl_log` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.hotel_id = $hotel_id and a.log_id < $last_id AND a.user_id= $user_id ORDER BY 1 DESC LIMIT 20";   
        } else{
            
            $sql = "SELECT a.*,b.firstname FROM `tbl_log` as a INNER JOIN tbl_user as b on a.user_id = b.user_id WHERE a.hotel_id = $hotel_id  AND a.user_id= $user_id ORDER BY 1 DESC LIMIT 20"; 
            
        }
    }
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['log_id'] = $row['log_id'];
            $temp['log_text'] = $row[2];
            $temp['date'] = date("d.m.Y", strtotime(substr($row[4],0,10)));
            $temp['time'] = substr($row[4],10);
            $temp['user'] = $row[5];

            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>