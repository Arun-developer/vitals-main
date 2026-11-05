<?php

class Sector_plan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('Mportfolio');
        $this->load->model('Sectorplan');
        $this->load->model('scouting/Mincharge');
        $this->load->model('scouting/Minnovation');
        $this->load->model('login/Muser');
        $this->load->model('login/Mdiligence');
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

    public function sector_plan_tables() {
        return array("1" => 'sector_plan_discovery', "2" => 'sector_plan_diligence', "3" => 'sector_plan_selection', "4" => 'sector_plan_graduates', "5" => 'sector_plan_exits', "6" => 'sector_plan_donorengagement', "7" => 'sector_plan_donorconnect', "8" => 'sector_plan_conferences', "9" => 'sector_plan_blogpost', "10" => 'sector_plan_publisharticle', "11" => 'sector_plan_speakingengagement', "12" => 'sector_plan_jurypanels', "13" => 'sector_plan_casestudy', "14" => 'sector_plan_equity', "15" => 'sector_plan_portfolioreturns');
    }

    public function sectorplan_temptables() {
        return array("1" => 'temp_sectorplan_discovery', "2" => 'temp_sectorplan_diligence', "3" => 'temp_sectorplan_selection', "4" => 'temp_sectorplan_graduates', "5" => 'temp_sectorplan_exits', "6" => 'temp_sectorplan_donorengagement', "7" => 'temp_sectorplan_donorconnect', "8" => 'temp_sectorplan_conferences', "9" => 'temp_sectorplan_blogpost', "10" => 'temp_sectorplan_publisharticle', "11" => 'temp_sectorplan_speakingengagement', "12" => 'temp_sectorplan_jurypanels', "13" => 'temp_sectorplan_casestudy', "14" => 'temp_sectorplan_equity', "15" => 'temp_sectorplan_portfolioreturns');
    }

    public function sector_plan_subtables() {
        return array("1" => 'sector_plan_discoverysubsector');
    }

    public function sectorplan_subtemptables() {
        return array("1" => 'temp_sectorplan_discoverysubsector');
    }

    public function sectorplan_tablefields($module_id) {
        if ($module_id == 1) {
            return array('total_applications_q1', 'total_applications_q2', 'total_applications_q3', 'total_applications_q4');
        } else if ($module_id == 2) {
            return array('q1_pard', 'q2_pard', 'q3_pard', 'q4_pard', 'q1_iic', 'q2_iic', 'q3_iic', 'q4_iic', 'q1_eic', 'q2_eic', 'q3_eic', 'q4_eic');
        } else if ($module_id == 3) {
            return array('q1_new_companies', 'q2_new_companies', 'q3_new_companies', 'q4_new_companies', 'q1_application_submitted', 'q2_application_submitted', 'q3_application_submitted', 'q4_application_submitted', 'q1_companies_in_portfolio', 'q2_companies_in_portfolio', 'q3_companies_in_portfolio', 'q4_companies_in_portfolio');
        } else if ($module_id == 4) {
            return array('q1_graduates', 'q2_graduates', 'q3_graduates', 'q4_graduates');
        } else if ($module_id == 5) {
            return array('q1_exits', 'q2_exits', 'q3_exits', 'q4_exits');
        } else if ($module_id == 6) {
            return array('q1_renewal_agreements', 'q2_renewal_agreements', 'q3_renewal_agreements', 'q4_renewal_agreements');
        } else if ($module_id == 7) {
            return array('q1_new_agreements', 'q2_new_agreements', 'q3_new_agreements', 'q4_new_agreements');
        } else if ($module_id == 8) {
            return array('q1_conferences', 'q2_conferences', 'q3_conferences', 'q4_conferences');
        } else if ($module_id == 9) {
            return array('q1_blogpost', 'q2_blogpost', 'q3_blogpost', 'q4_blogpost');
        } else if ($module_id == 10) {
            return array('q1_publisharticle', 'q2_publisharticle', 'q3_publisharticle', 'q4_publisharticle');
        } else if ($module_id == 11) {
            return array('q1_speakingengagement', 'q2_speakingengagement', 'q3_speakingengagement', 'q4_speakingengagement');
        } else if ($module_id == 12) {
            return array('q1_jurypanels', 'q2_jurypanels', 'q3_jurypanels', 'q4_jurypanels');
        } else if ($module_id == 13) {
            return array('q1_casestudy', 'q2_casestudy', 'q3_casestudy', 'q4_casestudy');
        } else if ($module_id == 14) {
            return array('q1_equity', 'q2_equity', 'q3_equity', 'q4_equity');
        } else if ($module_id == 15) {
            return array('q1_portfolioreturns', 'q2_portfolioreturns', 'q3_portfolioreturns', 'q4_portfolioreturns');
        }
    }

    public function sectorplan_subtablefields($module_id) {
        if ($module_id == 1) {
            return array('subsector_id', 'subsector_applications_q1', 'subsector_applications_q2', 'subsector_applications_q3', 'subsector_applications_q4');
        }
    }

    public function sectorplan_approvalfields() {
        return array("1" => 'discovery_approval', "2" => 'diligence_approval', "3" => 'selection_approval', "4" => 'graduates_approval', "5" => 'exits_approval', "6" => 'donorengagement_approval', "7" => 'donorconnect_approval', "8" => 'conferences_approval', "9" => 'blog_post_approval', "10" => 'publish_article_approval', "11" => 'speakingengagement_approval', "12" => 'jury_panels_approval', "13" => 'case_study_approval', "14" => 'equity_investment_approval', "15" => 'portfolio_return_approval');
    }

    public function getSectorLead($id) {
        $option['sector_id'] = $id;
        $option['partner_id'] = $this->session->userdata('partner_id');
        $emp_id = array();
        $get_lead = $this->Mportfolio->getDetails('assign_sector_lead', $option);
        foreach ($get_lead as $lead) {
            $emp_id[] = $lead['employee_id'];
        }
        return array_unique($emp_id);
    }

    public function getAssociateSectorLead($id) {
        $status = 3;
        $option['sector'] = $id;
        $inv_id = $associate_emp = array();
		
		#CR QUERY
        #$business_nature = $this->Mportfolio->getDetails('port_business', $option, $status);
        $business_nature = $this->Mportfolio->getDetails_pby('port_business', $id, $status);
		
        foreach ($business_nature as $inv) {
            $inv_id[] = $inv['inv_id'];
        }
        $innovation_id = php72_array_unique($inv_id);
        $assign_status = 1;
        if ($innovation_id != '') {
            $assign_list = $this->Mportfolio->getArrayListingDetails('assign_associate', $innovation_id, $assign_status);
            foreach ($assign_list as $emp) {
                $associate_emp[] = $emp['associate_employee'];
            }
        }
        return array_unique($associate_emp);
    }

    public function configCount($id, $fyear) {
        if ($id != '')
            $discovery['sector_id'] = $diligence['sector_id'] = $selection['sector_id'] = $graduates['sector_id'] = $exits['sector_id'] = $donorengagement['sector_id'] = $donorconnect['sector_id'] = $id;
        $conferences['sector_id'] = $blogpost['sector_id'] = $publisharticle['sector_id'] = $speakingengagement['sector_id'] = $jurypanels['sector_id'] = $casestudy['sector_id'] = $equityinvest['sector_id'] = $portfolioreturns['sector_id'] = $id;

        $discovery['financial_year'] = $diligence['financial_year'] = $selection['financial_year'] = $graduates['financial_year'] = $exits['financial_year'] = $donorengagement['financial_year'] = $donorconnect['financial_year'] = $fyear;
        $conferences['financial_year'] = $blogpost['financial_year'] = $publisharticle['financial_year'] = $speakingengagement['financial_year'] = $jurypanels['financial_year'] = $casestudy['financial_year'] = $equityinvest['financial_year'] = $portfolioreturns['financial_year'] = $fyear;

        $discovery['discovery_approval'] = $diligence['diligence_approval'] = $selection['selection_approval'] = $graduates['graduates_approval'] = $exits['exits_approval'] = $donorengagement['donorengagement_approval'] = $donorconnect['donorconnect_approval'] = 2;
        $conferences['conferences_approval'] = $blogpost['blog_post_approval'] = $publisharticle['publish_article_approval'] = $speakingengagement['speakingengagement_approval'] = $jurypanels['jury_panels_approval'] = $casestudy['case_study_approval'] = $equityinvest['equity_investment_approval'] = $portfolioreturns['portfolio_return_approval'] = 2;

        $data['discoveryCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $discovery);
        $data['diligenceCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $diligence);
        $data['selectionCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $selection);
        $data['graduatesCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $graduates);
        $data['exitsCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $exits);
        $data['donorengagementCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $donorengagement);
        $data['donorconnectCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $donorconnect);
        $data['conferenceCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $conferences);
        $data['blogspotCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $blogpost);
        $data['publisharticleCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $publisharticle);
        $data['speakingengagementCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $speakingengagement);
        $data['jurypanelsCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $jurypanels);
        $data['casestudyCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $casestudy);
        $data['equityinvestCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $equityinvest);
        $data['portfolioreturnCount'] = $this->Mportfolio->getDetails('sector_plan_approval', $portfolioreturns);

        return $data;
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

    public function sendapproval() {
        $config_option['sector_id'] = $option['sector_id'] = $proj_option['sector_id'] = $_POST['sector_id'];
//        if (isset($_POST['fin_year']) && $_POST['fin_year'] != '') {
//            $option['financial_year'] = $_POST['fin_year'];
//        } else {
//            $partner_id = $this->session->userdata('partner_id');
//            $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
//            $option['financial_year'] = $data['fin_year'][0]['fin_year'];
//        }

        $business_nature = $this->Sectorplan->getSecEmpId($_POST['sector_id']);

        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        if ($get_sect_leadID != '') {
            $sector_name = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        } else {
            $sector_name = '';
        }

//        if ($business_nature[0]['employee_id'] == '' && $dd_company[0]['employee_id'] != '') {
//            $data['sector'] = $dd_company[0]['sector'];
//            $query = $this->Mportfolio->updatePortfolioDetail('port_business', $data, $proj_option);
//        } else if ($business_nature[0]['employee_id'] == '' && $dd_company[0]['employee_id'] == '' && $incubation_app[0]['employee_id'] != '') {
//            $data['sector'] = $incubation_app[0]['sector'];
//            $query = $this->Mportfolio->updatePortfolioDetail('port_business', $data, $proj_option);
//        }


        $table = $_POST['table'];
        $getApprovalStatus = $this->Mportfolio->getDetails($table, $option);
        $appFields = array();
        foreach ($getApprovalStatus as $appFields) {
            $fields = array();
            $option['id'] = $appFields['id'];
            if ($appFields['discovery_approval'] == 1) {
                $fields['discovery_approval'] = 2;
            }
            if ($appFields['diligence_approval'] == 1) {
                $fields['diligence_approval'] = 2;
            }
            if ($appFields['selection_approval'] == 1) {
                $fields['selection_approval'] = 2;
            }
            if ($appFields['graduates_approval'] == 1) {
                $fields['graduates_approval'] = 2;
            }
            if ($appFields['exits_approval'] == 1) {
                $fields['exits_approval'] = 2;
            }
            if ($appFields['donorengagement_approval'] == 1) {
                $fields['donorengagement_approval'] = 2;
            }
            if ($appFields['donorconnect_approval'] == 1) {
                $fields['donorconnect_approval'] = 2;
            }
            if ($appFields['conferences_approval'] == 1) {
                $fields['conferences_approval'] = 2;
            }
            if ($appFields['blog_post_approval'] == 1) {
                $fields['blog_post_approval'] = 2;
            }
            if ($appFields['publish_article_approval'] == 1) {
                $fields['publish_article_approval'] = 2;
            }
            if ($appFields['speakingengagement_approval'] == 1) {
                $fields['speakingengagement_approval'] = 2;
            }
            if ($appFields['jury_panels_approval'] == 1) {
                $fields['jury_panels_approval'] = 2;
            }
            if ($appFields['case_study_approval'] == 1) {
                $fields['case_study_approval'] = 2;
            }
            if ($appFields['equity_investment_approval'] == 1) {
                $fields['equity_investment_approval'] = 2;
            }
            if ($appFields['portfolio_return_approval'] == 1) {
                $fields['portfolio_return_approval'] = 2;
            }
            if (isset($fields) && count($fields) > 0) {
                $result = $this->Mportfolio->approvalCompany($table, $option, $fields);
            }
            if ($result) {
                $config_approval = $this->Sectorplan->configApprovalUpdate('sector_plan_approval', $option);
            }
        }
//        if (isset($proj_fields)) {
//            $pro_result = $this->Mportfolio->approvalCompany($table, $proj_option, $proj_fields);
//            if ($pro_result) {
//                $project_approval = $this->Mportfolio->configApprovalUpdate('sector_plan_approval', $proj_option);
//            }
//        }

        if ($result || $pro_result) {
            $this->session->set_flashdata('successMsg', "Your updated sector plan will be sent for approval to " . $sector_name[0]['emp_names'] . ". You will get a notification / email once it is approved");

//            $log_data = array(
//                'sector_id' => $_POST['invid'],
//                'stage' => '12',
//                'status' => '21',
//                'modified_by' => $this->session->userdata['emp_number'],
//                'modified_date' => date('Y-m-d H:i:s')
//            );
//
//            $table_log = "application_status_log";
//            $result = $this->Minnovation->pitch_insert($table_log, $log_data);

            echo '1';
        } else {
            echo '0';
        }
    }

    public function Approved() {
        $status = 3;
        $main_fields['status'] = 1;
        $main_fields['edited_status'] = 0;
        $temp_fields['status'] = 1;
        $master_option['status'] = 1;

        $master_option['sector'] = $sector_id = $option['sector_id'] = $qual_option['sector_id'] = $this->input->post('sector_id');
        $master_option['financial_year'] = $fin_yr = $option['financial_year'] = $qual_option['financial_year'] = $this->input->post('fin_year');
        $app_field = $this->input->post('approval_field');
        $module_id = $this->input->post('module_id');
        $maintable = $this->input->post('maintable');
        $subtable = $this->input->post('subtable');
        $temptable = $this->input->post('temptable');
        $tempsubtable = $this->input->post('tempsubtable');
        $tablefields = $this->input->post('fields');
        $subtablefields = $this->input->post('subfields');
        $set_app[$app_field] = 3;

        $qualitative = $this->qualitative_approve($sector_id, $fin_yr, $module_id);

        $get_tempDetails = $this->Mportfolio->getDetails($temptable, $option, $status);
        foreach ($get_tempDetails as $detail) {
            foreach ($tablefields as $fields) {
                $data[$fields] = $detail[$fields];
            }
            $condition['sector_id'] = $sector_id;
            $condition['financial_year'] = $fin_yr;
            $copy_data = $this->Mportfolio->updatePortfolioDetail($maintable, $data, $condition);
        }

        $m_query = $this->Mportfolio->approvalCompany($maintable, $option, $main_fields, $status);
        $t_query = $this->Mportfolio->approvalCompany($temptable, $option, $temp_fields, $status);

        if (isset($subtable) && $subtable != '') {
            $get_tempsubDetails = $this->Mportfolio->getDetails($tempsubtable, $option, $status);
            foreach ($get_tempsubDetails as $subdetail) {
                foreach ($subtablefields as $subfields) {
                    $subdata[$subfields] = $subdetail[$subfields];
                }
                $subcondition['id'] = $subdetail['id'];
                $subcondition['sector_id'] = $sector_id;
                $subcondition['financial_year'] = $fin_yr;
                $copy_data = $this->Mportfolio->updatePortfolioDetail($subtable, $subdata, $subcondition);
            }

            $sm_query = $this->Mportfolio->approvalCompany($subtable, $option, $main_fields, $status);
            $st_query = $this->Mportfolio->approvalCompany($tempsubtable, $option, $temp_fields, $status);
        }

        $update_approval = $this->Mportfolio->approvalCompany('sector_plan_approval', $option, $set_app);
        if ($m_query) {
            if ($maintable == 'sector_plan_discovery') {
                $master_fields['app_q1'] = $data['total_applications_q1'];
                $master_fields['app_q2'] = $data['total_applications_q2'];
                $master_fields['app_q3'] = $data['total_applications_q3'];
                $master_fields['app_q4'] = $data['total_applications_q4'];
                $master_fields['app_annual'] = $data['total_applications_q1'] + $data['total_applications_q2'] + $data['total_applications_q3'] + $data['total_applications_q4'];
            } else if ($maintable == 'sector_plan_diligence') {
                $master_fields['pard_q1'] = $data['q1_pard'];
                $master_fields['pard_q2'] = $data['q2_pard'];
                $master_fields['pard_q3'] = $data['q3_pard'];
                $master_fields['pard_q4'] = $data['q4_pard'];
                $master_fields['iic_q1'] = $data['q1_iic'];
                $master_fields['iic_q2'] = $data['q2_iic'];
                $master_fields['iic_q3'] = $data['q3_iic'];
                $master_fields['iic_q4'] = $data['q4_iic'];
                $master_fields['eic_q1'] = $data['q1_eic'];
                $master_fields['eic_q2'] = $data['q2_eic'];
                $master_fields['eic_q3'] = $data['q3_eic'];
                $master_fields['eic_q4'] = $data['q4_eic'];
                $master_fields['pard_annual'] = $data['q1_pard'] + $data['q2_pard'] + $data['q3_pard'] + $data['q4_pard'];
                $master_fields['iic_annual'] = $data['q1_iic'] + $data['q2_iic'] + $data['q3_iic'] + $data['q4_iic'];
                $master_fields['eic_annual'] = $data['q1_eic'] + $data['q2_eic'] + $data['q3_eic'] + $data['q4_eic'];
            } else if ($maintable == 'sector_plan_selection') {
                $master_fields['new_q1'] = $data['q1_new_companies'];
                $master_fields['new_q2'] = $data['q2_new_companies'];
                $master_fields['new_q3'] = $data['q3_new_companies'];
                $master_fields['new_q4'] = $data['q4_new_companies'];
                $master_fields['tot_q1'] = $data['q1_companies_in_portfolio'];
                $master_fields['tot_q2'] = $data['q2_companies_in_portfolio'];
                $master_fields['tot_q3'] = $data['q3_companies_in_portfolio'];
                $master_fields['tot_q4'] = $data['q4_companies_in_portfolio'];
                $master_fields['new_annual'] = $data['q1_new_companies'] + $data['q2_new_companies'] + $data['q3_new_companies'] + $data['q4_new_companies'];
                $master_fields['tot_annual'] = $data['q1_companies_in_portfolio'] + $data['q2_companies_in_portfolio'] + $data['q3_companies_in_portfolio'] + $data['q4_companies_in_portfolio'];
            } else if ($maintable == 'sector_plan_graduates') {
                $master_fields['grad_q1'] = $data['q1_graduates'];
                $master_fields['grad_q2'] = $data['q2_graduates'];
                $master_fields['grad_q3'] = $data['q3_graduates'];
                $master_fields['grad_q4'] = $data['q4_graduates'];
                $master_fields['grad_annual'] = $data['q1_graduates'] + $data['q2_graduates'] + $data['q3_graduates'] + $data['q4_graduates'];
            } else if ($maintable == 'sector_plan_exits') {
                $master_fields['ext_q1'] = $data['q1_exits'];
                $master_fields['ext_q2'] = $data['q2_exits'];
                $master_fields['ext_q3'] = $data['q3_exits'];
                $master_fields['ext_q4'] = $data['q4_exits'];
                $master_fields['ext_annual'] = $data['q1_exits'] + $data['q2_exits'] + $data['q3_exits'] + $data['q4_exits'];
            }

            if (isset($master_fields) && php72_count($master_fields) > 0) {
                $get_masterdetails = $this->Mportfolio->getDetails('port_dashboard_master', $master_option);
                if (php72_count($get_masterdetails) > 0) {
                    $update_master = $this->Mportfolio->approvalCompany('port_dashboard_master', $master_option, $master_fields);
                } else {
                    $master_fields['partner_id'] = $this->session->userdata('partner_id');
                    $master_fields['sector'] = $sector_id;
                    $master_fields['financial_year'] = $fin_yr;
                    $master_fields['created_by'] = $this->session->userdata('emp_number');
                    $master_fields['created_at'] = date("Y-m-d H:i:s");
                    $master_fields['status'] = 1;
                    $insert_master = $this->Mportfolio->insertPortfolioDetail('port_dashboard_master', $master_fields);
                }
            }
            $config_approval = $this->Sectorplan->configApprovalUpdate('sector_plan_approval', $option);
            $this->session->set_userdata('approve_success', '1');

//            $log_data = array(
//                'sector_id' => $this->input->post('sector_id'),
//                'stage' => '12',
//                'status' => '22',
//                'modified_by' => $this->session->userdata['emp_number'],
//                'modified_date' => date('Y-m-d H:i:s')
//            );
//
//            $table_log = "application_status_log";
//            $result = $this->Minnovation->pitch_insert($table_log, $log_data);

            echo '1';
        } else {
            echo '0';
        }
    }

    public function ApproveAll() { 
        $table1 = $this->sector_plan_tables();
        $table2 = $this->sectorplan_temptables();
        $subtable1 = $this->sector_plan_subtables();
        $subtable2 = $this->sectorplan_subtemptables();
        $approval_fields = $this->sectorplan_approvalfields();
        foreach ($table1 as $module_id => $maintable) {

            $status = 3;
            $main_fields['status'] = 1;
            $main_fields['edited_status'] = 0;
            $temp_fields['status'] = 1;
            $master_option['status'] = 1;

            $master_option['sector'] = $sector_id = $option['sector_id'] = $qual_option['sector_id'] = $this->input->post('sector_id');
            $master_option['financial_year'] = $fin_yr = $option['financial_year'] = $qual_option['financial_year'] = $this->input->post('fin_year');
            $app_field = $approval_fields[$module_id];
            $subtable = $subtable1[$module_id];
            $temptable = $table2[$module_id];
            $tempsubtable = $subtable2[$module_id];
            $tablefields = $this->sectorplan_tablefields($module_id);
            $subtablefields = $this->sectorplan_subtablefields($module_id);
            $set_app[$app_field] = 3;
            $chk_approval = $this->Mportfolio->getDetails('sector_plan_approval', $option);

            if ($chk_approval[0][$app_field] != 0) {

                $qualitative = $this->qualitative_approve($sector_id, $fin_yr, $module_id);

                $get_tempDetails = $this->Mportfolio->getDetails($temptable, $option, $status);
                foreach ($get_tempDetails as $detail) {
                    $data = array();
                    foreach ($tablefields as $fields) {
                        $data[$fields] = $detail[$fields];
                    }
                    $condition['sector_id'] = $sector_id;
                    $condition['financial_year'] = $fin_yr;
                    $copy_data = $this->Mportfolio->updatePortfolioDetail($maintable, $data, $condition);
                }

                $m_query = $this->Mportfolio->approvalCompany($maintable, $option, $main_fields, $status);
                $t_query = $this->Mportfolio->approvalCompany($temptable, $option, $temp_fields, $status);

                if (isset($subtable) && $subtable != '') {
                    $get_tempsubDetails = $this->Mportfolio->getDetails($tempsubtable, $option, $status);
                    foreach ($get_tempsubDetails as $subdetail) {
                        foreach ($subtablefields as $subfields) {
                            $subdata[$subfields] = $subdetail[$subfields];
                        }
                        $subcondition['id'] = $subdetail['id'];
                        $subcondition['sector_id'] = $sector_id;
                        $subcondition['financial_year'] = $fin_yr;
                        $copy_data = $this->Mportfolio->updatePortfolioDetail($subtable, $subdata, $subcondition);
                    }

                    $sm_query = $this->Mportfolio->approvalCompany($subtable, $option, $main_fields, $status);
                    $st_query = $this->Mportfolio->approvalCompany($tempsubtable, $option, $temp_fields, $status);
                }

//            $update_approval = $this->Mportfolio->approvalCompany('sector_plan_approval', $option, $set_app);



                if ($this->session->userdata['sector_lead'] == 1) {
                    $update_approval = $this->Mportfolio->approvalCompany('sector_plan_approval', $option, $set_app);
                } else {
                    if ($chk_approval[0][$app_field] == 2) {
                        $update_approval = $this->Mportfolio->approvalCompany('sector_plan_approval', $option, $set_app);
                    }
                }

                if ($m_query) {

                    if ($maintable == 'sector_plan_discovery') {
                        $master_fields['app_q1'] = $data['total_applications_q1'];
                        $master_fields['app_q2'] = $data['total_applications_q2'];
                        $master_fields['app_q3'] = $data['total_applications_q3'];
                        $master_fields['app_q4'] = $data['total_applications_q4'];
                        $master_fields['app_annual'] = $data['total_applications_q1'] + $data['total_applications_q2'] + $data['total_applications_q3'] + $data['total_applications_q4'];
                    } else if ($maintable == 'sector_plan_diligence') {
                        $master_fields['pard_q1'] = $data['q1_pard'];
                        $master_fields['pard_q2'] = $data['q2_pard'];
                        $master_fields['pard_q3'] = $data['q3_pard'];
                        $master_fields['pard_q4'] = $data['q4_pard'];
                        $master_fields['iic_q1'] = $data['q1_iic'];
                        $master_fields['iic_q2'] = $data['q2_iic'];
                        $master_fields['iic_q3'] = $data['q3_iic'];
                        $master_fields['iic_q4'] = $data['q4_iic'];
                        $master_fields['eic_q1'] = $data['q1_eic'];
                        $master_fields['eic_q2'] = $data['q2_eic'];
                        $master_fields['eic_q3'] = $data['q3_eic'];
                        $master_fields['eic_q4'] = $data['q4_eic'];
                        $master_fields['pard_annual'] = $data['q1_pard'] + $data['q2_pard'] + $data['q3_pard'] + $data['q4_pard'];
                        $master_fields['iic_annual'] = $data['q1_iic'] + $data['q2_iic'] + $data['q3_iic'] + $data['q4_iic'];
                        $master_fields['eic_annual'] = $data['q1_eic'] + $data['q2_eic'] + $data['q3_eic'] + $data['q4_eic'];
                    } else if ($maintable == 'sector_plan_selection') {
                        $master_fields['new_q1'] = $data['q1_new_companies'];
                        $master_fields['new_q2'] = $data['q2_new_companies'];
                        $master_fields['new_q3'] = $data['q3_new_companies'];
                        $master_fields['new_q4'] = $data['q4_new_companies'];
                        $master_fields['tot_q1'] = $data['q1_companies_in_portfolio'];
                        $master_fields['tot_q2'] = $data['q2_companies_in_portfolio'];
                        $master_fields['tot_q3'] = $data['q3_companies_in_portfolio'];
                        $master_fields['tot_q4'] = $data['q4_companies_in_portfolio'];
                        $master_fields['new_annual'] = $data['q1_new_companies'] + $data['q2_new_companies'] + $data['q3_new_companies'] + $data['q4_new_companies'];
                        $master_fields['tot_annual'] = $data['q1_companies_in_portfolio'] + $data['q2_companies_in_portfolio'] + $data['q3_companies_in_portfolio'] + $data['q4_companies_in_portfolio'];
                    } else if ($maintable == 'sector_plan_graduates') {
                        $master_fields['grad_q1'] = $data['q1_graduates'];
                        $master_fields['grad_q2'] = $data['q2_graduates'];
                        $master_fields['grad_q3'] = $data['q3_graduates'];
                        $master_fields['grad_q4'] = $data['q4_graduates'];
                        $master_fields['grad_annual'] = $data['q1_graduates'] + $data['q2_graduates'] + $data['q3_graduates'] + $data['q4_graduates'];
                    } else if ($maintable == 'sector_plan_exits') {
                        $master_fields['ext_q1'] = $data['q1_exits'];
                        $master_fields['ext_q2'] = $data['q2_exits'];
                        $master_fields['ext_q3'] = $data['q3_exits'];
                        $master_fields['ext_q4'] = $data['q4_exits'];
                        $master_fields['ext_annual'] = $data['q1_exits'] + $data['q2_exits'] + $data['q3_exits'] + $data['q4_exits'];
                    }

                    if (isset($master_fields) && php72_count($master_fields) > 0) {
                        $get_masterdetails = $this->Mportfolio->getDetails('port_dashboard_master', $master_option);
                        if (php72_count($get_masterdetails) > 0) {
                            $update_master = $this->Mportfolio->approvalCompany('port_dashboard_master', $master_option, $master_fields);
                        } else {
                            $master_fields['partner_id'] = $this->session->userdata('partner_id');
                            $master_fields['sector'] = $sector_id;
                            $master_fields['financial_year'] = $fin_yr;
                            $master_fields['created_by'] = $this->session->userdata('emp_number');
                            $master_fields['created_at'] = date("Y-m-d H:i:s");
                            $master_fields['status'] = 1;
                            $insert_master = $this->Mportfolio->insertPortfolioDetail('port_dashboard_master', $master_fields);
                        }
                    }
                    $config_approval = $this->Sectorplan->configApprovalUpdate('sector_plan_approval', $option);
                    $this->session->set_userdata('approve_success', '2');

//                $log_data = array(
//                    'sector_id' => $this->input->post('sector_id'),
//                    'stage' => '12',
//                    'status' => '22',
//                    'modified_by' => $this->session->userdata['emp_number'],
//                    'modified_date' => date('Y-m-d H:i:s')
//                );
//
//                $table_log = "application_status_log";
//                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                    echo '1';
                } else {
                    echo '0';
                }
            }
        }
    }

    public function qualitative_approve($sector_id = '', $year = '', $module = '') {
        $status = 3;
        $qual_data['status'] = 1;
        $qual_data['edited_status'] = 0;
        $qual_temp_fields['status'] = 1;

        $qual_option['sector_id'] = $sector_id;
        $qual_option['financial_year'] = $year;
        $qual_option['module_id'] = $module;

        $getQual_tempDetails = $this->Mportfolio->getDetails('temp_sectorplan_qualitative_data', $qual_option, $status);
        if (php72_count($getQual_tempDetails) > 0) {
            $qual_data['q_one_desc'] = $getQual_tempDetails[0]['q_one_desc'];
            $qual_data['apr_desc'] = $getQual_tempDetails[0]['apr_desc'];
            $qual_data['may_desc'] = $getQual_tempDetails[0]['may_desc'];
            $qual_data['jun_desc'] = $getQual_tempDetails[0]['jun_desc'];
            $qual_data['q_two_desc'] = $getQual_tempDetails[0]['q_two_desc'];
            $qual_data['jul_desc'] = $getQual_tempDetails[0]['jul_desc'];
            $qual_data['aug_desc'] = $getQual_tempDetails[0]['aug_desc'];
            $qual_data['sep_desc'] = $getQual_tempDetails[0]['sep_desc'];
            $qual_data['q_three_desc'] = $getQual_tempDetails[0]['q_three_desc'];
            $qual_data['oct_desc'] = $getQual_tempDetails[0]['oct_desc'];
            $qual_data['nov_desc'] = $getQual_tempDetails[0]['nov_desc'];
            $qual_data['dec_desc'] = $getQual_tempDetails[0]['dec_desc'];
            $qual_data['q_four_desc'] = $getQual_tempDetails[0]['q_four_desc'];
            $qual_data['jan_desc'] = $getQual_tempDetails[0]['jan_desc'];
            $qual_data['feb_desc'] = $getQual_tempDetails[0]['feb_desc'];
            $qual_data['mar_desc'] = $getQual_tempDetails[0]['mar_desc'];
            $qual_data['updated_by'] = $getQual_tempDetails[0]['updated_by'];
        }

        $qm_query = $this->Mportfolio->approvalCompany('sectorplan_qualitative_data', $qual_option, $qual_data, $status);
        $qt_query = $this->Mportfolio->approvalCompany('temp_sectorplan_qualitative_data', $qual_option, $qual_temp_fields, $status);
    }

    public function deleteSubsectorDetail() {
        $this->db->set('status', 3);
        $id = $this->input->post('id');
        $condition = "'" . php72_implode("', '", $id) . "'";
        $m_query = $this->Mportfolio->deleteMentorDetail('sector_plan_discoverysubsector', $condition, 'id');
        $t_query = $this->Mportfolio->deleteMentorDetail('temp_sectorplan_discoverysubsector', $condition, 'id');
        if ($m_query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function discovery($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $subtable = $this->sector_plan_subtables();
        $temp_table = $this->sectorplan_temptables();
        $temp_subtable = $this->sectorplan_subtemptables();
        $approval_fields = $this->sectorplan_approvalfields();
        /* ends */

        /* using sector id getting sector name from sector table */
        $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        }

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);

        $data['sector_id'] = $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $data['subsector_details'] = $subsector_details = $this->Sectorplan->getSubSectors($sector['id']);
        $data['subsector_name'] = $subsector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }
        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* fetching details from admin portfolio master to load defaultly in corresponding fileds */
        $master_cond['sector'] = $id;
        $master_cond['financial_year'] = $f_year;
        $data['master_portfolio'] = $this->Mportfolio->getDetails('port_dashboard_master', $master_cond, 1);

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id); 
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 1;

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_subtable = $temp_subtable[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_subtable = $subtable[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */
        $data['sector_discovery'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['subsector_discovery'] = $this->Mportfolio->getDetails($previllege_subtable, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);


        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('discovery_approval', $approvals[0]['discovery_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'discovery_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/discovery/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/discovery');
    }

    public function addDiscovery() {

        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["discovery_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');

        $qual_data['status'] = 0;
        $qual_approval['discovery_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['total_applications_q1'] = isset($_POST["tot_application"][0]) && $_POST["tot_application"][0] != '' ? $_POST["tot_application"][0] : 0;
        $data1['total_applications_q2'] = isset($_POST["tot_application"][1]) && $_POST["tot_application"][1] != '' ? $_POST["tot_application"][1] : 0;
        $data1['total_applications_q3'] = isset($_POST["tot_application"][2]) && $_POST["tot_application"][2] != '' ? $_POST["tot_application"][2] : 0;
        $data1['total_applications_q4'] = isset($_POST["tot_application"][3]) && $_POST["tot_application"][3] != '' ? $_POST["tot_application"][3] : 0;

        $data1['status'] = 0;
        $approval['discovery_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_discovery', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_discovery', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_discovery', $data1, $option);
            $discovery_id = $_POST["discovery_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_discovery', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_discovery', $data1, $option);
            $discovery_id = $_POST["discovery_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_discovery', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_discovery', $data1);
            $discovery_id = $this->db->insert_id();
        }

        $arr = array();
        $j = 1;
        for ($i = 0; $i < php72_count($_POST['subtheme']); $i++) {
            if ($_POST['subtheme'][$i] != '') {

                $c_option['id'] = $_POST["subsector_discovery_id"][$i];
                $m_option['sector_id'] = $c_option['sector_id'] = $_POST["sector_id"];
                $m_option['subsector_id'] = $_POST["subtheme"][$i];
                $m_option['subsector_name'] = '';
                $m_option['financial_year'] = $c_option['financial_year'] = $data['financial_year'] = $_POST['finance_Year'];
                $m_option['subsector_applications_q1'] = isset($_POST["app_subtheme_q1"][$i]) && $_POST["app_subtheme_q1"][$i] != '' ? $_POST["app_subtheme_q1"][$i] : 0;
                $m_option['subsector_applications_q2'] = isset($_POST["app_subtheme_q2"][$i]) && $_POST["app_subtheme_q2"][$i] != '' ? $_POST["app_subtheme_q2"][$i] : 0;
                $m_option['subsector_applications_q3'] = isset($_POST["app_subtheme_q3"][$i]) && $_POST["app_subtheme_q3"][$i] != '' ? $_POST["app_subtheme_q3"][$i] : 0;
                $m_option['subsector_applications_q4'] = isset($_POST["app_subtheme_q4"][$i]) && $_POST["app_subtheme_q4"][$i] != '' ? $_POST["app_subtheme_q4"][$i] : 0;

                $c_option['discovery_id'] = $m_option['discovery_id'] = isset($_POST["discovery_id"]) && $_POST["discovery_id"] != '' ? $_POST["discovery_id"] : $discovery_id;

                $m_option['status'] = 0;

                $checkExist3 = $this->Mportfolio->getDetails('sector_plan_discoverysubsector', $c_option);
                if (php72_count($checkExist3) > 0 && $checkExist3[0]['status'] == 0) {
                    $m_option['updated_by'] = $this->session->userdata('emp_number');
                    $mc_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_discoverysubsector', $m_option, $c_option);
                    $tc_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_discoverysubsector', $m_option, $c_option);
                } else if (php72_count($checkExist3) > 0 && $checkExist3[0]['status'] == 1) {
                    $m_option['updated_by'] = $this->session->userdata('emp_number');
                    $edited['edited_status'] = 1;
                    $mc_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_discoverysubsector', $edited, $c_option);
                    $tc_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_discoverysubsector', $m_option, $c_option);
                } else {
                    $m_option['created_by'] = $this->session->userdata('emp_number');
                    $m_option['created_at'] = date("Y-m-d H:i:s");
                    $mc_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_discoverysubsector', $m_option);
                    $tc_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_discoverysubsector', $m_option);
                }
            }
            $j++;
        }
        if ($t_query || $tc_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Discovery details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        redirect('portfolio/sector_plan/discovery/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function diligence($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;
		
		
        /* using sector id getting sector name from sector table */
		#CR CHANGES
        $get_inc_sector = $this->Mportfolio->getIncSector();
        $getIncSector_cr = $this->Mportfolio->getIncSector_cr();
		
		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        }
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES
		
		
        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* fetching details from admin portfolio master to load defaultly in corresponding fileds */
        $master_cond['sector'] = $id;
        $master_cond['financial_year'] = $f_year;
        $data['master_portfolio'] = $this->Mportfolio->getDetails('port_dashboard_master', $master_cond, 1);
		
        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */
		
        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 2;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */
		
        $data['sector_diligence'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('diligence_approval', $approvals[0]['diligence_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'diligence_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/diligence/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/diligence');
    }

    public function addDiligence() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["diligence_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['diligence_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_pard'] = isset($_POST["deals_pard"][0]) && $_POST["deals_pard"][0] != '' ? $_POST["deals_pard"][0] : 0;
        $data1['q2_pard'] = isset($_POST["deals_pard"][1]) && $_POST["deals_pard"][1] != '' ? $_POST["deals_pard"][1] : 0;
        $data1['q3_pard'] = isset($_POST["deals_pard"][2]) && $_POST["deals_pard"][2] != '' ? $_POST["deals_pard"][2] : 0;
        $data1['q4_pard'] = isset($_POST["deals_pard"][3]) && $_POST["deals_pard"][3] != '' ? $_POST["deals_pard"][3] : 0;
        $data1['q1_iic'] = isset($_POST["deals_iic"][0]) && $_POST["deals_iic"][0] != '' ? $_POST["deals_iic"][0] : 0;
        $data1['q2_iic'] = isset($_POST["deals_iic"][1]) && $_POST["deals_iic"][1] != '' ? $_POST["deals_iic"][1] : 0;
        $data1['q3_iic'] = isset($_POST["deals_iic"][2]) && $_POST["deals_iic"][2] != '' ? $_POST["deals_iic"][2] : 0;
        $data1['q4_iic'] = isset($_POST["deals_iic"][3]) && $_POST["deals_iic"][3] != '' ? $_POST["deals_iic"][3] : 0;
        $data1['q1_eic'] = isset($_POST["deals_eic"][0]) && $_POST["deals_eic"][0] != '' ? $_POST["deals_eic"][0] : 0;
        $data1['q2_eic'] = isset($_POST["deals_eic"][1]) && $_POST["deals_eic"][1] != '' ? $_POST["deals_eic"][1] : 0;
        $data1['q3_eic'] = isset($_POST["deals_eic"][2]) && $_POST["deals_eic"][2] != '' ? $_POST["deals_eic"][2] : 0;
        $data1['q4_eic'] = isset($_POST["deals_eic"][3]) && $_POST["deals_eic"][3] != '' ? $_POST["deals_eic"][3] : 0;

        $data1['status'] = 0;
        $approval['diligence_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_diligence', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_diligence', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_diligence', $data1, $option);
            $diligence_id = $_POST["diligence_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_diligence', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_diligence', $data1, $option);
            $diligence_id = $_POST["diligence_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_diligence', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_diligence', $data1);
            $diligence_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Diligence details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/diligence/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function selection($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
       
		#CR CHANGES
        $get_inc_sector = $this->Mportfolio->getIncSector();
        $getIncSector_cr = $this->Mportfolio->getIncSector_cr();
		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        }
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES
		
		
        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* fetching details from admin portfolio master to load defaultly in corresponding fileds */
        $master_cond['sector'] = $id;
        $master_cond['financial_year'] = $f_year;
        $data['master_portfolio'] = $this->Mportfolio->getDetails('port_dashboard_master', $master_cond, 1);

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 3;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_selection'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('selection_approval', $approvals[0]['selection_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'selection_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/selection/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/selection');
    }

    public function addSelection() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["selection_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['selection_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_new_companies'] = isset($_POST["new_companies"][0]) && $_POST["new_companies"][0] != '' ? $_POST["new_companies"][0] : 0;
        $data1['q2_new_companies'] = isset($_POST["new_companies"][1]) && $_POST["new_companies"][1] != '' ? $_POST["new_companies"][1] : 0;
        $data1['q3_new_companies'] = isset($_POST["new_companies"][2]) && $_POST["new_companies"][2] != '' ? $_POST["new_companies"][2] : 0;
        $data1['q4_new_companies'] = isset($_POST["new_companies"][3]) && $_POST["new_companies"][3] != '' ? $_POST["new_companies"][3] : 0;
        $data1['q1_application_submitted'] = isset($_POST["app_submitted"][0]) && $_POST["app_submitted"][0] != '' ? $_POST["app_submitted"][0] : 0;
        $data1['q2_application_submitted'] = isset($_POST["app_submitted"][1]) && $_POST["app_submitted"][1] != '' ? $_POST["app_submitted"][1] : 0;
        $data1['q3_application_submitted'] = isset($_POST["app_submitted"][2]) && $_POST["app_submitted"][2] != '' ? $_POST["app_submitted"][2] : 0;
        $data1['q4_application_submitted'] = isset($_POST["app_submitted"][3]) && $_POST["app_submitted"][3] != '' ? $_POST["app_submitted"][3] : 0;
        $data1['q1_companies_in_portfolio'] = isset($_POST["total_companies"][0]) && $_POST["total_companies"][0] != '' ? $_POST["total_companies"][0] : 0;
        $data1['q2_companies_in_portfolio'] = isset($_POST["total_companies"][1]) && $_POST["total_companies"][1] != '' ? $_POST["total_companies"][1] : 0;
        $data1['q3_companies_in_portfolio'] = isset($_POST["total_companies"][2]) && $_POST["total_companies"][2] != '' ? $_POST["total_companies"][2] : 0;
        $data1['q4_companies_in_portfolio'] = isset($_POST["total_companies"][3]) && $_POST["total_companies"][3] != '' ? $_POST["total_companies"][3] : 0;

        $data1['status'] = 0;
        $approval['selection_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_selection', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_selection', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_selection', $data1, $option);
            $selection_id = $_POST["selection_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_selection', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_selection', $data1, $option);
            $selection_id = $_POST["selection_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_selection', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_selection', $data1);
            $selection_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Selection details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/selection/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function graduates($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
       
		#CR CHANGES
        $get_inc_sector = $this->Mportfolio->getIncSector();
        $getIncSector_cr = $this->Mportfolio->getIncSector_cr();
		
		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        }
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES
		
        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* fetching details from admin portfolio master to load defaultly in corresponding fileds */
        $master_cond['sector'] = $id;
        $master_cond['financial_year'] = $f_year;
        $data['master_portfolio'] = $this->Mportfolio->getDetails('port_dashboard_master', $master_cond, 1);

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 4;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_graduates'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('graduates_approval', $approvals[0]['graduates_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'graduates_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/graduates/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/graduates');
    }

    public function addGraduates() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["graduates_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['graduates_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_graduates'] = isset($_POST["graduates"][0]) && $_POST["graduates"][0] != '' ? $_POST["graduates"][0] : 0;
        $data1['q2_graduates'] = isset($_POST["graduates"][1]) && $_POST["graduates"][1] != '' ? $_POST["graduates"][1] : 0;
        $data1['q3_graduates'] = isset($_POST["graduates"][2]) && $_POST["graduates"][2] != '' ? $_POST["graduates"][2] : 0;
        $data1['q4_graduates'] = isset($_POST["graduates"][3]) && $_POST["graduates"][3] != '' ? $_POST["graduates"][3] : 0;

        $data1['status'] = 0;
        $approval['graduates_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_graduates', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_graduates', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_graduates', $data1, $option);
            $graduates_id = $_POST["graduates_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_graduates', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_graduates', $data1, $option);
            $graduates_id = $_POST["graduates_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_graduates', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_graduates', $data1);
            $graduates_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Graduates details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/graduates/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function exits($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* fetching details from admin portfolio master to load defaultly in corresponding fileds */
        $master_cond['sector'] = $id;
        $master_cond['financial_year'] = $f_year;
        $data['master_portfolio'] = $this->Mportfolio->getDetails('port_dashboard_master', $master_cond, 1);

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 5;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_exits'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('exits_approval', $approvals[0]['exits_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'exits_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/exits/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/exits');
    }

    public function addExits() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["exits_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['exits_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_exits'] = isset($_POST["exits"][0]) && $_POST["exits"][0] != '' ? $_POST["exits"][0] : 0;
        $data1['q2_exits'] = isset($_POST["exits"][1]) && $_POST["exits"][1] != '' ? $_POST["exits"][1] : 0;
        $data1['q3_exits'] = isset($_POST["exits"][2]) && $_POST["exits"][2] != '' ? $_POST["exits"][2] : 0;
        $data1['q4_exits'] = isset($_POST["exits"][3]) && $_POST["exits"][3] != '' ? $_POST["exits"][3] : 0;

        $data1['status'] = 0;
        $approval['exits_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_exits', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_exits', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_exits', $data1, $option);
            $exits_id = $_POST["exits_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_exits', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_exits', $data1, $option);
            $exits_id = $_POST["exits_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_exits', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_exits', $data1);
            $exits_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Exits details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/exits/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function donorengagement($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 6;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_donorengage'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('donorengagement_approval', $approvals[0]['donorengagement_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'donorengagement_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/donorengagement/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/donorengagement');
    }

    public function addDonorengagement() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["donorengage_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['donorengagement_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_renewal_agreements'] = isset($_POST["donor_engagement"][0]) && $_POST["donor_engagement"][0] != '' ? $_POST["donor_engagement"][0] : 0;
        $data1['q2_renewal_agreements'] = isset($_POST["donor_engagement"][1]) && $_POST["donor_engagement"][1] != '' ? $_POST["donor_engagement"][1] : 0;
        $data1['q3_renewal_agreements'] = isset($_POST["donor_engagement"][2]) && $_POST["donor_engagement"][2] != '' ? $_POST["donor_engagement"][2] : 0;
        $data1['q4_renewal_agreements'] = isset($_POST["donor_engagement"][3]) && $_POST["donor_engagement"][3] != '' ? $_POST["donor_engagement"][3] : 0;

        $data1['status'] = 0;
        $approval['donorengagement_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_donorengagement', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_donorengagement', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_donorengagement', $data1, $option);
            $donorengage_id = $_POST["donorengage_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_donorengagement', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_donorengagement', $data1, $option);
            $donorengage_id = $_POST["donorengage_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_donorengagement', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_donorengagement', $data1);
            $donorengage_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Donor engagement details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/donorengagement/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function donorconnect($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        #CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES
		

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 7;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_donorconnect'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('donorconnect_approval', $approvals[0]['donorconnect_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'donorconnect_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/donorconnect/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/donorconnect');
    }

    public function addDonorconnect() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["donorconnect_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['donorconnect_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_new_agreements'] = isset($_POST["donor_connect"][0]) && $_POST["donor_connect"][0] != '' ? $_POST["donor_connect"][0] : 0;
        $data1['q2_new_agreements'] = isset($_POST["donor_connect"][1]) && $_POST["donor_connect"][1] != '' ? $_POST["donor_connect"][1] : 0;
        $data1['q3_new_agreements'] = isset($_POST["donor_connect"][2]) && $_POST["donor_connect"][2] != '' ? $_POST["donor_connect"][2] : 0;
        $data1['q4_new_agreements'] = isset($_POST["donor_connect"][3]) && $_POST["donor_connect"][3] != '' ? $_POST["donor_connect"][3] : 0;

        $data1['status'] = 0;
        $approval['donorconnect_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_donorconnect', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_donorconnect', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_donorconnect', $data1, $option);
            $donorconnect_id = $_POST["donorconnect_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_donorconnect', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_donorconnect', $data1, $option);
            $donorconnect_id = $_POST["donorconnect_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_donorconnect', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_donorconnect', $data1);
            $donorconnect_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Donor connect details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/donorconnect/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function conferences($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
       /*  $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */

		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES


        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }
        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 8;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_conferences'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('conferences_approval', $approvals[0]['conferences_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'conferences_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/conferences/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/conferences');
    }

    public function addConferences() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["conferences_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['conferences_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_conferences'] = isset($_POST["conferences"][0]) && $_POST["conferences"][0] != '' ? $_POST["conferences"][0] : 0;
        $data1['q2_conferences'] = isset($_POST["conferences"][1]) && $_POST["conferences"][1] != '' ? $_POST["conferences"][1] : 0;
        $data1['q3_conferences'] = isset($_POST["conferences"][2]) && $_POST["conferences"][2] != '' ? $_POST["conferences"][2] : 0;
        $data1['q4_conferences'] = isset($_POST["conferences"][3]) && $_POST["conferences"][3] != '' ? $_POST["conferences"][3] : 0;

        $data1['status'] = 0;
        $approval['conferences_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_conferences', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_conferences', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_conferences', $data1, $option);
            $conferences_id = $_POST["conferences_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_conferences', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_conferences', $data1, $option);
            $conferences_id = $_POST["conferences_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_conferences', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_conferences', $data1);
            $conferences_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Conference details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/conferences/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function blogpost($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES


        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 9;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_blogpost'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('blog_post_approval', $approvals[0]['blog_post_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'blog_post_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/blogpost/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/blogpost');
    }

    public function addBlogpost() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["blogpost_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['blog_post_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_blogpost'] = isset($_POST["blogpost"][0]) && $_POST["blogpost"][0] != '' ? $_POST["blogpost"][0] : 0;
        $data1['q2_blogpost'] = isset($_POST["blogpost"][1]) && $_POST["blogpost"][1] != '' ? $_POST["blogpost"][1] : 0;
        $data1['q3_blogpost'] = isset($_POST["blogpost"][2]) && $_POST["blogpost"][2] != '' ? $_POST["blogpost"][2] : 0;
        $data1['q4_blogpost'] = isset($_POST["blogpost"][3]) && $_POST["blogpost"][3] != '' ? $_POST["blogpost"][3] : 0;

        $data1['status'] = 0;
        $approval['blog_post_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_blogpost', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_blogpost', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_blogpost', $data1, $option);
            $blogpost_id = $_POST["blogpost_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_blogpost', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_blogpost', $data1, $option);
            $blogpost_id = $_POST["conferences_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_blogpost', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_blogpost', $data1);
            $blogpost_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Blog post details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/blogpost/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function article($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 10;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_article'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('publish_article_approval', $approvals[0]['publish_article_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'publish_article_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/article/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/article');
    }

    public function addArticle() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["article_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['publish_article_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_publisharticle'] = isset($_POST["article"][0]) && $_POST["article"][0] != '' ? $_POST["article"][0] : 0;
        $data1['q2_publisharticle'] = isset($_POST["article"][1]) && $_POST["article"][1] != '' ? $_POST["article"][1] : 0;
        $data1['q3_publisharticle'] = isset($_POST["article"][2]) && $_POST["article"][2] != '' ? $_POST["article"][2] : 0;
        $data1['q4_publisharticle'] = isset($_POST["article"][3]) && $_POST["article"][3] != '' ? $_POST["article"][3] : 0;

        $data1['status'] = 0;
        $approval['publish_article_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_publisharticle', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_publisharticle', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_publisharticle', $data1, $option);
            $article_id = $_POST["article_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_publisharticle', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_publisharticle', $data1, $option);
            $article_id = $_POST["article_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_publisharticle', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_publisharticle', $data1);
            $article_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Publish article details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/article/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function speaking_engagement($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 11;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */
//        echo $previllege_qualtable;
//        die;
        $data['sector_speakingengagement'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('speakingengagement_approval', $approvals[0]['speakingengagement_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'speakingengagement_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/speaking_engagement/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/speaking_engagement');
    }

    public function addSpeakingengagement() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["speaking_engagement_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['speakingengagement_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_speakingengagement'] = isset($_POST["speaking_engagement"][0]) && $_POST["speaking_engagement"][0] != '' ? $_POST["speaking_engagement"][0] : 0;
        $data1['q2_speakingengagement'] = isset($_POST["speaking_engagement"][1]) && $_POST["speaking_engagement"][1] != '' ? $_POST["speaking_engagement"][1] : 0;
        $data1['q3_speakingengagement'] = isset($_POST["speaking_engagement"][2]) && $_POST["speaking_engagement"][2] != '' ? $_POST["speaking_engagement"][2] : 0;
        $data1['q4_speakingengagement'] = isset($_POST["speaking_engagement"][3]) && $_POST["speaking_engagement"][3] != '' ? $_POST["speaking_engagement"][3] : 0;

        $data1['status'] = 0;
        $approval['speakingengagement_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_speakingengagement', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_speakingengagement', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_speakingengagement', $data1, $option);
            $speaking_engagement_id = $_POST["speaking_engagement_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_speakingengagement', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_speakingengagement', $data1, $option);
            $speaking_engagement_id = $_POST["speaking_engagement_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_speakingengagement', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_speakingengagement', $data1);
            $speaking_engagement_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Speaking engagement details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/speaking_engagement/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function jury_panel($id = '', $year = '') {
        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 12;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_jurypanel'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('jury_panels_approval', $approvals[0]['jury_panels_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'jury_panels_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/jury_panel/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/jury_panels');
    }

    public function addJurypanel() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["jury_panel_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['jury_panels_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_jurypanels'] = isset($_POST["jury_panel"][0]) && $_POST["jury_panel"][0] != '' ? $_POST["jury_panel"][0] : 0;
        $data1['q2_jurypanels'] = isset($_POST["jury_panel"][1]) && $_POST["jury_panel"][1] != '' ? $_POST["jury_panel"][1] : 0;
        $data1['q3_jurypanels'] = isset($_POST["jury_panel"][2]) && $_POST["jury_panel"][2] != '' ? $_POST["jury_panel"][2] : 0;
        $data1['q4_jurypanels'] = isset($_POST["jury_panel"][3]) && $_POST["jury_panel"][3] != '' ? $_POST["jury_panel"][3] : 0;

        $data1['status'] = 0;
        $approval['jury_panels_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_jurypanels', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_jurypanels', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_jurypanels', $data1, $option);
            $jury_panel_id = $_POST["jury_panel_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_jurypanels', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_jurypanels', $data1, $option);
            $jury_panel_id = $_POST["jury_panel_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_jurypanels', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_jurypanels', $data1);
            $jury_panel_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Jury panel details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/jury_panel/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function case_study($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 13;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_casestudy'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('case_study_approval', $approvals[0]['case_study_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'case_study_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/case_study/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/case_study');
    }

    public function addCaseStudy() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["case_study_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['case_study_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_casestudy'] = isset($_POST["case_study"][0]) && $_POST["case_study"][0] != '' ? $_POST["case_study"][0] : 0;
        $data1['q2_casestudy'] = isset($_POST["case_study"][1]) && $_POST["case_study"][1] != '' ? $_POST["case_study"][1] : 0;
        $data1['q3_casestudy'] = isset($_POST["case_study"][2]) && $_POST["case_study"][2] != '' ? $_POST["case_study"][2] : 0;
        $data1['q4_casestudy'] = isset($_POST["case_study"][3]) && $_POST["case_study"][3] != '' ? $_POST["case_study"][3] : 0;

        $data1['status'] = 0;
        $approval['case_study_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_casestudy', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_casestudy', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_casestudy', $data1, $option);
            $case_study_id = $_POST["case_study_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_casestudy', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_casestudy', $data1, $option);
            $case_study_id = $_POST["case_study_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_casestudy', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_casestudy', $data1);
            $case_study_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Case study details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/case_study/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function equity_investments($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 14;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_equity'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('equity_investment_approval', $approvals[0]['equity_investment_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'equity_investment_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/equity_investments/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/equity_investment');
    }

    public function addEquityinvestments() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["equity_investment_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['equity_investment_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_equity'] = isset($_POST["equity"][0]) && $_POST["equity"][0] != '' ? $_POST["equity"][0] : 0;
        $data1['q2_equity'] = isset($_POST["equity"][1]) && $_POST["equity"][1] != '' ? $_POST["equity"][1] : 0;
        $data1['q3_equity'] = isset($_POST["equity"][2]) && $_POST["equity"][2] != '' ? $_POST["equity"][2] : 0;
        $data1['q4_equity'] = isset($_POST["equity"][3]) && $_POST["equity"][3] != '' ? $_POST["equity"][3] : 0;

        $data1['status'] = 0;
        $approval['equity_investment_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_equity', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_equity', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_equity', $data1, $option);
            $equity_id = $_POST["equity_investment_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_equity', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_equity', $data1, $option);
            $equity_id = $_POST["equity_investment_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_equity', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_equity', $data1);
            $equity_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Equity investment details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/equity_investments/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    public function consulting_engagements($id = '', $year = '') {

        if ($id != '')
            $status = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		
		#CR CHANGES
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$getIncSector_cr = $this->Mportfolio->getIncSector_cr();

		if(!empty($getIncSector_cr)){
			$allSectors = php72_array_map(function($item) {
				return explode(',', $item['sector']);
			}, $getIncSector_cr);
			$uniqueSectors = array_unique(php72_array_merge(...$allSectors));
		}
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		if(!empty($uniqueSectors)){
			$inc_sectors = array_unique(array_merge($inc_sectors, $uniqueSectors));
		}
		#CR CHANGES


        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = $assign_sectorlead = array_unique($sector_merge);
        /* end operation */

        $emp_id = $this->session->userdata['emp_number'];
        $qual_option['module_id'] = $moduleid = 15;

        /* fetching sector plan tables dynamic usage */
        $main_table = $this->sector_plan_tables();
        $temp_table = $this->sectorplan_temptables();
        /* ends */

        /* below condition is for restricting non-assigned employee from being save, approve & send for approval of a form */
        if (in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $previllege_table = $temp_table[$moduleid];
            $previllege_qualtable = 'temp_sectorplan_qualitative_data';
        } else {
            $previllege_table = $main_table[$moduleid];
            $previllege_qualtable = 'sectorplan_qualitative_data';
            $status = 1;
        }
        /* condition ends */

        $data['sector_portfolioreturns'] = $this->Mportfolio->getDetails($previllege_table, $c_option, $status, $f_year);
        $data['dataConfig'] = $this->configCount($id, $f_year);

        $data['qualitative_data'] = $this->Mportfolio->getDetails($previllege_qualtable, $qual_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        $data['approvals'] = $approvals = $this->Mportfolio->getDetails('sector_plan_approval', $appoption);

        $this->session->set_userdata('portfolio_return_approval', $approvals[0]['portfolio_return_approval']);
        $pending = '0';
        if ($year == '') {
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getConfigApprovalDetails('sector_plan_approval', $c_option, 'portfolio_return_approval');
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/sector_plan/consulting_engagements/' . $id . '/' . $get_data[0]['financial_year']);
                }
            }
        }

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_plan/portfolio_returns');
    }

    public function addConsultingengagements() {
        $data1['sector_id'] = $app_option['sector_id'] = $qual_approval['sector_id'] = $approval['sector_id'] = $_POST["sector_id"];
        $option['id'] = $_POST["portfolio_returns_id"];
        $option['financial_year'] = $app_option['financial_year'] = $qual_approval['financial_year'] = $approval['financial_year'] = $data1['financial_year'] = $_POST['financial_year'];

        $qual_cond['sector_id'] = $qual_data['sector_id'] = $_POST['sector_id'];
        $qual_cond['financial_year'] = $qual_data['financial_year'] = $_POST['financial_year'];
        $qual_cond['module_id'] = $qual_data['module_id'] = $_POST['module_id'];
        $qual_data['q_one_desc'] = $_POST['qOneDesc'];
        $qual_data['apr_desc'] = $_POST['aprContent'];
        $qual_data['may_desc'] = $_POST['mayContent'];
        $qual_data['jun_desc'] = $_POST['junContent'];
        $qual_data['q_two_desc'] = $_POST['qTwoDesc'];
        $qual_data['jul_desc'] = $_POST['julContent'];
        $qual_data['aug_desc'] = $_POST['augContent'];
        $qual_data['sep_desc'] = $_POST['sepContent'];
        $qual_data['q_three_desc'] = $_POST['qThreeDesc'];
        $qual_data['oct_desc'] = $_POST['octContent'];
        $qual_data['nov_desc'] = $_POST['novContent'];
        $qual_data['dec_desc'] = $_POST['decContent'];
        $qual_data['q_four_desc'] = $_POST['qFourDesc'];
        $qual_data['jan_desc'] = $_POST['janContent'];
        $qual_data['feb_desc'] = $_POST['febContent'];
        $qual_data['mar_desc'] = $_POST['marContent'];

        $qual_data['updated_by'] = $this->session->userdata('emp_number');
        $qual_data['status'] = 0;
        $qual_approval['portfolio_return_approval'] = 1;
        $qual_approval['config_approval'] = 1;

        $check_qualit_exist = $this->Mportfolio->getDetails('sectorplan_qualitative_data', $qual_cond);
        if (php72_count($check_qualit_exist) > 0) {
            $qual_option['id'] = $qual_temp_option['sector_plan_id'] = $check_qualit_exist[0]['id'];
            if ($check_qualit_exist[0]['status'] == 1) {
                $qual_edited['edited_status'] = 1;
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_edited, $qual_option);
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
            } else {
                $qual_data['edited_status'] = 0;
                $qt_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_qualitative_data', $qual_data, $qual_temp_option);
                $qm_query = $this->Mportfolio->updatePortfolioDetail('sectorplan_qualitative_data', $qual_data, $qual_option);
            }
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $qm_query = $this->Mportfolio->insertPortfolioDetail('sectorplan_qualitative_data', $qual_data);
            $qual_data['sector_plan_id'] = $this->db->insert_id();
            $qt_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_qualitative_data', $qual_data);
        }

        if ($qt_query) {
            $qual_checkExist1 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($qual_checkExist1) > 0) {
                $qual_query1 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $qual_approval, $app_option);
            } else {
                $qual_query1 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $qual_approval);
            }
            $this->session->set_flashdata('successMsg', "Qualitative sector plan saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }

        $data1['q1_portfolioreturns'] = isset($_POST["portfolio_returns"][0]) && $_POST["portfolio_returns"][0] != '' ? $_POST["portfolio_returns"][0] : 0;
        $data1['q2_portfolioreturns'] = isset($_POST["portfolio_returns"][1]) && $_POST["portfolio_returns"][1] != '' ? $_POST["portfolio_returns"][1] : 0;
        $data1['q3_portfolioreturns'] = isset($_POST["portfolio_returns"][2]) && $_POST["portfolio_returns"][2] != '' ? $_POST["portfolio_returns"][2] : 0;
        $data1['q4_portfolioreturns'] = isset($_POST["portfolio_returns"][3]) && $_POST["portfolio_returns"][3] != '' ? $_POST["portfolio_returns"][3] : 0;

        $data1['status'] = 0;
        $approval['portfolio_return_approval'] = 1;
        $approval['config_approval'] = 1;

        $checkExist = $this->Mportfolio->getDetails('sector_plan_portfolioreturns', $option);
        if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_portfolioreturns', $data1, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_portfolioreturns', $data1, $option);
            $portfolio_returns_id = $_POST["portfolio_returns_id"];
        } else if (php72_count($checkExist) > 0 && $checkExist[0]['status'] == 1) {
            $data1['updated_by'] = $this->session->userdata('emp_number');
            $edited['edited_status'] = 1;
            $m_query = $this->Mportfolio->updatePortfolioDetail('sector_plan_portfolioreturns', $edited, $option);
            $t_query = $this->Mportfolio->updatePortfolioDetail('temp_sectorplan_portfolioreturns', $data1, $option);
            $portfolio_returns_id = $_POST["portfolio_returns_id"];
        } else {
            $data1['created_by'] = $this->session->userdata('emp_number');
            $data1['created_at'] = date("Y-m-d H:i:s");
            $m_query = $this->Mportfolio->insertPortfolioDetail('sector_plan_portfolioreturns', $data1);
            $t_query = $this->Mportfolio->insertPortfolioDetail('temp_sectorplan_portfolioreturns', $data1);
            $portfolio_returns_id = $this->db->insert_id();
        }

        if ($t_query) {
            $checkExist4 = $this->Mportfolio->getDetails('sector_plan_approval', $app_option);
            if (php72_count($checkExist4) > 0) {
                $query3 = $this->Mportfolio->updatePortfolioDetail('sector_plan_approval', $approval, $app_option);
            } else {
                $query3 = $this->Mportfolio->insertPortfolioDetail('sector_plan_approval', $approval);
            }
            $this->session->set_flashdata('successMsg', "Portfolio returns details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_plan/consulting_engagements/' . $_POST['sector_id'] . '/' . $_POST['financial_year']);
    }

    /* sector plan export */

    function sector_plan_export($sector_id, $year) {
        if ($id != '')
            check_partner_privilege($id);
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");
        $currmonth = date('M');

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);

        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
        );

        if ($year == '') {
            if (isset($data['fin_year'][0]['fin_year']) && $data['fin_year'][0]['fin_year'] != '') {
                foreach ($data['fin_year'] as $fy) {
                    if ($fy['status'] == 1) {
                        $data['current_fy'] = $fy['fin_year'];
                    }
                }
            } else {
                $data['current_fy'] = date('Y');
            }

            if ($currmonth <= '3') {
//            $f_year = date('Y') - 1;
//            $fy2 = date('y') - 1;
                $f_year = $data['current_fy'] - 1;
                $fy2 = $data['current_fy'] - 1;
            } else {
//            $f_year = date('Y');
//            $fy2 = date('y');
                $f_year = $data['current_fy'];
                $fy2 = $data['current_fy'];
            }
            $nxtfy = $f_year + 1;
            $nxtfy2 = $fy2 + 1;
        } else {
            $data['current_fy'] = $f_year = $fy2 = $year;
            $nxtfy = $f_year + 1;
            $nxtfy2 = $fy2 + 1;
        }

        $sector_ct = $this->Mportfolio->getSummary_SectorName($sector_id);

        $styleheader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ));
        $style1 = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 10,
                'name' => 'Arial',
            ));

        $styletitle1 = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '95b9e5'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'c6c6c6'),
                ),
            ),
        );
        $styletitle2 = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b9e28c'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'c6c6c6'),
                ),
            ),
        );
        $styletitle3 = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'ffffff'),
                'size' => 11,
                'name' => 'Times New Roman',
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '17375e'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'c6c6c6'),
                ),
            ),
        );

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Plan');
        $rowheadings_plan = array('A4' => 'Focus area', 'B4' => 'Indicators', 'C4' => 'Q1', 'D4' => 'Apr ' . $f_year, 'E4' => 'May ' . $f_year, 'F4' => 'Jun ' . $f_year, 'G4' => 'Q2', 'H4' => 'Jul ' . $f_year, 'I4' => 'Aug ' . $f_year, 'J4' => 'Sep ' . $f_year, 'K4' => 'Q3', 'L4' => 'Oct ' . $f_year, 'M4' => 'Nov ' . $f_year, 'N4' => 'Dec ' . $f_year, 'O4' => 'Q4', 'P4' => 'Jan ' . $nxtfy, 'Q4' => 'Feb ' . $nxtfy, 'R4' => 'Mar ' . $nxtfy);
        $plan_title = array('Discovery', 'Diligence', 'Selection', 'Graduates (Non-financial)', 'Exits (With Equity)', 'Donor engagement plan', 'New donors to connect with', 'Conferences', 'Write blog post', 'Publish article', 'Speaking engagement', 'Attend Jury Panels', 'Case Study', 'Make equity investments', 'Generate returns from portfolio');
        $plan_title_keys = array('Discovery' => 5, 'Diligence' => 6, 'Selection' => 7, 'Graduates (Non-financial)' => 8, 'Exits (With Equity)' => 9, 'Donor engagement plan' => 10, 'New donors to connect with' => 11, 'Conferences' => 12, 'Write blog post' => 13, 'Publish article' => 14, 'Speaking engagement' => 15, 'Attend Jury Panels' => 16, 'Case Study' => 17, 'Make equity investments' => 18, 'Generate returns from portfolio' => 19);
        $rowHead_plan = array('C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R');
        $rowHead_tables = array('C' => 'q_one_desc', 'D' => 'apr_desc', 'E' => 'may_desc', 'F' => 'jun_desc', 'G' => 'q_two_desc', 'H' => 'jul_desc', 'I' => 'aug_desc', 'J' => 'sep_desc', 'K' => 'q_three_desc', 'L' => 'oct_desc', 'M' => 'nov_desc', 'N' => 'dec_desc', 'O' => 'q_four_desc', 'P' => 'jan_desc', 'Q' => 'feb_desc', 'R' => 'mar_desc');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Sector');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Year');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Pipeline');
        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Graduates & Exits');
        $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Fundraise');
        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Brand Building & Thought Leadership');
        $objPHPExcel->getActiveSheet()->setCellValue('A18', 'Drive Villgro Towards Financial');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $sector_ct[0]['sector']);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $f_year . '-' . $nxtfy);

        $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->getStyle('A5:AA5')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A6:AA6')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A7:AA7')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A8:AA8')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A9:AA9')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A10:AA10')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A11:AA11')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A12:AA12')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A13:AA13')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A14:AA14')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A15:AA15')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A16:AA16')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A17:AA17')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A18:AA18')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A19:AA19')->applyFromArray($style1);

        foreach ($rowheadings_plan as $key => $plvalue) {
            $objPHPExcel->getActiveSheet()->setCellValue($key, $plvalue);
        }
        foreach ($plan_title_keys as $key => $plvalue) {
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $plvalue, $key);
        }

        $qual_plan['sector_id'] = $sector_id;
        $qualit_discovery = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '1');
        $qualit_diligence = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '2');
        $qualit_selection = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '3');
        $qualit_graduates = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '4');
        $qualit_exits = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '5');
        $qualit_donor_engage = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '6');
        $qualit_donor_connect = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '7');
        $qualit_conference = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '8');
        $qualit_blogpost = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '9');
        $qualit_article = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '10');
        $qualit_speaking = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '11');
        $qualit_jury_panels = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '12');
        $qualit_case_study = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '13');
        $qualit_equity = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '14');
        $qualit_portfolio_returns = $this->Mportfolio->getQualitativePlanExport('sectorplan_qualitative_data', $qual_plan, '1', $f_year, '15');

        if (isset($qualit_discovery) && php72_count($qualit_discovery) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '5', $this->qualitative_excelAlign($qualit_discovery[0][$tablevals]));
            }
        }
        if (isset($qualit_diligence) && php72_count($qualit_diligence) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '6', $this->qualitative_excelAlign($qualit_diligence[0][$tablevals]));
            }
        }
        if (isset($qualit_selection) && php72_count($qualit_selection) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '7', $this->qualitative_excelAlign($qualit_selection[0][$tablevals]));
            }
        }
        if (isset($qualit_graduates) && php72_count($qualit_graduates) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '8', $this->qualitative_excelAlign($qualit_graduates[0][$tablevals]));
            }
        }
        if (isset($qualit_exits) && php72_count($qualit_exits) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '9', $this->qualitative_excelAlign($qualit_exits[0][$tablevals]));
            }
        }
        if (isset($qualit_donor_engage) && php72_count($qualit_donor_engage) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '10', $this->qualitative_excelAlign($qualit_donor_engage[0][$tablevals]));
            }
        }
        if (isset($qualit_donor_connect) && php72_count($qualit_donor_connect) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '11', $this->qualitative_excelAlign($qualit_donor_connect[0][$tablevals]));
            }
        }
        if (isset($qualit_conference) && php72_count($qualit_conference) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '12', $this->qualitative_excelAlign($qualit_conference[0][$tablevals]));
            }
        }
        if (isset($qualit_blogpost) && php72_count($qualit_blogpost) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '13', $this->qualitative_excelAlign($qualit_blogpost[0][$tablevals]));
            }
        }
        if (isset($qualit_article) && php72_count($qualit_article) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '14', $this->qualitative_excelAlign($qualit_article[0][$tablevals]));
            }
        }
        if (isset($qualit_speaking) && php72_count($qualit_speaking) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '15', $this->qualitative_excelAlign($qualit_speaking[0][$tablevals]));
            }
        }
        if (isset($qualit_jury_panels) && php72_count($qualit_jury_panels) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '16', $this->qualitative_excelAlign($qualit_jury_panels[0][$tablevals]));
            }
        }
        if (isset($qualit_case_study) && php72_count($qualit_case_study) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '17', $this->qualitative_excelAlign($qualit_case_study[0][$tablevals]));
            }
        }
        if (isset($qualit_equity) && php72_count($qualit_equity) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '18', $this->qualitative_excelAlign($qualit_equity[0][$tablevals]));
            }
        }
        if (isset($qualit_portfolio_returns) && php72_count($qualit_portfolio_returns) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '19', $this->qualitative_excelAlign($qualit_portfolio_returns[0][$tablevals]));
            }
        }


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        for ($col = 'C'; $col !== 'S'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('Target');
        $rowheadings_target = array('A4' => 'Focus area', 'B4' => 'Indicators', 'C4' => 'Target', 'D4' => 'Q1', 'E4' => 'Q2', 'F4' => 'Q3', 'G4' => 'Q4');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Sector');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Year');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $sector_ct[0]['sector']);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $f_year . '-' . $nxtfy);

        $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->getStyle('A5:AA5')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A6:AA6')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A7:AA7')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A8:AA8')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A9:AA9')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A10:AA10')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A11:AA11')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A12:AA12')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A13:AA13')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A14:AA14')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A15:AA15')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A16:AA16')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A17:AA17')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A18:AA18')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A19:AA19')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A20:AA20')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A21:AA21')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A22:AA22')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A23:AA23')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A24:AA24')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A25:AA25')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A26:AA26')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A27:AA27')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A28:AA28')->applyFromArray($style1);
        $objPHPExcel->getActiveSheet()->getStyle('A29:AA29')->applyFromArray($style1);

        $sec_plan_option['sector_id'] = $sector_id;
//        $sec_plan_suboption['sector_id'] = $sector_id;

        $sectorplan_discovery = $this->Mportfolio->getQualitativePlanExport('sector_plan_discovery', $sec_plan_option, '1', $f_year);
        $sectorplan_discoverysub = $this->Mportfolio->getQualitativePlanExport('sector_plan_discoverysubsector', $sec_plan_option, '1', $f_year);
        $sectorplan_diligence = $this->Mportfolio->getQualitativePlanExport('sector_plan_diligence', $qual_plan, '1', $f_year);
        $sectorplan_selection = $this->Mportfolio->getQualitativePlanExport('sector_plan_selection', $qual_plan, '1', $f_year);
        $sectorplan_graduates = $this->Mportfolio->getQualitativePlanExport('sector_plan_graduates', $qual_plan, '1', $f_year);
        $sectorplan_exits = $this->Mportfolio->getQualitativePlanExport('sector_plan_exits', $qual_plan, '1', $f_year);
        $sectorplan_donor_engage = $this->Mportfolio->getQualitativePlanExport('sector_plan_donorengagement', $qual_plan, '1', $f_year);
        $sectorplan_donor_connect = $this->Mportfolio->getQualitativePlanExport('sector_plan_donorconnect', $qual_plan, '1', $f_year);
        $sectorplan_conference = $this->Mportfolio->getQualitativePlanExport('sector_plan_conferences', $qual_plan, '1', $f_year);
        $sectorplan_blogpost = $this->Mportfolio->getQualitativePlanExport('sector_plan_blogpost', $qual_plan, '1', $f_year);
        $sectorplan_article = $this->Mportfolio->getQualitativePlanExport('sector_plan_publisharticle', $qual_plan, '1', $f_year);
        $sectorplan_speaking = $this->Mportfolio->getQualitativePlanExport('sector_plan_speakingengagement', $qual_plan, '1', $f_year);
        $sectorplan_jury_panels = $this->Mportfolio->getQualitativePlanExport('sector_plan_jurypanels', $qual_plan, '1', $f_year);
        $sectorplan_case_study = $this->Mportfolio->getQualitativePlanExport('sector_plan_casestudy', $qual_plan, '1', $f_year);
        $sectorplan_equity = $this->Mportfolio->getQualitativePlanExport('sector_plan_equity', $qual_plan, '1', $f_year);
        $sectorplan_portfolio_returns = $this->Mportfolio->getQualitativePlanExport('sector_plan_portfolioreturns', $qual_plan, '1', $f_year);

        foreach ($rowheadings_target as $key => $plvalue) {
            $objPHPExcel->getActiveSheet()->setCellValue($key, $plvalue);
        }


        $row_no = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_no, 'Pipeline');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Discovery');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'Total no. of applications');
        if (isset($sectorplan_discovery) && php72_count($sectorplan_discovery) > 0) {

            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_discovery[0]['total_applications_q1']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_discovery[0]['total_applications_q2']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_discovery[0]['total_applications_q3']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_discovery[0]['total_applications_q4']);
        }
        if (isset($sectorplan_discoverysub) && php72_count($sectorplan_discoverysub) > 0) {
            foreach ($sectorplan_discoverysub as $sub) {
                $row_no++;
                $subsector = $this->Mportfolio->getSummary_SectorName($sub['subsector_id']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, $subsector[0]['sector']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sub['subsector_applications_q1']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sub['subsector_applications_q2']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sub['subsector_applications_q3']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sub['subsector_applications_q4']);
            }
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Diligence');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of deals at PA/RD');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_diligence[0]['q1_pard']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_diligence[0]['q2_pard']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_diligence[0]['q3_pard']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_diligence[0]['q4_pard']);

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of deals brought to IIC');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_diligence[0]['q1_iic']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_diligence[0]['q2_iic']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_diligence[0]['q3_iic']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_diligence[0]['q4_iic']);

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of deals brought to EIC');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_diligence[0]['q1_eic']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_diligence[0]['q2_eic']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_diligence[0]['q3_eic']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_diligence[0]['q4_eic']);

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Selection');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of new companies');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_selection[0]['q1_new_companies']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_selection[0]['q2_new_companies']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_selection[0]['q3_new_companies']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_selection[0]['q4_new_companies']);

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of days from application submitted to Agreement Signed');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_selection[0]['q1_application_submitted']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_selection[0]['q2_application_submitted']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_selection[0]['q3_application_submitted']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_selection[0]['q4_application_submitted']);

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'Total no. of companies in portfolio (end of each Qtr)');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_selection[0]['q1_companies_in_portfolio']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_selection[0]['q2_companies_in_portfolio']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_selection[0]['q3_companies_in_portfolio']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_selection[0]['q4_companies_in_portfolio']);

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_no, 'Graduates & Exits');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Graduates (Non-financial)');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of graduates (non-financial)');
        if (isset($sectorplan_graduates) && php72_count($sectorplan_graduates) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_graduates[0]['q1_graduates']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_graduates[0]['q2_graduates']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_graduates[0]['q3_graduates']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_graduates[0]['q4_graduates']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Exits (With Equity)');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of exits (Villgro has equity)');
        if (isset($sectorplan_exits) && php72_count($sectorplan_exits) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_exits[0]['q1_exits']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_exits[0]['q2_exits']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_exits[0]['q3_exits']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_exits[0]['q4_exits']);
        }

        if ($this->session->userdata['currency'] == 'INR') {
            $currency_text = 'INR, In Lakhs';
        } else {
            $currency_text = $this->session->userdata['currency'] . ", In '000's";
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_no, 'Fundraise');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Donor engagement plan');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, "Value of renewal agreements ($currency_text)");
        if (isset($sectorplan_donor_engage) && php72_count($sectorplan_donor_engage) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_donor_engage[0]['q1_renewal_agreements']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_donor_engage[0]['q2_renewal_agreements']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_donor_engage[0]['q3_renewal_agreements']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_donor_engage[0]['q4_renewal_agreements']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'New donors to connect with ');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, "Value of new agreements signed ($currency_text)");
        if (isset($sectorplan_donor_connect) && php72_count($sectorplan_donor_connect) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_donor_connect[0]['q1_new_agreements']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_donor_connect[0]['q2_new_agreements']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_donor_connect[0]['q3_new_agreements']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_donor_connect[0]['q4_new_agreements']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_no, 'Brand building & Thought leadership');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Conferences');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of conferences attended');
        if (isset($sectorplan_conference) && php72_count($sectorplan_conference) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_conference[0]['q1_conferences']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_conference[0]['q2_conferences']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_conference[0]['q3_conferences']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_conference[0]['q4_conferences']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Write blog post');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of blog posts');
        if (isset($sectorplan_blogpost) && php72_count($sectorplan_blogpost) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_blogpost[0]['q1_blogpost']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_blogpost[0]['q2_blogpost']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_blogpost[0]['q3_blogpost']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_blogpost[0]['q4_blogpost']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Publish article');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of articles');
        if (isset($sectorplan_article) && php72_count($sectorplan_article) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_article[0]['q1_publisharticle']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_article[0]['q2_publisharticle']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_article[0]['q3_publisharticle']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_article[0]['q4_publisharticle']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Speaking engagement');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of speaking engagements');
        if (isset($sectorplan_speaking) && php72_count($sectorplan_speaking) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_speaking[0]['q1_speakingengagement']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_speaking[0]['q2_speakingengagement']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_speaking[0]['q3_speakingengagement']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_speaking[0]['q4_speakingengagement']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Attend Jury Panels');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of jury panels');
        if (isset($sectorplan_jury_panels) && php72_count($sectorplan_jury_panels) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_jury_panels[0]['q1_jurypanels']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_jury_panels[0]['q2_jurypanels']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_jury_panels[0]['q3_jurypanels']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_jury_panels[0]['q4_jurypanels']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Case Study');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of case studies');
        if (isset($sectorplan_case_study) && php72_count($sectorplan_case_study) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_case_study[0]['q1_casestudy']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_case_study[0]['q2_casestudy']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_case_study[0]['q3_casestudy']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_case_study[0]['q4_casestudy']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_no, 'Drive Villgro towards financial sustainability');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Make equity investments');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of equity investment deals');
        if (isset($sectorplan_equity) && php72_count($sectorplan_equity) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_equity[0]['q1_equity']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_equity[0]['q2_equity']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_equity[0]['q3_equity']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_equity[0]['q4_equity']);
        }

        $row_no += 1;
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_no, 'Generate returns from portfolio');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_no, 'No. of service agreements planned');
        if (isset($sectorplan_portfolio_returns) && php72_count($sectorplan_portfolio_returns) > 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_no, $sectorplan_portfolio_returns[0]['q1_portfolioreturns']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row_no, $sectorplan_portfolio_returns[0]['q2_portfolioreturns']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row_no, $sectorplan_portfolio_returns[0]['q3_portfolioreturns']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row_no, $sectorplan_portfolio_returns[0]['q4_portfolioreturns']);
        }


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        for ($col = 'C'; $col !== 'S'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet()->setTitle('Achievement Qualitative');
        $columnHead_plan = array('6', '9', '12', '15', '18', '21', '24', '27', '30', '33', '36', '39', '42', '45', '48');
        $columnHead_plan_achieve = array('7', '10', '13', '16', '19', '22', '25', '28', '31', '34', '37', '40', '43', '46', '49');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'FY:');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sector:');
//        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Enterprise Name:');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Discovery:');
        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Diligence');
        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Selection');
        $objPHPExcel->getActiveSheet()->setCellValue('A15', 'Graduates (Non-financial)');
        $objPHPExcel->getActiveSheet()->setCellValue('A18', 'Exits (with euity)');
        $objPHPExcel->getActiveSheet()->setCellValue('A21', 'Donor engagement');
        $objPHPExcel->getActiveSheet()->setCellValue('A24', 'New donors to connect with');
        $objPHPExcel->getActiveSheet()->setCellValue('A27', 'Conference');
        $objPHPExcel->getActiveSheet()->setCellValue('A30', 'Write blog post');
        $objPHPExcel->getActiveSheet()->setCellValue('A33', 'Publish article');
        $objPHPExcel->getActiveSheet()->setCellValue('A36', 'Speaking engagement');
        $objPHPExcel->getActiveSheet()->setCellValue('A39', 'Attend jury panels');
        $objPHPExcel->getActiveSheet()->setCellValue('A42', 'Case study');
        $objPHPExcel->getActiveSheet()->setCellValue('A45', 'Make equity investment');
        $objPHPExcel->getActiveSheet()->setCellValue('A48', 'Generate returns from portfolio');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $f_year . '-' . $nxtfy);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $sector_ct[0]['sector']);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Q1');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Apr-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'May-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Jun-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Q2');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Jul-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'Aug-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('J5', 'Sep-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('K5', 'Q3');
        $objPHPExcel->getActiveSheet()->setCellValue('L5', 'Oct-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('M5', 'Nov-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('N5', 'Dec-' . $f_year);
        $objPHPExcel->getActiveSheet()->setCellValue('O5', 'Q4');
        $objPHPExcel->getActiveSheet()->setCellValue('P5', 'Jan-' . $nxtfy);
        $objPHPExcel->getActiveSheet()->setCellValue('Q5', 'Feb-' . $nxtfy);
        $objPHPExcel->getActiveSheet()->setCellValue('R5', 'Mar-' . $nxtfy);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($styletitle);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray($styletitle);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AA3')->applyFromArray($styletitle);
        $objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->applyFromArray($styletitle);
//        $objPHPExcel->getActiveSheet()->getStyle('C6:R6')->applyFromArray($styletitle4);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($styletitle3);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($styletitle3);
        $objPHPExcel->getActiveSheet()->getStyle('K5')->applyFromArray($styletitle3);
        $objPHPExcel->getActiveSheet()->getStyle('O5')->applyFromArray($styletitle3);
        $objPHPExcel->getActiveSheet()->getStyle('D5:F5')->applyFromArray($styletitle1);
        $objPHPExcel->getActiveSheet()->getStyle('H5:J5')->applyFromArray($styletitle1);
        $objPHPExcel->getActiveSheet()->getStyle('L5:N5')->applyFromArray($styletitle1);
        $objPHPExcel->getActiveSheet()->getStyle('P5:R5')->applyFromArray($styletitle1);

        $plan_j = 0;
        for ($i = 0; $i < count($columnHead_plan); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $columnHead_plan[$i], 'Plan');
            $plan_j++;
            $start_row = $columnHead_plan[$i];
            $end_row = $columnHead_plan[$i] + 1;

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $start_row . ':A' . $end_row);
            $objPHPExcel->getActiveSheet()->getRowDimension($columnHead_plan[$i])->setRowHeight(25);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $columnHead_plan[$i])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $columnHead_plan[$i])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }

        $achieve_j = 0;
        for ($i = 0; $i < count($columnHead_plan_achieve); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $columnHead_plan_achieve[$i], 'Achieved');
            $achieve_j++;

            $objPHPExcel->getActiveSheet()->getRowDimension($columnHead_plan_achieve[$i])->setRowHeight(25);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $columnHead_plan_achieve[$i])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }


        $achieve_position = array('4' => 'D', '5' => 'E', '6' => 'F', '7' => 'H', '8' => 'I', '9' => 'J', '10' => 'L', '11' => 'M', '12' => 'N', '1' => 'P', '2' => 'Q', '3' => 'R');

        $qual_actual['sector_id'] = $sector_id;
        $qualit_discovery_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '1');
        $qualit_diligence_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '2');
        $qualit_selection_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '3');
        $qualit_graduates_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '4');
        $qualit_exits_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '5');
        $qualit_donor_engage_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '6');
        $qualit_donor_connect_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '7');
        $qualit_conference_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '8');
        $qualit_blogpost_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '9');
        $qualit_article_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '10');
        $qualit_speaking_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '11');
        $qualit_jury_panels_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '12');
        $qualit_case_study_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '13');
        $qualit_equity_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '14');
        $qualit_portfolio_returns_actual = $this->Mportfolio->getQualitativeActualExport('sector_actual_qualitative_data', $qual_actual, '3', $f_year, '15');

        if (isset($qualit_discovery) && php72_count($qualit_discovery) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '6', $this->qualitative_excelAlign($qualit_discovery[0][$tablevals]));
            }
        }
        if (isset($qualit_diligence) && php72_count($qualit_diligence) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '9', $this->qualitative_excelAlign($qualit_diligence[0][$tablevals]));
            }
        }
        if (isset($qualit_selection) && php72_count($qualit_selection) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '12', $this->qualitative_excelAlign($qualit_selection[0][$tablevals]));
            }
        }
        if (isset($qualit_graduates) && php72_count($qualit_graduates) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '15', $this->qualitative_excelAlign($qualit_graduates[0][$tablevals]));
            }
        }
        if (isset($qualit_exits) && php72_count($qualit_exits) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '18', $this->qualitative_excelAlign($qualit_exits[0][$tablevals]));
            }
        }
        if (isset($qualit_donor_engage) && php72_count($qualit_donor_engage) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '21', $this->qualitative_excelAlign($qualit_donor_engage[0][$tablevals]));
            }
        }
        if (isset($qualit_donor_connect) && php72_count($qualit_donor_connect) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '24', $this->qualitative_excelAlign($qualit_donor_connect[0][$tablevals]));
            }
        }
        if (isset($qualit_conference) && php72_count($qualit_conference) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '27', $this->qualitative_excelAlign($qualit_conference[0][$tablevals]));
            }
        }
        if (isset($qualit_blogpost) && php72_count($qualit_blogpost) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '30', $this->qualitative_excelAlign($qualit_blogpost[0][$tablevals]));
            }
        }
        if (isset($qualit_article) && php72_count($qualit_article) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '33', $this->qualitative_excelAlign($qualit_article[0][$tablevals]));
            }
        }
        if (isset($qualit_speaking) && php72_count($qualit_speaking) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '36', $this->qualitative_excelAlign($qualit_speaking[0][$tablevals]));
            }
        }
        if (isset($qualit_jury_panels) && php72_count($qualit_jury_panels) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '39', $this->qualitative_excelAlign($qualit_jury_panels[0][$tablevals]));
            }
        }
        if (isset($qualit_case_study) && php72_count($qualit_case_study) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '42', $this->qualitative_excelAlign($qualit_case_study[0][$tablevals]));
            }
        }
        if (isset($qualit_equity) && php72_count($qualit_equity) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '45', $this->qualitative_excelAlign($qualit_equity[0][$tablevals]));
            }
        }
        if (isset($qualit_portfolio_returns) && php72_count($qualit_portfolio_returns) > 0) {
            foreach ($rowHead_tables as $tablekeys => $tablevals) {
                $objPHPExcel->getActiveSheet()->setCellValue($tablekeys . '48', $this->qualitative_excelAlign($qualit_portfolio_returns[0][$tablevals]));
            }
        }


        if (isset($qualit_discovery_actual) && php72_count($qualit_discovery_actual) > 0) {
            foreach ($qualit_discovery_actual as $discovery_actual) {
                $position = $achieve_position[$discovery_actual['month']] . '7';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($discovery_actual['description']));
            }
        }

        if (isset($qualit_diligence_actual) && php72_count($qualit_diligence_actual) > 0) {
            foreach ($qualit_diligence_actual as $diligence_actual) {
                $position = $achieve_position[$diligence_actual['month']] . '10';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($diligence_actual['description']));
            }
        }

        if (isset($qualit_selection_actual) && php72_count($qualit_selection_actual) > 0) {
            foreach ($qualit_selection_actual as $selection_actual) {
                $position = $achieve_position[$selection_actual['month']] . '13';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($selection_actual['description']));
            }
        }

        if (isset($qualit_graduates_actual) && php72_count($qualit_graduates_actual) > 0) {
            foreach ($qualit_graduates_actual as $graduates_actual) {
                $position = $achieve_position[$graduates_actual['month']] . '16';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($graduates_actual['description']));
            }
        }

        if (isset($qualit_exits_actual) && php72_count($qualit_exits_actual) > 0) {
            foreach ($qualit_exits_actual as $exits_actual) {
                $position = $achieve_position[$exits_actual['month']] . '19';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($exits_actual['description']));
            }
        }

        if (isset($qualit_donor_engage_actual) && php72_count($qualit_donor_engage_actual) > 0) {
            foreach ($qualit_donor_engage_actual as $donorengage_actual) {
                $position = $achieve_position[$donorengage_actual['month']] . '22';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($donorengage_actual['description']));
            }
        }

        if (isset($qualit_donor_connect_actual) && php72_count($qualit_donor_connect_actual) > 0) {
            foreach ($qualit_donor_connect_actual as $donorconnect_actual) {
                $position = $achieve_position[$donorconnect_actual['month']] . '25';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($donorconnect_actual['description']));
            }
        }

        if (isset($qualit_conference_actual) && php72_count($qualit_conference_actual) > 0) {
            foreach ($qualit_conference_actual as $conference_actual) {
                $position = $achieve_position[$conference_actual['month']] . '28';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($conference_actual['description']));
            }
        }

        if (isset($qualit_blogpost_actual) && php72_count($qualit_blogpost_actual) > 0) {
            foreach ($qualit_blogpost_actual as $blogpost_actual) {
                $position = $achieve_position[$blogpost_actual['month']] . '31';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($blogpost_actual['description']));
            }
        }

        if (isset($qualit_article_actual) && php72_count($qualit_article_actual) > 0) {
            foreach ($qualit_article_actual as $article_actual) {
                $position = $achieve_position[$article_actual['month']] . '34';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($article_actual['description']));
            }
        }

        if (isset($qualit_speaking_actual) && php72_count($qualit_speaking_actual) > 0) {
            foreach ($qualit_speaking_actual as $speaking_actual) {
                $position = $achieve_position[$speaking_actual['month']] . '37';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($speaking_actual['description']));
            }
        }

        if (isset($qualit_jury_panels_actual) && php72_count($qualit_jury_panels_actual) > 0) {
            foreach ($qualit_jury_panels_actual as $jurypanels_actual) {
                $position = $achieve_position[$jurypanels_actual['month']] . '40';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($jurypanels_actual['description']));
            }
        }

        if (isset($qualit_case_study_actual) && php72_count($qualit_case_study_actual) > 0) {
            foreach ($qualit_case_study_actual as $casestudy_actual) {
                $position = $achieve_position[$casestudy_actual['month']] . '43';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($casestudy_actual['description']));
            }
        }

        if (isset($qualit_equity_actual) && php72_count($qualit_equity_actual) > 0) {
            foreach ($qualit_equity_actual as $equity_actual) {
                $position = $achieve_position[$equity_actual['month']] . '46';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($equity_actual['description']));
            }
        }

        if (isset($qualit_portfolio_returns_actual) && php72_count($qualit_portfolio_returns_actual) > 0) {
            foreach ($qualit_portfolio_returns_actual as $portfolio_actual) {
                $position = $achieve_position[$portfolio_actual['month']] . '49';
                $objPHPExcel->getActiveSheet()->setCellValue($position, $this->qualitative_excelAlign($portfolio_actual['description']));
            }
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        for ($col = 'C'; $col !== 'S'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
        }

        $sname = (str_replace(' ', '_', strtolower($sector_ct[0]['sector'])));

        $file_name = preg_replace('/[^A-Za-z0-9\_]/', '', $sname) . '.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        $objWriter->save('php://output');
        exit;
    }

    public function qualitative_excelAlign($desc) {
        $desc_get = html_entity_decode($desc);
        $strip_desc = stripslashes(str_replace("\\r\\n", '', $desc_get));
        return trim(strip_tags($strip_desc));
    }

}

?>