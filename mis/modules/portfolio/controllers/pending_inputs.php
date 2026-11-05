<?php

class Pending_inputs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('Mportfolio');
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

    /* for notification exclamation */

    public function pending_plans($id, $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $partner_id = $this->session->userdata('partner_id');
        $fin_year = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = $fin_year[0]['fin_year'];
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $month_notify = isset($month) && $month != '' ? $month : $last_month;

        $plans_arr = array('plan_updates', 'plan_board_meetings', 'plan_dp', 'plan_finance', 'plan_fundraise', 'plan_impact', 'plan_loans', 'plan_mentor', 'plan_partnerships', 'plan_channel', 'plan_pipeline', 'plan_sales', 'plan_tap', 'plan_team_hiring', 'plan_vif_funding');

        // $i = 0;
        // foreach ($plans_arr as $pl_arr) {
        //     $get_monthCount = $this->Mportfolio->getUpdatesCount($pl_arr, $id, $month_notify, $f_year);
        //     for ($i = ($arr - 1); $i >= 0; $i--) {
        //         $derivemonth[$pl_arr][] = array_search($getmonth[$i], $actualMonth);
        //         $monthName[] = $getmonth[$i];
        //     }
        //     foreach ($get_monthCount as $val) {
        //         if (in_array($val['month'], $derivemonth[$pl_arr])) {
        //             $key = array_search($val['month'], $derivemonth[$pl_arr]);
        //             unset($derivemonth[$pl_arr][$key]);
        //         }
        //     }
        //     if (count($derivemonth[$pl_arr]) > 0) {
        //         $data[$pl_arr . '_exclam'] = 1;
        //     } else {
        //         $data[$pl_arr . '_exclam'] = 0;
        //     }
        // }

        $i = 0;
        foreach ($plans_arr as $pl_arr) {
            $get_monthCount = $this->Mportfolio->getUpdatesCount($pl_arr, $id, $month_notify, $f_year);
            if (php72_count($get_monthCount) == 0) {
                $data[$pl_arr . '_exclam'] = 1;
            } else {
                $data[$pl_arr . '_exclam'] = 0;
            }
        }

        $get_vif_Count = $this->Mportfolio->getUpdatesCount('plan_vif_funding', $id, '', $f_year);
        if (php72_count($get_vif_Count) > 0) {
            $data['plan_vif_funding_exclam'] = 0;
        } else {
            $data['plan_vif_funding_exclam'] = 1;
        }

        $get_notes_Count = $this->Mportfolio->getUpdatesCount('plan_meeting_notes', $id, '', $f_year);
        if (php72_count($get_notes_Count) > 0) {
            $data['plan_notes_exclam'] = 0;
        } else {
            $data['plan_notes_exclam'] = 1;
        }

        return $data;
        /* end notification exclam */
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

    public function plan_updates($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $net_option['inv_id'] = $inv_id['inv_id'] = $data['innovation_id'] = $id;

        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $c_option['finance_id'] = 1;
        $revenue_data = $this->Mportfolio->getDetails('port_finance_fundraise', $c_option, '1', $f_year);


        $net_option['finance_id'] = 2;
        $net_data = $this->Mportfolio->getDetails('port_finance_fundraise', $net_option, '1', $f_year);


        $data['pending_plans'] = $this->pending_plans($id, $month);

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_updates', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('update_pending_month_' . $id)) {
            $this->session->set_userdata('update_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('update_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));

        // if (!in_array($activeMonth, $data['pending_month'])) {
        //     redirect('portfolio/pending_inputs/plan_updates/' . $id);
        // }

        $data['milestone'] = $this->Mportfolio->getPlanDetails('port_project_milestone', $inv_id, '', '', '1', $limit);


        $data['updates'] = $this->Mportfolio->getPlanDetails('plan_updates', $plan, '', $f_year, $status);


        $actual_revenue = $actual_profit = 0;
        if ($month != '4') {
            $finance = $this->Mportfolio->getFinanceDetails('plan_finance', $inv_id, $month, $f_year, $status, 'now');
            foreach ($finance as $value) {
                $a_revenue = str_replace(',', '', $value['revenue']);
                $actual_revenue += $a_revenue;
            }
            foreach ($finance as $value) {
                $a_profit = str_replace(',', '', $value['net_profit']);
                $actual_profit += $a_profit;
            }
        }

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
        $this->load->view('portfolio/pending_inputs/plan_updates');
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
        redirect('portfolio/pending_inputs/plan_updates/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function sales_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_sales', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('sales_pending_month_' . $id)) {
            $this->session->set_userdata('sales_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('sales_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/sales_plan/' . $id);
        }

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

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/sales_plan');
    }

    public function addSalesPlan() {
        $data = array();
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        $data['monthly_plan'] = $_POST['monthlyPlan'];
        $data['annual_goal'] = $_POST['annualGoal'];
        $data['year_to_date'] = $_POST['ytdCount'];

        $sales_volume = $sales_value = array();
        $i = $j = 0;
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
        if ($query) {
            $this->session->set_flashdata('successMsg', "Sales details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/pending_inputs/sales_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function channel_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_channel', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('channel_pending_month_' . $id)) {
            $this->session->set_userdata('channel_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('channel_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/channel_plan/' . $id);
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
        $this->load->view('portfolio/pending_inputs/channel_plan');
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
        redirect('portfolio/pending_inputs/channel_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function pipeline_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_pipeline', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('pipeline_pending_month_' . $id)) {
            $this->session->set_userdata('pipeline_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('pipeline_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/pipeline_plan/' . $id);
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
        $this->load->view('portfolio/pending_inputs/pipeline_plan');
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
        redirect('portfolio/pending_inputs/pipeline_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function finance_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_finance', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('finance_pending_month_' . $id)) {
            $this->session->set_userdata('finance_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('finance_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/finance_plan/' . $id);
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

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/finance_plan');
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
        redirect('portfolio/pending_inputs/finance_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function loan_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_loans', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('loan_pending_month_' . $id)) {
            $this->session->set_userdata('loan_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('loan_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/loan_plan/' . $id);
        }

        $data['loan_plan'] = $this->Mportfolio->getPlanDetails('plan_loans', $plan, '', $f_year, $status);
        $data['finance_plan'] = $this->Mportfolio->getPlanDetails('plan_finance', $plan, '', $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/loan_plan');
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
        redirect('portfolio/pending_inputs/loan_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function vif_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_vif_funding', $id, $least_month, $f_year);

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
//        $plan['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('vif_pending_month_' . $id)) {
            $this->session->set_userdata('vif_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('vif_pending_month_' . $id);
        $data['vif_plan'] = $this->Mportfolio->getPlanDetails('plan_vif_funding', $plan, '', $f_year, $status);
        $data['vif_config'] = $this->Mportfolio->getPlanDetails('port_vif_funding', $c_option, '', $f_year, '1');

        $donor['partner_id'] = $partner_id;
        $donor['status'] = 1;
        $data['donor_list'] = $this->Mportfolio->getCommonData('port_donor_masters', $donor, 'name', '', $partner_id);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/vif_plan');
    }

    public function addVifPlan() {
        for ($i = 0; $i < php72_count($_POST['donor_name']); $i++) {
            if ($_POST['donor_name'][$i] != '') {
                $data = array();
                $data['inv_id'] = $_POST['innovation_id'];
                $data['financial_year'] = $_POST['current_year'];
//                $data['month'] = $_POST['current_month'];
                $option['id'] = $_POST['id'][$i];
                $option['port_vif_id'] = $data['port_vif_id'] = $_POST['port_vif_id'][$i];
                $data['donor'] = $_POST['donor_name'][$i];
                $data['milestone'] = $_POST['txtMilestone'][$i];
                $data['month_disburse'] = date('Y-m-d', strtotime($_POST['txtMonth'][$i]));
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
        if ($query) {
            $this->session->set_flashdata('successMsg', "Seed funding details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/pending_inputs/vif_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function fundraise_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_fundraise', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);

        if (!$this->session->userdata('fundraise_pending_month_' . $id)) {
            $this->session->set_userdata('fundraise_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('fundraise_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/fundraise_plan/' . $id);
        }

        $data['loan_plan'] = $this->Mportfolio->getPlanDetails('plan_loans', $plan, '', $f_year, $status);
        $data['equity_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '1');
        $data['grand_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '4');
        $data['short_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '2');
        $data['long_plan'] = $this->Mportfolio->getFundraiseDetails('plan_fundraise', $plan, $f_year, $status, '3');
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/fundraise_plan');
    }

    public function addFundraisePlan() {
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
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_fundraise', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_fundraise', $data);
                }
            }
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Fundraise details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/pending_inputs/fundraise_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function impact_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_impact', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('impact_pending_month_' . $id)) {
            $this->session->set_userdata('impact_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('impact_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/impact_plan/' . $id);
        }

        $data['impact_plan'] = $this->Mportfolio->getPlanDetails('plan_impact', $plan, '', $f_year, $status);
        $data['impact_config'] = $this->Mportfolio->getPlanDetails('port_impact', $c_option, '', $f_year, '1');
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

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

        $checkExist = $this->Mportfolio->getDetails('plan_impact', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('plan_impact', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('plan_impact', $data);
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Impact details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/pending_inputs/impact_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function hiring_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_team_hiring', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('hiring_pending_month_' . $id)) {
            $this->session->set_userdata('hiring_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('hiring_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/hiring_plan/' . $id);
        }

        $data['team_plan'] = $this->Mportfolio->getPlanDetails('plan_team_hiring', $plan, '', $f_year, $status, '', 'job_name');

        $active['status'] = '1';
        $active['partner_id'] = $partner_id;
        $data['designation_list'] = $this->Mportfolio->getCommonData('port_team_designations', $active, 'name', '', $partner_id);

        $data['job_list'] = $this->Mportfolio->getHiringJobs('plan_team_hiring', $c_option, $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/hiring_plan');
    }

    public function addHiringPlan() {
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['current_year']) + 1;
        } else {
            $fyear = $_POST['current_year'];
        }
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
//        print_r($_POST['team_name']);
////        print_r($_POST['team_name']);
//        die;
        for ($i = 0; $i < php72_count($_POST['team_name']); $i++) {
            if ($_POST['team_name'][$i] != '') {
                $option['id'] = $_POST['team_id'][$i];
                $data['job_name'] = $_POST['team_name'][$i];
                $data['ytd_count'] = $_POST['team_ytd'][$i];
                $data['current_value'] = $_POST['current_number'][$i];
                $data['total_ytd'] = $_POST['total_ytd'];
                $data['total_value'] = $_POST['total_value'];

                $checkExist = $this->Mportfolio->getDetails('plan_team_hiring', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('plan_team_hiring', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('plan_team_hiring', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Hiring details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/pending_inputs/hiring_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function tap_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_tap', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('tap_pending_month_' . $id)) {
            $this->session->set_userdata('tap_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('tap_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/tap_plan/' . $id);
        }

        $data['tap_plan'] = $this->Mportfolio->getPlanDetails('plan_tap', $plan, '', $f_year, $status);
        $status = 1;
        $data['tap_config'] = $this->Mportfolio->getPlanDetails('port_ttm_tap', $c_option, '', $f_year, $status);

        $service['partner_id'] = $partner_id;
        $service['status'] = 1;
        $data['service_providers'] = $this->Mportfolio->getCommonData('port_service_providers', $service, 'name', '', $partner_id);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/tap_plan');
    }

    public function addTapPlan() {
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['requirement']); $i++) {
            if ($_POST['requirement'][$i] != '') {
                $option['id'] = $_POST['tap_id'][$i];
                $data['port_tap_id'] = $_POST['port_tap_id'][$i];
                $data['requirement'] = $_POST['requirement'][$i];
                $data['firm_engaged'] = $_POST['firm_name'][$i];
                $data['need_by'] = isset($_POST['need_by'][$i]) && $_POST['need_by'][$i] != '' ? date('Y-m-d', strtotime($_POST['need_by'][$i])) : '';
                $data['month_engaged'] = isset($_POST['eng_date'][$i]) && $_POST['eng_date'][$i] != '' ? date('Y-m-d', strtotime($_POST['eng_date'][$i])) : '';

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
        redirect('portfolio/pending_inputs/tap_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function mentor_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_mentor', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('mentor_pending_month_' . $id)) {
            $this->session->set_userdata('mentor_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('mentor_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/mentor_plan/' . $id);
        }

        $data['mentor_master'] = $this->Mportfolio->getPlanDetails('port_config_mentor', $c_option, '', $f_year, '1');
        $data['mentor_plan'] = $this->Mportfolio->getPlanDetails('plan_mentor', $plan, '', $f_year, $status);


        // $arr_master = array();
        // if (count($mentor_config) > 0) {
        //     for ($i = 0; $i < count($mentor_config); $i++) {
        //         $master['id'] = $mentor_config[$i]['master_id'];
        //         $mentor_master = $this->Mportfolio->getPlanDetails('port_villgro_relation_mentor', $master);
        //         array_push($arr_master, $mentor_master[0]['name']);
        //     }
        // }
        // $data['mentor_master'] = $arr_master;


        $userSetup1 = $this->Mmaster->getUserSetup_branch($partner_id);
        $data['emp_details'] = $this->Muser->getUsersList($userSetup1['abi'], $partner_id);
        $data['emp_mentors'] = $this->Mportfolio->getMentorList($partner_id);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/mentor_plan');
    }

    public function addMentorPlan() {
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['config_id']); $i++) {
            if ($_POST['name'][$i] != '') {
                $option['id'] = $_POST['mentor_id'][$i];
                $data['assigned_to'] = $_POST['name'][$i];
                $data['hours_spent'] = $_POST['hours_spent'][$i];
                $data['purpose'] = $_POST['purpose'][$i];
                $data['config_id'] = $_POST['config_id'][$i];

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
        redirect('portfolio/pending_inputs/mentor_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function nontap_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_partnerships', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('nontap_pending_month_' . $id)) {
            $this->session->set_userdata('nontap_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('nontap_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/nontap_plan/' . $id);
        }

        $data['nontap_plan'] = $nontap_plan = $this->Mportfolio->getPlanDetails('plan_partnerships', $plan, '', $f_year, $status);
        $status = 1;
        $data['nontap_config'] = $this->Mportfolio->getPlanDetails('port_ttm_partnership', $c_option, '', $f_year, $status);

        $plan = $nontap_plan[0];
        $data['plan_count'] = $plan_count = isset($plan) ? php72_count($nontap_plan) : 0;
        if ($plan_count == 0) {
            $service['inv_id'] = $id;
            $service['financial_year'] = $f_year;
            $service['status'] = 1;
            $data['nontap_plan'] = $this->Mportfolio->getCommonData('port_ttm_partnership', $service);
        }
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));


        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/nontap_plan');
    }

    public function addNontapPlan() {
        $option['inv_id'] = $data['inv_id'] = $_POST['innovation_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['current_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        for ($i = 0; $i < php72_count($_POST['type_id']); $i++) {
            if ($_POST['type_id'][$i] != '') {
                $option['type'] = $data['type'] = $_POST['type_id'][$i];
                $data['port_nontap_id'] = $_POST['port_nontap_id'][$i];
                $data['partner_name'] = $_POST['partner_name'][$i];
                $data['comments'] = $_POST['partner_comments'][$i];
                $data['need_by'] = (isset($_POST['eng_date'][$i]) && $_POST['eng_date'][$i] != '') ? date('Y-m-d', strtotime($_POST['eng_date'][$i])) : '';
                if (isset($_POST['plan_nontap_id'][$i])) {
                    $option['id'] = $_POST['plan_nontap_id'][$i];
                }
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
        redirect('portfolio/pending_inputs/nontap_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function milestone_plan($id = '', $milestone = '') {
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

        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
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
//        $pending = '0';
//        if ($milestone == '') {
//            if ($this->session->userdata['sector_lead'] == 1) {
//                $get_data = $this->Mportfolio->getApprovalDetails('port_project_milestone', $c_option, $pending);
//                if (count($get_data) > 0) {
//                    redirect('portfolio/milestone/' . $id . '/' . $get_data[0]['financial_year'] . '/' . $get_data[0]['id']);
//                }
//            }
//        }
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

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

    public function meeting_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_board_meetings', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);
        if (!$this->session->userdata('meeting_pending_month_' . $id)) {
            $this->session->set_userdata('meeting_pending_month_' . $id, $ses_pending);
        }
        $data['pending_month'] = $this->session->userdata('meeting_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/meeting_plan/' . $id);
        }

        $data['boardmeet_plan'] = $this->Mportfolio->getPlanDetails('plan_board_meetings', $plan, '', $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('pending_inputs/boardmt_plan');
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

        $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
        $data['meeting_type'] = $_POST['type_meet'];
        $data['venue'] = $_POST['venue'];
        $data['external'] = $_POST['board_external'];
        $data['internal'] = $_POST['board_internal'];
        $data['observers'] = $_POST['board_observer'];
        $data['invitees'] = $_POST['other_inviteees'];
        $data['document_link'] = $_POST['link_drive'];
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
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
        redirect('portfolio/pending_inputs/meeting_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function dp_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $c_option['inv_id'] = $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }
        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        $data['pending_plans'] = $this->pending_plans($id, $month);

        for ($i = ($arr - 1); $i >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
        }

        $get_current_month = date('n');
        if ($get_current_month == 1)
            $last_month = '12';
        else
            $last_month = date('n') - 1;

        $least_month = php72_implode(', ', $derivemonth);
        $get_monthCount = $this->Mportfolio->getUpdatesCount('plan_dp', $id, $least_month, $f_year);

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
        $ses_pending = php72_array_reverse($monthName);

        if (!$this->session->userdata('dp_pending_month_' . $id)) {
            $this->session->set_userdata('dp_pending_month_' . $id, $ses_pending);
        }

        $data['pending_month'] = $this->session->userdata('dp_pending_month_' . $id);
        $activeMonth = date("M", mktime(0, 0, 0, $month, 1));
        if (!php72_in_array($activeMonth, $data['pending_month'])) {
            redirect('portfolio/pending_inputs/dp_plan/' . $id);
        }

        $data['dp_plan'] = $this->Mportfolio->getPlanDetails('plan_dp', $plan, '', $f_year, $status);
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('pending_inputs/dp_plan');
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
        $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
        $data['location'] = $_POST['location'];
        $data['external_attendees'] = $_POST['external_attd'];
        $data['document_link'] = $_POST['link_drive'];
        $data['document'] = $this->portfolio_file_upload('app', 'uploads/portfolio/plan-dpplan', 'document_file', 'doc|docx|ppt|pptx|pdf', $_POST['old_doc']);
        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';

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
        redirect('portfolio/pending_inputs/dp_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
    }

    public function notes_plan($id = '', $month = '') {
        if ($id != '')
            check_partner_privilege($id);
        $status = 3;
        $data['innovation_id'] = $id;
        $data['plan_header'] = $this->plan_header($id);
        $partner_id = $this->session->userdata('partner_id');
        $data['fin_year'] = $this->Mportfolio->getAllFinancialYear($partner_id);
        $f_year = date('Y');
        foreach ($data['fin_year'] as $fy) {
            if ($fy['status'] == 1) {
                $f_year = $fy['fin_year'];
            }
        }

        $plan['inv_id'] = $id;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['note_plan'] = $this->Mportfolio->getPlanDetails('plan_meeting_notes', $plan, '', $f_year, $status);
        $data['meeting_type'] = $this->Mdiligence->get_data('diligence_meeting_type');
        $data['pending_plans'] = $this->pending_plans($id, $month);

        $donor['partner_id'] = $partner_id;
        $donor['status'] = 1;
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/pending_inputs/notes_plan');
    }

    function addNotesPlan() {
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
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
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
        redirect('portfolio/pending_inputs/notes_plan/' . $_POST['innovation_id'] . '/' . $_POST['current_month']);
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

    public function deleteTeamHiring() {
        $this->db->set('status', 3);
        $delete['job_name'] = $this->input->post('name');
        $delete['inv_id'] = $cond['inv_id'] = $plan['inv_id'] = $this->input->post('inv_id');
//        $cond['month'] = $plan['month'] = $this->input->post('cur_month');
        $delete['financial_year'] = $cond['financial_year'] = $f_year = $this->input->post('fin_year');
        $table = $this->input->post('table');
        $query = $this->Mportfolio->deleteHiringDetail($table, $delete);

        if ($query) {
            $status = 3;

            $hiring = $this->Mportfolio->getFundraiseDetails('plan_team_hiring', $plan, $f_year, $status);

            foreach ($hiring as $h) {
                $h_total = str_replace(',', '', $h['current_value']);
                $hdata[$h['month']] += $h_total;
            }

            if (php72_count($hiring) > 0) {
                foreach ($hdata as $hkey => $hval) {
                    $cond['month'] = $hkey;
                    $hirdata['total_value'] = $hval;
                    $h_equity = $this->Mportfolio->updatePendingFundraise('plan_team_hiring', $hirdata, $cond);
                }
            }

            echo '1';
        } else {
            echo '0';
        }
    }

}
