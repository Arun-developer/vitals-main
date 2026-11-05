
<?php
$back_link = "";
$cat_type = $this->uri->segment(4);
if ($cat_type != '') {
    $back_link = "index.php/master_pro/master/disaplay_asset/" . $cat_type;
}
?>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
    <main class="page-content">
        <div class="row dataconfig d_v_d_c">
            <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                <span><a href="<?php echo base_url() . $back_link; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                <h4>Add Master</h4>
            </div>
        </div>
        <div class="plan-structure-vital vital_windowScroll">
            <main class="page-content">
                <div class="inputplan-structureall plan-structure-new">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-6 col-lg-4 col-xl-4">
                            <form action="<?php echo base_url() . 'index.php/master_pro/master/insert_edit_additional_info' ?>" method="POST" id="master_setting">
                                <input type="hidden" name="tab_title" id="tab_title" value="<?php echo $tab_title; ?>" />
                                <input type="hidden" name="main_tab" id="main_tab" value="<?php echo $cat_type; ?>" />
                                <div class="form-group">
                                    <label>Master Type <span>*</span></label>
                                    <select id="master_type" name="master_type" class="form-control required">
                                        <option value="">Select</option>
                                        <?php
                                        if (!empty($menuMaster)) {
                                            foreach ($menuMaster as $key => $value) {
                                                ?>
                                                <option <?php if ($cat_type == $key) echo "selected"; ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
<?php if (!empty($programme)) { ?>
                                        <label><?php echo 'Programme'; ?></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_190">
                                            <select  name="programme" id="programmes_0" class="form-control programmes_filter required">
                                                <option value ="">Please select the Programme</option>
                                                <?php foreach ($programme as $lists) { ?>
                                                    <option <?php if ($programmes_filter == $lists->programme_id) echo "selected"; ?>  value ="<?php echo $lists->programme_id; ?>"><?php echo $lists->programme; ?></option>
    <?php } ?>
                                            </select>

                                        </div>
<?php } ?>
                                </div>
                                <div class="form-group" id="donor_data">
<?php if (!empty($donorList)) { ?>
                                        <label><?php echo 'Donor'; ?></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_190">
                                            <select  name="donor" id="donor_0" class="form-control donor_filter required">
                                                <option value ="">Please select the Donor</option>
                                                <?php foreach ($donorList as $lists) { ?>
                                                    <option <?php if ($donor_filter == $lists['master_id']) echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
    <?php } ?>
                                            </select>

                                        </div>
<?php } ?>
                                </div>

                                <div class="form-group">
<?php if (!empty($budgetList)) { ?>
                                        <label><?php echo 'Budget Head'; ?></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_190">
                                            <select  name="budget" id="budget_0" class="form-control budget_filter required">
                                                <option value ="">Please select the Budge Head</option>
                                                <?php foreach ($budgetList as $lists) { ?>
                                                    <option <?php if ($budget_filter == $lists['master_id']) echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
    <?php } ?>
                                            </select>
                                        </div>
<?php } ?>
                                </div>
                                <div class="form-group">
<?php if (!empty($lineitemList)) { ?>
                                        <label><?php echo 'line item'; ?></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_190">
                                            <select   name="lineitemList" id="lineitemList_0" class="form-control lineitemList_filter required">
                                                <option value ="">Please select the line item</option>
                                                <?php foreach ($lineitemList as $lists) { ?>
                                                    <option <?php if ($lineitemList_filter == $lists['master_id']) echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
    <?php } ?>
                                            </select>
                                        </div>
<?php } ?>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $tab_title; ?> <span> *</span></label>
                                    <input type="text" name="master_name" id="master_name" class="form-control required" placeholder="Please enter the travel mode" />
                                    <div id="error_msg" ></div>
                                </div>
                                <div>
                                    <ul class="vitals-links">
                                        <li><input type="submit" class="button vital_yellow_btn save_btn" value="Add Master"></li>
                                        <li><a href="<?php echo base_url() . $back_link; ?>" class="vital_bordered_btn">Cancel</a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>
</div>
<script>

    $(document).ready(function () {
        $('select').on('change', function () {
            var current_id = this.id;
            var current_value = this.value;
            var split_cid = current_id.split("_");
            var select_type = split_cid[0];
            var select_count = split_cid[1];

            var addinfo_length = '<?php echo count($get_results) + 1; ?>';
            console.log('addinfo_length' + addinfo_length);
            console.log('current_id' + current_id);
            var donor_option_txt = budget_option_txt = line_option_txt = '-- Select --';
            var search_type = '1';
            var search_type = '1';
            if (select_type == 'programmes') {
                var donor_option_txt = 'Please select the Donor';
                var budget_option_txt = 'Please select the Budge Head';
                var line_option_txt = 'Please select the Line item';
            } else if (select_type == 'donor') {
                var budget_option_txt = 'Please select the Budge Head';
                var line_option_txt = 'Please select the Line item';
            } else if (select_type == 'budget') {
                var line_option_txt = 'Please select the Line item';
            }

            if (select_type == 'programmes') {
                $("#donor_" + select_count).html('<option value="">' + donor_option_txt + '</option>');
                $("#budget_" + select_count).html('<option value="">' + budget_option_txt + '</option>');
                $("#lineitemList_" + select_count).html('<option value="">' + line_option_txt + '</option>');
            } else if (select_type == 'donor' && addinfo_length != select_count) {
                $("#budget_" + select_count).html('<option value="">' + budget_option_txt + '</option>');
                $("#lineitemList_" + select_count).html('<option value="">' + line_option_txt + '</option>');
            } else if (select_type == 'budget' && addinfo_length != select_count) {
                $("#lineitemList_" + select_count).html('<option value="">' + line_option_txt + '</option>');
            }
            if (current_id != '' && current_id != undefined && current_value != '' && current_value != undefined) {
                ajax_call_options(select_type, current_id, current_value, select_count, search_type);
            }
        });
    });
    function ajax_call_options(select_type, current_id, current_value, select_count, search_type) {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master_pro/master/get_ajax_option_data' ?>',
            cache: false,
            type: "POST",
            data: {select_type: select_type, current_id: current_id, current_value: current_value, search_type: search_type},
            dataType: "json",
            success: function (response) { //console.log('response' + response);
                if (select_type == 'programmes') {
                    $("#donor_" + select_count).html('');
                    if (response.current_id != '') {
                        $("#donor_" + select_count).html(response.response);
                    }
                } else if (select_type == 'donor') {
                    $("#budget_" + select_count).html('');
                    if (response.current_id != '') {
                        $("#budget_" + select_count).html(response.response);
                    }
                } else if (select_type == 'budget') {
                    $("#lineitemList_" + select_count).html('');
                    if (response.current_id != '') {
                        $("#lineitemList_" + select_count).html(response.response);
                    }
                }
            }
        });
    }


    $(function () {
        $("#master_setting").validate();
    });
    $(document).ready(function () {
        $('#master_type').on('change', function () {
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_add_asset_form/' ?>' + this.value;
            $("#donor_data").css("display", "none");
            if (this.value == 'budget_head') {
                $("#donor_data").css("display", "block");
            }
        });
    });

    $('.save_btn').click(function (e) {
        e.preventDefault();
        var tab_title = $("#tab_title").val();
        var master_type = $("#master_type").val();
        var master_name = $("#master_name").val();
        var donor_ms_id = $("#donor_master_id").val();

        var donor_master_id = '';
        if (donor_ms_id != '' && donor_ms_id != undefined) {
            donor_master_id = $("#donor_master_id").val();
        }
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master_pro/master/check_ajax_asset_data' ?>',
            cache: false,
            type: "POST",
            data: {master_type: master_type, master_name: master_name, tab_title: tab_title, donor_master_id: donor_master_id},
            dataType: "json",
            success: function (response) {
                $("#error_msg").html("");
                if (response.status == '1') {
                    $("#error_msg").html("<label class='error'>" + response.err_msg + "</label>");
                } else if (response.status == '0') {
                    $("#master_setting").submit();
                }
            }
        });
    });

</script>
<script type="text/javascript" src="<?= base_url() . 'source/jquery_datepick/jquery.ui.timepicker.js?v=0.1.0'; ?>"></script>