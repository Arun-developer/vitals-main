<html>

<head>
    <title>Bulk Innovation</title>
</head>

<body>

    <form action="<?php echo site_url('scouting/bulk_innovation');?>" method="post" enctype="multipart/form-data" />
    <table width="400px" height="100px" cellpadding="5">
        <tbody>
            <tr>
                <td style="margin-left:20px;"><input type="file" name="inno_file" required /></td>
                <td><input type="submit" name="ImportFile" value="submit" class="button" /></td>
            </tr>
        </tbody>
    </table>
    </form>
</body>

</html>