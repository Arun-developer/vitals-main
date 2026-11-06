<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Leave - Current Holiday Calendar')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'week_setup')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Week Setup</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new">
                            <form method="post" id="weekdaysForm" action="<?php echo base_url() . 'index.php/leave/addWeekdays'; ?>" autocomplete="off">
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Monday</label>
                                            <select class="form-control" name="monday_values" id="monday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['monday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['monday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['monday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Tuesday</label>
                                            <select class="form-control" name="tuesday_values" id="tuesday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['tuesday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['tuesday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['tuesday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Wednesday</label>
                                            <select class="form-control" name="wednesday_values" id="wednesday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['wednesday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['wednesday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['wednesday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Thursday</label>
                                            <select class="form-control" name="thursday_values" id="thursday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['thursday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['thursday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['thursday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Friday</label>
                                            <select class="form-control" name="friday_values" id="friday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['friday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['friday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['friday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Saturday</label>
                                            <select class="form-control" name="saturday_values" id="saturday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['saturday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['saturday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['saturday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Sunday</label>
                                            <select class="form-control" name="sunday_values" id="sunday_values" required>
                                                <option value="1" <?php
                                                if (php72_cmp($weekdays[0]['sunday']) == 1) {
                                                    echo 'selected';
                                                }
                                                ?> >Full Day</option>
                                                <option value="2" <?php
                                                if (php72_cmp($weekdays[0]['sunday']) == 2) {
                                                    echo 'selected';
                                                }
                                                ?> >Half Day</option>
                                                <option value="3" <?php
                                                if (php72_cmp($weekdays[0]['sunday']) == 3) {
                                                    echo 'selected';
                                                }
                                                ?> >Weekend</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-12 col-sm-12  col-md-12 ">
                                        <div class="">
                                            <ul class="vitals-links">
                                                <li><button type="submit" class="wdt_100 vital_yellow_btn">Save</button></li>
                                                <li><a href="<?php echo base_url() . 'index.php/leave/week_setup'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="edit_id" id="edit_id" value="<?= isset($weekdays[0]['id']) ? $weekdays[0]['id'] : ''; ?>" />
                                <input type="hidden" name="edit_year" id="edit_year" value="<?= isset($weekdays[0]['year']) ? $weekdays[0]['year'] : ''; ?>" />
                            </form>
                        </div>
                    </main>
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

</body>
</html>