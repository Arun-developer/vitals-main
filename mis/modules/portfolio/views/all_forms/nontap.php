<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$last_month = date("F", mktime(0, 0, 0, $current_month, 1));
$reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
$sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Achievement', 'company_name' => $company_name, 'port_action' => 'actual', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp150'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill newIncubatesTabs" id="nav-tab" role="tablist">
                        <div class="new-nav-changes">
                            <div class="new-changes-head"> &nbsp</div>
                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"    href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                        <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                        <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                        <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Team &amp; Board Meetings</a>
                        <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                    </div>
                    <div class="new-nav-changes2"><div class="new-changes-head2">Incubator Services/Interventions</div>
                    <a class="nav-item nav-link active" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false" style="margin-left: 15px;">07 </a>
                    <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/dp/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Diagnostic Panels</a>
                    <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/vif_funding/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Seed Funding</a>
                    <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/notes/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Calls</a>

                </div>
            </div>

        </nav>
        <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                <div class="tabpanel-title">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                            <h4>Mentors &amp; Partnerships</h4>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                            <ul class="milestone-links">
                                <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
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
                        <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'nontap', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                    </div>
                    <main class="page-content">
                        <div class="row dataconfig">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                <?php
                                $get_Qval = $actual_quarter[$current_month];
                                if ($get_Qval == 'Q4') {
                                    $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $current_financial);
                                    $next_financial = $get_end_year[0]['fin_to_year'];
                                } else {
                                    $next_financial = $current_financial;
                                }
                                ?>
                                <h4>Partnerships > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                            </div>
                            <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                    <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                </div>
                            <?php } ?>
                        </div>
                        <div>
                            <div class="tab-slider--navform">
                                <ul class="tab-slider--tabsform">
                                    <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Mentors</a></li>
                                    <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/tap/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Technical Assistance</a></li>
                                    <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Partnerships</a></li>
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
                                    <div class="inputplan-structureall">
                                        <form method="post" id="nontapPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addNontapPlan'; ?>" autocomplete="off">
                                            <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                            <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                            <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                            <input type='hidden' name='module_id' id="module_id" value="11">
                                           
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 table_configcontentnew Plan-structure">
                                                    <table class="input-nontaptable table tableresponsive mar-tp0">
                                                        <thead>
                                                            <tr>
																
                                                                <th width="25%">Type</th>
																<th width="25%">Program</th>
                                                                <th width="25%">Partner's name</th>
                                                                <th width="14%">Date engaged</th>
																<th width="14%">Sales Leads</th>
																<th width="14%">Revenue Generated Via Partner (INR) </th>
                                                                <th width="36%">Comments</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody >
                                                            <?php
                                                            if (php72_count($nontap_config) != 0) {
                                                                $i = 0;
                                                                $j = 1;
                                                                foreach ($nontap_config as $get_data) {
                                                                    $service['partner_id'] = $this->session->userdata('partner_id');
                                                                    $service['id'] = $get_data['type'];
                                                                    $service['status'] = 1;
                                                                    $partner_list = $this->Mportfolio->getCommonData('port_ttm_partnership_master', $service, 'name');

                                                                    $get_achieve['port_nontap_id'] = $get_data['id'];
                                                                    $get_achieve['inv_id'] = $get_data['inv_id'];
                                                                    $get_achieve['financial_year'] = $get_data['financial_year'];
                                                                    $get_achieve['month'] = $current_month;
                                                                    $get_achieve_data = $this->Mportfolio->getVifInput('plan_partnerships', $get_achieve, '3');
//                                                                                    echo '<pre>';
//                                                                                    print_r($get_achieve_data);
                                                                    $need_by = '';
                                                                    if (php72_count($get_achieve_data) > 0) {
                                                                        $need_by = (isset($get_achieve_data[0]['need_by']) && $get_achieve_data[0]['need_by'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($get_achieve_data[0]['need_by'])) : '';
                                                                    } else {
                                                                                // $need_by = (isset($get_data['need_by']) && $get_data['need_by'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($get_data['need_by'])) : '';
                                                                    }
                                                                    ?>
                                                                    <tr>
																	<!--<td class="vill-gray"><?= $partner_list[0]['name']; ?></td> -->
																		
																		
                                                                        <td ><?= $partner_list[0]['name']; ?></td>
                                                                        <input type="hidden" name="type_id[]" value="<?= $partner_list[0]['id']; ?>">
																		<td>
                                                                            <select disabled class="form-control form-control-sm program" name="program[]" id="program_<?php echo $j; ?>">
                                                                                <option value="">-Select-</option>
                                                                                <?php
                                                                               foreach ($program_type as $programData) {
                                                                                    if ($get_data['program'] == $programData['id']) {
                                                                                        $selected = 'selected';
                                                                                    } else {
                                                                                        $selected = '';
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?php echo $programData['id']; ?>" <?= $selected; ?> ><?php echo $programData['program_name']; ?></option>
																			<?php }   ?>
                                                                            </select>
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm readOnly" readonly="" type="text" name="partner_name[]" value="<?= $get_data['partner_name']; ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm disDate dateCalendar" type="text" name="eng_date[]" id="eng_date_<?= $i; ?>" value="<?= $need_by; ?>" placeholder="dd-mm-yyyy">
                                                                            </div>
                                                                        </td>
																		<td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm volumefld" readonly="" type="text" name="sales_lead[]" value="<?= $get_achieve_data[0]['sales_lead']; ?>">
                                                                            </div>
                                                                        </td>
																		<td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm revenue_amount currencyField" readonly="" type="text" name="revenue_amount[]" value="<?= $get_achieve_data[0]['revenue_amount']; ?>">
                                                                            </div>
                                                                        </td>
																		
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm" type="text" name="partner_comments[]" value="<?= $get_achieve_data[0]['comments']; ?>">
                                                                            </div>
                                                                        </td>
                                                                        <input type="hidden" name="port_nontap_id[]" id="port_nontap_id<?php echo $j; ?>" value="<?php echo $get_data['id']; ?>" />
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                    $j++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr align="center"><td colspan="4" >No data found</td></tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
											<hr><br><br>
											 <div class="row achievementNewComt">
                                                <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                    <p>Plan for <?= $current_quarter; ?></p>
                                                    <div class="form-group quaterlyCardnew fieldDisabled">
                                                        <textarea rows="3" disabled class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                    <p>Plan for <?= $last_month; ?></p>
                                                    <div class="form-group quaterlyCardnew fieldDisabled">
                                                        <textarea rows="3" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                    <p>Enter achievement for <?= $last_month; ?></p>
                                                    <div class="form-group quaterlyCardnew" id="achieveField">
                                                        <textarea rows="3" class="mceEditorActive" id="achieveContent" name='achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $qual_achieve[0]['description'])); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
											
											
                                        </form>
                                    </div>
                                </main>
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

<input type="hidden" id="qualitCount" value="<?= php72_count($qual_achieve); ?>">
<input type="hidden" id="enableCount" value="<?= php72_count($nontap_plan); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">


/////// New implement //////////////
	 $(".volumefld").on("input", function (evt) {
			var self = $(this);
			if (self.val() != 0 || self.val() == '') {
				self.val(self.val().replace(/[^0-9]/g, ''));
				self.val(self.val());
				//self.val(inrFormat(self.val()));
			} else {
				self.val(0);
			}
			if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
				evt.preventDefault();
			}
		});
	
	$(".revenue_amount").each(function() {
		let id = $(this).attr('id');
		let val = $(this).val();
		if(id!='' && val!=''){
			var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            self.val(inrFormat_val(self.val()));
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
            var matchedString = self.val().match(patt);
			if (matchedString) {
                self.val(matchedString);
            }
		}
	});
	function inrFormat_val(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		var z = 0;
		var len = String(x1).length;
		var num = parseInt((len / 2) - 1);
		while (rgx.test(x1)) {
			if (z > 0) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			} else {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
				rgx = /(\d+)(\d{2})/;
			}
			z++;
			num--;
			if (num == 0) {
				break;
			}
		}
		return x1 + x2;
	}
	/////// New implement //////////////
	
	
	

    $(window).on("load", function () {
        $('svg').attr("viewBox", "0 0 25 25");
        $('svg').css({"width": "20", "height": "20"});
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
        //auto_focus: "achieveContent",
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

    function datepickerEachFunction() {
        var sel_month = $('#current_month').val();
        var sel_year = $('#current_year').val();
        if (sel_month < 4) {
            sel_year = parseInt(sel_year) + 1;
        }
        $('.disDate').each(function (index, value) {
            $("#eng_date_" + index).datepicker({
                onSelect: function (selected) {
                    $("#txtDate_" + index).datepicker("option", "dateFormat", 'mm/dd/yy');
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
                    $("#eng_date_" + index).val(fulldatevalue);
                },
                defaultDate: new Date(sel_year, sel_month - 1),
                stepMonths: 0
            });
        });
    }

    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
        } else {
            datepickerEachFunction();
        }
        var qualitEdit = $('#qualitCount').val();
        if (qualitEdit > 0) {
            tinymce.get('achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
        }

        $('select').css('pointer-events', 'none');
        $('#financial_year').attr('readonly', false);
        $('#financial_year').css("pointer-events", "");
        $('#editBtn').addClass('opacity5');
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/nontap/' + inv_id + '/' + year;
    }

    $(document).on('click', '#editBtn', function () {
        $('input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
        datepickerEachFunction();
    });

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#nontapPlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#nontapPlanForm').submit();
        }
    });

</script>
</body>

</html>
