
<?php
require_once '../util_config.php';
require_once '../util_session.php';
$t=$hotel_id;
$time = time();
if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tempPath = $_FILES['image']['tmp_name'];
    $targetPath = 'images/' .$t.$time. $_FILES['image']['name'];

    if (move_uploaded_file($tempPath, $targetPath)) {
        echo $targetPath; // Return the URL of the uploaded image
    }
}
?>