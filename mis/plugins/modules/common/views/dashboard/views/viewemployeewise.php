<html>
    <h2><?=$cpagetitle;?></h2>
<div class="table_section ">

          <table class="gtable" width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td class="table_BG45"><table width="100%" border="1" cellspacing="1" cellpadding="0">
      <tr>
          <td width="14%">Employee</td>
        <td width="14%"><?=$year;?></td>
      </tr>
      <?php foreach($employeewise as $row):?>
      <tr>
          <td class="table_down"><?=$row['emp_name'];?></td>
        <td class="table_down"><?=$row['total'];?></td>
      </tr>
      <?php endforeach;?>
    </table></td>
  </tr>
</table>
</div>
</html>
