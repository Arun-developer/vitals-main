<html>
    <div>
        <ul class="tabs">
		<li class="<?php echo($this->uri->segment('3') == 'useraccess')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/index')?>" >Add User Access</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'essusers')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/essusers')?>">Add Users</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'addgroup')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/adduser')?>">Add User Group</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'addadmin')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/addadmin')?>">Add Admin</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'pim')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/pim')?>">Add Employee</a></li>
		<li class="<?php echo($this->uri->segment('3') == 'fellow')?'selected':'';?>"><a href="<?=site_url('mainmaster/useraccess/fellow')?>">Add Fellow</a></li>
		</ul>
    </div><br/>
	<div>
	<a href="<?=site_url('mainmaster/useraccess/addfellow')?>" class="button">Add</a>
	<a href="<?=site_url('mainmaster/useraccess/delfellow')?>" class="button">Delete</a>
	</div><br/>
	<div id="user-grid" class="grid-view">
	<table class="gtable sortable">
	<thead>
	<tr style="margin-left:40px">
	<td>Fellow Id</td>
	<td>Fellow Name</td>
	</tr>
	</thead>
	<tbody>
	<?php foreach($fellowusers as $row):?>
	<tr>
	<td><?=$row['emp_number'];?></td>
	<td><?=$row['name'];?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
 </html>
