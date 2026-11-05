<!-- start id-form -->

<h2><?php
    if ($action == 'resume') {
        echo "Reopen - " . $innovation['name_of_enterprise'];
    } else {
        echo ucfirst($action) . " - " . $innovation['name_of_enterprise'];
    }
    ?></h2>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>

<form name="actionForm" id="actionForm" enctype="multipart/form-data"
      action="<?= site_url('scouting/action/' . $action . '/' . $innovation['id']); ?>" method="post">
    <input type="hidden" name="txtSubmit" value="1">
    <dl class="inline">
		<?php if($action!='resume'){ ?>
			<dt><label for="source_type">Status:<font color="red">*</font></label></dt>
				<dd>
				<select style="<?php if(isset($status_id) && $status_id!=''){echo "pointer-events: none !important;"; } ?>"  name="status" id="status" class="required">
					<option value="">-Select-</option>
					<option <?php if(isset($status_id) && $status_id!=''){if($status_id =='24'){ echo"selected"; }} ?> value="24">Open-Banked</option>
					<option <?php if(isset($status_id) && $status_id!=''){if($status_id =='2'){ echo"selected"; }} ?> value="3">Close</option>
				</select>
				<p id='statusMsg'></p>
				
			</dd>
		<?php } ?>
		<input type="hidden" id="hid_status" ></input>
	
        <dt><label for="source_type">Reasons:<font color="red">*</font></label></dt>
        <dd>
            <select name="reasons" id="reasons" class="required">
                <option value="">-Select-</option>
                <?php
                foreach ($reasonsList as $row):
                    ?>
                    <option value="<?= $row['id'] ?>"><?= $row['master_name'] ?></option>
                    <?php
                endforeach;
                ?>
            </select>
            <p id='reasonMsg'></p>
        </dd>
        <dt><label for="source_type">Comments:<font color="red">*</font></label></dt>
        <dd><textarea name="comments" id="comments" class="input-text required" cols="30" rows="5"></textarea>
            <p id='cmntMsg'></p>
        </dd>
    </dl>

    <div class="buttons">
        <input type="button" value="<?= ucfirst($action) ?>" id="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>

<!-- end id-form  -->

<script type="text/javascript">
    /* $(document).ready(function () {
        $('#reasonMsg').html('');
        $('#cmntMsg').html('');
    });

    $('#txtSubmit').click(function () {
        var reason = $('#reasons').val();
        var comment = $('#comments').val();
        if (reason == '' && comment != '') {
            $('#reasonMsg').html('Select reason');
            $('#cmntMsg').html('');
        }
        if (reason != '' && comment == '') {
            $('#reasonMsg').html('');
            $('#cmntMsg').html('Enter comments');
        }
        if (reason == '' && comment == '') {
            $('#reasonMsg').html('Select reason');
            $('#cmntMsg').html('Enter comments');
        }
        if (reason != '' && comment != '') {
            $('#reasonMsg').html('');
            $('#cmntMsg').html('');
            $("#actionForm").submit();
        }

    }); */
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#reasonMsg').html('');
        $('#cmntMsg').html('');
    });
	$(document).on('change','#status', function() {
		$("#hid_status").val('');
		var current_val = $(this).val();
		if(current_val !=''){
			$("#hid_status").val(current_val);
		}
	});
				

    $('#txtSubmit').click(function () {
        var reason = $('#reasons').val();
        var comment = $('#comments').val();
		var status = $('#status').val();
		
        if (status == '') {
            $('#statusMsg').html('Select status');
            $('#cmntMsg').html('');
        }
        if (reason != '' && comment == '') {
            $('#reasonMsg').html('');
            $('#cmntMsg').html('Enter comments');
        }
        if (reason == '' && comment == '') {
            $('#reasonMsg').html('Select reason');
            $('#cmntMsg').html('Enter comments');
        }
        if (reason != '' && comment != '' && status!='') {
            $('#reasonMsg').html('');
            $('#cmntMsg').html('');
            $("#actionForm").submit();
        }

    });
</script>

<style type="text/css">
    #fancybox-content {
        width: 410px !important;
    }

    #fancybox-wrap {
        width: 425px !important;
    }

    textarea {
        resize: none;
        width: 288px !important;
    }

    #reasonMsg {
        color: red;
        padding: 0px;
    }

    #cmntMsg {
        color: red;
        padding: 0px;
        margin-top: -7px;
    }
</style>