<span style="color:red;font-weight:bold;">
    <blink>[NB:Please Furnish the following information to carry out detail delligence.]*</blink>
</span><br>
<br>
<span style="font-weight:bold;">Overall</span><span id="progressPercentage"> </span>
<div id="progressbar"> </div>
<br>
<div id="progressbarByTab"> </div>
<div style="" witdh="">
    <span id="progressValue"></span>
    <span id="progressbarTabPercentage"> </span>
</div>
<br>
<?php
$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>
<?php 
	$this->load->view('criteria_tab');
	?>
<ul class="option-tab">
    <?php 

if(!$isincubAuth)
     { 
	$this->load->model("Mscreening");
	if(!$this->Mauth->isLogged()) { 
	$name = $innovation['name_of_enterprise'];
	$data = $this->Mscreening->getData($name);
	
	}
	 if(empty($data)) {
	 ?>
    <li><a href="<?=site_url('screening/form/'.$code.'/'.$criteria.'/edit');?>" class="button">Edit</a></li>

    <?php } } ?>

    <?php if($isAuth){ ?>
    <li><a href="#view_comments" class="button">Comments</a></li>
    <li><a href="<?=site_url('screening/create_docuemnt/'.$innovation['id']);?>" class="button white">Download as
            Document</a></li>
    <li> <a href="<?php echo site_url('screening/discussion/'.$code);?>" class="button">Discussion Board</a></li>
    <?php } ?>
</ul>
<?php
if($this->uri->segment(4) == '12') {
$this->load->model("Mscreening");
$this->load->model("Minnovation");
$innovationDetails = $this->Minnovation->getInnovationDetails($code);

?><br>

<div style="cursor:pointer;margin-right:790px;margin-top:10px;" id="spanshowID" title="Upload Photo">
    <?php if(!empty($innovationDetails['0']['profile_pics'])) {  ?>
    <img src="<?php echo base_url();?>uploads/screening/<?php echo $innovationDetails['0']['profile_pics']; ?>"
        alt="Profile Photo" height="86" width="80" />
    <?php } else { ?>
    <img src="<?php echo base_url();?>source/template/images/icons/facebook-persona.png" height="86" width="80"
        style="cursor:pointer;" alt="Profile Photo" />
    <?php } ?>
</div>

<div id="showUpload">
    <!-- Last Edited-->
    <form name="step1" action="<?=site_url('screening/uploadprofile/'.$code.'/'.$criteria);?>"
        enctype="multipart/form-data" method="post" class="uniform">
        <table>
            <?php if(!isset($_POST['uploadProfilePics'])) {	?>
            <input type="hidden" name="innovation" value="<?=$innovation['id']?>" />
            <tr>
                <td><label for="photo" style="font-weight:bold;"> Photograph of the Innovator</label></td>
                <td>
                    <div id="uniform-undefined" class="uploader">
                        <input class=" " type="file" name="uploadProfilePics" size="40" style="opacity: 0;">
                        <span class="filename" style="-moz-user-select: none;">No file selected</span>
                        <span class="action" style="-moz-user-select: none;">Choose File</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td> </td>
                <td><input type="submit" class="button" name="txtProfileSubmit" value="Save" id="submit" /> </td>

            </tr>
            <?php } ?>

        </table>
    </form>

</div>
<!-- Edit -->
<span id="showproduceDocs" style="color:green;font-weight:bold;margin-left:860px;"><a href="#"
        title="Innovator Details">[-]</a></span>
<div id="produceDocs">

    <?php
$isEdit = false;
$isAssignCycle = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isEdit = true;
	$isAssignCycle = true;
}

foreach($innovationDetails as $row):

if($row['created_by'] == $this->session->userdata('emp_number'))
	$isEdit = true;

if($isEdit){
?>
    <?php } ?>

    <table class="gtable detailtable">
        <thead>
            <tr>
                <th colspan="2"><?=$row['name_of_enterprise']?></th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>Name of the Promoter</td>
                <td><?=$row['name_of_entrepreneur']?></td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td><?=$row['phone_no']?></td>
            </tr>
            <tr>
                <td>Mobile Number</td>
                <td><?=$row['mobile_no']?></td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td><?=$row['email_id']?></td>
            </tr>
            <tr>
                <td>Address Line1</td>
                <td><?=$row['address_line1']?></td>
            </tr>
            <tr>
                <td>Address Line1</td>
                <td><?=$row['address_line2']?></td>
            </tr>

            <tr>
                <td>City</td>
                <td><?=$row['city']?></td>
            </tr>
            <tr>
                <td>District</td>
                <td><?=$row['district']?></td>
            </tr>
            <tr>
                <td>State</td>
                <td><?=$row['state']?></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><?=$row['country']?></td>
            </tr>
            <tr>
                <td>Pin Code</td>
                <td><?=$row['pincode']?></td>
            </tr>

            <tr>
                <td>Name of your Entreprise</td>
                <td><?=$row['name_of_enterprise']?></td>
            </tr>
            <tr>
                <td>Website(If available)</td>
                <td><a href="http://<?=str_replace('http://','',$row['website']);?>"
                        target="_blank"><?=$row['website']?></a></td>
            </tr>

            <tr>
                <td>Applied Date </td>
                <td><?=mysql2date($row['created_date'])?></td>
            </tr>


        </tbody>
    </table>
    <?php 
	endforeach;
	?>
</div>

<?php } ?>

<br />

<form name="step1" action="<?=site_url('screening/form/'.$code.'/'.$criteria);?>" enctype="multipart/form-data"
    method="post" id="step1" class="uniform">
    <input type="hidden" name="criteria" value="<?=$criteria?>" ID="criteriatabID" />
    <input type="hidden" name="innovation" value="<?=$innovation['id']?>" />

    <?php

	$count = php72_count($fieldsList);
	$question = 0;
	$answer = 0;
	$myanswer =0;
	foreach($fieldsList as $key => $value) {
				
		$question += php72_count($fieldsList[$key]['label']);
		if($fieldsList[$key]['answer'] == "") {
			$answer  = "0";
		} else {
			$answer += php72_count($fieldsList[$key]['answer']);		
			
		}	
		
		 $myanswer +=php72_count($fieldsList[$key]['answer']);
	}	
	
	?>
    <input type="hidden" name="txtQuestion" value="<?=$question?>" id="questionID" />
    <input type="hidden" name="txtAnswer" value="<?=$myanswer?>" id="answerID" />
    <?php
	
	$this->load->model('master/Mprogram_service');
	$answerincub = $this->Mscreening->getInnovationService($innovation['id']);
    $programService = $this->Mprogram_service->getProgramServiceCombo('46');
	$count = php72_count($programService);
	$questionIncubation = 0;
	$answerIncubation = 0;
	foreach($programService as $row) {
			
		$questionIncubation += php72_count($row['title']);
	}
	foreach($answerincub as $answerkey => $answervalue) {
			$answerIncubation += php72_count($answerincub[$answerkey]);	
	}
	
?>

    <input type="hidden" name="txtIncubationQuestion" value="<?=$questionIncubation?>" id="questionIncubationID" />
    <input type="hidden" name="txtIncubationAnswer" value="<?=$answerIncubation?>" id="answerIncubationID" />

    <?php

foreach($fieldsList as $row):

	if($this->uri->segment(4) == '61' and $row['id'] == '134')
	{
		$data['isView'] = $isView;
		$this->load->view('service',$data);
		?>

    <?php
	}
	else
	{
		if($row['input_type'] == 'Group')
		{
			echo '</fieldset><br /><fieldset><legend>'.$row['label'].'</legend>';
		}
		else
		{ ?>
    <dl class="inline fieldMain">
        <dt><label
                for="<?=$row['id']?>"><?php  echo $row['label']; if($row['required'] == 'yes'){ echo '&nbsp;<font class="req_field">*</font>'; }?>
                :
            </label></dt>
        <dd>
            <?php
		
			
			echo $cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:$row['answer'];
			$suQuesion = ($row['sub_field']>0)?'showSubField':'';
			switch($row['input_type']){
				case 'Text':
					?>
            <input type="hidden" size="40"
                class="input-text <?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>" value="<?=$cfValue?>" />
            <?php
					break;
				case 'Textarea':
					?>
            <textarea style="display:none;" cols="80" rows="5"
                class="input-text <?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>"><?=$cfValue?></textarea>
            <?php
					break;
				case 'Listbox':
					?>
            <select name="<?=$row['id']?>" style="display:none;" id="<?=$row['id']?>"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>">
                <option value="">Select</option>
                <?php foreach($row['value'] as $key=>$value): ?>
                <option value="<?=$value?>" <?=($cfValue==$value)?'selected':'';?>><?=$value?></option>
                <?php endforeach; ?>
            </select>
            <?php
					break;
				case 'Radio':
					foreach($row['value'] as $key=>$value): ?>
            <input type="hidden" name="<?=$row['id']?>"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                value="<?=$value?>" <?=($cfValue==$value)?'checked="checked"':'';?> />

            <?php
					 endforeach;
					break;
				case 'Checkbox':
					$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:explode(',',$row['answer']);
					foreach($row['value'] as $key=>$value): ?>
            <input type="hidden" name="<?=$row['id']?>[]"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                value="<?=$value?>" <?=(php72_in_array($value,$cfValue))?'checked="checked"':'';?> />
            <br />
            <?php
					 endforeach;
					break;
				case 'File':
					?>
            <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>" />
            <?php
					if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">
                <img src="<?=base_url();?>source/template/images/icons/download.gif" height="16" /></a><?php }
					break;
			}
			 ?>

        </dd>
    </dl>
    <?php
			
		}
			
	}
			
endforeach;
?>
    </fieldset>
    <?php if($this->uri->segment('4') == '13') { ?>
    <dl class="inline">
        <dt><label>Upload the testimonial (video/ Published Material): </label></dt>
        <dl style="margin-left:100px;">
            <select name="sltTesimonial" id="showDocsID" onchange="showDocs(this.value);">
                <option value="">--Select--</option>
                <option value="document">Testimonial Document </option>
                <option value="video">Testimonial Video </option>
            </select>
        </dl>
        <dl><span id="showdocumentpanel">

            </span>
        </dl>
        <dl>
            <div id="showYoutube" style="display:none">
                <a href="javascript:void(0);" class="showYoutube button">Youtube</a>
                <div style="padding-top:5px;" class="youtubeField">
                    <label>http://www.youtube.com/watch?v=F7lao4eonuI </label>
                    Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank" style="color:#666;">
                        http://www.youtube.com/watch?v=F7lao4eonuI</a>
                    &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube">Hide</a>
                </div>
            </div>

        </dl>

    </dl>

    <?php } ?>
    <dl class="inline">
    </dl>
</form>



<?php
if($isAuth)
{
?>
<h1 id="view_comments">Comments</h1>
<ul class="comments">
    <?php 
foreach($assessComments as $com):
?>
    <li>
        <div class="comment-body clearfix">
            <img class="comment-avatar" src="<?=base_url();?>source/template/images/icons/Comments.png" />

            <div><?=$com['comments']?></div>
        </div>
        <div class="links">
            <span class="date"><strong>Added Date :</strong><?=mysql2date($com['created_date'])?></span>
            <span class="date"><strong>Added By :</strong> <?=$com['created_emp']?></span>
            <a href="javascript:void(0);"
                url="<?=site_url('screening/delete_comments/'.$innovation['id'].'/'.$criteria.'/'.$com["id"],"delete",'class="button"');?>"
                class="confirmDelete delete">Delete</a>
        </div>
    </li>
    <?php
endforeach; 
?>
</ul>
<div style="clear:both"></div>
<form name="add_assess_comments" enctype="multipart/form-data"
    action="<?=site_url('screening/add_comments/'.$innovation['id'].'/'.$criteria)?>" method="post"
    id="add_assess_comments">
    <input type="hidden" name="assess_id" value="" />
    <fieldset>
        <legend>Post Comments</legend>
        <dl class="inline">
            <dt><label for="name">Comments<span class="req_field">*</span></label></dt>
            <dd><textarea name="comments" class="input-text required" rows="5" cols="80"></textarea></dd>
        </dl>
        <div class="buttons" style="margin-left:40%;">
            <input type="submit" value="Post Comments" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>


<?php }?>

<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    $("#add_assess_comments").validate();
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#showUpload").hide();
    $("#showproduceDocs").click(function() {
        $("#produceDocs").slideToggle("slow");
    });

    $("#spanshowID").click(function() {

        $("#showUpload").toggle();
    });


    var tabValue = $("#criteriatabID").val();
    var question = $("#questionID").val();
    var incubationQuestion = $("#questionIncubationID").val();
    var answer = $("#answerID").val();
    var incubationAnswer = $("#answerIncubationID").val();
    var Percentage = (answer / question) * 100;
    Percentage = Math.round(Percentage);
    var IncubationPercentage = (incubationAnswer / incubationQuestion) * 100;
    IncubationPercentage = Math.round(IncubationPercentage);
    if (tabValue == "11") {
        document.getElementById("progressValue").innerHTML = "Innovation Completed";
        document.getElementById("progressPercentage").innerHTML = "15%";
        document.getElementById("progressbarTabPercentage").innerHTML = "<span style='font-weight:bold;'>" +
            Percentage + "%</span>";
        $("#progressbar").progressbar({
            value: 15,
        });
        $("#progressbarByTab").progressbar({
            value: Percentage,
        });
    }
    if (tabValue == "12") {
        document.getElementById("progressValue").innerHTML = "Entrepreneur";
        document.getElementById("progressPercentage").innerHTML = "30%";
        document.getElementById("progressbarTabPercentage").innerHTML = "<span style='font-weight:bold;'>" +
            Percentage + "%</span>";
        $("#progressbar").progressbar({
            value: 30,
        });
        $("#progressbarByTab").progressbar({
            value: Percentage,
        });
    }
    if (tabValue == "13") {
        document.getElementById("progressValue").innerHTML = "Social Impact";
        document.getElementById("progressPercentage").innerHTML = "45%";
        document.getElementById("progressbarTabPercentage").innerHTML = "<span style='font-weight:bold;'>" +
            Percentage + "%</span>";
        $("#progressbar").progressbar({
            value: 45,
        });
        $("#progressbarByTab").progressbar({
            value: Percentage,
        });
    }
    if (tabValue == "14") {
        document.getElementById("progressValue").innerHTML = "Business Viability";
        document.getElementById("progressPercentage").innerHTML = "60%";
        document.getElementById("progressbarTabPercentage").innerHTML = "<span style='font-weight:bold;'>" +
            Percentage + "%</span>";
        $("#progressbar").progressbar({
            value: 60,
        });
        $("#progressbarByTab").progressbar({
            value: Percentage,
        });
    }
    if (tabValue == "15") {
        document.getElementById("progressValue").innerHTML = "Scalability";
        document.getElementById("progressPercentage").innerHTML = "75%";
        document.getElementById("progressbarTabPercentage").innerHTML = "<span style='font-weight:bold;'>" +
            Percentage + "%</span>";
        $("#progressbar").progressbar({
            value: 75,
        });
        $("#progressbarByTab").progressbar({
            value: Percentage,
        });
    }
    if (tabValue == "61") {
        document.getElementById("progressValue").innerHTML = "Incubation Fit";
        document.getElementById("progressPercentage").innerHTML = "90%";
        document.getElementById("progressbarTabPercentage").innerHTML = "<span style='font-weight:bold;'>" +
            IncubationPercentage + "%</span>";
        $("#progressbar").progressbar({
            value: 90,
        });
        $("#progressbarByTab").progressbar({
            value: IncubationPercentage,
        });
    }


    $('.showSubField').live('change', function() {
        id = $(this).attr('name');
        innovation = $('[name=innovation]').val();
        criteria = $('[name=criteria]').val();
        subQuersionContent = getSubFields(innovation, criteria, id, this.value);
        $('.' + id + '_subLevel').remove();
        $(this).parents('.fieldMain').after(subQuersionContent);
    });

    $('.showSubField').each(function() {
        var lp = true;
        id = $(this).attr('name');
        inputType = $(this).attr('type');
        if (inputType == 'radio' || inputType == 'checkbox') {
            if (!this.checked) {
                lp = false;
            }
        }
        if (lp) {
            innovation = $('[name=innovation]').val();
            criteria = $('[name=criteria]').val();
            subQuersionContent = getSubFields(innovation, criteria, id, this.value);
            $('.' + id + '_subLevel').remove();
            $(this).parents('.fieldMain').after(subQuersionContent);
            newval = $('#' + id + '_input').val();
        }
    });

});

function getSubFields(innovation, criteria, pid, parent_value) {

    var form_data = {
        innovation: innovation,
        criteria: criteria,
        pid: pid,
        parent_value: parent_value,
        ajax: '4'
    };
    contentQuesion = $.ajax({
        url: '<?=site_url('screening/ajax_subfield/view');?>',
        type: 'POST',
        data: form_data,
        async: false
    }).responseText;
    return contentQuesion;
}
</script>
<style type="text/css">
dt {
    width: 35% !important;
}

dd {
    width: 65% !important;
}

#progressbar {

    height: 15px;
}

#progressValue {

    color: black;
    font-weight: bold;

}

.ui-progressbar-value {
    background-image: url("../images/pbar-ani.gif");
    background-color: orange;
    height: 15px;
}

.ui-progressbar.end .ui-progressbar-value {
    background: green;
}

#progressPercentage {
    color: black;
    font-weight: bold;
    margin-left: 20px;
}
</style>