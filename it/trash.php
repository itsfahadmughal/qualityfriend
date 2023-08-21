<?php 
require_once 'util_config.php';
require_once '../util_session.php';

$n=0;
$data = array();

$sq1="SELECT crjb_id, title, title_it, title_de, edittime FROM `tbl_create_job` where hotel_id = $hotel_id and is_active = 0";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        if($row['title_it'] != ""){
            $title=$row['title_it'];
        }else if($row['title'] != ""){
            $title=$row['title'];
        }else{
            $title=$row['title_de'];
        }

        $temp = array($row['crjb_id'],$title,$row['edittime'],'Job','tbl_create_job','crjb_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT hdb_id, title, title_it, title_de, edittime FROM `tbl_handbook` where hotel_id = $hotel_id and is_delete";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        if($row['title_it'] != ""){
            $title=$row['title_it'];
        }else if($row['title'] != ""){
            $title=$row['title'];
        }else{
            $title=$row['title_de'];
        }

        $temp = array($row['hdb_id'],$title,$row['edittime'],'Handbook','tbl_handbook','hdb_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT hdo_id, title, title_it, title_de, lastedittime FROM `tbl_handover` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        if($row['title_it'] != ""){
            $title=$row['title_it'];
        }else if($row['title'] != ""){
            $title=$row['title'];
        }else{
            $title=$row['title_de'];
        }

        $temp = array($row['hdo_id'],$title,$row['lastedittime'],'Handover','tbl_handover','hdo_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT nte_id, title, title_it, title_de, lastedittime FROM `tbl_note` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        if($row['title_it'] != ""){
            $title=$row['title_it'];
        }else if($row['title'] != ""){
            $title=$row['title'];
        }else{
            $title=$row['title_de'];
        }

        $temp = array($row['nte_id'],$title,$row['lastedittime'],'Notice','tbl_note','nte_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT rpr_id, title, title_it, title_de, lastedittime FROM `tbl_repair` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        if($row['title_it'] != ""){
            $title=$row['title_it'];
        }else if($row['title'] != ""){
            $title=$row['title'];
        }else{
            $title=$row['title_de'];
        }

        $temp = array($row['rpr_id'],$title,$row['lastedittime'],'Repair','tbl_repair','rpr_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT tdl_id, title, title_it, title_de, edittime FROM `tbl_todolist` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {
        $title="";
        if($row['title_it'] != ""){
            $title=$row['title_it'];
        }else if($row['title'] != ""){
            $title=$row['title'];
        }else{
            $title=$row['title_de'];
        }

        $temp = array($row['tdl_id'],$title,$row['edittime'],'Todolist','tbl_todolist','tdl_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT user_id, firstname, lastname, edittime FROM `tbl_user` where hotel_id = $hotel_id and is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {

        $title=$row['firstname'].' '.$row['lastname'];

        $temp = array($row['user_id'],$title,$row['edittime'],'User','tbl_user','user_id');

        $data[$n] = $temp;
        $n++;

    }   
}

$sq1="SELECT `title`,`sfs_id`,`edittime` FROM `tbl_shifts` WHERE hotel_id = $hotel_id AND is_delete = 1";
$res1 = $conn->query($sq1);

if ($res1 && $res1->num_rows > 0) {

    while($row = mysqli_fetch_array($res1)) {

        $title=$row['title'];

        $temp = array($row['sfs_id'],$title,$row['edittime'],'Shift','tbl_shifts','sfs_id');

        $data[$n] = $temp;
        $n++;

    }   
}


// Comparison function
function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1[2]);
    $datetime2 = strtotime($element2[2]);
    return $datetime2 - $datetime1;
} 

// Sort the array 
usort($data, 'date_compare');



//print_r($data);
//exit;

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
        <title>Cestino</title>
        <!-- This page CSS -->
        <!-- chartist CSS -->
        <link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">
        <!--c3 plugins CSS -->
        <link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../dist/css/style.min.css" rel="stylesheet">
        <!-- Dashboard 1 Page CSS -->
        <link href="../dist/css/pages/dashboard1.css" rel="stylesheet">

        <link href="../dist/css/pages/icon-page.css" rel="stylesheet">

        <link href="../assets/node_modules/tablesaw/dist/tablesaw.css" rel="stylesheet">

        <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Cestino</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <?php include 'util_header.php'; ?>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <?php include 'util_side_nav.php'; ?>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles mb-0 mobile-container-padding">
                        <div class="col-md-3 align-self-center">
                            <h4 class="text-themecolor font-weight-title font-size-title">Cestino</h4>
                        </div>
                        <div class="col-md-7 mtm-5px">
                            <div class="input-group">
                                <input type="text" id="searchInput" placeholder="Cercato da" class="form-control">
                                <div class="input-group-append"><span class="input-group-text"><i class="ti-search"></i></span></div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->



                    <div class="row">

                        <?php if(sizeof($data) != 0){ ?>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pm-0 pt-0 small-screen-pr-0 mobile-container-pl-60">
                                    <div class="table-responsive">
                                        <table id="myTable" style="display:inline-table;" class=" tablesaw table-bordered table-hover table no-wrap" data-tablesaw-mode="stack"
                                               data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap
                                               data-tablesaw-mode-switch>
                                            <thead class="text-center">
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border text-center" ><b>Titolo</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border text-center" ><b>Tipo</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border text-center" ><b> Data &amp; Volta</b></th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border text-center" ><b>Ristabilire</b></th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php
    for($i=0;$i<sizeof($data);$i++){
                                                ?>

                                                <tr>
                                                    <td class="text-center"><?php echo $data[$i][1]; ?></td>

                                                    <td class="text-center"><?php echo $data[$i][3]; ?></td>

                                                    <td class="text-center"><b><?php echo date("d.m.Y", strtotime(substr($data[$i][2],0,10))); ?></b><br><span class="label-light-gray"><?php echo substr($data[$i][2],10); ?></span></td>

                                                    <td class="text-center">
                                                        <h2><i class="mdi mdi-restore cursor-pointer" onclick="restore('<?php echo $data[$i][0]; ?>','<?php echo $data[$i][4]; ?>','<?php echo $data[$i][5]; ?>')"></i></h2>
                                                    </td>
                                                </tr>

                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
}else{
                        ?>
                        <div class="col-lg-12 col-xlg-12 col-md-12 mt-5">
                            <h1 class="text-center pt-5 pb-5">Il cestino è vuoto</h1>
                        </div>
                        <?php
}
                        ?>
                    </div>


                    <?php include 'util_right_nav.php'; ?>
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include 'util_footer.php'; ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap popper Core JavaScript -->
        <script src="../assets/node_modules/popper/popper.min.js"></script>
        <script src="../assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="../dist/js/perfect-scrollbar.jquery.min.js"></script>
        <!--Wave Effects -->
        <script src="../dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="../dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="../dist/js/custom.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="../assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
        <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

        <script>

            function restore(id, table_name, id_name){
                console.log(id,table_name,id_name);
                var status_name = "";
                var status_id = 0;
                if(table_name == 'tbl_create_job'){
                    status_name = "is_active";
                    status_id = 1;
                }else{
                    status_name = "is_delete";
                    status_id = 0;
                }

                Swal.fire({
                    title: 'Sei sicuro?',
                    text: "Non vuoi ripristinare questo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sì, ripristinalo!'
                }).then((result) => {
                    if (result.value) {

                        if(table_name == "tbl_shifts"){
                            $.ajax({
                                url:'util_update_status.php',
                                method:'POST',
                                data:{ tablename:table_name, idname:id_name, id:id, statusid:status_id,statusname: status_name},
                                success:function(response){
                                    console.log(response);
                                    if(response == "Updated"){
                                        $.ajax({
                                            url:'util_update_status.php',
                                            method:'POST',
                                            data:{ tablename:table_name, idname:id_name, id:id, statusid:1,statusname: 'is_active'},
                                            success:function(response){
                                                console.log(response);
                                                if(response == "Updated"){
                                                    Swal.fire({
                                                        title: 'Restaurato',
                                                        type: 'success',
                                                        confirmButtonColor: '#3085d6',
                                                        confirmButtonText: 'Ok'
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            location.replace("trash.php");
                                                        }
                                                    })
                                                }
                                                else{
                                                    Swal.fire({
                                                        type: 'error',
                                                        title: 'Oops...',
                                                        text: 'Qualcosa è andato storto!',
                                                        footer: ''
                                                    });
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(error);
                                            },
                                        });
                                    }
                                    else{
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oops...',
                                            text: 'Qualcosa è andato storto!',
                                            footer: ''
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                },
                            });
                        }else{
                            $.ajax({
                                url:'util_update_status.php',
                                method:'POST',
                                data:{ tablename:table_name, idname:id_name, id:id, statusid:status_id,statusname: status_name},
                                success:function(response){
                                    console.log(response);
                                    if(response == "Updated"){
                                        Swal.fire({
                                            title: 'Restaurato',
                                            type: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok'
                                        }).then((result) => {
                                            if (result.value) {
                                                location.replace("trash.php");
                                            }
                                        })
                                    }
                                    else{
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oops...',
                                            text: 'Qualcosa è andato storto!',
                                            footer: ''
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                },
                            }); 
                        }


                    }
                });




            }

            $(document).ready(function(){
                $("#searchInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

        </script>

        <!-- jQuery peity -->
        <script src="../assets/node_modules/tablesaw/dist/tablesaw.jquery.js"></script>
        <script src="../assets/node_modules/tablesaw/dist/tablesaw-init.js"></script>
    </body>

</html>