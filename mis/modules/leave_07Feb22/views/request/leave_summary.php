<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Leave - Leave Allocation', 'page_table' => 'datatable', 'module' => 'leave_summary'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php
                if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                    $this->load->view('master_sidemenu.php', array('left_menu' => 'approve', 'page' => 'leave_allocation', 'supervisor' => $chk_sup, 'approval_count' => $approval_count));
                } else {
                    $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'leave', 'supervisor' => $chk_sup, 'approval_count' => $approval_count));
                }
                ?>

            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Leave Allocation</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <?php
                        if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                            ?>
                            <div class="row justify-content-end display-hide" id="editbtn">
                                <div class="col-12 col-sm-12  col-md-12 text-right">
                                    <div class="text-right addActiveClass ">
                                        <ul class="vitals-links ">
                                            <li class="summary_edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <ul class="vitals-links saveLinkView display-hide" id="savebtn">
                            <li><a href="javascript:void(0)" onclick="submit_summary();" class="wdt_100 vital_yellow_btn">Save</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>" class="wdt_100 backPage vital_bordered_btn">Cancel</a></li>
                        </ul>
                    </div>
                </div>
                <div class="">
                    <div>
                        <?php if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') { ?>
                            <div class="tab-slider--navform">
                                <ul class="tab-slider--tabsform">
                                    <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>">New Leave Request</a></li>
                                    <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>">Leave Allocation</a></li>
                                    <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>">Leave Requests</a></li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') { ?>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>Year</label>
                                                    <select class="form-control" name="filter_year" id="filter_year">
                                                        <?php foreach ($fin_year as $f_years) { ?>
                                                            <option value="<?= $f_years['fin_year']; ?>"><?= $f_years['fin_year']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>Leave Type</label>
                                                    <select class="form-control" name="filter_leavetype" id="filter_leavetype">
                                                        <option value="all">All</option>
                                                        <?php foreach ($leave_types as $ltypes) { ?>
                                                            <option value="<?= $ltypes['leave_type_id'] ?>"><?= $ltypes['leave_type_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>User Type</label>
                                                    <select class="form-control" name="filter_usertype" id="filter_usertype" onchange="loadEmployee(this.value);">
                                                        <option value="all">All Employees</option>
                                                        <?php foreach ($user_types as $types) { ?>
                                                            <option value="<?= $types['id'] ?>"><?= $types['user_type'] ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2 col-md-2">
                                                <div class="form-group">
                                                    <label>Employee Name</label>
                                                    <div class="ui-widget">
                                                        <select class="form-control" name="filter_empname" id="combobox">
                                                            <option value="">Select Employee Name</option>
                                                            <?php foreach ($users_list as $users) { ?>
                                                                <option value="<?= $users['employee_id'] ?>"><?= $users['emp_firstname'] . ' ' . $users['emp_lastname']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-4 col-md-4 col-12 ">
                                                <div style="height: 15px;"></div>
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:" class="wdt_100 vital_yellow_btn view_summary">Search</a></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>" class="vitals_clearSearch" >Clear search</a></li>
                                                    <li><a href="javascript:void(0)" onclick="summary_export();" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl display-hide view_summary_table">
                                            <div class="table-responsive">
                                                <table class="table table-hover dt-responsive" id="leave_summary_table">
                                                    <thead >
                                                        <tr>
                                                            <?php
                                                            if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                                                                ?>
                                                                <th width="20%">Employee Name</th>
                                                            <?php } ?>
                                                            <th width="10%">Type</th>
                                                            <th width="10%">Entitled <small>(days)</small></th>
                                                            <th width="10%">Scheduled <small>(days)</small></th>
                                                            <th width="10%">Taken <small>(days)</small></th>
                                                            <th width="10%">Carry Forward <small>(days)</small></th>
                                                            <th width="10%">Encashed <small>(days)</small></th>
                                                            <th width="10%">Remaining <small>(days)</small></th>
                                                            <th width="10%">Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="vital_tablescroll ">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="edited_summary[]" id="edited_summary" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
</div>

<style type="text/css">
    .plan-structure-vital {
        height: 400px !important;
        overflow-y: scroll;
        overflow-x: hidden;
        overscroll-behavior: contain !important;
    }
    ul.multiselect-container.dropdown-menu.show {
        min-width: 145px;
    }
    .vital_tablescroll{
        overflow: auto;
    }
    table.dataTable thead .sorting_desc:after {
        position: absolute;
        top: 10px;
        right: -3px;
        display: block;
        font-family: 'Glyphicons Halflings';
        opacity: 0.5;
    }
    table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting:after{
        top: 10px;
        right: 0px;
    }
    .plan-structure-new {
        overflow-y: auto;
        overflow-x: hidden;
        overscroll-behavior: contain !important;
    }
    .vital_yellow_btn{
        margin:0px 3px;
    }
    .page-wrapper .page-content .dataconfig.d_v_d_c {
        padding: 10px !important;
    }

    .tab-slider--body {
        margin-bottom: 0px;
    }
    .inputplan-structureall {
        padding: 15px 20px 0px;
    }
    .vital_bordered_btn,.vital_yellow_btn{
        margin: 0px 3px;
    }
    table.dataTable{
        margin-top: 0 !important;
    }
    .vitalMasterDataTbl table.dataTable thead th{
        padding: .5rem .75rem !important;
    }

</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#filter_usertype").val(3);
        loadEmployee(3);
        $(".view_summary").trigger("click");
        $('.plan-structure-new').css({
            <?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') { ?>
                'height': (($(window).height()) - 180) + 'px'
            <?php } else { ?>
                'height': (($(window).height()) - 210) + 'px'
            <?php } ?>
        });

        <?php
        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            ?>
            $('.view_summary_table').removeClass("display-hide");
            $(".view_summary_table").addClass("display-show");
            leave_summary_trigger();
            <?php
        }
        ?>

        setTimeout(function () {
            $('#success-msg').addClass('display-hide');
        }, 3000);
    });
    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on("keyup", ".custom-combobox-input", function (event) {
        if (event.keyCode === 13) {
            $(".view_summary").trigger("click");
        }
    });

    function loadEmployee(usertype) {
        $(".custom-combobox-input").val('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/leave/load_employee",
            data: {
                usertype: usertype,
            },
            dataType: 'html',
            success: function (msg) {
                $('#combobox').html(msg);
            }
        });
    }

    function leave_summary_trigger() {
        $('#edited_summary').val('');
        var filter_year = $('#filter_year').val();
        var filter_leavetype = $('#filter_leavetype').val();
        var filter_usertype = $('#filter_usertype').val();
        var filter_empname = $('#combobox').val();
        <?php
        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            ?>
            var ordr_tble = [1, 2, 3, 4, 5, 6, 7];
            var center_tbl = [2, 6];
        <?php } else { ?>
            ordr_tble = [1, 2, 3, 4, 5, 6, 7, 8];
            center_tbl = [3, 7];
        <?php } ?>

        $('#leave_summary_table').DataTable({
            "scrollX": true,
            fixedHeader: true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            },
            columnDefs: [{
                orderable: false,
                targets: ordr_tble
            },
            {
                targets: center_tbl,
                className: 'dt-body-center'
            }],
            destroy: true,
            responsive: true,
            "bProcessing": true,
            "bServerSide": true,
            "paging": true,
            scrollY: '338px',
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 1,
            "lengthChange": false,
            "stateSave": false,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/leave/DTleavesummary",
                "type": "POST",
                "data": {
                    "filter_year": filter_year,
                    "filter_leavetype": filter_leavetype,
                    "filter_usertype": filter_usertype,
                    "filter_empname": filter_empname
                }
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            }
        });
    }

    $('.view_summary').click(function () {
        $('.view_summary_table').removeClass("display-hide");
        $(".view_summary_table").addClass("display-show");
        $('.edit_export').removeClass("display-hide");
        $('.summary_edit').removeClass("display-hide");
        $(".summary_edit").addClass("display-show");
        $('#editbtn').addClass('display-show');
        $('#savebtn').addClass('display-hide');
        $('#savebtn').removeClass('display-show');
        leave_summary_trigger();
    });

    $('.summaryEdit').click(function () {
        $("input").attr("disabled", false);
        $('.addActiveClass li:first-child a').addClass("greentab");

        $('#savebtn').addClass('display-show');
        $('#savebtn').removeClass('display-hide');

        $('#editbtn').removeClass('display-show');
        $('#editbtn').addClass('display-hide');
    });

    function save_summary(leave_id) {
        var leave_arr = $('#edited_summary').val();
        var arr = leave_arr.split(',');

        var idx = $.inArray(leave_id, arr);
        if (idx === -1) {
            arr.push(leave_id)
            arr.join(',')
            $('#edited_summary').val(arr);
        }
    }

    function submit_summary() {
        var larr = [];
        var leave_arr = $('#edited_summary').val();
        var arr = leave_arr.split(',');
        for (var i = 0; i < arr.length; i++) {
            if (larr.indexOf(arr[i]) == -1) {
                larr.push(arr[i]);
            }
        }

        for (var j = 0; j < larr.length; j++) {
            if (larr[j] != '') {
                var filter_year = $('#filter_year').val();
                var leave_type = $('#leave_type_' + larr[j]).val();
                var leave_empname = $('#leave_employee_' + larr[j]).val();
                var leave_entitled = $('#leave_entitled_' + larr[j]).val();
                var leave_summary_comments = $('#leave_summary_comments_' + larr[j]).val();
                var leave_brought_forward = $('#leave_brought_forward_' + larr[j]).val();
                var leave_encashed = $('#leave_encashed_' + larr[j]).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/leave/add_leave_summary",
                    data: {
                        leave_year: filter_year,
                        leave_type: leave_type,
                        leave_employee: leave_empname,
                        leave_entitled: leave_entitled,
                        leave_brought_forward: leave_brought_forward,
                        leave_encashed: leave_encashed,
                        leave_summary_comments: leave_summary_comments,
                        leave_summary_id: larr[j],
                    },
                    dataType: 'json',
                    success: function () {
                        location.reload();
                        // $('.toast').toast('show');
                        // $('.deleteMsg').removeClass('display-hide');
                        // setTimeout(function () {
                        //     leave_summary_trigger();
                        //     $('#editbtn').removeClass('display-hide');
                        //     $('#editbtn').addClass('display-show');

                        //     $('#savebtn').addClass('display-hide');
                        //     $('#savebtn').removeClass('display-show');
                        // }, 3000);
                    }
                });
            }
        }
    }

    function summary_export() {
        var filter_year = $('#filter_year').val();
        var filter_leavetype = $('#filter_leavetype').val();
        var filter_usertype = $('#filter_usertype').val();
        var filter_empname = $('#combobox').val();
        var url = "<?php echo base_url(); ?>index.php/leave/leavesummary_export/" + filter_year + '/' + filter_leavetype + '/' + filter_usertype + '/' + filter_empname;
        window.location.href = url;
    }

    $(document).on("input", '.leave_decimal', function (evt) {
        var self = $(this);
        var newValue = $(this).val();
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57) || hasDecimalPlace(newValue, 3)) {
            evt.preventDefault();
        }
    });

    function hasDecimalPlace(value, x) {
        var pointIndex = value.indexOf('.');
        return pointIndex >= 0 && pointIndex < value.length - x;
    }

    $(function () {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                .addClass("custom-combobox")
                .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                // this._createShowAllButton();
            },
            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";

                this.input = $("<input>")
                .appendTo(this.wrapper)
                .val(value)
                .attr("title", "")
                .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                .autocomplete({
                    delay: 0,
                    minLength: 2,
                    source: $.proxy(this, "_source")
                })
                .tooltip({
                    classes: {
                        "ui-tooltip": "ui-state-highlight"
                    }
                });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                    }));
            },
            _removeIfInvalid: function (event, ui) {
                if (ui.item) {
                    return;
                }
                var value = this.input.val(),
                valueLowerCase = value.toLowerCase(),
                valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
                if (valid) {
                    return;
                }
                this.input
                .val("")
                .attr("title", value + " didn't match any item")
                .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },
            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });

        $("#combobox").combobox();
        $("#toggle").on("click", function () {
            $("#combobox").toggle();
        });
    });
</script>

</body>
</html>