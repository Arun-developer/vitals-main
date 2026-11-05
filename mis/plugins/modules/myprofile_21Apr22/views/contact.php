
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Employee - Contact info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'my_profile')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?= $employee[0]['emp_name']; ?></h4>
                        <?php $emp_id = $this->session->userdata('emp_number'); ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>">Personal</a></li>
                                    <!-- <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/login/' . $emp_id; ?>">Login</a></li> -->
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation" class="active"><a href="javascript:void(0)">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/education/' . $emp_id; ?>">Education</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/document/' . $emp_id; ?>">Document</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container ">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="vitals_innerSub">Contact Details</h4>
                                        </div>
                                    </div>
                                    <form id="contact_form" method="post" action="<?php echo base_url() . 'index.php/myprofile/add_contact'; ?>" autocomplete="off">
                                        <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Personal Email</label>
                                                        <input type="text" class="form-control employeeInput" name="personal_email" value="<?= $employee[0]['personal_email']; ?>" disabled maxlength="50" placeholder="Personal email" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Personal Mobile</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="personal_mobile" value="<?= $employee[0]['personal_mobile']; ?>" maxlength="15" placeholder="Personal mobile" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select class="form-control employeeInput" disabled name="user_country">
                                                            <option value="">-- Select --</option>
                                                            <?php foreach ($country as $c_name) { ?>
                                                                <option value="<?= $c_name['id']; ?>" <?php
                                                                if ($c_name['id'] == $employee[0]['country']) {
                                                                    echo 'selected';
                                                                }
                                                                ?>><?= $c_name['country_name']; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Work Email <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control employeeInput" name="work_email" value="<?= $employee[0]['official_email']; ?>" disabled maxlength="50" placeholder="Official email" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Work Mobile</label>
                                                    <input type="text" class="form-control employeeInput" disabled name="official_mobile" value="<?= $employee[0]['official_mobile']; ?>" maxlength="15" placeholder="Official mobile" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>State/Province</label>
                                                    <input type="text" class="form-control employeeInput" disabled name="user_state" value="<?= $employee[0]['state']; ?>" maxlength="20" placeholder="State" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>ZIP Code</label>
                                                    <input type="text" class="form-control employeeInput" name="user_zipcode" value="<?= $employee[0]['zipcode']; ?>" disabled maxlength="6" placeholder="Zipcode" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Home Telephone</label>
                                                    <input type="text" class="form-control employeeInput" disabled name="home_mobile" value="<?= $employee[0]['home_mobile']; ?>" maxlength="15" placeholder="Home telephone" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control employeeInput" disabled name="user_city" value="<?= $employee[0]['city']; ?>" maxlength="20" placeholder="City" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea class="form-control employeeInput" disabled name="user_address" maxlength="200" placeholder="Address"><?= $employee[0]['address']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4"></div>
                                            <div class="col-12 col-lg-4 col-md-4"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><input type="submit" value="Save" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 valign-bottom">
                                            <h4 class="vitals_innerSub mar-bt0 pad-tp10">Emergency Contact</h4>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 text-right">
                                            <ul class="vitals-links ">
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/myprofile/add_emergency/' . $emp_id; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Emergency</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="master_deluser mar-vr10 none-pointer" id="delEmergency"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 designation_His_table vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="emergency_list">
                                                <thead>
                                                    <tr>
                                                        <th width="6%"><input type='checkbox' class='form-control data_checkAll' onchange="select_checkAll();" ></th>
                                                        <th>Name</th>
                                                        <th>Relationship</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Work Telephone</th>
                                                        <th>Home Telephone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php echo $this->pagination->create_links_new($form_name); ?>
                                                </tbody>
                                            </table>
                                            <div style="height:50px"></div>
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
        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            var link = "<?php echo base_url() . 'index.php/myprofile/lists/'; ?>" + previous_type;
            $('.backPage').attr('href', link);
        }

        $('#emergency_list').DataTable({
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
                "url": "<?php echo base_url(); ?>index.php/myprofile/DT_emergency",
                "data": {
                    "employee_id": "<?php echo $emp_id; ?>"
                },
                "type": "POST"
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#emergency_list tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var slug = $(":checkbox:eq(0)", this).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/myprofile/edit_emergency/' + slug);
                        window.location = $(this).attr('href');
                        return false;
                    }
                });
            },
            drawCallback: function () {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#emergency_list').dataTable();
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
                    'targets': [0]
                }],
            "order": [1, 'asc']
        });
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

    $(document).on('click', '#contact_chk_box', function () {
        var emer_check = $('.chk_box:checkbox:checked').length;
        if ($('.chk_box:checked').length == $('.chk_box').length) {
            $('.data_checkAll').prop('checked', true);
        } else {
            $('.data_checkAll').prop('checked', false);
        }

        if (emer_check > 0) {
            $('.master_deluser').addClass('clr_red');
            $('.master_deluser').removeClass('none-pointer');
        } else {
            $('.master_deluser').removeClass('clr_red');
            $('.master_deluser').addClass('none-pointer');
        }
    });

    $(document).on('click', '#delEmergency', function () {
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
            url: "<?php echo base_url(); ?>index.php/myprofile/deleteUserData",
            data: {
                id: del_id,
                table: 'hr_user_emergency_contact',
                field: 'status'
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
            }
        });
    });

    $('.summaryEdit').click(function () {
        $(".employeeInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    })

    $('#contact_form').validate({
        rules: {
            personal_email: {
                email: true
            },
            work_email: {
                required: true,
                email: true
            }
        },
        messages: {
            personal_email: {
                email: "Enter a valid email"
            },
            work_email: {
                required: "Enter email",
                email: "Enter a valid email"
            }
        }
    });
</script>

</body>
</html>