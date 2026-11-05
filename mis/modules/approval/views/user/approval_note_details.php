<?php
$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Approval Note Details'));
if ($approvalNoteDetails[0]['status'] == 'pending') {
    $back_link = 'all_pending';
} else {
    $back_link = 'all_approval/' . $approvalNoteDetails[0]['status'];
}
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'my_approval_note')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-5 col-lg-5 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/approval/approval_note/' . $back_link; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?php echo $cpagetitle . ' - ' . $approvalNoteDetails[0]['approval_no']; ?></h4>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <?php
                            if ($approvalNoteDetails[0]['status'] != 'closed' && $approvalNoteDetails[0]['status'] != 'cancelled' && $approvalNoteDetails[0]['status'] != 'confirmed' && ($approvalNoteDetails[0]['status'] == 'pending' || $approvalNoteDetails[0]['status'] == 'defered' || $this->session->userdata('user') == $approvalNoteDetails[0]['from_employee'])) {
                                ?>
                                <li class="edit"><a  href="<?php echo base_url() . 'index.php/approval/edit_approval_note/' . $approval_id; ?>" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                            <?php } ?>
                            <?php
                            $popup_type = '';
                            //if ($approvalNoteDetails[0]['status'] != 'closed' && $this->session->userdata('isAdmin') == 'Yes' && ($approvalNoteDetails[0]['status'] == 'pending' || $approvalNoteDetails[0]['status'] == 'confirmed')) {
                            if ($approvalNoteDetails[0]['status'] != 'closed' && $this->session->userdata('user') == $approvalNoteDetails[0]['from_employee'] && ($approvalNoteDetails[0]['status'] == 'pending' || $approvalNoteDetails[0]['status'] == 'confirmed')) {
							   if ($approvalNoteDetails[0]['status'] == 'pending') {
                                    $popup_type = 'AN_Closed_modal';
                                } elseif ($open_int_notes) {
                                    $popup_type = 'AN_DO_NOT_CLOSE_modal';
                                } else {
                                    $popup_type = 'AN_confirmed_Close_modal';
                                }
                                ?>
                                <?php if ($popup_type == 'AN_Closed_modal') { ?>
                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#an_close_model" class="master_aduser summaryEdit" id="<?php echo $popup_type; ?>"><span><i class="far fa-check-circle"></i></span> Close</a></li>
                                <?php } else if ($popup_type == 'AN_DO_NOT_CLOSE_modal') { ?>
                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#an_dont_close_model" class="master_aduser summaryEdit" id="<?php echo $popup_type; ?>"><span><i class="far fa-check-circle"></i></span> Close</a></li>

                                <?php } else if ($popup_type == 'AN_confirmed_Close_modal') { ?>
                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#an_confirm_close_model" class="master_aduser summaryEdit" id="<?php echo $popup_type; ?>"><span><i class="far fa-check-circle"></i></span> Close</a></li>
                                <?php } ?>
                            <?php } ?>

                            <?php
                            if (($this->session->userdata('user_id') == $approvalNoteDetails[0]['assigned_user'] && $approvalNoteDetails[0]['RO_status'] == 'confirmed') ||  $check_an_approver_user!='') {
									if ($approvalNoteDetails[0]['PH_status'] == 'pending') {
										?>
                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ph_approveModel" class="master_aduser summaryEdit" id="approve_cls"><span>
                                        <i class="far fa-check-circle"></i></span> Approve</a></li>

                                        <?php if ($approvalNoteDetails[0]['PH_status'] != 'defered') { ?>
                                            <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ph_defferModel" class="master_aduser summaryEdit" ><span>
                                                <i class="far fa-check-circle"></i></span> Defer</a></li>
                                            <?php } ?>
                                            <?php
                                        }
                                        if ($approvalNoteDetails[0]['PH_status'] != 'cancelled' && $approvalNoteDetails[0]['status'] != 'cancelled' && $approvalNoteDetails[0]['RO_status'] == 'confirmed') {
											
                                            ?>
                                            <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ph_dissappovemodal" class="master_aduser 	summaryEdit" ><span>
                                                <i class="far fa-check-circle"></i></span> Disapprove</a></li>
                                                <?php
												
                                            }
                                        }
                                        ?>

                                        <?php 
										
                                        if ($approvalNoteDetails[0]['to_RO'] == $this->session->userdata('user_id')) {
                                            if ($approvalNoteDetails[0]['RO_status'] == 'pending' && ($approvalNoteDetails[0]['PH_status'] == 'defered' || $approvalNoteDetails[0]['PH_status'] == 'pending'  || $approvalNoteDetails[0]['PH_status'] == 'confirmed')) {
                                                ?>
                                                <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ro_approveModel" class="master_aduser summaryEdit" id="approve_cls"><span>
                                                    <i class="far fa-check-circle"></i></span> Approve</a></li>

                                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ro_dissappovemodal" class="master_aduser summaryEdit" ><span>
                                                        <i class="far fa-check-circle"></i></span> Disapprove</a></li>
                                                        <?php if ($approvalNoteDetails[0]['RO_status'] != 'defered') { ?>
                                                            <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ro_defferModel" class="master_aduser summaryEdit" ><span>
                                                                <i class="far fa-check-circle"></i></span> Defer</a></li>
                                                            <?php } ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') {

                                                        if ($this->session->userdata('user') == $ceo && $approvalNoteDetails[0]['RO_status'] == 'confirmed' && $approvalNoteDetails[0]['PH_status'] != 'pending') {
                                                            if ($approvalNoteDetails[0]['CEO_status'] == 'pending') {
                                                                ?>
                                                                <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ceo_approveModel" class="master_aduser summaryEdit" id="approve_cls"><span>
                                                                    <i class="far fa-check-circle"></i></span> Approve</a></li>
                                                                <?php } if ($approvalNoteDetails[0]['CEO_status'] != 'cancelled' && $approvalNoteDetails[0]['status'] != 'cancelled') { ?>
                                                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ceo_dissappovemodal" class="master_aduser summaryEdit" ><span>
                                                                        <i class="far fa-check-circle"></i></span> Disapprove</a></li>
                                                                    <?php } ?>
                                                                    <?php if ($row['CEO_status'] != 'defered') { ?>
                                                                        <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ceo_defferModel" class="master_aduser summaryEdit" ><span>
                                                                            <i class="far fa-check-circle"></i></span> Defer</a></li>
                                                                        <?php } ?>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                <!--<li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-print"></i></span> Print</a></li>-->
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="plan-structure-vital vital_windowScroll approval_details">
                                                        <div class="tab-slider--container">
                                                            <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme ">
                                                                <main class="page-content">
                                                                    <div class="inputplan-structureall plan-structure-new">
                                                                        <div class="row approvalLabel">
                                                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                                                <div class="display-flex">
                                                                                    <label>Status :</label>
                                                                                    <p>
                                                                                        <?php
                                                                                        if ($approvalNoteDetails[0]['status'] == 'Defered') {
                                                                                            echo 'Deferred';
                                                                                        } else {
                                                                                            echo ucfirst($approvalNoteDetails[0]['status']);
                                                                                        }
                                                                                        ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                                                <div class="display-flex">
                                                                                    <label>From Employee :</label>
                                                                                    <p><?php
                                                                                    if ($emp_name != '') {
                                                                                        echo $emp_name;
                                                                                    } else {
                                                                                        echo '-';
                                                                                    }
                                                                                    ?></p>
                                                                                </div>
                                                                            </div>

                                        <!--<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>RO Status:</label>
                                                <p>
                                        <?php
                                        if ($approvalNoteDetails[0]['RO_status'] == 'Defered') {
                                            echo 'Deferred';
                                        } else {
                                            echo ucfirst($approvalNoteDetails[0]['RO_status']);
                                        }
                                        ?>
                                                </p>
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Approval Number :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['approval_no']) && $approvalNoteDetails[0]['approval_no'] != '') {
                                                        echo $approvalNoteDetails[0]['approval_no'];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Approval Status :</label>
                                                <p><?php
                                                if ($approvalNoteDetails[0]['PH_status'] == 'Defered') {
                                                    echo 'Deferred';
                                                } else {
                                                    echo ucfirst($approvalNoteDetails[0]['PH_status']);
                                                }
                                                ?></p>
                                            </div>
                                        </div> <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>RO Status :</label>
                                                <p><?php
                                                if ($approvalNoteDetails[0]['RO_status'] == 'Defered') {
                                                    echo 'Deferred';
                                                } else {
                                                    echo ucfirst($approvalNoteDetails[0]['RO_status']);
                                                }
                                                ?></p>
                                            </div>
                                        </div>
                                        <?php /* if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') { ?>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="display-flex">
                                                    <label>CEO Status :</label>
                                                    <p>
                                                        <?php
                                                        if ($approvalNoteDetails[0]['CEO_status'] == 'Defered') {
                                                            echo 'Deferred';
                                                        } else {
                                                            echo ucfirst($approvalNoteDetails[0]['CEO_status']);
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php }  */ ?>
                                    </div>

                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Reporting Officer :</label>
                                                <p><?php
                                                if ($to_RO != '') {
                                                    echo $to_RO;
                                                } else {
                                                    echo '-';
                                                }
                                                ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Approver Name :</label>
                                                <p>
                                                    <?php
                                                    if ($ph_name != '') {
                                                        echo $ph_name;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') { ?>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="display-flex">
                                                    <label>CEO :</label>
                                                    <p><?php
                                                    if ($ceo_name != '') {
                                                        echo $ceo_name;
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Programme :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['programme_name']) && $approvalNoteDetails[0]['programme_name'] != '') {
                                                        echo $approvalNoteDetails[0]['programme_name'];
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                            <div class="display-flex align-top">
                                                <label>Purpose :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['purpose']) && $approvalNoteDetails[0]['purpose'] != '') {
                                                        echo $approvalNoteDetails[0]['purpose'];
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 15px;"></div>
                                    <div class="newApprovalNoteViewTbl">
                                        <table class="table" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th>Donor - Grant</th>
                                                    <th>Budget Head</th>
                                                    <th>Line Item</th>
                                                    <th>Details</th>
                                                    <th>Amt. Available (<?= $this->session->userdata['currency']; ?>)</th>
                                                    <th>Amt. Required (<?= $this->session->userdata['currency']; ?>)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                foreach ($donorAN as $lists) {
//                                                    $get_grantName = $this->Mapproval->get_grantList($lists["grant_id"]);
//                                                    if ($get_grantName[0]->name != '') {
//                                                        $donor_grant = $lists["donor"] . '<strong> - </strong>' . $get_grantName[0]->name;
//                                                    } else {
                                                    $donor_grant = $lists["donor"];
//                                                    }
                                                    $total = $total + $lists['amt_required'];
                                                    ?>
                                                    <tr class="metric_more">
                                                        <td><?php echo $donor_grant; ?></td>
                                                        <td><?php echo $lists['budget_head']; ?></td>
                                                        <td><?php echo $lists['line_item']; ?></td>
                                                        <td><?php echo $lists['additionalinfo']; ?></td>
                                                        <td><?php echo formatnumber($lists['amt_available']); ?></td>
                                                        <td><?php echo formatnumber($lists['amt_required']); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="total">Total :</th>
                                                        <td><?= formatnumber($total); ?></td>
                                                    </tr>
                                                </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height: 15px;"></div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Date of Seeking Approval :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['date_of_seeking_approval']) && $approvalNoteDetails[0]['date_of_seeking_approval'] != '') {
                                                        echo date('d-m-Y', strtotime($approvalNoteDetails[0]['date_of_seeking_approval']));
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Programme Head Approval Status :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['PH_status']) && $approvalNoteDetails[0]['PH_status'] != '') {
                                                        if (ucfirst($approvalNoteDetails[0]['PH_status']) == 'Defered') {
                                                            echo 'Deferred';
                                                        } else {
                                                            echo ucfirst($approvalNoteDetails[0]['PH_status']);
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php /* if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') { ?>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="display-flex">
                                                    <label>CEO Approval Status :</label>
                                                    <p>
                                                        <?= (ucfirst($approvalNoteDetails[0]['CEO_status']) == 'Defered' ? 'Deferred' : ucfirst($approvalNoteDetails[0]['CEO_status'])); ?>&nbsp;&nbsp;
                                                        <?php
                                                        if (isset($row['approved_from'])) {
                                                            if ($row['approve_from'] == 'Ceohead') {
                                                                if ($row['approved_by'] != '') {
                                                                    ?>
                                                                    <strong><?= ucfirst($row['approved_by']); ?></strong>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } */ ?>
                                    </div>

                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Comments of Programme Head :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['comments_PH']) && $approvalNoteDetails[0]['comments_PH'] != '0') {
                                                        echo $approvalNoteDetails[0]['comments_PH'];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php /* if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') { ?>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="display-flex">
                                                    <label>Comments of CEO :</label>
                                                    <p><?php
                                                    if ($approvalNoteDetails[0]['comments_CEO'] != '') {
                                                        echo $approvalNoteDetails[0]['comments_CEO'];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?></p>
                                                </div>
                                            </div>
                                        <?php } */ ?>
                                    </div>

                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Programme Head Approval Date :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['PH_date']) && $approvalNoteDetails[0]['PH_date'] != '') {
                                                        echo date('d-m-Y', strtotime($approvalNoteDetails[0]['PH_date']));
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php /* if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') { ?>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="display-flex">
                                                    <label>CEO Approval Date :</label>
                                                    <p>
                                                        <?php
                                                        if (isset($approvalNoteDetails[0]['CEO_date']) && $approvalNoteDetails[0]['CEO_date'] != '') {
                                                            echo date('d-m-Y', strtotime($approvalNoteDetails[0]['CEO_date']));
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } */ ?>
                                    </div>

                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Supporting Documents :</label>
                                                <p>
                                                    <?php
                                                    if (isset($approvalNoteDetails[0]['supporting_documents']) && $approvalNoteDetails[0]['supporting_documents'] != '') {
                                                        echo nl2br($approvalNoteDetails[0]['supporting_documents']);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Attachments :</label>
                                                <p><?php
                                                foreach (unserialize($approvalNoteDetails[0]['attachment']) as $key => $value):
                                                    ?><a href="<?= base_url(); ?>uploads/support_docs/<?= $value ?>" target="_blank" style="font-weight:bold;font-size:10px;"><?= $value ?></a><br/><?php
                                                endforeach;
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>
                                                            <!--
                                                            <div class="row approvalLabel">
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="display-flex">
                                                            <label>Date of Seeking Approval:</label>
                                                            <p>
                                                            <?php
                                                            if (isset($approvalNoteDetails[0]['date_of_seeking_approval']) && $approvalNoteDetails[0]['date_of_seeking_approval'] != '') {
                                                                echo date('d-m-Y', strtotime($approvalNoteDetails[0]['date_of_seeking_approval']));
                                                            }
                                                            ?>
                                                            </p>
                                                            </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="display-flex">
                                                            <label>Comments of Reporting Officer :</label>
                                                            <p>
                                                            <?php
                                                            if (isset($approvalNoteDetails[0]['comments_RO']) && $approvalNoteDetails[0]['comments_RO'] != '') {
                                                                echo $approvalNoteDetails[0]['comments_RO'];
                                                            }
                                                            ?>
                                                            </p>
                                                            </div>
                                                            </div>
                                                        </div>-->


                                                            <!--      <?php if ($approvalNoteDetails[0]['above_50000'] == 'yes' || $approvalNoteDetails[0]['estimated_in_workplan'] == 'no') { ?>
                                                             <div class="row approvalLabel">
                                                             <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                             <div class="display-flex">
                                                             <label>Is expense above <?php echo $currency_lable; ?>?</label>
                                                             <p>
                                                             <?php
                                                             if (isset($approvalNoteDetails[0]['above_50000']) && $approvalNoteDetails[0]['above_50000'] != '') {
                                                                echo $approvalNoteDetails[0]['above_50000'];
                                                            }
                                                            ?>
                                                            </p>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            <?php } ?> -->
                                                        <!--
                                                        <div class="row approvalLabel">
                                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                        <label>Reporting Officer Approval :</label>
                                                        <p>
                                                        <? (ucfirst($row['RO_status']) == 'Defered' ? 'Deferred' : ucfirst($row['RO_status'])); ?>
                                                        <?php
                                                        if (isset($approvalNoteDetails[0]['RO_status']) && $approvalNoteDetails[0]['RO_status'] != '') {
                                                            if (ucfirst($row['RO_status']) == 'Defered') {
                                                                echo 'Deferred';
                                                            } else {
                                                                echo $row['RO_status'];
                                                            }
                                                        }
                                                        ?>
                                                        </p>
                                                        </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                        <label>Reporting Officer Approval Date:</label>
                                                        <p><?php
                                    /* if ($approvalNoteDetails[0]['RO_date'] != '') {
                                      echo (!empty($approvalNoteDetails[0]['RO_date']) && $approvalNoteDetails[0]['RO_status'] != 'pending') ? date("d-m-Y", strtotime($approvalNoteDetails[0]['RO_date'])) : '';
                                      } else {
                                      echo '--';
                                  } */
                                  ?></p>
                                  </div>
                                  </div>
                                  </div>
                                  <div class="row approvalLabel">
                                  <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                  <div class="display-flex">
                                  <label>From: (employee)</label>
                                  <p>
                                  <?php
                                  echo $emp_name
                                  ?>
                                  </p>
                                  </div>
                                  </div>
                                  <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                  <div class="display-flex">
                                  <label>Programme Head Approval Date :</label>
                                  <p>
                                  <?php
                                  if (isset($approvalNoteDetails[0]['PH_date']) && $approvalNoteDetails[0]['PH_date'] != '') {
                                    echo date('d-m-Y', strtotime($approvalNoteDetails[0]['PH_date']));
                                } else {
                                    echo '--';
                                }
                                ?>
                                </p>
                                </div>
                                </div>
                            </div> -->

                        </div>
                    </main>
                </div>
            </div>
        </div>
    </main>
</div>
</div>
</div>
</div>
</div>

<div class="modal" id="an_confirm_close_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4></h4>
                        </div>
                        <span>The selected approval note has unutilized amount of RS. <?php
                        $remain = ($remain_amt > 0) ? $remain_amt : 0;
                        echo $remain;
                        ?>. Closing the approval note will <br/>
                    a. Release the unutilized amount to donors budget.</br>
                    b. Update the amount required in this approval note to RS.<?php
                    if ($sumof_int_amt)
                        echo $sumof_int_amt;
                    else
                        echo '0';
                    ?> </br>
                    Please confirm to proceed.<br/>
                </span><br/>
            </div>
        </div>
    </div>
    <form name="an_confirm_form" id="an_confirm_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/close_approval_note/<?= $approvalNoteDetails[0]["status"]; ?>/<?= $approvalNoteDetails[0]["approval_id"]; ?>">
        <input type="hidden" name="new_apn" value="<?= $sumof_int_amt ?>" />
        <input type="hidden" name="new_donor" value="<?= $remain ?>" />
        <?php foreach ($progID as $res) { ?>
            <input type="hidden" name="approval_donor_id" value="<?= $res['approval_donor_id']; ?>" />
            <input type="hidden" name="donor" value="<?= $res['donor']; ?>" />
            <input type="hidden" name="lineitem" value="<?= $res['line_item']; ?>" />
            <input type="hidden" name="costcenter" value="<?= $res['cost_centre']; ?>" />
            <input type="hidden" name="budgethead" value="<?= $res['budget_head']; ?>" />
            <input type="hidden" name="programme" value="<?= $programmeid ?>" />
            <input type="hidden" name="internalamt" value="<?= $sumof_int_amt ?>" />
        <?php } ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-default"><a class="close portfolioclose an_confirm_model_btn" data-dismiss="modal" aria-label="Close">Cancel</a></button>
            <button type="button" class="btn btn-success" id="an_confirm_close">OK</button>
        </div>
    </form>
</div>
</div>
</div>

<div class="modal" id="an_close_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note was not confirmed. <br>Do you want to close it?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="an_close_form" id="an_close_form" method="post" action="<?php echo base_url(); ?>index.php/approval/approvaladmin/close_approval_note/<?= $approvalNoteDetails[0]['status']; ?>/<?= $approvalNoteDetails[0]['approval_id']; ?>">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose an_close_model_btn" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="an_dont_close">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="an_dont_close_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>This approval note has pending/ deferred Internal Notes. Please confirm or cancel the open Internal Notes before trying to close the approval note</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="an_dont_close">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ph_approveModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note - Approval Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ph_approval_form" id="ph_approval_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ph">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_PH" id="comments_PH" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="approve">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ph_approve_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ph_dissappovemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note - Disapprove Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ph_dissappove_form" id="ph_dissappove_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ph">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_PH" id="comments_PH" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="disapprove">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ph_dissappove_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ro -->
<div class="modal" id="ro_approveModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note - Approval Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ro_approval_form" id="ro_approval_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ro">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_RO" id="comments_RO" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="approve">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ro_approve_submit">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ro_dissappovemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note - Disapprove Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ro_dissappove_form" id="ro_dissappove_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ro">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_RO" id="comments_RO" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="disapprove">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ro_dissappove_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CEO -->
<div class="modal" id="ceo_approveModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note - Approval Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ceo_approval_form" id="ceo_approval_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ceo">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_CEO" id="comments_CEO" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="approve">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ceo_approve_submit">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ceo_dissappovemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Approval Note - Disapprove Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ceo_dissappove_form" id="ceo_dissappove_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ceo">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_CEO" id="comments_CEO" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="disapprove">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ceo_dissappove_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ro_defferModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Who would you like to send AN to?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <form name="ro_defferModel_form" id="ro_defferModel_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ro">
                        <div class="row">
                            <div class="col">
                                <input type="radio" checked name="employee" value="<?php echo $user_id; ?>"><?php echo $employee_name; ?>
                                <textarea class="form-control" rows="4" name="comments_RO" id="comments_RO" placeholder="Enter comments"></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="option" name="option" value="defer">
                        <input type="hidden" id="request_id" name="request_id">
                        <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                    </form>
                </div>
            </div>

            <br>
            <div class="text-right">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="ro_deffer_request">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ph_defferModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Who would you like to send AN to?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <form name="ph_defferModel_form" id="ph_defferModel_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ph">
                        <div class="row">
                            <input type="hidden" id="option" name="option" value="defer">
                            <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">

                            <div class="col">

                                <input type="radio" checked name="employee" value="<?php echo $user_id; ?>"><?php echo $employee_name; ?>
                                <textarea class="form-control" rows="4" name="comments_PH" id="comments_PH" placeholder="Enter comments"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="ph_deffer_request">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ceo_defferModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Who would you like to send AN to?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="ceo_defferModel_form" id="ceo_defferModel_form" method="POST" action="<?php echo base_url(); ?>index.php/approval/ceo">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                                <input type="hidden" id="option" name="option" value="defer">
                                <div class="col">
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" required="" name="employee" id="employee1" value="<?php echo $user_id; ?>">
                                                            <label class="form-check-label" for="employee1"><?php echo $employee_name; ?></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" required="" name="employee" id="employee2" value="<?php echo 'programme_head' ?>">
                                                            <label class="form-check-label" for="employee2"><?php echo $ph_name; ?></label>
                                                        </div>
                                                        <label for="employee" class="error"></label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </br>
                                <textarea class="form-control" rows="4" name="comments_CEO" id="comments_CEO" placeholder="Enter comments"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $approvalNoteDetails[0]["approval_id"]; ?>">
                <input type="hidden" id="option" name="option" value="disapprove">
            </form>

            <br>
            <div class="text-right">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="ceo_deffer_request">Confirm</button>
            </div>

        </div>
    </div>
</div>
</div>
<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }

    $(document).ready(function () {
        $(document).on('click', '#ceo_deffer_request', function () {
            if ($("#ceo_defferModel_form").valid() == true) {
				$('#ceo_deffer_request').css('pointer-events', 'none');
                $('#ceo_defferModel_form').submit();
            }
        });

        $(document).on('click', '#ro_deffer_request', function () {
			$('#ro_deffer_request').css('pointer-events', 'none');
            $('#ro_defferModel_form').submit();
        });

        $(document).on('click', '#ph_deffer_request', function () {
			$('#ph_deffer_request').css('pointer-events', 'none');
            $('#ph_defferModel_form').submit();
        });

        $(document).on('click', '#ph_approve_submit', function () {
			$('#ph_approve_submit').css('pointer-events', 'none');
            $('#ph_approval_form').submit();
        });

        $(document).on('click', '#ph_dissappove_submit', function () {
			$('#ph_dissappove_submit').css('pointer-events', 'none');
            $('#ph_dissappove_form').submit();
        });

        $(document).on('click', '#ro_approve_submit', function () {
			$('#ro_approve_submit').css('pointer-events', 'none');
            $('#ro_approval_form').submit();
        });

        $(document).on('click', '#ro_dissappove_submit', function () {
			$('#ro_dissappove_submit').css('pointer-events', 'none');
            $('#ro_dissappove_form').submit();
        });

        $(document).on('click', '#ceo_approve_submit', function () {
			$('#ceo_approve_submit').css('pointer-events', 'none');
            $('#ceo_approval_form').submit();
        });

        $(document).on('click', '#ceo_dissappove_submit', function () {
			$('#ceo_dissappove_submit').css('pointer-events', 'none');
            $('#ceo_dissappove_form').submit();
        });

        $(document).on('click', '#cancel_request', function () {
            $('#an_close_model').modal('hide');
            $('#an_close_form').submit();
        });

        $(document).on('click', '#AN_Closed_modal', function () {
            $('#an_close_model').modal('show');
        });

        $(document).on('click', '#an_confirm_close', function () {
            $('#an_confirm_close_model').modal('hide');
            $('#an_confirm_form').submit();
        });

        $(document).on('click', '#AN_confirmed_Close_modal', function () {
            $('#an_confirm_close_model').modal('show');
        });

        $(document).on('click', '#an_dont_close', function () {
            $('#an_dont_close_model').modal('hide');
        });
        $(document).on('click', '#AN_DO_NOT_CLOSE_modal', function () {
            $('#an_dont_close_model').modal('show');
        });

        $(document).on('click', '#close_cls', function () {
            $('#actionmodal').modal('show');
        });

        $(document).on('click', '#dissappove_cls', function () {
            $('#dissappovemodal').modal('show');
        });

        $(document).on('click', '#approve_cls', function () {
            $('#approveModel').modal('show');
        });

        $(document).on('click', '#deffer_cls', function () {
            $('#defferModel').modal('show');
        });

        $('#author').keypress(function (e) {
            if (e.which == 13) {
                filter_check();
                return false;
            }
        });
    });

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {
        $('#purpose').val('');
        $('#approval_no').val('');
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>