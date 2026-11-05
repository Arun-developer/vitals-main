<h1><?=$cpagetitle?> </h1>
<table class="gtable">
    <thead>
        <tr>
            <td>Year</td>
            <td>Total</td>
            
        </tr>
    </thead>
    <tbody>        
    <?php foreach($progress_report as $row):?>
        <tr>
            <td><?=$row['year'];?></td>
            <td><?=$row['answer'];?></td>
            
        </tr>
      <?php endforeach;?>
    <!-- end id-form  -->
    </tbody>
</table>
