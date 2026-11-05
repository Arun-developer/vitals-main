<html>
<h2><?=$cpagetitle;?></h2>
<div class="table_section ">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="table_BG">
         <table id="tabl" class="gtable" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr style="background:#4D4D4B;color:#fff;">
        <td class="table_HEADER" >&nbsp;</td>
        <?php foreach($stage as $key=>$value):?>
        <td width="10%" class="table_HEADER" style="color:#fff;"><?=$value;?></td>
        <?php endforeach; ?>
      </tr>
      <?php for($i=0;$i<count($stagewise);$i++)
      {
        ?>
      <tr>
	  <?php if(count($yearly) == 7) {
	  	 ?>
          <td  class="table_down"><?=$yearly[$i];?></td>
		  <?php } else {?>
		  	 <td class="table-down"><?=$yearly;?></td>
		  <?php } ?>
          <?php foreach($stage as $key=>$value){?>
		  

                <?php if($stage[$stagewise[$i]['stage']]==$value)
                { ?>

                <td class="table_down"><?=$stagewise[$i]['value'];?></td>
          <?php }  else
          {?>
                <td class="table_down">0</td>

          <?php } } ?>
           </tr>
      <?php }?>

    </table>
	</td>
  </tr>
</table>

        </div>
</html>
