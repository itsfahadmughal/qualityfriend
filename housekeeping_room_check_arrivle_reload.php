<?php
include 'util_config.php';
include 'util_session.php';
$name = "checklist_arrival";
$saved = "";
$checklist_arrival = array();
if(isset($_POST['checklist_arrival'])){
    $checklist_arrival=$_POST['checklist_arrival'];
}
if($saved != "saved"){
    if(sizeof($checklist_arrival) != 0){
        for ($x = 0; $x < sizeof($checklist_arrival); $x++) {
?>

<div class="col-lg-11 col-xlg-11 col-md-11 wm-80">
    <div>
        <input  type="text" value="<?php echo $checklist_arrival[$x]; ?>" class="form-control get-id_a" id="<?php echo $name."_".$x;?>" placeholder="Enter the text"> 
    </div>
</div>
<div class="col-lg-1 col-xlg-1 col-md-1 mt-1 wm-20">
    <button  id='<?php echo "a_".$x?>' onclick='update_list_a(<?php echo $x;?>)' type='button' class='close close-center1'  aria-hidden='true'>×</button>
</div>
<?php

?>

<?php
                                                    }}
} else {
    echo "ok"; 
}
?>