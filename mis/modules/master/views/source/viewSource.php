 <?php
	if(php72_count($sourceDetails))
	{    
		foreach($sourceDetails as $row)
		{
			?>
<h2 >Source Details - <?=$row["source_name"]?></h2>
 <div id="user-grid" class="grid-view" >
	<table class="gtable sortable">
	<thead>
    <tr class="odd">
    <th colspan="2" align="center"><?=$row["source_name"]?></th>
    </tr>
    </thead>
	<tbody>
  
		<tr class="odd">
		<td align="left" valign="middle" style="width:40%">Source Type</td>   
		<td align="left" valign="middle"><?=@$row["master_name"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">source_name</td>   
		<td align="left" valign="middle"><?=$row["source_name"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">contact_person</td>   
		<td align="left" valign="middle"><?=$row["contact_person"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">designation</td>   
		<td align="left" valign="middle"><?=$row["designation"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">address</td>   
		<td align="left" valign="middle"><?=$row["address"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">phone</td>   
		<td align="left" valign="middle"><?=$row["phone"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">mobile</td>   
		<td align="left" valign="middle"><?=$row["mobile"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">E-mail</td>   
		<td align="left" valign="middle"><?=$row["email"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">Fax</td>   
		<td align="left" valign="middle"><?=$row["fax"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">frequency</td>   
		<td align="left" valign="middle"><?=$row["frequency"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">date</td>   
		<td align="left" valign="middle"><?=mysql2date($row["date"])?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">alert</td>   
		<td align="left" valign="middle"><?=$row["alert"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">link</td>   
		<td align="left" valign="middle"><?=$row["link"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">username</td>   
		<td align="left" valign="middle"><?=$row["username"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">password</td>   
		<td align="left" valign="middle"><?=$row["password"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">pagecontent</td>   
		<td align="left" valign="middle"><?=$row["pagecontent"]?></td>
		</tr>
		<tr class="odd">
		<td align="left" valign="middle">description</td>   
		<td align="left" valign="middle"><?=$row["description"]?></td>
		</tr>
		<tr class="even">
		<td align="left" valign="middle">document</td>   
		<td align="left" valign="middle"><?php if($row["document"]!=''){  echo $row["document"];?>
		<a href="<?=base_url()?>uploads/source/<?=$row["document"]?>" target="_blank" ><img src="<?=base_url()?>source/template/images/icons/download.gif" height="16" alt="Download" /></a>
		<?php }?></td>
		</tr>
		
	</tbody>
	</table>
	</div>  
    	<?php 
		}
	}
	?> 
