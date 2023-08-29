<?php 
include 'util_config.php';
include 'util_session.php';


$supplier_group_title_ = 0;
$meat_supplier_ = 0;
$fruit_supplier_ = 0;
$bread_supplier_ = 0;
$frozen_supplier_ = 0;
$dairy_supplier_ = 0;
$cons_supplier_ = 0;
$tea_supplier_ = 0;
$coffee_supplier_ = 0;
$cheese_supplier_ = 0;
$eggs_supplier_ = 0;
$suppliers_id_ = 0;

$sql = "";
$last_editby_id=$user_id;
$last_editby_ip=getIPAddress();
$last_edit_time=date("Y-m-d H:i:s");

if(isset($_POST['supplier_group_title_'])){
    $supplier_group_title_ = $_POST['supplier_group_title_'];
}
if(isset($_POST['meat_supplier_'])){
    $meat_supplier_ = $_POST['meat_supplier_'];
}
if(isset($_POST['fruit_supplier_'])){
    $fruit_supplier_ = $_POST['fruit_supplier_'];
}
if(isset($_POST['bread_supplier_'])){
    $bread_supplier_ = $_POST['bread_supplier_'];
}
if(isset($_POST['frozen_supplier_'])){
    $frozen_supplier_ = $_POST['frozen_supplier_'];
}
if(isset($_POST['dairy_supplier_'])){
    $dairy_supplier_ = $_POST['dairy_supplier_'];
}
if(isset($_POST['cons_supplier_'])){
    $cons_supplier_ = $_POST['cons_supplier_'];
}
if(isset($_POST['tea_supplier_'])){
    $tea_supplier_ = $_POST['tea_supplier_'];
}
if(isset($_POST['coffee_supplier_'])){
    $coffee_supplier_ = $_POST['coffee_supplier_'];
}
if(isset($_POST['cheese_supplier_'])){
    $cheese_supplier_ = $_POST['cheese_supplier_'];
}
if(isset($_POST['eggs_supplier_'])){
    $eggs_supplier_ = $_POST['eggs_supplier_'];
}
if(isset($_POST['suppliers_id_'])){
    $suppliers_id_ = $_POST['suppliers_id_'];
}

if($suppliers_id_ == 0){
    $sql="INSERT INTO `tbl_forecast_goods_suppliers`(`goods_suppliers_group`, `Meat_Supplier`, `Fruit_Vegetable_Supplier`, `Bread_Supplier`, `Frozen_Goods_Supplier`, `Dairy_Products_Supplier`, `Cons_Earliest_Supplier`, `Tea_Supplier`, `Coffee_Supplier`, `Cheese_Supplier`, `Eggs_Supplier`, `hotel_id`)  VALUES ('$supplier_group_title_','$meat_supplier_','$fruit_supplier_','$bread_supplier_','$frozen_supplier_','$dairy_supplier_','$cons_supplier_','$tea_supplier_','$coffee_supplier_','$cheese_supplier_','$eggs_supplier_','$hotel_id')";
}else{
    $sql="UPDATE `tbl_forecast_goods_suppliers` SET `goods_suppliers_group`='$supplier_group_title_',`Meat_Supplier`='$meat_supplier_',`Fruit_Vegetable_Supplier`='$fruit_supplier_',`Bread_Supplier`='$bread_supplier_',`Frozen_Goods_Supplier`='$frozen_supplier_',`Dairy_Products_Supplier`='$dairy_supplier_',`Cons_Earliest_Supplier`='$cons_supplier_',`Tea_Supplier`='$tea_supplier_',`Coffee_Supplier`='$coffee_supplier_',`Cheese_Supplier`='$cheese_supplier_',`Eggs_Supplier`='$eggs_supplier_' WHERE `frcgsl_id` = $suppliers_id_ AND `hotel_id` = $hotel_id";
}
$result = $conn->query($sql);

if($result){
    echo 'success';
    $sql_log="INSERT INTO `tbl_log`(`user_id`, `log_text`, `hotel_id`, `entrytime`) VALUES ('$user_id','Forecast Goods Suppliers Saved.','$hotel_id','$last_edit_time')";
    $result_log = $conn->query($sql_log);
}else{
    echo 'unsuccess';
}



?>