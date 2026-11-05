<?php $form_name = "old_innovation"; ?>
<html>

<head>
    <style>
    fieldset {
        padding: 1em;
        font: 80%/1 sans-serif;
    }

    label {
        float: left;
        margin-right: 0.5em;
        padding-top: 0.2em;
        text-align: right;
        font-weight: bold;
    }
    </style>
    <script type="text/javascript">
    function TableToExcel() {
        var strCopy = document.getElementById("MyTable").innerHTML;
        window.clipboardData.setData("Text", strCopy);
        var objExcel = new ActiveXObject("Excel.Application");
        objExcel.visible = true;

        var objWorkbook = objExcel.Workbooks.Add;
        var objWorksheet = objWorkbook.Worksheets(1);
        objWorksheet.Paste;
    }
    $(document).ready(function() {
        $("#btnExport").click(function(e) {
            window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
            e.preventDefault();
        });
    });
    </script>
</head>
<ul class="tabs">
    <li class="selected"><a href="<?=site_url('scouting/old_innovation')?>">Fy 11-12</a></li>
    <li><a href="<?=site_url('scouting/old_innovations')?>">Fy 09-10</a></li>
    <li><a href="<?=site_url('scouting/oldinnovation')?>">Fy 05-08</a></li>

</ul>
<form id="<?=$form_name?>" action="<?=site_url('scouting/old_innovation/')?>" method="post" name="<?=$form_name?>"
    class="searchForm">
    <fieldset>
        <legend>Search Options</legend>
        <dl class="inline">
            <dt><label for="name_of_enterprise">Name of the Enterprise</label></dt>
            <dd>
                <?php $name_of_enterprise = isset($_REQUEST["name_of_enterprise"])?$_REQUEST["name_of_enterprise"]:'';   ?>
                <input type="text" value="<?=$name_of_enterprise?>" name="name_of_enterprise" class="input-text" />
            </dd>
            <dt><label for="summary_of_business">Summary of the Business</label></dt>
            <dd>
                <?php $summary_of_business = isset($_REQUEST["summary_business"])?$_REQUEST["summary_business"]:'';   ?>
                <input type="text" value="<?=$summary_of_business;?>" name="summary_business" class="input-text" />
            </dd>
            <dt><label for="website">Website</label></dt>
            <dd>
                <?php $website = isset($_REQUEST["website"])?$_REQUEST["website"]:'';   ?>
                <input type="text" value="<?=$website;?>" name="website" class="input-text" />
            </dd>
            <dt><label for="name_of_entrepreuner">Name of the Entrepreuner</label></dt>
            <dd>
                <?php $name_of_entrepreneur = isset($_REQUEST["name_of_entrepreneur"])?$_REQUEST["name_of_entrepreneur"]:'';   ?>
                <input type="text" value="<?=$name_of_entrepreneur;?>" name="name_of_entrepreneur" class="input-text" />
            </dd>
            <dt><label for="status">Status</label></dt>
            <dd>
                <?php $status = isset($_REQUEST["status"])?$_REQUEST["status"]:'';   ?>
                <select name="status">
                    <option value="">Select</option>
                    <option value="rejected" <?php echo ($status == 'rejected') ? 'selected="selected"' : ''; ?>>
                        Rejected</option>
                    <option value="Follow up" <?php echo ($status == 'Follow up') ? 'selected="selected"' : ''; ?>>
                        Follow up</option>
                    <option value="Response" <?php echo ($status == 'Response') ? 'selected="selected"' : ''; ?>>
                        Response</option>
                    <option value="Hold" <?php echo ($status == 'Hold') ? 'selected="selected"' : ''; ?>>Hold</option>
                </select>
            </dd>
            <dd>
                <input type="submit" class="button" name="txtSubmit" value="Search" />
                <input type="reset" class="button" name="txtSubmit" value="reset" /></dd>
        </dl>
    </fieldset>
</form>
<br />
<span id="MyTable">
    <table class="gtable" cellpadding="10" cellspacing="12">
        <thead>
            <tr>
                <td style="width:3%">S.no</td>
                <td style="width:10%">Name of the Promoter</td>
                <td style="width:10%">Name of Enterprise</td>
                <td style="width:10%">Phone Number</td>
                <td style="width:20%">Summary</td>
                <td style="width:20%">Business Plan</td>
                <td style="width:20%">Email Address</td>
                <td style="width:20%">Website</td>
                <td style="width:20%">Status</td>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
foreach($innovationlist as $row):?>
            <tr>
                <td><?=$row['id'];?></td>
                <td style="width:10%"><?=$row['Name of the Promoter'];?></td>
                <td style="width:10%"><?=$row['Name of your Enterprise'];?></td>
                <td style="width:8%"><?=$row['Phone Number'];?></td>
                <td style="width:15%"><?php
$overflow = (strlen($row['Summary']) > 60 ? true : false);
echo substr($row['Summary'], 0, 60) . ($overflow === true ? "..." : '');
?></td>
                <td style="width:15%"><?=$row['Do you have a Business Plan ?'];?></td>
                <td style="width:15%"><?=$row['Email Address'];?></td>
                <td style="width:15%"><?=$row['Website'];?></td>
                <td style="width:15%"><?=$row['Status'];?></td>
            </tr>
            <?php $i++; endforeach;?>
        </tbody>
    </table>
</span>

<?php

echo  $this->pagination->create_links($form_name);
?>

</html>