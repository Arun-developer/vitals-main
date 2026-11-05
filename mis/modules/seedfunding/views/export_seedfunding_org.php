<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <title>Seed Funding </title>
</head>

<body>

    <table class="gtable" style="width:967px;">
        <thead>
            <tr class="tablehead">
                <th width="10" style="background:#efefef;color:#333;">Id</th>
                <th width="80" style="background:#efefef;color:#333;">Goal</th>
                <th width="105" style="background:#efefef;color:#333;">Milestone</th>
                <th width="45" style="background:#efefef;color:#333;">Activity</th>
                <th width="105" style="background:#efefef;color:#333;">Peroid</th>
                <?php
			$i = 0;
            foreach($installmentList as $ins):
             ?>
                <th width="105" style="background:#efefef;color:#333;"><?php echo $ins['from']?> -
                    <?php echo $ins['to']?>
                    ( Installment <?php echo ++$i;?>)</th>
                <?php 
            endforeach;
            ?>
            </tr>
        </thead>
        <tbody id="activitiesTable">
            <?php 
		 ini_set('memory_limit', '-1');
	if(count($activitiesList))
	{    
	$rowtype = $j & 1 ? '' : 'style="background-color:#C3FDB8;"';
			foreach($activitiesList as $row):
			?>
            <tr <?php echo $rowtype;?>>
                <td align="left" valign="middle" width="10"><?=$row['id']?></td>
                <td align="left" valign="middle" width="80"><?=$row['goal']?></td>
                <td align="left" valign="middle" width="105"> <?=$row['milestone']?></td>
                <td align="left" valign="middle" width="45"> <?=$row['activity']?></td>
                <td align="left" valign="middle" width="105"> <?=$row['from']?> - <?=$row['to']?></td>
                <?php
					$installment = $this->Msfactivities->getAmount($row['id']);
					foreach($installmentList as $ins):
					 ?>
                <td align="left" valign="middle" width="105"><?=@$installment[$ins['id']]?> </td>
                <?php 
					endforeach;
					?>

            </tr>
            <?php 
			endforeach;
			$rowtype = "even";
			?>
            <tr class="<?php echo $rowtype;?>">
                <td align="left" valign="middle" style="background:#efefef;color:#333;">&nbsp;</td>
                <td align="left" valign="middle" width="90" style="background:#efefef;color:#333;">&nbsp;</td>
                <td align="left" valign="middle" style="background:#efefef;color:#333;">&nbsp;</td>
                <td align="left" valign="middle" style="background:#efefef;color:#333;">&nbsp;</td>
                <td align="left" valign="middle" style="background:#efefef;color:#333;">&nbsp; </td>
                <?php
					$installment = $this->Msfactivities->getAmount($row['id']);
					foreach($installmentList as $ins):
					 ?>
                <td align="left" valign="middle" style="background:#efefef;color:#333;"><strong>
                        <a href="<?=site_url('seedfunding/getinstallment/'.$innovation['id'].'/'.$ins['id'])?>"
                            class="button">
                            <?=$ins['amount']?></a></strong> </td>
                <?php 
					endforeach;
					?>
            </tr>
            <?php
	}
	else
	{ ?>
            <tr>
                <td colspan='7' align='center'>No Records found!</td>
            </tr>
            <?php
	} ?>
        </tbody>
    </table>
</body>

</html>