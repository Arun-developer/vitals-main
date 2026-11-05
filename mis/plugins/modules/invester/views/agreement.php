
<section id="content">
	<section class="container_12 clearfix">
		<section id="main" >
			<article id="dashboard">
		<h1>Terms and Condition</h1>
		<!--Signed Copy Uploaded by Innovator-->

<form name="documents" action="<?=site_url('invester/agreement/'.$innovationid.'/'.$investerid.'/'.$id);?>" enctype="multipart/form-data" method="post" id="documents"  class="uniform">
    <fieldset>
    <legend>Terms & Condition Document by Investor</legend>
    <dl class="inline">
        <dt><label for="signed_document">Signed Document</label></dt>
        <dd>
        <input type="file" size="40" class="required" name="investerfiledoc"  />
		
           <?php if(isset($rowdata['invester_agreement']))
			{?>
            (<a target="_blank" href="<?=base_url()?>/uploads/invester/agreement/investeragreement/<?php echo str_replace(" ","_",$rowdata['invester_agreement'])?>"><?= $rowdata['invester_agreement']?></a>)
			<?php } ?>
        </dd>
    </dl>
    <div class="buttons">
	    <input type="hidden" name="uploadby"  value="Invester" />
		<input type="hidden" name="id"  value="<?php echo $id ?>" />
        <input type="submit" class="button" name="fileSubmit" value="Upload" id="submit" />&nbsp;&nbsp;
        <input type="reset" class="button white" name="txtReset" value="Reset" />
    </div>
    </fieldset>
</form>


<!--Signed Copy Uploaded by Villgro-->
 <form name="documents" action="<?=site_url('invester/agreement/'.$innovationid.'/'.$investerid.'/'.$id);?>" enctype="multipart/form-data" method="post" id="documents"
     class="uniform">
    <fieldset>
    <legend>Terms & Condition Document by Incubatee</legend>
        <dl class="inline">
            <dt><label for="signed_document">Signed Document</label></dt>
            <dd>
            <input type="file" size="40" class="required" name="incubateefiledoc"  />
			 <?php if(isset($rowdata['incubatee_agreement']))
			  {?>
               (<a target="_blank" href="<?=base_url()?>/uploads/invester/agreement/incubateeagreement/<?php echo str_replace(" ","_",$rowdata['incubatee_agreement']);?>"><?=$rowdata['incubatee_agreement']?></a>)  
	   <?php  } ?>
            </dd>
        </dl>
        <div class="buttons">
		    <input type="hidden" name="uploadby"  value="Incubatee" />
			<input type="hidden" name="id"  value="<?php echo $id ?>" />
            <input type="submit" class="button" name="fileSubmit" value="Upload" id="submit" />&nbsp;&nbsp;
            <input type="reset" class="button white" name="txtReset" value="Reset" />
        </div>
       </fieldset>
    </form>
 
			</article>
		</section>
        
        
		
		
	</section>
</section>
