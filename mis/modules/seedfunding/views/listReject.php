		<section id="main" style="height:100px !important;">
		    <form id="rejectrequestform" action="<?=site_url('seedfunding/liststatus/reject/'.$innovationid);?>"
		        class="uniform" method="post">
		        <?php $editrequest_status=2; ?>
		        <input type="hidden" name="innovationid" value="<?= $innovationid;?>" />
		        <input type="hidden" name="editrequest_status" value="<?=$editrequest_status;?>" />
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