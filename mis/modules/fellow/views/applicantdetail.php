<?php
function multidimensional_search($parents, $searched) { 
  if (empty($searched) || empty($parents)) { 
    return false; 
  } 
  
  foreach ($parents as $key => $value) { 
    $exists = true; 
    foreach ($searched as $skey => $svalue) { 
      $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
    } 
    if($exists){ return $key; } 
  } 
  
  return -1; 
} 
 
$nullLink = "javascript:void(0);";

if(php72_count($applicantDetails)>0)
{
$val=array();
$val=$applicantDetails[0];
}

?>
<input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
<h1><?=$cpagetitle ?></h1>
<br />


<!--start table-content  -->
 <div id="user-grid" class="gtable sortable">
	  
        <table class="gtable sortable">
            <tbody>
                <tr>
                    <td width="22%">Request No. </td>
                    <td width="78%"><?php echo $val['request_key']; ?></td>
                </tr>
               
                <tr>
                    <td>Innovator Name</td>
                    <td><?php echo $val['innovator_name']; ?></td>
                </tr>
				 <tr>
                    <td>Request Date</td>
                    <td><?php echo $val['request_date']; ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo $val['job_description']; ?></td>
                </tr>
                <tr>
                    <td>From Period</td>
                    <td><?php echo $val['from_period']; ?></td>
                </tr>
                <tr>
                    <td>To Period</td>
                    <td><?php echo $val['to_period']; ?></td>
                </tr>
            </tbody>
         </table>		
  </div>
  <br/><br/>
<div id="user-grid" class="gtable sortable">

<ul class="option-tab" style="margin-top:0px;">

      <li><?php echo anchor('fellow/suggestfellow/'.$innovationid.'/'.$val['id'],'Add Applicant','class="button"'); ?></li>
      <li><?php echo anchor('fellow/induction_view/'.$innovationid,'Job Induction','class="button"');?></li>
      <li><a href="<?=site_url('fellow/budget/'.$innovationid)?>" class="button">Add Budget</a></li>
</ul>  

<br /><br/>

<form action="<?= site_url('fellow/addapplicantstatus')?>" method="post">
<input type="hidden" name="innovation" value="<?=$innovationid?>"/>
<input type="hidden" name="applicant_id" value="" />
	<table width="100%" class="items">
	<thead>
	<tr>
    <th><a href="<?=$nullLink?>" field="label">First Name</a></th>
	<th><a href="<?=$nullLink?>" field="label">Last Name</a></th>
	<th><a href="<?=$nullLink?>" field="label">Offer Letter</a></th>
	<th><a href="<?=$nullLink?>" field="label">Notes</a></th>
    <th><a href="<?=$nullLink?>" field="required">Status</a></th>
    <th><a href="<?=$nullLink?>" field="value">Action</a></th>

	
	</tr>
    </thead>
	<tbody>
<?php
	if(php72_count($applicantList))
	{    
		$i=0;
		foreach($applicantList as $row)
		{
			$index = multidimensional_search($applicantstatus, array('first_name'=>$row['firstname'], 'last_name'=>$row['lastname']));
	?>	
			<tr>
                <td align="left" valign="middle"><?php echo $row['firstname'];?></td>
                <td align="left" valign="middle"><?php echo $row['lastname'];?></td>
                <td align="left" valign="middle"><?php echo $row['oferrletter'];?></td>
                <td align="left" valign="middle"><?php echo $row['notes'];?></td>
				<td> 
			   <?php if(isset($row['status'])==1)
					 {
						echo "Accepted";
					 }
					 else if(isset($row['status'])==2)
					 {
						 echo "Rejected";
					 }
					 else if(isset($row['status'])==0)
					 {
					     echo "Pending";
			   		 } ?>
				</td>
				<td>
				<a href="<?=site_url('fellow/removeapplicant/'.$row['innovation'].'/'.$row['applicant_id']);?>" class="button">Remove Applicant</a>
				</td>
				</tr>
                <input type="hidden" name="applicant_id[]" value="<?=(isset($applicantstatus[$index]['applicant_id']))?$applicantstatus[$index]['applicant_id']:'';?>" />
			<?php 
			$i++;
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
	</table>
</form>	 			 
						
   </div>      
