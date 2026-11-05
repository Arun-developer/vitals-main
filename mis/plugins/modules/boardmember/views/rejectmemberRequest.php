		<section id="main" style="height:200px !important;">
			<form id="rejectrequestform" action="<?=site_url('boardmember/changememberstatus/reject/'.$innovationid.'/'.$id);?>" class="uniform" method="post">
			  <? $status=2; ?>
			 <input type="hidden" name="memberstatus" value="<?= $status;?>" />
		    <input type="hidden" name="requestid" value="<?=$requestid;?>" />
		   	<input type="hidden" name="innovationid" value="<?= $innovationid;?>" />
		    <input type="hidden" name="boardid" value="<?= $boardid;?>" />
			<input type="hidden" name="detailid" value="<?= $id;?>" />
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