<html>
<head>
<style>

		table {
			font-family: Helvetica, Arial, sans-serif;
			font-size: 13px;	
			width: 100%;
   border-collapse: collapse;
   table-layout: fixed;		
		}
		td{
overflow-wrap: break-word; 
word-wrap: break-word;
word-break: break-all;
}
body, p, li, td, table, tr, .bodytext, .stepfield {
	overflow-wrap: break-word; 
word-wrap: break-word;
word-break: break-all;
}
	</style>
</head>
<body id="pr_body">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<thead>
			<th>Employee</th>
			<th>Received Date</th>
			<th>Person's Name</th>
			<th>Company's Name</th>
			<th>Content</th>
			<th>Vendor</th>
			<th>Status</th>
			<?php
			if($tab == 'confirmed'){
			?>
			<th>Handover To</th>
			<th>Handover Date</th>
			<?php } ?>
		</thead>
		<tbody>
			<?php 
			$i = 1;
        foreach ($inwardList as $list) {

$username = $this->Mmaster->getUserNameInfo($list['employee_id']);
if($tab == 'confirmed'){
$handoverto = $this->Mmaster->getUserNameInfo($list['handover_to']);
}
            ?>
            <tr>
            <td><?= $username[0]['user_name']; ?></td>
            <td><?= $list['received_date']; ?></td>
            <td><?= $list['person_name']; ?></td>
            <td><?= $list['company_name']; ?></td>
            <td><?= $list['content']; ?></td>
            <td><?= $list['vendor']; ?></td>
            <td><?= $list['status']; ?></td>
            <?php
            if($tab == 'confirmed'){
            	?>
            <td><?= $handoverto[0]['user_name']; ?></td>
            <td><?= $list['handover_date'] ?></td>
        <?php } ?>
             </tr>
            <?php
            $i++;
        }
			 ?>
			
			
		</tbody>
	</table>

	
</body>

</html>