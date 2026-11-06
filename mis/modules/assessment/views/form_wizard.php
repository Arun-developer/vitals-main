<link rel="stylesheet" href="<?php  echo base_url()."source/template/FancySlidingForm/css/style.css"; ?>"
    type="text/css" media="screen" />
<script type="text/javascript" src="<?php  echo base_url()."source/template/FancySlidingForm/sliding.form.js"; ?>">
</script>
<script src="<?php  echo base_url()."source/template/FancySlidingForm/js/nicEdit-latest.js"; ?>" type="text/javascript">
</script>

<style>
span.reference {
    position: fixed;
    left: 5px;
    top: 5px;
    font-size: 10px;
    text-shadow: 1px 1px 1px #fff;
}

span.reference a {
    color: #555;
    text-decoration: none;
    text-transform: uppercase;
}

span.reference a:hover {
    color: #000;
}
</style>

<script type="text/javascript">
fCount = 0;

function addFileField() {
    fCount = fCount + 1;
    var id = 'file' + fCount;
    content = '<div id="' + id +
        '"><input type="file" name="documents[]"  />&nbsp;&nbsp;<a href="javascript:void(0);" style="color:red;" onclick="removeDiv(\'' +
        id + '\');" ><strong>( Remove )</strong></a><br/><br/></div>';

    $(content).appendTo('#multiFile');
}

function openScale(criteria) {
    $('.scaleFact_' + criteria).show();
}

function closeScale(criteria) {
    $('.scaleFact_' + criteria).hide();
}
</script>
<div id="content_slide">

    <div id="wrapper_slide">
        <div id="navigation_slide" style="display:none;">
            <ul id="navigation">
                <li id="first" class="<?php echo ($this->uri->segment('5') == '11') ? 'selected' : '';?>">
                    <a href="#">Innovation</a>
                </li>
                <li id="foo" class="<?php echo ($this->uri->segment('5') == '12') ? 'selected' : '';?>">
                    <a href="#">Entrepreneur</a>
                </li>
                <li class="<?php echo ($this->uri->segment('5') == '13') ? 'selected' : '';?>">
                    <a href="#">Social Impact</a>
                </li>
                <li class="<?php echo ($this->uri->segment('5') == '14') ? 'selected' : '';?>">
                    <a href="#">Business Viability</a>
                </li>
                <li class="<?php echo ($this->uri->segment('5') == '15') ? 'selected' : '';?>">
                    <a href="#">Scalability</a>
                </li>
                <li class="<?php echo ($this->uri->segment('5') == '61') ? 'selected' : '';?>">
                    <a href="#">Incubation Fit</a>
                </li>
                <li>
                    <a href="#">Files Upload</a>
                </li>
            </ul>
        </div>
        <div id="steps">
            <form name="add_assess_details" enctype="multipart/form-data"
                action="<?=site_url('assessment/formwizard/'.$innovation['id'])?>" method="post" id="add_assess_details"
                class="uniform">
                <fieldset class="step">
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[11][0]['id'];?>"
                        name="ass_id[]" />
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[11][0]['grading_id'];?>"
                        name="grad_id[]" />
                    <legend>Add Details - Innovation</legend>
                    <p>
                        <label for="score">Score</label>
                        <select name="score[]"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>>
                            <option value="">-- Select --</option>
                            <option value="1"
                                <?php echo (php72_cmp($assessDetails[11][0]['grade']) == 1) ? 'selected="selected"' : ''?>>1
                            </option>
                            <option value="2"
                                <?php echo (php72_cmp($assessDetails[11][0]['grade']) == 2) ? 'selected="selected"' : ''?>>2
                            </option>
                            <option value="3"
                                <?php echo (php72_cmp($assessDetails[11][0]['grade']) == 3) ? 'selected="selected"' : ''?>>3
                            </option>
                            <option value="4"
                                <?php echo (php72_cmp($assessDetails[11][0]['grade']) == 4) ? 'selected="selected"' : ''?>>4
                            </option>
                            <option value="5"
                                <?php echo (php72_cmp($assessDetails[11][0]['grade']) == 5) ? 'selected="selected"' : ''?>>5
                            </option>
                            <option value="6"
                                <?php echo (php72_cmp($assessDetails[11][0]['grade']) == 6) ? 'selected="selected"' : ''?>>6
                            </option>
                        </select>

                        <?php 
		
		foreach($gradesMasterList as $row): ?>

                        <?php 
        if($row['category'] == "11"){ 
		?>

                        <a href="javascript:openScale(11);" class="viewScaleFact_11">View</a>

                        <table class="scaleFact_11"
                            style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;  top: 35%; left: 20%;">
                            <tr>
                                <td align="center" valign="top" colspan="2">Scaling Factors ( <a
                                        href="javascript:closeScale(11);" class="closeScaleFact_11"
                                        style="color:red;">Close</a>)</td>
                            </tr>
                            <?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
                            <tr>
                                <td width="100" align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                                <td><?=$value?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>


                        <?php } ?>
                        <?php endforeach;?>

                    </p>
                    <p>
                        <label for="desc" style="height:100px;">Description</label>
                        <textarea name="desc[]" rows="5"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                            cols="60"
                            style="width: 50%; float:left"><?php echo !empty($assessDetails[11][0]['description']) ? strip_tags($assessDetails[11][0]['description']) : '';?></textarea>
                        <input type="hidden" name="criteria[]" value="11" />
                    </p>
                </fieldset>
                <fieldset class="step">
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[12][0]['id'];?>"
                        name="ass_id[]" />
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[12][0]['grading_id'];?>"
                        name="grad_id[]" />
                    <legend>Add Details - Entrepreneur</legend>
                    <p>
                        <label for="score">Score</label>
                        <select name="score[]"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>>
                            <option value="">-- Select --</option>
                            <option value="1"
                                <?php echo (php72_cmp($assessDetails[12][0]['grade']) == 1) ? 'selected="selected"' : ''?>>1
                            </option>
                            <option value="2"
                                <?php echo (php72_cmp($assessDetails[12][0]['grade']) == 2) ? 'selected="selected"' : ''?>>2
                            </option>
                            <option value="3"
                                <?php echo (php72_cmp($assessDetails[12][0]['grade']) == 3) ? 'selected="selected"' : ''?>>3
                            </option>
                            <option value="4"
                                <?php echo (php72_cmp($assessDetails[12][0]['grade']) == 4) ? 'selected="selected"' : ''?>>4
                            </option>
                            <option value="5"
                                <?php echo (php72_cmp($assessDetails[12][0]['grade']) == 5) ? 'selected="selected"' : ''?>>5
                            </option>
                            <option value="6"
                                <?php echo (php72_cmp($assessDetails[12][0]['grade']) == 6) ? 'selected="selected"' : ''?>>6
                            </option>
                        </select>

                        <?php foreach($gradesMasterList as $row): ?>
                        <?php 
        if($row['category'] == "12"){ ?>

                        <a href="javascript:openScale(12);" class="viewScaleFact_12">View</a>

                        <table class="scaleFact_12"
                            style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;  top: 35%; left: 20%;">
                            <tr>
                                <td align="center" valign="top" colspan="2">Scaling Factors ( <a
                                        href="javascript:closeScale(12);" class="closeScaleFact_12"
                                        style="color:red;">Close</a>)</td>
                            </tr>
                            <?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
                            <tr>
                                <td width="100" align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                                <td><?=$value?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>


                        <?php } ?>
                        <?php endforeach;?>


                    </p>
                    <p>
                        <label for="desc" style="height:100px;">Description</label>
                        <textarea name="desc[]" rows="5"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                            cols="60"
                            style="width: 55%;"><?php echo !empty($assessDetails[12][0]['description']) ? strip_tags($assessDetails[12][0]['description']) : '';?></textarea>
                        <input type="hidden" name="criteria[]" value="12" />
                    </p>
                </fieldset>
                <fieldset class="step">
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[13][0]['id'];?>"
                        name="ass_id[]" />
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[13][0]['grading_id'];?>"
                        name="grad_id[]" />
                    <legend>Add Details - Social Impact</legend>
                    <p>
                        <label for="score">Score</label>
                        <select name="score[]"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>>
                            <option value="">-- Select --</option>
                            <option value="1"
                                <?php echo (php72_cmp($assessDetails[13][0]['grade']) == 1) ? 'selected="selected"' : ''?>>1
                            </option>
                            <option value="2"
                                <?php echo (php72_cmp($assessDetails[13][0]['grade']) == 2) ? 'selected="selected"' : ''?>>2
                            </option>
                            <option value="3"
                                <?php echo (php72_cmp($assessDetails[13][0]['grade']) == 3) ? 'selected="selected"' : ''?>>3
                            </option>
                            <option value="4"
                                <?php echo (php72_cmp($assessDetails[13][0]['grade']) == 4) ? 'selected="selected"' : ''?>>4
                            </option>
                            <option value="5"
                                <?php echo (php72_cmp($assessDetails[13][0]['grade']) == 5) ? 'selected="selected"' : ''?>>5
                            </option>
                            <option value="6"
                                <?php echo (php72_cmp($assessDetails[13][0]['grade']) == 6) ? 'selected="selected"' : ''?>>6
                            </option>
                        </select>

                        <?php foreach($gradesMasterList as $row): ?>
                        <?php 
        if($row['category'] == "13"){ ?>

                        <a href="javascript:openScale(13);" class="viewScaleFact_13">View</a>

                        <table class="scaleFact_13"
                            style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;  top: 35%; left: 20%;">
                            <tr>
                                <td align="center" valign="top" colspan="2">Scaling Factors ( <a
                                        href="javascript:closeScale(13);" class="closeScaleFact_13"
                                        style="color:red;">Close</a>)</td>
                            </tr>
                            <?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
                            <tr>
                                <td width="100" align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                                <td><?=$value?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>


                        <?php } ?>
                        <?php endforeach;?>

                    </p>
                    <p>
                        <label for="desc" style="height:100px;">Description</label>
                        <textarea name="desc[]" rows="5"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                            cols="60"
                            style="width: 60%;"><?php echo !empty($assessDetails[13][0]['description']) ? strip_tags($assessDetails[13][0]['description']) : '';?></textarea>
                        <input type="hidden" name="criteria[]" value="13" />
                    </p>
                </fieldset>
                <fieldset class="step">
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[14][0]['id'];?>"
                        name="ass_id[]" />
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[14][0]['grading_id'];?>"
                        name="grad_id[]" />
                    <legend>Add Details - Business Viability</legend>
                    <p>
                        <label for="score">Score</label>
                        <select name="score[]"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>>
                            <option value="">-- Select --</option>
                            <option value="1"
                                <?php echo (php72_cmp($assessDetails[14][0]['grade']) == 1) ? 'selected="selected"' : ''?>>1
                            </option>
                            <option value="2"
                                <?php echo (php72_cmp($assessDetails[14][0]['grade']) == 2) ? 'selected="selected"' : ''?>>2
                            </option>
                            <option value="3"
                                <?php echo (php72_cmp($assessDetails[14][0]['grade']) == 3) ? 'selected="selected"' : ''?>>3
                            </option>
                            <option value="4"
                                <?php echo (php72_cmp($assessDetails[14][0]['grade']) == 4) ? 'selected="selected"' : ''?>>4
                            </option>
                            <option value="5"
                                <?php echo (php72_cmp($assessDetails[14][0]['grade']) == 5) ? 'selected="selected"' : ''?>>5
                            </option>
                            <option value="6"
                                <?php echo (php72_cmp($assessDetails[14][0]['grade']) == 6) ? 'selected="selected"' : ''?>>6
                            </option>
                        </select>

                        <?php foreach($gradesMasterList as $row): ?>
                        <?php 
        if($row['category'] == "14"){ ?>

                        <a href="javascript:openScale(14);" class="viewScaleFact_14">View</a>

                        <table class="scaleFact_14"
                            style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;  top: 35%; left: 20%;">
                            <tr>
                                <td align="center" valign="top" colspan="2">Scaling Factors ( <a
                                        href="javascript:closeScale(14);" class="closeScaleFact_14"
                                        style="color:red;">Close</a>)</td>
                            </tr>
                            <?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
                            <tr>
                                <td width="100" align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                                <td><?=$value?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>


                        <?php } ?>
                        <?php endforeach;?>

                    </p>
                    <p>
                        <label for="desc" style="height:100px;">Description</label>
                        <textarea name="desc[]" rows="5"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                            cols="60"
                            style="width: 60%;"><?php echo !empty($assessDetails[14][0]['description']) ? strip_tags($assessDetails[14][0]['description']) : '';?></textarea>
                        <input type="hidden" name="criteria[]" value="14" />
                    </p>
                </fieldset>
                <fieldset class="step">
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[15][0]['id'];?>"
                        name="ass_id[]" />
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[15][0]['grading_id'];?>"
                        name="grad_id[]" />
                    <legend>Add Details - Scalability</legend>
                    <p>
                        <label for="score">Score</label>
                        <select name="score[]"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>>
                            <option value="">-- Select --</option>
                            <option value="1"
                                <?php echo (php72_cmp($assessDetails[15][0]['grade']) == 1) ? 'selected="selected"' : ''?>>1
                            </option>
                            <option value="2"
                                <?php echo (php72_cmp($assessDetails[15][0]['grade']) == 2) ? 'selected="selected"' : ''?>>2
                            </option>
                            <option value="3"
                                <?php echo (php72_cmp($assessDetails[15][0]['grade']) == 3) ? 'selected="selected"' : ''?>>3
                            </option>
                            <option value="4"
                                <?php echo (php72_cmp($assessDetails[15][0]['grade']) == 4) ? 'selected="selected"' : ''?>>4
                            </option>
                            <option value="5"
                                <?php echo (php72_cmp($assessDetails[15][0]['grade']) == 5) ? 'selected="selected"' : ''?>>5
                            </option>
                            <option value="6"
                                <?php echo (php72_cmp($assessDetails[15][0]['grade']) == 6) ? 'selected="selected"' : ''?>>6
                            </option>
                        </select>

                        <?php foreach($gradesMasterList as $row): ?>
                        <?php 
        if($row['category'] == "15"){ ?>

                        <a href="javascript:openScale(15);" class="viewScaleFact_15">View</a>

                        <table class="scaleFact_15"
                            style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;  top: 35%; left: 20%;">
                            <tr>
                                <td align="center" valign="top" colspan="2">Scaling Factors ( <a
                                        href="javascript:closeScale(15);" class="closeScaleFact_15"
                                        style="color:red;">Close</a>)</td>
                            </tr>
                            <?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
                            <tr>
                                <td width="100" align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                                <td><?=$value?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>


                        <?php } ?>
                        <?php endforeach;?>

                    </p>
                    <p>
                        <label for="desc" style="height:100px;">Description</label>
                        <textarea name="desc[]" rows="5"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                            cols="60"
                            style="width: 60%;"><?php echo !empty($assessDetails[15][0]['description']) ? strip_tags($assessDetails[15][0]['description']) : '';?></textarea>
                        <input type="hidden" name="criteria[]" value="15" />
                    </p>
                </fieldset>
                <fieldset class="step">
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[61][0]['id'];?>"
                        name="ass_id[]" />
                    <input type="hidden"
                        value="<?=(isset($exist) && (php72_cmp($exist)==0 || $exist == ''))?'':$assessDetails[61][0]['grading_id'];?>"
                        name="grad_id[]" />
                    <legend>Add Details - Incubation Fit</legend>
                    <p>
                        <label for="score">Score</label>
                        <select name="score[]"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>>
                            <option value="">-- Select --</option>
                            <option value="1" <?php echo (php72_cmp($assessDetails[61][0]['grade']) == 1) ? 'selected' : ''?>>1
                            </option>
                            <option value="2" <?php echo (php72_cmp($assessDetails[61][0]['grade']) == 2) ? 'selected' : ''?>>2
                            </option>
                            <option value="3" <?php echo (php72_cmp($assessDetails[61][0]['grade']) == 3) ? 'selected' : ''?>>3
                            </option>
                            <option value="4" <?php echo (php72_cmp($assessDetails[61][0]['grade']) == 4) ? 'selected' : ''?>>4
                            </option>
                            <option value="5" <?php echo (php72_cmp($assessDetails[61][0]['grade']) == 5) ? 'selected' : ''?>>5
                            </option>
                            <option value="6" <?php echo (php72_cmp($assessDetails[61][0]['grade']) == 6) ? 'selected' : ''?>>6
                            </option>
                        </select>

                        <?php foreach($gradesMasterList as $row): ?>
                        <?php 
        if($row['category'] == "61"){ ?>

                        <a href="javascript:openScale(61);" class="viewScaleFact_61">View</a>

                        <table class="scaleFact_61"
                            style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;  top: 35%; left: 20%;">
                            <tr>
                                <td align="center" valign="top" colspan="2">Scaling Factors ( <a
                                        href="javascript:closeScale(61);" class="closeScaleFact_61"
                                        style="color:red;">Close</a>)</td>
                            </tr>
                            <?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
                            <tr>
                                <td width="100" align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                                <td><?=$value?></td>
                            </tr>
                            <?php endforeach;?>
                        </table>


                        <?php } ?>
                        <?php endforeach;?>

                    </p>
                    <p>
                        <label for="desc" style="height:100px;">Description</label>
                        <textarea name="desc[]" rows="5" cols="60"
                            <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                            style="width: 60%;"><?php echo !empty($assessDetails[61][0]['description']) ? strip_tags($assessDetails[61][0]['description']) : '';?></textarea>
                        <input type="hidden" name="criteria[]" value="61" />
                    </p>
                </fieldset>
                <fieldset class="step">
                    <legend>Add Details - Files upload</legend>
                    <p>
                        <label for="link">Link</label>
                        <input type="hidden" name="criteria[]" value="upfiles" />
                        <span id="addinputdocLink">
                            <span class="plink">
                                <input type="text" name="documentsLink[]"
                                    <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                                    value="" placeholder="Please enter you link" />
                                <?php if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))){?>
                                <a href="#" id="addNewdocLink">Add</a>
                                <?php } ?>
                            </span>
                            <br />
                            <table style="margin-left:200px;">
                                <?php
        
          foreach ($files as $row) {
                if($row['link'] != '')
                {
                  ?>
                                <tr>
                                    <td><a href="<?php echo $row['links'];?>"
                                            target="_blank"><?php echo $row['links'];?></a></td>
                                </tr>
                                <?php
                }
           } 
          ?>
                            </table>
                        </span>
                    </p>
                    <p>
                        <span id="addinputdocFile">
                            <label for="document">Documents</label>
                            <span class="pfile">
                                <input style="float:left;" type="file"
                                    <?php echo (in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))) ? '' : 'disabled="disabled"'?>
                                    name="documents[]" />
                                <?php if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge))){?>
                                <a class="file_up" href="#" id="addNewdocFile">Add</a>
                                <?php } ?>
                            </span>
                            <br />
                            <table style="margin-left:200px;">
                                <?php 
         foreach ($files as $row) {
                if($row['documents'] != '')
                {
                  ?>
                                <tr>
                                    <td><a href="<?=base_url();?>uploads/assessment/<?php echo $row['documents'];?>"
                                            target="_blank"><?php echo $row['documents'];?></a></td>
                                </tr>
                                <?php
                }
           } 
          ?>
                            </table>
                        </span>

                    </p>

                </fieldset>

            </form>
        </div>
    </div>
    <?php if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || (php72_in_array($this->session->userdata('emp_number'),$assigned_incharge)))
	{?>
    <p style="margin-left:330px;"><input type="submit" id="submit" value="Submit" name="txtSubmit">&nbsp;<input
            type="button" id="reset" value="Reset"></p>
    <?php } ?>
</div>
<script type="text/javascript">
$(function() {

    $('#first').addClass('selected');

    $('#reset').click(function() {
        $('#add_assess_details')[0].reset();
    });

    $('#submit').click(function() {
        $('#add_assess_details').submit();

    });

    $('.selected  a').trigger('click');

    var addDiv = $('#addinputdocLink');
    var i = $('#addinputdocLink .plink').size() + 1;

    $('#addNewdocLink').live('click', function() {
        $('<span class="plink"><br/><br/> <label for="link">Link</label><input type="text"  name="documentsLink[]" value="" placeholder="Please enter you link" /><a href="#" id="remNew">Remove</a> </span>')
            .appendTo(addDiv);
        i++;
        return false;
    });

    $('#remNew').live('click', function() {
        if (i > 2) {
            $(this).parents('.plink').remove();
            i--;
        }
        return false;
    });



    var addinputFile = $('#addinputdocFile');
    var j = $('#addinputdocFile .pfile').size() + 1;

    $('#addNewdocFile').live('click', function() {
        $('<span class="pfile"><br/><br/> <label for="document">Documents</label>	  <input type="file" name="documents[]" />&nbsp;&nbsp;<a href="#" style="margin-left:60px;" id="remNewfile">Remove</a></span>')
            .appendTo(addinputFile);
        j++;
        return false;
    });

    $('#remNewfile').live('click', function() {
        if (j > 2) {
            $(this).parents('.pfile').remove();
            j--;
        }
        return false;
    });


});
</script>