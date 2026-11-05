<h1 style="margin: 15px 0 10px;"><?= $cpagetitle ?></h1>
<?php $master_type = isset($currentTab) ? $currentTab : ''; ?>
<div style=" float:right; text-align:right;width:100%;">
    <?php echo anchor("master/master_settings/portfolio_list/$add_page", 'Back', 'class="button"'); ?>
</div>

<?php
$url = 'master/master_settings/portfolio_add';
if (isset($portfolio[0]['id'])) {
    $url = 'master/master_settings/portfolio_edit';
}
if ($errormsg) {
    ?>
    <p style="color:red"><?php
        echo $errormsg;
    }
    ?>

<form name="templateForm" enctype="multipart/form-data" action="<?= site_url($url); ?>" method="post" id="masterForm" class="uniform" >
    <dl class="inline">
        <dt><label for="master_type">Master Type<span class="error">*</span></label></dt>
        <dd>
            <?php if (!isset($portfolio[0]['id'])) { ?>
                <select name="master_type"  class="required" id="master_type" onchange="select_form(this.value);" >
                    <option value="">--Select--</option>
                    <?php foreach ($protoType as $key => $value) { ?>
                        <option value="<?= $value ?>" <?php
                        if ($key == $add_page) {
                            echo 'selected';
                        }
                        ?> ><?= $value; ?></option>
                            <?php } ?>
                </select>
            <?php } else { ?>
                <?php
                foreach ($protoType as $key => $value) {
                    if ($key == $currentTab) {
                        ?>
                        <input type="text" name="master_type" id="master_type" readonly value="<?php echo $value; ?>" />
                        <?php
                    }
                }
                ?>
                <?php
            }
            echo form_error('master_type', '<div class="errorMsg">', '</div>');
            ?>
        </dd>

        <div id="otherForm">
            <dt><label for="master_name">Master Name<span class="error">*</span></label></dt>
            <dd>
                <?php
                $master_name = isset($master_portfolio) ? $master_portfolio : "";
                echo form_input("master_name", $master_name, 'id="master_name" class="input-text required"');
                echo form_error('master_name', '<div class="errorMsg">', '</div>');
                ?>
            </dd>
        </div>

        <div id="companyForm">
            <dt><label for="sector_name">Sector<span class="error">*</span></label></dt>
            <dd>
                <?php $get_sector = isset($sector_name) ? $sector_name : ""; ?>
                <select name="sector_name" id="sector_name" class="required" >
                    <option value="" >--Select--</option>
                    <?php foreach ($sector_details as $sector) { ?>
                        <option value="<?php echo $sector['id']; ?>" <?php
                        if ($get_sector == $sector['id']) {
                            echo 'selected';
                        }
                        ?>> <?php echo $sector['sector']; ?> </option>
                            <?php } ?>
                </select>
            </dd>
            <dt><label for="f_year">Financial Year<span class="error">*</span></label></dt>
            <dd>
                <?php $get_year = isset($fy_year) ? $fy_year : ""; ?>
                <select name="f_year" id="f_year" class="required" >
                    <option value="" >--Select--</option>
                    <?php foreach ($fin_year as $year) { ?>
                        <option value="<?php echo $year['fin_year']; ?>" <?php
                        if ($get_year == $year['fin_year']) {
                            echo 'selected';
                        }
                        ?>> <?php echo $year['fin_year']; ?> </option>
                            <?php } ?>
                </select>
            </dd>
            <div class="revenueYears">
                <table>
                    <tr>
                        <th></th>
                        <th align='center'>Application</th>
                        <th align='center'>PA/RD</th>
                        <th align='center'>Deals at IIC</th>
                        <th align='center'>Deals at EIC</th>
                        <th align='center'>Total Incubatees</th>
                        <th align='center'>New Incubatees</th>
                        <th align='center'>Exit Incubatees</th>
                    </tr>

                    <?php
                    $get_app_q1 = isset($app_q1) ? $app_q1 : "";
                    $get_app_q2 = isset($app_q2) ? $app_q2 : "";
                    $get_app_q3 = isset($app_q3) ? $app_q3 : "";
                    $get_app_q4 = isset($app_q4) ? $app_q4 : "";
                    $get_app_annual = isset($app_annual) ? $app_annual : "";

                    $get_pard_q1 = isset($pard_q1) ? $pard_q1 : "";
                    $get_pard_q2 = isset($pard_q2) ? $pard_q2 : "";
                    $get_pard_q3 = isset($pard_q3) ? $pard_q3 : "";
                    $get_pard_q4 = isset($pard_q4) ? $pard_q4 : "";
                    $get_pard_annual = isset($pard_annual) ? $pard_annual : "";

                    $get_iic_q1 = isset($iic_q1) ? $iic_q1 : "";
                    $get_iic_q2 = isset($iic_q2) ? $iic_q2 : "";
                    $get_iic_q3 = isset($iic_q3) ? $iic_q3 : "";
                    $get_iic_q4 = isset($iic_q4) ? $iic_q4 : "";
                    $get_iic_annual = isset($iic_annual) ? $iic_annual : "";

                    $get_eic_q1 = isset($eic_q1) ? $eic_q1 : "";
                    $get_eic_q2 = isset($eic_q2) ? $eic_q2 : "";
                    $get_eic_q3 = isset($eic_q3) ? $eic_q3 : "";
                    $get_eic_q4 = isset($eic_q4) ? $eic_q4 : "";
                    $get_eic_annual = isset($eic_annual) ? $eic_annual : "";

                    $get_tot_q1 = isset($tot_q1) ? $tot_q1 : "";
                    $get_tot_q2 = isset($tot_q2) ? $tot_q2 : "";
                    $get_tot_q3 = isset($tot_q3) ? $tot_q3 : "";
                    $get_tot_q4 = isset($tot_q4) ? $tot_q4 : "";
                    $get_tot_annual = isset($tot_annual) ? $tot_annual : "";

                    $get_new_q1 = isset($new_q1) ? $new_q1 : "";
                    $get_new_q2 = isset($new_q2) ? $new_q2 : "";
                    $get_new_q3 = isset($new_q3) ? $new_q3 : "";
                    $get_new_q4 = isset($new_q4) ? $new_q4 : "";
                    $get_new_annual = isset($new_annual) ? $new_annual : "";

                    $get_ext_q1 = isset($ext_q1) ? $ext_q1 : "";
                    $get_ext_q2 = isset($ext_q2) ? $ext_q2 : "";
                    $get_ext_q3 = isset($ext_q3) ? $ext_q3 : "";
                    $get_ext_q4 = isset($ext_q4) ? $ext_q4 : "";
                    $get_ext_annual = isset($ext_annual) ? $ext_annual : "";
                    ?>

                    <tr>
                        <td>Q1<span class="error">*</span></td>
                        <td>
                            <?php
                            echo form_input("app_q1", $get_app_q1, 'id="app_q1" class="input-text required numberField apptotal"');
                            echo form_error('app_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("pard_q1", $get_pard_q1, 'id="pard_q1" class="input-text required numberField pardtotal"');
                            echo form_error('pard_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("iic_q1", $get_iic_q1, 'id="iic_q1" class="input-text required numberField iictotal"');
                            echo form_error('iic_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("eic_q1", $get_eic_q1, 'id="eic_q1" class="input-text required numberField eictotal"');
                            echo form_error('eic_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("tot_q1", $get_tot_q1, 'id="tot_q1" class="input-text required numberField cmptotal"');
                            echo form_error('tot_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("new_q1", $get_new_q1, 'id="new_q1" class="input-text required numberField newtotal"');
                            echo form_error('new_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("ext_q1", $get_ext_q1, 'id="ext_q1" class="input-text required numberField exttotal"');
                            echo form_error('ext_q1', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Q2<span class="error">*</span></td>
                        <td>
                            <?php
                            echo form_input("app_q2", $get_app_q2, 'id="app_q2" class="input-text required numberField apptotal"');
                            echo form_error('app_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("pard_q2", $get_pard_q2, 'id="pard_q2" class="input-text required numberField pardtotal"');
                            echo form_error('pard_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("iic_q2", $get_iic_q2, 'id="iic_q2" class="input-text required numberField iictotal"');
                            echo form_error('iic_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("eic_q2", $get_eic_q2, 'id="eic_q2" class="input-text required numberField eictotal"');
                            echo form_error('eic_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("tot_q2", $get_tot_q2, 'id="tot_q2" class="input-text required numberField cmptotal"');
                            echo form_error('tot_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("new_q2", $get_new_q2, 'id="new_q2" class="input-text required numberField newtotal"');
                            echo form_error('new_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("ext_q2", $get_ext_q2, 'id="ext_q2" class="input-text required numberField exttotal"');
                            echo form_error('ext_q2', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Q3<span class="error">*</span></td>
                        <td>
                            <?php
                            echo form_input("app_q3", $get_app_q3, 'id="app_q3" class="input-text required numberField apptotal"');
                            echo form_error('app_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("pard_q3", $get_pard_q3, 'id="pard_q3" class="input-text required numberField pardtotal"');
                            echo form_error('pard_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("iic_q3", $get_iic_q3, 'id="iic_q3" class="input-text required numberField iictotal"');
                            echo form_error('iic_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("eic_q3", $get_eic_q3, 'id="eic_q3" class="input-text required numberField eictotal"');
                            echo form_error('eic_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("tot_q3", $get_tot_q3, 'id="tot_q3" class="input-text required numberField cmptotal"');
                            echo form_error('tot_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("new_q3", $get_new_q3, 'id="new_q3" class="input-text required numberField newtotal"');
                            echo form_error('new_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("ext_q3", $get_ext_q3, 'id="ext_q3" class="input-text required numberField exttotal"');
                            echo form_error('ext_q3', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Q4<span class="error">*</span></td>
                        <td>
                            <?php
                            echo form_input("app_q4", $get_app_q4, 'id="app_q4" class="input-text required numberField apptotal"');
                            echo form_error('app_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("pard_q4", $get_pard_q4, 'id="pard_q4" class="input-text required numberField pardtotal"');
                            echo form_error('pard_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("iic_q4", $get_iic_q4, 'id="iic_q4" class="input-text required numberField iictotal"');
                            echo form_error('iic_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("eic_q4", $get_eic_q4, 'id="eic_q4" class="input-text required numberField eictotal"');
                            echo form_error('eic_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("tot_q4", $get_tot_q4, 'id="tot_q4" class="input-text required numberField cmptotal"');
                            echo form_error('tot_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("new_q4", $get_new_q4, 'id="new_q4" class="input-text required numberField newtotal"');
                            echo form_error('new_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("ext_q4", $get_ext_q4, 'id="ext_q4" class="input-text required numberField exttotal"');
                            echo form_error('ext_q4', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Annual<span class="error">*</span></td>
                        <td>
                            <?php
                            echo form_input("app_annual", $get_app_annual, 'id="app_annual" class="input-text required numberField apptotal" readonly="readonly"');
                            echo form_error('app_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("pard_annual", $get_pard_annual, 'id="pard_annual" class="input-text required numberField pardtotal" readonly="readonly"');
                            echo form_error('pard_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("iic_annual", $get_iic_annual, 'id="iic_annual" class="input-text required numberField iictotal" readonly="readonly"');
                            echo form_error('iic_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("eic_annual", $get_eic_annual, 'id="eic_annual" class="input-text required numberField eictotal" readonly="readonly"');
                            echo form_error('eic_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("tot_annual", $get_tot_annual, 'id="tot_annual" class="input-text required numberField cmptotal" readonly="readonly"');
                            echo form_error('tot_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("new_annual", $get_new_annual, 'id="new_annual" class="input-text required numberField newtotal" readonly="readonly"');
                            echo form_error('new_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                        <td>
                            <?php
                            echo form_input("ext_annual", $get_ext_annual, 'id="ext_annual" class="input-text required numberField exttotal" readonly="readonly"');
                            echo form_error('ext_annual', '<div class="errorMsg">', '</div>');
                            ?>
                        </td>
                    </tr>
                </table>
            </div>


        </div>

        <?php if ($this->session->userdata['isSuperAdmin'] == 'Yes') { ?>
            <dt><label for="partner_id">Partner Type</label></dt>
            <dd>
                <select name="partner_id" id="partner_id" required="">
                    <?php foreach ($branch as $partner) { ?>
                        <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $partner_branch ? 'selected' : ''); ?>>
                            <?php echo $partner['branch_name']; ?> </option>
                    <?php } ?>
                </select>
            </dd>
        <?php } ?>

    </dl>

    <?php
    $text = 'Add';
    if (isset($portfolio[0]['id']))
        $text = 'Update';
    ?>

    <input type="hidden" name="id" value="<?php echo $portfolio[0]['id']; ?>" />
    <div class="buttons">
        <button type="submit" class="button" value="Save" name="txtSubmit"><?php echo $text; ?></button>
        <button type="reset" class="button white">Reset</button>
    </div>

</form>

<style>
    .revenueYears{
        display: inline-block;
        width: 100%;
    }
    .revenueYears dl{
        width: 22% !important;
        display: inline;
        float: left;
        margin-bottom: 0 !important;
    }
    .revenueYears dl dt, .revenueYears dl dd{
        width: 100% !important;
    }
    .revenueYears dl dd input{
        width: 120px !important;
    }
    .error {color: red;}
    form label.error{display: inline-block;}
    .revenueYears table tr td{
        padding-left:10px;
        padding-bottom:20px;
    }
    .revenueYears table tr td input{
        width:100px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {
        var m_id = $('#master_type').val();
        select_form(m_id);
    });

    function innovation(id) {
        $("#txtSubmit").click();
    }

    function select_form(name) {
        if (name == 'Sector Target') {
            $('#otherForm').hide();
            $('#companyForm').show();
            $("#master_name").removeClass('required');
            $("#sector_name, #f_year").addClass('required');
            $("#app_q1, #app_q2, #app_q3, #app_q4, #app_annual").addClass('required');
            $("#pard_q1, #pard_q2, #pard_q3, #pard_q4, #pard_annual").addClass('required');
            $("#iic_q1, #iic_q2, #iic_q3, #iic_q4, #iic_annual").addClass('required');
            $("#eic_q1, #eic_q2, #eic_q3, #eic_q4, #eic_annual").addClass('required');
            $("#tot_q1, #tot_q2, #tot_q3, #tot_q4, #tot_annual").addClass('required');
            $("#new_q1, #new_q2, #new_q3, #new_q4, #new_annual").addClass('required');
            $("#ext_q1, #ext_q2, #ext_q3, #ext_q4, #ext_annual").addClass('required');
        } else {
            $('#companyForm').hide();
            $('#otherForm').show();
            $("#master_name").addClass('required');
            $("#sector_name, #f_year").removeClass('required');
            $("#app_q1, #app_q2, #app_q3, #app_q4, #app_annual").removeClass('required');
            $("#pard_q1, #pard_q2, #pard_q3, #pard_q4, #pard_annual").removeClass('required');
            $("#iic_q1, #iic_q2, #iic_q3, #iic_q4, #iic_annual").removeClass('required');
            $("#eic_q1, #eic_q2, #eic_q3, #eic_q4, #eic_annual").removeClass('required');
            $("#tot_q1, #tot_q2, #tot_q3, #tot_q4, #tot_annual").removeClass('required');
            $("#new_q1, #new_q2, #new_q3, #new_q4, #new_annual").removeClass('required');
            $("#ext_q1, #ext_q2, #ext_q3, #ext_q4, #ext_annual").removeClass('required');
        }
    }

    $(".numberField").on("input", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9]/g, ''));
        self.val(inrFormat(self.val()));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    $(document).on('keyup', '.apptotal', function () {
        var q1 = $('#app_q1').val();
        var q2 = $('#app_q2').val();
        var q3 = $('#app_q3').val();
        var q4 = $('#app_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#app_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.pardtotal', function () {
        var q1 = $('#pard_q1').val();
        var q2 = $('#pard_q2').val();
        var q3 = $('#pard_q3').val();
        var q4 = $('#pard_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#pard_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.iictotal', function () {
        var q1 = $('#iic_q1').val();
        var q2 = $('#iic_q2').val();
        var q3 = $('#iic_q3').val();
        var q4 = $('#iic_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#iic_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.eictotal', function () {
        var q1 = $('#eic_q1').val();
        var q2 = $('#eic_q2').val();
        var q3 = $('#eic_q3').val();
        var q4 = $('#eic_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#eic_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.cmptotal', function () {
        var q1 = $('#tot_q1').val();
        var q2 = $('#tot_q2').val();
        var q3 = $('#tot_q3').val();
        var q4 = $('#tot_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#tot_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.newtotal', function () {
        var q1 = $('#new_q1').val();
        var q2 = $('#new_q2').val();
        var q3 = $('#new_q3').val();
        var q4 = $('#new_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#new_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.exttotal', function () {
        var q1 = $('#ext_q1').val();
        var q2 = $('#ext_q2').val();
        var q3 = $('#ext_q3').val();
        var q4 = $('#ext_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#ext_annual').val(inrFormat(value));
    });

    function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }
</script>
<!-- end id-form  -->
