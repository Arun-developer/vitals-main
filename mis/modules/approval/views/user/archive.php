<?php
$page_list = $this->uri->segment(3);
if ($page_list == 'rolist') {
    $section = 'rolist';
    $page_heading = 'Approve As RO - Archive';
} else if ($page_list == 'phlist') {
    $page_title = 'approval_note';
    $page_heading = 'Approve As PH - Archive';
} else {
    $section = 'mylist';
    $page_heading = 'All My Approval Notes - Archive';
}
$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => $page_heading, 'page_table' => 'datatable'));



$finance_status = '';
$sess_empid = $this->session->userdata('emp_number');
$finance_user_count = financeuser_count($sess_empid);
$fin_user = 0;
if ($finance_user_count == 1) {
	$fin_user = 1;
}

if($this->uri->segment(1) =='approval' && $fin_user == 1 && $this->uri->segment(2)=='archive' && $this->uri->segment(3)=='1'){
	$finance_status = 'active';
	$page_heading = 'Approval Notes - Archive';
}

?>
<style>
    .multiselect-container li.active a {
        background-color: #ffffff;
    }
    .multiselect-container.dropdown-menu>.active>a, .multiselect-container.dropdown-menu>.active>a:focus, .multiselect-container.dropdown-menu>.active>a:hover {
        background-color: #ffffff;
    }
    .multiselect-container li.active a label.checkbox {
        width: 178px;
        background: #ffffff;
    }
</style>
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
                    <?php if($finance_status ==''){ ?>
                        <?php if ($section == 'rolist' || $section == 'phlist') { ?>
                            <div>
                                <div class="tab-slider--navform">
                                    <ul class="tab-slider--tabsform">
                                        <li class="tab-slider--triggerform <?php if ($section == 'rolist') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/pending/rolist'; ?>">Approve As RO</a></li>
                                        <li class="tab-slider--triggerform <?php if ($section == 'phlist') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/pending/phlist'; ?>">Approve As PH</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div>
                                <div class="tab-slider--navform">
                                    <ul class="tab-slider--tabsform">
                                        <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_pending'; ?>">My Pending Notes <?php echo isset($an_rocount) && $an_rocount != 0 ? '(' . $an_rocount . ')' : ''; ?></a></li>
                                        <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/confirmed'; ?>">All My Approval Notes</a></li>
                                        <?php if ($ph_Usercount == '1') { ?>
                                            <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/approval/approval_note/pending/phlist'; ?>">Approve As PH <?php echo isset($an_phcount) && $an_phcount != 0 ? '(' . $an_phcount . ')' : ''; ?></a></li>
                                        <?php } ?>
                                        <?php if ($ceo_status != '') { ?>
                                            <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_pending/ceolist'; ?>">Approve As CEO <?php echo isset($pending_ceo_count) && $pending_ceo_count != 0 ? '(' . $pending_ceo_count . ')' : ''; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="display-hide" id="navLoad">
                            <div class="newCLickTabs">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/confirmed'; ?>">Confirmed Notes</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/cancelled'; ?>">Cancelled Notes</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/defered'; ?>">Deferred Notes</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/closed'; ?>">Closed Notes</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/draft'; ?>">Draft Notes</a></li>
                                        <?php if($fin_user ==0){ ?>
                                          <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/approval/archive'; ?>">Archive</a></li>
                                          <!--<li role="presentation"><a href="<?php echo base_url() . 'index.php/approval/action_history'; ?>" >Action History</a></li>-->
                                      <?php } ?>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  <?php }else{ ?>


                  <?php } ?>
                  <div id="navLoad">
                        <!--<div class="newCLickTabs">
                            <div>

                                <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">

                        <?php foreach ($financialList as $lists) { ?>
                                                        <li role="presentation" class="year_filter" data-attr="<?php echo $lists['from'] . '-' . $lists['to']; ?>" ><a href='javascript:void(0)'  > <?php echo $lists['from'] . '-' . $lists['to']; ?></a></li>
                        <?php } ?>

                                </ul>

                            </div>
                        </div>-->
                    </div>

                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/approval/export_an_archive'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-10 col-lg-10 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Financial Year</label>
                                                    <div class="form-group mar-bt8  wdt_200">
                                                        <select name="interval_date" class="form-control wdt_200 year_filter">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($financialList as $lists) { ?>
                                                                <option value="<?php echo $lists['from'] . '-' . $lists['to']; ?>"><?php echo $lists['from'] . '-' . $lists['to']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="category_err"></div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Approval Number</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="approval_no" name="approval_no" class="form-control searchEnter">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id">
                                                    <label class="form-group">Purpose</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <input type="text" id="purpose" name="purpose" class="form-control searchEnter" placeholder="Search">
                                                    </div>
                                                    <div id="author_err"></div>
                                                </li>

                                                <li class="mob_fulfill" id="message_id">
                                                    <label class="form-group">From Date</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <input type="text" id="from_date" name="from_date" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="author_err"></div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id">
                                                    <label class="form-group">To Date</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <input type="text" id="to_date" name="to_date" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="author_err"></div>
                                                </li>

                                                <?php if($fin_user ==1){ ?>
                                                 <li class="mob_fulfill" id="message_id">
                                                  <label class="form-group">Type</label>
                                                  <div class="form-group has-search-right mar-bt8 wdt_180">
                                                   <select name="approval_note_type" id="approval_note_type" class="form-control wdt_200">
                                                    <option value="">--Select--</option>
                                                    <option value="0" selected>All Approval Notes</option>
                                                    <option value="1">My Approval Notes</option>
                                                </select>
                                            </div>
                                            <div id="author_err"></div>
                                        </li>
                                    <?php } ?>


                                    <li class="mob_fulfill lineHT" id="message_id">
                                        <label class="form-group">Status</label>
                                        <div class="form-group has-search-right mar-bt8 wdt_180">
                                            <select  name="status[]" class="form-control wdt_180 employeeInput select-ajax edit_cls" id="multiselect"  multiple="multiple">
                                                <option value="pending">Pending</option>
                                                <option value="confirmed">Confirmed</option>
                                                <option value="defered">Defered</option>
                                                <option value="closed">Closed</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                        <div id="author_err"></div>
                                    </li>

                                    <li><a name="search_btn" id="search_btn" type="submit" class="vital_yellow_btn">Search</a></li>
                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                    <li><a id="export_summary" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export</a></li>
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
                                            <th width="5%">Employee</th>
                                            <th width="10%">Date</th>
                                            <!-- <th width="5%">To(RO)</th> -->
                                            <th width="5%">Programme</th>
                                            <th width="5%">Purpose</th>                                     
                                            <!-- <th width="5%">Detail</th> -->
                                            <th width="5%">Status</th>                                      
                                            <th width="5%">Action</th>
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
                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">Ok</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect','page_name' => 'datatable')); ?>

<script type="text/javascript">
    $('.searchEnter').keypress(function (e) {
        if (e.which == 13) {
            filter_check();
        }
    });

    $(document).ready(function () {
       $('#multiselect, #accessibleTo').multiselect({
        buttonWidth: '100%',
        includeSelectAllOption: true,
        nonSelectedText: 'Select an Option'
    });

       var fy_val = $('.year_filter option').eq(1).val();
       $('.year_filter').val(fy_val);
       master_trigger(fy_val);

       $(document).on('click', '#export_summary', function() {
        $("#filter_job").submit();
    });


       $('#from_date').datepicker({
        dateFormat: "dd-mm-yy",
        onSelect: function(startDate) {
            $('#to_date').datepicker('option', 'minDate', startDate);
        }
    });

       $('#to_date').datepicker({
        dateFormat: "dd-mm-yy",
        onSelect: function(startDate) {
            $('#from_date').datepicker('option', 'maxDate', startDate);
        }
    });

       $(document).on('click', '.show_error_msg', function() {
        $('#actionmodal').modal('show');
    });

       $(document).on('change', '.year_filter', function() {
        var current_val = $(this).val();
        master_trigger(current_val);
    });

       $(document).on('click', '#cancel_request', function() {
        var request_id = $("#request_id").val();
        var ajax_url = "<?php echo base_url(); ?>index.php/book/ajax_book_request";

        if (request_id != '') {

            $('#actionmodal').modal('hide');
            $.ajax({
                url: ajax_url,
                type: "POST",
                data: {
                    "request_id": request_id
                },
                dataType: "json",
                cache: false,
                success: function(res) {
                    location.reload();
                }
            });

        }
        return false;
    });

       $('#author').keypress(function(e) {
        if (e.which == 13) {
            filter_check();
            return false;
        }
    });
   });

    $(document).on('click', '#search_btn', function() {
        var fy_val = $('.year_filter option').eq(1).val();
        $('.year_filter').val(fy_val);
        filter_check(fy_val);
    });

    $(document).on('click', '#reset_search', function() {
        $('#purpose').val('');
        $('#approval_no').val('');
        $('#from_date').val('');
        $('#to_date').val('');
        $('#status').val('');
        $('#approval_note_type').val('');
        $('#multiselect').multiselect('deselectAll', false);
        $('.multiselect-selected-text').text('Select an Option');
        
        var fy_val = $('.year_filter option').eq(1).val();
        $('.year_filter').val(fy_val);
        master_trigger(fy_val);
    });

    function filter_check(fy_val) {
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
            master_trigger(fy_val);
        }
    }

    function master_trigger(interval_date) {
        var approval_no = $('#approval_no').val();
        var purpose = $('#purpose').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var status = $('#multiselect').val();
        var approval_note_type = $('#approval_note_type').val();
        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function(settings, json) {
                $('.dataTables_scrollBody thead tr').css({
                    visibility: 'collapse'
                });
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
                    "approval_note_type": approval_note_type,
                    "section": '<?php echo $section; ?>',
                    "currentTab": '<?php echo $this->uri->segment(3); ?>'

                }
            },
            'columnDefs': [{
                'orderable': false,
                'targets': [6]
            }],
            "order": [0, 'desc'],
            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table').on('click', '.action_cls', function(e) {

                });
            },
            drawCallback: function(settings) {
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

    $(document).on('input', '.commonAlphaNum', function() {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });
</script>

</body>

</html>