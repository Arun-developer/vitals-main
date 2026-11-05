<?php
$formAction = site_url('master/reports/form');
$id = '';
$val = array();
if (php72_count($reportsDetails)) {
    $val = $reportsDetails['0'];
    $formAction = site_url('master/reports/form/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}

$report_type = isset($val["report_type"]) ? $val["report_type"] : "";
$report_name = isset($val["report_name"]) ? $val["report_name"] : "";
$report_data = isset($val["report_data"]) ? $val["report_data"] : array();

$reportFields = $this->Mreports->getReportFields($report_type);
?>
<ul class="option-tab">
<li><a href="<?=site_url('master/reports/view_list/');?>" class="button" >Back</a></li>
</ul>
<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<form name="reportForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="reportForm" class="uniform" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<dl class="inline">

     	<dt><label for="report type">Report Type :</label></dt>
     	<dd>
            <select name="report_type" id="report_type" onchange="this.form.submit();" class="required">
            <option value="">Select</option>
            <?php foreach ($reportTypes as $key => $value) {?>
            <option value="<?=$key?>" <?php echo ($report_type == $key) ? ('selected') : (''); ?>><?=$value?></option>
            <?php }?>
            </select>
            <font class="req_field">*</font>
            <?php echo form_error('report_type', '<div class="errorMsg">', '</div>'); ?>
		</dd>



	  	<dt><label for="report name">Report Name :</label></dt>
		<dd>
         <input type="text" value="<?=$report_name?>" class="input-text required" size="40" name="report_name" />
		 <font class="req_field">*</font>
		 <?php echo form_error('report_name', '<div class="errorMsg">', '</div>'); ?>
        </dd>


	  	<dt><label for="report type">Report Fields:</dt>
		<dd>
           <select id="report_data" class="multiselect required" multiple="multiple" name="report_data[]" >
             <?php foreach ($reportFields as $key => $value) {?>
                <option value="<?=$key?>" <?php if (php72_in_array($key, $report_data)) {echo 'selected="selected"';}?>>
                <?=$value?></option>
             <?php }?>
          </select>
          <font class="req_field">*</font>
          <?php echo form_error('report_data', '<div class="errorMsg">', '</div>'); ?>
		</dd>
</dl>
    <div class="buttons">
		<input type="submit" value="Search" name="txtSubmit" class="button"  />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
   </div>

</form>

<!-- end id-form  -->



