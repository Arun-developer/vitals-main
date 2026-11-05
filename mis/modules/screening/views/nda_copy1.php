<?php
$c = $this->uri->segment('5');
$c = ($c == '') ? 'copy1' : $c;
if (count($ndaDetails)) {
    $id = $ndaDetails['0']['id'];
    $copy1 = $ndaDetails['0'][$c];
} else {
    $id = '';
    $copy1 = '';
    $c = '';
}
?>
<script type="text/javascript">
$(function($) {
    $('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();
});
$(document).ready(function() {
    $('#ndaForm').submit(function() {
        if ($('#copy_upload').val() == '') {
            alert('Please upload document');
            return false;
        } else
            return true;
    });
});
</script>
<form name="ndaForm" enctype="multipart/form-data"
    action="<?=site_url('screening/nda_copy1/' . $innovationInfo['id'] . '/' . $id . '/' . $c);?>" method="post" id="ndaForm"
    class="uniform">
    <input type="hidden" name="old_copy1" value="<?=$copy1?>" />
    <fieldset>
        <legend>Upload Non-disclosure agreement</legend>
        <dl class="inline">
            <dt><label for="copy1">NDA Document<font class="req_field">*</font></label></dt>
            <dd>
                <input type="file" name="copy1" id="copy_upload" class="required" />
                <?php
if ($copy1 != '') {
    echo $copy1;
    ?>

                <a href="<?=base_url();?>uploads/nda/<?php echo $copy1; ?>" target="_blank"><img
                        src="<?=base_url();?>source/template/images/icons/download.gif" alt="Download"
                        height="16" /></a>
                <?php
}
?>
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Upload" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>