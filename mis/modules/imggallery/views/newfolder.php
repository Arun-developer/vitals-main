<form name="newfolder" action="<?php echo site_url('imggallery/example/add_newfolder')?>" method="post">
    <input type="hidden" name="path" value="<?=$path;?>"/>
	<label for="folder_name">Folder Name:</label>
    <input type="text" name="folder_name" size="20"/>
    <br/>
    <input type="submit" name="txtSubmit" class="button" value="Create"/>
</form>