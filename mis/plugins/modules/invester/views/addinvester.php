<?php 
        $formAction = "";
        $id = '';
		
		$val = array();
		if(count($investerDetails)>0)
		{  
			$val = $investerDetails['0'];
			$formAction = site_url('invester/form/'.$innovationid.'/'.$val['id']);
			$id = $val['id'];
			$action = 'edit';
		    $amount = isset($val['amount'])? $val['amount']:""; 
		    $sector = isset($val['sector'])? $val['sector']:""; 
			$description = isset($val['description'])? $val['description']:""; 
		}
		else
		{
		    $formAction = site_url('invester/form/'.$innovationid);  
			$action = 'add';
			$amount = isset($_REQUEST["amount"])?$_REQUEST["amount"]:"";
		    $sector = isset($_REQUEST["sector"])?$_REQUEST["sector"]:"";
		    $description = isset($_REQUEST["description"])?$_REQUEST["description"]:"";
		 }

?>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="addMemberForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 
<input type="hidden" value="<?=$innovationid; ?>" name="innovationid" />


	<h1><?=$cpagetitle?></h1>
	<fieldset>
	<legend><?=$cpagetitle?></legend>
	<dl class="inline">
                          
             	<dt><label for="namesd">Sector</label></dt>
				<dd>
				   <select name="sector" id="sector" class="medium">
        	         <option value="">-Select-</option>
					<?php
					foreach($sectorarr as $row):
						?>
						<option value="<?=$row ;?>"  <?php echo ($sector==$row)?('selected'):(''); ?> ><?=$row;?></option>
						<?php 
					endforeach;
					?>
                    </select>
				
					<small>Sector</small>
			   </dd>   
               
               <dt><label for="namesd">Investment Required(in Rs.)</label></dt>
				<dd>
					<input type="text" name="amount" id="amount" class="medium " size="50" value="<?php echo $amount; ?>" />
				
			   </dd>           
                                 
                <dt><label for="comments">Description</label></dt>
                <dd><textarea  name="description" id="description" class="medium"><?php echo $description; ?></textarea>
				<small> Write requirement description for board member</small></dd>
                 				
     	</dl>
			    <div class="buttons">
			     <input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
               </div>
			</fieldset>
</form>

<!-- end id-form  -->