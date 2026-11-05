<html>
    <h2><?=$cpagetitle;?></h2>
<div class="table_section ">

          <table class="gtable" width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td class="table_BG45"><table width="100%" border="1" cellspacing="1" cellpadding="0">
      <tr>
          <td width="14%">Service</td>
        <td width="14%"><?=$year;?></td>
        
      </tr>
      <?php for($i=4;$i<11;$i++){?>
      <tr>
          <td class="table_down"><?=$serviceoffering['title_'.$i]?></td>
            <td class="table_down"><?=$serviceoffering['total'.$i];?></td>
      </tr>
      <?php }?>
    </table></td>
  </tr>
</table>
</div>
</html>
