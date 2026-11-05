// JavaScript Document
	$(document).ready(function() {
		//get source list
		$("#sourceType").change(function(){
			sourceCombo(this.value);
			//alert($("[name='source_select']").val() );
			if( $("[name='source_select']").val() != '-1' || $("#sourceType").val() == '') {
				//alert($("#sourceType").val());				
				$('#src_others').hide();
			}
			else
			{
				$('#src_others').show();
			}
			
		});
		if($("#sourceType").val() != '-1'){
			sourceCombo($("#sourceType").val());
		}
		if($('#sourceList').val()){
			instanceCombo($("#source").val());
		}
		function sourceCombo(source_type)
		{
			//alert($("[name='source']").val());
			source_select = $("[name='source_select']").val();
			source_others = $("[name='source_others']").val();
			var form_data = {
					source_type: source_type,
					source_select: source_select,
					source_others:source_others,
					ajax: '4'		
				};
			$.ajax({
					url: SITE_URL+'master/source/get_source_combo',
					type: 'POST',
					data: form_data,
					success: function(msg) {
						$('#sourceList').html(msg);
						$('#instanceList').html('<option value="">-Select-</option>');
					}
			});
		}
		
		//get instance list
		$("#sourceList").change(function(){
			instanceCombo(this.value);
			if( $("#sourceList").val() == '-1') {
				$('#src_others').show();
			} else {
				$('#souce_others').val('');
				$('#src_others').hide();
			}
		});
		//var e = document.getElementById('sourceList');
		var value = $("[name='source_select']").val();
		//alert($("[name='source_select']").val());
		if(value == '-1') {
				$('#src_others').show();
			}
		else {
				$('#souce_others').val('');
				$('#src_others').hide();
		}
		
		$("#sectorList").change(function(){
			if($("#sectorList").val() == "others") {
				$('#sector_others').show();
			} else {
				$("[name='sector_others']").val('');
				$('#sector_others').hide();
			}
		});
		
		
		if($("#sourceList").val()){
			instanceCombo($("#sourceType").val());
		}
		source_select = $("[name='source_select']").val();
		if(source_select != '-1')
		{
			instanceCombo(source_select);
		}
		else
		{
			if($("#sourceList").val() == '-1') {
				$("#src_others").show();
			}
		}
		function instanceCombo(sourceid){
			instance_select = $("[name='instance']").val();
			var form_data = {
					source: sourceid,
					instance_select: instance_select,
					ajax: '4'		
				};
			$.ajax({
					url: SITE_URL+'master/instance/get_instance_combo',
					type: 'POST',
					data: form_data,
					success: function(msg) {
						$('#instanceList').html(msg);
					}
			});
		}
		$('.addDocument').click(function(){
			var cloned = $('.cloneDocument').clone().removeClass('cloneDocument');
				$('.documentTable').append(cloned);
				$('.uniform input[type="file"]').uniform();
		});
		$('.removeDocument').live('click',function(){
				$(this).parents('tr').remove();
		});
		
		$("[name='business_plan']").change(function(){
			businessPlan();
		});
		businessPlan();
		function businessPlan()
		{
			var business = $("[name='business_plan']:checked").val();
			if(business == 'Yes')
			{
				$(".businessDocField").show();
			}
			else
			{
				$(".businessDocField").hide();
			}
		}
		$("[name='document_type[]']").live('change',function(){
			var videoOption = $('input[name=videoOption]').val();
			if(this.value == videoOption)
			{
				$(this).parents('tr').find('.showYoutube').show();
			}
			else
			{
				$(this).parents('tr').find('.showYoutube').hide();
				$(this).parents('tr').find('.youtubeField').hide();
			}
		});
		
		$(".showYoutube").live('click',function(){
			$(this).parents('tr').find('.youtubeField').show();
		});
		$(".hideYoutube").live('click',function(){
			$(this).parents('tr').find('.youtubeField').hide();
		});
	});

