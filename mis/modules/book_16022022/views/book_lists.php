<?php
$master_menu = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Book Request', 'page_table' => 'datatable'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'bookrequest')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Book Request</h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-10 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Category</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="master_id" id="master_id">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($categoryList as $list) { ?>
                                                                <option value="<?php echo $list['master_id']; ?>"><?php echo $list['master_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="category_err"></div>
                                                </li>

                                                <li class="mob_fulfill">
                                                    <label class="form-group">Books Name</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="book_name"  name="book_name" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="book_name_err"></div>
                                                </li>

                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group">Author</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                                        <input type="text" id="author"  name="author" class="form-control" placeholder="Search">
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
                                                        <th width="10%">Category</th>
                                                        <th width="10%">Book Number</th>
                                                        <th width="5%">Book Name</th>
                                                        <th width="5%">Author</th>
                                                        <th width="5%">Availability Status</th>
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
                            <h4>Are you sure want to Request this Book?</h4>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="cancel_request">Ok</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
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
    // #Changes done for remove the CategoryMandatory options.
      //filter_check();
        master_trigger();
                return false;
            }
        });

        master_trigger();
    });

    $(document).on('click', '#search_btn', function () {
      // #Changes done for remove the CategoryMandatory options.
      //filter_check();
        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');
        var master_id = $('#master_id').val('');
        var book_name = $('#book_name').val('');
        var author = $('#author').val('');
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
        var master_id = $('#master_id').val();
        var book_name = $('#book_name').val();
        var author = $('#author').val();

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
                "url": "<?php echo base_url(); ?>index.php/book/DTbook_list",
                "type": "POST",
                "data": {
                    "master_id": master_id,
                    "book_name": book_name,
                    "author": author
                }
            },
			'columnDefs': [{
				'orderable': false,
				'targets': [5],
			}],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table').on('click', '.action_cls', function (e) {
                    if (!$(e.target).is("input")) {
                        var id = $(this).attr('data-attr');
                        if (id != '') {
                            console.log(id);
                            $('#request_id').val(id);
							$('#actionmodal').modal('show');
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