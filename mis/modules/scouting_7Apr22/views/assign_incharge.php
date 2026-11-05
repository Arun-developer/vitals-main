<?php 
$isAssign = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
	$isAssign = true;
?>
<h1><?=$cpagetitle?></h1>
<table class="gtable detailtable">
    <thead>
        <tr>
            <th>Associate Member</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
	$restrict = array();
	foreach($inchargeList as $row): 
			$restrict[] = $row['associate_employee'];
	?>
        <tr>
            <td align="center"><?=$row['emp_name']?></td>
            <td align="center"><?php
			if($isAssign)
			{
				if($row["status"]=='1')
					echo anchor('scouting/change_associate_status/'.$row["id"].'/0/'.$row["innovation"],'<img src="'.base_url().'source/template/images/icons/active.png">'); 
				else
					echo anchor('scouting/change_associate_status/'.$row["id"].'/1/'.$row["innovation"],'<img src="'.base_url().'source/template/images/icons/inactive.png">');
			}
			else
			{
				if($row["status"]=='1')
					echo "Active";
				else
					echo "Inactive";
			}
			?></td>
        </tr>
        <?php 
	endforeach;
	
	?>
    </tbody>
</table>
<!-- Paging style -->
<?php 
if($isAssign)
{
?>
<script type="text/javascript">
$(document).ready(function() {
    $(".uniform").validate();
});
</script>

<h2>Assign - <?php echo $cpagetitle?> - <?=$innovation['name_of_enterprise']?></h2>
<form name="assignIncharge" enctype="multipart/form-data" action="<?=site_url('scouting/associate_assign_incharge/');?>"
    method="post" id="assignIncharge" class="uniform">
    <dl class="inline">
        <dt><label for="source_type">Employee:<font color="red">*</font></label></dt>
        <dd>
            <?php $associate_employee = isset($_REQUEST["associate_employee"])?$_REQUEST["associate_employee"]:array();     ?>
            <select id="associate_employee" class="required" multiple="multiple" name="associate_employee[]"
                style="height:105px;width: 280px;">
                <?php 
		 foreach($usersList as $row) {
			if(!in_array($row['emp_number'],$restrict)){
			 ?>
                <option value="<?=$row['emp_number']?>"
                    <?php if(in_array($row['emp_number'],$associate_employee)){  echo 'selected'; } ?>>
                    <?=$row['emp_name']?></option>
                <?php } } ?>

            </select>

            <?php echo form_error('report_data', '<div class="errorMsg">', '</div>'); ?>
        </dd>
    </dl>
    <div class="buttons">
        <input type="hidden" name="innovations" id="innovation_id" value="<?php echo $innovation['id'];?>" />
        <input type="submit" value="Assign" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>
<?php }?>
<!-- end id-form  -->