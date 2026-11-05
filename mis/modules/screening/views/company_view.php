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
 <script type="text/javascript">
$(document).ready(function() {
    $('#addFinancialRow').click(function() {
        var arow = $('.cloneFinancial').clone().removeClass('cloneFinancial').addClass('odd');
        $('#financialTable').append(arow);
        ordering('sNo');
    });
    <?php if(count($financialList) == 0){ ?>
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
 <a href="<?php echo site_url('screening/documents/'.$innovation);?>" class="button" align="right">Back</a>
 <a href="<?php echo site_url('screening/getcompany/'.$innovation);?>" class="button" align="right">Edit Details</a>
 <form id="boardList" action="<?=site_url('screening/getcompany/'.$innovation)?>" method="post" name="boardList">
     <fieldset>
         <legend>Board Details</legend>
         <div id="user-grid" class="grid-view">
             <table width="100%" class="gtable sortable">
                 <thead>
                     <tr>
                         <th>S.No.</th>
                         <th>Board Members</th>
                         <th>Designation in the Board</th>
                         <th>Brief Profile</th>
                         <th>Inducted in Year</th>
                         <th>Email</th>
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

                             <label> <?=$row['members']?><label />
                         </td>
                         <td align="left" valign="middle"><label><?=$row['designation']?> </label></td>
                         <td align="left" valign="middle"><label> <?php echo $row['profile']; ?> <label /></td>
                         <td align="left" valign="middle">

                             <label><?php 
					for($i=date("Y")-20; $i<= date("Y")+5; $i++)
					{
						$ty = $i.'-'.($i+1);
						if($row['year'] == $ty) {
						 echo $ty; 
						 }
					
					}
					?></label>
                         </td>
                         <td align="left" valign="middle">
                             <?=$row['email'];?>
                         </td>
                     </tr>
                     <?php 
			endforeach; ?>
                 </tbody>
             </table>
             <!-- Paging style -->
         </div>
     </fieldset>
 </form>

 <form id="investmentList" action="<?=site_url('screening/getcompany/'.$innovation)?>" method="post"
     name="investmentList">
     <fieldset>
         <legend>Investment Details</legend>

         <div id="user-grid" class="grid-view">
             <table width="100%" class="gtable sortable">
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
			if(isset($investmentList)) {
            $r = 0;
			foreach($investmentList as $row):
			++$r;
			?>
                     <tr class="odd">
                         <td align="left" valign="middle" class="sNo"><?=$r?>
                         </td>
                         <td>
                             <label> <?php echo $row['funding_details']; ?> </label>
                         </td>
                         <td align="left" valign="middle"><?=$row['amount']?></td>
                         <td align="left" valign="middle">
                             <?php
					foreach($natureSource as $row1)
					{?>
                             <?=($row['nature_source'] == $row1['id'])? $row1['master_name']:'';
					 } ?>
                         </td>
                         <td align="left" valign="middle"><?=$row['ownership']?></td>
                         <td align="left" valign="middle">
                             <label><?php 
					for($i=date("Y")-20; $i<= date("Y")+5; $i++)
					{
						$ty = $i.'-'.($i+1);
						if($row['year'] == $ty) {
						 echo $ty; 
						 }
					
					}
					?></label>

                         </td>
                     </tr>
                     <?php 
			endforeach;
			}
				?>
                 </tbody>
             </table>
             <!-- Paging style -->
         </div>
     </fieldset>
 </form>



 <form id="financialList" action="<?=site_url('screening/documents/'.$innovation)?>" method="post" name="financialList">
     <fieldset>
         <legend>Financial Details</legend>

         <div id="user-grid" class="grid-view">
             <table width="100%" class="gtable sortable">
                 <thead>
                     <tr>
                         <th>S.No.</th>
                         <th>Year</th>
                         <th>Revenue(in lakhs)</th>
                         <th>COGS(in lakhs)</th>
                         <th>Expense(in lakhs)</th>
                         <th>Profit/(Loss)</th>
                         <th>No. of employees</th>
                         <th>Senior Management</th>
                         <th>Middle Management</th>
                         <th>Lower Management</th>
                     </tr>


                 </thead>
                 <tbody id="financialTable">
                     <?php 
			if(isset($financialList)) {
            $r = 0;
			foreach($financialList as $row):
			++$r;
			?>
                     <tr class="odd">
                         <td align="left" valign="middle" class="sNo"><?=$r?>
                         </td>
                         <td align="left" valign="middle" width="100">
                             <?=$row['year'];?>
                         </td>
                         <td align="left" valign="middle">
                             <?=$row['revenue']?></td>
                         <td align="left" valign="middle">
                             <?=$row['cogs']?></td>
                         <td align="left" valign="middle">
                             <?=$row['expense']?></td>
                         <td align="left" valign="middle">
                             <?=$row['profit']?>
                         </td>
                         <td align="left" valign="middle">
                             <?=$row['no_employees']?>
                         </td>
                         <td align="left" valign="middle">
                             <?=$row['senior']?>
                         </td>
                         <td align="left" valign="middle">
                             <?=$row['middle']?>
                         </td>
                         <td align="left" valign="middle">
                             <?=$row['lower']?>
                         </td>
                     </tr>
                     <?php 
			endforeach;
			}
				?>
                 </tbody>
             </table>
             <!-- Paging style -->
         </div>
     </fieldset>
 </form>