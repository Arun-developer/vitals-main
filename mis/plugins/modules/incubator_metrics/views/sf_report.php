<h1><?=$cpagetitle?> </h1>
<table class="gtable">
    <thead>
        <tr>
            <td>Approved Amount</td>
            <td>Total Fund Disbursed</td>
            <td>Total Fund Utilized</td>
        </tr>
    </thead>
    <tbody>        
    <?php foreach($seedfunding_report as $row):?>
        <tr>
            <td>
                <?=$row['approved_amount'];?>
            </td>
            <td><?=$row['amount'];?></td>
            <td><?=$row['fund_utilized'];?></td>
        </tr>
      <?php endforeach;?>
    <!-- end id-form  -->
    </tbody>
</table>
