<?php

require_once 'util_config.php';

$hotel_id=0;

if(isset($_POST['hotel_id'])){
    $hotel_id = $_POST['hotel_id'];
}


$n=0;
$data = array();
$temp1=array();

$sq1="SELECT crjb_id, title, title_it, title_de, edittime FROM `tbl_create_job` where hotel_id = $hotel_id and is_active = 0";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        $temp = array();

        $temp['id'] = $row['crjb_id'];
        $title=$row['title'];

        $title_it=$row['title_it'];

        $title_de=$row['title_de'];


        $temp['title'] = $title;
        $temp['title_it'] = $title_it;
        $temp['title_de'] = $title_de;


        $temp['datetime'] = $row['edittime'];
        $temp['type'] = 'Job';
        $temp['table_name'] = 'tbl_create_job';
        $temp['id_name'] = 'crjb_id';

        array_push($data, $temp);


    }   
}

$sq1="SELECT tae_id, name, surname, edittime FROM `tbl_applicants_employee` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title=$row['name'].' '.$row['surname'];

        $temp['id'] = $row['tae_id'];

        $temp['title'] = $title;
        $temp['title_it'] = $title;
        $temp['title_de'] = $title;

        $temp['datetime'] = $row['edittime'];
        $temp['type'] = 'Applicant/Employee';
        $temp['table_name'] = 'tbl_applicants_employee';
        $temp['id_name'] = 'tae_id';

        array_push($data, $temp);

    }   
}


$sq1="SELECT hdb_id, title, title_it, title_de, edittime FROM `tbl_handbook` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        $temp = array();

        $temp['id'] = $row['hdb_id'];
        $title=$row['title'];

        $title_it=$row['title_it'];

        $title_de=$row['title_de'];


        $temp['title'] = $title;
        $temp['title_it'] = $title_it;
        $temp['title_de'] = $title_de;

        $temp['datetime'] = $row['edittime'];
        $temp['type'] = 'Handbook';
        $temp['table_name'] = 'tbl_handbook';
        $temp['id_name'] = 'hdb_id';

        array_push($data, $temp);


    }   
}

$sq1="SELECT hdo_id, title, title_it, title_de, lastedittime FROM `tbl_handover` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        $temp = array();

        $temp['id'] = $row['hdo_id'];
        $title=$row['title'];

        $title_it=$row['title_it'];

        $title_de=$row['title_de'];


        $temp['title'] = $title;
        $temp['title_it'] = $title_it;
        $temp['title_de'] = $title_de;

        $temp['datetime'] = $row['lastedittime'];
        $temp['type'] = 'Handover';
        $temp['table_name'] = 'tbl_handover';
        $temp['id_name'] = 'hdo_id';

        array_push($data, $temp);


    }   
}

$sq1="SELECT nte_id, title, title_it, title_de, lastedittime FROM `tbl_note` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        $temp = array();

        $temp['id'] = $row['nte_id'];
        $title=$row['title'];

        $title_it=$row['title_it'];

        $title_de=$row['title_de'];


        $temp['title'] = $title;
        $temp['title_it'] = $title_it;
        $temp['title_de'] = $title_de;

        $temp['datetime'] = $row['lastedittime'];
        $temp['type'] = 'Notice';
        $temp['table_name'] = 'tbl_note';
        $temp['id_name'] = 'nte_id';

        array_push($data, $temp);


    }   
}

$sq1="SELECT rpr_id, title, title_it, title_de, lastedittime FROM `tbl_repair` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        $temp = array();

        $temp['id'] = $row['rpr_id'];
        $title=$row['title'];

        $title_it=$row['title_it'];

        $title_de=$row['title_de'];


        $temp['title'] = $title;
        $temp['title_it'] = $title_it;
        $temp['title_de'] = $title_de;

        $temp['datetime'] = $row['lastedittime'];
        $temp['type'] = 'Repair';
        $temp['table_name'] = 'tbl_repair';
        $temp['id_name'] = 'rpr_id';

        array_push($data, $temp);


    }   
}

$sq1="SELECT tdl_id, title, title_it, title_de, edittime FROM `tbl_todolist` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        $temp = array();

        $temp['id'] = $row['tdl_id'];
        $title=$row['title'];

        $title_it=$row['title_it'];

        $title_de=$row['title_de'];


        $temp['title'] = $title;
        $temp['title_it'] = $title_it;
        $temp['title_de'] = $title_de;

        $temp['datetime'] = $row['edittime'];
        $temp['type'] = 'Todolist';
        $temp['table_name'] = 'tbl_todolist';
        $temp['id_name'] = 'tdl_id';

        array_push($data, $temp);


    }   
}

$sq1="SELECT user_id, firstname, lastname, edittime FROM `tbl_user` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $temp = array();

        $title=$row['firstname'].' '.$row['lastname'];

        $temp['id'] = $row['user_id'];

        $temp['title'] = $title;
        $temp['title_it'] = $title;
        $temp['title_de'] = $title;

        $temp['datetime'] = $row['edittime'];
        $temp['type'] = 'User';
        $temp['table_name'] = 'tbl_user';
        $temp['id_name'] = 'user_id';

        array_push($data, $temp);


    }   
}

// Comparison function
function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['datetime']);
    $datetime2 = strtotime($element2['datetime']);
    return $datetime2 - $datetime1;
} 

// Sort the array 
usort($data, 'date_compare');

if(sizeof($data) > 0){
    $temp1['flag'] = 1;
    $temp1['message'] = "Successfull";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}


?>