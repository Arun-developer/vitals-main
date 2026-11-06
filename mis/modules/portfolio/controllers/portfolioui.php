<?php

class Portfolioui extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('Mportfolio');
        $this->load->model('scouting/Mincharge');
        $this->load->model('scouting/Minnovation');
        $this->load->model('login/Muser');
        $this->load->model('master/Mmaster');
        $this->load->model('master/Mmaster_settings');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->library('upload');

        if ($this->session->userdata['emp_number'] == '') {
            redirect('login/icon_menu');
        }

        $allowed_partner = array("1", "2", "9");
        if (!in_array($this->session->userdata['partner_id'], $allowed_partner)) {
            redirect('login/icon_menu');
        }
    }

    public function month() {
        $start_month = current_FYstartMonth($this->session->userdata('partner_id'));
        $end_month = current_FYendMonth($this->session->userdata('partner_id'));
        $start_year = current_FYstartYear($this->session->userdata('partner_id'));
        $end_year = current_FYendYear($this->session->userdata('partner_id'));

        $date_sMonth = date_parse($start_month);
        $date_eMonth = date_parse($end_month);

        $date1 = $start_year . "-" . $date_sMonth['month'] . "-01";
        $date2 = $end_year . "-" . $date_eMonth['month'] . "-30";

        $time1 = strtotime($date1);
        $time2 = strtotime($date2);
        $my = date('mY', $time2);

        $months = array(date('M', $time1));
        $f = '';

        while ($time1 < $time2) {
            $time1 = strtotime((date('Y-m-d', $time1) . ' +1 month'));
            if (date('M', $time1) != $f) {
                $f = date('M', $time1);
                if (date('mY', $time1) != $my && ($time1 < $time2))
                    $months[] = date('M', $time1);
            }
        }

        $months[] = date('M', $time2);
        return $months;
    }

    public function actual_month() {
        return array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
    }

    public function quarter1() {
        $fy_months = $this->month();
        $quart_1 = php72_array_slice($fy_months, 0, 3);
        $q1_arr = array();
        foreach ($quart_1 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q1_arr[$set_key] = $value;
        }
        $q1_arr['13'] = 'qone';
        return $q1_arr;
    }

    public function quarter2() {
        $fy_months = $this->month();
        $quart_2 = php72_array_slice($fy_months, 3, 3);
        $q2_arr = array();
        foreach ($quart_2 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q2_arr[$set_key] = $value;
        }
        $q2_arr['14'] = 'qtwo';
        return $q2_arr;
    }

    public function quarter3() {
        $fy_months = $this->month();
        $quart_3 = php72_array_slice($fy_months, 6, 3);
        $q3_arr = array();
        foreach ($quart_3 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q3_arr[$set_key] = $value;
        }
        $q3_arr['15'] = 'qthree';
        return $q3_arr;
    }

    public function quarter4() {
        $fy_months = $this->month();
        $quart_4 = php72_array_slice($fy_months, 9, 3);
        $q4_arr = array();
        foreach ($quart_4 as $key => $value) {
            $set_key = date('n', strtotime("$value 1 2020"));
            $q4_arr[$set_key] = $value;
        }
        $q4_arr['16'] = 'qfour';
        return $q4_arr;
    }

    public function allQuarter() {
        $fy_months = $this->month();
        $quart_1 = php72_array_slice($fy_months, 0, 3);
        $quart_2 = php72_array_slice($fy_months, 3, 3);
        $quart_3 = php72_array_slice($fy_months, 6, 3);
        $quart_4 = php72_array_slice($fy_months, 9, 3);
        $q1_arr = $q2_arr = $q3_arr = $q4_arr = array();
        foreach ($quart_1 as $q1) {
            $q1_arr['Q1'] = $q1;
        }
        foreach ($quart_2 as $q2) {
            $q2_arr['Q2'] = $q2;
        }
        foreach ($quart_3 as $q3) {
            $q3_arr['Q3'] = $q3;
        }
        foreach ($quart_4 as $q4) {
            $q4_arr['Q4'] = $q4;
        }
        return php72_array_merge($q1_arr, $q2_arr, $q3_arr, $q4_arr);
    }

    public function findQuarter($month) {
        $get_fy_month = $this->month();
        if ($month >= $get_fy_month[0] AND $month <= $get_fy_month[2]) {
            $q_name = "q1";
        } elseif ($month >= $get_fy_month[3] AND $month <= $get_fy_month[5]) {
            $q_name = "q2";
        } elseif ($month >= $get_fy_month[6] AND $month <= $get_fy_month[8]) {
            $q_name = "q3";
        } elseif ($month >= $get_fy_month[9] AND $month <= $get_fy_month[11]) {
            $q_name = "q4";
        }
        return $q_name;
    }

    public function get_months($date1, $date2) {
        $time1 = strtotime($date1);
        $time2 = strtotime($date2);
        $my = date('mY', $time2);
        $months = array(date('M-Y', $time1));

        while ($time1 < $time2) {
            $time1 = strtotime(date('Y-m-d', $time1) . ' +1 month');
            if (date('mY', $time1) != $my && ($time1 < $time2))
                $months[] = date('M-Y', $time1);
        }
        $end_date = date('M-Y', $time2);
        if (!in_array($end_date, $months)) {
            $months[] = date('M-Y', $time2);
        }
        return $months;
    }

    public function change_company_sector() {
        $partner_id = $this->session->userdata('partner_id');
        $sector_id = $this->input->post('sector_id');
        $fin_year = $this->input->post('fin_year');

        $q4 = $this->quarter4();
        $q4_key = php72_array_keys($q4);

        $curMonth = date("m", time());
        $curQuarter = ceil($curMonth / 3);
        $master_field = 'tot_annual';
        if ($curQuarter == '1') {
            $master_field = 'tot_q4';
        } else if ($curQuarter == '2') {
            $master_field = 'tot_q1';
        } else if ($curQuarter == '3') {
            $master_field = 'tot_q2';
        } else if ($curQuarter == '4') {
            $master_field = 'tot_q3';
        }

        $data['applicationDetails'] = $this->Mportfolio->companyApplicationCount($sector_id, $fin_year);
        $data['pard_allcount'] = $this->Mportfolio->pard_allCount($sector_id, $fin_year);
        $data['IIC_allCount'] = $this->Mportfolio->IIC_allCount($sector_id, $fin_year);
        $data['EIC_allcount'] = $this->Mportfolio->EIC_allcount($sector_id, $fin_year);
        $data['masterDetails'] = $this->Mportfolio->companyCountIncubatee($sector_id, $master_field, $fin_year);

        $condition = "BN.sector IN ($sector_id)";
        if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $condition = '';
        }
        $data['total_inc'] = $this->Mportfolio->getTotalCompany($condition, $fin_year);
        $data['new_inc'] = $this->Mportfolio->getNewCompany($condition, $fin_year);
        $exit_companies = $this->Mportfolio->getExitCompany($condition, $fin_year);
        $ext_count = 0;

        foreach ($exit_companies as $company) {
            $comp_yr = $company['exit_year'];
            $comp_mnt = date('n', strtotime($company['exit_month']));
            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);
            if (in_array($comp_mnt, $q4_key)) {
                if (php72_cmp($company['exit_month']) == 01 || php72_cmp($company['exit_month']) == 02 || php72_cmp($company['exit_month']) == 03) {
                    $comp_yr = $company['exit_year'] - 1;
                }
            }
            if (php72_cmp($company['company_status']) == 3 || php72_cmp($company['company_status']) == 2) {
                if ($comp_yr == '0000' || ($fin_year <= $comp_yr)) {
                    $ext_count += 1;
                }
            }
        }
        $data['exit_inc'] = $ext_count;
        echo json_encode($data);
    }

    public function configurationlist($id = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 1;
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
        $emp_id = $option1['associate_employee'] = $this->session->userdata['emp_number'];

        $option['employee_id'] = $this->session->userdata['emp_number'];
        $option['partner_id'] = $this->session->userdata('partner_id');
        $get_lead = $this->Mportfolio->getDetails('assign_sector_lead', $option);

        $sector = array();
        foreach ($get_lead as $lead) {
            array_push($sector, $lead['sector_id']);
        }
        $status = 3;
        $status1 = 1;
        $data['config_listing'] = $config_list = $this->Mportfolio->getListingDetails('assign_associate', $option1, $status1);
        $config_inv = $this->Mportfolio->getOnboardInv();
//        $plan_inv1 = $this->Mportfolio->getConApprovalData();
        foreach ($config_inv as $lists) {
            $listing[] = $lists['innovation'];
        }
        $sector_id = $string = rtrim(implode(',', $sector), ',');
        $innov_id = rtrim(php72_implode(',', $listing), ',');

        $data['listing'] = $this->Mportfolio->getJoinDetails('', '', $sector_id, $search_value, $innov_id, $status);

        $this->load->vars($data);
        $this->load->view('portfolio/configurationlist');
    }

    public function plan_impact($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr - 1); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $last_month = date('n') - 1;
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('port_impact', $least_month, $f_year);

        foreach ($get_monthCount as $val) {
            if (php72_in_array($val['month'], $derivemonth)) {
                if ($last_month != $val['month']) {
                    $key = php72_array_search($val['month'], $derivemonth);
                    unset($derivemonth[$key]);
                    unset($monthName[$key]);
                }
            }
        }

        if ($month == '') {
            $month = $last_month;
        }

        $plan['inv_id'] = $id;
        $plan['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        $data['impact_plan'] = $this->Mportfolio->getPlanDetails('port_impact', $plan, '', $f_year, $status);
        $data['impact_config'] = $this->Mportfolio->getPlanDetails('plan_impact', $c_option, '', $f_year, $status);

        $this->load->vars($data);
        $this->load->view('pending_inputs/impact_plan');
    }

    public function addImpactPlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];

        $data['beneficiaries'] = $_POST['end_beneficiaries'];
        $data['jobs_created'] = $_POST['created_jobs'];
        $data['total_impacted'] = $_POST['total_impacted'];

        $j = 1;
        foreach ($_POST["metric"] as $key => $val1) {
            if ($_POST["metric_name"][$key] != '') {
                $metric_name = 'metric' . $j;
                $mName[] = $_POST["metric_name"][$key];
                $mvalues[] = $val1;
                $j++;
            }
        }
        $metric_values = php72_array_combine($mName, $mvalues);
        $data['metric_unit'] = json_encode($metric_values);

        $checkExist = $this->Mportfolio->getDetails('port_impact', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('port_impact', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('port_impact', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Impact plan updated successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/portfolioui/plan_impact/' . $_POST['innovation_id']);
    }

    public function plan_header($id = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $id;
        $data['company_data'] = $this->Mportfolio->getDetails('port_company_data', $c_option);
        $data['business_nature'] = $this->Mportfolio->getDetails('port_business', $c_option);

        $sector['id'] = isset($data['business_nature']) ? $data['business_nature'][0]['sector'] : '';
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        return $data;
    }

    public function plan_milestone($id = '', $year = '', $milestone = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $condmiles['inv_id'] = $id;
        if ($milestone != '') {
            $condmiles['id'] = $milestone;
        }

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);

        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if (php72_cmp($fy['status']) == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }
        $data['get_milestone'] = $this->Mportfolio->getDetails('port_project_milestone', $condmiles, $status, $f_year);

        if ($milestone == '') {
            $actual_mile_id = $data['get_milestone'][0]['id'];
        } else {
            $actual_mile_id = $milestone;
        }


        $option['id'] = $appoption['inv_id'] = $c_option['inv_id'] = $projs['inv_id'] = $data['innovation_id'] = $id;
        $data['milestone_id'] = $projs['milestone_id'] = $taskmiles['milestone_id'] = $actual_mile_id;
        $data['company_data'] = $this->Mportfolio->getDetails('port_company_data', $c_option, $status);
        $data['business_nature'] = $this->Mportfolio->getDetails('port_business', $c_option, $status);
        $data['get_innovation'] = $invdetails = $this->Mportfolio->getDetails('innovation_pool', $option, $status);
        $data['get_allmilestone'] = $this->Mportfolio->getDetails('port_project_milestone', $c_option, $status, $f_year);

        $data['get_task'] = $taskdetails = $this->Mportfolio->getDetails('port_project_task', $taskmiles, $status);
        $projs['task_id'] = $taskdetails[0]['id'];
        $data['get_proj'] = $this->Mportfolio->getDetails('port_project_details', $projs, $status);

        $sector['id'] = isset($data['business_nature']) ? $data['business_nature'][0]['sector'] : $data['get_innovation'][0]['sector'];
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['emp_details'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['dataConfig'] = $this->configCount($id);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $appoption['financial_year'] = $f_year;
        $data['current_financial'] = $f_year;
        $data['awaiting'] = $this->Mportfolio->getApprovalDetails('port_project_milestone', $c_option, '', $year);
        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('port_config_approval', $appoption);

        $this->session->set_userdata('project_approval', $approvals[0]['project_approval']);
        $pending = '0';

        if ($milestone == '') {
            if (php72_cmp($this->session->userdata['sector_lead']) == 1) {
                $get_data = $this->Mportfolio->getApprovalDetails('port_project_milestone', $c_option, $pending);
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/milestone/' . $id . '/' . $get_data[0]['financial_year'] . '/' . $get_data[0]['id']);
                }
            }
        }

        $this->load->vars($data);
        $this->load->view('pending_inputs/milestone_plan');
    }

    public function findSectorLead($sector) {
        $option['employee_id'] = $this->session->userdata['emp_number'];
        $option['partner_id'] = $this->session->userdata('partner_id');
        $get_lead = $this->Mportfolio->getDetails('assign_sector_lead', $option);

        $findSector = array();
        foreach ($get_lead as $lead) {
            array_push($findSector, $lead['sector_id']);
        }

        if (in_array($sector, $findSector)) {
            $find = $this->session->set_userdata('sector_lead', '1');
        } else {
            $find = $this->session->set_userdata('sector_lead', '0');
        }
        return $find;
    }

    public function configCount($id) {
        if ($id != '')
            check_partner_privilege($id);

        $sales['inv_id'] = $channel['inv_id'] = $pipe['inv_id'] = $revenue['inv_id'] = $profit['inv_id'] = $vif['inv_id'] = $id;
        $fund['inv_id'] = $mentor['inv_id'] = $tap['inv_id'] = $nontap['inv_id'] = $board['inv_id'] = $impact['inv_id'] = $project['inv_id'] = $id;

        $sales['sales_approval'] = $channel['channel_approval'] = $pipe['pipeline_approval'] = $revenue['revenue_approval'] = $profit['netprofit_approval'] = $vif['vif_approval'] = 2;
        $fund['fundraise_approval'] = $mentor['mentor_approval'] = $tap['tap_approval'] = $nontap['nontap_approval'] = $board['board_approval'] = $impact['impact_approval'] = $project['project_approval'] = 2;

        $data['salesCount'] = $this->Mportfolio->getDetails('port_config_approval', $sales);
        $data['channelCount'] = $this->Mportfolio->getDetails('port_config_approval', $channel);
        $data['pipeCount'] = $this->Mportfolio->getDetails('port_config_approval', $pipe);
        $data['revenueCount'] = $this->Mportfolio->getDetails('port_config_approval', $revenue);
        $data['netCount'] = $this->Mportfolio->getDetails('port_config_approval', $profit);
        $data['vifCount'] = $this->Mportfolio->getDetails('port_config_approval', $vif);
        $data['fundCount'] = $this->Mportfolio->getDetails('port_config_approval', $fund);
        $data['mentorCount'] = $this->Mportfolio->getDetails('port_config_approval', $mentor);
        $data['tapCount'] = $this->Mportfolio->getDetails('port_config_approval', $tap);
        $data['nontapCount'] = $this->Mportfolio->getDetails('port_config_approval', $nontap);
        $data['boardCount'] = $this->Mportfolio->getDetails('port_config_approval', $board);
        $data['impactCount'] = $this->Mportfolio->getDetails('port_config_approval', $impact);
        $data['projectCount'] = $this->Mportfolio->getDetails('port_config_approval', $project);

        return $data;
    }

    public function plan_boardmeeting($id = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr - 1); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $last_month = date('n') - 1;
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_board_meetings', $least_month, $f_year);

        foreach ($get_monthCount as $val) {
            if (php72_in_array($val['month'], $derivemonth)) {
                if ($last_month != $val['month']) {
                    $key = php72_array_search($val['month'], $derivemonth);
                    unset($derivemonth[$key]);
                    unset($monthName[$key]);
                }
            }
        }

        if ($month == '') {
            $month = $last_month;
        }

        $plan['inv_id'] = $id;
        $plan['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        $data['boardmeet_plan'] = $this->Mportfolio->getPlanDetails('plan_board_meetings', $plan, '', $f_year, $status);

        $this->load->vars($data);
        $this->load->view('pending_inputs/boardmt_plan');
    }

    public function addboardmeetplan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];

        $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
        $data['meeting_type'] = $_POST['type_meet'];
        $data['venue'] = $_POST['venue'];
        $data['external'] = $_POST['board_external'];
        $data['internal'] = $_POST['board_internal'];
        $data['observers'] = $_POST['board_observer'];
        $data['invitees'] = $_POST['other_inviteees'];
        $data['document_link'] = $_POST['link_drive'];
//        $data['document'] = $this->portfolio_file_upload('app', 'uploads/portfolio/plan-boardmeet', 'document_file', 'doc|docx|ppt|pptx|pdf', $_POST['old_doc']);

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/plan-boardmeet';

        if ($_FILES["document_file"]["name"] != "") {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
            $file_name = explode('.', $_FILES["document_file"]["name"]);
            $config['file_name'] = date('Ymdhis') . '_' . str_replace(' ', '_', $_FILES["document_file"]["name"]);

            $this->upload->initialize($config);

            $_FILES['upload_single']['name'] = $_FILES['document_file']['name'];
            $_FILES['upload_single']['tmp_name'] = $_FILES['document_file']['tmp_name'];
            $_FILES['upload_single']['size'] = $_FILES['document_file']['size'];
            $_FILES['upload_single']['type'] = $_FILES['document_file']['type'];
            $_FILES['upload_single']['error'] = $_FILES['document_file']['error'];

            if (!$this->upload->do_upload('upload_single')) {
                $upload_error = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $data['document'] = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['old_doc']) && $_POST['old_doc'] != '') {
            $data['document'] = $_POST['old_doc'];
        } else {
            $data['document'] = '';
        }

        $checkExist = $this->Mportfolio->getDetails('plan_board_meetings', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_board_meetings', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_board_meetings', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Board meeting plan updated successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/portfolioui/plan_boardmeeting/' . $_POST['innovation_id']);
    }

    public function plan_dp($id = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr - 1); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $last_month = date('n') - 1;
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_dp', $least_month, $f_year);

        foreach ($get_monthCount as $val) {
            if (php72_in_array($val['month'], $derivemonth)) {
                if ($last_month != $val['month']) {
                    $key = php72_array_search($val['month'], $derivemonth);
                    unset($derivemonth[$key]);
                    unset($monthName[$key]);
                }
            }
        }

        if ($month == '') {
            $month = $last_month;
        }

        $plan['inv_id'] = $id;
        $plan['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        $data['dp_plan'] = $this->Mportfolio->getPlanDetails('plan_dp', $plan, '', $f_year, $status);

        $this->load->vars($data);
        $this->load->view('pending_inputs/dp_plan');
    }

    public function adddpplan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];

        $data['purpose'] = $_POST['purpose_meet'];
        $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
        $data['location'] = $_POST['location'];
        $data['external_attendees'] = $_POST['external_attd'];
        $data['document_link'] = $_POST['link_drive'];
        $data['document'] = $this->portfolio_file_upload('app', 'uploads/portfolio/plan-dpplan', 'document_file', 'doc|docx|ppt|pptx|pdf', $_POST['old_doc']);


        $checkExist = $this->Mportfolio->getDetails('plan_dp', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_dp', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_dp', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Diagnostic plan updated successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/portfolioui/plan_dp/' . $_POST['innovation_id']);
    }

    function portfolio_file_upload($rootfolder, $folder, $field, $allowed_types, $field_hidden = '') {
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $rootfolder . '/' . $folder . '/';

        $file_name = '';
        if ($_FILES[$field]["name"] != "") {
            $split_name = explode('.', $_FILES[$field]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);
            $this->load->library('upload');
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = $allowed_types;
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload($field)) {
                $upload_error = $this->upload->display_errors();
                return false;
            } else {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            }
            unset($config);
        } else if ($_FILES[$field]["name"] == "" && $field_hidden != '') {
            $file_name = $field_hidden;
        }
        return $file_name;
    }

    public function sectorname() {
        $sector_id = $this->input->post('sector_id');
        $sec_cond = "id = $sector_id";
        $sector_name = $this->Mportfolio->getMultiSector($sec_cond);
        echo $sector_name[0]['sector'];
    }

    public function totalCompanies() {
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');
        $sector_id = $this->input->post('sector_id');

        $searchArray = array();

        if ($sector_id != '') {
            $searchArray[] = "BN.sector IN ($sector_id)";
        }

        if ($startDate != '') {
            $from_date = date("Y-m-d", strtotime($startDate));
            $searchArray[] = "CD.created_at > '$from_date 00:00:00'";
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
            $searchArray[] = "CD.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
            $searchArray[] = "CD.created_at < '$to_date 23:59:59'";
        }

        $searchArray[] = "CD.company_status IN (1,2)";

        $where = implode(" and ", $searchArray);

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $master_list = $this->Mportfolio->getDashboardMaster($partner_id, $f_year, $sector_id);
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();

        $total_list = $this->Mportfolio->getTotalCompany($where, $f_year);
		
        $categories[0] = 'Q1';
        $categories[1] = 'Q2';
        $categories[2] = 'Q3';
        $categories[3] = 'Q4';
        $categories[4] = 'Annual';

        $target[0] = str_replace(',', '', $master_list[0]['tot_q1']);
        $target[1] = str_replace(',', '', $master_list[0]['tot_q2']);
        $target[2] = str_replace(',', '', $master_list[0]['tot_q3']);
        $target[3] = str_replace(',', '', $master_list[0]['tot_q4']);
        $target[4] = str_replace(',', '', $master_list[0]['tot_annual']);

        $actual[0] = $total_list[0]['q1'];
        $actual[1] = $total_list[0]['q2'];
        $actual[2] = $total_list[0]['q3'];
        $actual[3] = $total_list[0]['q4'];
        $actual[4] = $total_list[0]['annual'];

        $sec_cond = "id = $sector_id";
        $sector_name = $this->Mportfolio->getMultiSector($sec_cond);

        $id = $this->input->post('id');
        $data['div_id'] = 'totalChartDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['sector_name'] = $sector_name[0]['sector'];
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/totalCompanies_HC');
    }

    public function newCompanies() {
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');
        $sector_id = $this->input->post('sector_id');
        $searchArray = array();

        if ($sector_id != '') {
            $searchArray[] = "BN.sector IN ($sector_id)";
        }

        if ($startDate != '') {
            $from_date = date("Y-m-d", strtotime($startDate));
            $searchArray[] = "IR.initial_signed_on > '$from_date 00:00:00'";
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
            $searchArray[] = "IR.initial_signed_on < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
            $searchArray[] = "IR.initial_signed_on < '$to_date 23:59:59'";
        }

        $where = implode(" and ", $searchArray);

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $master_list = $this->Mportfolio->getDashboardMaster($partner_id, $f_year, $sector_id);
        $total_list = $this->Mportfolio->getNewCompany($where, $f_year);
		
        $categories = $target = $actual = array();

        $categories[0] = 'Q1';
        $categories[1] = 'Q2';
        $categories[2] = 'Q3';
        $categories[3] = 'Q4';
        $categories[4] = 'Annual';

        $target[0] = str_replace(',', '', $master_list[0]['new_q1']);
        $target[1] = str_replace(',', '', $master_list[0]['new_q2']);
        $target[2] = str_replace(',', '', $master_list[0]['new_q3']);
        $target[3] = str_replace(',', '', $master_list[0]['new_q4']);
        $target[4] = str_replace(',', '', $master_list[0]['new_annual']);

        $actual[0] = $total_list[0]['q1'];
        $actual[1] = $total_list[0]['q2'];
        $actual[2] = $total_list[0]['q3'];
        $actual[3] = $total_list[0]['q4'];
        $actual[4] = $total_list[0]['annual'];

        $sec_cond = "id = $sector_id";
        $sector_name = $this->Mportfolio->getMultiSector($sec_cond);

        $id = $this->input->post('id');
        $data['div_id'] = 'newChartDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['sector_name'] = $sector_name[0]['sector'];
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/newCompanies_HC');
    }

    public function exitCompanies() {
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');
        $sector_id = $this->input->post('sector_id');

        $searchArray = array();

        if ($sector_id != '') {
            $searchArray[] = "BN.sector IN ($sector_id)";
        }

        if ($startDate != '') {
            $from_date = date("Y-m-d", strtotime($startDate));
            $searchArray[] = "CD.created_at > '$from_date 00:00:00'";
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
            $searchArray[] = "CD.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
            $searchArray[] = "CD.created_at < '$to_date 23:59:59'";
        }

        $where = implode(" and ", $searchArray);

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $master_list = $this->Mportfolio->getDashboardMaster($partner_id, $f_year, $sector_id);
        $total_list = $this->Mportfolio->getExitCompany($where, $f_year);

        $categories = $target = $actual = array();

        $categories[0] = 'Q1';
        $categories[1] = 'Q2';
        $categories[2] = 'Q3';
        $categories[3] = 'Q4';
        $categories[4] = 'Annual';

        $exit_q1 = str_replace(',', '', $master_list[0]['ext_q1']);
        $exit_q2 = str_replace(',', '', $master_list[0]['ext_q2']);
        $exit_q3 = str_replace(',', '', $master_list[0]['ext_q3']);
        $exit_q4 = str_replace(',', '', $master_list[0]['ext_q4']);
        $exit_q5 = str_replace(',', '', $master_list[0]['ext_annual']);

        $grad_q1 = str_replace(',', '', $master_list[0]['grad_q1']);
        $grad_q2 = str_replace(',', '', $master_list[0]['grad_q2']);
        $grad_q3 = str_replace(',', '', $master_list[0]['grad_q3']);
        $grad_q4 = str_replace(',', '', $master_list[0]['grad_q4']);
        $grad_q5 = str_replace(',', '', $master_list[0]['grad_annual']);

        $target[0] = php72_num($exit_q1) + php72_num($grad_q1);
        $target[1] = php72_num($exit_q2) + php72_num($grad_q2);
        $target[2] = php72_num($exit_q3) + php72_num($grad_q3);
        $target[3] = php72_num($exit_q4) + php72_num($grad_q4);
        $target[4] = php72_num($exit_q5) + php72_num($grad_q5);

        $actual[0] = $total_list[0]['q1'];
        $actual[1] = $total_list[0]['q2'];
        $actual[2] = $total_list[0]['q3'];
        $actual[3] = $total_list[0]['q4'];
        $actual[4] = $total_list[0]['annual'];

        $sec_cond = "id = $sector_id";
        $sector_name = $this->Mportfolio->getMultiSector($sec_cond);

        $id = $this->input->post('id');
        $data['div_id'] = 'existChartDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['sector_name'] = $sector_name[0]['sector'];
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/exitCompanies_HC');
    }

    public function allSales() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);
            $monthly_target = $this->Mportfolio->getTargetSales($month_where);

            $monthly_actual = $this->Mportfolio->getActualSales($month_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['value'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['value']);
                                $rev_cost = str_replace(',', '', $result['value']);
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = isset($value['value']) && $value['value'] != '' ? str_replace(',', '', $value['value']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            if ($from_quarter == 4) {
                $nxt_from_yr = $from_year + 1;
            } else {
                $nxt_from_yr = $from_year;
            }

            if ($to_quarter == 4) {
                $nxt_to_yr = $getTo_year + 1;
            } else {
                $nxt_to_yr = $getTo_year;
            }

            $q_StartDate = $nxt_from_yr . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);
            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetSales($quarter_where);
            $monthly_actual = $this->Mportfolio->getActualSales($quarter_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['value'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['value']);
                                $rev_cost = str_replace(',', '', $result['value']);
                                $fetch_target[$m]['actual'] += php72_num($actual_cost);
                            } else {
                                $fetch_target[$m]['actual'] = isset($value['value']) && $value['value'] != '' ? str_replace(',', '', $value['value']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += php72_num($value['target']);
                    $hc_actual[$q] += php72_num($value['actual']);
                }
            }
        } else {
            $sales_target = $this->Mportfolio->getTargetSales($default_where);
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($sales_target) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    $categories[0] = 'Q1';
                    $categories[1] = 'Q2';
                    $categories[2] = 'Q3';
                    $categories[3] = 'Q4';
                    $categories[4] = 'Annual';
                    $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
                    $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';

                    foreach ($sales_target as $target) {
                        $get_data = json_decode($target['value']);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += php72_num(str_replace(',', '', $value));
                                $hc_target[0] = $q1_val;
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += php72_num(str_replace(',', '', $value));
                                $hc_target[1] = $q2_val;
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += php72_num(str_replace(',', '', $value));
                                $hc_target[2] = $q3_val;
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += php72_num(str_replace(',', '', $value));
                                $hc_target[3] = $q4_val;
                            }
                        }
                    }

                    $annual_target = php72_num($q1_val) + php72_num($q2_val) + php72_num($q3_val) + php72_num($q4_val);
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($sales_target as $target) {
                        $get_data = json_decode($target['value']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += php72_num(str_replace(',', '', $get_data->$value));
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && php72_cmp($g_quarter) != 5) {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $sales_actual = $this->Mportfolio->getActualSales($default_where);
            $actual_month_value = array();
            if (php72_count($sales_actual) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($sales_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += php72_num(str_replace(',', '', $actual['value']));
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += php72_num(str_replace(',', '', $actual['value']));
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += php72_num(str_replace(',', '', $actual['value']));
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += php72_num(str_replace(',', '', $actual['value']));
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($sales_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_value[$value] += php72_num(str_replace(',', '', $actual['value']));
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }


        $id = $this->input->post('id');
        $data['div_id'] = 'salesDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $data['current_year'] = $g_year;
        $data['current_quarter'] = $g_quarter;
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allSales_HC');
//        $this->load->view('portfolio/dashboard_chart/sales_combo');
    }

    public function allRevenue() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
//            $search_month[] = "t2.sector = '$g_sector'";
            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetRevenue($month_where);
            $monthly_actual = $this->Mportfolio->getActualRevenue($month_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['revenue']);
                                $rev_cost = str_replace(',', '', $result['revenue']);
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = isset($value['revenue']) && $value['revenue'] != '' ? str_replace(',', '', $value['revenue']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $nxt_year;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetRevenue($quarter_where);
            $monthly_actual = $this->Mportfolio->getActualRevenue($quarter_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['revenue']);
                                $rev_cost = str_replace(',', '', $result['revenue']);
                                $fetch_target[$m]['actual'] += php72_num($actual_cost);
                            } else {
                                $fetch_target[$m]['actual'] = isset($value['revenue']) && $value['revenue'] != '' ? str_replace(',', '', $value['revenue']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += php72_num($value['target']);
                    $hc_actual[$q] += php72_num($value['actual']);
                }
            }
        } else {
            $revenue_target = $this->Mportfolio->getTargetRevenue($default_where);
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($revenue_target) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($revenue_target as $target) {
                        $get_data = json_decode($target['data']);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += php72_num(str_replace(',', '', $value));
                                $hc_target[0] = $q1_val;
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += php72_num(str_replace(',', '', $value));
                                $hc_target[1] = $q2_val;
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += php72_num(str_replace(',', '', $value));
                                $hc_target[2] = $q3_val;
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += php72_num(str_replace(',', '', $value));
                                $hc_target[3] = $q4_val;
                            }
                        }
                    }
                    $annual_target = php72_num($q1_val) + php72_num($q2_val) + php72_num($q3_val) + php72_num($q4_val);
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($revenue_target as $target) {
                        $get_data = json_decode($target['data']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += php72_num(str_replace(',', '', $get_data->$value));
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && php72_cmp($g_quarter) != 5) {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $revenue_actual = $this->Mportfolio->getActualRevenue($default_where);
            $actual_month_value = array();
            if (php72_count($revenue_actual) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($revenue_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += php72_num(str_replace(',', '', $actual['revenue']));
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += php72_num(str_replace(',', '', $actual['revenue']));
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += php72_num(str_replace(',', '', $actual['revenue']));
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += php72_num(str_replace(',', '', $actual['revenue']));
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($revenue_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_value[$value] += php72_num(str_replace(',', '', $actual['revenue']));
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'revenueDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
//        $this->load->view('portfolio/dashboard_chart/revenue_combo');
    }

    public function allProfit() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = $this->input->post('f_quarter');
        $to_quarter = $this->input->post('t_quarter');
        $from_year = $this->input->post('f_year');
        $to_year = $this->input->post('t_year');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {

            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);
            $monthly_target = $this->Mportfolio->getTargetProfit($month_where);

            $monthly_actual = $this->Mportfolio->getActualProfit($month_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['net_profit']);
                                $rev_cost = str_replace(',', '', $result['net_profit']);
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = str_replace(',', '', $value['net_profit']);
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            $getFrom_year = $from_year;
            if (php72_cmp($from_quarter) == 1) {
                $start_month = reset($q1);
            } else if (php72_cmp($from_quarter) == 2) {
                $start_month = reset($q2);
            } else if (php72_cmp($from_quarter) == 3) {
                $start_month = reset($q3);
            } else if (php72_cmp($from_quarter) == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if (php72_cmp($to_quarter) == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($to_quarter) == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($to_quarter) == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($to_quarter) == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetProfit($quarter_where);
            $monthly_actual = $this->Mportfolio->getActualProfit($quarter_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['net_profit']);
                                $rev_cost = str_replace(',', '', $result['net_profit']);
                                $fetch_target[$m]['actual'] += php72_num($actual_cost);
                            } else {
                                $fetch_target[$m]['actual'] = str_replace(',', '', $value['net_profit']);
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += php72_num($value['target']);
                    $hc_actual[$q] += php72_num($value['actual']);
                }
            }
        } else {
            $profit_target = $this->Mportfolio->getTargetProfit($default_where);
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($profit_target) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($profit_target as $target) {
                        $get_data = json_decode($target['data']);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += php72_num(str_replace(',', '', $value));
                                $hc_target[0] = round($q1_val, 2);
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += php72_num(str_replace(',', '', $value));
                                $hc_target[1] = round($q2_val, 2);
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += php72_num(str_replace(',', '', $value));
                                $hc_target[2] = round($q3_val, 2);
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += php72_num(str_replace(',', '', $value));
                                $hc_target[3] = round($q4_val, 2);
                            }
                        }
                    }

                    $annual_target = php72_num($q1_val) + php72_num($q2_val) + php72_num($q3_val) + php72_num($q4_val);
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($profit_target as $target) {
                        $get_data = json_decode($target['data']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += php72_num(str_replace(',', '', $get_data->$value));
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && php72_cmp($g_quarter) != 5) {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $profit_actual = $this->Mportfolio->getActualProfit($default_where);
            $actual_month_value = array();
            if (php72_count($profit_actual) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($profit_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += php72_num(str_replace(',', '', $actual['net_profit']));
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += php72_num(str_replace(',', '', $actual['net_profit']));
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += php72_num(str_replace(',', '', $actual['net_profit']));
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += php72_num(str_replace(',', '', $actual['net_profit']));
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($profit_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_value[$value] += php72_num(str_replace(',', '', $actual['net_profit']));
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'profitDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allProfit_HC');
    }

    public function allEndbeneficiaries() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			#CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$g_year." AND B.year = ".$g_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$dynamicConditions = rtrim($dynamicConditions, " AND ");
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
			#CR CHANGE           
		   $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);


            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }
        $defimpact_where = "t1.field_type = 1";

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();
		
        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
//            $search_month[] = "t2.sector = '$g_sector'";
            $search_month[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 1";
            $month_where = php72_implode(" and ", $search_month);


            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($month_where, $impact_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($month_where,$g_sector);
			#echo'<pre>';print_r($month_where);
			#echo'<pre>';print_r($monthly_target);die;
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    } else {
                        $yearvalues[1] = $yearvalues[1];
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {

                    foreach ($monthly_target as $key => $value) {

                        if ($yearvalues[1] == $value['financial_year']) {
                            $yearvalues[0] = strtolower($yearvalues[0]);
                            if (isset($value[$yearvalues[0]])) {
                                $nums = str_replace(',', '', $value[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($nums);
                                } else {
                                    $search_array[$values] = $nums;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        } else {
                            return ($var['financial_year'] == $split_year);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            $end_male = str_replace(',', '', $value['end_male']);
                            $end_female = str_replace(',', '', $value['end_female']);
                            $end_other = str_replace(',', '', $value['end_other']);
                            $end_unknown = str_replace(',', '', $value['end_unknown']);
                            $endBeneficiaries = php72_num($end_male) + php72_num($end_female) + php72_num($end_other) + php72_num($end_unknown);
                            if ($result['month'] == $value['month']) {
                                $actual_cost = $endBeneficiaries;
                                $rev_cost = $endBeneficiaries;
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = isset($value['end_male']) && isset($value['end_female']) && isset($value['end_other']) && isset($value['end_unknown']) && $endBeneficiaries != '' ? $endBeneficiaries : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {

            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 1";
            $quarter_where = implode(" and ", $search_quarter);
			
            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($quarter_where, $impact_where,$g_sector);
			
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($quarter_where,$g_sector);

            $impt_act = array();
            $impt_tarquat['q1'] = 0;
            $impt_tarquat['q2'] = 0;
            $impt_tarquat['q3'] = 0;
            $impt_tarquat['q4'] = 0;
            $impt_actquat['q1'] = 0;
            $impt_actquat['q2'] = 0;
            $impt_actquat['q3'] = 0;
            $impt_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                $targ_apr = str_replace(',', '', $targs[strtolower($get_fy_month[0])]);
                $targ_may = str_replace(',', '', $targs[strtolower($get_fy_month[1])]);
                $targ_jun = str_replace(',', '', $targs[strtolower($get_fy_month[2])]);
                $targ_jul = str_replace(',', '', $targs[strtolower($get_fy_month[3])]);
                $targ_aug = str_replace(',', '', $targs[strtolower($get_fy_month[4])]);
                $targ_sep = str_replace(',', '', $targs[strtolower($get_fy_month[5])]);
                $targ_oct = str_replace(',', '', $targs[strtolower($get_fy_month[6])]);
                $targ_nov = str_replace(',', '', $targs[strtolower($get_fy_month[7])]);
                $targ_dec = str_replace(',', '', $targs[strtolower($get_fy_month[8])]);
                $targ_jan = str_replace(',', '', $targs[strtolower($get_fy_month[9])]);
                $targ_feb = str_replace(',', '', $targs[strtolower($get_fy_month[10])]);
                $targ_mar = str_replace(',', '', $targs[strtolower($get_fy_month[11])]);

                $impt_tarquat['q1'] += php72_num($targ_apr) + php72_num($targ_may) + php72_num($targ_jun);
                $impt_tarquat['q2'] += php72_num($targ_jul) + php72_num($targ_aug) + php72_num($targ_sep);
                $impt_tarquat['q3'] += php72_num($targ_oct) + php72_num($targ_nov) + php72_num($targ_dec);
                $impt_tarquat['q4'] += php72_num($targ_jan) + php72_num($targ_feb) + php72_num($targ_mar);
            }



            foreach ($monthly_actual as $acts) {
                $end_male = str_replace(',', '', $acts['end_male']);
                $end_female = str_replace(',', '', $acts['end_female']);
                $end_other = str_replace(',', '', $acts['end_other']);
                $end_unknown = str_replace(',', '', $acts['end_unknown']);
                $endBeneficiaries = php72_num($end_male) + php72_num($end_female) + php72_num($end_other) + php72_num($end_unknown);
                if (in_array($acts['month'], $q1_key)) {
                    $impt_actquat['q1'] += $endBeneficiaries;
                }
                if (in_array($acts['month'], $q2_key)) {
                    $impt_actquat['q2'] += $endBeneficiaries;
                }
                if (in_array($acts['month'], $q3_key)) {
                    $impt_actquat['q3'] += $endBeneficiaries;
                }
                if (in_array($acts['month'], $q4_key)) {
                    $impt_actquat['q4'] += $endBeneficiaries;
                }
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $impt_tarquat['q1'];
            $hc_target[1] = $impt_tarquat['q2'];
            $hc_target[2] = $impt_tarquat['q3'];
            $hc_target[3] = $impt_tarquat['q4'];
            $hc_target[4] = $impt_tarquat['q1'] + $impt_tarquat['q2'] + $impt_tarquat['q3'] + $impt_tarquat['q4'];

            $hc_actual[0] = $impt_actquat['q1'];
            $hc_actual[1] = $impt_actquat['q2'];
            $hc_actual[2] = $impt_actquat['q3'];
            $hc_actual[3] = $impt_actquat['q4'];
            $hc_actual[4] = $impt_actquat['q1'] + $impt_actquat['q2'] + $impt_actquat['q3'] + $impt_actquat['q4'];
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'impactDiv_' . $id;
        $data['xaxis'] = "No. of End Beneficiaries";
        $data['yaxis'] = "End beneficiaries count";
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/impact_combo');
    }

    /*public function allDirectjobs() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = array_keys($q1);
        $q2_key = array_keys($q2);
        $q3_key = array_keys($q3);
        $q4_key = array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if ($g_quarter == 1) {
                $g_start_month = reset($q1);
                $q1_arr = array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if ($g_quarter == 2) {
                $g_start_month = reset($q2);
                $q2_arr = array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if ($g_quarter == 3) {
                $g_start_month = reset($q3);
                $q3_arr = array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if ($g_quarter == 4) {
                $g_start_month = reset($q4);
                $q4_arr = array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }
        $defimpact_where = "t1.field_type = 2";

        $default_where = implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if ($type == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
//            $search_month[] = "t2.sector = '$g_sector'";
            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $impact_where = "t1.field_type = 2";
            $month_where = implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($month_where, $impact_where);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($month_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (count($monthly_target) > 0) {

                    foreach ($monthly_target as $key => $value) {

                        if ($yearvalues[1] == $value['financial_year']) {
                            $yearvalues[0] = strtolower($yearvalues[0]);
                            if (isset($value[$yearvalues[0]])) {
                                $nums = str_replace(',', '', $value[$yearvalues[0]]);
                                if (array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + $nums;
                                } else {
                                    $search_array[$values] = $nums;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime($split[0]));
                $split_year = $split[1];
                $new_fy = array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if ($var['month'] == 1 || $var['month'] == 2 || $var['month'] == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            $end_male = str_replace(',', '', $value['direct_male']);
                            $end_female = str_replace(',', '', $value['direct_female']);
                            $end_other = str_replace(',', '', $value['direct_other']);
                            $end_unknown = str_replace(',', '', $value['direct_unknown']);
                            $endBeneficiaries = $end_male + $end_female + $end_other + $end_unknown;
                            if ($result['month'] == $value['month']) {

                                $actual_cost = $endBeneficiaries;
                                $rev_cost = $endBeneficiaries;
                                $hc_actual[$m] += $actual_cost;
                            } else {
                                $hc_actual[$m] = isset($value['direct_male']) && isset($value['direct_female']) && isset($value['direct_other']) && isset($value['direct_unknown']) && $endBeneficiaries != '' ? $endBeneficiaries : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if ($type == 2) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 2";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($quarter_where, $impact_where);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($quarter_where);

            $impt_act = array();
            $impt_tarquat['q1'] = 0;
            $impt_tarquat['q2'] = 0;
            $impt_tarquat['q3'] = 0;
            $impt_tarquat['q4'] = 0;
            $impt_actquat['q1'] = 0;
            $impt_actquat['q2'] = 0;
            $impt_actquat['q3'] = 0;
            $impt_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                $targ_apr = str_replace(',', '', $targs[strtolower($get_fy_month[0])]);
                $targ_may = str_replace(',', '', $targs[strtolower($get_fy_month[1])]);
                $targ_jun = str_replace(',', '', $targs[strtolower($get_fy_month[2])]);
                $targ_jul = str_replace(',', '', $targs[strtolower($get_fy_month[3])]);
                $targ_aug = str_replace(',', '', $targs[strtolower($get_fy_month[4])]);
                $targ_sep = str_replace(',', '', $targs[strtolower($get_fy_month[5])]);
                $targ_oct = str_replace(',', '', $targs[strtolower($get_fy_month[6])]);
                $targ_nov = str_replace(',', '', $targs[strtolower($get_fy_month[7])]);
                $targ_dec = str_replace(',', '', $targs[strtolower($get_fy_month[8])]);
                $targ_jan = str_replace(',', '', $targs[strtolower($get_fy_month[9])]);
                $targ_feb = str_replace(',', '', $targs[strtolower($get_fy_month[10])]);
                $targ_mar = str_replace(',', '', $targs[strtolower($get_fy_month[11])]);

                $impt_tarquat['q1'] += $targ_apr + $targ_may + $targ_jun;
                $impt_tarquat['q2'] += $targ_jul + $targ_aug + $targ_sep;
                $impt_tarquat['q3'] += $targ_oct + $targ_nov + $targ_dec;
                $impt_tarquat['q4'] += $targ_jan + $targ_feb + $targ_mar;
            }

            foreach ($monthly_actual as $acts) {
                $direct_male = str_replace(',', '', $acts['direct_male']);
                $direct_female = str_replace(',', '', $acts['direct_female']);
                $direct_other = str_replace(',', '', $acts['direct_other']);
                $direct_unknown = str_replace(',', '', $acts['direct_unknown']);
                $directjobs = $direct_male + $direct_female + $direct_other + $direct_unknown;
                if (in_array($acts['month'], $q1_key)) {
                    $impt_actquat['q1'] += $directjobs;
                }
                if (in_array($acts['month'], $q2_key)) {
                    $impt_actquat['q2'] += $directjobs;
                }
                if (in_array($acts['month'], $q3_key)) {
                    $impt_actquat['q3'] += $directjobs;
                }
                if (in_array($acts['month'], $q4_key)) {
                    $impt_actquat['q4'] += $directjobs;
                }
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $impt_tarquat['q1'];
            $hc_target[1] = $impt_tarquat['q2'];
            $hc_target[2] = $impt_tarquat['q3'];
            $hc_target[3] = $impt_tarquat['q4'];
            $hc_target[4] = $impt_tarquat['q1'] + $impt_tarquat['q2'] + $impt_tarquat['q3'] + $impt_tarquat['q4'];

            $hc_actual[0] = $impt_actquat['q1'];
            $hc_actual[1] = $impt_actquat['q2'];
            $hc_actual[2] = $impt_actquat['q3'];
            $hc_actual[3] = $impt_actquat['q4'];
            $hc_actual[4] = $impt_actquat['q1'] + $impt_actquat['q2'] + $impt_actquat['q3'] + $impt_actquat['q4'];
        }

        $derive_target = array();
        for ($m = 0; $m < count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'impactDiv_' . $id;
        $data['xaxis'] = "No. of Direct Jobs Created";
        $data['yaxis'] = "Direct jobs count";
        $data['categories_list'] = array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/impact_combo');
    }*/

    public function allDirectjobs() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $nxt_year = $from_year + 1;
        $start_date = 'Apr, ' . $from_year;
        $end_date = 'Mar, ' . $nxt_year;

        // $from_quarter = $this->input->post('f_quarter');
        // $to_quarter = $this->input->post('t_quarter');
        // $from_year = $this->input->post('f_year');
        // $to_year = $this->input->post('t_year');
        // $start_date = $this->input->post('start_date');
        // $end_date = $this->input->post('end_date');

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			#CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
			#CR CHANGE   
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $g_end_month = $q1[6];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $g_end_month = $q2[9];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $g_end_month = $q3[12];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $g_end_month = $q4[3];
                $g_getTo_year = $g_year;
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }
        $defimpact_where = "t1.field_type = 2";

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
//            $search_month[] = "t2.sector = '$g_sector'";
            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $impact_where = "t1.field_type = 2";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($month_where, $impact_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($month_where,$g_sector);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                    $yearvalues[1] = $yearvalues[1] - 1;
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {

                    foreach ($monthly_target as $key => $value) {

                        if ($yearvalues[1] == $value['financial_year']) {
                            $yearvalues[0] = strtolower($yearvalues[0]);
                            if (isset($value[$yearvalues[0]])) {
                                $nums = str_replace(',', '', $value[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($nums);
                                } else {
                                    $search_array[$values] = $nums;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                        $prev_split_yr = $split_year - 1;
                        return ($var['financial_year'] == $prev_split_yr);
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            $end_male = str_replace(',', '', $value['direct_male']);
                            $end_female = str_replace(',', '', $value['direct_female']);
                            $end_other = str_replace(',', '', $value['direct_other']);
                            $end_unknown = str_replace(',', '', $value['direct_unknown']);
                            $endBeneficiaries = php72_num($end_male) + php72_num($end_female) + php72_num($end_other) + php72_num($end_unknown);
                            if ($result['month'] == $value['month']) {

                                $actual_cost = $endBeneficiaries;
                                $rev_cost = $endBeneficiaries;
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = isset($value['direct_male']) && isset($value['direct_female']) && isset($value['direct_other']) && isset($value['direct_unknown']) && $endBeneficiaries != '' ? $endBeneficiaries : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $end_month = $q1[6];
            } else if ($to_quarter == 2) {
                $end_month = $q2[9];
            } else if ($to_quarter == 3) {
                $end_month = $q3[12];
            } else if ($to_quarter == 4) {
                $end_month = $q4[3];
                $getTo_year = $to_year + 1;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 2";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($quarter_where, $impact_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($quarter_where,$g_sector);

            $impt_act = array();
            $impt_tarquat['q1'] = 0;
            $impt_tarquat['q2'] = 0;
            $impt_tarquat['q3'] = 0;
            $impt_tarquat['q4'] = 0;
            $impt_actquat['q1'] = 0;
            $impt_actquat['q2'] = 0;
            $impt_actquat['q3'] = 0;
            $impt_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                $targ_apr = str_replace(',', '', $targs['apr']);
                $targ_may = str_replace(',', '', $targs['may']);
                $targ_jun = str_replace(',', '', $targs['jun']);
                $targ_jul = str_replace(',', '', $targs['jul']);
                $targ_aug = str_replace(',', '', $targs['aug']);
                $targ_sep = str_replace(',', '', $targs['sep']);
                $targ_oct = str_replace(',', '', $targs['oct']);
                $targ_nov = str_replace(',', '', $targs['nov']);
                $targ_dec = str_replace(',', '', $targs['dec']);
                $targ_jan = str_replace(',', '', $targs['jan']);
                $targ_feb = str_replace(',', '', $targs['feb']);
                $targ_mar = str_replace(',', '', $targs['mar']);

                // $impt_tarquat['q1'] += $targ_apr + $targ_may + $targ_jun;
                // $impt_tarquat['q2'] += $targ_jul + $targ_aug + $targ_sep;
                // $impt_tarquat['q3'] += $targ_oct + $targ_nov + $targ_dec;
                // $impt_tarquat['q4'] += $targ_jan + $targ_feb + $targ_mar;

                $impt_tarquat['q1'] += php72_num($targ_jun);
                $impt_tarquat['q2'] += php72_num($targ_sep);
                $impt_tarquat['q3'] += php72_num($targ_dec);
                $impt_tarquat['q4'] += php72_num($targ_mar);
            }

        // $apr_directjobs = $may_directjobs = $jun_directjobs = $jul_directjobs = $aug_directjobs = $sep_directjobs = $oct_directjobs = $nov_directjobs = $dec_directjobs = $jan_directjobs = $feb_directjobs = $mar_directjobs = 0;
            foreach ($monthly_actual as $acts) {
                $direct_male = str_replace(',', '', $acts['direct_male']);
                $direct_female = str_replace(',', '', $acts['direct_female']);
                $direct_other = str_replace(',', '', $acts['direct_other']);
                $direct_unknown = str_replace(',', '', $acts['direct_unknown']);
                $directjobs = php72_num($direct_male) + php72_num($direct_female) + php72_num($direct_other) + php72_num($direct_unknown);
                if ($acts['month'] == '6') {
                    $jun_directjobs += $directjobs;
                } else if($acts['month'] == '5'){
                    $may_directjobs += $directjobs;
                } else if($acts['month'] == '4'){
                    $apr_directjobs += $directjobs;
                }

                if ($acts['month'] == '9') {
                    $sep_directjobs += $directjobs;
                } else if($acts['month'] == '8'){
                    $aug_directjobs += $directjobs;
                } else if($acts['month'] == '7'){
                    $jul_directjobs += $directjobs;
                }

                if ($acts['month'] == '12') {
                    $dec_directjobs += $directjobs;
                } else if($acts['month'] == '11'){
                    $nov_directjobs += $directjobs;
                } else if($acts['month'] == '10'){
                    $oct_directjobs += $directjobs;
                }

                if ($acts['month'] == '3') {
                    $mar_directjobs += $directjobs;
                } else if($acts['month'] == '2'){
                    $feb_directjobs += $directjobs;
                } else if($acts['month'] == '1'){
                    $jan_directjobs += $directjobs;
                }
                
            }

            if(isset($mar_directjobs)){
                $impt_actquat['q4'] = $mar_directjobs;
            } else if(isset($feb_directjobs)){
                $impt_actquat['q4'] = $feb_directjobs;
            } else {
                $impt_actquat['q4'] = $jan_directjobs;
            }

            if(isset($dec_directjobs)){
                $impt_actquat['q3'] = $dec_directjobs;
            } else if(isset($nov_directjobs)){
                $impt_actquat['q3'] = $nov_directjobs;
            } else {
                $impt_actquat['q3'] = $oct_directjobs;
            }

            if(isset($sep_directjobs)){
                $impt_actquat['q2'] = $sep_directjobs;
            } else if(isset($aug_directjobs)){
                $impt_actquat['q2'] = $aug_directjobs;
            } else {
                $impt_actquat['q2'] = $jul_directjobs;
            }

            if(isset($jun_directjobs)){
                $impt_actquat['q1'] = $jun_directjobs;
            } else if(isset($may_directjobs)){
                $impt_actquat['q1'] = $may_directjobs;
            } else {
                $impt_actquat['q1'] = $apr_directjobs;
            }


            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $impt_tarquat['q1'];
            $hc_target[1] = $impt_tarquat['q2'];
            $hc_target[2] = $impt_tarquat['q3'];
            $hc_target[3] = $impt_tarquat['q4'];
            $hc_target[4] = $impt_tarquat['q1'] + $impt_tarquat['q2'] + $impt_tarquat['q3'] + $impt_tarquat['q4'];

            $hc_actual[0] = $impt_actquat['q1'];
            $hc_actual[1] = $impt_actquat['q2'];
            $hc_actual[2] = $impt_actquat['q3'];
            $hc_actual[3] = $impt_actquat['q4'];
            $hc_actual[4] = $impt_actquat['q1'] + $impt_actquat['q2'] + $impt_actquat['q3'] + $impt_actquat['q4'];
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, $hc_target[$m]);
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, $hc_actual[$m]);
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'impactDiv_' . $id;
        $data['xaxis'] = "No. of Direct Jobs Created";
        $data['yaxis'] = "Direct jobs count";
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/impact_combo');
    }

    public function allIndirectjobs() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = 1;
        $to_quarter = 4;
        $from_year = $this->input->post('f_year');
        $to_year = $from_year;
        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $get_fy_month = $this->month();
        $start_date = $get_fy_month[0] . ', ' . $from_year;
        $end_date = $get_fy_month[11] . ', ' . $nxt_year;

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            #$search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
			#CR CHANGE
			$dynamicConditions = "(FIND_IN_SET('$g_sector', REPLACE(B.sector, ' ', '')) > 0 OR (t1.financial_year =".$sel_year." AND B.year = ".$sel_year." AND t1.financial_year = B.year)) OR (B.sector IS NULL AND FIND_IN_SET('$g_sector', REPLACE(t2.sector, ' ', '')) > 0)";
			$search_where[] = $search_month[] = $search_quarter[] = $dynamicConditions;
			#CR CHANGE   
			
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }
        $defimpact_where = "t1.field_type = 3";

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);
//            $search_month[] = "t2.sector = '$g_sector'";
            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $impact_where = "t1.field_type = 3";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($month_where, $impact_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($month_where,$g_sector);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {

                    foreach ($monthly_target as $key => $value) {

                        if ($yearvalues[1] == $value['financial_year']) {
                            $yearvalues[0] = strtolower($yearvalues[0]);
                            if (isset($value[$yearvalues[0]])) {
                                $nums = str_replace(',', '', $value[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($nums);
                                } else {
                                    $search_array[$values] = $nums;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            $end_male = str_replace(',', '', $value['indirect_male']);
                            $end_female = str_replace(',', '', $value['indirect_female']);
                            $end_other = str_replace(',', '', $value['indirect_other']);
                            $end_unknown = str_replace(',', '', $value['indirect_unknown']);
                            $endBeneficiaries = php72_num($end_male) + php72_num($end_female) + php72_num($end_other) + php72_num($end_unknown);
                            if ($result['month'] == $value['month']) {

                                $actual_cost = $endBeneficiaries;
                                $rev_cost = $endBeneficiaries;
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = isset($value['indirect_male']) && isset($value['indirect_female']) && isset($value['indirect_other']) && isset($value['indirect_unknown']) && $endBeneficiaries != '' ? $endBeneficiaries : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            $getFrom_year = $from_year;
            if ($from_quarter == 1) {
                $start_month = reset($q1);
            } else if ($from_quarter == 2) {
                $start_month = reset($q2);
            } else if ($from_quarter == 3) {
                $start_month = reset($q3);
            } else if ($from_quarter == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if ($to_quarter == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if ($to_quarter == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if ($to_quarter == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if ($to_quarter == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $from_year";
            $impact_where = "t1.field_type = 3";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetEndbeneficiaries($quarter_where, $impact_where,$g_sector);
            $monthly_actual = $this->Mportfolio->getActualEndbeneficiaries($quarter_where,$g_sector);

            $impt_act = array();
            $impt_tarquat['q1'] = 0;
            $impt_tarquat['q2'] = 0;
            $impt_tarquat['q3'] = 0;
            $impt_tarquat['q4'] = 0;
            $impt_actquat['q1'] = 0;
            $impt_actquat['q2'] = 0;
            $impt_actquat['q3'] = 0;
            $impt_actquat['q4'] = 0;

            foreach ($monthly_target as $targs) {
                $targ_apr = str_replace(',', '', $targs[strtolower($get_fy_month[0])]);
                $targ_may = str_replace(',', '', $targs[strtolower($get_fy_month[1])]);
                $targ_jun = str_replace(',', '', $targs[strtolower($get_fy_month[2])]);
                $targ_jul = str_replace(',', '', $targs[strtolower($get_fy_month[3])]);
                $targ_aug = str_replace(',', '', $targs[strtolower($get_fy_month[4])]);
                $targ_sep = str_replace(',', '', $targs[strtolower($get_fy_month[5])]);
                $targ_oct = str_replace(',', '', $targs[strtolower($get_fy_month[6])]);
                $targ_nov = str_replace(',', '', $targs[strtolower($get_fy_month[7])]);
                $targ_dec = str_replace(',', '', $targs[strtolower($get_fy_month[8])]);
                $targ_jan = str_replace(',', '', $targs[strtolower($get_fy_month[9])]);
                $targ_feb = str_replace(',', '', $targs[strtolower($get_fy_month[10])]);
                $targ_mar = str_replace(',', '', $targs[strtolower($get_fy_month[11])]);

                $impt_tarquat['q1'] += php72_num($targ_apr) + php72_num($targ_may) + php72_num($targ_jun);
                $impt_tarquat['q2'] += php72_num($targ_jul) + php72_num($targ_aug) + php72_num($targ_sep);
                $impt_tarquat['q3'] += php72_num($targ_oct) + php72_num($targ_nov) + php72_num($targ_dec);
                $impt_tarquat['q4'] += php72_num($targ_jan) + php72_num($targ_feb) + php72_num($targ_mar);
            }

            foreach ($monthly_actual as $acts) {
                $indirect_male = str_replace(',', '', $acts['indirect_male']);
                $indirect_female = str_replace(',', '', $acts['indirect_female']);
                $indirect_other = str_replace(',', '', $acts['indirect_other']);
                $indirect_unknown = str_replace(',', '', $acts['indirect_unknown']);
                $indirectjobs = php72_num($indirect_male) + php72_num($indirect_female) + php72_num($indirect_other) + php72_num($indirect_unknown);
                if (in_array($acts['month'], $q1_key)) {
                    $impt_actquat['q1'] += $indirectjobs;
                }
                if (in_array($acts['month'], $q2_key)) {
                    $impt_actquat['q2'] += $indirectjobs;
                }
                if (in_array($acts['month'], $q3_key)) {
                    $impt_actquat['q3'] += $indirectjobs;
                }
                if (in_array($acts['month'], $q4_key)) {
                    $impt_actquat['q4'] += $indirectjobs;
                }
            }

            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $hc_target[0] = $impt_tarquat['q1'];
            $hc_target[1] = $impt_tarquat['q2'];
            $hc_target[2] = $impt_tarquat['q3'];
            $hc_target[3] = $impt_tarquat['q4'];
            $hc_target[4] = $impt_tarquat['q1'] + $impt_tarquat['q2'] + $impt_tarquat['q3'] + $impt_tarquat['q4'];

            $hc_actual[0] = $impt_actquat['q1'];
            $hc_actual[1] = $impt_actquat['q2'];
            $hc_actual[2] = $impt_actquat['q3'];
            $hc_actual[3] = $impt_actquat['q4'];
            $hc_actual[4] = $impt_actquat['q1'] + $impt_actquat['q2'] + $impt_actquat['q3'] + $impt_actquat['q4'];
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'impactDiv_' . $id;
        $data['xaxis'] = "No. of Indirect Jobs Created";
        $data['yaxis'] = "Indirect jobs count";
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
//        $this->load->view('portfolio/dashboard_chart/allRevenue_HC');
        $this->load->view('portfolio/dashboard_chart/impact_combo');
    }

    public function allCapital() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();
        $get_fy_month = $this->month();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;
        $a1_equity = $a2_equity = $a3_equity = $a4_equity = 0;
        $a1_short = $a2_short = $a3_short = $a4_short = 0;
        $a1_long = $a2_long = $a3_long = $a4_long = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = $this->input->post('f_quarter');
        $to_quarter = $this->input->post('t_quarter');
        $from_year = $this->input->post('f_year');
        $to_year = $this->input->post('t_year');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $search_where = $search_month = $search_quarter = array();

        if ($g_sector != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_where[] = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }

        if ($inv_id != '') {
            $search_where[] = $search_month[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_where = php72_implode(" and ", $search_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
            $month_where = php72_implode(" and ", $search_month);

            $monthly_target = $this->Mportfolio->getTargetCapital($month_where);
            $monthly_actual = $this->Mportfolio->getActualCapital($month_where);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {
                                $cost = str_replace(',', '', $datavalues[$yearvalues[0]]);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                /* for new changes  - datemodified - 12/12/2019 */
                                $fund_mons = explode('-', $values);
                                if ($fund_mons[0] == $get_fy_month[2]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        $search_array[$values] = $search_array[$values] + php72_num(str_replace(',', '', $datavalues['qone']));
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qone']);
                                    }
                                }
                                if ($fund_mons[0] == $get_fy_month[5]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        $search_array[$values] = $search_array[$values] + php72_num(str_replace(',', '', $datavalues['qtwo']));
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qtwo']);
                                    }
                                }
                                if ($fund_mons[0] == $get_fy_month[8]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        $search_array[$values] = $search_array[$values] + php72_num(str_replace(',', '', $datavalues['qthree']));
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qthree']);
                                    }
                                }
                                if ($fund_mons[0] == $get_fy_month[11]) {
                                    if (php72_array_key_exists($values, $search_array)) {
                                        $search_array[$values] = $search_array[$values] + php72_num(str_replace(',', '', $datavalues['qfour']));
                                    } else {
                                        $search_array[$values] = str_replace(',', '', $datavalues['qfour']);
                                    }
                                }
                                /* end of changes */
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }
            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;

                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_cost = php72_num($actual_equity) + php72_num($actual_grand) + php72_num($actual_short) + php72_num($actual_long);
                                $rev_equity = str_replace(',', '', $result['equity_total']);
                                $rev_grand = str_replace(',', '', $result['grand_total']);
                                $rev_short = str_replace(',', '', $result['short_total']);
                                $rev_long = str_replace(',', '', $result['long_total']);
                                $rev_cost = php72_num($rev_equity) + php72_num($rev_grand) + php72_num($rev_short) + php72_num($rev_long);
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_cost = php72_num($actual_equity) + php72_num($actual_grand) + php72_num($actual_short) + php72_num($actual_long);
                                $hc_actual[$m] = $actual_cost;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            $quarter_qone = $quarter_qtwo = $quarter_qthree = $quarter_qfour = array();

            $getFrom_year = $from_year;
            if (php72_cmp($from_quarter) == 1) {
                $start_month = reset($q1);
            } else if (php72_cmp($from_quarter) == 2) {
                $start_month = reset($q2);
            } else if (php72_cmp($from_quarter) == 3) {
                $start_month = reset($q3);
            } else if (php72_cmp($from_quarter) == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if (php72_cmp($to_quarter) == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($to_quarter) == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($to_quarter) == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($to_quarter) == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter[] = "t1.financial_year >= $from_year and t1.financial_year <= $getTo_year";
            $quarter_where = implode(" and ", $search_quarter);

            $monthly_target = $this->Mportfolio->getTargetCapital($quarter_where);
            $monthly_actual = $this->Mportfolio->getActualCapital($quarter_where);
            $mr = 0;

            if (php72_count($monthly_target) > 0) {

                foreach ($monthly_target as $key => $value) {
                    foreach ($date_diff as $keys => $values) {

                        $yearvalues = explode('-', $values);
                        if (php72_in_array($yearvalues[0], $q4)) {
                            if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                                $yearvalues[1] = $yearvalues[1] - 1;
                            }
                        } else {
                            $yearvalues[1] = $yearvalues[1];
                        }
                        if ($yearvalues[1] == $value['financial_year']) {
                            $datavalues = json_decode($value['data'], TRUE);
                            if (php72_array_key_exists($yearvalues[0], $datavalues)) {

                            } else {

                                if (php72_in_array($yearvalues[0], $q1)) {
                                    $cost = str_replace(',', '', $datavalues['qone']);
                                    if (isset($quarter_qone[$mr])) {
                                        $ss = isset($quarter_qone[$mr]) && $quarter_qone[$mr] != '' ? $quarter_qone[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = php72_array_sum($quarter_qone);
                                    } else {
                                        $quarter_qone[$mr] = $cost;
                                        $search_array[$values] = php72_array_sum($quarter_qone);
                                    }
                                } else if (php72_in_array($yearvalues[0], $q2)) {
                                    $cost = str_replace(',', '', $datavalues['qtwo']);
                                    if (isset($quarter_qtwo[$mr])) {
                                        $ss = isset($quarter_qtwo[$mr]) && $quarter_qtwo[$mr] != '' ? $quarter_qtwo[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = php72_array_sum($quarter_qtwo);
                                    } else {
                                        $quarter_qtwo[$mr] = $cost;
                                        $search_array[$values] = php72_array_sum($quarter_qtwo);
                                    }
                                } else if (php72_in_array($yearvalues[0], $q3)) {
                                    $cost = str_replace(',', '', $datavalues['qthree']);
                                    if (isset($quarter_qthree[$mr])) {
                                        $ss = isset($quarter_qthree[$mr]) && $quarter_qthree[$mr] != '' ? $quarter_qthree[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = php72_array_sum($quarter_qthree);
                                    } else {
                                        $quarter_qthree[$mr] = $cost;
                                        $search_array[$values] = php72_array_sum($quarter_qthree);
                                    }
                                } else if (php72_in_array($yearvalues[0], $q4)) {
                                    $cost = str_replace(',', '', $datavalues['qfour']);
                                    if (isset($quarter_qfour[$mr])) {
                                        $ss = isset($quarter_qfour[$mr]) && $quarter_qfour[$mr] != '' ? $quarter_qfour[$mr] : ($cost != '' ? $cost : 0);
                                        $search_array[$values] = array_sum($quarter_qfour);
                                    } else {
                                        $quarter_qfour[$mr] = $cost;
                                        $search_array[$values] = array_sum($quarter_qfour);
                                    }
                                }
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                    $mr++;
                }
            } else {
                foreach ($date_diff as $keys => $values) {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    $q4 = $this->quarter4();
                    $q4_key = php72_array_keys($q4);
                    if (in_array($var['month'], $q4_key)) {
                        if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                            $prev_split_yr = $split_year - 1;
                            return ($var['financial_year'] == $prev_split_yr);
                        }
                    } else {
                        return ($var['financial_year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_cost = php72_num($actual_equity) + php72_num($actual_grand) + php72_num($actual_short) + php72_num($actual_long);
                                $rev_equity = str_replace(',', '', $result['equity_total']);
                                $rev_grand = str_replace(',', '', $result['grand_total']);
                                $rev_short = str_replace(',', '', $result['short_total']);
                                $rev_long = str_replace(',', '', $result['long_total']);
                                $rev_cost = php72_num($rev_equity) + php72_num($rev_grand) + php72_num($rev_short) + php72_num($rev_long);
                                $fetch_target[$m]['actual'] += php72_num($actual_cost);
                            } else {
                                $actual_equity = str_replace(',', '', $value['equity_total']);
                                $actual_grand = str_replace(',', '', $value['grand_total']);
                                $actual_short = str_replace(',', '', $value['short_total']);
                                $actual_long = str_replace(',', '', $value['long_total']);
                                $actual_cost = php72_num($actual_equity) + php72_num($actual_grand) + php72_num($actual_short) + php72_num($actual_long);
                                $fetch_target[$m]['actual'] = $actual_cost;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }

            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);
            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] = $value['target'];
                    $hc_actual[$q] += php72_num($value['actual']);
                }
            }
        } else {
            $capital_target = $this->Mportfolio->getTargetCapital($default_where);
            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($capital_target) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($capital_target as $target) {
                        $get_data = json_decode($target['data']);
                        foreach ($get_data as $key => $value) {
                            if (php72_in_array($key, $q1)) {
                                $q1_val += php72_num(str_replace(',', '', $value));
                                $hc_target[0] = $q1_val;
                            }
                            if (php72_in_array($key, $q2)) {
                                $q2_val += php72_num(str_replace(',', '', $value));
                                $hc_target[1] = $q2_val;
                            }
                            if (php72_in_array($key, $q3)) {
                                $q3_val += php72_num(str_replace(',', '', $value));
                                $hc_target[2] = $q3_val;
                            }
                            if (php72_in_array($key, $q4)) {
                                $q4_val += php72_num(str_replace(',', '', $value));
                                $hc_target[3] = $q4_val;
                            }
                        }
                    }

                    $annual_target = php72_num($q1_val) + php72_num($q2_val) + php72_num($q3_val) + php72_num($q4_val);
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($capital_target as $target) {
                        $get_data = json_decode($target['data']);
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $target_month_value[$value] += php72_num(str_replace(',', '', $get_data->$value));
                            $categories[$k] = $value;
                            $hc_actual[$k] = '0';
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && php72_cmp($g_quarter) != 5) {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $capital_actual = $this->Mportfolio->getActualCapital($default_where);
            $actual_month_value = $actual_month_equity = $actual_month_short = $actual_month_long = array();
            if (php72_count($capital_actual) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($capital_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_equity += php72_num(str_replace(',', '', $actual['equity_total']));
                            $a1_grand += php72_num(str_replace(',', '', $actual['grand_total']));
                            $a1_short += php72_num(str_replace(',', '', $actual['short_total']));
                            $a1_long += php72_num(str_replace(',', '', $actual['long_total']));
                            $a1_val = $a1_equity + $a1_grand + $a1_short + $a1_long;
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_equity += php72_num(str_replace(',', '', $actual['equity_total']));
                            $a2_grand += php72_num(str_replace(',', '', $actual['grand_total']));
                            $a2_short += php72_num(str_replace(',', '', $actual['short_total']));
                            $a2_long += php72_num(str_replace(',', '', $actual['long_total']));
                            $a2_val = $a2_equity + $a2_grand + $a2_short + $a2_long;
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_equity += php72_num(str_replace(',', '', $actual['equity_total']));
                            $a3_grand += php72_num(str_replace(',', '', $actual['grand_total']));
                            $a3_short += php72_num(str_replace(',', '', $actual['short_total']));
                            $a3_long += php72_num(str_replace(',', '', $actual['long_total']));
                            $a3_val = $a3_equity + $a3_grand + $a3_short + $a3_long;
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_equity += php72_num(str_replace(',', '', $actual['equity_total']));
                            $a4_grand += php72_num(str_replace(',', '', $actual['grand_total']));
                            $a4_short += php72_num(str_replace(',', '', $actual['short_total']));
                            $a4_long += php72_num(str_replace(',', '', $actual['long_total']));
                            $a4_val = $a4_equity + $a4_grand + $a4_short + $a4_long;
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    foreach ($capital_actual as $actual) {
                        foreach ($main_quarter as $key => $value) {
                            if ($key == $actual['month']) {
                                $actual_month_equity[$value] += php72_num(str_replace(',', '', $actual['equity_total']));
                                $actual_month_grand[$value] += php72_num(str_replace(',', '', $actual['grand_total']));
                                $actual_month_short[$value] += php72_num(str_replace(',', '', $actual['short_total']));
                                $actual_month_long[$value] += php72_num(str_replace(',', '', $actual['long_total']));
                                $actual_month_value[$value] += $actual_month_equity[$value] + $actual_month_grand[$value] + $actual_month_short[$value] + $actual_month_long[$value];
                            }
                        }
                    }
                    $k = 0;
                    foreach ($actual_month_value as $mv => $mv_amt) {
                        $hc_actual[$k] = $mv_amt;
                        $k++;
                    }
                    $hc_actual[3] = php72_array_sum($actual_month_value);
                }
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'capitalDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allCapital_HC');
    }

    public function allSeedFund() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $findQuarter = $this->allQuarter();

        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $q1_val = $q2_val = $q3_val = $q4_val = 0;

        $q1_key = php72_array_keys($q1);
        $q2_key = php72_array_keys($q2);
        $q3_key = php72_array_keys($q3);
        $q4_key = php72_array_keys($q4);

        $a1_val = $a2_val = $a3_val = $a4_val = 0;

        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $from_quarter = $this->input->post('f_quarter');
        $to_quarter = $this->input->post('t_quarter');
        $from_year = $this->input->post('f_year');
        $to_year = $this->input->post('t_year');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $get_end_year = $this->Mportfolio->getFYtoYear($partner_id, $from_year);
        $nxt_year = $get_end_year[0]['fin_to_year'];

        $search_target_where = $search_actual_where = $search_month = $search_actual = $search_quarter = array();

        if ($g_sector != '') {
            $search_target_where[] = $search_actual_where[] = $search_month[] = $search_actual[] = $search_quarter[] = $search_quarter_target[] = $search_quarter_actual[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }
        if ($g_year != '' || $g_quarter != '') {
            $g_getFrom_year = $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
                $g_getTo_year = $nxt_year;
            } else {
                $g_start_month = reset($q1);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
                $g_getTo_year = $nxt_year;
            }

            $g_StartDate = $g_getFrom_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $search_target_where[] = "t1.month >= '" . $g_StartDate . " 00:00:00' and t1.month <= '" . $g_StopDate . " 23:59:59'";
            $search_actual_where[] = "t1.disburse_date >= '" . $g_StartDate . " 00:00:00' and t1.disburse_date <= '" . $g_StopDate . " 23:59:59'";
        }

        if ($inv_id != '') {
            $search_target_where[] = $search_actual_where[] = $search_quarter_target[] = $search_quarter_actual[] = $search_month[] = $search_actual[] = $search_quarter[] = "t1.inv_id = $inv_id";
        }

        $default_target_where = php72_implode(" and ", $search_target_where);
        $default_actual_where = php72_implode(" and ", $search_actual_where);

        $search_array = $last_target = array();
        $categories = $hc_target = $hc_actual = array();

        if (php72_cmp($type) == 1) {
            $start_year = explode(', ', $start_date);
            $end_year = explode(', ', $end_date);

            $StartDate = $start_year[1] . '-' . date('m', strtotime($start_year[0])) . '-01';
            $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
            $date_diff = $this->get_months($StartDate, $StopDate);

            $search_month[] = "t1.month >= '$StartDate' and t1.month <= '$StopDate'";
            $search_actual[] = "t1.disburse_date >= '$StartDate 00:00:00' and t1.disburse_date <= '$StopDate 23:59:59'";
            $month_where = php72_implode(" and ", $search_month);
            $month_actual = php72_implode(" and ", $search_actual);
// $search_month[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";

            $monthly_target = $this->Mportfolio->getTargetSeedFund($month_where);
            $monthly_actual = $this->Mportfolio->getActualSeedFund($month_actual);
			#echo'<pre>';print_r($monthly_target);die;
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $value) {
                        $q4 = $this->quarter4();
                        $q4_key = php72_array_keys($q4);
                        if (in_array($value['month'], $q4_key)) {
                            if (php72_cmp($value['month']) == 1 || php72_cmp($value['month']) == 2 || php72_cmp($value['month']) == 3) {
                                $value['year'] = $value['year'] - 1;
                            }
                        } else {
                            $value['year'] = $value['year'];
                        }
                        if ($yearvalues[1] == $value['year']) {
                            $datavalues = date("M", mktime(0, 0, 0, $value['month'], 1));
                            if ($yearvalues[0] == $datavalues) {
                                $cost = str_replace(',', '', $value['amount']);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
            foreach ($search_array as $k => $name) {
                $categories[$m] = $k;
                $hc_target[$m] = isset($name) && $name != '' ? $name : 0;
                $split = explode('-', $k);
                $plan_month = date('n', strtotime("$split[0] 1 2020"));
                $split_year = $split[1];
//                if ($plan_month == 1 || $plan_month == 2 || $plan_month == 3) {
//                    $split_year = $split_year - 1;
//                } else {
//                    $split_year = $split_year;
//                }

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                        $prev_split_yr = $split_year;
                        return ($var['year'] == $prev_split_yr);
                    } else {
                        return ($var['year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['disburse_amount']);
                                $rev_cost = str_replace(',', '', $result['disburse_amount']);
                                $hc_actual[$m] += php72_num($actual_cost);
                            } else {
                                $hc_actual[$m] = isset($value['disburse_amount']) && $value['disburse_amount'] != '' ? str_replace(',', '', $value['disburse_amount']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $hc_actual[$m] = isset($hc_actual[$m]) && $hc_actual[$m] != '' ? $hc_actual[$m] : 0;
                }
                $m++;
            }
        } else if (php72_cmp($type) == 2) {
            $getFrom_year = $from_year;
            if (php72_cmp($from_quarter) == 1) {
                $start_month = reset($q1);
            } else if (php72_cmp($from_quarter) == 2) {
                $start_month = reset($q2);
            } else if (php72_cmp($from_quarter) == 3) {
                $start_month = reset($q3);
            } else if (php72_cmp($from_quarter) == 4) {
                $start_month = reset($q4);
                $getFrom_year = $from_year + 1;
            }

            $getTo_year = $to_year;
            if (php72_cmp($to_quarter) == 1) {
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($to_quarter) == 2) {
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($to_quarter) == 3) {
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($to_quarter) == 4) {
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $end_month = $q4[$q4_keyVal];
                $getTo_year = $nxt_year;
            }

            $q_StartDate = $getFrom_year . '-' . date('m', strtotime($start_month)) . '-01';
            $q_StopDate = date("Y-m-t", strtotime($getTo_year . '-' . date('m', strtotime($end_month))));
            $date_diff = $this->get_months($q_StartDate, $q_StopDate);

            $search_quarter_target[] = "t1.month >= '" . $q_StartDate . "' and t1.month <= '" . $q_StopDate . "'";
            $search_quarter_actual[] = "t1.disburse_date >= '" . $q_StartDate . "' and t1.disburse_date <= '" . $q_StopDate . "'";

            $quarter_target = php72_implode(" and ", $search_quarter_target);
            $quarter_actual = php72_implode(" and ", $search_quarter_actual);

            $monthly_target = $this->Mportfolio->getTargetSeedFund($quarter_target);
            $monthly_actual = $this->Mportfolio->getActualSeedFund($quarter_actual);
            foreach ($date_diff as $keys => $values) {
                $yearvalues = explode('-', $values);
                if (php72_in_array($yearvalues[0], $q4)) {
                    if ($yearvalues[0] == 'Jan' || $yearvalues[0] == 'Feb' || $yearvalues[0] == 'Mar') {
                        $yearvalues[1] = $yearvalues[1] - 1;
                    }
                } else {
                    $yearvalues[1] = $yearvalues[1];
                }
                if (php72_count($monthly_target) > 0) {
                    foreach ($monthly_target as $key => $value) {
                        $q4 = $this->quarter4();
                        $q4_key = php72_array_keys($q4);
                        if (in_array($value['month'], $q4_key)) {
                            if (php72_cmp($value['month']) == 1 || php72_cmp($value['month']) == 2 || php72_cmp($value['month']) == 3) {
                                $value['year'] = $value['year'] - 1;
                            }
                        } else {
                            $value['year'] = $value['year'];
                        }
                        if ($yearvalues[1] == $value['year']) {
                            $datavalues = date("M", mktime(0, 0, 0, $value['month'], 1));
                            if ($yearvalues[0] == $datavalues) {
                                $cost = str_replace(',', '', $value['amount']);
                                if (php72_array_key_exists($values, $search_array)) {
                                    $search_array[$values] = $search_array[$values] + php72_num($cost);
                                } else {
                                    $search_array[$values] = $cost;
                                }
                            } else {
                                $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                            }
                        } else {
                            $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                        }
                        $i++;
                    }
                } else {
                    $search_array[$values] = isset($search_array[$values]) && $search_array[$values] != '' ? $search_array[$values] : 0;
                }
            }

            $m = 0;
//            print_r($search_array);
            foreach ($search_array as $k => $name) {
// $fetch_target[$m]['name'] = $k;
                $split = explode('-', $k);
                $split_year = $split[1];
                $axis_name = php72_array_search($split[0], $findQuarter);
                if ($axis_name == 'Q4') {
                    $q_year = $split_year - 1;
                } else {
                    $q_year = $split_year;
                }
                $fetch_target[$m]['name'] = $axis_name . '-' . $q_year;
                $fetch_target[$m]['target'] = $name;
                $plan_month = date('n', strtotime("$split[0] 1 2020"));

                $new_fy = php72_array_filter($monthly_actual, function ($var) use ($split_year) {
                    if (php72_cmp($var['month']) == 1 || php72_cmp($var['month']) == 2 || php72_cmp($var['month']) == 3) {
                        $prev_split_yr = $split_year;
                        return ($var['year'] == $prev_split_yr);
                    } else {
                        return ($var['year'] == $split_year);
                    }
                });

                $new_m = array_filter($new_fy, function ($var) use ($plan_month) {
                    return ($var['month'] == $plan_month);
                });

                $result = '';
                if (count($new_m) > 0) {
                    foreach ($new_m as $key => $value) {
                        if (is_array($value)) {
                            if ($result['month'] == $value['month']) {
                                $actual_cost = str_replace(',', '', $value['disburse_amount']);
                                $rev_cost = str_replace(',', '', $result['disburse_amount']);
                                $fetch_target[$m]['actual'] += php72_num($actual_cost);
                            } else {
                                $fetch_target[$m]['actual'] = isset($value['disburse_amount']) && $value['disburse_amount'] != '' ? str_replace(',', '', $value['disburse_amount']) : 0;
                            }
                            $result = $value;
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $fetch_target[$m]['actual'] = isset($fetch_target[$m]['actual']) && $fetch_target[$m]['actual'] != '' ? $fetch_target[$m]['actual'] : 0;
                }
                $m++;
            }
//            print_r($fetch_target);
            $last_target = array();
            $quarter_group = array_chunk($fetch_target, 3);

            for ($q = 0; $q <= count($quarter_group); $q++) {
                foreach ($quarter_group[$q] as $value) {
                    $inc = $q + 1;
                    $categories[$q] = $value['name'];
                    $hc_target[$q] += php72_num($value['target']);
                    $hc_actual[$q] += php72_num($value['actual']);
                }
            }
        } else {
            $seed_target = $this->Mportfolio->getTargetSeedFund($default_target_where);


            $target_month_value = array();
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';
            $hc_target[0] = $hc_target[1] = $hc_target[2] = $hc_target[3] = $hc_target[4] = '0';
            $hc_actual[0] = $hc_actual[1] = $hc_actual[2] = $hc_actual[3] = $hc_actual[4] = '0';
            if (php72_count($seed_target) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($seed_target as $target) {
                        $value = $target['amount'];
                        if (in_array($target['month'], $q1_key)) {
                            $q1_val += php72_num(str_replace(',', '', $value));
                            $hc_target[0] = $q1_val;
                        }
                        if (in_array($target['month'], $q2_key)) {
                            $q2_val += php72_num(str_replace(',', '', $value));
                            $hc_target[1] = $q2_val;
                        }
                        if (in_array($target['month'], $q3_key)) {
                            $q3_val += php72_num(str_replace(',', '', $value));
                            $hc_target[2] = $q3_val;
                        }
                        if (in_array($target['month'], $q4_key)) {
                            $q4_val += php72_num(str_replace(',', '', $value));
                            $hc_target[3] = $q4_val;
                        }
                    }

                    $annual_target = php72_num($q1_val) + php72_num($q2_val) + php72_num($q3_val) + php72_num($q4_val);
                    $categories[4] = 'Annual';
                    $hc_target[4] = $annual_target;
                } else {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($seed_target as $target) {
                        $k = 0;
                        foreach ($main_quarter as $key => $value) {
                            $categories[$k] = $value;
                            if ($target['month'] == $key) {
                                $target_month_value[$value] += php72_num(str_replace(',', '', $target['amount']));
                                $hc_actual[$k] = '0';
                            }
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($target_month_value as $tv => $tv_amt) {
                        $hc_target[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_target[3] = array_sum($target_month_value);
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            } else {
                if ($g_quarter != '' && php72_cmp($g_quarter) != 5) {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }

                    $k = 0;
                    foreach ($main_quarter as $key => $value) {
                        $categories[$k] = $value;
                        $k++;
                    }
                    $categories[3] = $quarter_title;
                    unset($categories[4]);
                    unset($hc_target[4]);
                    unset($hc_actual[4]);
                }
            }

            $seed_actual = $this->Mportfolio->getActualSeedFund($default_actual_where);
            $actual_month_value = array();
            if (php72_count($seed_actual) > 0) {
                if ($g_quarter == '' || php72_cmp($g_quarter) == 5) {
                    foreach ($seed_actual as $actual) {
                        if (in_array($actual['month'], $q1_key)) {
                            $a1_val += php72_num(str_replace(',', '', $actual['disburse_amount']));
                            $hc_actual[0] = $a1_val;
                        }
                        if (in_array($actual['month'], $q2_key)) {
                            $a2_val += php72_num(str_replace(',', '', $actual['disburse_amount']));
                            $hc_actual[1] = $a2_val;
                        }
                        if (in_array($actual['month'], $q3_key)) {
                            $a3_val += php72_num(str_replace(',', '', $actual['disburse_amount']));
                            $hc_actual[2] = $a3_val;
                        }
                        if (in_array($actual['month'], $q4_key)) {
                            $a4_val += php72_num(str_replace(',', '', $actual['disburse_amount']));
                            $hc_actual[3] = $a4_val;
                        }
                    }

                    $annual_acheive = $a1_val + $a2_val + $a3_val + $a4_val;
                    $hc_actual[4] = $annual_acheive;
                } else {
                    if (php72_cmp($g_quarter) == 1) {
                        $main_quarter = $q1;
                        $quarter_title = 'Q1';
                    } else if (php72_cmp($g_quarter) == 2) {
                        $main_quarter = $q2;
                        $quarter_title = 'Q2';
                    } else if (php72_cmp($g_quarter) == 3) {
                        $main_quarter = $q3;
                        $quarter_title = 'Q3';
                    } else if (php72_cmp($g_quarter) == 4) {
                        $main_quarter = $q4;
                        $quarter_title = 'Q4';
                    }
                    foreach ($seed_actual as $actual) {
                        $k = 0;

                        foreach ($main_quarter as $key => $value) {
                            if ($actual['month'] == $key) {
                                $actual_month_value[$value] += php72_num(str_replace(',', '', $actual['disburse_amount']));
                                $categories[$k] = $value;
                                $hc_actual[$k] = '0';
                            }
                            $k++;
                        }
                    }
                    $m = 0;
                    foreach ($actual_month_value as $tv => $tv_amt) {
                        $hc_actual[$m] = $tv_amt;
                        $m++;
                    }
                    $categories[3] = $quarter_title;
                    $hc_actual[3] = array_sum($actual_month_value);
                }
            } else {
                foreach ($seed_actual as $actual) {
                    foreach ($main_quarter as $key => $value) {
                        if ($key == $actual['month']) {
                            $actual_month_value[$value] += php72_num(str_replace(',', '', $actual['disburse_amount']));
                        }
                    }
                }
                $k = 0;
                foreach ($actual_month_value as $mv => $mv_amt) {
                    $hc_actual[$k] = $mv_amt;
                    $k++;
                }
                $hc_actual[3] = array_sum($actual_month_value);
            }
        }

        $derive_target = array();
        for ($m = 0; $m < php72_count($hc_target); $m++) {
            array_push($derive_target, round($hc_target[$m], 2));
        }

        $derive_actual = array();
        for ($m = 0; $m < count($hc_actual); $m++) {
            array_push($derive_actual, round($hc_actual[$m], 2));
        }

        ksort($categories);
        $id = $this->input->post('id');
        $data['div_id'] = 'fundingDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = array_values($derive_target);
        $data['actual_list'] = array_values($derive_actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allSeedFund_HC.php');
    }

    public function mentorNumber() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $q1 = $this->quarter1();
        $q2 = $this->quarter2();
        $q3 = $this->quarter3();
        $q4 = $this->quarter4();

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');

        $searchArray = array();

        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            if ($startDate != '' && $endDate != '') {
                $start_year = explode(', ', $startDate);
                $end_year = explode(', ', $endDate);
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));

                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                $q4 = $this->quarter4();
                $q4_key = php72_array_keys($q4);
                if (in_array($fin_smonth, $q4_key)) {
                    if (php72_cmp($fin_smonth) == 1 || php72_cmp($fin_smonth) == 2 || php72_cmp($fin_smonth) == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if (php72_cmp($fin_emonth) == 1 || php72_cmp($fin_emonth) == 2 || php72_cmp($fin_emonth) == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }
            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $searchArray = array();
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if (php72_cmp($sdatefmt) == 1 || php72_cmp($sdatefmt) == 2 || php72_cmp($sdatefmt) == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if (php72_cmp($edatefmt) == 1 || php72_cmp($edatefmt) == 2 || php72_cmp($edatefmt) == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $edate = explode(', ', $endDate);
            $to_date = date("Y-m-t", strtotime($edate[0] . ' ' . $edate[1]));
//            $searchArray[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y");
//            $searchArray[] = "t1.financial_year = $start_year[1]";
        }

        if ($g_sector != '') {
            $searchArray[] = "t2.sector = '$g_sector'";
            $sector['id'] = $g_sector;
            $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
            $data['sector_name'] = $sector_details[0]['sector'];
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }

        $where = implode(" and ", $searchArray);

        $master_list = $this->Mportfolio->getTargetMentorHours($where, $startDate, '', '1');
        $diffmon = array();
        $fin_quarters['Q1'] = 0;
        $fin_quarters['Q2'] = 0;
        $fin_quarters['Q3'] = 0;
        $fin_quarters['Q4'] = 0;

        foreach ($diffmon as $cnts) {
            $count[] = php72_count($cnts);
        }

        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();
        $ment_act = array();
        $ment_actquat['q1'] = 0;
        $ment_actquat['q2'] = 0;
        $ment_actquat['q3'] = 0;
        $ment_actquat['q4'] = 0;

        $total_list = $this->Mportfolio->getActualMentorNumber($where, $startDate, '', '1');
        $get_unique_mentor = array();

        foreach ($total_list as $tot) {
            if (!isset($ment_act[$tot['inv_id']][$tot['month']][$tot['assigned_to']])) {
                if (php72_cmp($ftype) != 1) {
                    if ($tot['month'] == '4' || $tot['month'] == '5' || $tot['month'] == '6') {
                        if (isset($ment_act[$tot['inv_id']][4][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][5][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][6][$tot['assigned_to']])) {
                            $ment_actquat['q1'] = $ment_actquat['q1'];
                        } else {
                            $ment_actquat['q1'] += 1;
                        }
                    }
                    if ($tot['month'] == '7' || $tot['month'] == '8' || $tot['month'] == '9') {
                        if (isset($ment_act[$tot['inv_id']][7][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][8][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][9][$tot['assigned_to']])) {
                            $ment_actquat['q2'] = $ment_actquat['q2'];
                        } else {
                            $ment_actquat['q2'] += 1;
                        }
                    }
                    if ($tot['month'] == '10' || $tot['month'] == '11' || $tot['month'] == '12') {
                        if (isset($ment_act[$tot['inv_id']][10][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][11][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][12][$tot['assigned_to']])) {
                            $ment_actquat['q3'] = $ment_actquat['q3'];
                        } else {
                            $ment_actquat['q3'] += 1;
                        }
                    }
                    if ($tot['month'] == '1' || $tot['month'] == '2' || $tot['month'] == '3') {
                        if (isset($ment_act[$tot['inv_id']][1][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][2][$tot['assigned_to']]) || isset($ment_act[$tot['inv_id']][3][$tot['assigned_to']])) {
                            $ment_actquat['q4'] = $ment_actquat['q4'];
                        } else {
                            $ment_actquat['q4'] += 1;
                        }
                    }
                    $ment_act[$tot['inv_id']][$tot['month']][$tot['assigned_to']] = 1;
                    $get_unique_mentor[] = $tot['assigned_to'];
                } else {
                    $t = 0;
                    foreach ($date_diff as $values) {

                        $categories[$t] = $values;
                        if (isset($ment_act[$tot['inv_id']][$values][$tot['assigned_to']])) {
                            $ment_actquat[$values] = $ment_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            if ($datavalues == $expmonth[0] && $expmonth[1] == $tot['financial_year']) {
                                $ment_actquat[$values] += 1;
                                $ment_act[$tot['inv_id']][$values][$tot['assigned_to']] = 1;
                            }
                        }
                        $t++;
                    }
                }
            }
        }


//        $target[0] = $fin_quarters['Q1'];
//        $target[1] = $fin_quarters['Q2'];
//        $target[2] = $fin_quarters['Q3'];
//        $target[3] = $fin_quarters['Q4'];
//        $target[4] = $fin_quarters['Q1'] + $fin_quarters['Q2'] + $fin_quarters['Q3'] + $fin_quarters['Q4'];

        if (php72_cmp($ftype) != 1) {
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $master_list[0]['mentorq1'];
            $target[1] = $master_list[0]['mentorq2'];
            $target[2] = $master_list[0]['mentorq3'];
            $target[3] = $master_list[0]['mentorq4'];
            $target[4] = max($target);
//            $target[4] = $master_list[0]['mentorq1'] + $master_list[0]['mentorq2'] + $master_list[0]['mentorq3'] + $master_list[0]['mentorq4'];

            $actual[0] = $ment_actquat['q1'];
            $actual[1] = $ment_actquat['q2'];
            $actual[2] = $ment_actquat['q3'];
            $actual[3] = $ment_actquat['q4'];
            $actual[4] = count(array_unique($get_unique_mentor));
//            $actual[4] = $ment_actquat['q1'] + $ment_actquat['q2'] + $ment_actquat['q3'] + $ment_actquat['q4'];
        } else {
            $t = 0;
            foreach ($date_diff as $values) {
                $categories[$t] = $values;
                $t++;
            }
            $ac = 0;
            foreach ($categories as $cate) {

                $actual[$ac] = $ment_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }

                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            if (php72_in_array($tar_mnths[0], $q1)) {
                                $target[$ac] = $mas_tar['mentorq1'];
                            } else if (php72_in_array($tar_mnths[0], $q2)) {
                                $target[$ac] = $mas_tar['mentorq2'];
                            } else if (php72_in_array($tar_mnths[0], $q3)) {
                                $target[$ac] = $mas_tar['mentorq3'];
                            } else if (php72_in_array($tar_mnths[0], $q4)) {
                                $target[$ac] = $mas_tar['mentorq4'];
                            }
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }

                $ac++;
            }
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'mentorNumber_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['ftype'] = $ftype;
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allMentorNumber_HC.php');
    }

    public function mentorHour() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));

                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if (php72_cmp($fin_smonth) == 1 || php72_cmp($fin_smonth) == 2 || php72_cmp($fin_smonth) == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if (php72_cmp($fin_emonth) == 1 || php72_cmp($fin_emonth) == 2 || php72_cmp($fin_emonth) == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }
            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $searchArray = array();
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if (php72_cmp($sdatefmt) == 1 || php72_cmp($sdatefmt) == 2 || php72_cmp($sdatefmt) == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if (php72_cmp($edatefmt) == 1 || php72_cmp($edatefmt) == 2 || php72_cmp($edatefmt) == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $edate = explode(', ', $endDate);
            $to_date = date("Y-m-t", strtotime($edate[0] . ' ' . $edate[1]));
//            $searchArray[] = "t1.financial_year >= $start_year[1] and t1.financial_year <= $end_year[1]";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y");
//            $searchArray[] = "t1.financial_year = $start_year[1]";
        }

        if ($g_sector != '') {
            $searchArray[] = "t2.sector = '$g_sector'";
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }

        $where = implode(" and ", $searchArray);
        $master_list = $this->Mportfolio->getTargetMentorHours($where, $startDate, '', '1');
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();

        if (php72_cmp($ftype) != 1) {
            $total_list = $this->Mportfolio->getActualMentorHours($where, $startDate, '', '1');
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $master_list[0]['q1'];
            $target[1] = $master_list[0]['q2'];
            $target[2] = $master_list[0]['q3'];
            $target[3] = $master_list[0]['q4'];
            $target[4] = $master_list[0]['q1'] + $master_list[0]['q2'] + $master_list[0]['q3'] + $master_list[0]['q4'];

            $actual[0] = isset($total_list[0]['q1']) && $total_list[0]['q1'] != '' ? $total_list[0]['q1'] : 0;
            $actual[1] = isset($total_list[0]['q2']) && $total_list[0]['q2'] != '' ? $total_list[0]['q2'] : 0;
            $actual[2] = isset($total_list[0]['q3']) && $total_list[0]['q3'] != '' ? $total_list[0]['q3'] : 0;
            $actual[3] = isset($total_list[0]['q4']) && $total_list[0]['q4'] != '' ? $total_list[0]['q4'] : 0;
            $actual[4] = $total_list[0]['q1'] + $total_list[0]['q2'] + $total_list[0]['q3'] + $total_list[0]['q4'];
        } else {
            $ment_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualMentorHours($where, $startDate, '', '1');
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {

                        $categories[$t] = $values;
                        if (isset($ment_act[$values])) {
                            $ment_actquat[$values] = $ment_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];
                            if ($datavalues == $expmonth[0] && $tot['financial_year'] == $expmonth[1]) {
                                $ment_actquat[$values] = $tot['hours'];
                                $ment_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }

            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $ment_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {

                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            if (php72_in_array($tar_mnths[0], $q1)) {
                                $target[$ac] = round(($mas_tar['q1'] / 3), 2);
                            } else if (php72_in_array($tar_mnths[0], $q2)) {
                                $target[$ac] = round(($mas_tar['q2'] / 3), 2);
                            } else if (php72_in_array($tar_mnths[0], $q3)) {
                                $target[$ac] = round(($mas_tar['q3'] / 3), 2);
                            } else if (php72_in_array($tar_mnths[0], $q4)) {
                                $target[$ac] = round(($mas_tar['q4'] / 3), 2);
                            }
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'mentorHour_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $data['ftype'] = $ftype;
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allMentorHour_HC.php');
    }

    public function dpMeeting() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        $get_fy_month = $this->month();
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $ftype = $this->input->post('type');
        $g_sector = $this->input->post('sector');
        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;
        $g_quarter = $this->input->post('quarter');

        $inv_id = $this->input->post('inv_id');
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');

        $searchArray = array();
        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);
        if ($g_year != '' || $g_quarter != '') {
            $g_getTo_year = $g_year;
            if (php72_cmp($g_quarter) == 1) {
                $g_start_month = reset($q1);
                $q1_arr = php72_array_slice($q1, 2, 2, true);
                $q1_key = array_keys($q1_arr);
                $q1_keyVal = $q1_key[0];
                $g_end_month = $q1[$q1_keyVal];
            } else if (php72_cmp($g_quarter) == 2) {
                $g_start_month = reset($q2);
                $q2_arr = php72_array_slice($q2, 2, 2, true);
                $q2_key = array_keys($q2_arr);
                $q2_keyVal = $q2_key[0];
                $g_end_month = $q2[$q2_keyVal];
            } else if (php72_cmp($g_quarter) == 3) {
                $g_start_month = reset($q3);
                $q3_arr = php72_array_slice($q3, 2, 2, true);
                $q3_key = array_keys($q3_arr);
                $q3_keyVal = $q3_key[0];
                $g_end_month = $q3[$q3_keyVal];
            } else if (php72_cmp($g_quarter) == 4) {
                $g_start_month = reset($q4);
                $q4_arr = php72_array_slice($q4, 2, 2, true);
                $g_q4_key = array_keys($q4_arr);
                $q4_keyVal = $g_q4_key[0];
                $g_end_month = $q4[$q4_keyVal];
            }

            $g_StartDate = $g_year . '-' . date('m', strtotime($g_start_month)) . '-01';
            $g_StopDate = date("Y-m-t", strtotime($g_getTo_year . '-' . date('m', strtotime($g_end_month))));
            $g_date_diff = $this->get_months($g_StartDate, $g_StopDate);

            $q4 = $this->quarter4();
            $q4_key = php72_array_keys($q4);

            if ($startDate != '' && $endDate != '') {
                $StartDate = date("Y-m-01", strtotime($start_year[0] . ' ' . $start_year[1]));
                $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[1] . '-' . $end_year[0]))));
                $date_diff = $this->get_months($StartDate, $StopDate);
                $fin_smonth = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
                $fin_emonth = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
                if (in_array($fin_smonth, $q4_key)) {
                    if (php72_cmp($fin_smonth) == 1 || php72_cmp($fin_smonth) == 2 || php72_cmp($fin_smonth) == 3) {
                        $g_year = $g_year - 1;
                    }
                }

                if (in_array($fin_emonth, $q4_key)) {
                    if (php72_cmp($fin_emonth) == 1 || php72_cmp($fin_emonth) == 2 || php72_cmp($fin_emonth) == 3) {
                        $g_getTo_year = $end_year[1] - 1;
                    }
                }
            }

            $fin_whr = "t1.financial_year >= $g_year and t1.financial_year <= $g_getTo_year";
        }
        if ($startDate != '') {
            $sdate = explode(', ', $startDate);
            $from_date = date("Y-m-01", strtotime($sdate[0] . ' ' . $sdate[1]));
            $sdatefmt = date("n", strtotime($start_year[0] . ' ' . $start_year[1]));
            $edatefmt = date('n', strtotime($end_year[1] . '-' . $end_year[0]));
            if (in_array($sdatefmt, $q4_key)) {
                if (php72_cmp($sdatefmt) == 1 || php72_cmp($sdatefmt) == 2 || php72_cmp($sdatefmt) == 3) {
                    $st_year = $start_year[1] - 1;
                }
            }

            if (in_array($edatefmt, $q4_key)) {
                if (php72_cmp($edatefmt) == 1 || php72_cmp($edatefmt) == 2 || php72_cmp($edatefmt) == 3) {
                    $end_yr = $end_year[1] - 1;
                }
            } else {
                $end_yr = $end_year[1];
            }
            if (!isset($fin_whr) || $fin_whr == '') {
                $searchArray[] = "t1.financial_year >= $st_year and t1.financial_year <= $end_yr";
            } else {
                $searchArray[] = $fin_whr;
            }
        } else {
            $searchArray[] = $fin_whr;
        }

        if ($endDate != '') {
            $to_date = date("Y-m-d", strtotime($endDate));
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($startDate != '' && $endDate == '') {
            $to_date = date("Y-m-d");
//            $searchArray[] = "t1.created_at < '$to_date 23:59:59'";
        }

        if ($g_sector != '') {
            $searchArray[] = "t2.sector = '$g_sector'";
        }

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }
        $where = implode(" and ", $searchArray);

        $q1_val = $q2_val = $q3_val = $q4_val = 0;
        $master_list = $this->Mportfolio->getTargetDpMeeting($where, $startDate, '', '1');
        $categories = $target = $actual = array();
        $actualMonth = $this->actual_month();

        if (php72_cmp($ftype) != 1) {
            $total_list = $this->Mportfolio->getActualDpMeeting($where, $startDate, '', '1');
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            foreach ($master_list as $dp) {
                $getdata = json_decode($dp['dp_plan']);
                foreach ($getdata as $key => $value) {
                    if ($key == 'q1') {
                        $q1_val += php72_num(str_replace(',', '', $value));
                        $target[0] = $q1_val;
                        $actual[0] = '0';
                    }
                    if ($key == 'q2') {
                        $q2_val += php72_num(str_replace(',', '', $value));
                        $target[1] = $q2_val;
                        $actual[1] = '0';
                    }
                    if ($key == 'q3') {
                        $q3_val += php72_num(str_replace(',', '', $value));
                        $target[2] = $q3_val;
                        $actual[2] = '0';
                    }
                    if ($key == 'q4') {
                        $q4_val += php72_num(str_replace(',', '', $value));
                        $target[3] = $q4_val;
                        $actual[3] = '0';
                    }
                }
            }

            $annual_target = php72_num($q1_val) + php72_num($q2_val) + php72_num($q3_val) + php72_num($q4_val);
            $categories[4] = 'Annual';
            $target[4] = $annual_target;

            $actual[0] = $total_list[0]['q1'];
            $actual[1] = $total_list[0]['q2'];
            $actual[2] = $total_list[0]['q3'];
            $actual[3] = $total_list[0]['q4'];
            $actual[4] = $total_list[0]['annual'];
        } else {
            $dps_act = array();
            $total_list = $this->Mportfolio->getMonthlyActualDpMeeting($where, $startDate, '', '1');
            if (php72_count($total_list) > 0) {
                foreach ($total_list as $tot) {
                    $t = 0;
                    foreach ($date_diff as $values) {
                        $categories[$t] = $values;
                        if (isset($dps_act[$values])) {
                            $dp_actquat[$values] = $dp_actquat[$values];
                        } else {
                            $expmonth = explode('-', $values);
                            $datavalues = date("M", mktime(0, 0, 0, $tot['month'], 1));
                            $finyr = $datavalues . '-' . $tot['financial_year'];

                            if (php72_in_array($expmonth[0], $q4)) {
                                if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                    $expmonth[1] = $expmonth[1] - 1;
                                }
                            } else {
                                $expmonth[1] = $expmonth[1];
                            }
                            $check_month = $expmonth[0] . '-' . $expmonth[1];
                            if ($datavalues == $expmonth[0] && $finyr == $check_month) {
                                $dp_actquat[$values] = $tot['dps'];
                                $dps_act[$values] = 1;
                            }
                        }
                        $t++;
                    }
                }
            } else {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
            $ac = 0;
            foreach ($categories as $cate) {
                $actual[$ac] = $dp_actquat[$cate];
                $tar_mnths = explode('-', $cate);
                if (php72_in_array($tar_mnths[0], $q4)) {
                    if ($tar_mnths[0] == 'Jan' || $tar_mnths[0] == 'Feb' || $tar_mnths[0] == 'Mar') {
                        $tar_mnths[1] = $tar_mnths[1] - 1;
                    }
                } else {
                    $tar_mnths[1] = $tar_mnths[1];
                }
                if (php72_count($master_list) > 0) {
                    foreach ($master_list as $mas_tar) {
                        if ($mas_tar['financial_year'] == $tar_mnths[1]) {
                            $getdata = json_decode($mas_tar['dp_plan']);

                            foreach ($getdata as $key => $value) {
                                if ($key == 'q1') {
                                    $q1_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q2') {
                                    $q2_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q3') {
                                    $q3_val = str_replace(',', '', $value);
                                }
                                if ($key == 'q4') {
                                    $q4_val = str_replace(',', '', $value);
                                }
                            }

                            /* changed to last month of quarter - datemodified - 12/12/2019 */
                            if ($tar_mnths[0] == $get_fy_month[2]) {
                                $target[$ac] += php72_num($q1_val);
                            } else if ($tar_mnths[0] == $get_fy_month[5]) {
                                $target[$ac] += php72_num($q2_val);
                            } else if ($tar_mnths[0] == $get_fy_month[8]) {
                                $target[$ac] += php72_num($q3_val);
                            } else if ($tar_mnths[0] == $get_fy_month[11]) {
                                $target[$ac] += php72_num($q4_val);
                            } else {
                                $target[$ac] = 0;
                            }
                            /* end of changes */
                        } else {
                            $target[$ac] = $target[$ac];
                        }
                    }
                } else {
                    $target[$ac] = 0;
                }
                $ac++;
            }
        }
        $id = $this->input->post('id');
        $data['div_id'] = 'dpMeeting_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allDpMeeting_HC.php');
    }

    public function Tap() {
        $partner_id = $this->session->userdata('partner_id');
        $sel_year = $this->input->post('year');
        if (isset($sel_year) && $sel_year != '') {
            $this->session->set_userdata('portfolio_summary_year', $sel_year);
        }
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if (php72_cmp($fy['status']) == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $inv_id = $this->input->post('inv_id');
        $type = $this->input->post('type');
        $sector = $this->input->post('sector');
        $sector_id = $this->input->post('sector_id');

        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');

        $from_quarter = $this->input->post('f_quarter');
        $to_quarter = $this->input->post('t_quarter');
        $from_year = $this->input->post('f_year');
        $to_year = $this->input->post('t_year');
        $g_quarter = $this->input->post('quarter');

        $g_year = isset($sel_year) && $sel_year != '' ? $sel_year : $f_year;

        $searchArray = array();

        $search_target_where = $search_actual_where = $search_month = $search_actual = $search_quarter = array();

        if ($sector_id != '') {
            $searchArray[] = "t2.sector IN ($sector_id)";
        } else if ($sector != '') {
            $searchArray[] = "t2.sector IN ($sector)";
        }

        $start_year = explode(', ', $startDate);
        $end_year = explode(', ', $endDate);

        if ($inv_id != '') {
            $searchArray[] = "t1.inv_id = $inv_id";
        }

        $where = implode(" and ", $searchArray);

        $StartDate = date("Y-m-01", strtotime($start_year[1] . '-' . date('m', strtotime($start_year[0]))));
        $StopDate = date("Y-m-t", strtotime($end_year[1] . '-' . date('m', strtotime($end_year[0]))));
        $date_diff = $this->get_months($StartDate, $StopDate);
        $categories = $target = $actual = array();
        $tap_act = $tap_tar = array();
        $tap_tarquat['q1'] = 0;
        $tap_tarquat['q2'] = 0;
        $tap_tarquat['q3'] = 0;
        $tap_tarquat['q4'] = 0;
        $tap_actquat['q1'] = 0;
        $tap_actquat['q2'] = 0;
        $tap_actquat['q3'] = 0;
        $tap_actquat['q4'] = 0;

        if (php72_cmp($type) == 1) {
            $search_month = "t1.need_by >= '$StartDate 00:00:00' and t1.need_by <= '$StopDate 23:59:59'";
            $search_actual = "t1.month_engaged >= '$StartDate 00:00:00' and t1.month_engaged <= '$StopDate 23:59:59'";

            $targetlist = $this->Mportfolio->getTargetTap($where, $g_year, $search_month);
            $actuallist = $this->Mportfolio->getActualTap($where, $g_year, $search_actual);
            foreach ($targetlist as $list) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    if (isset($tap_tar[$values][$list['financial_year']])) {
                        $tap_tarquat[$values] = $tap_tarquat[$values];
                    } else {
                        $expmonth = explode('-', $values);
                        if (php72_in_array($expmonth[0], $q4)) {
                            if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                $expmonth[1] = $expmonth[1] - 1;
                            }
                        } else {
                            $expmonth[1] = $expmonth[1];
                        }
                        if ($expmonth[1] == $list['financial_year']) {
                            if ($expmonth[0] == 'Dec') {
                                $expmonth[0] = 'dec';
                            }
                            $tap_tarquat[$values] = $list[strtolower($expmonth[0])];
                            $tap_tar[$values][$list['financial_year']] = 1;
                        }
                    }
                    $t++;
                }
            }
            foreach ($actuallist as $actlist) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    if (isset($tap_act[$values][$actlist['financial_year']])) {
                        $tap_actquat[$values] = $tap_actquat[$values];
                    } else {
                        $expmonth = explode('-', $values);
                        if (php72_in_array($expmonth[0], $q4)) {
                            if ($expmonth[0] == 'Jan' || $expmonth[0] == 'Feb' || $expmonth[0] == 'Mar') {
                                $expmonth[1] = $expmonth[1] - 1;
                            }
                        } else {
                            $expmonth[1] = $expmonth[1];
                        }
                        if ($expmonth[1] == $actlist['financial_year']) {
                            if ($expmonth[0] == 'Dec') {
                                $expmonth[0] = 'dec';
                            }
                            $tap_actquat[$values] = $actlist[strtolower($expmonth[0])];
                            $tap_act[$values][$actlist['financial_year']] = 1;
                        }
                    }
                    $t++;
                }
            }

            if (php72_count($targetlist) == 0 && php72_count($actuallist) == 0) {
                $t = 0;
                foreach ($date_diff as $values) {
                    $categories[$t] = $values;
                    $t++;
                }
            }
        } else {
            $targetlist = $this->Mportfolio->getTargetTap($where, $g_year);
            $actuallist = $this->Mportfolio->getActualTap($where, $g_year);
            foreach ($targetlist as $list) {
                $tap_tarquat['q1'] += $list[strtolower($get_fy_month[0])] + $list[strtolower($get_fy_month[1])] + $list[strtolower($get_fy_month[2])];
                $tap_tarquat['q2'] += $list[strtolower($get_fy_month[3])] + $list[strtolower($get_fy_month[4])] + $list[strtolower($get_fy_month[5])];
                $tap_tarquat['q3'] += $list[strtolower($get_fy_month[6])] + $list[strtolower($get_fy_month[7])] + $list[strtolower($get_fy_month[8])];
                $tap_tarquat['q4'] += $list[strtolower($get_fy_month[9])] + $list[strtolower($get_fy_month[10])] + $list[strtolower($get_fy_month[11])];
            }
            foreach ($actuallist as $actlist) {
                $tap_actquat['q1'] += $actlist[strtolower($get_fy_month[0])] + $actlist[strtolower($get_fy_month[1])] + $actlist[strtolower($get_fy_month[2])];
                $tap_actquat['q2'] += $actlist[strtolower($get_fy_month[3])] + $actlist[strtolower($get_fy_month[4])] + $actlist[strtolower($get_fy_month[5])];
                $tap_actquat['q3'] += $actlist[strtolower($get_fy_month[6])] + $actlist[strtolower($get_fy_month[7])] + $actlist[strtolower($get_fy_month[8])];
                $tap_actquat['q4'] += $actlist[strtolower($get_fy_month[9])] + $actlist[strtolower($get_fy_month[10])] + $actlist[strtolower($get_fy_month[11])];
            }
        }

        if (php72_cmp($type) == 1) {
            $ac = 0;
            foreach ($categories as $cate) {
                $target[$ac] = $tap_tarquat[$cate];
                $actual[$ac] = $tap_actquat[$cate];
                $ac++;
            }
        } else {
            $categories[0] = 'Q1';
            $categories[1] = 'Q2';
            $categories[2] = 'Q3';
            $categories[3] = 'Q4';
            $categories[4] = 'Annual';

            $target[0] = $tap_tarquat['q1'];
            $target[1] = $tap_tarquat['q2'];
            $target[2] = $tap_tarquat['q3'];
            $target[3] = $tap_tarquat['q4'];
            $target[4] = $tap_tarquat['q1'] + $tap_tarquat['q2'] + $tap_tarquat['q3'] + $tap_tarquat['q4'];

            $actual[0] = $tap_actquat['q1'];
            $actual[1] = $tap_actquat['q2'];
            $actual[2] = $tap_actquat['q3'];
            $actual[3] = $tap_actquat['q4'];
            $actual[4] = $tap_actquat['q1'] + $tap_actquat['q2'] + $tap_actquat['q3'] + $tap_actquat['q4'];
        }

        $id = $this->input->post('id');
        $data['div_id'] = 'tapChartDiv_' . $id;
        $data['categories_list'] = php72_array_values($categories);
        $data['target_list'] = php72_array_values($target);
        $data['actual_list'] = array_values($actual);
        $this->load->vars($data);
        $this->load->view('portfolio/dashboard_chart/allTap_HC');
    }

    public function tinymce($id = '', $year = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $option['id'] = $appoption['inv_id'] = $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['company_data'] = $this->Mportfolio->getDetails('port_company_data', $c_option);
        $data['business_nature'] = $this->Mportfolio->getDetails('port_business', $c_option);
        $data['get_innovation'] = $this->Mportfolio->getDetails('innovation_pool', $option);


        $sector['id'] = isset($data['business_nature']) ? $data['business_nature'][0]['sector'] : $data['get_innovation'][0]['sector'];
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);

        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if (php72_cmp($fy['status']) == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }
        $appoption['financial_year'] = $f_year;
        $data['current_financial'] = $f_year;

        $qual_option['module_id'] = 1;
        $data['qualitative_data'] = $this->Mportfolio->getDetails('temp_qualitative_data', $qual_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('port_config_approval', $appoption);
        $this->session->set_userdata('product_approval', $approvals[0]['product_approval']);

        $pending = '0';
        if ($year == '') {
            if (php72_cmp($this->session->userdata['sector_lead']) == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('port_config_approval', $c_option, 'product_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/product/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        $business_nature = $this->Mportfolio->getSecEmpId($id);
        $dd_company = $this->Mportfolio->getSecEmployee_DD($id);
        $incubation_app = $this->Mportfolio->getSecEmployee_app($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : $dd_company[0]['employee_id'];
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : $incubation_app[0]['employee_id'];
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);

        $this->load->vars($data);
        $this->load->view('portfolio/tinymce');
    }

}

?>
