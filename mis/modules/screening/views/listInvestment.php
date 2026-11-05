<script type="text/javascript">
$(document).ready(function() {
    $('#addInvestmentRow').click(function() {
        var arow = $('.cloneInvestment').clone().removeClass('cloneInvestment').addClass('odd');
        $('#investmentTable').append(arow);
        ordering('sNo');
    });
    <?php if(count($investmentList) == 0){ ?>
    var arow = $('.cloneInvestment').clone().removeClass('cloneInvestment').addClass('odd');
    $('#investmentTable').append(arow);
    ordering('sNo');
    <?php } ?>
    $('.removeInvestmentRow').live('click', function() {
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
    $('.removeInvestmentList').live('click', function() {
        var investmentId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    investmentId: investmentId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('screening/company/delete_investment');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html(
                                    'Investment Details Deleted Successfully')
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
<form id="investmentList" action="<?=site_url('screening/company/investment/'.$innovation)?>" method="post"
    name="investmentList">

    <div id="user-grid" class="grid-view">
        <table width="800" class="gtable sortable">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Funding Details</th>
                    <th>Amount (in lakhs.)</th>
                    <th>Nature of the Source</th>
                    <th>Ownership</th>
                    <th>Year of Investment</th>
                    <th>Options</th>
                </tr>


            </thead>
            <tbody id="investmentTable">
                <?php 
            $r = 0;
			foreach($investmentList as $row):
			++$r;
			?>
                <tr class="odd">
                    <td align="left" valign="middle" class="sNo"><?=$r?>
                    </td>
                    <td align="left" valign="middle" width="100">
                        <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                        <input type="text" class="fundID" name="funding_details[]" size="40"
                            value="<?=$row['funding_details']?>" class="input-text " />

                    </td>
                    <td align="left" valign="middle"><input type="text" class="amountID" name="amount[]" size="20"
                            value="<?=$row['amount']?>" class="input-text " /></td>
                    <td align="left" valign="middle">
                        <select name="nature_source[]" class="natureID">
                            <option value="">-Select-</option>
                            <?php
					foreach($natureSource as $row1)
					{
						?>
                            <option value="<?=$row1['id']?>"
                                <?=($row['nature_source'] == $row1['id'])?'selected':''; ?>><?=$row1['master_name']?>
                            </option>
                            <?php
					}
					?>
                        </select>
                    </td>
                    <td align="left" valign="middle"><input type="text" class="ownerID" name="ownership[]" size="20"
                            value="<?=$row['ownership']?>" class="input-text " /></td>
                    <td align="left" valign="middle">
                        <select name="year[]" class="yearID">
                            <option value="">-Select-</option>
                            <?php
					for($i=date("Y")-20; $i<= date("Y")+5; $i++)
					{
						$ty = $i.'-'.($i+1);
						?>
                            <option value="<?=$ty?>" <?=($row['year'] == $ty)?'selected':''; ?>><?=$ty?></option>
                            <?php
					}
					?>
                        </select>
                    </td>
                    <td align="left" valign="middle">
                        <a href="javascript:void(0);" id="<?=$row['id']?>"
                            class="removeInvestmentList button">Remove</a>
                    </td>
                </tr>
                <?php 
			endforeach;

			?>
            </tbody>
        </table>
        <!-- Paging style -->
    </div>
    <a href="javascript:void(0);" id="addInvestmentRow" class="button">Add Row</a>
    <table class="nostyle" width="100%">
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
    <tr class="cloneInvestment">
        <td align="left" valign="middle" class="sNo">
        </td>

        <td align="left" valign="middle" width="100">
            <input type="hidden" name="id[]" />
            <input type="text" name="funding_details[]" size="40" class="input-text " />
        </td>
        <td align="left" valign="middle"><input type="text" name="amount[]" size="20" class="input-text " /></td>
        <td align="left" valign="middle">
            <select name="nature_source[]">
                <option value="">-Select-</option>
                <?php
					foreach($natureSource as $row1)
					{
						?>
                <option value="<?=$row1['id']?>"><?=$row1['master_name']?></option>
                <?php
					}
					?>
            </select></td>
        <td align="left" valign="middle"><input type="text" name="ownership[]" size="20" class="input-text " /></td>
        <td align="left" valign="middle">
            <select name="year[]">
                <option value="">-Select-</option>
                <?php
					for($i=date("Y")-20; $i<= date("Y")+5; $i++)
					{
						$ty1 = $i.'-'.($i+1);
						?>
                <option value="<?=$ty1?>"><?=$ty1;?></option>
                <?php
					}
					?>
            </select>
        </td>
        <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeInvestmentRow button">Remove</a>
        </td>
    </tr>
</table>