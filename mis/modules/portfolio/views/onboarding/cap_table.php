<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

$cap_data = $capTableDetails[0];
$capdd_data = $get_capdd[0];
$cap_count = isset($cap_data) ? php72_count($capTableDetails) : 1;
$cap_ddcount = isset($capdd_data) ? php72_count($get_capdd) : 1;
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Info', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'add_class' => 'mar-tp140'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"
                           href="<?= $company_link; ?>"
                           aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab"
                           href="<?= $nature_link; ?>"
                           aria-controls="nav-business" aria-selected="false">Nature of Business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab"
                           href="<?= $mgmnt_link; ?>"
                           aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab"
                           href="<?= $govern_link; ?>"
                           aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab"
                           href="<?= $vilrel_link; ?>"
                           aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link filled-data" id="nav-incubation-tab"
                           href="<?= $increl_link; ?>"
                           aria-controls="nav-incubation" aria-selected="true">Incubation Relationship</a>
                        <a class="nav-item nav-link active" id="nav-cap-tab" aria-controls="nav-cap"
                           aria-selected="false">07</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" aria-controls="nav-interested"
                           href="<?= $int_link; ?>"
                           aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab" href="#nav-about"
                           aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= $dataconfig_link; ?>"
                           role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <form id="capTableForm" method="POST"  action="<?php echo base_url() . 'index.php/portfolio/addCapTable'; ?>" autocomplete="off">
                        <div class="tab-pane fade show active" id="nav-business" role="tabpanel"
                             aria-labelledby="nav-business-tab">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12">
                                        <h4>Cap Table</h4>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                            
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="addMore"><i class="fas fa-plus-circle"></i>
                                                        Add New</a>
                                                </li>
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="edit_cmpny"><i
                                                            class="fas fa-pencil-alt"></i> Edit</a>
                                                </li>
                                                <li class="brd-left-onboard" id="disableBtn">
                                                    <a class="deleteControl" id="deleteBtn" href="javascript:void(0)"><i class="fas fa-trash"></i>
                                                        Delete</a>
                                                </li>
                                                <li class="brd-left-onboard">
                                                    <a class="saveContinue" href="javascript:void(0);">Save</a>
                                                </li>
                                            
                                        <?php } ?>
                                        <li><a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="Diagnostic-graph plan-structure-new">
                                <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="3%"></th>
                                                <th width="5%" class="text-center">S. No</th>
                                                <th width="20%">Shareholder</th>
                                                <th width="15%">% Shares</th>
                                                <th width="15%">Type of shares</th>
                                                <th width="15%">Vesting ?</th>
                                                <th width="15%">Vesting Schedule</th>
                                                <th width="22%"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="add_more_cap">
                                            <?php
                                            if (php72_count($capTableDetails) != 0) {
                                                for ($i = 0; $i < $cap_count; $i++) {
                                                    ?>

                                                    <tr>
                                                        <td width="3%">
                                                            <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                <div class="input-group">
                                                                    <input type="checkbox" class="check_box delete_box"
                                                                           aria-label="Checkbox for following text input"
                                                                           name="check_delete"
                                                                           value="<?php echo $capTableDetails[$i]['id']; ?>">
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="serial_index text-center" ><?php echo $i + 1; ?></td>
                                                        <td width="20%">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                       class="form-control form-control-sm share_holder"
                                                                       name="share_holder[]" id="share_holder_<?= $i; ?>"
                                                                       value="<?php echo $capTableDetails[$i]['name']; ?>">
                                                            </div>
                                                        </td>
                                                        <td width="10%">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                       class="form-control form-control-sm percentage"
                                                                       name="percentage[]" id="percentage_<?= $i; ?>" maxlength="5"
                                                                       value="<?php echo $capTableDetails[$i]['percentage']; ?>">
                                                                <label class="error error_msg"></label>
                                                            </div>
                                                        </td>
                                                        <td width="15%">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm type"
                                                                       name="type[]" id="type_<?= $i; ?>"  maxlength="50"
                                                                       value="<?php echo $capTableDetails[$i]['type']; ?>">
                                                            </div>
                                                        </td>
                                                        <td width="15%">
                                                            <div>
                                                                <div class="wdt_50 float-left">
                                                                    <div class="input-group">
                                                                        <input type="radio" class="check_box vesting vestingy" id="vestingY_<?= $i; ?>"
                                                                               name="vesting[<?php echo $i; ?>]" value="1" onclick="enable_schedule(<?= $i; ?>)"
                                                                               <?php if ($capTableDetails[$i]['vesting'] == 1) { ?> checked="checked" <?php } ?>>
                                                                        <label for="vestingY_<?= $i; ?>">Yes</label>
                                                                        <input type="radio" class="check_box vesting vestingn" id="vestingN_<?= $i; ?>"
                                                                               name="vesting[<?php echo $i; ?>]" value="0" onclick="disable_schedule(<?= $i; ?>)"
                                                                               <?php if ($capTableDetails[$i]['vesting'] == 0) { ?> checked="checked" <?php } ?>>
                                                                        <label for="vestingN_<?= $i; ?>">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="15%">
                                                            <div class="form-group" id="tim_range">
                                                                <input type="text" class="form-control form-control-sm vesting_schedule"
                                                                       name="vesting_schedule[]" id="vesting_schedule_<?= $i; ?>"  maxlength="100"
                                                                       value="<?php echo $capTableDetails[$i]['vesting_schedule']; ?>">
                                                            </div>
                                                        </td>
                                                        <td width="22%"></td>
                                                    </tr>
                                                <input type="hidden" name="id[]" value="<?php echo $capTableDetails[$i]['id']; ?>" />
                                                <?php
                                            }
                                        } else {

                                            for ($i = 0; $i < $cap_ddcount; $i++) {
                                                ?>
                                                <tr>
                                                    <td width="3%">
                                                        <div class="input-group">
                                                            <input type="checkbox" class="check_box delete_box"
                                                                   aria-label="Checkbox for following text input"
                                                                   name="check_delete"
                                                                   value="<?php echo $get_capdd[$i]['id']; ?>">
                                                        </div>
                                                    </td>
                                                    <td class="serial_index text-center" ><?php echo $i + 1; ?></td>
                                                    <td width="20%">
                                                        <div class="form-group">
                                                            <input type="text"
                                                                   class="form-control form-control-sm share_holder"
                                                                   name="share_holder[]" id="share_holder_<?= $i; ?>"
                                                                   value="<?php echo $get_capdd[$i]['holder']; ?>">
                                                        </div>
                                                    </td>
                                                    <td width="10%">
                                                        <div class="form-group">
                                                            <input type="text"
                                                                   class="form-control form-control-sm percentage"
                                                                   name="percentage[]" id="percentage_<?= $i; ?>" maxlength="5"
                                                                   value="<?php echo $get_capdd[$i]['share']; ?>">
                                                            <label class="error error_msg"></label>
                                                        </div>
                                                    </td>
                                                    <td width="15%">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm type"
                                                                   name="type[]" id="type_<?= $i; ?>"  maxlength="50"
                                                                   value="<?php echo $get_capdd[$i]['type']; ?>">
                                                        </div>
                                                    </td>
                                                    <td width="15%">
                                                        <div>
                                                            <div class="wdt_50 float-left">
                                                                <div class="input-group">
                                                                    <input type="radio" class="check_box vesting vestingy" id="vestingY_<?= $i; ?>"
                                                                           name="vesting[<?php echo $i; ?>]" value="1" checked  onclick="enable_schedule(<?= $i; ?>)"
                                                                           >
                                                                    <label for="vestingY_<?= $i; ?>">Yes</label>
                                                                    <input type="radio" class="check_box vesting vestingn" id="vestingN_<?= $i; ?>"
                                                                           name="vesting[<?php echo $i; ?>]" value="0" onclick="disable_schedule(<?= $i; ?>)"
                                                                           >
                                                                    <label for="vestingN_<?= $i; ?>">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="15%">
                                                        <div class="form-group" id="tim_range">
                                                            <input type="text" class="form-control form-control-sm vesting_schedule"
                                                                   name="vesting_schedule[]" id="vesting_schedule_<?= $i; ?>"  maxlength="100"
                                                                   value="">
                                                        </div>
                                                    </td>
                                                    <td width="22%"></td>
                                                </tr>

                                                <input type="hidden" name="id[]" value="" />
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tbody id='cap_add'></tbody>
                                        <input type="hidden" name="innovation_id" value="<?php echo $innovation_id; ?>" />
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= php72_count($capTableDetails); ?>">

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default portfolioclose">Cancel</button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        onLoad();
    });
    var _changeInterval = null;
    function onLoad() {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"], select').attr('readonly', 'readonly');
            $('input[type="radio"], select, .wdt_50 label').css('pointer-events', 'none');
        }
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
        $('#edit_cmpny').addClass('opacity5');
    }
    $(document).on('click', '.portfolioclose', function () {
        $('#deletemodal').modal('hide');
    });

    function pad(num) {
        var s = num + "";
        s = parseFloat(s, 10);
        return s;
    }

    $(document).on('blur', '.percentage', function () {
        if ($(this).val() > 100) {
            $(this).val('');
            $(this).next('label').text('Value should be less than 100');
            clearInterval(_changeInterval);
            _changeInterval = setInterval(function () {
                $('.error_msg').text('');
                clearInterval(_changeInterval);
            }, 3000);
        }

        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));

        if (self.val().split('.').length >= 3) {
            self.val('');
        }

        var n = self.val();
        n = (n + "").split(".")[1];
        if (n == undefined) {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            if (self_val >= 0 || self_val == '') {
                self.val(self_val);
            } else {
                self.val(0);
            }
        } else if (n.length == 1) {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{1}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                var self_val = Number.parseFloat(matchedString).toFixed(1);
                self.val(self_val);
            }
        } else {
            var getValues = (self.val().split(',').join(''));
            var flval = parseFloat(getValues);
            var self_val = Number(flval.toFixed(2));
            if (self_val > 0 || self_val != '') {
                var decim = pad(self_val);
                var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
                var matchedString = self.val().match(patt);
                if (matchedString) {
                    var self_val = Number.parseFloat(matchedString).toFixed(2);
                    if (self_val > 0) {
                        self.val(self_val);
                    }
                }
            } else {
                self.val(0);
            }
        }
    });

    $(document).on('click', '#addMore', function () {
        var lengthDiv = $('.add_more_cap').find('tr').length;
        var s = lengthDiv + 1;
        var datass = '<tr>';
        datass += '<td width="3%"><div class="input-group"><input type="checkbox" class="check_box delete_box" aria-label="Checkbox for following text input" name="check_delete" value=""></div></td>';
        datass += '<td class="serial_index text-center">' + s + '</td><td width="20%"><div class="form-group"><input type="text" class="form-control form-control-sm share_holder" name="share_holder[]" id="share_holder_' + lengthDiv + '" value=""></div></td>';
        datass += '<td width="10%"><div class="form-group"><input type="text" class="form-control form-control-sm percentage" maxlength="5" name="percentage[]" id="percentage_' + lengthDiv + '" value=""><label class="error error_msg"></label></div></td>';
        datass += '<td width="15%"><div class="form-group"><input type="text" class="form-control form-control-sm type" name="type[]"  maxlength="50" id="type_' + lengthDiv + '" value=""></div></td>';
        datass += '<td width="15%"><div> <div class="wdt_50 float-left"><div class="input-group"><input type="radio" class="check_box vesting vestingy" id="vestingY_' + lengthDiv + '" name="vesting[' + lengthDiv + ']" value="1" checked="checked"  onclick="enable_schedule(' + lengthDiv + ')">';
        datass += '<label for="vestingY_' + lengthDiv + '">Yes</label><input type="radio" class="check_box vesting vestingn" id="vestingN_' + lengthDiv + '" name="vesting[' + lengthDiv + ']" value="0" onclick="disable_schedule(' + lengthDiv + ')"><label for="vestingN_' + lengthDiv + '">No</label></div></div></div></td>';
        datass += '<td width="15%"><div class="form-group" id="tim_range"><input type="text" class="form-control form-control-sm vesting_schedule"  maxlength="100" name="vesting_schedule[]" id="vesting_schedule_' + lengthDiv + '" value="" ></div></td>';
        datass += '<td width="22%"></td></tr>';
        $('.add_more_cap').append(datass);
    });

    $(document).on('click', '.saveContinue', function (e) {
        if ($('#capTableForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#capTableForm').submit();
        }
    });

    $('#edit_cmpny').on('click', function () {
        $('input[type="radio"], select, .wdt_50 label').css('pointer-events', 'visible');
        $('#tim_range input[type="text"]').attr('readonly', true);
        $('input[type="text"], select').attr('readonly', false);
        $('#edit_cmpny').removeClass('opacity5');
        checkVest();
    });

    function checkVest() {
        $('.vesting').each(function (key, value) {
            var checkVal = $('input[name="vesting[' + key + ']"]:checked').val();
            if (checkVal == 0) {
                $('#vesting_schedule_' + key).val('').attr('readonly', true);
            } else {
                $('#vesting_schedule_' + key).attr('readonly', false);
            }
        });
    }

    function enable_schedule(id) {
        $('#vesting_schedule_' + id).attr('readonly', false);
    }

    function disable_schedule(id) {
        $('#vesting_schedule_' + id).val('').attr('readonly', true);
    }

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $('.delete_box').on('click', function () {
        if ($("#capTableForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        $('.delete_box').on('click', function () {
            if ($("#capTableForm input:checkbox:checked").length > 0) {
                $('#disableBtn').css("cursor", "pointer");
                $('#deleteBtn').css("pointer-events", "");
            } else {
                $('#disableBtn').css("cursor", "not-allowed");
                $('#deleteBtn').css("pointer-events", "none");
            }
        });
    }

    $('#deleteRecord').on('click', function () {
        var deleteId = new Array();
        $("input:checkbox[name=check_delete]:checked").each(function () {
            deleteId.push($(this).val());
        });

        if ($("#capTableForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'port_cap_table'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#accordion').load(location.href + ' #accordion');
                    $('#deletemodal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});
</script>

</body>
</html>