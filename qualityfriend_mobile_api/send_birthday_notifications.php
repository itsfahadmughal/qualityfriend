<?php 
require_once 'vendor/autoload.php';
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $n = $nn = 0;
    $data = array();
    $ios_token_array= array();

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

    $send_notification_array= array();

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
    $date = date('m-d', strtotime('+3 day', time()));
    $date_current = date("m-d");
    $date_current1 = date("Y-m-d");
    $body_send ="";
    //getUserToken
    $user_token  = "";
    $name  = "";
    $user_device = "";
    $hotel_id = "";
    $name_employee="";
    $entry_time = date("Y-m-d H:i:s");
    $sql_dob="SELECT * FROM `tbl_applicants_employee` WHERE `dob` like '%$date' OR `dob` like '%$date_current'";
    $result_dob = $conn->query($sql_dob);
    if ($result_dob && $result_dob->num_rows > 0) {
        while($row_dob = mysqli_fetch_array($result_dob)) {
            $hotel_id  = $row_dob['hotel_id'];
            $dob  = $row_dob['dob'];
            $hotel_lang = "EN";
            if($n==0){
                $name_employee = $row_dob['name'];
            }

            $sql_lang="SELECT hotel_language FROM `tbl_hotel` WHERE hotel_id = $hotel_id";
            $result_lang = $conn->query($sql_lang);
            if ($result_lang && $result_lang->num_rows > 0) {
                while($row_lang = mysqli_fetch_array($result_lang)) {
                    $hotel_lang = $row_lang['hotel_language'];
                }
            }

if($name_employee != $row_dob['name'] || $n == 0){

            $sql_user_token="SELECT a.* FROM `tbl_user` as a INNER JOIN tbl_rules as b on a.usert_id = b.usert_id Where a.hotel_id = $hotel_id AND b.rule_11 = 1";
            $result_user_token = $conn->query($sql_user_token);
            if ($result_user_token && $result_user_token->num_rows > 0) {
                while($row_user_token = mysqli_fetch_array($result_user_token)) {
                    $user_id = $row_user_token['user_id'];
                    $user_token = $row_user_token['user_token'];
                    $user_device = $row_user_token['login_as'];
                    $last_id = $row_dob['tae_id'];

                    $date1 = strtotime($dob);
                    $date2 = strtotime($date_current1);
                    $diff = abs($date2 - $date1);
                    $years = floor($diff / (365*60*60*24));

                    if($hotel_lang == "IT"){
                        $title = "Dipendente Compleanno!";
                        $alert_msg = $row_dob['name']." ha il ".date("d.m.", strtotime($dob)).' il '.$years." compleanno.";
                    }else if($hotel_lang == "DE"){
                        $title = "Mitarbeiter Geburtstag!";
                        $alert_msg = $row_dob['name']." hat am ".date("d.m.", strtotime($dob)).' seinen '.$years.". Geburtstag.";
                    }else{
                        $title = "Employee Birthday!";
                        $alert_msg = $row_dob['name']." has on ".date("d.m.", strtotime($dob)).' '.$years."th birthday.";
                    }


                    $sql_alert="INSERT INTO `tbl_alert`(`user_id`, `id`, `id_name`, `id_table_name`, `alert_message`, `alert_type`, `hotel_id`, `entrytime`) VALUES ('$user_id','$last_id','tae_id','tbl_applicants_employee','$alert_msg','UPDATE','$hotel_id','$entry_time')";
                    $result_alert = $conn->query($sql_alert);

                    if($user_device == "ANDRIOD"){
                        //Notification for mobile
                        array_push($send_notification_array, $user_token);

                        $body_send = $alert_msg;
                        $title_send = $title;
                        sendFCM($send_notification_array,$title_send,$body_send);
                        $temp1['flag'] = 1;
                        $temp1['message'] = "Successful";
                        
                       
                        echo json_encode(array('Status' => $temp1,'Data1' => $data));
                    }else if($user_device == "IOS"){
                        array_push($ios_token_array, $user_token);

                        // this is only needed with php prior to 5.5.24
                        if (!defined('CURL_HTTP_VERSION_2_0')) {
                            define('CURL_HTTP_VERSION_2_0', 3);
                        }

                        $title_send = $title;
                        $body_send = $alert_msg;

                        // open connection
                        $http2ch = curl_init();
                        curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
                        // send push
                        $payload1['aps'] = array(
                            'category' => 'MESSAGES',
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


                        $nn++;

                        echo json_encode(array('Status' => $temp1,'Data2' => $data));
                    }

                }
            }
            
            $name_employee = $row_dob['name'];
            
          }
          
           $n++;
          
        }
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Failed!";

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