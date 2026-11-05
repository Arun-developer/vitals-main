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
			<th>Date</th>
			<th>Name Of Visitor</th>
			<th>Name Of Organization</th>
			<th>Intending To Meet</th>
			<th>Purpose</th>
			<th>Time In</th>
			<th>Time Out</th>
			<th>Innovation</th>
		</thead>
		<tbody>
			<?php 
			$i = 1;
        foreach ($visitorsList as $list) {

            ?>
            <tr>
            <td><?= $list['date']; ?></td>
            <td><?= $list['name_of_visitor']; ?></td>
            <td><?= $list['name_of_organization']; ?></td>
            <td><?= $list['user_name']; ?></td>
            <td><?= $list['purpose']; ?></td>
            <td><?= $list['time_in']; ?></td>
            <td><?= $list['time_out']; ?></td>
            <td><?= $list['innovation']; ?></td>
             </tr>
            <?php
            $i++;
        }
			 ?>
			
			
		</tbody>
	</table>

	
</body>

</html>