<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Leave - Archive Holiday Calendar', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'holiday')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Holiday Details</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right"></div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">Holiday Calendar-Current</a></li>
                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/leave/archive_holiday_calendar'; ?>">Holiday Calendar-Archive</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form method="post" id="holiday_search" autocomplete="off">
                                        <ul class="vitals-links">
                                            <li>Select Year</li>
                                            <li><select class=" form-control" name="filter_year" id="filter_year" onchange="load_year(this.value);">
                                                    <?php foreach ($fin_year as $year) { ?>
                                                        <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                    <?php } ?>
                                                </select></li>
                                        </ul>
                                    </form>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="holiday_table">
                                                <thead>
                                                    <tr>
                                                        <th>Name of Holiday</th>
                                                        <th>Date</th>
                                                        <th>Full Day/Half Day</th>
                                                        <th>Repeat Annually</th>
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
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#holiday_table').DataTable({
            columnDefs: [{orderable: false, targets: [0, 1, 2, 3]}],
            "bProcessing": true,
            "bServerSide": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": false,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/leave/DTholidayarchieve",
                "data": {"year": "<?php echo $current_fy; ?>"},
                "type": "POST"
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            }
        });
    });

    function load_year() {
        $('form#holiday_search').submit();
        return false;
    }

</script>

</body>
</html>