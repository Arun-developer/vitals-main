		<section id="main" style="height:100px !important;">
		<form id="rejectrequestform" action="<?=site_url('invester/liststatus/reject/'.$innovationid.'/'.$id);?>" class="uniform" method="post">
		  <? $status=0; ?>
		 <input type="hidden" name="innovationid" value="<?= $innovationid;?>" />
		 <input type="hidden" name="id" value="<?=$id;?>" />
		 <input type="hidden" name="status" value="<?= $status;?>" />
				<h1><?=$cpagetitle?></h1>
               <div class="buttons">
			     <input type="submit" name="rejectSubmit" value="Submit" class="button" />
           		 <input type="reset" value="Reset" class="button white" />
               </div>
		</form>
	
		</section>