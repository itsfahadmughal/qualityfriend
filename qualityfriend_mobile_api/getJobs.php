<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;
    $saved_status="";
    $job_id_is =  0 ;
    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }
    if(isset($_POST["saved_status"])){
        $saved_status = $_POST["saved_status"];
    }

    if(isset($_POST["job_id"])){
        $job_id_is = $_POST["job_id"];
    }



    $data = array();
    $temp1=array();

    //Working

    if ($job_id_is == 0){


        if($saved_status == 'ARCHIVED'){
            $sql = "SELECT a.*,a.is_active as active,b.* FROM `tbl_create_job` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.is_active = 0 AND a.saved_status = 'CREATE' AND a.hotel_id = $hotel_id ORDER BY a.`crjb_id` DESC";    
        }
        else if ($saved_status == 'DRAFT'){
            $sql = "SELECT a.*,a.is_active as active,b.* FROM `tbl_create_job` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.saved_status = '$saved_status' AND a.hotel_id = $hotel_id ORDER BY a.`crjb_id` DESC"; 
        }
        else{
            $sql = "SELECT a.*,a.is_active as active,b.* FROM `tbl_create_job` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE a.saved_status = '$saved_status' AND a.is_active = 1 AND a.hotel_id = $hotel_id ORDER BY a.`crjb_id` DESC";
        }
    }else {

        $sql = "SELECT a.*,a.is_active as active,b.* FROM `tbl_create_job` as a INNER JOIN tbl_department as b on a.depart_id = b.depart_id WHERE  a.crjb_id = $job_id_is AND a.hotel_id = $hotel_id ORDER BY a.`crjb_id` DESC";

    }
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();


            $crjb_id =  $row['crjb_id'];
            $temp['job_id'] =   $row['crjb_id'];
            $temp['title'] =   $row['title'];
            $temp['title_it'] =   $row['title_it'];
            $temp['title_de'] =   $row['title_de'];


            //Hide one 

            if ($job_id_is != 0 ){

                $temp['description'] =   $row['description'];
                $temp['description_it'] =   $row['description_it'];
                $temp['description_de'] =   $row['description_de'];
                $temp['job_image'] =   $row['job_image'];
            }
            $temp['creation_date'] =   $row['creation_date'];
            //Hide one 
            if ($job_id_is != 0 ){
                $temp['location'] =   $row['location'];
                $temp['location_it'] =   $row['location_it'];
                $temp['location_de'] =   $row['location_de'];
            }
            $temp['is_delete'] =   $row['is_delete'];

            if($row['is_delete'] == 0){
                $temp['department_name'] =   $row['department_name'];
            }else{
                $temp['department_name'] =   "";
            }


            $temp['generated_link'] = $baseurl.$row['generated_link'];

            if( $row['whatsapp_isactive'] == 1){
                $temp['whatsapp_isactive'] = "Yes";
            }else {
                $temp['whatsapp_isactive'] = "No";
            }
            $temp['whatsapp_number'] =   $row['whatsapp'];

            if($row['active'] == 1){
                $temp['is_archived'] = "No";
            }else{
                $temp['is_archived'] = "Yes";
            }

            if( $row['is_cv_required'] == 1){
                $temp['is_cv_required'] = "Yes";
            }else {
                $temp['is_cv_required'] = "No";
            }


            $temp6  = array();
            $temp_comments = array();
            $sql2="SELECT * FROM `tbl_job_benefits` WHERE `job_id` =    $crjb_id";
            $result2 = $conn->query($sql2);
            if ($result2 && $result2->num_rows > 0) {
                while($row2 = mysqli_fetch_array($result2)) {
                    $temp6['text'] = $row2['text'];
                    array_push($temp_comments, $temp6);
                }
            }
            $temp['auto_msg'] =$row['auto_msg'];
            $temp['benefits'] = $temp_comments;
            $temp['job_funnel'] = $row['job_funnel'];
            $temp['is_funnel'] = $row['is_funnel'];
            $temp['logo_image'] =   $row['logo_image'];


            array_push($data, $temp);
            unset($temp);
            $temp1['flag'] = 1;
            $temp1['message'] = "Successfull";
        }
    } else {
        $temp1['flag'] = 0;
        $temp1['message'] = "Data not Found!!!";
    }

    echo json_encode(array('Status' => $temp1,'Data' => $data));

}else{
    $temp1['flag'] = 0;
    $temp1['message'] = "Failed to connecting database!!!";
    echo json_encode(array('Status' => $temp1,'Data' => $data));
}
$conn->close();
?>