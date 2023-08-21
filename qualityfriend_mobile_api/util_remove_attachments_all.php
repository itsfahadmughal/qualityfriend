<?php 

include 'util_config.php';

$id=0;
$id2=0;
$source="";
$data = array();
$temp1=array();

if(isset($_POST['attachment_id'])){
    $id=$_POST['attachment_id'];
}
if(isset($_POST['source_id'])){
    $id2=$_POST['source_id'];
}
if(isset($_POST['source'])){
    $source=$_POST['source'];
}

if($source != "" && $source == "handover"){
    $sql="DELETE FROM `tbl_handover_attachment` WHERE `hdoa_id` = $id AND `hdo_id` = $id2";
    $result = $conn->query($sql);
    if($result){
        $temp1['flag'] = 1;
        $temp1['message'] = "Attachement Removed.";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Attachment not Removed.";
    }
}else if($source != "" && $source == "notice"){
    $sql="DELETE FROM `tbl_note_attachment` WHERE `ntea_id` = $id AND `nte_id` = $id2";
    $result = $conn->query($sql);
    if($result){
        $temp1['flag'] = 1;
        $temp1['message'] = "Attachement Removed.";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Attachment not Removed.";
    }
}else if($source != "" && $source == "repair"){
    $sql="DELETE FROM `tbl_repair_attachment` WHERE `rpra_id` = $id AND `rpr_id` = $id2";
    $result = $conn->query($sql);
    if($result){
        $temp1['flag'] = 1;
        $temp1['message'] = "Attachement Removed.";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Attachment not Removed.";
    }
}else if($source != "" && $source == "todo"){
    $sql="DELETE FROM `tbl_todolist_attachment` WHERE `tdla_id` = $id AND `tdl_id` = $id2";
    $result = $conn->query($sql);
    if($result){
        $temp1['flag'] = 1;
        $temp1['message'] = "Attachement Removed.";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Attachment not Removed.";
    }
}else if($source != "" && $source == "handbook"){
    $sql="DELETE FROM `tbl_handbook_attachment` WHERE `hdba_id` = $id AND `hdb_id` = $id2";
    $result = $conn->query($sql);
    if($result){
        $temp1['flag'] = 1;
        $temp1['message'] = "Attachement Removed.";
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Attachment not Removed.";
    }
}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "5This Source not Found.";
}

echo json_encode(array('Status' => $temp1,'Data' => $data));

?>