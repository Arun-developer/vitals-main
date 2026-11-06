<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$innovation = $get_master_company[0];

$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;

$cin_number = isset($master_data) ? $master_data['cin'] : $innovation['cik'];
$reg_address = isset($master_data) ? $master_data['reg_address'] : $innovation['reg_office_address'];
$reg_pincode = isset($master_data) ? $master_data['reg_pincode'] : $innovation['reg_pincode'];
$reg_city = isset($master_data) && $master_data['reg_city'] != '' ? $master_data['reg_city'] : $innovation['reg_city'];
$other_address = isset($master_data) && $master_data['other_address'] != '' ? $master_data['other_address'] : $innovation['other_address_1'];
$other_pincode = isset($master_data) && $master_data['other_pincode'] != '' ? $master_data['other_pincode'] : $innovation['other_pincode_1'];
$other_city = isset($master_data) && $master_data['other_city'] != '' ? $master_data['other_city'] : $innovation['other_city_1'];
$company_status = isset($master_data) ? $master_data['company_status'] : $innovation['company_status'];
$document_file = isset($master_data) ? $master_data['document'] : '';
$company_valuation = isset($master_data) ? $master_data['company_valuation'] : '';
$villgro_investment = isset($master_data) ? $master_data['villgro_investment'] : '';
$investor_name = isset($master_data) ? $master_data['investor_name'] : '';
$size_of_round = isset($master_data) ? $master_data['size_of_round'] : '';

$city = array("Ahmedabad", "Bangalore", "Bhubaneswar", "Chennai", "Delhi", "Hyderabad", "Jaipur", "Kanpur", "Kochi", "Kolkata", "Mumbai", "Pune", "Others");
$clength = count($city);
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Info', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'add_class' => 'mar-tp140'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10" id="accordion">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-Companymaster-tab" data-toggle="tab"
                           href="#nav-Companymaster" role="tab" aria-controls="nav-Companymaster"
                           aria-selected="true">01</a>
                        <a class="nav-item nav-link" id="nav-business-tab" href="<?= $nature_link; ?>"
                           aria-controls="nav-business" aria-selected="false">Nature of Business</a>
                        <a class="nav-item nav-link" id="nav-management-tab" href="<?= $mgmnt_link; ?>"
                           aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link" id="nav-governance-tab" href="<?= $govern_link; ?>"
                           aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= $vilrel_link; ?>"
                           aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= $increl_link; ?>"
                           aria-controls="nav-incubation" aria-selected="true">Incubation Relationship</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" href="<?= $cap_link; ?>"
                           aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" href="<?= $int_link; ?>"
                           aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab" href="#nav-about"
                           aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab"
                           href="<?= $dataconfig_link; ?>" role="tab" aria-controls="nav-dataconfig"
                           aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel"
                         aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                                    <h4>Company Master Data</h4>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                <ul class="milestone-links">
                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                        
                                            <li>
                                                <a href="javascript:void(0)" id="edit_cmpny"><i class="fas fa-pencil-alt"></i>
                                                    Edit</a>
                                            </li>
                                            <li>
                                                <a class="saveContinue" href="javascript:void(0)">Save</a>
                                            </li>
                                       
                                    <?php } ?>
                                    <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tabpanel-details plan-structure-new">
                            <form id="companyForm" method="POST"
                                  action="<?php echo base_url() . 'index.php/portfolio/addCompany'; ?>"
                                  autocomplete="off" enctype=multipart/form-data>
                                <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                <input type='hidden' name='first_city' id="first_city" value="<?= $reg_city; ?>">
                                <input type='hidden' name='second_city' id="second_city" value="<?= $other_city; ?>">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <h6 class="pad-lt15px">Company Details</h6>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <label>Name of the company<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm"
                                                   name="company_name" placeholder="Company Name"
                                                   value="<?= $company_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <label>CIN#</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm cinNmbr"
                                                   name="cin_number" placeholder="12345-*****-*****-313-214"
                                                   maxlength="21" value="<?= $cin_number; ?>">
                                            <small class="form-text text-right text-muted"><span>*</span> <span
                                                    id="cinCount"></span></small>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <h6 class="pad-lt15px">Address</h6>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <label>Registered Address<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <textarea class="form-control regAddr" name="reg_address"
                                                      placeholder="Enter full address" rows="3"
                                                      maxlength="95"><?= $reg_address; ?></textarea>
                                            <small class="form-text text-right text-muted"><span>*</span> <span
                                                    id="regCount"></span></small>
                                        </div>
                                        <div>
                                            <div class="float-left wdt-50">
                                                <label>City<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm"
                                                       name="reg_city" placeholder="Enter city"
                                                       maxlength="30" value="<?= $reg_city; ?>">
                      <!-- <select class="form-control form-control-sm" name="reg_city"
                              id="reg_city" onchange="regCity();">
                          <option value="">-Select-</option>
                                                <?php for ($x = 0; $x < $clength; $x++) { ?>
                                                                                                                                                                                                                                            <option value="<?php echo $city[$x]; ?>" <?php
                                                    if ($city[$x] == $reg_city) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $city[$x]; ?></option>
                                                <?php } ?>
                               </select> -->
                                            </div>
                                            <div class="float-right wdt-30">
                                                <label>Pin Code<span class="text-danger">*</span></label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-sm pin_code"
                                                           name="reg_pin" placeholder="" value="<?= $reg_pincode; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <label class="pad-lt15px">Other Address</label>
                                        <div class="form-group">
                                            <textarea class="form-control otherAddr" name="other_address"
                                                      placeholder="Enter full address" rows="3"
                                                      maxlength="95"><?= $other_address; ?></textarea>
                                            <small class="form-text text-right text-muted"><span>*</span> <span
                                                    id="otherCount"></span></small>
                                        </div>
                                        <div>
                                            <div class="float-left wdt-50">
                                                <label>City</label>
                                                <input type="text" class="form-control form-control-sm"
                                                       name="other_city" placeholder="Enter city"
                                                       maxlength="30" value="<?= $other_city; ?>">
                                                  <!-- <select class="form-control form-control-sm" name="other_city"
                                                          id="other_city" onchange="otherCity()">
                                                      <option value="">-Select-</option>
                                                <?php for ($x = 0; $x < $clength; $x++) { ?>
                                                                                                                                                                                                                                            <option value="<?php echo $city[$x]; ?>" <?php
                                                    if ($city[$x] == $other_city) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $city[$x]; ?></option>
                                                <?php } ?>
                                                   </select> -->
                                            </div>
                                            <div class="float-right wdt-30">
                                                <label>Pin Code</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-sm pin_code"
                                                           name="other_pin" placeholder=""
                                                           value="<?= $other_pincode; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-2 col-12">
                                        <h6 class="pad-lt15px">Deal Details</h6>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <label>INV ID</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm invid"
                                                   name="company_inv" placeholder="inv_id" readonly=""
                                                   value="<?= $inv_data['copy_id'] . '_' . $inv_data['partner_id'] . '_' . $inv_data['partner_count']; ?>">
                                        </div>
                                        <div>
                                            <div class="float-left wdt-50">
                                                <label>Status<span class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm" name="company_status"
                                                        id="company_status" onchange="companyStatus(this.value);">
                                                    <option value="1" <?php
                                                    if (php72_cmp($company_status) == 1) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Open</option>
                                                    <option value="2" <?php
                                                    if (php72_cmp($company_status) == 2) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Graduated (Non-Financial)</option>
                                                    <option value="3" <?php
                                                    if (php72_cmp($company_status) == 3) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Exited (With Equity)</option>
													<option value="4" <?php
                                                    if (php72_cmp($company_status) == 4) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Contract terminated</option>
													<option value="5" <?php
                                                    if (php72_cmp($company_status) == 5) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Company Shutdown</option>
													
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <label>Document <small>(Max 10MB size of ppt, pdf, doc files)</small></label>

                                        <div class="form-group">
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($document_file) && !empty($document_file)) {
                                                    echo $document_file;
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                    <input type="file" class="uploadlogo" name="document_file" />
                                                <?php } ?>
                                            </div>
                                            <?php if (isset($document_file) && !empty($document_file)) { ?>
                                                <span><a href="<?php echo base_url() . 'uploads/portfolio/company/' . $document_file; ?>" class="download-btn" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                    <span><a href="javascript:void(0)" id="removeDoc" title="Delete Document" class="delete-btnconfig"><i class="fas fa-trash"></i></a></span>
                                                <?php } ?>
                                                <input type="hidden" name="old_doc" value="<?php echo $document_file; ?>">
                                            <?php } ?>
                                        </div>
                                        <label for="document_file" class="error wdt-100m" ></label>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-3 col-sm-3 col-12"></div>
                                    <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div id="uploadSuccess" class="msg hidden_cls success text-center"><strong
                                                class="text-success"><i class="fas fa-check"></i></strong>&nbsp;File
                                            has been deleted successfully</div>
                                    </div>
                                </div>

                                <?php
                                if ($this->session->userdata['currency'] == 'INR') {
                                    $currency_text = 'INR, In Lakhs';
                                } else {
                                    $currency_text = $this->session->userdata['currency'] . ", In '000's";
                                }
                                ?>

                                <div id="exitFields">
                                    <hr/>
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                            <h6 class="pad-lt15px">At the time of exits </h6><small class="exi-sm">(Upload SHA document(s) in the Incubation Relationship tab)</small>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label>Valuation of the company (<?= $currency_text; ?>)<span class="text-danger">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm numberField" name="company_valuation" placeholder="00" maxlength="10" value="<?= $company_valuation; ?>">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <label>Valuation of Villgro's investment (<?= $currency_text; ?>)<span class="text-danger">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm numberField" name="villgro_invest" placeholder="00" maxlength="10" value="<?= $villgro_investment ?>">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12"></div>
                                    </div>
                                    <div class="add_more_invest" id="loadInvestData">
                                        <?php
                                        $investData_count = isset($invest_list) && php72_count($invest_list) > 0 ? php72_count($invest_list) : '1';
                                        $j = 1;
                                        for ($i = 0; $i < $investData_count; $i++) {
                                            ?>
                                            <div class="row invest_more" id="invest_tr_<?php echo $j; ?>">
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <?php if ($j == 1) { ?>
                                                        <label>Name of investor(s)<span class="text-danger">*</span></label>
                                                    <?php } ?>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-sm" name="investor_name[]" id="investor_name_<?php echo $j; ?>" placeholder="Investor Name" value="<?= $invest_list[$i]['investor_name']; ?>">
                                                    </div>
                                                    <label class="error" id="investor_name<?= $i . '_error'; ?>"></label>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                    <?php if ($j == 1) { ?>
                                                        <label>Size of round (<?= $currency_text; ?>)<span class="text-danger">*</span></label>
                                                    <?php } ?>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-sm numberField" name="size_round[]" id="size_round_<?php echo $j; ?>" placeholder="00" maxlength="10" value="<?= $invest_list[$i]['round_size']; ?>">
                                                    </div>
                                                    <label class="error" id="size_round<?= $i . '_error'; ?>"></label>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                    <?php if ($j == 1) { ?>
                                                        <label for="">&nbsp</label>
                                                    <?php } ?>
                                                    <i title="Add More" class="fa fa-plus bg-success text-left px-2 py-2 text-white cursor" onclick="addInvest();" aria-hidden="true"></i>
                                                    <?php if (php72_count($invest_list) > 0) { ?>
                                                        <i title="Delete" class="fa fa-trash bg-danger text-left px-2 py-2 text-white cursor" onclick="deleteInvest(<?= $invest_list[$i]['id']; ?>);" aria-hidden="true"></i>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="invest_id[]" value="<?= $invest_list[$i]['id']; ?>">
                                            <?php
                                            $j++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                    </div>
                    <div class="tab-pane fade" id="nav-management" role="tabpanel"
                         aria-labelledby="nav-management-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-governance" role="tabpanel"
                         aria-labelledby="nav-governance-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-relationship" role="tabpanel"
                         aria-labelledby="nav-relationship-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-incubation" role="tabpanel"
                         aria-labelledby="nav-incubation-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-cap" role="tabpanel" aria-labelledby="nav-cap-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-interested" role="tabpanel"
                         aria-labelledby="nav-interested-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">

                    </div>
                    <div class="tab-pane fade" id="nav-dataconfig" role="tabpanel"
                         aria-labelledby="nav-dataconfig-tab">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= php72_count($company_data); ?>">
<input type="hidden" id="prev_compStatus" value="<?= $company_status; ?>">
<input type="hidden" name="innovationId" id="innovationId" value="<?php echo $inv_data['id']; ?>">

<div class="modal" id="welcomeModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body onboarding-permission text-center">
                <div class="text-right">
                    <a class="portfolioclose" data-dismiss="modal">Close</a>
                </div>
                <img src="<?php echo base_url() . 'source/portfolio_assets/img/popup-portfolio.png'; ?>">
                <div class="popup-content">
                    <p>Hey there, Welcome</p>
                    <p>to your <?php echo $welcome_count; ?> incubatee onboarding.</p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Let's do this</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model (Delete and select) -->
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal"
                                                                 aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteInvestModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delInvestCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" nale="delete_id" id="delete_id" value="">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteInvestRecord"> Delete Investor</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">

    function addInvest() {
        var dyn = $(".invest_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<div class="row invest_more" id="invest_tr_' + i + '"><div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div><div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">' +
                '<div class="form-group"><input type="text" class="form-control form-control-sm" name="investor_name[]" id="investor_name_' + i + '" placeholder="Investor Name" value=""></div> <label class="error" id="investor_name' + (i - 1) + '_error"></label></div>' +
                '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"><div class="form-group"><input type="text" class="form-control form-control-sm numberField" name="size_round[]" id="size_round_' + i + '" placeholder="00" maxlength="10" value=""></div><label class="error" id="size_round' + (i - 1) + '_error"></label></div>' +
                '<div class = "col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" ><i title="Add Row" class = "fa fa-plus bg-success text-left px-2 py-2 text-white cursor" onclick = "addInvest();" aria-hidden = "true" ></i> <i title="Remove" class = "fa fa-minus bg-danger text-left px-2 py-2 text-white cursor" onclick = "removeAddMore(' + i + ');" aria-hidden = "true" ></i></div></div>';
        $(datas).insertAfter($('#invest_tr_' + dyn));
    }

    function removeAddMore(div_id) {
        $('#invest_tr_' + div_id).closest('div').remove();
    }

    function deleteInvest(del_id) {
        if (del_id != '') {
            $('#deleteInvestModal').modal('show');
            $('#delete_id').val(del_id);
        }
    }

    $('#deleteInvestRecord').on('click', function () {
        var inv_id = $('#innovation_id').val();
        var deleteId = $('#delete_id').val();
        if (deleteId != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deleteExitInvestors",
                data: {
                    id: deleteId,
                    inv_id: inv_id,
                    table: 'port_company_data_exit_invest'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadInvestData').load(location.href + ' #loadInvestData');
                    $('#deleteInvestModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
//                                                                                }, 500);
//                                                                                setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });

    function investValidate() {
        var err = 0;
        var company_status = $('#company_status').val();
        if (company_status == 3) {
            var invest_arr = [];
            var invest_dyn = document.getElementsByName("investor_name[]").length;
            for (var r = 0; r < invest_dyn; r++) {
                var dyn_id = document.getElementsByName("investor_name[]")[r].id;
                invest_arr.push(dyn_id);
            }

            var s = 1;
            for (var q = 0; q < invest_arr.length; q++) {
                var invest_name = $('#investor_name_' + s).val();
                var invest_size = $('#size_round_' + s).val();
                if (invest_name == '') {
                    $('#investor_name' + [q] + '_error').css('display', 'block');
                    $('#investor_name' + [q] + '_error').text('Please enter investor name');
                    err = 1;
                } else {
                    $('#investor_name' + [q] + '_error').css('display', 'none');
                    $('#investor_name' + [q] + '_error').text('');
                }
                if (invest_size == '') {
                    $('#size_round' + [q] + '_error').css('display', 'block');
                    $('#size_round' + [q] + '_error').text('Please enter amount');
                    err = 1;
                } else {
                    $('#size_round' + [q] + '_error').css('display', 'none');
                    $('#size_round' + [q] + '_error').text('');
                }
                s++;
            }
        }
        return err;
    }

    function companyValidate() {
        if ($('#companyForm').valid()) {
            return 0;
        } else {
            return 1;
        }
    }

    $(document).on('click', ".saveContinue", function (e) {
        var company_result = companyValidate();
        var invest_result = investValidate();
        console.log(company_result + ' == ' + invest_result);
        if (company_result == 1 || invest_result == 1) {
            return false;
        } else {
            $('.saveContinue').css('pointer-events', 'none');
            $('#companyForm').submit();
            return true;
        }
    });

    $(document).ready(function () {
        var popUp = localStorage.getItem('onboardPop');
        if (popUp == 1) {
            $('#welcomeModal').modal('show');
        }
        localStorage.setItem('onboardPop', 0);
        onLoad();
        $("#cinCount").html((21 - $(".cinNmbr").val().length) + " Characters left");
        $("#regCount").html((95 - $(".regAddr").val().length) + " Characters left");
        $("#otherCount").html((95 - $(".otherAddr").val().length) + " Characters left");
    });
    function onLoad() {
        var comp_status = $('#prev_compStatus').val();
        companyStatus(comp_status);
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"], textarea, select').attr('readonly', 'readonly');
            // $('select').prop('disabled', true);
            $('input[type="file"], select').css('pointer-events', 'none');
        }
        $('#edit_cmpny').addClass('opacity5');
    }

    $(document).on('keyup', 'textarea', function () {
        if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
        }
    });
    $(".uploadlogo").on('change', function () {
        var filename = readURL(this);
        $(this).parent().children('span').html(filename);
    });
    function uploadFile() {
        $(".uploadlogo").on('change', function () {
            var filename = readURL(this);
            $(this).parent().children('span').html(filename);
        });
    }

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
            path = $(input).val();
            filename = path.replace(/^.*\\/, "");
            $('#companyForm').valid();
            return filename;
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>';
            $('#companyForm').valid();
            return filename;
        }
    }

    $(document).on('keyup', '.pin_code', function () {
        if (this.value.match(/[^0-9 ]/g)) {
            this.value = this.value.replace(/[^0-9 ]/g, '');
        }
    });
    $(".cinNmbr").keyup(function () {
        $("#cinCount").html((21 - $(this).val().length) + " Characters left");
        if (this.value.match(/[^a-zA-Z0-9]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        }
    });
    $(".regAddr").keyup(function () {
        $("#regCount").html((95 - $(this).val().length) + " Characters left");
    });
    $(".otherAddr").keyup(function () {
        $("#otherCount").html((95 - $(this).val().length) + " Characters left");
    });
    $('#removeDoc').on('click', function () {
        $('#deletemodal').modal('show');
    });
    $('#deleteRecord').on('click', function () {
        var invId = $('#innovationId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/deleteUploadFiles",
            data: {
                invId: invId,
                table: 'port_company_data'
            },
            dataType: 'json',
            success: function (msg) {
                $('#accordion').load(location.href + ' #accordion');
                $('#deletemodal').modal('hide');
                $('#uploadSuccess').show();
                setTimeout(function () {
                    onLoad();
                    uploadFile();
                }, 500);
            }
        });
    });
    $(document).on('click', '#edit_cmpny', function () {
        $('input[type="text"], textarea, select').attr('readonly', false);
        //                                                                $('select').attr('disabled', false);
        $('input[type="file"], select').css('pointer-events', '');
        $('.invid').attr('readonly', 'readonly');
        $('#edit_cmpny').removeClass('opacity5');
    });
    function regCity() {
        var reg = $('#reg_city').val();
        $('#first_city').val(reg);
    }

    function otherCity() {
        var other = $('#other_city').val();
        $('#second_city').val(other);
    }

    function companyStatus(id) {
        if (id == 3) {
            $('#exitFields').show();
        } else {
            $('#exitFields').hide();
        }
    }

    $(document).on('input', '.numberField', function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        self.val(inrFormat(self.val()));
        var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
        var matchedString = self.val().match(patt);
        if (matchedString) {
            self.val(matchedString);
        }
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

    $.validator.addMethod("maxfilesize", function (value, element) {
        return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
    }, $.format('The file size cannot exceed 10MB'));
    $.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, "Not a valid file format");
    $('#companyForm').validate({
        rules: {
            company_name: "required",
            reg_address: "required",
            reg_city: "required",
            reg_pin: "required",
            company_status: "required",
            company_valuation: {
                required: {
                    depends: function (element) {
                        return $("#company_status").val() == 3
                    }
                }
            },
            villgro_invest: {
                required: {
                    depends: function (element) {
                        return $("#company_status").val() == 3
                    }
                }
            },
//                                                                    investor_name: {
//                                                                        required: {
//                                                                            depends: function (element) {
//                                                                                return $("#company_status").val() == 3
//                                                                            }
//                                                                        }
//                                                                    },
//                                                                    size_round: {
//                                                                        required: {
//                                                                            depends: function (element) {
//                                                                                return $("#company_status").val() == 3
//                                                                            }
//                                                                        }
//                                                                    },
            document_file: {
                extension: "pdf|ppt|pptx|doc|docx",
                maxfilesize: true
            }
        },
        messages: {
            company_name: "Please enter company name",
            reg_address: "Please enter address with maximum of 95 characters",
            reg_city: "Please enter city name",
            reg_pin: "Please enter pincode",
            company_status: "Please select status",
            company_valuation: "Please enter amount",
            villgro_invest: "Please enter amount",
//                                                                    investor_name: "Please enter investor name",
//                                                                    size_round: "Please enter amount",
            document_file: {
                extension: 'Only ppt,pdf,doc files are accepted'
            }
        }
    });
//                                                            $(document).on('click', ".saveContinue", function (e) {
//                                                                if ($('#companyForm').valid()) {
//                                                                    $('.saveContinue').css('pointer-events', 'none');
//                                                                    $('#companyForm').submit();
//                                                                }
//                                                            });
    $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});
</script>
<style>
    .fileUpload {
        width: 80%;
    }
</style>
</body>

</html>