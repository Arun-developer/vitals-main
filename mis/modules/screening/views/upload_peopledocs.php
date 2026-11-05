<?php
$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>
<h1><?php echo $cpagetitle;?></h1>

<form name="ndaForm" enctype="multipart/form-data"
    action="<?=site_url('screening/upload_docs/'.$innovation.'/'.$criteria.'/'.$subfield.'/'.$rowID.'/'.$id);?>"
    method="post" id="ndaForm" class="uniform">
    <input type="hidden" name="rowID" value="<?php echo $rowID;?>" />
    <input type="hidden" name="editID" value="<?php echo $id;?>" />
    <fieldset>
        <legend>External Document</legend>
        <dl class="inline">
            <dt><label for="copy1">Upload Document<font class="req_field">*</font></label></dt>
            <dd>
                <div id="uniform-undefined" class="uploader">
                    <input class=" " type="file" name="uploadDocs" size="40" style="opacity: 0;">
                    <span class="filename" style="-moz-user-select: none;">No file selected</span>
                    <span class="action" style="-moz-user-select: none;">Choose File</span>
                </div>
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Upload" name="txtFileSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>