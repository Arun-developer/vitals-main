		<section id="main" style="height:200px !important;">
		    <form id="rejectrequestform"
		        action="<?=site_url('mentor/changevillgrostatus/reject/'.$innovationid.'/'.$requestid);?>" class="uniform"
		        method="post">
		        <?php $status=2; ?>
		        <input type="hidden" name="villgrostatus" value="<?= $status;?>" />
		        <input type="hidden" name="requestid" value="<?=$requestid;?>" />

		        <input type="hidden" name="mentorid" value="<?= $mentorid;?>" />
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