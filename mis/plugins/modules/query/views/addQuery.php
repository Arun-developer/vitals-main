<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    $(".uniform").validate();

    $('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true
    });
});
</script>
<!-- start id-form -->

<form name="sourceForm" enctype="multipart/form-data" action="<?=site_url('query/add/' . $activity);?>" method="post"
    id="sourceForm" class="uniform">
    <fieldset>
        <legend><?=$cpagetitle?></legend>
        <p style="float:right; color:red; font-weight:bold; text-align:right">Fields marked with (*) represents
            required. </p>

        <dl class="inline">
            <dt><label for="query_status">Query Status<font class="req_field">*</font></label></dt>
            <dd>
                <?php $query_status = isset($_REQUEST["query_status"]) ? $_REQUEST["query_status"] : '';?>
                <select name="query_status" class="required" disabled="disabled">
                    <option value="">Select</option>
                    <option value="1" selected="selected">Open</option>
                    <option value="0">Closed</option>
                </select>
            </dd>

            <dt><label for="employee">Raised To</label></dt>
            <dd>
                <?php $employee = isset($_REQUEST["employee"]) ? $_REQUEST["employee"] : '';?>
                <select id="employee" name="employee">
                    <option value="">-Select-</option>
                    <?php
foreach ($usersList as $row) {
    ?>
                    <option value="<?=$row['emp_number']?>"
                        <?php if ($employee == $row['emp_number']) {echo 'selected';}?>>
                        <?=$row['emp_name']?></option>
                    <?php }?>

                </select>
            </dd>

            <dt><label for="subject_line">Subject Line</label></dt>
            <dd>
                <?php $subject_line = isset($_REQUEST["subject_line"]) ? $_REQUEST["subject_line"] : "";?>
                <input type="text" name="subject_line" value="<?=$subject_line?>" class="required" size="40" />
            </dd>

            <dt><label for="due_date">Due Date<font class="req_field">*</font></label></dt>
            <dd>
                <?php $due_date = isset($_REQUEST["due_date"]) ? $_REQUEST["due_date"] : "";?>
                <input type="text" name="due_date" value="<?=$due_date?>" class="datepicker required" />
                <?=form_error('due_date', '<div class="errorMsg">', '</div>');?>
            </dd>

            <dt><label for="alert">Alert <font class="req_field">*</font></label></dt>
            <dd>
                <?php $alert = isset($_REQUEST["alert"]) ? $_REQUEST["alert"] : "";?>
                <label><input type="radio" name="alert" checked="checked" value="1" class="required" />&nbsp;Yes</label>
                <label><input type="radio" name="alert" value="0" class="required" />&nbsp;No</label>
                <?=form_error('alert', '<div class="errorMsg">', '</div>');?>
            </dd>

            <dt><label for="query_description">Query Description</label></dt>
            <dd>
                <?php $query_description = isset($_REQUEST["query_description"]) ? $_REQUEST["query_description"] : "";?>
                <textarea name="query_description" rows="3" cols="40"><?=$query_description?></textarea>
            </dd>


            <dt><label for="documents">Documents</label></dt>
            <dd>
                <?php $documents = isset($_REQUEST["documents"]) ? $_REQUEST["documents"] : "";?>
                <input type="file" name="documents" />
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Submit" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>
<!-- end id-form  -->