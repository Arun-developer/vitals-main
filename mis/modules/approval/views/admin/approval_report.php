<?php
$master_menu = $this->uri->segment(4);
$section = $this->uri->segment(5);
$this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Approval Note - Reports', 'page_table' => 'datatable'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'approval_note')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Approval Note - Reports</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                    <li role="presentation"><a  href="<?php echo base_url() . 'index.php/approval/approvaladmin/approval_notes/pending'; ?>">Pending Notes</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/approval_notes/confirmed'; ?>">Confirmed Notes</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/approval_notes/cancelled'; ?>">Cancelled Notes</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/approval_notes/defered'; ?>">Deferred Notes</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/approval_notes/closed'; ?>" >Closed Notes</a></li>
                                    <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/approval_report'; ?>" >Report</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/archive'; ?>" >Archive</a></li>
                                    <!--<li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approvaladmin/action_history'; ?>" >Action History</a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">

                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/approval/approvaladmin/export_report'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-12 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Employee</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180" name="employee_id" id="employee_id">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($userList as $list) { ?>
                                                                <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group">Date From Month</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <select class="form-control wdt_180" name="month" id="month">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($monthArray as $key => $value) { ?>
                                                                <option value="<?= $key; ?>" <?php echo ($key == $month) ? ('selected') : (''); ?>>
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="author_err" ></div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group" >Date From Year</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <select class="form-control wdt_180" name="year" id="year">
                                                            <option value="">--Select--</option>
                                                            <?php for ($i = 2011; $i <= date('Y') + 10; $i++) { ?>
                                                                <option value="<?= $i; ?>" <?php echo ($i == $year) ? ('selected') : (''); ?>>
                                                                    <?= $i; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="author_err" ></div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group" >Date To Month</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <select class="form-control wdt_180" name="month1" id="month1">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($monthArray as $key => $value) { ?>
                                                                <option value="<?= $key; ?>" <?php echo ($key == $month) ? ('selected') : (''); ?>>
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="author_err" ></div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group" >Date To Year</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <select class="form-control wdt_180" name="year1" id="year1">
                                                            <option value="">--Select--</option>
                                                            <?php for ($i = 2011; $i <= date('Y') + 10; $i++) { ?>
                                                                <option value="<?= $i; ?>" <?php echo ($i == $year) ? ('selected') : (''); ?>>
                                                                    <?= $i; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="author_err" ></div>
                                                </li>
                                                <li><a href="javascript:" id="search_btn" class="vital_yellow_btn">Search</a></li>
                                                <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                <li><a id="export_summary" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export</a></li>
                                            </ul>
                                        </div>
                                        <div style="height:10px;"></div>
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                            <ul class="vitals-links"></ul>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Approval Note</th>
                                                        <th width="5%">Date</th>
                                                        <th width="5%">Amount (<?= $this->session->userdata('currency'); ?>)</th>
                                                        <th width="5%">Budget Head</th>
                                                        <th width="5%">Donor</th>
                                                        <th width="5%">Employee</th>
                                                        <th width="5%">Payment in favor of</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" name="delete_ids" id="delete_ids" />
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

<div class="modal" id="actionmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Internal note cannot be submitted at this time as the grant(Ford - 012019-062020) has been put on-hold/closed. Please check with the donor and finance teams.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Ok</a></button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    $(document).ready(function () {

        $(document).on('click', '#export_summary', function () {
            $("#filter_job").submit();
        });

        $(document).on('click', '#export', function () {
            var approval_no = $('#approval_no').val();
            var purpose = $('#purpose').val();
            var purpose = $('#purpose').val();
            var ajax_url = "<?php echo base_url(); ?>index.php/approval/approvaladmin/approval_notes";
            var section = '<?php echo $section; ?>';
            var currentTab = '<?php echo $this->uri->segment(4); ?>';

            $.ajax({
                url: ajax_url,
                type: "POST",
                data: {"approval_no": approval_no, "purpose": purpose, 'export': 'export', 'section': section, 'currentTab': currentTab},
                dataType: "json",
                cache: false,
                success: function (res) {}
            });
            return false;
        });

        $('#author').keypress(function (e) {
            if (e.which == 13) {
                filter_check();
                return false;
            }
        });

        master_trigger();
    });

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {
        $('#employee_id').val('');
        $('#month').val('');
        $('#year').val('');
        $('#month1').val('');
        $('#year1').val('');
        master_trigger();
    });

    function filter_check() {
        var filter_err = 0;
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');

        var master_id = $('#master_id').val();
        var book_name = $('#book_name').val();
        var author = $('#author').val();

        if (master_id == '') {
            filter_err = 1;
            $("#category_err").html('<label class="error" id="txt_error">Select category</label>');
        }
        if (filter_err > 0) {
            return false;
        } else {
            master_trigger();
        }
    }

    function master_trigger() {
        var employee_id = $('#employee_id').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var month1 = $('#month1').val();
        var year1 = $('#year1').val();

        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            },
            "bProcessing": true,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            //"ordering": true,
            "responsive": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 20,
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/approval/approvaladmin/DTapproval_report",
                "type": "POST",
                "data": {
                    "employee_id": employee_id,
                    "month": month,
                    "year": year,
                    "month1": month1,
                    "year1": year1,
                    "section": '<?php echo $section; ?>',
                    "currentTab": '<?php echo $this->uri->segment(4); ?>'

                }
            },
            'columnDefs': [{
                'orderable': false,
                'targets': [6]
            }],
            "order": [0, 'desc'],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table').on('click', '.action_cls', function (e) {

                });
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#master_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.master_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
            },
        });
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>