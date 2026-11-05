<?php
$this->load->view('vitals_header.php', array('main_menu' => 'funder', 'page_title' => 'Edit Funder - ' . $funder_list->name));
$funder_id = $this->uri->segment(3);
?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'funder', 'page' => 'funder_summary')); ?>
        </div>

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-9 col-lg-8 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Funds/Grants - <?php if (isset($funder_list->name) && $funder_list->name != '') echo $funder_list->name; ?></h4>
                    </div>
                    <?php if ($this->auth == '1') { ?>
                        <div class="col-xl-3 col-lg-4 col-md-12 col-12 text-right">
                            <ul class="vitals-links">
                                <li class="edit">
                                    <a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/funder/edit_funder_form/' . $funder_id; ?>">Funder Details</a></li>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/funder/display_grant_list/' . $funder_id; ?>">Grants</a></li>
                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/funder/edit_funder_documents/' . $funder_id; ?>">Documents</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="add_furnder_form" name="add_furnder_form" action="<?php echo base_url() . 'index.php/funder/insertEdit_funder' ?>" method="POST">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                <h4 class="vitals_innerSub">Funder Details</h4>
                                            </div>
                                        </div>
                                        <input type="hidden" name="funder_id" id="funder_id" value="<?php echo $funder_id; ?>">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Funder Name <span>*</span></label>
                                                    <input disabled name="name" id="name" title="Enter name" class="form-control required donorInput" type="text" value="<?php if (isset($funder_list->name) && $funder_list->name != '') echo $funder_list->name; ?>" placeholder="Name">
                                                    <div id="name_error"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Type <span>*</span></label>
                                                    <select disabled name="type" id="type" title="Select type" class="form-control required donorInput">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($fundertypeList as $key => $value) { ?>
                                                            <option <?php
                                                            if (isset($funder_list->type) && $funder_list->type != '') {
                                                                if ($funder_list->type == $key)
                                                                    echo "selected";
                                                            }
                                                            ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>PAN</label>
                                                    <input disabled name="pan" id="pan" type="text" class="form-control donorInput" value="<?php if (isset($funder_list->pan) && $funder_list->pan != '') echo $funder_list->pan; ?>" placeholder="Enter PAN">
                                                    <div id="pan_error"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>FCRA Status <span>*</span></label>
                                                    <select disabled name="fcra_status" title="Select FCRA" id="fcra_status" class="form-control required donorInput">
                                                        <option value="">--Select--</option>
                                                        <option value="fcra" <?php
                                                        if (isset($funder_list->fcra_status) && $funder_list->fcra_status != '') {
                                                            if ($funder_list->fcra_status == 'fcra')
                                                                echo "selected";
                                                        }
                                                        ?>>FCRA</option>
                                                        <option value="non_fcra" <?php
                                                        if (isset($funder_list->fcra_status) && $funder_list->fcra_status != '') {
                                                            if ($funder_list->fcra_status == 'non_fcra')
                                                                echo "selected";
                                                        }
                                                        ?>>Non FCRA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant/ Service <span>*</span></label>
                                                    <select disabled name="grant_service" title="Select service" id="grant_service" class="form-control required donorInput">
                                                        <option value="">--Select--</option>
                                                        <option <?php
                                                        if (isset($funder_list->grant_service) && $funder_list->grant_service != '') {
                                                            if ($funder_list->grant_service == 'grant')
                                                                echo "selected";
                                                        }
                                                        ?> value="grant">Grant</option>
                                                        <option <?php
                                                        if (isset($funder_list->grant_service) && $funder_list->grant_service != '') {
                                                            if ($funder_list->grant_service == 'service')
                                                                echo "selected";
                                                        }
                                                        ?> value="service">Service Agreement</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input disabled value="<?php if (isset($funder_list->address) && $funder_list->address != '') echo $funder_list->address; ?>" name="address" id="address" class="form-control donorInput" type="text" placeholder="Enter address">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>City/State</label>
                                                    <input disabled name="city" id="city" title="Select city" class="form-control donorInput" value="<?php if (isset($funder_list->city) && $funder_list->city != '') echo $funder_list->city; ?>" type="text" placeholder="City">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select disabled name="country" id="country" class="form-control donorInput">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        if ($country_list) {
                                                            foreach ($country_list as $list) {
                                                                ?>
                                                                <option <?php
                                                                if (isset($list->country_code) && $list->country_code != '') {
                                                                    if ($list->country_code == $funder_list->country)
                                                                        echo "selected";
                                                                }
                                                                ?> value="<?php echo $list->country_code; ?>"><?php echo $list->country_name; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><a id="save_funder_form" class="pointer_cls vital_yellow_btn wdt_100 pointer_cls">Save</a></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/funder/edit_funder_form/' . $funder_id; ?>" class="pointer_cls vital_bordered_btn wdt_100 pointer_cls">Cancel</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form id="edit_contact_form" name="edit_contact_form" action="<?php echo base_url() . 'index.php/funder/insert_EditFunder_Contacts' ?>" method="POST">
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Contact Details</h4>
                                                    </div>
                                                    <?php if ($this->auth == '1') { ?>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                            <ul class="milestone-links">
                                                                <li class="brd-left-onboard">
                                                                    <a href="javascript:void(0)" class="pointer_cls edit-btnconfig mar-tp15" id="add_contact"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                </li>
                                                                <li class="brd-left-onboard">
                                                                    <a href="javascript:void(0)" class="pointer_cls edit-btnconfig  mar-tp15 opacity5 none-pointer delete_cls" data-chk-attr='contact_checkbox' data-toggle="modal" data-target="" id="delete_contact"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                </li>
                                                                <li class="brd-left-onboard"><a href="javascript:void(0)" class="pointer_cls saveContinue none-pointer opacity5 mar-tp15" id="save_contact_form">Save</a></li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="hid_table_type">
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="contact_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none;";
                                                        }
                                                        ?>" width="5%" class="removeArrow"><input <?php
                                                            if ($this->auth == '0') {
                                                                echo "disabled";
                                                            }
                                                            ?> class="form-control common_checkbox" data-attr='contact_table' id="contact_checkbox" type="checkbox"></th>
                                                        <th width="20%">Name</th>
                                                        <th width="20%">Designation</th>
                                                        <th width="20%">Phone</th>
                                                        <th width="25%">Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <input type="hidden" name="funder_id" value="<?php echo $funder_id; ?>">
                                                <?php
                                                $i = 0;
                                                if (!empty($funder_contact)) {
                                                    foreach ($funder_contact as $lists) {
                                                        ?>
                                                        <tr class="metric_more" id="contact_tbl_<?php echo $i; ?>">
                                                        <input disabled type="hidden" name="contact_id[]" value="<?php echo $lists->id; ?>">
                                                        <td style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none;";
                                                        }
                                                        ?>" class="valign-center"><input <?php
                                                            if ($this->auth == '0') {
                                                                echo "disabled";
                                                            }
                                                            ?> class="form-control contact_checkbox" value="<?php echo $lists->id; ?>" type="checkbox"></td>
                                                        <td><input disabled class="form-control" title="Enter contact name" name="contact_name[][<?php echo $i; ?>]" value="<?php if (isset($lists->name) && $lists->name != '') echo $lists->name; ?>" type="text" placeholder="Enter name"></td>
                                                        <td><input disabled class="form-control" title="Enter designation" name="designation[][<?php echo $i; ?>]" type="text" value="<?php if (isset($lists->designation) && $lists->designation != '') echo $lists->designation; ?>" placeholder="Enter designation"></td>
                                                        <td><input disabled class="form-control" data-attr-mn-id="<?php echo $lists->id; ?>" title="Enter mobile number" data-attr='phone_err_<?php echo $i; ?>' maxlength="15" name="mobile_number[][<?php echo $i; ?>]" type="text" value="<?php if (isset($lists->mobile_number) && $lists->mobile_number != '') echo $lists->mobile_number; ?>" placeholder="Enter phone">
                                                            <div id="phone_err_<?php echo $i; ?>"></div>
                                                        </td>
                                                        <td><input disabled class="form-control email email_spc" title="Enter valid email" data-attr-em-id="<?php echo $lists->id; ?>" data-attr='email_err_<?php echo $i; ?>' name="email[][<?php echo $i; ?>]" type="text" value="<?php if (isset($lists->email) && $lists->email != '') echo $lists->email; ?>" placeholder="Enter email">
                                                            <div id="email_err_<?php echo $i; ?>"></div>
                                                        </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr class="metric_more no_data">
                                                        <td colspan="5" style="text-align: center;">No data available in table</td>
                                                    </tr>
                                                <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </form>

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

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
    if ($('input:checkbox.new_contact_checkbox').length > 0) {
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    $(".new_contact_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
    }

    $(document).on('click', '.delete_cls', function() {
    var cur_attr = $(this).attr("data-chk-attr");
    $('#delCount').val('');
    var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
    $('#delCount').html(sel_item);
    $('#deleteModal').modal('show');
    });
    $(document).on('click', '.masterPicUpdatebtn', function() {
    $current = $(this).attr('data_attr_id');
    $("input[id=" + $current + "]").click();
    });
    $(document).on('change keyup paste', '#pan', function() {
    $("#pan_error").html('');
    var pan_val = this.value;
    if (pan_val != '' && pan_val != undefined) {
    var regExp = "/[a-zA-z]{5}\d{4}[a-zA-Z]{1}/";
    if (!pan_val.match(regExp)) {
    $("#pan_error").html('<label  class="error tbl_err" >Enter valid pan number format</label>');
    }
    }
    });
    $('.summaryEdit').click(function() {
    $(".donorInput").attr("disabled", false);
    $('li.edit').addClass("activeTabs");
    $('li.edit a').addClass("greentab");
    $('.saveLinkView').removeClass("display-hide");
    $('.saveLinkView').addClass("display-show");
    });
    });
    $(document).ready(function() {
    //Add Multiple Form
    $("#add_contact").click(function() {
    $(".no_data").css('display', 'none');
    var contact_tbl_len = $('#contact_table tr').length + 1;
    var markup = "<tr class='metric_more' id=contact_tbl_" + contact_tbl_len + "><input type='hidden' name='contact_id[]' value=''><td class='valign-center'><input class='form-control contact_checkbox new_contact_checkbox' type='checkbox'></td><td><input  title='Enter contact name' name='contact_name[][" + contact_tbl_len + "]'  class='form-control' type='text' placeholder='Enter name'></td><td><input class='form-control'  title='Enter designation' name='designation[][" + contact_tbl_len + "]'  type='text' placeholder='Enter designation'></td><td><input maxlength='15' title='Enter mobile number'  class='form-control' name='mobile_number[][" + contact_tbl_len + "]' type='text' data-attr=phone_err_" + contact_tbl_len + " placeholder='Enter phone'><div id=phone_err_" + contact_tbl_len + "></div></td><td><input title='Enter vaild email' class='form-control email email_spc'  data-attr=email_err_" + contact_tbl_len + " name='email[][" + contact_tbl_len + "]' type='text' placeholder='Enter email'><div id=email_err_" + contact_tbl_len + "></div></td></tr>";
    $("#contact_table tbody").prepend(markup);
    $('#contact_checkbox').prop('checked', false);
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    });
    //Change delete attribute Modal
    $(document).on('change', '.contact_checkbox, #contact_checkbox', function() {
    if ($('input:checkbox.contact_checkbox').length > 0){
    if ($('input:checkbox.contact_checkbox').length != $('input:checkbox.contact_checkbox:checked').length) {
    $('#contact_checkbox').prop('checked', false);
    } else if ($('input:checkbox.contact_checkbox').length == $('input:checkbox.contact_checkbox:checked').length) {
    $('#contact_checkbox').prop('checked', true);
    }
    }

    if ($('input:checkbox.contact_checkbox:checked').length > 0) {
    $("#delete_contact").removeClass("opacity5 none-pointer");
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    $("#delete_contact").attr({
    "data-target": "#deleteModal"
    });
    } else {
    $("#delete_contact").addClass("opacity5 none-pointer");
    $("#save_contact_form").addClass("opacity5 none-pointer");
    $("#delete_contact").attr({
    "data-target": ""
    });
    }

    if ($('input:checkbox.new_contact_checkbox').length > 0) {
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    $(".new_contact_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
    }
    });
    $(document).on('change', '.new_contact_checkbox', function() {
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    });
    $("#delete_contact").click(function() {
    if ($('input:checkbox.contact_checkbox:checked').length > 0) {
    $("#hid_table_type").val('hid_contact_table');
    }
    });
    //Disable input box by table id
    $(document).on('click', '.contact_checkbox', function() {
    if (!$(this).is(":checked")) {
    $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", true);
    } else {
    $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
    }
    });
    //if click pop current checked td are removed
    $("#editSubmit").click(function() {
    var cur_val = $("#hid_table_type").val();
    var common_ids = [];
    if (cur_val == 'hid_contact_table') {
    $("#contact_table tbody").find('input[type="checkbox"]').each(function(index) {
    if ($(this).is(":checked")) {
    if (this.value != '' && this.value != undefined) {
    common_ids[index] = this.value;
    }
    $(this).parents("tr").remove();
    }
    });
    ajax_common_delete(common_ids, 'contact_table');
    $('#deleteModal').modal('toggle');
    }
    $("#hid_table_type").val('');
    if ($('input:checkbox.contact_checkbox').length == 0) {
    $('#contact_checkbox').prop('checked', false);
    }
    if ($('input:checkbox.contact_checkbox:checked').length > 0) {
    $("#delete_contact").removeClass("opacity5 none-pointer");
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    } else {
    $("#delete_contact").addClass("opacity5 none-pointer");
    $("#save_contact_form").addClass("opacity5 none-pointer");
    }
    if ($('input:checkbox.new_contact_checkbox').length > 0) {
    $("#save_contact_form").removeClass("opacity5 none-pointer");
    $(".new_contact_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
    }

    });
    //Disable all inputs by common checkbox class
    $('.common_checkbox').click(function(e) {
    var table = $(e.target).closest('table');
    var cur_tbl_id = $(e.target).closest('table').attr('id');
    $('td input:checkbox', table).prop('checked', this.checked);
    if (!this.checked) {
    $("#" + cur_tbl_id + " tbody").find('input[type="checkbox"]').each(function() {
    if (!$(this).is(":checked")) {
    $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", true);
    }
    });
    } else {
    $("#" + cur_tbl_id + " tbody").find('input[type="checkbox"]').each(function() {
    if ($(this).is(":checked")) {
    $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
    }
    });
    }
    });
    });
    //Form Validated

    $('#save_contact_form').click(function() {
    $("#edit_contact_form").valid();
    //check if input field is disabled or not
    var disabled_count = $('#contact_table').find('input[type="text"]').not(":disabled").length;
    if (disabled_count > 0 && $("#edit_contact_form").valid() == true) {
    //$("#edit_contact_form").submit();
    $("#save_contact_form").addClass("none-pointer");
    $(".pointer_cls").addClass("none-pointer");
    ajax_funder_validate('contact_form');
    }
    });
    $('.vital_yellow_btn').click(function(e) {
    e.preventDefault();
    $(".tbl_err").html('');
    if ($("#add_furnder_form").valid() == true) {
    $(".pointer_cls").addClass("none-pointer");
    $("#save_funder_form").addClass("none-pointer");
    ajax_funder_validate();
    }
    });
    function ajax_funder_validate(form_type = '') {
    var name = $("#name").val();
    var funder_id = $("#funder_id").val();
    $.ajax({
    url: '<?php echo base_url() . 'index.php/funder/ajax_funder_validate' ?>',
            cache: false,
            type: "POST",
            data: {
            name: name,
                    funder_id: funder_id
            },
            dataType: "json",
            success: function(response) {
            if (response.status > 0) {
            for (const [key, value] of Object.entries(response.response)) {
            $("#" + key).html('<label  class="error tbl_err" >' + value + '</label>');
            }
            }
            if (form_type == 'contact_form') {
            if (response.status == 0) {
            $("#edit_contact_form").submit();
            } else {
            $("#save_contact_form").removeClass("none-pointer");
            $(".pointer_cls").removeClass("none-pointer");
            }
            } else {
            if (response.status == 0) {
            $("#add_furnder_form").submit();
            } else {
            $("#save_funder_form").removeClass("none-pointer");
            $(".pointer_cls").removeClass("none-pointer");
            }
            }
            }
    });
    }

    function ajax_common_delete(common_id, formType) {
    var funder_id = '<?php echo $funder_id; ?>'
            $.ajax({
            url: '<?php echo base_url() . 'index.php/funder/ajax_common_delete' ?>',
                    cache: false,
                    type: "POST",
                    data: {
                    common_id: common_id,
                            funder_id:funder_id,
                            formType: formType
                    },
                    dataType: "json",
                    success: function(response) {
                    window.location.reload();
                    if (response.status > 0) {
                    for (const [key, value] of Object.entries(response.response)) {
                    $("#" + key).html('<label  class="error tbl_err" >' + value + '</label>');
                    }
                    }
                    if (response.status == 0) {
                    $("#add_furnder_form").submit();
                    }

                    }
            });
    }
    $(document).ready(function() {
    var checkBoxStatus = '<?php echo $this->auth; ?>';
    if (checkBoxStatus == '0') {
    $("input[type='button'],input[type='file'],input[type='text'],input[type='hidden'],select,textarea").prop("disabled", true);
    }
    });

</script>

</body>
</html>