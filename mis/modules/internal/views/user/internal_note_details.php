<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'My Internal Note Details')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'internal_note')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-5 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/internal/internal_notes/' . $internalNoteDetails[0]['status']; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?php echo 'Internal Notes Details - ' . $internalNoteDetails[0]['internal_no']; ?></h4>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if ($internalNoteDetails[0]['status'] != 'cancelled') { ?>
                                <li class="edit"><a href="<?php echo base_url() . 'index.php/internal/edit_internal_note/' . $internalNoteDetails[0]['internal_id']; ?>" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                            <?php } ?>

                            <?php
                            if ($internalNoteDetails[0]['to_RO'] == $this->session->userdata('user_id')) {
                                ?>
                                <?php if ($internalNoteDetails[0]['RO_status'] == 'pending') { ?>
                                    <?php if ($internalNoteDetails[0]['status'] != 'cancelled') { ?>
                                        <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ro_approveModel" class="master_aduser summaryEdit" id="approve_cls"><span>
                                            <i class="far fa-check-circle"></i></span> Approval</a></li>
                                        <?php } ?>
                                        <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ro_dissappovemodal" class="master_aduser summaryEdit"><span>
                                            <i class="far fa-check-circle"></i></span> Disapprove</a></li>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <?php
                                    if ($this->session->userdata('user') == $internalNoteDetails[0]['programme_head'] && $internalNoteDetails[0]['RO_status'] == 'confirmed' && $internalNoteDetails[0]['PH_status'] == 'pending') {
                                        ?>
                                        <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ph_approveModel" class="master_aduser summaryEdit" id="approve_cls"><span>
                                            <i class="far fa-check-circle"></i></span> Approval</a></li>

                                            <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#ph_dissappovemodal" class="master_aduser summaryEdit"><span>
                                                <i class="far fa-check-circle"></i></span> Disapprove</a></li>
                                            <?php } ?>

                                            <?php
                                            if ($fin_Usercount == 1 && $internalNoteDetails[0]['RO_status'] == 'confirmed') {
                                                if ($internalNoteDetails[0]['finance_status'] != 'confirmed') {
                                                    ?>
                                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#fin_approveModel" class="master_aduser summaryEdit" id="approve_cls"><span>
                                                        <i class="far fa-check-circle"></i></span> Confirm</a></li>
                                                        <?php
                                                        if ($internalNoteDetails[0]['finance_status'] != 'cancelled') {
                                                            ?>
                                                            <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#fin_dissappovemodal" class="master_aduser summaryEdit"><span>
                                                                <i class="far fa-check-circle"></i></span> Cancel</a></li>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($internalNoteDetails[0]['status'] != 'cancelled' && $internalNoteDetails[0]['approval_status'] != 'closed') {
                                                        ?>
    <!--                                <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#in_cancelmodal" class="master_aduser summaryEdit" ><span>
        <i class="far fa-check-circle"></i></span> Cancel</a></li>-->
    <?php } ?>

    <?php
    if ($fin_Usercount == 1 && $internalNoteDetails[0]['finance_status'] == 'confirmed') {
        ?>
        <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#fin_amountModel" class="master_aduser summaryEdit"><span>
            <i class="far fa-check-circle"></i></span> Amount recovered</a></li>
        <?php } ?>

        <!--<li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-print"></i></span> Print</a></li>-->

    </ul>
</div>
</div>

<div class="plan-structure-vital vital_windowScroll">
    <div class="tab-slider--container">
        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
            <main class="page-content">
                <div class="inputplan-structureall plan-structure-new">
                    <div class="row approvalLabel">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>Status :</label>
                                <p>
                                    <?php
                                    if ($internalNoteDetails[0]['status'] == 'Defered') {
                                        echo 'Deferred';
                                    } else {
                                        echo ucfirst($internalNoteDetails[0]['status']);
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>Reporting Officer Status :</label>
                                <p>
                                    <?php
                                    if ($internalNoteDetails[0]['RO_status'] == 'Defered') {
                                        echo 'Deferred';
                                    } else {
                                        echo ucfirst($internalNoteDetails[0]['RO_status']);
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>Reporting Officer :</label>
                                <p> <?php
                                if ($reporting_officer != '') {
                                    echo $reporting_officer;
                                } else {
                                    echo '';
                                }
                                ?></p>
                            </div>
                        </div>

                    </div>
                    <div class="row approvalLabel">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>Approval Note :</label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['approval_no']) && $internalNoteDetails[0]['approval_no'] != '') {
                                        echo $internalNoteDetails[0]['approval_no'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>Internal Note :</label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['internal_no']) && $internalNoteDetails[0]['internal_no'] != '') {
                                        echo $internalNoteDetails[0]['internal_no'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>From Employee :</label>
                                <p>
                                    <?php echo $from_employeeName; ?>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="row approvalLabel">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="display-flex">
                                <label>Date :</label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['date']) && $internalNoteDetails[0]['date'] != '') {
                                        echo date('d-m-Y', strtotime($internalNoteDetails[0]['date']));
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                            <div class="display-flex">
                                <label>Subject :</label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['subject']) && $internalNoteDetails[0]['subject'] != '') {
                                        echo $internalNoteDetails[0]['subject'];
                                    } else {
                                        echo '';
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
                                    <th>Programme</th>
                                    <th>Donor - Grant</th>
                                    <th>Budget Head</th>
                                    <th>Line Item</th>
									<th>Details</th>
                                    <th>AN Amount (<?= $this->session->userdata['currency']; ?>)</th>
                                    <th>IN Amount (<?= $this->session->userdata['currency']; ?>)</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="metric_more">
                                    <td><?php echo $internalNoteDetails[0]['programme']; ?></td>
                                    <td><?php echo $donor_grant; ?></td>
                                    <td><?php echo $internalNoteDetails[0]['budget_head']; ?></td>
                                    <td><?php echo $internalNoteDetails[0]['line_item']; ?></td>
									<td><?php echo $internalNoteDetails[0]['additionalinfo']; ?></td>
                                    <td><?php echo number_format($internalNoteDetails[0]['total_amount'], 2); ?></td>
                                    <td><?php echo number_format($internalNoteDetails[0]['amount_toapprove'], 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="height: 15px;"></div>


                    <div class="row approvalLabel">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Reason for which payment is sought : </label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['reason_payment_sougnt']) && $internalNoteDetails[0]['reason_payment_sougnt'] != '') {
                                        echo $internalNoteDetails[0]['reason_payment_sougnt'];
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row approvalLabel">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Invoice date : </label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['invoice_date']) && $internalNoteDetails[0]['invoice_date'] != '') {
                                        echo date('d-m-Y', strtotime($internalNoteDetails[0]['invoice_date']));
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Proposed Date of Payment : </label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['proposed_date']) && $internalNoteDetails[0]['proposed_date'] != '') {
                                        echo date('d-m-Y', strtotime($internalNoteDetails[0]['proposed_date']));
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row approvalLabel">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Payment in favor of : </label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['payment_favor']) && $internalNoteDetails[0]['payment_favor'] != '') {
                                        echo $internalNoteDetails[0]['payment_favor'];
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Reporting Officer's Approval Date : </label>
                                <p>
                                    <?php
                                    if (isset($internalNoteDetails[0]['RO_date']) && $internalNoteDetails[0]['RO_date'] != '') {
                                        echo date('d-m-Y', strtotime($internalNoteDetails[0]['RO_date']));
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row approvalLabel">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label style="margin-bottom: auto;">Supporting documents attached : </label>
                                <p>
                                    <?php
                                    if ($internalNoteDetails[0]['supporting_documents'] != '') {
                                        echo nl2br($internalNoteDetails[0]['supporting_documents']);
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Reporting Officer's Comments : </label>
                                <p> <?php
                                if (isset($internalNoteDetails[0]['comments_RO']) && $internalNoteDetails[0]['comments_RO'] != '') {
                                    echo $internalNoteDetails[0]['comments_RO'];
                                } else {
                                    echo '';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

                <?php if ($internalNoteDetails[0]['status'] == 'cancelled') { ?>
                    <div class="row approvalLabel">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="display-flex">
                                <label>Cancelled by : </label>
                                <p> <?php
                                if (isset($internalNoteDetails[0]['cancelledby']) && $internalNoteDetails[0]['cancelledby'] != '') {
                                    echo "Admin (" . $internalNoteDetails[0]['cancelledby'] . ")";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row approvalLabel">
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="display-flex">
                            <label>Cancelled date : </label>
                            <p> <?php
                            if (isset($internalNoteDetails[0]['cancelled_date']) && $internalNoteDetails[0]['cancelled_date'] != '') {
                                echo date('d-m-Y', strtotime($internalNoteDetails[0]['cancelled_date']));
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="display-flex">
                        <label>Cancelled comments : </label>
                        <p>
                            <?php
                            if (isset($internalNoteDetails[0]['comments_admin']) && $internalNoteDetails[0]['comments_admin'] != '') {
                                echo $internalNoteDetails[0]['comments_admin'];
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($internalNoteDetails[0]['ip_address'] != '') { ?>
            <div class="row approvalLabel">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="display-flex">
                        <label>IP Address : </label>
                        <p> <?php
                        if (isset($internalNoteDetails[0]['ip_address']) && $internalNoteDetails[0]['ip_address'] != '') {
                            echo $internalNoteDetails[0]['ip_address'];
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row approvalLabel">
        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
            <div class="display-flex">
                <label style="margin-bottom: auto;">Attachments : </label>
                <p>
                    <?php
                    if (!empty($internalNoteDetails[0]['attachment'])) {
                        foreach (unserialize(@$internalNoteDetails[0]['attachment']) as $key => $value) :
                            ?><a href="<?= base_url(); ?>uploads/support_docs/<?= $value ?>" target="_blank" style="font-weight:bold;"><?= $value ?></a><br /><?php
                        endforeach;
                    }
                    $text = 'b:0;';
                    if (!empty($internalNoteDetails[0]['andocuments']) && $internalNoteDetails[0]['andocuments'] != $text) {
                        foreach (unserialize(@$internalNoteDetails[0]['andocuments']) as $key => $value) :
                            ?><a href="<?= base_url(); ?>uploads/support_docs/<?= $value ?>" target="_blank" style="font-weight:bold;"><?= $value ?></a><br /><?php
                        endforeach;
                    }
                    ?>
                    <?php
                                                    /* foreach (unserialize($internalNoteDetails[0]['attachment']) as $key => $value):
                                                      ?><a href="<?= base_url(); ?>uploads/support_docs/<?= $value ?>" target="_blank" style="font-weight:bold;font-size:10px;"><?= $value ?></a><br/><?php
                                                  endforeach; */
                                                  ?></p>
                                              </div>
                                          </div>
                                      </div>

                                      <?php if ($internalNoteDetails[0]['finance_status'] == 'confirmed') { ?>
                                        <div class="row approvalLabel">
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="display-flex">
                                                    <label>Cheque Number : </label>
                                                    <p> <?php
                                                    if (isset($internalNoteDetails[0]['check_no']) && $internalNoteDetails[0]['check_no'] != '') {
                                                        echo $internalNoteDetails[0]['check_no'];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Payment Status : </label>
                                                <p>
                                                    <?php
                                                    if (isset($internalNoteDetails[0]['finance_status']) && $internalNoteDetails[0]['finance_status'] != '') {
                                                        echo ucfirst($internalNoteDetails[0]['finance_status']);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Cheque Date : </label>
                                                <p>
                                                    <?php
                                                    if (isset($internalNoteDetails[0]['check_date']) && $internalNoteDetails[0]['check_date'] != '') {
                                                        echo date('d-m-Y', strtotime($internalNoteDetails[0]['check_date']));
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Finance Comments : </label>
                                                <p>
                                                    <?php
                                                    if (isset($internalNoteDetails[0]['finance_comments']) && $internalNoteDetails[0]['finance_comments'] != '') {
                                                        echo $internalNoteDetails[0]['finance_comments'];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($internalNoteDetails[0]['finance_status'] == 'cancelled') {
                                    ?>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Payment Status : </label>
                                                <p>
                                                    <?php
                                                    if (isset($internalNoteDetails[0]['finance_status']) && $internalNoteDetails[0]['finance_status'] != '') {
                                                        echo ucfirst($internalNoteDetails[0]['finance_status']);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Finance Comments : </label>
                                                <p>
                                                    <?php
                                                    if (isset($internalNoteDetails[0]['finance_comments']) && $internalNoteDetails[0]['finance_comments'] != '') {
                                                        echo $internalNoteDetails[0]['finance_comments'];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (php72_count($recover_amt) > 0) { ?>
                                    <div class="row approvalLabel pad-tp12">
                                        <div class="col-xl-12">
                                            <h6>Recovered Amount</h6>
                                            <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                <table class="table" id="detail_table" style="margin-top: 0">
                                                    <thead>
                                                        <tr>
                                                            <!--<th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>-->
                                                            <th width="2%"></th>
                                                            <th width="13%">Amount</th>
                                                            <th width="15%">Date</th>
                                                            <th width="15%">Comment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $j = 1;
                                                        $list_tot = 0;
                                                        foreach ($recover_amt as $amtlist) {
                                                            $list_tot += $amtlist['amount'];
                                                            ?>
                                                            <tr id="addview_tr_<?= $j; ?>">
                                                                <td><?= $j; ?></td>
                                                                <td><?php echo $amtlist['amount']; ?></td>
                                                                <td><?php echo date('d-m-Y', strtotime($amtlist['date'])); ?></td>
                                                                <td><?php echo $amtlist['comments']; ?></textarea>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $j++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfooter>
                                                        <th colspan="1">Total</th>
                                                        <td><?php echo $list_tot; ?></td>

                                                    </tfooter>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
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

<div class="modal" id="an_dont_close_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
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
                <form name="ph_approval_form" id="ph_approval_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/ph">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_PH" id="comments_PH" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
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
                <form name="ph_dissappove_form" id="ph_dissappove_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/ph">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-10">
                                    <textarea class="form-control" rows="4" name="comments_PH" id="comments_PH" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="disapprove">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ph_dissappove_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="fin_approveModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Internal Note - Payment status confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="fin_approval_form" id="fin_approval_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/finance_approval">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Cheque Number</label>
                                        <input type="text" id="cheque_number" class="form-control" name="cheque_number" value="" placeholder="Enter number">
                                    </div>
                                    <div class="form-group">
                                        <label>Cheque Date</label>
                                        <input type="text" id="cheque_date" class="form-control datefield" name="cheque_date" value="" placeholder="dd-mm-yyyy">
                                    </div>
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea class="form-control" rows="4" name="comments_fin" class="form-control" id="comments_fin" placeholder="Enter comments"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="internal_id" name="internal_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="approve">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="fin_approve_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="fin_dissappovemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Internal Note - Cancel Payment Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="fin_dissappove_form" id="fin_dissappove_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/finance_approval">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <textarea class="form-control" rows="4" name="comments_fin" placeholder="Enter comments" id="comments_fin"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="internal_id" name="internal_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="disapprove">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="ph_dissappove_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="fin_amountModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Internal Note - Amount Recovered Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="modal-content">
                    <form name="fin_amount_form" id="fin_amount_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/finance_recoveramt" autocomplete="off">
                        <div class="modal-body text-center">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9"></div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fa fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="detail_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="2%"></th>
                                                        <th width="13%">Amount</th>
                                                        <th width="15%">Date</th>
                                                        <th width="15%">Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($recover_amt) && php72_count($recover_amt) > 0) {
                                                        ?>
                                                        <input type="hidden" name="recovery_id" id="recovery_id" value="<?php echo $recover_amt[0]['recover_id']; ?>" />
                                                        <?php
                                                        $j = 1;
                                                        foreach ($recover_amt as $amtlist) {
                                                            ?>
                                                            <input type="hidden" name="recov_amt_id[]" id="recov_amt_id_<?= $j; ?>" value="<?php echo $amtlist['id']; ?>" />
                                                            <tr id="add_tr_<?= $j; ?>" class="add_more">
                                                                <td><i title="Remove" class="fas fa-minus-circle cursor" onclick="deleteRow('<?php echo $amtlist['id']; ?>', '<?= $j; ?>');" aria-hidden="true"></i></td>
                                                                <td>
                                                                    <input class="form-control" onkeypress="return isNumberKey_With_Dot(event);" type="text" name="recover_amt[]" id="recover_amt_<?= $j; ?>" value="<?php echo $amtlist['amount']; ?>" placeholder="00" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control datefield" type="text" name="recover_date[]" id="recover_date_<?= $j; ?>" value="<?php echo date('d-m-Y', strtotime($amtlist['date'])); ?>" placeholder="dd-mm-yyyy" />
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="recover_comments[]" id="recover_comments_<?= $j; ?>" placeholder="Enter comments"><?php echo $amtlist['comments']; ?></textarea>
                                                                </td>

                                                            </tr>
                                                            <?php
                                                            $j++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr id="add_tr_1" class="add_more">
                                                            <td></td>
                                                            <td>
                                                                <input type="text" onkeypress="return isNumberKey_With_Dot(event);" class="form-control" name="recover_amt[]" id="recover_amt_1" value="" placeholder="00" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control datefield" name="recover_date[]" id="recover_date_1" value="" placeholder="dd-mm-yyyy" />
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="recover_comments[]" id="recover_comments_1" placeholder="Enter comments"></textarea>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                        <input type="hidden" id="internal_id" name="internal_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>">
                        <br>
                        <div class="text-right">
                            <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                            <button type="submit" class="btn btn-success" id="fin_approve_submit">Add</button>
                        </div>
                    </form>
                </div>
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
                <form name="ro_approval_form" id="ro_approval_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/ro">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_RO" id="comments_RO" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="internal_id" name="internal_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="approve">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="ro_approve_submit">Confirm</button>
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
                <form name="ro_dissappove_form" id="ro_dissappove_form" method="POST" action="<?php echo base_url(); ?>index.php/internal/ro">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_RO" id="comments_RO" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="internal_id" name="internal_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>">
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

<div class="modal" id="in_cancelmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Internal Note - Cancel Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="in_cancel_from" id="in_cancel_from" method="POST" action="<?php echo base_url(); ?>index.php/internal/InCancel">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control" rows="4" name="comments_admin" id="comments_admin" placeholder="Enter comments"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="approval_id" name="approval_id" value="<?php echo $internalNoteDetails[0]["approval_id"]; ?>">
                    <input type="hidden" id="internal_id" name="internal_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>">
                    <input type="hidden" id="option" name="option" value="disapprove">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="in_cancel_submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
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

    function isNumberKey_With_Dot(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
            if (charCode == 46)
                return true;
            else
                return false;
        } else
        return true;
    }



    $(document).on('click', '#addMore', function () {
        var dyn = $(".add_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
        datas += '<td><input class="form-control" type="text" onkeypress="return isNumberKey_With_Dot(event);" name="recover_amt[]" id="recover_amt_' + i + '" value="" placeholder="00" /></td>';
        datas += '<td><input type="text" class="form-control datefield" name="recover_date[]" id="recover_date_' + i + '" value="" placeholder="dd-mm-yyyy" /></td>';
        datas += '<td><textarea class="form-control" name="recover_comments[]" id="recover_comments_' + i + '" placeholder="Enter comments"></textarea></td></tr>';
        $(datas).insertAfter($('#add_tr_' + dyn));
    });

    function removeRow(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    function deleteRow(amtid, div_id) {
        var recovery_id = $('#recovery_id').val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/internal/finance_deleteamt",
            type: 'POST',
            "data": {
                'recovery_id': recovery_id,
                'amtid': amtid
            },
            success: function (msg) {
                $('#add_tr_' + div_id).closest('tr').remove();

            }
        });
    }

    $(document).on("focus", ".datefield", function () {
        if ($(this).hasClass('hasDatepicker') === false) {
            $(this).datepicker({
                dateFormat: 'dd-mm-yy'
            });
        }
    });
</script>

</body>

</html>