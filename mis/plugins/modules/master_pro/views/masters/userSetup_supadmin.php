
<h1><?=$cpagetitle?></h1>
<script type="text/javascript">
$(document).ready(function(){

	 $("#branch").change(function(){
	 		var branch = $(this).val();
	 	  		$.ajax({
	 	  		   type:"POST",
	 	  		   dataType: 'json',
    			   url: "<?php echo site_url('master/user_setup_sa');?>",
				   data: {'branch':branch},
					success: function(response) {
						         		var options = '';  
										var options_finance = '';
                        if(response.users=='' && response.defaultt==null)
                        {
                            options= '<option value=""> Select </option>';
							options_finance= '<option value=""> Select </option>';
                            $("#ceo").html(options);
                            $("#cio").html(options);
                            $("#icm").html('');
                            $('#icm').multiselect('destroy');
                            $("#icm").multiselect();
                            $("#abi").html('');
                            $('#abi').multiselect('destroy');
                            $("#abi").multiselect();
                            $("#pre_ic").val('');
                        }
                        else if(response.users!='' || response.defaultt!=null)   
                        {   
                            '<option value="">Select </option>';
                          	for (var i = 0; i < response.users.length; i++) 
                            {
                                options += '<option value="' + response.users[i].emp_number + '">' + response.users[i].emp_name + '</option>';                        		
                          	}
							for (var i = 0; i < response.users.length; i++) 
                            {
                                options_finance += '<option value="' + response.users[i].id + '">' + response.users[i].emp_name + '</option>';
                          	}
                          	$("#ceo").html(options);
                            if(response.defaultt !=null)
                          	{
                                $("#ceo").find("option[value="+response.defaultt.ceo+"]").prop("selected", "selected");
                            }
                            $("#cio").html(options);
                            if(response.defaultt !=null)
                          	{
                                $("#cio").find("option[value="+response.defaultt.cio+"]").prop("selected", "selected");
                            }
                        	  $('#icm').multiselect('destroy');
                        	  $("#icm").html(options);
                            if(response.defaultt !=null)
                            {
                        	      for (var i = 0; i < response.users.length; i++) {
                        		      if($.inArray(response.users[i].emp_number,response.defaultt.icm)!= -1)
                                  	  {
                                			$("#icm").find("option[value="+response.users[i].emp_number+"]").prop("selected", "selected");
                        		      }
                                  }
                            }
                        	$('#icm').multiselect();
                        	$("#icm").multiselect("refresh");
                        	$('#abi').multiselect('destroy');
                        	$("#abi").html(options);
                          if(response.defaultt !=null){
                        	for (var i = 0; i < response.users.length; i++) {
                        	           	if($.inArray(response.users[i].emp_number,response.defaultt.abi)!= -1){

                        			$("#abi").find("option[value="+response.users[i].emp_number+"]").prop("selected", "selected");
                        		}
                            }}
                        	$('#abi').multiselect();
                        	$("#abi").multiselect("refresh");

							$('#finance').multiselect('destroy');
                        	$("#finance").html(options_finance);
                          if(response.defaultt !=null){
                        	for (var i = 0; i < response.users.length; i++) {
                        	    if($.inArray(response.users[i].id,response.defaultt.finance)!= -1){
									
                        			$("#finance").find("option[value="+response.users[i].id+"]").prop("selected", "selected");
                        		}
                            }}
                        	$('#finance').multiselect();
                        	$("#finance").multiselect("refresh");

                          $("#pre_ic").val('');
                          if(response.defaultt !=null){
                        	$("#pre_ic").val(response.defaultt.pre_ic);}
                        }
                    
                	}
                	

						
					});
	});
});
</script>
<!-- start id-form -->
<?php $setup = $userSetup;
?>
<form name="reportForm" enctype="multipart/form-data" action="<?=site_url('master/user_setup_add');?>" method="post" id="reportForm" >
<dl class="inline">
	   <dt><label for="program">Partner</label></dt>
        
      	<dd>
          <select name="branch" id="branch">
              <option value="">Select Partner</option>
              <?php 
              foreach ($branch as $partner) { ?>
                 <option value="<?php echo $partner['id'];?>"<?php echo ($branch_name==$partner['id'])?('selected'):(''); ?>><?php echo $partner['branch_name'];?> </option>
              <?php } ?>
          </select>
        </dd>


	 	<dt><label for="ceo">CEO : </label></dt>
		<dd>
		<select name="ceo" id="ceo" >
			<option value="">Select</option>
		</select>
		<font class="req_field"></font>
		<?php echo form_error('report_type', '<div class="errorMsg">', '</div>'); ?>
		</dd>
	 

    <dt><label for="message type">Chief Incubation Officer :	</label></dt>
	<dd>
		<select name="cio" id="cio" >
			<option value="">Select</option>
		</select>
		<font class="req_field"></font>
		<?php echo form_error('cio', '<div class="errorMsg">', '</div>'); ?>
	</dd>


    <dt><label for="incubation committee">Incubation Committee Members:</dt>
	<dd>
	<select id="icm" class="multiselect" multiple="multiple" name="icm[]" >
	
	 </select>
	 <font class="req_field"></font>
	<?php echo form_error('icm', '<div class="errorMsg">', '</div>'); ?>
	</dd>


   	 <dt><label for="associate">Associate: Business Incubation</dt>
	<dd>
	<select id="abi" class="multiselect" multiple="multiple" name="abi[]" >
	 
	 </select>
	 <font class="req_field"></font>
	<?php echo form_error('abi', '<div class="errorMsg">', '</div>'); ?>
	</dd>

	<dt><label for="associate">Finance Members</dt>
<dd>
  <select id="finance" class="multiselect" multiple="multiple" name="finance[]" >
  
</select>
</dd>


    <dt><label for="pre incubation">Pre - Incubation Committee</label></dt>
	<dd>
    	<input type="text" size="40" id="pre_ic" name="pre_ic" class="input-text email" />
    </dd>

</dl>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
</div>

</form>
<!-- end id-form  -->

