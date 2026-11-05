<script type="text/javascript">
function change(value) {

    var goal = value;
    var innovation = <?php echo $innovation;?>;

    var datas = $.ajax({
        type: "POST",
        url: "<?php echo site_url('seedfunding/activities/get');?>",
        data: {
            'goals': goal,
            'innovation': innovation,
            'isajax': true
        },
        dataType: 'json',
        success: function(datas) {
            var m = populateSelectbox(datas);

            $('#sel_milestoneadd').find('option').remove().end().append(m);
        }
    });
}

function changes(value) {
    var installment = value;
    var innovation = <?php echo $innovation;?>;
    var datas = $.ajax({
        type: "POST",
        url: "<?php echo site_url('seedfunding/activities/getactivity');?>",
        data: {
            'installments': installment,
            'innovation': innovation,
            'isajax': true
        },
        dataType: 'json',
        success: function(datas) {
            var m = populateSelectsbox(datas);
            $('#sel_activityadd').find('option').remove().end().append(m);
        }
    });
}

function populateSelectsbox(optArray) {
    var option = '<option value="">Select</option>';
    $.each(optArray, function(i, value) {
        option += '<option value="' + optArray[i].id + '">' + optArray[i].activity + '</option>';
    });
    return option;
}

function populateSelectbox(optArray) {
    var option = '<option value="">Select</option>';
    $.each(optArray, function(i, value) {
        option += '<option value="' + optArray[i].id + '">' + optArray[i].milestone + '</option>';
    });
    return option;
}
var goal = $('#sel_goal').val();
if (goal) {
    change(goal);
}
var installment = $('#sel_installment').val();
if (installment) {
    change(installment);
}
</script>
<?php
		$formAction = site_url('seedfunding/activities/form/'.$innovation);
		$id = '';
		$val = array();
		$installment = array();
		if(count($activitiesDetails))
		{
			$val = $activitiesDetails['0'];
			$formAction = site_url('seedfunding/activities/form/'.$innovation.'/'.$val['id']);
			$id = $val['id'];
			$action = 'edit';
			$installment = $this->Msfactivities->getAmount($id);
		}
		else
			$action = 'add';
		
		if(isset($_POST['action'])){ $val = $_POST; }
		
		$goal = isset($val["goal"])?$val["goal"]:"";
		$milestone = isset($val["milestone"])?$val["milestone"]:""; 
		$activity = isset($val["activity"])?$val["activity"]:"";
		$from = isset($val["from"])?$val["from"]:"";
		$to = isset($val["to"])?$val["to"]:"";
		$vfunded = isset($val['vfunded'])?$val['vfunded']:"";
		
		
		$installment = $this->Msfactivities->getAmount($id);
?>
<h2><?=$cpagetitle?></h2>
<!-- start id-form -->

<style>
.ui-datepicker-calendar {
    display: none;
}
</style>


<form name="activitiesForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="activitiesForm">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />
    <input type="hidden" value="<?=$innovation?>" name="innovation" />
    <?php if($action=='edit'){ ?>
    <input type="hidden" value="<?=$val['goalid']?>" name="goal" />
    <input type="hidden" value="<?=$val['milestoneid']?>" name="milestone" />
    <input type="hidden" value="<?=$val['installment']?>" name="installment_id" />
    <input type="hidden" value="<?=$val['activity']?>" name="activity" />
    <?php } ?>

    <dl class="inline" style="width:600px">
        <p id="errormsg" style="color:red;"></p>
        <dt><label for="goal">Goal<font class="req_field">*</font></label></dt>
        <dd>
            <?php if($action=='edit'){?>
            <select class="required">
                <option value="<?=$val['goalid']?>" selected><?=$goal?></option>
            </select>
            <?php }else {
		?>
            <select name="goal" class="required" id="sel_goal" onchange="change(this.value);">
                <option value="">-Select-</option>
                <?php
            foreach($goalList as $pt):
                ?>
                <option value="<?=$pt['id']?>" <?=($goal == $pt['id'])?'selected':'';?>><?=$pt['goal']?></option><?php 
            endforeach;?>

            </select>
            <?php } ?>
        </dd>

        <dt><label for="milestone">Milestone<font class="req_field">*</font></label></dt>
        <dd>
            <?php if($action=='edit'){?>
            <select class="required">
                <option value="<?php $val['milestoneid'];?>" selected><?=$milestone?></option>
            </select>
            <?php } else { ?>
            <select name="milestone" id="sel_milestoneadd" class="required">
                <option value="">Select</option>
            </select>
            <?php } ?>
        </dd>

        <dt><label for="">Installment<font class="req_field">*</font></label></dt>
        <dd>
            <?php if($action=='edit'){?>
            <select class="required">
                <option value="<?php $val['installment'];?>" selected><?=$from?>-<?=$to;?></option>
            </select>
            <?php } else { ?>
            <select name="installment_id" id="sel_installment" class="required" onchange="changes(this.value)">
                <option value="">-Select-</option>
                <?php
            foreach($installmentList as $ins): ?>
                <option value="<?=$ins['id']?>" <?=($installment == $ins['id'])?'selected':'';?>><?=$ins['from']?> -
                    <?=$ins['to']?></option><?php 
            endforeach;
            ?>
            </select>
            <?php } ?>
        </dd>

        <dt><label for="">Villgro Fund (in Rs.)<font class="req_field">*</font></label></dt>
        <dd>
            <input type="text" name="vfunded" id="fund" value="<?= $vfunded;?>" class="input-text number required" />
        </dd>


    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" value="Submit" name="txtSubmit" id="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>

<!-- end id-form  -->

<script>
$('#txtSubmit').click(function() {
    var goal = $('#sel_goal').val();
    var mile = $('#sel_milestoneadd').val();
    var install = $('#sel_installment').val();
    var fund = $('#fund').val();

    if (goal == '' || mile == '' || install == '' || fund == '') {
        $('#errormsg').html('Enter mandatory fields*');
        return false;
    } else {
        $('#errormsg').html('');
    }
});
</script>