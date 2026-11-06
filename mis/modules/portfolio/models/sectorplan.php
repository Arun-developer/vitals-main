<?php

class Sectorplan extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
    }

    public function configApprovalUpdate($table, $condition) {
        $result = '';
        if ($condition != '') {
            $this->db->where($condition);
        }
        $this->db->select('id, discovery_approval, diligence_approval, selection_approval, graduates_approval, exits_approval, donorengagement_approval, donorconnect_approval, conferences_approval, blog_post_approval, publish_article_approval, speakingengagement_approval, jury_panels_approval, case_study_approval, equity_investment_approval, portfolio_return_approval');
        $query = $this->db->get($table);
        $sql_rows = $query->result_array();
        $i = 1;
        foreach ($sql_rows as $rows) {
            $condition['id'] = $rows['id'];
            $alltrue = 1;
            $check_appr = array();
            foreach ($rows as $key => $item) {
                if ($key != 'id')
                    array_push($check_appr, $item);
            }
            if (in_array("1", $check_appr) || in_array("2", $check_appr)) {
                $alltrue = 0;
            } else {
                $alltrue = 1;
            }

            if ($alltrue == 1) {
                $approval['config_approval'] = 3;
                $this->db->set($approval);
                $this->db->where($condition);
                $result = $this->db->update($table);
            } else {
                $search = 1;
                foreach ($rows as $key => $item) {
                    if ($key != 'id' && $item == '1') {
                        $search = 0;
                    }
                }
                if ($search == 1) {
                    $approval['config_approval'] = 2;
                    $this->db->set($approval);
                    $this->db->where($condition);
                    $result = $this->db->update($table);
                } else {
                    $approval['config_approval'] = 1;
                    $this->db->set($approval);
                    $this->db->where($condition);
                    $result = $this->db->update($table);
                }
            }
            $i++;
        }
        return $result;
    }

    public function getSectorLists() {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $this->db->select("*");
//        $this->db->where('pitch', $pitch_id);
        $this->db->where('status', 1);
        $this->db->where('parent_id', 0);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getSubSectors($id) {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $this->db->select("*");
//        $this->db->where('pitch', $pitch_id);
        $this->db->where('status', 1);
        $this->db->where('parent_id', $id);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getSectorNames($id) {
        $cond = "id IN ($id)";
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $this->db->select("*");
        $this->db->where('parent_id', 0);
//        $this->db->where('pitch', $pitch_id);
        $this->db->where($cond);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getSecEmpId($sec_id) {
        $this->db->select("A.sector, B.employee_id");
        $this->db->join('assign_sector_lead B', 'B.sector_id = A.sector', 'left');
        $this->db->where('A.sector', $sec_id);
        $query = $this->db->get('port_business A');
        $rows = $query->result_array();
        return $rows;
    }
	
	#CR QUERY
    public function getCompanies($sector = '', $year, $month, $status) { 
		
		$dynamicConditions = '';
		if ($sector != '') {
            $dynamicConditions .= "(FIND_IN_SET('$sector', REPLACE(D.sector, ' ', '')) > 0 OR (D.sector IS NULL AND FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0)) AND ";
        }
		$dynamicConditions = rtrim($dynamicConditions, " AND ");
		
		$this->db->select("DISTINCT A.name, A.company_status, IFNULL(B.inv_id, C.inv_id) as inv_id, C.exit_date as exit_date", false);
		$this->db->from('port_company_data A');
		$this->db->join('port_business B', 'B.inv_id = A.inv_id', 'left');
		$this->db->join('port_incubation_relation C', 'C.inv_id = A.inv_id', 'left');
		$this->db->join('port_business_year D', 'D.inv_id = A.inv_id', 'left');
		$this->db->where(array('A.company_status' => $status, 'YEAR(C.exit_date)' => $year, 'MONTH(C.exit_date)' => $month, 'A.status !=' => 3));
		if ($sector != '') {
			$this->db->where($dynamicConditions, null, false);
		}
		$query = $this->db->get();
		$rows = $query->result_array();
		return $rows; 
		#echo $this->db->last_query();
		#echo'<pre>';print_r($rows);die;
	
	
       /* if ($sector != '') {
            $this->db->where('B.sector', $sector);
        }
        $this->db->select("A.name, A.company_status, B.inv_id, C.exit_date");
        $this->db->join('port_business B', 'B.inv_id = A.inv_id', 'left');
        $this->db->join('port_incubation_relation C', 'C.inv_id = A.inv_id', 'left');
        #$this->db->where(array('A.company_status' => $status, 'YEAR(C.exit_date)' => $year, 'MONTH(C.exit_date)' => $month, 'A.status !=' => 3));
        $query = $this->db->get('port_company_data A');
        $rows = $query->result_array();
		echo'<pre>';print_r($rows);die;
        return $rows;  */
		
		/* $dynamicValues = array();
		// Construct the SQL query string for dynamic conditions
		$dynamicConditions = '';
		foreach ($dynamicValues as $value) {
			$dynamicConditions .= "(FIND_IN_SET('$value', REPLACE(D.sector, ' ', '')) > 0 OR (D.sector IS NULL AND FIND_IN_SET('$value', REPLACE(B.sector, ' ', '')) > 0)) AND ";
		}
		$dynamicConditions = rtrim($dynamicConditions, " AND ");

		// Modify the original query with dynamic conditions
		$this->db->select("A.name, A.company_status, IFNULL(B.inv_id, C.inv_id) as inv_id, C.exit_date as exit_date", false);
		$this->db->from('port_company_data A');
		$this->db->join('port_business B', 'B.inv_id = A.inv_id', 'left');
		$this->db->join('port_incubation_relation C', 'C.inv_id = A.inv_id', 'left');
		$this->db->join('port_business_year D', 'D.inv_id = A.inv_id', 'left');
		#$this->db->where(array('A.company_status' => $status, 'YEAR(C.exit_date)' => $year, 'MONTH(C.exit_date)' => $month, 'A.status !=' => 3));
		$this->db->where($dynamicConditions, null, false); // Add dynamic conditions
		$query = $this->db->get();
		#echo $this->db->last_query(); // For debugging purposes
		$rows = $query->result_array();

		return $rows; */


    }

    public function getEquityCompanies($sector, $month, $year) { 
        $this->db->select("A.name, B.sector, C.sha_date, C.invest_amount");
        $this->db->join('port_business B', 'B.inv_id = A.inv_id', 'left');
        $this->db->join('plan_vif_equity C', 'C.inv_id = A.inv_id', 'left');
        $this->db->where(array('B.sector' => $sector, 'C.month' => $month, 'C.financial_year' => $year, 'A.status !=' => 3, 'C.status !=' => 3));
        $query = $this->db->get('port_company_data A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getUpdatesCount($table, $id = '', $value = '', $year = '') {
        if ($value != '') {
            $condition = "month IN($value)";
            $this->db->where($condition);
        }
        if ($id != '') {
            $this->db->where('sector_id', $id);
        }
        if ($year != '') {
            $this->db->where('financial_year', $year);
        }
        $this->db->where('status !=', '3');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getPlanMonths($table, $id = '', $value = '', $year = '', $condition = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT month SEPARATOR ',') as months", false);
        if ($id != '') {
            $this->db->where('sector_id', $id);
        }
        if ($year != '') {
            $this->db->where('financial_year', $year);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }

        $this->db->where('status !=', '3');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    /* for deleting consulting engagement docs */

    public function deleteConsultingDoc($table, $condition, $field) {
        $this->db->set($field, '');
        $this->db->where($condition);
        $result = $this->db->update($table);
        return $result;
    }

    /* deleting consulting engagement docs ends */

    /* for diligence */

    public function pard_allCount($sector = '', $fyear = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }

        $nxtye = $fyear + 1;
        $date_value = "$fyear-04-01 00:00:00";
        $next_fy = "$nxtye-03-31 23:59:59";
        $partner_id = $this->session->userdata('partner_id');

        // $log_where = "LG.stage = '8' and LG.status = '12' and MONTH(LG.modified_date) = $month  and LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy' $sectorcond";
        // $this->db->select("count(DISTINCT IP.id) as PARD_count");
        $log_where = "LG.stage = '8' and LG.status = '12' and LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy' $sectorcond";
        $this->db->select("IP.id");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $this->db->where($log_where);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function IIC_allCount($sector = '', $fyear = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $nxtye = $fyear + 1;
        $date_value = "$fyear-04-01 00:00:00";
        $next_fy = "$nxtye-03-31 23:59:59";
        $partner_id = $this->session->userdata('partner_id');

        $log_where = "LG.stage = '8' and LG.status = '15' $sectorcond";
        $this->db->select("IP.id");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->join('grading_feedback GF', 'GF.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        //GF.internal_date != '' AND 
        $this->db->where("IF(GF.internal_date != '0000-00-00 00:00:00' , MONTH(GF.internal_date) = $month and GF.internal_date >= '$date_value' and GF.internal_date <= '$next_fy', MONTH(LG.modified_date) = $month and LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy')");
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $this->db->where($log_where);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function EIC_allCount($sector = '', $fyear = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $nxtye = $fyear + 1;
        $date_value = "$fyear-04-01 00:00:00";
        $next_fy = "$nxtye-03-31 23:59:59";
        $partner_id = $this->session->userdata('partner_id');

        $log_where = "LG.stage = '9' and (LG.status = '17' or LG.status = '18') and MONTH(LG.modified_date) = $month and LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy' $sectorcond";
        // $this->db->select("count(DISTINCT IP.id) as EIC_count");
        $this->db->select("IP.id");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $this->db->where($log_where);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    /* for diligence ends */

    /* for selection */

    public function getTotalCompany($cond = '', $fyear = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }

        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = php72_implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }
        $partner_id = $this->session->userdata('partner_id');
        if (php72_cmp($month) == 01 || php72_cmp($month) == 02 || php72_cmp($month) == 03) {
            $nxtye = $fyear + 1;
        } else {
            $nxtye = $fyear;
        }
        // $current_date = $fyear . '-04-01 00:00:00';
        // $next_fyear = $nxtye . '-03-31 00:00:00';

        $sign_date = $nxtye . '-' . $month;
        $exit_fyear = $nxtye . '-' . $month . '-01 00:00:00';
        // $nda_cond = "CD.created_at BETWEEN '$current_date' AND '$next_fyear'";
        $nda_cond = "DATE_FORMAT(IR.initial_signed_on, '%Y-%m') <= '$sign_date' AND (DATE_FORMAT(IR.exit_date, '%Y-%m') > '$sign_date' OR YEAR(IR.exit_date) = 0000)";
        $this->db->where($nda_cond);
        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.stage' => '12', 'CD.status !=' => '3'));
        $this->db->where("IP.status NOT IN('4','10','11')");
        // $this->db->select('CD.id, IR.inv_id, CD.name, MONTH(IR.initial_signed_on) as month, MONTH(IR.exit_date) as exitmonth, IR.initial_signed_on as year, IR.exit_date as exityear');
        $this->db->select('count(CD.id) as total_company');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id = CD.inv_id', 'left');

        $query = $this->db->get('port_company_data CD');
        // debug_last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }
	
	#CR QUERY
	public function getTotalCompany_cr($sector = '', $fyear = '', $month = '') {
		$digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
		
        $partner_id = $this->session->userdata('partner_id');
        if (php72_cmp($month) == 01 || php72_cmp($month) == 02 || php72_cmp($month) == 03) {
            $nxtye = $fyear + 1;
        } else {
            $nxtye = $fyear;
        }
		$sign_date = $nxtye . '-' . $month;
        $exit_fyear = $nxtye . '-' . $month . '-01 00:00:00';
		
		// Assuming $sector is the variable you want to dynamically include
		if (!empty($sector)) {
			$this->db->where("(FIND_IN_SET('$sector', REPLACE(D.sector, ' ', '')) > 0 OR (D.sector IS NULL AND FIND_IN_SET('$sector', REPLACE(BN.sector, ' ', '')) > 0))");
		}
		$this->db->select('count(DISTINCT CD.id) as total_company');
		$this->db->from('port_company_data CD');
		$this->db->join('port_business BN', 'BN.inv_id = CD.inv_id', 'left');
		$this->db->join('port_business_year D', 'D.inv_id = BN.inv_id', 'left');
		$this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');
		$this->db->join('port_incubation_relation IR', 'IR.inv_id = CD.inv_id', 'left');

		// Additional conditions
		//$this->db->where('BN.sector', $sector);
		$this->db->where("DATE_FORMAT(IR.initial_signed_on, '%Y-%m') <= '$sign_date' AND (DATE_FORMAT(IR.exit_date, '%Y-%m') > '$sign_date' OR YEAR(IR.exit_date) = 0000)");
		$this->db->where('IP.partner_id',(int)$partner_id);
		$this->db->where('IP.stage', '12');
		$this->db->where('CD.status !=', '3');
		$this->db->where_not_in('IP.status', array('4', '10', '11'));

		$query = $this->db->get();
		//debug_last_query();
		$rows = $query->result_array();
		return $rows;  
		
    }
	
	#CR QUERY
	public function getNewCompany_cr($sector = '', $f_year = '', $month = '') {
		// Assuming $this->db is your CodeIgniter database instance
		$digits = (int)(log($month, 10) + 1);
		if ($digits > 1) {
			$month = $month;
		} else {
			$month = '0' . $month;
		}
		$partner_id = $this->session->userdata('partner_id');

		$current_date = $f_year . '-04-01 00:00:00';
		$nda_cond = "IR.initial_signed_on > '$current_date'";

		$nxtye = $f_year + 1;
        $current_date = $f_year . '-04-01 00:00:00';
        $next_fyear = $nxtye . '-03-31 23:59:59';
        $yr_cond = "IR.initial_signed_on BETWEEN '$current_date' AND '$next_fyear'";
        $this->db->where($yr_cond);
		
		$this->db->where($nda_cond);
		if (!empty($sector)) {
			$dynamicCondition = "(FIND_IN_SET('1', REPLACE(D.sector, ' ', '')) > 0 OR (D.sector IS NULL AND FIND_IN_SET('1', REPLACE(BN.sector, ' ', '')) > 0))";
			$this->db->where($dynamicCondition);
		}
		
		$this->db->select('COUNT(DISTINCT CD.id) as new_company');
		$this->db->from('port_company_data CD');
		$this->db->join('port_business BN', 'BN.inv_id = CD.inv_id', 'left');
		$this->db->join('port_business_year D', 'D.inv_id = BN.inv_id', 'left');
		$this->db->join('port_incubation_relation IR', 'IR.inv_id = CD.inv_id', 'left');
		$this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');

		$this->db->where('MONTH(IR.initial_signed_on)', $month);
		$this->db->where('IP.partner_id', (int)$partner_id);
		$this->db->where('IP.stage', '12');
		$this->db->where('CD.company_status', '1');
		$this->db->where('CD.status !=', '3');
		$this->db->where_not_in('IP.status', array('4', '10', '11'));

		$query = $this->db->get();
		$result = $query->row()->new_company;
		return $result;



    }
	

    /* for selection quarterly */

    public function getQuarterwiseTotalCompany($cond = '', $fyear = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }

        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = php72_implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }
        $partner_id = $this->session->userdata('partner_id');
        if (php72_cmp($month) == 01 || php72_cmp($month) == 02 || php72_cmp($month) == 03) {
            $nxtye = $fyear + 1;
        } else {
            $nxtye = $fyear;
        }
        // $current_date = $fyear . '-04-01 00:00:00';
        // $next_fyear = $nxtye . '-03-31 00:00:00';

        $sign_date = $nxtye . '-' . $month;
        $exit_fyear = $nxtye . '-' . $month . '-01 00:00:00';
        // $nda_cond = "CD.created_at BETWEEN '$current_date' AND '$next_fyear'";
        $nda_cond = "DATE_FORMAT(IR.initial_signed_on, '%Y-%m') <= '$sign_date' AND (DATE_FORMAT(IR.exit_date, '%Y-%m') > '$sign_date' OR YEAR(IR.exit_date) = 0000)";
        $this->db->where($nda_cond);
        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.stage' => '12', 'CD.status !=' => '3'));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $this->db->select('CD.id, IR.inv_id, CD.name, MONTH(IR.initial_signed_on) as month, MONTH(IR.exit_date) as exitmonth, IR.initial_signed_on as year, YEAR(IR.exit_date) as exityear, IR.exit_date');
        // $this->db->select('count(CD.id) as total_company');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
		#CR QUERY 
		$this->db->join('port_business_year B', 'B.inv_id = BN.inv_id', 'left');
		#CR QUERY 
        $this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id = CD.inv_id', 'left');

        $query = $this->db->get('port_company_data CD');
        // debug_last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getNewCompany($cond = '', $f_year = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = php72_implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }
        $partner_id = $this->session->userdata('partner_id');

        $current_date = $f_year . '-04-01 00:00:00';
        $nda_cond = "IR.initial_signed_on > '$current_date'";

        $nxtye = $f_year + 1;
        $current_date = $f_year . '-04-01 00:00:00';
        $next_fyear = $nxtye . '-03-31 23:59:59';
        $yr_cond = "IR.initial_signed_on BETWEEN '$current_date' AND '$next_fyear'";
        $this->db->where($yr_cond);

        $this->db->where($nda_cond);
        $this->db->where(array('MONTH(IR.initial_signed_on)' => $month, "IP.partner_id" => (int) $partner_id, 'IP.stage' => '12', 'CD.company_status' => '1', 'CD.status !=' => '3'));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $this->db->select('count(CD.id) as new_company');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');

        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getQuarterwiseNewCompany($cond = '', $f_year = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = php72_implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }
        $partner_id = $this->session->userdata('partner_id');

        $current_date = $f_year . '-04-01 00:00:00';
        $nda_cond = "IR.initial_signed_on > '$current_date'";

        $nxtye = $f_year + 1;
        $current_date = $f_year . '-04-01 00:00:00';
        $next_fyear = $nxtye . '-03-31 23:59:59';
        $yr_cond = "IR.initial_signed_on BETWEEN '$current_date' AND '$next_fyear'";
        $this->db->where($yr_cond);

        $this->db->where($nda_cond);
        $this->db->where(array('MONTH(IR.initial_signed_on)' => $month, "IP.partner_id" => (int) $partner_id, 'IP.stage' => '12', 'CD.company_status' => '1', 'CD.status !=' => '3'));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $this->db->select('CD.id');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
		#CR QUERY 
		$this->db->join('port_business_year B', 'B.inv_id = BN.inv_id', 'left');
		#CR QUERY 
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');

        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    /* for selection ends */

    /* for discovery */

    public function companyApplicationCount($sector = '', $subsector = '', $fyear = '', $month = '') {
        $digits = (int) (log($month, 10) + 1);
        if ($digits > 1) {
            $month = $month;
        } else {
            $month = 0 . $month;
        }
        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }

        if ($subsector != "") {
            $subsectorinv = "and INV.sub_sector IN($subsector)";
            $subsectorpitch = "and PITCH2.sub_sector IN($subsector)";
        } else {
            $subsectorinv = "";
            $subsectorpitch = "";
        }
        $nxtye = $fyear + 1;
        $date_value = "$fyear-04-01 00:00:00";
        $next_fy = "$nxtye-03-31 23:59:59";


        $partner_id = $this->session->userdata('partner_id');
        $this->db->select("sum(case when IP.program = '0' and INV.submitted_date >= '$date_value' and INV.submitted_date <= '$next_fy' and MONTH(INV.submitted_date) = '$month' $sectorcond $subsectorinv then 1 else 0 end) inc_app,
            sum(case when IP.program = '1' and EIR.date_submitted >= '$date_value' and EIR.date_submitted <= '$next_fy' and MONTH(EIR.date_submitted) = '$month' $sectorcond  then 1 else 0 end) eir_app,
            sum(case when IP.program = '2' and SEED.submitted_date >= '$date_value' and SEED.submitted_date <= '$next_fy' and MONTH(SEED.submitted_date) = '$month' $sectorcond then 1 else 0 end) seed_app,
            sum(case when IP.program = '3' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' and MONTH(PITCH.submitted_date) = '$month' $sectorcond $subsectorpitch then 1 else 0 end) pitch_app,
            sum(case when IP.program = '4' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' and MONTH(PITCH.submitted_date) = '$month' $sectorcond $subsectorpitch then 1 else 0 end) liveli_app
            ");
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('eir_user EIR', 'EIR.innovation_no = IP.innovation_id', 'left');
        $this->db->join('seed_step1 SEED', 'SEED.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_user PITCH', 'PITCH.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2 PITCH2', 'PITCH2.pitch_id = PITCH.pitch_id', 'left');
        $this->db->from('innovation_pool IP');
        $this->db->where(array("IP.partner_id" => (int) $partner_id));
        $this->db->where("IP.status NOT IN('4','10','11')");
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    /* ends for discovery */

    public function getPendingSectorplans() {
        $query = "select GROUP_CONCAT(DISTINCT sector_id SEPARATOR ',') as sector from sector_plan_approval where config_approval = 2";
//        $this->db->select("GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation");
//        $this->db->where('config_approval', 2);
        $result = $this->db->query($query);
        $rows = $result->result_array();
        return $rows;
    }

    public function pendingSectorListing($num, $offset, $sectors) {
        $this->db->select("SP.sector_id, SP.financial_year, SC.sector as sector_name");
        $this->db->join('sector_category SC', 'SC.id =  SP.sector_id', 'left');
        $this->db->distinct();
        $this->db->group_by("SP.sector_id");
        if ($sectors != '') {
            $seccond = "SP.sector_id IN ($sectors)";
            $this->db->where($seccond);
        }

        $this->db->where('SP.config_approval', 2);
        $this->db->limit($num, $offset);
        $query = $this->db->get('sector_plan_approval SP');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTPendingSectorCount($search_value, $sectors, $status, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("SP.sector_id, SC.sector as sector_name");
        $this->db->join('sector_category SC', 'SC.id =  SP.sector_id', 'left');
        $this->db->distinct();
        $this->db->group_by("SP.sector_id");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        if ($sectors != '') {
            $seccond = "SP.sector_id IN ($sectors)";
            $this->db->where($seccond);
        }
        $this->db->where('SP.config_approval', 2);
        $query = $this->db->get('sector_plan_approval SP');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTPendingSectorList($num, $offset, $sectors, $search_value, $status, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("SP.sector_id, SC.sector as sector_name");
        $this->db->join('sector_category SC', 'SC.id =  SP.sector_id', 'left');
        $this->db->distinct();
        $this->db->group_by("SP.sector_id");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($sectors != '') {
            $seccond = "SP.sector_id IN ($sectors)";
            $this->db->where($seccond);
        }

        $this->db->where('SP.config_approval', 2);

        $this->db->limit($num, $offset);
        $query = $this->db->get('sector_plan_approval SP');
        $rows = $query->result_array();
        return $rows;
    }

    /* for graphs */

    public function getTargetDiscovery($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_discovery t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetDiligence($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_diligence t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetSelection($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_selection t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetGraduates($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_graduates t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetExits($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_exits t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetRenewalagreement($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_donorengagement t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getSumrenewalagreement($sector = '') {
        if ($sector != '') {
            $this->db->where('t1.sector_id', $sector);
        }
        $this->db->select('t1.sector_id, t2.signed_date as agreement_signed_date, MONTH(t2.signed_date) as renewalmonth, YEAR(t2.signed_date) as renewalyear, t2.grant_amount as amount');
        $this->db->where(array('t1.status !=' => 3));
        $this->db->join('grant_list t2', 't2.id = t1.grant_id', 'left');
        $result = $this->db->get('sector_actual_donorengagement t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetNewagreement($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_donorconnect t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getSumnewagreement($sector = '') {
        if ($sector != '') {
            $this->db->where('t1.sector_id', $sector);
        }
        $this->db->select('t1.sector_id, t2.signed_date as agreement_signed_date, MONTH(t2.signed_date) as newagreemonth, YEAR(t2.signed_date) as newagreeyear, t2.grant_amount as amount');
        $this->db->where(array('t1.status !=' => 3));
        $this->db->join('grant_list t2', 't2.id = t1.grant_id', 'left');
        $result = $this->db->get('sector_actual_donorconnect t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetEquity($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_equity t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
	
	#CR QUERY
    public function getActualEquityCompanies($sector = '', $month, $year) {
	
	   #old-query
       /* if ($sector != '') {
            $this->db->where('B.sector', $sector);
        }
        $this->db->select("count(DISTINCT A.id) as equitycount");
        $this->db->join('port_business B', 'B.inv_id = A.inv_id', 'left');
        $this->db->join('plan_vif_equity C', 'C.inv_id = A.inv_id', 'left');
        $this->db->where(array('C.month' => $month, 'C.financial_year' => $year, 'A.status !=' => 3, 'C.status !=' => 3));
        $query = $this->db->get('port_company_data A');
        $rows = $query->result_array(); */
		#return $rows;
		#old-query
        
		#new-query
		$dynamicConditions = '';
		if ($sector !== '') {
			$dynamicConditions .= "(FIND_IN_SET('$sector', REPLACE(D.sector, ' ', '')) > 0 OR (D.sector IS NULL AND FIND_IN_SET('$sector', REPLACE(B.sector, ' ', '')) > 0)) AND ";
		}
		$dynamicConditions = rtrim($dynamicConditions, " AND ");	
		$this->db->select("count(DISTINCT A.id) as equitycount")
			->from('port_company_data A')
			->join('port_business B', 'B.inv_id = A.inv_id', 'left')
			->join('plan_vif_equity C', 'C.inv_id = A.inv_id', 'left')
			->where(['C.month' => $month, 'C.financial_year' => $year, 'A.status !=' => 3, 'C.status !=' => 3]);
		if ($sector !== '') {
			$this->db->join('port_business_year D', 'D.inv_id = A.inv_id', 'left');
			$this->db->where($dynamicConditions, null, false);
		}
		$query = $this->db->get();
		#echo $this->db->last_query();
		$rows = $query->result_array();
		#echo '<pre>';print_r($rows);
		return $rows;
		#new-query



    }

    public function getTargetConsultingengagement($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $this->db->where(array('t1.status' => '1'));
        $this->db->select('t1.*');
        $result = $this->db->get('sector_plan_portfolioreturns t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualConsultingengagement($sector = '', $month, $year) {
        if ($sector != '') {
            $this->db->where('A.sector_id', $sector);
        }
        $this->db->select("count(A.id) as consultingcount");
        $this->db->where(array('A.month' => $month, 'A.financial_year' => $year, 'A.status !=' => 3));
        $query = $this->db->get('sector_actual_portfolioreturns A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getGrantFunderList($type = '') {
        if ($type != '') {
            $this->db->where('t2.grant_service', "$type");
        }
        $this->db->select("t2.id, t2.name");
        $this->db->join('funder_list t2', 't2.id = t1.funder_id', 'left');
        $this->db->where(array('t1.status_type' => 'open', 't1.status' => '1'));
        $this->db->group_by('t1.funder_id');
        $this->db->order_by('t2.name', 'asc');
        $query = $this->db->get('grant_list t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getGrantList($id = '') {
        $this->db->select("id, name, signed_date, purpose");
        $this->db->where(array('funder_id' => $id, 'status_type' => 'open', 'status' => '1'));
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('grant_list');
        $rows = $query->result_array();
        return $rows;
    }

}
