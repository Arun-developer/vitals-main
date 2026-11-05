<script type="text/javascript">
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
  </script>
  <style>
.ui-datepicker-calendar {
    display: none;
}
  </style>
  <script type="text/javascript">
$(document).ready(function() {
    $('#addInstallmentRow').click(function() {
        addRow();
    });

    <?php if(php72_count($installmentList) == 0){ echo "addRow();"; } ?>

    function addRow() {
        var arow = $('.cloneInstallment').clone().removeClass('cloneInstallment').addClass('odd');
        $('#installmentTable').append(arow);
        ordering('sNo');
        $('.monthYear').attr('id', '');
        $('.monthYear').removeClass('hasDatepicker');
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
    }

    $('.removeInstallmentRow').live('click', function() {
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
    $('.removeInstallmentList').live('click', function() {
        var installmentId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    installmentId: installmentId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('seedfunding/installment/delete');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('Installment Deleted Successfully')
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
  <form id="installmentList" action="<?=site_url('seedfunding/installment/view_list/'.$innovation)?>" method="post"
      name="installmentList">
      <table class="gtable sortable" style="width:600px;">
          <thead>
              <tr>
                  <th>S.No.</th>
                  <th>From </th>
                  <th>To </th>
                  <th>Options</th>
              </tr>
          </thead>
          <tbody id="installmentTable">
              <?php 
            $i = 0;
			foreach($installmentList as $row):
			++$i;
			?>
              <tr class="odd">
                  <td align="left" valign="middle" class="sNo"><?=$i?></td>
                  <td align="left" valign="middle" width="100">
                      <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                      <input type="text" name="from[]" value="<?=$row['from']?>" size="20" class="monthYear" />
                  </td>
                  <td align="left" valign="middle" width="100">
                      <input type="text" name="to[]" value="<?=$row['to']?>" size="20" class="monthYear" />
                  </td>
                  <td align="left" valign="middle">
                      <a href="javascript:void(0);" id="<?=$row['id']?>" class="removeInstallmentList">
                          <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
                  </td>
              </tr>
              <?php 
			endforeach; ?>
          </tbody>
      </table>
      <!-- Paging style --><br />

      <a href="javascript:void(0);" id="addInstallmentRow" class="button black" style="float:right">Add Row</a>
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
      <tr class="cloneInstallment">

          <td align="left" valign="middle" class="sNo"></td>

          <td align="left" valign="middle" width="100">
              <input type="hidden" name="id[]" value="" />
              <input type="text" name="from[]" value="" size="20" class="monthYear" />
          </td>
          <td align="left" valign="middle">
              <input type="text" name="to[]" value="" size="20" class="monthYear" />
          </td>

          <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeInstallmentRow"><img
                      src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
          </td>
      </tr>
  </table>