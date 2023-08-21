<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    $user_id = $_POST['user_id'];
    $by = $_POST['by'];
    $id = $_POST['id'];



    $data = array();
    $temp1=array();
    //Working  

    if($by == "handover"){
        $sql = "SELECT a.*,b.firstname,b.address FROM `tbl_handover_comments` as a inner join tbl_user as b on a.comment_by = b.user_id Where a.hdo_id=$id and a.is_delete = 0  ORDER BY a.`hdc_id` DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp['id'] =   $row['hdc_id'];
                $temp['comment'] =   $row['comment'];
                $temp['entrytime'] = $row['entrytime'];
                $temp['firstname'] = $row['firstname'];
                $temp['image_url']  =  $row['address'];
                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }
    } if($by == "todolist"){
        $sql = "SELECT a.*,b.firstname,b.address FROM `tbl_todolist_comments_user` as a inner join tbl_user as b on a.comment_by = b.user_id Where a.tdl_id=$id and a.is_delete = 0 ORDER BY a.`tdlcn_id` DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp['id'] =   $row['tdlcn_id'];
                $temp['comment'] =   $row['comment'];
                $temp['entrytime'] = $row['entrytime'];
                $temp['firstname'] = $row['firstname'];
                $temp['image_url']  =  $row['address'];
                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }


    } 

    if($by == "repair"){
        $sql = "SELECT a.*,b.firstname,b.address FROM `tbl_repair_comments` as a inner join tbl_user as b on a.comment_by = b.user_id Where a.rpr_id=$id and a.is_delete = 0 ORDER BY a.`rprc_id` DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp['id'] =   $row['rprc_id'];
                $temp['comment'] =   $row['comment'];
                $temp['entrytime'] = $row['entrytime'];
                $temp['firstname'] = $row['firstname'];
                $temp['image_url']  =  $row['address'];
                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }

    }  


    if($by == "note"){
        $sql = "SELECT a.*,b.firstname,b.address FROM `tbl_note_comments` as a inner join tbl_user as b on a.comment_by = b.user_id Where a.nte_id=$id and a.is_delete = 0 ORDER BY a.`ntec_id` DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp['id'] =   $row['ntec_id'];
                $temp['comment'] =   $row['comment'];
                $temp['entrytime'] = $row['entrytime'];
                $temp['firstname'] = $row['firstname'];
                $temp['image_url']  =  $row['address'];
                array_push($data, $temp);
                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data notdd Found!!!";
        }


    }



    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>