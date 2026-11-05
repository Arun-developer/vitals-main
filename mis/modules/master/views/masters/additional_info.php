<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Additional info', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'additional_info')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Additional Info</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 10px;"></div>
                                    <form id="filter_job" action="" class="pad-lt15px" method="POST" autocomplete="off">
                                        <div class="row spec-label">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <label>Programme</label>
                                                <div class="form-group mar-bt8  ">
                                                    <select class="form-control " id="prgm_search" name="prgm_search" onchange="getDonor(this.value);">
                                                        <option value="">--Select Programme--</option>
                                                        <?php foreach ($programme as $p_search) { ?>
                                                            <option value="<?= $p_search['programme_id']; ?>"><?= $p_search['programme']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <label>Donor</label>
                                                <div class="form-group mar-bt8  ">
                                                    <select class="form-control " id="donor_search" name="donor_search" onchange="getBudget('', this.value);">
                                                        <option value="">--Select Donor--</option>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <label>Budget Head</label>
                                                <div class="form-group mar-bt8  ">
                                                    <select class="form-control " id="budget_search" name="budget_search" onchange="getLineitem(this.value)">
                                                        <option value="">--Select Budget head--</option>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                        </div>
                                        <div class="row spec-label">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <label>Line item</label>
                                                <div class="form-group mar-bt8  ">
                                                    <select class="form-control " id="line_search" name="line_search">
                                                        <option value="">--Select Line item--</option>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <label>Additional Information</label>
                                                <div class="form-group mar-bt8 ">
                                                    <input type="text" id="filter_search" value="<?php if (isset($filter_search) && $filter_search != '') echo $filter_search; ?>" name="filter_search" class="form-control" placeholder="Search">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div style="height: 10px;"></div>
                                                <ul class="vitals-links pad-none">
                                                    <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                    <li><span class="vitals_clearSearch" id="reset_search">Clear search</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                    <div style="height: 10px;"></div>
                                    <div class="row">
                                        <div class="col-12 col-md-12 text-right">
                                            <ul class="vitals-links">
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/master/additional_info/add'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Additional Info</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="8%"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all' onchange="selectall_chk();"></th>
                                                        <th width="15%">Programme</th>
                                                        <th width="15%">Donor</th>
                                                        <th width="15%">Budget Head</th>
                                                        <th width="15%">Line Item</th>
                                                        <th width="20%">Additional Info</th>
                                                        <th width="15%">Status</th>
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
    div.dataTables_scrollHead table thead tr th:first-child, .vitalMasterDataTbl table.dataTable tbody tr td:first-child{
        min-width:20px !important;
        max-width:20px !important;
    }
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $('.plan-structure-new').css({
            'height': (($(window).height()) - 250) + 'px'
        });

        setTimeout(function () {
            $('.success').addClass('display-hide');
        }, 3000);

        master_trigger();
    });

    function master_trigger() {
        var filter_search = $('#filter_search').val();
        var line_search = $('#line_search').val();
        var donor_search = $('#donor_search').val();
        var budget_search = $('#budget_search').val();
        var prgm_search = $('#prgm_search').val();
        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            },
            "bProcessing": true,
            "responsive": false,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            "ordering": true,
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
                "url": "<?php echo base_url(); ?>index.php/master/DTAdditional",
                "type": "POST",
                "data": {
                    "search_field": filter_search,
                    "line_search": line_search,
                    "donor_search": donor_search,
                    "budget_search": budget_search,
                    "programme_search": prgm_search

                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var edited_id = $(":checkbox:eq(0)", this).val();
                        var slug = $('#master_edit_id_' + edited_id).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/master/additional_info/edit/' + slug);
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
                $('#delete_ids').val('');
                selectall_chk();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0],
                },
                {
                    "width": "30px",
                    "targets": [0],
                    "visible": true,
                }],
            "order": [5, 'asc']
        });
    }

    function enableEdits() {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var len = arr.length;
        for (var a = 0; a < len; a++) {
        }
    }

    $(document).on('click', '#search_btn', function () {
        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $('#filter_search').val('');
        $('#donor_search').val('');
        $('#budget_search').val('');
        $('#prgm_search').val('');
        $('#line_search').val('');
        master_trigger();
    });

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".master_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var paylen = $('.master_check').length;
        var payinput = $('.master_check:checked').length;
        var delete_id = $('#master_edit_id_' + checkid).val();

        if (paylen != payinput) {
            $('.master_check_all').prop('checked', false);
        } else {
            $('.master_check_all').prop('checked', true);
        }
        if ($('#master_check_' + checkid).prop('checked') == true) {
            $("#delUser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                var new_f = $(".new_field").length;
                if (new_f > 0) {
                } else {
                }
                $("#delUser").removeClass("clr_red");
                $("#delUser").addClass("opacity5 none-pointer");
            }
        }
    }

    $(document).on('click', '#deleteRecord', function () {
        var id = $('#delete_ids').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/deleteMasterSetting",
            data: {
                id: id,
                field: 'id',
                table: 'additional_info',
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                // $('.deletetoast').toast('show');
                $('.deleteMsg').removeClass('display-hide');
                // setTimeout(function() {
                location.reload();
                // }, 3000);
            }
        });
    });

    function selectall_chk() {
        if ($('input[name="master_check_all"]:checked').length > 0) {
            $('.master_check').prop('checked', true);
            // var favorite = [];
            $.each($(".master_check:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.master_check').prop('checked', false);
            $.each($(".master_check"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    function submit_fields() {
        $('#master_form').submit();
    }

    function getDonor(prgmval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getPrgmDonor",
            data: {
                parent: prgmval,
            },
            dataType: 'html',
            success: function (data) {
                $('#donor_search').html(data);
            }
        });
    }

    function getBudget(increa, donorval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Budget Head',
                parent: donorval,
            },
            dataType: 'html',
            success: function (data) {
                // $('.deletetoast').toast('show');
                $('#budget_head_' + increa).html(data);
                if (increa == '') {
                    $('#budget_search').html(data);
                }
                // }, 3000);
            }
        });
    }

    function getLineitem(budgetval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Line Item',
                parent: budgetval,
            },
            dataType: 'html',
            success: function (data) {
                $('#line_search').html(data);
            }
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