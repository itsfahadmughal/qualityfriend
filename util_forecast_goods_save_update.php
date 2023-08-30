<?php 
include 'util_config.php';
include 'util_session.php';


$meat_cost_ = 0;
$meat_supplier_ = 0;
$fruit_cost_ = 0;
$fruit_supplier_ = 0;
$bread_cost_ = 0;
$bread_supplier_ = 0;
$frozen_cost_ = 0;
$frozen_supplier_ = 0;
$dairy_cost_ = 0;
$dairy_supplier_ = 0;
$cons_cost_ = 0;
$cons_supplier_ = 0;
$tea_cost_ = 0;
$tea_supplier_ = 0;
$coffee_cost_ = 0;
$coffee_supplier_ = 0;
$cheese_cost_ = 0;
$cheese_supplier_ = 0;
$eggs_cost_ = 0;
$eggs_supplier_ = 0;
$minus_costs_ = 0;
$date_month_goods_ = 0;
$date_year_goods_ = 0;
$goods_id_ = 0;

$sql = "";
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");

if(isset($_POST['meat_cost_'])){
    $meat_cost_ = $_POST['meat_cost_'];
}
if(isset($_POST['meat_supplier_'])){
    $meat_supplier_ = $_POST['meat_supplier_'];
}
if(isset($_POST['fruit_cost_'])){
    $fruit_cost_ = $_POST['fruit_cost_'];
}
if(isset($_POST['fruit_supplier_'])){
    $fruit_supplier_ = $_POST['fruit_supplier_'];
}
if(isset($_POST['bread_cost_'])){
    $bread_cost_ = $_POST['bread_cost_'];
}
if(isset($_POST['bread_supplier_'])){
    $bread_supplier_ = $_POST['bread_supplier_'];
}
if(isset($_POST['frozen_cost_'])){
    $frozen_cost_ = $_POST['frozen_cost_'];
}
if(isset($_POST['frozen_supplier_'])){
    $frozen_supplier_ = $_POST['frozen_supplier_'];
}
if(isset($_POST['dairy_cost_'])){
    $dairy_cost_ = $_POST['dairy_cost_'];
}
if(isset($_POST['dairy_supplier_'])){
    $dairy_supplier_ = $_POST['dairy_supplier_'];
}
if(isset($_POST['cons_cost_'])){
    $cons_cost_ = $_POST['cons_cost_'];
}
if(isset($_POST['cons_supplier_'])){
    $cons_supplier_ = $_POST['cons_supplier_'];
}
if(isset($_POST['tea_cost_'])){
    $tea_cost_ = $_POST['tea_cost_'];
}
if(isset($_POST['tea_supplier_'])){
    $tea_supplier_ = $_POST['tea_supplier_'];
}
if(isset($_POST['coffee_cost_'])){
    $coffee_cost_ = $_POST['coffee_cost_'];
}
if(isset($_POST['coffee_supplier_'])){
    $coffee_supplier_ = $_POST['coffee_supplier_'];
}
if(isset($_POST['cheese_cost_'])){
    $cheese_cost_ = $_POST['cheese_cost_'];
}
if(isset($_POST['cheese_supplier_'])){
    $cheese_supplier_ = $_POST['cheese_supplier_'];
}
if(isset($_POST['eggs_cost_'])){
    $eggs_cost_ = $_POST['eggs_cost_'];
}
if(isset($_POST['eggs_supplier_'])){
    $eggs_supplier_ = $_POST['eggs_supplier_'];
}
if(isset($_POST['minus_costs_'])){
    $minus_costs_ = $_POST['minus_costs_'];
}
if(isset($_POST['date_month_goods_'])){
    $date_month_goods_ = $_POST['date_month_goods_'];
}
if(isset($_POST['date_year_goods_'])){
    $date_year_goods_ = $_POST['date_year_goods_'];
}
if(isset($_POST['goods_id_'])){
    $goods_id_ = $_POST['goods_id_'];
}

$full_date = $date_year_goods_.'-'.$date_month_goods_.'-28';

$total = $meat_cost_ + $fruit_cost_ + $bread_cost_ + $frozen_cost_ + $dairy_cost_ + $cons_cost_ + $tea_cost_ + $coffee_cost_ + $cheese_cost_ + $eggs_cost_ - $minus_costs_;

if($goods_id_ == 0){
    $sql="INSERT INTO `tbl_forecast_goods_cost`(`Meat`, `Meat_Supplier`, `Fruit_Vegetable`, `Fruit_Vegetable_Supplier`, `Bread`, `Bread_Supplier`, `Frozen_Goods`, `Frozen_Goods_Supplier`, `Dairy_Products`, `Dairy_Products_Supplier`, `Cons_Earliest`, `Cons_Earliest_Supplier`, `Minus`, `Tea`, `Tea_Supplier`, `Coffee`, `Coffee_Supplier`, `Cheese`, `Cheese_Supplier`, `Eggs`, `Eggs_Supplier`, `total_cost`, `date`, `hotel_id`, `lastedittime`, `lasteditbyip`, `lasteditbyid`)  VALUES ('$meat_cost_','$meat_supplier_','$fruit_cost_','$fruit_supplier_','$bread_cost_','$bread_supplier_','$frozen_cost_','$frozen_supplier_','$dairy_cost_','$dairy_supplier_','$cons_cost_','$cons_supplier_','$minus_costs_','$tea_cost_','$tea_supplier_','$coffee_cost_','$coffee_supplier_','$cheese_cost_','$cheese_supplier_','$eggs_cost_','$eggs_supplier_','$total','$full_date','$hotel_id','$last_edit_time','$last_editby_ip','$last_editby_id')";
}else{
    $sql="UPDATE `tbl_forecast_goods_cost` SET `Meat`='$meat_cost_',`Meat_Supplier`='$meat_supplier_',`Fruit_Vegetable`='$fruit_cost_',`Fruit_Vegetable_Supplier`='$fruit_supplier_',`Bread`='$bread_cost_',`Bread_Supplier`='$bread_supplier_',`Frozen_Goods`='$frozen_cost_',`Frozen_Goods_Supplier`='$frozen_supplier_',`Dairy_Products`='$dairy_cost_',`Dairy_Products_Supplier`='$dairy_supplier_',`Cons_Earliest`='$cons_cost_',`Cons_Earliest_Supplier`='$cons_supplier_',`Minus`='$minus_costs_',`Tea`='$tea_cost_',`Tea_Supplier`='$tea_supplier_',`Coffee`='$coffee_cost_',`Coffee_Supplier`='$coffee_supplier_',`Cheese`='$cheese_cost_',`Cheese_Supplier`='$cheese_supplier_',`Eggs`='$eggs_cost_',`Eggs_Supplier`='$eggs_supplier_',`total_cost`='$total',`date`='$full_date',`lastedittime`='$last_edit_time',`lasteditbyip`='$last_editby_ip',`lasteditbyid`='$last_editby_id' WHERE `frcgct_id` = $goods_id_ AND `hotel_id` = $hotel_id";
}
$result = $conn->query($sql);

if($result){
    echo 'success';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Forecast Goods Cost Saved.','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo 'unsuccess';
}



?>