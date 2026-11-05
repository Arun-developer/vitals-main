<html>
<form name="form1" action="<?=site_url('master/mailtemplate/writehrismail')?>" method="POST">
<input type="hidden" name="filename" value="<?=$filename;?>"/>
<input type="hidden" name="foldername" value="<?=$foldername;?>"/>
<table cellpadding="5" cellspacing="10">
<tbody>
<tr>
<td>Subject:</td>
<td><input type="text"  size="50"  name="subject" id="subject" value="<?=$mail['subject'];?>"></td></tr>

<tr>
<td>Body:</td>
<td><textarea name="body" class="input-text" id="editor"  style="height:360px;" cols="100" ><?=$mail['body'];?></textarea></td></tr>
</tbody>
</table>
<div class="buttons">
<input type="submit" name="Save" class="button" id="Save"/>
<input type="reset" name="Reset" class="button" id="Reset"/>
</div>
</form>
</html>