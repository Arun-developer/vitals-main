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
<?php foreach ($queryDetails as $quy): ?>
<form name="sourceForm" enctype="multipart/form-data"
    action="<?=site_url('query/edit/' . $activity . '/' . $quy['id']);?>" method="post" id="sourceForm" class="uniform">
    <fieldset>
        <legend><?=$cpagetitle?></legend>
        <p style="float:right; color:red; font-weight:bold; text-align:right">Fields marked with (*) represents
            required. </p>

        <dl class="inline">
            <dt><label for="query_status">Query Status<font class="req_field">*</font></label></dt>
            <dd>
                <?php $query_status = isset($_REQUEST["query_status"]) ? $_REQUEST["query_status"] : $quy['query_status'];?>
                <select name="query_status" class="required">
                    <option value="">Select</option>
                    <option value="1" <?=($query_status == 1) ? 'selected' : '';?>>Open</option>
                    <option value="0" <?=($query_status == 0) ? 'selected' : '';?>>Closed</option>
                </select>
            </dd>

            <dt><label for="employee">Raised To</label></dt>
            <dd>
                <?php $employee = isset($_REQUEST["employee"]) ? $_REQUEST["employee"] : $quy['employee'];?>
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

            <dt><label for="subject_line">Subject Line<font class="req_field">*</font></label></dt>
            <dd>
                <?php $subject_line = isset($_REQUEST["subject_line"]) ? $_REQUEST["subject_line"] : $quy['subject_line'];?>
                <input type="text" name="subject_line" value="<?=$subject_line?>" class="input-text required"
                    size="40" />
            </dd>

            <dt><label for="due_date">Due Date<font class="req_field">*</font></label></dt>
            <dd>
                <?php $due_date = isset($_REQUEST["due_date"]) ? $_REQUEST["due_date"] : mysql2date($quy['due_date']);?>
                <input type="text" name="due_date" value="<?=$due_date?>" class="input-text datepicker required" />
            </dd>

            <dt><label for="alert">Alert<font class="req_field">*</font></label></dt>
            <dd>
                <?php $alert = isset($_REQUEST["alert"]) ? $_REQUEST["alert"] : $quy['alert'];?>
                <label><input type="radio" name="alert" checked="checked" value="1" class="input-text required"
                        size="40" />&nbsp;Yes</label>
                <label><input type="radio" name="alert" value="0" class="input-text required"
                        size="40" />&nbsp;No</label>
            </dd>


            <dt><label for="query_description">Query Description</label></dt>
            <dd>
                <?php $query_description = isset($_REQUEST["query_description"]) ? $_REQUEST["query_description"] : $quy['query_description'];?>
                <textarea name="query_description" rows="3" cols="40"
                    class="input-text"><?=$query_description?></textarea>
            </dd>

            <dt><label for="documents">Documents</label></dt>
            <dd>
                <?php $documents = isset($_REQUEST["documents"]) ? $_REQUEST["documents"] : $quy['documents'];?>
                <input type="hidden" name="pre_documents" value="<?=$documents?>" />
                <input type="file" name="documents" />
                <?php if (!empty($quy['documents'])) {?>
                <a href="<?php echo base_url() . "uploads/query/" . $quy['documents']; ?>"
                    target="_blank"><?=$quy['documents']?></a>&nbsp;&nbsp;
                <?php }?>
            </dd>

            <dt><label for="query_response">Query Response:</label></dt>
            <dd>
                <?php $query_response = isset($_REQUEST["query_response"]) ? $_REQUEST["query_response"] : $quy['query_response'];?>
                <textarea name="query_response" rows="3" cols="40" class="input-text"><?=$query_response?></textarea>
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Save" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>
<?php endforeach;?>
<!-- end id-form  -->