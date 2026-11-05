// JavaScript Document
function check(){
  var k = '';
  $(':checkbox:checked').each(function()
  {	 k = 'yes';	  });
  if(k == '')
  {
		alert('Please Select the Innovation!');
		return false;
  }}
$(document).ready(function() {
	$(".fancyboxt").fancybox({onStart:check});});