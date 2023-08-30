<?php 
include 'util_config.php';
include 'util_session.php';


$sql = "SELECT * FROM `tbl_forecast_goods_cost` WHERE `hotel_id` = $hotel_id ORDER BY date DESC LIMIT 1";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo $row['Meat_Supplier'].','.$row['Fruit_Vegetable_Supplier'].','.$row['Bread_Supplier'].','.$row['Frozen_Goods_Supplier'].','.$row['Dairy_Products_Supplier'].','.$row['Cons_Earliest_Supplier'].','.$row['Tea_Supplier'].','.$row['Coffee_Supplier'].','.$row['Cheese_Supplier'].','.$row['Eggs_Supplier'];
    }
}else{
    echo '';
}

?>