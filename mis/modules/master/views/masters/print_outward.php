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
			<th>Dispatch Date</th>
			<th>Person's Name</th>
			<th>Company's Name</th>
			<th>City</th>
			<th>State</th>
			<th>Pincode</th>
			<th>Content</th>
			<th>Status</th>
			<?php
			if($tab == 'confirmed'){
			?>
			<th>Consignment No</th>
			<th>Sent Date</th>
			<th>Vendor</th>
			<?php } ?>
		</thead>
		<tbody>
			<?php 
			$i = 1;
        foreach ($outwardList as $list) {

$username = $this->Mmaster->getUserNameInfo($list['employee_id']);

            ?>
            <tr>
            <td><?= $username[0]['user_name']; ?></td>
            <td><?= $list['dispatch_date']; ?></td>
            <td><?= $list['person_name']; ?></td>
            <td><?= $list['company_name']; ?></td>
            <td><?= $list['city']; ?></td>
            <td><?= $list['state']; ?></td>
            <td><?= $list['pincode']; ?></td>
            <td><?= $list['content']; ?></td>
            <td><?= $list['status']; ?></td>
            <?php
            if($tab == 'confirmed'){
            	?>
            <td><?= $list['consignment_no']; ?></td>
            <td><?= $list['sent_date'] ?></td>
            <td><?= $list['vendor'] ?></td>
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