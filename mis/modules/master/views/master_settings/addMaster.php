<h1><?= $cpagetitle ?></h1>
<div style=" float:right; text-align:right;width:100%;">
    <?php echo anchor('master/master_settings/view_list', 'Back', 'class="button"'); ?>
</div>
<form name="templateForm" enctype="multipart/form-data" action="<?= site_url('master/master_settings/add'); ?>" method="post" id="masterForm" class="uniform" >
    <dl class="inline">
        <dt><label for="master_type">Master Type</label></dt>
        <dd>
            <?php $master_type = isset($_REQUEST["master_type"]) ? $_REQUEST["master_type"] : '';
            ?>
            <select name="master_type"  class="required">
                <option value="">Select</option>
                <?php foreach ($masterType as $key => $value) { ?>
                    <option value="<?= $value ?>" <?php echo ($master_type == $value) ? ('selected') : (''); ?>><?= $value ?></option>
                <?php } ?>
            </select>
            <?php
            echo '<font class="req_field">*</font>' . form_error('master_type', '<div class="errorMsg">', '</div>');
            ?>
        </dd>
        <dt><label for="master_name">Master Name</label></dt>
        <dd>
            <?php
            $master_name = isset($_REQUEST["master_name"]) ? $_REQUEST["master_name"] : "";
            echo form_textarea("master_name", $master_name, 'class="input-text required"');
            echo '<font class="req_field">*</font>' . form_error('master_name', '<div class="errorMsg">', '</div>');
            ?>
        </dd>
    </dl>
    <div class="buttons">
        <button type="submit" class="button" value="Save" name="txtSubmit">Add</button>
        <button type="reset" class="button white">Reset</button>
    </div>

</form>
<!-- end id-form  -->