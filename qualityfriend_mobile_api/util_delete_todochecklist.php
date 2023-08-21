<?php

if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    $todocheck_id = 0;
    if(isset($_POST['todocheck_id'])){
        $todocheck_id = $_POST["todocheck_id"];
    }

    $data = array();
    $temp1=array();

    //Working
    $sql = "UPDATE `tbl_todolist` SET `is_delete`='1' WHERE `tdl_id` = '$todocheck_id'";
    if ($result = $conn->query($sql)) {
        
         //    del all the notification about the todo list
        $sql_d = "DELETE FROM `tbl_todo_notification` WHERE `tdl_id` =  $todocheck_id";
        $result_d = $conn->query($sql_d);
    
        
        $temp1['flag'] = 1;
        $temp1['message'] = "Todolist Deleted...";

    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Todolist not Deleted!!!";
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