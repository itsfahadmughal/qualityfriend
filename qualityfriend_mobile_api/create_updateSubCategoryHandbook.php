<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $subcat_id=0;
    $subcat="";
    $subcat_it="";
    $subcat_de="";
    $api_status="";
    $handbook_cat_id=0;
    $sql="";


    $data = array();
    $temp1=array();


    if(isset($_POST['subcat_id'])){
        $subcat_id=str_replace("'","`",$_POST['subcat_id']);
    }
    if(isset($_POST['subcat'])){
        $subcat=str_replace("'","`",$_POST['subcat']);
    }
    if(isset($_POST['subcat_it'])){
        $subcat_it=str_replace("'","`",$_POST['subcat_it']);
    }
    if(isset($_POST['subcat_de'])){
        $subcat_de=str_replace("'","`",$_POST['subcat_de']);
    }
    if(isset($_POST['api_status'])){
        $api_status=str_replace("'","`",$_POST['api_status']);
    }
    if(isset($_POST['handbook_cat_id'])){
        $handbook_cat_id=$_POST['handbook_cat_id'];
    }


    if($handbook_cat_id == 0 || $api_status == ""){

        $temp1['flag'] = 0;
        $temp1['message'] = "Handbook Category Id & Api Status Required...";

    }else{


        if($api_status=='create'){

            $sql="INSERT INTO `tbl_handbook_subcat`(`subcat_name`, `subcat_name_it`, `subcat_name_de`, `hdbc_id`) VALUES ('$subcat','$subcat_it','$subcat_de','$handbook_cat_id')";

        }elseif($api_status=='update'){

            $sql="UPDATE `tbl_handbook_subcat` SET `subcat_name`='$subcat',`subcat_name_it`='$subcat_it',`subcat_name_de`='$subcat_de',`hdbc_id`='$handbook_cat_id' WHERE `hdbsc_id` = $subcat_id";

        }

        $result = $conn->query($sql);

        if($result){
            $temp1['flag'] = 1;
            $temp1['message'] = "Successful";
        }else{
            $temp1['flag'] = 0;
            $temp1['message'] = "Something Bad Happend!!!";
        }

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