<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Detailed Assessment - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'diligence_company', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content vital_windowScroll">
                <?php $this->load->view('detailed_diligence/diligence_options.php', array('application_id' => $application_id, 'title' => 'Company & Team', 'inv_id' => $inv_id_format, 'stage' => $stage_name, 'status' => $status_name, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation['name_of_enterprise'], 'sector' => $sector[0]['sector'], 'sub_sector' => $subsector, 'assign_to' => $assign_to, 'eic_date' => $eic_date)); ?>

                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/diligence_company_data/' . $application_id; ?>">Company Master Data</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/diligence_management_team/' . $application_id; ?>">Management Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/diligence_cap_table/' . $application_id; ?>">Cap Table</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container ">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <form name="detail_form" id="detail_form" action="<?php echo site_url('application/save_master_data'); ?>" method="post" autocomplete="off">
                                <input type="hidden" name="innovation_id" value="<?= $application_id; ?>">
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Brief description of business </label>
                                                <textarea class="form-control" name="description" id="description" maxlength="1000" cols="30" rows="3"><?php echo ((isset($masterData[0]['business_description']) && $masterData[0]['business_description']) ? $masterData[0]['business_description'] : $main_data[0]['summary_of_business']); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>CIK #</label>
                                                <input type="text" class="form-control" name="cik" id="cik" value="<?php echo ((isset($masterData[0]['cik'])) ? $masterData[0]['cik'] : ""); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Stage of incubatee</label>
                                                <input type="text" class="form-control" name="stage" id="stage" readonly="" value="<?php echo isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' ? $innovation['enterprise_stage'] : $stage_name; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Sector</label>
                                                <select class="form-control" id="sector" name="sector" onchange="subsector(this.value)">
                                                    <option value="">-Select</option>
                                                    <?php
                                                    foreach ($sectors_values as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>" <?php
                                                        if ($masterData[0]['sector'] == $row['id']) {
                                                            echo 'selected';
                                                        } else if ($main_data[0]['sector'] == $row['id']) {
                                                            echo 'selected';
                                                        }
                                                        ?> ><?php echo $row['sector']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Sub Sector</label>
                                                <select class="form-control" id="sub_sector" name="sub_sector">
                                                    <option value="">-Select</option>
                                                    <?php if ($subSectorName[0]['sector'] != '') { ?>
                                                        <option value="<?php echo $subSectorName[0]['id']; ?>" selected><?php echo $subSectorName[0]['sector']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $format_date = (isset($masterData[0]['incorporation_date']) && $masterData[0]['incorporation_date'] != '0000-00-00') ? date('d-m-Y', strtotime($masterData[0]['incorporation_date'])) : '';
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Date of incorporation</label>
                                                <input type="text" class="form-control meet_date" name="incorporation_date" id="incorporation_date" placeholder="dd-mm-yyyy" value="<?= $format_date; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Invention</label>
                                                <select class="form-control" name="invention" id="invention">
                                                    <option value="1" <?php if ($masterData[0]['invention'] == '1') { ?> selected <?php } ?> >Yes</option>
                                                    <option value="2" <?php if ($masterData[0]['invention'] == '2') { ?> selected <?php } ?> >No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column wdt-98 bg-gray">
                                        <b class="heading-address">Registered Office address</b >
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="reg_address" rows="3" cols="30"><?php echo ((isset($masterData[0]['reg_office_address']) && $masterData[0]['reg_office_address'] != '') ? $masterData[0]['reg_office_address'] : (isset($main_data[0]['address1']) ? $main_data[0]['address1'] : '')); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="reg_city" value="<?php echo isset($masterData[0]['reg_city']) && $masterData[0]['reg_city'] != '' ? $masterData[0]['reg_city'] : $main_data[0]['city']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Pin-code</label>
                                                <input type="text" class="form-control" name="reg_pin" value="<?php echo isset($masterData[0]['reg_pincode']) ? $masterData[0]['reg_pincode'] : ''; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column wdt-98 bg-gray">
                                        <b class="heading-address">Other office address1</b >
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="other_addr_1" rows="3" cols="30"><?php echo ((isset($masterData[0]['other_address_1'])) ? $masterData[0]['other_address_1'] : ""); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="other_city_1" value="<?php echo isset($masterData[0]['other_city_1']) ? $masterData[0]['other_city_1'] : ''; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Pin-code</label>
                                                <input type="text" class="form-control" name="other_pin_1" value="<?php echo isset($masterData[0]['other_pincode_1']) ? $masterData[0]['other_pincode_1'] : ''; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column wdt-98 bg-gray">
                                        <b class="heading-address">Other office address2</b>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="other_addr_2" rows="3" cols="30"><?php echo ((isset($masterData[0]['other_address_2'])) ? $masterData[0]['other_address_2'] : ""); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="other_city_2" value="<?php echo isset($masterData[0]['other_city_2']) ? $masterData[0]['other_city_2'] : ''; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Pin-code</label>
                                                <input type="text" class="form-control" name="other_pin_2" value="<?php echo isset($masterData[0]['other_pincode_2']) ? $masterData[0]['other_pincode_2'] : ''; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView">
                                                    <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || php72_in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                                                        <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/application/diligence_company_data/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </main>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<input type="hidden" id="load_subsec" value="<?php echo $sector[0]['id']; ?>" />
<input type="hidden" id="select_subsec" value="<?php echo $subSectorName[0]['id']; ?>" />

<script type="text/javascript">
    $(document).ready(function () {
        var sub_sec = $('#load_subsec').val();
        subsector(sub_sec);
    });

    $(document).on("focus", ".meet_date", function () {
        if ($(this).hasClass('hasDatepicker') === false) {
            $(this).datepicker({dateFormat: 'dd-mm-yy'});
        }
    });

    function subsector(val) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {sector_id: val},
            dataType: 'json',
            success: function (msg) {
                var sub_sec = $('#select_subsec').val();
                $('#sub_sector').find('option').remove().end();
                $("#sub_sector").prepend("<option value=''>-Select</option>");
                $.each(msg, function (i, value) {
                    $('#sub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                    $('#sub_sector').val(sub_sec);
                });
            },
        });
    }
</script>

</body>
</html>