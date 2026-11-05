<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$header;?></title>
<base href="<?=base_url();?>" />
<link rel="stylesheet" href="<?= base_url();?>source/jquery_ui/css/south-street/style.css" type="text/css" media="screen" charset="utf-8" />
</head>

<body>
  <div id="container">
<div id="navcontainer">
<ul>
<li><?php echo anchor('calendar/create', 'Add Events');?> </li>
<li><?php echo anchor('calendar/showevents', 'Show Events');?></li>

</ul>
</div>
<div id="header">
    
    <br/>
  <?php 
  	foreach ($dayevents as $dayevent){
        echo "<table>";
  		echo "<tr><div class=\"dayevents\">";
  		echo "<td><h3>Event date: </h3></td>";
  		echo "<td>".$dayevent['eventDate']."<td></tr>";
  		echo "<br />\n";
  		echo "<td><h3>Event Title: </h3></td>";
  		echo "<td>".$dayevent['eventTitle']."<td></tr>";
  		echo "<br />\n";
  		echo "<td><h3>Event Content: </h3></td>";
  		echo "<td>".$dayevent['eventContent']."<td></tr>";
  		echo "</div></table>";
    }
  	
  
  ?>

 </div>
  </div>

 </body>
</html>