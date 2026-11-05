<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<div style="height: 600px;overflow:scroll">
<table class="gtable sorttable">
	<thead>
		<tr>
            <th>Label</th>
            <th>Answer</th>
		</tr>
	</thead>
	<tbody id="activitiesTable">
    
    	 <?php  
		  $i=0;
		  $j=1;
	  if(php72_count($answerList))
	  {
		 $key1 = 0;  
		 $na="";
		 $key2 =0;
		 $label="NULL";
		  foreach($answerList as $row)
		  {
		   $na_new = $row['master_type'];
	       if($na_new != $na)
	       {
		    $na = $na_new;
		    $key1 = 0;
			?>
			 <tr><td colspan="3"><h2><a><?php echo $row['master_type'];?></a></h2></td></tr>
       <?php } ?>
		       
            <tr>
			<?php 
			$label = $answerList[$i]['label'];  ?>
			<td align="left" valign="middle"><?=$label?></td>
			<td align="left" valign="middle"><?=$answerList[$i]['answer'];?></td>
			
       		
            <?php $i++;$j++;
		  }		
			?>
            </tr>
            <?php
	  }
	else
	{ ?>
		<tr>
		<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?php
	} ?>
	
	</tbody>
	</table>
    </div>
</body>
</html>