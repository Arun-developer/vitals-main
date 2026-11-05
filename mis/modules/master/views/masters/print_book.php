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
			<th>SNo</th>
			<th>Category Name</th>
			<th>Book Number</th>
			<th>Book Name</th>
			<th>Author</th>
		</thead>
		<tbody>
			<?php 
			$i = 1;
        foreach ($booklist as $list) {

            ?>
            <tr>
            <td><?= $list['book_id']; ?></td>
            <td><?= $list['master_name']; ?></td>
            <td><?= $list['book_number']; ?></td>
            <td><?= $list['book_name']; ?></td>
            <td><?= $list['author']; ?></td>
             </tr>
            <?php
            $i++;
        }
			 ?>
			
			
		</tbody>
	</table>

	
</body>

</html>