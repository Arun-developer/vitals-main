	<h1><?=$cpagetitle?></h1>
	<table class="gtable detailtable">
	    <thead>
	        <tr>
	            <th><a href="#">Document Type</a></th>
	            <th><a href="#">Document Name</a></th>
	            <th><a href="#">Download</a></th>
	            <th><a href="#">Delete</a></th>
	        </tr>

	    </thead>
	    <tbody>
	        <?php
	foreach($documentList as $row): 
	?>
	        <tr class="odd">
	            <td><?=$row['document_type_value']?></td>
	            <td><?=$row['document']?></td>
	            <td>
	                <?php if($row['document'] != ""){ ?>
	                <a href="<?=base_url();?>uploads/innovaton/supporting_documents/<?=$row['document']?>"
	                    target="_blank"><img src="<?=base_url();?>source/template/images/icons/download.gif" alt="Download"
	                        height="16" /></a>
	                <?php } if($row['youtube'] != ""){ ?>
	                <a href="<?=$row['youtube']?>" class="youtube button">Youtube</a>
	                <?php } ?>
	            </td>
	            <td><a href="javascript:void(0);"
	                    url="<?=site_url('scouting/delete_document/'.$row['innovation'].'/'.$row['id']);?>"
	                    class="deleteDocument confirmDelete"><img
	                        src="<?=base_url();?>source/template/images/icons/cross.png" alt="Delete" /></a></td>

	        </tr>
	        <?php 
	endforeach;
	?>
	    </tbody>
	</table>
	<!-- Paging style -->

	<h2>Add Supporting Documents</h2>
	<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>

	<form name="addDocument" enctype="multipart/form-data"
	    action="<?=site_url('scouting/innovation_document/'.$innovation['id']);?>" method="post" class="uniform"
	    id="addDocument">
	    <dl class="inline">
	        <dt><label for="source_type">Document Type<font color="red">*</font></label></dt>
	        <dd><select name="document_type" class="required" id="sourceType">
	                <option value="">-Select-</option>
	                <?php
        foreach($documentTypeList as $row):
            ?>
	                <option value="<?=$row['id']?>"><?=$row['master_name']?></option>
	                <?php 
        endforeach;
        ?>
	            </select></dd>

	        <dt><label for="source_type">Document<font color="red">*</font></label></dt>
	        <dd><input type="file" name="document" class="required" />
	            <a href="javascript:void(0);" style="display:none" class="showYoutube button">Youtube</a>
	            <div style="display:none; padding-top:5px;" class="youtubeField">
	                <input type="text" name="youtube" class="input-text" size="40" /><br />
	                Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank" style="color:#666;">
	                    http://www.youtube.com/watch?v=F7lao4eonuI</a>
	                &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube">Hide</a></div>
	        </dd>
	    </dl>


	    <div class="clear"></div>
	    <div class="buttons">
	        <input type="submit" value="Upload" name="txtSubmit" class="button" />
	        <input type="reset" value="Reset" name="txtReset" class="button white" />
	    </div>
	</form>

	<!-- end id-form  -->