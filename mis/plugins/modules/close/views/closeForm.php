<html>
<head>
<title>Close Form</title>
</head>
<body>

<form action="<?php echo site_url('close/rejection'); ?>" method="post" enctype="multipart/form-data" />
	<table width="400px" height="100px" cellpadding="5">
		<tbody>
			<tr><td style="margin-left:20px;"><input type="file" name="close_file" required /></td>
			<td><input type="submit" name="ImportFile" value="submit" class="button"/></td></tr>
		</tbody>
	</table>
	</form>
</body>
</html>