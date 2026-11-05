		<section id="main" style="height:200px !important;">
		<form id="rejectrequestform" action="<?=site_url('media/addinnovator_detail/'.$innovationid.'/'.$id);?>" class="uniform" method="post">
		 
		  <input type="hidden" name="innovationid" value="<?= $innovationid;?>" />
		  <input type="hidden" name="id" value="<?=$id;?>" />
			 
				<h1><?=$cpagetitle?></h1>
			 <dl class="inline">        
             	<dt><label for="namesd">Enter Information</label></dt>
				<dd>
					<textarea name="comments" id="comments" class="" rows="25px" cols="50px"></textarea>
			   </dd>  
			 </dl>  
               <div class="buttons">
			     <input type="submit" name="txtsubmit" value="Submit" class="button" />
           		 <input type="reset" value="Reset" class="button white" />
               </div>
		</form>
	
		</section>