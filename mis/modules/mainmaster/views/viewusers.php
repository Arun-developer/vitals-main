<html>
<h1><?=$cpagetitle;?></h1>
<div align="right"><a href="<?=site_url('mainmaster/useraccess/index')?>" class="button">Back</div>
<div>
<table class="gtable">
<thead>
<tr>
<th>User Group</th>
<th>User Name</th>
<th>Action</th>
</tr> 
</thead>
<tbody>
<?php foreach($grouplist as $row) { ?>
<tr>
     <td><?=$row['userg_id'];?></td>
	 <td><?=$row['user_name'];?></td>
	 <td><a href="<?=site_url('mainmaster/useraccess/removeuser/'.$row['id'])?>">Remove</a></td>
</tr>
<?php } ?>

</tbody>
</table>
</div>
</html>