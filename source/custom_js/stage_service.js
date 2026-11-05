			$(document).ready( function() {
				$("#programType").change(function(){
					programServiceCombo(this.value);
				});
				if($("#programType").val()){
					programServiceCombo($("#programType").val());
				}
				
				$("#programServiceOffering").change(function(){
					programStageCombo(this.value);
				});
				if($("#programServiceOffering").val()){
					programStageCombo($("#programServiceOffering").val());
				}
				if($("#PSO").val())
				{
					programStageCombo($("#PSO").val());
				}
			});
			function programServiceCombo(program_type)
			{
				var form_data = {
						program_type: program_type,
						selected:$("#PSO").val(),
						ajax: '4'		
					};
				$.ajax({
						url: SITE_URL+'master/program_service/program_service_combo',
						type: 'POST',
						data: form_data,
						success: function(msg) {
							$('#programServiceOffering').html(msg);
						}
				});
			}
			function programStageCombo(program_service)
			{
				var form_data = {
						program_service: program_service,
						selected:$("#PSTAGE").val(),
						ajax: '4'		
					};
				$.ajax({
						url: SITE_URL+'master/program_stage/program_stage_combo',
						type: 'POST',
						data: form_data,
						success: function(msg) {
							$('#programStage').html(msg);
						}
				});
			}