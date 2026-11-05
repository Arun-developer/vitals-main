<?php
$this->load->view('vitals_noheader.php', array('main_menu' => 'portfolio', 'page_title' => $cpagetitle));
?>
<?php
$successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
$errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
if ($successMsg != '') {
    ?>
    <div class="position-absolute d-flex flex-column p-4 toastPlace toasterHide">
        <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-success text-white">
                        <strong><?= $successMsg; ?></strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="text-white">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($errorMsg != '') {
    ?>
    <div class="position-absolute d-flex flex-column p-4 toastPlace toasterHide">
        <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-danger text-white">
                        <strong><?= $errorMsg; ?></strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="text-white">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row" style="margin: 10px;">
        <div class="col-lg-12 col-xl-12 col-md-12 col-12 pad-lf0 ">
            <main class="page-content" style="height: 320px;">
                <div class="row dataconfig d_v_d_c">
                    <h4>Comments</h4>
                </div>
                <div class="plan-structure-vital1 vital_windowScroll" style="height: 200px !important;">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form method="post" id="commentForm" action="<?php echo base_url() . 'index.php/portfolio/insert_incComment'; ?>" class="form" novalidate autocomplete="off">
                                        <input type="hidden" name="module_id" value="<?= isset($_REQUEST['moduleid']) && $_REQUEST['moduleid'] != '' ? $_REQUEST['moduleid'] : ''; ?>">
                                        <input type="hidden" name="chart_sector" value="<?= isset($_REQUEST['sectorid']) && $_REQUEST['sectorid'] != '' ? $_REQUEST['sectorid'] : ''; ?>">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <div class="form-group">
                                                    <label>Enter your comments</label>
                                                    <textarea class="form-control" rows="5" name="comment"></textarea>
                                                </div>												
                                                <div id="submit_btn_cls">
                                                    <ul class="vitals-links">
                                                        <li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Save" ></input>
                                                        </li>                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

<?php $this->load->view('vitals_footer.php'); ?>

<script>
    $('#commentForm').validate({
        rules: {
            comment: "required"
        },
        messages: {
            comment: "Please enter the comment"
        }
    });
</script>

</body>
</html>