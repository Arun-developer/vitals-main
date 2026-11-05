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
			<th>Asset Type</th>
			<th>Asset Number</th>
			<th>Asset Name</th>
			<th>Asset Code</th>
                  <?php if($tab == 'general'){ ?>
                  <th>Description</th>
            <?php } else { ?>
			<th>Brand Name</th>
			<th>Model</th>
			<th>Serial Number</th>
            <?php } ?>
			<th>Purchase Date</th>
			<th>Price</th>
			<th>Bill Number</th>
			<th>Bill Date</th>
                  <th>Warranty</th>
                  <th>Vendor</th>
                  <th>AMC</th>
                  <th>AMC Vendor</th>
                  <th>AMC Period</th>
                  <th>Available Status</th>
		</thead>
		<tbody>
			<?php 
			$i = 1;
        foreach ($assetlist as $list) {

            ?>
            <tr>
            <td><?= $i; ?></td>
            <td><?= $list['asset_id']; ?></td>
            <td><?= $list['master_name']; ?></td>
            <td><?= $list['asset_no']; ?></td>
            <td><?= $list['asset_name']; ?></td>
            <td><?= $list['asset_code']; ?></td>
                  <?php if($tab == 'general'){ ?>
            <td><?= $list['description']; ?></td>
      <?php } else { ?>
            <td><?= $list['brand_name']; ?></td>
            <td><?= $list['model']; ?></td>
            <td><?= $list['serial_no']; ?></td>
      <?php } ?>
            <td><?= $list['purchase_date']; ?></td>
            <td><?= $list['price']; ?></td>
            <td><?= $list['bill_no']; ?></td>
            <td><?= $list['bill_date']; ?></td>
            <td><?= $list['warrenty_expiry_date']; ?></td>
            <td><?= $list['vendor_name']; ?></td>
            <td><?= $list['AMC']; ?></td>
            <td><?= $list['AMC_vendor']; ?></td>
            <td><?= $list['AMC_period']; ?></td>
            <td><?= $list['available_status']; ?></td>
            </tr>
            <?php
            $i++;
        }
			 ?>
			
			
		</tbody>
	</table>

	
</body>

</html>