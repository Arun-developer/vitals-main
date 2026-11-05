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
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue">Save &amp; Continue</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'mentor', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Mentors > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Mentors</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/tap/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Technical Assistance</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/nontap/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Partnerships</a></li>
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
                                                <form method="post" id="mentorPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addMentorPlan'; ?>" autocomplete="off"  enctype="multipart/form-data">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <input type='hidden' name='module_id' id="module_id" value="9">
                                                   
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 vil-Deals portfolio-table">
                                                            <table class="tableresponsive table-inputmentor input-fundtable bg-white mar-tp0">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="20%">Mentor Assigned</th>
                                                                        <th width="15%">Hours Spent</th>
																		<th width="19%">Invoice Amount (INR)</th>
																		<th width="25%">Invoice</th>
                                                                        <th width="30%">Requirement / Purpose</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $j = 1;
                                                                    $men_data = $mentor_master[0];
                                                                    $mentorData_count = isset($men_data) ? count($mentor_master) : 1;
                                                                    if (count($mentor_master) != 0) {
                                                                        for ($i = 0; $i < $mentorData_count; $i++) {
                                                                            $master['id'] = $mentor_master[$i]['master_id'];
                                                                            $get_emp = $this->Mportfolio->getMentorsInput('port_villgro_relation_mentor', $master, '3');


                                                                            $cond['config_id'] = $mentor_master[$i]['id'];
                                                                            $cond['inv_id'] = $mentor_master[$i]['inv_id'];
                                                                            $cond['financial_year'] = $mentor_master[$i]['financial_year'];
                                                                            $cond['month'] = $current_month;
                                                                            $get_data = $this->Mportfolio->getMentorsInput('plan_mentor', $cond, '3');
                                                                            $hr_spent = 0;
                                                                            foreach ($get_data as $m_data) {
                                                                                $hr_spent += $m_data['hours_spent'];
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td width="20%" valign="top">
                                                                                    <div class="form-group">
                                                                                        <select class="form-control form-control-sm mentorDiv readOnly" readonly="" name="name[]" id="mentor_name_<?php echo $j; ?>">
                                                                                            <option value="">-Select-</option>
                                                                                            <?php
                                                                                            foreach ($emp_mentors as $emps) {
                                                                                                if ($get_emp[0]['name'] == $emps['emp_number']) {
                                                                                                    $selected = 'selected';
                                                                                                } else {
                                                                                                    $selected = '';
                                                                                                }
                                                                                                ?>
                                                                                                <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="15%" valign="top">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm numberField" maxlength="6" type="text" name="hours_spent[]" id="hours_spent_<?php echo $j; ?>" value="<?= $hr_spent; ?>">
                                                                                    </div>
                                                                                </td>
																				<td width="19%" valign="top">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm currencyField changecurrencyField"  type="text" name="invoice_amount[]" id="invoice_amount_<?php echo $j; ?>" value="<?= $get_data[0]['invoice_amount']; ?>">
                                                                                    </div>
                                                                                </td>
																				<td class="sowFile">
																					<div class="fileUpload blue-btn btn width100">
																						<?php
																						
																					
																						if (isset($get_data[0]['document']) && !empty($get_data[0]['document'])) {
																							echo strlen($get_data[0]['document']) > 20 ? "..." . substr($get_data[0]['document'], -20) : $get_data[0]['document'];
																						} else {
																							?>
																							<span><i class="fas fa-upload"></i>Upload</span>
																						<?php } ?>
																						<input type="file" class="uploadlogo" data-dyn="<?= $m; ?>" name="document[]" id="document<?= $m; ?>" />
																					</div>
																					<label class="sow_msg error" id="document<?= $m . '_error'; ?>"></label>
																					<?php if (isset($get_data[0]['document']) && !empty($get_data[0]['document'])) { ?>
																						<span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/mentor_invoice/' . $get_data[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
																						<?php //if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
																							<span><a href="javascript:void(0)" class="delete-btnconfig" title="Delete Document" onclick="delDocument('<?= $get_data[0]['id']; ?>')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
																						<?php //} ?>
																					<?php } ?>
																					<input type="hidden" name="old_document[]" id="old_document<?= $m; ?>" class="uploadlogo" data-dyn="<?= $m; ?>" value="<?php echo $get_data[0]['document']; ?>">
																				</td>
																				
                                                                                <td width="30%" valign="top">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control form-control-sm description" maxlength="250" row="3" name="purpose[]" id="purpose_<?php echo $j; ?>"><?= $get_data[0]['purpose']; ?></textarea>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="35%"></td>
                                                                        <input type='hidden' name="mentor_id[]" id='mentor_id_<?php echo $j; ?>' value='<?= $get_data[0]['id']; ?>'>
                                                                        <input type="hidden" name="config_id[]" value="<?= $mentor_master[$i]['id']; ?>">
                                                                        </tr>
                                                                        <?php
                                                                        $j++;
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr align="center"><td colspan="5" >No data found</td></tr>
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
</div>
</div>

<input type="hidden" id="qualitCount" value="<?= count($qual_achieve); ?>">
<input type="hidden" id="enableCount" value="<?= count($mentor_plan); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">


	/////// New implement //////////////
	$(".changecurrencyField").each(function() {
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
	
	$(document).on('change', '.uploadlogo', function () {
        var get_id = $(this).attr('id');
        var filename = readURL(this);
        var result = filename.split('|*|');
        $(this).parent().children('span').html(result[0]);
        if (result[1] != '1') {
            $('#' + get_id).val('');
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(result[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });
	
	function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        var bsize = input.files[0].size;
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
            if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
                path = $(input).val();
                filename = path.replace(/^.*\\/, "");
                return filename + '|*|1';
            } else {
                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                return filename;
            }
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
            return filename;
        }
    }

	
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
	
	function delDocument(mtrid) {
        $('#deleteDocModal').modal('show');
        $('#doc_id').val(mtrid);
    }
	
	 $(document).on('click', '#deleteDocRecord', function () {
        var document_id = $('#doc_id').val();
        if (document_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletedoc_unset",
                data: {
                    mentr: document_id,
                    column: 'document',
                    table: 'plan_mentor',
					unlink:'uploads/discussion/'
                },
                dataType: 'json',
                success: function (msg) { 
				
					window.location.reload();
					//alert();
					
					/* $('#deleteMsg').show();
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000); */
					//window.location.reload();
					
                   /*  $('#loadSurveyData').load(location.href + ' #loadSurveyData');
                    $('#deleteDocModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000); */
                }
            });
        }
    });
	
	 function deleteMore(field_name, list_id, btn_id) {
        if ($('input:checkbox[name=' + field_name + ']:checked').length > 0) {
            $('#' + list_id).css("cursor", "pointer");
            $('#' + btn_id).css("pointer-events", "");
        } else {
            $('#' + list_id).css("cursor", "not-allowed");
            $('#' + btn_id).css("pointer-events", "none");
        }
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

    $(document).ready(function () {
        var qualitEdit = $('#qualitCount').val();
        var editOpt = $('#enableCount').val();
        if (qualitEdit > 0 || editOpt > 0) {
            $('input[type="text"], textarea').attr('readonly', 'readonly');
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
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/mentor/' + inv_id + '/' + year;
    }

    $(document).on('click', '#editBtn', function () {
        $('input[type="text"], textarea').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
    });

    function pad(num) {
        var s = num + "";
        s = parseFloat(s, 10);
        return s;
    }

    $(".numberField").on("blur", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));

        if (self.val().split('.').length >= 3) {
            self.val('');
        }

        var n = self.val();
        n = (n + "").split(".")[1];
        if (n == undefined) {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            if (self_val >= 0 || self_val == '') {
                self.val(self_val);
            } else {
                self.val('');
            }
        } else if (n.length == 1) {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{1}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                var self_val = Number.parseFloat(matchedString).toFixed(1);
                self.val(self_val);
            }
        } else {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                var self_val = Number.parseFloat(matchedString).toFixed(2);
                if (self_val > 0) {
                    self.val(self_val);
                }
            }
        }
    });

    $(".description").on("input", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^a-zA-Z0-9., &]/g, ''));
    });

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#mentorPlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#mentorPlanForm').submit();
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>
</body>

</html>
