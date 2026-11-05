<?php
$nullLink = 'javascript:void(0);';
$form_name = 'meetingForm';
?>
<ul class="option-tab">
    <li><a href="<?=site_url('activities/view_list/'.$activityDetails['0']['innovation'])?>" class="button">Activities</a></li>
    <li><a href="<?=site_url('activities/activity_details/'.$activityDetails['0']['innovation'].'/'.$activityDetails['0']['id']);?>" class="button">Back</a>
</li>
</ul>
<h1><?=$cpagetitle?> - <?=$activityDetails['0']['name_of_enterprise']?></h1>
<script type="text/javascript">
$(document).ready(function(){
	
	function ordering(parent)
	{
		var d=0;
		$('.'+parent+' .s_no').each(function(){
			$(this).html(d);
			++d;
		});
	}
	function cloneRows(clone,parent)
	{
		var cloned = $('.'+clone).clone().show().removeClass(clone).addClass('odd');
			$('.'+parent).append(cloned);
			ordering(parent);
		$('.datepicker').attr('id','');
		$('.datepicker').removeClass('hasDatepicker').datepicker();
	}
	$('.removeRow').live('click',function(){
			parent = $(this).parents('tbody').attr('class');
			$(this).parents('tr').remove();	
			ordering(parent);
	});
	//agenda table
	$('#addAgendaRow').click(function(){
			cloneRows('cloneAgenda','agendaTable')
	});
	//attendence table
	$('#addAttendeesRow').click(function(){
			cloneRows('cloneAttendees','attendeesTable')
	});
	//action Table
	$('#addActionRow').click(function(){
			cloneRows('cloneAction','actionTable')
	});
});
</script>
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
}
?>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>

<form id="meetingForm" action="<?=site_url('meeting/view/'.$activity)?>" enctype="multipart/form-data" method="post" name="meetingForm">
<input type="hidden" name="meeting_id" value="<?=$meeting_id?>"  />
<dl class="inline">
        <dt><label for="meeting_date">Meeting Date<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="meeting_date" class="input-text datepicker  required" value="<?=$meeting_date?>"  size="40" /></dd>
        
        <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="subject" class="input-text required" value="<?=$subject?>"  size="40" /></dd>
        
        <dt><label for="location">Location<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="location" class="input-text required" value="<?=$location?>"  size="40" /></dd>
        
        <dt><label for="start_datetime">Start Date & Time<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="start_datetime"  class="input-text datetimepicker required" value="<?=$start_datetime?>"  size="40" /></dd>
        
        <dt><label for="end_datetime">End Date & Time<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="end_datetime" class="input-text datetimepicker required" value="<?=$end_datetime?>"  size="40" /></dd>
</dl>        
<h2>Agenda</h2>
<table class="gtable sortable">
<thead>
<tr>
<th width="10%">S.No.</th>
<th width="19%">Subject</th>
<th width="18%">Description</th>
<th width="17%">Owner</th>
<th width="19%">Outcome</th>
<th width="11%" class="head">Action</th>
</tr>
	</thead>
	<tbody class="agendaTable">
    <tr class="cloneAgenda"  style="display:none">
			<td align="left" valign="middle" class="s_no">&nbsp;</td>
            <td align="left" valign="middle"><input type="text"  name="agenda_subject[]" class="input-text" /></td>
            <td align="left" valign="middle"><input type="text"  name="agenda_description[]" class="input-text" /></td>
            <td align="left" valign="middle"><select id="owner"  name="owner[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($usersList as $row) {
                 ?>
                <option value="<?=$row['emp_number']?>" >
                <?=$row['emp_name']?></option>
                <?php } ?>
             </select></td>
            <td align="left" valign="middle"><input type="text"  name="outcome[]" class="input-text" /></td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>
    <?php
	$i = 0;
	foreach($agendaList as $row):
	++$i;
	?>
    <tr class="odd">
			<td align="left" valign="middle" class="s_no"><?=$i?></td>
            <td align="left" valign="middle"><input type="text"  name="agenda_subject[]" value="<?=$row['subject']?>" class="input-text" /></td>
            <td align="left" valign="middle"><input type="text"  name="agenda_description[]" value="<?=$row['description']?>" class="input-text" /></td>
            <td align="left" valign="middle">
             <select id="owner"  name="owner[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($usersList as $user) {
                 ?>
                <option value="<?=$user['emp_number']?>"  <?=($row['owner']==$user['emp_number'])?'selected':'';?>  >
                <?=$user['emp_name']?></option>
                <?php } ?>
             </select>
            <td align="left" valign="middle"><input type="text"  name="outcome[]" value="<?=$row['outcome']?>" class="input-text" /></td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>
    <?php endforeach; ?>
			
            
	</tbody>
	</table>
   <a href="javascript:void(0);" id="addAgendaRow" class="button" >Add Row</a> 
<h2>Attendees</h2>
<table class="gtable sortable">
<thead>
<tr>
<th width="10%">S.No.</th>
<th width="19%">Name</th>
<th width="18%">Attendance</th>
<th width="17%">Response</th>
<th width="11%" class="head">Action</th>
</tr>
	</thead>
	<tbody class="attendeesTable">
    <tr class="cloneAttendees"  style="display:none">
			<td align="left" valign="middle" class="s_no">&nbsp;</td>
            
            <td align="left" valign="middle">
            <select id="employee"  name="employee[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($usersList as $row) {
                 ?>
                <option value="<?=$row['emp_number']?>" >
                <?=$row['emp_name']?></option>
                <?php } ?>
             </select></td>
            <td align="left" valign="middle"> 
            <select id="attendence"  name="attendence[]" >
             <option value="">-Select-</option>
                <option value="Required" >Required</option>
                <option value="Organizer" >Organizer</option>   
                <option value="Optional" >Optional</option>           
             </select></td>
            <td align="left" valign="middle">
            <select id="response"  name="response[]" >
             <option value="">-Select-</option>
                <option value="Accepted" >Accepted</option>
                <option value="Rejected" >Rejected</option>   
             </select></td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>
     <?php
	$i = 0;
	foreach($attendeesList as $row):
	++$i;
	?>
    <tr class="odd" >
			<td align="left" valign="middle" class="s_no"><?=$i?></td>
            
            <td align="left" valign="middle">
            <select id="employee"  name="employee[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($usersList as $user) {
                 ?>
                <option value="<?=$user['emp_number']?>" <?=($row['employee']==$user['emp_number'])?'selected':'';?> >
                <?=$user['emp_name']?></option>
                <?php } ?>
             </select></td>
            <td align="left" valign="middle"> 
            <select id="attendence"  name="attendence[]" >
             <option value="">-Select-</option>
                <option value="Required" <?=($row['attendence']== 'Required')?'selected':'';?>>Required</option>
                <option value="Organizer" <?=($row['attendence']== 'Organizer')?'selected':'';?> >Organizer</option>   
                <option value="Optional" <?=($row['attendence']== 'Optional')?'selected':'';?> >Optional</option>           
             </select></td>
            <td align="left" valign="middle">
            <select id="response"  name="response[]" >
             <option value="">-Select-</option>
                <option value="Accepted" <?=($row['response']== 'Accepted')?'selected':'';?>>Accepted</option>
                <option value="Rejected" <?=($row['response']== 'Rejected')?'selected':'';?>>Rejected</option>   
             </select></td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>
   <?php endforeach; ?> 
		
            
	</tbody>
	</table>
   <a href="javascript:void(0);" id="addAttendeesRow" class="button" >Add Row</a> 

<h2>Action Items</h2>
<div style="overflow:scroll">
<table class="gtable sortable">
<thead>
<tr>
<th width="10%">S.No.</th>
<th width="19%">Subject</th>
<th width="18%">Description</th>
<th width="17%">Assigned To </th>
<th width="11%">Due Date </th> 
<th width="17%">Priority</th>

<th width="17%">Status</th>
<th width="17%">Commented On </th>
<th width="11%" class="head">Action</th>
</tr>
	</thead>
	<tbody class="actionTable">
    <tr class="cloneAction"  style="display:none">
			<td align="left" valign="middle" class="s_no">&nbsp;</td>
            <td align="left" valign="middle">
            <input type="text"  name="action_subject[]" class="input-text" />
            </td>
            <td align="left" valign="middle">
            <input type="text"  name="action_description[]" class="input-text" />
            </td>
            <td align="left" valign="middle">
            <select id="name"  name="assigned_to[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($usersList as $row) {
                 ?>
                <option value="<?=$row['emp_number']?>" >
                <?=$row['emp_name']?></option>
                <?php } ?>
             </select></td>
             <td align="left" valign="middle">
            <input type="text"  name="due_date[]" class="input-text datepicker" />
            </td>
            <td align="left" valign="middle"> 
            <select id="priority"  name="priority[]" style="min-width : 80px;" >
             <option value="">-Select-</option>
                <option value="High" >High</option>
                <option value="Medium" >Medium</option>   
                <option value="Low" >Low</option>           
             </select></td>
            <td align="left" valign="middle">
            <select id="status"  name="status[]" style="min-width : 80px;" >
             <option value="">-Select-</option>
                <option value="Open" >Open</option>
                <option value="Closed" >Closed</option>   
             </select></td>
             <td align="left" valign="middle">
            <input type="text"  name="commented_on[]" class="input-text" />
            </td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>
  <?php 
  	$i = 0;
	foreach($actionList as $row):
	++$i;
  ?>
	<tr class="odd">
			<td align="left" valign="middle" class="s_no"><?=$i?></td>
            <td align="left" valign="middle">
            <input type="text"  name="action_subject[]" value="<?=$row['subject']?>" class="input-text datepicker" />
            </td>
            <td align="left" valign="middle">
            <input type="text"  name="action_description[]" value="<?=$row['description']?>" class="input-text" />
            </td>
            <td align="left" valign="middle">
            <select id="name"  name="assigned_to[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($usersList as $emp) {
                 ?>
               <option value="<?=$emp['emp_number']?>" <?=($row['assigned_to']==$emp['emp_number'])?'selected':'';?> >
                <?=$emp['emp_name']?> </option>
                <?php } ?>
             </select></td>
             <td align="left" valign="middle">
            <input type="text"  name="due_date[]" class="input-text datepicker" value="<?=mysql2date($row['due_date'])?>" />
            </td>
            <td align="left" valign="middle"> 
            <select id="priority"  name="priority[]" style="min-width : 80px;" >
             <option value="">-Select-</option>
                <option value="High" <?=($row['priority']== 'High')?'selected':'';?> >High</option>
                <option value="Medium" <?=($row['priority']== 'Medium')?'selected':'';?> >Medium</option>   
                <option value="Low" <?=($row['priority']== 'Low')?'selected':'';?> >Low</option>           
             </select></td>
            <td align="left" valign="middle">
            <select id="status"  name="status[]" style="min-width : 80px;" >
             <option value="">-Select-</option>
                <option value="Open" <?=($row['status']== 'Open')?'selected':'';?>>Open</option>
                <option value="Closed" <?=($row['status']== 'Closed')?'selected':'';?> >Closed</option>   
             </select></td>
             <td align="left" valign="middle">
            <input type="text"  name="commented_on[]" class="input-text" value="<?=$row['comments']?>" />
            </td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>	
  <?php endforeach;?>
            
	</tbody>
	</table>
</div>
   <a href="javascript:void(0);" id="addActionRow" class="button" >Add Row</a> 
<h2>Comments & Discussions</h2>
<dl class="inline">
    <dt><label for="meeting_date">Comments<font class="req_field">*</font></label></dt>
    <dd><textarea name="comments_discussions" rows="4" cols="40" class="input-text"><?=$comments_discussions?></textarea></dd>
</dl>
<div class="buttons">
    <input type="submit" name="txtSubmit" value="Submit" class="button" />
    <input type="reset" name="txtReset" value="Reset" class="button white" />
</div>
</div>
<!-- Paging style -->
</form>