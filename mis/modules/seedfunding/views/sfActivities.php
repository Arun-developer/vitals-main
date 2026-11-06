
<script type="text/javascript">
$(document).ready( function() {
	//confirmantion Box
	$(".confirmDelete").click( function() {
	var linkUrl = $(this).attr('url');
	jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
	if(r)
	{
	  $(window.location).attr('href',linkUrl);
	}
	});
	});
});
</script> 
<?php

	$nullLink = 'javascript:void(0);';

	$form_name = 'activities_list';

	$isAuth = true;

?>

<h1><?=$cpagetitle.'-'.$innovation['name_of_enterprise']?></h1>

<?php

$pre_ic_status = array('Pending','Approved','Rejected');

?>

<?php
if($this->session->userdata('user_type') == 'admin'){

if(php72_cmp($innovation['edit_request']) == 1 && (php72_cmp($innovation['editrequest_status']) == 0)) { 

?>

<div align="right">

<a href="<?=site_url('seedfunding/liststatus/approve/'.$innovation['id']);?>" class="button">Approve</a>

<a href="<?=site_url('seedfunding/liststatus/reject/'.$innovation['id']);?>" class="button">Reject</a>

</div>  

<?php

}
}
?>

<h2><?=$cpagetitle?>
 <?php if(php72_cmp($innovation['incubation_plan']) == 1)
 { 
 	echo "&nbsp;&nbsp;(&nbsp;Status : ".$pre_ic_status[$innovation['pre_ic_status']]."&nbsp;)"; 
 }?>
</h2> 

<ul class="option-tab" style="margin-top:0px;">
<?php if($pre_ic_status[$innovation['pre_ic_status']] == 'Pending'){
?>
<li><a href="<?=site_url('seedfunding/activities/view_list/'.$innovation['id']);?>" class="button">Incubation Plan</a></li>
<?php } 
else{
?>
<li><a href="<?=site_url('seedfunding/mail_form/'.$innovation['id']);?>" class="button ">Request for Change Plan</a></li><?php } ?>
<li><a href="<?=site_url('seedfunding/exportPdf/'.$innovation['id']);?>" class="button">Export Incubation Plan</a></li>
<li><a href="<?=site_url('seedfunding/monthly_progress/'.$innovation['id']);?>" class="button">Add Monthly Target/Achieved</a></li>
<li><a href="<?=site_url('seedfunding/actionhistory/'.$innovation['id']);?>" class="button fancybox">Action History</a></li>
    <?php 
	if(php72_cmp($innovation['incubation_plan']) == 1 && php72_cmp($innovation['pre_ic_status']) == 0 && $isAuth){ //
	?>
    <li><a url="<?=site_url('screening/pre_ic_action/1/'.$innovation['id']);?>" class="button confirmDelete">Approve</a></li>
    <li><a url="<?=site_url('screening/pre_ic_action/2/'.$innovation['id']);?>" class="button confirmDelete">Reject</a></li>
    <?php
	}?>
 </ul> 
 <br />
<br />
	<table class="gtable sorttable">
<thead>
		<tr>
            <th width="235">Goal</th>
            <th width="201">Milestone</th>
			<th width="201">Budget</th>
			<th width="201">LineItem</th>
            <th width="192">Period</th>
            <?php
			$i = 0;

            foreach($installmentList as $ins):

             ?>

             <th width="292"><?=$ins['from']?> - <?=$ins['to']?> 

             <br/>( Installment <?php echo ++$i;?>) &nbsp; in (<img src="<?=base_url();?>source/template/images/show_image_helcat.png" width="18px" height="12px"/>)</th>

			<?php 

            endforeach;

            ?>

		</tr>

	</thead>

	<tbody id="activitiesTable">

	<?php 

		  $i=0;

		  $j=1;

	  	if(php72_count($activitiesList))

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

       <?php } ?>

                    <tr>

                    <td align="left" valign="middle" width="235"><?=$activitiesList[$i]['goal']?></td>

                    <td align="left" valign="middle"><?=$activitiesList[$i]['milestone']?></td>

					<td align="left" valign="middle"><?=$activitiesList[$i]['budget']?></td>

                    <td align="left" valign="middle"><?=$activitiesList[$i]['lineitem']?></td>

					<td align="left" valign="middle"><?=$activitiesList[$i]['from']?>-<?=$activitiesList[$i]['to']?></td>

                    <?php

					$installment = $this->Msfactivities->getbudgetfund($activitiesList[$i]['id']);

					foreach($installmentList as $ins):

					$amounts = isset($installment[$ins['id']]) ? $installment[$ins['id']] : '-';

					 ?>

					  <td align="left" valign="middle"><?=formatnumber($amounts)?> </td>	

					  

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

                    <td  colspan="5" align="left" valign="middle" >&nbsp;</td>

                    <?php  

					 foreach($vfunded as $key => $value){

				if(php72_cmp($innovation['pre_ic_status']) == 1)	{?>

                    <td align="left" valign="middle"><strong>

                    <a href="<?=site_url('seedfunding/getinstallment/'.$innovation['id'].'/'.$key)?>" class="button" ><?php echo formatnumber($value); ?></a></strong></td><?php }

					 else { 

                            ?><td align="left" valign="middle"><?php echo formatnumber($value);?></td><?php } ?>								          

                    <?php } ?></tr>

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

	<!-- Paging style -->



