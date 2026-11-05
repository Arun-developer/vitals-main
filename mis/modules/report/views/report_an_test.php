<?php $this->load->view('vitals_header.php', array('main_menu' => 'report', 'page_title' => 'AN Unutilized Report', 'page_table' => 'datatable')); ?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'report', 'page' => 'reportAn')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Approval note/ Internal Note report</h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/report/an_report_export_an_new' ?>" class="pad-lt15px " method="POST" autocomplete="off">
                                        <input type="hidden" id="set_export" name="export_status" >
                                        <div class="col-xl-12 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Programme</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="programme" id="programme">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($programmeList as $lists) { ?>
                                                                <option value="<?php echo $lists['programme_id']; ?>" ><?php echo $lists['programme']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="hidden" id="export_type"  name="export_type"  value="">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Donor</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="donor" id="donor">
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >From Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="from_date"  name="from_date" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >To Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="to_date"  name="to_date" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <div class="form-group mar-bt8">
                                                        <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                        <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                        <li>
                                                            <a id="export_summary_an" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export AN</a>
                                                            <a id="export_summary_in" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export IN</a>
                                                            <a id="export_summary_new" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export New</a>
                                                        </li>


                                                    </div>
                                                </li>


                                            </ul>
                                    </form>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                    <ul class="vitals-links"></ul>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                        <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th class="sorting_disabled removeArrow" width="3%" style="font-weight:bold;">Approval ID</th>
                                                    <th width="3%" style="font-weight:bold;">Internal ID</th>
                                                    <th width="4%" style="font-weight:bold;">AN Raised Date</th>
                                                    <th width="4%" style="font-weight:bold;">IN Raised Date</th>
                                                    <th width="5%" style="font-weight:bold;">From Employee</th>
                                                    <th width="5%" style="font-weight:bold;">Programme</th>
                                                    <th width="5%" style="font-weight:bold;">Donor</th>
                                                    <th width="5%" style="font-weight:bold;">Grant</th>
                                                    <th width="5%" style="font-weight:bold;">Budget Head</th>
                                                    <th width="5%" style="font-weight:bold;">Line Item</th>
                                                    <th width="4%" style="font-weight:bold;">Cost Center</th>
                                                    <th width="4%" style="font-weight:bold;">Detail</th>
                                                    <th width="12%" style="font-weight:bold;">Subject</th>
                                                    <th width="3%" style="font-weight:bold;">AN Status</th>
                                                    <th width="3%" style="font-weight:bold;">IN Status</th>
                                                    <th width="3%" style="font-weight:bold;">Amount in AN</th>
                                                    <th width="3%" style="font-weight:bold;">Amount in IN</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                                <input type="hidden" name="delete_ids" id="delete_ids" />

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
    $(document).ready(function () {
        $(document).on('click', '#export_summary_an', function () {
            $("#export_type").val('0');
            $("#filter_job").submit();
        });
        $(document).on('click', '#export_summary_in', function () {
            $("#export_type").val('1');
            $("#filter_job").submit();
        });
        $(document).on('click', '#export_summary_new', function () {
            $("#export_type").val('2');
            $("#filter_job").submit();
        });


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

        $(document).on('change', '#programme', function () {

            var programme_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url() . 'index.php/report/report_donor' ?>',
                cache: false,
                type: "POST",
                data: {programme_id: programme_id},
                dataType: "json",
                success: function (response) {
                    $("#donor").html(response.response);
                }
            });

        });

    });



    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {

        $("#set_export").val('0');
        $('#status').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#programme').val('');
        $('#donor').val('');

        master_trigger();
    });

    $(document).ready(function () {
        master_trigger();
        //$("#reset_search").trigger("click");
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

        var status = $('#status').val();
        var date_from = $('#from_date').val();
        var date_to = $('#to_date').val();
        var programme = $('#programme').val();
        var donor = $('#donor').val();

        var action = '<?php echo $this->uri->segment(3); ?>';
        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            },
            "bDestroy": true,
            "bProcessing": true,
            "bServerSide": true,
            "bSort": false,
            "paging": true,
            "responsive": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 20,
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/report/report_an_ajax_test",
                "type": "POST",
                "data": {
                    "date_from": date_from,
                    "date_to": date_to,
                    "programme": programme,
                    "donor": donor,
                    "status": status
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
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