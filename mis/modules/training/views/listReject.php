		<section id="main" style="height:100px !important;">
		<form id="rejectrequestform" action="<?=site_url('training/liststatus/reject/'.$innovationid.'/'.$id);?>" class="uniform" method="post">
		  <?php $status=1; ?>
		 <input type="hidden" name="innovationid" value="<?= $innovationid;?>" />
		 <input type="hidden" name="id" value="<?=$id;?>" />
		 <input type="hidden" name="status" value="<?=$status;?>" />
				<h1><?=$cpagetitle?></h1>
			<dl class="inline">        
             	<dt><label for="namesd">Comments</label></dt>
				<dd>
					<textarea name="comments" id="comments" class=""></textarea>
			   </dd>  
			 </dl>
               <div class="buttons">
			     <input type="submit" name="rejectSubmit" value="Submit" class="button" />
           		 <input type="reset" value="Reset" class="button white" />
               </div>
		</form>
	
		</section>