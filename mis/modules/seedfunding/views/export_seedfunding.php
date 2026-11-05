<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head> <title><h2 style="color:#ff3366;"> </h2></title>

</head>

<body>

<table style="width:967px;">

		<tr>

		<td> <img src="<?php echo base_url();?>source/template/images/logo.gif"  alt="Profile Photo" height="110" width="259"/></td>

</tr>

</table>	

<h2 align="center" style="color:#902452">Seed Funding-Incubation Plan</h2>


<table class="gtable"  style="width:987px;">

	<thead>

		<tr>

            <th width="auto" style="background:#99cc99;color:#333;">Goal</th>

            <th width="auto" style="background:#99cc99;color:#333;">Milestone</th>

			<th width="auto" style="background:#99cc99;color:#333;">Activity</th>

			<?php

			$i = 0;

            foreach($installmentList as $ins):

             ?>

             <th width="auto" style="background:#99cc99;color:#333;"><?=$ins['from']?> - <?=$ins['to']?> 

             <br/>( Installment <? echo ++$i;?>) &nbsp; in (<img src="<?=base_url();?>source/template/images/show_image_helcat.png" width="18px" height="12px"/>)</th>
			
			<?php 

            endforeach;

            ?>
           
		</tr>

	</thead>

	<tbody id="activitiesTable">
	
	 <?php 

		  $i=0;

		  $j=1;

	  	if(count($activitiesLists))

		{    

		 $key1 = 0;  

		 $na="";

		 foreach($activitiesLists as $key=>$value)

		  {

		   $na_new = $activitiesLists[$i]['from'];

		   $na_new .= $activitiesLists[$i]['to'];

	       if($na_new != $na)

	       {

		    $na = $na_new;

		    $key1 = 0;

			?>

			 <tr><td colspan="3"><h2><?php echo $activitiesLists[$i]['from'];?>-<?php echo $activitiesLists[$i]['to']?></h2></td></tr>

       <?php } $rowtype = $j & 1 ? '' : 'style="background-color:#C3FDB8;"';       
?>

                    <tr <?php echo $rowtype;?>>

                    <input type="hidden" name="id" value="<?=$activitiesLists[$i]['id']?>"/>

                    <td align="left" valign="middle" width="235"><?=$activitiesLists[$i]['goal']?></td>

                    <td align="left" valign="middle"><?=$activitiesLists[$i]['milestone']?></td>

                    <td align="left" valign="middle"><?=$activitiesLists[$i]['activity']?></td>
					
                   <?php

					$installment = $this->Msfactivities->getvillgrofund($activitiesLists[$i]['mid']);

					foreach($installmentList as $ins):

					$amounts = isset($installment[$ins['id']]) ? $installment[$ins['id']] : '-';

					 ?>

					  <td align="left" valign="middle"><?=$amounts?> </td>	

					
                     <?php 

					  if(!isset($vfunded[$ins['id']]))
					  {
						 $vfunded[$ins['id']] = $amounts;
					  }

					 else
					 {
						 $vfunded[$ins['id']] += $amounts;
					 }

					endforeach;

					?>

                    </tr>

            <?php $i++;$j++; 

			}

			?>

             <tr>

						<td  colspan="2" align="left" valign="middle">&nbsp;</td> 
						<td><h4>Total in (Rs.)</h4></td>
                    <?php

					if(isset($vfunded))

					{

					 foreach($vfunded as $key => $value)

					{?>

					  <td align="left" valign="middle"><strong><?=$value?></strong> </td>								          

                    <?php } }?>
                   
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
	
	<br /><br /><br />

<table  class="gtable" style="width:987px;">

	<thead>

		<tr>

           <th width="auto" style="background:#99cc99;color:#333;">Budget</th>

			<th width="auto" style="background:#99cc99;color:#333;">Line Item</th>

            <?php

			$i = 0;

            foreach($installmentList as $ins):

             ?>

             <th width="auto" style="background:#99cc99;color:#333;"><?php echo $ins['from']?> - <?php echo $ins['to']?> 

             ( Installment <?php echo  ++$i;?>)</th>

			<?php 

            endforeach;

            ?>

		</tr>

	</thead>

	<tbody >

	<?php 

		  $i=0;

		  $j=1;

	  	if(count($activitiesList))

		{    

		 $key1 = 0;  

		 $na="";
		 foreach($activitiesList as $key=>$value)

		  {

		   $na_new = $activitiesList[$i]['from'];

		   $na_new .= $activitiesList[$i]['to'];

	       if($na_new != $na)

	       {

		    $na = $na_new;

		    $key1 = 0;

			?>

			 <tr><td colspan="3"><h2><?php echo $activitiesList[$i]['from'];?>-<?php echo $activitiesList[$i]['to']?></h2></td></tr>

       <?php } 

                     $rowtype = $j & 1 ? '' : 'style="background-color:#C3FDB8;"';       

       ?>

                    <tr <?php echo $rowtype;?>>

								<td align="left" valign="middle"><?=$activitiesList[$i]['budget']?></td>

                                <td align="left" valign="middle"><?=$activitiesList[$i]['lineitem']?></td>

                                <?php 

                                $installment = $this->Msfactivities->getbudgetfund($activitiesList[$i]['id']);

                                foreach($installmentList as $ins):

                                $amount = isset($installment[$ins['id']]) ? $installment[$ins['id']] : '-';

                                ?>

                                <td align="left" valign="middle"><?=$amount?> </td>	

                                <?php 

                                if(!isset($vfundeds[$ins['id']]))
                                {

                                 $vfundeds[$ins['id']] = $amount;

                                }

                                else
                                {

                                  $vfundeds[$ins['id']] += $amount;

                                }

                                endforeach;

                                ?>

                                </tr>

            <?php $i++;$j++; 

			}

			?>

             <tr>

                    <td  colspan="1" align="left" valign="middle" >&nbsp;</td>
					<td><h4>Total in (Rs.)</h4></td>
                    <?php  

                                    foreach($vfundeds as $key => $value){

                                    if($innovation['pre_ic_status'] == 1)	{?>

                                    <td align="left" valign="middle"><strong>

                                    <a href="<?=site_url('seedfunding/getinstallment/'.$innovation['id'].'/'.$key)?>" class="button" ><?php echo $value; ?></a></strong></td><?php }

                                    else { 

                                    ?><td align="left" valign="middle"><?php echo $value;?></td><?php } ?>								          

                    <?php } ?>

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
		