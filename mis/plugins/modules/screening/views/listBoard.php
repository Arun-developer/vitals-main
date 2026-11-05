<script type="text/javascript">
$(document).ready(function() {
    $('#addBoardRow').click(function() {
        var arow = $('.cloneBoard').clone().removeClass('cloneBoard').addClass('odd');
        $('#boardTable').append(arow);
        ordering('sNo');
    });
    <?php if(count($boardList) == 0){ ?>
    var arow = $('.cloneBoard').clone().removeClass('cloneBoard').addClass('odd');
    $('#boardTable').append(arow);
    ordering('sNo');
    <?php } ?>
    $('.removeBoardRow').live('click', function() {
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
    $('.removeBoardList').live('click', function() {
        var boardId = $(this).attr('id');
        var delRow = $(this).parents('tr');
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            if (r) {
                var form_data = {
                    boardId: boardId,
                    ajax: '4'
                };
                $.ajax({
                    url: '<?=site_url('screening/company/delete_board');?>',
                    type: 'POST',
                    data: form_data,
                    success: function(msg) {
                        if (msg == 'success') {
                            delRow.remove();
                            $('.msg').html('Board Details Deleted Successfully')
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
 <form id="boardList" action="<?=site_url('screening/company/board_details/'.$innovation)?>" method="post"
     name="boardList">

     <div id="user-grid" class="grid-view">
         <table class="gtable sortable">
             <thead>
                 <tr>
                     <th>S.No.</th>
                     <th>Board Members</th>
                     <th>Designation in the Board</th>
                     <th>Brief Profile</th>
                     <th>Inducted in Year</th>
                     <th>Options</th>
                 </tr>

             </thead>
             <tbody id="boardTable">
                 <?php 
            $r = 0;
			foreach($boardList as $row):
			++$r;
			?>
                 <tr class="odd">
                     <td align="left" valign="middle" class="sNo"><?=$r?>
                     </td>
                     <td align="left" valign="middle" width="100">
                         <input type="hidden" name="id[]" value="<?=$row['id']?>" />
                         <input type="text" class="memberID" name="members[]" size="40" value="<?=$row['members']?>"
                             class="input-text " />
                     </td>
                     <td align="left" valign="middle"><input type="text" class="designationID" name="designation[]"
                             size="40" value="<?=$row['designation']?>" class="input-text " /></td>
                     <td align="left" valign="middle"><input type="text" class="profileID" name="profile[]" size="40"
                             value="<?=$row['profile']?>" class="input-text " /></td>
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
                         <a href="javascript:void(0);" id="<?=$row['id']?>" class="removeBoardList button">Remove</a>
                     </td>
                 </tr>
                 <?php 
			endforeach; ?>
             </tbody>
         </table>
         <!-- Paging style -->
     </div>
     <a href="javascript:void(0);" id="addBoardRow" class="button">Add Row</a>
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
     <tr class="cloneBoard">
         <td align="left" valign="middle" class="sNo">
         </td>

         <td align="left" valign="middle" width="100">
             <input type="hidden" name="id[]" />
             <input type="text" name="members[]" size="40" class="input-text " />
         </td>
         <td align="left" valign="middle"><input type="text" name="designation[]" size="40" class="input-text " /></td>
         <td align="left" valign="middle"><input type="text" name="profile[]" size="40" class="input-text " /></td>
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
         <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeBoardRow button">Remove</a>
         </td>
     </tr>
 </table>