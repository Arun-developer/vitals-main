<?php
$cat_type = $this->uri->segment(4);
$active_status = "";
?>
<style>
    .form-inline {
        display: block;
    }
    .table.dataTable {
        border-collapse: collapse;
    }
    .active {
        background: #2e8751;
        color: black;
    }

    .sector
</style>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
    <div class="plan-structure-vital vital_windowScroll">

        <main class="page-content">
            <div class="row dataconfig d_v_d_c">
                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                    <h4>Master Settings</h4>
                </div>
            </div>
            <form id="delete_form" action="<?php echo base_url() . 'index.php/master_pro/master/common_delete' ?>" method="POST">
                <input type="hidden" name="redirect_master_type" value="<?php echo $cat_type; ?>">
                <div class="delete_ids"></div>
            </form>
            <div class="plan-structure-vital">
                <div>
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="<?php if ($cat_type == 'travel_mode') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/travel_mode'; ?>" role="tab">Travel Mode</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'books_category') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/books_category'; ?>" role="tab">Books Category</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'general_asset') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/general_asset'; ?>" role="tab">General Asset</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'it_asset') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/it_asset'; ?>" role="tab">IT Asset</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'business_card_catsset') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/business_card_catsset'; ?>" role="tab">Business Card Category</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'utilities') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/utilities'; ?>" role="tab">Utilities Type</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'pay_grade') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/pay_grade'; ?>" role="tab">Pay Grade</a></li>
                                <li role="presentation" class="<?php if ($cat_type == 'job_specification') echo $active_status = "active"; ?>"><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/job_specification'; ?>" role="tab">Job Specification</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <div class="row leaveLabel">
                                    <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">
                                        <ul class="vitals-links">
                                            <li class="pad-lt15px">
                                                <label><?php echo $tab_title; ?></label>
                                                <div class="form-group has-search-right mar-bt8 wdt_180">
                                                    <a id="search_btn" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                    <input type="text" id="filter_type" name="filter_type" class="form-control" value="<?php if ($filter_val != '') echo $filter_val; ?>" placeholder="Search">
                                                    <li><a href="<?php echo base_url() . 'index.php/master_pro/master/master_settings/' . $cat_type; ?>"><span class="vitals_clearSearch">Clear search</span></a></li>
                                                </div>

                                                <div class="col-xl-5 col-lg-5 col-md-12 col-12 text-right">
                                                    <label>&nbsp;</label>
                                                    <ul class="vitals-links">
                                                        <li>
                                                            <a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_add_edit_form/' . $cat_type; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a>
                                                        </li>
                                                        <li class="edit">
                                                            <a style="display:none" href="javascript:" id="edit_btn" class="master_aduser"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
                                                            <a href="javascript:" style="color:#6bc08a" id="dummy_edit_btn" class="master_aduser"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:" id="delete_btn" class="master_deluser" data-toggle="modal" data-target=""><span><i class="fas fa-trash-alt"></i></span> Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="table_configcontentnew pad-bt0">
                                    <div class="tabpanel-title">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                <h4>Pay Grade</h4>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                <ul class="milestone-links">
                                                    <li class="brd-left-onboard">
                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="add_contact"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                    </li>
                                                    <li class="brd-left-onboard">
                                                        <a href="javascript:void(0)" data-chk-attr='contact_checkbox' class="edit-btnconfig none-pointer opacity5 mar-tp15 delete_cls" data-toggle="modal" data-target="" id="delete_contact"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="hid_table_type">
                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                    <table class="table" id="contact_table" style="margin-top: 0">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="removeArrow"><input class="form-control" id="contact_checkbox" type="checkbox"></th>
                                                <th width="20%">Pay Grade</th>
                                                <th width="20%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
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
</body>

<script type="text/javascript">
    $(document).ready(function () {
        $('#contact_table').DataTable({
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
                "url": "<?php echo base_url(); ?>index.php/master_pro/master/ajax_load_datatable",
                "data": {
                    'funder_id': '<?php echo $funder_id; ?>'
                },
                "type": "POST"
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#grant_list tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var slug = $(":checkbox:eq(0)", this).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/funder/edit_grant_form/' + slug);
                        window.location = $(this).attr('href');
                        return false;
                    }
                });
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, -1]
                }],
            "order": [1, 'desc']
        });
        //$('.vital_windowScroll').css({'height': (($(window).height()) - 200) + 'px'});
        $("#display_lists").validate();
    });
    $('#search_btn').click(function () {
        var filter_val = $("#filter_type").val();
        var donor_filter_msid = $("#donor_filter_msid").val();
        var budget_filter_msid = $("#budget_filter_msid").val();
        var common_filter_val = '';
        var cat_type = '<?php echo $cat_type; ?>';

        if (cat_type != '' && cat_type == 'budget_head') {
            if (donor_filter_msid != '' && donor_filter_msid != undefined) {
                common_filter_val = '&donor_val=' + btoa(donor_filter_msid);
                window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/' . $cat_type . '?donor_val=' ?>' + btoa(donor_filter_msid);
            }
        }
        if (filter_val != '' && filter_val != undefined) {
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/' . $cat_type . '?filter_val=' ?>' + btoa(filter_val) + common_filter_val;
        }
    });

    $('.vital_bordered_btn').click(function () {
        window.location.reload();
    });

    $(".save_btn").click(function (e) {
        var master_val = $("#master_type").val();
        type = "alpha_special";
        manual_required('display_lists', type);
        check_ajax_master_data();
    });

    function check_ajax_master_data() {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master_pro/master/check_ajax_masterdata' ?>',
            cache: false,
            type: "POST",
            data: $("#display_lists").serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status > 0) {
                    for (const [key, value] of Object.entries(response.response)) {
                        $("#" + key).text(value);
                    }
                }
                if (response.status == 0) {
                    if (err_count == 0) {
                        //$("#display_lists").submit();
                    }
                }
            }
        });
    }

    $(document).on('input', 'textarea', function () {
        if (this.value.match(/[^a-zA-Z0-9_.,'"!$:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9_.,'"!$:\-&\/() ]/g, '');
        }
    });
</script>
<style>
    .master_deluser_mark {
        color: red !important;
    }
</style>

</html>