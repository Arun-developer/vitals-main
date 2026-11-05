<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Add Donor Amount', 'page_table' => 'datatable')); ?>
<div class="display-hide deleteMsg">
    <div class="position-absolute d-flex flex-column p-4 toastPlace">
        <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
                <div class="toast deletetoast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-success text-white">
                        <strong class="mr-auto">Record(s) deleted successfully</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="text-white">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'budget_master')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Action History</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 10px;"></div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover" id="master_table">
                                                <thead>
                                                    <tr>
                                                        <th>Programme</th>
                                                        <th>Donor</th>
                                                        <th>Grant</th>
                                                        <th>Budget head</th>
                                                        <th>Line Item</th>
                                                        <th>Operation</th>
                                                        <th>Amount (<?= $this->session->userdata['currency']; ?>)</th>
                                                        <th>Amount Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($history_action as $actionlist) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $actionlist['programme']; ?></td>
                                                            <td><?= $actionlist['master_name']; ?></td>
                                                            <td><?= $actionlist['grant_name']; ?></td>
                                                            <td><?= $actionlist['budget_head']; ?></td>
                                                            <td><?= $actionlist['line_item']; ?></td>
                                                            <td><?= $actionlist['operation']; ?></td>
                                                            <td><?= formatnumber($actionlist['amount']); ?></td>
                                                            <td><?= date('d-m-Y', strtotime($actionlist['amount_date'])); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
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

<script type="text/javascript">
    $(document).ready(function () {
        master_trigger();
    });

    function master_trigger() {
        $('#master_table').DataTable({
            "bProcessing": true,
            "bSortable": true,
            "paging": true,
            // "ordering": true,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 10,
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

            },
            /* 'columnDefs': [{
             'orderable': false,
             'targets': [0],
             }], */
            "order": [1, 'asc']
        });
    }

</script>

</body>
</html>