<?php 
include 'util_config.php';
include 'util_session.php';

$id = 0;
if(isset($_POST['goods_id_'])){
    $id = $_POST['goods_id_'];
}

$temp = "";


if($id != 0){

    $sql = "SELECT * FROM `tbl_forecast_goods_cost` WHERE `hotel_id` = $hotel_id AND frcgct_id = $id";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            
            $temp = explode('-',$row['date']);

            echo $row['frcgsl_id'].','.$row['Meat'].','.$row['Fruit_Vegetable'].','.$row['Bread'].','.$row['Frozen_Goods'].','.$row['Dairy_Products'].','.$row['Cons_Earliest'].','.$row['Minus'].','.$row['Tea'].','.$row['Coffee'].','.$row['Cheese'].','.$row['Eggs'].','.$temp[0].','.$temp[1];
        }
    }else{
        echo '';
    }

}else{
    echo '';
}

?>