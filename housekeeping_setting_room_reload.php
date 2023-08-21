<?php 
include 'util_config.php';
include 'util_session.php';

$name="";
$div_id = 0;
if(isset($_POST['name'])){
    $name=$_POST['name'];
}
if(isset($_POST['selected_id'])){
    $id=$_POST['selected_id'];
}
?>

<div class='col-lg-12 col-xlg-12 col-md-12'>
    <h4><b>Rooms</b></h4>
</div>
<?php
$sql="SELECT * FROM `tbl_rooms` WHERE `hotel_id` =  $hotel_id  AND `is_delete` = 0 ORDER BY `room_num` ASC";
$result = $conn->query($sql);
$i = 0;
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {

        $rms_id           = $row["rms_id"];
        $room_num         = $row["room_num"];
        $room_name        = $row["room_name"];
        $room_name_it     = $row["room_name_it"];
        $room_name_de     = $row["room_name_de"];
        $floor_id         = $row["floor_id"];
        $room_cat_id      = $row["room_cat_id"];
        $assigned = "";
        if($name == "floor"){
            if($id == $floor_id) {
                $assigned = "assign_background";
            }
        }else if($name == "category") {
            if($id == $room_cat_id) {
                $assigned = "assign_background";
            }
        }


?>
<div class='col-lg-3 col-xlg-3 col-md-3 mt-2'>
    <div  onclick='addroom_on("<?php echo $name; ?>",<?php echo $id; ?>,<?php echo $rms_id; ?>)' class='pointer pt-3 pb-3 div-white-background div-white-background <?php echo $assigned; ?>'>
        <div class='row' >
            <div class='col-lg-8 col-xlg-8 col-md-8 pl-4 wm-70'>
                <h5><?php echo "Room Number : ".$room_num ;?></h5>
            </div>
            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15'>
                <a   onclick="set_room('Edit Rooms',
                              '<?php echo $room_num; ?>',
                              '<?php echo $room_name; ?>',
                              '<?php echo $room_name_it; ?>',
                              '<?php echo $room_name_de; ?>',
                              '<?php echo $room_cat_id; ?>',
                              '<?php echo $floor_id; ?>',
                              '<?php echo $rms_id; ?>'
                              )" data-toggle="modal"  data-target="#add-room" data-dismiss="modal" href="JavaScript:void(0)"

                   > <img width="30" height="30"  class='' src="./assets/images/edit.png" alt="Girl in a jacket"></a>
            </div> 
            <div class='col-lg-2 col-xlg-2 col-md-2 wm-15 plm-5px'>
                <img onclick="delete_items('room','<?php echo $rms_id; ?>')"  width="30" height="30" id=''  type='button' class='' data-dismiss='modal' aria-hidden='true' src="./assets/images/cross.png" alt="">
            </div> 
        </div>

    </div>
</div>
<?php }}?>