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
		$("#reason_name").val('');
	});

	<?php
	if(isset($_REQUEST['reason_name']) && $_REQUEST['reason_name'] != '')
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
<form id="search" action="<?=site_url('master/master_settings/reject_reasons/search')?>" method="post" name="<?=$form_name?>">
<input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
<input type="hidden"  name="orderby" value="<?=$orderby?>"  />
<div class="searchBox" style="display:none;"  >
<dl class="inline">
<?php
	if($this->session->userdata['user_type'] == 'superadmin'){
	$branch_name = isset($_REQUEST["branch"])?$_REQUEST["branch"]:'';
	?>
<dt><label for="program">Partner</label></dt>
        
      	<dd>
          <select name="branch" id="branch">
              <option value="">Select Partner</option>
              <?php 
              foreach ($branch as $partner) { ?>
                 <option value="<?php echo $partner['id'];?>"<?php echo ($branch_name==$partner['id'])?('selected'):(''); ?>><?php echo $partner['branch_name'];?> </option>
              <?php } ?>
          </select>
        </dd>
        <?php } ?>
        
 <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $this->session->userdata('partner_id');?>">
       
       
            <dt><label for="reason_name">Reject Reason Name</label></dt>
            <dd>
              <?php $reason_name = isset($_REQUEST['reason_name'])?$_REQUEST['reason_name']:'';?>
			  <input type="text" id="reason_name" name="reason_name" class="input-text" value="<?=$reason_name?>"  />
            </dd>
 </dl>          
 <div class="buttons">
    <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
    <!-- <button type="reset" class="button white">Reset</button> -->
</div>          
</div>
</form>

<div style=" float:right; text-align:right;width:100%;">
<?php echo anchor('master/master_settings/reject_reasons','Clear Search','class="button clear1"'); ?>
<a href="<?=$nullLink?>" class="button toggleSearchs" >Show Search</a>&nbsp;&nbsp;
<?php echo anchor('master/master_settings/reject_reasons_add','Add Reject Reason','class="button"'); ?>
</div>
<br />
<br />



	<table class="gtable sortable">
	<thead>
		<tr>
			<th width="55%"><a href="<?=$nullLink?>" field="reason_name" class="sortlink">Reject Reason Name</a></th>
			<th width="15%"><a href="<?=$nullLink?>" field="status" class="sortlink">Partner</a></th>
			<th width="15%"><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
			<th width="15%" class="head">Action</th>
		</tr>
		
	</thead>
	<tbody>
   <?php
	if(php72_count($reject_reasons))
	{   
		$r=1;
		foreach($reject_reasons as $reject_reason)
		{
			 $this->hris = $this->load->database('hris', TRUE);
			 $this->hris->select('branch_name');
			 $this->hris->where('id',$reject_reason['partner_id']);
			 $emp = $this->hris->get('hr_branch');
			 $branch_name = $emp->result_array();
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$reject_reason["master_name"]?></td>
			<td align="left" valign="middle"><?=$branch_name[0]["branch_name"]?></td>
			
			<td align="left" valign="middle"><?php
			if($reject_reason["status"]=='1') { ?>
			<a href="<?=site_url('master/master_settings/reject_reason_changestatus/'.$reject_reason['id'].'/0') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>

			<?php } else
			{?>
			<a href="<?=site_url('master/master_settings/reject_reason_changestatus/'.$reject_reason['id'].'/1') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
		   <?php }
			?></td>
			<td nowrap="nowrap">
			<a href="<?=site_url('master/master_settings/reject_reason_edit/'.$reject_reason['id'])?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>
			
			<a  class="confirmDelete" url="<?=site_url('master/master_settings/reject_reason_delete/'.$reject_reason['id'])?>"  ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
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
	<?php
	} ?>
		
	</tbody>
	</table>
	<!-- Paging style -->
	<?php echo  $this->pagination->create_links($form_name);?>
 
