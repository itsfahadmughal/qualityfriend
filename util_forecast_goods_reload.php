<?php
require_once 'util_config.php';
require_once 'util_session.php';
?>


<div class="mt-4">
    <h3>Goods Cost</h3>
</div>

<?php
$sql_goods = "SELECT * FROM `tbl_forecast_goods_cost` WHERE `hotel_id` = $hotel_id ORDER BY date DESC";

$result_goods = $conn->query($sql_goods);
if ($result_goods && $result_goods->num_rows > 0) {
?>
<div class="table-responsive">
    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list full-color-table full-dark-table hover-table" data-paging="true" data-paging-size="25">
        <thead>
            <tr>
                <th class="" >Meat</th>
                <th class="" >Fruit Vegetable</th>
                <th class="" >Bread</th>
                <th class="" >Frozen Goods</th>
                <th class="" >Dairy Products</th>
                <th class="" >Cheese</th>
                <th class="" >Minus</th>
                <th class="" >Total</th>
                <th class="" >Date</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
    $km = 0;
    while ($row = mysqli_fetch_array($result_goods)) {

        if($km == 0){
            ?>

            <tr class="">
                <th><small><?php echo $row['Meat_Supplier']; ?></small></th>
                <th><small><?php echo $row['Fruit_Vegetable_Supplier']; ?></small></th>
                <th><small><?php echo $row['Bread_Supplier']; ?></small></th>
                <th><small><?php echo $row['Frozen_Goods_Supplier']; ?></small></th>
                <th><small><?php echo $row['Dairy_Products_Supplier']; ?></small></th>
                <th><small><?php echo $row['Cheese_Supplier']; ?></small></th>
                <th>-</th>
                <th>-</th>
                <th>-</th>
                <th>-</th>
            </tr>

            <?php
        }

            ?>
            <tr class="" id="goods_cost_<?php echo $row['frcgct_id']; ?>">
                <td><?php echo $row['Meat']; ?></td>
                <td><?php echo $row['Fruit_Vegetable']; ?></td>
                <td class=""><?php echo $row['Bread']; ?></td>
                <td class=""><?php echo $row['Frozen_Goods']; ?></td>
                <td class=""><?php echo $row['Dairy_Products']; ?></td>
                <td class=""><?php echo $row['Cheese']; ?></td>
                <td class=""><?php echo $row['Minus']; ?></td>
                <td class=""><?php echo $row['total_cost']; ?></td>
                <td class=""><?php echo date('M, Y', strtotime($row['date'])); ?></td>
                <td class="font-size-subheading text-center black_color">
                    <a  class="black_color" href="javascript:void(0)" onclick="edit_goods('<?php echo $row['frcgct_id']; ?>')"><i class="fas fa-pencil-alt font-size-subheading text-right"></i></a>
                </td>
            </tr>
            <?php 
        $km++;
    } 
            ?>
        </tbody>
    </table>
</div>

<?php }else{ ?>
<div class="text-center mt-5 pt-4"><img src="assets/images/no-results-cookie.png" width="250" /></div>
<h5 class="text-center"><b>Goods Cost Not Found.</b></h5>
<?php } ?>