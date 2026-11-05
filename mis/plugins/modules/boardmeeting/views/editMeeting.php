
<?php
$nullLink = 'javascript:void(0);';
$form_name = 'meetingForm';

?>
<ul class="option-tab">
 <li>
 	<a href="<?=site_url('boardmeeting/view_list/'.$innovationid);?>" class="button">Back</a>
 </li>
 
</ul>
<h1><?=$cpagetitle?> </h1>
<script type="text/javascript">
$(document).ready(function(){

$('#response').change(function() { alert("sdfsdf");
  	   var ss=$("#response").val();
});
    $value=$(this).val();
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
	    $("#showID").hide();	
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
if(count($meetingDetails))
{
	$meeting_id = $meetingDetails['0']['id'];
	$meeting_date = mysql2date($meetingDetails['0']['meeting_date']);
	$subject = $meetingDetails['0']['subject'];
	$location = $meetingDetails['0']['location'];
	$start_datetime = $meetingDetails['0']['start_datetime'];
	$end_datetime = $meetingDetails['0']['end_datetime'];
	$comments_discussions = $meetingDetails['0']['comments_discussions'];
	$status = $meetingDetails['0']['status'];
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
}
?>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
 
<form id="meetingForm" action="<?=site_url('boardmeeting/view/'.$innovationid)?>" enctype="multipart/form-data" method="post" name="meetingForm">
<input type="hidden" name="meeting_id" value="<?=$meeting_id?>"  />
<input type="hidden" name="innovationid" value="<?=$innovationid?>"  />
<input type="hidden" name="option" value="<?php echo $option ?>" />
<dl class="inline">
        
        <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="subject" class="input-text required" value="<?=$subject?>"  size="40" /></dd>
        
        <dt><label for="location">Location<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="location" class="input-text required" value="<?=$location?>"  size="40" /></dd>
        
        <dt><label for="start_datetime">Start Time<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="start_datetime"  class="datetimepicker required" value="<?=$start_datetime?>"  size="40" /></dd>
        
        <dt><label for="end_datetime">End Time<font class="req_field">*</font></label></dt>
        <dd><input type="text"  name="end_datetime" class="datetimepicker required" value="<?=$end_datetime?>"  size="40" /></dd>
		
</dl>        

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
             foreach($userList as $row) {
                 ?>
                <option value="<?=$row['members']?>" >
                <?=$row['members']?></option>
                <?php } ?>
             </select></td>
			 <td>
			 <select id="email"  name="email[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($userList as $row) {
                 ?>
                <option value="<?=$row['email']?>" >
                <?=$row['email']?></option>
                <?php } ?>
             </select></td>
            <td align="left" valign="middle"> 
			
            <select id="attendence"  name="attendence[]" >
             <option value="">-Select-</option>
			
                <option value="Required" >Required</option>
                <option value="Organizer" >Organizer</option>   
                <option value="Optional" >Optional</option>           
	
             </select></td>
            <td align="left" valign="middle" >
            <select id="response"  name="response[]" class="response">
             <option value="">-Select-</option>
					<option value="Accepted" >Accepted</option>
					<option value="Rejected" >Rejected</option>
					<option value="Reassigned" >Reassigned</option>
             </select></td>
			 
			 <td><a href="#" id="showID" syle="display:none;"> Click here</a> </td>
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
             foreach($userList as $user) {
                 ?>
                <option value="<?=$user['members']?>" <?=($row['employee']==$user['members'])?'selected':'';?> >
                <?=$user['members']?></option>
                <?php } ?>
             </select></td>
			 <td align="left" valign="middle">
            <select id="email"  name="email[]" >
             <option value="">-Select-</option>
             <?php 
             foreach($userList as $user) {
                 ?>
                <option value="<?=$user['email']?>" <?=($row['email']==$user['email'])?'selected':'';?> >
                <?=$user['email']?></option>
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
			<?php
			  if($emp_number==$row['employee'])
			    {?>
           	 <select id="response"  name="response[]" >
		
            	<option value="">-Select-</option>
			 
                <option value="Accepted" <?=($row['response']== 'Accepted')?'selected':'';?>>Accepted</option>
                <option value="Rejected" <?=($row['response']== 'Rejected')?'selected':'';?>>Rejected</option>   
		    
             </select>
			 <?php  }
			 else
			  {?>
			   <input type="text"  name="response[]" value="<?php echo $row['response']; ?>" readonly="readonly"/>
		<?php  } ?>
			  </td>
            <td align="left" valign="middle"><a href="javascript:void(0);" class="removeRow" >Delete</a></td>
			</tr>
   <?php endforeach; ?> 
		
            
	</tbody>
	</table>
   <a href="javascript:void(0);" id="addAttendeesRow" class="button" >Add Row</a> 
  <br/><br/>&nbsp;
   <dl class="inline">
   <table width="100%" height="100%">
   <tr>
   <td>
   <label for="agenda">Agenda</label></td>
   <td><input type="file" name="agenda"/></td>
   <td><?php echo $attendeesList[0]['agenda'];?></td>
	</tr>
	<tr>
	<td>
   <label for="Board Meeting Note">Board Meeting Note</label>
	</td>	   
	<td>
   <input type="file" name="board_note"/></td>
        <td><?php echo $attendeesList[0]['boardmeeting_note'];?></td>
   </tr>
   <tr>
   <td>
   <label for="supporting document">Supporting Document</label>
   </td>
   <td>
   <input type="file" name="supporting_document[]" multiple="multiple"/></td>
   <td><?php echo $attendeesList[0]['supporting_document'];?></td>
   </tr>
   </table>
   </dl>
   


 <?php
     $today=date("Y/m/d");
   if($end_datetime !='')
   {
	   $today=strtotime($today);
	   $meeting=explode("/",$end_datetime);
	   $year= $meeting[2];
	   $month=$meeting[1];
	   $date=$meeting[0];
	   $year = substr($year,0,4);
	   $meeting=$year."/".$month."/".$date;
	   $meeting_date=strtotime($meeting);
   }
   
   
if($today >= $meeting_date && $meeting_date!='')
 {  ?>
  
<h2>Comments & Discussions</h2>
<dl class="inline">
    <dt><label for="meeting_date">Minutes of Meeting<font class="req_field">*</font></label></dt>
	 <dd>
	<?php if($isincubAuth) 
	 {?>
     <textarea name="comments_discussions" rows="4" cols="40" class="input-text"><?=$comments_discussions?></textarea></dd>
<?php } else
      {?>
           <textarea name="comments_discussions" rows="4" cols="40" class="input-text" ><?=$comments_discussions?></textarea>
  <?php }  ?>
    </dd>
	
	<dt><label for="name">Upload File1</label></dt>
	<dd><input type="file" name="filedoc"/></dd>
	<dt><label for="name">Upload File2</label></dt>
	<dd><input type="file" name="filedoc2"/></dd>
	
	<dt><label for="meeting_date">Status</label></dt>
	<dd>
	<?php

	 if($this->session->userdata('emp_number') == isset($empnumber))
	 {

	 ?>
	  
	    <select  name="status" id="status" >
	      <option value="option1">select</option>
				<?php  foreach($completestatus as $key=>$row)
				{

                    ?>
				 <option value="<?php echo $key ;?>" <?=($key==$status)?' selected="selected"' : '';?> ><?php echo $row; ?></option>
		  <?php } ?>
	    </select> 
  <?php 
         }
        else
	         { ?>
			        <?php if($status!='')

					{?>
	                  <input type="text" id="status1" name="status1" value="<?php echo @$completestatus[$status]; ?>" />
					  <input type="hidden" id="status" name="status" readonly="readonly" value="1" />
			  <?php } ?>
	   <?php   
	         }	?>
	 	</dd>
</dl>

<!--- this is of closing of date restriction ---->
<?php } 
else
{?>
   <input type="hidden" id="status" name="status" readonly="readonly" value="1" />
   <input type="hidden" name="comments_discussions" value="<?=$comments_discussions?>" />

<?php }
?>

<div class="buttons">
    <input type="submit" name="txtSubmit" value="Submit" class="button" />
    <input type="reset" name="txtReset" value="Reset" class="button white" />
</div>

<!-- Paging style -->
</form>