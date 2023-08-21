<?php
require 'deepl_vendor/autoload.php';
use DeepL\DeepLException;
use DeepL\Translator;
$outupt = "";
$input_deepl ="";
$deepl_language ="";
$input_deepl = $_POST['input_deepl'];
$deepl_language = $_POST['deepl_language'];

$data = array();
$temp1=array();
$text_input ="".$input_deepl;
$authKey = "1fc25113-77d5-087e-a084-47542f9c50ba"; // Replace with your key
$translator = new \DeepL\Translator($authKey);
$result = $translator->translateText($text_input, null, $deepl_language);
if($result){
    $myout_put = $result->text;
    $temp = array();
    $temp['out_put'] =   $myout_put;
    array_push($data, $temp);
    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}else{
    $outupt = "error";
    $temp1['flag'] = 1;
    $temp1['message'] = $outupt;
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}

?>