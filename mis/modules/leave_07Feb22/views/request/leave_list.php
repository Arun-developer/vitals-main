<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Leave - Leave Requests', 'page_table' => 'datatable', 'module' => 'leave_summary')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'leave', 'supervisor' => $chk_sup)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Leave Requests</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <?php
                                if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
                                    ?>
                                    <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>">New Leave Request</a></li>
                                <?php } ?>
                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>">Leave Allocation</a></li>
                                <?php
                                if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
                                    ?>
                                    <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>">Leave Requests</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <form method="post" name="filter_form" id="filter_form" >
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>Period</label>
                                                    <div class="position-relative">
                                                        <input class="form-control" type="text" name="filter_fromdate" id="filter_fromdate" placeholder=""  value="<?= isset($filter_fromdate) && $filter_fromdate != '' ? $filter_fromdate : '01-01-' . date('Y'); ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div class="position-relative">
                                                        <input class="form-control" type="text" name="filter_todate" id="filter_todate" placeholder="" value="<?= isset($filter_todate) && $filter_todate != '' ? $filter_todate : '31-12-' . date('Y'); ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>Show leave with status</label>
                                                    <select class="form-control" name="l_status[]" id="multiselect" multiple="multiple">
                                                        <option value="0" <?php
                                                        if ($l_status != '' && in_array(0, $l_status)) {
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

                                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                                <div style="height:15px"></div>
                                                <ul class="vitals-links">
                                                    <li><a  name="search_btn" id="search_btn" type="submit" class="vital_yellow_btn">Search</a></li>
                                                    <li><span class="vitals_clearSearch" name="reset_btn" id="reset_btn"  onclick="reset_form();">Clear search</span></li>
                                                </ul>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3 text-right">
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:void(0)" onclick="export_leavelist();" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/leave/leave_archieve'; ?>" class="master_aduser"><span><i class="far fa-file-alt"></i></span> Leave Archives</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <div class="table-responsive">
                                                <table class="table table-hover dt-responsive" id="leave_list_table">
                                                    <thead >
                                                        <tr>
                                                            <th width="15%">Date</th>
                                                            <th width="15%">Applied Date</th>
                                                            <th width="10%">Approval Date</th>
                                                            <th width="5%">No. of Days</th>
                                                            <th width="10%">Leave Type</th>
                                                            <th width="15%">Status</th>
                                                            <th width="10%">Comments</th>
                                                            <!-- <th width="20%">Actioned By</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="edited_leaves[]" id="edited_leaves" />
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 20px">
                                        <div class="col-12 col-sm-12  col-md-12">
                                            <div class="saveLinkView ">
                                                <ul class="vitals-links ">
                                                    <li><a href="javascript:void(0)" onclick="submit_approval();" class="wdt_100 vital_yellow_btn">Save</a></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
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
    table{
        table-layout: fixed;
        border-collapse: collapse;
        width: 100%;
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
    .vitalMasterDataTbl table.dataTable thead th{
        padding: .5rem .75rem !important;
    }
    .vitalMasterDataTbl table.dataTable tbody tr td, .vitalMasterDataTbl table.dataTable tbody tr:hover td{
        white-space: pre-wrap;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable', 'module' => 'leave_summary', 'multi_select' => 'multiselect')); ?>

<script>
    $(document).ready(function () {
        $('.tabpanel-details').css({'height': (($(window).height()) - 230) + 'px'});
        leave_list_trigger();
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $(".dataTables_scrollBody").mouseover(function () {
        $(this).css("overflow-y", "scroll");
    });

    $(".dataTables_scrollBody").mouseout(function () {
        $(this).css("overflow-y", "hidden");
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

        $('#leave_list_table').DataTable({
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
            scrollY: '280px',
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": false,
            fixedHeader: {
                header: true,
                headerOffset: 45,
            },
            // scrollY:'288px',
            "autowidth": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/leave/DTleavelist",
                "type": "POST",
                "data": {"from_date": filter_from, "to_date": filter_to, "filter_status": multiselect, "page": "leavelist"}
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            },
            'columnDefs': [
                {"width": "160px", "targets": 0},
                {"width": "80px", "targets": 1},
                {"width": "55px", "targets": 3},
                {"width": "80px", "targets": 2},
                {"width": "120px", "targets": 4},
                {"width": "110px", "targets": 5},
                {"width": "150px", "targets": 6},
                // {"width": "150px", "targets": 7},
                {
                    'orderable': false,
                    'targets': [0, 3, 4, 5, 6],
                },
                {
                    targets: [1, 2, 4, 5],
                    className: 'dt-body-center'
                },
                {
                    targets: [3],
                    className: 'dt-body-right'
                },
                {
                    targets: [0],
                    className: 'dt-head-center'
                }
            ],
            "order": [1, 'desc']
        });
    }

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
                    $('.toast').toast('show');
                    $('.deleteMsg').removeClass('display-hide');
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            });
        }
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
        // $(this).closest('form').find("input[type=text], select").val("");
        $('#filter_fromdate').val("<?php echo "01-01-" . date('Y'); ?>");
        $('#filter_todate').val("<?php echo "31-12-" . date('Y'); ?>");
        $('#multiselect').val('1,2');
        $('#filter_form').submit();
        // $("#filter_form").trigger("reset");
    });

    $('#filter_fromdate').datepicker({
        changeMonth: true,
        changeYear: true,
        // showButtonPanel: true,
        dateFormat: 'd-m-yy',
    });

    $('#filter_todate').datepicker({
        changeMonth: true,
        changeYear: true,
        // showButtonPanel: true,
        dateFormat: 'd-m-yy',
    });

    function export_leavelist() {
        var filter_from = $('#filter_fromdate').val();
        var filter_to = $('#filter_todate').val();
        var multiselect = $('#multiselect').val().join('_');

        var url = "<?php echo base_url(); ?>index.php/leave/leave_export/" + filter_from + '/' + filter_to + '/' + multiselect;
        window.location.href = url;
    }

</script>

</body>
</html>