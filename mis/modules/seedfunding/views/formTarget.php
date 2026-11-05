<?php
$formAction = site_url('seedfunding/add_month_report/' . $innovation);
$id = '';
$val = array();
if (php72_count($targetDetails)) {
    $val = $targetDetails['0'];
    $formAction = site_url('seedfunding/add_month_report/' . $innovation . '/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
    $installment = $this->Msfactivities->getAmount($id);
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}
$month = isset($val["month"]) ? $val["month"] : "";
$target = isset($val["target"]) ? $val["target"] : "";
$achieved = isset($val["achieved"]) ? $val["achieved"] : "";
$fund_utilized = isset($val["fund_utilized"]) ? $val["fund_utilized"] : "";
$next_target = isset($val["next_target"]) ? $val["next_target"] : "";
?>
<h2><?=$cpagetitle?></h2>
<!-- start id-form -->

<style>
.ui-datepicker-calendar {
    display: none;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    $("#activitiesForm").validate();

    $(function() {
        $(".monthYear").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',

            onClose: function(dateText, inst) {

                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });

    });
});

function change(value) {
    var budget = value;
    var innovation = <?php echo $innovation; ?>;
    var datas = $.ajax({
        type: "POST",
        url: "<?php echo site_url('seedfunding/seedfunding/getlineitem'); ?>",
        data: {
            'budget': budget,
            'innovation': innovation,
            'isajax': true
        },
        dataType: 'json',
        success: function(datas) {
            var m = populateSelectbox(datas);
            $('#sel_lineitem').find('option').remove().end().append(m);
        }
    });
}

function populateSelectbox(optArray) {
    var option = '';
    $.each(optArray, function(i, value) {
        option += '<option value="' + optArray[i].id + '">' + optArray[i].lineitem + '</option>';
    });
    return option;
}
</script>

<form name="activitiesForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="activitiesForm">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />
    <input type="hidden" value="<?=$activity?>" name="activity" />
    <input type="hidden" value="<?=$innovation?>" name="innovation" />
    <input type="hidden" value="<?=date('F Y');?>" name="month" />
    <dl class="inline" style="width:600px">
        <dt><label for="">Target<font class="req_field">*</font></label></dt>
        <dd><textarea name="target" cols="40" rows="6" class="input-text"><?php $a = (empty($targets)) ? "" : $targets[0]['next_target'];
echo $a;?></textarea>
        </dd>

        <dt><label for="">Achieved<font class="req_field">*</font></label></dt>
        <dd><textarea name="achieved" cols="40" rows="6" class="input-text"><?=$achieved?></textarea></dd>

        <dt><label for="">Budget Head<font class="req_field">*</font></label></dt>
        <dd><select name="budget" onchange="change(this.value)">
                <option value="">-select-</option>
                <?php foreach ($budgethead as $row) {?>
                <option value="<?=$row['budget'];?>"><?=$row['budget'];?></option>
                <?php }?>
            </select>
        </dd>

        <dt><label for="lineitem">Line Item</label></dt>
        <dd>
            <select name="lineitem[]" multiple="multiple" id="sel_lineitem" class="required">
            </select>
        </dd>

        <dt><label for="">Add Fund Utilization<font class="req_field">*</font></label></dt>
        <dd><textarea name="fund_utilized" cols="40" rows="6" class="input-text"><?=$fund_utilized?></textarea></dd>

        <dt><label for="">Target for Next Month<font class="req_field">*</font></label></dt>
        <dd><textarea name="next_target" cols="40" rows="6" class="input-text"><?=$next_target?></textarea></dd>
    </dl>

    <div class="clear"></div>

    <div class="buttons">
        <input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>

<!-- end id-form  -->