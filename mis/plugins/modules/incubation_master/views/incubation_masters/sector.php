<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Sectors', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'incubation_masters')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Sectors</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form method="post" id="emp_search" autocomplete="off" >
                                        <input type="hidden" name="current_user" id="current_user" value="<?= $current_user; ?>">
                                        <div class="row v_m_e_search leaveLabel">
                                            <div class="col-xl-7 col-lg-7 col-md-7 col-12 ">
                                                <ul class="vitals-links pad-tp0">
                                                    <li class="mob_fulfill">
                                                        <div class="form-group">
                                                            <div class="form-group has-search-right mar-bt8 wdt_180">
                                                                <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                                                <input type="text" class="form-control" name="filter_search" id="filter_search" value="<?php echo $search_value; ?>" placeholder="Search">
                                                                <div id="filter_search_err" ></div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                </ul>
                                            </div>
											
										 <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
											<ul class="vitals-links ">
												<li>
													<a href="<?php echo base_url() . 'index.php/incubation_master/addSectors'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Sector</a>
												</li>
												<?php /* <li>
													<a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
												</li> */ ?>
											</ul>
										</div>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 salary_His_table vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive dataTable" id="master_table">
                                                <thead>
                                                    <tr >
                                                        <th >Sectors</th>
                                                        <th>Assigned Incharge</th>
                                                        <th>Lead's</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
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

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about to delete <span id="delCount"></span> selected row, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .tab-slider--body {
        margin-bottom: 0px;
    }
    .inputplan-structureall {
        padding: 15px 0px 0px;
    }
    div.dataTables_scrollHead table{
        margin-bottom: 10px !important;
    }
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        master_trigger();
    });

    $('#filter_search').keypress(function (e) {
        if (e.which == 13) {
            filter_check();
            return false;
        }
    });

    $(document).on('click', '#reset_search', function () {
        $('#filter_search').val('');
        $("#filter_search_err").html('');
        master_trigger();
    });

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    function filter_check() {
        var filter_err = 0;
        $("#filter_search_err").html('');
        var filter_search = $('#filter_search').val();
        if (filter_search == '') {
            filter_err = 1;
            $("#filter_search_err").html('<label class="error" id="txt_error">Enter value</label>');
        }
        if (filter_err > 0) {
            return false;
        } else {
            master_trigger();
        }
    }

    function master_trigger() {
        var filter_search = $('#filter_search').val();
        $('#master_table').DataTable({
            "bProcessing": true,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 10,
            "scrollY": '288px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/incubation_master/DTsector",
                "type": "POST",
                "data": {
                    "search_field": filter_search
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var edited_id = $(":checkbox:eq(0)", this).val();
                        var slug = $(this).closest('tr').find('td:eq(3) input').val();
                        //var slug = $('#master_edit_id_' + edited_id).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/incubation_master/view_sectors/' + slug);
                        window.location = $(this).attr('href');
                        return false;
                    }
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
                $('.master_check_all').prop('checked', false);
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [1, 2, 3],
                }],
            "order": [0, 'asc']
        });
    }

    function submit_fields() {
        $('#master_form').submit();
    }

</script>

</body>
</html>