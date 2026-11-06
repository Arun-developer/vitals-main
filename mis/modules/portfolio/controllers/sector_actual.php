<?php

class Sector_actual extends CI_Controller {

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
        $business_nature = $this->Mportfolio->getDetails('port_business', $option, $status);
        foreach ($business_nature as $inv) {
            $inv_id[] = $inv['inv_id'];
        }
        $innovation_id = php72_array_unique($inv_id);
        $assign_status = 1;
        $assign_list = $this->Mportfolio->getArrayListingDetails('assign_associate', $innovation_id, $assign_status);
        foreach ($assign_list as $emp) {
            $associate_emp[] = $emp['associate_employee'];
        }

        return array_unique($associate_emp);
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

    public function deleteActualDetail() {
        $this->db->set('status', 3);
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $condition = "'" . php72_implode("', '", $id) . "'";
        $m_query = $this->Mportfolio->deleteMentorDetail($table, $condition, 'id');
        if ($m_query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function discovery($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 1;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_diligence', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_diligence', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['subsector_details'] = $subsector_details = $this->Sectorplan->getSubSectors($sector['id']);
        $data['subsector_name'] = $subsector_details[0]['sector'];

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        /* fetching details from admin portfolio master to load defaultly in corresponding fileds */
        $master_cond['sector'] = $id;
        $master_cond['financial_year'] = $f_year;
        $data['master_portfolio'] = $this->Mportfolio->getDetails('port_dashboard_master', $master_cond, 1);

        $data['discovery_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_discovery', $actual_option, '', $f_year, $status);

        $data['sector_discovery'] = $this->Mportfolio->getDetails('sector_plan_discovery', $c_option, $status, $f_year);
        $data['total_app'] = $this->Sectorplan->companyApplicationCount($id, '', $f_year, $month);
        $data['subsector_discovery'] = $subsectordisc = $this->Mportfolio->getDetails('sector_plan_discoverysubsector', $c_option, 1, $f_year);
        $subsec_arr = array();
        foreach ($subsectordisc as $subs) {
            $subsec_arr[] = $subs['subsector_id'];
        }
        $subsec = implode(',', $subsec_arr);
        // $total_subapp['total_subapp'] = '';
        if ($subsec != '') {
            foreach($subsec_arr as $subs){
                // $total_subapp[$subs] = '';
                $total_subapp[$subs] = $this->Sectorplan->companyApplicationCount($id, $subs, $f_year, $month);

            }
        }
        $data['total_subapp'] = $total_subapp;
        // print_r($data['total_subapp']);
        // die;


        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['find_lead'] = $this->findSectorLead($sector['id']);

        /* for sector lead name */
        $business_nature = $this->Sectorplan->getSecEmpId($id);
        $get_port_leadID = isset($business_nature[0]['employee_id']) && $business_nature[0]['employee_id'] != '' ? $business_nature[0]['employee_id'] : '';
        $get_sect_leadID = isset($get_port_leadID) && $get_port_leadID != '' ? $get_port_leadID : '';
        $data['sector_lead'] = $this->Mportfolio->getEmpDetailsById($get_sect_leadID);
        /* functionality ends */

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/discovery_actuals');
    }

    public function diligence($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 2;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_diligence', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_diligence', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $month_arr = array(4 => 'Apr-' . $from_year, 5 => 'May-' . $from_year, 6 => 'Jun-' . $from_year, 7 => 'Jul-' . $from_year, 8 => 'Aug-' . $from_year, 9 => 'Sep-' . $from_year, 10 => 'Oct-' . $from_year, 11 => 'Nov-' . $from_year, 12 => 'Dec-' . $from_year, 1 => 'Jan-' . $nxt_year, 2 => 'Feb-' . $nxt_year, 3 => 'Mar-' . $nxt_year);

        $data['diligence_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_diligence', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $pard_count = array();
        $iic_count = array();
        $eic_count = array();
        $data['pard_cnt'] = 0;
        $data['eic_cnt'] = 0;
        $data['iic_cnt'] = 0;
        foreach ($month_arr as $keys => $values) {

            $pard_allcount = $this->Sectorplan->pard_allCount($id, $f_year, $keys);
            if (php72_count($pard_allcount) != 0) {
                foreach ($pard_allcount as $pards) {
                    if (!isset($pard_count[$pards['id']])) {
                        $pard_count[$pards['id']] = 1;
                        if($keys == $month){
                            $data['pard_cnt'] += 1;
                        }
                    }
                }
            }
            $IIC_allCount = $this->Sectorplan->IIC_allCount($id, $f_year, $keys);
            if (php72_count($IIC_allCount) != 0) {
                foreach ($IIC_allCount as $iics) {
                    if (!isset($iic_count[$iics['id']])) {
                        $iic_count[$iics['id']] = 1;
                        if($keys == $month){
                            $data['iic_cnt'] += 1;
                        }
                    }
                }
            }

            $EIC_allcount = $this->Sectorplan->EIC_allcount($id, $f_year, $keys);
            if (php72_count($EIC_allcount) != 0) {
                foreach ($EIC_allcount as $eics) {
                    if (!isset($eic_count[$eics['id']])) {
                        $eic_count[$eics['id']] = 1;
                        if($keys == $month){
                            $data['eic_cnt'] += 1;
                        }
                    }
                }
            }
        }
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/diligence_actuals');
    }

    public function selection($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 3;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_selection', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_selection', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['selection_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_selection', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $total_condition = "BN.sector IN($id)";
		#CR CHANGES
        #$data['total_companies'] = $this->Sectorplan->getTotalCompany($total_condition, $f_year, $month);
		$data['total_companies'] = $this->Sectorplan->getTotalCompany_cr($id, $f_year, $month);
		#echo'<pre>';print_r($data['total_companies']);die;

        #$data['new_companies'] = $this->Sectorplan->getNewCompany($total_condition, $f_year, $month);
        $data['new_companies'] = $this->Sectorplan->getNewCompany_cr($id, $f_year, $month);
		#echo'<pre>';print_r($data['new_companies']);die;
		
		#CR CHANGES

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/selection_actual');
    }

    public function graduates($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 4;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_graduates', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_graduates', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['graduates_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_graduates', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        if(php72_cmp($month) == 1 || php72_cmp($month) == 2 || php72_cmp($month) == 3){
            $year_qry = $year + 1;
        } else {
            $year_qry = $year;
        }
        $data['graduates_companies'] = $this->Sectorplan->getCompanies($id, $year_qry, $month, 2);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/graduates_actual');
    }

    public function exits($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 5;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_exits', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_exits', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['exits_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_exits', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        if(php72_cmp($month) == 1 || php72_cmp($month) == 2 || php72_cmp($month) == 3){
            $year_qry = $year + 1;
        } else {
            $year_qry = $year;
        }
        $data['exited_companies'] = $this->Sectorplan->getCompanies($id, $year_qry, $month, 3);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/exits_actual');
    }

    public function addGraduates() {
        $query = $this->addQualitativePlan($_POST);
        if ($query) {
            $this->session->set_flashdata('successMsg', $_POST['success_head'] . " details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/' . $_POST['redirect'] . '/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function donorengagement($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $qual_module['module_id'] = 6;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_donorengagement', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_donorengagement', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['donorengage_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_donorengagement', $actual_option, '', $f_year, $status);
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = 6;
        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['donorengage_plan'] = $this->Mportfolio->getDetails('sector_plan_donorengagement', $c_option, $status, $f_year);
        $data['donor_list'] = $this->Sectorplan->getGrantFunderList();
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/donorengagement_actual');
    }

    public function addDonorengagement() {
        $this->addQualitativePlan($_POST);
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['donor']); $i++) {
            if ($_POST['donor'][$i] != '') {
                $option['id'] = $_POST['donorengage_id'][$i];
                $data['donor_id'] = $_POST['donor'][$i];
                $data['grant_id'] = isset($_POST['grant'][$i]) && $_POST['grant'][$i] != '' ? $_POST['grant'][$i] : '';
                $data['comments'] = $_POST['comments'][$i];

                $checkExist = $this->Mportfolio->getDetails('sector_actual_donorengagement', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_donorengagement', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_donorengagement', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Donor engagement details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/donorengagement/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function donorconnect($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 7;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_donorconnect', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_donorconnect', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['donorconnect_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_donorconnect', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['donorconnect_plan'] = $this->Mportfolio->getDetails('sector_plan_donorconnect', $c_option, $status, $f_year);
        $data['donor_list'] = $this->Sectorplan->getGrantFunderList();
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/donorconnect_actual');
    }

    public function addDonorconnect() {
        $this->addQualitativePlan($_POST);
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['donor']); $i++) {
            if ($_POST['donor'][$i] != '') {
                $option['id'] = $_POST['donorconnect_id'][$i];
                $data['donor_id'] = $_POST['donor'][$i];
                $data['grant_id'] = isset($_POST['grant'][$i]) && $_POST['grant'][$i] != '' ? $_POST['grant'][$i] : '';
                $data['comments'] = $_POST['comments'][$i];

                $checkExist = $this->Mportfolio->getDetails('sector_actual_donorconnect', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_donorconnect', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_donorconnect', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Donor connect details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/donorconnect/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function conference($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 8;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_conference', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_conference', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['conference_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_conference', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['conference_plan'] = $this->Mportfolio->getDetails('sector_actual_conference', $c_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/conference_actual');
    }

    public function addConference() {
        $this->addQualitativePlan($_POST);
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['conferencedate']); $i++) {
            if ($_POST['conferencedate'][$i] != '') {
                $option['id'] = $_POST['conference_id'][$i];
                $data['date'] = (isset($_POST['conferencedate'][$i]) && $_POST['conferencedate'][$i] != '') ? date('Y-m-d', strtotime($_POST['conferencedate'][$i])) : '';
                $data['conference'] = $_POST['conference'][$i];
                $data['details'] = $_POST['details'][$i];

                $checkExist = $this->Mportfolio->getDetails('sector_actual_conference', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_conference', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_conference', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Conference details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/conference/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function blogpost($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 9;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_blogpost', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_blogpost', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['blogpost_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_blogpost', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['blogpost_plan'] = $this->Mportfolio->getDetails('sector_actual_blogpost', $c_option, $status, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/blogpost_actual');
    }

    public function addBlogpost() {
        $this->addQualitativePlan($_POST);
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['datepost']); $i++) {
            if ($_POST['datepost'][$i] != '') {
                $option['id'] = $_POST['blogpost_id'][$i];
                $data['date_post'] = (isset($_POST['datepost'][$i]) && $_POST['datepost'][$i] != '') ? date('Y-m-d', strtotime($_POST['datepost'][$i])) : '';
                $data['blog_link'] = $_POST['blog_link'][$i];
                $data['details'] = $_POST['details'][$i];

                $checkExist = $this->Mportfolio->getDetails('sector_actual_blogpost', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_blogpost', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_blogpost', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Blog post details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/blogpost/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function article($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 10;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_publisharticle', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_publisharticle', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['article_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_publisharticle', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/article_actual');
    }

    public function speaking_engagement($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 11;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_speakingengagement', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_speakingengagement', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

        /* using sector id getting sector name from sector table */
        /* $get_inc_sector = $this->Mportfolio->getIncSector();
        $inc_sectors = array();
        foreach ($get_inc_sector as $sect) {
            array_push($inc_sectors, $sect['sector']);
        } */
		
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

        $merge_incs = implode(',', $inc_sectors);
        $data['sectors_values'] = $this->Mportfolio->getIncSectorNames($merge_incs);
        $sector['id'] = $id;
        $sector_details = $this->Mportfolio->getDetails('sector_category', $sector);
        $data['sector_name'] = $sector_details[0]['sector'];

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['speaking_engagement_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_speakingengagement', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/speaking_engagement_actual');
    }

    public function jury_panel($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 12;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_jurypanels', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_jurypanels', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['jurypanel_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_jurypanels', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/jurypanel_actual');
    }

    public function case_study($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 13;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_casestudy', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_casestudy', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['casestudy_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_casestudy', $actual_option, '', $f_year, $status);

        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/casestudy_actual');
    }

    public function addArticle() {
        $this->addQualitativePlan($_POST);
        $table = $_POST['table'];
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['datepost']); $i++) {
            if ($_POST['datepost'][$i] != '') {
                $option['id'] = $_POST[$_POST['redirect'] . '_id'][$i];
                $data['date'] = (isset($_POST['datepost'][$i]) && $_POST['datepost'][$i] != '') ? date('Y-m-d', strtotime($_POST['datepost'][$i])) : '';
                $data['details'] = $_POST['details'][$i];

                $checkExist = $this->Mportfolio->getDetails($table, $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail($table, $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail($table, $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', $_POST['success_head'] . " details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/' . $_POST['redirect'] . '/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function equity_investments($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 14;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_equity', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_equity', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['equity_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_equity', $actual_option, '', $f_year, $status);
        $data['euity_plan'] = $this->Mportfolio->getDetails('sector_plan_equity', $c_option, $status, $f_year);
        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['invest_details'] = $this->Sectorplan->getEquityCompanies($id, $month, $f_year);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/equity_actual');
    }

    public function addEquity() {
        $this->addQualitativePlan($_POST);
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['conferencedate']); $i++) {
            if ($_POST['conferencedate'][$i] != '') {
                $option['id'] = $_POST['conference_id'][$i];
                $data['date'] = (isset($_POST['conferencedate'][$i]) && $_POST['conferencedate'][$i] != '') ? date('Y-m-d', strtotime($_POST['conferencedate'][$i])) : '';
                $data['conference'] = $_POST['conference'][$i];
                $data['details'] = $_POST['details'][$i];

                $checkExist = $this->Mportfolio->getDetails('sector_actual_conference', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_conference', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_conference', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Conference details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/conference/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function consulting_engagements($id = '', $year = '', $month = '') {
        if ($id != '')
            $status = 3;
        $data['module_id'] = $qual_option['module_id'] = $qual_cond['module_id'] = $qual_module['module_id'] = 15;
        $option['id'] = $appoption['sector_id'] = $c_option['sector_id'] = $data['sector_id'] = $qual_option['sector_id'] = $id;

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

        $cur_month = date('M');
        $getmonth = $this->month();
        $actualMonth = $this->actual_month();
        $arr = php72_array_search($cur_month, $getmonth);

        for ($i = ($arr); php72_cmp($i) >= 0; $i--) {
            $derivemonth[] = php72_array_search($getmonth[$i], $actualMonth);
            $monthName[] = $getmonth[$i];
            $monthlist[] = $getmonth[$i];
        }

        $last_month = date('n');
        $least_month = php72_implode(', ', $derivemonth);

        $get_monthCount = $this->Sectorplan->getUpdatesCount('sector_actual_portfolioreturns', $id, $least_month, $f_year);
        $get_plan_pending = $this->Sectorplan->getPlanMonths('sector_actual_portfolioreturns', $id, '', $f_year);
        $get_qualitative = $this->Sectorplan->getPlanMonths('sector_actual_qualitative_data', $id, '', $f_year, $qual_module);
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
        $actual_option['sector_id'] = $qual_cond['sector_id'] = $id;
        $actual_option['month'] = $qual_cond['month'] = $month;
        $data['current_month'] = $month;
        $data['current_financial'] = $f_year;
        $data['pending_month'] = php72_array_reverse($monthName);
        if ($f_year == date('Y')) {
            $data['monthlist'] = php72_array_reverse($monthlist);
        } else {
            $data['monthlist'] = $this->month();
        }

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

        $data['current_financial'] = $appoption['financial_year'] = $f_year;

        /* for previlleges - approve,save,add more,edit, send for approval */
        /* fetching sector leads and assign incharge */
        $data['app_sectorlead'] = $s_lead = $this->getSectorLead($id);
        $data['app_assinglead'] = $assoc_lead = $this->getAssociateSectorLead($id);
        $sector_merge = php72_array_merge($s_lead, $assoc_lead);
        $data['assign_sectorlead'] = array_unique($sector_merge);
        /* end operation */

        $data['portfolio_returns_actual'] = $this->Mportfolio->getPlanDetails('sector_actual_portfolioreturns', $actual_option, '', $f_year, $status);
        $data['portfolioreturns_plan'] = $this->Mportfolio->getDetails('sector_plan_portfolioreturns', $c_option, $status, $f_year);
        $data['qualitative_actual'] = $this->Mportfolio->getFundraiseDetails('sector_actual_qualitative_data', $qual_cond, $f_year, $status);
        $data['qualitative_plan'] = $this->Mportfolio->getPlanDetails('sectorplan_qualitative_data', $qual_option, '', $f_year, $status);

        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['donor_list'] = $this->Sectorplan->getGrantFunderList('service');

        $this->load->vars($data);
        $this->load->view('portfolio/sector_actual/portfolioreturns_actual');
    }

    public function addPortfolioreturns() {

        $this->addQualitativePlan($_POST);
        $option['sector_id'] = $data['sector_id'] = $_POST['sector_id'];
        $option['financial_year'] = $data['financial_year'] = $_POST['financial_year'];
        $option['month'] = $data['month'] = $_POST['current_month'];
        if ($_POST['current_month'] == '1' || $_POST['current_month'] == '2' || $_POST['current_month'] == '3') {
            $fyear = php72_num($_POST['financial_year']) + 1;
        } else {
            $fyear = $_POST['financial_year'];
        }

        $data['fy_date'] = $fyear . '-' . $_POST['current_month'] . '-01 00:00:00';
        for ($i = 0; $i < php72_count($_POST['donor']); $i++) {
            if ($_POST['donor'][$i] != '') {
                $option['id'] = $_POST['portfolio_returns_id'][$i];
                $data['donor_id'] = $_POST['donor'][$i];
                $data['grant_id'] = isset($_POST['grant'][$i]) && $_POST['grant'][$i] != '' ? $_POST['grant'][$i] : '';
                $data['typeof_engagement'] = $_POST['engagement_type'][$i];
                $data['comment'] = $_POST['comments'][$i];

                $checkExist = $this->Mportfolio->getDetails('sector_actual_portfolioreturns', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $data['status'] = 0;
                    $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_portfolioreturns', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_portfolioreturns', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Consulting engagement details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('portfolio/sector_actual/consulting_engagements/' . $_POST['sector_id'] . '/' . $_POST['financial_year'] . '/' . $_POST['current_month']);
    }

    public function deleteConsultingDoc() {
        $cond['id'] = $this->input->post('mentr');
        $table = $this->input->post('table');
        $field = $this->input->post('field');
        $query = $this->Sectorplan->deleteConsultingDoc($table, $cond, $field);
        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function addQualitativePlan($post) {
        $qual_option['sector_id'] = $qual_data['sector_id'] = $post['sector_id'];
        $qual_option['financial_year'] = $qual_data['financial_year'] = $post['financial_year'];
        $qual_option['month'] = $qual_data['month'] = $post['current_month'];
        $qual_option['module_id'] = $qual_data['module_id'] = $post['module_id'];
        $qual_data['description'] = $post['achieveContent'];

        if ($post['current_month'] == '1' || $post['current_month'] == '2' || $post['current_month'] == '3') {
            $fyear = $post['financial_year'] + 1;
        } else {
            $fyear = $post['financial_year'];
        }

        $qual_data['fy_date'] = $fyear . '-' . $post['current_month'] . '-01 00:00:00';

        $checkExist = $this->Mportfolio->getDetails('sector_actual_qualitative_data', $qual_option);
        if (php72_count($checkExist) > 0) {
            $qual_data['updated_by'] = $this->session->userdata('emp_number');
            $qual_data['status'] = 0;
            $query = $this->Mportfolio->updatePortfolioDetail('sector_actual_qualitative_data', $qual_data, $qual_option);
        } else {
            $qual_data['created_by'] = $this->session->userdata('emp_number');
            $qual_data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('sector_actual_qualitative_data', $qual_data);
        }
        return $query;
    }

    public function getGrantNameList() {
        $donor_id = $this->input->post('donor');
        $data = $this->Sectorplan->getGrantList($donor_id);
        echo json_encode($data);
    }

    public function getGrantDetails() {
        $grant['id'] = $this->input->post('grant');
        $data = $this->Mportfolio->getDetails('grant_list', $grant);
        echo json_encode($data);
    }

}
