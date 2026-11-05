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
    $("#milestoneList").validate({
        rules: {
            'amount[]': {
                required: true,
                number: true
            },
            'companyamt[]': {
                required: true,
                number: true
            }
        },
    });


    $('#addBudgetRow').click(function() {
        var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
        $('#milestoneTable').append(arow);
        ordering('sNo');
    });
    <?php if(php72_count($milestoneList) == 0){ ?>
    var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
    $('#milestoneTable').append(arow);
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
        var milestoneId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    milestoneId: milestoneId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('seedfunding/milestone/delete');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('Milestone Deleted Successfully')
                                .addClass('done').show();
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
<form id="milestoneList" action="<?=site_url('seedfunding/milestone/view_list/'.$innovation)?>" method="post"
    name="milestoneList">
    <table class="gtable sortable" style="width:600px;">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Goals</th>
                <th>Milestone</th>
                <th>Projected Expenditure(in Rs.)</th>
                <th>Other Funds Amount(in Rs.)</th>
                <th>Installments</th>
                <th>Options</th>
            </tr>


        </thead>
        <tbody id="milestoneTable">
            <?php 
            $i = 0;
			foreach($milestoneList as $row):
			++$i;
			?>
            <tr class="odd">
                <td align="left" valign="middle" class="sNo"><?=$i?>
                </td>
                <td align="left" valign="middle" width="100">
                    <select name="goal[]">
                        <option value="">-Select-</option>
                        <?php foreach($goalList as $gl): ?>
                        <option value="<?=$gl['id']?>" <?=($row['goal'] == $gl['id'])?'selected':'';?>><?=$gl['goal']?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td align="left" valign="middle" width="100">
                    <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                    <input type="text" name="milestone[]" size="60" value="<?=$row['milestone']?>"
                        class="input-text required" />
                </td>
                <td>
                    <input type="text" name="amount[]" size="30" value="<?=$row['amount']?>"
                        class="input-text required" />
                </td>
                <td>
                    <input type="text" name="companyamt[]" size="30" value="<?=$row['companyamt']?>" />
                </td>
                <td>
                    <dd>
                        <select name="installment_id[]" class="required">
                            <option value="">-Select-</option>
                            <?php
            foreach($installmentList as $ins): ?>

                            <option value="<?=$ins['id']?>" <?=($row['installment'] == $ins['id'])?'selected':'';?>>
                                <?=$ins['from']?> - <?=$ins['to']?></option><?php 
            endforeach;
            ?>
                        </select>
                    </dd>
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
        <td align="left" valign="middle" width="100">
            <select name="goal[]">
                <option value="">-Select-</option>
                <?php foreach($goalList as $gl): ?>
                <option value="<?=$gl['id']?>"><?=$gl['goal']?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td align="left" valign="middle" width="100">
            <input type="hidden" name="id[]" value="" />
            <input type="text" name="milestone[]" value="" size="60" class="input-text required" />
        </td>
        <td>
            <input type="text" name="amount[]" value="" size="30" class="input-text required" />
        </td>
        <td><input type="text" name="companyamt[]" value="" size="30" />
        </td>
        <td>
            <dd>
                <select name="installment_id[]" class="required">
                    <option value="">-Select-</option>
                    <?php
            foreach($installmentList as $ins): ?>

                    <option value="<?=$ins['id']?>"><?=$ins['from']?> - <?=$ins['to']?></option><?php 
            endforeach;
            ?>
                </select>
            </dd>
        </td>
        <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeBudgetRow"><img
                    src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
        </td>
    </tr>
</table>