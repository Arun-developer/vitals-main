<?php
$master_data = $company_data[0];
$page_title = isset($master_data['name']) && $master_data['name'] != '' ? $master_data['name'] . ' - Summary' : 'Company Summary';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $page_title, 'container' => 'yes'));
?>

<div id="loaderGif"></div>
<div class="vil-sub_menu deal-bread fixed-header-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5 col-md-5 col-sm-5 col-12">
                <div class="display-flex">
                    <span>
                       <a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary_old'.'/'.$current_fy; ?>" class="clr_geen" title="Back to Dashboard"><i class="fas fa-angle-double-left"></i></a>
                    </span>
                    <h4><?= $master_data['name']; ?></h4>, <span style="padding-top: 4px;"><?= $sector_name; ?></span>
                </div>                
            </div>

            <div class="col-xl-7 col-md-7 col-sm-7 col-12 text-right">
                <ul class="milestone-links header-incubatee">
                    <li class="res1200">
                        <div class="form-group">
                            <ul>
                                <?php if ($this->session->userdata['role_id'] == '4') { ?>
                                    <li>
                                        <select name="txtSector" id="txtSector" class="form-control form-control-sm" onchange="load_sector(this.value)">
                                            <option value="">All Sectors</option>
                                            <?php
                                            foreach ($sectors_values as $row) {
                                                ?>
                                                <option value="<?php echo $row['id']; ?>" <?php
                                                if ($row['id'] == $default_sector) {
                                                    echo 'selected';
                                                }
                                                ?>><?php echo $row['sector']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </li>
                                <?php } ?>
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
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="<?= base_url() . 'index.php/portfolio/portfolio/company_profile/' . $innovation_id . '/' . $current_fy; ?>">Company Profile</a>
                </li>
                <li>
                    <a href="<?= base_url() . 'index.php/portfolio/product/' . $innovation_id . '/' . $current_fy; ?>">Plan</a>
                </li>
                <li>
                    <a href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_fy; ?>">Achievements</a>
                </li>
                <li>
                    <a href="<?= base_url() . 'index.php/portfolio/company_summary_export/' . $innovation_id . '/' . $current_fy; ?>" title="Export <?php echo $master_data['name']; ?> Summary"><i class="fas fa-file-export"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
<div style="position:relative">
    <div class="vi-dashboard-portfolio vi-dashboard-top170">
        <div class="container-fluid">
            <!--Finance & Fundraise-->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="title-cart-vi">
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
                                                    <select name="fundraiseTab" id="fundraiseTab" class="form-control form-control-sm" onchange="finance_fundraise();finance_fundraise_qualitative();">
                                                        <option value="1">Revenue</option>
                                                        <option value="2">Profit</option>
                                                        <option value="3">Fundraise</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <!-- <label>Financial Year</label> -->
                                                    <select class="form-control form-control-sm" name="fundraise_fyear" id="fundraise_fyear" onchange="finance_fundraise();finance_fundraise_qualitative();">
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
                                                                <select class="form-control form-control-sm dropdown" name="fundraise_quarter" id="fundraise_quarter" onchange="finance_fundraise_qualitative();">
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
                                        <div id="loadFinanceQualitative"></div>
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
                                                    <select name="productTab" id="productTab" class="form-control form-control-sm" onchange="product_sales();product_sales_qualitative('1');">
                                                        <option value="product">Product</option>
                                                        <option value="">Sales - INR</option>
                                                        <?php
                                                        $j = 1;
                                                        foreach ($approved_sales as $sku) {
                                                            ?>
                                                            <option value="<?= $sku['id']; ?>"><?php echo 'SKU ' . $j . ' - ' . ucwords($sku['product_name']); ?></option>
                                                            <?php
                                                            $j++;
                                                        }
                                                        ?>
                                                    </select>
                                                </li>
                                                <li>
                                                    <!-- <label>Financial Year</label> -->
                                                    <select class="form-control form-control-sm" name="product_fyear" id="product_fyear" onchange="product_sales();product_sales_qualitative('1');get_sales_sku();">
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
                                                                <select class="form-control form-control-sm dropdown" name="product_quarter" id="product_quarter" onchange="product_sales_qualitative('1');">
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
                                        <div id="loadProductQualitative"></div>
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
                                                    <select name="teamTab" id="teamTab" class="form-control form-control-sm" onchange="team_board_meeting();team_board_meeting_qualitative();">
                                                        <option value="1">Recruitment</option>
                                                        <option value="2">Attrition</option>
                                                        <option value="3">Board Meetings</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <!-- <label>Financial Year</label> -->
                                                    <select class="form-control form-control-sm" name="team_fyear" id="team_fyear" onchange="team_board_meeting();team_board_meeting_qualitative();">
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
                                                    <select class="form-control form-control-sm" name="team_chartView" id="team_chartView" onchange="team_board_meeting();team_board_meeting_qualitative();">
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
                                                                <select class="form-control form-control-sm dropdown" name="team_quarter" id="team_quarter" onchange="team_board_meeting_qualitative();">
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
                                        <div id="loadTeamQualitative"></div>
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
                                                    <select name="impact_cate" id="impact_cate" class="form-control form-control-sm" onchange="impact()">
                                                        <option value="1">No. of End Beneficiaries</option>
                                                        <option value="2">No. of Direct Jobs Created</option>
                                                        <option value="3">No. of Indirect Jobs Created</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <!-- <label>Financial Year</label> -->
                                                    <select class="form-control form-control-sm dropdown" name="impact_fyear" id="impact_fyear" onchange="impact();">
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
                                                                <select class="form-control form-control-sm dropdown" name="impact_quarter" id="impact_quarter" onchange="impact_qualitative();">
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
                                        <div id="loadImpactQualitative"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
                                                    <select name="mentorTab" id="mentorTab" class="form-control form-control-sm" onchange="mentor_partnerships();mentor_partnerships_qualitative();">
                                                        <option value="1" selected="">Mentor Hours</option>
                                                        <option value="2">Mentor Numbers</option>
                                                        <option value="3">Technical Assistance</option>
                                                        <option value="4">Partnerships</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <!-- <label>Financial Year</label> -->
                                                    <select class="form-control form-control-sm" name="mentor_fyear" id="mentor_fyear" onchange="mentor_partnerships();mentor_partnerships_qualitative();">
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
                                                                <select class="form-control form-control-sm dropdown" name="mentor_quarter" id="mentor_quarter" onchange="mentor_partnerships_qualitative();">
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
                                        <div id="loadMentorQualitative"></div>
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
                                                    <select class="form-control form-control-sm" name="diagnostic_fyear" id="diagnostic_fyear" onchange="diagnostic_panels();diagnostic_panels_qualitative();">
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
                                                    <select class="form-control form-control-sm" name="diagnostic_chartView" id="diagnostic_chartView" onchange="diagnostic_panels();">
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
                                                                <select class="form-control form-control-sm dropdown" name="diagnostic_quarter" id="diagnostic_quarter" onchange="diagnostic_panels_qualitative();">
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
                                        <div id="loadDiagnosticQualitative"></div>
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
                                                    <select class="form-control form-control-sm" name="seed_fyear" id="seed_fyear" onchange="seed_funding();seed_funding_qualitative();">
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
                                                    <select class="form-control form-control-sm" name="seed_chartView" id="seed_chartView" onchange="seed_funding();">
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
                                                                <select class="form-control form-control-sm dropdown" name="seed_quarter" id="seed_quarter" onchange="seed_funding_qualitative();">
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
                                        <div id="loadSeedQualitative"></div>
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
                                <h4>Board Meetings/Diagnostic Panels</h4>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="vil-milestone portfolio-table">
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
                                    foreach ($upcoming_meeting as $miles) {
                                        if ($miles['type'] == 1) {
                                            $type = 'Diagnostic Panel';
                                        } else if ($miles['type'] == 2) {
                                            $type = 'Board Meeting';
                                        } else {
                                            $type = '-';
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $s; ?></td>
                                            <td><?= $miles['company_name']; ?></td>
                                            <td><?= $type; ?></td>
                                            <td><?= isset($miles['due_by']) && $miles['due_by'] != '' ? date('d-M-Y', strtotime($miles['due_by'])) : ''; ?></td>
                                            <td><?= $miles['task_name']; ?></td>
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
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col">
                    <div class="title-cart-vi">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-12">
                                <h4>Upcoming/Due Milestone</h4>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <div class="vil-milestone portfolio-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Milestone</th>
                                        <th>Task</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s = 1;
                                    foreach ($upcoming_milestone as $miles) {
                                        $task_date = (isset($miles['due_by']) && $miles['due_by'] != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($miles['due_by'])) : '';
                                        ?>
                                        <tr>
                                            <td><?= $s; ?></td>
                                            <td><?= strlen($miles['name']) > 20 ? substr($miles['name'], 0, 20) . "..." : $miles['name']; ?></td>
                                            <td><?= strlen($miles['task_name']) > 20 ? substr($miles['task_name'], 0, 20) . "..." : $miles['task_name']; ?></td>
                                            <td><?= $task_date; ?></td>
                                            <td><?= strlen($miles['description']) > 35 ? substr($miles['description'], 0, 35) . "..." : $miles['description']; ?></td>
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
    <div class="sidebar-item-new">
        <aside class="portfolio-sidebar make-me-sticky-new">
            <div class="portfolio-Incubatees">
                <label>Incubatees (<span id="incubatee_count"><?= count($company_list); ?></span>)</label>
                <ul class="scroll-company">
                    <?php
                    $curr_user_inv = array();
                    $other_user_inv = array();
                    $exited_inv = array();
                    $i = 0;
                    foreach ($company_list as $company) {
                        if ($company['company_status'] == 3) {
                            $exited_inv[$i]['id'] = $company['id'];
                            $exited_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                            $exited_inv[$i]['company_status'] = $company['company_status'];
                            $exited_inv[$i]['emp_id'] = $company['emp_id'];
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
                    $company_merge = array_merge($companies, $exited_inv);
                    foreach ($company_merge as $company) {
                        if ($company['id'] == $innovation_id) {
                            $active_class = "active";
                        } else {
                            $active_class = "";
                        }
                        $exit_class = '';
                        if ($company['company_status'] == '3') {
                            $exit_class = 'addedExit';
                        }
                        ?>
                        <li class="<?php echo $exit_class . ' ' . $active_class; ?>"><a href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $company['id'] . '/' . $current_fy; ?>"><?= strlen($company['name_of_enterprise']) > 30 ? substr($company['name_of_enterprise'], 0, 30) . "..." : $company['name_of_enterprise']; ?></a></li>
                    <?php }
                    ?>
                </ul>
            </div>
        </aside>
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

<input type="hidden" id="company_name" value="<?= $master_data['name']; ?>">
<input type="hidden" id="company_id" value="<?= $innovation_id; ?>">
<input type="hidden" id="current_fy" value="<?= isset($current_fy) && $current_fy != '' ? $current_fy : date('Y'); ?>">
<input type="hidden" id="current_partner" value="<?= $this->session->userdata['partner_id']; ?>">
<input type="hidden" id="filter_sector" value="">
<input type="hidden" id="filter_year" value="<?= $current_fy; ?>">
<input type="hidden" id="filter_quarter" value="">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'chart' => 'yes')); ?>

<script type="text/javascript">

    $(document).ready(function () {
        loadGraphValues();
        if (localStorage.getItem("port_sector") !== null) {
            var previous_sector = localStorage.getItem('port_sector');
            $('#txtSector').val(previous_sector);
        }
    });

    function loadGraphValues() {
        product_sales();
        finance_fundraise();
        impact();
        team_board_meeting();
        mentor_partnerships();
        diagnostic_panels();
        seed_funding();
    }

    $('.scroll-company').css({'height': (($(window).height()) - 250) + 'px'});
    $(document).ready(function () {
        $('#loaderGif').css('display', 'block');
        var sect_value = localStorage.getItem('port_sector');
        load_incubatees(sect_value);
    });

    function load_incubatees(sector) {
        var inv_id = $('#company_id').val();
        var base_url = "<?php echo base_url(); ?>";
        var year = $('#financial_year').val();
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
                    var count = 30;
                    var result = text.slice(0, count) + (text.length > count ? "..." : "");
                    var sel_class = '';
                    if (inv_id == val.id) {
                        sel_class = 'active';
                    }

                    var inc_list = '<li class="' + sel_class + '"><a id="incubatees_comp_link" href="' + base_url + 'index.php/portfolio/company_summary/' + val.id + '/' + year + '" class="' + exit_class + '" title="' + text + '">' + result + '</a></li>';
                    $(".portfolio-Incubatees ul").append(inc_list);
                });
            }
        });
        product_sales_qualitative();
    }

    function load_year(year) {
        var inv_id = $('#company_id').val();
		var set_previous_link = '<?= base_url(); ?>' + 'index.php/portfolio/company_summary/' + inv_id + '/' + year;
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/company_summary/' + inv_id + '/' + year;
		localStorage.setItem('back_link',set_previous_link);
    }
	$(document).on('click','#incubatees_comp_link',function(e){
		e.preventDefault;
		var anchor_tag_href = $(this).attr('href');
		var set_previous_link = anchor_tag_href;
		localStorage.setItem('back_link',set_previous_link);
		if(anchor_tag_href!=''){
			return true;
		}
	});

    function load_quarter(id) {
        $('#product_quarter, #fundraise_quarter, #team_quarter, #impact_quarter, #mentor_quarter, #diagnostic_quarter, #seed_quarter').val(id);
        product_sales_qualitative();
    }

    function product_sales() {
        var name = $('#productTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#product_fyear').val();
        var view_type = $('#product_chartView').val();
        var graph_title = $("#productTab option:selected").text();

        if (view_type == 1) {
            $('#product_quarter').val(5);
            product_sales_qualitative('1');
        }

        if (name == 'product') {
            $("#product_sales_value").html("Dashboard not available for the category 'Product'.");
            $('#product_sales_value').css('cursor', 'default');
            $('#product_sales_value').addClass('product_sales_value');
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/allCompanySales",
                data: {id: 1, inv_id: inv_id, f_year: f_year, sales_id: name, type: view_type, graph_title: graph_title},
                dataType: 'html',
                success: function (sales_msg) {
                    $("#product_sales_value").html(sales_msg);
                    $('#product_sales_value').css('cursor', 'pointer');
                }
            });
        }
    }

    function product_sales_qualitative(id = '') {
        var name = $('#productTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#product_fyear').val();
        var view_type = $('#product_chartView').val();
        var quarter = $('#product_quarter').val();

        var module = '';
        var table_name = 'plan_qualitative_data';
        var field_name = 'description';

        if (name == 'product') {
            module = 1;
            table_name = 'plan_qualitative_data';
            field_name = 'description';
        } else {
            module = 2;
            table_name = 'plan_sales';
            field_name = 'achievement_desc';
        }

        $.ajax({
            async: true,
            cache: false,
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (product_data) {
                $("#loadProductQualitative").html(product_data);
                if (id == '')
                    finance_fundraise_qualitative();
            }
        });
    }

    function get_sales_sku() {
        var inv_id = $('#company_id').val();
        var f_year = $('#product_fyear').val();
        var myarray = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/sales_sku_list",
            data: {inv_id: inv_id, f_year: f_year},
            dataType: 'json',
            success: function (sku_data) {
                $('#productTab').find('option').not(':nth-child(1),:nth-child(2)').remove().end();
                $.each(sku_data, function (i, value) {
                    var j = i + 1;
                    myarray.push(value.id);
                    $('#productTab').append($('<option>').text('SKU ' + j + ' - ' + value.product_name).attr('value', value.id));
                });
            }
        });
    }

    function finance_fundraise() {
        var name = $('#fundraiseTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#fundraise_fyear').val();
        var view_type = $('#fundraise_chartView').val();
        var graph_name = 'allRevenue';

        if (view_type == 1) {
            $('#fundraise_quarter').val(5);
            finance_fundraise_qualitative();
        }

        if (name == 1) {
            graph_name = 'allRevenue';
        } else if (name == 2) {
            graph_name = 'allProfit';
        } else if (name == 3) {
            graph_name = 'allCapital';
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/" + graph_name,
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (finance_msg) {
                $("#finance_value").html(finance_msg);
            }
        });
    }

    function finance_fundraise_qualitative() {
        var name = $('#fundraiseTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#fundraise_fyear').val();
        var view_type = $('#fundraise_chartView').val();
        var quarter = $('#fundraise_quarter').val();
        var module = 5;
        var table_name = 'plan_finance';
        var field_name = 'revenue_achievement';

        if (name == 1) {
            module = 5;
            table_name = 'plan_finance';
            field_name = 'revenue_achievement';
        } else if (name == 2) {
            module = 6;
            table_name = 'plan_finance';
            field_name = 'profit_achievement';
        } else if (name == 3) {
            module = 8;
            table_name = 'plan_qualitative_data';
            field_name = 'description';
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (finance_data) {
                $("#loadFinanceQualitative").html(finance_data);
                impact_qualitative();
            }
        });
    }

    function impact() {
        var name = $('#impact_cate').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#impact_fyear').val();
        var view_type = $('#impact_chartView').val();
        var quarter = $('#impact_quarter').val();
        var graph_name = 'allEndbeneficiaries';

        if (view_type == 1) {
            $('#impact_quarter').val(5);
            impact_qualitative();
        }

        if (name == 1) {
            graph_name = 'allEndbeneficiaries';
        } else if (name == 2) {
            graph_name = 'allDirectjobs';
        } else if (name == 3) {
            graph_name = 'allIndirectjobs';
        }

        $.ajax({
            type: "POST",
            async: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + graph_name,
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, quarter: quarter},
            dataType: 'html',
            success: function (msg) {
                $("#all_impact").html(msg);
            }
        });
    }

    function impact_qualitative() {
        var name = $('#impact_cate').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#impact_fyear').val();
        var view_type = $('#impact_chartView').val();
        var quarter = $('#impact_quarter').val();
        var module = 14;

        var table_name = 'plan_impact';
        var field_name = 'achievement_desc';

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (impact_data) {
                $("#loadImpactQualitative").html(impact_data);
                team_board_meeting_qualitative();
            }
        });
    }

    function team_board_meeting() {
        var name = $('#teamTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#team_fyear').val();
        var view_type = $('#team_chartView').val();
        var graph_name = 'allRecruitment';

        if (view_type == 1) {
            $('#team_quarter').val(5);
            team_board_meeting_qualitative();
        }

        if (name == 1) {
            graph_name = 'allRecruitment';
        } else if (name == 2) {
            graph_name = 'allAttrition';
        } else if (name == 3) {
            graph_name = 'allBoardMeeting';
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/" + graph_name,
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (team_msg) {
                $("#team_value").html(team_msg);
            }
        });
    }

    function team_board_meeting_qualitative() {
        var name = $('#teamTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#team_fyear').val();
        var view_type = $('#team_chartView').val();
        var quarter = $('#team_quarter').val();
        var module = 15;
        var table_name = 'plan_qualitative_data';
        var field_name = 'description';

        if (name == 1 || name == 2) {
            module = 15;
            table_name = 'plan_qualitative_data';
            field_name = 'description';
        } else if (name == 3) {
            module = 13;
            table_name = 'plan_board_meetings';
            field_name = 'achievement_desc';
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (finance_data) {
                $("#loadTeamQualitative").html(finance_data);
                mentor_partnerships_qualitative();
            }
        });
    }

    function mentor_partnerships() {
        var name = $('#mentorTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#mentor_fyear').val();
        var view_type = $('#mentor_chartView').val();
        var graph_name = 'allMentorHour';

        if (view_type == 1) {
            $('#mentor_quarter').val(5);
            mentor_partnerships_qualitative();
        }

        if (name == 1) {
            graph_name = 'allMentorHour';
        } else if (name == 2) {
            graph_name = 'allMentorNumber';
        } else if (name == 3) {
            graph_name = 'allTechnicalAssistance';
        } else if (name == 4) {
            graph_name = 'allPartnerships';
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/" + graph_name,
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (mentor_msg) {
                $("#mentor_value").html(mentor_msg);
            }
        });
    }

    function mentor_partnerships_qualitative() {
        var name = $('#mentorTab').val();
        var inv_id = $('#company_id').val();
        var f_year = $('#mentor_fyear').val();
        var view_type = $('#mentor_chartView').val();
        var quarter = $('#mentor_quarter').val();
        var module = 9;
        var table_name = 'plan_qualitative_data';
        var field_name = 'description';

        if (name == 1 || name == 2) {
            module = 9;
        } else if (name == 3) {
            module = 10;
        } else if (name == 4) {
            module = 11;
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (mentor_data) {
                $("#loadMentorQualitative").html(mentor_data);
                diagnostic_panels_qualitative();
            }
        });
    }

    function diagnostic_panels() {
        var inv_id = $('#company_id').val();
        var f_year = $('#diagnostic_fyear').val();
        var view_type = $('#diagnostic_chartView').val();

        if (view_type == 1) {
            $('#diagnostic_quarter').val(5);
            diagnostic_panels_qualitative();
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/allDiagnosticPanels",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (diagnostic_msg) {
                $("#diagnostic_value").html(diagnostic_msg);
            }
        });
    }

    function diagnostic_panels_qualitative() {
        var inv_id = $('#company_id').val();
        var f_year = $('#diagnostic_fyear').val();
        var view_type = $('#diagnostic_chartView').val();
        var quarter = $('#diagnostic_quarter').val();
        var module = 12;
        var table_name = 'plan_dp';
        var field_name = 'achievement_desc';

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (diagnostic_data) {
                $("#loadDiagnosticQualitative").html(diagnostic_data);
                seed_funding_qualitative();
            }
        });
    }

    function seed_funding() {
        var inv_id = $('#company_id').val();
        var f_year = $('#seed_fyear').val();
        var view_type = $('#seed_chartView').val();

        if (view_type == 1) {
            $('#seed_quarter').val(5);
            seed_funding_qualitative();
        }

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/allSeedFunding",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type},
            dataType: 'html',
            success: function (seed_msg) {
                $("#seed_value").html(seed_msg);
            }
        });
    }

    function seed_funding_qualitative() {
        var inv_id = $('#company_id').val();
        var f_year = $('#seed_fyear').val();
        var view_type = $('#seed_chartView').val();
        var quarter = $('#seed_quarter').val();
        var module = 7;
        var table_name = 'plan_qualitative_data';
        var field_name = 'description';

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            url: "<?php echo base_url(); ?>index.php/portfolio/incubatee_graphs/qualitativeFilters",
            data: {id: 1, inv_id: inv_id, f_year: f_year, type: view_type, module_id: module, quarter: quarter, actual_table: table_name, actual_field: field_name},
            dataType: 'html',
            success: function (seed_data) {
                $("#loadSeedQualitative").html(seed_data);
                $('#loaderGif').css('display', 'none');
            }
        });
    }

    /*Expand script */
    $(function () {
        var wrapHeight = $(".vill_chatcard .desc-wrap").height();
        var descHeight = $(".vill_chatcard").height();

        if (descHeight <= wrapHeight) {
            $(".vill_chatcard .desc-fade").hide();
            $(".vill_chatcard .open-link").hide();
        }

        var wrapQHeight = $(".vill_chatcardQuater .desc-wrap").height();
        var descQHeight = $(".vill_chatcardQuater").height();

        if (descQHeight <= wrapQHeight) {
            $(".vill_chatcardQuater .desc-fade").hide();
            $(".vill_chatcardQuater .open-link").hide();
        }
    });

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

    function load_sector(id) {
        localStorage.setItem('port_sector', id);
        var fin_year = $('#financial_year').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/custom_company_summary",
            data: {sec_id: id, f_year: fin_year},
            dataType: 'html',
            success: function (msg) {
                var split_arr = JSON.parse(msg);
                var company_id = split_arr['company'];
                var year_id = split_arr['fyear'];
                window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/company_summary/' + company_id + '/' + year_id;
            }
        });
    }

</script>

<style type="text/css">
    label.error{width: 100% !important;text-align:right}
    .highcharts-title{font-size: 14px !important;}
    .ui-datepicker-calendar{display:none !important;}
    #ui-datepicker-div{width:16% !important;}
    .loadChartBtn{padding: 0 0 5px;}
    .loadChartBtn a{color: #000 !important}
    #line_pre_chart, #line_nxt_chart, #pre_chart, #nxt_chart{margin: 5px;}
    .col-lg-5.brd-rgtChart.pad0 .vil_chatsec {
        margin-left: 0px;
        padding-left: 0px;
    }
</style>

</body>
</html>
