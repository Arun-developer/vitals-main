<h2><?=$cpagetitle;?></h2>
<table class="gtable">
<thead>
<tr>
<th>Master Type</th>
<th>Master Name</th>
<th>Field</th>
<th>Description</th>
<th>Documents</th>
<th>Options</th>
</tr>
</thead>
<tbody>
<?php foreach($assessmentdocument as $row)
{?>
<tr>	
<td><?=($row['master_type'] == 'm1') ? 'Assessment' : $row['master_type'] == 'm2' ? 'Document Validation' : 'External Validation';?></td>
<td><?=$row['master_name'];?></td>
<td><?=$row['label'];?></td>
<td><?=$row['answer'];?></td>
<td><?=$row['documents'];?></td>
<td><a href="<?=site_url('screening/editassessdoc/'.$innovation.'/'.$row['id'])?>"><img src="<?=base_url();?>source/template/images/icons/edit.png"/></a></td>
</tr>
<?php } ?>
</tbody>
</table>