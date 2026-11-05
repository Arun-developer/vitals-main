<h1><?=$cpagetitle?> - <?=ucfirst($currentTab)?> Innovations
    <?php if($currentTab == 'similar'){ echo '( '.$name_of_enterprise.' )'; }?></h1>
<?php
$nullLink = "javascript:void(0);";
$form_name = "innovation_pool";

$isAssign = false;
$isExport = false;
$isAssignCycle = false;
$isDetails = true;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
{
	$isAssign = true;
	$isExport = true;
	$isAssignCycle = true;
}
?>

<form id="<?=$form_name?>" action="<?=site_url('scouting/innovation_pool/'.$currentTab)?>" method="post"
    name="<?=$form_name?>" class="searchForm">
    <input type="hidden" name="ordertype" value="<?=$ordertype?>" />
    <input type="hidden" name="orderby" value="<?=$orderby?>" />
    <input type="hidden" name="export" value="" />
    <div class="searchBox" style=" <?=(isset($_POST['txtSubmit']))?'':'display:none;'?>">
        <dl class="inline">
            <dt><label for="source_type">Source Type</label></dt>
            <dd>
                <?php $source_type = isset($_REQUEST['source_type'])?$_REQUEST['source_type']:'';?>
                <select name="source_type">
                    <option value="">-Select-</option>
                    <option value="0" <?=("0" ==$source_type)?'selected':'';?>>Direct Application</option>
                    <?php
                foreach($sourceTypeList as $st):
                    ?><option value="<?=$st['id']?>" <?=($st['id']==$source_type)?'selected':'';?>>
                        <?=$st['master_name']?></option>
                    <?php 
                endforeach;
                ?>
                </select>

            </dd>
            <dt><label for="source_type">Identified By</label></dt>
            <dd>
                <select name="employee" class="required" id="employee">
                    <option value="">-Select-</option>

                    <?php $employee = (isset($_REQUEST['employee']))?$_REQUEST['employee']:'';?>
                    <?php
			foreach($emplist as $row):
				?>
                    <option value="<?=$row['emp_number']?>" <?=($row['emp_number']==$employee)?'selected':'';?>>
                        <?=$row['emp_name']?></option>
                    <?php 
			endforeach;
			?>

                </select>
                <font color="red"></font>
            </dd>
            <dt><label for="created_date">Date Applied</label></dt>
            <dd>
                <?php 
				$created_date = isset($_REQUEST['created_date'])?$_REQUEST['created_date']:'';
				$created_date_to = isset($_REQUEST['created_date_to'])?$_REQUEST['created_date_to']:'';
				?>
                <input type="text" name="created_date" value="<?=$created_date?>" class="input-text"
                    id="fromdate" />&nbsp;-&nbsp;
                <input type="text" name="created_date_to" value="<?=$created_date_to?>" class="input-text"
                    id="todate" />
            </dd>
            <dt><label for="stage">Stage</label></dt>
            <dd>
                <?php 
                $stage_post = isset($_REQUEST['stage'])?$_REQUEST['stage']:"";
                ?>
                <select name="stage">
                    <option value="">-Select-</option>
                    <?php
                foreach($stage as $key => $value):
                    ?><option value="<?=$key?>" <?=((string)$key==$stage_post)?'selected':'';?>><?=$value?></option>
                    <?php 
                endforeach;
                ?>
                </select>
            </dd>
            <dt><label for="status">Status</label></dt>
            <dd>
                <?php 
                $status_post = isset($_REQUEST['status'])?$_REQUEST['status']:"";
                ?>
                <select name="status">
                    <option value="">-Select-</option>
                    <?php
                foreach($status as $key => $value):
                    ?><option value="<?=$key?>" <?=((string)$key==$status_post)?'selected':'';?>><?=$value?></option>
                    <?php 
                endforeach;
                ?>
                </select>
            </dd>
            <dt><label for="source_type">Incubation Cycle</label></dt>
            <dd>
                <?php $incubation_cycle = isset($_REQUEST["incubation_cycle"])?$_REQUEST["incubation_cycle"]:'';   ?>
                <select name="incubation_cycle">
                    <option value="">-Select-</option>
                    <?php
				foreach($cycleList as $row):
					?>
                    <option value="<?=$row['id']?>" <?=($incubation_cycle == $row['id'])?'selected':'';?>>
                        <?=$row['master_name']?></option>
                    <?php 
				endforeach;
			  ?>
                </select>
            </dd>
            <dt><label for="name_of_enterprise">Name of the Enterprise</label></dt>
            <dd>
                <?php $name_of_enterprise = isset($_REQUEST["name_of_enterprise"])?$_REQUEST["name_of_enterprise"]:'';   ?>
                <input type="text" value="<?=$name_of_enterprise?>" name="name_of_enterprise" class="input-text" />
            </dd>
            <dt><label for="summary_of_business">Summary of the Business</label></dt>
            <dd>
                <?php $summary_of_business = isset($_REQUEST["summary_of_business"])?$_REQUEST["summary_of_business"]:'';   ?>
                <input type="text" value="<?=$summary_of_business;?>" name="summary_of_business" class="input-text" />
            </dd>
            <dt><label for="website">Website</label></dt>
            <dd>
                <?php $website = isset($_REQUEST["website"])?$_REQUEST["website"]:'';   ?>
                <input type="text" value="<?=$website;?>" name="website" class="input-text" />
            </dd>
            <dt><label for="name_of_entrepreuner">Name of the Entrepreuner</label></dt>
            <dd>
                <?php $name_of_entrepreneur = isset($_REQUEST["name_of_entrepreneur"])?$_REQUEST["name_of_entrepreneur"]:'';   ?>
                <input type="text" value="<?=$name_of_entrepreneur;?>" name="name_of_entrepreneur" class="input-text" />
            </dd>
        </dl>
        <div class="buttons">
            <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
            <button type="reset" class="button white">Reset</button>
        </div>
    </div>
</form>
<ul class="option-tab">
    <?php if($this->session->userdata('user_name') == 'Altacit')
{
?>

    <li><a href="<?=site_url('scouting/new_innovation');?>" class="button">Create Innovation</a></li>
    &nbsp;&nbsp;
    <li><a href="<?=site_url('login/logout');?>" class="button">Logout</a></li>
    <li> <a class="button fancybox" height="200" href="<?=site_url('login/changepassword');?>"> Change Password</a></li>
    <?php } else {?>
    <li><a href="<?=$nullLink?>" class="button toggleSearch">Show Search</a></li>
    <?php if($isExport){ ?>
    <li><?php $this->Mexport->exportOption('innovation',$form_name); ?></li>
    <?php } }?>
</ul>
<br />
<br />
<table id="table1" class="gtable sortable">
    <thead>
        <tr>
            <?php if($currentTab == 'lead'){ ?>
            <th><input type="checkbox" class="checkall" /></th>
            <?php } ?>
            <th>S N0</a></th>
            <th><a href="<?=$nullLink?>" field="innovation_id" class="sortlink">Innovator ID</a></th>
            <?php if($currentTab == 'lead'){ ?>
            <th><a href="<?=$nullLink?>" field="score" class="sortlink">Score</a></th>
            <?php }else{ ?>
            <?php }?>

            <th><a href="<?=$nullLink?>" field="name_of_enterprise" class="sortlink">Name of the Enterprise</a></th>
            <th><a href="<?=$nullLink?>" field="created_date" class="sortlink">Date Applied</a></th>
            <th><a href="<?=$nullLink?>">Assigned to</a></th>
            <th><a href="<?=$nullLink?>" field="stage" class="sortlink">Stage</a></th>
            <?php if($this->uri->segment('3') != 'incubation')
			{?>
            <th><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
            <?php } ?>
            <th><a href="<?=$nullLink?>">View</a></th>
            <?php if($this->session->userdata('user_type') == 'admin'){?>
            <th><a href="<?=$nullLink?>">Delete</a></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
	if(count($innovationList)){
		$i='odd';
                $j=0;
		foreach($innovationList as $row): 
		  
			$loop = true;
			if($currentTab == 'entry_pending' && $row['grading_status'] == '0')
				continue;
			$i = ($i=='odd')?'even':'odd';
			$ischeck=false;
			if($row['status'] != '3' ){
			$fstagedate = @$stagedate[@$stage[$row['stage']]];
				if($fstagedate !='')
				{
					$daylimit=$timelimit[0][$row['stage']];
					$fdatearr= $row[$fstagedate];
					$fdatearr=explode(' ',$fdatearr);
					$fdate=$fdatearr[0];
					$cdate= date("Y-m-d");
					$dateDiff =  strtotime($cdate) -  strtotime($fdate);
					$fullDays = floor($dateDiff/(60*60*24));
					if($fullDays >= $daylimit)
						$ischeck=true;
				}
			}
			?>
        <tr class="<?=$i?>">
            <td><?php echo ++$j;?></td>
            <?php if($currentTab == 'lead'){ ?>
            <td><input type="checkbox" name="innovation_id[]" value="<?=$row['id']?>" /></td>
            <?php } ?>
            <td><?=$row['innovation_id']?></td>
            <?php if($currentTab == 'lead'){ ?>
            <td><?=$row['score'];?></td>
            <?php }else{ ?>
            <?php }?>

            <td><?=$row['name_of_enterprise']?></td>
            <td><?=mysql2date($row['created_date'])?></td>
            <td width="150">
                <?php
					if($isAssign && ($row['status'] == '1' || $row['status'] == '0'))
					{
						if($row['associate_emp_name'] != '')
						{
							$incharge = explode(',',$row['associate_emp_name']);
							foreach($incharge as $k => $v):
							?>
                <a href="<?=site_url('scouting/assign_incharge/'.$row['id'])?>" class="fancybox"><?=$v;?></a> ,
                <?php
							endforeach;
						}
						else
							anchor('scouting/assign_incharge/'.$row['id'],'class="fancybox"','Assign');
					}
					else
					{
						echo $row['associate_emp_name'];
					}
					?>
            </td>
            <td>
                <?php
					if($ischeck){ echo '<blink><strong>';}
					if($row['stage'] =='2' && $row['status'] == '1' && $isAssignCycle){
					?>
                <a href="<?=site_url('scouting/cycle/'.$row['id'])?>"
                    class="fancybox button"><?=$stage[$row['stage']]?></a>
                <?php
					}
					else
					{
					   echo $stage[$row['stage']];
					}
					if($ischeck){ echo '</strong></blink>';}
					?>
            </td>
            <?php if($this->uri->segment('3') != 'incubation')
					{?>
            <td><?=$status[$row['status']]?></td>
            <?php } ?>

            <td>
                <?php 
					
					
					
					if($isDetails)
					{ 
					   
					  if($this->session->userdata('user_name') == 'Altacit')
					  {
					     $detailLink = 'scouting/innovation_details/'.$row['id'];
					  }
					  else
					  {
						 $detailLink = 'scouting/innovation_details/'.$row['id'];
						 if($row['stage'] == '0')
							$detailLink = 'scouting/innovation_details/'.$row['id'];
						 elseif($row['stage'] == '1')
							$detailLink = 'assessment/view_list/'.$row['id'];
						elseif($row['stage'] == '2')
							$detailLink = 'assessment/view_list/'.$row['id'];
						elseif($row['stage'] == '3')
							$detailLink = 'presentation/view/'.$row['id'];
						elseif($row['stage'] == '4')
							$detailLink = 'screening/form/'.$row['id'];
						elseif($row['stage'] == '5')	 
						  	$detailLink = 'seedfunding/view/'.$row['id'];
						elseif($row['stage'] == '6')
							$detailLink = 'repayment/repayment/index/'.$row['id'];		
						}
					 ?>

                <a href="<?=site_url($detailLink)?>"
                    class="button"><?=($row['grading_status'] == '1' && $status[$row['status']] != 'Closed')?'Decision Pending':'Details';?></a>
                <?php } ?>
            </td>
            <?php if($this->session->userdata('user_type') == 'admin'){?>
            <td>
                <a href="<?=site_url('scouting/delete/'.$row['id'])?>"><img
                        src="<?php echo base_url();?>source/template/images/icons/cross.png" /></a>
            </td>
            <?php } ?>
        </tr>
        <?php 
	
		endforeach;
	}
	else
	{
	?>
        <tr class="odd">
            <td colspan="10" align="center">No Records</td>
        </tr>
        <?php } ?>


    </tbody>
</table>
<?php 
if($currentTab == 'lead' && count($innovationList) && $isAssign){ 
?>
<a href="<?=site_url('scouting/multi_cycle/')?>" class="fancyboxt button">Assign Cycle</a>
<?php
}
elseif($currentTab == 'entry_pending'){
    
}
else
{
echo  $this->pagination->create_links($form_name);
}
?>