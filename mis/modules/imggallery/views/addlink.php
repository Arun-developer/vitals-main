<h1><?=$cpagetitle;?></h1>
<form name="videoform" action="<?=site_url('imggallery/addvideo')?>" method="post">
<table>
<tr>
<td>Name:</td>
<td><input type="text" name="name" value=""/><br /></td>
</tr>
<tr>
<td>URL Link:</td>
<td><input type="text" name="urllink" value=""/><br />
</td>
</tr>
<tr>
<Td><input type="submit" class="button" name="submit" value="submit"/></Td>
</tr>
</table>
</form>
