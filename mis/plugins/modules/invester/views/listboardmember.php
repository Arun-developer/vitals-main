<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

?>
<h1><?=$cpagetitle ?></h1>

<br />
dfsfssdfddf
<ul class="option-tab" style="margin-top:0px;">
<?php echo "fdff".$isincubAuth; ?>
 <?php  if($isincubAuth)
    { ?>
        <li>
		   <a href="<?=site_url('boardmember/form/'.$innovation);?>" class="button fancybox">Send Request</a></li>
	    </li>
 <?php	}	?>
 	</ul>  
<br /><br/>
<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>

    <th><a href="<?=$nullLink?>" field="label">Request Number</a></th>
	<th><a href="<?=$nullLink?>" field="label">No. of Board Member</a></th>
    <th><a href="<?=$nullLink?>" field="input_type">Qualification</a></th>
    <th><a href="<?=$nullLink?>" field="value">status</a></th>
	<th><a href="<?=$nullLink?>" field="status">Detail</a></th>
    <th><a href="<?=$nullLink?>" field="status">Action</a></th>

	</tr>
    </thead>
	<tbody>
	<?php
	if(count($boardList))
	{    
		$r=1;
		foreach($boardList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row["request_number"];?></td>
			<td align="left" valign="middle"><?=$row["no_boardmemeber"];?></td>
            <td align="left" valign="middle"><?=$row["qualification"];?></td>
			
           
			<td align="left" valign="middle" width="60">
			<? if($row["status"]=='1')
			{
				 echo anchor('master/screening_master/changestatus/'.$row["id"].'/0/sub',"status"); 		
			}else{ 
				echo anchor('master/screening_master/changestatus/'.$row["id"].'/1/sub',"status");
			}
			?></td>
			<td nowrap="nowrap" width="70">
		           <a href="<?=site_url('boardmember/memberDetail/'.$innovation.'/'.$row["id"]);?>"> Details</a>	
			</td>
            
			<td nowrap="nowrap" width="70">
		             <a class="fancybox" href="<?=site_url('boardmember/board_member/form/'.$innovation.'/'.$row['id'])?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>&nbsp;
                     <a href="javascript:void(0);" url="<?=site_url('seedfunding/milestone/delete/'.$row['id'])?>"
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
	<?
	} ?>
	</tbody>
	</table>
	<!-- Paging style -->
	</div>   
