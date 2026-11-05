<?php
if (php72_count($targetDetails)) {
    $val = $targetDetails['0'];
}
$month = isset($val["month"]) ? $val["month"] : "";
$target = isset($val["target"]) ? $val["target"] : "";
$achieved = isset($val["achieved"]) ? $val["achieved"] : "";
$next_target = isset($val["next_target"]) ? $val["next_target"] : "";
?>
<h1><?=$cpagetitle?> - <?=$month?></h1>
<form>
<dl class="inline" style="width:600px">
    <dt><label for="">Target</label></dt>
    <dd><?=$target?></dd>

    <dt><label for="">Achieved</label></dt>
    <dd><?=$achieved?></dd>

	<dt><label for="">Month </label></dt>
    <dd><?=$month?></dd>

    <dt><label for="">Target for Next Month</label></dt>
    <dd><?=$next_target?></dd>
</dl>
</form>


