
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
<img align="center" src="<?php echo $folder->url;?>" height="600" width="800"/>