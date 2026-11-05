<?php 
$nullLink = 'javascript:void(0);';

//load scripts
echo '<h1 style="margin: 15px 0 10px;">'.$cpagetitle.'</h1>';
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
		$("#prelim_name").val('');
	});

	<?php
	if(isset($_REQUEST['prelim_name']) && $_REQUEST['prelim_name'] != '')
	{
		?>
		$('.toggleSearchs').trigger('click');
		<?php
	}
	?>
});
</script>
<script type="text/javascript">
$(document).ready( function() {
	//confirmantion Box
	$(".confirmDelete").click( function() {
	var linkUrl = $(this).attr('url');
	jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
	if(r)
	{
	  $(window.location).attr('href',linkUrl);
	}
	});
	});
});
</script> 
<br />
<form id="search" action="<?=site_url('master/master_settings/preliminary_reason/search')?>" method="post" name="<?=$form_name?>">
<input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
<input type="hidden"  name="orderby" value="<?=$orderby?>"  />
<div class="searchBox" style="display:none;"  >
<dl class="inline">
            <dt><label for="prelim_name">Preliminary Reason</label></dt>
            <dd>
              <?php $prelim_name = isset($_REQUEST['prelim_name'])?$_REQUEST['prelim_name']:'';?>
			  <input type="text"  name="prelim_name" class="input-text" value="<?=$prelim_name?>"  />
			</dd>
			
 </dl>          
 <div class="buttons">
    <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
    <button type="reset" class="button white">Reset</button>
</div>          
</div>
</form>

<div style=" float:right; text-align:right;width:100%;">
<?php echo anchor('master/master_settings/preliminary_reason','Clear Search','class="button clear1"'); ?>
<a href="<?=$nullLink?>" class="button toggleSearchs" >Show Search</a>&nbsp;&nbsp;
<?php echo anchor('master/master_settings/preliminary_reason_add','Add Preliminary Reason','class="button"'); ?>
</div>
<br />
<br />



	<table class="gtable sortable">
	<thead>
		<tr>
			<th width="45%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Preliminary Reason</a></th>
			<th width="20%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Partner</a></th>
			<th width="18%"><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
			<th width="17%" class="head">Action</th>
			</tr>
		
	</thead>
	<tbody>
   <?php
	if(php72_count($reasons))
	{    
		$r=1;
		foreach($reasons as $reason)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$reason["name"]?></td>
			<td align="left" valign="middle"><?=$reason["partner_name"]?></td>
			<td align="left" valign="middle"><?php 
			if($reason["status"]=='1') { ?>
			<a href="<?=site_url('master/master_settings/Prelim_changestatus/'.$reason['id'].'/0') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>

			<?php } else { ?>
			<a href="<?=site_url('master/master_settings/Prelim_changestatus/'.$reason['id'].'/1') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
		    <?php } ?></td>
			<td nowrap="nowrap">
			<a href="<?=site_url('master/master_settings/Prelim_edit/'.$reason['id'])?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>
			
			<a url="<?=site_url('master/master_settings/Prelim_delete/'.$reason['id'])?>"  class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
			</td>
			</tr>
			<?php 
		}
	}
	else
	{ ?>
		<tr>
		<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?php } ?>
		
	</tbody>
	</table>
	<!-- Paging style -->
	<?php echo  $this->pagination->create_links($form_name);?>
 
