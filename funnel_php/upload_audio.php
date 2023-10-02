<?php
if ($_FILES["audio"]["error"] == UPLOAD_ERR_OK) {
    $uploadDir = 'audio/';
    
    
    
    $originalFileName = basename($_FILES["audio"]["name"]);
    $newFileName = "custom_nameq.mp3"; // Change this to your desired custom name
    $uploadedFile = $uploadDir .time(). $newFileName;

    if (move_uploaded_file($_FILES["audio"]["tmp_name"], $uploadedFile)) {
        $response = array("success" => true, "filePath" => 'funnel_php/'.$uploadedFile);
    } else {
        $response = array("success" => false, "error" => "Error moving the uploaded file");
    }
} else {
    $response = array("success" => false, "error" => "File upload error: " . $_FILES["audio"]["error"]);
}

echo json_encode($response);
?>
