<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>jQuery content selection from list.</title>
<link href="<?php echo base_url();?>source/jquery_ui/test.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>source/jquery_ui/jquery.js"></script>
</head>
<body>
<form name="combo-box">
   
    <div>
        <ul class="tabs">
		<li class="<?php echo($this->uri->segment('2') == 'useraccess')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/index')?>" >Add User Access</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'addgroup')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/adduser')?>">Add User Group</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'addadmin')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/addadmin')?>">Add Admin</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'pim')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/addincubatee')?>">Manage Incubatee</a></li>
		</ul>
    </div>
	
	 <h1><?=$cpagetitle;?></h1>
	 
<div style="width:900px" class="stack">
	  <br/>
          <div style="width:900px;"><span style="float:left;padding-left:20px;"><font><b>User Group </b></font></span> <span style="padding-left:332px;"><b>Users </b></span> <span style="padding-left:325px;"><b> Users in usergroup</b></span> </div>
        <div style="width:900px;" class="formbox">

		<div id="user-group">
		<?php
		foreach($users as $row): ?>
		<div id="user.<?=$row['userg_id'];?>" userid="<?=$row['userg_id'];?>" class="innertxt">
                	<img src="<?php echo base_url();?>source/jquery_ui/images.jpg" width="75" height="75"><strong><?=$row['userg_name'];?></strong>
		   <ul style="margin-top:8px">
                    	<li>User ID: <?=$row['userg_id'];?></li><br/>
                        <li>Email: </li><br/>
                        <li style="padding-top:5px;"><input type="radio" checked="checked" name="select2" id="usergroup" value="<?=$row['userg_id'];?>" class="selectit" /><label for="select2">&nbsp;&nbsp;Select it.</label><a style="padding-left:12px;" href="<?=site_url('mainmaster/useraccess/viewrights/'.$row['userg_id'])?>"><font color="blue">view rights</font></a>&nbsp;/&nbsp;<a  href="<?=site_url('mainmaster/useraccess/viewusers/'.$row['userg_id'])?>" class="fancybox"><font color="blue">view users</font></a></li>
                    </ul>
                </div>
				<?php endforeach;?>
				</div>
          <br />
          <div style="width:100%;padding-left:240px;" class="formbox">
            <div id="all_users">
			<?php $na = ""; $i=1; foreach($userlist as $row):
			if($row['emp_type'] == '')
			{
				$row['emp_type'] = 'mip';
			}
			$na_new = $row['emp_type'];
			if($na_new != $na)
	    	{
		    $na = $na_new;
			 ?>
			 <h3><?=$row['emp_type'];?></h3>
		<?php } ?>
          		<div id="user<?=$row['id'];?>" userid="<?=$row['id'];?>" class="innertxt">
					<img src="<?php echo base_url();?>source/jquery_ui/images.jpg" width="75" height="75"><strong><?=$row['user_name'];?></strong>
					<ul style="margin-top:8px">
                    	<li>User ID: <?=$row['id'];?></li><br/>
                        <li>Email: <?=$row['email1'];?></li><br/>
                        <li style="padding-top:5px;"><input type="checkbox" id="select1" value="<?=$row['id'];?>" class="selectit" /><label for="select1">&nbsp;&nbsp;Select it.</label></li>
                    </ul>
                 </div>
                <div class="float_break"></div>
				<?php $i++;endforeach;?>
            </div>

            <div style="width:100px; text-align:center; margin-left:20px; padding-top: 100px; width:75px; float:left;">
           	<a href="javascript:void(0);" class="button" id="move_right">Right &raquo;</a><br /><br />
            <a href="javascript:void(0);" class="button" id="move_left">&laquo; Left</a>
            <div class="float_break"></div>
            </div>

            <div id="selected_users"></div>
             <div class="float_break"></div>
          </div>
          <div class="formbox">
            <input type="button" value="View Selected users Id" id="view" class="form_button"/>
          </div>
        </div>
    </div>
</form>
</body>
</html>
<script language="javascript">
	$(document).ready(function () {
		var usergroup = $('input[name=select2]:checked').val();
		userselect(usergroup);
		// Uncheck each checkbox on body load
		$('#all_users .selectit').each(function() {this.checked = false;});
		$('#selected_users .selectit').each(function() {this.checked = false;});

    	$('#all_users .selectit').click(function() {
			var userid = $(this).val();
			$('#user' + userid).toggleClass('innertxt_bg');
		});

		$('#selected_users .selectit').click(function() {
			var userid = $(this).val();
			document.getElementById('list2').value = userid;
			$('#user' + userid).toggleClass('innertxt_bg');
		});

		$("#move_right").click(function() {
			var users = $('#selected_users .innertxt2').size();
			var selected_users = $('#all_users .innertxt_bg').size();

			if (users + selected_users > 5) {
				alert('You can only chose maximum 5 users.');
				return;
			}
			$('#all_users .innertxt_bg').each(function() {
				var user_id = $(this).attr('userid');
				$('#select' + user_id).each(function() {this.checked = false;});

				var user_clone = $(this).clone(true);
				$(user_clone).removeClass('innertxt');
				$(user_clone).removeClass('innertxt_bg');
				$(user_clone).addClass('innertxt2');

				$('#selected_users').append(user_clone);
				$(this).remove();
			});
                        var usergroup = $('input[name=select2]:checked').val();
			var users = '';
			$('#selected_users .innertxt2').each(function() {
				var user_id = $(this).attr('userid');
				if (users == '')
					users += user_id;
				else
					users += ',' + user_id;
			});
                    var datas = $.ajax({
                    type:"POST",
                    url: "<?php echo site_url('mainmaster/useraccess/updateuser');?>",
                    data:{'groupid':usergroup,'userid':users,'isajax':true},
                    dataType:'json',
                    success:function(datas)
                    {
                        return true;
                    }
       		 });
		});

		$("#move_left").click(function() {
                    var val = [];
                    $('[name=select3]:checked').each(function(i) {
                      val[i] = $(this).val();
                    });
                    alert(val);
                    var datas = $.ajax({
                    type:"POST",
                    url: "<?php echo site_url('mainmaster/useraccess/removeuser');?>",
                    data:{'userid':users,'isajax':true},
                    dataType:'json',
                    success:function(datas)
                    {
                        return true;
                    }
       		 });
		});

		$('#view').click(function() {

		});
	});
        function userselect(groupid)
		 {
                         var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('mainmaster/useraccess/get');?>",
				data: {'groupid':groupid,'isajax':true},
				dataType:'json',
				success: function(datas) {
				}
			});
		 }

</script>