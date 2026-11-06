<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];

$allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img><br>';
$allowedTags.='<li><ol><ul><span><div><br><ins><del>'; 
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?= $company_name . ' - Plan'; ?></title>
    </head>

    <body>
        <?php
        $reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $this->load->view('port_header.php', array('page_title' => 'Plan Setup', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id));
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard onboardtabmenu mar-tp150">
            <?php if ($successMsg != '') { ?>
                <div class="msg success text-center"><strong class="text-success"><i class="fas fa-check"></i></strong>&nbsp;<?= $successMsg; ?></div>
                <?php
            }
            if ($errorMsg != '') {
                ?>
                <div class="msg error text-center"><strong><i class="fas fa-times"></i></strong>&nbsp;<?= $errorMsg; ?></div>
            <?php } ?>
            <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
            <?php if ($this->session->userdata['approve_success'] == '1') { ?>
                <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Product details approved successfully</div>
            <?php } ?>
            <?php if ($this->session->userdata['approve_success'] == '2') { ?>
                <div id="approveallMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;All plan details are approved successfully</div>
            <?php } ?>
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
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h4>Define the annual plan for <?= $company_name; ?></h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                            <ul class="milestone-links">
                                                <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin') && (php72_cmp($approvals[0]['product_approval']) == 2 || php72_cmp($approvals[0]['sales_approval']) == 2 || php72_cmp($approvals[0]['channel_approval']) == 2 || php72_cmp($approvals[0]['pipeline_approval']) == 2 || php72_cmp($approvals[0]['revenue_approval']) == 2 || php72_cmp($approvals[0]['netprofit_approval']) == 2 || php72_cmp($approvals[0]['vif_approval']) == 2 || php72_cmp($approvals[0]['fundraise_approval']) == 2 || php72_cmp($approvals[0]['mentor_approval']) == 2 || php72_cmp($approvals[0]['tap_approval']) == 2 || php72_cmp($approvals[0]['nontap_approval']) == 2 || php72_cmp($approvaless[0]['board_approval']) == 2 || php72_cmp($approvals[0]['impact_approval']) == 2 || php72_cmp($approvals[0]['project_approval']) == 2)) { ?>
                                                    <li><a class="approveall" href="javascript:void(0);">Approve All</a></li>
                                                <?php } ?>
                                                <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <li><a class="saveContinue" href="javascript:void(0);">Save</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata['sector_lead'] != '1' && php72_cmp($approvals[0]['config_approval']) == 1) { ?>
                                                    <li><a class="sendApproval sendApprovalBtn" id="sendApproval" href="javascript:void(0);">Send for Approval</a></li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="config-wrapper tabpanel-detailsconfig  dataconfig-content page-wrapper chiller-theme">
                                    <div id="leftMenuLoad">
                                        <?php $this->load->view('config_left_menu.php', array('class_name' => 'productDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
                                    </div>
                                    <main class="page-content" id="pageContent">
                                        <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                            <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                        <?php } ?>
                                        <div class="row dataconfig">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <?php if (php72_cmp($approvals[0]['product_approval']) == 2) { ?>
                                                    <h4>Tinymce : <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                <?php } else if (php72_cmp($approvals[0]['product_approval']) == 3) { ?>
                                                    <h4>Tinymce : <span class="text-success"><small>(Approved)</small></span></h4>
                                                <?php } else { ?>
                                                    <h4>Tinymce</h4>
                                                <?php } ?>
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
                                        <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin') && php72_cmp($approvals[0]['product_approval']) == 2) { ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="approved-btn text-right">
                                                        <button type="button" class="btn btn-success capitilize">Approve</button>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div id='accordion' class="brd-tp">
                                            <form id="skuData" method="post" class="Plan-structure" action="<?php echo base_url() . 'index.php/portfolio/addSales'; ?>" autocomplete="off">
                                                <input type='hidden' name='inv_id' id="inv_id" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                <input type='hidden' name='module_id' id="module_id" value="1">
                                                <!-- Quantity new design -->

                                                <div class="quaterlyNewplanstru">
                                                    <h4>Quarterly Plan</h4>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <p>Q1 (Apr-Jun <?= $current_financial; ?>)</p>
                                                            <div class="quaterlyCardnew" id="qOne_active">
                                                                <textarea rows="3" class="mceEditor" id="txtQuarterOne" name="qOneDesc" placeholder="Enter quarterly plan details in here"><?= str_replace("\\r\\n", '', $qualitative_data[0]['q_one_desc']); ?></textarea>
                                                                <div class="tabset1">
                                                                    <input type="radio" name="tabset1" id="tab4" aria-controls="Apr" checked >
                                                                    <label for="tab4">Apr</label>
                                                                    <input type="radio" name="tabset1" id="tab2" aria-controls="May" >
                                                                    <label for="tab2">May</label>
                                                                    <input type="radio" name="tabset1" id="tab3" aria-controls="Jun" >
                                                                    <label for="tab3">Jun</label>
                                                                    <div class="tab-panels">
                                                                        <section class="tab-panel" id="Apr">
                                                                            <div class="aprBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtApril" name='aprContent' placeholder="Plan for April"><?= str_replace("\\r\\n", '', $qualitative_data[0]['apr_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section class="tab-panel" id="May">
                                                                            <div class="mayBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtMay" name='mayContent' placeholder="Plan for May"><?= str_replace("\\r\\n", '', $qualitative_data[0]['may_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section class="tab-panel" id="Jun">
                                                                            <div class="junBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtJune" name='junContent' placeholder="Plan for June"><?= str_replace("\\r\\n", '', $qualitative_data[0]['jun_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                                <p><?php echo strip_tags(stripslashes($qualitative_data[0]['q_one_desc']),$allowedTags); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <p>Q2 (Jul-Sep <?= $current_financial; ?>)</p>
                                                            <div class="quaterlyCardnew" id="qTwo_active">
                                                                <textarea rows="3" class="mceEditor" id="txtQuarterTwo" name="qTwoDesc" placeholder="Enter quarterly plan details in here"><?= str_replace("\\r\\n", '', $qualitative_data[0]['q_two_desc']); ?></textarea>
                                                                <div class="tabset2">
                                                                    <input type="radio" name="tabset2" id="tab5" aria-controls="Jul" checked >
                                                                    <label for="tab5">Jul</label>
                                                                    <input type="radio" name="tabset2" id="tab6" aria-controls="Aug" >
                                                                    <label for="tab6">Aug</label>
                                                                    <input type="radio" name="tabset2" id="tab7" aria-controls="Sep" >
                                                                    <label for="tab7">Sep</label>

                                                                    <div class="tab-panels">
                                                                        <section id="Jul" class="tab-panel">
                                                                            <div class="julBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtJuly" name='julContent' placeholder="Plan for July"><?= str_replace("\\r\\n", '', $qualitative_data[0]['jul_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section id="Aug" class="tab-panel">
                                                                            <div class="augBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtAugust" name='augContent' placeholder="Plan for August"><?= str_replace("\\r\\n", '', $qualitative_data[0]['aug_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section id="Sep" class="tab-panel">
                                                                            <div class="sepBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtSeptember" name='sepContent' placeholder="Plan for September"><?= str_replace("\\r\\n", '', $qualitative_data[0]['sep_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <p>Q3 (Oct-Dec <?= $current_financial; ?>)</p>
                                                            <div class="quaterlyCardnew" id="qThree_active">
                                                                <textarea rows="3" class="mceEditor" id="txtQuarterThree" name="qThreeDesc" placeholder="Enter quarterly plan details in here"><?= str_replace("\\r\\n", '', $qualitative_data[0]['q_three_desc']); ?></textarea>
                                                                <div class="tabset3">
                                                                    <input type="radio" name="tabset3" id="tab8" aria-controls="Oct" checked >
                                                                    <label for="tab8">Oct</label>
                                                                    <input type="radio" name="tabset3" id="tab9" aria-controls="Nov" >
                                                                    <label for="tab9">Nov</label>
                                                                    <input type="radio" name="tabset3" id="tab10" aria-controls="Dec" >
                                                                    <label for="tab10">Dec</label>

                                                                    <div class="tab-panels">
                                                                        <section id="Oct" class="tab-panel">
                                                                            <div class="octBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtOctober" name='octContent' placeholder="Plan for October"><?= str_replace("\\r\\n", '', $qualitative_data[0]['oct_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section id="Nov" class="tab-panel">
                                                                            <div class="novBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtNovember" name='novContent' placeholder="Plan for November"><?= str_replace("\\r\\n", '', $qualitative_data[0]['nov_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section id="Dec" class="tab-panel">
                                                                            <div class="decBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtDecember" name='decContent' placeholder="Plan for December"><?= str_replace("\\r\\n", '', $qualitative_data[0]['dec_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <p>Q4 (Jan-Mar <?= $current_financial; ?>)</p>
                                                            <div class="quaterlyCardnew" id="qFour_active">
                                                                <textarea rows="3" class="mceEditor" id="txtQuarterFour" name="qFourDesc" placeholder="Enter quarterly plan details in here"><?= str_replace("\\r\\n", '', $qualitative_data[0]['q_four_desc']); ?></textarea>
                                                                <div class="tabset4">
                                                                    <input type="radio" name="tabset4" id="tab11" aria-controls="Jan" checked >
                                                                    <label for="tab11">Jan</label>
                                                                    <input type="radio" name="tabset4" id="tab12" aria-controls="Feb" >
                                                                    <label for="tab12">Feb</label>
                                                                    <input type="radio" name="tabset4" id="tab13" aria-controls="Mar" >
                                                                    <label for="tab13">Mar</label>

                                                                    <div class="tab-panels">
                                                                        <section id="Jan" class="tab-panel">
                                                                            <div class="janBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtJanuary" name='janContent' placeholder="Plan for January"><?= str_replace("\\r\\n", '', $qualitative_data[0]['jan_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section id="Feb" class="tab-panel">
                                                                            <div class="febBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtFebruary" name='febContent' placeholder="Plan for February"><?= str_replace("\\r\\n", '', $qualitative_data[0]['feb_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                        <section id="Mar" class="tab-panel">
                                                                            <div class="marBox">
                                                                                <textarea rows="3" class="mceEditor" id="txtMarch" name='marContent' placeholder="Plan for March"><?= str_replace("\\r\\n", '', $qualitative_data[0]['mar_desc']); ?></textarea>
                                                                            </div>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="planBox" value="<?= $this->session->userdata['plan_lightbox']; ?>">

            <div class="modal" id="planModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content data_congifpopup">
                        <div class="modal-header text-center">
                            <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                                        class="fas fa-check-circle"></i></span> Successfully updated the plan</h5>
                        </div>
                        <div class="modal-body onboarding-permission text-center">
                            <ul>
                                <li>You have successfully saved & updated the plan for <br>"<strong><span>
                                            <?php
                                            echo ucfirst($company_name) . ', ';
                                            if ($reg_city != '') {
                                                echo ucfirst($reg_city) . ', ';
                                            }
                                            if ($sector_name != '') {
                                                echo ucfirst($sector_name);
                                            }
                                            ?>
                                        </span></strong>"</li>
                            </ul>
                            <div class="popup-content-final popup-content">
                                <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Later</a>
                                <!--<a class="btn btn-configure " href="javascript:void(0)"  >Send for Approval Now</a>-->
                                <a class="btn btn-configure" data-toggle="modal" data-target="#sendapproval">Send for Approval Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- approval send modal -->
            <div class="modal" id="sendapproval" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content data_congifpopup">
                        <div class="modal-header text-center">
                            <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                                        class="fas fa-check-circle"></i></span> Sending for Approval</h5>
                        </div>
                        <div class="modal-body onboarding-permission text-center">
                            <ul>
                                <li>The updated plan for <?= $company_name; ?> will now be sent to <?= $sector_lead[0]['emp_names']; ?> for approval. Click Okay to proceed.</li>
                            </ul>
                            <div class="popup-content-final popup-content">
                                <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a>
                                <a class="btn btn-configure" href="javascript:void(0)" onclick="sendApproval();">Okay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
            <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">

            <?php
            $this->session->set_userdata('plan_lightbox', 0);
            $this->session->set_userdata('approve_success', 0);
            ?>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
            <script src="<?php echo base_url() . 'source/portfolio_assets/js/tinymce.min.js'; ?>"></script>

            <script type="text/javascript">

                                    $(window).on("load", function () {
                                        ($("iframe").contents().click(function (event) {
                                            $('.quaterlyCardnew').removeClass('greenplantxt');
                                            if (event.target.localName == 'html') {
                                                var div_id = event.target.childNodes[1].attributes["0"].ownerElement.dataset.id
                                            } else if (event.target.localName == 'body') {
                                                var div_id = event.target.dataset.id;
                                            } else {
                                                var div_id = event.target.offsetParent.attributes["0"].ownerElement.dataset.id;
                                            }

                                            if (div_id == 'txtQuarterOne' || div_id == 'txtApril' || div_id == 'txtMay' || div_id == 'txtJune') {
                                                $("#qOne_active").addClass("greenplantxt");
                                            } else if (div_id == 'txtQuarterTwo' || div_id == 'txtJuly' || div_id == 'txtAugust' || div_id == 'txtSeptember') {
                                                $("#qTwo_active").addClass("greenplantxt");
                                            } else if (div_id == 'txtQuarterThree' || div_id == 'txtOctober' || div_id == 'txtNovember' || div_id == 'txtDecember') {
                                                $("#qThree_active").addClass("greenplantxt");
                                            } else if (div_id == 'txtQuarterFour' || div_id == 'txtJanuary' || div_id == 'txtFebruary' || div_id == 'txtMarch') {
                                                $("#qFour_active").addClass("greenplantxt");
                                            }
                                        }));
                                    });

                                    tinyMCE.init({
                                        mode: "specific_textareas",
                                        editor_selector: "mceEditor",
                                        entity_encoding: "numeric",
                                        menubar: false,
                                        plugins: [
                                            'lists',
                                            'tinymcespellchecker'
                                        ],
                                        toolbar: [
                                            'bold italic underline| numlist bullist outdent indent'
                                        ],
                                        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
                                        powerpaste_word_import: 'clean',
                                        powerpaste_html_import: 'clean',
                                        force_p_newlines : false,
										force_br_newlines : true,
										convert_newlines_to_brs : false,
										remove_linebreaks : true
                                    });

                                    $(document).ready(function () {
                                        var popup = $('#planBox').val();
                                        onLoad();
                                        setTimeout(function () {
                                            $('#approveMsg').hide();
                                            $('#approveallMsg').hide();
                                        }, 3000);
                                    });

                                    $(document).on('click', '#sendApproval', function () {
                                        $('#sendapproval').modal('show');
                                    });

                                    function sendApproval() {
                                        var inv_id = $('#innovation_id').val();
                                        var fin_year = $('#cur_finance').val();
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>index.php/portfolio/sendapproval",
                                            data: {
                                                fin_year: fin_year,
                                                invid: inv_id,
                                                table: 'port_config_approval'
                                            },
                                            dataType: 'json',
                                            success: function (msg) {
                                                if (msg == '1') {
                                                    location.reload();
                                                }
                                            }
                                        });
                                    }

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
                                            $('#edit_sales_' + inc).addClass('opacity5');
                                            $('#delete_sales_' + inc).addClass('opacity5');
                                        });
                                    }

                                    $(".saveContinue").on('click', function (e) {
                                        if ($('#skuData').valid()) {
                                            $('.saveContinue').css('pointer-events', 'none');
                                            $('#skuData').submit();
                                            e.preventDefault();
                                        }
                                    });

                                    function loadYear(year) {
                                        var inv_id = $('#inv_id').val();
                                        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/product/' + inv_id + '/' + year;
                                    }

                                    $(document).on('click', '.capitilize', function () {
                                        var inv_id = $('#innovation_id').val();
                                        var fin_year = $('#cur_finance').val();
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>index.php/portfolio/productApproved",
                                            data: {
                                                inv_id: inv_id,
                                                fin_year: fin_year
                                            },
                                            dataType: 'json',
                                            success: function (msg) {
                                                location.reload();
                                            }
                                        });
                                    });
                                    $(document).on('click', '.approveall', function () {
                                        var inv_id = $('#innovation_id').val();
                                        var fin_year = $('#cur_finance').val();
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>index.php/portfolio/ApproveAll",
                                            data: {
                                                inv_id: inv_id,
                                                fin_year: fin_year
                                            },
                                            dataType: 'json',
                                            success: function (msg) {
                                                setTimeout(function () {
                                                    location.reload();
                                                }, 1000);
                                            }
                                        });
                                    });

            </script>

            <style>
                .saleslabel{cursor: pointer;}

                .tox-notifications-container, .tox-statusbar{display:none !important;}
                .tab-panels p{height: 100px !important;}
                .tox{height: 140px !important;}

            </style>

    </body>
</html>