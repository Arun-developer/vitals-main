<?php
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => $type_name[0]['user_type'] . " Lists", 'page_table' => 'datatable'));
?>

<div class="dataconfig-content page-wrapper vitals_mainContent">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'emp_list')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4><div id="type_name">Employee Listing</div></h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <form method="post" id="emp_search" autocomplete="off">
                        <input type="hidden" name="current_user" id="current_user" value="<?= $current_user; ?>">
                        <div class="row v_m_e_search">
                            <div class="col-xl-7 col-lg-7 col-md-7 col-12 ">
                                <ul class="vitals-links">
                                    <li class="mob_fulfill">
                                        <div class="form-group mar-bt0">
                                            <select class="form-control" onchange="load_user(this.value);" id="emp_view">
                                                <?php foreach ($user_type as $user) { ?>
                                                    <option value="<?= $user['id']; ?>" <?php
                                                    if ($current_user == $user['id']) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?= $user['user_type']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="mob_fulfill">
                                        <div class="form-group mar-bt8 wdt_180">
                                            <select class="form-control wdt_180" id="emp_select" name="search_field">
                                                <option value="">--Search by--</option>
                                                <option value="1" <?php
                                                if ($search_field == "1") {
                                                    echo "selected";
                                                }
                                                ?>>Employee ID</option>
                                                <option value="2" <?php
                                                if ($search_field == "2") {
                                                    echo "selected";
                                                }
                                                ?>>Employee Name</option>
                                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <option value="3" <?php
                                                    if ($search_field == "3") {
                                                        echo "selected";
                                                    }
                                                    ?>>Partner Name</option>
                                                <?php } ?>
                                                <option value="4" <?php
                                                if ($search_field == "4") {
                                                    echo "selected";
                                                }
                                                ?>>Job Title</option>
                                                <!--                                                                <option value="5" <?php
                                                if ($search_field == "5") {
                                                    echo "selected";
                                                }
                                                ?>>Reporting Manager</option>-->
                                            </select>
                                        </div>
                                        <label class="error hidden" id="sel_error">Select type</label>
                                    </li>
                                    <li class="pad-lt15px mob_fulfill">
                                        <div class="form-group has-search-right mar-bt8 wdt_180">
                                            <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                            <input type="text" class="form-control" name="search_value" id="emp_search_box" value="<?php echo $search_value; ?>" placeholder="Search">
                                        </div>
                                        <label class="error hidden" id="txt_error">Enter value</label>
                                    </li>
                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                </ul>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                <ul class="vitals-links ">
                                    <li>
                                        <a href="<?php echo base_url() . 'index.php/user/add_user'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add User</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                            <table class="table dt-responsive" id="emp_list">
                                <thead>
                                    <tr>
                                        <th width="6%"><input type='checkbox' class='form-control data_checkAll' onchange="select_checkAll();" ></th>
                                        <th width="10%"><?= $type_name[0]['user_type']; ?> ID</th>
                                        <th><?= $type_name[0]['user_type']; ?> Name</th>
                                        <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <th>Partner</th>
                                        <?php } ?>
                                        <th>Employee Role</th>
                                        <th>Job Title</th>
                                        <th>Reporting Manager</th>
                                        <th>User Type</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $('table th:first').removeClass('sorting_asc');

        var e_type = $('#emp_view').val();
        localStorage.setItem('emp_type', e_type);

        var sel_text = $("#emp_view option:selected").text();
        $('#type_name').html(sel_text + ' Listing');

        $('#emp_list').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": false,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/user/DT_employee",
                "data": {"search_value": "<?php echo $search_value; ?>", "search_field": "<?php echo $search_field; ?>", "current_user": "<?php echo $current_user; ?>"},
                "type": "POST"
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#emp_list tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var slug = $(":checkbox:eq(0)", this).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/user/personal/' + slug);
                        window.location = $(this).attr('href');
                        return false;
                    }
                });
            },
            drawCallback: function () {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#emp_list').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.data_checkAll').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }

                $('.data_checkAll').prop('checked', false);
                $('.master_deluser').removeClass('clr_red');
                $('.master_deluser').addClass('none-pointer');
                $('tr td:first-child').css('text-align', 'center');
            },
            'columnDefs': [{
                'orderable': false,
                'targets': [0, -1]
            }],
            "order": [1, 'desc']
        });
    });

    $(document).on('click', '#search_btn', function () {
        var search = $('#emp_select').val();
        var search_text = $('#emp_search_box').val();
        var sr_error = 0;
        if (search == '') {
            sr_error = 1;
            $('#sel_error').removeClass('hidden');
            return false;
        } else {
            sr_error = 0;
            $('#sel_error').addClass('hidden');
        }

        if (search_text == '') {
            sr_error = 1;
            $('#txt_error').removeClass('hidden');
            return false;
        } else {
            sr_error = 0;
            $('#txt_error').addClass('hidden');
        }

        if (sr_error == 0) {
            $('#sel_error, #txt_error').addClass('hidden');
            $('form#emp_search').submit();
            return false;
        }
    });

    $('#emp_search_box').keypress(function (e) {
        if (e.which == 13) {
            var search = $('#emp_select').val();
            var search_text = $('#emp_search_box').val();
            var sr_error = 0;
            if (search == '') {
                sr_error = 1;
                $('#sel_error').removeClass('hidden');
                return false;
            } else {
                sr_error = 0;
                $('#sel_error').addClass('hidden');
            }

            if (search_text == '') {
                sr_error = 1;
                $('#txt_error').removeClass('hidden');
                return false;
            } else {
                sr_error = 0;
                $('#txt_error').addClass('hidden');
            }

            if (sr_error == 0) {
                $('#sel_error, #txt_error').addClass('hidden');
                $('form#emp_search').submit();
                return false;
            }
        }
    });

    function select_checkAll() {
        if ($('.data_checkAll:checked').length > 0) {
            $('.chk_box').prop('checked', true);
            $('.master_deluser').addClass('clr_red');
            $('.master_deluser').removeClass('none-pointer');

        } else {
            $('.chk_box').prop('checked', false);
            $('.master_deluser').removeClass('clr_red');
            $('.master_deluser').addClass('none-pointer');
        }
    }

    $(document).on('click', '#emp_chk_box', function () {
        var emp_check = $('.chk_box:checkbox:checked').length;
        if ($('.chk_box:checked').length == $('.chk_box').length) {
            $('.data_checkAll').prop('checked', true);
        } else {
            $('.data_checkAll').prop('checked', false);
        }

        if (emp_check > 0) {
            $('.master_deluser').addClass('clr_red');
            $('.master_deluser').removeClass('none-pointer');
        } else {
            $('.master_deluser').removeClass('clr_red');
            $('.master_deluser').addClass('none-pointer');
        }
    });

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".chk_box:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    $(document).on('click', '#deleteRecord', function () {
        var vals = $('.chk_box:checkbox:checked').map(function () {
            return this.value;
        }).get().join(',');
        var del_id = vals.split(',');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/user/deleteDetail",
            data: {
                id: del_id,
                table: 'hr_user_profile',
                field: 'status'
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
            }
        });
    });

    function load_user(id) {
        localStorage.setItem('emp_type', id);
        window.location.href = '<?= base_url(); ?>' + 'index.php/user/lists/' + id;
    }

    $(document).on('click', '#reset_search', function () {
        $('#emp_select, #emp_search_box').val('');
        $('form#emp_search').submit();
        return false;
    });

</script>

</body>
</html>