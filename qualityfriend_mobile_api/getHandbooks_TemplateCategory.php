<?php
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{
    // Declaration

    $hotel_id= 0;

    if(isset($_POST["hotel_id"])){
        $hotel_id = $_POST["hotel_id"];
    }

    $data = array();
    $temp1=array();

    //Working

    $sql = "SELECT b.*,a.hotel_id FROM `tbl_handbook_cat` as a INNER JOIN tbl_handbook_subcat as b on a.hdbc_id = b.hdbc_id WHERE a.hotel_id = $hotel_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $temp = array();

            $temp['template_cat_id'] =   $row['hdbsc_id'];
            $temp['template_category_name'] =   $row['subcat_name'];
            $temp['template_category_name_it'] =   $row['subcat_name_it'];
            $temp['template_category_name_de'] =   $row['subcat_name_de'];
            $temp['hotel_id'] =   $row['hotel_id'];

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