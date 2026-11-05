<script type="text/javascript">
$(document).ready(function() {
    $('#addBudgetRow').click(function() {
        var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
        $('#goalTable').append(arow);
        ordering('sNo');
    });
    <?php if(count($goalList) == 0){ ?>
    var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
    $('#goalTable').append(arow);
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
        var goalId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    goalId: goalId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('seedfunding/goal/delete');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('Budget Line Item Deleted Successfully')
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
<form id="goalList" action="<?=site_url('seedfunding/goal/view_list/'.$innovation)?>" method="post" name="goalList">
    <table class="gtable sortable" style="width:600px;">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Goals</th>
                <th>Options</th>
            </tr>


        </thead>
        <tbody id="goalTable">
            <?php 
            $i = 0;
			foreach($goalList as $row):
			++$i;
			?>
            <tr class="odd">
                <td align="left" valign="middle" class="sNo"><?=$i?>
                </td>
                <td align="left" valign="middle" width="100">
                    <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                    <input type="text" name="goal[]" size="60" value="<?=$row['goal']?>" class="input-text required" />
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
            <input type="hidden" name="id[]" value="" />
            <input type="text" name="goal[]" value="" size="60" class="input-text required" />
        </td>

        <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeBudgetRow"><img
                    src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
        </td>
    </tr>
</table>