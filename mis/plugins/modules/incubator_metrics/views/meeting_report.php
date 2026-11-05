<h1><?=$cpagetitle ?>-<?=$year?> </h1>
<table class="gtable" width="auto" cellspacing="3" cellpadding="4">
<thead>
<tr>
<th style="background:#74AD5A !important;">Label:</th>
<?php foreach($quarterly as $quarters):
?>
<th style="background:#74AD5A !important;">Q<?php echo $quarters;?></th>
<?php endforeach; 
?>
</tr>
</thead>
    <tbody>        
    <?php 
	$tmdata['count'] = '';
	$tick  = "<img src='".base_url()."source/template/images/icons/tick.png'  />";
	$wrong = "<img src='".base_url()."source/template/images/icons/wrong.gif'  />";
	for($i=0;$i<count($quartermeeting);$i++)
	{
	   if($quartermeeting[$i][0]['id'] != '0')
	   {
	   		$tmdata['count'] .= "<td><a href='".base_url()."index.php/boardmeeting/view_list/488/view/'>".$tick."</td></a>";	
	   }
	   else
	   {
	   		$tmdata['count'] .= "<td><a href='".base_url()."index.php/boardmeeting/view/488/edit/edit'>".$wrong."</td></a>";
	   }
	   
	}
echo '<tr>';
echo '<td>Total</td>'.$tmdata['count'];
echo '</tr>';
      ?>
    <!-- end id-form  -->
   </tbody>
</table>
