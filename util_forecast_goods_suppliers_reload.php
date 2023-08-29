<?php
require_once 'util_config.php';
require_once 'util_session.php';
?>


<div class="mt-4">
    <h3>Goods Suppliers</h3>
</div>

<?php
$sql_goods = "SELECT * FROM `tbl_forecast_goods_suppliers` WHERE `hotel_id` = $hotel_id ORDER BY 1 DESC";

$result_goods = $conn->query($sql_goods);
if ($result_goods && $result_goods->num_rows > 0) {
?>
<div class="table-responsive">
    <table id="demo-foo-addrow" class="goods_table_responsive table table-bordered m-t-30 table-hover contact-list full-color-table full-danger-table hover-table" data-paging="true" data-paging-size="25">
        <thead>
            <tr>
                <th class="" >Suppliers Group</th>
                <th class="" >Meat</th>
                <th class="" >Fruit Vegetable</th>
                <th class="" >Bread</th>
                <th class="" >Frozen Goods</th>
                <th class="" >Dairy Products</th>
                <th class="" >Cons Earliest</th>
                <th class="" >Tea</th>
                <th class="" >Coffee</th>
                <th class="" >Cheese</th>
                <th class="" >Eggs</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php

    while ($row = mysqli_fetch_array($result_goods)) {
            ?>
            <tr class="" id="goods_suppliers_<?php echo $row['frcgsl_id']; ?>">
                <td><?php echo $row['goods_suppliers_group']; ?></td>
                <td><?php echo $row['Meat_Supplier']; ?></td>
                <td><?php echo $row['Fruit_Vegetable_Supplier']; ?></td>
                <td class=""><?php echo $row['Bread_Supplier']; ?></td>
                <td class=""><?php echo $row['Frozen_Goods_Supplier']; ?></td>
                <td class=""><?php echo $row['Dairy_Products_Supplier']; ?></td>
                <td class=""><?php echo $row['Cons_Earliest_Supplier']; ?></td>
                <td class=""><?php echo $row['Tea_Supplier']; ?></td>
                <td class=""><?php echo $row['Coffee_Supplier']; ?></td>
                <td class=""><?php echo $row['Cheese_Supplier']; ?></td>
                <td class=""><?php echo $row['Eggs_Supplier']; ?></td>
                <td class="font-size-subheading text-center black_color">
                    <a  class="black_color" href="javascript:void(0)" onclick="edit_goods_suppliers('<?php echo $row['frcgsl_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                </td>
            </tr>
            <?php 
    } 
            ?>
        </tbody>
    </table>
</div>

<?php }else{ ?>
<div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
<h5 class="text-center"><b>Goods Suppliers Not Found.</b></h5>
<?php } ?>