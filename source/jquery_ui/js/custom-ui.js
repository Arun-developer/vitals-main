// custome Jquery ui
$(function(){
	$(".multiselect").multiselect();
	
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
	
	$('.datetimepicker').datetimepicker();
	
	/* $( ".datepicker_past" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: today_date()
	}); */	
	$( ".datepicker_future" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//minDate: today_date()
	});
	var dates = $( "#fromdate, #todate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "fromdate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});