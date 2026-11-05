<script src="<?php echo base_url(); ?>source/validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>source/validate/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    jQuery.validator.addMethod("phone", function(value, element) {
        return this.optional(element) || /^[\+0-9\-]+$/.test(value);
    }, "Please Enter Valid Phone Number");
    jQuery.validator.addMethod("mobile", function(value, element) {
        return this.optional(element) || /^[\+0-9\-]+$/.test(value);
    }, "Please Enter Valid Mobile Number");
    $("#budgetList").validate({
        rules: {
            'budgetamt[]': {
                required: true,
                number: true
            }
        },
    });

    $('#addBudgetRow').click(function() {
        var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
        $('#budgetTable').append(arow);
        ordering('sNo');
    });
    <?php if(php72_count($budgetList) == 0){ ?>
    var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
    $('#budgetTable').append(arow);
    ordering('sNo');
    <?php } ?>

    $('.removeBudgetRow').live('click', function() {
        $(this).parents('tr').remove();
        ordering('sNo');
    });

    function ordering(parent) {
        var d = 1;
        $('.' + parent).each(function() {
            $(this).html(d);
            ++d;
        });
    }
    $('.removeBudgetList').live('click', function() {
        var budgetId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    budgetId: budgetId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('seedfunding/budget/delete');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('budget Deleted Successfully').addClass(
                                'done').show();
                        } else {
                            $('.msg').html(msg).addClass('error').show();
                        }
                        $('.msg').fadeOut(50000);
                        ordering('sNo');
                    }
                });

            }

        });

    });
});
</script>
<div class="msg" style="display:none"></div>
<h2><?=$cpagetitle?></h2>
<form id="budgetList" action="<?=site_url('seedfunding/budget/view_list/'.$innovation)?>" method="post"
    name="budgetList">
    <table class="gtable sortable" style="width:600px;">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Goal</th>
                <th>Milestone</th>
                <th>Installments</th>
                <th>budget</th>
                <th>Lineitem</th>
                <th>Budget Amount</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody id="budgetTable">
            <?php 
            $i = 0;
			foreach($budgetList as $row):
			++$i;
			?>
            <tr class="odd">
                <td align="left" valign="middle" class="sNo"><?=$i?>
                </td>
                <td align="left" valign="middle" width="100">
                    <select name="goal[]" style="width:60px">
                        <option value="">-Select-</option>
                        <?php foreach($goalList as $gl): ?>
                        <option value="<?=$gl['id']?>" <?=($row['goal'] == $gl['id'])?'selected':'';?>><?=$gl['goal']?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="milestone[]" style="width:60px">
                        <option value="">-Select-</option>
                        <?php foreach($milestoneList as $ml): ?>
                        <option value="<?=$ml['id']?>" <?=($row['milestone'] == $ml['id'])?'selected':'';?>>
                            <?=$ml['milestone']?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td align="left" valign="middle" width="100">
                    <select name="installment[]">
                        <option value="">-Select-</option>
                        <?php
            foreach($installmentList as $ins): ?>
                        <option value="<?=$ins['id']?>" <?=($row['installment'] == $ins['id'])?'selected':'';?>>
                            <?=$ins['from']?> - <?=$ins['to']?></option><?php 
            endforeach;
            ?>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                    <input type="text" name="budget[]" size="20" value="<?=$row['budget']?>"
                        class="input-text required" /></td>
                <td><input type="text" name="lineitem[]" size="20" value="<?=$row['lineitem']?>"
                        class="input-text required" /></td>
                <td><input type="text" name="budgetamt[]" size="20" value="<?=$row['budgetamt']?>"
                        class="input-text number required" />
                </td>
                <td align="left" valign="middle">
                    <a href="javascript:void(0);" id="<?=$row['id']?>" class="removeBudgetList"><img
                            src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
                </td>
            </tr>
            <?php 
			endforeach; ?>
        </tbody>
    </table>
    <!-- Paging style --><br />

    <a href="javascript:void(0);" id="addBudgetRow" class="button black" style="float:right">Add Row</a>
    <table class="gtable detailtable">
        <tr>
            <td width="30%" align="right" valign="top">&nbsp;</td>
            <td valign="top">
                <input type="submit" value="Save" name="txtSubmit" class="button" />
                <input type="reset" value="Reset" name="txtReset" class="button white" />
            </td>
        </tr>
    </table>
</form>

<table style="display:none">
    <tr class="cloneBudget">
        <td align="left" valign="middle" class="sNo">
        </td>
        <td>
            <select name="goal[]" class="required" id="sel_goal" onchange="change(this);">
                <option value="">-Select-</option>
                <?php
            foreach($goalList as $pt):
                ?>
                <option value="<?=$pt['id']?>"><?=$pt['goal']?></option><?php 
            endforeach;?>

            </select>
        </td>
        <td align="left" valign="middle" width="100">

            <select name="milestone[]" class="sel_milestoneadd" class="required">
                <option value="">Select</option>
            </select>
        </td>
        <td align="left" valign="middle" width="100">
            <select name="installment[]">
                <option value="">-Select-</option>
                <?php
            foreach($installmentList as $ins): ?>

                <option value="<?=$ins['id']?>"><?=$ins['from']?> - <?=$ins['to']?></option><?php 
            endforeach;
            ?>
            </select>
        </td>
        <td align="left" valign="middle" width="100">
            <input type="hidden" name="id[]" value="" />
            <input type="text" name="budget[]" value="" size="20" class="input-text required" /></td>
        <td> <input type="text" name="lineitem[]" value="" size="20" class="input-text required" /></td>
        <td><input type="text" name="budgetamt[]" value="" size="20" class="input-text number required" />
        </td>

        <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeBudgetRow"><img
                    src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
        </td>
    </tr>
</table>
<script>
function change(obj) {
    var t = $(this).nextAll('select').find('.sel_milestoneadd').attr('class');
    var goal = obj.value;
    var innovation = <?php echo $innovation;?>;

    var datas = $.ajax({
        type: "POST",
        url: "<?php echo site_url('seedfunding/activities/get');?>",
        data: {
            'goals': goal,
            'innovation': innovation,
            'isajax': true
        },
        dataType: 'json',
        success: function(datas) {
            var m = populateSelectbox(datas);

            $(obj).parents('tr').find('.sel_milestoneadd').html(m);
        }
    });
}

function populateSelectbox(optArray) {

    var option = '<option value="">Select</option>';
    $.each(optArray, function(i, value) {
        option += '<option value="' + optArray[i].id + '">' + optArray[i].milestone + '</option>';
    });
    return option;
}
</script>