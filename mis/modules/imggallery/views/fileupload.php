<html>
<div> 
  <form enctype="multipart/form-data" action="<?=site_url('imggallery/example/upload')?>" method="POST">
	<input type="hidden" name="path" value="<?=$path;?>"/>
	Choose a file to upload: <input name="item_file" type="file" /><br />
	<input type="submit" value="Upload File" />
  </form>
</div>
</html>
