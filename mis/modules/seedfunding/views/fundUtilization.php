<?php
$formAction = site_url('seedfunding/add_fundutilization/' . $innovation . '/' . $installment);
$id = '';
$val = array();
if (count($fundDetails)) {
    $val = $fundDetails['0'];
    $formAction = site_url('seedfunding/add_fundutilization/' . $innovation . '/' . $installment . '/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
} else {
    $action = 'add';
}

$date = isset($val["date"]) ? mysql2date($val["date"]) : "";
$amount = isset($val["amount"]) ? $val["amount"] : "";
$id = isset($val["id"]) ? $val["id"] : "";
$document = isset($val["document"]) ? $val["document"] : "";
$comments = isset($val["comments"]) ? $val["comments"] : "";
?>
<h1><?=$cpagetitle?></h1>
<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    $("#fundUtilizationForm").validate();
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });
    $('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();
});

fCount = 0;

function addFileField() {
    fCount = fCount + 1;
    var id = 'file' + fCount;
    content = '<div id="' + id +
        '"><input type="file" class="upload" name="supporting_documents[]"  />&nbsp;&nbsp;<a href="javascript:void(0);" style="color:red;" onclick="removeDiv(\'' +
        id + '\');" ><strong>( Remove )</strong></a><br/><br/></div>';

    $(content).appendTo('#multiFile');
}
</script>
<script language="javascript">
function _add_more() {
    var txt = "<br><input type=\"file\" name=\"supporting_documents[]\">";
    document.getElementById("dvFile").innerHTML += txt;
}
</script>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>

<!-- start id-form -->
<form name="fundUtilizationForm" action="<?=$formAction?>" enctype="multipart/form-data" method="post"
    id="fundUtilizationForm" class="uniform">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />
    <dl class="inline">

        <dt><label for="date">Date<font class="req_field">*</font></label></dt>
        <dd><input type="text" name="date" class="datepicker required" value="<?=$date?>" /></dd>

        <dt><label for="amount">Amount(in Rs.)<font class="req_field">*</font></label></dt>
        <dd><input type="text" name="amount" value="<?=$amount?>" class="required" /></dd>

        <dt><label for="comments">Supporting Documents<font class="req_field">*</font></label></dt>
        <dd><textarea name="comments" class="input-text required" rows="5" cols="50"><?=$comments?></textarea></dd>

        <dt><label for="document">Attach Supporting Documents</label></dt>
        <dd width="79%" align="left" valign="top" id="multiFile">
            <div>
                <input type="file" class="upload" name="supporting_documents[]" />&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="addFileField();" style="color:green"><strong>( Add
                        )</strong></a><br /><br /></div>
        </dd>
    </dl>

    <div class="buttons">
        <input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>