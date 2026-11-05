<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>

    <title></title>

    <link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/stylesheet.css">
    </link>

</head>

<body>

    <table style="width:967px;margin-left: 185px;">
        <tr>
            <td> <img src="<?php echo base_url();?>source/template/images/logo.gif" alt="Profile Photo" height="110"
                    width="259" /></td>
        </tr>
    </table>

    <?php echo  "<h2 align='center'>".$pageTitle."</h2>";echo $htmView;  ?>
    <hr />


    <table style="width:967px;" class="footerTable">

        <tr>

            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td style="color:grey;margin-top: 20px;font-size: 10px;" align="right">All Rights Reserved. Villgro.org
            </td>
            <td> </td>
            <td style="padding-left: 160px;font-size: 10px;"><?php echo date('d-M-Y');?> </td>



        </tr>

    </table>



</body>

</html>