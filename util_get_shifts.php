<?php 
include 'util_config.php';
include 'util_session.php';

$empid = "";


if(isset($_POST['emp_id'])){
    $empid = $_POST['emp_id'];
}

$html = "";
$pre_date  = date('Y-m-d', strtotime(' -10 day'));
$sql = "SELECT * FROM `tbl_shifts` WHERE assign_to = $empid AND is_completed = 0 AND is_active = 1 AND is_delete = 0 AND date > '$pre_date' ORDER BY 1 DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $html .= '<h4 class="text-dark display_flex_div"><span>'.date("D, M d, Y", strtotime($row['date'])).' '.$row['start_time'].' - '.$row['end_time'].'<br><small>'.$row['title'].'</small></span><span><input class="shift_radio" onclick="radioselected('.$row['sfs_id'].');" type="radio" name="fav_language" value="'.$row['sfs_id'].'" /></span></h4>';
    }
    echo "<div class='amount_div p-3'>".$html."</div>";
}else{
    echo '<h4 class="text-dark">No, Shift Found From Selected Employee, Try Again!</h4>';   
} 
?>