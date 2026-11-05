    <?php

	$nullLink = 'javascript:void(0);';

	$form_name = 'activities_list';

	$isAuth = true;

    ?>

    <?php if(isset($filename) == "") { ?>
    <br />
    <br />
    <ul class="option-tab" style="margin-top:0px;">

        <li><a href="<?=site_url('seedfunding/view/'.$innovation['id']);?>" class="button">Back</a></li>

    </ul>

    <?php } ?>



    <?php

$pre_ic_status = array('Pending','Approved','Rejected');

?>



    <h1><?=$cpagetitle?>

        <?php if(isset($filename) == "") { ?>

        <?php if($innovation['incubation_plan'] == 1){  echo "&nbsp;&nbsp;(&nbsp;Status : ".$pre_ic_status[$innovation['pre_ic_status']]."&nbsp;)"; } } ?>
    </h1>



    <form id="activities_list" action="<?=site_url('seedfunding/activities/view_list/'.$innovation['id'])?>"
        method="post" name="activities_list">

        <input type="hidden" name="ordertype" value="<?=$ordertype?>" />

        <input type="hidden" name="orderby" value="<?=$orderby?>" />

        <div class="searchBox" style="<?=($_POST)?'':'display:none;'?>">

            <dl class="inline">

                <dt><label for="">Milestone</label></dt>

                <dd>

                    <?php $milestone = isset($_REQUEST['milestone'])?$_REQUEST['milestone']:'';?>

                    <select name="milestone" class="required">

                        <option value="">-Select-</option>

                        <?php
            sort($milestoneList);
            foreach($milestoneList as $pt):
                ?>
                        <option value="<?=$pt['id']?>"><?=$pt['milestone']?></option><?php 

            endforeach;

            ?>

                    </select>

                </dd>

            </dl>

            <div class="buttons">

                <input type="submit" value="Search" name="txtSubmit" class="button" />

                <input type="reset" value="RESET" name="txtSubmit" class="button white" />

            </div>

        </div>

    </form>

    <ul class="option-tab" style="margin-top:0px;">

        <?php if(isset($filename) == "") { ?>

        <li><a href="<?=$nullLink?>" class="button toggleSearch">Show Search</a></li>

        <li><a href="<?=site_url('seedfunding/activities/view_list/'.$innovation['id']."/ex");?>"
                class="button">Export</a></li>



        <?php if($this->session->userdata('user_type') != 'incubatee') {
		if($innovation['pre_ic_status'] == 0) { ?>

        <li><a href="<?=site_url('seedfunding/installment/view_list/'.$innovation['id']);?>"
                class="fancybox button">Installments</a></li>

        <li><a href="<?=site_url('seedfunding/budget/view_list/'.$innovation['id']);?>"
                class="fancybox button">Budget</a></li>

        <li><a href="<?=site_url('seedfunding/goal/view_list/'.$innovation['id']);?>" class="fancybox button">Goals</a>
        </li>

        <li><a href="<?=site_url('seedfunding/milestone/view_list/'.$innovation['id']);?>"
                class="fancybox button">Milestone</a></li>

        <li><a href="<?=site_url('seedfunding/activity/view_list/'.$innovation['id']);?>"
                class="button fancybox">Activity</a></li>

        <li><?php echo anchor('seedfunding/activities/form/'.$innovation['id'],'Add Activities','class="button fancybox"'); ?>
        </li>

        <?php } ?>

        <li><a href="<?=site_url('screening/send_incubation_plan/'.$innovation['id']);?>" class="button">

                <?=($innovation['incubation_plan'] == 1)?'Resend Incubation Plan':'Send Incubation Plan';?></a></li>

        <?php 

	if($innovation['incubation_plan'] == 1 && $innovation['pre_ic_status'] == 0 && $isAuth && $this->session->userdata('user_type')!='abi'){ //

	?>

        <li><a url="<?=site_url('screening/pre_ic_action/1/'.$innovation['id']);?>"
                class="button confirmDelete">Approve</a></li>

        <li><a url="<?=site_url('screening/pre_ic_action/2/'.$innovation['id']);?>"
                class="button confirmDelete">Reject</a></li>

        <?php

	}?>

        <?php }  } ?>

    </ul>



    <br />

    <br />



    <table class="gtable sorttable">

        <thead>

            <tr>

                <th width="235">Goal</th>

                <th width="201">Milestone</th>

                <th width="292">Activity</th>

                <th width="292">Projected Amount (in Rs.)</th>

                <th width="292">Other Funding Sources (in Rs.)</th>

                <?php

			$i = 0;

            foreach($installmentList as $ins):

             ?>

                <th width="292"><?=$ins['from']?> - <?=$ins['to']?>

                    <br />( Installment
                    <? echo ++$i;?>) &nbsp; in (<img src="<?=base_url();?>source/template/images/show_image_helcat.png"
                        width="18px" height="12px" />)</th>

                <?php 

            endforeach;

            ?>

                <?php if($pre_ic_status[$innovation['pre_ic_status']] == "Approved"){ ?>

                <?php } else { ?>

                <th width="223">Option</th><?php } ?>

            </tr>

        </thead>

        <tbody id="activitiesTable">

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

            <tr>
                <td colspan="3">
                    <h2><?php echo $activitiesList[$i]['from'];?>-<?php echo $activitiesList[$i]['to']?></h2>
                </td>
            </tr>

            <?php } ?>

            <tr>

                <input type="hidden" name="id" value="<?=$activitiesList[$i]['id']?>" />

                <td align="left" valign="middle" width="235"><?=$activitiesList[$i]['goal']?></td>

                <td align="left" valign="middle"><?=$activitiesList[$i]['milestone']?></td>

                <td align="left" valign="middle"><?=$activitiesList[$i]['activity']?></td>

                <?php if($activitiesList[$i]['amount'] == 0) {?>
                <td align="left" valign="middle">-</td>
                <?php } else
					{?>
                <td align="left" valign="middle"><?=formatnumber($activitiesList[$i]['amount'])?></td>
                <?php } ?>
                <?php if($activitiesList[$i]['companyamt'] == 0)
					{?>
                <td align="left" valign="middle">-</td>
                <?php } else { ?>

                <td align="left" valign="middle"><?=formatnumber($activitiesList[$i]['companyamt'])?></td>
                <?php } ?>

                <?php

					$installment = $this->Msfactivities->getvillgrofund($activitiesList[$i]['mid']);

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

                <?php if($pre_ic_status[$innovation['pre_ic_status']] == "Approved"){ ?>

                <td></td>

                <?php }  else { ?>

                <td align="left" valign="middle">

                    <a href="<?=site_url('seedfunding/activities/form/'.$innovation['id'].'/'.$activitiesList[$i]['id'])?>"
                        class="fancybox">

                        <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png">

                    </a>

                    <a href="<?=site_url('seedfunding/activities/delete/'.$innovation['id'].'/'.$activitiesList[$i]['id'])?>"
                        class="confirmDelete"><img
                            src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>

                </td><?php } ?>

            </tr>

            <?php $i++;$j++; 

			}

			?>

            <tr>

                <td colspan="5" align="left" valign="middle">&nbsp;</td>

                <?php

					if(isset($vfunded))

					{

					 foreach($vfunded as $key => $value)

					{?>

                <td align="left" valign="middle"><strong><?=formatnumber($value)?></strong> </td>

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

    <!-- Paging style -->