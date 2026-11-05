<?php $this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => 'Portfolio Summary', 'portfolio_summary' => 'yes')); ?>
<div id="loaderGif"></div>
<div class="vil-sub_menu deal-bread fixed-header-2">
    <div>
        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-8 col-12">
                <ul class="milestone-links">
                    <li>
                        <div class="form-group">
                            <ul class="milestone-links">
                                <li>
                                    <select name="txtSector" id="txtSector" class="form-control form-control-sm" onchange="load_sector(this.value)">
                                        <option value="">All Sectors</option>
                                        <?php
                                        foreach ($sectors_values as $row) {
											if($row['id']!='3' &&  $row['id']!='109'){ // Education sector removed
                                            ?>
                                            <option value="<?php echo $row['id']; ?>" <?php
                                            if ($row['id'] == $default_sector) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $row['sector']; ?></option>
                                                <?php 
												
												}
												
												} ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="form-group">
                            <ul class="milestone-links sectormenusnav">
                                <li>
                                    <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="load_year(this.value);">
                                        <?php
                                        if (count($fin_year) > 0) {
                                            foreach ($fin_year as $year) {
                                                $nxt_fyear = $year['fin_year'] + 1;
                                                ?>
                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="<?= date('Y'); ?>" <?php if (isset($current_fy) && $current_fy == date('Y')) { ?> selected <?php } ?>><?= date('Y'); ?></option>
                                        <?php } ?>
                                    </select>
                                </li>
                                <li><select class="form-control form-control-sm" name="quarter_name" id="quarter_name" onchange="load_quarter(this.value);">
                                        <option value="1">Q1</option>
                                        <option value="2">Q2</option>
                                        <option value="3">Q3</option>
                                        <option value="4">Q4</option>
                                        <option value="5" selected="">Annual</option>
                                    </select>
                                </li>
                                <li>
                                    <?php
                                    $g_label = $this->session->userdata['graph_label'];
                                    if ($g_label == 1) {
                                        $swt_check = 'Checked';
                                        $swt_title = 'Data labels - on';
                                    } else {
                                        $swt_check = '';
                                        $swt_title = 'Data labels - off';
                                    }
                                    ?>
                                    <div style="padding-top:8px">
                                        Data Labels&nbsp;&nbsp;
                                        <label class="switch">
                                            <input type="checkbox" name="graphLabel" id="graphLabel" <?= $swt_check; ?>>
                                            <span title="<?= $swt_title; ?>" class="slider round" id="labelSwitch"></span>
                                        </label>
                                    </div>
                                </li>
                                <!-- <li style="margin-left: 40px;">
                                    <a href="<?= base_url() . 'index.php/portfolio/portfolio_summary_new'; ?>" target="_blank" class="active">New! VITALS Analytics Dashboard</a>
                                </li> -->
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-4 col-12 text-right">
                <ul class="milestone-links sectormenusnav">
					<li>
						<select class="form-control form-control-sm" name="table_year" id="table_year">
							<?php
							if (count($fin_year) > 0) {
								foreach ($fin_year as $year) {
									if($year['fin_year'] > 2018){
									$nxt_fyear = $year['fin_year'] + 1;
									?>
									<option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?>  <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
									<?php
									}
								}
							} else {
								?>
								<option value="<?= date('Y'); ?>" <?php if (isset($current_fy) && $current_fy == date('Y')) { ?>  <?php } ?>><?= date('Y'); ?></option>
							<?php } ?>
						</select>
					</li>
					<input style="color: #fff;background-color: #2e8751;border-color: #6c757d;" type="button" id="submit_summary_table" onclick="submit_summary();" class="btn btn-secondary  btnColor" value="Save">
					
                    <span id="show_secLink">
                        <li>
                            <a id="load_sectorPlan" href="<?= base_url() . 'index.php/portfolio/sector_plan/discovery/' . $default_sector . '/' . $current_fy; ?>">Sector Plan</a>
                        </li>
                        <li>
                            <a id="load_sectorAchievement" href="<?= base_url() . 'index.php/portfolio/sector_actual/discovery/' . $default_sector . '/' . $current_fy; ?>">Sector Achievements</a>
                        </li>
                    </span>
                    <li>
                        <?php
                        if ($default_sector == '') {
                            $export_link = 'all';
                        } else {
//                            $export_link = $default_export;
                            $export_link = '';
                        }
                        ?>
                        <a href="<?= base_url() . 'index.php/portfolio/sectorwise_incubatee_export/' . $export_link . '/' . $current_fy; ?>" id="portfolio_export" title="Export Sector Summary"><i class="fas fa-file-export"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Inner Dashboard-->
<div style="position:relative">
    <div class="vi-dashboard-portfolio vi-dashboard-top170">
        <div class="">
            <div id="sector_summary_link">
                <div class="tab-slider--navform" style="padding: 0px 0px 0;border-bottom: 1px solid #abe0bf;margin-top: 5px;margin-bottom:0px;">
                    <ul class="tab-slider--tabsform">
                        <li class="tab-slider--triggerform active" id="inc_tabMenu" style="width: 50%;"><a href="javascript:void(0)">Incubatee Summary</a></li>
                        <li class="tab-slider--triggerform" id="sec_tabMenu" style="width: 50%;"><a href="javascript:void(0)">Sector Summary</a></li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"> </div>
            <div class="scrollFinder scroll-summary" id="incubatee_rollup">
                <!--Finance & Fundraise-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi mar-tp0" id="finance_graphSec">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Finance & Fundraise</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="fundraiseTab" id="fundraiseTab" class="form-control form-control-sm" onchange="finance_fundraise(); finance_fundraise_conversation();">
                                                            <option value="1">Revenue</option>
                                                            <option value="2">Profit</option>
                                                            <option value="3">Fundraise</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="fundraise_fyear" id="fundraise_fyear" onchange="finance_fundraise(); finance_fundraise_conversation();">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="fundraise_chartView" id="fundraise_chartView" onchange="finance_fundraise();">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="finance_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="finance_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="finance_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="finance_submitBtn" onclick="commentSubmit('finance_chartSubmit', 'finance');" class="btn btn-secondary  btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="finance_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="finance_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="finance_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="finance_module_id" value="">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="finance_commentMsg"></span>
                                                <div class="chatWindow-model" id="finance_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Product & Sales-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Product & Sales</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="productTab" id="productTab" class="form-control form-control-sm" onchange="product_sales(); product_sales_conversation();">
                                                            <option value="1">Product</option>
                                                            <option value="2">Sales - <?= $this->session->userdata['currency']; ?></option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="product_fyear" id="product_fyear" onchange="product_sales(); product_sales_conversation();">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="product_chartView" id="product_chartView" onchange="product_sales();">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="product_sales_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="product_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="product_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="product_submitBtn" onclick="commentSubmit('product_chartSubmit', 'product');" class="btn btn-secondary btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="product_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="product_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="product_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="product_module_id" value="">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="product_commentMsg"></span>
                                                <div class="chatWindow-model" id="product_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Team & Board Meeting-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Team & Board Meeting</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="teamTab" id="teamTab" class="form-control form-control-sm" onchange="team_board_meeting(); team_board_conversation();">
                                                            <option value="1">Recruitment</option>
                                                            <option value="2">Attrition</option>
                                                            <option value="3">Board Meetings</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="team_fyear" id="team_fyear" onchange="team_board_meeting(); team_board_conversation();">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="team_chartView" id="team_chartView" onchange="team_board_meeting();">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="team_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="team_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="team_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="team_submitBtn" onclick="commentSubmit('team_chartSubmit', 'team');" class="btn btn-secondary btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="team_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="team_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="team_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="team_module_id" value="">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="team_commentMsg"></span>
                                                <div class="chatWindow-model" id="team_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- impact -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Impact</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="impactTab" id="impactTab" class="form-control form-control-sm" onchange="impact(); impact_board_conversation();">
                                                            <option value="1">No. of End Beneficiaries</option>
                                                            <option value="2">No. of Direct Jobs Created</option>
                                                            <option value="3">No. of Indirect Jobs Created</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm dropdown" name="impact_fyear" id="impact_fyear" onchange="impact(); impact_board_conversation();">
                                                            <option value="">--Year--</option>
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" class="impact_chartView" id="impact_chartView" onchange="impact();">
                                                            <option value="">--Select--</option>
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected>Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)">
                                                <div id="all_impact"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="impact_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="impact_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="impact_submitBtn" onclick="commentSubmit('impact_chartSubmit', 'impact');" class="btn btn-secondary btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="impact_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="impact_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="impact_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="impact_module_id" value="">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="impact_commentMsg"></span>
                                                <div class="chatWindow-model" id="impact_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div
                <!--Mentors & Partnerships-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Mentors & Partnerships</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="mentorTab" id="mentorTab" class="form-control form-control-sm" onchange="mentor_partnerships(); mentor_partner_conversation();">
                                                            <option value="1">Mentor Hours</option>
                                                            <option value="2">Mentor Numbers</option>
                                                            <option value="3">Technical Assistance</option>
                                                            <option value="4">Partnerships</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="mentor_fyear" id="mentor_fyear" onchange="mentor_partnerships(); mentor_partner_conversation();">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="mentor_chartView" id="mentor_chartView" onchange="mentor_partnerships();">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="mentor_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="mentor_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="mentor_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="mentor_submitBtn" onclick="commentSubmit('mentor_chartSubmit', 'mentor');" class="btn btn-secondary btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="mentor_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="mentor_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="mentor_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="mentor_module_id" value="">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="mentor_commentMsg"></span>
                                                <div class="chatWindow-model" id="mentor_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Diagnostic Panels-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Diagnostic Panels</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links sectormenusnav">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <input type="text" class="form-control form-control-sm" readonly="" value="Diagnostic Panels">
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="diagnostic_fyear" id="diagnostic_fyear" onchange="diagnostic_panels(); diagnostic_panel_conversation();">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="diagnostic_chartView" id="diagnostic_chartView" onchange="diagnostic_panels(); diagnostic_panel_conversation();">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="diagnostic_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="diagnostic_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="diagnostic_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="diagnostic_submitBtn" onclick="commentSubmit('diagnostic_chartSubmit', 'diagnostic');" class="btn btn-secondary btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="diagnostic_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="diagnostic_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="diagnostic_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="diagnostic_module_id" value="16">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="diagnostic_commentMsg"></span>
                                                <div class="chatWindow-model" id="diagnostic_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Seed Funding-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Seed Funding</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links sectormenusnav">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <input type="text" class="form-control form-control-sm" readonly="" value="Seed Funding">
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="seed_fyear" id="seed_fyear" onchange="seed_funding(); seed_fund_conversation();">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="seed_chartView" id="seed_chartView" onchange="seed_funding(); seed_fund_conversation();">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="seed_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                        <div class="vil_chatpart marlt_14">
                                            <div class="newChatPortfolio-model">
                                                <h3 class="wdt-100">Comments</h3>
                                                <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <form id="seed_chartSubmit" method="POST" autocomplete="off">
                                                        <div class="input-group">
                                                            <input type="text" name="txt_description" id="seed_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                            <div class="input-group-append">
                                                                <input type="button" id="seed_submitBtn" onclick="commentSubmit('seed_chartSubmit', 'seed');" class="btn btn-secondary btnColor" value="Submit">
                                                            </div>
                                                        </div>
                                                        <label for="seed_text_description" class="error"></label>
                                                        <input type="hidden" name="chart_sector" id="seed_sector" value="<?= $default_sector; ?>">
                                                        <input type="hidden" name="chat_finYear" id="seed_chatFyear" value="<?= $chart_fyear; ?>">
                                                        <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                        <input type="hidden" name="module_id" id="seed_module_id" value="17">
                                                    </form>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <span class="text-success" id="seed_commentMsg"></span>
                                                <div class="chatWindow-model" id="seed_conversation_data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Upcoming Board Meetings/Diagnostic Panels</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                            </div>
                        </div>
                        <div class="bg-white">
                            <div class="vil-milestone portfolio-table" style="height: 100%;border-left: 1px solid #c9e4d4">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Incubatee</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $s = 1;
                                        foreach ($upcoming_milestone as $miles) {
                                            if ($miles['type'] == 1) {
                                                $type = 'Diagnostic Panel';
                                            } else if ($miles['type'] == 2) {
                                                $type = 'Board Meeting';
                                            } else {
                                                $type = '-';
                                            }
                                            $task_date = (isset($miles['due_by']) && $miles['due_by'] != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($miles['due_by'])) : '';
                                            ?>
                                            <tr>
                                                <td><?= $s; ?></td>
                                                <td><?= strlen($miles['company_name']) > 20 ? substr($miles['company_name'], 0, 20) . "..." : $miles['company_name']; ?></td>
                                                <td><?= $type; ?></td>
                                                <td><?= $task_date; ?></td>
                                                <td><?= strlen($miles['task_name']) > 15 ? substr($miles['task_name'], 0, 15) . "..." : $miles['task_name']; ?></td>
                                            </tr>
                                            <?php
                                            $s++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid pad-none">
            <div class="scrollFinder scroll-summary" id="sector_dashboard">
                <!--Discovery-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi mar-tp0">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Discovery</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <input type="text" name="discoveryTab" id="discoveryTab" class="form-control form-control-sm" readonly="" value="Total no. of Application">
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="discovery_fyear" id="discovery_fyear" onchange="sectorGraph('discovery'); sector_qualitative('discovery', 'loadDiscoveryQualitative');sector_conversation('discovery');">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="discovery_chartView" id="discovery_chartView" onchange="sectorGraph('discovery');">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="discovery_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="sector_qualView">
                                        <div class="vil_chatHead expandNewChat_head">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h4>Plans & Achievements</h4>
                                                </div>
                                                <div class="col-lg-5 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <div class="form-group">
                                                                <ul class="milestone-links sectormenusnav">
                                                                    <li>
                                                                        <select class="form-control form-control-sm dropdown" name="discovery_quarter" id="discovery_quarter" onchange="sector_qualitative('discovery', 'loadDiscoveryQualitative');">
                                                                            <option value="1">Q1</option>
                                                                            <option value="2">Q2</option>
                                                                            <option value="3">Q3</option>
                                                                            <option value="4">Q4</option>
                                                                            <option value="5" selected="">Annual</option>
                                                                        </select>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vil_chatsec scrollbar " id="style-1">
                                            <div class="vil_chatpart">
                                                <div id="loadDiscoveryQualitative"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sector_chatView">
                                        <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                            <div class="vil_chatpart marlt_14">
                                                <div class="newChatPortfolio-model">
                                                    <h3 class="wdt-100">Comments</h3>
                                                    <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <form id="discovery_chartSubmit" method="POST" autocomplete="off">
                                                            <div class="input-group">
                                                                <input type="text" name="txt_description" id="discovery_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                                <div class="input-group-append">
                                                                    <input type="button" id="discovery_submitBtn" onclick="commentSubmit('discovery_chartSubmit', 'discovery');" class="btn btn-secondary btnColor" value="Submit">
                                                                </div>
                                                            </div>
                                                            <label for="discovery_text_description" class="error"></label>
                                                            <input type="hidden" name="chart_sector" id="discovery_sector" value="<?= $default_sector; ?>">
                                                            <input type="hidden" name="chat_finYear" id="discovery_chatFyear" value="<?= $chart_fyear; ?>">
                                                            <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                            <input type="hidden" name="module_id" id="discovery_module_id" value="21">
                                                        </form>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <span class="text-success" id="discovery_commentMsg"></span>
                                                    <div class="chatWindow-model" id="discovery_conversation_data"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Diligence-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Diligence</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="diligenceTab" id="diligenceTab" class="form-control form-control-sm" onchange="sectorGraph('diligence'); sector_qualitative('diligence', 'loadDiligenceQualitative');sector_conversation('diligence');">
                                                            <option value="1">No. of Deals at PA/RD</option>
                                                            <option value="2">No. of Deals brought to IIC</option>
                                                            <option value="3">No. of Deals brought to EIC</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="diligence_fyear" id="diligence_fyear" onchange="sectorGraph('diligence'); sector_qualitative('diligence', 'loadDiligenceQualitative');sector_conversation('diligence');">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="diligence_chartView" id="diligence_chartView" onchange="sectorGraph('diligence');">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="diligence_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="sector_qualView">
                                        <div class="vil_chatHead expandNewChat_head">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h4>Plans & Achievements</h4>
                                                </div>
                                                <div class="col-lg-5 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <div class="form-group">
                                                                <ul class="milestone-links sectormenusnav">
                                                                    <li>
                                                                        <select class="form-control form-control-sm dropdown" name="diligence_quarter" id="diligence_quarter" onchange="sector_qualitative('diligence', 'loadDiligenceQualitative');">
                                                                            <option value="1">Q1</option>
                                                                            <option value="2">Q2</option>
                                                                            <option value="3">Q3</option>
                                                                            <option value="4">Q4</option>
                                                                            <option value="5" selected="">Annual</option>
                                                                        </select>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vil_chatsec scrollbar " id="style-1">
                                            <div class="vil_chatpart">
                                                <div id="loadDiligenceQualitative"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sector_chatView">
                                        <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                            <div class="vil_chatpart marlt_14">
                                                <div class="newChatPortfolio-model">
                                                    <h3 class="wdt-100">Comments</h3>
                                                    <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <form id="diligence_chartSubmit" method="POST" autocomplete="off">
                                                            <div class="input-group">
                                                                <input type="text" name="txt_description" id="diligence_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                                <div class="input-group-append">
                                                                    <input type="button" id="diligence_submitBtn" onclick="commentSubmit('diligence_chartSubmit', 'diligence');" class="btn btn-secondary  btnColor" value="Submit">
                                                                </div>
                                                            </div>
                                                            <label for="diligence_text_description" class="error"></label>
                                                            <input type="hidden" name="chart_sector" id="diligence_sector" value="<?= $default_sector; ?>">
                                                            <input type="hidden" name="chat_finYear" id="diligence_chatFyear" value="<?= $chart_fyear; ?>">
                                                            <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                            <input type="hidden" name="module_id" id="diligence_module_id" value="">
                                                        </form>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <span class="text-success" id="diligence_commentMsg"></span>
                                                    <div class="chatWindow-model" id="diligence_conversation_data"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- selection -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Selection</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="selectionTab" id="selectionTab" class="form-control form-control-sm" onchange="sectorGraph('selection'); sector_qualitative('selection', 'loadSelectionQualitative');sector_conversation('selection');" style="width: 200px;">
                                                            <option value="1">No. of new companies</option>
                                                            <option value="2">Total no. of companies in portfolio</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm dropdown" name="selection_fyear" id="selection_fyear" onchange="sectorGraph('selection'); sector_qualitative('selection', 'loadSelectionQualitative');sector_conversation('selection');">
                                                            <option value="">--Year--</option>
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" class="selection_chartView" id="selection_chartView" onchange="sectorGraph('selection');">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected>Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)">
                                                <div id="selection_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="sector_qualView">
                                        <div class="vil_chatHead expandNewChat_head">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h4>Plans & Achievements</h4>
                                                </div>
                                                <div class="col-lg-5 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <div class="form-group">
                                                                <ul class="milestone-links sectormenusnav">
                                                                    <li>
                                                                        <select class="form-control form-control-sm dropdown" name="selection_quarter" id="selection_quarter" onchange="sector_qualitative('selection', 'loadSelectionQualitative');">
                                                                            <option value="1">Q1</option>
                                                                            <option value="2">Q2</option>
                                                                            <option value="3">Q3</option>
                                                                            <option value="4">Q4</option>
                                                                            <option value="5" selected="">Annual</option>
                                                                        </select>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vil_chatsec scrollbar" id="style-1">
                                            <div class="vil_chatpart">
                                                <div id="loadSelectionQualitative"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sector_chatView">
                                        <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                            <div class="vil_chatpart marlt_14">
                                                <div class="newChatPortfolio-model">
                                                    <h3 class="wdt-100">Comments</h3>
                                                    <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <form id="selection_chartSubmit" method="POST" autocomplete="off">
                                                            <div class="input-group">
                                                                <input type="text" name="txt_description" id="selection_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                                <div class="input-group-append">
                                                                    <input type="button" id="selection_submitBtn" onclick="commentSubmit('selection_chartSubmit', 'selection');" class="btn btn-secondary  btnColor" value="Submit">
                                                                </div>
                                                            </div>
                                                            <label for="selection_text_description" class="error"></label>
                                                            <input type="hidden" name="chart_sector" id="selection_sector" value="<?= $default_sector; ?>">
                                                            <input type="hidden" name="chat_finYear" id="selection_chatFyear" value="<?= $chart_fyear; ?>">
                                                            <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                            <input type="hidden" name="module_id" id="selection_module_id" value="">
                                                        </form>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <span class="text-success" id="selection_commentMsg"></span>
                                                    <div class="chatWindow-model" id="selection_conversation_data"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--Graduates & Exits-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Graduates & Exits</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="graduates_exitsTab" id="graduates_exitsTab" class="form-control form-control-sm" onchange="sectorGraph('graduates_exits'); sector_qualitative('graduates_exits', 'loadGraduatesexitsQualitative');sector_conversation('graduates_exits');">
                                                            <option value="1">Graduates (Non-Financial)</option>
                                                            <option value="2">Exits (With Equity)</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="graduates_exits_fyear" id="graduates_exits_fyear" onchange="sectorGraph('graduates_exits'); sector_qualitative('graduates_exits', 'loadGraduatesexitsQualitative');sector_conversation('graduates_exits');">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="graduates_exits_chartView" id="graduates_exits_chartView" onchange="sectorGraph('graduates_exits');">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="graduates_exits_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="sector_qualView">
                                        <div class="vil_chatHead expandNewChat_head">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h4>Plans & Achievements</h4>
                                                </div>
                                                <div class="col-lg-5 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <div class="form-group">
                                                                <ul class="milestone-links sectormenusnav">
                                                                    <li>
                                                                        <select class="form-control form-control-sm dropdown" name="graduates_exits_quarter" id="graduates_exits_quarter" onchange="sector_qualitative('graduates_exits', 'loadGraduatesexitsQualitative');">
                                                                            <option value="1">Q1</option>
                                                                            <option value="2">Q2</option>
                                                                            <option value="3">Q3</option>
                                                                            <option value="4">Q4</option>
                                                                            <option value="5" selected="">Annual</option>
                                                                        </select>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vil_chatsec scrollbar" id="style-1">
                                            <div class="vil_chatpart">
                                                <div id="loadGraduatesexitsQualitative"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sector_chatView">
                                        <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                            <div class="vil_chatpart marlt_14">
                                                <div class="newChatPortfolio-model">
                                                    <h3 class="wdt-100">Comments</h3>
                                                    <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <form id="graduates_exits_chartSubmit" method="POST" autocomplete="off">
                                                            <div class="input-group">
                                                                <input type="text" name="txt_description" id="graduates_exits_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                                <div class="input-group-append">
                                                                    <input type="button" id="graduates_exits_submitBtn" onclick="commentSubmit('graduates_exits_chartSubmit', 'graduates_exits');" class="btn btn-secondary  btnColor" value="Submit">
                                                                </div>
                                                            </div>
                                                            <label for="graduates_exits_text_description" class="error"></label>
                                                            <input type="hidden" name="chart_sector" id="graduates_exits_sector" value="<?= $default_sector; ?>">
                                                            <input type="hidden" name="chat_finYear" id="graduates_exits_chatFyear" value="<?= $chart_fyear; ?>">
                                                            <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                            <input type="hidden" name="module_id" id="graduates_exits_module_id" value="">
                                                        </form>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <span class="text-success" id="graduates_exits_commentMsg"></span>
                                                    <div class="chatWindow-model" id="graduates_exits_conversation_data"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fundraise-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Fundraise</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="sectorfundraiseTab" id="sectorfundraiseTab" class="form-control form-control-sm" onchange="sectorGraph('sectorfundraise'); sector_qualitative('sectorfundraise', 'loadSectorfundraiseQualitative');sector_conversation('sectorfundraise');">
                                                            <option value="1">Renewal Agreements</option>
                                                            <option value="2">New Agreements</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="sectorfundraise_fyear" id="sectorfundraise_fyear" onchange="sectorGraph('sectorfundraise'); sector_qualitative('sectorfundraise', 'loadSectorfundraiseQualitative');sector_conversation('sectorfundraise');">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="sectorfundraise_chartView" id="sectorfundraise_chartView" onchange="sectorGraph('sectorfundraise');">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="sectorfundraise_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="sector_qualView">
                                        <div class="vil_chatHead expandNewChat_head">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h4>Plans & Achievements</h4>
                                                </div>
                                                <div class="col-lg-5 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <div class="form-group">
                                                                <ul class="milestone-links sectormenusnav">
                                                                    <li>
                                                                        <select class="form-control form-control-sm dropdown" name="sectorfundraise_quarter" id="sectorfundraise_quarter" onchange="sector_qualitative('sectorfundraise', 'loadSectorfundraiseQualitative');">
                                                                            <option value="1">Q1</option>
                                                                            <option value="2">Q2</option>
                                                                            <option value="3">Q3</option>
                                                                            <option value="4">Q4</option>
                                                                            <option value="5" selected="">Annual</option>
                                                                        </select>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vil_chatsec scrollbar" id="style-1">
                                            <div class="vil_chatpart">
                                                <div id="loadSectorfundraiseQualitative"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sector_chatView">
                                        <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                            <div class="vil_chatpart marlt_14">
                                                <div class="newChatPortfolio-model">
                                                    <h3 class="wdt-100">Comments</h3>
                                                    <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <form id="sectorfundraise_chartSubmit" method="POST" autocomplete="off">
                                                            <div class="input-group">
                                                                <input type="text" name="txt_description" id="sectorfundraise_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                                <div class="input-group-append">
                                                                    <input type="button" id="sectorfundraise_submitBtn" onclick="commentSubmit('sectorfundraise_chartSubmit', 'sectorfundraise');" class="btn btn-secondary  btnColor" value="Submit">
                                                                </div>
                                                            </div>
                                                            <label for="sectorfundraise_text_description" class="error"></label>
                                                            <input type="hidden" name="chart_sector" id="sectorfundraise_sector" value="<?= $default_sector; ?>">
                                                            <input type="hidden" name="chat_finYear" id="sectorfundraise_chatFyear" value="<?= $chart_fyear; ?>">
                                                            <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                            <input type="hidden" name="module_id" id="sectorfundraise_module_id" value="">
                                                        </form>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <span class="text-success" id="sectorfundraise_commentMsg"></span>
                                                    <div class="chatWindow-model" id="sectorfundraise_conversation_data"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Financial stability-->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Financial Stability</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph mar-bt0">
                            <div class="row">
                                <div class="col-lg-7 brd-rgtChart pad0 wdt_70c newChartPort">
                                    <ul class="milestone-links">
                                        <li>
                                            <div class="form-group">
                                                <ul class="milestone-links sectormenusnav">
                                                    <li><label>Category</label></li>
                                                    <li>
                                                        <!-- <label>Category</label> -->
                                                        <select name="financialstabilityTab" id="financialstabilityTab" class="form-control form-control-sm" onchange="sectorGraph('financialstability'); sector_qualitative('financialstability', 'loadFinancialStabilityQualitative');sector_conversation('financialstability');">
                                                            <option value="1">Equity Investments</option>
                                                            <option value="2">Service Agreements</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>Financial Year</label> -->
                                                        <select class="form-control form-control-sm" name="financialstability_fyear" id="financialstability_fyear" onchange="sectorGraph('financialstability'); sector_qualitative('financialstability', 'loadFinancialStabilityQualitative');sector_conversation('financialstability');">
                                                            <?php
                                                            foreach ($fin_year as $year) {
                                                                $nxt_fyear = $year['fin_year'] + 1;
                                                                ?>
                                                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <!-- <label>View</label> -->
                                                        <select class="form-control form-control-sm" name="financialstability_chartView" id="financialstability_chartView" onchange="sectorGraph('financialstability');">
                                                            <option value="1">Monthly</option>
                                                            <option value="2" selected="">Quarterly</option>
                                                        </select>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0);">
                                                <div id="financialstability_value"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 brd-rgtChart pad0 wdt_30c">
                                    <div class="sector_qualView">
                                        <div class="vil_chatHead expandNewChat_head">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h4>Plans & Achievements</h4>
                                                </div>
                                                <div class="col-lg-5 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <div class="form-group">
                                                                <ul class="milestone-links sectormenusnav">
                                                                    <li>
                                                                        <select class="form-control form-control-sm dropdown" name="financialstability_quarter" id="financialstability_quarter" onchange="sector_qualitative('financialstability', 'loadFinancialStabilityQualitative');">
                                                                            <option value="1">Q1</option>
                                                                            <option value="2">Q2</option>
                                                                            <option value="3">Q3</option>
                                                                            <option value="4">Q4</option>
                                                                            <option value="5" selected="">Annual</option>
                                                                        </select>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vil_chatsec scrollbar" id="style-1">
                                            <div class="vil_chatpart">
                                                <div id="loadFinancialStabilityQualitative"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sector_chatView">
                                        <div class="vil_chatsec scrollbar noScrollbar hgt-100" id="style-1">
                                            <div class="vil_chatpart marlt_14">
                                                <div class="newChatPortfolio-model">
                                                    <h3 class="wdt-100">Comments</h3>
                                                    <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <form id="financialstability_chartSubmit" method="POST" autocomplete="off">
                                                            <div class="input-group">
                                                                <input type="text" name="txt_description" id="financialstability_text_description" class="form-control enterSubmit" placeholder="Enter your comments">
                                                                <div class="input-group-append">
                                                                    <input type="button" id="financialstability_submitBtn" onclick="commentSubmit('financialstability_chartSubmit', 'financialstability');" class="btn btn-secondary  btnColor" value="Submit">
                                                                </div>
                                                            </div>
                                                            <label for="financialstability_text_description" class="error"></label>
                                                            <input type="hidden" name="chart_sector" id="financialstability_sector" value="<?= $default_sector; ?>">
                                                            <input type="hidden" name="chat_finYear" id="financialstability_chatFyear" value="<?= $chart_fyear; ?>">
                                                            <input type="hidden" name="chat_quarter" class="chat_quarter" value="5">
                                                            <input type="hidden" name="module_id" id="financialstability_module_id" value="">
                                                        </form>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <span class="text-success" id="financialstability_commentMsg"></span>
                                                    <div class="chatWindow-model" id="financialstability_conversation_data"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- <div class="portfolio-sidemenu"> -->
        <div class="sidebar-item">
            <aside class="portfolio-sidebar make-me-sticky">
                <div class="portfolio-Incubatees">
                    <label>Incubatees (<span id="incubatee_count"><?= count($company_list); ?></span>)</label>
                    <ul class="scroll-company">
                        <?php
                        $curr_user_inv = array();
                        $other_user_inv = array();
                        $exited_inv = $graduated_inv = array();
                        $i = 0;
                        foreach ($company_list as $company) {
                            if ($company['company_status'] == 3) {
                                $exited_inv[$i]['id'] = $company['id'];
                                $exited_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                $exited_inv[$i]['company_status'] = $company['company_status'];
                                $exited_inv[$i]['emp_id'] = $company['emp_id'];
                            } elseif ($company['company_status'] == 2) {
                                $graduated_inv[$i]['id'] = $company['id'];
                                $graduated_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                $graduated_inv[$i]['company_status'] = $company['company_status'];
                                $graduated_inv[$i]['emp_id'] = $company['emp_id'];
                            } else {
                                if (in_array($company['id'], $assignlist)) {
                                    $curr_user_inv[$i]['id'] = $company['id'];
                                    $curr_user_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                    $curr_user_inv[$i]['company_status'] = $company['company_status'];
                                    $curr_user_inv[$i]['emp_id'] = $company['emp_id'];
                                } else {
                                    $other_user_inv[$i]['id'] = $company['id'];
                                    $other_user_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                    $other_user_inv[$i]['company_status'] = $company['company_status'];
                                    $other_user_inv[$i]['emp_id'] = $company['emp_id'];
                                }
                            }
                            $i++;
                        }

                        $companies = array_merge($curr_user_inv, $other_user_inv);
                        $graduted = array_merge($companies, $graduated_inv);
                        $company_merge = array_merge($graduted, $exited_inv);
                        foreach ($company_merge as $company) {
                            $exit_class = '';
                            if ($company['company_status'] == 3 || $company['company_status'] == 2) {
                                $exit_class = 'addedExit';
                            }
                            ?>
                            <li><a href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $company['id'] . '/' . $current_fy; ?>" class="<?php echo $exit_class; ?>" title="<?php echo $company['name_of_enterprise']; ?>"><?= strlen($company['name_of_enterprise']) > 30 ? substr($company['name_of_enterprise'], 0, 30) . "..." : $company['name_of_enterprise']; ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </aside>
        </div>
        <!-- </div> -->
    </div>
</div>


<div class="modal fade seedfund-portfolio" id="chartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-head">
                <div class="title-cart-vi">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-12">
                            <h4 id="chartTitle"></h4>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="newmodelQuaterSlection">
                        <form method="post" id="chartFilter">
                            <div class="row">
                                <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                    <label class="wdt-100">View Type :</label>
                                    <select class="form-control form-control-sm" class="viewType" id="viewType" onchange="selectType(this.value);">
                                        <option value="">--Select--</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Quarterly</option>
                                    </select>
                                </div>
                                <div id="monthRange">
                                    <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                <label class="wdt-100">From :</label>
                                                <input Type="text" class="startDat form-control form-control-sm dateCalendar" id="startDate" name="startDate" placeholder="dd-mm-yyyy">
                                            </div>
                                            <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                <label class="wdt-100">To :</label>
                                                <input Type="text" class="endDat form-control form-control-sm dateCalendar" id="endDate" name="endDate" placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                    <label class="wdt-100">&nbsp;</label>
                                    <button class="btn btn-sm btn-success wdt-100" id="chart_searchBtn" type="button" onclick="totalCompanyFilter();">Search</button>
                                </div>
                                <input type="hidden" id="functionName" value="">
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                            <div id="charts1">
                                <div id="chartContent" class="chart_modal"></div>
                            </div>
                            <br>
                            <div class="loadChartBtn">
                                <span style="display: inline-block; width: 35px;">
                                    <a href="javascript:void(0)" id="pre_chart" title="Next">
                                        <i class="fas fa-chevron-circle-left"></i>
                                    </a>
                                </span>
                                <span style="display: inline-block; width: 35px;">
                                    <a href="javascript:void(0)" id="nxt_chart" title="Previous">
                                        <i class="fas fa-chevron-circle-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seedfund-portfolio" id="linechartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-head">
                <div class="title-cart-vi">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-12">
                            <h4 id="lineChartTitle"></h4>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="newmodelQuaterSlection">
                        <div class="row">
                            <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                <label class="wdt-100">View Type :</label>
                                <select class="form-control form-control-sm" class="lineViewType" id="lineViewType" onchange="selectLineType(this.value);">
                                    <option value="">--Select--</option>
                                    <option value="1">Monthly</option>
                                    <option value="2">Quarterly</option>
                                </select>
                            </div>
                            <div id="quarterView">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">From :</label>
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="fromQuarterName" id="fromQuarterName">
                                                        <option value="">--Quarter--</option>
                                                        <option value="1" selected="">Q1</option>
                                                        <option value="2">Q2</option>
                                                        <option value="3">Q3</option>
                                                        <option value="4">Q4</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="fromYear" id="fromYear">
                                                        <option value="">--Year--</option>
                                                        <?php foreach ($fin_year as $year) { ?>
                                                            <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">To :</label>
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="toQuarterName" id="toQuarterName">
                                                        <option value="">--Quarter--</option>
                                                        <option value="1">Q1</option>
                                                        <option value="2">Q2</option>
                                                        <option value="3">Q3</option>
                                                        <option value="4" selected="">Q4</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="toYear" id="toYear">
                                                        <option value="">--Year--</option>
                                                        <?php foreach ($fin_year as $year) { ?>
                                                            <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="monthView">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">From :</label>
                                            <input Type="text" class="form-control form-control-sm" id="lineStartDate" name="lineStartDate" placeholder="dd-mm-yyyy">
                                        </div>
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">To :</label>
                                            <input Type="text" class="form-control form-control-sm" id="lineEndDate" name="lineEndDate" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                <label class="wdt-100">&nbsp;</label>
                                <button class="btn btn-sm btn-success wdt-100" id="line_searchBtn" type="button" onclick="totalLineFilter();">Search</button>
                            </div>
                            <input type="hidden" id="lineName" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12 col-md-12 col-lg-12 bgf4f5fa">
                            <div id="charts1">
                                <div id="lineChartContent" class="chart_modal"></div>
                            </div>
                            <br>
                            <div class="loadChartBtn">
                                <span style="display: inline-block; width: 35px;">
                                    <a href="javascript:void(0)" id="line_pre_chart" title="Next">
                                        <i class="fas fa-chevron-circle-left"></i>
                                    </a>
                                </span>
                                <span style="display: inline-block; width: 35px;">
                                    <a href="javascript:void(0)" id="line_nxt_chart" title="Previous">
                                        <i class="fas fa-chevron-circle-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade seedfund-portfolio" id="newChartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-head">
                <div class="title-cart-vi">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-12">
                            <h4 id="newChartTitle"></h4>
                        </div>
                        <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="newmodelQuaterSlection">
                        <div class="row">
                            <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                <label class="wdt-100">View Type :</label>
                                <select class="form-control form-control-sm" class="lineViewType" id="newViewType" onchange="selectNewType(this.value);">
                                    <option value="">--Select--</option>
                                    <option value="1">Monthly</option>
                                    <option value="2">Quarterly</option>
                                </select>
                            </div>
                            <div id="quarterNewView">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">From :</label>
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="fromNewQuarterName" id="fromNewQuarterName">
                                                        <option value="">--Quarter--</option>
                                                        <option value="1" selected="">Q1</option>
                                                        <option value="2">Q2</option>
                                                        <option value="3">Q3</option>
                                                        <option value="4">Q4</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="fromNewYear" id="fromNewYear">
                                                        <option value="">--Year--</option>
                                                        <?php foreach ($fin_year as $year) { ?>
                                                            <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">To :</label>
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="toQuarterName" id="toNewQuarterName">
                                                        <option value="">--Quarter--</option>
                                                        <option value="1">Q1</option>
                                                        <option value="2">Q2</option>
                                                        <option value="3">Q3</option>
                                                        <option value="4" selected="">Q4</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <select class="form-control form-control-sm dropdown" name="toYear" id="toNewYear">
                                                        <option value="">--Year--</option>
                                                        <?php foreach ($fin_year as $year) { ?>
                                                            <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="monthNewView">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">From :</label>
                                            <input Type="text" class="form-control form-control-sm" id="newStartDate" name="lineStartDate" placeholder="dd-mm-yyyy">
                                        </div>
                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                            <label class="wdt-100">To :</label>
                                            <input Type="text" class="form-control form-control-sm" id="newEndDate" name="lineEndDate" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                <label class="wdt-100">&nbsp;</label>
                                <button class="btn btn-sm btn-success wdt-100" id="new_searchBtn" type="button" onclick="totalNewFilter();">Search</button>
                            </div>
                            <input type="hidden" id="newName" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12 col-md-12 col-lg-12 bgf4f5fa">
                            <div id="charts1">
                                <div id="newChartContent" class="chart_modal"></div>
                            </div>
                            <br>
                            <div class="loadChartBtn">
                                <span style="display: inline-block; width: 35px;">
                                    <a href="javascript:void(0)" id="new_pre_chart" title="Next">
                                        <i class="fas fa-chevron-circle-left"></i>
                                    </a></span>
                                <span style="display: inline-block; width: 35px;">
                                    <a href="javascript:void(0)" id="new_nxt_chart" title="Previous">
                                        <i class="fas fa-chevron-circle-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="current_fy" value="<?= isset($current_fy) && $current_fy != '' ? $current_fy : date('Y'); ?>">
<input type="hidden" id="current_partner" value="<?= $this->session->userdata['partner_id']; ?>">
<input type="hidden" id="filter_sector" value="<?= $default_sector; ?>">
<input type="hidden" id="filter_sector_name" value="<?= $default_sector_name; ?>">
<input type="hidden" id="filter_year" value="<?= $current_fy; ?>">
<input type="hidden" id="filter_quarter" value="">

<input type="hidden" id="productSuccess" value="0">
<input type="hidden" id="financeSuccess" value="0">
<input type="hidden" id="teamSuccess" value="0">
<input type="hidden" id="impactSuccess" value="0">
<input type="hidden" id="mentorSuccess" value="0">
<input type="hidden" id="diagnosticSuccess" value="0">
<input type="hidden" id="seedSuccess" value="0">

<?php $this->load->view('vitals_footer.php', array('copyrights' => '0', 'page_load' => 'portfolio', 'chart' => 'yes')); ?>

<script type="text/javascript">

    $(document).on('click', '#inc_tabMenu', function () {
        $('#inc_tabMenu').addClass('active');
        $('#sec_tabMenu').removeClass('active');
        $('#incubatee_rollup').show();
        $('#sector_dashboard').hide();
    });
    $(document).on('click', '#sec_tabMenu', function () {
        $('#sec_tabMenu').addClass('active');
        $('#inc_tabMenu').removeClass('active');
        $('#sector_dashboard').show();
        $('#incubatee_rollup').hide();
    });
    function commentSubmit(form_id, form_name) {
        $('#' + form_id).validate({
            rules: {
                txt_description: "required"
            },
            messages: {
                txt_description: "Please enter description"
            }
        });
        if ($('#' + form_id).valid()) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'index.php/portfolio/addChartConversation'; ?>",
                data: $('#' + form_id).serialize(),
                success: function (output) {
                    $("#" + form_id)[0].reset();
                    $('#' + form_name + '_commentMsg').html('Comment posted successfully');
                    $('#' + form_name + '_conversation_data').html(output);
                    setTimeout(function () {
                        $('#' + form_name + '_commentMsg').html('');
                    }, 3000);
                }
            });
        }
    }

    $(document).on('keypress', '.enterSubmit', function (e) {
        var current_id = $(this).attr('id');
        var split_id = current_id.split("_");
        if (current_id == 'graduates_exits_text_description') {
            var form_name = split_id[0] + '_' + split_id[1];
        } else {
            var form_name = split_id[0];
        }
        var key = e.which;
        var form_id = form_name + '_chartSubmit';
        if (key == 13) {
            commentSubmit(form_id, form_name);
            return false;
        }
    });

    $(document).on('focusout', '.enterSubmit', function (e) {
        $('.btnColor').css('background-color', '#6c757d');
    });

    $(document).on('focus', '.enterSubmit', function (e) {
        var current_id = $(this).attr('id');
        var split_id = current_id.split("_");
        if (current_id == 'graduates_exits_text_description') {
            var form_name = split_id[0] + '_' + split_id[1];
        } else {
            var form_name = split_id[0];
        }
        var form_id = form_name + '_submitBtn';
        $('#' + form_id).css('background-color', '#27a745');
    });

    $('.scroll-company').css({'height': (($(window).height()) - 210) + 'px'});
    // $('.scroll-summary').css({'height': (($(window).height()) - 280) + 'px'});

    $(document).ready(function () {
        $('#loaderGif').css('display', 'block');
        $('#incubatee_rollup').show();
        $('#load_sectorPlan, #load_sectorAchievement').hide();
        $('#sector_dashboard').hide();
        var fin_year = $('#filter_year').val();
        var sector_plan_link = "<?= base_url() . 'index.php/portfolio/sector_plan/discovery/'; ?>";
        var sector_achieve_link = "<?= base_url() . 'index.php/portfolio/sector_actual/discovery/'; ?>";
        if (localStorage.getItem("port_sector") !== null) {
            var previous_sector = localStorage.getItem('port_sector');
            if (previous_sector != '') {
                $('#load_sectorPlan, #load_sectorAchievement').show();
                $('#load_sectorPlan').attr('href', sector_plan_link + previous_sector + '/' + fin_year);
                $('#load_sectorAchievement').attr('href', sector_achieve_link + previous_sector + '/' + fin_year);
                $("html, body").animate({scrollTop: 0}, "slow");
                loadSector_qualitative();
            } else {
                $('#load_sectorPlan, #load_sectorAchievement').hide();
                loadSector_conversation();
            }
            load_sector(previous_sector);
            $('#txtSector').val(previous_sector);
        } else {
            var sector = $('#filter_sector').val();
            if (sector != '') {
                $('#load_sectorPlan, #load_sectorAchievement').show();
                $('#load_sectorPlan').attr('href', sector_plan_link + sector + '/' + fin_year);
                $('#load_sectorAchievement').attr('href', sector_achieve_link + previous_sector + '/' + fin_year);
                load_sector(sector);
                localStorage.setItem('port_sector', sector);
                $("html, body").animate({scrollTop: 0}, "slow");
                loadSector_qualitative();
            } else {
                $('#load_sectorPlan, #load_sectorAchievement').hide();
                loadSector_conversation();
                localStorage.setItem('port_sector', '');
            }
        }
        loadGraphValues();
        loadSectorGraphValues();
        load_incubatees();
        $("#discoveryTab").css("pointer-events", "");
    });
    function loadGraphValues() {
        product_sales();
        finance_fundraise();
        impact();
        team_board_meeting();
        mentor_partnerships();
        diagnostic_panels();
        seed_funding();
        $('#productSuccess, #financeSuccess, #teamSuccess, #impactSuccess, #mentorSuccess, #diagnosticSuccess, #seedSuccess').val('0');
        product_sales_conversation();
    }

    function loadSectorGraphValues() {
        sectorGraph('discovery');
        sectorGraph('diligence');
        sectorGraph('selection');
        sectorGraph('graduates_exits');
        sectorGraph('sectorfundraise');
        sectorGraph('financialstability');
    }

    function loadSector_qualitative() {
        $('.sector_chatView').hide();
        $('.sector_qualView').show();
        sector_qualitative('discovery', 'loadDiscoveryQualitative');
        sector_qualitative('diligence', 'loadDiligenceQualitative');
        sector_qualitative('selection', 'loadSelectionQualitative');
        sector_qualitative('graduates_exits', 'loadGraduatesexitsQualitative');
        sector_qualitative('sectorfundraise', 'loadSectorfundraiseQualitative');
        sector_qualitative('financialstability', 'loadFinancialStabilityQualitative');
    }

    function loadSector_conversation() {
        $('.sector_qualView').hide();
        $('.sector_chatView').show();
        sector_conversation('discovery');
        sector_conversation('diligence');
        sector_conversation('selection');
        sector_conversation('graduates_exits');
        sector_conversation('sectorfundraise');
        sector_conversation('financialstability');
    }

    function load_incubatees() {
        var sector = $('#filter_sector').val();
        var base_url = "<?php echo base_url(); ?>";
        var year = $('#filter_year').val();
        $.ajax({
            type: "POST",
            async: true,
            url: base_url + "index.php/portfolio/portfolio_incubatees",
            data: {sector: sector, year: year},
            dataType: 'html',
            success: function (msg) {
                var split_arr = JSON.parse(msg);
                var application_arr = split_arr['incubatee_list'];
                var inc_count = application_arr.length;
                $('#incubatee_count').html(inc_count);
                $(".scroll-company").html('');
                $.each(application_arr, function (key, val) {
                    var exit_class = '';
                    var text = '';
                    if (val.company_status == '2') {
                        exit_class = 'addedExit';
                        text = val.name_of_enterprise + ' (Graduated)';
                    } else if (val.company_status == '3') {
                        exit_class = 'addedExit';
                        text = val.name_of_enterprise + ' (Exited)';
                    } else {
                        text = val.name_of_enterprise;
                    }
					var exit_class = '';
					if(year ==val.exit_year){
						 exit_class = 'addedExit';
					}
					
                    var count = 30;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                    var inc_list = '<li><a id="incubatees_comp_links" href="' + base_url + 'index.php/portfolio/company_summary/' + val.id + '/' + year + '" class="' + exit_class + '" title="' + text + '">' + result + ''+ '</a></li>';
                    $(".portfolio-Incubatees ul").append(inc_list);
                });
            }
        });
    }
	
	$(document).on('click','#incubatees_comp_links',function(e){
		e.preventDefault;
		var anchor_tag_href = $(this).attr('href');
		var set_previous_link = anchor_tag_href;
		localStorage.setItem('back_link',set_previous_link);
		if(anchor_tag_href!=''){
			return true;
		}
	});


    function load_sector(id) { 
        $('#filter_sector').val(id);
        $('#product_sector, #finance_sector, #team_sector, #impact_sector, #mentor_sector, #diagnostic_sector, #seed_sector').val(id);
        $('#discovery_sector, #diligence_sector, #selection_sector, #graduates_exits_sector, #sectorfundraise_sector, #financialstability').val(id);
        var fin_year = $('#filter_year').val();
        localStorage.setItem('port_sector', id);
        var export_link = "<?= base_url() . 'index.php/portfolio/sectorwise_incubatee_export/'; ?>";
        if (id != '') {
            var sector_plan_link = "<?= base_url() . 'index.php/portfolio/sector_plan/discovery/'; ?>";
            var sector_achieve_link = "<?= base_url() . 'index.php/portfolio/sector_actual/discovery/'; ?>";
            $('#load_sectorPlan, #load_sectorAchievement').show();
            $('#load_sectorPlan').attr('href', sector_plan_link + id + '/' + fin_year);
            $('#load_sectorAchievement').attr('href', sector_achieve_link + id + '/' + fin_year);
            $('#portfolio_export').attr('href', export_link + id + '/' + fin_year);
            $("html, body").animate({scrollTop: 0}, "slow");
            loadSector_qualitative();
        } else {
            $('#portfolio_export').attr('href', export_link + 'all/' + fin_year);
            $('#load_sectorPlan, #load_sectorAchievement').hide();
            loadSector_conversation();
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/summary_sectorName",
            data: {sec_id: id},
            dataType: "text",
            success: function (msg) {
                if (msg == '')
                    $('#filter_sector_name').val('');
                else
                    $('#filter_sector_name').val(msg);
            }
        });
        loadGraphValues();
        loadSectorGraphValues();
        load_incubatees();
    }

    function load_year(id) {
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/portfolio_summary_old/' + id;
    }

    function load_quarter(id) {
        $('#productSuccess, #financeSuccess, #teamSuccess, #impactSuccess, #mentorSuccess, #diagnosticSuccess, #seedSuccess').val('0');
        $('#discovery_quarter,#diligence_quarter,#selection_quarter,#graduates_exits_quarter,#sectorfundraise_quarter,#financialstability_quarter').val(id);

        $('#filter_quarter').val(id);
        $('.chat_quarter').val(id);
        product_sales_conversation();

        var sector_id = $('#filter_sector').val();
        if (sector_id != '') {
            loadSector_qualitative();
        } else {
            loadSector_conversation();
        }
    }

    $(document).on('click', '#graphLabel', function () {
        if ($(this).is(":checked")) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/updateGraphLabel",
                data: {enable: 1},
                dataType: 'html',
                success: function (msg) {
                    location.reload();
                }
            });
        } else if ($(this).is(":not(:checked)")) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/updateGraphLabel",
                data: {enable: 0},
                dataType: 'html',
                success: function (msg) {
                    location.reload();
                }
            });
        }
    });
    function product_sales() {
        var name = $('#productTab').val();
        var sector_id = $('#filter_sector').val();
        var f_year = $('#product_fyear').val();
        var view_type = $('#product_chartView').val();
        var graph_title = $("#productTab option:selected").text();
        $('#product_chatFyear').val(f_year);
        if (name == 1) {
            $("#product_sales_value").html("Dashboard not available for the category 'Product'.");
            $('#product_sales_value').css('cursor', 'default');
            $('#product_module_id').val('1');
            $('#product_sales_value').addClass('product_sales_value');
        } else {
            $('#product_module_id').val('2');
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/allCompanySales",
                data: {id: 1, sector: sector_id, f_year: f_year, type: view_type, graph_title: graph_title},
                dataType: 'html',
                success: function (sales_msg) {
                    $("#product_sales_value").html(sales_msg);
                    $('#product_sales_value').css('cursor', 'pointer');
                    load_incubatees();
                }
            });
        }
    }

    function finance_fundraise() {
        var name = $('#fundraiseTab').val();
        var sector_id = $('#filter_sector').val();
        var f_year = $('#fundraise_fyear').val();
        var view_type = $('#fundraise_chartView').val();
        var graph_name = 'allRevenue';
        $('#finance_chatFyear').val(f_year);
        if (name == 1) {
            graph_name = 'allRevenue';
            $('#finance_module_id').val('3');
        } else if (name == 2) {
            graph_name = 'allProfit';
            $('#finance_module_id').val('4');
        } else if (name == 3) {
            graph_name = 'allCapital';
            $('#finance_module_id').val('5');
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/" + graph_name,
            data: {id: 1, sector: sector_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (finance_msg) {
                $("#finance_value").html(finance_msg);
            }
        });
    }
	
	function submit_summary() {
		let table_year = $("#table_year").val();
		$("#submit_summary_table").prop('disabled', true);
		window.location = "<?php echo base_url(); ?>index.php/portfolio/check_table/"+table_year;
	}
	
    function team_board_meeting() {
        var name = $('#teamTab').val();
        var inv_id = $('#company_id').val();
        var sector_id = $('#filter_sector').val();
        var f_year = $('#team_fyear').val();
        var view_type = $('#team_chartView').val();
        var graph_name = 'allRecruitment';
        $('#team_chatFyear').val(f_year);
        if (name == 1) {
            graph_name = 'allRecruitment';
            $('#team_module_id').val('6');
        } else if (name == 2) {
            graph_name = 'allAttrition';
            $('#team_module_id').val('7');
        } else if (name == 3) {
            graph_name = 'allBoardMeeting';
            $('#team_module_id').val('8');
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/" + graph_name,
            data: {id: 1, inv_id: inv_id, sector: sector_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (team_msg) {
                $("#team_value").html(team_msg);
            }
        });
    }

    function impact() {
        var name = $('#impactTab').val();
        var f_year = $('#impact_fyear').val();
        var sector_id = $('#filter_sector').val();
        var view_type = $('#impact_chartView').val();
        var graph_name = 'allEndbeneficiaries';
        $('#impact_chatFyear').val(f_year);
        if (name == 1) {
            graph_name = 'allEndbeneficiaries';
            $('#impact_module_id').val('9');
        } else if (name == 2) {
            graph_name = 'allDirectjobs';
            $('#impact_module_id').val('10');
        } else if (name == 3) {
            graph_name = 'allIndirectjobs';
            $('#impact_module_id').val('11');
        }

        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + graph_name,
            data: {id: 1, sector: sector_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (msg) {
                $("#all_impact").html(msg);
            }
        });
    }

    function mentor_partnerships() {
        var name = $('#mentorTab').val();
        var sector_id = $('#filter_sector').val();
        var f_year = $('#mentor_fyear').val();
        var view_type = $('#mentor_chartView').val();
        var graph_name = 'allMentorHour';
        $('#mentor_chatFyear').val(f_year);
        if (name == 1) {
            graph_name = 'allMentorHour';
            $('#mentor_module_id').val('12');
        } else if (name == 2) {
            graph_name = 'allMentorNumber';
            $('#mentor_module_id').val('13');
        } else if (name == 3) {
            graph_name = 'allTechnicalAssistance';
            $('#mentor_module_id').val('14');
        } else if (name == 4) {
            graph_name = 'allPartnerships';
            $('#mentor_module_id').val('15');
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/" + graph_name,
            data: {id: 1, sector: sector_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (mentor_msg) {
                $("#mentor_value").html(mentor_msg);
            }
        });
    }

    function diagnostic_panels() {
        var sector_id = $('#filter_sector').val();
        var f_year = $('#diagnostic_fyear').val();
        var view_type = $('#diagnostic_chartView').val();
        $('#diagnostic_chatFyear').val(f_year);
        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/allDiagnosticPanels",
            data: {id: 1, sector: sector_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (diagnostic_msg) {
                $("#diagnostic_value").html(diagnostic_msg);
            }
        });
    }

    function seed_funding() {
        var sector_id = $('#filter_sector').val();
        var f_year = $('#seed_fyear').val();
        var view_type = $('#seed_chartView').val();
        $('#seed_chatFyear').val(f_year);
        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/allSeedFunding",
            data: {id: 1, sector: sector_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (seed_msg) {
                $("#seed_value").html(seed_msg);
                $('#loaderGif').css('display', 'none');
            }
        });
    }
	
    function product_sales_conversation() {
        var fin_year = $('#product_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var tab_name = $('#productTab').val();
        var load_next = $('#productSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '1';
        if (tab_name == 1)
            module_id = '1';
        else
            module_id = '2';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (product_chat) {
                $("#product_conversation_data").html(product_chat);
                if (load_next == 0) {
                    finance_fundraise_conversation();
                }
            }
        });
        $('#productSuccess').val('1');
    }

    function finance_fundraise_conversation() {
        var fin_year = $('#fundraise_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var tab_name = $('#fundraiseTab').val();
        var load_next = $('#financeSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '3';
        if (tab_name == 1)
            module_id = '3';
        else if (tab_name == 2)
            module_id = '4';
        else
            module_id = '5';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (finance_chat) {
                $("#finance_conversation_data").html(finance_chat);
                if (load_next == 0) {
                    team_board_conversation();
                }
            }
        });
        $('#financeSuccess').val('1');
    }

    function team_board_conversation() {
        var fin_year = $('#team_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var tab_name = $('#teamTab').val();
        var load_next = $('#teamSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '6';
        if (tab_name == 1)
            module_id = '6';
        else if (tab_name == 2)
            module_id = '7';
        else
            module_id = '8';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (team_chat) {
                $("#team_conversation_data").html(team_chat);
                if (load_next == 0) {
                    impact_board_conversation();
                }
            }
        });
        $('#teamSuccess').val('1');
    }

    function impact_board_conversation() {
        var fin_year = $('#impact_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var tab_name = $('#impactTab').val();
        var load_next = $('#impactSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '9';
        if (tab_name == 1)
            module_id = '9';
        else if (tab_name == 2)
            module_id = '10';
        else
            module_id = '11';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (team_chat) {
                $("#impact_conversation_data").html(team_chat);
                if (load_next == 0) {
                    mentor_partner_conversation();
                }
            }
        });
        $('#impactSuccess').val('1');
    }

    function mentor_partner_conversation() {
        var fin_year = $('#mentor_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var tab_name = $('#mentorTab').val();
        var load_next = $('#mentorSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '12';
        if (tab_name == 1)
            module_id = '12';
        else if (tab_name == 2)
            module_id = '13';
        else if (tab_name == 3)
            module_id = '14';
        else
            module_id = '15';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (mentor_chat) {
                $("#mentor_conversation_data").html(mentor_chat);
                if (load_next == 0) {
                    diagnostic_panel_conversation();
                }
            }
        });
        $('#mentorSuccess').val('1');
    }

    function diagnostic_panel_conversation() {
        var fin_year = $('#diagnostic_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var load_next = $('#diagnosticSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '16';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (diagnostic_chat) {
                $("#diagnostic_conversation_data").html(diagnostic_chat);
                if (load_next == 0) {
                    seed_fund_conversation();
                }
            }
        });
        $('#diagnosticSuccess').val('1');
    }

    function seed_fund_conversation() {
        var fin_year = $('#seed_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var load_next = $('#seedSuccess').val();
        var annual = $('#quarter_name').val();
        var module_id = '17';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (seed_chat) {
                $("#seed_conversation_data").html(seed_chat);
            }
        });
        $('#seedSuccess').val('1');
    }

    function sectorGraph(sectorMod) {
        var name = $('#' + sectorMod + 'Tab').val();
        var sector_id = $('#filter_sector').val();
        var f_year = $('#' + sectorMod + '_fyear').val();
        var view_type = $('#' + sectorMod + '_chartView').val();
        if (sectorMod == 'discovery') {
            $('#' + sectorMod + '_module_id').val('21');
        } else if (sectorMod == 'diligence') {
            if (name == 1) {
                $('#' + sectorMod + '_module_id').val('22');
            } else if (name == 2) {
                $('#' + sectorMod + '_module_id').val('23');
            } else if (name == 3) {
                $('#' + sectorMod + '_module_id').val('24');
            }
        } else if (sectorMod == 'selection') {
            if (name == 1) {
                $('#' + sectorMod + '_module_id').val('25');
            } else if (name == 2) {
                $('#' + sectorMod + '_module_id').val('26');
            }
        } else if (sectorMod == 'graduates_exits') {
            if (name == 1) {
                $('#' + sectorMod + '_module_id').val('27');
            } else if (name == 2) {
                $('#' + sectorMod + '_module_id').val('28');
            }
        } else if (sectorMod == 'sectorfundraise') {
            if (name == 1) {
                $('#' + sectorMod + '_module_id').val('29');
            } else if (name == 2) {
                $('#' + sectorMod + '_module_id').val('30');
            }
        } else if (sectorMod == 'financialstability') {
            if (name == 1) {
                $('#' + sectorMod + '_module_id').val('31');
            } else if (name == 2) {
                $('#' + sectorMod + '_module_id').val('32');
            }
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/all" + sectorMod,
            data: {id: 1, sector: sector_id, f_year: f_year, type: view_type, module: name},
            dataType: 'html',
            success: function (graph_msg) {
                $("#" + sectorMod + "_value").html(graph_msg);
                // load_incubatees();
            }
        });
    }

    function sector_conversation(sectorMod = '') {
        var fin_year = $('#' + sectorMod + '_fyear').val();
        var sector_id = $('#filter_sector').val();
        var partner_id = $('#current_partner').val();
        var name = $('#' + sectorMod + 'Tab').val();
        var annual = $('#quarter_name').val();
        var module_id = '21';
        $('#' + sectorMod + '_chatFyear').val(fin_year);
        if (sectorMod == 'discovery') {
            module_id = '21';
        } else if (sectorMod == 'diligence') {
            if (name == 1) {
                module_id = '22';
            } else if (name == 2) {
                module_id = '23';
            } else if (name == 3) {
                module_id = '24';
            }
        } else if (sectorMod == 'selection') {
            if (name == 1) {
                module_id = '25';
            } else if (name == 2) {
                module_id = '26';
            }
        } else if (sectorMod == 'graduates_exits') {
            if (name == 1) {
                module_id = '27';
            } else if (name == 2) {
                module_id = '28';
            }
        } else if (sectorMod == 'sectorfundraise') {
            if (name == 1) {
                module_id = '29';
            } else if (name == 2) {
                module_id = '30';
            }
        } else if (sectorMod == 'financialstability') {
            if (name == 1) {
                module_id = '31';
            } else if (name == 2) {
                module_id = '32';
            }
        }


        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/getConversationData",
            data: {sector_id: sector_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id, quarter: annual},
            success: function (sector_chat) {
                $("#" + sectorMod + "_conversation_data").html(sector_chat);
            }
        });
    }

    function sector_qualitative(sectorMod, loaddiv) {
        var name = $('#' + sectorMod + 'Tab').val();
        var sector_id = $('#filter_sector').val();
        var f_year = $('#' + sectorMod + '_fyear').val();
        var view_type = $('#' + sectorMod + '_chartView').val();
        var quarter = $('#' + sectorMod + '_quarter').val();
        if (sectorMod == 'discovery') {
            var module = 1;
        } else if (sectorMod == 'diligence') {
            module = 2;
        } else if (sectorMod == 'selection') {
            module = 3;
        } else if (sectorMod == 'graduates_exits') {
            if (name == 1) {
                module = 4;
            } else if (name == 2) {
                module = 5;
            }
        } else if (sectorMod == 'sectorfundraise') {
            if (name == 1) {
                module = 6;
            } else if (name == 2) {
                module = 7;
            }
        } else if (sectorMod == 'financialstability') {
            if (name == 1) {
                module = 14;
            } else if (name == 2) {
                module = 15;
            }
        }
        var table_name = 'sector_actual_qualitative_data';
        var field_name = 'description';
        $.ajax({
            async: true,
            cache: false,
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/sectorqualitativeFilters",
            data: {id: 1, sector_id: sector_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (product_data) {
                $("#" + loaddiv).html(product_data);
            }
        });
    }

    function scrollto(divid) {
        $('html, body').animate({
            scrollTop: $("#" + divid).offset().top
        }, 3000);
    }

    function open_link(anchor, divid) {
        $(anchor).hide();
        var chartdiv = $(anchor).parent().attr('class');
        $(anchor).parent().children('.chat_achievement_inner').children('#long_' + divid).show();
        $(anchor).parent().children('.chat_achievement_inner').children('#short_' + divid).hide();
        $(anchor).parent().children('.desc-fade').hide();
        $(anchor).parent().children('.open-link').hide();
        $(anchor).parent().children('.close-link').show();
        $(anchor).parent().addClass("increaseHeight");
        $(anchor).parent().removeClass("decreaseHeight");
        $(anchor).parent().animate(1000);
    }

    function close_link(anchor, divid) {
        $(anchor).show();
        var chartdiv = $(anchor).parent();
        $(anchor).parent().children('.chat_achievement_inner').children('#long_' + divid).hide();
        $(anchor).parent().children('.chat_achievement_inner').children('#short_' + divid).show();
        $(anchor).parent().addClass("decreaseHeight");
        $(anchor).parent().removeClass("increaseHeight");
        $(anchor).parent().children('.desc-fade').show();
        $(anchor).parent().children('.open-link').show();
        $(anchor).parent().children('.close-link').hide();
        $(anchor).parent().animate(1000);
    }
    // Defalut scroll removel (when using inner scroll in tabs)
    var $document = $(document),
            $body = $('body'),
            $scrolable = $('#incubatee_rollup, #sector_dashboard');
    $scrolable.on({
        'mouseenter': function () {
            // save scroll position
            //var scrollPosition = $document.scrollTop();

            // add hack class to prevent workspace scroll when scroll outside
            $body.addClass('noscroll');
            // restore scroll position
            //element.scrollTop(scrollPosition);
        },
        'mouseleave': function () {
            // save scroll position
            //var scrollPosition = element.scrollTop();

            // remove hack class to allow scroll
            $body.removeClass('noscroll');
            // restore scroll position
            //$document.scrollTop(scrollPosition);
        }
    });

</script>

<style type="text/css">
    .switch {
        position: relative;
        display: inline-block;
        width: 40px !important;
        height: 20px !important;
    }

    .switch input {
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2e8751 !important;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2e8751;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(20px);
        -ms-transform: translateX(20px);
        transform: translateX(20px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    /* Tooltip container */
    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
        /* If you want dots under the hoverable text */
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: #fff;
        color: #2e8751;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        border: 2px solid #2e8751;

        /* Position the tooltip text - see examples below! */
        position: absolute;
        z-index: 1;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

    label.error{width: 100% !important;text-align:right}
    .highcharts-title{font-size: 14px !important;}
    .ui-datepicker-calendar{display:none !important;}
    #ui-datepicker-div{width:16% !important;}
    .loadChartBtn{padding: 0 0 5px;}
    .loadChartBtn a{color: #000 !important}
    #line_pre_chart, #line_nxt_chart, #pre_chart, #nxt_chart{margin: 5px;}
</style>

</body>
</html>
