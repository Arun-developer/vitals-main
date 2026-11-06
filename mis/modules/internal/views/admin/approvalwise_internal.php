<?php
$type = $this->uri->segment(3);
$section = $this->uri->segment(4);
$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'My Internal Note - ' . ucfirst($type), 'page_table' => 'datatable'));

$main_menu = false;
if ($type == 'confirmed' || $type == 'cancelled' || $type == 'defered') {
    $main_menu = true;
}
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'internal_note')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>My Internal Note - <?= ucfirst($type); ?></h4>
                    </div>
                </div>
                <div>
                    <div class="tab-slider--navform">
                        <ul class="tab-slider--tabsform">
                            href="<?php echo base_url() . 'index.php/internal/internal_notes/cancelled'; ?>"
                            <li class="tab-slider--triggerform <?php if ($type == 'pending' && $section != 'rolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/internal/internal_notes/pending'; ?>">My Pending Notes <?php echo isset($an_rocount) && php72_cmp($an_rocount) != 0 ? '(' . $an_rocount . ')' : ''; ?></a></li>
                            <?php //if ($ro_Usercount == '1') { ?>
                                <li class="tab-slider--triggerform <?php if ($section == 'rolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/internal/internal_notes/pending/rolist'; ?>">Approve as Ro <?php echo isset($an_phcount) && php72_cmp($an_phcount) != 0 ? '(' . $an_phcount . ')' : ''; ?></a></li>
                                <?php //} ?>
                                <li class="tab-slider--triggerform <?php if ($main_menu == true) echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/internal/internal_notes/confirmed'; ?>">All Approval Notes<?php echo isset($an_phcount) && php72_cmp($an_phcount) != 0 ? '(' . $an_phcount . ')' : ''; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="plan-structure-vital vital_windowScroll">
                        <?php if ($main_menu == true) { ?>
                            <div class="display-hide" id="navLoad">
                                <div class="newCLickTabs">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                            <li role="presentation" class="<?php if ($type == 'confirmed') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/internal/internal_notes/confirmed'; ?>">Confirmed Requests</a></li>
                                            <li role="presentation" class="<?php if ($type == 'cancelled') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/internal/internal_notes/cancelled'; ?>">Cancelled Requests</a></li>
                                            <li role="presentation" class="<?php if ($type == 'deferred') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/internal/internal_notes/deferred'; ?>">Deferred Requests</a></li>
                                            <li role="presentation" class="<?php if ($type == 'archive') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/internal/archive'; ?>">Archive</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="tab-slider--container tab-content">
                            <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                            <div class="col-xl-12 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                                <ul class="vitals-links leaveLabel">
                                                    <li class="mob_fulfill">
                                                        <label class="form-group" >Approval Note</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="approval_no"  name="approval_no" class="form-control" >
                                                        </div>
                                                    </li>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group" >Internal Note</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="internal_no"  name="internal_no" class="form-control" >
                                                        </div>
                                                    </li>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group" >Payment in favor of</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="reason"  name="reason" class="form-control" >
                                                        </div>
                                                    </li>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group" >Reason for which payment is sought</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="reason1"  name="reason1" class="form-control" >
                                                        </div>
                                                    </li>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group" >Payment Status</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select class="form-control wdt_180" name="finance_status" id="finance_status">
                                                                <option value="">--Select--</option>
                                                                <option value="confirmed">Confirmed</option>
                                                                <option value="cancelled">Cancelled</option>
                                                                <option value="inprogress">InProgress</option>
                                                            </select>
                                                        </div>
                                                    </li>

                                                    <?php if ($section == 'rolist') { ?>
                                                        <li class="mob_fulfill">
                                                            <label class="form-group">Status</label>
                                                            <div class="form-group mar-bt8  wdt_180">
                                                                <select class="form-control" id="status_type" name="status_type">
                                                                    <?php
                                                                    $status_list = array(
                                                                        'pending' => 'Pending', 'confirmed' => 'Confirmed',
                                                                        'cancelled' => 'Cancelled', 'defered' => 'Defered',
                                                                        'closed' => 'Closed', 'draft' => 'Draft'
                                                                    );
                                                                    ?>
                                                                    <?php foreach ($status_list as $key => $val) { ?>
                                                                        <option value='<?php echo $key; ?>'><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </li>
                                                    <?php } ?>


                                                    <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                </ul>
                                            </div>
                                            <div style="height:10px;"></div>
                                        <!--- <div class="row">
                                                <div class="col-12 text-right">
                                                        <ul class="vitals-links">
                                                                <li>
                                                                        <a  href='javascript:void(0)' id="export"  class="master_aduser"><span><i class="fas fa-download"></i></span>Export</a>
                                                                </li>
                                                        </ul>
                                                </div>
                                            </div>-->
                                            <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                                <ul class="vitals-links"></ul>
                                            </div>
                                        </form>

                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">Internal Note</th>
                                                            <th width="10%">Approval Note</th>
                                                            <th width="10%">Date</th>
                                                            <th width="10%">From</th>
                                                            <th width="5%">Subject</th>
                                                            <th width="5%">Payment in favor of</th>
                                                            <th width="5%">Pending With</th>
                                                            <th width="5%">Amount to Approve (<?= $this->session->userdata['currency']; ?>)</th>
                                                            <th width="5%">Programe</th>
                                                            <th width="5%">Donor - Grant</th>
                                                            <th width="5%">Budget Head</th>
                                                            <th width="5%">Line Item</th>
                                                            <th width="5%">Detail</th>
                                                            <th width="5%">Status</th>
                                                            <th width="5%">Action</th>
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
        $('#purpose').val('');
        $('#approval_no').val('');
        $('#status_type').val('');
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
        var approval_no = $('#approval_no').val();
        var internal_no = $('#internal_no').val();
        var reason = $('#reason').val();
        var status_type = $('#status_type').val();
        var reason1 = $('#reason1').val();
        var finance_status = $('#finance_status').val();

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
                "url": "<?php echo base_url(); ?>index.php/internal/DTinternal_note",
                "type": "POST",
                "data": {
                    "approval_no": approval_no,
                    "internal_no": internal_no,
                    "reason": reason,
                    "reason1": reason1,
                    "finance_status": finance_status,
                    "status_type": status_type,
                    "section": '<?php echo $section; ?>',
                    "currentTab": '<?php echo $this->uri->segment(3); ?>'
                }
            },
            'columnDefs': [{
                'orderable': false,
                'targets': [13, 14]
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