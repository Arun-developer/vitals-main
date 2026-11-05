<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $innovation['name_of_enterprise'] . ' - Assessment Summary', 'page_table' => 'datatable', 'module' => 'leave_summary')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'pre_assitant', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span> -->
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                </div>
                <?php if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge)) { ?>
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_scoring/' . $application_id; ?>">Assessment Scoring</a></li>
                                    <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/assessment_summary/' . $application_id; ?>">Assessment Summary</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                    <form name="assess_summary" id="assess_summary" action="<?php echo site_url('application/store_summary'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                <?php
								$innovationID = $innovation['id'];
                                if (php72_in_array($this->session->userdata('emp_number'), $active_incharge) && $inno_status != '3' && $inno_status != '9' && $inno_status != '7') {
                                    $readonly1 = '';
                                    $disabled1 = '';
                                    $display1 = '';
                                    $class1 = 'multiselect';
                                    $width1 = '';
                                    $c_pointer = '';
                                } else {
									if($innovationID!='285455'){
										$readonly1 = "readonly='readonly'";
										$disabled1 = 'disabled="disabled"';
										$display1 = 'style = "display:none"';
										$class1 = '';
										$width1 = 'style="width:200px"';
										$c_pointer = 'style="pointer-events: none;"';
									}
                                }
                                if ($this->session->userdata('emp_number') == $cio_emp_num && $inno_status != '3' && $inno_status != '9' && $inno_status != '7' && $inno_status == '6' && isset($feed_back[0]['result']) && $feed_back[0]['result'] == 'Accept') {
                                    $readonly = '';
                                    $disabled = '';
                                    $display = '';
                                    $class = 'multiselect';
                                    $width = '';
                                } else if ($assigned_incharge[0] == $cio_emp_num && $inno_status == '1') {
                                    $readonly = '';
                                } else {
									if($innovationID!='285455'){
										$readonly = "readonly='readonly'";
										$disabled = 'disabled="disabled"';
										$display = 'style = "display:none"';
										$class = '';
										$width = 'style="width:200px"';
									}
                                }
                                ?>

                                <table class="table table-hover dt-responsive" id="summary_table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Parameters</th>
                                            <?php
                                            $innovationID = $innovation['id'];
                                            $exist_date = date("d-m-Y", strtotime($iic_log_detail[0]['modified_date']));
                                            $current_date = date("d-m-Y");
                                            $set_current_date = date("Y-m-d");
                                            $iic_exist_date = isset($iic_log_detail[0]['modified_date']) && $iic_log_detail[0]['modified_date'] != '' && $iic_log_detail[0]['modified_date'] != '0000-00-00 00:00:00' ? $exist_date : $current_date;
                                            $iic_save_date = date("d-m-Y", strtotime($feed_back[0]['internal_date']));
                                            $iic_date = isset($feed_back[0]['internal_date']) && $feed_back[0]['internal_date'] != '' && $feed_back[0]['internal_date'] != '0000-00-00 00:00:00' ? $iic_save_date : $iic_exist_date;

                                            $exist_save_date = isset($feed_back[0]['internal_date']) && $feed_back[0]['internal_date'] != '' && $feed_back[0]['internal_date'] != '0000-00-00 00:00:00' ? $feed_back[0]['internal_date'] : $set_current_date;
                                            $find_set_iic = isset($iic_log_detail[0]['modified_date']) && $iic_log_detail[0]['modified_date'] != '' && $iic_log_detail[0]['modified_date'] != '0000-00-00 00:00:00' ? $iic_log_detail[0]['modified_date'] : $exist_save_date;
                                            $already_set_iic = date("d-M-Y", strtotime($find_set_iic));

                                            if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                                $final_assigned_incharge = array();
                                                $temp_assigned_incharge = $assigned_incharge;
                                                $check_pard_user = $this->Massessment->getInactivePARDuser($innovationID, $assigned_incharge);
                                                foreach ($check_pard_user as $active_user) {
                                                    array_push($final_assigned_incharge, $active_user['associate_employee']);
                                                    unset($temp_assigned_incharge[php72_array_search($active_user['associate_employee'], $temp_assigned_incharge)]);
                                                }

                                                if (php72_count($temp_assigned_incharge) > 0) {
                                                    foreach ($temp_assigned_incharge as $active_user_id) {
                                                        $inactive_user_score = $this->Massessment->getInactiveUserScore($innovationID, $active_user_id);
                                                        array_push($final_assigned_incharge, $inactive_user_score[0]['assesst_by']);
                                                    }
                                                }
                                                $assigned = count(array_filter($final_assigned_incharge));
                                                for ($a = 0; $a < $assigned; $a++) {
                                                    if($final_assigned_incharge[$a] != '') {
                                                        $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $final_assigned_incharge[$a]);
                                                        if (empty($assigned_score)) {
                                                            $assigned_score[] = 0;
                                                        }

                                                        if (!empty($assigned_score)) {
                                                            ?>
                                                            <th style="text-align: left;">
                                                                <?php
                                                                $ass_user = $this->Muser->getUsersList($final_assigned_incharge[$a]);
                                                                $url = site_url("assessment/view_assesst_detail/" . $final_assigned_incharge[$a] . "/" . $application_id . "/0/1");
                                                                ?>
                                                                <a class='individual_form' href='javascript:void(0)' onclick="scoreDetail(<?= $ass_user[0]['id']; ?>)" style='text-decoration:none;color:#fff'><?= $ass_user[0]['emp_name']; ?></a>
                                                            </th>

                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php
                                            $emp = array();
                                            if (isset($assessor) && !empty($assessor)) {
                                                $empl = unserialize($assessor[0]['assessor_id']);
                                                $status = unserialize($assessor[0]['status']);
                                                $e = 0;
                                                $s = 0;

                                                foreach ($status as $stat) {
                                                    if ($stat == 1) {
                                                        $emp[$s] = $empl[$e];
                                                        $s++;
                                                    }
                                                    $e++;
                                                }
                                            }

                                            $count = 0;
                                            if (!empty($emp)) {
                                                $count = count($emp);
                                            }

                                            $j = 2;
                                            for ($i = 0; $i < $count; $i++) {
                                                $ass_score = array();
                                                $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);

                                                if (!empty($assesst_sub)) {
                                                    ?>
                                                    <th>
                                                        <?php
                                                        $ass_asse = $this->Muser->getUsersList($emp[$i]);
                                                        $url = site_url("assessment/view_assesst_detail/" . $emp[0] . "/" . $application_id . "/0/1");

                                                        if ($this->session->userdata('emp_number') == $cio_emp_num && $inno_status != '7' && $inno_status != '9' && $inno_status != '3' && $inno_status == '6' && isset($feed_back[0]['result']) && $feed_back[0]['result'] == 'Accept') {
                                                            ?>
                                                            <a href="#" title="Transfer Score" class="transfer" data="<?php echo $emp[$i]; ?>" style="float:left"><img style="margin-bottom:-6px;" src="<?php echo base_url(); ?>source/images/images1.jpg" /></a> &nbsp;
                                                            <?php
                                                        }
                                                        ?>
                                                        <a class='individual_form' href='javascript:void(0)' style='text-decoration:none;color:#fff'><?= $ass_asse[0]['emp_name']; ?></a>
                                                    </th>
                                                    <?php
                                                }
                                                $j++;
                                            }
                                            ?>
                                            <th>Rationale</th>
                                            <th>Risk</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $error_msg = array();
                                            $k = 0;
                                            foreach ($area as $area) {
                                                if (isset($feed_back) && !empty($feed_back)) {
                                                    $feed_score = unserialize($feed_back[0]['area_score']);
                                                    $feed_rational = unserialize($feed_back[0]['rational']);
                                                    $feed_risk = unserialize($feed_back[0]['risk']);
                                                }
                                                if (isset($assesst)) {
                                                    $score = unserialize($assesst[0]['score']);
                                                    $rational = unserialize($assesst[0]['rational']);
                                                    $risk = unserialize($assesst[0]['risk']);
                                                }
                                                $k++;
                                                ?>
                                                <tr class="in-child">
                                                    <td id="sno"><?php echo $k; ?></td>
                                                    <td id="param"><?php echo $area['Name']; ?></td>
                                                    <?php
                                                    if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                                        $final_assigned_incharge = array();
                                                        $temp_assigned_incharge = $assigned_incharge;
                                                        $check_pard_user = $this->Massessment->getInactivePARDuser($innovationID, $assigned_incharge);
                                                        foreach ($check_pard_user as $active_user) {
                                                            array_push($final_assigned_incharge, $active_user['associate_employee']);
                                                            unset($temp_assigned_incharge[php72_array_search($active_user['associate_employee'], $temp_assigned_incharge)]);
                                                        }
                                                        if (php72_count($temp_assigned_incharge) > 0) {
                                                            foreach ($temp_assigned_incharge as $active_user_id) {
                                                                $inactive_user_score = $this->Massessment->getInactiveUserScore($innovationID, $active_user_id);
                                                                array_push($final_assigned_incharge, $inactive_user_score[0]['assesst_by']);
                                                            }
                                                        }

                                                        $assigned = count(array_filter($final_assigned_incharge));
                                                        $rationala = array();
                                                        $riska = array();
                                                        for ($a = 0; $a < $assigned; $a++) {
                                                            if($final_assigned_incharge[$a] != '') {
                                                                $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $final_assigned_incharge[$a]);
                                                                $scorea = unserialize($assigned_score[0]['score']);
                                                                $comment[$final_assigned_incharge[$a]] = $assigned_score[0]['comment'];
                                                                $rationala[$final_assigned_incharge[$a]] = unserialize($assigned_score[0]['rational']);
                                                                $riska[$final_assigned_incharge[$a]] = unserialize($assigned_score[0]['risk']);
                                                                $sub_cat_score = $this->Massessment->getSubAssesst($assigned_score[0]['id']);
                                                                foreach ($sub_cat_score as $sub_cat) {
                                                                    $sub_scores = unserialize($sub_cat['sub_score']);
                                                                    foreach ($sub_scores as $ss) {
                                                                        if ($ss == '') {
                                                                            $error_msg[] = $final_assigned_incharge[$a];
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <td><span class="score1"><?php echo (isset($scorea[$area['id']])) && $scorea[$area['id']] != '' ? $scorea[$area['id']] : '-'; ?></span></td>
                                                                <?php
                                                            }
                                                        }
                                                        $comment_count = php72_count($comment);
                                                        $assigned_comment = '';

                                                        for ($l = 0; $l < $comment_count; $l++) {
                                                            $username = $this->Massessment->getEmpName($final_assigned_incharge[$l]);
                                                            $user = explode(' ', $username);
                                                            if ($comment[$final_assigned_incharge[$l]] != '') {
                                                                $assigned_comment .= $user[0] . ' : ' . $comment[$final_assigned_incharge[$l]] . "\r\n\n";
                                                            }
                                                        }

                                                        $assigned_count = count($rationala);
                                                        $assigned_rational_val = '';
                                                        for ($i = 0; $i < $assigned_count; $i++) {
                                                            $username = $this->Massessment->getEmpName($final_assigned_incharge[$i]);
                                                            $user = explode(' ', $username);
                                                            if ($rationala[$final_assigned_incharge[$i]][$area['id']] != '') {
                                                                $assigned_rational_val .= $user[0] . ' : ' . $rationala[$final_assigned_incharge[$i]][$area['id']] . "\r\n\n";
                                                            }
                                                        }
                                                        $assigned_risk_val = '';
                                                        for ($i = 0; $i < $assigned_count; $i++) {
                                                            $username = $this->Massessment->getEmpName($final_assigned_incharge[$i]);
                                                            $user = explode(' ', $username);
                                                            if ($riska[$final_assigned_incharge[$i]][$area['id']] != '') {
                                                                $assigned_risk_val .= $user[0] . ' : ' . $riska[$final_assigned_incharge[$i]][$area['id']] . "\r\n\n";
                                                            }
                                                        }
                                                    }

                                                    $ass_rational = array();
                                                    $ass_risk = array();
                                                    for ($i = 0; $i < $count; $i++) {
                                                        $ass_score = array();
                                                        $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);
                                                        if ($emp[$i] && empty($assesst_sub)) {
                                                            $error_msg[] = $emp[$i];
                                                        }
                                                        if (!empty($assesst_sub)) {
                                                            $ass_score = unserialize($assesst_sub[0]['score']);
                                                            $ass_rational[$emp[$i]] = unserialize($assesst_sub[0]['rational']);
                                                            $ass_risk[$emp[$i]] = unserialize($assesst_sub[0]['risk']);
                                                            $sub_cat_as_score = $this->Massessment->getSubAssesst($assesst_sub[0]['id']);
                                                            foreach ($sub_cat_as_score as $sub_as_cat) {
                                                                $sub_as_scores = unserialize($sub_as_cat['sub_score']);
                                                                foreach ($sub_as_scores as $ass) {
                                                                    if ($ass == '') {
                                                                        $error_msg[] = $emp[$i];
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <td><span class="score1"><?php
                                                            if (isset($ass_score[$area['id']])) {
                                                                echo $ass_score[$area['id']];
                                                            } else {
                                                                echo '1';
                                                            }
                                                            ?></span></td>
                                                            <?php
                                                        }
                                                        $j++;
                                                    }
                                                    $ass_count = count($ass_rational);
                                                    $ass_rational_val = '';
                                                    for ($i = 0; $i < $ass_count; $i++) {
                                                        $username = $this->Massessment->getEmpName($emp[$i]);
                                                        $user = explode(' ', $username);
                                                        $ass_rational_val .= $user[0] . ' : ' . $ass_rational[$emp[$i]][$area['id']] . "\r\n";
                                                    }
                                                    $ass_risk_val = '';
                                                    for ($i = 0; $i < $ass_count; $i++) {
                                                        $username = $this->Massessment->getEmpName($emp[$i]);
                                                        $user = explode(' ', $username);
                                                        $ass_risk_val .= $user[0] . ' : ' . $ass_risk[$emp[$i]][$area['id']] . "\r\n";
                                                    }
                                                    ?>


                                                    <td><textarea class="pre-input rational" cols="30" rows="3" name="rational[<?php echo $area['id']; ?>]" id="rational_<?php echo $area['id']; ?>" <?php echo $readonly; ?>><?php
                                                    if (isset($feed_rational[$area['id']])) {
                                                        $r_explode = explode(":", $feed_rational[$area['id']]);
                                                    }

                                                    if (trim($r_explode[1]) != '') {
                                                        echo $feed_rational[$area['id']] . "\r\n";
                                                    } else {
                                                        if (isset($assigned_rational_val) && $assigned_rational_val != '') {
                                                            echo $assigned_rational_val;
                                                        }

                                                        if (isset($ass_rational_val) && $ass_rational_val != '') {
                                                            echo $ass_rational_val;
                                                        }
                                                    }
                                                    ?></textarea></td>
                                                    <td><textarea class="pre-input risk" cols="30" rows="3" name="risk[<?php echo $area['id']; ?>]" id="risk_<?php echo $area['id']; ?>" <?php echo $readonly; ?>><?php
                                                    if (isset($feed_risk[$area['id']])) {
                                                        $explode = explode(":", $feed_risk[$area['id']]);
                                                        if (trim($explode[1]) != '') {
                                                            echo $feed_risk[$area['id']] . "\r\n";
                                                        }
                                                    } else {
                                                        if (isset($assigned_risk_val) && $assigned_risk_val != '') {
                                                            echo $assigned_risk_val;
                                                        }

                                                        if (isset($ass_risk_val) && $ass_risk_val != '') {
                                                            echo $ass_risk_val;
                                                        }
                                                    }
                                                    ?></textarea></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <tr class="parent">
                                                <td></td>
                                                <td>
                                                    <strong>Total</strong>
                                                </td>

                                                <?php
                                                if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                                    $final_assigned_incharge = array();
                                                    $temp_assigned_incharge = $assigned_incharge;
                                                    $check_pard_user = $this->Massessment->getInactivePARDuser($innovationID, $assigned_incharge);
                                                    foreach ($check_pard_user as $active_user) {
                                                        array_push($final_assigned_incharge, $active_user['associate_employee']);
                                                        unset($temp_assigned_incharge[php72_array_search($active_user['associate_employee'], $temp_assigned_incharge)]);
                                                    }
                                                    if (php72_count($temp_assigned_incharge) > 0) {
                                                        foreach ($temp_assigned_inchare as $active_user_id) {
                                                            $inactive_user_score = $this->Massessment->getInactiveUserScore($innovationID, $active_user_id);
                                                            array_push($final_assigned_incharge, $inactive_user_score[0]['assesst_by']);
                                                        }
                                                    }

                                                    $assigned = count(array_filter($final_assigned_incharge));
                                                    $assigned_user = array_filter($final_assigned_incharge);
                                                    for ($a = 0; $a < $assigned; $a++) {
                                                        $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $assigned_user[$a]);
                                                        if (!empty($assigned_score)) {
                                                            ?>
                                                            <td><strong><input type="text" class="pre-input score_submit" style="width:70px" name="total_score_assign" id="total_score_assign" readonly value="<?php
                                                            if (isset($assigned_score[0]['total_score'])) {
                                                                echo $assigned_score[0]['total_score'];
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>" /></strong></td>
                                                            <?php } else {
                                                                ?>
                                                                <td><strong><input type="text" class="pre-input score_submit" style="width:70px" name="total_score" id="total_score" readonly="readonly" value="<?php
                                                                if (isset($feed_back[0]['score'])) {
                                                                    echo $feed_back[0]['score'];
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                    ?>" /></strong></td>
                                                                    <?php
                                                                }
                                                            }

                                                            for ($i = 0; $i < $count; $i++) {
                                                                $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);
                                                                if (!empty($assesst_sub)) {
                                                                    ?>
                                                                    <td><strong><input type="text" class="pre-input" style="width:70px" name="total_score_sub" id="total_score_sub" readonly="readonly" value="<?php
                                                                    if (isset($assesst_sub[0]['total_score'])) {
                                                                        echo $assesst_sub[0]['total_score'];
                                                                        } else {
                                                                            echo '';
                                                                        }
                                                                        ?>" /></strong></td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>

                                                        <tr class="parent">
                                                            <td></td>
                                                            <td>
                                                                <strong>Total %</strong>
                                                            </td>
                                                            <?php
                                                            if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                                                $final_assigned_incharge = array();
                                                                $temp_assigned_incharge = $assigned_incharge;
                                                                $check_pard_user = $this->Massessment->getInactivePARDuser($innovationID, $assigned_incharge);
                                                                foreach ($check_pard_user as $active_user) {
                                                                    array_push($final_assigned_incharge, $active_user['associate_employee']);
                                                                    unset($temp_assigned_incharge[php72_array_search($active_user['associate_employee'], $temp_assigned_incharge)]);
                                                                }
                                                                if (php72_count($temp_assigned_incharge) > 0) {
                                                                    foreach ($temp_assigned_incharge as $active_user_id) {
                                                                        $inactive_user_score = $this->Massessment->getInactiveUserScore($innovationID, $active_user_id);
                                                                        array_push($final_assigned_incharge, $inactive_user_score[0]['assesst_by']);
                                                                    }
                                                                }

                                                                $assigned = count(array_filter($final_assigned_incharge));
                                                                $assigned_user = array_filter($final_assigned_incharge);
                                                                for ($a = 0; $a < $assigned; $a++) {
                                                                    $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $assigned_user[$a]);
                                                                    if (!empty($assigned_score)) {
                                                                        ?>
                                                                        <td><strong><input type="text" class="pre-input" style="width:70px" name="total_per_assign" id="total_per_assign" readonly value="<?php
                                                                        if (isset($assigned_score[0]['total_per'])) {
                                                                            echo $assigned_score[0]['total_per'];
                                                                            } else {
                                                                                echo '';
                                                                            }
                                                                            ?>" /></strong></td>
                                                                        <?php } else {
                                                                            ?>
                                                                            <td><strong><input type="text" class="pre-input" style="width:70px" name="total_per_cio" id="total_per_cio" readonly value="<?php
                                                                            if (isset($feed_back[0]['per_score'])) {
                                                                                echo $feed_back[0]['per_score'];
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?>" /></strong></td>
                                                                                <?php
                                                                            }
                                                                        }

                                                                        for ($i = 0; $i < $count; $i++) {
                                                                            $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);
                                                                            if (!empty($assesst_sub)) {
                                                                                ?>
                                                                                <td><strong><input type="text" class="pre-input" style="width:70px" name="total_per_sub" id="total_per_sub" readonly value="<?php
                                                                                if (isset($assesst_sub[0]['total_per'])) {
                                                                                    echo $assesst_sub[0]['total_per'];
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>" /></strong></td>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td></td>
                                                                        <td>Comments</td>
                                                                        <td colspan="4">
                                                                            <textarea rows="3" cols="70" name="comment" id="comment" readonly="readonly"><?php
                                                                            if (isset($assigned_comment) && $assigned_comment != '') {
                                                                                echo $assigned_comment;
                                                                            } else {
                                                                                echo '';
                                                                            }
                                                                            ?></textarea>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr class="in-child">
                                                                        <td></td>
                                                                        <td>LIS</td>
                                                                        <td>
                                                                            <input type="radio" value="1" name="LIS" <?php echo $disabled1; ?> <?php echo (isset($feed_back[0]['LIS']) && $feed_back[0]['LIS'] != '' && $feed_back[0]['LIS'] == '1') ? 'checked="checked"' : ''; ?>>Yes<span>&nbsp;&nbsp;&nbsp;</span>
                                                                            <input type="radio" value="0" name="LIS" <?php echo $disabled1; ?> <?php echo (isset($feed_back[0]['LIS']) && $feed_back[0]['LIS'] != '' && $feed_back[0]['LIS'] == '0') ? 'checked="checked"' : ''; ?> <?php
                                                                            if ($feed_back[0]['LIS'] == '') {
                                                                                echo 'checked="checked"';
                                                                            }
                                                                            ?>>No
                                                                        </td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="LIS1" id="LIS1" value="<?php echo $feed_back[0]['LIS']; ?>">
                                                    <input type="hidden" name="accept_reject" id="accept_reject" value="">
                                                    <div style="height: 20px;"></div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4 class="vitals_innerSub">Donor Fit</h4>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                            <table class="table table-hover dt-responsive dataTable no-footer" id="donor_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"></th>
                                                                        <th width="30%">Donor</th>
                                                                        <th width="30%">Fund Recommended</th>
                                                                        <th width="30%">Funds Approved</th>

                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $donors = '';
                                                                        if (isset($feed_back[0]['donor_fit'])) {
                                                                            $donors = explode(',', $feed_back[0]['donor_fit']);
                                                                        }

                                                                        $recomm = explode(',', $feed_back[0]['fund_recom']);
                                                                        $approved = explode(',', $feed_back[0]['fund_approved']);
                                                                        if (!empty($recomm)) {
                                                                            foreach ($recomm as $value) {
                                                                                $array = explode('_', $value);
                                                                                if (!empty($array)) {
                                                                                    $recomm_array[$array[0]] = $array[1];
                                                                                }
                                                                            }
                                                                            foreach ($approved as $value) {
                                                                                $array = explode('_', $value);
                                                                                if (!empty($array)) {
                                                                                    $approved_array[$array[0]] = $array[1];
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        foreach ($donor_fit as $donor) {                                                                            
                                                                            if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $inno_status != '3' && $inno_status != '9') {
                                                                                $readonly_donor = (isset($feed_back[0]['donor_fit']) && php72_in_array($donor['id'], $donors)) ? '' : $readonly_donor = 'readonly="readonly"';
                                                                            } else {
																				if($innovationID!='285455'){
																					$readonly_donor = 'readonly="readonly"';
																				}
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td class="sorting_1">
                                                                                    <input <?php echo $disabled1; ?> type="checkbox" id='donor_fit' name="donor_fit[]" value="<?php echo $donor['id']; ?>" class="form-control donor_fit" <?php echo (isset($feed_back[0]['donor_fit']) && php72_in_array($donor['id'], $donors)) ? 'checked="checked"' : ''; ?>>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $donor['name']; ?>
                                                                                </td>
                                                                                <td><input <?php echo $readonly_donor; ?> type="text" id="fund_recom" name="fund_recom[<?php echo $donor['id']; ?>]" value="<?php
                                                                                if (isset($recomm_array[$donor['id']]) && $recomm_array[$donor['id']] != '0') {
                                                                                    echo $recomm_array[$donor['id']];
                                                                                }
                                                                                ?>" class="form-control fund_recom"><br /><span class="fund_recom_error"></span></td>
                                                                                <td><input <?php echo $readonly_donor; ?> type="text" id="fund_approved" name="fund_approved[<?php echo $donor['id']; ?>]" value="<?php
                                                                                if (isset($approved_array[$donor['id']]) && $approved_array[$donor['id']] != '0') {
                                                                                    echo $approved_array[$donor['id']];
                                                                                }
                                                                                ?>" class="form-control fund_approved"><br /><span class="fund_approved_error"></span>
                                                                            </td>
                                                                        </tr>

                                                                        <?php
                                                                    }
                                                                    $hid_don_fit = $feed_back[0]['donor_fit'];
                                                                    ?>

                                                                    <input type="hidden" name='donor_fit1' id='donor_fit1' value="<?php echo $hid_don_fit; ?>">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div style="height: 20px;"></div>
                                                    <div class="table-responsive">
                                                        <?php
                                                        $ass_disabled = $ass_readonly = '';
                                                        if ($feed_back[0]['cio_status'] != '' && $innovationID!='285455') {
                                                            $ass_disabled = 'disabled="disabled"';
                                                            $ass_readonly = 'readonly="readonly"';
                                                        }
                                                        ?>

                                                        <table class="tree" width="60%" align="left" cellpadding="0" cellspacing="0">

                                                            <tr class="in-child">
                                                                <td width="25%"><strong>Recommendation</strong></td>
                                                                <td width="50%">
                                                                    <select class="form-control" name="recomment" id="recomment" <?php
                                                                    echo $disabled1;
                                                                    echo $ass_disabled;
                                                                    ?>>
                                                                    <option value="">-Select-</option>
                                                                    <option value="Accept" <?php echo (isset($feed_back[0]['result']) && $feed_back[0]['result'] != '' && $feed_back[0]['result'] == 'Accept') ? 'selected="selected"' : ''; ?>>Accept</option>
                                                                    <option value="Reject" <?php echo (isset($feed_back[0]['result']) && $feed_back[0]['result'] != '' && $feed_back[0]['result'] == 'Reject') ? 'selected="selected"' : ''; ?>>Reject & Close</option>
                                                                </select>
                                                                <label id="recomment_error" style="width: 100%;"></label>
                                                                <?php
                                                                if ($disabled1 != '' || $ass_disabled != '') {
                                                                    ?>
                                                                    <input type="hidden" name="recomment" id="recomment" value="<?php echo $feed_back[0]['result']; ?>">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>

                                                        <tr class="in-child">
                                                            <td>
                                                                <div id="accept" style="<?php echo $style = ($feed_back[0]['result'] == 'Accept') ? 'display:block' : 'display:none'; ?>">
                                                                    <strong>Incubatee Stage</strong>
                                                                </div>
                                                                <div id="reject" style="<?php echo $style = ($feed_back[0]['result'] == 'Reject') ? 'display:block' : 'display:none'; ?>">
                                                                    <strong>Reason</strong>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div id="accept1" style="<?php echo $style = ($feed_back[0]['result'] == 'Accept') ? 'display:block' : 'display:none'; ?>">
                                                                    <select class="form-control" name="stage" id="stage" <?php
                                                                    echo $disabled1;
                                                                    echo $ass_disabled;
                                                                    ?>>
                                                                    <option value="">-Select Stage-</option>
                                                                    <option value="Pre-Product" <?php echo (isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' && $innovation['enterprise_stage'] == 'Pre-Product') ? 'selected="selected"' : ''; ?>>Pre-Product</option>
                                                                    <option value="Pre-Revenue" <?php echo (isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' && $innovation['enterprise_stage'] == 'Pre-Revenue') ? 'selected="selected"' : ''; ?>>Pre-Revenue</option>
                                                                    <option value="Pre-Scale" <?php echo (isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' && $innovation['enterprise_stage'] == 'Pre-Scale') ? 'selected="selected"' : ''; ?>>Pre-Scale</option>
                                                                </select>
                                                                <label id="stage_error"></label>
                                                                <?php
                                                                if ($disabled1 != '' || $ass_disabled != '') {
                                                                    ?>
                                                                    <input type="hidden" name="stage" id="stage" value="<?php echo $innovation['enterprise_stage']; ?>">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div id="reject1" style="<?php echo $style = ($feed_back[0]['result'] == 'Reject') ? 'display:block' : 'display:none'; ?>">
                                                                <select class="form-control" name="reason" id="reason" <?php
                                                                echo $disabled1;
                                                                echo $ass_disabled;
                                                                ?>>
                                                                <option value="">-Select Reason-</option>
                                                                <?php
                                                                foreach ($reasonsList as $list) {
                                                                    ?>
                                                                    <option value="<?php echo $list['id']; ?>" <?php echo (isset($feed_back[0]['reject_reason']) && $feed_back[0]['reject_reason'] != '' && $feed_back[0]['reject_reason'] == $list['id']) ? 'selected="selected"' : ''; ?>><?php echo $list['master_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <br /><label id="reason_error"></label>
                                                            <?php
                                                            if ($disabled1 != '' || $ass_disabled != '') {
                                                                ?>
                                                                <input type="hidden" name="reason" id="reason" value="<?php echo $feed_back[0]['reject_reason']; ?>">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="in-child">
                                                    <td><strong>Comments</strong></td>
                                                    <td>
                                                        <textarea rows="3" name="comments" id="comments" class="form-control" <?php
                                                        echo $readonly1;
                                                        echo $ass_readonly
                                                        ?>><?php echo (isset($feed_back[0]['feed_back'])) ? $feed_back[0]['feed_back'] : ''; ?></textarea>
                                                        <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $this->uri->segment(3); ?>" />
                                                        <input type="hidden" name="feed_back_id" id="feed_back_id" value="<?php echo (isset($feed_back[0]['id'])) ? $feed_back[0]['id'] : ''; ?>" />
                                                        <br>
                                                    </td>
                                                </tr>
                                                <tr class="in-child">
                                                    <td><strong>Upload Document</strong></td>
                                                    <td>
                                                        <input type="file" size="40" name="user_doc" id="user_doc" class="form-control input-text" value="" onblur="valid_doc('user_doc');" <?php
                                                        echo $readonly1;
                                                        echo $ass_readonly;
                                                        echo $c_pointer;
                                                        ?> />
                                                        <?php
                                                        if ($feed_back[0]['user_document'] != '') {
                                                           ?>
                                                           <a href="<?php echo base_url() . 'uploads/assessment/' . $feed_back[0]['user_document']; ?>" target="_blank"><?php echo $feed_back[0]['user_document']; ?></a>
                                                       <?php } ?>
                                                       <input type="hidden" name="user_doc_old" id="user_doc_old" value="<?php echo $feed_back[0]['user_document']; ?>" />
                                                       <br /><span id="user_doc_error"></span>
                                                   </td>
                                               </tr>
                                               <?php
                                // innovation status = 6 -> decision pending
                                               $cio_readonly = '';
                                               $cio_display = '';
                                               $cio_show = '';

                                               if ($inno_status == 3 || $inno_status == 9 || $inno_status == 7 || $inno_status != 6 || (isset($feed_back[0]['cio_status']) && $feed_back[0]['cio_status'] != '')) {
                                                $cio_readonly = 'readonly="readonly"';
                                                $cio_display = 'disabled="disabled"';
                                                $cio_show = 'style="display:none"';
                                            }

                                            $error_msg = array_unique($error_msg);
                                            $assign_users = '';
                                            $i = 0;
                                            foreach ($error_msg as $id) {
                                                if ($i) {
                                                    $assign_users .= ", ";
                                                }
                                                $assign_users .= $this->Massessment->getEmpName($id);
                                                $i++;
                                            }
                                            ?>
                                            <input type="hidden" name="assigned_err" id="assigned_err" value="<?php
                                            if (isset($assign_users)) {
                                                echo $assign_users;
                                            }
                                            ?>" />
                                            <?php
                                            $enable_iic = 0;
                                            if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $feed_back[0]['result'] == 'Accept') {
                                               $enable_iic = 1;
                                               ?>
                                               <tr class="in-child">
                                                <td><strong>Internal IC Recommendation</strong></td>
                                                <td>
                                                    <select class="form-control" name="internal_status" id="internal_status" <?php
                                                    if ($inno_status == '7' || ($feed_back[0]['internal_status'] != '' && $inno_status != '12') || ($feed_back[0]['internal_status'] != '' && $innovation['stage'] == '12' && $inno_status == '12')) {
                                                        echo 'disabled="disabled"';
                                                    }
                                                    ?>>
                                                    <option value="">-Select-</option>
                                                    <option value="Accept" <?php echo (isset($feed_back[0]['internal_status']) && $feed_back[0]['internal_status'] != '' && $feed_back[0]['internal_status'] == 'Accept') ? 'selected="selected"' : ''; ?>>Accept</option>
                                                    <option value="Reject" <?php echo (isset($feed_back[0]['internal_status']) && $feed_back[0]['internal_status'] != '' && $feed_back[0]['internal_status'] == 'Reject') ? 'selected="selected"' : ''; ?>>Reject & Close</option>
                                                </select>
                                                <label id="internal_status_error"></label>
                                                <input type="hidden" id="hinternal_status" name="hinternal_status" value="<?php echo $feed_back[0]['internal_status']; ?>">
                                            </td>
                                        </tr>
                                        <tr class="in-child">
                                            <td><strong>Internal IC Date</strong></td>
                                            <td>
                                                <input type="text" name="iic_date" value="<?= $iic_date; ?>" id="iic_date" placeholder="dd-mm-yyyy" class="form-control input-text datepicker">
                                                <br>
                                            </td>
                                        </tr>
                                        <tr class="in-child">
                                            <td><strong>Internal IC Comments</strong></td>
                                            <td>
                                                <textarea rows="3" name="internal_comment" id="internal_comment" class="form-control" <?php
                                                if ($inno_status == 7 || ($feed_back[0]['internal_status'] != '' && $inno_status != '12') || ($feed_back[0]['internal_status'] != '' && $innovation['stage'] == '12' && $inno_status == '12')) {
                                                    echo 'readonly="readonly"';
                                                }
                                                ?>><?php echo (isset($feed_back[0]['internal_comment'])) ? $feed_back[0]['internal_comment'] : ''; ?></textarea>
                                                <br>
                                            </td>
                                        </tr>
                                        <tr class="in-child">
                                            <td><strong>IIC Minutes</strong></td>
                                            <td>
                                                <input type="file" size="40" name="iic_doc" id="iic_doc" class="form-control input-text" value="" onblur="valid_doc('iic_doc');" <?php
                                                echo $readonly1;
                                                echo $ass_readonly
                                                ?> />
                                                <?php
                                                if ($feed_back[0]['iic_document'] != '') {
                                                   ?>
                                                   <a href="<?php echo base_url() . 'uploads/assessment/' . $feed_back[0]['iic_document']; ?>" target="_blank"><?php echo $feed_back[0]['iic_document']; ?></a>
                                               <?php } ?>
                                               <input type="hidden" name="iic_doc_old" id="iic_doc_old" value="<?php echo $feed_back[0]['iic_document']; ?>" />
                                               <br /><span id="iic_doc_error"></span>
                                           </td>
                                       </tr>

                                       <?php
                                       $ext_style = "none";
                                       if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $feed_back[0]['result'] == 'Accept' && $feed_back[0]['internal_status'] == 'Accept') {
                                        $ext_style = "row";
                                    }
                                    ?>


                                    <?php
                                } else if ((!php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $inno_status == 7) || $feed_back[0]['internal_status'] != '') {
                                    ?>
                                    <tr class="in-child">
                                        <td><strong>Internal IC Recommendation</strong></td>
                                        <td><?php echo $feed_back[0]['internal_status']; ?>
                                    </td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>Internal IC Date</strong></td>
                                    <td><?php echo $already_set_iic; ?></td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>Internal IC Comments</strong></td>
                                    <td><?php echo $feed_back[0]['internal_comment']; ?></td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>IIC Minutes</strong></td>
                                    <td><a href="<?php echo base_url() . 'uploads/assessment/' . $feed_back[0]['iic_document']; ?>" target="_blank"><?php echo $feed_back[0]['iic_document']; ?></a></td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <input type="hidden" name="form_type" id="form_type" value="">
                </form>
                <br>
                <?php
                if ((!php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $inno_status == 7) || ($feed_back[0]['internal_status'] != '' && $inno_status != '12') || ($feed_back[0]['internal_status'] != '' && $innovation['stage'] == '12' && $inno_status == '12')) {
					if($innovationID!='285455'){
						$display_none = 'style = "display:none"';
					}
					$display_none_submit = 'style = "display:none"';
                } else {
                    $display_none = '';
                }
                ?>
                <div class="asseSummary_btns">
                    <ul class="option-tab">
                        <li><a class="vital_bordered_btn wdt_100" id="back" href="<?php echo site_url('application/assessment_scoring/' . $application_id); ?>">Back</a></li>
                        <li><a class="save wdt_100 vital_yellow_btn" id="saves" href="javascript:void(0);" <?php echo $display1; ?> <?php echo $display_none; ?>>Save</a></li>
                        <li><a class="submit wdt_100 vital_yellow_btn" id="submit" href="javascript:void(0);" <?php echo $display1; ?> <?php echo $display_none_submit; ?>>Submit</a></li>

                    </ul>
                    <?php if ($this->session->userdata('emp_number') == $cio_emp_num && $inno_status == '6' && isset($feed_back[0]['result']) && $feed_back[0]['result'] == 'Accept') { ?>
                        <ul class="option-tab">
                            <li><a class="save wdt_100 vital_yellow_btn" id="saves" href="javascript:void(0);" <?php echo $cio_show; ?>>Save</a></li>
                            <li><a class="submit wdt_100 vital_yellow_btn" id="submit" href="javascript:void(0);" <?php echo $cio_show; ?>>Submit</a></li>
                        </ul>
                    </div>
                <?php } ?>


            </div>
        </main>
    </div>
</div>
</div>
</div>
</div>

<div class="modal" id="scoringModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<input type="hidden" id="scoring_count" value="<?= $get_score[0]['score_entered']; ?>">
<input type="hidden" id="iic_doc_count" value="<?= $enable_iic; ?>">

<style>
    .inputplan-structureall{
        border-top:none;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable', 'multi_select' => 'multiselect')); ?>

<script>
    $("#iic_date").datepicker({dateFormat: "dd-mm-yy"});    

    $('.donor_fit').change(function () {
        if ($(this).is(':checked')) {
            $(this).closest("tr").find("input[name='fund_recom[" + $(this).val() + "]']").prop('readonly', false);
            $(this).closest("tr").find("input[name='fund_approved[" + $(this).val() + "]']").prop('readonly', false);
        } else {
            $(this).closest("tr").find("input[name='fund_recom[" + $(this).val() + "]']").val('');
            $(this).closest("tr").find("input[name='fund_recom[" + $(this).val() + "]']").prop('readonly', true);
            $(this).closest("tr").find('.fund_recom_error').text('');
            $(this).closest("tr").find("input[name='fund_approved[" + $(this).val() + "]']").val('');
            $(this).closest("tr").find("input[name='fund_approved[" + $(this).val() + "]']").prop('readonly', true);
            $(this).closest("tr").find('.fund_approved_error').text('');
        }
    });

    $('.fund_recom').blur(function () {
        if ($(this).val().length > 0 && $(this).val() == 0) {
            $(this).closest("td").find('.fund_recom_error').text('Fund must be greater than zero').css('color', 'red');
            $(this).val('');
            $(this).focus();
        } else if (isNaN($(this).val())) {
            $(this).closest("td").find('.fund_recom_error').text('Enter numbers only').css('color', 'red');
            $(this).val('');
            $(this).focus();
        } else {
            $(this).closest("td").find('.fund_recom_error').text('');
        }
    });

    $('.fund_approved').blur(function () {
        if ($(this).val().length > 0 && $(this).val() == 0) {
            $(this).closest("td").find('.fund_approved_error').text('Fund must be greater than zero').css('color', 'red');
            $(this).val('');
            $(this).focus();
        } else if (isNaN($(this).val())) {
            $(this).closest("td").find('.fund_approved_error').text('Enter numbers only').css('color', 'red');
            $(this).val('');
            $(this).focus();
        } else {
            $(this).closest("td").find('.fund_approved_error').text('');
        }
    });

    $(document).ready(function () {
        $("#recomment").change(function () {
            if ($("#recomment").val() == 'Reject') {
                $("#reject").show();
                $("#reject1").show();
                $("#reason").show();
                $("#stage").hide();
                $("#accept").hide();
                $("#accept1").hide();
            } else {
                $("#reject").hide();
                $("#reject1").hide();
                $("#reason").hide();
                $("#stage").show();
                $("#accept").show();
                $("#accept1").show();
            }
        });

        $("#total_score").focus(function () {
            var total = 0;
            $('.score').each(function () {
                var val = ($(this).val() != '') ? $(this).val() : 0;
                total = parseFloat(total) + parseFloat(val);
            });

            total = (total != 0) ? total : '';
            $("#total_score").val(total);
        });

        $("#total_per_cio").focus(function () {
            var total = total_count = 0;
            $('.score').each(function () {
                var val = ($(this).val() != '') ? $(this).val() : 0;
                total = parseFloat(total) + parseFloat(val);
                if (val != 0)
                    total_count = total_count + 1;
            });

            var tot_val_per = total_count * 3;
            var percent = '';
            if (total != '' && total != 0 && tot_val_per != 0)
                percent = ((total / tot_val_per) * 100).toFixed(2);
            $("#total_per_cio").val(percent);
        });

        $(".score").keyup(function () {
            var id = $(this).attr('id');
            var area = id.split('_');
            if (!$.isNumeric($(this).val())) {
                $("#" + id).focus();
                var len = $("#" + id).val().length;
                var str = $("#" + id).val().substring(0, len - 1);
                $("#" + id).val(str);
            } else {
                if (parseInt($(this).val()) > 3) {
                    $("#" + id).focus();
                    $("#score_error_" + area[1]).html("Enter number between 0 to 3").show().css('color', 'red');
                } else {
                    $("#score_error_" + area[1]).html("");
                    var total = total_count = 0;
                    $('.score').each(function () {
                        var val = ($(this).val() != '') ? $(this).val() : 0;
                        total = parseFloat(total) + parseFloat(val);
                        if ($(this).val() != '')
                            total_count = total_count + 1;
                    });
                    total = (total != 0) ? total : '';
                    $("#total_score").val(total);

                    var tot_val_per = total_count * 3;
                    var percent = '';
                    if (total != '' && total != 0 && tot_val_per != 0)
                        percent = ((total / tot_val_per) * 100).toFixed(2);
                    $("#total_per_cio").val(percent);
                }
            }
        });

        $(".save,.submit,.ciosubmit").click(function () {
            var find_button = $(this).attr('class');
            var split_class = find_button.split(' ');
            var class_name = split_class[1];
            var formType = $(this).attr('id');
            $('#form_type').val(formType);
            var user_status = "<?php echo $feed_back[0]['result']; ?>";
            var recommend = $("#recomment").val();
            if (user_status == recommend) {
                $("#accept_reject").val('0');
            } else {
                $("#accept_reject").val('1');
            }

            var errorval = 0;
            var userVal = 0;
            var total_count = 0;
            var total = 0;
            var scoreVal = 0;

            $('.score').each(function () {
                var val = ($(this).val() != '') ? $(this).val() : 0;
                total = parseFloat(total) + parseFloat(val);
                if ($(this).val() != '')
                    total_count = total_count + 1;
            });
            total = (total != 0) ? total : '';
            $("#total_score").val(total);

            var tot_val_per = total_count * 3;
            var percent = '';
            if (total != '' && total != 0 && tot_val_per != 0)
                percent = ((total / tot_val_per) * 100).toFixed(2);
            $("#total_per_cio").val(percent);
            $('.error').each(function () {
                if ($('.error').html() != '')
                    errorval = errorval + 1;
            });

            var user_accept = valid_doc('user_doc');
            if (user_accept == false) {
                errorval = errorval + 1;
            }

            var iic_section = $("#iic_doc_count").val();
            if (iic_section == '1') {
                var iic_accept = valid_doc('iic_doc');
                if (iic_accept == false) {
                    errorval = errorval + 1;
                }
            }

            <?php if ($this->session->userdata('emp_number') != $cio_emp_num) { ?>
                if ($("#recomment").val() == 'Accept') {
                    var checkbox_length = $(".donor_fit").length;
                    $('.donor_fit').each(function () {
                        if ($(this).is(':checked')) {
                            userVal = 1;
                        } else {

                        }
                    });
                } else {
                    userVal = 1;
                }
                if (userVal != 1 && checkbox_length > 0) {
                    alert("Enter funds detail for any donor");
                    return false;
                }
            <?php } ?>

            <?php if ($this->session->userdata('emp_number') == $cio_emp_num) { ?>
                if ($(this).attr('class').split(' ')[1] == 'ciosubmit') {

                    $('#assess_summary').append('<input type="hidden" name="ciosubmit" id="ciosubmit" value="submit"/>');
                    var score = 0;
                    $('.score').each(function () {
                        if ($(this).val() == '') {
                            score = score + 1;
                        }
                    });

                    var rational = 0;
                    $('.rational').each(function () {
                        if ($(this).val() == '') {
                            rational = rational + 1;
                        }
                    });

                    var risk = 0;
                    $('.risk').each(function () {
                        if ($(this).val() == '') {
                            risk = risk + 1;
                        }
                    });
                    if (score > 0) {
                        alert("Enter scores for each criteria");
                        errorval = errorval + 1;
                    } else if (rational > 0) {
                        alert("Enter rationale comments");
                        errorval = errorval + 1;
                    } else if (risk > 0) {
                        alert("Enter risk comments");
                        errorval = errorval + 1;
                    } else if ($("#cio_status").val() == "") {
                        alert("Select your recommendation to submit the innovation");
                        errorval = errorval + 1;
                    }
                }
            <?php } ?>

            var flag = 0;
            $("#recomment_error").html("");
            $("#stage_error").html("");
            $("#reason_error").html("");

            var score_total = '';
            var score_len = $('#scoring_count').val();
            if (class_name == 'submit' || class_name == 'ciosubmit') {
                $('.score_submit').each(function () {
                    var assign_score = $(this).val();
                    // if (assign_score == 'NaN' || assign_score == '') {
                        score_total += assign_score;
                    // }
                    scoreVal += parseFloat(assign_score);
                });

                if (score_len == 0 && $("#internal_status").val() == 'Accept') {
                    alert("Enter score value");
                    errorval = errorval + 1;
                    document.getElementById("back").click();
                    return false;
                }
                var chosen_date = $('#iic_date').val();
                if (score_len > 0 && $("#internal_status").val() == 'Accept' && chosen_date == '') {
                    alert("Select date");
                    errorval = errorval + 1;
                }
            }

            if (errorval == 0 && flag == 0) {
                if ($(this).attr('class').split(' ')[1] == 'submit') {
                    $('#assess_summary').append('<input type="hidden" name="submit1" id="submit1" value="submit"/>');
                    if ($("#recomment").val() == '') {
                        alert("Select your recommendation before submit for approval");
                        return false
                    } else if ($("#recomment").val() == 'Accept') {
                        if ($("#stage").val() == '') {
                            alert("Select stage of innovation before submit for approval");
                            return false
                        }
                    } else if ($("#recomment").val() == 'Reject') {
                        if ($("#reason").val() == '') {
                            alert("Select reason for the rejection of innovation");
                            return false
                        }
                    }

                    if ($("#hcio_status").val() != '' && $("#hcio_status").val() == 'Accept') {
                        if ($("#hinternal_status").val() == '' && $("#internal_status").val() == '') {
                            alert("Select Internal IC recommendation of innovation before submit");
                            return false;
                        }
                    }

                    if ($("#internal_status").val() == 'Accept') {
                        var r = confirm("You are about to submit the IIC status of this deal. PA/RD scoring sheets will not be editable once this is done. Do you want to proceed?");
                        if (r == true) {
                            $("#assess_summary").submit();
                        } else {
                            return false;
                        }
                    }
                    $("#assess_summary").submit();
                } else {
                    $("#assess_summary").submit();
                }
            } else
            return false;

        });

$('.transfer').click(function () {
    var id = $(this).attr('data');
    var inno = '<?php echo $this->uri->segment("3"); ?>';
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            innov: inno
        },
        url: '<?php echo site_url("assessment/getscore/"); ?>',
        success: function (response) {
            var array = response['area'];
            $.each(array, function (index, value) {
                $("#score_" + value).val(response[value]);
                $("#total_score").val(response['total_score']);
            });
        }
    });
});
});

function valid_doc(id) {
    var filename = $("#" + id).val();
    if (filename != '') {
        if (!(/\.(doc|docx|pdf|ppt|pptx)$/i).test(filename)) {
            $("#" + id + "_file .filename").html('No file selected');
            var fieldSpan = $("#" + id + "_file");
            fieldSpan.html(fieldSpan.html());
            $("#" + id + "_error").text("Invalid file. Supported document type is pdf,doc,ppt").css('color', 'red');
            return false;
            setTimeout(function () {
                $("#" + id).focus();
            }, 10);
        } else {
            $("#" + id + "_file .filename").html(filename);
            $("#" + id + "_error").text("");
            return true;
        }
    } else {
        $("#" + id + "_file .filename").html("No file selected");
        $("#" + id + "_error").text("");
        return true;
    }
}

//    $('.individual_form').on('click', function () {
//        $('#scoringModal').modal('show');
//    });

function scoreDetail(id) {

}

var stage = "<?php echo $innovation['stage']; ?>";
var innovationID = "<?php echo $innovationID; ?>";
if (stage != '8' && innovationID!='285455') {
    $("#assess_summary :input").attr("disabled", true);
}

$(document).ready(function () {
    $('#summary_table, #donor_table').DataTable({
        "paging": false,
        "ordering": false,
        "searching": false,
        "info": false
    });
});
</script>

</body>
</html>