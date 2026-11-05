<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script> 

<script type="text/javascript" src="<?=base_url();?>source/template/javascripts/top_up-min.js"/>
<link rel="stylesheet" href="<?=base_url();?>source/template/stylesheets/style.css"/>
<link rel="stylesheet" href="<?=base_url();?>source/template/stylesheets/example.css"/>

<h2><?=$cpagetitle;?></h2>
<form method="post" action="<?php echo site_url('imggallery/example/searchkeyword')?>" id="search">
  	<input name="q"  type="text" size="40" placeholder="Search..." />
</form>
<div align="right">
<input type="hidden" id="url" value="<?=$folder->url?>"/>
	<a href=""><img src="<?php echo base_url();?>source/template/images/file_add.png" height="30" width="35" title="Upload"/></a>&nbsp;&nbsp;
	<a href=""><img src="<?php echo base_url();?>source/template/images/folder-new.png" height="30" width="35" title="New Folder"/></a>&nbsp;&nbsp;
	<a href=""><img src="<?php echo base_url();?>source/template/images/GetOpenContent.gif" height="30" width="35" title="Get Link"/></a>&nbsp;&nbsp;
	<a href=""><img src="<?php echo base_url();?>source/template/images/edit_delete.png" height="30" width="35" title="Show Delete Information"/></a>
</div>
<div align="center">
		<video width="800" height="600" autoplay="true" controls="controls">
  <source src="<?php echo $folder->url;?>" type="video/mp4" />
  <source src="<?php echo $folder->url;?>" type="video/webm" />
  <source src="<?php echo $folder->url;?>" type="video/ogg" />
Your browser does not support the video tag.
</video>
</div>