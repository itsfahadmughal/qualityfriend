<?php
include 'util_config.php';
include 'util_session.php';
$name = "checklist";
$saved = "";
$checklist= array();
if(isset($_POST['checklist'])){
    $checklist=$_POST['checklist'];
}
if($saved != "saved"){
    if(sizeof($checklist) != 0){
        for ($x = 0; $x < sizeof($checklist); $x++) {
?>

<div class="col-lg-11 col-xlg-11 col-md-11 wm-80">
    <div>
        <input  type="text" value="<?php echo $checklist[$x]; ?>" class="form-control get-id" id="<?php echo $name."_".$x;?>" placeholder="Enter the text"> 
    </div>
</div>
<div class="col-lg-1 col-xlg-1 col-md-1 mt-1 wm-20">
    <button  id='<?php echo $x?>' onclick='update_list(<?php echo $x;?>)' type='button' class='close close-center1'  aria-hidden='true'>×</button>
</div>
<?php

?>

<?php
                                                    }}
} else {
    echo "ok"; 
}
?>