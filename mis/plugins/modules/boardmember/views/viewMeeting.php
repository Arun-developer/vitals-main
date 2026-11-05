<?php
$nullLink = 'javascript:void(0);';
$form_name = 'meetingForm';
$this->load->model('Mmeeting');

?>
<ul class="option-tab">

 <li>
 	<a href="<?=site_url('boardmeeting/view_list/'.$innovationid);?>" class="button">Back</a>
 </li>
 
</ul>
<h1><?=$cpagetitle?> </h1>

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
	$filedoc = $meetingDetails['0']['filedoc'];
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
}
?>
    <div align="right">
 	  <a href="<?=site_url('boardmeeting/view/'.$innovationid.'/edit/'.$meetingid);?>" class="button red">Edit</a>
	</div>

<form id="meetingForm" action="<?=site_url('boardmeeting/view/'.$innovationid)?>" enctype="multipart/form-data" method="post" name="meetingForm">
<input type="hidden" name="meeting_id" value="<?=$meeting_id?>"  />
<input type="hidden" name="innovationid" value="<?=$innovationid?>"  />

<dl class="inline">
        <dt><label for="meeting_date">Meeting Date<font class="req_field">*</font></label></dt>
        <dd><?=$meeting_date?></dd>
        
        <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
        <dd><?=$subject?></dd>
        
        <dt><label for="location">Location<font class="req_field">*</font></label></dt>
        <dd><?=$location?></dd>
        
        <dt><label for="start_datetime">Start Date & Time<font class="req_field">*</font></label></dt>
        <dd><?=$start_datetime?></dd>
        
        <dt><label for="end_datetime">End Date & Time<font class="req_field">*</font></label></dt>
        <dd><?=$end_datetime?></dd>
		
</dl>        
<h2>Agenda</h2>

<h2>Attendees</h2>
<table class="gtable sortable">
<thead>
<tr>
<th width="10%">S.No.</th>
<th width="19%">Name</th>
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
			         echo $employee;?>
            </td>
            <td align="left" valign="middle"> 
			    <?php echo $row['attendence']; ?>
            </td>
            <td align="left" valign="middle">
			    <?php echo $row['response']; ?>
			</td>
          
			</tr>
   <?php endforeach; ?> 
	       
	</tbody>
	</table>
 

<h2>Action Items</h2>
<div>
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

</tr>
	</thead>
	<tbody class="actionTable">
   
  <?php 
  	$i = 0;
	foreach($actionList as $row):

	
	 
	++$i;
  ?>
	<tr class="odd">
			<td align="left" valign="middle" class="s_no"><?=$i?></td>
            <td align="left" valign="middle">
                <?=$row['subject']?>
            </td>
            <td align="left" valign="middle">
                <?=$row['description']?>
            </td>
            <td align="left" valign="middle">
			    <?php
				 if($row['assigned_to']!='0' )
				 {
				    $employee=$this->Mmeeting->getUsers($row['assigned_to']); 
			        echo $employee;
				 }
					 ?>
            </td>
             <td align="left" valign="middle">
                  <?=mysql2date($row['due_date'])?>
             </td>
            <td align="left" valign="middle"> 
           
              <?= $row['priority'] ?>
                   
           </td>
            <td align="left" valign="middle">
                   <?= $row['status']?>
		    </td>
             <td align="left" valign="middle">
                  <?=$row['comments']?>
            </td>
           
			</tr>	
  <?php endforeach;?>
            
	</tbody>
	</table>
</div>
  
<h2>Comments & Discussions</h2>
<dl class="inline">
    <dt><label for="meeting_date">Comments<font class="req_field">*</font></label></dt>
	 <dd>
	
           <?=$comments_discussions?>

    </dd>
	<dt><label for="meeting_date">Status</label></dt>
	<dd>
	     <?php 
		   if($status!='')
		   {
		     echo $completestatus[$status]; 
		 }?>

	</dd>
	<dt><label for="name">Upload File</label></dt>
	<dd>
	     <?php  if($filedoc!='')
		 {?>
		      <a target="_blank" href="<?=base_url()?>/uploads/boardmeeting/<?php echo $filedoc;?>">Download</a>
		  
		 <?php  } 
		 else
		  {?>
		   <?php echo "No FILE UPLOAD"; ?>
		 <?php  } ?>
		 
		 
	</dd>
</dl>
<div class="buttons" style="margin-top:50px;">
   
  &nbsp;
</div>
</div>
<!-- Paging style -->
</form>