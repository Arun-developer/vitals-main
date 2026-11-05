<?php
$this->load->view('vitals_header.php', array('main_menu' => 'funder', 'page_title' => 'Add Grant - ' . $funder_name));
$current_page = $this->uri->segment(2);
$funder_id = $this->uri->segment(3);
$currency = $this->session->userdata['currency'];
?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'funder', 'page' => 'funder_grant')); ?>
        </div>

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/funder/display_grant_list/' . $funder_id; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Funds/Grant - <?php echo $funder_name; ?></h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <form id="add_grant_form" name="add_grant_form" autocomplete="off" action="<?php echo base_url() . 'index.php/funder/insertEdit_grant' ?>" enctype="multipart/form-data"  method="POST">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                <h4 class="vitals_innerSub">Add Grant Details </h4>
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
                                                    <input name="name" title="Enter Id"  id="name" class="form-control required alphanum" type="text" placeholder="Enter Id">
                                                    <div id="name_error"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Grant Amount (<?= $currency; ?>) <span>*</span></label>
                                                        <input name="grant_amt" id="grant_amt" data-attr-err='gd_amt_err' title="Enter amount"  class="form-control required currencyField" type="text" placeholder="Enter amount">
                                                        <div id="gd_amt_err"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant Signed Date  <span>*</span></label>
                                                    <div class="position-relative">
                                                        <input name="grant_sign_date" id="grant_sign_date" title="Select signed Date"  class="datepicker form-control required" type="text" placeholder="dd-mm-yyyy">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Status  <span>*</span></label>
                                                    <select name="status_type" id="status_type" title="Select status" class="form-control required">
                                                        <option value="">--Select--</option>
                                                        <option value="open" >Open</option>
                                                        <option value="on Hold">On Hold</option>
                                                        <option value="closed">Closed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant Start Date  <span>*</span></label>
                                                    <div class="position-relative">
                                                        <input name="grant_start_date" id="grant_start_date"  title="Select start Date" class="form-control required grant_start_date" type="text" placeholder="dd-mm-yyyy">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant End Date <span>*</span></label>
                                                    <div class="position-relative">
                                                        <input title="Select end date" name="grant_end_date" id="grant_end_date"  class="form-control required alphanum grant_end_date" type="text" placeholder="dd-mm-yyyy">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                                <div class="form-group">
                                                    <label>Purpose <span>*</span></label>
                                                    <textarea name="purpose" id="purpose" class="form-control required" title="Enter comments" placeholder="Enter comments"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height:30px"></div>
                                    <div class="table_configcontentnew pad-bt0">
                                        <div class="tabpanel-title">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                    <h4>Grant Line Items</h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                    <ul class="milestone-links">
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_grant_line"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                        </li>
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)"  class="pointer_cls edit-btnconfig  mar-tp15 opacity5 mar-tp15 delete_cls" data-chk-attr='gl_checkbox'  data-toggle="modal" data-target=""  id="delete_grant_line"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                        <table class="table" id="grant_line" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="removeArrow"><input class="form-control" id="gl_checkbox" type="checkbox"></th>
                                                    <th width="20%">Budget Head</th>
                                                    <th width="20%">Line Item</th>
                                                    <th width="18%">Amount (<?= $currency; ?>)</th>
                                                    <th width="25%">Comments</th>
                                                    <th width="5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="metric_more" id="grantline_tbl_0">
                                                    <td class="valign-center"><input class="form-control gl_checkbox" type="checkbox"></td>
                                                    <td>
                                                        <input placeholder="Enter budget head" name="budget[][0]" id="budget_0" data-attr="lineitem_0" class="budget_opt form-control"></input>
                                                    </td>
                                                    <td><input  type="text" placeholder="Enter line item"name="line_item[][0]"  id="lineitem_0" data-attr="subline_0" class="lineitem form-control"></input>
                                                    </td>
                                                    <td><input  name="grant_amount[][0]" class="form-control currencyField mobile_number gl_amt"  type="text" placeholder="Enter amount"></td>
                                                    <td><input  name="grant_comments[][0]" class="form-control" type="text" placeholder="Enter comments"></td>
                                                    <td>
                                                        <!-- <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(316);" href="javascript:void(0)"><i class="fas fa-trash"></i></a> -->
                                                    </td>
                                                </tr>
                                                <tr class="metric_more gl_total" id="grantline_tbl_0">
                                                    <td style="<?php
                                                    if ($this->auth == '0') {
                                                        echo"display:none";
                                                    }
                                                    ?>" class="valign-center"></td>
                                                    <td><b>Total</b></td>
                                                    <td></td>
                                                    <td><input disabled  id="gl_amount" class="form-control" value="0.00" ></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" id="hid_table_type">

                                    <div style="height:30px"></div>
                                    <div class="table_configcontentnew pad-bt0">
                                        <div class="tabpanel-title">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                    <h4>Disbursement Schedule</h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                    <ul class="milestone-links">
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_disbursement"> <i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                        </li>
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15 opacity5 delete_cls" data-chk-attr='disb_checkbox'  data-toggle="modal" data-target=""  id="delete_disbursement"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                        <table class="table" style="margin-top: 0" id="disbursement">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="removeArrow"><input class="form-control" id="disb_checkbox" type="checkbox"></th>
                                                    <th width="20%">Milestone</th>
                                                    <th width="20%">Date of Disbursement</th>
                                                    <th width="18%">Amount (<?= $currency; ?>)</th>
                                                    <th width="18%">Date of Deposit</th>
                                                    <th width="20%">Amount Deposited (<?= $currency; ?>)</th>
                                                    <th width="23%">Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="metric_more" id="disbursement_tbl_0">
                                                    <td class="valign-center"><input class="form-control disb_checkbox" type="checkbox"></td>
                                                    <td class="valign-center"><textarea name="disbursement_mile[][0]" placeholder="Milestone" class="form-control"></textarea></td>
                                                    <td><div class="position-relative"><input class="datepicker form-control" name="date_disbursement[][0]"  type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                    <td><input  class="form-control currencyField disb_amt" name="disbursement_amount[][0]"  type="text" placeholder="Enter amount"></td>
                                                    <td><div class="position-relative"><input  class="datepicker form-control" name="date_deposite[][0]"  type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                    <td><input class="form-control currencyField amt_dep" name="amount_deposite[][0]"  type="text" placeholder="Enter amount"></td>
                                                    <td><input class="form-control" name="disbursement_cmd[][0]" type="text" placeholder="Enter comments"></td>
                                                </tr>
                                                <tr class="metric_more disb_total" id="grantline_tbl_0">
                                                    <td style="<?php
                                                    if ($this->auth == '0') {
                                                        echo"display:none";
                                                    }
                                                    ?>" class="valign-center"></td>
                                                    <td><b>Total</b></td>
                                                    <td></td>
                                                    <td><input id="disb_amount" disabled  class="form-control"  value="0.00" ></td>
                                                    <td></td>
                                                    <td><input id="disb_total_amount" disabled  class="form-control" value="0.00" ></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height:30px"></div>
                                    <div class="table_configcontentnew pad-bt0">
                                        <div class="tabpanel-title">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                    <h4>Grant Reports</h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                    <ul class="milestone-links">
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_grant_report"> <i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                        </li>
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="pointer_cls edit-btnconfig  mar-tp15 opacity5 delete_cls" data-chk-attr='gr_checkbox'   data-toggle="modal" data-target="" id="delete_grant_report"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                        <table class="table" style="margin-top: 0" id="grant_report">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="removeArrow"><input class="form-control" id="gr_checkbox" type="checkbox"></th>
                                                    <th width="18%">Due Date</th>
                                                    <th width="18%">Submitted date</th>
                                                    <th width="18%">Responsibility</th>
                                                    <th width="18%">Comments</th>
                                                    <th width="30%">Report <small>(Max 10MB size of  xls, ppt, xlsx,doc,docx,pptx files)</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="metric_more" id="grantreport_tbl_0">
                                                    <td class="valign-center"><input class="form-control gr_checkbox" type="checkbox"></td>
                                                    <td><div class="position-relative"><input class="datepicker form-control" name="grantreport_dop[][0]" type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                    <td><div class="position-relative"><input class="datepicker form-control" name="submit_date[][0]"  type="text" placeholder="dd-mm-yyyy"><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>
                                                    <td><!--<input class="form-control alphaonly" name="grantreport_resp[][0]" type="text" placeholder="Enter name">-->
                                                        <select name="grantreport_resp[][0]"  id="grantreport_resp_0" class="form-control">
                                                            <option value="">--Select--</option>
                                                            <?php
                                                            if (!empty($responsibility)) {
                                                                foreach ($responsibility as $list) {
                                                                    ?>
                                                                    <option value="<?php echo $list->id; ?>"><?php echo $list->emp_first_name . ' ' . $list->emp_last_name; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control" name="grantreport_cmd[][0]" type="text" placeholder="Enter comments"></td>
                                                    <td>
                                                        <input type="button" class="form-control masterPicUpdatebtn employeeInput" id="file_btn_0" data_attr_id='file_upload_0' value="Upload Report">
                                                        <input type="file" data-err='file_err_0'  name="file_upload[][0]" data-btn-id="file_btn_0"  id="file_upload_0" style="display: none;"><div id="file_err_0"></div></td>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height:20px"></div>
                                    <div class="row">
                                        <div class="col-12 col-sm-4 col-md-4">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView ">
                                                    <li><a class="vital_yellow_btn wdt_100 pointer_cls" id="submit_form">Save</a></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/funder/display_grant_list/' . $funder_id; ?>" class="vital_bordered_btn wdt_100 pointer_cls">Cancel</a></li>
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

<?php $this->load->view('vitals_footer.php'); ?>

<style type="text/css">
    table thead th{
        vertical-align: top !important;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.masterPicUpdatebtn', function () {
            $current = $(this).attr('data_attr_id');
            $("input[id=" + $current + "]").click();
        });

        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
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

        $(document).on('click', '.delete_cls', function () {
            var cur_attr = $(this).attr("data-chk-attr");
            $('#delCount').val('');
            var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
            $('#delCount').html(sel_item);
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

        $(document).on('changeDate', '#grant_end_date', function (e) {
            $('#grant_start_date').datepicker({
                format: 'dd-mm-yyyy',
                maxDate: new Date(e.date),
            });
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
        $("#add_grant_form").validate();
    });

    amount_err = 0;
    $(document).on('change keyup keydown paste', '.currencyField', function () {
        var current_attr = $(this).attr('data-attr-err');
        $('#' + current_attr).html("");
        var value = $(this).val().length
    });

    $('.vital_yellow_btn').click(function () {
        if ($("#add_grant_form").valid() == true) {
            if (error_count == 0) {
                $("#name_error").html('');
                var funder_id = '<?php echo $funder_id; ?>';
                var grant_name = $("#name").val();
                $.ajax({
                    url: '<?php echo base_url() . 'index.php/funder/ajax_Grantname_duplicate' ?>',
                    cache: false,
                    type: "POST",
                    data: {funder_id: funder_id, grant_name: grant_name},
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 1) {
                            $("#name_error").html('<label class="error tbl_err">Name already exists</label>');
                            return false;
                        } else if (response.status == 0 && amount_err == 0) {
                            $("#submit_form").addClass("none-pointer");
                            $(".pointer_cls").addClass("none-pointer");
                            $("#add_grant_form").submit();
                        }
                    }
                });
            }
        }
    });

    $(document).ready(function () {
        var programe_id = '<?php echo $funder_id; ?>';
        ajax_call_fun(programe_id);
        if (programe_id == '') {
            $(".budget_opt").html('');
            $(".budget_opt").html('<option value="">-Select-</option>');
        }

        $("#add_grant_line").click(function () {
            var grant_line_tbl_len = $('#grant_line tr').length + 1;
            var markup = "<tr class='metric_more' id=grant_line_tbl_" + grant_line_tbl_len + "><td class='valign-center'><input class='form-control gl_checkbox' type='checkbox'></td><td><input type='text' placeholder='Enter budget head' class='budget_opt form-control'name=budget[][" + grant_line_tbl_len + "] id=budget_" + grant_line_tbl_len + " data-attr=lineitem_" + grant_line_tbl_len + " class='form-control'></td><td><input class='form-control'name=line_item[][" + grant_line_tbl_len + "] id=lineitem_" + grant_line_tbl_len + " data-attr=subline_" + grant_line_tbl_len + " class='form-control' placeholder='Enter line item'></td><td><input  name='grant_amount[][" + grant_line_tbl_len + "]' class='form-control mobile_number currencyField alphanum gl_amt'  type='text' placeholder='Enter amount'><div id=grantamt_err_" + grant_line_tbl_len + "></div></td><td><input  name='grant_comments[][" + grant_line_tbl_len + "]' class='form-control'  type='text' placeholder='Enter comments'><div id=grantcmd_err_" + grant_line_tbl_len + "></div></td>"
            $("#grant_line tbody").prepend(markup);
            $('#gl_checkbox').prop('checked', false);
            var donor_value = '<?php echo $funder_id; ?>';
            if (donor_value != '') {
                dom_type = "budget_" + grant_line_tbl_len;
                get_budget_ajax_data(donor_value, dom_type, 'add');
            }
        });

        $(document).on('change', '.gl_checkbox,#gl_checkbox', function () {
            if ($('input:checkbox.gl_checkbox').length != $('input:checkbox.gl_checkbox:checked').length) {
                $('#gl_checkbox').prop('checked', false);
            } else {
                $('#gl_checkbox').prop('checked', true);
            }
            if ($('input:checkbox.gl_checkbox:checked').length > 0) {
                $("#delete_grant_line").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_grant_line").addClass("opacity5 none-pointer");
            }
        });

        $(document).on('change', '.disb_checkbox,#disb_checkbox', function () {
            if ($('input:checkbox.disb_checkbox').length != $('input:checkbox.disb_checkbox:checked').length) {
                $('#disb_checkbox').prop('checked', false);
            } else {
                $('#disb_checkbox').prop('checked', true);
            }
            if ($('input:checkbox.disb_checkbox:checked').length > 0) {
                $("#delete_disbursement").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_disbursement").addClass("opacity5 none-pointer");
            }
        });

        $(document).on('change', '.gr_checkbox,#gr_checkbox', function () {
            if ($('input:checkbox.gr_checkbox').length != $('input:checkbox.gr_checkbox:checked').length) {
                $('#gr_checkbox').prop('checked', false);
            } else {
                $('#gr_checkbox').prop('checked', true);
            }
            if ($('input:checkbox.gr_checkbox:checked').length > 0) {
                $("#delete_grant_report").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_grant_report").addClass("opacity5 none-pointer");
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

        $("#editSubmit").click(function () {
            var cur_val = $("#hid_table_type").val();
            if (cur_val == 'hid_gl_table') {
                $("#grant_line tbody").find('input[type="checkbox"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });
                $('#deleteModal').modal('toggle');
            } else if (cur_val == 'hid_disb_table') {
                $("#disbursement tbody").find('input[type="checkbox"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });
                $('#deleteModal').modal('toggle');
            } else if (cur_val == 'hid_gr_table') {
                $("#grant_report tbody").find('input[type="checkbox"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });
                $('#deleteModal').modal('toggle');
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

            if ($('input:checkbox.gl_checkbox:checked').length > 0) {
                $("#delete_grant_line").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_grant_line").addClass("opacity5 none-pointer");
            }
            if ($('input:checkbox.disb_checkbox:checked').length > 0) {
                $("#delete_disbursement").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_disbursement").addClass("opacity5 none-pointer");
            }
            if ($('input:checkbox.gr_checkbox:checked').length > 0) {
                $("#delete_grant_report").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_grant_report").addClass("opacity5 none-pointer");
            }
            ajax_call_fun_err();
        });

        function ajax_call_fun_err() {
            error_val = 0;
            $.ajax({
                url: '<?php echo base_url() . 'index.php/funder/ajax_common_delete' ?>',
                cache: false,
                type: "POST",
                data: {error_val: error_val},
                dataType: "json",
                success: function (response) {
                    window.location.reload();
                    return  false;
                }
            });
        }

        $("#add_disbursement").click(function () {
            var disbursement_tbl_len = $('#disbursement tr').length + 1;
            var markup = "<tr class='metric_more' id=disbursement_tbl_" + disbursement_tbl_len + "><td class='valign-center'><input class='form-control disb_checkbox' type='checkbox'></td><td class='valign-center'><textarea placeholder='Milestone' name='disbursement_mile[][" + disbursement_tbl_len + "]' class='form-control'></textarea></td><td><div class='position-relative'><input class='datepicker form-control alphanum' name='date_disbursement[][" + disbursement_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div><div id=disbursement_err_" + disbursement_tbl_len + "></div></td><td><input  name='disbursement_amount[][" + disbursement_tbl_len + "]' class='form-control currencyField disb_amt'  type='text' placeholder='Enter amount'><div id=disb_amt_err_" + disbursement_tbl_len + "></div></td><td><div class='position-relative'><input class='datepicker form-control alphanum' name='date_deposite[][" + disbursement_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div><div id=date_deposite_err" + disbursement_tbl_len + "></div></td><td><input class='form-control currencyField amt_dep' name='amount_deposite[][" + disbursement_tbl_len + "]' type='text' placeholder='Enter amount'><div id=amount_deposite_err" + disbursement_tbl_len + "></div></td><td><input  name='disbursement_cmd[][" + disbursement_tbl_len + "]' class='form-control'  type='text' placeholder='Enter comments'><div id=disb_cmd_err_" + disbursement_tbl_len + "></div></td>";
            $("#disbursement tbody").prepend(markup);
            $('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});
            $('#disb_checkbox').prop('checked', false);
        });

        $("#add_grant_report").click(function () {
            var grantreport_tbl_len = $('#grant_report tr').length + 1;
            var markup = "<tr class='metric_more' id=grantreport_tbl_" + grantreport_tbl_len + "><td class='valign-center'><input class='form-control gr_checkbox' type='checkbox'></td><td><div class='position-relative'><input class='datepicker form-control alphanum' name='grantreport_dop[][" + grantreport_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div><div id=gr_dop_err_" + grantreport_tbl_len + "></div></td><td><div class='position-relative'><input class='datepicker form-control' name='submit_date[][" + grantreport_tbl_len + "]' type='text' placeholder='dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div></td><td><select class='form-control'name=grantreport_resp[][" + grantreport_tbl_len + "] id=grantreport_resp_" + grantreport_tbl_len + " ><option value=''>--Select--</option></select><div id=grantresp_err" + grantreport_tbl_len + "></td><td><input class='form-control' name='grantreport_cmd[][" + grantreport_tbl_len + "]' type='text' placeholder='Enter comments'><div id=gr_cmd_err_" + grantreport_tbl_len + "></div></td><td><input type='button' class='form-control masterPicUpdatebtn employeeInput' data_attr_id='file_upload_" + grantreport_tbl_len + "' id=file_btn_" + grantreport_tbl_len + " value='Upload Report'><input type='file'  data-btn-id=file_btn_" + grantreport_tbl_len + " data-err=file_err_" + grantreport_tbl_len + " name='file_upload[][" + grantreport_tbl_len + "]' id='file_upload_" + grantreport_tbl_len + "' style='display:none' ><div id=file_err_" + grantreport_tbl_len + "></div></td>";
            $("#grant_report tbody").prepend(markup);
            $('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});
            $('#gr_checkbox').prop('checked', false);

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

function ajax_call_fun(selected_funder_id) {
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
            if (selected_funder_id != '') {
                get_budget_ajax_data(response.donor_id, '', '');
            }
        }
    });
}

Attribute = '';
function get_budget_ajax_data(donor_id, dom_type, type) {
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/get_budget_ajax_data' ?>',
        cache: false,
        type: "POST",
        data: {donor_id: donor_id},
        dataType: "json",
        success: function (response) {
            if (dom_type != '' && dom_type != undefined) {
                Attribute = '#' + dom_type;
            } else {
                $(".budget_opt").html(response.response);
            }
            if (response.status == 1) {
                if (type != '' && type == 'add') {
                    $(Attribute).html(response.response);
                }
            } else if (response.status == 0) {
                if (Attribute != '') {
                    $(Attribute).html('<option value="">--Select--</option>');
                }
            }
        }
    });
}

$(document).on('change', '.budget_opt', function () {
    var current_val = this.value;
    var current_attr = $(this).attr("data-attr");
    if (current_val != '') {
        get_lineitem_ajax_data(current_val, current_attr);
    }
});

function get_lineitem_ajax_data(lineitem_id, current_attr) {
    $.ajax({
        url: '<?php echo base_url() . 'index.php/funder/get_lineitem_ajax_data' ?>',
        cache: false,
        type: "POST",
        data: {lineitem_id: lineitem_id},
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

</script>

</body>
</html>
