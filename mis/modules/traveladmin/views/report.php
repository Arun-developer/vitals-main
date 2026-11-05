<?php

$this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Travel & Accommodation', 'page_table' => 'datatable')); ?>
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
                        <div class="newCLickTabs pTReportsTab">
                            <div>
                                <?php 
									$type = $this->uri->segment(3);
								?>
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
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
												<?php if($type =='employee'){?>
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
												<?php } ?>
												<?php if($type =='costcentre'){?>
													<li class="mob_fulfill">
														<label class="form-group">Cost Center</label>
														<div class="form-group mar-bt8  wdt_180">
															<select class="form-control wdt_180" name="cost_centre" id="cost_centre">
																<option value="">Select</option>
																<?php foreach ($costCentreList as $rows) { ?>
																	<option value="<?= $rows['master_id'] ?>" <?php echo ($cost_centre == $rows['master_id']) ? ('selected') : (''); ?>>
																		<?= $rows['master_name'] ?>
																	</option>
																<?php } ?>
																<option value="0" <?php echo ($cost_centre == "0") ? ('selected') : (''); ?>>Others</option>
															</select>
														</div>
													</li>
												<?php } ?>
												
												
												<li class="mob_fulfill">
                                                    <label class="form-group" >From Month</label>
                                                    <div class="form-group mar-bt8  wdt_120">
														<select class="form-control wdt_120" name="month" id="month">
															<option value="">--Select--</option>
															<?php foreach ($monthArray as $key => $value) { ?>
																<option value="<?= $key ?>" <?php echo ($key == $month) ? ('selected') : (''); ?>>
																	<?= $value ?>
																</option>
															<?php } ?>
														</select>
                                                    </div>
                                                </li>
												<li class="mob_fulfill">
                                                    <label class="form-group" >From Year</label>
                                                    <div class="form-group mar-bt8  wdt_180">
														<select class="form-control wdt_180" name="year" id="year">
														<option value="">--Select--</option>
															<?php for ($i = 2011; $i <= date('Y') + 10; $i++) { ?>
																<option value="<?= $i ?>" <?php echo ($i == $year) ? ('selected') : (''); ?>>
																	<?= $i ?>
																</option>
															<?php } ?>
														</select>
                                                    </div>
                                                </li>
												<li class="mob_fulfill">
                                                    <label class="form-group" >To Month</label>
                                                    <div class="form-group mar-bt8  wdt_180">
														<select class="form-control wdt_180" name="month1" id="month1">
															<option value="">--Select--</option>
															<?php foreach ($monthArray as $key => $value) { ?>
																<option value="<?= $key ?>" <?php echo ($key == $month) ? ('selected') : (''); ?>>
																	<?= $value ?>
																</option>
															<?php } ?>
														</select>
                                                    </div>
                                                </li>
												<li class="mob_fulfill">
                                                    <label class="form-group" >To Year</label>
                                                    <div class="form-group mar-bt8  wdt_180">
														<select class="form-control wdt_180" name="year1" id="year1">
														<option value="">--Select--</option>
															<?php for ($i = 2011; $i <= date('Y') + 10; $i++) { ?>
																<option value="<?= $i ?>" <?php echo ($i == $year) ? ('selected') : (''); ?>>
																	<?= $i ?>
																</option>
															<?php } ?>
														</select>
                                                    </div>
                                                </li>
												<li><a name="search_btn" id="search_btn" type="submit" class="vital_yellow_btn">Search</a></li>
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
                                                        <th width="10%">Request No</th>
                                                        <th width="10%">Bill No</th>
                                                        <th width="5%">Name</th>
                                                        <th width="5%">Place</th>
                                                        <th width="5%">Date</th>
                                                        <th width="5%">Mode</th>
                                                        <th width="5%">Total Amount</th>
                                                        <th width="5%">Purpose</th>
                                                        <th width="5%">Donor</th>
                                                        <th width="5%">Budget Head</th>
                                                        <th width="5%">Line Item</th>
                                                        <th width="5%">Cost Centre</th>
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
                            <h4>Are you sure want to Request this Book?</h4>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="cancel_request">OK</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable'));

?>

<script type="text/javascript">
    $(document).ready(function () {
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
        $("#month").val('');
        $("#month1").val('');
        $("#year").val('');
        $("#year1").val('');
        $("#employee_id").val('');
        $("#cost_centre").val('');
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

        var month = $('#month').val();
        var month1 = $('#month1').val();
        var year = $('#year').val();
        var year1 = $('#year1').val();
        var employee_id = $('#employee_id').val();
        var cost_centre = $('#cost_centre').val();

        $('#master_table').DataTable({
            "scrollX": true,
            
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
                "url": "<?php echo base_url(); ?>index.php/traveladmin/DTreport",
                "type": "POST",
                "data": {
                    "month": month,
                    "month1": month1,
                    "year": year,
                    "year1": year1,
                    "employee_id": employee_id,
                    "cost_centre": cost_centre,
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