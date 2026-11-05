<?php

$documentTypeList = array();

$cpagetitle = "Incubation Application Form";



function base_url()

{

	return "https://mis.villgroapps.org/";

}



$site_url = base_url()."index.php/";





$knowAboutUs = array('Villgro\'s Incubatee','Villgro\'s Employee','Web surf','e-mailers','Referral','Others');

$videoOption = '52';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<meta http-equiv="content-language" content="en" />

	<meta name="robots" content="noindex,nofollow" />

	<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/style.css">

<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/skins/green.css" title="green">



<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/mystyle.css" /> 



<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/cufon-yui.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/Delicious_500.font.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.flot.min.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.cookie.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/switcher.js"></script>



<script type="text/javascript" src="<?=base_url();?>source/template/js/custom.js"></script>

<!--[if lte IE 8]>

<script type="text/javascript" src="<?=base_url();?>source/template/js/html5.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/selectivizr.js"></script>

<script type="text/javascript" src="<?=base_url();?>source/template/js/excanvas.min.js"></script>

<![endif]-->







    <!-- WRITE YOUR CSS CODE HERE -->

    <script type="text/javascript" src="<?=base_url();?>source/js/jquery.js"></script>  

    

     <link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/uniform.default.css">

    <script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.uniform.min.js"></script>

	<script type="text/javascript">

     $(document).ready( function() {

         $('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();

     });

     </script>

         

	

    <script src="<?php echo base_url();?>source/validate/jquery.validate.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>source/validate/jquery.metadata.js" type="text/javascript"></script>

    <script type="text/javascript">

			$.metadata.setType("attr", "validate");

			$(document).ready(function() {

									   

				jQuery.validator.addMethod("phone", function(value, element) { 

					  return this.optional(element) || /^[\+0-9\-]+$/.test(value); 

					}, "Please Enter Valid Phone Number");

				jQuery.validator.addMethod("mobile", function(value, element) { 

					  return this.optional(element) || /^[\+0-9\-]+$/.test(value); 

					}, "Please Enter Valid Mobile Number");

				

				$("#new_innovation").validate();

			});

	</script>

    <script type="text/javascript">

	$(document).ready(function() {

		

		$('.addDocument').click(function(){

			var cloned = $('.cloneDocument').clone().removeClass('cloneDocument');

				$('.documentTable').append(cloned);

				$('.uniform input[type="file"]').uniform();

		});

		

		$('.removeDocument').live('click',function(){

				$(this).parents('tr').remove();

		});

		

		$("[name='reference']").change(function(){

			if(this.value == 'Others')		

				$('.otherReferenceField').show();

			else

				$('.otherReferenceField').hide();

		});

		

		$("[name='business_plan']").change(function(){

			businessPlan = $("[name='business_plan']:checked").val();

			if(businessPlan == 'Yes')

			{

				$(".businessDocField").show();

			}

			else

			{

				$(".businessDocField").hide();

			}

		});

		

		$("[name='document_type[]']").live('change',function(){

			var videoOption = $('input[name=videoOption]').val();

			if(this.value == '<?=$videoOption?>')

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

	</script>

    

    

    <style type="text/css">

  	.successBox

	 {

		 font-size:16px;

		 color:#006E37;

		 font-weight:bold;

		 text-align:center;

		 vertical-align:middle;

		 border:2px dotted #73C904;

		 padding:30px;

		 background:#F0FAFF;

		 width:60%;

		 margin:auto;

		 margin-top:150px;

		 

	 }

    </style>

	<title><?=$cpagetitle?></title>

</head>



<body>

<!--<header id="top">

	<div class="container_12 clearfix">

		<div id="logo" class="grid_5">

			<h2 style="border:none"><?=$cpagetitle?></h2>

            <p id="logo" style="float:right; margin-top:-20px;">

            <a href="#"><img src="<?php echo base_url(); ?>source/template/images/logo.gif" title="Villgro"></a></p>

		</div>

	</div>

</header>-->



<section id="content">

	<section class="container_12 clearfix">

		<section id="main" class="grid_14">

        	<article id="application">

           <h1><?=$cpagetitle?></h1>

            <p id="logo" style="float:right; margin-top:-20px;">

            <a href="#"><img src="<?php echo base_url(); ?>source/template/images/logo.gif" title="Villgro"></a></p><br />



            

			 <?php  if(@$_GET['msg'] != 'success'){ ?>

                <p>Please provide the information in the boxes below. We will review your application and get back to you as soon as possible. Please contact <a href="mailto:scouting@villgro.org"><strong>scouting@villgro.org</strong></a> if you have problem in filling the application form. </p><br />





<p style=" color:red; font-weight:bold;">Note : Fields marked with (*) represents required. </p>



 <form name="new_innovation" action="<?=$site_url.'scouting/application';?>" enctype="multipart/form-data" method="post" id="new_innovation" class="uniform">

         <dl class="inline" style="margin-left:100px;">

	            

                <dt><label for="name_of_entrepreneur">Name of the Promoter<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="name_of_entrepreneur" class="input-text required"/></dd>

                

                <dt><label for="phone_no">Phone Number<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="phone_no" class="input-text required phone" /></dd>

                

                <dt><label for="mobile_no">Mobile Number<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="mobile_no" class="input-text required mobile" /></dd>

                

                <dt><label for="email_id">Email Address<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="email_id" class="input-text required email" /></dd>

                

                <dt><label for="address_line1">Address Line 1<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="address_line1" class="input-text required" /></dd>

                

                <dt><label for="address_line2">Address Line 2<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="address_line2" class="input-text required" /></dd>

                

                <dt><label for="city">City<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="city" class="input-text required" /></dd>

                

                <dt><label for="newstitle">District<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="district" class="input-text required" /></dd>

                

                <dt><label for="state">State<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="state" class="input-text required" /></dd>

                

                <dt><label for="country">Country<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="country" class="input-text required" /></dd>

                

                <dt><label for="pincode">Pin Code<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="pincode" class="input-text required number" /></dd>

                       

                <dt><label for="name_of_enterprise">Name of the Enterprise<span class="req_field">*</span></label></dt>

                <dd><input type="text" size="40" name="name_of_enterprise" class="input-text required checkDuplicate" /></dd>

                     

                <dt><label for="website">Website (if available)</label></dt>

                <dd><input type="text" size="40" name="website" class="input-text" /></dd>

                       

                <dt><label for="summary">A Short Summary of your Business.<br/>What Product / services do your offer?

                <span class="req_field">*</span></label></dt>

                <dd><textarea cols="40" rows="5" class="input-text required" name="summary"></textarea></dd>

                

                <dt><label for="entreprise_years">For how long have you been in operation?<span class="req_field">*</span></label></dt>

                <dd>

                  <label><input type="radio" name="entreprise_years" class="required" value="Less than 1 year" checked="checked" /> Less than 1 year </label><br />

                  <label><input type="radio" name="entreprise_years" class="required" value="1 year to 2 years"  /> 1 year to 2 years</label><br/>

                  <label><input type="radio" name="entreprise_years" class="required" value="More than 2 years"  /> More than 2 years </label>

                </dd>

                

                

                <dt><label for="business_plan">Do you have a Business Plan?<span class="req_field">*</span></label></dt>

                <dd>

                	<label><input type="radio" name="business_plan" class="required" value="Yes" /> Yes </label> <br />

                    <label><input type="radio" name="business_plan" class="required" value="No" checked="checked"/> No </label>

                </dd>

               

                <dt style="display:none" class="businessDocField"><label for="business_plan_document">Upload Business Plan Document</label></dt>

                <dd style="display:none" class="businessDocField"><input type="file" name="business_plan_document"  /></dd>

                

                <dt><label for="phone_no">Any other supporting document you would like to share pertaining to the product/service?</label></dt>

                <dd>

                  <table width="650" border="0" cellspacing="5" cellpadding="5"  class="documentTable gtable sortable">

                  <tr>

                     <td><strong>Document Type:</strong></td>

                     <td><strong>Document:</strong></td>

                     <td><a href="javascript:void(0);" class="addDocument button">Add Row</a>&nbsp;</td>

                  </tr>

                  <tr>

                   <td> 

                   <select id="sourceType" name="document_type[]">

                            <option value="">-Select-</option>

                                                <option value="51">Photograph of the product</option>

                                                <option value="52">Videos</option>

                                                <option value="53">Marketing Collateral</option>

                                                <option value="54">Media Coverage</option>

                                                <option value="55">Lab Test Results</option>

                                                <option value="56">Field Trial Report</option>

                                                <option value="57">Design Document/Drawings</option>

                                                <option value="58">Patent Filing details</option>

                                        </select><font color="red"></font></td>

                    <td><input type="file" name="supporting_documents[]"  />

                     <a href="javascript:void(0);" style="display:none" class="showYoutube button">Youtube</a> 

                   <div style="display:none; padding-top:5px;" class="youtubeField">

                   <input type="text" name="youtube[]" class="input-text" size="40"  /><br />

                       Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank" style="color:#666;" >

                       http://www.youtube.com/watch?v=F7lao4eonuI</a>

                       &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube" >Hide</a></div></td>

                    <td>&nbsp;</td>

                  </tr>

                </table>

                </dd>

                

                <dt><label for="reference">How did you come to know about us?</label></dt>

                <dd>

					<?php foreach($knowAboutUs as $key=>$value):?>

                              <label><input type="radio" name="reference" class="check" value="<?=$value?>" /><?=$value?></label> <br />

                    <?php endforeach;?>

                </dd>



                <dt style="display:none" class="otherReferenceField"><label for="phone_no">Others (Please Mention)</label></dt><td></td>

                <dd style="display:none" class="otherReferenceField"><input type="text" size="40" name="other_reference" class="input-text" /></dd>

       </dl>

              

             <div class="buttons" style="margin-left:300px;">

             		<input type="submit" class="button" name="txtSubmit" value="Submit" />&nbsp;&nbsp;

                    <input type="reset" class="button white" name="txtReset" value="Reset" />

             </div>

 </form>

 <table style="display:none">

                 <tr class="cloneDocument">

                   <td> 

                   <select id="sourceType" name="document_type[]">

                            <option value="">-Select-</option>

                                                <option value="51">Photograph of the product</option>

                                                <option value="52">Videos</option>

                                                <option value="53">Marketing Collateral</option>

                                                <option value="54">Media Coverage</option>

                                                <option value="55">Lab Test Results</option>

                                                <option value="56">Field Trial Report</option>

                                                <option value="57">Design Document/Drawings</option>

                                                <option value="58">Patent Filing details</option>

                                        </select></td>

                    <td><input type="file" name="supporting_documents[]" />

                   <a href="javascript:void(0);" style="display:none" class="showYoutube button">Youtube</a> 

                   <div style="display:none; padding-top:5px;" class="youtubeField">

                   <input type="text" name="youtube[]" class="input-text" size="40"  /><br />

                       Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank" style="color:#666;" >

                       http://www.youtube.com/watch?v=F7lao4eonuI</a>

                       &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube" >Hide</a></div>

                    </td>

                    <td><a href="javascript:void(0);" class="removeDocument" style="color:red; font-weight:bold;">Remove</a></td>

                  </tr>

                </table>

                <?php }else{ ?>

                <div class="successBox"><div ><img src="login_source/tick.jpg" height="50"   /></div> Application sent Successfully</div>

                <?php } ?>

			 </article>

		</section>

	</section>

</section>





<footer id="bottom">

	<section class="container_12 clearfix">

		<div class="grid_6 alignright">

			Copyright &copy; 2011 <a href="#">villgro.org</a>

		</div>

	</section>

</footer>





</body>

</html>