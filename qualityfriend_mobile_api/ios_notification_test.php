<?php
require_once 'vendor/autoload.php';

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;

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
//        CURLOPT_RETURNTRANSFER => TRUE,
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
// this is only needed with php prior to 5.5.24
if (!defined('CURL_HTTP_VERSION_2_0')) {
    define('CURL_HTTP_VERSION_2_0', 3);
}
// open connection
$http2ch = curl_init();
curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
// send push
//$message = '{"aps":{"alert":"Ho gasi tasaliccc!","sound":"default"}}';
$message = '{"aps": {
    "alert": {
      "title": "title of your message On line",
      "subtitle": "subtitle of your message (shown below title, above body)",
      "body": "body of your message"
    },"sound":"default"}}';

$token = '83233816762782520c6af79fcefbed183be11b34ac03ed0c31b9acb9e46e578c';
$http2_server = 'https://api.push.apple.com'; // or 'api.push.apple.com' if production
$app_bundle_id = 'com.qualityfriend.arfasoftech';

$st = sendHTTP2Push($http2ch, $http2_server, $app_bundle_id, $message, $token, $jws);


//$json_en = json_encode($st);
 
echo $st['http_code'];



//print_r($st);
// close connection
curl_close($http2ch);
?>