<?php 
// IOSNotification
require_once 'vendor/autoload.php';
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $user_id = 0;
    $hotel_id = 0;
    $create_as="";
    $title="";
    $title_it="";
    $title_de="";
    $language="";
    $active=1;
    $select_one="";
    $assing="";
    $due_date="";
    $timepicker="";
    $repart="";
    $duration="";
    $until_date = "";
    $no_of_reparts="";
    $days="";
    $description="";
    $description_it="";
    $description_de="";
    $recipent_list_array=array();
    $todo_list_array=array();
    $todo_list_array_it=array();
    $todo_list_array_de=array();
    $tour_list_array=array();
    $tour_list_array_it=array();
    $tour_list_array_de=array();
    $inspection_list_array=array();
    $inspection_list_array_it=array();
    $inspection_list_array_de=array();
    $comments_list_array=array();

    $ios_token_array= array();
    $send_notification_array =  array();
    $dep_array_id = array();    





    $key_file = 'key.p8';
    $secret = null; // If the key is encrypted, the secret must be set in this variable
    $private_key = JWKFactory::createFromKeyFile($key_file, $secret, [
        'kid' => 'P5QF2XQHT2', // The Key ID obtained from your developer account
        'alg' => 'ES256',      // Not mandatory but recommended
        'use' => 'sig',        // Not mandatory but recommended
    ]);

    $payload = [
        'iss' => 'YYF7W472DP',
        'iat' => time(),
    ];

    $header = [
        'alg' => 'ES256',
        'kid' => $private_key->get('kid'),
    ];
    //
    $jws = JWSFactory::createJWSToCompactJSON(
        $payload,
        $private_key,
        $header
    );
    function sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $token, $jws) {

        // url (endpoint)
        $url = "{$http2_server}/3/device/{$token}";

        // headers
        $headers = array(
            "apns-topic: {$app_bundle_id}",
            'Authorization: bearer ' . $jws
        );

        // other curl options
        curl_setopt_array($http2ch, array(
            CURLOPT_URL => $url,
            CURLOPT_PORT => 443,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $message,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => 1
        ));

        // go...
        $result = curl_exec($http2ch);
        if ($result === FALSE) {
            throw new Exception("Curl failed: " .  curl_error($http2ch));
        }
        // get response
        $status = curl_getinfo($http2ch);

        return $status;
    }

    function sendFCM($registration_ids,$title,$msg) {

        // FCM API Url
        $url = 'https://fcm.googleapis.com/fcm/send';
        // Put your Server Key here
        $apiKey = "AAAAQJVy_jw:APA91bE8sIykRMyCAHsiW1oAHHiYlT_ExpDdj6Irny-pz4B5yvgo3TjyIELP_ZhxR3BNVXolErjrrcdtZ8i7m5pCosM4lJf9CD0EXtcyHHhRgod2ir8gvlVZe4IJLR1sXVru4M7u_2Sl";

        // Compile headers in one variable
        $headers = array (
            'Authorization:key=' . $apiKey,
            'Content-Type:application/json'
        );

        // Add notification content to a variable for easy reference
        $notifData = [
            'title' => $title,
            'body' => $msg,
            //  "image": "url-to-image",//Optional
            //            'click_action' => "activities.NotifHandlerActivity" //Action/Activity - Optional
        ];

        $dataPayload = [
            'experienceId' => '@asim_bashir/Quality_Friend',
            'scopeKey' => '@asim_bashir/Quality_Friend',
            'title'  => $title,
            'message'  => $msg,
            'to'=> 'My Name', 
            'points'=>80, 
            'other_data' => 'This is extra payload'
        ];
        // Create the api body
        $apiBody = [
            'notification' => $notifData,
            'data' => $dataPayload, //Optional
            'time_to_live' => 600, // optional - In Seconds
            //'to' => '/topics/mytargettopic'
            'registration_ids' => $registration_ids
            //        'to' => '',
        ];
        // Initialize curl with the prepared headers and body
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

        // Execute call and save result
        $result = curl_exec($ch);
        // Close curl after call
        curl_close($ch);

        return $result;
    }

    $attachments_url = array();

    if(isset($_POST['attachments_url'])){
        if($_POST['attachments_url'] != ""){
            $attachments_url= (array)explode(",",$_POST['attachments_url']);    
        }

    }
    $id = 0;
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }
    if(isset($_POST['create_as'])){
        $create_as=$_POST['create_as'];
    }
    if(isset($_POST['title'])){
        $title=str_replace("'","`",$_POST['title']);
    }
    if(isset($_POST['title_it'])){
        $title_it=str_replace("'","`",$_POST['title_it']);
    }
    if(isset($_POST['title_de'])){
        $title_de=str_replace("'","`",$_POST['title_de']);
    }
    if(isset($_POST['language'])){
        $language=$_POST['language'];
    }
    if(isset($_POST['active'])){
        $active=$_POST['active'];
    }
    if(isset($_POST['select_one'])){
        $select_one=$_POST['select_one'];
    }
    if(isset($_POST['recipent_list_array'])){
        if($_POST['recipent_list_array'] != ""){
            $recipent_list_array=$_POST['recipent_list_array'];
            $recipent_list_array= (array)explode(",",$recipent_list_array);
        }
    }
    if(isset($_POST['assing'])){
        $assing=$_POST['assing'];
    }
    //start date
    if(isset($_POST['due_date'])){
        $due_date=$_POST['due_date'];
    }
    if(isset($_POST['time'])){
        $timepicker=$_POST['time'];
    }
    if(isset($_POST['repart'])){
        $repart=$_POST['repart'];
    }
    if(isset($_POST['repeat_status'])){
        $duration=$_POST['repeat_status'];
    }
    //end_date
    if(isset($_POST['until_date'])){
        $until_date=$_POST['until_date'];
    }
    if(isset($_POST['days'])){
        $days=$_POST['days'];
    }
    if(isset($_POST['description'])){
        $description=trim(str_replace("'","`",$_POST['description']));
    }
    if(isset($_POST['description_it'])){
        $description_it=trim(str_replace("'","`",$_POST['description_it']));
    }
    if(isset($_POST['description_de'])){
        $description_de=trim(str_replace("'","`",$_POST['description_de']));
    }
    if(isset($_POST['todo_list_array'])){

        if($_POST['todo_list_array'] != ""){

            $todo_list_array=$_POST['todo_list_array'];

            $todo_list_array =   (array)explode(",",$todo_list_array);

        }

    }
    if(isset($_POST['dep_array_id'])){
        if($_POST['dep_array_id'] != ""){
            $dep_array_id= (array) explode(",",$_POST['dep_array_id']);
        }

    }
    if(isset($_POST['todo_list_array_it'])){
        if($_POST['todo_list_array_it'] != ""){
            $todo_list_array_it=$_POST['todo_list_array_it'];
            $todo_list_array_it =   (array)explode(",",$todo_list_array_it);
        }
    }
    if(isset($_POST['todo_list_array_de'])){
        if($_POST['todo_list_array_de'] != ""){
            $todo_list_array_de=$_POST['todo_list_array_de'];

            $todo_list_array_de =   (array)explode(",",$todo_list_array_de);
        }
    }
    if(isset($_POST['tour_list_array'])){
        if($_POST['tour_list_array'] != ""){
            $tour_list_array=$_POST['tour_list_array'];

            $tour_list_array =   (array)explode(",",$tour_list_array);
        }
    }
    if(isset($_POST['tour_list_array_it'])){
        if($_POST['tour_list_array_it'] != ""){
            $tour_list_array_it=$_POST['tour_list_array_it'];
            $tour_list_array_it =   (array)explode(",",$tour_list_array_it);
        }
    }
    if(isset($_POST['tour_list_array_de'])){
        if($_POST['tour_list_array_de'] != ""){
            $tour_list_array_de=$_POST['tour_list_array_de'];

            $tour_list_array_de =   (array)explode(",",$tour_list_array_de);
        }
    }
    if(isset($_POST['inspection_list_array'])){
        if($_POST['inspection_list_array'] != ""){
            $inspection_list_array=$_POST['inspection_list_array'];
            $inspection_list_array =   (array)explode(",",$inspection_list_array);
        }
    }
    if(isset($_POST['inspection_list_array_it'])){
        if($_POST['inspection_list_array_it'] != ""){
            $inspection_list_array_it=$_POST['inspection_list_array_it'];
            $inspection_list_array_it =   (array)explode(",",$inspection_list_array_it);
        }
    }
    if(isset($_POST['inspection_list_array_de'])){
        if($_POST['inspection_list_array_de'] != ""){
            $inspection_list_array_de=$_POST['inspection_list_array_de'];
            $inspection_list_array_de =   (array)explode(",",$inspection_list_array_de);
        }
    }
    if(isset($_POST['comments_list_array'])){
        if($_POST['comments_list_array'] != ""){
            $comments_list_array=$_POST['comments_list_array'];
            $comments_list_array =   (array)explode(",",$comments_list_array);
        }
    }


    $data = array();
    $temp1=array();
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }

    $due_date_id_used = $due_date;
    $due_date_id_used = date('l j F Y', strtotime($due_date_id_used . ' +1 day'));


    $due_date = $due_date."-".$timepicker ;

    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");






    $lenth_recipent = sizeof($recipent_list_array);
    $lenth_todo = sizeof($todo_list_array);
    $lenth_tour = sizeof($tour_list_array);
    $lenth_inspection = sizeof($inspection_list_array);
    $lenth_comment = sizeof($comments_list_array);
    $inserted_check_list_array = array();
    $inserted_inspection_array = array();
    $inserted_tour_array = array();




    

    $current_date =   date("l j F Y");
    $current_date_temp_array = explode(" ",$current_date);
    $current_date_day = strtoupper($current_date_temp_array[0]);
    $current_date_date = strtoupper($current_date_temp_array[1]);

    function getDatesFromRange($start, $end, $format = 'l j F Y') {

        // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }

        return $array;
    }




    $due_date_used = $due_date;
    $due_date_used = date('l j F Y', strtotime($due_date_used . ' +1 day'));


    $array_of_dates = array();
    if($duration == "DAILY"){
        if($until_date != ""){


            $Date = getDatesFromRange($due_date_used, $until_date);
            $lenth_array = sizeof($Date);
            for ($x = 0; $x < $lenth_array; $x++) {
                array_push($array_of_dates,$Date[$x]);
            }
        }
        $duration = "DAILY";
    }else if ($duration == "WEEKLY") {
        $Date = getDatesFromRange($due_date_used, $until_date);
        $lenth_array = sizeof($Date);
        for ($x = 1; $x < $lenth_array; $x++) {
            $new_temp_array_day = explode(" ",$Date[$x]);
            $selected_day = strtoupper($new_temp_array_day[0]);
            if($selected_day   == $days){
                array_push($array_of_dates,$Date[$x]);
            }else {

            }
        }
        $duration = "WEEKLY";

    }else if ($duration == "MONTHLY") {
        $new_current_date = date("y-m-d", strtotime($due_date_used)); 
        $new_untill = date("y-m-d", strtotime($until_date));
        while($new_current_date <= $new_untill) {
            $new_current_date =  date("y-m-d",strtotime( "+1 months", strtotime($new_current_date)));
            if ($new_current_date > $new_untill){

            }else {
                $pre = date("y-m-d",strtotime( "-7 days", strtotime($new_current_date)));
                $Date = getDatesFromRange($pre, $new_current_date);
                $lenth_array = sizeof($Date);
                for ($x = 0; $x < $lenth_array; $x++) {
                    $new_temp_array_day = explode(" ",$Date[$x]);
                    $selected_day = strtoupper($new_temp_array_day[0]);
                    if($selected_day   == $days){
                        array_push($array_of_dates,$Date[$x]);
                    }else {

                    }
                } 
            }

        }
        $duration = "MONTHLY";
    }
    else if ($duration == "QUARTERLY") {
        $new_current_date = date("y-m-d", strtotime($due_date_used)); 
        $new_untill = date("y-m-d", strtotime($until_date));
        while($new_current_date <= $new_untill) {
            $new_current_date =  date("y-m-d",strtotime( "+3 months", strtotime($new_current_date)));
            if ($new_current_date > $new_untill){

            }else {
                $pre = date("y-m-d",strtotime( "-7 days", strtotime($new_current_date)));
                $Date = getDatesFromRange($pre, $new_current_date);
                $lenth_array = sizeof($Date);
                for ($x = 0; $x < $lenth_array; $x++) {
                    $new_temp_array_day = explode(" ",$Date[$x]);
                    $selected_day = strtoupper($new_temp_array_day[0]);
                    if($selected_day   == $days){
                        array_push($array_of_dates,$Date[$x]);
                    }else {

                    }
                } 
            }

        }
        $duration = "QUARTERLY";
    }else if ($duration == "HALF_YEARLY") {
        $new_current_date = date("y-m-d", strtotime($due_date_used)); 
        $new_untill = date("y-m-d", strtotime($until_date));
        while($new_current_date <= $new_untill) {
            $new_current_date =  date("y-m-d",strtotime( "+6 months", strtotime($new_current_date)));
            if ($new_current_date > $new_untill){

            }else {
                $pre = date("y-m-d",strtotime( "-7 days", strtotime($new_current_date)));
                $Date = getDatesFromRange($pre, $new_current_date);
                $lenth_array = sizeof($Date);
                for ($x = 0; $x < $lenth_array; $x++) {
                    $new_temp_array_day = explode(" ",$Date[$x]);
                    $selected_day = strtoupper($new_temp_array_day[0]);
                    if($selected_day   == $days){
                        array_push($array_of_dates,$Date[$x]);
                    }else {

                    }
                } 
            }

        }
        $duration = "HALF_YEARLY";

    }else if ($duration == "YEARLY") {
        $new_current_date = date("y-m-d", strtotime($due_date_used)); 
        $new_untill = date("y-m-d", strtotime($until_date));
        while($new_current_date <= $new_untill) {
            $new_current_date =  date("y-m-d",strtotime( "+12 months", strtotime($new_current_date)));
            if ($new_current_date > $new_untill){

            }else {
                $pre = date("y-m-d",strtotime( "-7 days", strtotime($new_current_date)));
                $Date = getDatesFromRange($pre, $new_current_date);
                $lenth_array = sizeof($Date);
                for ($x = 0; $x < $lenth_array; $x++) {
                    $new_temp_array_day = explode(" ",$Date[$x]);
                    $selected_day = strtoupper($new_temp_array_day[0]);
                    if($selected_day   == $days){
                        array_push($array_of_dates,$Date[$x]);
                    }else {

                    }
                } 
            }

        }
        $duration = "YEARLY";
    }


    if($user_id == 0 || $hotel_id == 0){

        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & User Id Required...";

    }else{

        if($language=='english'){ 

            $sql="INSERT INTO `tbl_todolist`( `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `visibility_status`, `assign_recipient_status`, `due_date`, `repeat_status`, `day`, `repeat_until`, `no_of_repeat`, `tags`, `hotel_id`, `saved_status`, `status_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$title','','','$description','','','$select_one','$assing','$due_date','$duration','$days','$until_date','$repart','','$hotel_id','$create_as','6','$active','0','$entry_time','$entryby_id','$entryby_ip','$entry_time','$last_editby_id','$entryby_ip')";
            $result = $conn->query($sql);
            if($result){
                $last_id = $conn->insert_id;
                if($create_as == 'CREATE'){
                    $lenth_array  = sizeof($array_of_dates);
                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                            $sql_user = "SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                            $result_user = $conn->query($sql_user);
                            if ($result_user && $result_user->num_rows > 0) {
                                while($row_user = mysqli_fetch_array($result_user)) {
                                    if(!in_array($row_user['user_id'],$recipent_list_array)){
                                        $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$row_user[0],$last_id,'$final_store_date','0')";
                                        $result_alert = $conn->query($sql_alert);
                                    }
                                }
                            }
                        }
                    }

                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < $lenth_recipent; $x++) {
                            $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$recipent_list_array[$x],$last_id,'$final_store_date','0')";
                            $result_alert = $conn->query($sql_alert);

                        }




                    }
                }

                for ($x = 0; $x < $lenth_todo; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_checklist`(`tdl_id`, `checklist`) 
            VALUES ($last_id,'$todo_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_comment; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_comments`(`tdl_id`, `comment`) 
            VALUES ($last_id,'$comments_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_inspection; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_inspection`(`tdl_id`, `inspection`) 
            VALUES ($last_id,'$inspection_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }


                for ($x = 0; $x < sizeof($dep_array_id); $x++) {        
                    $sql1="INSERT INTO `tbl_todo_departments`(`tdl_id`,`depart_id`) VALUES ('$last_id','$dep_array_id[$x]')";
                    $result1 = $conn->query($sql1);


                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){

                        $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                        $result_user = $conn->query($sql_user);
                        if ($result_user && $result_user->num_rows > 0) {
                            while($row_user = mysqli_fetch_array($result_user)) {
                                if(!in_array($row_user['user_id'],$recipent_list_array)){
                                    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$row_user[0];','$last_id','tdl_id','tbl_todolist','$title Created','CREATE','$hotel_id','$entry_time')";
                                    $result_alert = $conn->query($sql_alert);


                                    $check_user = $row_user[0];
                                    //getUserToken
                                    $user_token  = "";
                                    $user_device = "";
                                    $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                                    $result_user_token = $conn->query($sql_user_token);
                                    if ($result_user_token && $result_user_token->num_rows > 0) {
                                        while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                            $user_token = $row_user_token['user_token'];
                                            $user_device = $row_user_token['login_as'];
                                        }
                                    }
                                    if($user_token != "" && $user_device == "ANDRIOD" ){
                                        //Notification for mobile
                                        array_push($send_notification_array, $user_token);
                                    }else if($user_token != "" && $user_device == "IOS"){
                                        array_push($ios_token_array, $user_token);
                                    }




                                }
                            }
                        }
                    }
                }
                for ($x = 0; $x < $lenth_recipent; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_recipents`(`tdl_id`, `user_id`,`is_completed`) 
            VALUES ($last_id,$recipent_list_array[$x],'0')";
                    $result1 = $conn->query($sql1);

                    if($create_as == 'CREATE'){
                        $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$recipent_list_array[$x]','$last_id','tdl_id','tbl_todolist','$title Created','CREATE','$hotel_id','$entry_time')";
                        $result_alert = $conn->query($sql_alert);


                        $check_user = $recipent_list_array[$x];
                        //getUserToken
                        $user_token  = "";
                        $user_device = "";
                        $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                        $result_user_token = $conn->query($sql_user_token);
                        if ($result_user_token && $result_user_token->num_rows > 0) {
                            while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                $user_token = $row_user_token['user_token'];
                                $user_device = $row_user_token['login_as'];
                            }
                        }
                        if($user_token != "" && $user_device == "ANDRIOD" ){
                            //Notification for mobile
                            array_push($send_notification_array, $user_token);
                        }else if($user_token != "" && $user_device == "IOS"){
                            array_push($ios_token_array, $user_token);
                        }
                    }

                }
                $title_send = "Todo/Checklist Created";
                $body_send = $title;
                sendFCM($send_notification_array,$title_send,$body_send);

                // this is only needed with php prior to 5.5.24
                if (!defined('CURL_HTTP_VERSION_2_0')) {
                    define('CURL_HTTP_VERSION_2_0', 3);
                }
                // open connection
                $http2ch = curl_init();
                curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
                // send push
                $payload1['aps'] = array(
                    'alert' => array(
                        'title' => $title_send,
                        'body' => $body_send,
                    ),
                    'sound' => 'default'
                );
                $message = json_encode($payload1);
                $http2_server = 'https://api.push.apple.com'; // or 'api.push.apple.com' if production
                $app_bundle_id = 'com.qualityfriend.arfasoftech';

                for ($x = 0; $x < sizeof($ios_token_array); $x++) {
                    $st = sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $ios_token_array[$x], $jws);
                }
                curl_close($http2ch);



                for ($x = 0; $x < $lenth_tour; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_tour`(`tdl_id`, `tour`) 
            VALUES ($last_id,'$tour_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                //checklist 
                $sql_check="SELECT `tdlclt_id` FROM `tbl_todolist_checklist` WHERE `tdl_id` = $last_id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        array_push($inserted_check_list_array,$row_check['tdlclt_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                        $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$recipent_list_array[$r]','$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }


                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }

                // inspection
                $sql_inspection="SELECT `tdlin_id` FROM `tbl_todolist_inspection` WHERE `tdl_id` =  $last_id";
                $result_inspection = $conn->query($sql_inspection);
                if ($result_inspection && $result_inspection->num_rows > 0) {
                    while($row_inspection = mysqli_fetch_array($result_inspection)) {
                        array_push($inserted_inspection_array,$row_inspection['tdlin_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($i = 0; $i < sizeof($inserted_inspection_array); $i++) {
                        $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`,`tdl_id`, `is_completed`) VALUES ('$inserted_inspection_array[$i]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }
                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_inspection_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_inspection_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }
                // tour
                $sql_tour="SELECT `tdltr_id` FROM `tbl_todolist_tour` WHERE `tdl_id` =  $last_id";
                $result_tour = $conn->query($sql_tour);
                if ($result_tour && $result_tour->num_rows > 0) {
                    while($row_tour = mysqli_fetch_array($result_tour)) {
                        array_push($inserted_tour_array,$row_tour['tdltr_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($t = 0; $t < sizeof($inserted_tour_array); $t++) {
                        $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$t]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_tour_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }

                for ($z = 0; $z < sizeof($attachments_url); $z++) {
                    $sql="INSERT INTO `tbl_todolist_attachment`( `tdl_id`, `attachment_url`, `user_id`) VALUES ('$last_id','$attachments_url[$z]', '$user_id')";
                    $result = $conn->query($sql);
                }

                if($create_as=="CREATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";

                }else if ($create_as=="DRAFT"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="TEMPLATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                else if ($create_as=="COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="NON_COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }

                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Todo/Checklist Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }

        }else if($language=='italian'){
            $sql="INSERT INTO `tbl_todolist`( `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `visibility_status`, `assign_recipient_status`, `due_date`, `repeat_status`, `day`, `repeat_until`, `no_of_repeat`, `tags`, `hotel_id`, `saved_status`, `status_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('','$title','','','$description','','$select_one','$assing','$due_date','$duration','$days','$until_date','$repart','','$hotel_id','$create_as','6','$active','0','$entry_time','$entryby_id','$entryby_ip','$entry_time','$last_editby_id','$entryby_ip')";
            $result = $conn->query($sql);
            if($result){
                $last_id = $conn->insert_id;
                if($create_as == 'CREATE'){
                    $lenth_array  = sizeof($array_of_dates);
                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                            $sql_user = "SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                            $result_user = $conn->query($sql_user);
                            if ($result_user && $result_user->num_rows > 0) {
                                while($row_user = mysqli_fetch_array($result_user)) {
                                    if(!in_array($row_user['user_id'],$recipent_list_array)){
                                        $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$row_user[0],$last_id,'$final_store_date','0')";
                                        $result_alert = $conn->query($sql_alert);
                                    }
                                }
                            }
                        }
                    }

                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < $lenth_recipent; $x++) {
                            $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$recipent_list_array[$x],$last_id,'$final_store_date','0')";
                            $result_alert = $conn->query($sql_alert);

                        }




                    }
                }
                for ($x = 0; $x < $lenth_todo; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_checklist`(`tdl_id`, `checklist_it`) 
            VALUES ($last_id,'$todo_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_comment; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_comments`(`tdl_id`, `comment`) 
            VALUES ($last_id,'$comments_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_inspection; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_inspection`(`tdl_id`, `inspection_it`) 
            VALUES ($last_id,'$inspection_list_array[$x]')";
                    $result1 = $conn->query($sql1);

                }



                for ($x = 0; $x < sizeof($dep_array_id); $x++) {        
                    $sql1="INSERT INTO `tbl_todo_departments`(`tdl_id`,`depart_id`) VALUES ('$last_id','$dep_array_id[$x]')";
                    $result1 = $conn->query($sql1);


                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){

                        $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                        $result_user = $conn->query($sql_user);
                        if ($result_user && $result_user->num_rows > 0) {
                            while($row_user = mysqli_fetch_array($result_user)) {
                                if(!in_array($row_user['user_id'],$recipent_list_array)){
                                    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$row_user[0];','$last_id','tdl_id','tbl_todolist','$title Created','CREATE','$hotel_id','$entry_time')";
                                    $result_alert = $conn->query($sql_alert);


                                    $check_user = $row_user[0];
                                    //getUserToken
                                    $user_token  = "";
                                    $user_device = "";
                                    $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                                    $result_user_token = $conn->query($sql_user_token);
                                    if ($result_user_token && $result_user_token->num_rows > 0) {
                                        while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                            $user_token = $row_user_token['user_token'];
                                            $user_device = $row_user_token['login_as'];
                                        }
                                    }
                                    if($user_token != "" && $user_device == "ANDRIOD" ){
                                        //Notification for mobile
                                        array_push($send_notification_array, $user_token);
                                    }else if($user_token != "" && $user_device == "IOS"){
                                        array_push($ios_token_array, $user_token);
                                    }




                                }
                            }
                        }
                    }

                }




                for ($x = 0; $x < $lenth_recipent; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_recipents`(`tdl_id`, `user_id`,`is_completed`) 
            VALUES ($last_id,'$recipent_list_array[$x]','0')";
                    $result1 = $conn->query($sql1);

                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){
                        $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$recipent_list_array[$x]','$last_id','tdl_id','tbl_todolist','$title Created','CREATE','$hotel_id','$entry_time')";
                        $result_alert = $conn->query($sql_alert);


                        $check_user = $recipent_list_array[$x];
                        //getUserToken
                        $user_token  = "";
                        $user_device = "";
                        $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                        $result_user_token = $conn->query($sql_user_token);
                        if ($result_user_token && $result_user_token->num_rows > 0) {
                            while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                $user_token = $row_user_token['user_token'];
                                $user_device = $row_user_token['login_as'];
                            }
                        }
                        if($user_token != "" && $user_device == "ANDRIOD" ){
                            //Notification for mobile
                            array_push($send_notification_array, $user_token);
                        }else if($user_token != "" && $user_device == "IOS"){
                            array_push($ios_token_array, $user_token);
                        }






                    }
                }
                $title_send = "Todo/Checklist Created";
                $body_send = $title;
                sendFCM($send_notification_array,$title_send,$body_send);

                // this is only needed with php prior to 5.5.24
                if (!defined('CURL_HTTP_VERSION_2_0')) {
                    define('CURL_HTTP_VERSION_2_0', 3);
                }
                // open connection
                $http2ch = curl_init();
                curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
                // send push
                $payload1['aps'] = array(
                    'alert' => array(
                        'title' => $title_send,
                        'body' => $body_send,
                    ),
                    'sound' => 'default'
                );
                $message = json_encode($payload1);
                $http2_server = 'https://api.push.apple.com'; // or 'api.push.apple.com' if production
                $app_bundle_id = 'com.qualityfriend.arfasoftech';

                for ($x = 0; $x < sizeof($ios_token_array); $x++) {
                    $st = sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $ios_token_array[$x], $jws);
                }
                curl_close($http2ch);



                for ($x = 0; $x < $lenth_tour; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_tour`(`tdl_id`, `tour_it`) 
            VALUES ($last_id,'$tour_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }

                //checklist
                $sql_check="SELECT `tdlclt_id` FROM `tbl_todolist_checklist` WHERE `tdl_id` = $last_id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        array_push($inserted_check_list_array,$row_check['tdlclt_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                        $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$recipent_list_array[$r]',$last_id,0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }

                // inspection
                $sql_inspection="SELECT `tdlin_id` FROM `tbl_todolist_inspection` WHERE `tdl_id` =  $last_id";
                $result_inspection = $conn->query($sql_inspection);
                if ($result_inspection && $result_inspection->num_rows > 0) {
                    while($row_inspection = mysqli_fetch_array($result_inspection)) {
                        array_push($inserted_inspection_array,$row_inspection['tdlin_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($i = 0; $i < sizeof($inserted_inspection_array); $i++) {
                        $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`,`tdl_id`, `is_completed`) VALUES ('$inserted_inspection_array[$i]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }
                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_inspection_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_inspection_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }

                // tour
                $sql_tour="SELECT `tdltr_id` FROM `tbl_todolist_tour` WHERE `tdl_id` =  $last_id";
                $result_tour = $conn->query($sql_tour);
                if ($result_tour && $result_tour->num_rows > 0) {
                    while($row_tour = mysqli_fetch_array($result_tour)) {
                        array_push($inserted_tour_array,$row_tour['tdltr_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($t = 0; $t < sizeof($inserted_tour_array); $t++) {
                        $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$t]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_tour_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }



                for ($z = 0; $z < sizeof($attachments_url); $z++) {
                    $sql="INSERT INTO `tbl_todolist_attachment`( `tdl_id`, `attachment_url`, `user_id`) VALUES ('$last_id','$attachments_url[$z]', '$user_id')";
                    $result = $conn->query($sql);
                }
                if($create_as=="CREATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";

                }else if ($create_as=="DRAFT"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="TEMPLATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                else if ($create_as=="COMPLETE_TODO"){
                    echo '4';
                } else if ($create_as   =="NON_COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Todo/Checklist Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
        }
        else if($language=='german'){
            $sql="INSERT INTO `tbl_todolist`( `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `visibility_status`, `assign_recipient_status`, `due_date`, `repeat_status`, `day`, `repeat_until`, `no_of_repeat`, `tags`, `hotel_id`, `saved_status`, `status_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('','','$title','','','$description','$select_one','$assing','$due_date','$duration','$days','$until_date','$repart','','$hotel_id','$create_as','6','$active','0','$entry_time','$entryby_id','$entryby_ip','$entry_time','$last_editby_id','$entryby_ip')";
            $result = $conn->query($sql);
            if($result){
                $last_id = $conn->insert_id;
                if($create_as == 'CREATE'){
                    $lenth_array  = sizeof($array_of_dates);
                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                            $sql_user = "SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                            $result_user = $conn->query($sql_user);
                            if ($result_user && $result_user->num_rows > 0) {
                                while($row_user = mysqli_fetch_array($result_user)) {
                                    if(!in_array($row_user['user_id'],$recipent_list_array)){
                                        $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$row_user[0],$last_id,'$final_store_date','0')";
                                        $result_alert = $conn->query($sql_alert);
                                    }
                                }
                            }
                        }
                    }

                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < $lenth_recipent; $x++) {
                            $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$recipent_list_array[$x],$last_id,'$final_store_date','0')";
                            $result_alert = $conn->query($sql_alert);

                        }




                    }
                }
                for ($x = 0; $x < $lenth_todo; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_checklist`(`tdl_id`, `checklist_de`) 
            VALUES ($last_id,'$todo_list_array[$x]')";
                    $result1 = $conn->query($sql1);

                }
                for ($x = 0; $x < $lenth_comment; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_comments`(`tdl_id`, `comment`) 
            VALUES ($last_id,'$comments_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_inspection; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_inspection`(`tdl_id`, `inspection_de`) 
            VALUES ($last_id,'$inspection_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }



                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql1="INSERT INTO `tbl_todo_departments`(`tdl_id`,`depart_id`) VALUES ('$last_id','$dep_array_id[$x]')";
                    $result1 = $conn->query($sql1);


                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){

                        $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                        $result_user = $conn->query($sql_user);
                        if ($result_user && $result_user->num_rows > 0) {
                            while($row_user = mysqli_fetch_array($result_user)) {
                                if(!in_array($row_user['user_id'],$recipent_list_array)){
                                    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$row_user[0];','$last_id','tdl_id','tbl_todolist','$title Created','CREATE','$hotel_id','$entry_time')";
                                    $result_alert = $conn->query($sql_alert);


                                    $check_user = $row_user[0];
                                    //getUserToken
                                    $user_token  = "";
                                    $user_device = "";
                                    $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                                    $result_user_token = $conn->query($sql_user_token);
                                    if ($result_user_token && $result_user_token->num_rows > 0) {
                                        while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                            $user_token = $row_user_token['user_token'];
                                            $user_device = $row_user_token['login_as'];
                                        }
                                    }
                                    if($user_token != "" && $user_device == "ANDRIOD" ){
                                        //Notification for mobile
                                        array_push($send_notification_array, $user_token);
                                    }else if($user_token != "" && $user_device == "IOS"){
                                        array_push($ios_token_array, $user_token);
                                    }




                                }
                            }
                        }
                    }

                }


                for ($x = 0; $x < $lenth_recipent; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_recipents`(`tdl_id`, `user_id`,`is_completed`) 
            VALUES ($last_id,'$recipent_list_array[$x]','0')";
                    $result1 = $conn->query($sql1);
                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){
                        $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$recipent_list_array[$x]','$last_id','tdl_id','tbl_todolist','$title Created','CREATE','$hotel_id','$entry_time')";
                        $result_alert = $conn->query($sql_alert);


                        $check_user = $recipent_list_array[$x];
                        //getUserToken
                        $user_token  = "";
                        $user_device = "";
                        $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                        $result_user_token = $conn->query($sql_user_token);
                        if ($result_user_token && $result_user_token->num_rows > 0) {
                            while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                $user_token = $row_user_token['user_token'];
                                $user_device = $row_user_token['login_as'];
                            }
                        }
                        if($user_token != "" && $user_device == "ANDRIOD" ){
                            //Notification for mobile
                            array_push($send_notification_array, $user_token);
                        }else if($user_token != "" && $user_device == "IOS"){
                            array_push($ios_token_array, $user_token);
                        }
                    }

                }


                $title_send = "Todo/Checklist Created";
                $body_send = $title;
                sendFCM($send_notification_array,$title_send,$body_send);


                // this is only needed with php prior to 5.5.24
                if (!defined('CURL_HTTP_VERSION_2_0')) {
                    define('CURL_HTTP_VERSION_2_0', 3);
                }
                // open connection
                $http2ch = curl_init();
                curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
                // send push
                $payload1['aps'] = array(
                    'alert' => array(
                        'title' => $title_send,
                        'body' => $body_send,
                    ),
                    'sound' => 'default'
                );
                $message = json_encode($payload1);
                $http2_server = 'https://api.push.apple.com'; // or 'api.push.apple.com' if production
                $app_bundle_id = 'com.qualityfriend.arfasoftech';

                for ($x = 0; $x < sizeof($ios_token_array); $x++) {
                    $st = sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $ios_token_array[$x], $jws);
                }
                curl_close($http2ch);


                for ($x = 0; $x < $lenth_tour; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_tour`(`tdl_id`, `tour_de`) 
            VALUES ($last_id,'$tour_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                //checklist
                $sql_check="SELECT `tdlclt_id` FROM `tbl_todolist_checklist` WHERE `tdl_id` = $last_id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        array_push($inserted_check_list_array,$row_check['tdlclt_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                        $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$recipent_list_array[$r]','$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }
                // inspection
                $sql_inspection="SELECT `tdlin_id` FROM `tbl_todolist_inspection` WHERE `tdl_id` =  $last_id";
                $result_inspection = $conn->query($sql_inspection);
                if ($result_inspection && $result_inspection->num_rows > 0) {
                    while($row_inspection = mysqli_fetch_array($result_inspection)) {
                        array_push($inserted_inspection_array,$row_inspection['tdlin_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($i = 0; $i < sizeof($inserted_inspection_array); $i++) {
                        $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`,`tdl_id`, `is_completed`) VALUES ('$inserted_inspection_array[$i]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }
                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_inspection_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_inspection_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }
                // tour
                $sql_tour="SELECT `tdltr_id` FROM `tbl_todolist_tour` WHERE `tdl_id` =  $last_id";
                $result_tour = $conn->query($sql_tour);
                if ($result_tour && $result_tour->num_rows > 0) {
                    while($row_tour = mysqli_fetch_array($result_tour)) {
                        array_push($inserted_tour_array,$row_tour['tdltr_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($t = 0; $t < sizeof($inserted_tour_array); $t++) {
                        $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$t]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_tour_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$c]','$get_user','$last_id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }
                for ($z = 0; $z < sizeof($attachments_url); $z++) {
                    $sql="INSERT INTO `tbl_todolist_attachment`( `tdl_id`, `attachment_url`, `user_id`) VALUES ('$last_id','$attachments_url[$z]', '$user_id')";
                    $result = $conn->query($sql);
                }
                if($create_as=="CREATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";

                }else if ($create_as=="DRAFT"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="TEMPLATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                else if ($create_as=="COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="NON_COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Todo/Checklist Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);

            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
            }
        }


        else if($language=='TEMPLATE'){
            $sql="INSERT INTO `tbl_todolist`( `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `visibility_status`, `assign_recipient_status`, `due_date`, `repeat_status`, `day`, `repeat_until`, `no_of_repeat`, `tags`, `hotel_id`, `saved_status`, `status_id`, `is_active`, `is_delete`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$title','$title_it','$title_de','$description','$description_it','$description_de','$select_one','$assing','$due_date','$duration','$days','$until_date','$repart','','$hotel_id','$create_as','6','$active_id','0','$entry_time','$entryby_id','$entryby_ip','$entry_time','$last_editby_id','$entryby_ip')";
            $result = $conn->query($sql);
            if($result){



                $last_id = $conn->insert_id;
                for ($x = 0; $x < $lenth_todo; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_checklist`(`tdl_id`, `checklist`, `checklist_it`, `checklist_de`) 
            VALUES ('$last_id',`$todo_list_array[$x]`,`$todo_list_array_it[$x]`,`$todo_list_array_de[$x]`)";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_comment; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_comments`(`tdl_id`, `comment`) 
            VALUES ('$last_id',`$comments_list_array[$x]`)";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_inspection; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_inspection`(`tdl_id`,`inspection`,`inspection_it`,`inspection_de`) 
            VALUES ('$last_id',`$inspection_list_array[$x]`,`$inspection_list_array_it[$x]`,`$inspection_list_array_de[$x]`)";
                    $result1 = $conn->query($sql1);
                }
                for ($x = 0; $x < $lenth_recipent; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_recipents`(`tdl_id`, `user_id`,`is_completed`) 
            VALUES ('$last_id','$recipent_list_array[$x]','0')";
                    $result1 = $conn->query($sql1);


                }
                for ($x = 0; $x < $lenth_tour; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_tour`(`tdl_id`,`tour`, `tour_it`, `tour_de`) 
            VALUES ('$last_id',`$tour_list_array[$x]`,`$tour_list_array_it[$x]`,`$tour_list_array_de[$x]`)";
                    $result1 = $conn->query($sql1);
                }
                //checklist
                $sql_check="SELECT `tdlclt_id` FROM `tbl_todolist_checklist` WHERE `tdl_id` = $last_id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        array_push($inserted_check_list_array,$row_check['tdlclt_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                        $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$recipent_list_array[$r]','$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }
                // inspection
                $sql_inspection="SELECT `tdlin_id` FROM `tbl_todolist_inspection` WHERE `tdl_id` =  $last_id";
                $result_inspection = $conn->query($sql_inspection);
                if ($result_inspection && $result_inspection->num_rows > 0) {
                    while($row_inspection = mysqli_fetch_array($result_inspection)) {
                        array_push($inserted_inspection_array,$row_inspection['tdlin_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($i = 0; $i < sizeof($inserted_inspection_array); $i++) {
                        $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`,`tdl_id`, `is_completed`) VALUES ('$inserted_inspection_array[$i]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }
                // tour
                $sql_tour="SELECT `tdltr_id` FROM `tbl_todolist_tour` WHERE `tdl_id` =  $last_id";
                $result_tour = $conn->query($sql_tour);
                if ($result_tour && $result_tour->num_rows > 0) {
                    while($row_tour = mysqli_fetch_array($result_tour)) {
                        array_push($inserted_tour_array,$row_tour['tdltr_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($t = 0; $t < sizeof($inserted_tour_array); $t++) {
                        $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$t]',$recipent_list_array[$r],'$last_id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }
                if($create_as=="CREATE"){
                    echo '1';

                }else if ($create_as=="DRAFT"){
                    echo '2';
                } else if ($create_as   =="TEMPLATE"){
                    echo '3';
                }
                else if ($create_as=="COMPLETE_TODO"){
                    echo '4';
                } else if ($create_as   =="NON_COMPLETE_TODO"){
                    echo '5';
                }

                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title  Todo/Checklist Template Create','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }else{
                echo "Error";
            }
        }
        else{

            $sql_alert_del="UPDATE `tbl_alert` SET `is_delete`= 1 WHERE `id_table_name` = 'tbl_todolist' AND `hotel_id` = $hotel_id  AND `alert_type` = 'UPDATE' AND `id` = $id";
            $result_alert_del = $conn->query($sql_alert_del);
            $sql="UPDATE `tbl_todolist` SET `title`='$title',`title_it`='$title_it',`title_de`='$title_de',`description`='$description',`description_it`='$description_it',`description_de`='$description_de',`visibility_status`='$select_one',`assign_recipient_status`='$assing',`due_date`='$due_date',`repeat_status`='$duration',`day`='$days',`repeat_until`='$until_date',`no_of_repeat`='$repart',`saved_status`='$create_as',`is_active`='$active',`edittime`='$last_edit_time',`editbyid`='$last_editby_id',`editbyip`='$last_editby_ip' WHERE   `tdl_id` = $id";
            $result = $conn->query($sql);
            if($result){


                if($title != ""){
                    $title = $title;
                }else if($title_it != ""){
                    $title = $title_it;
                }else if($title_de != ""){
                    $title_de = $title_de;
                }
                $recipent_userid_array = array();
                $recipent_iscompleate_array = array();
                $recipent_priority_array =  array();

                $sql_tour="SELECT * FROM `tbl_todolist_recipents` WHERE `tdl_id` =  $id";
                $result_tour = $conn->query($sql_tour);
                if ($result_tour && $result_tour->num_rows > 0) {
                    while($row_tour = mysqli_fetch_array($result_tour)) {
                        array_push($recipent_userid_array,$row_tour['user_id']);
                        array_push($recipent_iscompleate_array,$row_tour['is_completed']);
                        array_push($recipent_priority_array,$row_tour['priority']);

                    }
                }



                $iscompleate_array_len = sizeof($recipent_iscompleate_array);
                $sql_d="DELETE FROM `tbl_todolist_recipents` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d = "DELETE FROM `tbl_todo_departments` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_checklist` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_inspection` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_tour` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_comments` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_checklist_user_map` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_inspection_user_map` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todolist_tour_user_map` WHERE `tdl_id` = $id";
                $result_d = $conn->query($sql_d);
                $sql_d="DELETE FROM `tbl_todo_notification` WHERE `tdl_id` =  $id";
                $result_d = $conn->query($sql_d);
                
                
                $sql_d3="DELETE FROM `tbl_todolist_attachment` WHERE `tdl_id` =  $id";
                $result_d3 = $conn->query($sql_d3);



                if($create_as == 'CREATE'){
                    $lenth_array  = sizeof($array_of_dates);
                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                            $sql_user = "SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                            $result_user = $conn->query($sql_user);
                            if ($result_user && $result_user->num_rows > 0) {
                                while($row_user = mysqli_fetch_array($result_user)) {
                                    if(!in_array($row_user['user_id'],$recipent_list_array)){
                                        $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$row_user[0],$id,'$final_store_date','0')";
                                        $result_alert = $conn->query($sql_alert);
                                    }
                                }
                            }
                        }
                    }

                    for($y = 0; $y < $lenth_array; $y++){
                        $final_store_date = date("Y-m-d", strtotime($array_of_dates[$y]));
                        for ($x = 0; $x < $lenth_recipent; $x++) {
                            $sql_alert="INSERT INTO `tbl_todo_notification`( `hotel_id`, `user_id`, `tdl_id`, `date`,`is_view`) VALUES ($hotel_id,$recipent_list_array[$x],$id,'$final_store_date','0')";
                            $result_alert = $conn->query($sql_alert);

                        }
                    }
                }


                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql1="INSERT INTO `tbl_todo_departments`(`tdl_id`,`depart_id`) VALUES ($id,'$dep_array_id[$x]')";
                    $result1 = $conn->query($sql1);
                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){
                        $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                        $result_user = $conn->query($sql_user);
                        if ($result_user && $result_user->num_rows > 0) {
                            while($row_user = mysqli_fetch_array($result_user)) {
                                if(!in_array($row_user['user_id'],$recipent_list_array)){


                                    $priority = 0;
                                    $completed = 0;
                                    for ($y = 0; $y < $iscompleate_array_len; $y++) {
                                        if($recipent_userid_array[$y] == $row_user[0]){
                                            if($recipent_iscompleate_array[$y] == 1 ){
                                                $completed = 1;
                                            }
                                            if($recipent_priority_array[$y] == 1 ){
                                                $priority  =  1;
                                            }

                                        }
                                    }


                                    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$row_user[0]','$id','tdl_id','tbl_todolist','$title Updated','UPDATE','$hotel_id','$entry_time')";
                                    $result_alert = $conn->query($sql_alert);



                                    $check_user = $row_user[0];
                                    //getUserToken
                                    $user_token  = "";
                                    $user_device = "";
                                    $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                                    $result_user_token = $conn->query($sql_user_token);
                                    if ($result_user_token && $result_user_token->num_rows > 0) {
                                        while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                            $user_token = $row_user_token['user_token'];
                                            $user_device = $row_user_token['login_as'];
                                        }
                                    }
                                    if($user_token != "" && $user_device == "ANDRIOD" ){
                                        //Notification for mobile
                                        array_push($send_notification_array, $user_token);
                                    }else if($user_token != "" && $user_device == "IOS"){
                                        array_push($ios_token_array, $user_token);
                                    }
                                }
                            }
                        }
                    }
                }




                $priority = 0;
                for ($x = 0; $x <$lenth_recipent; $x++) {
                    $completed = 0;
                    for ($y = 0; $y < $iscompleate_array_len; $y++) {
                        if($recipent_userid_array[$y] == $recipent_list_array[$x]){
                            if($recipent_iscompleate_array[$y] == 1 ){
                                $completed = 1;
                            }
                            if($recipent_priority_array[$y] == 1 ){
                                $priority  =  1;
                            }

                        }
                    }
                    $sql1="INSERT INTO `tbl_todolist_recipents`(`tdl_id`, `user_id`,is_completed,`priority`) 
                            VALUES ('$id','$recipent_list_array[$x]','$completed',$priority)";
                    $result1 = $conn->query($sql1);

                    if($create_as == 'CREATE' && $select_one != "PRIVATE"){

                        $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$recipent_list_array[$x]','$id','tdl_id','tbl_todolist','$title Updated','UPDATE','$hotel_id','$entry_time',$priority)";
                        $result_alert = $conn->query($sql_alert);



                        $check_user = $recipent_list_array[$x];
                        //getUserToken
                        $user_token  = "";
                        $user_device = "";
                        $sql_user_token="SELECT `user_token`,`login_as` FROM `tbl_user` WHERE `user_id` =  $check_user";
                        $result_user_token = $conn->query($sql_user_token);
                        if ($result_user_token && $result_user_token->num_rows > 0) {
                            while($row_user_token = mysqli_fetch_array($result_user_token)) {
                                $user_token = $row_user_token['user_token'];
                                $user_device = $row_user_token['login_as'];
                            }
                        }
                        if($user_token != "" && $user_device == "ANDRIOD" ){
                            //Notification for mobile
                            array_push($send_notification_array, $user_token);
                        }else if($user_token != "" && $user_device == "IOS"){
                            array_push($ios_token_array, $user_token);
                        }
                    }

                }

                $title_send = "Todo/Checklist Updated";
                $body_send = $title;
                sendFCM($send_notification_array,$title_send,$body_send);


                // this is only needed with php prior to 5.5.24
                if (!defined('CURL_HTTP_VERSION_2_0')) {
                    define('CURL_HTTP_VERSION_2_0', 3);
                }
                // open connection
                $http2ch = curl_init();
                curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
                // send push
                $payload1['aps'] = array(
                    'alert' => array(
                        'title' => $title_send,
                        'body' => $body_send,
                    ),
                    'sound' => 'default'
                );
                $message = json_encode($payload1);
                $http2_server = 'https://api.push.apple.com'; // or 'api.push.apple.com' if production
                $app_bundle_id = 'com.qualityfriend.arfasoftech';

                for ($x = 0; $x < sizeof($ios_token_array); $x++) {
                    $st = sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $ios_token_array[$x], $jws);
                }
                curl_close($http2ch);


                for ($x = 0; $x < $lenth_todo; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_checklist`(`tdl_id`, `checklist`, `checklist_it`, `checklist_de`) 
                    VALUES ($id,'$todo_list_array[$x]','$todo_list_array_it[$x]','$todo_list_array_de[$x]')";
                    $result1 = $conn->query($sql1);


                }

                for ($x = 0; $x < $lenth_inspection; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_inspection`(`tdl_id`, `inspection`, `inspection_it`, `inspection_de`) 
                    VALUES ($id,'$inspection_list_array[$x]','$inspection_list_array_it[$x]','$inspection_list_array_de[$x]')";
                    $result1 = $conn->query($sql1);
                }

                for ($x = 0; $x < $lenth_tour; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_tour`(`tdl_id`, `tour`, `tour_it`, `tour_de`) 
                    VALUES ($id,'$tour_list_array[$x]','$tour_list_array_it[$x]','$tour_list_array_de[$x]')";
                    $result1 = $conn->query($sql1);
                }

                for ($x = 0; $x < $lenth_comment; $x++) {
                    $sql1="INSERT INTO `tbl_todolist_comments`(`tdl_id`, `comment`) 
                    VALUES ($id,'$comments_list_array[$x]')";
                    $result1 = $conn->query($sql1);
                }
                //checklist
                $sql_check="SELECT `tdlclt_id` FROM `tbl_todolist_checklist` WHERE `tdl_id` = $id";
                $result_check = $conn->query($sql_check);
                if ($result_check && $result_check->num_rows > 0) {
                    while($row_check = mysqli_fetch_array($result_check)) {
                        array_push($inserted_check_list_array,$row_check['tdlclt_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($c = 0; $c < sizeof($inserted_check_list_array); $c++) {
                        $sql1="INSERT INTO `tbl_todolist_checklist_user_map`( `tdlclt_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_check_list_array[$c]','$recipent_list_array[$r]','$id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }


                // inspection
                $sql_inspection="SELECT `tdlin_id` FROM `tbl_todolist_inspection` WHERE `tdl_id` =  $id";
                $result_inspection = $conn->query($sql_inspection);
                if ($result_inspection && $result_inspection->num_rows > 0) {
                    while($row_inspection = mysqli_fetch_array($result_inspection)) {
                        array_push($inserted_inspection_array,$row_inspection['tdlin_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($i = 0; $i < sizeof($inserted_inspection_array); $i++) {
                        $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`,`tdl_id`, `is_completed`) VALUES ('$inserted_inspection_array[$i]',$recipent_list_array[$r],'$id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_inspection_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_inspection_user_map`( `tdlin_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_inspection_array[$c]','$get_user','$id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }

                // tour
                $sql_tour="SELECT `tdltr_id` FROM `tbl_todolist_tour` WHERE `tdl_id` =  $id";
                $result_tour = $conn->query($sql_tour);
                if ($result_tour && $result_tour->num_rows > 0) {
                    while($row_tour = mysqli_fetch_array($result_tour)) {
                        array_push($inserted_tour_array,$row_tour['tdltr_id']);

                    }
                }
                for ($r = 0; $r < $lenth_recipent; $r++) {
                    for ($t = 0; $t < sizeof($inserted_tour_array); $t++) {
                        $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$t]',$recipent_list_array[$r],'$id',0)";
                        $result1 = $conn->query($sql1);
                    }
                }

                for ($x = 0; $x < sizeof($dep_array_id); $x++) {
                    $sql_user="SELECT * FROM `tbl_user` WHERE `depart_id` = $dep_array_id[$x]";
                    $result_user = $conn->query($sql_user);
                    if ($result_user && $result_user->num_rows > 0) {
                        while($row_user1 = mysqli_fetch_array($result_user)) {
                            if(!in_array($row_user1['user_id'],$recipent_list_array)){
                                $get_user = $row_user1[0];
                                for ($c = 0; $c < sizeof($inserted_tour_array); $c++) {
                                    $sql1="INSERT INTO `tbl_todolist_tour_user_map`( `tdltr_id`, `user_id`, `tdl_id`,`is_completed`) VALUES ('$inserted_tour_array[$c]','$get_user','$id',0)";
                                    $result1 = $conn->query($sql1);
                                }
                            }
                        }
                    }


                }


                for ($z = 0; $z < sizeof($attachments_url); $z++) {
                    $sql="INSERT INTO `tbl_todolist_attachment`( `tdl_id`, `attachment_url`, `user_id`) VALUES ('$id','$attachments_url[$z]', '$user_id')";
                    $result = $conn->query($sql);
                }
                if($create_as=="CREATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";

                }else if ($create_as=="DRAFT"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="TEMPLATE"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                else if ($create_as=="COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                } else if ($create_as   =="NON_COMPLETE_TODO"){
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Successful";
                }
                $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$title Todo/Checklist Updated','$hotel_id','$entry_time')";
                $result_log = $conn->query($sql_log);
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Something Bad Happend!!!";
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