<?php

class All_forms extends CI_Controller {

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

    public function month() {
        return array("0" => 'Apr', "1" => 'May', "2" => 'Jun', "3" => 'Jul', "4" => 'Aug', "5" => 'Sep', "6" => 'Oct', "7" => 'Nov', "8" => 'Dec', "9" => 'Jan', "10" => 'Feb', "11" => 'Mar');
    }

    public function actual_month() {
        return array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
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
		
		#CR CHANGE
		$sector_name ='';
		if($id!=''){
			$cr_option['inv_id'] = $id;
			$getPorBusinessYear  = $this->Mportfolio->getDetails('port_business_year', $cr_option);
			if(!empty($getPorBusinessYear)){
				$getMultisectorid = $getPorBusinessYear[0]['sector'];
				if($getMultisectorid!=''){
					$sectorArray = explode(',',$getMultisectorid);
					$sector_ct = $this->Mportfolio->getSectorIn($sectorArray);
					if(!empty($sector_ct)){
						$getSectorArr = php72_array_column($sector_ct,'sector');
						if(!empty($getSectorArr)){
							$data['sector_name'] =  implode(', ',$getSectorArr);
						}
					}
				}
			}
		}
		#CR CHANGE
        return $data;
    }

    public function updates($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $net_option['inv_id'] = $inv_id['inv_id'] = $data['innovation_id'] = $id;

        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }

//            if ($get_current_month == 0) {
//                $past_month = '1';
//            } else {
//                $past_month = $get_current_month;
//            }
            redirect('portfolio/all_forms/updates/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $c_option['finance_id'] = 1;
        $revenue_data = $this->Mportfolio->getDetails('port_finance_fundraise', $c_option, '1', $f_year);

        $net_option['finance_id'] = 2;
        $net_data = $this->Mportfolio->getDetails('port_finance_fundraise', $net_option, '1', $f_year);

        $rev_total = $net_total = 0;

        $r_data = json_decode($revenue_data[0]['data'], true);
        foreach ($r_data as $value) {
            $g_value = str_replace(',', '', $value);
            $rev_total += $g_value;
        }

        $n_data = json_decode($net_data[0]['data'], true);
        foreach ($n_data as $value) {
            $n_value = str_replace(',', '', $value);
            $net_total += $n_value;
        }

        $data['plan_revenue'] = $rev_total;
        $data['plan_profit'] = $net_total;

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }
        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_updates', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_updates', $id, '', $f_year);
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

        $status = $limit = 3;
        $plan['inv_id'] = $id;
        $plan['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['pending_month'] = php72_array_reverse($monthName);
        $data['milestone'] = $this->Mportfolio->getPlanDetails('port_project_milestone', $inv_id, '', '', '1', $limit);

        if ($month == '1' || $month == '2' || $month == '3') {
            $get_fyear = $f_year + 1;
        } else {
            $get_fyear = $f_year;
        }

        $data['updates'] = $this->Mportfolio->getPlanDetails('plan_updates', $plan, '', $f_year, $status);

        $actual_revenue = $actual_profit = 0;
//        if ($month != '4') {
        $finance = $this->Mportfolio->getFinanceDetails('plan_finance', $inv_id, $month, $f_year, $status, 'now');
        foreach ($finance as $value) {
            $a_revenue = str_replace(',', '', $value['revenue']);
            $actual_revenue += $a_revenue;
        }
        foreach ($finance as $value) {
            $a_profit = str_replace(',', '', $value['net_profit']);
            $actual_profit += $a_profit;
        }
//        }

        $data['plan_revenue'] = $rev_total;
        $data['actual_revenue'] = $actual_revenue;
        $data['plan_profit'] = $net_total;
        $data['actual_profit'] = $actual_profit;

        $data['dp_meet_count'] = $data['board_meet_count'] = 0;
        $dp_values = $this->Mportfolio->getMeetingCount('plan_dp', $inv_id, $f_year);
        $data['dp_meet_count'] = $dp_values[0]['meet_count'];

        $board_values = $this->Mportfolio->getMeetingCount('plan_board_meetings', $inv_id, $f_year);
        $data['board_meet_count'] = $board_values[0]['meet_count'];
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/updates');
    }

    public function addUpdates() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];

        $data['achievements'] = $_POST['achievement_desc'];
        $data['challenges'] = $_POST['challenge_desc'];
        $data['villgro_relationship'] = $_POST['villgro_desc'];
        $data['other_comments'] = $_POST['other_desc'];
        $data['actual_revenue'] = $_POST['actual_revenue'];
        $data['plan_revenue'] = $_POST['plan_revenue'];
        $data['actual_profit'] = $_POST['actual_profit'];
        $data['plan_profit'] = $_POST['plan_profit'];
        $data['total_dp'] = $_POST['dp_count'];
        $data['total_bm'] = $_POST['bm_count'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

        $checkExist = $this->Mportfolio->getDetails('plan_updates', $option);
		#echo'<pre>';print_r($option);die;
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_updates', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_updates', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/updates/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function product($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $qual_module['module_id'] = 1;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/product/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);
        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_qualitative_data', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);

        $plan['module_id'] = $qual_option['module_id'] = 1;
        $data['product_qualitative'] = $this->Mportfolio->getPlanDetails('plan_qualitative_data', $plan, '', $f_year, '3');
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/product');
    }

    public function addProductPlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['module_id'] = $data['module_id'] = $_POST['module_id'];

        $data['description'] = $_POST['achieveContent'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

        $checkExist = $this->Mportfolio->getDetails('plan_qualitative_data', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_qualitative_data', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_qualitative_data', $data);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Product details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/product/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function sales($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);
        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_sales', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_sales', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);

        $data['sales_plan'] = $this->Mportfolio->getPlanDetails('plan_sales', $plan, '', $f_year, '3');
        $data['approved_sales'] = $this->Mportfolio->getSalesMaster('port_sales_data', $c_option, $f_year, '1');

        $status = 3;
        $total_last_ytd = $total_now_ytd = 0;

        if ($month != '4') {
            $uptoLast_ytd = $this->Mportfolio->getFinanceDetails('plan_sales', $c_option, $month, $f_year, $status, 'last');
            $uptoNow_ytd = $this->Mportfolio->getFinanceDetails('plan_sales', $c_option, $month, $f_year, $status, 'now');
            foreach ($uptoLast_ytd as $value) {
                $a_ytd = str_replace(',', '', $value['value']);
                $total_last_ytd += $a_ytd;
            }

            foreach ($uptoNow_ytd as $value) {
                $n_ytd = str_replace(',', '', $value['value']);
                $total_now_ytd += $n_ytd;
            }
        }

        $data['ytd_value'] = $total_last_ytd;
        $data['current_ytd'] = $total_now_ytd;
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = 2;
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/sales');
    }

    public function addSalesPlan() {
        $data = array();
        $option['inv_id'] = $qual_option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $qual_option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $qual_option['financial_year'] = $data['financial_year'] = $_POST['current_year'];

        $data['achievement_desc'] = $_POST['achieveContent'];
        $data['monthly_plan'] = $_POST['monthlyPlan'];
        $data['annual_goal'] = $_POST['annualGoal'];
        $data['year_to_date'] = $_POST['ytdCount'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

        $i = $j = 0;
        $qual_data = $data;

        if (php72_count($_POST["product_id"]) > 0) {
            foreach ($_POST["product_id"] as $key) {
                $data['volume'] = $_POST['volume'][$i];
                $data['value'] = $_POST['value'][$i];
                $option['product_id'] = $data['product_id'] = $_POST['product_id'][$i];
                $i++;

                $checkExist = $this->Mportfolio->getDetails('plan_sales', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_sales', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_sales', $data);
                }
            }
            $qual_option['product_id'] = '0';
            $qual_data['updated_by'] = $this->session->userdata('emp_number');
            $qual_data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_sales', $qual_data, $qual_option);
        } else {
            $checkExist = $this->Mportfolio->getDetails('plan_sales', $option);
            if (php72_count($checkExist) > 0) {
                $data['updated_by'] = $this->session->userdata('emp_number');
                $data['status'] = 0;
                $query = $this->Mportfolio->updatePortfolioDetail('plan_sales', $data, $option);
            } else {
                $data['created_by'] = $this->session->userdata('emp_number');
                $data['created_at'] = date("Y-m-d H:i:s");
                $query = $this->Mportfolio->insertPortfolioDetail('plan_sales', $data);
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Sales details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/sales/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function channel($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_channel', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_channel', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['approved_channel'] = $this->Mportfolio->getChannelMaster('port_channel_data', $c_option, $f_year, '1');
        $data['channel_plan'] = $this->Mportfolio->getPlanDetails('plan_channel', $plan, '', $f_year, '3');

        $status = 3;
        $total_last_ytd = $total_now_ytd = 0;

        if ($month != '4') {
            $uptoLast_ytd = $this->Mportfolio->getFinanceDetails('plan_channel', $c_option, $month, $f_year, $status, 'last');
            $uptoNow_ytd = $this->Mportfolio->getFinanceDetails('plan_channel', $c_option, $month, $f_year, $status, 'now');

            foreach ($uptoLast_ytd as $value) {
                $a_ytd = str_replace(',', '', $value['channel_data']);
                $total_last_ytd += $a_ytd;
            }

            foreach ($uptoNow_ytd as $value) {
                $n_ytd = str_replace(',', '', $value['channel_data']);
                $total_now_ytd += $n_ytd;
            }
        }

        $data['ytd_value'] = $total_last_ytd;
        $data['current_ytd'] = $total_now_ytd;
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/channel');
    }

    public function addChannelPlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];

        $data['annual_goal'] = $_POST['annualGoal'];
        $data['ytd_amount'] = $_POST['ytdCount'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

        $details = array();
        $i = 0;
        foreach ($_POST["channel_id"] as $key) {
            $data['channel_data'] = $_POST['value'][$i];
            $option['channel_id'] = $data['channel_id'] = $_POST['channel_id'][$i];
            $i++;

            $checkExist = $this->Mportfolio->getDetails('plan_channel', $option);
            if (php72_count($checkExist) > 0) {
                $data['updated_by'] = $this->session->userdata('emp_number');
                $data['status'] = 0;
                $query = $this->Mportfolio->updatePortfolioDetail('plan_channel', $data, $option);
            } else {
                $data['created_by'] = $this->session->userdata('emp_number');
                $data['created_at'] = date("Y-m-d H:i:s");
                $query = $this->Mportfolio->insertPortfolioDetail('plan_channel', $data);
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Channel details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/channel/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function pipeline($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }
        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_pipeline', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_pipeline', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['pipe_plan'] = $this->Mportfolio->getPlanDetails('plan_pipeline', $plan, '', $f_year, '3');
        $data['pipe_config'] = $this->Mportfolio->getPlanDetails('port_pipeline_data', $c_option, '', $f_year, '1');

        $status = 3;
        $total_last_ytd = $total_now_ytd = 0;

        if ($month != '4') {
            $uptoLast_ytd = $this->Mportfolio->getFinanceDetails('plan_pipeline', $c_option, $month, $f_year, $status, 'last');
            $uptoNow_ytd = $this->Mportfolio->getFinanceDetails('plan_pipeline', $c_option, $month, $f_year, $status, 'now');

            foreach ($uptoLast_ytd as $value) {
                $open_ytd = str_replace(',', '', $value['open']);
                $under_ytd = str_replace(',', '', $value['under_discussion']);
                $reject_ytd = str_replace(',', '', $value['rejected']);
                $convert_ytd = str_replace(',', '', $value['converted']);
                $total_last_ytd += $open_ytd + $under_ytd + $reject_ytd + $convert_ytd;
            }

            foreach ($uptoNow_ytd as $value) {
                $open_ytd = str_replace(',', '', $value['open']);
                $under_ytd = str_replace(',', '', $value['under_discussion']);
                $reject_ytd = str_replace(',', '', $value['rejected']);
                $convert_ytd = str_replace(',', '', $value['converted']);
                $total_now_ytd += $open_ytd + $under_ytd + $reject_ytd + $convert_ytd;
            }
        }

        $data['ytd_value'] = $total_last_ytd;
        $data['current_ytd'] = $total_now_ytd;
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/pipeline');
    }

    public function addPipePlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];

        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $data['annual_goal'] = $_POST['annualGoal'];
        $data['ytd_amount'] = $_POST['ytdCount'];

        $data['currency'] = $_POST['amount'];
        $data['open'] = $_POST['openValue'];
        $data['under_discussion'] = $_POST['underValue'];
        $data['rejected'] = $_POST['rejectValue'];
        $data['converted'] = $_POST['convertValue'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

        $checkExist = $this->Mportfolio->getDetails('plan_pipeline', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_pipeline', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_pipeline', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Pipeline details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/pipeline/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function finance($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $rev_qual_option['inv_id'] = $prof_qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/finance/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_finance', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_finance', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['finance_plan'] = $this->Mportfolio->getPlanDetails('plan_finance', $plan, '', $f_year, '3');
        $data['finance_config'] = $this->Mportfolio->getPlanDetails('port_finance_fundraise', $c_option, '', $f_year, '1');

        $status = 3;
        $total_last_ytd = $total_now_ytd = 0;

        if ($month != '4') {
            $uptoLast_ytd = $this->Mportfolio->getFinanceDetails('plan_finance', $c_option, $month, $f_year, $status, 'last');
            $uptoNow_ytd = $this->Mportfolio->getFinanceDetails('plan_finance', $c_option, $month, $f_year, $status, 'now');

            foreach ($uptoLast_ytd as $value) {
                $a_ytd = str_replace(',', '', $value['net_profit']);
                $total_last_ytd += $a_ytd;
            }

            foreach ($uptoNow_ytd as $value) {
                $n_ytd = str_replace(',', '', $value['net_profit']);
                $total_now_ytd += $n_ytd;
            }
        }

        $data['ytd_value'] = $total_last_ytd;
        $data['current_ytd'] = $total_now_ytd;
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $rev_qual_option['module_id'] = 5;
        $data['rev_qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $rev_qual_option, '', $f_year, '1');

        $prof_qual_option['module_id'] = 6;
        $data['prof_qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $prof_qual_option, '', $f_year, '1');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/finance');
    }

    public function addFinancePlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $data['revenue'] = $_POST['txtRevenue'];
        $data['cogs'] = $_POST['txtCOGS'];
        $data['gross_profit'] = $_POST['txtProfit'];
        $data['gross_margin'] = $_POST['txtMargin'];
        $data['sales_expenses'] = $_POST['txtSales'];
        $data['market_expenses'] = $_POST['txtMarket'];
        $data['rd_expenses'] = $_POST['txtRD'];
        $data['salaries'] = $_POST['txtSalaries'];
        $data['over_heads'] = $_POST['txtOverheads'];
        $data['other_optg'] = $_POST['txtOPTG'];
        $data['total_expenses'] = $_POST['txtExpenditure'];
        $data['net_profit'] = $_POST['txtnetProfit'];
        $data['ytd_amount'] = $_POST['txtYTD'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        $data['revenue_achievement'] = $_POST['rev_achieveContent'];
        $data['profit_achievement'] = $_POST['prof_achieveContent'];

        $checkExist = $this->Mportfolio->getDetails('plan_finance', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_finance', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_finance', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Finance details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/finance/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function loans($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_loans', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_loans', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['loan_plan'] = $this->Mportfolio->getPlanDetails('plan_loans', $plan, '', $f_year, $status);
        $data['finance_plan'] = $this->Mportfolio->getPlanDetails('plan_finance', $plan, '', $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/loans');
    }

    public function addLoanPlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        $data['long_term'] = $_POST['longTerm'];
        $data['short_term'] = $_POST['shortTerm'];
        $data['long_interest'] = $_POST['longInterest'];
        $data['short_interest'] = $_POST['shortInterest'];
        $data['np_interest'] = $_POST['lessInterest'];
        $data['acc_payable'] = $_POST['accPayable'];
        $data['acc_receivable'] = $_POST['accReceive'];
        $data['inventory'] = $_POST['inventory'];
        $data['payable_days'] = $_POST['dayPayable'];
        $data['receivable_days'] = $_POST['dayReceive'];
        $data['inventory_days'] = $_POST['dayInvent'];
        $data['bank_cash'] = $_POST['bankCash'];
        $data['total_value'] = $_POST['txtValue'];
        $data['wc_days'] = $_POST['wcDay'];
        $data['runway'] = $_POST['runWay'];

        $checkExist = $this->Mportfolio->getDetails('plan_loans', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_loans', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_loans', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Loan details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/loans/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function vif_funding($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $qual_module['module_id'] = 7;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/vif_funding/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_loans', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
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

        $plan['inv_id'] = $equity_cond['inv_id'] = $qual_cond['inv_id'] = $id;
//        $plan['month'] = $month;
        $data['current_month'] = $equity_cond['month'] = $qual_cond['month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['vif_plan'] = $this->Mportfolio->getPlanDetails('plan_vif_funding', $plan, '', $f_year, $status);
        $data['vif_config'] = $this->Mportfolio->getPlanDetails('port_vif_funding', $c_option, '', $f_year, '1');
        $donor['partner_id'] = $partner_id;
        $donor['status'] = 1;
        // $data['donor_list'] = $this->Mportfolio->getCommonData('port_donor_masters', $donor, '', '', $partner_id);
        $data['donor_list'] = $this->Sectorplan->getGrantFunderList();
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
		
		$data['program_type'] = $this->Mportfolio->getDetailsProgram('program_type', array('status'=>1),'','','','program_name');

        $qual_option['module_id'] = $qual_cond['module_id'] = 7;
        $data['qual_achieve'] = $this->Mportfolio->getFundraiseDetails('plan_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');
        $data['equity_list'] = $this->Mportfolio->getPlanDetails('plan_vif_equity', $equity_cond, '', $f_year, $status);

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/vif_funding');
    }

    public function addVifPlan() {
        $this->addQualitativePlan($_POST);
        $data['inv_id'] = $equity_data['inv_id'] = $_POST['innovation_id'];
        $data['financial_year'] = $equity_data['financial_year'] = $_POST['current_year'];
        $equity_data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['donor_name']); $i++) {
            if ($_POST['donor_name'][$i] != '') {
                $data = array();
                $data['inv_id'] = $_POST['innovation_id'];
                $data['financial_year'] = $_POST['current_year'];
//                $data['month'] = $_POST['current_month'];
                $option['id'] = $_POST['id'][$i];
                $data['port_vif_id'] = $_POST['port_vif_id'][$i];
                $data['donor'] = $_POST['donor_name'][$i];
				$data['program'] = $_POST["program"][$i];
                $data['milestone'] = $_POST['txtMilestone'][$i];
//                $data['month_disburse'] = $_POST['txtMonth'][$i];
                $data['month_disburse'] = (isset($_POST['txtMonth'][$i]) && $_POST['txtMonth'][$i] != '') ? date('Y-m-d', strtotime($_POST['txtMonth'][$i])) : '';
                $data['commited'] = $_POST['txtCommit'][$i];
                $data['disburse_amount'] = $_POST['txtDisbursedAmt'][$i];
                $data['comments'] = $_POST['txtComment'][$i];
                $data['disburse_date'] = (isset($_POST['txtDate'][$i]) && $_POST['txtDate'][$i] != '') ? date('Y-m-d', strtotime($_POST['txtDate'][$i])) : '';

                $checkExist = $this->Mportfolio->getDetails('plan_vif_funding', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_vif_funding', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_vif_funding', $data);
                }
            }
        }

        for ($i = 0; $i < php72_count($_POST['equity_date']); $i++) {
            if ($_POST['equity_date'][$i] != '') {
                $option['id'] = $_POST['equity_id'][$i];
                $equity_data['inv_id'] = $_POST['innovation_id'];
                $equity_data['financial_year'] = $_POST['current_year'];
                $equity_data['sha_date'] = isset($_POST['equity_date'][$i]) && $_POST['equity_date'][$i] != '' ? date("Y-m-d", strtotime($_POST['equity_date'][$i])) : "0000-00-00 00:00:00";
                $equity_data['incubatee_amount'] = $_POST['incubatee_amount'][$i];
                $equity_data['invest_amount'] = $_POST['invest_amount'][$i];
                $equity_data['comments'] = $this->db->escape_str($_POST['equity_comment'][$i]);
                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/equity_investment';

                if ($_FILES["equity_doc"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["equity_doc"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);

                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);

                    $_FILES['upload_single']['name'] = $_FILES['equity_doc']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['equity_doc']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['equity_doc']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['equity_doc']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['equity_doc']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $equity_data['sha_document'] = $upload_data['file_name'];
                    }
                    unset($config);
                } else if (isset($_POST['old_equity_doc'][$i]) && $_POST['old_equity_doc'][$i] != '') {
                    $equity_data['sha_document'] = $_POST['old_equity_doc'][$i];
                } else {
                    $equity_data['sha_document'] = '';
                }

                $checkExist = $this->Mportfolio->getDetails('plan_vif_equity', $option);
                if (php72_count($checkExist) > 0) {
                    $equity_data['updated_by'] = $this->session->userdata('emp_number');
                    $equity_data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_vif_equity', $equity_data, $option);
                } else {
                    $equity_data['created_by'] = $this->session->userdata('emp_number');
                    $equity_data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_vif_equity', $equity_data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Seed funding details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/vif_funding/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function fundraise($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $qual_module['module_id'] = 8;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_loans', $id, $least_month, $f_year);
        $get_plan_pending = $this->Mportfolio->getPlanMonths('plan_fundraise', $id, '', $f_year);
        $get_qualitative = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
        $month_merge = php72_array_merge($get_plan_pending, $get_qualitative);
        $final_month_menus = $group_months = $push_months = array();
        foreach ($month_merge as $k) {
            if (empty($group_months['months'])) {
                $group_months['months'] = $k['months'];
            } else {
                $group_months['months'] = $group_months['months'] . ', ' . $k['months'];
            }
        }
        $unique_month_value = array();
        $explode_months = explode(',', $group_months['months']);
        foreach ($explode_months as $m) {
            if (!in_array($m, $unique_month_value))
                array_push($unique_month_value, $m);
        }

        $final_month_menus['months'] = implode(',', $unique_month_value);
        array_push($push_months, $final_month_menus);
        $data['get_yearMonth'] = $push_months;

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

        $plan['inv_id'] = $qual_cond['inv_id'] = $id;
        $plan['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['loan_plan'] = $this->Mportfolio->getPlanDetails('plan_loans', $plan, '', $f_year, $status);
        $data['equity_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '1');
        $data['grand_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '4');
        $data['short_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '2');
        $data['long_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '3');
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = $qual_cond['module_id'] = 8;
        $data['qual_achieve'] = $this->Mportfolio->getFundraiseDetails('plan_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/fundraise');
    }

    public function addFundraisePlan() { #echo'<pre>';print_r($_POST);die;

        $this->addQualitativePlan($_POST);
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];

        for ($i = 0; $i < php72_count($_POST['equity_name']); $i++) {
            if ($_POST['equity_name'][$i] != '') {
                $option['id'] = $_POST['equity_id'][$i];
                $data['fund_type'] = 1;
                $data['name'] = $_POST['equity_name'][$i];
                $data['value'] = $_POST['equity_value'][$i];
                $data['equity_total'] = $_POST['equity_total'];
                $data['grand_total'] = $_POST['grand_total'];
                $data['short_total'] = $_POST['short_total'];
                $data['long_total'] = $_POST['long_total'];

                $checkExist = $this->Mportfolio->getDetails('plan_fundraise', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_fundraise', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_fundraise', $data);
                }
            }
        }

        for ($i = 0; $i < php72_count($_POST['grand_name']); $i++) {
            if ($_POST['grand_name'][$i] != '') {
                $option['id'] = $_POST['grand_id'][$i];
                $data['fund_type'] = 4;
                $data['name'] = $_POST['grand_name'][$i];
                $data['value'] = $_POST['grand_value'][$i];
                $data['equity_total'] = $_POST['equity_total'];
                $data['grand_total'] = $_POST['grand_total'];
                $data['short_total'] = $_POST['short_total'];
                $data['long_total'] = $_POST['long_total'];

                $checkExist = $this->Mportfolio->getDetails('plan_fundraise', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_fundraise', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_fundraise', $data);
                }
            }
        }

        for ($i = 0; $i < php72_count($_POST['short_name']); $i++) {
            if ($_POST['short_name'][$i] != '') {
                $option['id'] = $_POST['short_id'][$i];
                $data['fund_type'] = 2;
                $data['name'] = $_POST['short_name'][$i];
                $data['value'] = $_POST['short_value'][$i];
                $data['equity_total'] = $_POST['equity_total'];
                $data['grand_total'] = $_POST['grand_total'];
                $data['short_total'] = $_POST['short_total'];
                $data['long_total'] = $_POST['long_total'];

                $checkExist = $this->Mportfolio->getDetails('plan_fundraise', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_fundraise', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_fundraise', $data);
                }
            }
        }

        for ($i = 0; $i < php72_count($_POST['long_name']); $i++) {
            if ($_POST['long_name'][$i] != '') {
                $option['id'] = $_POST['long_id'][$i];
                $data['fund_type'] = 3;
                $data['name'] = $_POST['long_name'][$i];
                $data['value'] = $_POST['long_value'][$i];
                $data['equity_total'] = $_POST['equity_total'];
                $data['grand_total'] = $_POST['grand_total'];
                $data['short_total'] = $_POST['short_total'];
                $data['long_total'] = $_POST['long_total'];

                $checkExist = $this->Mportfolio->getDetails('plan_fundraise', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    //$query = $this->Mportfolio->updatePortfolioDetail('plan_fundraise', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    //$query = $this->Mportfolio->insertPortfolioDetail('plan_fundraise', $data);
                }
            }
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Fundraise details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/fundraise/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function impact($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $c_option['field_type'] = 4;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/impact/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_impact', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_impact', $id, '', $f_year);
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
        $data['pending_month'] = $pend = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['impact_plan'] = $this->Mportfolio->getPlanDetails('plan_impact', $plan, '', $f_year, $status);
        $data['metric_count'] = $this->Mportfolio->getPlanDetails('plan_impact_metric', $plan, '', $f_year, $status);

        $data['metric_plan'] = $this->Mportfolio->getImpactMetricInput($c_option, $f_year, '1');
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = 14;
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');

        $data['end_male_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 1, 1, $partner_id);
        $data['end_female_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 1, 2, $partner_id);
        $data['end_other_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 1, 3, $partner_id);
        $data['end_unknown_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 1, 4, $partner_id);

        $data['direct_male_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 2, 1, $partner_id);
        $data['direct_female_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 2, 2, $partner_id);
        $data['direct_other_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 2, 3, $partner_id);
        $data['direct_unknown_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 2, 4, $partner_id);

        $data['indirect_male_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 3, 1, $partner_id);
        $data['indirect_female_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 3, 2, $partner_id);
        $data['indirect_other_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 3, 3, $partner_id);
        $data['indirect_unknown_iris'] = $this->Mportfolio->getIRIScode($id, $f_year, 3, 4, $partner_id);
		
		$data['getMasterMetrics'] = $this->Mportfolio->getDetails('master_metrics',array('status'=>1));
		
        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/impact');
    }

    public function addImpactPlan() {
		
		
		
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $metric_option['inv_id'] = $metric_data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $metric_option['financial_year'] = $metric_data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $metric_option['month'] = $metric_data['month'] = $_POST['current_month'];

        $data['end_male'] = $_POST['end_male'];
        $data['end_female'] = $_POST['end_female'];
        $data['end_other'] = $_POST['end_other'];
        $data['end_unknown'] = $_POST['end_unknown'];
        $data['direct_male'] = $_POST['direct_male'];
        $data['direct_female'] = $_POST['direct_female'];
        $data['direct_other'] = $_POST['direct_other'];
        $data['direct_unknown'] = $_POST['direct_unknown'];
        $data['indirect_male'] = $_POST['indirect_male'];
        $data['indirect_female'] = $_POST['indirect_female'];
        $data['indirect_other'] = $_POST['indirect_other'];
        $data['indirect_unknown'] = $_POST['indirect_unknown'];
        $data['achievement_desc'] = $_POST['achieveContent'];

        $checkExist = $this->Mportfolio->getDetails('plan_impact', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_impact', $data, $option);
            $achievement_id = $checkExist[0]['id'];
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_impact', $data);
            $achievement_id = $this->db->insert_id();
        }

        $jw = 1;
		
		
		if($this->session->userdata('emp_number') ==457){
		
				
			 foreach ($_POST["metric"] as $key => $val) {
				// if ($_POST["metric"][$key] != '') {
				$metric_option['achievement_id'] = $metric_data['achievement_id'] = $achievement_id;
				$metric_option['plan_id'] = $metric_data['plan_id'] = $_POST["metric_plan_id"][$key];
				$metric_data['metric_value'] = isset($_POST["metric"][$key]) && $_POST["metric"][$key] != '' ? $_POST["metric"][$key] : '';
				
				
					#ECHO'<pre>';print_r($metric_option);
			

				$metri_checkExist = $this->Mportfolio->getDetails('plan_impact_metric', $metric_option);
				//ECHO'<pre>';print_r($metric_data);
				if (php72_count($metri_checkExist) > 0) {
					$metric_data['updated_by'] = $this->session->userdata('emp_number');
					$metric_data['status'] = 0;
					#$query = $this->Mportfolio->updatePortfolioDetail('plan_impact_metric', $metric_data, $metric_option);
				} else {
					$metric_data['created_by'] = $this->session->userdata('emp_number');
					$metric_data['created_at'] = date("Y-m-d H:i:s");
					#$query = $this->Mportfolio->insertPortfolioDetail('plan_impact_metric', $metric_data);
				}
				// }
				$jw++;
			}
			//die;
				#echo'asdasd';die;
		}
			
			
		
        foreach ($_POST["metric"] as $key => $val) {
            // if ($_POST["metric"][$key] != '') {
            $metric_option['achievement_id'] = $metric_data['achievement_id'] = $achievement_id;
            $metric_option['plan_id'] = $metric_data['plan_id'] = $_POST["metric_plan_id"][$key];
            $metric_data['metric_value'] = isset($_POST["metric"][$key]) && $_POST["metric"][$key] != '' ? $_POST["metric"][$key] : '';
			
			
		
		

            $metri_checkExist = $this->Mportfolio->getDetails('plan_impact_metric', $metric_option);
            if (php72_count($metri_checkExist) > 0) {
                $metric_data['updated_by'] = $this->session->userdata('emp_number');
                $metric_data['status'] = 0;
                $query = $this->Mportfolio->updatePortfolioDetail('plan_impact_metric', $metric_data, $metric_option);
            } else {
                $metric_data['created_by'] = $this->session->userdata('emp_number');
                $metric_data['created_at'] = date("Y-m-d H:i:s");
                $query = $this->Mportfolio->insertPortfolioDetail('plan_impact_metric', $metric_data);
            }
            // }
            $j++;
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Impact details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/impact/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function hiring($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $qual_module['module_id'] = 15;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/hiring/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_team_hiring', $id, $least_month, $f_year);
        $get_plan_pending = $this->Mportfolio->getPlanMonths('plan_team_hiring', $id, '', $f_year);
        $get_qualitative = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
        $month_merge = php72_array_merge($get_plan_pending, $get_qualitative);
        $final_month_menus = $group_months = $push_months = array();
        foreach ($month_merge as $k) {
            if (empty($group_months['months'])) {
                $group_months['months'] = $k['months'];
            } else {
                $group_months['months'] = $group_months['months'] . ', ' . $k['months'];
            }
        }
        $unique_month_value = array();
        $explode_months = explode(',', $group_months['months']);
        foreach ($explode_months as $m) {
            if (!in_array($m, $unique_month_value))
                array_push($unique_month_value, $m);
        }

        $final_month_menus['months'] = implode(',', $unique_month_value);
        array_push($push_months, $final_month_menus);
        $data['get_yearMonth'] = $push_months;

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

        $plan['inv_id'] = $qual_cond['inv_id'] = $id;
        $c_option['month'] = $plan['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['team_plan'] = $this->Mportfolio->getPlanDetails('plan_team_hiring', $plan, '', $f_year, $status, '', 'job_name');

        $active['status'] = '1';
        $active['partner_id'] = $partner_id;
        $data['designation_list'] = $this->Mportfolio->getCommonData('port_team_designations', $active, 'name', '', $partner_id);

//        $data['job_list'] = $this->Mportfolio->getHiringJobs('plan_team_hiring', $c_option, $f_year, $status);
        $data['hire_list'] = $this->Mportfolio->getHiringJobs('plan_team', $c_option, $f_year, $status, '1');
        $data['exit_list'] = $this->Mportfolio->getHiringJobs('plan_team', $c_option, $f_year, $status, '2');
        $data['survey_list'] = $this->Mportfolio->getHiringJobs('plan_team', $c_option, $f_year, $status, '3');
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = $qual_cond['module_id'] = 15;
        $data['qual_achieve'] = $this->Mportfolio->getFundraiseDetails('plan_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/team_hiring');
    }

    public function addHiringPlan() {
        $this->addQualitativePlan($_POST);
        $option['inv_id'] = $hire_data['inv_id'] = $exit_data['inv_id'] = $survey_data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $hire_data['month'] = $exit_data['month'] = $survey_data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $hire_data['financial_year'] = $exit_data['financial_year'] = $survey_data['financial_year'] = $_POST['current_year'];
        $hire_data['fy_date'] = $exit_data['fy_date'] = $survey_data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

        for ($i = 0; $i < php72_count($_POST['hire_position']); $i++) {
            if ($_POST['hire_position'][$i] != '') {
                $option['id'] = $_POST['hire_id'][$i];
                $option['field_type'] = $hire_data['field_type'] = 1;
                $hire_data['role'] = $_POST['hire_position'][$i];
                $hire_data['gender'] = $_POST['hire_gender'][$i];
                $hire_data['date_value'] = isset($_POST['hire_openDate'][$i]) && $_POST['hire_openDate'][$i] != '' ? date("Y-m-d", strtotime($_POST['hire_openDate'][$i])) : "0000-00-00 00:00:00";
                $hire_data['signed_date'] = isset($_POST['hire_signDate'][$i]) && $_POST['hire_signDate'][$i] != '' ? date("Y-m-d", strtotime($_POST['hire_signDate'][$i])) : "0000-00-00 00:00:00";
                $hire_data['comments'] = $this->db->escape_str($_POST['hire_comment'][$i]);

                $checkExist = $this->Mportfolio->getDetails('plan_team', $option);
                if (php72_count($checkExist) > 0) {
                    $hire_data['updated_by'] = $this->session->userdata('emp_number');
                    $hire_data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_team', $hire_data, $option);
                } else {
                    $hire_data['created_by'] = $this->session->userdata('emp_number');
                    $hire_data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_team', $hire_data);
                }
            }
        }

        for ($i = 0; $i < php72_count($_POST['exit_position']); $i++) {
            if ($_POST['exit_position'][$i] != '') {
                $option['id'] = $_POST['exit_id'][$i];
                $option['field_type'] = $exit_data['field_type'] = 2;
                $exit_data['role'] = $_POST['exit_position'][$i];
                $exit_data['gender'] = $_POST['exit_gender'][$i];
                $exit_data['exit_type'] = $_POST['exit_type'][$i];
                $exit_data['date_value'] = isset($_POST['exit_date'][$i]) && $_POST['exit_date'][$i] != '' ? date("Y-m-d", strtotime($_POST['exit_date'][$i])) : "0000-00-00 00:00:00";
                $exit_data['comments'] = $this->db->escape_str($_POST['exit_comment'][$i]);

                $checkExist = $this->Mportfolio->getDetails('plan_team', $option);
                if (php72_count($checkExist) > 0) {
                    $exit_data['updated_by'] = $this->session->userdata('emp_number');
                    $exit_data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_team', $exit_data, $option);
                } else {
                    $exit_data['created_by'] = $this->session->userdata('emp_number');
                    $exit_data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_team', $exit_data);
                }
            }
        }

        for ($i = 0; $i < php72_count($_POST['survey_date']); $i++) {
            if ($_POST['survey_date'][$i] != '') {
                $option['id'] = $_POST['survey_id'][$i];
                $option['field_type'] = $survey_data['field_type'] = 3;
                $survey_data['date_value'] = isset($_POST['survey_date'][$i]) && $_POST['survey_date'][$i] != '' ? date("Y-m-d", strtotime($_POST['survey_date'][$i])) : "0000-00-00 00:00:00";
                $survey_data['comments'] = $this->db->escape_str($_POST['survey_comment'][$i]);
//                $data['document'] = $this->portfolio_file_upload('app', 'uploads/portfolio/company', 'document_file', 'doc|docx|ppt|pptx|pdf', $_POST['old_doc']);
                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/team_hiring';

                if ($_FILES["survey_doc"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["survey_doc"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);

                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);

                    $_FILES['upload_single']['name'] = $_FILES['survey_doc']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['survey_doc']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['survey_doc']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['survey_doc']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['survey_doc']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $survey_data['document'] = $upload_data['file_name'];
                    }
                    unset($config);
                } else if (isset($_POST['old_survey_doc'][$i]) && $_POST['old_survey_doc'][$i] != '') {
                    $survey_data['document'] = $_POST['old_survey_doc'][$i];
                } else {
                    $survey_data['document'] = '';
                }

                $checkExist = $this->Mportfolio->getDetails('plan_team', $option);
                if (php72_count($checkExist) > 0) {
                    $survey_data['updated_by'] = $this->session->userdata('emp_number');
                    $survey_data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_team', $survey_data, $option);
                } else {
                    $survey_data['created_by'] = $this->session->userdata('emp_number');
                    $survey_data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_team', $survey_data);
                }
            }
        }

//        for ($i = 0; $i < count($_POST['team_name']); $i++) {
//            if ($_POST['team_name'][$i] != '') {
//                $option['id'] = $_POST['team_id'][$i];
//                $data['job_name'] = $_POST['team_name'][$i];
//                $data['ytd_count'] = $_POST['team_ytd'][$i];
//                $data['current_value'] = $_POST['current_number'][$i];
//                $data['total_ytd'] = $_POST['total_ytd'];
//                $data['total_value'] = $_POST['total_value'];
//
//                $checkExist = $this->Mportfolio->getDetails('plan_team_hiring', $option);
//                if (count($checkExist) > 0) {
//                    $data['updated_by'] = $this->session->userdata('emp_number');
//                    $data['status'] = 0;
//                    $query = $this->Mportfolio->updatePortfolioDetail('plan_team_hiring', $data, $option);
//                } else {
//                    $data['created_by'] = $this->session->userdata('emp_number');
//                    $data['created_at'] = date("Y-m-d H:i:s");
//                    $query = $this->Mportfolio->insertPortfolioDetail('plan_team_hiring', $data);
//                }
//            }
//        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Hiring details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/hiring/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function deleteHiringAchieve() {
        $this->db->set('status', 3);
        $id = $this->input->post('id');
        $option = "'" . php72_implode("', '", $id) . "'";
        $cond['inv_id'] = $this->input->post('inv_id');
        $cond['field_type'] = $this->input->post('field');
        $cond['month'] = $this->input->post('cur_month');
        $cond['financial_year'] = $this->input->post('fin_year');
        $query = $this->Mportfolio->deleteHiringAchievement('plan_team', $cond, $option);
        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function deleteSeedingEquity() {
        $this->db->set('status', 3);
        $id = $this->input->post('id');
        $option = "'" . php72_implode("', '", $id) . "'";
        $cond['inv_id'] = $this->input->post('inv_id');
        $cond['month'] = $this->input->post('cur_month');
        $cond['financial_year'] = $this->input->post('fin_year');
        $query = $this->Mportfolio->deleteHiringAchievement('plan_vif_equity', $cond, $option);
        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function tap($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $qual_module['module_id'] = 10;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_tap', $id, $least_month, $f_year);
        $get_plan_pending = $this->Mportfolio->getPlanMonths('plan_tap', $id, '', $f_year);
        $get_qualitative = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
        $month_merge = php72_array_merge($get_plan_pending, $get_qualitative);
        $final_month_menus = $group_months = $push_months = array();
        foreach ($month_merge as $k) {
            if (empty($group_months['months'])) {
                $group_months['months'] = $k['months'];
            } else {
                $group_months['months'] = $group_months['months'] . ', ' . $k['months'];
            }
        }
        $unique_month_value = array();
        $explode_months = explode(',', $group_months['months']);
        foreach ($explode_months as $m) {
            if (!in_array($m, $unique_month_value))
                array_push($unique_month_value, $m);
        }

        $final_month_menus['months'] = implode(',', $unique_month_value);
        array_push($push_months, $final_month_menus);
        $data['get_yearMonth'] = $push_months;

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

        $plan['inv_id'] = $qual_cond['inv_id'] = $id;
        // $plan['month'] = $qual_cond['month'] = $month;
        $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['tap_plan'] = $this->Mportfolio->getPlanDetails('plan_tap', $plan, '', $f_year, $status);
        $status = 1;
        $data['tap_config'] = $this->Mportfolio->getPlanDetails('port_ttm_tap', $c_option, '', $f_year, $status);

        $service['partner_id'] = $partner_id;
        $service['status'] = 1;
        $data['service_providers'] = $this->Mportfolio->getCommonData('port_service_providers', $service, '', '', $partner_id);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = $qual_cond['module_id'] = 10;
        $data['qual_achieve'] = $this->Mportfolio->getFundraiseDetails('plan_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');
		$data['program_type'] = $this->Mportfolio->getDetailsProgram('program_type', array('status'=>1),'','','','program_name');
		
        $active['status'] = '1';
        $data['focus_area'] = $this->Mportfolio->getCommonData('port_tap_focus_area', $active, 'name', '', $partner_id);

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/tap');
    }

    public function addTapPlan() {
        $this->addQualitativePlan($_POST);
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['requirement']); $i++) {
            if ($_POST['requirement'][$i] != '') {
                $option['id'] = $_POST['tap_id'][$i];
                $option['port_tap_id'] = $data['port_tap_id'] = $_POST['port_tap_id'][$i];
                $data['requirement'] = $_POST['requirement'][$i];
                $data['firm_engaged'] = $_POST['firm_name'][$i];
                $data['focus_area'] = $_POST['focus_area'][$i];
                $data['comment'] = $_POST['comments'][$i];
                $data['need_by'] = (isset($_POST['need_by'][$i]) && $_POST['need_by'][$i] != '') ? date('Y-m-d', strtotime($_POST['need_by'][$i])) : '';
                $data['month_engaged'] = (isset($_POST['start_date'][$i]) && $_POST['start_date'][$i] != '') ? date('Y-m-d', strtotime($_POST['start_date'][$i])) : '';
                $data['month_end'] = (isset($_POST['end_date'][$i]) && $_POST['end_date'][$i] != '') ? date('Y-m-d', strtotime($_POST['end_date'][$i])) : '';
				
				$data['contract_amount'] = str_replace(",", "",$_POST['contract_amount'][$i]);
				
                $upload_path_contract = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/tap/contract';
                if ($_FILES["contract_file"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["contract_file"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);

                    $config['upload_path'] = $upload_path_contract;
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);

                    $_FILES['upload_single']['name'] = $_FILES['contract_file']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['contract_file']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['contract_file']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['contract_file']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['contract_file']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $data['contract_doc'] = $upload_data['file_name'];
                    }
                    unset($config);
                } else if (isset($_POST['old_contract_doc'][$i]) && $_POST['old_contract_doc'][$i] != '') {
                    $data['contract_doc'] = $_POST['old_contract_doc'][$i];
                } else {
                    $data['contract_doc'] = '';
                }

                $upload_path_reports = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/tap/other';

                if ($_FILES["reports_file"]["name"][$i] != "") {
                    $split_name1 = explode('.', $_FILES["reports_file"]["name"][$i]);
                    $get_extension1 = array_pop($split_name1);
                    $get_name1 = implode('', $split_name1);

                    $config1['upload_path'] = $upload_path_reports;
                    $config1['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                    $rename_file1 = str_replace(' ', '_', strtolower($get_name1));
                    $new_name1 = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file1);
                    $config1['file_name'] = date('Ymdhis') . '_' . $new_name1 . '.' . $get_extension1;

                    $this->upload->initialize($config1);

                    $_FILES['upload_single']['name'] = $_FILES['reports_file']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['reports_file']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['reports_file']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['reports_file']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['reports_file']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error1 = $this->upload->display_errors();
                        echo $upload_error1 . "--" . $i;
                    } else {
                        $upload_data1 = $this->upload->data();
                        $data['other_doc'] = $upload_data1['file_name'];
                    }
                    unset($config1);
                } else if (isset($_POST['old_reports_doc'][$i]) && $_POST['old_reports_doc'][$i] != '') {
                    $data['other_doc'] = $_POST['old_reports_doc'][$i];
                } else {
                    $data['other_doc'] = '';
                }

                $checkExist = $this->Mportfolio->getDetails('plan_tap', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_tap', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_tap', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "TAP details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/tap/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function mentor($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $qual_module['module_id'] = 9;
        $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/mentor/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_mentor', $id, $least_month, $f_year);
        $get_plan_pending = $this->Mportfolio->getPlanMonths('plan_mentor', $id, '', $f_year);
        $get_qualitative = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
        $month_merge = php72_array_merge($get_plan_pending, $get_qualitative);
        $final_month_menus = $group_months = $push_months = array();
        foreach ($month_merge as $k) {
            if (empty($group_months['months'])) {
                $group_months['months'] = $k['months'];
            } else {
                $group_months['months'] = $group_months['months'] . ', ' . $k['months'];
            }
        }
        $unique_month_value = array();
        $explode_months = explode(',', $group_months['months']);
        foreach ($explode_months as $m) {
            if (!in_array($m, $unique_month_value))
                array_push($unique_month_value, $m);
        }

        $final_month_menus['months'] = implode(',', $unique_month_value);
        array_push($push_months, $final_month_menus);
        $data['get_yearMonth'] = $push_months;

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

        $plan['inv_id'] = $qual_cond['inv_id'] = $id;
        $plan['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

        $data['mentor_master'] = $this->Mportfolio->getConfigMentorsInput($id, $f_year, $month);
        $data['mentor_plan'] = $this->Mportfolio->getPlanDetails('plan_mentor', $plan, '', $f_year, $status);

        $userSetup1 = $this->Mmaster->getUserSetup_branch($partner_id);
        $data['emp_details'] = $this->Muser->getUsersList($userSetup1['abi'], $partner_id);
        $data['emp_mentors'] = $this->Mportfolio->getMentorList($partner_id);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = $qual_cond['module_id'] = 9;
        $data['qual_achieve'] = $this->Mportfolio->getFundraiseDetails('plan_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');
		$data['program_type'] = $this->Mportfolio->getDetailsProgram('program_type', array('status'=>1),'','','','program_name');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/mentor');
    }

    public function addMentorPlan() {
        $this->addQualitativePlan($_POST);
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['config_id']); $i++) {
            if ($_POST['name'][$i] != '') {
                $option['id'] = $_POST['mentor_id'][$i];
                $data['assigned_to'] = $_POST['name'][$i];
                $data['hours_spent'] = $_POST['hours_spent'][$i];
                $data['purpose'] = $_POST['purpose'][$i];
				$data['invoice_amount'] = str_replace(",", "",$_POST['invoice_amount'][$i]);
                $data['config_id'] = $_POST['config_id'][$i];
				
				//Document Upload
				$upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/mentor_invoice';
				if ($_FILES["document"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["document"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);

                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);

                    $_FILES['upload_single']['name'] = $_FILES['document']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['document']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['document']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['document']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['document']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $data['document'] = $upload_data['file_name'];
                    }
					
                    unset($config);
                } else if (isset($_POST['old_document'][$i]) && $_POST['old_document'][$i] != '') {
                    $data['document'] = $_POST['old_document'][$i];
                } else {
                    $data['document'] = '';
                }
				

                $checkExist = $this->Mportfolio->getDetails('plan_mentor', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_mentor', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_mentor', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Mentor details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/mentor/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function nontap($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $qual_module['module_id'] = 11;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_partnerships', $id, $least_month, $f_year);
        $get_plan_pending = $this->Mportfolio->getPlanMonths('plan_partnerships', $id, '', $f_year);
        $get_qualitative = $this->Mportfolio->getPlanMonths('plan_qualitative_data', $id, '', $f_year, $qual_module);
        $month_merge = php72_array_merge($get_plan_pending, $get_qualitative);
        $final_month_menus = $group_months = $push_months = array();
        foreach ($month_merge as $k) {
            if (empty($group_months['months'])) {
                $group_months['months'] = $k['months'];
            } else {
                $group_months['months'] = $group_months['months'] . ', ' . $k['months'];
            }
        }
        $unique_month_value = array();
        $explode_months = explode(',', $group_months['months']);
        foreach ($explode_months as $m) {
            if (!in_array($m, $unique_month_value))
                array_push($unique_month_value, $m);
        }

        $final_month_menus['months'] = implode(',', $unique_month_value);
        array_push($push_months, $final_month_menus);
        $data['get_yearMonth'] = $push_months;

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

        $plan['inv_id'] = $qual_cond['inv_id'] = $id;
        $plan['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['nontap_plan'] = $nontap_plan = $this->Mportfolio->getPlanDetails('plan_partnerships', $plan, '', $f_year, $status);
        $data['nontap_config'] = $this->Mportfolio->getPlanDetails('port_ttm_partnership', $c_option, '', $f_year, '1');

        $plan = $nontap_plan[0];
        $data['plan_count'] = $plan_count = isset($plan) ? php72_count($nontap_plan) : 0;
        if ($plan_count == 0) {
            $service1['inv_id'] = $id;
            $service1['financial_year'] = $f_year;
            $service1['status'] = 1;
            $data['nontap_plan'] = $this->Mportfolio->getCommonData('port_ttm_partnership', $service1);
        }

        $service['partner_id'] = $partner_id;
        $service['status'] = 1;
        $data['partner_list'] = $this->Mportfolio->getCommonData('port_ttm_partnership_master', $service, '', '', $partner_id);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = $qual_cond['module_id'] = 11;
        $data['qual_achieve'] = $this->Mportfolio->getFundraiseDetails('plan_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');
		$data['program_type'] = $this->Mportfolio->getDetailsProgram('program_type', array('status'=>1),'','','','program_name');
		
        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/nontap');
    }

    public function addNontapPlan() {
        $this->addQualitativePlan($_POST);
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['type_id']); $i++) {
            if ($_POST['type_id'][$i] != '') {
                $option['type'] = $data['type'] = $_POST['type_id'][$i];
                $option['port_nontap_id'] = $data['port_nontap_id'] = $_POST['port_nontap_id'][$i];
                $data['partner_name'] = $_POST['partner_name'][$i];
                $data['comments'] = $_POST['partner_comments'][$i];
                $data['need_by'] = (isset($_POST['eng_date'][$i]) && $_POST['eng_date'][$i] != '') ? date('Y-m-d', strtotime($_POST['eng_date'][$i])) : '';
                if (isset($_POST['plan_nontap_id'][$i])) {
                    $option['id'] = $_POST['plan_nontap_id'][$i];
                }
				$data['sales_lead'] = $_POST['sales_lead'][$i];
				$data['revenue_amount'] = str_replace(",", "",$_POST['revenue_amount'][$i]); $_POST['revenue_amount'][$i];
				
                $checkExist = $this->Mportfolio->getDetails('plan_partnerships', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_partnerships', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_partnerships', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Non-TAP details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/nontap/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function notes($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
		$f_year = '';
        $plan['inv_id'] = $id;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        //$data['note_plan'] = $this->Mportfolio->getPlanDetails('plan_meeting_notes', $plan, '', $f_year, $status);
        $data['meeting_type'] = $this->Mdiligence->get_data('diligence_meeting_type');
        $data['monthlist'] = $this->month();
        $donor['partner_id'] = $partner_id;
        $donor['status'] = 1;
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
            $data['note_plan'] = $this->Mportfolio->getPlanDetails('plan_meeting_notes', $plan, '', $f_year, $status, '', 'meeting_date', 'desc');
        }else{
            $data['note_plan'] = $this->Mportfolio->getPlanDetails('plan_meeting_notes', $plan, '', $f_year, $status, '', 'meeting_date', 'desc');
			
			/* $data['note_plan'] = $this->Mportfolio->getPlanDetails('plan_meeting_notes', $plan, '', '', $status, '', 'meeting_date', 'desc'); */
        }
        
        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/notes');
    }

    public function addNotesPlan() {
        for ($i = 0; $i < php72_count($_POST['start_date']); $i++) {
            if ($_POST['start_date'][$i] != '') {
                $data = array();
                $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
                $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
                $option['id'] = $_POST['id'][$i];

                $data['meeting_date'] = (isset($_POST['start_date'][$i]) && $_POST['start_date'][$i] != '') ? date('Y-m-d', strtotime($_POST['start_date'][$i])) : '';
                $data['meeting_type'] = $_POST['m_name'][$i];
                $data['description'] = $_POST['cmnt_desc'][$i];
                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';

                if ($_FILES["sow_doc"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["sow_doc"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);

                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx|xls|xlsx';
                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);

                    $_FILES['upload_single']['name'] = $_FILES['sow_doc']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['sow_doc']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['sow_doc']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['sow_doc']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['sow_doc']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $data['document'] = $upload_data['file_name'];
                    }
                    unset($config);
                } else if (isset($_POST['old_sow_doc'][$i]) && $_POST['old_sow_doc'][$i] != '') {
                    $data['document'] = $_POST['old_sow_doc'][$i];
                } else {
                    $data['document'] = '';
                }

                $checkExist = $this->Mportfolio->getDetails('plan_meeting_notes', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_meeting_notes', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_meeting_notes', $data);
                }
            }
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Call notes details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/notes/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function milestone($id = '', $year = '', $milestone = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $condmiles['inv_id'] = $id;
        if ($milestone != '') {
            $condmiles['id'] = $milestone;
        }

        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $data['plan_header'] = $this->plan_header($id);

        if ($year == '') {
            foreach ($data['fin_year'] as $fy) {
                if ($fy['status'] == 1) {
                    $f_year = $fy['fin_year'];
                }
            }
        } else {
            $f_year = $year;
        }

        $data['get_milestone'] = $this->Mportfolio->getDetails('port_project_milestone', $condmiles, $status);

        if ($milestone == '') {
            $actual_mile_id = $data['get_milestone'][0]['id'];
        } else {
            $actual_mile_id = $milestone;
        }


        $option['id'] = $appoption['inv_id'] = $c_option['inv_id'] = $projs['inv_id'] = $taskmiles['inv_id'] = $data['innovation_id'] = $id;
        $data['milestone_id'] = $projs['milestone_id'] = $taskmiles['milestone_id'] = $actual_mile_id;
        $data['company_data'] = $this->Mportfolio->getDetails('port_company_data', $c_option, $status);
        $data['business_nature'] = $this->Mportfolio->getDetails('port_business', $c_option, $status);
        $data['get_innovation'] = $invdetails = $this->Mportfolio->getDetails('innovation_pool', $option, $status);
        $data['get_allmilestone'] = $this->Mportfolio->getDetails('temp_project_milestone', $c_option, $status, '', 'asc');

        $p_area['partner_id'] = $partner_id;
        $p_area['status'] = 1;
        $data['project_area'] = $this->Mportfolio->getCommonData('port_project_area', $p_area, 'name', '', $partner_id);
        $data['project_assign_type'] = $this->Mportfolio->getCommonData('port_project_assign_type', $p_area, 'name', '', $partner_id);

        $data['get_task'] = $taskdetails = $this->Mportfolio->getDetails('temp_project_task', $taskmiles, $status, '', 'asc');
        $projs['task_id'] = $taskdetails[0]['id'];
        $data['get_proj'] = $this->Mportfolio->getDetails('temp_project_details', $projs, $status);

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
            if ($this->session->userdata['sector_lead'] == 1) {
                $get_data = $this->Mportfolio->getApprovalDetails('port_project_milestone', $c_option, $pending);
                if (php72_count($get_data) > 0) {
                    redirect('portfolio/milestone/' . $id . '/' . $get_data[0]['financial_year'] . '/' . $get_data[0]['id']);
                }
            }
        }
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/milestone');
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

    public function meeting($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_board_meetings', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_board_meetings', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['boardmeet_plan'] = $this->Mportfolio->getPlanDetails('plan_board_meetings', $plan, '', $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = 13;
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/meeting');
    }

    public function addboardmeetplan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }

        if ($_POST['meet_date'] != '')
            $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
        $data['meeting_type'] = $_POST['type_meet'];
        $data['venue'] = $_POST['venue'];
        $data['external'] = $_POST['board_external'];
        $data['internal'] = $_POST['board_internal'];
        $data['observers'] = $_POST['board_observer'];
        $data['invitees'] = $_POST['other_inviteees'];
        $data['document_link'] = $_POST['link_drive'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        $data['achievement_desc'] = $_POST['achieveContent'];
//        $data['document'] = $this->portfolio_file_upload('app', 'uploads/portfolio/plan-boardmeet', 'document_file', 'doc|docx|ppt|pptx|pdf', $_POST['old_doc']);

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/portfolio/plan-boardmeet';

        if ($_FILES["document_file"]["name"] != "") {
            $split_name = explode('.', $_FILES["document_file"]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

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
            $this->session->set_flashdata('successMsg', "Board meeting details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/meeting/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
    }

    public function dp($id = '', $year = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $qual_option['inv_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
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

        $get_current_date = date('d');
        $get_current_month = date('n');
        $url_fyear = $f_year;

        if ($month == '') {
            if ($get_current_date >= 16) {
                $past_month = $get_current_month;
            } else {
                $set_past_month = $get_current_month - 1;
                if ($set_past_month == 0) {
                    $past_month = '12';
                } else if ($set_past_month == 3) {
                    $url_fyear = $f_year - 1;
                    $past_month = $set_past_month;
                } else {
                    $past_month = $set_past_month;
                }
            }
            redirect('portfolio/all_forms/dp/' . $id . '/' . $f_year . '/' . $past_month);
        }

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_dp', $id, $least_month, $f_year);
        $data['get_yearMonth'] = $this->Mportfolio->getPlanMonths('plan_dp', $id, '', $f_year);
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
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }
        $data['dp_plan'] = $this->Mportfolio->getPlanDetails('plan_dp', $plan, '', $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $qual_option['module_id'] = 12;
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('port_qualitative_data', $qual_option, '', $f_year, '1');

        $this->load->vars($data);
        $this->load->view('portfolio/all_forms/dp');
    }

    public function adddpplan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }

        $data['purpose'] = $_POST['purpose_meet'];
        if ($_POST['meet_date'] != '')
            $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
        $data['location'] = $_POST['location'];
        $data['external_attendees'] = $_POST['external_attd'];
        $data['document_link'] = $_POST['link_drive'];
        $data['document'] = $this->portfolio_file_upload('app', 'uploads/portfolio/plan-dpplan', 'document_file', 'doc|docx|ppt|pptx|pdf', $_POST['old_doc']);
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        $data['achievement_desc'] = $_POST['achieveContent'];

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
            $this->session->set_flashdata('successMsg', "Diagnostic details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/all_forms/dp/' . $_POST['innovation_id'] . '/' . $_POST['current_year'] . '/' . $_POST['current_month']);
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

    public function addQualitativePlan($post) {
        $qual_option['inv_id'] = $qual_data['inv_id'] = $post['innovation_id'];
        $qual_option['financial_year'] = $qual_data['financial_year'] = $post['current_year'];
        $qual_option['month'] = $qual_data['month'] = $post['current_month'];
        $qual_option['module_id'] = $qual_data['module_id'] = $post['module_id'];
        $qual_data['description'] = $post['achieveContent'];

        if ($post['current_month'] == '1' || $post['current_month'] == '2' || $post['current_month'] == '3') {
            $fyear = $post['current_year'] + 1;
        } else {
            $fyear = $post['current_year'];
        }

        $qual_data['fy_date'] = $fyear . '-' . $post['current_month'] . '-01 00:00:00';

        $checkExist = $this->Mportfolio->getDetails('plan_qualitative_data', $qual_option);
        if (php72_count($checkExist) > 0) {
            $qual_data['updated_by'] = $this->session->userdata('emp_number');
            $qual_data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_qualitative_data', $qual_data, $qual_option);
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_qualitative_data', $qual_data);
        }
    }

}
