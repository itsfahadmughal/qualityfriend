<?php 
require_once 'vendor/autoload.php';
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $mrtitle="";
    $first_name="";
    $last_name="";
    $email="";
    $phone="";
    $department_id="";
    $job_id="";
    $message="";
    $application_time =date("Y-m-d H:i:s");
    $status_id = 6;
    $is_active_user = 2;
    $is_delete = 0;
    $img_url= "";
    $cv_url= "";
    $sql="";
    $comments = "";
    $dob = "";
    $tags = "";
    $start_working_time = "";
    $end_working_time = "";
    $dob_place = "";
    $tax_number = "";
    $hotel_id = 0;
    $user_id = 0;


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

    $data = array();
    $temp1=array();

    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }
    if(isset($_POST['mrtitle'])){
        $mrtitle=$_POST['mrtitle'];
    }
    if(isset($_POST['first_name'])){
        $first_name=str_replace("'","`",$_POST['first_name']);
    }
    if(isset($_POST['last_name'])){
        $last_name=str_replace("'","`",$_POST['last_name']);
    }
    if(isset($_POST['email'])){
        $email=$_POST['email'];
    }
    if(isset($_POST['phone'])){
        $phone=$_POST['phone'];
    }
    if(isset($_POST['department_id'])){
        $department_id=$_POST['department_id'];
    }
    if(isset($_POST['job_id'])){
        $job_id=$_POST['job_id'];
    }
    if(isset($_POST['dob'])){
        $dob=$_POST['dob'];
    }
    if(isset($_POST['message'])){
        $message=str_replace("'","`",$_POST['message']);
    }
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
    }

    if(isset($_POST['img_url'])){
        $img_url=$_POST['img_url'];
    }
    if(isset($_POST['cv_url'])){
        $cv_url=$_POST['cv_url'];
    }

    $entryby_id=$user_id;
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_id=$user_id;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");


    $sql="INSERT INTO `tbl_applicants_employee`( `hotel_id`,`crjb_id`, `title`, `name`, `surname`, `email`, `phone`, `resume_url`, `image_url`, `message`, `depart_id_app`, `depart_id_emp`, `dob`, `dob_place`, `tax_number`, `application_time`, `start_working_time`, `end_working_time`, `status_id`, `is_active_user`, `is_delete`, `tags`, `comments`, `entrytime`, `entrybyid`, `entrybyip`, `edittime`, `editbyid`, `editbyip`) VALUES ('$hotel_id','$job_id','$mrtitle','$first_name','$last_name','$email','$phone','$cv_url','$img_url','$message','$department_id','$department_id','$dob','$dob_place','$tax_number','$application_time','$start_working_time','$end_working_time','$status_id','$is_active_user','$is_delete','$tags','$comments','$entry_time','$entryby_id','$entryby_ip','$last_edit_time','$last_editby_id','$last_editby_ip')";
    $result = $conn->query($sql);
    if($result){
        $last_id = $conn->insert_id;


        $title ="";
        $sql_sub33="SELECT * FROM `tbl_create_job` WHERE `crjb_id` = $job_id";
        $result_sub33 = $conn->query($sql_sub33);
        $row_sub33 = mysqli_fetch_array($result_sub33);
        if(isset($row_sub33['title'])){
            if($row_sub33['title'] != ""){
                $title =  $row_sub33['title'];
            }else if($row_sub33['title_it'] != ""){
                $title =  $row_sub33['title_it'];
            }else{
                $title =  $row_sub33['title_de'];
            }

        }

        //getUserToken
        $user_token  = "";
        $user_id = "";
        $user_device = "";
        $send_notification_array =  array();
        $ios_token_array= array();
        $sql_user_token="SELECT * FROM `tbl_user` WHERE `usert_id` = 1 AND `hotel_id` = $hotel_id";
        $result_user_token = $conn->query($sql_user_token);
        if ($result_user_token && $result_user_token->num_rows > 0) {
            while($row_user_token = mysqli_fetch_array($result_user_token)) {
                $user_token = $row_user_token['user_token'];
                $user_id = $row_user_token['user_id'];
                $user_device = $row_user_token['login_as'];

                if($user_token != "" && $user_device == "ANDRIOD" ){
                    //Notification for mobile
                    array_push($send_notification_array, $user_token);
                }else if($user_token != "" && $user_device == "IOS"){
                    array_push($ios_token_array, $user_token);
                }

                $aleart_msg = $first_name." Applied in ".$title; 
                $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$user_id','$last_id','tae_id','tbl_applicants_employee','$aleart_msg','CREATE','$hotel_id','$entry_time')";
                $result_alert = $conn->query($sql_alert);

            }
        }
        $title_send = "New Applicant";
        $body_send =  $first_name." Applied in ".$title; ;
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
            'category' => 'JOB',
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



        $temp1['flag'] = 1;
        $temp1['message'] = "Successful";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Something Bad Happend!!!";
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