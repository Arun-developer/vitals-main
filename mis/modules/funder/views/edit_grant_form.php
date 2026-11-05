<?php
$this->load->view('vitals_header.php', array('main_menu' => 'funder', 'page_title' => 'Edit - ' . $funder_name . '_' . $grand_lists->name));
$current_page = $this->uri->segment(2);
$tbl_grant_id = $this->uri->segment(3);
$ci = & get_instance();
$currency = $this->session->userdata['currency'];
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'funder', 'page' => 'funder_summary')); ?>
        </div>

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-8 col-lg-7 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/funder/display_grant_list/' . $funder_id; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?php if (isset($funder_name) && $funder_name != '') echo $funder_name; ?> - <?php if (isset($grand_lists->name) && $grand_lists->name != '') echo $grand_lists->name; ?></h4>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li><a href="javascript:" class="master_aduser" data-toggle="modal" data-target="#exampleModal"><span><i class="far fa-file-alt"></i></span> View Status Log</a></li>
                            <?php if ($this->auth == '1') { ?>
                                <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                            <?php } ?>
                            <li><a href="javascript:" id="go_printer" class="master_aduser"><span><i class="fas fa-print"></i></span> Print</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="edit_grant_form" autocomplete="off"  name="edit_grant_form" action="<?php echo base_url() . 'index.php/funder/insertEdit_grant' ?>" method="POST">
                                        <input disabled type="hidden" name="tbl_grant_id" id="tbl_grant_id" class="form-control required grantInput" value="<?php echo $tbl_grant_id; ?>" type="text" placeholder="TLF">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                <h4 class="vitals_innerSub">Grants Details</h4>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Funder Name <span>*</span></label>
                                                    <input  disabled value="<?php echo $funder_name; ?>" title="Enter name" class="form-control required alphanum" type="text" placeholder="Name">
                                                    <input type="hidden" name="donor" value="<?php echo $funder_id; ?>">
                                                    <div id="name_error"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">

                                                <div class="form-group">
                                                    <label>Grant ID <span>*</span></label>
                                                    <input disabled name="name" title="Enter name" id="name" class="form-control required alphanum grantInput" value="<?php if (isset($grand_lists->name) && $grand_lists->name != '') echo $grand_lists->name; ?>" type="text"  placeholder="Enter Id">
                                                    <div id="name_error"></div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="status_commands" id="status_commands" ></input>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant Amount (<?= $currency; ?>) <span>*</span></label>
                                                    <input title="Enter amount" disabled value="<?= $grand_lists->grant_amount; ?>" name="grant_amt" id="grant_amt" class="form-control currencyField required grantInput" type="text" placeholder="Enter amount">
                                                    <!-- <input title="Enter amount" disabled value="<?php if (isset($grand_lists->grant_amount) && $grand_lists->grant_amount != '') echo $ci->numberToCurrency($grand_lists->grant_amount); ?>" name="grant_amt" id="grant_amt" class="form-control currencyField required grantInput" type="text" placeholder="Enter amount"> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant Signed Date  <span>*</span></label>
                                                    <div class="position-relative">
                                                        <input disabled  name="grant_sign_date" title="Select signed Date"  id="grant_sign_date" class="datepicker form-control required grantInput" value="<?php if (isset($grand_lists->signed_date) && $grand_lists->signed_date != '') echo date('d-m-Y', strtotime($grand_lists->signed_date)); ?>" type="text" placeholder="dd-mm-yyyy">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Status  <span>*</span></label>
                                                    <select disabled name="status_type"  title="Select status" id="status_type" class="form-control required grantInput">
                                                        <option value="">--Select--</option>
                                                        <option <?php
                                                        if (isset($grand_lists->status_type) && $grand_lists->status_type != '') {
                                                            if ($grand_lists->status_type == 'open')
                                                                echo "selected";
                                                        }
                                                        ?> value="open">Open</option>
                                                        <option <?php
                                                        if (isset($grand_lists->status_type) && $grand_lists->status_type != '') {
                                                            if ($grand_lists->status_type == 'on Hold')
                                                                echo "selected";
                                                        }
                                                        ?>  value="on Hold">On Hold</option>
                                                        <option <?php
                                                        if (isset($grand_lists->status_type) && $grand_lists->status_type != '') {
                                                            if ($grand_lists->status_type == 'closed')
                                                                echo "selected";
                                                        }
                                                        ?>  value="closed">Closed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant Start Date  <span>*</span></label>
                                                    <div class="position-relative">
                                                        <input disabled name="grant_start_date" title="Select start Date" id="grant_start_date" class="form-control required grantInput grant_start_date" value="<?php if (isset($grand_lists->start_date) && $grand_lists->start_date != '') echo date('d-m-Y', strtotime($grand_lists->start_date)); ?>" type="text" placeholder="dd-mm-yyyy">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant End Date <span>*</span></label>
                                                    <div class="position-relative">
                                                        <input title="Select end date" disabled value="<?php if (isset($grand_lists->end_date) && $grand_lists->end_date != '') echo date('d-m-Y', strtotime($grand_lists->end_date)); ?>" name="grant_end_date" id="grant_end_date"  class="grant_end_date form-control required grantInput" type="text" placeholder="dd-mm-yyyy">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                                <div class="form-group">
                                                    <label>Purpose <span>*</span></label>
                                                    <textarea disabled name="purpose" id="purpose" class="form-control required grantInput" placeholder="Enter comments"><?php if (isset($grand_lists->purpose) && $grand_lists->purpose != '') echo $grand_lists->purpose; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><a id="save_grant_details" class="pointer_cls vital_yellow_btn wdt_100">Save</a></li>
                                                        <li><a href="" class="pointer_cls vital_bordered_btn wdt_100">Cancel</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="edit_grantline_form" autocomplete="off"  name="edit_grantline_form" action="<?php echo base_url() . 'index.php/funder/inserEdit_grant_line' ?>"  method="POST">
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Grant Line Items</h4>
                                                    </div>
                                                    <?php if ($this->auth == '1') { ?>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                            <ul class="milestone-links">
                                                                <li class="brd-left-onboard">
                                                                    <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_grant_line"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                </li>
                                                                <li class="brd-left-onboard">
                                                                    <a href="javascript:void(0)" class="pointer_cls edit-btnconfig  mar-tp15 none-pointer opacity5 mar-tp15 delete_cls" data-chk-attr='gl_checkbox'  data-toggle="modal" data-target="" id="delete_grant_line"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                </li>
                                                                <li class="brd-left-onboard"><a  href="javascript:void(0)" class="pointer_cls saveContinue opacity5 none-pointer" id="save_grantline_form" >Save</a></li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table"  id="grant_line" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow" style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none;";
                                                        }
                                                        ?>"><input <?php
                                                        if ($this->auth == '0') {
                                                            echo"disabled";
                                                        }
                                                        ?> class="form-control common_checkbox" id="gl_checkbox" type="checkbox"></th>
                                                        <th width="20%">Budget Head</th>
                                                        <th width="20%">Line Item</th>
                                                        <th width="20%">Amount (<?= $currency; ?>)</th>
                                                        <th width="25%">Comments</th>
                                                        <th width="5%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input type="hidden" name="tbl_grant_id" id="tbl_grant_id" class="form-control required grantInput" value="<?php echo $tbl_grant_id; ?>" type="text" placeholder="TLF">
                                                    <input type="hidden" class="hid_programme_id" name="hid_programme_id"  class="form-control required grantInput" value="<?php echo $grand_lists->programme_id; ?>" type="text" placeholder="TLF">
                                                    <input type="hidden" class="hid_funder_id" name="hid_funder_id"  class="form-control required grantInput" value="<?php echo $grand_lists->funder_id; ?>" type="text" placeholder="TLF">

                                                    <?php
                                                    $sum = 0;
                                                    $check_gl_total = 0;
                                                    if (!empty($grantline_list)) {
                                                        $check_gl_total = 1;
                                                        $i = 0;
                                                        foreach ($grantline_list as $lists) {
                                                            ?>
                                                            <tr class="metric_more" id="grantline_tbl_<?php echo $lists->id; ?>">
                                                                <input disabled type="hidden" name="garntline_id[]" value="<?php echo $lists->id; ?>" >
                                                                <td class="valign-center" style="<?php
                                                                if ($this->auth == '0') {
                                                                    echo"display:none;";
                                                                }
                                                                ?>" ><input <?php
                                                                if ($this->auth == '0') {
                                                                    echo"disabled";
                                                                }
                                                                ?> class="form-control gl_checkbox" value="<?php echo $lists->id; ?>" type="checkbox"></td>
                                                                <td><input disabled type="text" placeholder="Enter budget head" disabled name="budget[][<?php echo $lists->id; ?>]" value="<?php if (isset($lists->budget_head_id) && $lists->budget_head_id != '') echo $lists->budget_head_id; ?>"  id="budget_<?php echo $lists->id; ?>" data-selected-lt='<?php echo $lists->lineitem_id; ?>' data-attr="lineitem_<?php echo $lists->id; ?>" class="budget_opt form-control"></input></td>
                                                                <td><input disabled type="text"  placeholder="Enter line item" disabled name="line_item[][<?php echo $lists->id; ?>]" value="<?php if (isset($lists->lineitem_id) && $lists->lineitem_id != '') echo $lists->lineitem_id; ?>"   id="lineitem_<?php echo $lists->id; ?>" data-attr="subline_<?php echo $lists->id; ?>" class="lineitem form-control"></input></td>
                                                                <td><input disabled name="grant_amount[][<?php echo $lists->id; ?>]" class="form-control currencyField mobile_number gl_amt"  value="<?php if (isset($lists->amount) && $lists->amount != '') echo $ci->numberToCurrency($lists->amount); ?>" type="text" placeholder="Enter amount"></td>
                                                                <td><input disabled name="grant_comments[][<?php echo $lists->id; ?>]" class="form-control" value="<?php if (isset($lists->comments) && $lists->comments != '') echo $lists->comments; ?>" type="text" placeholder="Enter comments"></td>
                                                                <td>
                                                                    <!-- <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(316);" href="javascript:void(0)"><i class="fas fa-trash"></i></a> -->
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                            $sum+= $lists->amount;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr class="metric_more no_data" id="grantline_tbl_0">
                                                            <td colspan="6" style="text-align: center;">No data available in table</td>
                                                        </tr>

                                                    <?php } ?>
                                                    <tr style="display:none;" class="metric_more gl_total" id="grantline_tbl_0">
                                                        <td style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none";
                                                        }
                                                        ?>" class="valign-center"></td>
                                                        <td><b>Total</b></td>
                                                        <td></td>
                                                        <td><input disabled  id="gl_amount" class="form-control"  value="<?php
                                                        $gl_total_amt_res = explode(".", $sum);
                                                        $final_res = $ci->numberToCurrency($gl_total_amt_res[0], '');
                                                        $final_res = $final_res . '.' . $gl_total_amt_res[1];
                                                        if ($gl_total_amt_res[1] == 0) {
                                                            $final_res = $ci->numberToCurrency($gl_total_amt_res[0], '');
                                                        }
                                                        echo $final_res;
                                                        ?>" ></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <input type="hidden" id="hid_table_type">
                                    <form id="edit_disbursement_form" autocomplete="off"  name="edit_disbursement_form" action="<?php echo base_url() . 'index.php/funder/inserEdit_disbursement' ?>"  method="POST">
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Disbursement Schedule</h4>
                                                    </div>
                                                    <?php if ($this->auth == '1') { ?>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                            <ul class="milestone-links">
                                                                <li class="brd-left-onboard">
                                                                    <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_disbursement"> <i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                </li>
                                                                <li class="brd-left-onboard">
                                                                    <a href="javascript:void(0)" class="pointer_cls edit-btnconfig  mar-tp15 none-pointer opacity5 delete_cls" data-chk-attr='disb_checkbox'  data-toggle="modal" data-target="" id="delete_disbursement"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                </li>
                                                                <li class="brd-left-onboard"><a   href="javascript:void(0)" class="pointer_cls saveContinue opacity5 none-pointer" id="save_disbursement" >Save</a></li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma table-responsive" id="quatermetric_forma">
                                            <table class="table" style="margin-top: 0" id="disbursement_tbl">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none;";
                                                        }
                                                        ?>" class="removeArrow"><input <?php
                                                        if ($this->auth == '0') {
                                                            echo"disabled";
                                                        }
                                                        ?> class="form-control common_checkbox" data-attr='disbursement_tbl' id="disb_checkbox" type="checkbox"></th>
                                                        <th width="18%">Milestone</th>
                                                        <th width="18%">Date of<br>Disbursement</th>
                                                        <th width="18%">Amount (<?= $currency; ?>)</th>
                                                        <th width="22%">Date of Deposit</th>
                                                        <th width="27%">Amount Deposited (<?= $currency; ?>)</th>
                                                        <th width="23%">Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input type="hidden" name="tbl_grant_id" id="tbl_grant_id" class="form-control  grantInput" value="<?php echo $tbl_grant_id; ?>" type="text" placeholder="TLF">
                                                    <input type="hidden" class="hid_programme_id" name="hid_programme_id"  class="form-control  grantInput" value="<?php echo $grand_lists->programme_id; ?>" type="text" placeholder="TLF">
                                                    <input type="hidden" class="hid_funder_id" name="hid_funder_id"  class="form-control  grantInput" value="<?php echo $grand_lists->funder_id; ?>" type="text" placeholder="TLF">

                                                    <?php
                                                    $check_disb_total_amt = 0;
                                                    $sum_ammount = 0;
                                                    $sum_am_deposite = 0;
                                                    if (!empty($disbursement_list)) {
                                                        $check_disb_total_amt = 1;
                                                        $i = 0;

                                                        foreach ($disbursement_list as $lists) {
                                                            ?>
                                                            <tr class="metric_more" id="disbursement_tbl_<?php echo $lists->id; ?>">
                                                                <input disabled type="hidden" name="disbursement_id[]" value="<?php echo $lists->id; ?>" >
                                                                <td style="<?php
                                                                if ($this->auth == '0') {
                                                                    echo"display:none;";
                                                                }
                                                                ?>" class="valign-center"><input <?php
                                                                if ($this->auth == '0') {
                                                                    echo"disabled";
                                                                }
                                                                ?> class="form-control disb_checkbox" value="<?php echo $lists->id; ?>" type="checkbox"></td>
                                                                <td class="valign-center"><textarea disabled  placeholder="Milestone" name="disbursement_mile[][<?php echo $lists->id; ?>]" class="form-control"><?php if (isset($lists->milestone) && $lists->milestone != '') echo $lists->milestone; ?></textarea></td>
                                                                <td><div class="position-relative"><input disabled class="datepicker form-control" name="date_disbursement[][<?php echo $lists->id; ?>]"  value="<?php if (isset($lists->date_of_disbursement) && $lists->date_of_disbursement != '' && $lists->date_of_disbursement != 0) echo date('d-m-Y', strtotime($lists->date_of_disbursement)); ?>" type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                                <td><input disabled class="form-control currencyField mobile_number disb_amt" name="disbursement_amount[][<?php echo $lists->id; ?>]"  value="<?php if (isset($lists->amount) && $lists->amount != '') echo $ci->numberToCurrency($lists->amount); ?>" type="text" placeholder="Enter amount"></td>
                                                                <td><div class="position-relative"><input disabled class="datepicker form-control" name="date_deposite[][<?php echo $lists->id; ?>]"  value="<?php if (isset($lists->date_of_deposite) && $lists->date_of_deposite != '' && $lists->date_of_deposite != 0) echo date('d-m-Y', strtotime($lists->date_of_deposite)); ?>" type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                                <td><input disabled class="form-control currencyField mobile_number amt_dep" name="amount_deposite[][<?php echo $lists->id; ?>]"  value="<?php if (isset($lists->amount_deposite) && $lists->amount_deposite != '') echo $ci->numberToCurrency($lists->amount_deposite); ?>" type="text" placeholder="Enter amount"></td>
                                                                <td><input disabled class="form-control wdt_120" name="disbursement_cmd[][<?php echo $lists->id; ?>]" value="<?php if (isset($lists->comments) && $lists->comments != '') echo $lists->comments; ?>" type="text" placeholder="Enter comments"></td>

                                                                <?php
                                                                $i++;
                                                                $sum_ammount += $lists->amount;
                                                                $sum_am_deposite += $lists->amount_deposite;
                                                            }
                                                        }else {
                                                            ?>
                                                            <tr class="metric_more no_data_disb">
                                                                <td colspan="7" style="text-align: center;">No data available in table</td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr style="display:none" class="metric_more disb_total" id="grantline_tbl_0">
                                                        <td style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none";
                                                        }
                                                        ?>" class="valign-center"></td>
                                                        <td><b>Total</b></td>
                                                        <td></td>
                                                        <td><input id="disb_amount" disabled  class="form-control"  value="<?php
                                                        $da_total_amt_res = explode(".", $sum_ammount);
                                                        $da_final_res = $ci->numberToCurrency($da_total_amt_res[0], '');
                                                        $da_final_res = $da_final_res . '.' . $da_total_amt_res[1];
                                                        if ($da_total_amt_res[1] == 0) {
                                                            $da_final_res = $ci->numberToCurrency($da_total_amt_res[0], '');
                                                            } echo $da_final_res;
                                                            ?>" ></td>
                                                            <td></td>
                                                            <td><input id="disb_total_amount"  disabled  class="form-control"  value="<?php
                                                            $dar_total_amt_res = explode(".", $sum_am_deposite);
                                                            $dar_final_res = $ci->numberToCurrency($dar_total_amt_res[0], '');
                                                            $dar_final_res = $dar_final_res . '.' . $dar_total_amt_res[1];
                                                            if ($dar_total_amt_res[1] == 0) {
                                                                $dar_final_res = $ci->numberToCurrency($dar_total_amt_res[0], '');
                                                                } echo $dar_final_res;
                                                                ?>" ></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>

                                            <form id="edit_grantreport_form" autocomplete="off"  name="edit_grantreport_form" action="<?php echo base_url() . 'index.php/funder/edit_grantreport_form' ?>" enctype="multipart/form-data" method="POST">
                                                <div style="height:30px"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>Grant Reports</h4>
                                                            </div>
                                                            <?php if ($this->auth == '1') { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                    <ul class="milestone-links">
                                                                        <li class="brd-left-onboard">
                                                                            <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_grant_report"> <i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                        </li>
                                                                        <li class="brd-left-onboard">
                                                                            <a    class="pointer_cls edit-btnconfig  mar-tp15 opacity5 none-pointer delete_cls" data-chk-attr='gr_checkbox'  data-toggle="modal" data-target="" id="delete_grant_report"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                        </li>
                                                                        <li class="brd-left-onboard"><a  href="javascript:void(0)" class="pointer_cls saveContinue opacity5 none-pointer"" id="save_grant_report" >Save</a></li>
                                                                    </ul>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table" style="margin-top: 0" id="grant_report">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                $width = '18%';
                                                                if (php72_count($lists) > 0) {
                                                                    $width = '18%';
                                                                }
                                                                ?>
                                                                <th width="5%" style="<?php
                                                                if ($this->auth == '0') {
                                                                    echo"display:none;";
                                                                }
                                                                ?>" class="removeArrow"><input <?php
                                                                if ($this->auth == '0') {
                                                                    echo"disabled";
                                                                }
                                                                ?> class="form-control common_checkbox" id="gr_checkbox" type="checkbox"></th>
                                                                <th width="<?php echo $width; ?>">Due Date</th>
                                                                <th width="18%">Submitted date</th>
                                                                <th width="16%">Responsibility</th>
                                                                <th width="17%">Comments</th>
                                                                <th width="20%">Report <small>(Max 10MB size of  xls,ppt,doc files)</small></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <input type="hidden" name="delete_doc_id" id="delete_doc_id" value="">
                                                            <input type="hidden" name="tbl_grant_id" id="tbl_grant_id" class="form-control grantInput" value="<?php echo $tbl_grant_id; ?>" type="text" >
                                                            <input type="hidden" class="hid_programme_id" name="hid_programme_id"  class="form-control grantInput" value="<?php echo $grand_lists->programme_id; ?>" type="text" >
                                                            <input type="hidden" class="hid_funder_id" name="hid_funder_id"  class="form-control grantInput" value="<?php echo $grand_lists->funder_id; ?>" type="text" >
                                                            <?php
                                                            if (!empty($grant_report_list)) {
                                                                $i = 0;
                                                                foreach ($grant_report_list as $lists) {
                                                                    ?>
                                                                    <tr class="metric_more" id="grantreport_tbl_<?php echo $lists->id; ?>">
                                                                        <input disabled type="hidden" name="grantreport_id[]" value="<?php echo $lists->id; ?>" >
                                                                        <td class="valign-center" style="<?php
                                                                        if ($this->auth == '0') {
                                                                            echo"display:none;";
                                                                        }
                                                                        ?>" ><input <?php
                                                                        if ($this->auth == '0') {
                                                                            echo"disabled";
                                                                        }
                                                                        ?> class="form-control gr_checkbox" type="checkbox" value="<?php echo $lists->id; ?>"></td>
                                                                        <td><div class="position-relative"><input disabled class="datepicker form-control" name="grantreport_dop[][<?php echo $lists->id; ?>]" value="<?php if (isset($lists->date_of_report) && $lists->date_of_report != '' && $lists->date_of_report != 0) echo date('d-m-Y', strtotime($lists->date_of_report)); ?>" type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                                        <td><div class="position-relative"><input disabled class="datepicker form-control" name="submit_date[][<?php echo $lists->id; ?>]" value="<?php if (isset($lists->submit_date) && $lists->submit_date != '' && $lists->submit_date != 0) echo date('d-m-Y', strtotime($lists->submit_date)); ?>" type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                                        <td>
                                                                            <select disabled name="grantreport_resp[][<?php echo $i; ?>]"  id="grantreport_resp_<?php echo $i; ?>" class="form-control">
                                                                                <option value="">--Select--</option>
                                                                                <?php
                                                                                if (!empty($responsibility)) {
                                                                                    foreach ($responsibility as $list) {
                                                                                        ?>
                                                                                        <option <?php
                                                                                        if (isset($lists->responsibility) && $lists->responsibility != '') {
                                                                                            if ($list->id == $lists->responsibility)
                                                                                                echo"selected";
                                                                                        }
                                                                                        ?> value="<?php echo $list->id; ?>"><?php echo $list->emp_first_name . ' ' . $list->emp_last_name; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><input disabled class="form-control" name="grantreport_cmd[][<?php echo $lists->id; ?>]" value="<?php if (isset($lists->comments) && $lists->comments != '') echo $lists->comments; ?>" type="text" placeholder="Enter comments"></td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="button"  id="file_btn_<?php echo $i; ?>" disabled class="fileUpload form-control masterPicUpdatebtn employeeInput" data_attr_id='file_upload_<?php echo $i; ?>'  value="<?php
                                                                                if (isset($lists->file_name) && $lists->file_name != '') {
                                                                                    echo substr($lists->file_name, -35);
                                                                                    } else {
                                                                                        echo "Upload Report";
                                                                                    }
                                                                                    ?>">
                                                                                    <input disabled data-btn-id="file_btn_<?php echo $i; ?>" type="file" data-err="file_err_<?php echo $i; ?>"  name="file_upload[][<?php echo $lists->id; ?>]"  id="file_upload_<?php echo $i; ?>" style="display: none;"><div id="file_err_<?php echo $i; ?>"></div>
                                                                                    <?php if ($lists->file_name != '') { ?>
                                                                                        <span class="download-btn"><a href="<?php echo base_url() . '/uploads/file_documents/' . $lists->file_name; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="" onclick="showDeletePop(<?php echo $lists->id; ?>)" title="Delete Document" class="<?php
                                                                                        if ($this->auth == '0') {
                                                                                            echo"none-pointer";
                                                                                        }
                                                                                        ?> removeDoc initial_doc_delete delete-btnconfig" data-dyn="initial_agreement"><i class="fas fa-trash"></i></a>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </td>

                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr class="metric_more no_data_report">
                                                                        <td colspan="7" style="text-align: center;">No data available in table</td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </form>
                                                <div  style="display:none;"  id="load_print"></div>
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

    <div class="modal" id="statusModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content delete-alert">
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-10">
                                <h4>Enter Comments  <span style="font-size: 12px;color: #dc3545!important;">*</span></h4>
                                <textarea id="status_cmd" title="Enter comments"  name="grant_amt" class="form-control required" type="text" placeholder="Enter comments"></textarea>
                                <label id="status_cmd_err" class="error"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                    <button type="button" id="close_popup" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                    <button type="button" class="btn btn-success" id="submit_cmd">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal_cls">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Log Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl view_log">
                            <table id="view_log_tbl" class="table table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Date</th>
                                        <th>From Status</th>
                                        <th>To Status</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        .modal_cls {
            margin: auto;
            width: 70%;
        }
        table thead th{
            vertical-align: top !important;
        }
    </style>

    <?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            var grant_inr = inrFormat($('#grant_amt').val());
            $('#grant_amt').val(grant_inr);
        });

        $(document).on('click', '#close_popup', function () {
            $("#save_grant_details").removeClass("none-pointer");
            $(".pointer_cls").removeClass("none-pointer");
            $("#statusModal").modal('hide');
        });

        $(document).on('keyup keydown', '#status_cmd', function () {
            $("#statusModal").modal('show');
            var status_val = $("#status_cmd").val();
            if (status_val != '') {
                $("#status_cmd_err").text('');
            } else {
                $("#status_cmd_err").text('Enter comments');
            }
        });

        $("#go_printer").click(function () {
            var var_grant_id = '<?php echo $tbl_grant_id; ?>';
            var var_funder_id = '<?php echo $funder_id; ?>';
            $.ajax({
                url: '<?php echo base_url() . 'index.php/funder/print_grant_pdf' ?>',
                cache: false,
                type: "POST",
                data: {grant_id: var_grant_id, funder_id: var_funder_id},
                dataType: "html",
                success: function (response) {
                    $('#load_print').html('');
                    $('#load_print').html(response);
                    var prtContent = document.getElementById('load_print');
                    var WinPrint = window.open('', '', 'left=0,top=0,width=20,height=20,toolbar=0,scrollbars=0,status=0');
                    WinPrint.document.write(prtContent.innerHTML);
                    WinPrint.document.close();
                    WinPrint.focus();
                    WinPrint.print();
                    WinPrint.close();
                }
            });
        });

        function download_print(grant_id) {
            var funder_id = '<?php echo $funder_id; ?>';
            if (grant_id != '') {
                var url = "<?php echo base_url() . 'index.php/funder/download_grant_pdf/' ?>";
                window.location.href = url + grant_id + '/' + funder_id;
            }
        }

        function showDeletePop(ids) {
            $("#delCount").text('');
            $('#deleteModal').modal('toggle');
            $("#delete_doc_id").val(ids);
        }

        function call_ajax_doc_delete(id) {
            $.ajax({
                url: '<?php echo base_url() . 'index.php/funder/ajax_delete_grant_document' ?>',
                cache: false,
                type: "POST",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    window.location.reload();
                }
            });
        }

        $(document).ready(function () {
            $('#view_log_tbl').DataTable({
                "bProcessing": true,
                "bSortable": true,
                "destroy": true,
                "bDestroy": true,
                "paging": true,
                "ordering": true,
                "info": false,
                "searching": false,
                "lengthChange": false,
                "bServerSide": true,
                "stateSave": false,
                "autoWidth": false,
                "pageLength": 10,
                "ajax": {
                    "url": "<?php echo base_url(); ?>index.php/funder/ajax_log_datatable",
                    "data": {'funder_id': '<?php echo $funder_id; ?>', 'grant_id': '<?php echo $tbl_grant_id; ?>'},
                    "type": "POST"
                }, drawCallback: function (settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);
                }
            });
            $(".inputplan-structureall").find('.master_aduser').on('click', function () {
                $.print(".inputplan-structureall");
            });
            if ($('input:checkbox.new_gl_checkbox').length > 0) {
                $("#save_grantline_form").removeClass("opacity5 none-pointer");
                $(".new_gl_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
            }

            if ($('input:checkbox.new_disb_checkbox').length > 0) {
                $("#save_disbursement").removeClass("opacity5 none-pointer");
                $(".new_disb_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
            }
            if ($('input:checkbox.new_gr_checkbox').length > 0) {
                $("#save_grant_report").removeClass("opacity5 none-pointer");
                $(".new_gr_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
            }

            $(".portfolioclose").click(function () {
                $("#delete_doc_id").val('');
            });

            error_count = 0;
            $(document).on('change', 'input[type="file"]', function () {
                var error_id = $(this).attr('data-err');
                var file_btn_id = $(this).attr('data-btn-id');
                var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                var last_char = filename.slice(-40);
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var imgSize = $(this)[0].files[0].size;
                $('#' + error_id).html("");
                if (imgSize <= 10485760) {
                    var file_typeArr = ["pdf", "xls", "ppt", "xlsx", "doc", "docx", "pptx"];
                    if (file_typeArr.indexOf(extn) <= -1) {
                        error_count = 1;
                        $('#' + error_id).html("<label class='tbl_err'>Invalid File</label>");
                    } else {
                        $('#' + file_btn_id).val(last_char);
                        error_count = 0;
                    }
                } else {
                    error_count = 1;
                    $('#' + error_id).html("<label class='tbl_err'>File exceeds 10 MB</label>");
                }
            });

            $(document).on('click', '.delete_cls', function () {
                var cur_attr = $(this).attr("data-chk-attr");
                $('#delCount').val('');
                var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
                $('#delCount').html(sel_item);
            });

            $(document).on('click', '.masterPicUpdatebtn', function () {
                $current = $(this).attr('data_attr_id');
                $("input[id=" + $current + "]").click();
            });

            $('.summaryEdit').click(function () {
                $(".grantInput").attr("disabled", false);
                $('li.edit').addClass("activeTabs");
                $('li.edit a').addClass("greentab");
                $('.saveLinkView').removeClass("display-hide");
                $('.saveLinkView').addClass("display-show");
            })

            var funder_id = '<?php echo $funder_id; ?>';
            ajax_call_fun(funder_id);
            $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });

            var endDate = '<?php echo date("d-m-Y", strtotime($grand_lists->start_date)); ?>';
            $('.grant_end_date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
                minDate: endDate
            });

            $('.grant_start_date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
            //minDate: new Date(),
            onSelect: function (dateText) {
                $(".grant_end_date").datepicker("destroy");
                $('.grant_end_date').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd-mm-yy",
                    minDate: dateText,
                });
            }
        });

            $('#gl_checkbox').click(function (e) {
                var table = $(e.target).closest('table');
                $('td input:checkbox', table).prop('checked', this.checked);
            });

            $('#disb_checkbox').click(function (e) {
                var table = $(e.target).closest('table');
                $('td input:checkbox', table).prop('checked', this.checked);
            });

            $('#gr_checkbox').click(function (e) {
                var table = $(e.target).closest('table');
                $('td input:checkbox', table).prop('checked', this.checked);
            });
        });

$(function () {
    $("#edit_grant_form").valid();
});
submit_type = 0;
$('#save_grant_details').click(function () {
    if ($("#edit_grant_form").valid() == true) {
        $("#name_error").html('');
        var funder_id = '<?php echo $funder_id; ?>';
        var grant_name = $("#name").val();
        var grant_id = '<?php echo $tbl_grant_id; ?>';
        $.ajax({
            url: '<?php echo base_url() . 'index.php/funder/ajax_Grantname_duplicate' ?>',
            cache: false,
            type: "POST",
            data: {funder_id: funder_id, grant_name: grant_name, grant_id: grant_id},
            dataType: "json",
            success: function (response) {
                if (response.status == 1) {
                    $("#save_grant_details").removeClass("none-pointer");
                    $(".pointer_cls").removeClass("none-pointer");
                    $("#name_error").html('<label class="error tbl_err">Name already exists</label>');
                    return false;
                } else if (response.status == 0) {
                    $("#save_grant_details").addClass("none-pointer");
                    $(".pointer_cls").addClass("none-pointer");
                    submit_type = 1;
                    var status = '<?php echo $grand_lists->status_type; ?>';
                    var current_val = $("#status_type").val();
                    if (current_val != '') {
                        if (status != current_val) {
                            $("#status_cmd").val('');
                            $("#statusModal").modal('show');
                        } else {
                            $("#edit_grant_form").submit();
                        }
                    }
                        //$("#edit_grant_form").submit();
                    }
                }
            });
    }
});

$('#submit_cmd').click(function () {
    if (submit_type == 1) {
        status_type = $("#status_type").val();
        if (status != status_type) {
            $("#status_commands").val('');
            var status_val = $("#status_cmd").val();
            if (status_val == '') {
                $("#status_cmd_err").text('Enter comments');
                return false;
            } else {
                $("#status_commands").val(status_val);
                $("#statusModal").modal('hide');
                $("#edit_grant_form").submit();
            }
        }
    }
});

$('#save_disbursement').click(function () {
    var disabled_count = $('#disbursement_tbl').find('input[type="text"]').not(":disabled").length;
    if (disabled_count > 0) {
        if ($("#edit_disbursement_form").valid() == true) {
            $("#add_disbursement").addClass("none-pointer");
            $("#save_disbursement").addClass("none-pointer");
            $("#edit_disbursement_form").submit();
        }
    }
});

$('#save_grant_report').click(function () {
    $("#edit_grantreport_form").validate();
    var disabled_count = $('#grant_report').find('input[type="text"]').not(":disabled").length;
    if (disabled_count > 0 && error_count == 0) {
        if ($("#edit_grantreport_form").valid() == true) {
            $("#add_grant_report").addClass("none-pointer");
            $("#save_grant_report").addClass("none-pointer");
            $("#edit_grantreport_form").submit();
        }
    }
});

$('#save_grantline_form').click(function () {
    $("#edit_grantline_form").validate();
    var disabled_count = $('#grant_line').find('input[type="text"]').not(":disabled").length;
    if (disabled_count > 0) {
        if ($("#edit_grantline_form").valid() == true) {
            $("#edit_grantline_form").submit();
        }
    }
});

$(document).ready(function () {
    $('.vital_windowScroll').css({
        'height': (($(window).height()) - 190) + 'px'
    });
});

$(document).ready(function () {
    $("#add_grant_line").click(function () {
        $('#gl_checkbox').prop('checked', false);
        $(".no_data").css('display', 'none');
        var grant_line_tbl_len = $('#grant_line tr').length + 1;
        var markup = "<tr class='metric_more' id=grant_line_tbl_" + grant_line_tbl_len + "><input type='hidden' name='garntline_id[]' value=''><td class='valign-center'><input class='form-control gl_checkbox new_gl_checkbox' type='checkbox'></td><td><input type='text' class='budget_opt form-control'name=budget[][" + grant_line_tbl_len + "] id=budget_" + grant_line_tbl_len + " data-attr=lineitem_" + grant_line_tbl_len + " class='form-control' placeholder='Enter budget head' ></td><td><input class='form-control'name=line_item[][" + grant_line_tbl_len + "] id=lineitem_" + grant_line_tbl_len + " data-attr=subline_" + grant_line_tbl_len + " class='form-control' placeholder='Enter line item' ></td><td><input  name='grant_amount[][" + grant_line_tbl_len + "]' class='form-control currencyField mobile_number gl_amt'  type='text' placeholder='Enter amount'><div id=grantamt_err_" + grant_line_tbl_len + "></div></td><td><input  name='grant_comments[][" + grant_line_tbl_len + "]' class='form-control'  type='text' placeholder='Enter comments'><div id=grantcmd_err_" + grant_line_tbl_len + "></div></td>"
        $("#grant_line tbody").prepend(markup);
        $(".gl_total").css("display", "contents");
        var donor_value = '<?php echo $funder_id; ?>';
        $("#save_grantline_form").removeClass("opacity5 none-pointer");
        if (donor_value != '') {
            dom_type = "budget_" + grant_line_tbl_len;
            get_budget_ajax_data(donor_value, dom_type);
        }
    });

    $(document).on('change', '.gl_checkbox,#gl_checkbox', function () {
        if ($('input:checkbox.gl_checkbox').length > 0) {
            if ($('input:checkbox.gl_checkbox').length != $('input:checkbox.gl_checkbox:checked').length) {
                $('#gl_checkbox').prop('checked', false);
            } else if ($('input:checkbox.gl_checkbox').length == $('input:checkbox.gl_checkbox:checked').length) {
                $('#gl_checkbox').prop('checked', true);
            }
        }

        if ($('input:checkbox.gl_checkbox:checked').length > 0) {
            $("#save_grantline_form").removeClass("opacity5 none-pointer");
            $("#delete_grant_line").removeClass("opacity5 none-pointer");
        } else {
            $("#save_grantline_form").addClass("opacity5 none-pointer");
            $("#delete_grant_line").addClass("opacity5 none-pointer");
        }
        if ($('input:checkbox.new_gl_checkbox').length > 0) {
            $("#save_grantline_form").removeClass("opacity5 none-pointer");
            $(".new_gl_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }
    });

    $(document).on('change', '.new_gl_checkbox', function () {
        $("#save_grantline_form").removeClass("opacity5 none-pointer");
    });

    $(document).on('change', '.new_disb_checkbox', function () {
        $("#save_disbursement").removeClass("opacity5 none-pointer");
    });
    $(document).on('change', '.new_gr_checkbox', function () {
        $("#save_grant_report").removeClass("opacity5 none-pointer");
    });

    $(document).on('change', '.disb_checkbox,#disb_checkbox', function () {
        if ($('input:checkbox.disb_checkbox').length > 0) {
            if ($('input:checkbox.disb_checkbox').length != $('input:checkbox.disb_checkbox:checked').length) {
                $('#disb_checkbox').prop('checked', false);
            } else if ($('input:checkbox.disb_checkbox').length == $('input:checkbox.disb_checkbox:checked').length) {
                $('#disb_checkbox').prop('checked', true);
            }
        }
        if ($('input:checkbox.disb_checkbox:checked').length > 0) {
            $("#save_disbursement").removeClass("opacity5 none-pointer");
            $("#delete_disbursement").removeClass("opacity5 none-pointer");
        } else {
            $("#save_disbursement").addClass("opacity5 none-pointer");
            $("#delete_disbursement").addClass("opacity5 none-pointer");
        }
        if ($('input:checkbox.new_disb_checkbox').length > 0) {
            $("#save_disbursement").removeClass("opacity5 none-pointer");
            $(".new_disb_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }
    });

    $(document).on('change', '.gr_checkbox,#gr_checkbox', function () {
        if ($('input:checkbox.gr_checkbox').length > 0) {
            if ($('input:checkbox.gr_checkbox').length != $('input:checkbox.gr_checkbox:checked').length) {
                $('#gr_checkbox').prop('checked', false);
            } else if ($('input:checkbox.gr_checkbox').length == $('input:checkbox.gr_checkbox:checked').length) {
                $('#gr_checkbox').prop('checked', true);
            }
        }
        if ($('input:checkbox.gr_checkbox:checked').length > 0) {
            $("#save_grant_report").removeClass("opacity5 none-pointer");
            $("#delete_grant_report").removeClass("opacity5 none-pointer");
        } else {
            $("#save_grant_report").addClass("opacity5 none-pointer");
            $("#delete_grant_report").addClass("opacity5 none-pointer");
        }
        if ($('input:checkbox.new_gr_checkbox').length > 0) {
            $("#save_grant_report").removeClass("opacity5 none-pointer");
            $(".new_gr_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }
    });

    $("#delete_grant_line").click(function () {
        $('#deleteModal').modal('show');
        $("#hid_table_type").val('hid_gl_table');
    });

    $("#delete_disbursement").click(function () {
        $('#deleteModal').modal('show');
        $("#hid_table_type").val('hid_disb_table');
    });

    $("#delete_grant_report").click(function () {
        $('#deleteModal').modal('show');
        $("#hid_table_type").val('hid_gr_table');
    });

    $(".disb_checkbox, .gr_checkbox, .gl_checkbox").click(function () {
        if (!$(this).is(":checked")) {
            $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", true);
        } else {
            $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }
    });

    $('.common_checkbox').click(function (e) {
        var table = $(e.target).closest('table');
        var cur_tbl_id = $(e.target).closest('table').attr('id');
        $('td input:checkbox', table).prop('checked', this.checked);
        if (!this.checked) {
            $("#" + cur_tbl_id + " tbody").find('input[type="checkbox"]').each(function () {
                if (!$(this).is(":checked")) {
                    $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", true);
                }
            });
        } else {
            $("#" + cur_tbl_id + " tbody").find('input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
                }
            });
        }
    });

    $("#editSubmit").click(function () {
        $('#delCount').val('');
        var delete_doc_val = $('#delete_doc_id').val();
        if (delete_doc_val != '' && delete_doc_val != undefined) {
            call_ajax_doc_delete(delete_doc_val);
            return false;
        } else {
            $('#delCount').val('');
        }
        var cur_val = $("#hid_table_type").val();
        common_ids = [];
        if (cur_val == 'hid_gl_table') {
            $("#grant_line tbody").find('input[type="checkbox"]').each(function (index) {
                if ($(this).is(":checked")) {
                    if (this.value != '' && this.value != undefined) {
                        common_ids[index] = this.value;
                    }
                    $(this).parents("tr").remove();
                }
            });
            if (common_ids.length > 0) {
                ajax_common_delete(common_ids, 'grantline_table');
            }
            $('#deleteModal').modal('toggle');
            if ($('input:checkbox.gl_checkbox:checked').length > 0) {
                $("#delete_grant_line").removeClass("opacity5 none-pointer");
                $("#save_grantline_form").removeClass("opacity5 none-pointer");
            } else {
                if ($('input.disb_checkbox:checkbox').length > 0) {
                    $("#delete_grant_line").addClass("opacity5 none-pointer");
                    $("#save_grantline_form").addClass("opacity5 none-pointer");
                }
            }
        } else if (cur_val == 'hid_disb_table') {
            $("#disbursement_tbl tbody").find('input[type="checkbox"]').each(function (index) {
                if ($(this).is(":checked")) {
                    if (this.value != '' && this.value != undefined) {
                        common_ids[index] = this.value;
                    }
                    $(this).parents("tr").remove();
                }
            });
            if (common_ids.length > 0) {
                ajax_common_delete(common_ids, 'disbursement_table');
            }
            $('#deleteModal').modal('toggle');
            if ($('input:checkbox.disb_checkbox:checked').length > 0) {
                $("#delete_disbursement").removeClass("opacity5 none-pointer");
                $("#save_disbursement").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_disbursement").addClass("opacity5 none-pointer");
                $("#save_disbursement").addClass("opacity5 none-pointer");
            }
        } else if (cur_val == 'hid_gr_table') {
            $("#grant_report tbody").find('input[type="checkbox"]').each(function (index) {
                if ($(this).is(":checked")) {
                    if (this.value != '' && this.value != undefined) {
                        common_ids[index] = this.value;
                    }
                    $(this).parents("tr").remove();
                }
            });
            if (common_ids.length > 0) {
                ajax_common_delete(common_ids, 'grantreport_table');
            }
            $('#deleteModal').modal('toggle');
            if ($('input:checkbox.gr_checkbox:checked').length > 0) {
                $("#save_grant_report").removeClass("opacity5 none-pointer");
                $("#delete_grant_report").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_grant_report").addClass("opacity5 none-pointer");
                $("#save_grant_report").addClass("opacity5 none-pointer");
            }
        }

        $("#hid_table_type").val('');
        if ($('input:checkbox.gl_checkbox').length == 0) {
            $('#gl_checkbox').prop('checked', false);
        }
        if ($('input:checkbox.disb_checkbox').length == 0) {
            $('#disb_checkbox').prop('checked', false);
        }
        if ($('input:checkbox.gr_checkbox').length == 0) {
            $('#gr_checkbox').prop('checked', false);
        }

        if ($('input:checkbox.new_disb_checkbox').length > 0) {
            $("#save_disbursement").removeClass("opacity5 none-pointer");
            $(".new_disb_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }

        if ($('input:checkbox.new_gr_checkbox').length > 0) {
            $("#save_grant_report").removeClass("opacity5 none-pointer");
            $(".new_gr_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }

        if ($('input:checkbox.new_gr_checkbox').length > 0) {
            $("#save_grant_report").removeClass("opacity5 none-pointer");
            $(".new_gr_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }

        $.ajax({
            url: '<?php echo base_url() . 'index.php/funder/ajax_common_delete' ?>',
            cache: false,
            type: "POST",
            data: {},
            dataType: "json",
            success: function (response) {
                window.location.reload();
            }
        });
    });

function ajax_common_delete(common_id, formType) {
    var grant_id = '<?php echo $tbl_grant_id; ?>';
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/ajax_common_delete' ?>',
        cache: false,
        type: "POST",
        data: {common_id: common_id, formType: formType, grant_id: grant_id},
        dataType: "json",
        success: function (response) {
            if (response.status > 0) {
                for (const [key, value] of Object.entries(response.response)) {
                    $("#" + key).html('<label  class="error tbl_err" >' + value + '</label>');
                }
            }
            if (response.status == 0) {
                $("#add_furnder_form").submit();
            }
            window.location.reload();
        }
    });
}

$("#add_disbursement").click(function () {
    $('#disb_checkbox').prop('checked', false);
    $(".no_data_disb").css('display', 'none');
    var disbursement_tbl_len = $('#disbursement tr').length + 1;
    var markup = "<tr class='metric_more' id=disbursement_tbl_" + disbursement_tbl_len + "><input type='hidden' name='disbursement_id[]' value=''><td class='valign-center'><input class='form-control disb_checkbox new_disb_checkbox' type='checkbox'></td><td class='valign-center'><textarea  placeholder='Milestone' name='disbursement_mile[][" + disbursement_tbl_len + "]' class='form-control'></textarea></td><td><div class='position-relative'><input class='datepicker form-control' name='date_disbursement[][" + disbursement_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div><div id=disbursement_err_" + disbursement_tbl_len + "></div></td><td><input  name='disbursement_amount[][" + disbursement_tbl_len + "]' class='form-control currencyField mobile_number disb_amt' type='text' placeholder='Enter amount'><div id=disb_amt_err_" + disbursement_tbl_len + "></div></td><input class='form-control currencyField amt_dep' name='disbursement_amount[][" + disbursement_tbl_len + "]' type='text' placeholder='Enter amount'><div id=disb_amount_err_" + disbursement_tbl_len + "></div></td><td><div class='position-relative'><input class='datepicker form-control' name='date_deposite[][" + disbursement_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div><div id=date_deposite_err" + disbursement_tbl_len + "></div></td><td><input class='form-control currencyField mobile_number amt_dep' name='amount_deposite[][" + disbursement_tbl_len + "]' type='text' placeholder='Enter Amount'><div id=amount_deposite_err" + disbursement_tbl_len + "></div></td><td><input  name='disbursement_cmd[][" + disbursement_tbl_len + "]' class='form-control'  type='text' placeholder='Enter Comments'><div id=disb_cmd_err_" + disbursement_tbl_len + "></div></td>";
    $("#disbursement_tbl tbody").prepend(markup);
    $(".disb_total").css("display", "contents");
    $('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});
    $("#save_disbursement").removeClass("opacity5 none-pointer");
});

$("#add_grant_report").click(function () {
    $('#gr_checkbox').prop('checked', false);
    $(".no_data_report").css('display', 'none');
    var grantreport_tbl_len = $('#grant_report tr').length + 1;
    var markup = "<tr class='metric_more' id=grantreport_tbl_" + grantreport_tbl_len + "><input type='hidden' name='grantreport_id[]' value=''><td class='valign-center'><input class='form-control gr_checkbox new_gr_checkbox' type='checkbox'></td><td><div class='position-relative'><input class='datepicker form-control' name='grantreport_dop[][" + grantreport_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div><div id=gr_dop_err_" + grantreport_tbl_len + "></div></td><td><div class='position-relative'><input class='datepicker form-control' name='submit_date[][" + grantreport_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div></td><td><select class='form-control'name=grantreport_resp[][" + grantreport_tbl_len + "] id=grantreport_resp_" + grantreport_tbl_len + " ><option value=''>--Select--</option></select><div id=grantresp_err" + grantreport_tbl_len + "></td><td><input class='form-control' name='grantreport_cmd[][" + grantreport_tbl_len + "]' type='text' placeholder='Enter comments'><div id=gr_cmd_err_" + grantreport_tbl_len + "></div></td><td><input type='button' class='fileUpload form-control masterPicUpdatebtn employeeInput' id=file_btn_" + grantreport_tbl_len + " data_attr_id='file_upload_" + grantreport_tbl_len + "' value='Upload Report'><input data-btn-id=file_btn_" + grantreport_tbl_len + " type='file'  data-err=file_err_" + grantreport_tbl_len + " name='file_upload[][" + grantreport_tbl_len + "]' id='file_upload_" + grantreport_tbl_len + "' style='display:none'><div id=file_err_" + grantreport_tbl_len + "></div></td>";
    $("#grant_report tbody").prepend(markup);
    $('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});
    $("#save_grant_report").removeClass("opacity5 none-pointer");
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/get_resp_users_ajax' ?>',
        cache: false,
        type: "POST",
        data: {},
        dataType: "json",
        success: function (response) {
            $("#grantreport_resp_" + grantreport_tbl_len).html(response.response);
        }
    });
});
});

function ajax_call_fun(g_funder_id) {
    selected_funder_id = g_funder_id;
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/get_donor_ajax_data' ?>',
        cache: false,
        type: "POST",
        data: {selected_funder_id: selected_funder_id},
        dataType: "json",
        success: function (response) {
            $("#donor").html('');
            if (response.status == 1) {
                $("#donor").html(response.response);
            } else if (response.status == 0) {
                $("#donor").html('<option value="">--Select--</option>');
            }
            var donor_value = $("#donor").val();
            if (g_funder_id != '') {
                dom_type = "budget_0";
                get_budget_ajax_data(donor_value, dom_type);
            }
        }
    });
}

$('#donor').on('change', function () {
    var donor_id = this.value;
    $('.hid_funder_id').val(donor_id);
    get_budget_ajax_data(donor_id, '');
});

function get_budget_ajax_data(donor_id, dom_type) {
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/get_budget_ajax_data' ?>',
        cache: false,
        type: "POST",
        data: {donor_id: donor_id},
        dataType: "json",
        success: function (response) {
            if (dom_type == '') {
                $(".budget_opt").html(response.response);
                $(".lineitem").html('<option value="">--Select--</option>');
            } else {
                $("#" + dom_type).html('');
                Attribute = '#' + dom_type;
            }
            if (response.status == 1) {
                $(Attribute).html(response.response);
            } else if (response.status == 0) {
                $(Attribute).html('<option value="">--Select--</option>');
            }
        }
    });
}

$('.budget_opt').each(function () {
    var current_val = this.value;
    var current_attr = $(this).attr("data-attr");
    var selected_lineItem = $(this).attr("data-selected-lt");
    var selected_id = ''
    if (selected_lineItem != '' && selected_lineItem != undefined) {
        selected_id = selected_lineItem;
    }
    if (current_val != '') {
        get_lineitem_ajax_data(current_val, current_attr, selected_id);
    }
});

$(document).on('change', '.budget_opt', function () {
    var current_val = this.value;
    var current_attr = $(this).attr("data-attr");
    if (current_val != '') {
        get_lineitem_ajax_data(current_val, current_attr);
    }
});

function get_lineitem_ajax_data(lineitem_id, current_attr, selected_id) {
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/get_lineitem_ajax_data' ?>',
        cache: false,
        type: "POST",
        data: {lineitem_id: lineitem_id, selected_id: selected_id},
        dataType: "json",
        success: function (response) {
            $("#" + current_attr).html('');
            if (response.status == 1) {
                $("#" + current_attr).html(response.response);
            } else if (response.status == 0) {
                $("#" + current_attr).html('<option value="">--Select--</option>');
            }
        }
    });
}

$(document).ready(function () {
    $(document).on('change keyup keydown paste', '.amt_dep', function () {
        sum = 0;
        $(".amt_dep").each(function (index, value) {
            sum_vals = parseFloat(this.value.split(",").join(""));
            if (!isNaN(sum_vals)) {
                sum_val = sum_vals + 0;
                sum += sum_val;
            }
        });
        if (!isNaN(sum)) {
            var final_val = sum.toFixed(2);
            var split_res = final_val.split(".");
            x = split_res[0];
            y = split_res[1];
            var lastThree = x.substring(x.length - 3);
            var otherNumbers = x.substring(0, x.length - 3);
            if (otherNumbers != '')
                lastThree = ',' + lastThree;
            var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
            $("#disb_total_amount").val(res + '.' + y);
        }
    });

    $(document).on('change keyup keydown paste', '.disb_amt', function () {
        sum = 0;
        $(".disb_amt").each(function (index, value) {
            sum_vals = parseFloat(this.value.split(",").join(""));
            if (!isNaN(sum_vals)) {
                sum_val = sum_vals + 0;
                sum += sum_val;
            }
        });
        if (!isNaN(sum)) {
            var final_val = sum.toFixed(2);
            var split_res = final_val.split(".");
            x = split_res[0];
            y = split_res[1];
            var lastThree = x.substring(x.length - 3);
            var otherNumbers = x.substring(0, x.length - 3);
            if (otherNumbers != '')
                lastThree = ',' + lastThree;
            var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
            $("#disb_amount").val(res + '.' + y);
        }
    });

    $(document).on('change keyup keydown paste', '.gl_amt', function () {
        sum = 0;
        $(".gl_amt").each(function (index, value) {
            sum_vals = parseFloat(this.value.split(",").join(""));
            if (!isNaN(sum_vals)) {
                sum_val = sum_vals + 0;
                sum += sum_val;
            }
        });
        if (!isNaN(sum)) {
            var final_val = sum.toFixed(2);
            var split_res = final_val.split(".");
            x = split_res[0];
            y = split_res[1];
            var lastThree = x.substring(x.length - 3);
            var otherNumbers = x.substring(0, x.length - 3);
            if (otherNumbers != '')
                lastThree = ',' + lastThree;
            var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
            $("#gl_amount").val(res + '.' + y);
        }
    });
    var checkBoxStatus = '<?php echo $this->auth; ?>';
    if (checkBoxStatus == '0') {
        $("input[type='button'],input[type='file'],input[type='text'],input[type='hidden'],select,textarea").prop("disabled", true);
    }
});

var gl_total_count = '<?php echo $check_gl_total; ?>';
if (gl_total_count > 0) {
    $(".gl_total").css("display", "contents");
}

var disb_total_count = '<?php echo $check_disb_total_amt; ?>';
if (disb_total_count > 0) {
    $(".disb_total").css("display", "contents");
}

</script>

</body>
</html>