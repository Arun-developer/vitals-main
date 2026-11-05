<h1>Month Wise Report</h1>
<table class="gtable">
    <?php $na=''; foreach($month_report as $row):
        $na_new = $row['month'];
        if($na != $na_new)
        {
            $na = $na_new;
    ?>
    <tr><td><h2><?=$row['month'];?></h2></td></tr>
    <tr>
        <td><b>Target</b></td>
        <td><b>Achieved</b></td>
    </tr>
    <?php } ?>
    <tr>
        <td><?=$row['target'];?></td>
        <td><?=$row['achieved'];?></td>
    </tr>
    <?php  endforeach;?>
</table>



