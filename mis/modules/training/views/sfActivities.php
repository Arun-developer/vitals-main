<?php 
$this->load->library('jquery');
$this->jquery->fancybox();
?>
<h1><?=$cpagetitle.'-'.$innovation['name_of_enterprise']?></h1>
<?php if(!$isincubAuth){?>
<ul class="option-tab" style="margin-top:0px;">
    <li><a href="<?=site_url('training/view_list/'.$innovation['id']);?>" class="button">Back</a></li>
    <li><a href="<?=site_url('training/add_fund/'.$innovation['id']);?>" class="button">Add Budget</a></li>
</ul> <?php }?>

<br />
<br />
<table class="gtable sorttable">
    <thead>
        <tr>
        <tr>
            <th width="235">Line Item</th>
            <th width="235">Amount</th>
            <th width="235">Period</th>
        </tr>
    </thead>
    <tbody id="activitiesTable">
        <?php 
	if(count($budgetList))
	{    
			foreach($budgetList as $row):
			?>
        <tr>
            <td align="left" valign="middle" width="235"><?=$row['line_item']?></td>
            <?php if(!$isincubAuth)
					{
						?>
            <td align="left" valign="middle" width="235"><a
                    href="<?=site_url('training/getinstallment/'.$innovation['id'].'/'.$row['id'])?>"
                    class="button"><?=$row['amount']?></a></strong></td>
            <?php } else
					{
						?>
            <td align="left" valign="middle"><?=$row['amount'];?></td><?php } ?>
            <td align="left" valign="middle"> <?=$row['start_date']?>- <?=$row['end_date']?></td>
        </tr>
        <?php 
			endforeach;
			?>
        <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp; </td>
            <td align="left" valign="middle"><strong>
            </td>
        </tr>
        <?php
	}
	else
	{ ?>
        <tr>
            <td colspan='7' align='center'>No Records found!</td>
        </tr>
        <?
	} ?>
    </tbody>
</table>
<!-- Paging style -->