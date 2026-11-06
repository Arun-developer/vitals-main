<?php
$page_list = $this->uri->segment(3);

if ($page_list == 'rolist') {
    $section = 'rolist';
    $page_heading = 'Approve As RO - Action History';
} else if ($page_list == 'phlist') {
    $section = 'phlist';
    $page_heading = 'Approve As PH - Action History';
} else {
    $section = 'mylist';
    $page_heading = 'All My Approval Notes - Action History';
}
$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => $page_heading, 'page_table' => 'datatable'));
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
                        <h4><?= $page_heading; ?></h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <?php if ($section == 'rolist' || $section == 'phlist') { ?>
                        <div>
                            <div class="tab-slider--navform">
                                <ul class="tab-slider--tabsform">
                                    <li class="tab-slider--triggerform <?php if ($section == 'rolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/pending/rolist'; ?>">Approve As RO</a></li>
                                    <li class="tab-slider--triggerform <?php if ($section == 'phlist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/pending/phlist'; ?>">Approve As PH</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div>
                            <div class="tab-slider--navform">
                                <ul class="tab-slider--tabsform">
                                    <li class="tab-slider--triggerform"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/all_pending'; ?>">My Pending Notes <?php echo isset($an_rocount) && php72_cmp($an_rocount) != 0 ? '(' . $an_rocount . ')' : ''; ?></a></li>
                                    <li class="tab-slider--triggerform active"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/confirmed'; ?>">All My Approval Notes</a></li>
                                    <?php if ($ph_Usercount == '1') { ?>
                                        <li class="tab-slider--triggerform"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/pending/phlist'; ?>">Approve As PH <?php echo isset($an_phcount) && php72_cmp($an_phcount) != 0 ? '(' . $an_phcount . ')' : ''; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/confirmed'; ?>">Confirmed Requests</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/cancelled'; ?>">Canceled Requests</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/defered'; ?>">Deferred Requests</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/closed'; ?>" >Closed Notes</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/draft'; ?>" >Draft Notes</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/archive'; ?>" >Archive</a></li>
                                    <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/approval/action_history'; ?>" >Action History</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Approval Note</th>
                                                        <th width="10%">From Emp</th>
                                                        <th width="5%">Assigned Emp</th>
                                                        <th width="5%">RO</th>
                                                        <th width="5%">Assigned Date</th>
                                                        <th width="5%">Internal Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
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
                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close" >Ok</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#from_date').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#to_date').datepicker('option', 'minDate', startDate);
            }
        });

        $('#to_date').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#from_date').datepicker('option', 'maxDate', startDate);
            }
        });

        $(document).on('click', '.show_error_msg', function () {
            $('#actionmodal').modal('show');
        });

        $(document).on('click', '.year_filter', function () {
            $('.year_filter').removeClass('active');
            $(this).addClass('active');
            var current_val = $(this).attr("data-attr");
            master_trigger(current_val);
        });

        $(document).on('click', '#cancel_request', function () {
            var request_id = $("#request_id").val();
            var ajax_url = "<?php echo base_url(); ?>index.php/book/ajax_book_request";

            if (request_id != '') {
                $('#actionmodal').modal('hide');
                $.ajax({
                    url: ajax_url,
                    type: "POST",
                    data: {"request_id": request_id},
                    dataType: "json",
                    cache: false,
                    success: function (res) {
                        location.reload();
                    }
                });
            }
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
        $('#purpose').val('');
        $('#approval_no').val('');
        $('#from_date').val('');
        $('#to_date').val('');
        $('#status').val('');
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

    function master_trigger(interval_date) {
        var approval_no = $('#approval_no').val();
        var purpose = $('#purpose').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var status = $('#status').val();

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
                "url": "<?php echo base_url(); ?>index.php/approval/DTarchive",
                "type": "POST",
                "data": {
                    "approval_no": approval_no,
                    "purpose": purpose,
                    "interval_date": interval_date,
                    "from_date": from_date,
                    "to_date": to_date,
                    "status": status,
                    "section": '<?php echo $section; ?>',
                    "currentTab": '<?php echo $this->uri->segment(3); ?>'
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [5]
                }],
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