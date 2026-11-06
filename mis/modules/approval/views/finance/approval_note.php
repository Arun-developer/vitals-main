<?php
$master_menu = $this->uri->segment(3);
$page_list = $this->uri->segment(4);
if ($page_list == 'rolist') {
    $section = 'rolist';
    $page_title = 'approval_note';
    $page_heading = 'Approve as RO - ';
} else if ($page_list == 'phlist') {
    $section = 'phlist';
    $page_title = 'approval_note';
    $page_heading = 'Approve as PH - ';
} else {
    $section = 'mylist';
    $page_title = 'new_approval_note';
    $page_heading = 'My Approval Note - ';
}
$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'My Approval Note - ' . ucfirst($master_menu), 'page_table' => 'datatable'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => $page_title)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4><?php echo 'Approve'; ?></h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <li class="tab-slider--triggerform <?php if ($page_list == 'all_pending') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/finance/approval_note/all_pending'; ?>">Pending Notes <?php echo isset($an_rocount) && php72_cmp($an_rocount) != 0 ? '(' . $an_rocount . ')' : ''; ?></a></li>
                                <li class="tab-slider--triggerform <?php if ($page_list == 'all_approval') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/finance/approval_note/all_approval'; ?>">All Approvel Notes<?php echo isset($an_phcount) && php72_cmp($an_phcount) != 0 ? '(' . $an_phcount . ')' : ''; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-10 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Approval Number</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="approval_no" name="approval_no" class="form-control searchEnter" >
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Programme</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control" id="program_name" name="program_name">
                                                            <option value=''>--Select--</option>
                                                            <?php foreach ($program_list as $program) { ?>
                                                                <option value='<?= $program['programme_id']; ?>'><?= $program['programme']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id">
                                                    <label class="form-group" >Purpose</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                                        <input type="text" id="purpose" name="purpose"  class="form-control searchEnter" placeholder="Search">
                                                    </div>
                                                    <div id="author_err"></div>
                                                </li>

                                                <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                            </ul>
                                        </div>
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
                                                        <th width="10%">Date</th>
                                                        <th width="5%">Programme</th>
                                                        <th width="5%">Purpose</th>
                                                        <th width="5%">Status</th>
                                                        <th width="5%">Pending With</th>
                                                        <th width="5%"></th>
                                                        <!--
                                                                                                                <th width="10%">Approval Note Number</th>
                                                                                                                <th width="10%">Employee</th>
                                                                                                                <th width="5%">Date of seeking Approval</th>
                                                                                                                <th width="5%">To(RO)</th>
                                                                                                                <th width="5%">Pending With</th>
                                                                                                                <th width="5%">Purpose</th>
                                                                                                                <th width="5%">Programme</th>
                                                                                                                <th width="5%">Detail</th>
                                                                                                                <th width="5%">Status</th>
                                                                                                                <th width="5%">Action</th> -->
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

                                                    $('.searchEnter').keypress(function (e) {
                                                        if (e.which == 13) {
                                                            filter_check();
                                                        }
                                                    });
                                                    
                                                    $(document).ready(function () {
                                                        $(document).on('click', '.show_error_msg', function () {
                                                            $('#actionmodal').modal('show');
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
                                                        var purpose = $('#purpose').val();
                                                        var program_name = $('#program_name').val();

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
                "url": "<?php echo base_url(); ?>index.php/approval/finance/DTapproval_note",
                "type": "POST",
                "data": {
                    "approval_no": approval_no,
                    "purpose": purpose,
                    "program_name": program_name,
                    "section": '<?php echo $section; ?>',
                    "currentTab": '<?php echo $this->uri->segment(3); ?>'

                }
            },
            'columnDefs': [{
                'orderable': false,
                'targets': [1, 4, 6]
            }],
            "order": [2, 'desc'],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    // if (!$(e.target).is("input")) {
                    //     var edited_id = $(":checkbox:eq(0)", this).val();
                    //     var slug = $(this).closest('tr').find('td:eq(6) input').val();
                    //     //var slug = $('#master_edit_id_' + edited_id).val();
                    //     $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/approval/finance/approval_note_details/' + slug);
                    //     window.location = $(this).attr('href');
                    //     return false;
                    // }
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