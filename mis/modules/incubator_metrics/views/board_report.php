<h1><?=$cpagetitle?> </h1>
<table class="gtable">
    <thead>
        <tr>
            <td>Total</td>
            <td>Accept</td>
            <td>Reject</td>
        </tr>
    </thead>
    <tbody>        
    <?php foreach($board_report as $row):?>
        <tr>
            <td><?=$row['total'];?></td>
            <td><?=$row['accept'];?></td>
            <td><?=$row['reject'];?></td>
        </tr>
      <?php endforeach;?>
    <!-- end id-form  -->
    </tbody>
</table>
