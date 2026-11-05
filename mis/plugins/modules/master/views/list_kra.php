<h1>KRA Sheet</h1>
<table class="gtable">
    <thead>
        <tr>
            <td><b>KRA</b></td>
            <td><b>KPI</b></td>
            <td><b>FROM DATE</b></td>
            <td><b>TO DATE</b></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($kra_list as $row):?>
        <tr>
        <td><?=$row['kra'];?></td>
        <td><?=$row['kpi'];?></td>
        <td><?=$row['from_date'];?></td>
        <td><?=$row['to_date'];?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
