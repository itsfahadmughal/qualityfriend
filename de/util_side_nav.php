<aside class="left-sidebar">
    <div class="d-flex no-block nav-text-box align-items-center">
        <span><img src="../assets/images/logo-icon.png" width="30px" height="30px" alt="elegant admin template"></span>
        <a class="nav-lock waves-effect waves-dark ml-auto hidden-md-down" href="javascript:void(0)"><i class="mdi mdi-toggle-switch"></i></a>
        <a class="nav-toggler waves-effect waves-dark ml-auto hidden-sm-up" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
    </div>
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="" href="dashboard.php" aria-expanded="false"><i class="icon-home"></i><span class="hide-menu">Dashboard</span></a>
                </li>

                <?php  if($recruiting_flag  == 1){ ?>
                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'edit_job.php' || basename($_SERVER['PHP_SELF']) == 'application_detail.php' || basename($_SERVER['PHP_SELF']) == 'employees_detail.php'){ echo 'selected'; }else{ echo ''; } ?>" > <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-format-float-none"></i><span class="hide-menu">Recruiting</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'edit_job.php' || basename($_SERVER['PHP_SELF']) == 'application_detail.php' || basename($_SERVER['PHP_SELF']) == 'employees_detail.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?>">
                        <?php if($Create_edit_job_ad == 1 || $usert_id == 1){ ?>
                        <li><a href="create_job.php">Stellenanzeige erstellen<i class="mdi mdi-plus-circle"></i></a></li>

                        <li><a href="campaign.php">Tracking-Kampagne<i class="ti ti-target"></i></a></li>
                        <?php } ?>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'edit_job.php'){ echo 'active'; }else{ echo ''; } ?>" ><a href="jobs.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'edit_job.php'){ echo 'active'; }else{ echo ''; } ?>"  >Aktive Stellenanzeigen<i class="mdi mdi-tooltip-edit"></i></a></li>
                        <?php if($Create_edit_job_ad == 1 || $usert_id == 1){ ?>
                        <li><a href="job_drafted.php">Entwürfe Stellenanzeigen<i class="mdi mdi-arrange-bring-forward"></i></a></li>
                        <li><a href="job_archived.php">Archivierte Stellenanzeigen<i class="mdi mdi-archive"></i></a></li>
                        <?php }  if($Create_view_edit_applications == 1 || $usert_id == 1){ ?>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'application_detail.php'){ echo 'active'; }else{ echo ''; } ?>" ><a href="applications.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'application_detail.php'){ echo 'active'; }else{ echo ''; } ?>" >Bewerbungen <i class="mdi mdi-clipboard-text"></i></a></li>
                        <li><a href="archived_application.php">Archivierte Bewerbungen<i class="ti-archive"></i></a></li>

                        <?php } if($Create_view_edit_employees == 1 || $usert_id == 1){ ?>
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'employees_detail.php'){ echo 'active'; }else{ echo ''; } ?>"><a href="employees.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'employees_detail.php'){ echo 'active'; }else{ echo ''; } ?>" >Mitarbeiter<i class="ti-user"></i></a></li>
                        <li><a href="employees_retired.php">Mitarbeiter ausgeschieden<i class="mdi mdi-account"></i></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php }
                if($handover_flag == 1){
                ?>


                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'handover_create.php' || basename($_SERVER['PHP_SELF']) == 'handover_detail.php' || basename($_SERVER['PHP_SELF']) == 'handover_edit.php'){ echo 'selected'; }else{ echo ''; } ?>" > <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-hands-helping"></i><span class="hide-menu">Übergaben</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'handover_create.php' || basename($_SERVER['PHP_SELF']) == 'handover_detail.php' || basename($_SERVER['PHP_SELF']) == 'handover_edit.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?> ">

                        <li class="<?php  if(basename($_SERVER['PHP_SELF']) == 'handover_create.php' || basename($_SERVER['PHP_SELF']) == 'handover_detail.php' || basename($_SERVER['PHP_SELF']) == 'handover_edit.php'){ echo 'active'; }else{ echo ''; } ?>"><a href="handover.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'handover_create.php' || basename($_SERVER['PHP_SELF']) == 'handover_detail.php' || basename($_SERVER['PHP_SELF']) == 'handover_edit.php'){ echo 'active'; }else{ echo ''; } ?>">Aktive Übergaben<i class="fas fa-handshake"></i></a></li>


                        <li><a href="handover_completed.php">Abgeschlossen Übergaben<i class="fas fa-hand-rock"></i></a></li>

                        <?php if($Create_edit_handovers == 1 || $usert_id == 1){ ?>
                        <li><a href="handover_drafted.php">Entwürfe Übergaben<i class="fas fa-hand-holding"></i></a></li> 
                        <?php } ?>
                    </ul>
                </li>

                <?php }
                if($handbook_flag == 1){
                ?>

                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'handbook_detail.php' || basename($_SERVER['PHP_SELF']) == 'edit_handbook.php' || basename($_SERVER['PHP_SELF']) == 'create_handbook.php'){ echo 'selected'; }else{ echo ''; } ?>" > <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-book"></i><span class="hide-menu">Handbücher</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'handbook_detail.php' || basename($_SERVER['PHP_SELF']) == 'edit_handbook.php' || basename($_SERVER['PHP_SELF']) == 'create_handbook.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?>" >
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'handbook_detail.php' || basename($_SERVER['PHP_SELF']) == 'edit_handbook.php' || basename($_SERVER['PHP_SELF']) == 'create_handbook.php'){ echo 'active'; }else{ echo ''; } ?>" ><a href="handbook.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'handbook_detail.php' || basename($_SERVER['PHP_SELF']) == 'edit_handbook.php' || basename($_SERVER['PHP_SELF']) == 'create_handbook.php'){ echo 'active'; }else{ echo ''; } ?>" >Aktive Handbücher<i class="mdi mdi-plus-circle"></i></a></li>
                        <?php if($Create_edit_handbooks == 1 || $usert_id == 1){ ?>
                        <li><a href="handbook_drafted.php">Entwürfe Handbücher<i class="mdi mdi-tooltip-edit"></i></a></li> 
                        <?php } ?>
                    </ul>
                </li>
                <?php }
                if($checklist_flag == 1){
                ?>

                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'create_todo_checklist.php' || basename($_SERVER['PHP_SELF']) == 'todo_check_list_detail.php' || basename($_SERVER['PHP_SELF']) == 'edittodo_check_list.php'){ echo 'selected'; }else{ echo ''; } ?>" > <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-clipboard-check"></i><span class="hide-menu">Todo/Checklisten</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'create_todo_checklist.php' || basename($_SERVER['PHP_SELF']) == 'todo_check_list_detail.php' || basename($_SERVER['PHP_SELF']) == 'edittodo_check_list.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?>" >
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'create_todo_checklist.php' || basename($_SERVER['PHP_SELF']) == 'todo_check_list_detail.php' || basename($_SERVER['PHP_SELF']) == 'edittodo_check_list.php'){ echo 'active'; }else{ echo ''; } ?>" ><a href="todo_check_list.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'create_todo_checklist.php' || basename($_SERVER['PHP_SELF']) == 'todo_check_list_detail.php' || basename($_SERVER['PHP_SELF']) == 'edittodo_check_list.php'){ echo 'active'; }else{ echo ''; } ?>" > Erstellte Todo/Checklisten<i class="fas fa-check-circle"></i></a></li>


                        <li><a href="todo_check_list_completed.php">Todo Abgeschlossen<i class="fas fa-paste"></i></a></li> 


                        <?php if($Create_edit_todo_checklist == 1 || $usert_id == 1){ ?>
                        <li><a href="todo_checklist_drafted.php">Entwürfe Todo/Checklisten<i class="fas fa-calendar-check"></i></a></li> 
                        <?php } ?>
                    </ul>
                </li>
                <?php }
                if($notices_flag == 1){
                ?>


                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'notice_create.php' || basename($_SERVER['PHP_SELF']) == 'notice_detail.php' || basename($_SERVER['PHP_SELF']) == 'notices_edit.php'){ echo 'selected'; }else{ echo ''; } ?>" > <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-readme"></i><span class="hide-menu">Notizen</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'notice_create.php' || basename($_SERVER['PHP_SELF']) == 'notice_detail.php' || basename($_SERVER['PHP_SELF']) == 'notices_edit.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?>" >
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'notice_create.php' || basename($_SERVER['PHP_SELF']) == 'notice_detail.php' || basename($_SERVER['PHP_SELF']) == 'notices_edit.php'){ echo 'active'; }else{ echo ''; } ?>"><a href="notices.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'notice_create.php' || basename($_SERVER['PHP_SELF']) == 'notice_detail.php' || basename($_SERVER['PHP_SELF']) == 'notices_edit.php'){ echo 'active'; }else{ echo ''; } ?>">Erstellte Notizen<i class="fab fa-digital-ocean"></i></a></li>
                        <?php if($Create_edit_notices == 1 || $usert_id == 1){ ?>
                        <li><a href="notices_drafted.php">Entwürfe Notizen<i class="fab fa-draft2digital"></i></a></li> 
                        <?php } ?>
                    </ul>
                </li>
                <?php }
                if($repairs_flag == 1){
                ?>

                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'repair_detail.php' || basename($_SERVER['PHP_SELF']) == 'repair_edit.php' || basename($_SERVER['PHP_SELF']) == 'repair_create.php'){ echo 'selected'; }else{ echo ''; } ?>"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-wrench"></i><span class="hide-menu">Reparaturen</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'repair_detail.php' || basename($_SERVER['PHP_SELF']) == 'repair_edit.php' || basename($_SERVER['PHP_SELF']) == 'repair_create.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?>">
                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'repair_detail.php' || basename($_SERVER['PHP_SELF']) == 'repair_edit.php' || basename($_SERVER['PHP_SELF']) == 'repair_create.php'){ echo 'active'; }else{ echo ''; } ?>"><a href="repairs.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'repair_detail.php' || basename($_SERVER['PHP_SELF']) == 'repair_edit.php' || basename($_SERVER['PHP_SELF']) == 'repair_create.php'){ echo 'active'; }else{ echo ''; } ?>">Erstellte Reparaturen<i class="fas fa-plus-circle"></i></a></li>


                        <li><a href="repairs_completed.php">Reparaturen abgeschlossen<i class="fab fa-empire"></i></a></li>


                        <?php if($Create_edit_repairs == 1 || $usert_id == 1){ ?>
                        <li><a href="repairs_drafted.php">Entwürfe Reparaturen<i class="fab fa-firstdraft"></i></a></li> 
                        <?php } ?>
                    </ul>
                </li>
                <?php }
                if($housekeeping_flag == 1){
                ?>


                <?php if($housekeeping == 1 || $housekeeping_admin == 1){ ?>

                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'housekeeping.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_settings.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_rooms_detail.php'  || basename($_SERVER['PHP_SELF']) == 'cleaning.php'){ echo 'selected'; }else{ echo ''; } ?>" > <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-broom"></i><span class="hide-menu">Housekeeping</span></a>
                    <ul aria-expanded="false" class="<?php if(basename($_SERVER['PHP_SELF']) == 'housekeeping.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_rooms_detail.php' || basename($_SERVER['PHP_SELF']) == 'cleaning.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_settings.php'){ echo 'collapse in'; }else{ echo 'collapse'; } ?>" >

                        <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'housekeeping.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_rooms_detail.php' || basename($_SERVER['PHP_SELF']) == 'cleaning.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_settings.php'){ echo 'active'; }else{ echo ''; } ?>"><a href="housekeeping.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'housekeeping.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_rooms_detail.php' || basename($_SERVER['PHP_SELF']) == 'housekeeping_settings.php' || basename($_SERVER['PHP_SELF']) == 'cleaning.php'){ echo 'active'; }else{ echo ''; } ?>">Housekeeping<i class="mdi mdi-broom"></i></a></li>


                        <li><a href="housekeeping_extrajob_complete.php">Abgeschlossene Zusatzaufgaben</a></li> 
                    </ul>
                </li>
                <?php } }

                if($time_schedule_flag == 1){
                ?>
                <!--Time Schedule Start-->

                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'schedules.php' || basename($_SERVER['PHP_SELF']) == 'add_time_off.php' || basename($_SERVER['PHP_SELF']) == 'my_schedules.php' || basename($_SERVER['PHP_SELF']) == 'add_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'engage.php' || basename($_SERVER['PHP_SELF']) == 'shift_pool.php' || basename($_SERVER['PHP_SELF']) == 'off_time.php' || basename($_SERVER['PHP_SELF']) == 'edit_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'schedule_settings.php' || basename($_SERVER['PHP_SELF']) == 'edit_schedule.php' || basename($_SERVER['PHP_SELF']) == 'edit_schedule_event.php' || basename($_SERVER['PHP_SELF']) == 'pre_defined_shifts.php') {
                    echo 'selected';
                } else {
                    echo '';
                } ?>">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-timeline"></i><span class="hide-menu">Dienstplanung</span></a>
                    <ul aria-expanded="false" class="<?php if (basename($_SERVER['PHP_SELF']) == 'schedules.php' || basename($_SERVER['PHP_SELF']) == 'add_time_off.php' || basename($_SERVER['PHP_SELF']) == 'my_schedules.php' || basename($_SERVER['PHP_SELF']) == 'add_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'engage.php' || basename($_SERVER['PHP_SELF']) == 'shift_pool.php' || basename($_SERVER['PHP_SELF']) == 'off_time.php' || basename($_SERVER['PHP_SELF']) == 'edit_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'schedule_settings.php' || basename($_SERVER['PHP_SELF']) == 'edit_schedule.php' || basename($_SERVER['PHP_SELF']) == 'edit_schedule_event.php' || basename($_SERVER['PHP_SELF']) == 'pre_defined_shifts.php') {
                    echo 'collapse in';
                } else {
                    echo 'collapse';
                } ?>">

                        <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { ?> 
                        <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'schedules.php') {
                    echo 'active';
                } else {
                    echo '';
                } ?>" ><a class="<?php if (basename($_SERVER['PHP_SELF']) == 'schedules.php'  || basename($_SERVER['PHP_SELF']) == 'schedule_settings.php' || basename($_SERVER['PHP_SELF']) == 'edit_schedule.php' || basename($_SERVER['PHP_SELF']) == 'edit_schedule_event.php' || basename($_SERVER['PHP_SELF']) == 'pre_defined_shifts.php') {
                    echo 'active';
                } else {
                    echo '';
                } ?>" href="schedules.php">Dienstplan erstellen<i class="mdi mdi-timetable"></i></a></li> <?php } ?>

                        <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'my_schedules.php') {
                    echo 'active';
                } else {
                    echo '';
                } ?>" ><a class="<?php if (basename($_SERVER['PHP_SELF']) == 'my_schedules.php') {
                    echo 'active';
                } else {
                    echo '';
                } ?>" href="my_schedules.php">Mein Plan<i class="mdi mdi-table-column-width"></i></a></li>

                        <?php   if ($Create_view_schedules == 1 || $usert_id == 1) { ?> <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'engage.php') {
                    echo 'active';
                } else {
                    echo '';
                } ?>"><a class="<?php if (basename($_SERVER['PHP_SELF']) == 'engage.php') {
                    echo 'active';
                } else {
                    echo '';
                } ?>" href="engage.php">Stastiken<i class="mdi mdi-emoticon"></i></a></li> <?php } ?>


                        <?php $sql_check = "SELECT * FROM `tbl_time_schedule_rules` WHERE hotel_id = $hotel_id AND 	is_shift_pool_enable = 0";
                    $result_check = $conn->query($sql_check);
                    if($result_check && $result_check->num_rows > 0){
                        if ($Create_view_schedules == 1 || $usert_id == 1) {
                        ?>
                        <li><a href="shift_pool.php">Shift Pool<i class="fas fa-life-ring"></i></a></li>
                        <?php
                        }
                    }else{
                        ?>
                        <li><a href="shift_pool.php">Shift Pool<i class="fas fa-life-ring"></i></a></li>
                        <?php
                    } ?>


                        <?php $sql_check = "SELECT * FROM `tbl_time_schedule_rules` WHERE hotel_id = $hotel_id AND 	is_time_off_enable = 0";
                    $result_check = $conn->query($sql_check);
                    if($result_check && $result_check->num_rows > 0){
                        if ($Create_view_schedules == 1 || $usert_id == 1) {
                        ?>
                        <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'off_time.php' || basename($_SERVER['PHP_SELF']) == 'add_time_off.php' || basename($_SERVER['PHP_SELF']) == 'add_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'edit_blocked_day.php') {
                            echo 'active';
                        } else {
                            echo '';
                        } ?>"><a href="off_time.php?slug=flag" class="<?php if (basename($_SERVER['PHP_SELF']) == 'off_time.php' || basename($_SERVER['PHP_SELF']) == 'add_time_off.php' || basename($_SERVER['PHP_SELF']) == 'add_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'edit_blocked_day.php') {
                            echo 'active';
                        } else {
                            echo '';
                        } ?>" >Abwesenheiten<i class="mdi mdi-clock"></i></a></li>
                        <?php
                        }
                    }else{
                        ?>
                        <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'off_time.php' || basename($_SERVER['PHP_SELF']) == 'add_time_off.php' || basename($_SERVER['PHP_SELF']) == 'add_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'edit_blocked_day.php') {
                            echo 'active';
                        } else {
                            echo '';
                        } ?>"><a href="off_time.php?slug=flag" class="<?php if (basename($_SERVER['PHP_SELF']) == 'off_time.php' || basename($_SERVER['PHP_SELF']) == 'add_time_off.php' || basename($_SERVER['PHP_SELF']) == 'add_blocked_day.php' || basename($_SERVER['PHP_SELF']) == 'edit_blocked_day.php') {
                            echo 'active';
                        } else {
                            echo '';
                        } ?>" >Abwesenheiten<i class="mdi mdi-clock"></i></a></li>
                        <?php
                    } 
                    if ($wage_admin == 1 || $usert_id == 1) {
                        ?>
                        <li><a href="reports.php">Reports<i class="far fa-chart-bar"></i></a></li>
                        <?php } ?>


                    </ul>
                </li>

                <?php } ?>

                <!--Time Schedule End-->

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>