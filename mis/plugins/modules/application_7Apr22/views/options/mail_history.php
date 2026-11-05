<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'All Mails - ' . $innovation['name_of_enterprise'], 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'mail_history', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span> -->
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                </div>
                <div class="tab-slider--navform">
                    <ul class="tab-slider--tabsform">
                        <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/application/mail_history/' . $application_id; ?>">All Mails</a></li>
                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/application/external_mail/' . $application_id; ?>">Add External Mail</a></li>
                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/application/send_mail/' . $application_id; ?>">Send Mail</a></li>
                    </ul>
                </div>

                <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                            <form method="post" id="mail_history_search" autocomplete="off">
                                <input type="hidden" name="innovation" id="innovation" value="<?= $application_id; ?>">
                                <div class="row leaveLabel">
                                    <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                        <div class="form-group">
                                            <label>Option</label>
                                            <select class="form-control" name="txt_option">
                                                <option value="">--Select--</option>
                                                <option value="1">Internal</option>
                                                <option value="2">External</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                        <div class="form-group">
                                            <label>Mail type</label>
                                            <input class="form-control" type="text" name="mail_type" placeholder="Enter type">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                        <div class="form-group">
                                            <label>From date</label>
                                            <input class="startDat form-control form-control-sm dateCalendar" type="text" name="start_date" id="start_date" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                        <div class="form-group">
                                            <label>To date</label>
                                            <input class="endDat form-control form-control-sm dateCalendar" type="text" name="end_date" id="end_date" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                        <div style="height: 15px;"></div>
                                        <ul class="vitals-links">
                                            <li><a href="" class="vital_yellow_btn pad-hr15">Search</a></li>
                                            <li><span class="vitals_clearSearch">Clear search</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>

                            <div style="height:20px"></div>
                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-titl">
                                    <div class="row  d_v_d_c">
                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                            <h6>Internal Mail</h6>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                    <table class="table table-hover dt-responsive" id="internal_list">
                                        <thead>
                                            <tr>
                                                <!-- <th width="6%"><input type='checkbox' class='form-control internal_checkAll' onchange="internal_checkAll();"></th> -->
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Sent Date</th>
                                                <th>Mail Type</th>
                                                <th>Subject</th>
                                                <th>View</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd">
                                                <td valign="top" colspan="11" class="dataTables_empty text-center">No data available in table</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div style="height:20px"></div>
                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-titl">
                                    <div class="row  d_v_d_c">
                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                            <h6>External Mail</h6>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                    <table class="table table-hover dt-responsive" id="external_list">
                                        <thead>
                                            <tr>
                                                <!-- <th width="6%"><input type='checkbox' class='form-control external_checkAll' onchange="external_checkAll();"></th> -->
                                                <th>To</th>
                                                <th>Subject</th>
                                                <th>Body</th>
                                                <th>Sent On</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd">
                                                <td valign="top" colspan="11" class="dataTables_empty text-center">No data available in table</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </main>
                </div>
            </div>

        </main>
    </div>
</div>
</div>
</div>

<div class="modal" id="mailModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title">
                    <span class="text-success"><i class="far fa-envelope"></i></span>&nbsp;&nbsp;View Mail History
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body onboarding-permission text-center vitalMasterDataTbl">
                <table style="width:100%" id="table1" class="gtable dataTable sortable">
                    <tbody>
                        <tr class="odd">
                            <td align="left" valign="middle"><strong>From</strong></td>
                            <td align="left" valign="middle" id="fromValue"></td>
                        </tr>
                        <tr class="even">
                            <td align="left" valign="middle"><strong>To</strong></td>
                            <td align="left" valign="middle" id="toValue"></td>
                        </tr>
                        <tr class="odd">
                            <td align="left" valign="middle"><strong>Subject</strong></td>
                            <td align="left" valign="middle" id="subjectValue"></td>
                        </tr>
                        <tr class="even">
                            <td align="left" valign="middle"><strong>Mail Type</strong></td>
                            <td align="left" valign="middle" id="typeValue"></td>
                        </tr>
                        <tr class="odd">
                            <td align="left" valign="middle" colspan="2" id="bodyValue"></td>
                        </tr>
                    </tbody>
                </table>
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
                            <h4>Are you sure you want to delete selected item?</h4>
                            <p>you are about to delete the selected information fields, you
                            can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="inv_id" id="inv_id" />
                <input type="hidden" name="mail_id" id="mail_id" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    function mailDetails(id) {
        $('#mailModal').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/application/viewMailHistory",
            data: {id: id},
            dataType: 'html',
            success: function (msg) {
                var mail_arr = JSON.parse(msg);
                $('#fromValue').html(mail_arr[0].from);
                $('#toValue').html(mail_arr[0].to);
                $('#subjectValue').html(mail_arr[0].subject);
                $('#typeValue').html(mail_arr[0].mail_type);
                $('#bodyValue').html(mail_arr[0].body);
            },
        });
    }

    function deleteMail(inv_id, id) {
        $('#deletemodal').modal('show');
        $('#inv_id').val(inv_id);
        $('#mail_id').val(id);
    }

    $(document).on('click', '#deleteRecord', function () {
        var inv_id = $('#inv_id').val();
        var mail_id = $('#mail_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/application/deleteMailHistory/' + inv_id + '/' + mail_id;
    });

    $(document).ready(function () {
        $('#internal_list').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "bDestroy": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "pageLength": 10,
            "searching": false,
            "lengthChange": false,
            "stateSave": false,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/application/DT_internalMail",
                "data": {"innovation": "<?php echo $application_id; ?>"},
                "type": "POST"
            },
            drawCallback: function () {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                // var table = $('#internal_list').dataTable();
                // var data_len = table.fnGetData().length;
                // if (data_len == 0) {
                //     $('.design_checkAll').hide();
                //     $('tr td:first-child').addClass('none-pointer');
                // }

                $('.design_checkAll').prop('checked', false);
                $('.designation_His_del').removeClass('clr_red');
                $('.designation_His_del').addClass('none-pointer');
                $('#internal_list tr td:first-child').css('text-align', 'center');
            },
            // 'columnDefs': [{
            //     'orderable': false,
            //     'targets': [0]
            // }],
            "order": [0, 'desc']
        });

        $('#external_list').DataTable({
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
                "url": "<?php echo base_url(); ?>index.php/application/DT_externalMail",
                "data": {"innovation": "<?php echo $application_id; ?>"},
                "type": "POST"
            },
            drawCallback: function () {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                // var table = $('#external_list').dataTable();
                // var data_len = table.fnGetData().length;
                // if (data_len == 0) {
                //     $('.design_checkAll').hide();
                //     $('tr td:first-child').addClass('none-pointer');
                // }

                $('.design_checkAll').prop('checked', false);
                $('.designation_His_del').removeClass('clr_red');
                $('.designation_His_del').addClass('none-pointer');
                $('#external_list tr td:first-child').css('text-align', 'center');
            },
            // 'columnDefs': [{
            //     'orderable': false,
            //     'targets': [0]
            // }],
            "order": [0, 'desc']
        });

        datepickerEachFunction();
    });

    function datepickerEachFunction() {
        $("#start_date").datepicker({
            onSelect: function (selected) {
                $("#start_date").datepicker("option", "dateFormat", 'mm/dd/yy');
                $("#end_date").val('');
                var dt = new Date(selected);
                var dateval = dt.getDate();
                var monthval = dt.getMonth() + 1;
                var yearval = dt.getFullYear();
                if (monthval < 10) {
                    monthval = "0" + monthval;
                } else {
                    monthval = monthval;
                }
                if (dateval < 10) {
                    dateval = "0" + dateval;
                } else {
                    dateval = dateval;
                }
                var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                $("#start_date").val(fulldatevalue);
                dt.setDate(dt.getDate() + 1);
                $("#end_date").datepicker("option", {minDate: dt});
            }
        });

        $("#end_date").datepicker({
            onSelect: function (selected) {
                var dt = new Date(selected);
                var dateval = dt.getDate();
                var monthval = dt.getMonth() + 1;
                var yearval = dt.getFullYear();
                if (monthval < 10) {
                    monthval = "0" + monthval;
                } else {
                    monthval = monthval;
                }
                if (dateval < 10) {
                    dateval = "0" + dateval;
                } else {
                    dateval = dateval;
                }
                var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                $("#end_date").val(fulldatevalue);
                dt.setDate(dt.getDate() - 1);
            }
        });
    }

</script>

</body>
</html>