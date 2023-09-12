<?php 
require_once 'vendor/autoload.php';
use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
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

    //getUserToken
    $user_token  = "";
    $name  = "";
    $user_device = "";
    $sql_user_token="SELECT * FROM `tbl_user`";
    $result_user_token = $conn->query($sql_user_token);
    if ($result_user_token && $result_user_token->num_rows > 0) {
        while($row_user_token = mysqli_fetch_array($result_user_token)) {
            $user_token = $row_user_token['user_token'];
            $user_device = $row_user_token['login_as'];

            if($user_device == "ANDRIOD" ){
                //Notification for mobile

            }else if($user_device == "IOS"){
                array_push($ios_token_array, $user_token);
            }

        }
    }

    // this is only needed with php prior to 5.5.24
    if (!defined('CURL_HTTP_VERSION_2_0')) {
        define('CURL_HTTP_VERSION_2_0', 3);
    }

    $title_send = "Qualityfriend App Update";
    $body_send = "New App Update Available Check Your App Store";

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




    echo json_encode(array('Status' => $temp1,'Data' => $data));
}else{
    $temp1=array();
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>