<?php
if(!empty($_FILES['file_attachment']['name']))
{
    $target_dir = "../attachments/";
    if (!file_exists($target_dir))
    {
        mkdir($target_dir, 0777);
    }
    $target_file =
        $target_dir . basename($_FILES["file_attachment"]["name"]);
    $imageFileType = 
        strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
        echo json_encode(
            array(
                "status" => 0,
                "data" => array()
                ,"msg" => "Sorry, file already exists."
            )
        );
        die();
    }
    // Check file size
    if ($_FILES["file_attachment"]["size"] > 10000000) {
        echo json_encode(
            array(
                "status" => 0,
                "data" => array(),
                "msg" => "Sorry, your file is too large."
            )
        );
        die();
    }
    if (
        move_uploaded_file(
            $_FILES["file_attachment"]["tmp_name"], $target_file
        )
    ) {
        echo json_encode(
            array(
                "status" => 1,
                "data" => array(),
                "msg" => "The file " . 
                basename( $_FILES["file_attachment"]["name"]) .
                " has been uploaded."));
    } else {
        echo json_encode(
            array(
                "status" => 0,
                "data" => array(),
                "msg" => "Sorry, there was an error uploading your file."
            )
        );
    }

}else{
    echo json_encode(
        array(
            "status" => 0,
            "data" => array(),
            "msg" => "Error File not Found."
        )
    );
}
?>