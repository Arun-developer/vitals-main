<?php $this->load->view('templates/header_copy.php'); ?>
<style>
    .dataTables_scroll {
        overflow: auto;
    }
    .dataTables_empty{
        text-align: center;
    }
</style>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
    <main class="page-content">
        <div class="row dataconfig d_v_d_c">
            <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                <h4>Funds/Grants</h4>
            </div>
        </div>
        <div class="plan-structure-vital vital_windowScroll">
            <div class="tab-slider--container">
                <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new">

                            <div class="row leaveLabel">
                                <div class="col-12 col-md-9 col-lg-9 col-xl-9">
                                    <form id="summary_search" autocomplete="off" action="<?php echo base_url() . 'index.php/funder/display_summary_list' ?>" method="POST">
                                        <ul class="vitals-links" style="white-space: nowrap; ">
                                            <li>
                                                <input type="hidden" id="set_export" name="export_status" >
                                                <div class="form-group mar-bt8 wdt_180">
                                                    <select id="type" name="type" class="form-control wdt_190">
                                                        <option value="">-- Search by --</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'funder') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="funder">Funder</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'grant_name') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="grant_name">Grant Id</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'start_date') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="start_date">Start Date</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'end_date') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="end_date">End Date</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'grant_amount') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="grant_amount">Grant Amount</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'project_amount') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="project_amount">Projected Utilization</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'amount_received') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="amount_received">Amount Received</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'total_utilized') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="total_utilized">Total Utilized</option>
                                                        <option <?php
                                                        if (isset($type) && $type != '') {
                                                            if ($type == 'grant_status') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="grant_status">Grant Status</option>
                                                    </select>
                                                    <label for="grant_start_date" id="select_err" class="error"></label>
                                                </div>
                                            </li>
                                            <li id="start_date" style="<?php
                                            if (isset($start_date) && $start_date != '') {
                                                echo "inline-block";
                                            } else {
                                                echo "display:none";
                                            }
                                            ?>">
                                                <div class="form-group mar-bt8 wdt_180">
                                                    <input value="<?php if (isset($start_date) && $start_date != '') echo $start_date; ?>" type="text" name='start_date' class="form-control start_date datepicker" placeholder="Start date">
                                                    <label for="grant_start_date" id="start_err" class="error"></label>
                                                </div>
                                            </li>
                                            <li id="end_date" style="<?php
                                            if (isset($end_date) && $end_date != '') {
                                                echo "inline-block";
                                            } else {
                                                echo "display:none";
                                            }
                                            ?>">
                                                <div class="form-group mar-bt8 wdt_180">
                                                    <input value="<?php if (isset($end_date) && $end_date != '') echo $end_date; ?>" type="text" name='end_date' class="form-control required end_date datepicker" placeholder="End date">
                                                    <label for="grant_start_date" id="end_err" class="error"></label>
                                                </div>
                                            </li>

                                            <li class="pad-lt15px">
                                                <div class="form-group has-search-right mar-bt8 wdt_180">
                                                    <a href="javascript:" id="search_btn" class="form-control-feedback"><span class="fa fa-search" style="margin-top: 10px; "></span></a>
                                                    <input value="<?php if (isset($search_val) && $search_val != '') echo $search_val; ?>" type="text" name="search_val" id="search_submitted" class="form-control" placeholder="Search">
                                                    <label for="grant_start_date" id="search_err" class="error"></label>
                                                </div>
                                            </li>
                                            <li><a href="display_summary_list"><span class="vitals_clearSearch" >Clear search</span></a></li>
                                        </ul>
                                    </form>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                    <ul class="vitals-links" >
                                        <li  class="pad-lt15px">
                                            <div class="form-group has-search-right mar-bt8 wdt_180">
                                                <a  id="export_summary" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export</a>
                                                <a class="master_deluser delete_cls none-pointer" data-chk-attr='tbl_checkbox' data-toggle="modal" data-target="#deleteModal" id="delete_document"><i class="fas fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                    <form id="delete_summay_list" autocomplete="off" name="delete_summay_list" action="<?php echo base_url() . 'index.php/funder/delete_summay_list' ?>" enctype="multipart/form-data" method="POST">
                                        <div class="table-responsive">
                                            <table id="summary_list_tbl" class="table table-hover nowrap dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th class="removeArrow"><input style="width: 12px; <?php
                                                            if ($this->auth == '0') {
                                                                echo"display:none;";
                                                            }
                                                            ?>" <?php
                                                            if ($this->auth == '0') {

                                                            }
                                                            ?> class="form-control common_checkbox" type="checkbox"></th>
                                                        <th >Funder</th>
                                                        <th>Grant Id</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Grant Amount (INR)</th>
                                                        <th>Amount Received (INR)</th>
                                                        <th>Projected Utilization (INR)</th>
                                                        <th>Total Utilised (INR)</th>
                                                        <th>Grant Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $CI = &get_instance(); ?>
                                                    <?php
                                                    $arr_cnts = array();
                                                    $i = 0;
                                                    $j = 0;
                                                    if (!empty($funder_lists)) {
                                                        foreach ($funder_lists as $list) { #echo'<pre>';print_r($list);die;
                                                            ?>
                                                            <tr class="">
                                                        <input type="hidden" id="viewRow_<?php echo $i + 1; ?>" value="">
                                                        <td><input <?php
                                                            if ($this->auth == '0') {
                                                                echo "disabled";
                                                            }
                                                            ?> style="<?php
                                                                if ($this->auth == '0') {
                                                                    echo"display:none;";
                                                                }
                                                                ?>" class="form-control tbl_checkbox tbl_parent parent_checkbox_<?php echo $list[0]['id']; ?>" data-attr-type ='parent' data-attr ='child_checkbox_<?php echo $list[0]['id']; ?>' type="checkbox" name="funder_id[]" value="<?php echo $list[0]['id']; ?>"></td>
                                                        <td><?php if (count($list) != 0) { ?><a class="getFunderRow tlf_row<?php echo $i + 1; ?>" id="<?php echo $i + 1; ?>" href="javascript:"><i class="fas fa-caret-down" style="<?php
                                                                    if ($list[0]['gl_id']) {
                                                                        echo "display: block;";
                                                                    } else {
                                                                        echo "display: none;";
                                                                    }
                                                                    ?>" ></i></a><?php } ?></td>
                                                        <td>

                                                            <input class="get_count" type="hidden" value="<?php
                                                            if ($list[0]['gl_id']) {
                                                                if (count($list) > 0) {
                                                                    echo count($list) + 1;
                                                                }
                                                            } else {
                                                                echo "1";
                                                            }
                                                            ?>" />


                                                            <a href="<?php echo base_url() . 'index.php/funder/edit_funder_form/' . $list[0]['id']; ?>"><?php echo $list[0]['name']; ?>(<?php
                                                                if ($list[0]['gl_id']) {
                                                                    $arr_cnts[] = count($list) + 1;
                                                                    echo count($list);
                                                                } else {
                                                                    $arr_cnts[] = 1;
                                                                    echo "0";
                                                                }
                                                                ?>)</a></td>
                                                        <td><span class="clr_gray">Type: </span><?php echo ucfirst($list[0]['type']); ?></td>
                                                        <td><span class="clr_gray">FCRA Status: </span><?php echo strtoupper($list[0]['fcra_status']); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        </tr>
                                                        <?php
                                                        foreach ($list as $grant_lists) { #echo'<pre>';print_r($grant_lists);die;
                                                            if ($grant_lists['gl_id'] != '') {
                                                                ?>
                                                                <tr class="display-none tlf_<?php echo $i + 1; ?>">
                                                                    <?php
                                                                    if (isset($search_type) && $search_type == 'amount_received' && $totalAmount[$grant_lists['gl_id']] != '') {
                                                                        if ($search_val == $totalAmount[$grant_lists['gl_id']]) {
                                                                            echo $search_val;
                                                                            ?>

                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <td><input style="<?php
                                                                        if ($this->auth == '0') {
                                                                            echo"display:none;";
                                                                        }
                                                                        ?>" <?php
                                                                        if ($this->auth == '0') {
                                                                            echo "disabled";
                                                                        }
                                                                        ?> class="form-control tbl_checkbox tbl_child child_checkbox_<?php echo $list[0]['id']; ?>" data-attr-type ='child' data-attr="parent_checkbox_<?php echo $list[0]['id']; ?>" type="checkbox" name="grant_id[]" value="<?php echo $grant_lists['gl_id']; ?>"></td>
                                                                    <td><?php echo $grant_lists['name']; ?></td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/funder/edit_grant_form/' . $grant_lists['gl_id']; ?>"><?php echo $grant_lists['gl_name']; ?></a></td>
                                                                    <td><?php echo $grant_lists['gl_start_date']; ?></td>
                                                                    <td><?php echo $grant_lists['gl_end_date']; ?></td>
                                                                    <td><?php echo $CI->numberToCurrency($grant_lists['gl_amount']); ?></td>
                                                                    <td><?php echo $CI->numberToCurrency($grant_lists['gl_deposite_amt']); ?></td>
                                                                    <td><?php echo $CI->numberToCurrency($grant_lists['gl_projected_amount']); ?></td>
                                                                    <td><?php echo $CI->numberToCurrency($grant_lists['gl_amount_utilized']); ?></td>
                                                                    <td><?php echo ucfirst($grant_lists['gl_status']); ?></td>

                                                                </tr>
                                                                <?php
                                                                $j++;
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        $i++;
                                                    }
                                                }

                                                $arr_impl = implode(',', $arr_cnts);
                                                ?>

                                                <input type='hidden' name="samplesa[]" id="samplesa" value="<?php echo $arr_impl; ?>"/>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right">

                                        </div>
                                    </form>
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



<?= 'Page Count: ' . $pagination_counts; ?>
<input type="hidden" id='overallRow' value='<?= $pagination_counts; ?>'>
<?php $this->load->view('templates/footer_copy.php'); ?>

<style>
    .dataTables_scrollHead{
        height: 52px;
    }
</style>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>" type="text/javascript">></script>

<script type="text/javascript">


            $(document).on('click', '#search_btn', function () {
        check_search();
    });
    $('#search_submitted').keypress(function (e) {
        if (e.which == 13) {
            check_search();
        }
    });
    function check_search() {

        var type = $("#type").val();
        var search_val = $("#search_submitted").val();
        var start_dates = $(".start_date").val();
        var end_dates = $(".end_date").val();

        $('#select_err').html('');
        $('#search_err').html('');
        $('#start_err').html('');
        $('#end_err').html('');

        //alert('type ::' + type);alert('search_val ::' + search_val);alert('start_dates ::' +start_dates);
        //alert('end_dates ::' + end_dates);
        if (type == '') {
            $('#select_err').html('<label for="grant_start_date" id="start_err" class="error">Select type</label>');
            if ((search_val == '' || search_val == undefined) && type != 'start_date' && type != 'end_date') {
                $('#search_err').html('<label for="grant_start_date" id="start_err" class="error">Enter value</label>');
            }
            return false;
        }
        if ((search_val == '' || search_val == undefined) && type != 'start_date' && type != 'end_date') {
            $('#search_err').html('<label for="grant_start_date" id="start_err" class="error">Enter value</label>');
            return false;
        }
        if (type == 'start_date' && (start_dates == '' || start_dates == undefined)) {
            $('#start_err').html('<label for="grant_start_date" id="start_err" class="error">Select date</label>');
            return false;
        }
        if (type == 'end_date' && (end_dates == '' || end_dates == undefined)) {
            $('#end_err').html('<label for="grant_start_date" id="start_err" class="error">Select date</label>');
            return false;
        }
        $("#set_export").val('0');
        $("#summary_search").submit();

    }

    $(document).ready(function () {
        var dyn_count;
        var pagination_count = '<?php echo $pagination_counts; ?>';
        dyn_count = pagination_count;
        $('#summary_list_tbl').on('xhr.dt', function (e, settings, json, xhr) {
            table.page.len(pagination_count).draw();
        });
    });

    $(document).on('click', '.paginate_button', function () {
        loadNext();
    });

    function loadNext() {
        var common_val = 0;
        $(".get_count").each(function (index) {
            if (this.value != '' && this.value != undefined) {
                sum_val = parseFloat(this.value);
                if (!isNaN(sum_val)) {
                    common_val += sum_val;
                }
            }
        });
        dyn_count = common_val;
        $('#overallRow').val(common_val);

        $('#summary_list_tbl').on('xhr.dt', function (e, settings, json, xhr) {
            table.page.len(common_val).draw();
        });
    }

    var table = $("#summary_list_tbl").DataTable({
        "bProcessing": true,
        "bDestroy": true,
        "autoWidth": false,
        "bSortable": false,
        "ordering": false,
        "bInfo": false,
        "bPaginate": true,
        "false": false,
        "bScrollCollapse": true,
        "scrollX": true,
        "pageLength": <?php echo $pagination_counts; ?>,
        "initComplete": function (settings, json) {
            $('.dataTables_scrollBody thead tr').css({
                visibility: 'collapse'
            });
        },
        drawCallback: function (settings) {
            var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
            pagination.toggle(this.api().page.info().pages > 1);

            loadNext();
            setPageLength();
        },
        "columnDefs": [
            {"width": "10px", "targets": 0},
            {"width": "100px", "targets": 1},
            {"width": "100px", "targets": 2},
            {"width": "100px", "targets": 3},
            {"width": "100px", "targets": 4},
            {"width": "100px", "targets": 5}
        ],
        "columns": [{
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }, {
                "width": "30%"
            }],
    }).columns.adjust();

    function setPageLength() {
        $.extend(true, $.fn.dataTable.defaults, {
            pageLength: dyn_count
        });
    }

    $(document).on('click', '.getFunderRow', function () {
        var id = $(this).attr('id');
        var view_id = $('#viewRow_' + id).val();
        if (view_id == '') {
            $('.tlf_' + id).removeClass('display-none');
            $('#viewRow_' + id).val('1');
        } else {
            $('.tlf_' + id).addClass('display-none');
            $('#viewRow_' + id).val('');
        }
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $(document).on('click', '#search_btn', function () {
        //$("#set_export").val('0');
        //$("#summary_search").submit();
    });

    $(document).on('click', '.delete_cls', function () {
        var cur_attr = $(this).attr("data-chk-attr");
        $('#delCount').val('');
        var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
        $('#delCount').html(sel_item);
        $('#deleteModal').modal('show');
    });

    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy"
    });

    $(document).on('change', '#type', function () {

        //status_type
        var type_value = this.value;
        $(".grant_status").prop('disabled', true);
        $(".start_date").prop('disabled', true);
        $(".end_date").prop('disabled', true);
        if (type_value == 'funder') {
            $(".funder_name").prop('disabled', false);
            $(".start_date").prop('disabled', true);
            $(".end_date").prop('disabled', true);

            $("#start_date").css('display', 'none');
            $("#start_date").css('display', 'none');

        } else if (type_value == 'grant_name' || type_value == 'grant_amount' || type_value == 'amount_received' || type_value == 'total_utilized') {
            $(".start_date").prop('disabled', true);
            $(".end_date").prop('disabled', true);

            $("#start_date").css('display', 'none');
            $("#end_date").css('display', 'none');
        } else if (type_value == 'start_date') {
            $(".start_date").prop('disabled', false);
            $(".end_date").prop('disabled', true);

            $("#start_date").css('display', 'inline-block');
            $("#end_date").css('display', 'none');

        } else if (type_value == 'end_date') {
            $(".end_date").prop('disabled', false);
            $(".start_date").prop('disabled', true);

            $("#end_date").css('display', 'inline-block');
            $("#start_date").css('display', 'none');

        } else if (type_value == 'grant_status') {
            $(".start_date").prop('disabled', true);
            $(".end_date").prop('disabled', true);

            $("#start_date").css('display', 'none');
            $("#end_date").css('display', 'none');
        } else {
            $(".start_date").prop('disabled', true);
            $(".end_date").prop('disabled', true);
            $("#start_date").css('display', 'none');
            $("#end_date").css('display', 'none');
        }
        //$("#summary_search").valid();
    });



    $(document).ready(function () {

        // alert('<?php $arr_cnts; ?>');
        $(document).on('click', '#export_summary', function () {
            $("#set_export").val('1');
            $("#summary_search").submit();
        });
        $(document).on('click', '.delete_cls', function () {
            var cur_attr = $(this).attr("data-chk-attr");
            $('#delCount').val('');
            var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
            $('#delCount').html(sel_item);
            if (sel_item > 0) {
                //$('#deletemodal').modal('show');
            }
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
            if ($('input:checkbox.common_checkbox:checked').length > 0) {
                $(".master_deluser").addClass("clr_red none-pointer");
                $(".master_deluser").removeClass("none-pointer");
            } else {
                $(".master_deluser").removeClass("clr_red");
                $(".master_deluser").addClass("none-pointer");
            }
        });
        $(document).on('click', '.tbl_checkbox', function () {
            if (this.checked) {
                var attr_type = $(this).attr('data-attr-type');
                var attr_val = $(this).attr('data-attr');
                if (attr_type == 'parent') {
                    $('.' + attr_val).prop('checked', true);
                } else if (attr_type == 'child') {
                    var attr_type = $(this).attr('data-attr-type');
                    var split_attr_val = attr_val.substr(6);
                    unchecked_length = $('input:checkbox.child' + split_attr_val).length;
                    checked_length = $('input:checkbox.child' + split_attr_val + ':checked').length;
                    if ($('input:checkbox.child' + split_attr_val).length == $('input:checkbox.child' + split_attr_val + ':checked').length) {
                        $('.' + attr_val).prop('checked', true);
                    } else {
                        $('.' + attr_val).prop('checked', false);
                    }
                }
            } else if (!this.checked) {
                var attr_type = $(this).attr('data-attr-type');
                var attr_val = $(this).attr('data-attr');
                if (attr_type == 'parent') {
                    $('.' + attr_val).prop('checked', false);
                } else if (attr_type == 'child') {
                    var attr_type = $(this).attr('data-attr-type');
                    var split_attr_val = attr_val.substr(6);
                    unchecked_length = $('input:checkbox.child' + split_attr_val).length;
                    checked_length = $('input:checkbox.child' + split_attr_val + ':checked').length;
                    if ($('input:checkbox.child' + split_attr_val).length == $('input:checkbox.child' + split_attr_val + ':checked').length) {
                        $('.' + attr_val).prop('checked', true);
                    } else {
                        $('.' + attr_val).prop('checked', false);
                    }
                }
            }

            if ($('input:checkbox.tbl_checkbox').length != $('input:checkbox.tbl_checkbox:checked').length) {
                $('.common_checkbox').prop('checked', false);
            } else {
                $('.common_checkbox').prop('checked', true);
            }
            if ($('input:checkbox.tbl_checkbox:checked').length > 0) {

                $(".master_deluser").addClass("clr_red none-pointer");
                $(".master_deluser").removeClass("none-pointer");
            } else {

                $(".master_deluser").removeClass("clr_red none-pointer");
                $(".master_deluser").addClass("none-pointer");
            }

        });
        $(document).on('click', '#editSubmit', function () {
            $('#deleteModal').modal('hide');
            $(".delete_cls").addClass("none-pointer");
            $(".delete_cls").removeClass("clr_red");
            $("#delete_summay_list").submit();
        });
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
    });
</script>