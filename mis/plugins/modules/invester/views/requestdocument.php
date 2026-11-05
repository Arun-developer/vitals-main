<?php 
$nullLink = "javascript:void(0);";
?>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=site_url('invester/requestDoc/'.$innovationid.'/'.$id);?>" method="post" id="addMemberForm" >

<input type="hidden" value="<?=$innovationid; ?>" name="innovationid" />


	<h1><?=$cpagetitle?></h1>
	<table width="100%" class="items">
			<thead>
			<tr>
				<th><a href="<?=$nullLink?>" field="label">S.NO</a></th>
				<th><a href="<?=$nullLink?>" field="label">Document Description</a></th>
				<th><a href="<?=$nullLink?>" field="label">Select</a></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if(count($document))
			{    
				$r=1;
				foreach($document as $row)
				{
					$row_type = ($r%2 == 0) ? ('even'):('odd');
					
					?>
				    <tr class="<?=$row_type?>">
					<td align="left" valign="middle"><?=$r ;?></td>
					<td align="left" valign="middle"><?=$row["master_name"];?></td>
					<td align="left" valign="middle"><input type="checkbox" name="document[]" id="document" value="<?php echo $row['id']; ?>"
					 <?php if (in_array($row['id'],explode(',',$checkbox))) { echo 'checked="checked"'; }?>  /></td>
					</tr>
					<?php 
					$r++;
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
	<br/><br/>
	 <div style="float:right;">
		 <input type="submit" name="txtSubmit" value="submit" class="button" />
	 </div>	
</form>

<!-- end id-form  -->