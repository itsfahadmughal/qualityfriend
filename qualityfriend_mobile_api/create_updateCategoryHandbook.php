<?php 
if(file_exists("util_config.php") && is_readable("util_config.php") && include("util_config.php")) 
{

    $cat_id=0;
    $cat="";
    $cat_it="";
    $cat_de="";
    $api_status="";
    $hotel_id=0;
    $sql="";


    $data = array();
    $temp1=array();


    if(isset($_POST['cat_id'])){
        $cat_id=str_replace("'","`",$_POST['cat_id']);
    }
    if(isset($_POST['cat'])){
        $cat=str_replace("'","`",$_POST['cat']);
    }
    if(isset($_POST['cat_it'])){
        $cat_it=str_replace("'","`",$_POST['cat_it']);
    }
    if(isset($_POST['cat_de'])){
        $cat_de=str_replace("'","`",$_POST['cat_de']);
    }
    if(isset($_POST['api_status'])){
        $api_status=str_replace("'","`",$_POST['api_status']);
    }
    if(isset($_POST['hotel_id'])){
        $hotel_id=$_POST['hotel_id'];
    }


    if($hotel_id == 0 || $api_status == ""){

        $temp1['flag'] = 0;
        $temp1['message'] = "Hotel Id & Api Status Required...";

    }else{

        if($api_status=='create'){

            $sql="INSERT INTO `tbl_handbook_cat`(`category_name`, `category_name_it`, `category_name_de`, `hotel_id`) VALUES ('$cat','$cat_it','$cat_de','$hotel_id')";

        }elseif($api_status=='update'){

            $sql="UPDATE `tbl_handbook_cat` SET `category_name`='$cat',`category_name_it`='$cat_it',`category_name_de`='$cat_de' WHERE `hdbc_id` = $cat_id";

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