<?php
$nullLink = 'javascript:void(0);';
$form_name = 'meetingForm';
$this->load->model('Mmeeting');
?>
<ul class="option-tab">
 <li>
 <a href="<?=site_url('boardmeeting/view/'.$innovationid.'/'.$this->uri->segment('4').'/edit')?>" class="button">Edit</a>
 </li>	
 <li>
 	<a href="<?=site_url('boardmeeting/view_list/'.$innovationid);?>" class="button">Back</a>
 </li>
 
</ul>
<h1><?=$cpagetitle?> </h1>

<?php 
if(php72_count($meetingDetails))
{
	$meeting_id = $meetingDetails['0']['id'];
	$meeting_date = mysql2date($meetingDetails['0']['meeting_date']);
	$subject = $meetingDetails['0']['subject'];
	$location = $meetingDetails['0']['location'];
	$start_datetime = $meetingDetails['0']['start_datetime'];
	$end_datetime = $meetingDetails['0']['end_datetime'];
	$comments_discussions = $meetingDetails['0']['comments_discussions'];
	$status = $meetingDetails['0']['status'];
	$filedoc = $meetingDetails['0']['filedoc'];
	$filedoc2=$meetingDetails[0]['filedoc2'];
}
else
{
	$meeting_id = '';
	$meeting_date = '';
	$subject = '';
	$location = '';
	$start_datetime = '';
	$end_datetime = '';
	$comments_discussions = '';
	$status="";
	$filedoc ="";
	$filedoc2="";
}
?>
<form id="meetingForm" action="<?=site_url('boardmeeting/view/'.$innovationid)?>" enctype="multipart/form-data" method="post" name="meetingForm">
<input type="hidden" name="meeting_id" value="<?=$meeting_id?>"  />
<input type="hidden" name="innovationid" value="<?=$innovationid?>"  />
<input type="hidden" name="option" value="<?php echo $option ?>" />
<dl class="inline">
        <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
        <dd><input type="text"  style="border:solid 0px;" readonly="readonly" name="subject" class="input-text required" value="<?=$subject?>"  size="40" /></dd>
        
        <dt><label for="location">Location<font class="req_field">*</font></label></dt>
        <dd><input type="text" style="border:solid 0px;" readonly="readonly"  name="location" class="input-text required" value="<?=$location?>"  size="40" /></dd>
        
        <dt><label for="start_datetime">Start Time<font class="req_field">*</font></label></dt>
        <dd><input type="text" style="border:solid 0px;" readonly="readonly" class="input-text timepicker"  name="start_datetime"   value="<?=$start_datetime?>"  size="40" /></dd>
        
        <dt><label for="end_datetime">End Time<font class="req_field">*</font></label></dt>
        <dd><input type="text" style="border:solid 0px;" readonly="readonly"  class="input-text timepicker"  name="end_datetime"  value="<?=$end_datetime?>"  size="40" /></dd>
				
</dl>   
        
<h2>Attendees</h2>
<table class="gtable sortable">
<thead>
<tr>
<th width="10%">S.No.</th>
<th width="19%">Name</th>
<th width="19%">Email</th>
<th width="18%">Attendance</th>
<th width="17%">Response</th>
</tr>
	</thead>
	<tbody class="attendeesTable">
 
     <?php
	$i = 0;
	foreach($attendeesList as $row):
	++$i;
	?>
    <tr class="odd" >
			<td align="left" valign="middle" class="s_no"><?=$i ?></td>
            
            <td align="left" valign="middle">
			  <?php $employee=$this->Mmeeting->getUsers($row['employee']); 
			          $employee;?>
		  <select id="employee1"  name="employee1[]" disabled="disabled"  >
             <option value="">-Select-</option>
             <?php 
             foreach($userList as $user) 
			 {
                 ?>
			  
                <option value="<?=$user['members']?>" <?=($row['employee']==$user['members'])?'selected':'';?> >
                <?=$user['members']?></option>
				
                <?php } ?>
             </select>  
			
			 <input type="hidden" id="employee" name="employee[]" value="<?=$row['employee']?>" />
	   
            </td>
			<td align="left" valign="middle">
			 <select id="email"  name="email[]" disabled="disabled"  >
             <option value="">-Select-</option>
             <?php 
             foreach($userList as $user) 
			 {
                 ?>
			  
                <option value="<?=$user['email']?>" <?=($row['email']==$user['email'])?'selected':'';?> >
                <?=$user['email']?></option>
				
                <?php } ?>
             </select> 
			
			</td>
            <td align="left" valign="middle"> 
			<input type="text" id="attendence" disabled="disabled"   name="attendence[]" value="<?=$row['attendence']; ?>"		
			 
            </td>
            <td align="left" valign="middle">
			
			    <?php if($this->session->userdata('emp_name')==$employee) 
				{?>
             	<select id="response"  name="response[]"  >
					<option value="">-Select-</option>
					<option value="Accepted" <?=($row['response']== 'Accepted')?'selected':'';?>>Accepted</option>
					<option value="Rejected" <?=($row['response']== 'Rejected')?'selected':'';?>>Rejected</option>   
                </select>
		 <?php } 
		       else
			   { ?>
			    <input type="text" name="response[]" disabled="disabled" value=" <?php echo $row['response']; ?>" />
	   <?php   } ?>
	
			
			</td>
          
			</tr>
   <?php endforeach; ?> 
	       
	</tbody>
	</table>
 

 <h2>Documents</h2>
 <div>
 <table class="gtable">
 <thead>
 <tr>
 <th><h4>Agenda</h4></th>
 <th><h4>Board Meeting Note</h4></th>
 <th><h4>Supporting Documents</h4></th>
 </tr>
 </thead>
 <tr>
     <?php if($attendeesList[0]['agenda']){?>
 <td><a href="<?php echo base_url()."uploads/boardmeeting/".str_replace(" ","_",$attendeesList[0]['agenda'])?>" target="_blank">&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /><?=$attendeesList[0]['agenda'];?></a></td>
 <?php } else {?>
 <td>No Documents</td>
 <?php } if($attendeesList[0]['boardmeeting_note']){?>
 <td><a href="<?php echo base_url()."uploads/boardmeeting/".str_replace(" ","_",$attendeesList[0]['boardmeeting_note']);?>" target="_blank">&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /><?=$attendeesList[0]['boardmeeting_note'];?></a></td>
 <?php } else {?>
 <td>No Documents</td>
 <?php } if($attendeesList[0]['supporting_document']){?>
 <td><a href="<?php echo base_url()."uploads/boardmeeting/".str_replace(" ","_",$attendeesList[0]['supporting_document']);?>" target="_blank">&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /><?=$attendeesList[0]['supporting_document'];?></a></td>
 <?php } else {?>
 <td>No Documents</td>
 <?php } ?>
 </tr>
 </table>
 </div>
<?php
   $today=date("Y/m/d");
  if($meeting_date!='')
  {
      $meeting=explode("/",$meeting_date);
	 
	  $today=strtotime($today);
	  $year= $meeting[2];
	  $month=$meeting[1];
	  $date=$meeting[0];
	  $meeting=$year."/".$month."/".$date;
	  
	  $meeting_date=strtotime($meeting);
  }
 
 if($today >= $meeting_date )
 {  ?>
<div style="min-height:200px; height:100%;">  
<h2>Comments & Discussions</h2>
<dl class="inline">
    <dt><label for="meeting_date">Minutes of Meeting<font class="req_field">*</font></label></dt>
	 <dd>
	
      <?=$comments_discussions?>

    </dd>
	<dt><label for="meeting_date">Status</label></dt>
	<dd>
	     <?php 
		 
		   if($status !='')
		   {
		     echo @$completestatus[$status];
		   }
		?>

	</dd>
	<dt><label for="name">Upload File</label></dt>
	<dd>
	     <?php  if($filedoc!='')
		 {?>
		      <a target="_blank" href="<?=base_url()?>/uploads/boardmeeting/<?php echo $filedoc;?>">Download</a>
	<?php } 
		 else
		  {?>
		   <?php echo "No FILE UPLOAD"; ?>
		 <?php  } ?>
		 
		 
	</dd>
	<dt><label for="name">Upload File2</label></dt>
	<dd>
	     <?php if($filedoc2!='')
		 {?>
		      <a target="_blank" href="./uploads/boardmeeting/<?php echo $filedoc2;?>">Download</a>
		 <?php  } 
		 else
		  {?>
		   <?php echo "No FILE UPLOAD"; ?>
		 <?php  } ?>
		 
		 
	</dd>
</dl>
</div>
<?php } 

else
{?>
   <input type="hidden" id="status" name="status" readonly="readonly" value="<?php echo $status; ?>" />
   <input type="hidden" name="comments_discussions" value="<?=$comments_discussions?>" />

<?php }
?>
<!-- Paging style -->
</form>