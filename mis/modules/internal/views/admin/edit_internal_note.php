<?php $this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Edit Internal Note', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'internal_note')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/internal/internal_note_details/' . $internalNoteDetails[0]["internal_id"]; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Edit Internal Note <?php
                            if (isset($internalNoteDetails[0]['internal_no']) && $internalNoteDetails[0]['internal_no'] != '') {
                                echo '- ' . $internalNoteDetails[0]['internal_no'];
                            }
                            ?></h4>

                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <form name="addApproval" id="addApproval" enctype="multipart/form-data" action="<?php echo base_url() . 'index.php/internal/internaladmin/insert_internal_note'; ?>" method="post" autocomplete="off" onsubmit="return validate_amount();">
                                    
									<input type="hidden" name="additionalinfo_id" id="additionalinfo_id" value="<?php echo $internalNoteDetails[0]["additionalinfo"]; ?>" >
									<input type="hidden" name="internal_edit_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>" >
									<input type="hidden" name="programme_id_val" id="programme_id_val" value="<?php echo $internalNoteDetails[0]['prog_id']; ?>" >	
									
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Internal Note Number</label>
                                                    <input class="form-control" name="internal_no" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['internal_no']) && $internalNoteDetails[0]['internal_no'] != '') {
                                                        echo $internalNoteDetails[0]['internal_no'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Date<span>*</span></label>
                                                    <input class="form-control" name="date" type="text" name="approval_no" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['date']) && $internalNoteDetails[0]['date'] != '') {
                                                        echo $internalNoteDetails[0]['date'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>From<span>*</span></label>
                                                    <input class="form-control" readonly name="to_RO_show" id="to_RO_show" value="<?php
                                                    if (isset($from_employee) && $from_employee != '') {
                                                        echo $from_employee;
                                                    }
                                                    ?>" type="text" placeholder="Enter here">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <input class="form-control" name="subject" type="text"  value="<?php
                                                    if (isset($internalNoteDetails[0]['subject']) && $internalNoteDetails[0]['subject'] != '') {
                                                        echo $internalNoteDetails[0]['subject'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Approval Number<span>*</span></label>
                                                    <input class="form-control" name="approval_no" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['approval_no']) && $internalNoteDetails[0]['approval_no'] != '') {
                                                        echo $internalNoteDetails[0]['approval_no'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Programme<span>*</span></label>
                                                    <input class="form-control" name="programme" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['programme_name']) && $internalNoteDetails[0]['programme_name'] != '') {
                                                        echo $internalNoteDetails[0]['programme_name'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="approval_id" value="<?php echo $internalNoteDetails[0]['approval_id']; ?>" >
                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="detail_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow"></th>
                                                        <th width="13%">Donor<span class="clr-red">*</span></th>
                                                        <th width="15%">Grant<span class="clr-red">*</span></th>
                                                        <th width="15%">Budget Head<span class="clr-red">*</span></th>
                                                        <th width="15%">Line Item<span class="clr-red">*</span></th>
                                                        <th width="15%">Sub-Line Item<span class="clr-red">*</span></th>
                                                        <th width="10%">Details<span class="clr-red">*</span></th>
                                                        <th width="10%">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
													$t = 1;
                                                    $tot_amount = 0;
													#echo'<pre>';print_r($donorAN);die;
                                                    foreach ($donorAN as $dataList) {

                                                        $donorAN1 = $this->Mapproval->getApprovalDonors($dataList["approval_id"]);
                                                        foreach ($donorAN1 as $rows):
                                                            $tamt_required[] = $rows['amt_required'];
                                                        endforeach;
                                                        $amt_required = array_sum($tamt_required);
                                                        $sumof_int_amt = $this->Mapproval->int_amt_sumof($dataList["approval_id"]);
                                                        $remain_amt = $amt_required - $sumof_int_amt;

                                                        $tot_amount += $dataList['amt_required'];
                                                        $this->load->model('Minternal');
                                                        $get_grantName = $this->Minternal->get_grantName($dataList['grant_id']);
                                                        if ($get_grantName[0]->status_type == 'open') {
                                                            $opt_disable = '';
                                                            $opt_color = '#fff';
                                                        } else {
                                                            $opt_disable = 'disabled';
                                                            $opt_color = '#f1c2c4';
                                                        }

                                                        if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
                                                            $readonly = '';
                                                        } else {
                                                            $readonly = 'readonly';
                                                        }
                                                        ?>
                                                        <tr id="add_tr_1" class="add_more" style="background-color: <?= $opt_color; ?>">
                                                            <td class="align-middle">
                                                                <input date-attr-details="<?php echo 'details_'.$t; ?>" type="radio" name="select_donor" id="select_donor" onchange="donor_change(<?= $dataList['approval_id'] ?>, this.value, <?= $internalNoteDetails[0]['internal_id'] ?>);" value="<?php
                                                                if (isset($dataList['approval_donor_id']) && $dataList['approval_donor_id'] != '') {
                                                                    echo $dataList['approval_donor_id'];
                                                                }
                                                                ?>" <?= $opt_disable; ?> <?= ($apn_donor_id[0]['approval_donor_id'] == $dataList['approval_donor_id']) ? 'checked' : ''; ?> class="form-control select_donor" />
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['donor']) && $dataList['donor'] != '') {
                                                                    echo $dataList['donor'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="donor_list[]" id="donor_1" >
                                                            </td>
                                                            <td>
                                                                <input readonly value="<?php echo $get_grantName[0]->name; ?>"  type="text" class="form-control" name="grant_list[]" id="grant_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['budget_head']) && $dataList['budget_head'] != '') {
                                                                    echo $dataList['budget_head'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="budget_list[]" id="budget_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['line_item']) && $dataList['line_item'] != '') {
                                                                    echo $dataList['line_item'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="line_list[]" id="lineitem_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['donor']) && $dataList['donor'] != '') {
                                                                    echo $dataList['donor'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="donor_list[]" id="sublineitem_1" >
                                                            </td>
                                                            <td>
                                                               <select  data-attr-details-id-<?php echo $t;?>="<?php echo $dataList['details_id'] ?>" data-attr-donor-id-<?php echo $t;?>="<?php echo $dataList['donor_id'] ?>" data-attr-budgethead-id-<?php echo $t;?>="<?php echo $dataList['budgethead_id'] ?>" data-attr-lineitem-id-<?php echo $t;?>="<?php echo $dataList['lineitem_id'] ?>"  value="<?php
																?>" type="text" class="form-control <?php echo 'details_'.$t; ?> details" name="additional_list[]" id="additional_1" >
																	<option value=''>--Select--</option>
																</select>
                                                            </td>
                                                            <td>
																<?php //echo $dataList['amt_required']; ?>
                                                                <input value="<?php
                                                                if (isset($dataList['amt_required']) && $dataList['amt_required'] != '') {
                                                                    echo $dataList['amt_required'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="amount" >
                                                            </td>
                                                            <?php if ($get_grantName[0]->status_type != 'open') { ?>
                                                                <td style="background-color: #fff; border: none;">&nbsp;<strong>&nbsp;<a href="javascript:(void)" onmouseover="showMsg('<?= $t; ?>');" id="draft_hint_<?= $t; ?>">(?)</a></strong></td>
                                                        <div id="draft_<?= $t; ?>" title="Information" style="display:none;height:100px;">
                                                            <p>
                                                                Internal note cannot be submitted at this time as the grant (<?= $get_grantName[0]->name; ?>) has been put <b><?= ucfirst($get_grantName[0]->status_type); ?></b>. Please check with the donor and finance teams.
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                    </tr>
                                                <?php  $t++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="height:20px"></div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Amount for which approval has been taken (<?= $this->session->userdata['currency']; ?>)<span>*</span></label>
                                                    <input readonly="" name="total_amount" value="<?php
                                                    if (isset($internalNoteDetails[0]['total_amount']) && $internalNoteDetails[0]['total_amount'] != '' && $internalNoteDetails[0]['total_amount'] != 0) {
                                                        echo $internalNoteDetails[0]['total_amount'];
                                                    } else {
                                                        echo $tot_amount;
                                                    }
                                                    ?>" class="form-control" type="text" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Remaining amount on the selected donor (<?= $this->session->userdata['currency']; ?>)<span>*</span></label>
                                                    <input type="text" name="remain_amt" id="remain_amt" value="<?php echo $donor_balance; ?>" readonly class="form-control" placeholder=""/>
                                                </div>
                                            </div>
                                            <?php
                                            $apn_status = $this->Mapproval->getStatusApn($dataList["approval_id"]);
                                            $status = $apn_status[0]['status'];
                                            $in_status = $internalNoteDetails[0]['status'];
                                            $amount_toapprove = $internalNoteDetails[0]['amount_toapprove'];
                                            ?>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Amount to be approved (<?= $this->session->userdata['currency']; ?>)<span>*</span></label>
                                                    <input class="form-control" <?= $readonly; ?> name="amount_toapprove" type="text" id="amount_toapprove" <?php if ($status == 'closed') echo 'readonly'; ?> value="<?php
                                                    if (isset($internalNoteDetails[0]['amount_toapprove']) && $internalNoteDetails[0]['amount_toapprove'] != '') {
                                                        echo $internalNoteDetails[0]['amount_toapprove'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Date of Invoice<span>*</span></label>
                                                    <div class="position-relative">
                                                        <input class="form-control" placeholder="dd-mm-yy"  id="invoice_date" name="invoice_date" type="text" value="<?php
                                                        if (isset($internalNoteDetails[0]['invoice_date']) && $internalNoteDetails[0]['invoice_date'] != '') {
                                                            echo date('d-m-Y', strtotime($internalNoteDetails[0]['invoice_date']));
                                                        }
                                                        ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Proposed date of processing payments<span>*</span></label>
                                                    <div class="position-relative">
                                                        <input class="form-control"  id="proposed_date" placeholder="dd-mm-yy" type="text" name="proposed_date"  value="<?php
                                                        if (isset($internalNoteDetails[0]['proposed_date']) && $internalNoteDetails[0]['proposed_date'] != '') {
                                                            echo date('d-m-Y', strtotime($internalNoteDetails[0]['proposed_date']));
                                                        }
                                                        ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Reason for which payment is sought</label>
                                                    <div class="position-relative">
                                                        <textarea class="form-control" name="reason_payment_sougnt" id="reason_payment_sougnt"><?php
                                                            if (isset($internalNoteDetails[0]['reason_payment_sougnt']) && $internalNoteDetails[0]['reason_payment_sougnt'] != '') {
                                                                echo $internalNoteDetails[0]['reason_payment_sougnt'];
                                                            }
                                                            ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Supporting documents attached</label>
                                                    <div class="position-relative">
                                                        <textarea class="form-control" name="supporting_documents"><?php
                                                            if (isset($internalNoteDetails[0]['supporting_documents']) && $internalNoteDetails[0]['supporting_documents'] != '') {
                                                                echo $internalNoteDetails[0]['supporting_documents'];
                                                            }
                                                            ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Payment in favor of<span>*</span></label>
                                                    <input class="form-control" name="payment_favor" type="text" name="approval_no" <?= $readonly; ?> value="<?php
                                                    if (isset($internalNoteDetails[0]['payment_favor']) && $internalNoteDetails[0]['payment_favor'] != '') {
                                                        echo $internalNoteDetails[0]['payment_favor'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $files = unserialize($internalNoteDetails[0]['andocuments']);
                                        if (!empty($files)) {
                                            ?>
                                            <div class="row leaveLabel">
                                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label>AN Supporting Documents</label>
                                                        <div class="position-relative">
                                                            <table class="table" style="margin-top: 0">
                                                                <tbody>
                                                                    <?php
                                                                    $an = 1;
                                                                    foreach (unserialize($internalNoteDetails[0]['andocuments']) as $key => $value) {
                                                                        ?>
                                                                        <tr id="andocument_tr_<?php echo $an; ?>">
                                                                            <td>
                                                                                <div class="fileUpload blue-btn btn width100">
                                                                                    <span><i ></i> <?php echo substr($value, -30); ?></span>
                                                                                    <input type="hidden" value="<?php echo $value; ?>" class="form-control" name="andocument[]" />
                                                                                </div>&nbsp;
                                                                                <span class="download-btn"><a href="<?php
                                                                                    if (isset($value) && $value != '') {
                                                                                        echo base_url() . 'uploads/support_docs/' . $value;
                                                                                    }
                                                                                    ?>" title="View Document - <?= $value; ?>" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                <i title="Remove" class="fas fa-minus-circle cursor" onclick="removeDocAN(<?php echo $an; ?>);" aria-hidden="true"></i>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $an++;
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
										
										
										<?php if($finance_user_status=='1' && $status == 'confirmed'){ ?>
										
										 <input type="hidden" name="tds_id" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['id']; } ?>" />
										<div class="row leaveLabel">
                                          
										  
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Taxable amount</label>
                                                    <input name="taxable_amount" id="taxable_amount"  class="form-control" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['taxable_amount']; } ?>" type="number" placeholder=""/>
                                                </div>
                                            </div>
											
										  <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>TDS Type</label>
                                                    <select class="form-control " name="tds_type" id="tds_type" >
															<option value=''>--Select--</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_type'] =='TDS on Contract'){ echo "selected"; } } ?>  value="TDS on Contract">TDS on Contract</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_type'] =='TDS on Professional fee'){ echo "selected"; } } ?> value="TDS on Professional fee">TDS on Professional fee</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_type'] =='TDS on Rent'){ echo "selected"; } } ?> value="TDS on Rent">TDS on Rent</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_type'] =='TDS on Salary'){ echo "selected"; } } ?> value="TDS on Salary">TDS on Salary</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_type'] =='TDS on Commission'){ echo "selected"; } } ?> value="TDS on Commission">TDS on Commission</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_type'] =='TDS on Non-Resident Persons Payment'){ echo "selected"; } } ?> value="TDS on Non-Resident Persons Payment">TDS on Non-Resident Persons Payment</option>
													</select>
                                                </div>
                                            </div>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>TDS Percentage</label>
													<select class="form-control " name="tds_percentage" id="tds_percentage" >
															<option value=''>--Select--</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_percentage'] =='1'){ echo "selected"; } } ?>   value="1">1 %</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_percentage'] =='2'){ echo "selected"; } } ?> value="2">2 %</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_percentage'] =='5'){ echo "selected"; } } ?> value="5">5 %</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_percentage'] =='10'){ echo "selected"; } } ?> value="10">10 %</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_percentage'] =='20'){ echo "selected"; } } ?> value="20">20 %</option>
															<option <?php if(isset($tdsDetails) && $tdsDetails!=''){ if($tdsDetails['tds_percentage'] =='custom'){ echo "selected"; } } ?> value="custom">Custom</option>
													</select>
												</div>
                                            </div>
											
											<div 
											
											style="<?php 
												if(isset($tdsDetails) && !empty($tdsDetails) && isset($tdsDetails['tds_percentage']) && $tdsDetails['tds_percentage'] =='custom'){
													echo "display:block;";
												} else {
													echo "display:none;";
												}
											?>" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['tds_custom_percentage']; } ?>" class="col-12 col-md-4 col-lg-4 col-xl-4" id="custorm_per" >
                                                <div class="form-group">
                                                    <label>Custom percentage</label>
                                                    <input name="custom_percentage" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['tds_custom_percentage']; } ?>" id="custom_percentage" class="form-control" type="number" placeholder=""/>
                                                </div>
                                            </div>
											
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>TDS amount</label>
                                                    <input readonly name="tds_amount" id="tds_amount"  class="form-control" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['tds_amount']; } ?>" type="number" placeholder=""/>
                                                </div>
                                            </div>
											
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Advance Paid Inclusive of TDS</label>
                                                    <input name="advance_paid" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['advance_paid']; } ?>" id="advance_paid" class="form-control" type="number" placeholder=""/>
                                                </div>
                                            </div>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Net Amount</label>
                                                    <input readonly name="net_amount" value="<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['net_amount']; } ?>" id="net_amount"  class="form-control" type="text" placeholder=""/>
                                                </div>
                                            </div>
											
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Vendor Lists</label>
                                                      <select class="form-control " name="vendor_id" id="vendor_id" >
															<option value=''>--Select--</option>
															<?php
																foreach ($get_vendor as $lists) {
																$selected = '';
																if(isset($tdsDetails) && $tdsDetails!=''){ 
																	if($tdsDetails['vendor_id'] ==$lists['id']){
																		$selected = 'selected';
																	}
																}
															?>
															<option value="<?= $lists['id']; ?>" <?= $selected; ?>><?= $lists['name']; ?></option>
														<?php } ?>
													</select>
                                                </div>
                                            </div>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Vendor Bank List</label>
                                                      <select class="form-control" id="vendor_bank_id" name="vendor_bank_id"  >
														<option value=''>--Select--</option>
													</select>
                                                </div>
                                            </div>
											
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Debit Bank Lists</label>
                                                      <select class="form-control" name="debit_bank_id" id="debit_bank_id" >
															<option value=''>--Select--</option>
															<?php
																if(!empty($get_debit_account)){
																foreach ($get_debit_account as $lists) {
																$selected = '';
																if(isset($tdsDetails) && $tdsDetails!=''){ 
																	if($tdsDetails['debit_bank_id'] == $lists->id){
																		$selected = 'selected';
																	}
																} 
															?>
															<option value="<?= $lists->id; ?>" <?= $selected; ?>><?php echo $lists->bank_name.' - '.$lists->account_number; ?></option>
														<?php } 
														
														} ?>
													</select>
                                                </div>
                                            </div>

                                        </div>
										
										
										
										<?php } ?>
										

                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Supporting Documents</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="docMore"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="35%">Upload Document</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $get_inDoc = unserialize($internalNoteDetails[0]['attachment']);
                                                    if ($get_inDoc[0] != '') {
                                                        foreach (unserialize($internalNoteDetails[0]['attachment']) as $key => $value) {
                                                            ?>
                                                            <tr id="document_tr_<?php echo $i; ?>" class="document_more">
                                                        <input type="hidden" name="exist_doc[]" class="exist_doc_<?php echo $i; ?>" id="exist_doc_<?php echo $i; ?>" value="<?= $value; ?>" />
                                                        <td>
                                                            <div class="fileUpload blue-btn btn width100">
                                                                <span><i ></i> <?php echo substr($value, -30); ?></span>
                                                                <input type="file" value="<?php echo $value; ?>" class="uploadlogo" name="meet_doc[]"  id="meet_doc_<?php echo $i; ?>" />
                                                            </div>
                                                            <span class="download-btn"><a href="<?php
                                                                if (isset($value) && $value != '') {
                                                                    echo base_url() . '/uploads/support_docs/' . $value;
                                                                }
                                                                ?>" title="View Document - <?= $value; ?>" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                            <i title="Remove" class="fas fa-minus-circle cursor" onclick="removeDocRow(<?php echo $i; ?>);" aria-hidden="true"></i>
                                                            <label class="sow_msg error" id="meet_doc_<?php echo $i; ?>_error"></label>
                                                        </td>
                                                        <td></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr id="document_tr_1" class="document_more">
                                                        <td width="30%">
                                                            <div class="fileUpload blue-btn btn width100">
                                                                <span><i class="fas fa-upload"></i> Upload</span>
                                                                <input type="file" value="" class="uploadlogo" name="meet_doc[]"  id="meet_doc_1" />
                                                            </div>

                                                            <label class="sow_msg error" id="meet_doc_1_error"></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div style="height:20px"></div>
                                        <div class="row ">
                                            <div class="col-12 col-sm-12  col-md-12 ">
                                                <ul class="vitals-links">
                                                    <li><input type="submit" name="submitForm" value="Update" class="vital_yellow_btn wdt_100"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
<style>
/* Hide the up and down arrows */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type="number"] {
    -moz-appearance: textfield; /* Firefox */
}
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
		
		$("#tds_percentage").click(function(){
			$("#custorm_per").css('display','none');
			if($(this).val()=='custom'){
				$("#custorm_per").css('display','block');
			}
			//calclateTaxPercentage();
		});
		$("#taxable_amount, #custom_percentage, #tds_percentage").on("input", function() {
			calculateTdsAmount();
		});
		function calculateTdsAmount(){console.log("tds_amt");
			var taxable_amount_val = parseFloat($("#taxable_amount").val()) || 0;
			get_tds_percentage_val = $("#tds_percentage").val();
			tds_percentage_val  ='';
			tds_amt ='';
			if(get_tds_percentage_val!=''){
				if(get_tds_percentage_val!='custom'){
					tds_percentage_val =parseFloat($("#tds_percentage").val()) || 0;
				}else{
					tds_percentage_val =parseFloat($("#custom_percentage").val()) || 0;
				}
			}
			if(tds_percentage_val!='' && taxable_amount_val!=''){
				tds_amt = Math.round(taxable_amount_val*0.01*tds_percentage_val)|| 0;
			}
			$("#tds_amount").val(tds_amt);
			$("#advance_paid").val('');
			$("#net_amount").val('');
		}

		if($("#vendor_id").val()!=''){
			$("#vendor_bank_id").html('<select id="vendor_bank_id" name="vendor_bank_id"><option value="">--Select--</option></select>');
			if($("#vendor_id").val()!=''){
				 $.ajax({
					url: '<?= site_url('internal/getVendorBankDetails'); ?>',
					type: 'POST',
					"data": {
							"vendor_id": $("#vendor_id").val(),
							"internal_id": '<?php echo $internalNoteDetails[0]["internal_id"]; ?>',
							"selected_id": '<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['vendor_bank_id']; } ?>'
						},
					dataType: "html",
					async: false,
					success: function (datas_val) {
						if(datas_val!=''){
							$("#vendor_bank_id").html(datas_val);
						}
					}
				});	
			}
		}
		
		
		 // Function to calculate net amount (Amount to be approved - Advance Paid (Manual Entry) - TDS amount Debit Account field to be added based on Donor Type)
		function calculateNetAmount() {
			var amount_toapprove = parseFloat($("#amount_toapprove").val()) || 0;
			var advance_paid = parseFloat($("#advance_paid").val()) || 0; 
			var tds_amount = parseFloat($("#tds_amount").val()) || 0; 
			var netAmount = (amount_toapprove - advance_paid) - tds_amount;
			if (netAmount < 0) {
					netAmount = 0; 
				}
			$("#net_amount").val(netAmount.toFixed(2));
		}

		$("#tds_amount, #advance_paid").on("input", function() {
			calculateNetAmount();
		});
		
		$(document).on('change', '#vendor_id', function () {
			$("#vendor_bank_id").html('<select id="vendor_bank_id" name="vendor_bank_id"><option value="">--Select--</option></select>');
			if($(this).val()!=''){
				 $.ajax({
					url: '<?= site_url('internal/getVendorBankDetails'); ?>',
					type: 'POST',
					"data": {
							"vendor_id": $(this).val(),
							"internal_id": '<?php echo $internalNoteDetails[0]["internal_id"]; ?>',
							"selected_id": '<?php if(isset($tdsDetails) && $tdsDetails!=''){ echo $tdsDetails['vendor_bank_id']; } ?>'
						},
					dataType: "html",
					async: false,
					success: function (datas_val) {
						if(datas_val!=''){
							$("#vendor_bank_id").html(datas_val);
						}
					}
				});	
			}
		});
		
        $('input[type="checkbox"]').on('change', function () {
            $('input[type="checkbox"]').not(this).prop('checked', false);
        });

        $('#invoice_date').datepicker({
            dateFormat: "dd-mm-yy",
        });

        $('#proposed_date').datepicker({
            dateFormat: "dd-mm-yy",
        });
		
		$(".details").attr("disabled", true);
		let current_active_tab = $('.select_donor:checked').attr("date-attr-details");
		if(current_active_tab!=''){
			$("."+current_active_tab).attr("disabled", false);
			$("."+current_active_tab).removeAttr("readonly");
		}
		$('.select_donor').on('change', function() {
			$(".details").attr("disabled", true);
			$(".details").attr("readonly", "readonly");
			let currentVal = $(this).attr("date-attr-details");
			
			if(currentVal!=''){
				$("."+currentVal).attr("disabled", false);
				$("."+currentVal).removeAttr("readonly"); 
			}
		});
		
		var count_details = $(".details").length;
		var programme_id_val = $("#programme_id_val").val();
		var additionalinfo_id =$("#additionalinfo_id").val();
		if(count_details > 0){
			for (var i = 0; i<count_details; i++) {
				
				count_id =i+1
				var selectedId = $(".details_"+count_id).attr("data-attr-details-id-"+count_id);
				var donorId = $(".details_"+count_id).attr("data-attr-donor-id-"+count_id);
				var budgetheadId = $(".details_"+count_id).attr("data-attr-budgethead-id-"+count_id);
				var lineitemId = $(".details_"+count_id).attr("data-attr-lineitem-id-"+count_id);
				
				var internal_note_selectedId = $("."+current_active_tab).attr("data-attr-details-id-"+count_id);
				if(internal_note_selectedId && additionalinfo_id!=''){
					var selectedId = additionalinfo_id;
				}
				
				if(donorId!='' && budgetheadId!='' && lineitemId!='' && programme_id_val!=''){
					var form_data1 = {'programme': programme_id_val,'donor': donorId,'budgethead': budgetheadId,'lineitem': lineitemId,'selected_id':selectedId};
					console.log(form_data1);
					var datas = $.ajax({
						url: '<?= site_url('internal/ajax_get_addinfo_details'); ?>',
						type: 'POST',
						data: form_data1,
						dataType: "json",
						async: false,
						success: function (datas_val) {
							if(datas_val.status =='1'){
								var j = 0;
								var output = [];
								output.push('<option value="">--Select--</option>');
								$.each(datas_val.data, function (key, value) { //alert(additionalinfo_id);
									let res = '';
									let selected_data = '';
									if(datas_val.data[j].id){
										if(datas_val.data[j].id ==datas_val.selected_id){
											selected_data = 'selected';
										}
										/* if(datas_val.data[j].id ==additionalinfo_id){
											selected_data = 'selected';
										} */
										res +='<option '+selected_data+' value="' + datas_val.data[j].id + '">' +datas_val.data[j].additionalinfo  + '</option>'
									}
									output.push(res);
									j++;
								});
								$('.details_'+count_id).html(output.join(''));
							}
						}
					});	
				}
				
			}	
		}
		
    });

    function validate_amount() {
        var trequired = "<?= $amt_required ?>";
        var remain = "<?= $remain_amt + $amount_toapprove ?>";
        var amt_toapprove = document.getElementById('amount_toapprove').value;
        var status_apn = "<?= $status ?>";
        var status_int = "<?= $in_status ?>";
        if (status_int != 'confirmed' && $("#remain_amt").val() == '0') {
            alert("You don't have amount in the selected donor. Please select the donor which having amount and try again to update internal note");
            return false;
        } else if ($("#amount_toapprove").val() == '0') {
            alert("Internal note required amount should not be zero");
            return false;
        } else if (status_int != 'confirmed' && status_apn != 'closed') {
            if (parseInt(remain) >= parseInt(amt_toapprove)) {
                return true;
            } else {
                alert('Remaining amount in Approval note is ' + remain);
                return false;
            }
        } else {
            return true;
        }
    }

    $(document).ready(function () {
        approval_amount = parseFloat($('input[name=remain_amt]').val());
        $(document).on('input', 'input[name=amount_toapprove]', function () {
            internal_amount = $(this).val();
            checkValid(internal_amount);
        });
    });

    function checkValid(internal_amount) {
        approval_amount = parseFloat($('input[name=remain_amt]').val());
        internal_amount = (internal_amount);
        if (isNaN(internal_amount)) {
            alert("Please Enter Numbers");
            $('input[name=amount_toapprove]').val('');
        }
        if (approval_amount < internal_amount) {
            alert("The amount exceeds amount approved and it is not possible to enter higher amount");
            $('input[name=amount_toapprove]').val('');
        }
    }
	
    $('#addApproval').validate({
        rules: {
            "programme": "required",
            "donor_list[]": "required",
            "grant_list[]": "required",
            "budget_list[]": "required",
            "line_list[]": "required",
            "amt_required[]": "required",
			"additional_list[]": "required",
            "to_RO": "required",
            "date_of_seeking_approval": "required",
        },
        messages: {
            "programme": "Select Programme",
            "donor_list[]": "Select donor",
            "grant_list[]": "Select grant",
            "budget_list[]": "Select budget",
            "line_list[]": "Select line item",
            "amt_required[]": "Enter amount",
			"additional_list[]": "Select Details",
            "date_of_seeking_approval": "Select Date",
            "to_RO": "Select RO",
        }
    });

    function showMsg(id) {
        $("#draft_" + id).dialog({
            modal: true,
            width: 460,
            maxWidth: 500,
            resizable: false,
            dialogClass: "dialogaddSeasons"
        });
    }

    function donor_change(approval_id, donor_id, internal_id) {
        var bal = current_int_amt(approval_id, donor_id, internal_id);
        var form_data = {
            approval_id: approval_id,
            donor_id: donor_id,
        };
        var datas = $.ajax({
            url: '<?= site_url('internal/donor_balance'); ?>',
            type: 'POST',
            data: form_data,
            async: false,
            success: function (datas) {
                datas = parseFloat(bal) + parseFloat(datas);
                $('input[name=remain_amt]').val(datas);
            }
        });
    }

    function current_int_amt(approval_id, donor_id, internal_id) {
        var remain;
        var form_data = {
            approval_id: approval_id,
            donor_id: donor_id,
            internal_id: internal_id,
        };

        var datas = $.ajax({
            url: '<?= site_url('internal/edit_donor_balance'); ?>',
            type: 'POST',
            data: form_data,
            async: false,
            success: function (datas)
            {
                remain = datas;
            }

        });
        return remain;
    }

    $(document).on("focus", ".seeking_date", function () {
        if ($(this).hasClass('hasDatepicker') === false) {
            $(this).datepicker({dateFormat: 'dd-mm-yy'});
        }
    });

    function removeAddMore() {
        $(".remove_more").remove();
    }

    function getDonorList(id, val) {
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getDonorNameList",
                type: 'POST',
                "data": {'program': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].donor_id + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#donor_' + id).html(output.join(''));
                }
            });
        }
    }

    function getGrantList(id, val) {
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getGrantNameList",
                type: 'POST',
                "data": {'donor': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].id + '">' + split_arr[i].name + '</option>');
                        i++;
                    });
                    $('#grant_' + id).html(output.join(''));
                }
            });
        }
    }

    function getBudgetList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor_' + id).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getBudgetItemList",
                type: 'POST',
                "data": {'program': program, 'donor': donor, 'grant': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].budget_id + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#budget_' + id).html(output.join(''));
                }
            });
        }
    }

    function getLineList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor_' + id).val();
            var grant = $('#grant_' + id).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getLineList",
                type: 'POST',
                "data": {'program': program, 'donor': donor, 'grant': grant, 'budget': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].line_itemid + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#lineitem_' + id).html(output.join(''));
                }
            });
        }
    }

    function getAdditionalList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor_' + id).val();
            var budget = $('#budget_' + id).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getAdditionalList",
                type: 'POST',
                "data": {'program': program, 'donor': donor, 'budget': budget, 'lineitem': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].id + '">' + split_arr[i].additionalinfo + '</option>');
                        i++;
                    });
                    $('#additional_' + id).html(output.join(''));
                }
            });
        }
    }

    function getAvailAmount() {
        var donor = [];
        var grant_list = [];
        var budgethead = [];
        var lineitem = [];
        var amtavailable = [];
        var amtreq = [];
        var progid = $("#programme_id").val();

        $("select[name='donor_list[]']").each(function () {
            donor.push($(this).val());
        });
        $("select[name='grant_list[]']").each(function () {
            grant_list.push($(this).val());
        });
        $("select[name='budget_list[]']").each(function () {
            budgethead.push($(this).val());
        });
        $("select[name='line_list[]']").each(function () {
            lineitem.push($(this).val());
        });
        $("input[name='amt_available[]']").each(function () {
            amtavailable.push($(this).val());
        });
        $("input[name='amt_required[]']").each(function () {
            amtreq.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/approval/check_calucalations',
            data: {donor: donor, budgethead: budgethead, lineitem: lineitem, amtavailable: amtavailable, amtreq: amtreq, progid: progid, grant_list: grant_list},
            dataType: "json",
            type: 'POST',
            success: function (msg) {
                $("input[name='amt_available[]']").each(function (i, elem) {
                    $(this).val(msg[i]["amtavailable"]);
                    $("input[name='amt_required[]']").eq(i).val(msg[i]["amtreq"]);
                });
            }
        });
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $(".add_more").length;
        var i = parseInt(dyn) + 1;
        var program_id = $('#programme_id').val();
        getDonorList(i, program_id);
        var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
        datas += '<td><select class="form-control" name="donor_list[]" id="donor_' + i + '" onchange="getGrantList(' + i + ', this.value);"><option value="">--Select--</option></td>';
        datas += '<td><select class="form-control" name="grant_list[]" id="grant_' + i + '" onchange="getBudgetList(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control" name="budget_list[]" id="budget_' + i + '" onchange="getLineList(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control" name="line_list[]" id="lineitem_' + i + '" onchange="getAdditionalList(' + i + ', this.value);getAvailAmount(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control" name="additional_list[]" id="additional_' + i + '"><option value="">--Select--</option></select></td>';
        datas += '<td><input class="form-control" readonly="" name="amt_available[]" id="amt_available_' + i + '" placeholder="Available Amount"></td>';
        datas += '<td><input class="form-control" name="amt_required[]" id="amt_required_' + i + '" placeholder="Enter Amount"></td></tr>';
        $(datas).insertAfter($('#add_tr_' + dyn));
    });

    function removeRow(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    function removeDocAN(div_id) {
        $('#andocument_tr_' + div_id).closest('tr').remove();
    }

    function removeDocRow(div_id) {
        $('#document_tr_' + div_id).closest('tr').remove();
    }

    $(document).on('click', '#docMore', function () {
        var dyn = $(".document_more").length;
        var i = parseInt(dyn) + 1;
        var data = '<tr id="document_tr_' + i + '" class="document_more remove_more">';
        data += '<td width="30%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_' + i + '" /></div><label class="sow_msg error" id="meet_doc_' + i + '_error"></label>';
        data += '<span>&nbsp;<i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeDocRow(' + i + ');" aria-hidden = "true" ></i></span></td></tr>';
        $(data).insertAfter($('#document_tr_' + dyn));
    });

    $(document).on("click", ".vital_yellow_btn", function () {
        if ($('#addApproval').valid() == true) {
            var result = formValidate();
            if (result == 1) {
                return false;
            } else {
				$('.vital_yellow_btn').css('pointer-events', 'none');
                return true;
            }
        } else {
            return false;
        }
    });

    function formValidate() {
        var err = 0;
        var cmnt_arr = [];
        var hid_docarr = [];
        var cmnt_dyn = document.getElementsByName("meet_doc[]").length;
        for (var r = 0; r < cmnt_dyn; r++) {
            var dyn_id = document.getElementsByName("meet_doc[]")[r].id;
            var hdoc_id = document.getElementsByName("exist_doc[]")[r].id;
            cmnt_arr.push(dyn_id);
            hid_docarr.push(hdoc_id);
        }

        var s = 1;
        for (var q = 0; q < cmnt_arr.length; q++) {
            var cmnt_desc = $('#meet_desc_' + s).val();
            var doc = $('#' + cmnt_arr[q]).val();
            var hid_doc = $('#' + hid_docarr[q]).val();

            if (hid_doc == '') {
                if (doc == '') {
                    $('#' + cmnt_arr[q] + '_error').css('display', 'block');
                    $('#' + cmnt_arr[q] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + cmnt_arr[q] + '_error').css('display', 'none');
                    $('#' + cmnt_arr[q] + '_error').text('');
                }
            } else {
                $('#' + cmnt_arr[q] + '_error').css('display', 'none');
                $('#' + cmnt_arr[q] + '_error').text('');
            }

            s++;
        }
        var g = 1;
        $(".uploadlogo").each(function () {
            var doc_desc = $('#meet_desc_' + g).val();
            var inputid = $(this).attr('id');
            var sprid = inputid.split('_');
            var hid_doc = $('#exist_doc_' + sprid[2]).val();
            if (typeof hid_doc == undefined || hid_doc == '') {
                var filename = readURL(this);
                if (filename) {
                    var result = filename.split('|*|');
                    $(this).parent().children('span').html(result[0]);
                    if (result[1] != '1') {
                        $(this).parent().parent().children('.sow_msg').show();
                        $(this).parent().parent().children('.sow_msg').text(result[1]);
                        err = 1;
                    } else {
                        $(this).parent().parent().children('.sow_msg').text('');
                        $(this).parent().parent().children('.sow_msg').hide();
                    }
                }
                g++;
            }
        });
        return err;
    }

    $(document).on('change', '.uploadlogo', function () {
        var inputid = $(this).attr('id');
        var sprid = inputid.split('_');
        var hid_doc = $('#exist_doc_' + sprid[2]).val();
        var filename = readURL(this);

        var reslt = filename.split('|*|');
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(reslt[1]);
        } else {
            $('#exist_doc_' + sprid[2]).val('');
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        //var bsize = input.files[0].size;
        var bsize = (input.files.length && input.files[0].size) || '';
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
            if (fsize != 0) {
                if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx" || ext == "jpg" || ext == "jpeg" || ext == "gif" || ext == "png" || ext == "xls" || ext == "xlsx" || ext == "csv")) {
                    path = $(input).val();
                    filename = path.replace(/^.*\\/, "");
                    return filename + '|*|1';
                } else {
                    filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                    return filename;
                }
            } else {
                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Upload document';
                return filename;
            }
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
            return filename;
        }
    }

</script>

</body>
</html>