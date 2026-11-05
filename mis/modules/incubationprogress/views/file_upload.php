<form action="<?php echo site_url('incubationprogress/fileupload/'.$innovation)?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="year" value="<?=$year?>"/>
<input type="hidden" name="month" value="<?=$month?>"/>
<input type="hidden" name="criteria" value="<?=$criteria?>"/>
<input type="hidden" name="field" value="<?=$field?>"/>
<input type="hidden" name="type" value="<?=$type?>"/>
<input type="hidden" name="innovation" value="<?=$innovation?>"/>
<input type="hidden" name="frequency" value="<?=$frequency?>"/>
      <table align="center" cellpadding="4" cellspacing="0" bgcolor="#EDEDED">	
		<tr class="tblSubHead">
			<td colspan="2">Upload any number of file</td>
		</tr>
		<tr class="txt">
			<td valign="top"><div id="dvFile"><input type="file" name="userfile[]"></div></td>
			<td valign="top"><a href="javascript:_add_more();" title="Add more"><img src="<?=base_url();?>source/template/images/plus_icon.gif" border="0"></a></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><div style="margin-left:40%;" class="buttons">
		 <input type="submit" class="button" name="txtSubmit" value="Submit" />
		 <input type="reset" class="button white" name="txtReset" value="Reset" />
	  </div></td>
		</tr>
	</table>
</form>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function _add_more() {
		var txt = "<br><input type=\"file\" name=\"userfile[]\">";
		document.getElementById("dvFile").innerHTML += txt;
	}
</script>
