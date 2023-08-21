<?php
require_once 'vendor/autoload.php';
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $data = array();
    $temp1=array();
    $first_name = "";
    $first_name = $_POST['first_name'];
    $hotel_id = $_POST['hotel_id'];
    $user_id = $_POST['user_id'];
    $tablename = $_POST['tablename'];
    $idname = $_POST['idname'];
    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $entry_time=date("Y-m-d H:i:s");

    $comment_table = $tablename."_comments";
    $recipents_table = $tablename."_recipents";

    if($tablename == "tbl_todolist"){
        $comment_table = $comment_table."_user";
    }




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


    $q="INSERT INTO `$comment_table`($idname, `comment`, `comment_by`, `is_delete`, `entrytime`) VALUES ('$id','$comment','$user_id','0','$entry_time')";
    $stmt=$conn->query($q);

    if($stmt){

        $title = "";
        $created_by = "";
        $sql_user="SELECT * FROM $tablename WHERE $idname = $id";
        $result_user = $conn->query($sql_user);
        if ($result_user && $result_user->num_rows > 0) {
            while($row = mysqli_fetch_array($result_user)) {
                if(isset($row['title'])){
                    if($row['title'] != ""){
                        $title = $row['title']; 
                    }
                    else if($row['title_it'] != ""){
                        $title = $row['title_it']; 
                    } else{
                        $title = $row['title_de']; 
                    }
                }else if(isset($row['firstname'])){
                    $title = $row['firstname'];   
                }else{
                    $title = "";
                }
                $created_by = $row['entrybyid'];

            }
        }
        $user_id_array =  array();
        array_push($user_id_array, $created_by);
        $sql_user_token="SELECT * FROM `tbl_user` WHERE `usert_id` = 1 AND `hotel_id` = $hotel_id";
        $result_user_token = $conn->query($sql_user_token);
        if ($result_user_token && $result_user_token->num_rows > 0) {
            while($row_user= mysqli_fetch_array($result_user_token)) {
                $user_ids = $row_user['user_id'];
                array_push($user_id_array, $user_ids);
            }
        }
        //sentnotification
        $user_token  = "";
        $user_id = "";
        $send_notification_array =  array();
        $ios_token_array =  array();
        $sql_get_recipent="SELECT * FROM $recipents_table WHERE $idname =  $id";
        $result_get_recipent = $conn->query($sql_get_recipent);
        if ($result_get_recipent && $result_get_recipent->num_rows > 0) {
            while($row_get_recipent = mysqli_fetch_array($result_get_recipent)) {
                $user_id = $row_get_recipent['user_id'];
                array_push($user_id_array, $user_id);

            }
        }
        $filterd_users = array_unique($user_id_array);
        $filterd_users = array_values($filterd_users);




        for($i = 0; $i < sizeof($filterd_users); $i++) {
            $check_user = $filterd_users[$i];
            $priority = 0; 
            //getpoerity
            $sql_get_recipent_p="SELECT * FROM $recipents_table WHERE $idname =  $id and user_id = $check_user";
            $result_get_recipent_p = $conn->query($sql_get_recipent_p);
            if ($result_get_recipent_p && $result_get_recipent_p->num_rows > 0) {
                while($row_get_recipent_p = mysqli_fetch_array($result_get_recipent_p)) {
                    $priority = $row_get_recipent_p['priority'];

                }
            }


            $alert_msg = $first_name." Comment on ".$title;
            $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`,`priority`) VALUES ('$check_user','$id','$idname','$tablename','$alert_msg','COMMENT','$hotel_id','$entry_time',$priority)";
            $result_alert = $conn->query($sql_alert);
            //getUserToken
            $user_token  = "";
            $user_device = "";
            $sql_user_token="SELECT * FROM `tbl_user` WHERE `user_id` =  $check_user";
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

        $tablename = explode("_",$tablename);
        $title_send = $first_name." Comment on ".$title.' in '.ucfirst($tablename[1]); 
        $body_send =  $comment; 
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
            'category' => 'COMMENTS',
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


        $text_log = 'Comment Added in '.$title.' '.ucfirst($tablename[1]);

        $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','$text_log','$hotel_id','$entry_time')";
        $result_log = $conn->query($sql_log);

        $temp1=array();
        $temp1['flag'] = 1;
        $temp1['message'] = "Saved";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{ 
        $temp1=array();
        $temp1['flag'] = 0;
        $temp1['message'] = "Not Save";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    } 

}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>