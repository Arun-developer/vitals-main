<?php
$nullLink = "javascript:void(0);";
?>

<h1><?=$cpagetitle?></h1>


<br />

<ul class="option-tab" style="margin-top:0px;">

      <li><?php echo anchor('master/media/form','Add Media','class="button"'); ?></li>
</ul>  
<br /><br/>
<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
    <th><a href="<?=$nullLink?>" field="label">Media Name</a></th>
	<th><a href="<?=$nullLink?>" field="label">Media Type</a></th>
    <th><a href="<?=$nullLink?>" field="required">Journalist Name</a></th>
    <th><a href="<?=$nullLink?>" field="value">Published Articles</a></th>
	<th><a href="<?=$nullLink?>" field="status">View</a></th>
    <th><a href="<?=$nullLink?>" field="status">Action</a></th>
	
	</tr>
    </thead>
	<tbody>
	<?php
	if(php72_count($mediaList))
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
			<td align="left" valign="middle"><?=$row["journalist_name"];?></td>
			<td align="left" valign="middle"><a class="fancybox" href="<?=site_url('master/media/article/'.$row["media_name"])?>" >Published_Article</a></td>
          
            <td nowrap="nowrap" >
		       <a class="fancybox" href="<?=site_url('master/media/viewprofile/'.$row["id"])?>" >View Profile</a>	
			</td>
			
			<td colspan='3' align="left" valign="middle" >
			
		       <a  href="<?=site_url('master/media/form/'.$row['id'])?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>&nbsp;
                     <a href="<?=site_url('master/media/delete/'.$row['id'])?>"
                    class="confirmDelete"  ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>	
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
	<?php
	} ?>
	</tbody>
	</table>
	<!-- Paging style -->
	</div>   
