<?php
$nullLink = 'javascript:void(0);';
$form_name = 'documents';

$listLink = 'master/documents/view_list/'.$activity_id;
$formLink =  'master/documents/form/'.$activity_id;
$statusLink = 'master/documents/changestatus/'.$activity_id;
$deleteLink = 'master/documents/delete/'.$activity_id;
?>
<h1><?=$cpagetitle?></h1>
<div class="searchBox" style=" <?=($_POST)?'':'display:none;'?>"  >
<form id="document_list" action="<?=site_url($listLink)?>" method="post" name="<?=$form_name?>">
<input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
<input type="hidden"  name="orderby" value="<?=$orderby?>"  />

<dl class="inline">
        <dt><label for="program_type">Tag Name</label></dt>
        <dd>
		<?php $tag = isset($_REQUEST["tag"])?$_REQUEST["tag"]:"";?>
		<input type="text" name="tag" value="<?=$tag?>" class="input-text"  />
        </dd>
        <dt><label for="program_type">Employee Name</label></dt>
        <dd>
		<?php $emp_name = isset($_REQUEST["emp_name"])?$_REQUEST["emp_name"]:"";?>
		<input type="text" name="emp_name" value="<?=$emp_name?>" class="input-text"  />
        </dd>
</dl>
<div class="buttons">
		<input type="submit" value="Search" name="txtSubmit" class="button" />
</div>


</form>
</div> 
<div style=" float:right; text-align:right;width:100%;">
<a href="<?=$nullLink?>" class="button toggleSearch" >Show Search</a>&nbsp;&nbsp;
<?php echo anchor($formLink,'Add Document','class="fancybox button"'); ?></div>
<br /><br />

<!--start table-content  -->
	<table class="gtable sortable">
	<thead>
		<tr>
	<th><a href="<?=$nullLink?>" field="tag" class="sortlink" >Tags</a></th>
        <th><a href="<?=$nullLink?>" field="tag" class="sortlink" >Uploaded By</a></th>
        <th><a href="<?=$nullLink?>" field="tag" class="sortlink" >Uploaded Date</a></th>
	<th><a href="<?=$nullLink?>" >Documents</a></th>
	<th class="head">Action</th>
	</tr>
    </thead>
	<tbody>
	<?php
	if(count($documentsList))
	{    
		$r=1;
		foreach($documentsList as $documents)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$documents["tag"]; ?></td>
                        <td align="left" valign="middle"><?=$documents["table"]; ?></td>
                        <td align="left" valign="middle"><?=$documents["created_date"]; ?></td>
			<td align="left" valign="middle"><?php echo $documents["document"]; ?>
            <a href="<?php echo base_url()."uploads/documents/".$documents['document'];?>"  target="_blank" >&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /></a>
            </td>
			<td nowrap="nowrap" width="70">
			
            <a href="<?=site_url($formLink.$documents["id"])?>"  class="fancybox" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>
            
			<a href="<?=$nullLink?>" url="<?=site_url($deleteLink.$documents["id"])?>" class=" confirmDelete" ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>
			
			</td>
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
	<!-- Paging style -->
	<?php echo  $this->pagination->create_links($form_name);?>
	</div>   


	