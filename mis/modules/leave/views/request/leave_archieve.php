<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Leave - Leave Archive', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'leave', 'supervisor' => $chk_sup)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Leave Archive</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                    $current_year = date('Y');
                                    $loop_year = isset($emp_detail[0]['created_year']) && $emp_detail[0]['created_year'] != '' ? $emp_detail[0]['created_year'] : ($current_year - 10);
                                    for ($i = $current_year; $i >= $loop_year; $i--) {
                                        if ($i == $selected_yr) {
                                            $active_yr = 'active';
                                        } else {
                                            $active_yr = '';
                                        }
                                        ?>
                                        <li class="tab-slider--triggerform <?= $active_yr; ?>"><a href="<?php echo base_url() . 'index.php/leave/leave_archieve/' . $i; ?>"><?= $i; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="archieve_table">
                                                <thead>
                                                    <tr>
                                                        <th>Date Applied</th>
                                                        <th>Total No of Days</th>
                                                        <th>Leave Date</th>
                                                        <th>Leave Reason</th>
                                                        <th>Leave Type</th>
                                                        <th>Leave Status</th>
                                                        <th>Approved Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($leaves_list as $list) {
                                                        if (php72_cmp($list['leave_status']) == 0) {
                                                            $status = 'Pending Approval';
                                                        } else if (php72_cmp($list['leave_status']) == 1) {
                                                            $status = 'Approved';
                                                        } else if (php72_cmp($list['leave_status']) == 2) {
                                                            $status = 'Taken';
                                                        } else if (php72_cmp($list['leave_status']) == 3) {
                                                            $status = 'Rejected';
                                                        } else if (php72_cmp($list['leave_status']) == 4) {
                                                            $status = 'Cancelled';
                                                        }

                                                        if (php72_cmp($list['leave_approval_date']) != 0 && $list['leave_approval_date'] != '') {
                                                            $approval_date = date('d-M-Y', strtotime($list['leave_approval_date']));
                                                        } else {
                                                            $approval_date = '--';
                                                        }
                                                        ?>
                                                        <tr >
                                                            <td><?= date('d-M-Y', strtotime($list['leave_applied_date'])) ?></td>
                                                            <td><?= $list['leave_length_days'] ?></td>
                                                            <td><?= date('d-M-Y', strtotime($list['leave_date'])) ?></td>
                                                            <td><?= $list['leave_comments'] ?></td>
                                                            <td><?= $list['leave_type_name'] ?></td>
                                                            <td><?= $status; ?></td>
                                                            <td><?= $approval_date; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script>
    $('#archieve_table').DataTable({
        "info": false,
        "searching": false,
        "lengthChange": false,
        "ordering": false,
        "pageLength": 10,
        // "scrollX": true,
        "initComplete": function (settings, json) {
            $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
        },
        drawCallback: function (settings) {
            var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
            pagination.toggle(this.api().page.info().pages > 1);
        }
        // columnDefs: [ { orderable: false, targets: [0,5,7,8]}],
    });

    (function () {
        'use strict';
        $(activate);
        function activate() {
            $('.nav-tabs')
                    .scrollingTabs({
                        enableSwiping: true
                    })
                    .on('ready.scrtabs', function () {
                        $('.tab-content').show();
                    });
        }
    }());

</script>

</body>
</html>