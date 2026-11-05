<script type="text/javascript">
$(document).ready(function() {
    $('#addFinancialRow').click(function() {
        var arow = $('.cloneFinancial').clone().removeClass('cloneFinancial').addClass('odd');
        $('#financialTable').append(arow);
        ordering('sNo');
    });
    <?php if(php72_count($financialList) == 0){ ?>
    var arow = $('.cloneFinancial').clone().removeClass('cloneFinancial').addClass('odd');
    $('#financialTable').append(arow);
    ordering('sNo');
    <?php } ?>
    $('.removeFinancialRow').live('click', function() {
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
    $('.removeFinancialList').live('click', function() {
        var financialId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    financialId: financialId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('screening/company/delete_financial');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('Financial Details Deleted Successfully')
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
<form id="financialList" action="<?=site_url('screening/company/financial_details/'.$innovation)?>" method="post"
    name="financialList">

    <div id="user-grid" class="grid-view">
        <table width="800" class="gtable sortable">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Year</th>
                    <th>Revenue</th>
                    <th>COGS</th>
                    <th>Expense</th>
                    <th>Profit/(Loss)</th>
                    <th>No. of employees</th>
                    <th>Senior Management</th>
                    <th>Middle Management</th>
                    <th>Lower Management</th>
                    <th>Options</th>
                </tr>


            </thead>
            <tbody id="financialTable">
                <?php 
            $r = 0;
			foreach($financialList as $row):
			++$r;
			?>
                <tr class="odd">
                    <td align="left" valign="middle" class="sNo"><?=$r?>
                    </td>
                    <td align="left" valign="middle" width="100">
                        <input type="hidden" name="id[]" value="<?=$row['id']?>" />
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
                        <input type="text" name="revenue[]" class="revenueID" size="10" value="<?=$row['revenue']?>"
                            class="input-text " /></td>
                    <td align="left" valign="middle">
                        <input type="text" name="cogs[]" class="cogsID" size="10" value="<?=$row['cogs']?>"
                            class="input-text " /></td>
                    <td align="left" valign="middle">
                        <input type="text" name="expense[]" class="expenseID" size="10" value="<?=$row['expense']?>"
                            class="input-text " /></td>
                    <td align="left" valign="middle">
                        <input type="text" name="profit[]" class="profitID" size="10" value="<?=$row['profit']?>"
                            class="input-text " />
                    </td>
                    <td align="left" valign="middle">
                        <input type="text" name="no_employees[]" class="no_employeeID" size="10"
                            value="<?=$row['no_employees']?>" class="input-text " />
                    </td>
                    <td align="left" valign="middle">
                        <input type="text" name="senior[]" class="seniorID" size="10" value="<?=$row['senior']?>"
                            class="input-text " />
                    </td>
                    <td align="left" valign="middle">
                        <input type="text" name="middle[]" class="middleID" size="10" value="<?=$row['middle']?>"
                            class="input-text " />
                    </td>
                    <td align="left" valign="middle">
                        <input type="text" name="lower[]" class="lowerID" size="10" value="<?=$row['lower']?>"
                            class="input-text " />
                    </td>
                    <td align="left" valign="middle">
                        <a href="javascript:void(0);" id="<?=$row['id']?>" class="removeFinancialList button">Remove</a>
                    </td>
                </tr>
                <?php 
			endforeach; ?>
            </tbody>
        </table>
        <!-- Paging style -->
    </div>
    <a href="javascript:void(0);" id="addFinancialRow" class="button">Add Row</a>
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
    <tr class="cloneFinancial">
        <td align="left" valign="middle" class="sNo">
        </td>

        <td align="left" valign="middle" width="100">
            <input type="hidden" name="id[]" />
            <select name="year[]">
                <option value="">-Select-</option>
                <?php
					for($i=date("Y")-20; $i<= date("Y")+5; $i++)
					{
						$ty = $i.'-'.($i+1);
						?>
                <option value="<?=$ty?>"><?=$ty?></option>
                <?php
					}
					?>
            </select>

        </td>
        <td align="left" valign="middle">
            <input type="text" name="revenue[]" size="10" class="input-text " /></td>
        <td align="left" valign="middle">
            <input type="text" name="cogs[]" size="10" class="input-text " /></td>
        <td align="left" valign="middle">
            <input type="text" name="expense[]" size="10" class="input-text " /></td>
        <td align="left" valign="middle">
            <input type="text" name="profit[]" size="10" class="input-text " />
        </td>
        <td align="left" valign="middle">
            <input type="text" name="no_employees[]" size="10" class="input-text " />
        </td>
        <td align="left" valign="middle">
            <input type="text" name="senior[]" size="10" class="input-text " />
        </td>
        <td align="left" valign="middle">
            <input type="text" name="middle[]" size="10" class="input-text " />
        </td>
        <td align="left" valign="middle">
            <input type="text" name="lower[]" size="10" class="input-text " />
        </td>
        <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeFinancialRow button">Remove</a>
        </td>
    </tr>
</table>