
<h2><?=$cpagetitle;?></h2>
<div class="table_section ">
<table class="gtable" width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td class="table_BG45"><table width="100%" border="1" cellspacing="1" cellpadding="0">
      <tr>
          <td width="14%" style="font-weight:bold;">Employee</font></td>
          <td width="14%" style="font-weight:bold;">Hours Spend</font></td>
      </tr>
	 
		<?php foreach($projectemp as $row) 
		{ ?>
		   <tr>
			   <td> <?php echo $row['emp_firstname']; ?> </td>
			   <td> <?php echo ceil($row['total']); ?> </td>
		   </tr>  
 <?php } ?>
        
 
      
    </table></td>
  </tr>
</table>
</div>

