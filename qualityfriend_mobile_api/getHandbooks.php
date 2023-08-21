<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= $usert_id= $depart_id= $Create_edit_handbooks= $handbook_id=0;
    $saved_status="";

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["user_id"])){
        $user_id = $_POST["user_id"];
    }
    if(isset($_POST["usert_id"])){
        $usert_id = $_POST["usert_id"];
    }
    if(isset($_POST["depart_id"])){
        $depart_id = $_POST["depart_id"];
    }
    if(isset($_POST["create_edit_rule"])){
        $Create_edit_handbooks = $_POST["create_edit_rule"];
    }
    if(isset($_POST["handbook_id"])){
        $handbook_id = $_POST["handbook_id"];
    }
    if(isset($_POST["saved_status"])){
        $saved_status = $_POST["saved_status"];
    }

    $data = array();
    $temp1=array();

    //Working
    if($hotel_id != 0){
        if($handbook_id == 0){
            if($Create_edit_handbooks == 1 || $usert_id == 1){
                $sql="SELECT a.* FROM `tbl_handbook` AS a  WHERE a.`hotel_id` = $hotel_id AND a.is_delete = 0 and a.saved_status = '$saved_status' ORDER BY 1 DESC";
            } else{
                $sql="SELECT DISTINCT a.* FROM `tbl_handbook` as a INNER JOIN tbl_handbook_cat_depart_map as b on a.hdb_id = b.hdb_id  WHERE a.`hotel_id` = $hotel_id AND a.is_delete = 0 AND a.is_active=1 AND a.saved_status = 'CREATE' AND b.depart_id= $depart_id ORDER BY 1 DESC";
            }
        }else{
            $sql="SELECT * FROM `tbl_handbook` WHERE `is_delete` = 0 AND `hotel_id` = $hotel_id AND hdb_id = $handbook_id ORDER BY 1 DESC";
        }
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $temp = array();
                $temp2 = array();
                $temp3 = array();

                $temp_attachment = array();
                $temp_department = array();

                $temp['hdb_id'] = $row['hdb_id'];
                $hdb_id= $row['hdb_id'];


                $temp['template_category_id'] = $row['hdbsc_id'];
                $hdbsc_id= $row['hdbsc_id'];

                $template_cat="";
                $template_cat_it="";
                $template_cat_de="";
                $main_cat="";
                $main_cat_it="";
                $main_cat_de="";
                $hdbc_id = 0;
                $sql_t="SELECT hdbc_id,subcat_name,	subcat_name_it, subcat_name_de FROM `tbl_handbook_subcat` WHERE hdbsc_id = $hdbsc_id";
                $result_t = $conn->query($sql_t);
                if ($result_t && $result_t->num_rows > 0) {
                    while($row_t = mysqli_fetch_array($result_t)) {
                        $template_cat = $row_t['subcat_name'];
                        $template_cat_it = $row_t['subcat_name_it'];
                        $template_cat_de = $row_t['subcat_name_de'];
                        $hdbc_id = $row_t['hdbc_id'];

                        $sql_mc="SELECT category_name, category_name_it, category_name_de FROM `tbl_handbook_cat` WHERE hdbc_id = $hdbc_id";
                        $result_mc = $conn->query($sql_mc);
                        if ($result_mc && $result_mc->num_rows > 0) {
                            while($row_mc = mysqli_fetch_array($result_mc)) {
                                $main_cat = $row_mc['category_name'];
                                $main_cat_it = $row_mc['category_name_it'];
                                $main_cat_de = $row_mc['category_name_de'];
                            }
                        }
                    }
                }

                $temp['template_cat'] = $template_cat;
                $temp['template_cat_it'] = $template_cat_it;
                $temp['template_cat_de'] = $template_cat_de;

                $temp['main_cat_id'] = $hdbc_id;
                $temp['main_cat'] = $main_cat;
                $temp['main_cat_it'] = $main_cat_it;
                $temp['main_cat_de'] = $main_cat_de;


                $temp['title'] = trim($row['title']);
                $temp['title_it'] = trim($row['title_it']);
                $temp['title_de'] = trim($row['title_de']);


                //Hide one
                if ($handbook_id != 0 || $saved_status == 'TEMPLATE' ){




                    $temp['description'] = trim($row['description']);
                    $temp['description_it'] = trim($row['description_it']);
                    $temp['description_de'] = trim($row['description_de']);
                    $temp['tags'] = $row['tags'];
                }
                $temp['saved_status'] = $row['saved_status'];
                $temp['visibility_status'] = $row['visibility_status'];
                $temp['hotel_id'] = $row['hotel_id'];

                $creater_id = $row['entrybyid'];
                $creater="";
                $sql_c="SELECT firstname FROM `tbl_user` WHERE user_id = $creater_id";
                $result_c = $conn->query($sql_c);
                if ($result_c && $result_c->num_rows > 0) {
                    while($row_c = mysqli_fetch_array($result_c)) {
                        $creater = $row_c['firstname'];
                    }
                }
                $temp['creater'] = $creater;

                $temp['entrytime'] = $row['entrytime'];
                $temp['entrybyid'] = $row['entrybyid'];
                $temp['entrybyip'] = $row['entrybyip'];
                $temp['lastedittime'] = $row['edittime'];
                $temp['lasteditbyid'] = $row['editbyid'];
                $temp['lasteditbyip'] = $row['editbyip'];


                if( $row['is_active'] == 1){
                    $temp['is_active'] = "Yes";
                }else {
                    $temp['is_active'] = "No";
                }

                if( $row['is_delete'] == 1){
                    $temp['is_delete'] = "Yes";
                }else {
                    $temp['is_delete'] = "No";
                }



                $sql2="SELECT * FROM `tbl_handbook_attachment` WHERE hdb_id = $hdb_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp3['attachment_id'] = $row2['hdba_id'];
                        $temp3['attachment_url'] = $row2['attachment_url'];
                        array_push($temp_attachment, $temp3);
                    }
                }

                $sql2="SELECT b.* FROM `tbl_handbook_cat_depart_map` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.hdb_id = $hdb_id";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    while($row2 = mysqli_fetch_array($result2)) {
                        $temp2['depart_id'] = $row2['depart_id'];
                        $temp2['department_name'] = $row2['department_name'];
                        $temp2['department_name_it'] = $row2['department_name_it'];
                        $temp2['department_name_de'] = $row2['department_name_de'];

                        array_push($temp_department, $temp2);
                    }
                }

                $temp['Attachements'] = $temp_attachment;
                $temp['Departments'] = $temp_department;

                array_push($data, $temp);

                unset($temp);
                $temp1['flag'] = 1;
                $temp1['message'] = "Successfull";
            }
        } else {
            $temp1['flag'] = 0;
            $temp1['message'] = "Data not Found!!!";
        }
    }else{
        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id Required!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>