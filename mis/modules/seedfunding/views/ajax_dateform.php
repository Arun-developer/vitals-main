<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <title></title>
    <script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $("#DragWordList li").draggable({
            helper: 'clone'
        });
        $(".txtDropTarget").droppable({
            accept: "#DragWordList li",
            drop: function(ev, ui) {
                $(this).insertAtCaret(ui.draggable.text());
            }
        });
    });

    $.fn.insertAtCaret = function(myValue) {
        return this.each(function() {
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
                this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this
                    .value.length);
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
    #leftcolumn li {
        cursor: pointer;
    }
    </style>
</head>

<body>


    <?php
$r = 0;

if($fieldsList == NULL) { echo "<span style='color:#C34A2C;'>"."No records found!  Please enter data in master for selected period."."</span>"; }
$j=0;

		$answer = array();
		$field = array();
		foreach($ajxValues as $data)
		{
			$answer[] = $data['answer'];
			$field[] = $data['field'];
		}
foreach($fieldsList as $row): ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#descriptionLink_<?=$row['id']?>").fancybox({
            'titlePosition': 'inside',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });
    </script>
    <?php

	if($row['input_type'] == 'Group')
	{
	    echo '</fieldset><br /><fieldset><legend>'.$row['label'].'</legend>';
		continue;
	} 
	if($r==0)
	{ 
	?>
    <div class="<?=$row['pid']?>_subLevel">
        <?php } ?>
        <dl class="inline fieldMain <?=$row['pid']?>_subLevel">
            <dt>
                <label
                    for="<?=$row['id']?>"><?php echo $row['label']; if($row['required'] == 'yes'){ echo '&nbsp;<font class="req_field">*</font>'; }?></label>
                <a href="<?=site_url('progress/view_info/'.$row['id'].'/');?>" class="fancybox"
                    id="descriptionLink_<?php echo $row['id']?>">[Info]&nbsp;</a>&nbsp;
            </dt>
            <dd>
                <?php 
	$cfValue = (isset($_POST['txtSubmit'])) ? $_POST[$row['id']] : $row['answer']; 
	
	
switch($row['input_type'])
{
	case 'Text':
		if($this->session->userdata('user_type') != 'incubatee'){?>
                <input type="text" size="40"
                    class="input-text <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                    name="<?=$row['id']?>" value="<?php if($row['id'] == isset($field[$j]))
	  { if(isset($answer[$j]))
	  	{
		  echo $answer[$j];
		}
		else
		{
			echo '';
		}
	  }
	  else
	  {
		  echo '';
	  }?>" /><?php } else { ?>
                <input type="text" size="40" readonly="readonly"
                    class="input-text <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                    name="<?=$row['id']?>" value="<?php if($row['id'] == isset($field[$j]))
	  { if(isset($answer[$j]))
	  	{
		  echo $answer[$j];
		}
		else
		{
			echo '';
		}
	  }
	  else
	  {
		  echo '';
	  }?>" />
                <?php } ?>
                <?php 
	break;
	case 'Textarea':
		if($this->session->userdata('user_type') != 'incubatee'){?>
                <textarea cols="40" rows="5" id="txtMessage" class="txtDropTarget" name="<?=$row['id']?>"><?php if($row['id'] == isset($field[$j]))
	  { if(isset($answer[$j]))
	  	{
		  echo $answer[$j];
		}
		else
		{
			echo '';
		}
	  }
	  else
	  {
		  echo '';
	  }?>
</textarea>
                <?php } else { ?>
                <textarea cols="40" rows="5" id="txtMessage" readonly="readonly" class="txtDropTarget"
                    name="<?=$row['id']?>"><?php if($row['id'] == isset($field[$j]))
	  { if(isset($answer[$j]))
	  	{
		  echo $answer[$j];
		}
		else
		{
			echo '';
		}
	  }
	  else
	  {
		  echo '';
	  }?>
</textarea>
                <?php } ?>
                <?php
	break;
	case 'Listbox':
		?>
                <select name="<?=$row['id']?>"
                    class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>">
                    <option value="">Select</option>
                    <?php foreach($row['value'] as $key=>$value): ?>
                    <option value="<?=$value?>" <?=($cfValue==$value)?'selected':'';?>>
                        <?=$value?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <?php
		break;
	case 'Radio':
		foreach($row['value'] as $key=>$value): ?>
                <label>
                    <input type="radio" name="<?=$row['id']?>"
                        class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                        value="<?=$value?>" <?=($cfValue==$value)?'checked="checked"':'';?> />
                    <?=$value?>
                </label>
                <?php
		 endforeach;
		break;
	case 'Checkbox':
		$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:explode(',',$row['answer']);
		foreach($row['value'] as $key=>$value): ?>
                <label>
                    <input type="checkbox" name="<?=$row['id']?>[]"
                        class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                        value="<?=$value?>" <?=(php72_in_array($value,$cfValue))?'checked="checked"':'';?> />
                    <?=$value?>
                </label>
                <br />
                <?php
		 endforeach;
		break;
	case 'File':
		?>
                <input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                    name="<?=$row['id']?>" />
                <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>" />
                <?php
		if($cfValue!=''){ echo $cfValue;?>
                <a href="/ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/progress/<?=$cfValue?>"
                    target="_blank"><img src="<?=base_url();?>source/template/images/icons/download.gif"
                        height="16" /></a>
                <?php }
		break;
}

$j++;

?>
            </dd>
        </dl>
        <?php
if(php72_cmp($row['sub_field'])>0)
{
	$this->Mprogress->ajaxForm($innovation,$criteria,$row['id'],$cfValue);
}
endforeach;
if(($criteria == '97') && ($this->session->userdata('user_type')!='incubatee'))
{?>
        <div id="leftcolumn">

            <fieldset style="padding-left:350px">
                <legend>Please a Select Symbol</legend>
                <ul id="DragWordList">
                    <li>+</li>
                    <li>-</li>
                    <li>*</li>
                    <li>/</li>
                    <li>(</li>
                    <li>)</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Drag to insert:</legend>
                <ul id="DragWordList" style="width: 300px; height: 200px; overflow: auto">
                    <?php foreach($labelsList as $row)
	{
		echo "<li>".$row['label']."</li>";
	}
	?>
                </ul>

            </fieldset>


        </div>
        <?php }
?>
        <?php if($fieldsList != NULL) { ?>
        <div class="buttons">
            <input type="submit" class="button" name="txtSubmit" value="Save" id="submit" />&nbsp;
            <input type="reset" class="button white" name="txtReset" value="Reset" />
        </div>
        <?php } ?>
    </div>
</body>

</html>