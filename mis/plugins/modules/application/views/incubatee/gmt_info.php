<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $additional_information[0]['name_of_enterprise'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'], 'doc3' => $additional_information[0]['doc3'])); ?>
                <?php /* <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								<?php if($additional_information[0]['program'] == '14') { ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div> */ ?>
				
				<div class="" id="navLoad">
                    <div class="newCLickTabs">
                        <div class="scrtabs-allow-scrollbar">
                            <div class="scrtabs-tab-container" style="visibility: visible;"><div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-left" style=""><span class="fas fa-chevron-left"></span></div><div class="scrtabs-tabs-fixed-container" style="width: 1360px;"><div class="scrtabs-tabs-movable-container" style="width: 1360px;"><ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">
								
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "Team information";  
									}else{
										echo "Team";
									}  
								?>
								</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "About the Enterprise";  
									}else{
										echo "Enterprise";
									}  
								?>
								</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "About the Business model";  
									}else if($additional_information[0]['program'] == '23'){
										echo "Funding details & Support";
									}else{
										echo "Impact";
									}  
								?>
								
								</a></li>
								
								<?php if($additional_information[0]['program'] == '14' || $additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22') { ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "Impact of the business";  
									}else{
										echo "Business";
									}  
								?>
								</a></li>
								<?php } ?>
								<?php  if ($additional_information[0]['program'] == 25) {  ?>
								<li role="presentation"  class=" active"><a href="<?php echo base_url() . 'index.php/application/gmt_info/' . $application_id; ?>">GTM related information </a></li>
								<?php } ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul></div></div><div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-right" style=""><span class="fas fa-chevron-right"></span></div></div>
                        </div>
                    </div>
                </div> 
				
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="additionalForm" action="<?php echo base_url() . 'index.php/application/add_additional_details'; ?>" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $additional_information[0]['inv_user_id']; ?>">
									
									<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Please elaborate on the product-market fit including targeted geographies<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['company_description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>What is the competitive landscape? Please provide a full competitive analysis<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['inv_idea_ent']; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>How do we benchmark against the competitive landscape? e.g., define competitive advantage / customer benefit across geographies<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['inno_desc']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>What is the product's value proposition?<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['inno_prob']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>(Where applicable) How large is the current market and how much do we expect to capture?e.g., total market size, Total Accessible Market (TAM), % of TAM that would be covered annually for the next 5 years<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['avail_alter']; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>What are the regulatory compliances and licenses required for the targeted geographies? List based on geographies<span>*</span></label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['prop_model']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>What is the current stage of regulatory and procurement?<span>*</span><label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['ident_risk']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>Is a Quality Management System in place?<span>*</span><label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['robot_efficient']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>What trial data exists to support the GTM strategy?<span>*</span><label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['market_size']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>(Where applicable) What is the breakdown of the product's pricing? e.g., COGS , marketing, margins<span>*</span><label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['geographic']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>Are you seeking a scale-up or IP transfer?<span>*</span> <label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['estimate_qua']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>Please indicate the support you would like from us <span>*</span><label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['business_model']; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>Mention  <span>*</span><label>
													  <input class="form-control fieldDisable" cols="30" rows="3" disabled value="<?= $additional_information[0]['target_beneficiary']; ?>"></input>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>If you are seeking an IP transfer, please mention any licensing plans. Otherwise please put N/A <label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['part_org']; ?></textarea>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>What are your marketing KPIs and goals? Please provide for the next 2-3 years <label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['central_state']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>What is your ask from the market partner? <label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['other_funding']; ?></textarea>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                     <label>What is the profitability outlook? <span>*</span><label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['future_growth']; ?></textarea>
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


<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#vill_support, #abt_vill').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        support_value();
        about_value();
    });

    $(document).on('click', '#saveForm', function (e) {
        var support_len = $('#multiple_support .multiselect-selected-text').html();
        var about_len = $('#multiple_about .multiselect-selected-text').html();
        $("#support_err, #about_err").html('');
        if (support_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#support_err").html('<label for="vill_support" class="error">Select type</label>');
        }
        if (about_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#about_err").html('<label for="abt_vill" class="error">Select type</label>');
        }
    });

    function support_value() {
        var myArray = [];
        $('#vill_support option:selected').each(function () {
            myArray.push($(this).val());
        });

        if ($.inArray("Other", myArray) !== -1) {
            $('#villgro_other').show();
        } else {
            $('#villgro_other').hide();
        }
    }

    function about_value() {
        var myArray = [];
        $('#abt_vill option:selected').each(function () {
            myArray.push($(this).val());
        });
        if ($.inArray("Other", myArray) !== -1) {
            $('#about_other').show();
        } else {
            $('#about_other').hide();
        }
    }

    $(document).ready(function () {
        $('input[type="file"]').css("pointer-events", "none");
    });

    $('.summaryEdit').click(function () {
        $('input[type="file"]').css("pointer-events", "");
        $(".fieldDisable").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
    });

    $('#additionalForm').validate({
        rules: {
            "otr_support": "required",
            "ref_name": "required",
        },
        messages: {
            "otr_support": "Enter name",
            "ref_name": "Enter name",
        }
    });

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        var result = filename.split('|*|');
        $(this).parent().children('span').html(result[0]);
        if (result[1] != '1') {
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
        var bsize = (input.files.length && input.files[0].size) || '';
        if (bsize != '') {
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
    }

    $(document).on('submit', '#additionalForm', function (e) {
        $('#additionalForm').valid();
        var result = validateForm();
        if (result == 1) {
            return false;
        } else {
            $('#saveForm').css('pointer-events', 'none');
            return true;
        }
    });

    function validateForm() {
        var err = 0;

        $(".uploadlogo").each(function () {
            var filename = readURL(this);
            if (filename) {
                var result = filename.split('|*|');
                $(this).parent().children('span').html(result[0]);
                if (result[1] != '1') {
                    $(this).parent().parent().children('.sow_msg').show();
                    $(this).parent().parent().children('.sow_msg').text(result[1]);
                    err = 1;
                } else {
                    $(this).parent().parent().children('.sow_msg').text('');
                    $(this).parent().parent().children('.sow_msg').hide();
                }
            }
        });
        return err;
    }
</script>

</body>
</html>