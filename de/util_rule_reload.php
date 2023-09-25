<?php 
include 'util_config.php';
include '../util_session.php';

$type_id="";

if(isset($_POST['type_id'])){
    $type_id=$_POST['type_id'];
}
$rule1 = "";
$rule2 = "";
$rule3 = "";
$rule4 = "";
$rule5 = "";
$rule6 = "";
$rule7 = "";
$rule8 = "";
$rule9 = "";
$rule10 = "";
$rule11 = "";
$rule12 = "";
$rule13 = "";
$rule14 = "" ;
$rule15 = "";
$rule16 = "";
$sql="SELECT * FROM `tbl_rules` where usert_id = $type_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $i=1;
    while($row = mysqli_fetch_array($result)) {
        $rule1 =$row['rule_1'];
        $rule2 = $row['rule_2'];
        $rule3 = $row['rule_3'];
        $rule4 = $row['rule_4'];
        $rule5 = $row['rule_5'];
        $rule6 = $row['rule_6'];
        $rule7 = $row['rule_7'];
        $rule8 = $row['rule_8'];
        $rule9 = $row['rule_9'];
        $rule10 = $row['rule_10'];
        $rule11 = $row['rule_11'];
        $rule12 = $row['rule_12'];
        $rule13 = $row['rule_13'];
        $rule14 = $row['rule_14'];
        $rule15 = $row['rule_15'];
        $rule16 = $row['rule_16'];
    } 
}
?>
<div class="row  <?php if($type_id == 1){ echo "disabled";} ?>" >
    <div class="form-group col-lg-12 col-xlg-12 col-md-12">
        <div class="row div-background p-4">
            <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                <label class="control-label"><strong>Regeln</strong></label>
            </div>
            <div class="form-group col-lg-12 col-xlg-12 col-md-12 div-white-background">
                <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                    <label class="control-label pt-2"><strong>Quality Management</strong></label>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule1" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i"   <?php if($rule1 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Todo und Checklisten anlegen und  bearbeiten</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule2" type="checkbox" 
                                   onclick ="type_update(<?php echo $type_id;?>)"
                                   class="checkbox-size-20 check_box_i" <?php if($rule2 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Handbücher anlegen und bearbeiten</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule3" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule3 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Reparaturen anlegen und bearbeiten</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule4" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule4 == 1){ echo "checked";} ?> >
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Notizen anlegen und bearbeiten</h5>
                    </div>


                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule5" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule5 == 1){ echo "checked";} ?> >
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Übergaben anlegen und bearbeiten</h5>
                    </div>

                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule6" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule6 == 1){ echo "checked";} ?> >
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>User,Teams,Abteilungen anlegen und bearbeiten</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule7" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule7 == 1){ echo "checked";} ?> >
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Mitteilungen senden und empfangen</h5>
                    </div>

                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule8" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule8 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Regeln anlegen und bearbeiten</h5>
                    </div>

                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule12" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule12 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Verwalten Sie Zeitpläne</h5>
                    </div>


                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule15" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule15 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Lohnadministrator</h5>
                    </div>

                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule16" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule16 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Budget &amp; Forecast</h5>
                    </div>


                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule13" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule13 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Housekeeping</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule14" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"

                                   class="checkbox-size-20 check_box_i" <?php if($rule14 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Housekeeping Admin</h5>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-12 col-xlg-12 col-md-12 div-white-background">
                <div class="form-group col-lg-12 col-xlg-12 col-md-12">
                    <label class="control-label pt-2"><strong>Recruiting</strong></label>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule9" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"
                                   class="checkbox-size-20 check_box_i" <?php if($rule9 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Stellenanzeige anlegen und bearbeiten </h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule10" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"
                                   class="checkbox-size-20 check_box_i" <?php if($rule10 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Bewerbungen anlegen und bearbeiten</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule11" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"
                                   class="checkbox-size-20 check_box_i" <?php if($rule11 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Mitarbeiter anlegen und bearbeiten</h5>
                    </div>
                    <div class="col-lg-1 col-xlg-1 col-md-1 pl-3 pb-3 wm-10">
                        <div class="checkbox checkbox-success">
                            <input  id="rule12" type="checkbox" onclick ="type_update(<?php echo $type_id;?>)"
                                   class="checkbox-size-20 check_box_i" <?php if($rule12 == 1){ echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="col-lg-11 col-xlg-11 col-md-11  pb-3 wm-90">
                        <h5>Arbeitszeit anlegen und bearbeiten</h5>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
?>
