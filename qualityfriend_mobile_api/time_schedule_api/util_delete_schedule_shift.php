<?php

if(file_exists("../util_config.php") && is_readable("../util_config.php") && include("../util_config.php")) 
{
    $id = $user_id = $hotel_id = $apply_on = 0;
    $repeat_until_date = "";
    if(isset($_POST['shift_id'])){
        $id = $_POST["shift_id"];
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST['user_id'])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST['delete_until_date'])){
        $repeat_until_date = $_POST["delete_until_date"];
    }
    if(isset($_POST['delete_type'])){
        $repeat_type = $_POST["delete_type"];
    }
    if(isset($_POST['apply_on'])){
        $apply_on = $_POST["apply_on"];
    }

    $last_edit_time=date("Y-m-d H:i:s");
    $last_editby_ip=getIPAddress();
    $data = array();
    $temp1=array();

    if($hotel_id == "" || $hotel_id == 0 || $id == 0 || $id == "" || $user_id == 0 || $user_id == ""){
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel id, User id and Shift id is Required.";
        echo json_encode(array('Status' => $temp1,'Data' => $data));
    }else{
        //Working
        if($repeat_type == 1){
            $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE `sfs_id` = $id AND hotel_id = $hotel_id";  
            $stmt=$conn->query($q);
            if ($stmt) {
                $temp1['flag'] = 1;
                $temp1['message'] = "Shift Deleted...";
            }else{
                $temp1['flag'] = 0;
                $temp1['message'] = "Shift Not Deleted!!!";
            }
        }else if($repeat_type == 2){

            $query = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
            $result = $conn->query($query);
            while ($row = mysqli_fetch_array($result)) {

                $date = $row['date'];
                $assign_to = $row['assign_to'];

                for($i=0;$i<=50;$i++){
                    $str = ' + '.(7*($i)).' days';
                    $new_date = date('Y-m-d', strtotime($date. $str)); 

                    if($apply_on == 1){
                        $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE `date` = '$new_date' AND assign_to = $assign_to AND hotel_id = $hotel_id";  
                        $stmt=$conn->query($q);
                    }else{
                        $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE `date` = '$new_date' AND hotel_id = $hotel_id";  
                        $stmt=$conn->query($q);
                    }

                }

                if ($stmt) {
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Shifts Deleted...";
                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Shifts Not Deleted!!!";
                }

            }


        }else{
            $query = "SELECT * FROM `tbl_shifts`WHERE `sfs_id` = $id";
            $result = $conn->query($query);
            while ($row = mysqli_fetch_array($result)) {
                $date = $row['date'];
                $assign_to = $row['assign_to'];

                if($apply_on == 1){
                    $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE (`date` between '$date' AND '$repeat_until_date') AND assign_to = $assign_to AND hotel_id = $hotel_id";  
                    $stmt=$conn->query($q);
                }else{
                    $q="UPDATE `tbl_shifts` SET `is_delete`= 1, `is_active`= 0  WHERE (`date` between '$date' AND '$repeat_until_date') AND hotel_id = $hotel_id";  
                    $stmt=$conn->query($q);
                }
                if ($stmt) {
                    $temp1['flag'] = 1;
                    $temp1['message'] = "Shifts Deleted...";
                }else{
                    $temp1['flag'] = 0;
                    $temp1['message'] = "Shifts Not Deleted!!!";
                }
            }
        }



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