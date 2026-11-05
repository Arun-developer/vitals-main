<?php
$this->load->view('templates/header_copy.php');
$funder_id = $this->uri->segment(3);
$page = $this->uri->segment(2);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

<div class="position-absolute d-flex flex-column p-4 toastPlace">
    <div id="toast-container" aria-live="polite" aria-atomic="true">
        <div id="toast-wrapper">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-danger text-white">
                    <strong><?= $errorMsg; ?></strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true" class="text-white">×</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
    <main class="page-content">
        <div class="row dataconfig d_v_d_c">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 pad-none display-flex">
                <span><a href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                <h4>Funds/Grants - <?php if ($funder_name != '') echo $funder_name; ?></h4>
            </div>
        </div>
        <div class="plan-structure-vital vital_windowScroll">
            <div>
                <div class="tab-slider--navform">
                    <ul class="tab-slider--tabsform">
                        <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/funder/edit_funder_form/' . $funder_id; ?>">Funder Details</a></li>
                        <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/funder/edit_grant_form/' . $funder_id; ?>">Grants</a></li>
                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/funder/edit_funder_documents/' . $funder_id; ?>">Documents</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-slider--container">
                <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6 text-right">
                                    <ul class="vitals-links">
                                        <?php if ($this->auth == '1') { ?>
                                                      <!-- <li><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li> -->
                                            <li><a href="<?php echo base_url() . 'index.php/funder/add_grant_form/' . $funder_id; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Grant</a></li>
                                            <li>
                                                <a class="master_deluser none-pointer" data-chk-attr='tbl_checkbox' data-toggle="modal" data-target="" id="delete_document" ><i class="fas fa-trash-alt"></i> Delete</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 col-xl-6 text-right">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                    <div class="table-responsive">
                                        <form id="deleted_grant_list" name="deleted_grant_list" action="<?php echo base_url() . 'index.php/funder/deleted_grant_list' ?>" method="POST">
                                            <input type="hidden" name="funder_id" value="<?php echo $funder_id; ?>">
                                            <div class="table-responsive">
                                                <table id="grant_list" style="margin-top: 10px;" class="table table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th width="6%" class="removeArrow"><input  style="width: 12px; <?php
                                                                if ($this->auth == '0') {
                                                                    echo"display:none;";
                                                                }
                                                                ?>" class="form-control common_checkbox" type="checkbox"></th>
                                                            <th >Grant Id</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Amount Committed <small>(INR)</small></th>
                                                            <th>Amount Received <small>(INR)</small></th>
                                                            <th>Projected Utilization <small>(INR)</small></th>
                                                            <th>Amount Utilized <small>(INR)</small></th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
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
</body>

<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>" >
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>


<script>

    $(document).ready(function () {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
        $('.common_checkbox').click(function (e) {
            var table = $(e.target).closest('table');
            var cur_tbl_id = $(e.target).closest('table').attr('id');
            $('td input:checkbox', table).prop('checked', this.checked);
            if (this.checked) {
                $('.tbl_checkbox').prop('checked', true);
            } else {
                $('.tbl_checkbox').prop('checked', false);
            }

            if ($('input:checkbox.common_checkbox:checked').length > 0 && $('input:checkbox.tbl_checkbox').length > 0) {
                $("#delete_document").attr({"data-target": "#deleteModal"});
                $(".master_deluser").addClass("clr_red none-pointer");
                $(".master_deluser").removeClass("none-pointer");
            } else {
                $("#delete_document").attr({"data-target": ""});
                $(".master_deluser").removeClass("clr_red none-pointer");
                $(".master_deluser").addClass("none-pointer");
            }
			
			
        });
        $(document).on('click', '.tbl_checkbox', function () {
            if ($('input:checkbox.tbl_checkbox').length != $('input:checkbox.tbl_checkbox:checked').length) {
                $('.common_checkbox').prop('checked', false);
            } else {
                $('.common_checkbox').prop('checked', true);
            }
            if ($('input:checkbox.tbl_checkbox:checked').length > 0) {
                $("#delete_document").attr({"data-target": "#deleteModal"});
                $(".master_deluser").addClass("clr_red none-pointer");
                $(".master_deluser").removeClass("none-pointer");
            } else {
                $("#delete_document").attr({"data-target": ""});
                $(".master_deluser").removeClass("clr_red none-pointer");
                $(".master_deluser").addClass("none-pointer");
            }

        });
        $(document).on('click', '#editSubmit', function () {
            $('#deleteModal').modal('hide');
            $(".master_deluser").addClass("none-pointer");
            $(".master_deluser").removeClass("clr_red");
            $("#deleted_grant_list").submit();
        });
		
    });

    $(document).on('click', '.master_deluser', function () {
        var cur_attr = $(this).attr("data-chk-attr");
        $('#delCount').val('');
        var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
        $('#delCount').html(sel_item);
        if (sel_item > 0) {
            //$('#deletemodal').modal('show');
        }
    });

	 
	
    $('#grant_list').DataTable({
        "bProcessing": true,
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
        "autoWidth": true,
		//"scrollX": true,
        "pageLength": 12,
        "ajax": {
            "url": "<?php echo base_url(); ?>index.php/funder/ajax_load_datatable",
            "data": {'funder_id': '<?php echo $funder_id; ?>'},
            "type": "POST",
        }, drawCallback: function (settings) {
            var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
            //if(this.api().page.info().pages == 0){
            pagination.toggle(this.api().page.info().pages > 1);
            //}
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        },
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('#grant_list tbody').on('click', 'tr', function (e) {
                if (!$(e.target).is("input")) {
                    var slug = $(":checkbox:eq(0)", this).val();
                    $(nRow).attr("href", '<?php echo base_url(); ?>' + 'index.php/funder/edit_grant_form/' + slug + '/' + '<?php echo $funder_id; ?>');
                    window.location = $(this).attr('href');
                    return false;
                }
            });
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        },
        'columnDefs': [{
                'orderable': false,
                'targets': [0]
            }
        ],
        "order": [1, 'desc']
    });
	
    $('.dataTables_length').addClass('bs-select');
	$(document).ready(function () {
		$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
	});	
</script>
<?php $this->load->view('templates/footer.php'); ?>