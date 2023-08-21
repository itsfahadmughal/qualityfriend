<?php 
include 'util_config.php';
include '../util_session.php';
$ids="";
$name="";
if(isset($_POST['ids'])){
    $ids=$_POST['ids'];
}
if(isset($_POST['name'])){
    $name=$_POST['name'];
}
if($name == "team"){
    $x = 0;
    $lenth_team = 0;
    $team_id_array = array();
    $sql="SELECT * FROM `tbl_team_map` WHERE`team_id` = $ids ORDER BY user_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            array_push($team_id_array,$row['user_id']);
        } 
    }
    $lenth_team = 0;
    $lenth_team = sizeof($team_id_array);
?>
<div class="row">
    <div class="form-group col-lg-12 col-xlg-12 col-md-12">
        <div class="row div-background p-4">
            <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                <label class="control-label"><strong>Mitarbeiter</strong></label>
            </div>

            <div class="col-lg-12 col-xlg-12 col-md-12 pl-4 pr-4 pb-4">
                <div class="row div-white-background">
                    <div class="col-lg-4 col-xlg-4 col-md-4 pt-4 pb-3">
                        <h5> <strong>Name</strong></h5>
                    </div>
                </div>
                <?php 
    $sql="SELECT `firstname` ,`user_id` FROM `tbl_user` WHERE `hotel_id` = $hotel_id  and is_delete = 0 and is_active = 1 ORDER BY `user_id`";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $i = 0;
        while($row = mysqli_fetch_array($result)) {
            if($row['user_id'] != "" ) {$user = $row['user_id'];} else{$user = 0;};
                ?>
                <div class="row div-white-background mt-3">
                    <div class="col-lg-10 col-xlg-10 col-md-10 pt-4 pb-3 wm-80">
                        <h5> <?php echo $row['firstname']; ?></h5>
                    </div>
                    <div class="col-lg-2 col-xlg-2 col-md-2 pt-4 pb-3 wm-20">
                        <div class="checkbox checkbox-success"> 
                            <input  onclick ="team_update(<?php echo $ids;?>)" value="<?php echo $user; ?>"  id="<?php echo "active_".$x ?>" type="checkbox" 
                                   class="checkbox-size-20 check_box_i" 
                                   <?php if($lenth_team != 0 && $i < $lenth_team){ 
                    if($team_id_array[$i] == $user){
                        echo "checked";
                        $i= $i +1;
                    }
                } 
                                   ?>
                                   >
                        </div>
                    </div>
                </div>
                <?php
            $x= $x +1;

        }   
    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
}else if($name == "department"){
    $x = 0;
?>
<div class="row">
    <div class="form-group col-lg-12 col-xlg-12 col-md-12">
        <div class="row div-background p-4">
            <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                <label class="control-label"><strong>Mitarbeiter</strong></label>
            </div>

            <div class="col-lg-12 col-xlg-12 col-md-12 pl-4 pr-4 pb-4">
                <div class="row div-white-background">
                    <div class="col-lg-4 col-xlg-4 col-md-4 pt-4 pb-3">
                        <h5> <strong>Name</strong></h5>
                    </div>
                </div>
                <?php 
//    $sql="SELECT `firstname` ,`usert_id`,`depart_id` FROM `tbl_user` WHERE `hotel_id` = $hotel_id";
    $sql = "SELECT `firstname` ,`user_id`,`depart_id` FROM `tbl_user` WHERE `hotel_id` = $hotel_id and is_delete = 0 and is_active = 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
                ?>
                <div class="row div-white-background mt-3">
                    <div class="col-lg-10 col-xlg-10 col-md-10 pt-4 pb-3 wm-80">
                        <h5> <?php echo $row['firstname']; ?></h5>
                    </div>
                    <div class="col-lg-2 col-xlg-2 col-md-2 pt-4 pb-3 wm-20">
                        <div class="checkbox checkbox-success">
                            <input onclick ="department_update(<?php echo $ids;?>)" value="<?php echo $row['user_id']; ?>" 
                                   id="<?php echo "actived_".$x ?>" type="checkbox" 
                                   class="checkbox-size-20 check_box_d" 
                                   <?php if($ids == $row['depart_id'] ){
                    echo "checked";
                } ?>  >
                        </div>
                    </div>
                </div>
                <?php
            $x= $x +1;
        }   
    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
}

?>
