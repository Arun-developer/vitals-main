<?php
$nullLink = "javascript:void(0);";
$form_name = "innovation_report";
?>
<script type="application/javascript">
    $(document).ready(function() {
    //get source list
    $("#sourceType").change(function(){
    sourceCombo(this.value);
    });
    if($("#sourceType").val()){
    sourceCombo($("#sourceType").val());
    }
    function sourceCombo(sourec_type)
    {
    var form_data = {
    source_type: sourec_type,
    ajax: '4'
    };
    $.ajax({
    url: '<?= site_url('master/source/get_source_combo'); ?>',
    type: 'POST',
    data: form_data,
    success: function(msg) {
    $('#sourceList').html(msg);
    $('#instanceList').html('<option value="">-Select-</option>');
    }
    });
    }
    //get instance list
    $("#sourceList").change(function(){
    instanceCombo(this.value);
    });
    if($("#sourceList").val()){
    instanceCombo($("#sourceType").val());
    }
    function instanceCombo(sourceid){
    var form_data = {
    source: sourceid,
    ajax: '4'
    };
    $.ajax({
    url: '<?= site_url('master/instance/get_instance_combo'); ?>',
    type: 'POST',
    data: form_data,
    success: function(msg) {
    $('#instanceList').html(msg);
    }
    });
    }
    });
</script>
<h1><?= $cpagetitle ?></h1>
<form id="<?= $form_name ?>" action="<?= site_url('common/report/innovation_report/' . $currentTab) ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <input type="hidden"  name="export" value=""  />
    <br />

    <div class="searchBox" style="display:none">
        <table class="gtable detailtable" cellpadding="5" style="width:45%; float:left">
            <tr>
                <td width="24%" align="right" >Source Type</td>
                <td width="73%">
                    <?php $source_type = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : ''; ?>
                    <select name="source_type"  id="sourceType">
                        <option value="">-Select-</option>
                        <option value="0" <?= ("0" == $source_type) ? 'selected' : ''; ?>>Direct Applications</option>
                        <?php
                        foreach ($sourceTypeList as $row):
                            ?>
                            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $source_type) ? 'selected' : ''; ?>><?= $row['master_name'] ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td width="24%" align="right" >Source</td>
                <td>
                    <select name="source"  id="sourceList">
                        <option value="">-Select-</option>
                    </select></td>
            </tr>
            <tr>
                <td width="24%" align="right" >Instance</td>
                <td>
                    <select name="instance" class="required" id="instanceList">
                        <option value="">-Select-</option>
                    </select></td>
                <td width="3%"></td>
            </tr>
            <tr>
                <td width="24%" align="right" valign="top">Date Applied:</td>
                <td>
                    <?php
                    $created_date = isset($_REQUEST['created_date']) ? $_REQUEST['created_date'] : '';
                    $created_date_to = isset($_REQUEST['created_date_to']) ? $_REQUEST['created_date_to'] : '';
                    ?>
                    <input type="text" name="created_date" value="<?= $created_date ?>" class="input-text" id="fromdate" />&nbsp;-&nbsp;
                    <input type="text" name="created_date_to" value="<?= $created_date_to ?>" class="input-text" id="todate"/>

                </td>
            </tr>
            <tr>
                <td width="24%" align="right" valign="top">Stage:</td>
                <td>
                    <?php
                    $stage_post = isset($_REQUEST['stage']) ? $_REQUEST['stage'] : "";
                    ?>
                    <select name="stage" >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($stage as $key => $value):
                            ?><option value="<?= $key ?>" <?= ((string) $key == $stage_post) ? 'selected' : ''; ?>><?= $value ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="24%" align="right" valign="top">Status:</td>
                <td>
                    <?php
                    $status_post = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
                    ?>
                    <select name="status" >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($status as $key => $value):
                            ?><option value="<?= $key ?>" <?= ((string) $key == $status_post) ? 'selected' : ''; ?>><?= $value ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td valign="top">
                    <input type="submit" value="Search" name="txtSubmit" class="button" />
                    <input type="reset" value="Reset" name="txtReset" class="button white" />
                </td>
            </tr>
        </table>
        <table class="gtable detailtable" style="width:45%;  float:left">
            <tr>
                <td width="39%" align="right" >Name of the Incubatee</td>
                <td width="58%">
                    <?php $name_of_enterprise = isset($_REQUEST["name_of_enterprise"]) ? $_REQUEST["name_of_enterprise"] : ''; ?>
                    <input type="text" value="<?= $name_of_enterprise ?>" name="name_of_enterprise" class="input-text" /></td>
            </tr>
            <tr>
                <td width="39%" align="right" >Person Incharge </td>
                <td><?php $person_incharge = isset($_REQUEST["person_incharge"]) ? $_REQUEST["person_incharge"] : ''; ?>
                    <select name="person_incharge"  >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" <?= ($person_incharge == $row['emp_number']) ? 'selected' : ''; ?>><?= $row['emp_name'] ?></option>
                            <?php
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td width="39%" align="right" >Identified by </td>
                <td><?php $created_by = isset($_REQUEST["created_by"]) ? $_REQUEST["created_by"] : ''; ?>
                    <select name="created_by"  >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" <?= ($created_by == $row['emp_number']) ? 'selected' : ''; ?>><?= $row['emp_name'] ?></option>
                        <?php } ?>

                    </select></td>
                <td width="3%"></td>
            </tr>
            <tr>
                <td width="39%" align="right" valign="top">Reference</td>
                <td>
                    <?php $reference = isset($_REQUEST["reference"]) ? $_REQUEST["reference"] : ''; ?>
                    <select name="reference"  >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($knowAboutUs as $key => $value) {
                            ?>
                            <option value="<?= $value ?>" <?= ($reference == $value) ? 'selected' : ''; ?>><?= $value ?></option>
                            <?php
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td width="39%" align="right" valign="top">Incubation Cycle</td>
                <td>
                    <?php $incubation_cycle = isset($_REQUEST["incubation_cycle"]) ? $_REQUEST["incubation_cycle"] : ''; ?>
                    <select name="incubation_cycle">
                        <option value="">-Select-</option>
                        <?php
                        foreach ($cycleList as $row):
                            ?>
                            <option value="<?= $row['id'] ?>" <?= ($incubation_cycle == $row['id']) ? 'selected' : ''; ?>><?= $row['master_name'] ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td width="39%" align="right" valign="top">Reasons for reject/on-hold</td>
                <td>
                    <?php $reasons = isset($_REQUEST["reasons"]) ? $_REQUEST["reasons"] : ''; ?>
                    <select name="reasons" >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($reasonsList as $row):
                            ?>
                            <option value="<?= $row['id'] ?>" <?= ($reasons == $row['id']) ? 'selected' : ''; ?>><?= $row['master_name'] ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select></td>
            </tr>

        </table>
    </div>
</form>
<div class="clear"></div>
<?php
$this->load->vars(array('form_name' => $form_name));
switch ($currentTab) {
    case 'default':
        $this->load->view('report/default_report');
        break;
    case 'stage':
        $this->load->view('report/stage_report');
        break;
    case 'stage':
        $this->load->view('report/resource_report');
        break;
    default:
        $this->load->view('report/resource_report');
        break;
}
?>
