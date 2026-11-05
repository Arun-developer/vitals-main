<?php
$val = array();
$scaling_factor = array();
if (php72_count($gradeDetails)) {
    $val = (isset($_POST['id'])) ? $_POST : $gradeDetails['0'];
    $scaling_factor = @unserialize($val['scaling_factor']);
}

$val = (isset($_POST['id'])) ? $_POST : $val;
$scaling_factor = (isset($_REQUEST['scaling_factor'])) ? $_REQUEST['scaling_factor'] : $scaling_factor;
$program_type = isset($_REQUEST['program_type']) ? $_REQUEST['program_type'] : '';
$program_service_offering = isset($_REQUEST['program_service_offering']) ? $_REQUEST['program_service_offering'] : '';

$id = isset($val['id']) ? $val['id'] : '';
$program_stage = isset($val['program_stage']) ? $val['program_stage'] : '';
$category = isset($val['category']) ? $val['category'] : '';
$waitage = isset($val['waitage']) ? $val['waitage'] : '';
$criteria = isset($val['criteria']) ? $val['criteria'] : '';
$scale = isset($val['scale']) ? $val['scale'] : '6';

?>
<h1><?=$cpagetitle?></h1>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>

<form id="gradeList" action="<?=site_url('master/grade/form/' . $id)?>" method="post" name="gradeList" class="uniform">
<input type="hidden" name="id" value="<?=$id?>"  />

<dl class="inline">
<?php if ($id == '') {?>

		<dt><label for="program type">Program Type<font class="req_field">*</font></label></dt>
		<dd>
        <select name="program_type" id="programType" class="required" >
        <option value="">-Select-</option>
        <?php
foreach ($programType as $pt):
    ?>
            <option value="<?=$pt['id']?>" <?=($pt['id'] == $program_type) ? 'selected' : '';?>><?=$pt['master_name']?></option>
			<?php
endforeach;
    ?>
        </select>
		</dd>



		 <dt><label for="public service offering">Program Service Offering<font class="req_field">*</font></label></dt>
		<dd>

        <input type="hidden"  name="PSO" id="PSO" value="<?=$program_service_offering?>" />
        <select name="program_service_offering" id="programServiceOffering" class="required">
        <option value="">-Select-</option>
        </select>
		</dd>

		 <dt><label for="program stage">Program Stage<font class="req_field">*</font></label></dt>
		<dd>
        <input type="hidden"  name="PSTAGE" id="PSTAGE" value="<?=$program_stage?>" />
        <select name="program_stage" id="programStage" class="required">
        <option value="">-Select-</option>
        </select>
		</dd>

    <?php }?>

		<dt><label for="criteria">Criteria<font class="req_field">*</font></label></dt>
		<dd>
		<select name="category" class="required"  >
                <option value="">-Select-</option>
                <?php
foreach ($gradingCategory as $gc):
?>
                    <option value="<?=$gc['id']?>" <?=($gc['id'] == $category) ? 'selected' : '';?>><?=$gc['master_name']?></option><?php
endforeach;
?>
                </select>

		</dd>


		 <dt><label for="sub criteria">Sub-Criteria<font class="req_field">*</font></label></dt>
		<dd>
		<input type="text" name="criteria" value="<?=$criteria?>" size="40" class="input-text required"  />

		</td>


		 <dt><label for="weightage">Weightage<font class="req_field">*</font></label></dt>
		<dd>
		<input type="text" name="waitage" value="<?=$waitage?>"  size="40" class="input-text required" />
		</dd>

		<dt><label for="scale">Scale<font class="req_field">*</font></label></dt>
		<dd>
		<input type="text" name="scale" value="<?=$scale?>" size="40" class="input-text required" readonly="readonly" />
		</dd>

    <?php for ($i = 1; $i <= $scale; $i++) {?>

	     <dt><label for="scaling factor">Scaling Factor[<strong>Scale <?=$i?></strong>]<font class="req_field">*</font></label></dt>
		<dd>
	    	<textarea name="scaling_factor[]" class="input-text required" cols="40"><?=@$scaling_factor[$i - 1]?></textarea>
		</dd>

    <?php }?>


 </dl>

  <div class="buttons">
		<input type="submit" value="Save" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />

   </div>

<br />
	</form>
