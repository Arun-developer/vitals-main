<?php
$emp_id = $this->session->userdata['emp_number'];
if (php72_count($equity_actual) > 0) {
    $enable = 1;
} else {
    $enable = 0;
}

$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = array("1" => 'Q4', "2" => 'Q4', "3" => 'Q4', "4" => 'Q1', "5" => 'Q1', "6" => 'Q1', "7" => 'Q2', "8" => 'Q2', "9" => 'Q2', "10" => 'Q3', "11" => 'Q3', "12" => 'Q3');
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$last_month = date("F", mktime(0, 0, 0, $current_month, 1));
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $sector_name . ' - Equity Investments Achievements', 'port_action' => 'sec_actual', 'sector_id' => $sector_id, 'sector_name' => $sector_name, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp120">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" id="nav-Companymaster-tab" href="<?= base_url() . 'index.php/portfolio/sector_actual/discovery/' . $sector_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="false">Pipeline</a>
                        <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/sector_actual/graduates/' . $sector_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Graduates & Exits</a>
                        <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/sector_actual/donorengagement/' . $sector_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="true">Fundraise</a>
                        <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/sector_actual/conference/' . $sector_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Brand Building & Thought Leadership</a>
                        <a class="nav-item nav-link active" id="nav-governance-tab active" href="" aria-controls="nav-governance" aria-selected="false">05</a>
                        <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab" href="#nav-about" aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                    <h4>Driving Financial Sustainability</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if (php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue">Save &amp; Continue</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('sector_actual/leftmenu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'equity_investments', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                            </div>
                            <main class="page-content">
                                <div class="row dataconfig">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-12">
                                        <?php
                                        if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                            $next_financial = $current_financial + 1;
                                        } else {
                                            $next_financial = $current_financial;
                                        }
                                        ?>
                                        <h4>Driving Financial Sustainability Achievement > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if (php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform active"><a href="<?= base_url() . 'index.php/portfolio/sector_actual/equity_investments/' . $sector_id . '/' . $current_financial . '/' . $current_month; ?>">Equity Investments</a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/sector_actual/consulting_engagements/' . $sector_id . '/' . $current_financial . '/' . $current_month; ?>">Service Agreements</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                $current_quarter = $actual_quarter[$current_month];
                                $total_qualPlan = $get_quarter_fieldName[$current_quarter];
                                $monthly_qualPlan = $get_quarter_monthField[$current_month];
                                ?>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <form method="post" id="equityForm" action="<?php echo base_url() . 'index.php/portfolio/sector_actual/addGraduates'; ?>" autocomplete="off">

                                                    <div class="row achievementNewComt">
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $current_quarter; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea row="5" disabled placeholder="Plan for this quarter come here" class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea row="5" disabled placeholder="Plan for February month come here" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Enter achievements for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew" id="achieveField">
                                                                <textarea row="5" class="mceEditorActive" id="achieveContent" name='achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $qualitative_actual[0]['description'])); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="table_configcontentnew pad-bt0">
                                                        <div class="tabpanel-title">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                    <h4 style="font-size:14px;padding: 15px 10px;">No. of Equity Investments Deals</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if ($this->session->userdata['currency'] == 'INR') {
                                                        $currency_text = 'INR, In Lakhs';
                                                    } else {
                                                        $currency_text = $this->session->userdata['currency'] . ", In '000's";
                                                    }
                                                    ?>

                                                    <div class="table-responsive table_configcontentnew ">
                                                        <table class="table mentor-table" id="accordion">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%">S.No</th>
                                                                    <th width="30%">Company Name</th>
                                                                    <th width="30%">Equity Investment Amount (<?= $currency_text; ?>)</th>
                                                                    <th width="30%">Date of Investment</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="add_tranche">
                                                                <?php
                                                                $j = 1;
                                                                foreach ($invest_details as $invest) {
                                                                    $invest_date = (isset($invest['sha_date']) && $invest['sha_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($invest['sha_date'])) : '';
                                                                    ?>
                                                                    <tr>
                                                                        <td width="7%"><?= $j; ?></td>
                                                                        <td >
                                                                            <input type="text" name="company_name" disabled value="<?= $invest['name'] != '' ? $invest['name'] : ''; ?>"  class="form-control form-control-sm volumefld" maxlength="2" placeholder="Company name">
                                                                            <label class="error error_msg"></label>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="invest_amount" value="<?= $invest['invest_amount'] != '' ? $invest['invest_amount'] : ''; ?>" disabled class="form-control form-control-sm volumefld" maxlength="2" placeholder="0">
                                                                            <label class="error error_msg"></label>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" name="date_investment" id="date_investment" value="<?php
                                                                            echo
                                                                            $invest_date;
                                                                            ?>" disabled class="form-control form-control-sm volumefld" maxlength="2" placeholder="">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $j++;
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <input type='hidden' name='sector_id' id="sector_id" value="<?= $sector_id; ?>">
                                                    <input type='hidden' name='financial_year' id="financial_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <!--<input type='hidden' name='updatePlan' id="updatePlan" value="0">-->
                                                    <input type='hidden' name='module_id' id="module_id" value="<?= $module_id; ?>">
                                                    <input type='hidden' name='redirect' id="redirect" value="equity_investments">
                                                    <input type='hidden' name='success_head' id="success_head" value="Equity investment">
                                                </form>
                                            </div>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<input type="hidden" id="qualitCount" value="<?= php72_count($qualitative_actual); ?>">
<input type="hidden" id="enableCount" value="<?= php72_count($equity_actual); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">
    $(window).on("load", function () {
        // $('svg').attr("viewBox", "0 0 25 25");
        // $('svg').css({"width": "20", "height": "20"});
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        entity_encoding: "numeric",
        menubar: false,
        readonly: 1,
        toolbar: [
            ''
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditorActive",
        entity_encoding: "numeric",
        menubar: false,
        auto_focus: "achieveContent",
        plugins: [
            'lists'
        ],
        toolbar: [
            'bold italic | numlist bullist'
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });



    $(document).ready(function () {
        onLoad();
    });

    function onLoad() {
        var qualitEdit = $('#qualitCount').val();
        var editOpt = $('#enableCount').val();
        if (qualitEdit > 0) {
            tinymce.get('achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
        }
        if (editOpt > 0) {
            $('input[type="text"], select, textarea').attr('readonly', 'readonly');
            $('.disDate, select').css('pointer-events', 'none');
        } else {
            datepickerEachFunction();
        }
        $('#financial_year').attr('readonly', false);
        $('#financial_year').css("pointer-events", "");
        $('#editBtn').addClass('opacity5');
    }


    $(document).on('click', '#editBtn', function () {
//                                                                                                    $('input[type="text"], select, textarea').attr('readonly', false);
//                                                                                                    $('.disDate, select').css('pointer-events', '');
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
        datepickerEachFunction();
    });

    function loadYear(year) {
        var sector_id = $('#sector_id').val();
        var month = $('#current_month').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/sector_actual/equity_investments/' + sector_id + '/' + year + '/' + month;
    }

    function pad(num) {
        var s = num + "";
        s = parseFloat(s, 10);
        return s;
    }

    $(".numberField").on("input", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9]/g, ''));
    });

    $(document).on("input", ".volumefld", function (evt) {
        var self = $(this);
        if (self.val() != 0 || self.val() == '') {
            self.val(self.val().replace(/[^0-9]/g, ''));
        } else {
            self.val(0);
        }
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $(document).on('click', '.check_box', function () {
        if ($("#equityForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });



    $(document).on('click', '#edit_mentor', function () {
        $('.saveContinue').text('Save');
        $('#editMentor').html('<a href="javascript:void(0)" id="cancel_mentor"><i class="fas fa-times"></i>&nbsp;Cancel</a>')
        $('#edit_mentor').removeClass('opacity5');
        $('#accordion select').attr('readonly', false);
        $('#accordion input[type="text"]').attr('readonly', false);
        $('.disDate').css('pointer-events', '');
        $('#accordion textarea').attr('readonly', false);
        $("#accordion select").css("pointer-events", "");
        datepickerEachFunction();
    });

    $(document).on('click', '#cancel_mentor', function () {
        $('.saveContinue').text('Save');
        $('#editMentor').html('<a href="javascript:void(0)" id="edit_mentor"><i class="fas fa-pencil-alt"></i>Edit</a>');
        onLoad();
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('#accordion select').attr('readonly', 'readonly');
            $('#accordion input[type="text"]').attr('readonly', 'readonly');
            $('#accordion textarea').attr('readonly', 'readonly');
        }
        $('#edit_mentor').addClass('opacity5');
    });





    function datepickerEachFunction() {
        var sel_month = $('#current_month').val();
        var sel_year = $('#current_year').val();
        if (sel_month < 4) {
            sel_year = parseInt(sel_year) + 1;
        }
        $('.disDate').each(function (index, value) {
            $("#datepost_" + index).datepicker({
                onSelect: function (selected) {
                    $("#datepost_" + index).datepicker("option", "dateFormat", 'mm/dd/yy');
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
                    $("#datepost_" + index).val(fulldatevalue);
                },
                defaultDate: new Date(sel_year, sel_month - 1),
                stepMonths: 0
            });
        });
    }

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#equityForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#equityForm').submit();
        }
    });
    $('.plan-structure-new').css({
        'height': (($(window).height()) - 240) + 'px'
    });
</script>
</body>

</html>