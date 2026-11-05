<?php
$nullLink = "javascript:void(0);";
?>

<h1><?=$cpagetitle?></h1>

<br />

<!--start table-content  -->


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
			<td align="left" valign="middle"><a href="<?=site_url('master/media/download/'.$row['article'])?>"><?=$row['article'];?></a></td>         
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
    
	</table><br /><br /><br /><br />
    <form name="file upload" action="media/fileupload" method="post" enctype="multipart/form-data">
    <dt><label for name="article upload">Upload a New Article</label></dt>
    <div class="uploader" id="uniform-undefined">
              <input type="file" name="document" size=19  style="opacity : 0;" id="document"/>
               <span class="filename">No file selected</span>
               <span class="action">choose file</span>
              </div>
    <dt><dd><input type="submit" name="txtsubmit" value="submit" />
 	<input type="reset" name="reset" value="reset" /></dd></dt>
    </form>
	<!-- Paging style -->
	</div>   
