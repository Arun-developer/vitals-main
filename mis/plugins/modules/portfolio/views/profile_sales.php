<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>


    </head>

    <body>
        <?php
        $innovation = $get_innovation[0];
        $master_data = $company_data[0];

        $company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];
        $reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $this->load->view('port_header.php', array('page_title' => 'Plan Setup', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard onboardtabmenu">
            <?php if ($successMsg != '') { ?>
                <div class="msg success text-center"><strong class="text-success"><i class="fas fa-check"></i></strong>&nbsp;<?= $successMsg; ?></div>
                <?php
            }
            if ($errorMsg != '') {
                ?>
                <div class="msg error text-center"><strong><i class="fas fa-times"></i></strong>&nbsp;<?= $errorMsg; ?></div>
            <?php } ?>
            <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"  href="<?= base_url() . 'index.php/portfolio/company_data/' . $innovation_id; ?>"  aria-selected="false">Company Master Data</a>
                                <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/business_nature/' . $innovation_id; ?>" aria-controls="nav-business" aria-selected="false">Nature of business</a>
                                <a class="nav-item nav-link filled-data" id="nav-management-tab"  href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>" aria-controls="nav-management" aria-selected="false">Management</a>
                                <a class="nav-item nav-link filled-data" id="nav-governance-tab"  href="<?= base_url() . 'index.php/portfolio/governance/' . $innovation_id; ?>" aria-controls="nav-governance" aria-selected="false">Governance</a>
                                <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id; ?>" aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                                <a class="nav-item nav-link filled-data" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id; ?>"   aria-controls="nav-incubation" aria-selected="false">Incubation Relationship</a>
                                <a class="nav-item nav-link filled-data" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/cap_table/' . $innovation_id; ?>"   aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                                <a class="nav-item nav-link filled-data" id="nav-interested-tab" href="<?= base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id; ?>" aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                                <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                                <a class="nav-item nav-link dataConfig active" id="nav-dataconfig-tab"  href="javascript:void(0)" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                            </div>
                        </nav>
                        <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-9">
                                            <h4>Define the annual plan for <?= $company_name; ?></h4>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 text-center">
                                            <a class="saveContinue" href="<?= base_url() . 'index.php/portfolio/channel' . $innovation_id; ?>">Save &amp; Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                    <?php $this->load->view('config_left_menu.php', array('class_name' => 'salesDiv')); ?>
                                    <main class="page-content">
                                        <form method="post" id="create_sales" action="<?php echo base_url() . 'index.php/portfolio/createSales'; ?>" autocomplete="off">
                                            <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                            <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                            <div class="row dataconfig">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <h4>Sales</h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                    <div class="config-sales">
                                                        <label>Financial Year</label>
                                                        <div class="form-group">
                                                            <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="loadYear(this.value);">
                                                                <?php foreach ($fin_year as $year) { ?>
                                                                    <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <label>/</label>
                                                        <label>Monthly</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="add-sales">
                                                <ul class="milestone-links">
                                                    <li class="valigntop"><p>Create SKU</p></li>
                                                    <li><div class="form-group">
                                                            <input type="text" name="sales_name" id="sales_name" class="form-control form-control-sm" placeholder="Add new product">
                                                        </div></li>
                                                    <li class="valigntop"> <span><input type="submit" id="skuSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add"></span></li>
                                                </ul>
                                            </div>
                                        </form>
                                        <div id='accordion'>
                                            <form id="skuData" method="post" class="Plan-structure" action="<?php echo base_url() . 'index.php/portfolio/addSales'; ?>" autocomplete="off">
                                                <input type='hidden' name='inv_id' id="inv_id" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                                <?php
                                                $i = 1;
                                                if (count($sales_data) > 0) {
                                                    foreach ($sales_data as $row) {
                                                        $get_unit = $row['unit'];
                                                        $get_volume = json_decode($row['volume']);
                                                        $get_value = json_decode($row['value']);

                                                        $enable_volume = json_decode($row['volume'], true);
                                                        $enable_value = json_decode($row['value'], true);

                                                        if (!array_filter($enable_volume) && !array_filter($enable_volume) && $row['other'] == '' && $row['unit'] == '') {
                                                            $enable = 0;
                                                        } else {
                                                            $enable = 1;
                                                        }
                                                        ?>

                                                        <input type="hidden" class="enableCount" id="enableCount_<?= $i; ?>" value="<?= $enable; ?>">
                                                        <input type="hidden" name="row_id" id="row_id" value="<?= $i; ?>">
                                                        <input type="hidden" name="sales_id<?= $i; ?>" id="sales_id<?= $i; ?>" value="<?= $row['id']; ?>">

                                                        <div class="row">
                                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-12">
                                                                <h6>Create Plan</h6>
                                                            </div>
                                                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-12">
                                                                <p>SKU <span><?= $i; ?></span> / <span><?= $row['product_name']; ?></span></p>
                                                            </div>
                                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 text-right">
                                                                <a href="javascript:void(0)" class="edit-btnconfig" onclick="editBtn(<?= $i; ?>)" id="edit_sales_<?= $i; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 ">
                                                                <a href="javascript:void(0)" class="delete-btnconfig" onclick="deleteSKU(<?= $row['id']; ?>)" id="delete_sales_<?= $i; ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive table_configcontent table_content" id="table_content_<?= $i; ?>">
                                                            <table class="table">
                                                                <thead>
                                                                <th colspan="12">Volume</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <p>Apr</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Apr; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>May</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->May; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Jun</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Jun; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Jul</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Jul; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Aug</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Aug; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Sep</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Sep; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Oct</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Oct; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Nov</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Nov; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Dec</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Dec; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Jan</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Jan; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Feb</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Feb; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Mar</p>
                                                                            <div class="form-group">
                                                                                <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->Mar; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <p>Unit</p>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <div class="form-group">
                                                                                <select class="form-control form-control-sm" name="unit<?= $i; ?>">
                                                                                    <option value="">-Select-</option>
                                                                                    <?php
                                                                                    foreach ($units as $u) {
                                                                                        ?>
                                                                                        <option value="<?php echo $u['id']; ?>" <?php
                                                                                        if ($u['id'] == $get_unit) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>><?php echo $u['units']; ?></option>
                                                                                            <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Other</p>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control form-control-sm" name="others<?= $i; ?>" value="<?= $row['other']; ?>" maxlength="25" placeholder="Specify">
                                                                            </div>
                                                                        </td>
                                                                        <td colspan="6">

                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="table">
                                                                <thead class="table-success">
                                                                <th colspan="12">Value <span class="rupee-value">(Rs.)</span></th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <p>Apr</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Apr; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>May</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->May; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Jun</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Jun; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Jul</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Jul; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Aug</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Aug; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Sep</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Sep; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Oct</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Oct; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Nov</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Nov; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Dec</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Dec; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Jan</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Jan; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td >
                                                                            <p>Feb</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Feb; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>Mar</p>
                                                                            <div class="form-group ">
                                                                                <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->Mar; ?>" class="form-control form-control-sm volumefld" maxlength="7" placeholder="0000">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br/>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>

                                            </form>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content delete-alert">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="col-10">
                                    <h4>Are you sure you want to delete selected items?</h4>
                                    <p>you are about delete this selected information fields, you can't undo this</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="deleteID" value="">
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

        <script type="text/javascript">

                                                                    $(document).ready(function () {
                                                                        onLoad();
                                                                    });

                                                                    $(document).on('keyup', '.volumefld', function () {
                                                                        if (this.value.match(/[^0-9 ]/g)) {
                                                                            this.value = this.value.replace(/[^0-9 ]/g, '');
                                                                        }
                                                                        if (this.value.match(/\s/g)) {
                                                                            this.value = this.value.replace(/\s/g, '');
                                                                        }
                                                                    });


                                                                    function onLoad() {
                                                                        $('.enableCount').each(function (key, value) {
                                                                            var inc = key + 1;
                                                                            var editOpt = $('#enableCount_' + inc).val();
                                                                            if (editOpt > 0) {
                                                                                $('#table_content_' + inc + ' input[type="text"], #table_content_' + inc + ' select').attr('readonly', 'readonly');
                                                                                $('#table_content_' + inc + ' select').css('pointer-events', 'none');
                                                                            } else {
                                                                                $('#table_content_' + inc + ' input[type="text"], #table_content_' + inc + ' select').attr('readonly', false);
                                                                                $('#table_content_' + inc + ' select').css('pointer-events', '');
                                                                            }
                                                                        });
                                                                    }

                                                                    function editBtn(id) {
                                                                        $('#table_content_' + id + ' input[type="text"], #table_content_' + id + ' select').attr('readonly', false);
                                                                        $('#table_content_' + id + ' select').css('pointer-events', '');
                                                                    }

                                                                    function deleteSKU(sales_id) {
                                                                        $('#deletemodal').modal('show');
                                                                        $('#deleteID').val(sales_id);
                                                                    }

                                                                    $('#deleteRecord').on('click', function () {
                                                                        var sales_id = $('#deleteID').val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioConfig",
                                                                            data: {
                                                                                fields: 'volume,value',
                                                                                id: sales_id,
                                                                                table: 'port_sales_data'
                                                                            },
                                                                            dataType: 'json',
                                                                            success: function (msg) {
                                                                                $('#accordion').load(location.href + ' #accordion');
                                                                                $('#deletemodal').modal('hide');
                                                                                $('#deleteMsg').show();
                                                                                setTimeout(function () {
                                                                                    onLoad();
                                                                                }, 500);
                                                                                setTimeout(function () {
                                                                                    $('#deleteMsg').hide();
                                                                                }, 3000);
                                                                            }
                                                                        });
                                                                    });

                                                                    $(document).on('click', '#skuSubmit', function () {
                                                                        $('#create_sales').validate({
                                                                            rules: {
                                                                                sales_name: {
                                                                                    required: true,
                                                                                    remote: {
                                                                                        url: "<?php echo base_url() . 'index.php/portfolio/productName'; ?>",
                                                                                        type: "post",
                                                                                        data: {
                                                                                            id: $('#innovation_id').val(),
                                                                                            year: $('#financial_year').val(),
                                                                                            sales_name: function () {
                                                                                                return $("#sales_name").val();
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            },
                                                                            messages: {
                                                                                sales_name: {
                                                                                    required: "Please enter product name",
                                                                                    remote: "Product name already exist"
                                                                                }
                                                                            }
                                                                        });
                                                                    });

                                                                    $(".saveContinue").on('click', function (e) {
                                                                        if ($('#skuData').valid()) {
                                                                            $('.saveContinue').css('pointer-events', 'none');
                                                                            $('#skuData').submit();
                                                                            e.preventDefault();
                                                                        }
                                                                    });

                                                                    function loadYear(year) {
                                                                        var inv_id = $('#inv_id').val();
                                                                        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/sales/' + inv_id + '/' + year;
                                                                    }
        </script>

    </body>
</html>