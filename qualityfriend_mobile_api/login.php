<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration
    $email = $password= $token = "";
    $login_as ="";
    if(isset($_POST["email"])){
        $email = $_POST["email"];    
    }
    if(isset($_POST["token"])){
        $token = $_POST["token"];    
    }
    if(isset($_POST["password"])){
        $password = $_POST["password"];    
        $password = md5($password);
    }
    if(isset($_POST["login_as"])){
        $login_as = $_POST["login_as"];
    }
    
    $user = array();
    $temp1=array();

    //Working
    $sql = "SELECT a.*,c.hotel_language FROM tbl_user as a INNER JOIN tbl_hotel as c on a.hotel_id = c.hotel_id WHERE a.email='$email' AND a.password='$password' AND a.is_active=1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_row($result);
            $temp = array();
            
            $user_id = $row[0];

            $temp['userid'] = $row[0];
            $userid = $row[0];
            $temp['usert_id'] = $row[1];
            $temp['firstname'] = $row[2];
            $temp['lastname'] = $row[3];
            $temp['email'] = $row[4];
            $temp['address'] = $row[6];
            $temp['image_url'] = $row[6];
            $temp['hotel_id'] = $row[11];
            $hotel_id = $row[11];

            $sql_token = "UPDATE `tbl_user` SET `user_token` = '$token',`login_as`='$login_as' WHERE `user_id` = $user_id";
            $result_t = $conn->query($sql_token);

            $depart_id = $row[8];
            $sql_inner="SELECT depart_id,department_name,department_name_it,department_name_de FROM tbl_department WHERE depart_id = $depart_id";
            $result_c = $conn->query($sql_inner);
            if ($result_c && $result_c->num_rows > 0) {
                while($row_c = mysqli_fetch_array($result_c)) {
                    $temp['department_id'] = $row_c['depart_id'];
                    $temp['department'] = $row_c['department_name'];
                    $temp['department_it'] = $row_c['department_name_it'];
                    $temp['department_de'] = $row_c['department_name_de'];
                }
            }

            $day = strtolower(date("l",time()));
            $day = $day."_text";
            $day_it = $day."_it";
            $day_de = $day."_de";

            $sql_welcome = "SELECT $day,$day_it,$day_de FROM `tbl_hotel_welcome_note` WHERE hotel_id = $hotel_id";
            $result_welcome = $conn->query($sql_welcome);
            if ($result_welcome && $result_welcome->num_rows > 0) {
                while($row_welcome = mysqli_fetch_array($result_welcome)) {
                    if(trim($row_welcome[$day]) == ""){
                        $temp['welcome_text'] = "I wish you a nice day.";
                    }else{
                        $temp['welcome_text'] = $row_welcome[$day];
                    }
                    if(trim($row_welcome[$day_it]) == ""){
                        $temp['welcome_text_it'] = "Ti auguro una buona giornata.";
                    }else{
                        $temp['welcome_text_it'] = $row_welcome[$day_it];
                    }
                    if(trim($row_welcome[$day_de]) == ""){
                        $temp['welcome_text_de'] = "ich wünsche Dir einen schönen Tag.";
                    }else{
                        $temp['welcome_text_de'] = $row_welcome[$day_de];
                    }

                }
            }





            $temp['language'] = $row[24];

            array_push($user, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Email OR Password is incorrect!!!";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "User Not Found!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $user));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $user));
}
$conn->close();
?>