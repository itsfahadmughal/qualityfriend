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

            echo $row['Meat'].','.$row['Meat_Supplier'].','.$row['Fruit_Vegetable'].','.$row['Fruit_Vegetable_Supplier'].','.$row['Bread'].','.$row['Bread_Supplier'].','.$row['Frozen_Goods'].','.$row['Frozen_Goods_Supplier'].','.$row['Dairy_Products'].','.$row['Dairy_Products_Supplier'].','.$row['Cons_Earliest'].','.$row['Cons_Earliest_Supplier'].','.$row['Minus'].','.$row['Tea'].','.$row['Tea_Supplier'].','.$row['Coffee'].','.$row['Coffee_Supplier'].','.$row['Cheese'].','.$row['Cheese_Supplier'].','.$row['Eggs'].','.$row['Eggs_Supplier'].','.$temp[0].','.$temp[1];
        }
    }else{
        echo '';
    }

}else{
    echo '';
}

?>