
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Employee - Education info')); ?>
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
                        <span><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?= $employee[0]['emp_name']; ?></h4>
                        <?php $emp_id = $this->session->userdata('emp_number'); ?>
                    </div>                   
                </div>

                <?php
                $menu_access = explode(',', $employee_detail[0]['tab_access']);
                $bank_opacity = $depent_opacity = $edu_opacity = $immig_opacity = $job_opacity = $report_opacity = $doc_opacity = '';
                $bank_blur = $depent_blur = $edu_blur = $immig_blur = $job_blur = $report_blur = $doc_blur = '';
                if (in_array('1', $menu_access)) {
                  $bank_menu_url = base_url() . 'index.php/myprofile/bank/' . $emp_id;
              } else {
                  $bank_menu_url = 'javascript:void(0);';
                  $bank_opacity = 'opacity5 nocursor';
                  $bank_blur = 'menu-blur';
              }

              if (in_array('2', $menu_access)) {
                  $depent_menu_url = base_url() . 'index.php/myprofile/dependents/' . $emp_id;
              } else {
                  $depent_menu_url = 'javascript:void(0);';
                  $depent_opacity = 'opacity5 nocursor';
                  $depent_blur = 'menu-blur';
              }

              if (in_array('3', $menu_access)) {
                  $edu_menu_url = base_url() . 'index.php/myprofile/education/' . $emp_id;
              } else {
                  $edu_menu_url = 'javascript:void(0);';
                  $edu_opacity = 'opacity5 nocursor';
                  $edu_blur = 'menu-blur';
              }

              if (in_array('4', $menu_access)) {
                  $immig_menu_url = base_url() . 'index.php/myprofile/immigration/' . $emp_id;
              } else {
                  $immig_menu_url = 'javascript:void(0);';
                  $immig_opacity = 'opacity5 nocursor';
                  $immig_blur = 'menu-blur';
              }

              if (in_array('5', $menu_access)) {
                  $job_menu_url = base_url() . 'index.php/myprofile/job/' . $emp_id;
              } else {
                  $job_menu_url = 'javascript:void(0);';
                  $job_opacity = 'opacity5 nocursor';
                  $job_blur = 'menu-blur';
              }

              if (in_array('6', $menu_access)) {
                  $report_menu_url = base_url() . 'index.php/myprofile/reporting/' . $emp_id;
              } else {
                  $report_menu_url = 'javascript:void(0);';
                  $report_opacity = 'opacity5 nocursor';
                  $report_blur = 'menu-blur';
              }

              if (in_array('7', $menu_access)) {
                  $doc_menu_url = base_url() . 'index.php/myprofile/document/' . $emp_id;
              } else {
                  $doc_menu_url = 'javascript:void(0);';
                  $doc_opacity = 'opacity5 nocursor';
                  $doc_blur = 'menu-blur';
              }
              ?>
              
              <div class="plan-structure-vital vital_windowScroll">
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>">Personal</a></li>
                                <li role="presentation"><a href="<?php echo $report_menu_url; ?>">Reporting</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                                <li role="presentation"><a href="<?php echo $depent_menu_url; ?>">Dependents</a></li>
                                <li role="presentation"><a href="<?php echo $immig_menu_url; ?>">Immigration</a></li>
                                <li role="presentation"><a href="<?php echo $job_menu_url; ?>">Job & Salary</a></li>
                                <li role="presentation"><a href="<?php echo $bank_menu_url; ?>">Bank</a></li>
                                <li role="presentation" class="active"><a href="javascript:void(0)">Education</a></li>
                                <li role="presentation"><a href="<?php echo $doc_menu_url; ?>">Document</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new ">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <h4 class="vitals_innerSub">Education Details</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <ul class="vitals-links ">
                                            <li>
                                                <a href="<?php echo base_url() . 'index.php/myprofile/add_education/' . $emp_id; ?>" class="pad-none master_aduser"><i class="fas fa-plus-circle"></i> Add Education</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="mar-vr10 master_deluser pad-none none-pointer" id="delEducation"><i class="fas fa-trash-alt"></i> Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 designation_His_table vitalMasterDataTbl">
                                        <table class="table table-hover dt-responsive" id="education_list">
                                            <thead>
                                                <tr>
                                                    <th width="6%"><input type='checkbox' class='form-control data_checkAll' onchange="select_checkAll();" ></th>
                                                    <th>Qualification</th>
                                                    <th>Institute Name</th>
                                                    <th>GPA/Score</th>
                                                    <th>City/State</th>
                                                    <th>Year Range</th>
                                                    <th>Years</th>
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
            $('#backPage').attr('href', link);
        }

        $('#education_list').DataTable({
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
                "url": "<?php echo base_url(); ?>index.php/myprofile/DT_education",
                "data": {"employee_id": "<?php echo $emp_id; ?>"},
                "type": "POST"
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#education_list tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var slug = $(":checkbox:eq(0)", this).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/myprofile/edit_education/' + slug);
                        window.location = $(this).attr('href');
                        return false;
                    }
                });
            },
            drawCallback: function () {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#education_list').dataTable();
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
            "order": [1, 'desc']
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

    $(document).on('click', '#education_chk_box', function () {
        var edu_check = $('.chk_box:checkbox:checked').length;
        if ($('.chk_box:checked').length == $('.chk_box').length) {
            $('.data_checkAll').prop('checked', true);
        } else {
            $('.data_checkAll').prop('checked', false);
        }

        if (edu_check > 0) {
            $('.master_deluser').addClass('clr_red');
            $('.master_deluser').removeClass('none-pointer');
        } else {
            $('.master_deluser').removeClass('clr_red');
            $('.master_deluser').addClass('none-pointer');
        }
    });

    $(document).on('click', '#delEducation', function () {
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
                table: 'hr_user_education',
                field: 'status'
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
            }
        });
    });

</script>

</body>
</html>