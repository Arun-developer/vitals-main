<h1><?php echo $title; ?></h1>
<?php 
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo form_open('calendar/create');?>
	<table align="center">
		
		<tr>
			<td valign="top">Date : </td>
			<td><input class="datepicker" name="date" size="30"></td>
		</tr>
		<tr>
			<td valign="top">Event Title : </td>
			<td><input id="eventTitle" name="eventTitle" size="30"></td>
		</tr>
		<tr>
			<td>Event Details : </td>
			<td><textarea cols="26" rows="5" name="eventContent" id="eventContent"></textarea></td>
		</tr>
		<tr>
		<td><input type="hidden" name="user_id" id="user_id" value="<?php  echo $user_id;?>" /></td>
		<td><input type="hidden" name="user" id="nick" value="<?php echo $user;?>" />		</td>
		</tr>
		<tr>
		<td valign="top">File Attachment:</td>
		<td><input type="file" name="file" id="file"/></td>
		</tr>
		<?php if($this->session->userdata('user_type') != 'admin'){
			?>
		<tr>
		<td valign="top">
		If you want to share?
		</td>
		<td>
		<input type="checkbox" name="share" value="share"/>
		</td>
		</tr>
		<tr>
		<Td valign="top">To Which Employee</Td>
		<td>
		
		<select name="to">
		<option value="">-select-</option>
		<?php foreach($empname as $row):?>
		<option value="<?=$row['empname'];?>"><?=$row['empname'];?></option>
		<?php endforeach;?>
		</select>
		</td>
		</tr>
		<?php } ?>
		<tr>
            <td></td>
			<td>
				<div style="margin-left:10px;">
				<input type="submit" value="Add Event" name="add" class="button"/>
				<input type="reset" value="Clear" name="reset" class="button"/>
				</div>
			
			</td>
                     
		</tr>
	</table>
<script type="text/javascript">
    $(function() {
      	$('.datepicker').datepick({dateFormat: 'yy-mm-dd'});
    });
</script>
	<?php form_close() ;?>
	
	<?php
//check if there is any alert message set
if(isset($alert) && !empty($alert))
{
	//message alert
	echo $alert;
}
?>
<style type="text/css">
        
.button{
	cursor: pointer;
	text-decoration:none;
	border: 1px solid rgb(51, 102, 51);
	padding: 4px 6px 4px 5px;
	color:rgb(255, 255, 255);
	font-size:12px;
        height:25px;
        width:75px;
        text-align:center;
	font-family:arial, serif;
	text-shadow: 0px 0px 4px rgb(0, 51, 51);
	font-size: 12px;
	border-radius:5px 4px 4px 4px;
	-moz-border-radius:5px 4px 4px 4px;
	-webkit-border-radius:5px 4px 4px 4px;
	box-shadow:0px 0px 0px rgb(0, 0, 0);
	-moz-box-shadow:0px 0px 0px rgb(0, 0, 0);
	-webkit-box-shadow:0px 0px 0px rgb(0, 0, 0);
	background-color: rgb(0, 102, 102);
	background-image:linear-gradient(-90deg, rgb(238, 238, 238), rgb(51, 153, 51));
	background-image:-webkit-gradient(linear, 50% 0%, 50% 100%, from(rgb(238, 238, 238)), to(rgb(51, 153, 51)));
	background-image:-moz-linear-gradient(-90deg, rgb(238, 238, 238), rgb(51, 153, 51));
}
.button:hover{
	cursor: pointer;
	text-decoration:none;
	border: 2px solid rgb(51, 204, 51);
	padding: 4px 6px 4px 5px;
	color:rgb(0, 0, 0);
	font-size:14px;
        height:25px;
        width:75px;
        text-align:center;
	font-family:arial, serif;
	text-shadow: 0px 0px 5px rgb(204, 255, 255);
	font-size: 14px;
	border-radius:5px 5px 5px 5px;
	-moz-border-radius:5px 5px 5px 5px;
	-webkit-border-radius:5px 5px 5px 5px;
	box-shadow:0px 0px 0px rgb(0, 0, 0);
	-moz-box-shadow:0px 0px 0px rgb(0, 0, 0);
	-webkit-box-shadow:0px 0px 0px rgb(0, 0, 0);
	background-color: rgb(255, 255, 255);
	background-image:linear-gradient(-90deg, rgb(238, 238, 238), rgb(0, 102, 102));
	background-image:-webkit-gradient(linear, 50% 0%, 50% 100%, from(rgb(238, 238, 238)), to(rgb(0, 102, 102)));
	background-image:-moz-linear-gradient(-90deg, rgb(238, 238, 238), rgb(0, 102, 102));
}
.button:active{
	cursor: pointer;
	text-decoration:none;
	border: 2px solid rgb(0, 204, 102);
	padding: 4px 6px 4px 5px;
	color:rgb(0, 0, 0);
	font-size:14px;
	font-family:arial, serif;
	text-shadow: 0px 0px 5px rgb(0, 0, 102);
	font-size: 14px;
        height:25px;
        width:75px;
        text-align:center;
	border-radius:5px 5px 5px 5px;
	-moz-border-radius:5px 5px 5px 5px;
	-webkit-border-radius:5px 5px 5px 5px;
	box-shadow:0px 0px 0px rgb(0, 0, 0);
	-moz-box-shadow:0px 0px 0px rgb(0, 0, 0);
	-webkit-box-shadow:0px 0px 0px rgb(0, 0, 0);
	background-color: rgb(255, 255, 255);
	background-image:linear-gradient(-90deg, rgb(238, 238, 238), rgb(0, 102, 102));
	background-image:-webkit-gradient(linear, 50% 0%, 50% 100%, from(rgb(238, 238, 238)), to(rgb(0, 102, 102)));
	background-image:-moz-linear-gradient(-90deg, rgb(238, 238, 238), rgb(0, 102, 102));
}

    </style>	