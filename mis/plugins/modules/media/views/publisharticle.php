<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
    $("#vendorForm").validate();
});
</script>
<?php
	$nullLink = 0;
	
	if(isset($_POST['id'])){ $val = $_POST; }
	$title = isset($val["title"])?$val["title"]:"";
	$topic = isset($val["topic"])?$val["topic"]:"";
	$description = isset($val["description"])?$val["description"]:"";
	$media_name = isset($_REQUEST["media_name"])?$_REQUEST["media_name"]:"";
	$media_type = isset($_REQUEST['media_type'])?$_REQUEST['media_type']:"";
	$journalist_name = isset($_REQUEST['journalist_name'])?$_REQUEST['journalist_name']:"";
	$description = isset($_REQUEST['description'])?$_REQUEST['description']:"";
	$document = isset($_REQUEST['document'])?$_REQUEST['document']:"";
	$publish_date = isset($_REQUEST['publish_date'])?$_REQUEST['publish_date']:"";
	$interview  = isset($_REQUEST['interview'])?$_REQUEST['interview']:"";
	
?>
<div id="user-grid" class="gtable sortable">

    <table width="100%" class="items">
        <thead>
            <tr>
                <th><a href="<?=$nullLink?>" field="label">Media Name</a></th>
                <th><a href="<?=$nullLink?>" field="label">Media Type</a></th>
                <th><a href="<?=$nullLink?>" field="label">Article Title</a></th>
                <th><a href="<?=$nullLink?>" field="label">Article Topic</a></th>
                <th><a href="<?=$nullLink?>" field="required">Journalist Name</a></th>
                <th><a href="<?=$nullLink?>" field="value">Articles</a></th>

            </tr>
        </thead>
        <tbody>
            <?php
	if(count($mediaList))
	{    
		$r=1;
		foreach($mediaList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
            <tr class="<?=$row_type?>">
                <td align="left" valign="middle"><?=$row["media_name"];?></td>
                <td align="left" valign="middle"><?=$row["media_type"];?></td>
                <td align="left" valign="middle"><?=$row['title'];?></td>
                <td align="left" valign="middle"><?=$row['topic'];?></td>
                <td align="left" valign="middle"><?=$row['journalist_name'];?></td>
                <td align="left" valign="middle"><a
                        href="<?=site_url('master/media/download/'.$row['article'])?>"><?=$row['article'];?></a></td>
            </tr>
            <?php 
		}
	}
	else
	{ ?>
            <tr>
                <td colspan='9' align='center'>No Records found!</td>
            </tr>
            <?
	} ?>
        </tbody>

    </table>
</div>
<form name="vendorForm" enctype="multipart/form-data" action="<?=site_url('media/publisharticle/');?>" method="post">
    <input type="hidden" name="innovation" value="<?=$innovationid?>" />
    <fieldset>
        <legend>Add Publish Article</legend>
        <dl class="inline">
            <dt><label for="name">Title<span class="req_field">*</span></label></dt>
            <dd><input type="text" name="title" value="" />
            </dd>
            <dt><label for="name">Topic<span class="req_field">*</span></label></dt>
            <dd><input type="text" name="topic" value="" />
            </dd>
            <dt><label for="publish_date">Publish Date<span style="color:#F00" class="req_field">*</span></label></dt>
            <dd>
                <input type="text" name="publish_date" class="input-text datepicker required" size="50" />
            </dd>
            <dt><label for="name">Media Name<span class="req_field">*</span></label></dt>
            <dd><input type="text" name="media_name" value="" />
            </dd>
            <dt><label for="name">Media Type<span class="req_field">*</span></label></dt>
            <dd><input type="text" name="media_type" value="" />
            </dd>
            <dt><label for="name">Journalist Name<span class="req_field">*</span></label></dt>
            <dd><input type="text" name="journalist_name" value="" />
            </dd>

            <dt><label for="description">Description</label></dt>
            <dd><textarea name="description" class="medium"></textarea><small> Brief Description</small>
            </dd>
            <dt><label for="interview">Did the Interview Happened</label></dt>
            <dd><input type="checkbox" name="interview" value="checked" /></dd>
            <dt><label for="document">Article</label></dt>
            <div class="uploader" id="uniform-undefined">
                <input type="file" name="document" size=19 style="opacity : 0;" id="document" value="<?=$document;?>" />
                <span class="filename">No file selected</span>
                <span class="action">choose file</span>
            </div>
        </dl>

        <div style="margin-left:40%;" class="buttons">
            <input type="submit" class="button" name="txtSubmit" value="Submit" />
            <input type="reset" class="button white" name="txtReset" value="Reset" />
        </div>
    </fieldset>
</form>

<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
    $("#vendorForm").validate();
});
</script>