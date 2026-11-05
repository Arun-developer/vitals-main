<h2 style="font-family:Gill !important;"><?=$cpagetitle?> </h2>
<div id="cssform">
    <?php
$formAction = site_url('scouting/new_innovation_import/add');
	if (isset($action))
	{
		if (isset($errormsg) && $action == "add")
		{
			echo("<div class=\"errorMsg\">" . $errormsg . "</div>");
		}
	}
	?>
    <div align="right">
        <a height="200" class="button fancybox" style="display:inline;" href="#openformat" id="open_format">View CSV
            Format</a>
        <a href="<?php echo base_url();?>uploads/csv_format.csv" style="display:inline;" class="button"
            id="down_format">Download CSV Format</a>
    </div>
    <form name="new_innovation" action="<?=$formAction;?>" enctype="multipart/form-data" method="post"
        id="new_innovation_import" class="uniform">

        <dl class="inline">
            <dt><label for="card" style="cursor:'alias' !important;">CSV file</label></dt>
            <dd>
                <input type="file" name="card" id="card" class="required" />
            </dd>
        </dl>
        <div class="clear"></div>
        <div class="buttons">
            <button type="submit" class="button" name="submit" value="Submit">Submit</button>
            <a href="<?php echo site_url('scouting/new_innovation'); ?>" class="button">back</a>
        </div>

    </form>
    <div style="display:none;">
        <div id="openformat">
            <h2>CSV Format</h2>
            <table border="1" class="gtable">
                <tr>
                    <td>Column 1 </td>
                    <td>source type</td>
                </tr>
                <tr>
                    <td>Column 2 </td>
                    <td>source</td>
                </tr>
                <tr>
                    <td>Column 3 </td>
                    <td>instance</td>
                </tr>
                <tr>
                    <td>Column 4 </td>
                    <td>name_of_the_entrepreuner</td>
                </tr>
                <tr>
                    <td>Column 5 </td>
                    <td>phone_no</td>
                </tr>
                <tr>
                    <td>Column 6 </td>
                    <td>mobile_no</td>
                </tr>
                <tr>
                    <td>Column 7 </td>
                    <td>email_id</td>
                </tr>
                <tr>
                    <td>Column 8 </td>
                    <td>address_line1</td>
                </tr>
                <tr>
                    <td>Column 9 </td>
                    <td>address_line2</td>
                </tr>
                <tr>
                    <td>Column 10 </td>
                    <td>city</td>
                </tr>
                <tr>
                    <td>Column 11 </td>
                    <td>district</td>
                </tr>
                <tr>
                    <td>Column 12 </td>
                    <td>state</td>
                </tr>
                <tr>
                    <td>Column 13 </td>
                    <td>country</td>
                </tr>
                <tr>
                    <td>Column 14 </td>
                    <td>pincode</td>
                </tr>
                <tr>
                    <td>Column 15 </td>
                    <td>name_of_enterprise</td>
                </tr>
                <tr>
                    <td>Column 16 </td>
                    <td>website</td>
                </tr>
                <tr>
                    <td>Column 17 </td>
                    <td>summary_of_the_business</td>
                </tr>
                <tr>
                    <td>Column 18 </td>
                    <td>enterprise_years</td>
                </tr>
            </table>
        </div>
    </div>
</div>