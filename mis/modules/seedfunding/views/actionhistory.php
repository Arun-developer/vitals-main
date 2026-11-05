<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>

<body>
    <table class="gtable sorttable">
        <thead>
            <tr>
                <th width="53">Id</th>
                <th width="235">Goal</th>
                <th width="201">Milestone</th>
                <th width="292">Activity</th>
                <th width="192">Period</th>

                <?php
			    $i = 0;
                $k=1;
            foreach($installmenthistory as $ins):
             ?>
                <th width="292"><?=$ins['from']?> - <?=$ins['to']?>
                    <br />( Installment
                    <?php echo ++$i;?>)</th>
                <?php 
            endforeach;
            ?>
                <th width="192">Created Date</th>
                <th width="192">Modified Date</th>
            </tr>
        </thead>
        <tbody id="activitiesTable">
            <?php
		  $i=0;
		  $j=1;
	  	if(count($activitieshistory))
	    {    
		 $key1 = 0;  
		 $na="";
		 foreach($activitieshistory as $row)
		  {
		   $na_new = $activitieshistory[$i]['from'];
		   $na_new .= $activitieshistory[$i]['to'];
	       if($na_new != $na)
	       {
		    $na = $na_new;
		    $key1 = 0;?>
            <tr>
                <td colspan="5">
                    <h2><?php echo 'version'.$k++;?></h2>&nbsp;Request Sent:<?=@$datehistory[0]['sent_date']?>&nbsp;
                    Approved Date:<?=@$datehistory[0]['approved_date']?>
                </td>
            </tr>
            <?php  } ?>
            <tr>
                <td align="left" valign="middle"><?=$row['id']?></td>
                <td align="left" valign="middle" width="235"><?=$row['goal']?></td>
                <td align="left" valign="middle"> <?=$row['milestone']?></td>
                <td align="left" valign="middle"> <?=$row['activity']?></td>
                <td align="left" valign="middle"><?=$row['from']?> - <?=$row['to']; ?></td>
                <?php
					$amount = array();
		    		$installment = $this->Msfactivities->getvillgrofund($row['mid']);
          	     	foreach($installmenthistory as $ins):
				    $amounts = isset($installment[$ins['id']]) ? $installment[$ins['id']] : 0;
		    ?>
                <td align="left" valign="middle">
                    <?=formatnumber($amounts)?> </td>
                <?php 
                     if(!isset($amount[$ins['id']]))
                     {
                             $amount[$ins['id']] = $amounts;

                     }
                     else
                     {
                              $amount[$ins['id']] += $amounts;
                     }
                     endforeach;
                    ?>
                <td align="left" valign="middle"><?=$row['created_date']?></td>
                <td align="left" valign="middle"><?=$row['modified_date']?></td>

                <?php $i++;$j++; 
                  }
			?>


            </tr>
            <tr>

                <td colspan="5" align="left" valign="middle">&nbsp;</td>
                <?php foreach($amount as $key => $value){?>
                <td align="left" valign="middle"><?php echo formatnumber($value);?></td>
                <?php } ?>

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