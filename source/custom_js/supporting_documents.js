// JavaScript Document
$(document).ready(function(){
		$("[name='document_type']").change(function(){
			if(this.value == '52')
			{
				$('.showYoutube').show();
				$("[name='document']").removeClass('required');
			}
			else
			{
				$('.showYoutube').hide();
				$('.youtubeField').hide();
				$("[name='document']").addClass('required');
			}
		});
		
		$(".showYoutube").click(function(){
			$('.youtubeField').show();
		});
		$(".hideYoutube").click(function(){
			$('.youtubeField').hide();
		});
	});