<span style="color:red;font-weight:bold;">
    <blink>[NB:Please Furnish the following information to carry out detail delligence.]*</blink>
</span><br>
<br>
<span style="font-weight:bold;">Overall</span><span id="progressPercentage"> </span>
<div id="progressbar"> </div>
<br>
<div id="progressbarByTab"> </div>
<div style="" witdh="100%">
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
<script type="text/javascript">
$(document).ready(function() {
    $("#produceDocs").hide();
    $("#showUpload").hide();
    $.metadata.setType("attr", "validate");
    jQuery.validator.addMethod("phone", function(value, element) {
        return this.optional(element) || /^[\+0-9\-]+$/.test(value);
    }, "Please Enter Valid Phone Number");
    jQuery.validator.addMethod("mobile", function(value, element) {
        return this.optional(element) || /^[\+0-9\-]+$/.test(value);
    }, "Please Enter Valid Mobile Number");
    $("#step1").validate();
});
</script>

<h1><?=$cpagetitle?> - <a href="<?php echo site_url('incubator_metrics/wglobal_report/index/81/2')?>"
        title="Global Report"> <?=$innovation['name_of_enterprise']?></a></h1>
<?php 
$this->load->view('criteria_tab');

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
        title="Innovator Details">[+]</a></span>
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
			$myanswer +=php72_count($fieldsList[$key]['answer']);
		}	
		
		 
	}	
?>
    <input type="hidden" name="txtQuestion" value="<?=$question?>" id="questionID" />
    <input type="hidden" name="txtAnswer" value="<?=$myanswer?>" id="answerID" />

    <?php
foreach($fieldsList as $row):

if($this->uri->segment(4) == '61' and $row['id'] == '134')
{
    $this->load->view('service',array('row' =>$row));
}
else
{
	if($row['input_type'] == 'Group'){ 
	echo '</fieldset><br /><fieldset><legend>'.$row['label'].'</legend>';
	}else{ ?>
    <dl class="inline fieldMain">
        <dt><label
                for="<?=$row['id']?>"><?php  echo $row['label']; if($row['required'] == 'yes'){ echo '&nbsp;<font class="req_field">*</font>'; }?></label>
        </dt>
        <dd>
            <?php
	$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:$row['answer'];
	$suQuesion = (php72_cmp($row['sub_field'])>0)?'showSubField':'';
	
	switch($row['input_type']){
		case 'Text':
			?>
            <input type="text" size="40"
                class="input-text <?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>" value="<?=$cfValue?>" />
            <?php
			break;
		case 'Textarea':
			?>
            <textarea cols="80" rows="5"
                class="input-text <?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>"><?=$cfValue?></textarea>
            <?php
			break;
		case 'Listbox':
			?>
            <select name="<?=$row['id']?>" id="<?=$row['id']?>"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>">
                <option value="">Select</option>
                <?php 
                                sort($row['value']);
                                foreach($row['value'] as $key=>$value): ?>
                <option value="<?=$value?>" <?=($cfValue==$value)?'selected':'';?>><?=$value?></option>
                <?php endforeach; ?>
            </select>
            <?php
			break;
		case 'Radio':
			foreach($row['value'] as $key=>$value): ?>
            <label><input type="radio" name="<?=$row['id']?>"
                    class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                    value="<?=$value?>" <?=($cfValue==$value)?'checked="checked"':'';?> />
                <?=$value?></label><br />
            <?php
			 endforeach;
			break;
		case 'Checkbox':
			$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:explode(',',$row['answer']);
			foreach($row['value'] as $key=>$value): ?>
            <label><input type="checkbox" name="<?=$row['id']?>[]"
                    class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                    value="<?=$value?>" <?=(php72_in_array($value,$cfValue))?'checked="checked"':'';?> />
                <?=$value?></label><br />
            <?php
			 endforeach;
			break;
		case 'File':
			 if($cfValue == ''){?>
            <input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>" />
            <?php } else { ?>
            <input type="file" value="<?=$cfValue;?>" size="40" name="<?=$row['id']?>" />
            <?php } ?>
            <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>" />
            <?php
			if($cfValue!=''){ ?> <?=$cfValue?><a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">
                <img src="<?=base_url();?>source/template/images/icons/download.gif" height="16" /></a><?php }
			break;
	}
	?>
        </dd>
    </dl>
    <?php
	 } 
}
endforeach; ?>


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
        <dl><span id="showdocumentpanel" style="margin-left:318px;">
                <input type="file" size="40" name="documentTestimonial" />
            </span>
        </dl>
        <dl>
            <div id="showYoutube" style="display:none;margin-left:317px;">
                <a href="http://www.youtube.com/" class="showYoutube button" target="_blank">Youtube</a>
                <div style="padding-top:5px;" class="youtubeField">
                    <input type="text" name="youtube[]" class="input-text" size="40" /><br />
                    Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank" style="color:#666;">
                        http://www.youtube.com/watch?v=F7lao4eonuI</a>
                    &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube">Hide</a>
                </div>
            </div>

        </dl>

    </dl>

    <?php } ?>
    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" class="button" name="txtSubmit" value="Save" id="submit" />&nbsp;&nbsp;
        <input type="reset" class="button white" name="txtReset" value="Reset" />
    </div>
</form>



<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
    $("#documentID").hide();
    var tabValue = $("#criteriatabID").val();
    var question = $("#questionID").val();
    var answer = $("#answerID").val();
    var Percentage = (answer / question) * 100;
    Percentage = Math.round(Percentage);

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
            Percentage + "%</span>";
        $("#progressbar").progressbar({
            value: 90,
        });
    }

    $("#showproduceDocs").click(function() {
        $("#produceDocs").slideToggle("slow");
    });

    $("#spanshowID").click(function() {

        $("#showUpload").toggle();
    });

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

function showDocs(value) {

    if (value == "document") {
        $('#showdocumentpanel').show();
    } else {
        $('#showdocumentpanel').hide();
    }
    if (value == "video") {
        $("#showYoutube").show();
    } else {
        $("#showYoutube").hide();
    }
}

function getSubFields(innovation, criteria, pid, parent_value) {

    var form_data = {
        innovation: innovation,
        criteria: criteria,
        pid: pid,
        parent_value: parent_value,
        ajax: '4'
    };
    contentQuesion = $.ajax({
        url: '<?=site_url('screening/ajax_subfield/');?>',
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
<script type="text/javascript">
// O2k7 skin (silver)
tinyMCE.init({
    // General options
    mode: "specific_textareas",
    editor_selector: "mceEditor",
    theme: "advanced",
    skin: "o2k7",
    width: 450,
    height: 200,
    skin_variant: "silver",
    plugins: "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

    // Theme options
    theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,
    file_browser_callback: "airfilemanager",
    document_base_url: BASE_URL,
    relative_urls: true,
    remove_scripts_host: false
});

function airfilemanager(field_name, url, type, win) {
    switch (type) {
        case "media":
        case "image":
        case "flash":
        case "file":
            break;
        default:
            return !1;
    }
    tinyMCE.activeEditor.windowManager.open({
        url: BASE_URL + "source/airfilemanager/afm.php" + "?type=" + type,
        width: 650,
        height: 500,
        inline: "yes",
        close_previous: "no"
    }, {
        window: win,
        input: field_name
    });
}
</script>