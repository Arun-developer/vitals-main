<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title></title>
<script language="JavaScript" type="text/javascript">
$(document).ready( function() 
{	
	$('#ClickWordList li').click(function() { 
		$("#txtMessage").insertAtCaret($(this).text());
		return false
	});
	$("#DragWordList li").draggable({helper: 'clone'});
	$(".txtDropTarget").droppable({
		accept: "#DragWordList li",
		drop: function(ev, ui) {
			$(this).insertAtCaret(ui.draggable.text());
		}
	});
});

$.fn.insertAtCaret = function (myValue) {
	return this.each(function(){
			//IE support
			if (document.selection) {
					this.focus();
					sel = document.selection.createRange();
					sel.text = myValue;
					this.focus();
			}
			//MOZILLA / NETSCAPE support
			else if (this.selectionStart || this.selectionStart == '0') {
					var startPos = this.selectionStart;
					var endPos = this.selectionEnd;
					var scrollTop = this.scrollTop;
					this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
					this.focus();
					this.selectionStart = startPos + myValue.length;
					this.selectionEnd = startPos + myValue.length;
					this.scrollTop = scrollTop;
			} else {
					this.value += myValue;
					this.focus();
			}
	});
};

</script>
<style type="text/css" media="Screen">
	#maibBODYRHT li{
				cursor:pointer;
}
.maibBODYlft, .maibBODYRHT{ width:49%; height:100%; min-height:400px; float:left; }
		.maibBODYRHT{  float:right;}
.mainBODY{ width:100%;  height:100%; }
</style>
</head>
<body>
<a href="javascript:history.go(-1);"  class="button" style="margin-left:1023px;">Take me to Incubation Progress </a>
<br>
<div class="mainBODY">
<div class="maibBODYlft"  style="overflow:scroll;height:480px;">
<h2>Build Formula </h2>
<form name="form1" action="<?=site_url('incubationprogress/formula')?>" method="post">
<input type="hidden" name="innovation" value="<?=$innovation;?>"/>

<table class="gtable" width="100%" >

<?php foreach($ratioslabel as  $row):?>
<tr>
<td>
<label for="<?=$row['label']?>"><?=$row['label']?></label>
</td>
<td>
<textarea cols="40"  rows="5" id="txtMessage" name="<?=$row['id']?>" class="txtDropTarget"></textarea>
</td>
</tr>
<?php endforeach;?>

</table>
</div>
<div class="buttons">
    <input type="submit" class="button" name="txtSubmit" value="Save" id="submit" />&nbsp;
    <input type="reset" class="button white" name="txtReset" value="Reset" />
  </div>
 
</form>


<div id="maibBODYRHT">
<table width="100%" >
<tr>
<td >
    <fieldset >
    <legend ><b>Choose Symbol</b></legend>
    <ul id="DragWordList" style="margin-left:29px;font-weight:bold;" >
    <li>+</li>
    <li>-</li>
    <li>*</li>
    <li>/</li>
    <li>(</li>
    <li>)</li>
    </ul>
    </fieldset>
</td>
<td>
    <fieldset>
    <legend><b>Drag to insert:</b></legend>
    <ul id="DragWordList" style="width: 400px; height: auto; overflow: auto">
    <?php foreach($labelsList as $row)
	{
		echo "<li>".$row['label']."</li>";
	}
	?>
    </ul>
    </fieldset>
</td>	
</tr>   
</table>   
  </div>
</div>
 
</body>
</html>
