<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Sectors')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'incubation_masters')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/incubation_master/program_master_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?php echo $program_name; ?></h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
							<div class="inputplan-structureall plan-structure-new">
								<form method="post" id="insertProgram" action="<?php echo base_url() . 'index.php/incubation_master/insertProgram'; ?>" class="form" novalidate autocomplete="off">
									<div class="row leaveLabel">
										<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>Program Name</label>
												<input type="text" class="form-control program_name"  name="program_name" id="program_name" value="<?php echo $program_name; ?>" />
												
												<div id="program_name_err"></div>
											</div>
											<div class="form-group">
												<label>Sectors<span></span></label>
												<select name="associate_sector[]" class="form-control employeeInput select-ajax" id="multiselect"  multiple="multiple"></select>
												<div id="associate_employee_err"></div>
											</div>
											<br><br><br><br><br><br><br><br><br><br>
											<div class="form-group">
												<label>     <span></span></label>
													
												<div id="associate_employee_errs"></div>
											</div>
											<input type="hidden" id="edit_status">
											<div id="submit_btn_cls" >
												<ul class="vitals-links">
													<li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Save" ></input>

													</li>
													<li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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

<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect')); ?>

<script type="text/javascript">

    $('#insertEditSector').validate({
        rules: {
            sector_type: "required"
        },
        messages: {
            sector_type: "Select Sector Type"
        }
    });

    $(document).ready(function () {
        $('#multiselect').val('');
        var sector_type = '0';
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/incubation_master/getSectorLists',
            data: {sector_type: sector_type},
            dataType: 'json',
            success: function (response) {
                $(".select-ajax").empty();
                sortedData = response.response;
                $.each(sortedData, function (i, item) {
                    if ($(".select-ajax option[value='" + item.sector + "']").length == 0) {
                        selected_val = '';
                        if (jQuery.inArray(item.id, response.incharge_id) !== -1) {
                            console.log(item.id);
                            selected_val = "selected";
                        }
                        if (sector_type == '') {
                            selected_val = '';
                        }
                        $('.select-ajax').append('<option ' + selected_val + ' value="' + item.id + '">' + item.sector + '</option>');
                    }
                });
                $('.select-ajax').multiselect('rebuild');
                multiselect_len = $('#multiselect :selected').length;
                if (multiselect_len != '0') {
                    $("#associate_employee_err").html('');
                }

                if ($("#edit_status").val() != '1') {
                    //$(".multiselect").attr("disabled", true);
                }

            },
        });

		
    });

    $(document).on('click', '.summaryEdit', function () {
        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $(".multiselect").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });	
	
	$(document).on('click', '#submit_btn', function (e) {
	
    e.preventDefault(); 
    var multiselect_len = $('#multiselect :selected').length;
    var multiselect_lens = $('.select-ajaxs :selected').length;
	var programName = $(".program_name").val();
	
    $("#associate_employee_err").html('');
    $("#associate_employee_errs").html();
	$("#program_name_err").html('');
	
   /*  if (multiselect_len == 0 || multiselect_lens == 0) {
        if (multiselect_len == 0 && multiselect_lens == 0) {
            $("#insertProgram").valid();
            $("#associate_employee_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Select Assigned Incharge</label>');
			if (programName === '') {
				$("#program_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Please enter the program</label>');
			}
            return;
        }
    } */
	
    if (programName === '') {
       $("#program_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Please enter the program</label>');
        return;
    }
    var isFormValid = true; 

    $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/incubation_master/checkSProgramName',
        data: { programName: programName },
        dataType: 'json',
        async: false,
        success: function (response) {
            if (response.status == '1') {
                $("#program_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Program  name already exists</label>');
                isFormValid = false;
            } else {
                console.log(' checkSProgramName ');
            }
        },
    });
    if (isFormValid) {
        $("#insertProgram").submit();
    }
});



    
    function submit_fields() {
        $('#master_form').submit();
    }

    $(document).ready(function () {
        $('#multiselect, #accessibleTo').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

</script>

</body>
</html>