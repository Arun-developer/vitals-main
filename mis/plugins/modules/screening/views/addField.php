<script type="text/javascript">
$(document).ready(function() {
    $('#addBudgetRow').click(function() {
        var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
        $('#milestoneTable').append(arow);
        $('.datepicker').attr('id', '');
        $('.datepicker').removeClass('hasDatepicker').datepicker();
        ordering('sNo');
        $('#addcompanyrow').click(function() {
            var arow = $('.clonetable').clone().removeClass('clonetable').addClass('even');
            $("#clonetable").show();
            $('#cloneID').append(arow);
            $('.datepicker').attr('id', '');

            $('.datepicker').removeClass('hasDatepicker').datepicker();
            ordering('sNo');
        });

    });

    <?php if(count($peopleDetails) == 0){ ?>
    var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
    $('#milestoneTable').append(arow);
    ordering('sNo');
    <?php } ?>

    $('.removeBudgetRow').live('click', function() {
        $(this).parents('tr').remove();
        ordering('sNo');
    });

    $('.removeCompanyRow').live('click', function() {
        $(this).parents('tr').remove();
        ordering('sNo');
    });

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',

        onClose: function(dateText, inst) {

            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });

    function ordering(parent) {
        var d = 1;
        $('.' + parent).each(function() {
            $(this).html(d);
            ++d;
        });
    }
    $('.removeBudgetList').live('click', function() {
        var rowID = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this ?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    Id: rowID,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('screening/externaldelete');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('Criteria Deleted Successfully')
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
<?php $innovation = $this->uri->segment("3"); ?>
<a href="javascript: history.go(-1)" class="button" style="float:right;">Back </a><br>
<div class="msg" style="display:none"></div>
<h2><?=$cpagetitle?></h2>
<form id="milestoneList" action="<?=site_url('screening/peopleform/'.$innovation)?>" method="post" name="milestoneList">
    <table class="gtable sortable" style="width:600px;">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Criteria</th>
                <th>Sub Criteria</th>
                <th>Individual/Organization</th>
                <th>Where</th>
                <th>Date </th>
                <th>Action</th>
            </tr>


        </thead>
        <tbody id="milestoneTable">
            <?php 
	 
	 
            $i = 0;
			foreach($peopleDetails as $row):
			++$i;
			?>
            <tr class="odd">
                <td align="left" valign="middle" class="sNo"><?=$i?>
                </td>
                <td align="left" valign="middle" width="100">
                    <select name="criteria[]" style="width:60px">
                        <option value="">-Select-</option>
                        <?php foreach($criteriaList as $criteria){   ?>
                        <option value="<?=$criteria['id']?>" <?=($row['criteria'] == $criteria['id'])?'selected':'';?>>
                            <?=$criteria['master_name']?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="subcriteria[]" style="width:60px">
                        <option value="">-Select-</option>

                        <?php foreach($subCriteriaDetails as $subCriteria): ?>
                        <option value="<?=$subCriteria['subcriteria_id']?>"
                            <?=($row['subcriteria'] == $subCriteria['subcriteria_id'])?'selected':'';?>>
                            <?=$subCriteria['subcriteria']?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <td align="left" valign="middle" width="100">
                    <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                    <input type="text" name="category[]" size="30" value="<?=$row['category']?>"
                        class="input-text required" /></td>
                <td>
                    <input type="text" name="place[]" size="30" value="<?=$row['place']?>"
                        class="input-text required" />
                </td>

                <td align="left" valign="middle">
                    <input type="text" name="date" class="input-text datepicker" value="<?=$row['date']?>" />
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

    <a href="javascript:void(0);" id="addBudgetRow" class="button">Add Row</a>
    <table class="gtable detailtable">
        <tr>
            <td width="30%" align="right" valign="top">&nbsp;</td>
            <td valign="top">
                <input type="submit" value="Save" name="txtsiteSubmit" class="button" />
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
            <select name="criteria[]" class="required" id="sel_goal" onchange="change(this);">
                <option value="">-Select-</option>
                <?php
            foreach($criteriaList as $pt):
                ?>
                <option value="<?=$pt['id']?>"><?=$pt['master_name']?></option><?php 
            endforeach;?>

            </select>
        </td>
        <td align="left" valign="middle" width="100">

            <select name="subcriteria[]" class="sel_milestoneadd" class="required">
                <option value="">Select</option>
            </select>
        </td>
        <td align="left" valign="middle" width="100">
            <input type="hidden" name="id[]" value="" />
            <input type="text" name="category[]" value="" size="30" class="input-text required" /></td>
        <td>
            <input type="text" name="place[]" value="" size="30" class="input-text required" />
        </td>

        <td align="left" valign="middle">
            <input type="text" name="date[]" class="input-text datepicker" />
        </td>
        <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeBudgetRow"><img
                    src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
        </td>
    </tr>
</table>
<script>
function change(obj) {

    var t = $(this).nextAll('select').find('.sel_milestoneadd').attr('class');
    var masterID = obj.value;
    var datas = $.ajax({
        type: "POST",
        url: "<?php echo site_url('screening/getSubcriteriDetails/');?>",
        data: {
            'master_type': masterID,
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
        option += '<option value="' + optArray[i].subcriteria_id + '">' + optArray[i].subcriteria + '</option>';
    });
    return option;
}
</script>