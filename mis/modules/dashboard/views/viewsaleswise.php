<html>
<div class="table_section ">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td class="table_BG45"><table  class="gtable" width="100%" border="1" cellspacing="1" cellpadding="0">
      <tr>
          <td width="14%" class="table_HEADER">Service</td>
          <?php foreach($years as $rw):?>
              <td width="14%" class="table_HEADER"><?=$rw['YEAR'];?></td>
          <?php endforeach; ?>
      </tr>
      <?php for($i=0;$i<php72_count($salesreport);$i++)
      {
        ?>
      <tr>
          <td><?=$salesreport[$i]['NAME_OF_ENTERPRISE'];?></td>
          <?php foreach($years as $key=>$value){?>

                <?php if($salesreport[$i]['YEAR']==$value['YEAR'])
                { ?>

                <td><?=$salesreport[$i]['TOTAL'];?></td>
          <?php }  else
          {?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
          <?php } } ?>
           </tr>
      <?php }?>

    </table></td>
  </tr>
</table>
</div>
</html>
