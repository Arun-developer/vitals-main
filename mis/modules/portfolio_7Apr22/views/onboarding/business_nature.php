<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$innovation = $get_master_company[0];
$business_data = $business_nature[0];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;

$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['reg_city'];
$sector = isset($business_data) ? $business_data['sector'] : $innovation['sector'];
$sub_sector = isset($business_data) ? $business_data['sub_sector'] : $innovation['sub_sector'];
$stage = isset($business_data) ? $business_data['stage'] : $inv_data['stage'];
$description = isset($business_data) ? $business_data['description'] : $innovation['business_description'];
$stage_val = array("1" => "No MVP", "2" => "MVP Ready, Not launched", "3" => "On sale, no traction", "4" => "Low/Inconsistent sales", "5" => "Consistent sales", "6" => "EBITDA Positive");

$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Info', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'add_class' => 'mar-tp140'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab" href="<?= $company_link; ?>" aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link active" id="nav-business-tab" aria-controls="nav-business" aria-selected="true">02</a>
                        <a class="nav-item nav-link" id="nav-management-tab" href="<?= $mgmnt_link; ?>" aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link" id="nav-governance-tab" href="<?= $govern_link; ?>" aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= $vilrel_link; ?>" aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= $increl_link; ?>" aia-controls="nav-incubation" aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" href="<?= $cap_link; ?>" aia-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" href="<?= $int_link; ?>" aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab"  href="#nav-about" aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= $dataconfig_link; ?>" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0 vital_windowScroll" id="nav-tabContent">
                    <form id="businessForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/addBusiness'; ?>" autocomplete="off">
                        <div class="tab-pane fade show active" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                            <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                            <input type='hidden' id='sector_id' value="<?= $sector; ?>">
                            <input type='hidden' id='subsector_id' value="<?= $sub_sector; ?>">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                                        <h4>Nature of Business</h4>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                            
                                                <li>
                                                    <a href="javascript:void(0)" id="edit_cmpny"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                </li>
                                                <li>
                                                    <a class="saveContinue" href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>">Save</a>
                                                </li>
                                            
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tabpanel-details">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <?php
                                        $branch_id = $this->session->userdata('partner_id');
                                        if ($branch_id == 10) {
                                            ?>
                                            <h6 class="pad-lt15px">Sector<span class="text-danger">*</span></h6>
                                        <?php } else { ?>
                                            <h6 class="pad-lt15px">Sector/Subsector<span class="text-danger">*</span></h6>
                                        <?php } ?>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <select id="sector" name="txtSector" class="form-control form-control-sm" onchange="subsector(this.value)">
                                                <option value="">-Select-</option>
                                                <?php
                                                foreach ($sectors_values as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php
                                                    if ($row['id'] == $sector) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $row['sector']; ?></option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if ($branch_id != 10) {
                                        ?>
                                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <select id="loadSubSector" class="form-control form-control-sm" name="sub_sector">
                                                    <option value="">-Select-</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-xl-6 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <h6 class="pad-lt15px">Stage of the incubatee</h6>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="txtstage">
                                                <option value="">-Select-</option>
                                                <?php foreach ($stage_val as $key => $val) { ?>
                                                    <option value="<?php echo $key; ?>" <?php
                                                    if ($key == $stage) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $val; ?></option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 text-right">
                                        <h6 >Brief description of business</h6>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <textarea class="form-control description" maxlength="1000" name="txtdescription" placeholder="Enter description" rows="3"><?= $description; ?></textarea>
                                            <small class="form-text text-right text-muted"><span>*</span> <span id="descCount"></span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <input type="hidden" id="enableCount" value="<?= count($business_nature); ?>">

    <?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

    <script type="text/javascript">

        $(document).ready(function () {
            var sec_id = $('#sector_id').val();
            subsector(sec_id);

            var editOpt = $('#enableCount').val();
            if (editOpt > 0) {
                $('textarea, select').attr('readonly', 'readonly');
                $('select').css('pointer-events', 'none');
            }

            var content = $(".description").val();
            var charCount = content.length;
            $('.text-muted').hide();
            if (charCount < 1000) {
                $('.text-muted').show();
                $("#descCount").html((1000 - $(".description").val().length) + " Characters left");
            }
            $('#edit_cmpny').addClass('opacity5');
        });

        $(".description").keyup(function () {
            var content = $(".description").val();
            var charCount = content.length;
            $('.text-muted').hide();
            if (charCount < 1000) {
                $('.text-muted').show();
                $("#descCount").html((1000 - $(this).val().length) + " Characters left");
            }
            if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
            }
        });

        function subsector(val) {
            var myarray = new Array();
            if (val != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
                    data: {sector_id: val},
                    dataType: 'json',
                    success: function (msg) {
                        $('#loadSubSector').find('option').not(':first').remove().end();
                        $.each(msg, function (i, value) {
                            myarray.push(value.id);
                            $('#loadSubSector').append($('<option>').text(value.sector).attr('value', value.id));
                        });
                        var subsec_id = $('#subsector_id').val();
                        if ($.inArray(subsec_id, myarray) != -1) {
                            $('#loadSubSector').val(subsec_id);
                        } else {
                            $('#loadSubSector').val('');
                        }
                    }
                });
            } else {
                $('#loadSubSector').find('option').not(':first').remove().end();
            }
        }

        $('#businessForm').validate({
            rules: {
                txtSector: "required",
                sub_sector: "required"
            },
            messages: {
                txtSector: "Please select sector",
                sub_sector: "Please select sub sector"
            }
        });

        $('#edit_cmpny').on('click', function () {
            $('textarea, select').attr('readonly', false);
            $('select').css('pointer-events', '');
            $('#edit_cmpny').removeClass('opacity5');
        });

        $(document).on('click', ".saveContinue", function (e) {
            e.preventDefault();
            if ($('#businessForm').valid()) {
                $('.saveContinue').css('pointer-events', 'none');
                $('#businessForm').submit();

            }
        });
    </script>

    <style type="text/css">
        select.error{
            width:100% !important;
        }
    </style>

</body>
</html>