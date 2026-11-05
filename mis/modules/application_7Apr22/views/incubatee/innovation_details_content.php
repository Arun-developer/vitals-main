<?php
foreach ($innovationDetails as $row):
?>
<h2><?=$row['name_of_enterprise']?></h2>

<div id="user-grid" class="grid-view">
    <table width="100%" class="items" bgcolor="#F5F5F5" cellspacing="2" cellpadding="2">
        <thead>
            <tr>
                <th colspan="2"><?=$row['name_of_enterprise']?></th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd">
                <td style="width:40%">Innovation Id </td>
                <td><?=$row['innovation_id']?></td>
            </tr>
            <?php if ($row['source_name'] != '') {?>
            <tr class="even">
                <td>Source Type</td>
                <td><?=$row['source_type']?></td>
            </tr>
            <tr class="odd">
                <td>Source</td>
                <td><?=$row['source_name']?></td>
            </tr>
            <tr class="even">
                <td>Instance</td>
                <td><?=$row['instance_name']?></td>
            </tr>
            <?php }?>
            <tr class="odd">
                <td>Name of the Promoter</td>
                <td><?=$row['name_of_entrepreneur']?></td>
            </tr>
            <tr class="even">
                <td>Phone Number</td>
                <td><?=$row['phone_no']?></td>
            </tr>
            <tr class="odd">
                <td>Mobile Number</td>
                <td><?=$row['mobile_no']?></td>
            </tr>
            <tr class="odd">
                <td>Email Address</td>
                <td><?=$row['email_id']?></td>
            </tr>
            <tr class="even">
                <td>Address Line1</td>
                <td><?=$row['address_line1']?></td>
            </tr>
            <tr class="odd">
                <td>Address Line1</td>
                <td><?=$row['address_line2']?></td>
            </tr>

            <tr class="even">
                <td>City</td>
                <td><?=$row['city']?></td>
            </tr>
            <tr class="odd">
                <td>District</td>
                <td><?=$row['district']?></td>
            </tr>
            <tr class="even">
                <td>State</td>
                <td><?=$row['state']?></td>
            </tr>
            <tr class="odd">
                <td>Country</td>
                <td><?=$row['country']?></td>
            </tr>
            <tr class="even">
                <td>Pin Code</td>
                <td><?=$row['pincode']?></td>
            </tr>

            <tr class="odd">
                <td>Name of your Entreprise</td>
                <td><?=$row['name_of_enterprise']?></td>
            </tr>
            <tr class="even">
                <td>Website(If available)</td>
                <td><a href=" <?=$row['website']?>" target="_blank">
                        <?=$row['website']?>
                    </a></td>
            </tr>

            <tr class="odd">
                <td>A Short Summary of your Business.
                    What Product / services do your offer? </td>
                <td><?=nl2br($row['summary_of_business']);?></td>
            </tr>
            <tr class="even">
                <td>For how long have you been in operation?</td>
                <td><?=$row['entreprise_years']?></td>
            </tr>
            <tr class="odd">
                <td>Do you Have a Business Plan ? </td>
                <td><?=$row['business_plan']?></td>
            </tr>
            <?php if ($row['business_plan_document'] != "") {?>
            <tr class="odd">
                <td>Business Plan Document</td>
                <td>
                    <?=$row['business_plan_document']?>

            </tr>
            <?php }?>


            <?php if ($row['reference'] != '') {?>
            <tr class="even">
                <td>Reference</td>
                <td><?=$row['reference']?></td>
            </tr>
            <?php }
if ($row['other_reference'] != '') {
    ?>
            <tr class="odd">
                <td>Other Reference</td>
                <td><?=$row['other_reference']?></td>
            </tr>
            <?php
}
?>
            <tr class="even">
                <td>Applied Date </td>
                <td><?=mysql2date($row['created_date'])?></td>
            </tr>
            <tr class="odd">
                <td>Identified by </td>
                <td><?=$row['created_emp']?></td>
            </tr>

            <tr class="even">
                <td>Last Modified</td>
                <td><?=mysql2date($row['modified_date'])?></td>
            </tr>
            <tr class="odd">
                <td>Modified By</td>
                <td><?=$row['modified_emp']?></td>
            </tr>


        </tbody>
    </table>
    <?php
endforeach;
?>
</div>