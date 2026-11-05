<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Leave - Approve Leave', 'page_table' => 'datatable', 'module' => 'leave_summary')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'approve_leave', 'supervisor' => $chk_sup, 'approval_count' => $approval_count, 'an_approval_count' => $an_approval_count)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Approve Leave</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <form method="post" name="filter_form" id="filter_form" >
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-2 col-md-2 padhr10">
                                                <div class="form-group">
                                                    <label>Period</label>
                                                    <div class="position-relative">
                                                        <input class="form-control" type="text" name="filter_fromdate" id="filter_fromdate" placeholder=""  value="<?= isset($filter_fromdate) ? $filter_fromdate : ''; ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2 col-md-2 padhr10">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div class="position-relative">
                                                        <input class="form-control" type="text" name="filter_todate" id="filter_todate" placeholder=""  value="<?= isset($filter_todate) ? $filter_todate : ''; ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-2 padhr10">
                                                <div class="form-group">
                                                    <label>Show leave with status</label>
                                                    <select class="form-control" name="l_status[]" id="multiselect" multiple="multiple">
                                                        <option value="0" <?php
                                                        if (in_array(0, $l_status)) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Pending Approval</option>
                                                        <option value="1" <?php
                                                        if ($l_status != '' && (in_array(1, $l_status) || in_array(2, $l_status))) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Approved </option>
                                                        <option value="4" <?php
                                                        if ($l_status != '' && (in_array(4, $l_status) || in_array(3, $l_status))) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Cancelled </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                <div class="col-12 col-sm-2 col-md-2 padhr10">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <div class="position-relative">
                                                            <select class="form-control" name="filter_partner" id="filter_partner" >
                                                                <option value="">--Select Partner Type</option>
                                                                <?php
                                                                foreach ($partner_types as $list) {
                                                                    if ($list['id'] == $filter_partner) {
                                                                        $selected = 'selected';
                                                                    } else {
                                                                        $selected = '';
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $list['id'] ?>" <?= $selected; ?>><?= $list['partner_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 padhr10">
                                                <div style="height:20px"></div>
                                                <ul class="vitals-links">
                                                    <li><a name="search_btn" id="search_btn" type="submit" class="vital_yellow_btn mar0">Search</a></li>
                                                    <li><span class="vitals_clearSearch" name="reset_btn" id="reset_btn"  onclick="reset_form();">Clear search</span></li>
                                                </ul>
                                            </div>
                                            <div class="col-12 col-md-12  col-lg-1 col-xl-1 text-right pad0">
                                                <div style="height:15px"></div>
                                                <ul class="vitals-links">
                                                    <li class="app_export pad0"><a href="javascript:void(0)" onclick="export_leavelist();" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                </ul>
                                                <div style="height: 10px;"></div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="approve_leave_list_table">
                                                <thead>
                                                    <tr>
                                                        <!-- <th></th> -->
                                                        <th width="20%">Date</th>
                                                        <th width="10%">Applied Date</th>
                                                        <th width="10%">Approved Date</th>
                                                        <th width="15%">Employee Name</th>
                                                        <?php
                                                        if ($this->session->userdata['user_type'] == 'superadmin') {
                                                            ?>
                                                            <th width="10%">Partner Name</th>
                                                        <?php } ?>
                                                        <th width="5%">No. of Days</th>
                                                        <th width="10%">Leave Type</th>
                                                        <th width="10%">Status</th>
                                                        <th width="10%">Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <input type="hidden" name="edited_leaves[]" id="edited_leaves" />
                                        </div>
                                    </div>
                                    <?php if ($this->session->userdata('user_type') == 'superadmin' || $approval_count > 0) { ?>
                                        <div style="height:20px"></div>
                                        <div class="row justify-content-end">
                                            <div class="col-12 col-sm-12  col-md-12">
                                                <div class="saveLinkView ">
                                                    <ul class="vitals-links ">
                                                        <li><a href="javascript:void(0)" onclick="submit_approval();" class="wdt_100 vital_yellow_btn">Save</a></li>
                                                        <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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

<style type="text/css">
    table.dataTable thead .sorting_desc:after {
        position: absolute;
        top: 10px;
        right: -3px;
        display: block;
        font-family: 'Glyphicons Halflings';
        opacity: 0.5;
    }
    table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting:after{
        top: 10px;
        right: 0px;
    }
    ul.multiselect-container.dropdown-menu.show {
        min-width: 145px;
    }
    .tab-slider--body {
        margin-bottom: 0px;
    }
    .inputplan-structureall {
        padding: 15px 20px 0px;
    }
    .vital_bordered_btn,.vital_yellow_btn{
        margin: 0px 3px;
    }
    table.dataTable{
        margin-top: 0 !important;
    }
    table.dataTable tbody td,.vitalMasterDataTbl table.dataTable thead th{
        padding: .5rem .75rem !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable', 'module' => 'leave_summary', 'multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        leave_list_trigger();
    });

    jQuery(document).ready(function ($) {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });

    });

    $(document).ready(function () {
        $('#multiselect, #accessibleTo').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    $(document).on('click', '#search_btn', function () {
        $('#filter_form').submit();
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    function leave_list_trigger() {
        var filter_from = $('#filter_fromdate').val();
        var filter_to = $('#filter_todate').val();
        var multiselect = $('#multiselect').val();
        var partner_search = $('#filter_partner').val();

        $('#approve_leave_list_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            },
            "bProcessing": true,
            "bServerSide": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 20,
//            scrollY: '258px',
"autowidth": true,
"lengthChange": false,
"stateSave": false,
"ajax": {
    "url": "<?php echo base_url(); ?>index.php/leave/DTApproveleavelist",
    "type": "POST",
    "data": {"from_date": filter_from, "to_date": filter_to, "filter_status": multiselect, "partner_search": partner_search, "page": "approval"}
},
drawCallback: function (settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);

    var table = $('#approve_leave_list_table').dataTable();
    var data_len = table.fnGetData().length;
    if (data_len == 0) {
        $('.saveLinkView').addClass('display-hide');
        $('.app_export').addClass('display-hide');
    }
},
columnDefs: [
{"width": "160px", "targets": 0},
{"width": "80px", "targets": 1},
{"width": "55px", "targets": 3},
{"width": "80px", "targets": 2},
{"width": "120px", "targets": 4},
{"width": "110px", "targets": 5},
{"width": "150px", "targets": 6},
{"width": "150px", "targets": 7},
{
    targets: [1, 2, 3],
    className: 'dt-body-center'
},
{
    targets: [0],
    className: 'dt-head-center'
}],
"order": [1, 'desc']
});
    }

    function getSelectedValues() {
        var selectedVal = $("#multiselect, #accessibleTo").val();
        for (var i = 0; i < selectedVal.length; i++) {
            if (window.CP.shouldStopExecution(0))
                break;

            function innerFunc(i) {
                setTimeout(function () {
                    location.href = selectedVal[i];
                }, i * 2000);
            }
            innerFunc(i);
        }
        window.CP.exitedLoop(0);
    }

    $("#reset_btn").click(function () {
        $('#filter_fromdate').val("<?php echo "01-01-" . date('Y'); ?>");
        $('#filter_todate').val("<?php echo "31-12-" . date('Y'); ?>");
        $('#multiselect').val(0);
        $('#filter_partner').val('');
        $('#filter_form').submit();
        // $(this).closest('form').find("input[type=text], select").val("");
        // $("#filter_form").trigger("reset");
    });

//    $('#filter_fromdate').datepicker({
//        changeMonth: true,
//        changeYear: true,
//        // showButtonPanel: true,
//        dateFormat: 'd-m-yy',
//    });

//    $('#filter_todate').datepicker({
//        changeMonth: true,
//        changeYear: true,
//        // showButtonPanel: true,
//        dateFormat: 'd-m-yy',
//    });

$("#filter_fromdate").datepicker({
    changeMonth: true,
    changeYear: true,
    onSelect: function (selected) {
        $("#filter_fromdate").datepicker("option", "dateFormat", 'mm/dd/yy');
        $("#filter_todate").val('');
        var dt = new Date(selected);
        var dateval = dt.getDate();
        var monthval = dt.getMonth() + 1;
        var yearval = dt.getFullYear();
        if (monthval < 10) {
            monthval = "0" + monthval;
        } else {
            monthval = monthval;
        }
        if (dateval < 10) {
            dateval = "0" + dateval;
        } else {
            dateval = dateval;
        }
        var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
        $("#filter_fromdate").val(fulldatevalue);
        dt.setDate(dt.getDate() + 1);
        $("#filter_todate").datepicker("option", {
            minDate: dt
        });
    }
});

$("#filter_todate").datepicker({
    changeMonth: true,
    changeYear: true,
    onSelect: function (selected) {
        var dt = new Date(selected);
        var dateval = dt.getDate();
        var monthval = dt.getMonth() + 1;
        var yearval = dt.getFullYear();
        if (monthval < 10) {
            monthval = "0" + monthval;
        } else {
            monthval = monthval;
        }
        if (dateval < 10) {
            dateval = "0" + dateval;
        } else {
            dateval = dateval;
        }
        var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
        $("#filter_todate").val(fulldatevalue);
        dt.setDate(dt.getDate() - 1);
    }
});

function save_approval(leave_id) {
    var leave_arr = $('#edited_leaves').val();
    var arr = leave_arr.split(',');

// arr.push(leave_id);
// for(var i=0; i<arr.length; i++){
//     if(leave_id.indexOf(arr[i]) == -1){
//         larr.push(arr[i]);
//     }
// }
var idx = leave_arr.indexOf(leave_id);
if (idx === -1) {
    arr.push(leave_id)
    arr.join(',')
    $('#edited_leaves').val(arr);
}
}

function submit_approval() {
    var larr = [];
    var leave_arr = $('#edited_leaves').val();
    var arr = leave_arr.split(',');
    for (var i = 0; i < arr.length; i++) {
        if (larr.indexOf(arr[i]) == -1) {
            larr.push(arr[i]);
        }
    }

    for (var j = 0; j < larr.length; j++) {
        var status = $('#approve_status_' + larr[j]).val();
        var comments = $('#approve_comments_' + larr[j]).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/leave/leavereq_approve",
            data: {
                status: status,
                comments: comments,
                leave_id: larr[j],
            },
            dataType: 'json',
            success: function (msg) {
                    // $('.toast').toast('show');
                    $('.deleteMsg').removeClass('display-hide');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                    // var url = "<?php echo base_url(); ?>index.php/leave/approve_leave_list/success";
                    // window.location.href = url;
                }
            });
    }
}

function export_leavelist() {
    var filter_from = $('#filter_fromdate').val();
    var filter_to = $('#filter_todate').val();
    var multiselect = $('#multiselect').val().join('_');
    var url = "<?php echo base_url(); ?>index.php/leave/leave_export/" + filter_from + '/' + filter_to + '/' + multiselect + '/approve';
    window.location.href = url;
}

</script>

</body>
</html>