// JavaScript Document
$(document).ready( function() {
			$('.sortlink').click(function(){
				field = $(this).attr('field');
				orderType = $('[name=ordertype]').val();
				orderType = (orderType == 'asc')?'desc':'asc';
				$('[name=orderby]').val(field);
				$('[name=ordertype]').val(orderType);
				$('.searchForm').submit();
			});	
			//search box toggle
			changeSearchText();
			$('.toggleSearch').click(function(){
				$('.searchBox').toggle();
				changeSearchText();
			});
			function changeSearchText()
			{
				displayVal = $('.searchBox').css('display');
				if(displayVal == 'block')
				{
					$('.toggleSearch').html('Hide Search');
				}
				else
				{
					$('.toggleSearch').html('Show Search');
				}
			}
			
			//export
			$('.exportLink').click(function(){
				$('.exportOption').show();
			});
			$('.closeExport').click(function(){
				$('.exportOption').hide();
			});
			$("[name='report_data']").change(function(){ 
				if($(this).val() != '')
				{
					$("[name='export']").val($(this).val());
					$('.exportOption').hide();
					$(".searchForm").submit();
					$("[name='export']").val('');
				}
			});
		
});