<?php 
$nullLink = 'javascript:void(0);';

//load scripts
echo '<h1>'.$cpagetitle.'</h1>';
?>
<script type="text/javascript">
$(document).ready(function (){
	$('.clear1').hide();
	$('.toggleSearchs').click(function(){
         $('.searchBox').toggle();
         if($('.toggleSearchs').html() == 'Show Search')
         {
         	$('.toggleSearchs').html('Hide Search');
         	$('.clear1').show();
         }
         else
         {  $('.clear1').hide();
         	$('.toggleSearchs').html('Show Search');
         }
	});

	$('.white').click(function(){
	    $("#fit_name").val('');
	});

	<?php
	if(isset($_REQUEST['fit_name']) && $_REQUEST['fit_name'] != '') {
		?>
		$('.toggleSearchs').trigger('click');
		<?php
	}
	?>
});
</script>
<script type="text/javascript">
$(document).ready( function() {
	$(".confirmDelete").click( function() {
	var linkUrl = $(this).attr('url');
	jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
		if(r) {
		  $(window.location).attr('href',linkUrl);
		}
	});
  });
});
</script> 
<br />

<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/master_settings/meeting_type_add','Add Meeting Type','class="button"'); ?>
</div>
<br />
<br />

	<table class="gtable sortable">
	<thead>
		<tr>
			<th width="55%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Meeting Type</a></th>
			<th width="15%"><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
			<th width="15%" class="head">Action</th>
			</tr>		
	</thead>
	<tbody>
   <?php
	if(count($type_list)) {   
		$r=1;
		foreach($type_list as $doc) {
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
	?>
			<tr class="<?=$row_type?>">
				<td align="middle" valign="middle"><?=$doc["name"]?></td>			
				<td align="middle" valign="middle">
					<?php if($doc["status"]=='1') { ?>
					<a href="<?=site_url('master/master_settings/meetType_changeStatus/'.$doc['id'].'/2'); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>
					<?php } else { ?>
					<a href="<?=site_url('master/master_settings/meetType_changeStatus/'.$doc['id'].'/1'); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
					<?php } ?>
			    </td>
				<td align="middle" nowrap="nowrap">
					<a href="<?=site_url('master/master_settings/meeting_type_edit/'.$doc['id']); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>			
					<a class="confirmDelete" url="<?=site_url('master/master_settings/meetType_changeStatus/'.$doc['id'].'/3')?>"  ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
				</td>
			</tr>
	<?php 
		}
	} else { ?>
		<tr>
			<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?php } ?>
		
	</tbody>
	</table>
	<!-- Paging style -->
 
<style type="text/css">
	.confirmDelete{cursor: pointer;}
	 nav#topmenu { min-width: 947px !important;}
</style>