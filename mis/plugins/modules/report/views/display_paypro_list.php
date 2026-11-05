<?php $this->load->view('vitals_header.php', array('main_menu' => 'report', 'page_title' => 'Reports - Innovation Archives', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'report', 'page' => 'paypro')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Reports - PayPro</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job"  action="<?php echo base_url() . 'index.php/report/export_in_paypro'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-12 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Internal Note</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="internal_note"  name="internal_note" class="form-control" placeholder="Search">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <div class="form-group mar-bt8">
                                                        <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                        <li class="cursor" id="reset_search"><a href="<?php echo base_url() . 'index.php/report/paypro_list/1'; ?>" id="search_btn" class="vitals_clearSearch">Clear search</a></li>
														<li><a id="export_account_summary" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export Paypro</a></li>
													</div>
                                                </li>
                                            </ul>
                                            <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                                <ul class="vitals-links"></ul>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                    <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">Internal No</th>
                                                                <th width="5%">Beneficiary Name</th>
                                                                <th width="5%">Amount</th>
                                                                <th width="5%">Bene Account Number</th>
                                                                <th width="5%">Debit Account Number</th>
                                                                <th width="5%">Receiver IFSC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <input type="hidden" name="delete_ids" id="delete_ids" />
                                    </form>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

$(document).on('click', '#export_account_summary', function () {
    $("#filter_job").submit();
});



    $(document).ready(function () {
        $('#transfer_form').validate({
            rules: {
                emp_id: {
                    required: true
                },
                issue_date: {
                    required: true
                },
            },
            messages: {
                emp_id: "Select Employee",
                issue_date: "Select Date",
            }
        });

        $(document).on('change', '#emp_id', function () {
            $("#other_employee").css('display', 'none');
            $("#other_employee").css('display', 'none');
            $("#other_employee_id").val('');
            if ($(this).val() == 'others') {
                $("#other_employee").css('display', 'contents');
            }
        });

        $(document).on('click', '.cancel_at', function () {
            $("#emp_id").val('');
            $("#issue_date").val('');
        });

        $(document).on('click', '#transfer', function () {
            if ($("#transfer_form").valid() == true) {
                $("#transfer_form").submit();
            }
            return false;
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.transfer_cls', function () {
            var asset_number = $(this).attr('data-attr-an');
            var asset_code = $(this).attr('data-attr-ac');
            var asset_id = $(this).attr('data-attr-aid');

            $("#vendor_asset_id").val(asset_id);
            $("#asset_num").val(asset_number);
            $("#asset_co").val(asset_code);
            $('#transfermodal').modal('show');
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
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');

        $('#vendor').val('');
        $('#asset_number').val('');
        $('#asset_name').val('');
        $('#asset_code').val('');
        $('#employee_id').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#available_status').val('');
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
        var internal_note = $('#internal_note').val();
        var action = '<?php echo $this->uri->segment(3); ?>';
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
            "responsive": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 20,
            "scrollY": '334px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/report/DTPaypro",
                "type": "POST",
                "data": {
                    "internal_note": internal_note
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 1, 2, 3],
                }],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

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