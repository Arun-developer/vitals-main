<?php $this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Travel & Accommodation', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'travellist')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Travel & Accommodation</h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <?php $type = $this->uri->segment(3); ?>
                                <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                    <li role="presentation" class="<?php if ($type == 'pending') echo"active"; ?>"><a  href="<?php echo base_url() . 'index.php/traveladmin/requestlist/pending' ?>">Pending Requests</a></li>
                                    <li role="presentation" class="<?php if ($type == 'confirmed') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/requestlist/confirmed' ?>">Confirmed Requests</a></li>
                                    <li role="presentation" class="<?php if ($type == 'cancelled') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/requestlist/cancelled' ?>">Cancelled Requests</a></li>
                                    <li role="presentation" class="<?php if ($type == '') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/report' ?>">Report</a></li>
                                    <li role="presentation" class="<?php if ($type == 'employee') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/report/employee' ?>">Employee wise Report</a></li>
                                    <li role="presentation" class="<?php if ($type == 'costcentre') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/report/costcentre' ?>">Cost centre wise Report</a></li>
                                    <li role="presentation" class="<?php if ($type == 'all') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/requestlist/all' ?>" >All Pending Requests</a></li>
                                    <li role="presentation" class="<?php if ($type == 'archive') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/traveladmin/archive' ?>" >Archive</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" >
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Employee</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180" name="employee_id" id="employee_id">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($userList as $rowsuser) { ?>
                                                                <option value="<?= $rowsuser['id'] ?>" <?php echo ($employee_id == $rowsuser['id']) ? ('selected') : (''); ?>>
                                                                    <?= $rowsuser['user_name'] ?>
                                                                </option>
                                                            <?php } ?>
                                                            <option value="0" <?php echo ($employee_id == '0') ? ('selected') : (''); ?>>Others</option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Request Date From Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_from"  name="date_from" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Request Date To Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_to"  name="date_to" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group" >Request No</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                                        <input type="text" id="travel_request_id"  name="travel_request_id" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="author_err" ></div>
                                                </li>
                                                <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                            </ul>

                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                            <ul class="vitals-links">


                                            </ul>
                                        </div>
                                    </form>
                                    <?php /* ?>
                                      <div class="row">
                                      <div class="col-12 col-md-12 text-right">
                                      <ul class="vitals-links" style="margin-top: -35px; ">
                                      <li><a class="master_aduser" id="export"><span><i class="fas fa-download"></i></span> Export</a></li>
                                      </ul>
                                      </div>
                                      </div>
                                      <?php */ ?>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Request No</th>
                                                        <th width="10%">Employee</th>
                                                        <th width="10%">Date of Request</th>
                                                        <th width="5%">Donor</th>
                                                        <th width="5%">Budget Head</th>
                                                        <th width="5%">Sub-line Item</th>
                                                        <th width="5%">Journey Type</th>
                                                        <th width="5%">Reporting Authority</th>
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
                            <h4>Custom Export</h4>
                        </div>
                        <table style="border-bottom: 1px solid #ffffff;" width="400" cellspacing="5" cellpadding="5">
                            <tr>
                                <td style="border-bottom: 1px solid #ffffff;"><label>Report Name : </label></td>
                                <td style="border-bottom: 1px solid #ffffff;">
                                    <select class="form-control vendor_<?php echo $ticket_count; ?>" name="vendor" >
                                        <option value="">Select</option>
                                        <?php foreach ($vendorList as $rows) { ?>
                                            <option value="<?= $rows['vendor_id'] ?>" <?php echo ($row_jur['vendor'] == $rows['vendor_id']) ? ('selected') : (''); ?>>
                                                <?= $rows['vendor_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div id="vendor_<?php echo $ticket_count; ?>_err" ></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="cancel_request">Export</button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#export', function () {
            $("#actionmodal").modal('show');
        });

        $('#date_from').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#date_to').datepicker('option', 'minDate', startDate);
            }
        });

        $('#date_to').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#date_from').datepicker('option', 'maxDate', startDate);
            }
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

        //$('#actionmodal').modal('show');
        $('#author').keypress(function (e) {
            if (e.which == 13) {
                filter_check();
                return false;
            }
        });

        // $('.nav-tabs').scrollingTabs({
        //     enableSwiping: true
        // }).on('ready.scrtabs', function () {
        //     $('.tab-content').show();
        // });
        master_trigger();
    });

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');
        $('#travel_request_id').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#employee_id').val('');
        master_trigger();
    });

    function filter_check() {
        filter_err = 0;
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
        /* if(book_name ==''){
         filter_err = 1;
         $("#book_name_err").html('<label class="error" id="txt_error">Enter book</label>');
         }
         if(author ==''){
         filter_err = 1;
         $("#author_err").html('<label class="error" id="txt_error">Enter author</label>');
         }
         */
        if (filter_err > 0) {
            return false;
        } else {
            master_trigger();
        }
    }

    function master_trigger() {

        var travel_request_id = $('#travel_request_id').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var employee_id = $('#employee_id').val();

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
            // "ordering": true,
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
                "url": "<?php echo base_url(); ?>index.php/traveladmin/DTrequest_list",
                "type": "POST",
                "data": {
                    "travel_request_id": travel_request_id,
                    "request1": date_from,
                    "request2": date_to,
                    "employee_id": employee_id,
                    "currentTab": '<?php echo $this->uri->segment(3); ?>'
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [2, 3, 4, 8]
                }],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table').on('click', '.action_cls', function (e) {
                    if (!$(e.target).is("input")) {
                        var id = $(this).attr('data-attr');
                        if (id != '') {
                            $('#actionmodal').modal('show');
                            $('#request_id').val(id);
                        }
                        return false;
                    }
                    return false;
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