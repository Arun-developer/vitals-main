<?php

class Mportfolio extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
    }
	
	
	 public function get_programID() {
		 
		 $this->db->select("pb.id,ip.program");
		 $this->db->join("port_business pb","pb.inv_id = ip.copy_id");
		 $this->db->from('innovation_pool ip');
		 $query = $this->db->get();
         $rows = $query->result_array();
		 return $rows;
		 
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

    public function getActualMonthNumber() {
        return array("Jan" => '1', "Feb" => '2', "Mar" => '3', "Apr" => '4', "May" => '5', "Jun" => '6', "Jul" => '7', "Aug" => '8', "Sep" => '9', "Oct" => '10', "Nov" => '11', "Dec" => '12');
    }

    public function monthByQuarters() {
        $fy_months = $this->month();
        $quart_1 = array_slice($fy_months, 0, 3);
        $quart_2 = array_slice($fy_months, 3, 3);
        $quart_3 = array_slice($fy_months, 6, 3);
        $quart_4 = array_slice($fy_months, 9, 3);

        $quarter_arr = array();
        foreach ($quart_1 as $key => $value) {
            $set_key = date('n', strtotime($value));
            $quarter_arr[$set_key] = 'Q1';
        }
        foreach ($quart_2 as $key => $value) {
            $set_key = date('n', strtotime($value));
            $quarter_arr[$set_key] = 'Q2';
        }
        foreach ($quart_3 as $key => $value) {
            $set_key = date('n', strtotime($value));
            $quarter_arr[$set_key] = 'Q3';
        }
        foreach ($quart_4 as $key => $value) {
            $set_key = date('n', strtotime($value));
            $quarter_arr[$set_key] = 'Q4';
        }
        return $quarter_arr;
    }

    public function find_application_partner($inv_id) {
        $data = array();
        $this->db->select('partner_id');
        $this->db->where('id', $inv_id);
        $query = $this->db->get('innovation_pool');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function companyCount_old($sector, $fin_year = '') {
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $fin_year));

        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->select("sum(case when IP.stage = '7' and LG.stage = '7' and LG.modified_date >= '$fin_year-$start_month-01 00:00:00' $sectorcond then 1 else 0 end) Application,
            sum(case when IP.stage = '8' and LG.stage = '8' and LG.status = '15' and LG.modified_date >= '$fin_year-$start_month-01 00:00:00' $sectorcond then 1 else 0 end) PA_RD,
            sum(case when ((IP.status = '14' or IP.status = '13') and (LG.status = '14' or LG.status = '13')) and ((IP.stage = '9' or IP.stage = '11') and (LG.stage = '9' or LG.stage = '11')) and LG.modified_date >= '$fin_year-$start_month-01 00:00:00' $sectorcond then 1 else 0 end) IIC_Approved,
            sum(case when ((IP.status = '17' or IP.status = '18') and (LG.status = '17' or LG.status = '18')) and ((IP.stage = '10' or IP.stage = '11') and (LG.stage = '10' or LG.stage = '11')) and LG.modified_date >= '$fin_year-$start_month-01 00:00:00' $sectorcond then 1 else 0 end) EIC_Approved");
        $this->db->join('application_status_log LG', 'LG.innovation_id =  IP.copy_id', 'left');
        $this->db->from('innovation_pool IP');
        $this->db->where("IP.partner_id", $partner_id);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function companyApplicationCount($sector, $fin_year = '') {
        $partner_id = $this->session->userdata('partner_id');
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $fin_year));
        $end_month = date('m', strtotime($get_fy_month[11] . ' ' . $fin_year));
        $get_end_year = $this->getFYtoYear($partner_id, $fin_year);
        $nxtye = $get_end_year[0]['fin_to_year'];
        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $date_value = "$fin_year-$start_month-01 00:00:00";
        $a_date = "$nxtye-$end_month-15";
        $last_date = date("t", strtotime($a_date));
        $next_fy = "$nxtye-$end_month-$last_date 23:59:59";
        $this->db->select("sum(case when IP.program = '0' and INV.submitted_date >= '$date_value' and INV.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) inc_app,
            sum(case when IP.program = '1' and EIR.date_submitted >= '$date_value' and EIR.date_submitted <= '$next_fy' $sectorcond then 1 else 0 end) eir_app,
            sum(case when IP.program = '2' and SEED.submitted_date >= '$date_value' and SEED.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) seed_app,
            sum(case when IP.program = '3' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) pitch_app,
            sum(case when IP.program = '4' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) liveli_app,
            sum(case when IP.program = '5' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) fpai_app,
            sum(case when IP.program = '6' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) ubs_app,
            sum(case when IP.program = '7' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) ysvf_app,
            sum(case when IP.program = '8' and PITCH.submitted_date >= '$date_value' and PITCH.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) aws_app,
            sum(case when IP.program = '9' and INV.submitted_date >= '$date_value' and INV.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) afd_app,
            sum(case when IP.program = '10' and INV.submitted_date >= '$date_value' and INV.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) tanseed_app,
            sum(case when IP.program = '11' and INV.submitted_date >= '$date_value' and INV.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) sisfs_app,
            sum(case when IP.program = '12' and INV.submitted_date >= '$date_value' and INV.submitted_date <= '$next_fy' $sectorcond then 1 else 0 end) yash_app
            ");
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('eir_user EIR', 'EIR.innovation_no = IP.innovation_id', 'left');
        $this->db->join('seed_step1 SEED', 'SEED.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_user PITCH', 'PITCH.inno_id = IP.innovation_id', 'left');
        $this->db->from('innovation_pool IP');
        $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value", 'IP.status !=' => '11'));
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function companyCount($sector, $fin_year = '') {
        $partner_id = $this->session->userdata('partner_id');
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $fin_year));
        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $date_value = "$fin_year-$start_month-01 00:00:00";
        $this->db->select("sum(case when (IP.stage = '8' or IP.stage = '9' or IP.stage = '12') and LG.stage = '8' and LG.status = '12' and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) PA_RD,
            sum(case when IP.stage = '9' and IP.status = '13' and LG.status = '13' and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) open_IIC,
            sum(case when IP.stage = '9' and IP.status = '14' and LG.status = '14' and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) close_IIC,
            sum(case when IP.stage = '12' and IP.status = '12' and (LG.status = '13' or LG.status = '14') and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) inc_IIC,
            sum(case when IP.stage = '9' and IP.status = '17' and LG.status = '17' and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) open_EIC,
            sum(case when IP.stage = '9' and IP.status = '18' and LG.status = '18' and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) close_EIC,
            sum(case when IP.stage = '9' and IP.status = '20' and LG.status = '20' and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) final_EIC,
            sum(case when IP.stage = '12' and IP.status = '12' and (LG.status = '17' or LG.status = '18' or LG.status = '20') and LG.modified_date >= '$date_value' $sectorcond then 1 else 0 end) inc_EIC
            ");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id));
        $this->db->order_by('IP.id', 'desc');
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function pard_allCount($sector, $fin_year = '') {
        $partner_id = $this->session->userdata('partner_id');
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $fin_year));
        $end_month = date('m', strtotime($get_fy_month[11] . ' ' . $fin_year));
        $get_end_year = $this->getFYtoYear($partner_id, $fin_year);
        $nxtye = $get_end_year[0]['fin_to_year'];

        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $date_value = "$fin_year-$start_month-01 00:00:00";
        $a_date = "$nxtye-$end_month-15";
        $last_date = date("t", strtotime($a_date));
        $next_fy = "$nxtye-$end_month-$last_date 23:59:59";

        $log_where = "LG.stage = '8' and LG.status = '12' and LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy' $sectorcond";
        $this->db->select("count(DISTINCT IP.id) as PARD_count");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.status !=' => '11'));
        $this->db->where($log_where);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function IIC_allCount($sector, $fin_year = '') {
        $partner_id = $this->session->userdata('partner_id');
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $fin_year));
        $end_month = date('m', strtotime($get_fy_month[11] . ' ' . $fin_year));
        $get_end_year = $this->getFYtoYear($partner_id, $fin_year);
        $nxtye = $get_end_year[0]['fin_to_year'];

        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $date_value = "$fin_year-$start_month-01 00:00:00";
        $a_date = "$nxtye-$end_month-15";
        $last_date = date("t", strtotime($a_date));
        $next_fy = "$nxtye-$end_month-$last_date 23:59:59";

        $log_where = "LG.stage = '8' and LG.status = '15' $sectorcond";
        $this->db->select("count(DISTINCT IP.id) as IIC_count");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->join('grading_feedback GF', 'GF.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        $this->db->where("IF(GF.internal_date != '0000-00-00', GF.internal_date >= '$date_value' and GF.internal_date <= '$next_fy', LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy')");
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.status !=' => '11'));
        $this->db->where($log_where);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function EIC_allCount($sector, $fin_year = '') {
        $partner_id = $this->session->userdata('partner_id');
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $fin_year));
        $end_month = date('m', strtotime($get_fy_month[11] . ' ' . $fin_year));
        $get_end_year = $this->getFYtoYear($partner_id, $fin_year);
        $nxtye = $get_end_year[0]['fin_to_year'];

        if ($sector != "") {
            $sectorcond = "and IP.sector = '$sector'";
        } else {
            $sectorcond = '';
        }
        $date_value = "$fin_year-$start_month-01 00:00:00";
        $a_date = "$nxtye-$end_month-15";
        $last_date = date("t", strtotime($a_date));
        $next_fy = "$nxtye-$end_month-$last_date 23:59:59";

        $log_where = "LG.stage = '9' and (LG.status = '17' or LG.status = '18') and LG.modified_date >= '$date_value' and LG.modified_date <= '$next_fy' $sectorcond";
        $this->db->select("count(DISTINCT IP.id) as EIC_count");
        $this->db->join('application_status_log LG', 'LG.innovation_id = IP.id', 'left');
        $this->db->from('innovation_pool IP');
        // $this->db->where(array("IP.partner_id" => (int) $partner_id, "IP.created_date >=" => "$date_value"));
        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.status !=' => '11'));
        $this->db->where($log_where);
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function companyCountIncubatee($sector, $field = '', $fin_year = '') {
        if ($sector != "" && $sector != null) {
            $port_sector = "sector IN($sector)";
            $this->db->where($port_sector);
        }

        if ($fin_year != '') {
            $this->db->where('financial_year', $fin_year);
        }

        $partner_id = $this->session->userdata('partner_id');
        $this->db->select("sum(app_annual) as application, sum(pard_annual) as pa_rd, sum(iic_annual) as iic_approve, sum(eic_annual) as eic_approve, sum($field) as tot_annual, sum(new_annual) as new_annual, sum(ext_annual) as exit_annual, sum(grad_annual) as graduate_annual");
        $this->db->where(array("partner_id" => (int) $partner_id, 'status' => '1'));

        $this->db->from('port_dashboard_master');
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function companyTotalIncubatee($sector) {
        if ($sector != "") {
            $port_sector = "and BN.sector IN($sector)";
        } else {
            $port_sector = '';
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where("IP.partner_id", (int) $partner_id);
        $this->db->select("sum(case when IP.stage = '12' and CD.company_status = '1' $port_sector then 1 else 0 end) total_company");
        $this->db->join('port_company_data CD', 'CD.inv_id = IP.copy_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->from('innovation_pool IP');

        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

//    public function companyCount($sector) {
//        if ($sector != "") {
//            $sectorcond = "and IP.sector IN($sector)";
//            $port_sector = "and BN.sector IN($sector)";
//        } else {
//            $sectorcond = '';
//            $port_sector = '';
//        }
//        $partner_id = $this->session->userdata('partner_id');
//        $this->db->select("sum(case when IP.stage = '12' and IP.status != '3' and CD.company_status != '2' $port_sector then 1 else 0 end) COS,
//            sum(case when IP.stage = '7' $sectorcond then 1 else 0 end) Application,
//            sum(case when (IP.stage = '8' or IP.stage = '9' or IP.stage = '12') $sectorcond then 1 else 0 end) PA_RD,
//            sum(case when IP.status = '13' then 1 else 0 end) + sum(case when IP.status = '17' then 1 else 0 end) + sum(case when (IP.stage = '12') $sectorcond then 1 else 0 end) IIC_Approved,
//            sum(case when IP.status = '17' then 1 else 0 end) + sum(case when (IP.stage = '12') $sectorcond then 1 else 0 end) EIC_Approved,
//            sum(case when IP.id != '' $sectorcond then 1 else 0 end) Total_count,
//            sum(case when IP.stage = '12' and IP.status = '12' $sectorcond then 1 else 0 end) + sum(case when IP.stage = '12' and IP.status = '9' and YEAR(INC.initial_signed_on) = YEAR(CURDATE()) $sectorcond then 1 else 0 end) total_company,
//            sum(case when IP.stage = '12' and IP.status = '12' and YEAR(INC.initial_signed_on) = YEAR(CURDATE()) $sectorcond then 1 else 0 end) new_company,
//            sum(case when IP.status = '9' and YEAR(INC.initial_signed_on) = YEAR(CURDATE()) $sectorcond then 1 else 0 end) exits");
//        $this->db->join('port_company_data CD', 'CD.inv_id = IP.copy_id', 'left');
//        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
//        $this->db->join('port_incubation_relation INC', 'INC.inv_id =  IP.copy_id', 'left');
//        $this->db->from('innovation_pool IP');
//        $this->db->where("IP.partner_id = $partner_id");
//        $query = $this->db->get();
//        $rows = $query->result_array();
//        return $rows;
//    }

    public function getProgramName($inv_id) {
        /* $this->db->select('t2.program_name');
        $this->db->where('t1.id', $inv_id);
        $this->db->join('program_type t2', 't2.program_id =  t1.program', 'left');
        $query = $this->db->get('innovation_pool t1'); */
		
		/* $this->db->select('t2.program_name');
        $this->db->where('t1.inv_id', $inv_id);
        $this->db->join('program_type t2', 't2.program_id =  t1.program', 'left');
		$query = $this->db->get('port_business t1');

        $rows = $query->result_array();
        return $rows; */
		
		$raw = "SELECT t2.program_name FROM port_business t1 LEFT JOIN program_type t2 ON FIND_IN_SET(t2.program_id, t1.program) WHERE t1.inv_id = ".$inv_id."";
		$result = $this->db->query($raw);
		$rows = $result->result_array();
        return $rows;
		
    }

    public function getSummaryDetails($table, $sector = '', $fy = '') {
		$sel_fy = $fy.'-12-31';
        if ($sector > 0) {
            $this->db->where('PB.sector', $sector);
            $this->db->join('port_business PB', 'PB.inv_id = IP.id', 'left');
        }

        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('CD.partner_id' => (int) $partner_id, 'IP.stage' => '12', 'IP.status !=' => '3', 'IP.status !=' => '11'));
        if ($fy != '') {
			if($this->session->userdata('emp_number') =='275'){
				//$this->db->where("`IR`.initial_signed_on <= '$sel_fy'");
			}
			//if($this->session->userdata('emp_number')=='275'){
				//echo $sel_fy;
				//$this->db->where("IF(`IR`.`initial_signed_on` != '0000-00-00 00:00:00', `IR`.initial_signed_on >= $sel_fy, '')");
				//$this->db->where("`IR`.initial_signed_on <= '$sel_fy'");
				//$this->db->where("`IR`.exit_date >= '$sel_fy'");
				//$this->db->where("'$sel_fy' between `IR`.initial_signed_on and `IR`.initial_signed_on");
				
			//}
            $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");
            $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        }
//        $this->db->select('IP.id, IP.name_of_enterprise,(`IP`.`name_of_enterprise`+0 > 0) boolNum,CD.company_status,CD.created_by as emp_id');
        $this->db->select('IP.id, CD.name, CD.name as name_of_enterprise,(`CD`.`name`+0 > 0) boolNum,CD.company_status,CD.created_by as emp_id, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month');
        $this->db->join('port_company_data CD', 'CD.inv_id =  IP.id', 'left');
        $this->db->order_by("CD.name ASC,boolNum DESC, CD.company_status", 'ASC');
        $this->db->group_by('CD.inv_id');
        $query = $this->db->get($table . ' IP');		
		
		if($this->session->userdata('emp_number') =='275'){
			//ECHO $fy;
			//debug_last_query();die;
			 $rows = $query->result_array();
			 //echo'<pre>';print_r($rows);die;
		}
		
        $rows = $query->result_array();
        return $rows;
    }

    public function leadCount($sector) {
        $condition = "sector IN($sector)";
        $this->db->select('inv_id, count(id) as pending_count');
        $this->db->where($condition);
        $this->db->where('status', 0);
        $this->db->group_by('id');
        $this->db->from('port_business');
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function getPendingApproval($num, $offset, $sector, $search_value, $inv, $status) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name");
        $this->db->select("GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp_id", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  CD.inv_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by("CD.id", "desc");

        if ($this->session->userdata('user_type') != 'admin' && $sector != "") {
            $sectorcond = "and BN.sector IN($sector)";
        } else {
            $sectorcond = '';
        }

        if ($inv != '') {
            $invcond = "and AP.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $cond = "(CD.partner_id = $partner_id and CD.status = 0 and CD.company_status != 2 $sectorcond $invcond and AA.status = 1)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where('AP.config_approval', 2);

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;

//        SELECT DISTINCT CD.inv_id, CD.innovation_id, GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp, CD.name, BN.stage, SC.sector as sector_name, (select GROUP_CONCAT(CONCAT_WS(' ', emp_firstname, emp_lastname) SEPARATOR ',') from villgro_hris_db.hs_hr_employee where emp_number IN (GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ','))) as emp_name FROM (port_company_data CD) LEFT JOIN assign_associate AA ON AA.innovation = CD.inv_id LEFT JOIN port_business BN ON BN.inv_id = CD.inv_id LEFT JOIN sector_category SC ON SC.id = BN.sector WHERE (CD.partner_id = 1 and CD.status = 0 and BN.sector IN(2,12,1)) GROUP BY CD.inv_id ORDER BY CD.id d
    }

    public function getPortfolioData($table) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getUpcomingMilestones($asslist = '', $limit = '') {
        if ($asslist != '' && count($asslist) > 0) {
            $cond = "C.inv_id IN ($asslist)";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        // $datecond = "((A.due_by < CURDATE()) or (MONTH(A.due_by) >= MONTH(CURDATE()) and MONTH(A.due_by) <= MONTH(CURDATE() + INTERVAL 1 MONTH)))";
        // $datecond = "((A.due_by < CURDATE()) or (A.due_by BETWEEN CURDATE() and CURDATE() + INTERVAL 30 DAY))";
        $datecond = "A.due_by < CURDATE()";
        $this->db->select("C.inv_id, C.financial_year, C.name, A.due_by as date, B.name as company_name,A.type,A.description");
        $this->db->join('port_project_milestone C', 'C.id = A.milestone_id', 'left');
        $this->db->join('port_company_data B', 'B.inv_id = C.inv_id', 'left');
        $this->db->order_by("A.due_by", "asc");
        $this->db->where(array('B.partner_id' => (int) $partner_id, 'C.status' => '1'));
        $this->db->where('A.completed_on', 0);
        $this->db->where($datecond);
        $this->db->limit($limit);
        $query = $this->db->get('port_project_details A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getGrantList($userId = '') {
        $rows = array();
        if ($userId != '') {
            $this->db->select("gr.responsibility as grant_resp,'Report Due' as name,gr.date_of_report as date, gr.submit_date,gr.grant_id as inv_id, fl.name as company_name");
            $this->db->join('funder_list fl', 'fl.id = gr.funder_id', 'left');
            #$d2 = date('d-m-y', strtotime('+30 days'));
            $d2 = date('Y-m-d', strtotime('+30 days'));
            $this->db->where(array('responsibility' => $userId, 'submit_date' => 0, 'gr.date_of_report <' => $d2));
            $query = $this->db->get('grant_reports gr');
            $rows = $query->result();
            return $rows;
        }
    }

    public function getPortUpcomingMilestones($asslist, $limit = '') {
        if ($asslist != '' && count($asslist) > 0) {
            $cond = "C.inv_id IN ($asslist)";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
//        $datecond = "(C.due_by < CURDATE() or C.due_by >= DATE_ADD(curdate(), INTERVAL 1 MONTH))";
        $this->db->select("C.inv_id, C.financial_year, C.name, A.due_by, B.name as company_name,A.type,A.description,D.task_name");
        $this->db->join('port_project_milestone C', 'C.id = A.milestone_id', 'left');
        $this->db->join('port_company_data B', 'B.inv_id = C.inv_id', 'left');
        $this->db->join('port_project_task D', 'D.id = A.task_id', 'left');
        $this->db->order_by("A.due_by", "asc");
        $this->db->where(array('B.partner_id' => (int) $partner_id, 'C.status' => '1', 'D.status' => '1', 'A.status' => '1'));
        $this->db->where('A.type >', '0');
//        $this->db->where($datecond);
        $this->db->limit($limit);
        $query = $this->db->get('port_project_details A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getCompDPMeeting($inv = '', $limit = '', $f_year = '') {
        $partner_id = $this->session->userdata('partner_id');
        $get_fy_month = $this->month();
        $start_month = date('m', strtotime($get_fy_month[0] . ' ' . $f_year));
        $end_month = date('m', strtotime($get_fy_month[11] . ' ' . $f_year));

        $this->db->select("A.task_name, B.name as company_name, C.type, C.due_by, C.description, D.name, D.created_at as date");
        $this->db->join('port_company_data B', 'B.inv_id = A.inv_id', 'left');
        $this->db->join('port_project_details C', 'C.task_id = A.id', 'left');
        $this->db->join('port_project_milestone D', 'D.id = A.milestone_id', 'left');
        if ($inv != '') {
            $this->db->where('A.inv_id', $inv);
        }
        if ($f_year != '') {
            $get_end_year = $this->getFYtoYear($partner_id, $f_year);
            $nxt_fy = $get_end_year[0]['fin_to_year'];
            $fy_cond = "C.due_by between '$f_year-$start_month-01' and '$nxt_fy-$end_month-31'";
            $this->db->where($fy_cond);
        }
        $this->db->where(array('B.partner_id' => (int) $partner_id, 'A.status' => '1'));
        $this->db->where('C.type >', '0');
        $this->db->order_by("C.due_by", "asc");
        $this->db->limit($limit);
        $query = $this->db->get('port_project_task A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getCompUpcomingMilestones($inv = '', $limit = '') {
        $partner_id = $this->session->userdata('partner_id');
        $this->db->select("A.task_name, B.name as company_name, C.type, C.due_by, C.description, D.name, D.created_at as date");
        $this->db->join('port_company_data B', 'B.inv_id = A.inv_id', 'left');
        $this->db->join('port_project_details C', 'C.task_id = A.id', 'left');
        $this->db->join('port_project_milestone D', 'D.id = A.milestone_id', 'left');
        if ($inv != '') {
            $this->db->where('A.inv_id', $inv);
        }
        $this->db->where(array('B.partner_id' => (int) $partner_id, 'A.status' => '1'));
        $this->db->group_by("C.task_id");
        $this->db->order_by("C.due_by", "asc");
        $this->db->limit($limit);
        $query = $this->db->get('port_project_task A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getUpcomingBoardMeetings() {
        $partner_id = $this->session->userdata('partner_id');
        $this->db->select("A.inv_id, A.financial_year, A.name, A.created_at as date, B.name as company_name");
        $this->db->join('port_company_data B', 'B.inv_id = A.inv_id', 'left');
//        $this->db->join('port_project_details C', 'C.milestone_id = A.inv_id', 'left');
        $this->db->where(array('B.partner_id' => (int) $partner_id));
        $this->db->order_by("A.id", "asc");
        $this->db->limit(6);
        $query = $this->db->get('port_project_milestone A');
        $rows = $query->result_array();
        return $rows;
    }

    public function get_dashboardUpcomingTask($asslist = '', $limit = '') {
        if ($asslist != '' && count($asslist) > 0) {
            $cond = "C.inv_id IN ($asslist)";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $datecond = "(A.due_by > CURDATE())";
        $this->db->select("C.inv_id, C.financial_year, C.name, A.due_by as date, B.name as company_name,A.type,A.description");
        $this->db->join('port_project_milestone C', 'C.id = A.milestone_id', 'left');
        $this->db->join('port_company_data B', 'B.inv_id = C.inv_id', 'left');
        $this->db->order_by("A.due_by", "asc");
        $this->db->where(array('B.partner_id' => (int) $partner_id, 'C.status' => '1'));
        $this->db->where('A.completed_on', 0);
        $this->db->where($datecond);
        $this->db->limit($limit);
        $query = $this->db->get('port_project_details A');
        $rows = $query->result_array();
        return $rows;
    }
	
	
	public function getDetailsProgram($table, $condition = '', $status = '', $financial = '', $orderby = '', $column = '', $group = '') {
        if ($status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status == '0' || $status == '1') {
            $this->db->where('status', $status);
        }

        if ($financial != '') {
            $this->db->where('financial_year', $financial);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($column == '') {
            if ($orderby != '') {
                $this->db->order_by('id', $orderby);
            } else {
                $this->db->order_by('id', 'desc');
            }
        } else {
            $this->db->order_by($column, 'asc');
        }

        if ($group != '') {
            $this->db->group_by('port_tap_id, financial_year');
        }

        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getDetails($table, $condition = '', $status = '', $financial = '', $orderby = '', $column = '', $group = '') {
        if ($status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status == '0' || $status == '1') {
            $this->db->where('status', $status);
        }

        if ($financial != '') {
            $this->db->where('financial_year', $financial);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($column == '') {
            if ($orderby != '') {
                $this->db->order_by('id', $orderby);
            } else {
                $this->db->order_by('id', 'desc');
            }
        } else {
            $this->db->order_by($column, 'desc');
        }

        if ($group != '') {
            $this->db->group_by('port_tap_id, financial_year');
        }

        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getDetailsbyId($table, $condition = '',$status=''){

        if ($condition != '') {
            $this->db->where('id',$condition);
        }
        if ($status != '') {
            $this->db->where('status',$status);
        }
        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }


    public function getQualitativePlanExport($table, $condition = '', $status = '', $financial = '', $module_id = '') {
        if ($status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status == '0' || $status == '1') {
            $this->db->where('status', $status);
        }

        if ($financial != '') {
            $this->db->where('financial_year', $financial);
        }
        if ($module_id != '') {
            $this->db->where('module_id', $module_id);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }

        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getQualitativeActualExport($table, $condition = '', $status = '', $financial = '', $module_id = '') {
        if ($status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status == '0' || $status == '1') {
            $this->db->where('status', $status);
        }

        if ($financial != '') {
            $this->db->where('financial_year', $financial);
        }
        if ($module_id != '') {
            $this->db->where('module_id', $module_id);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }

        $this->db->group_by('month');
        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getIncSector() {
        $this->db->select('sector');
        $this->db->where(array('status !=' => '3', 'sector >' => '0'));
        $this->db->group_by('sector');
        $query = $this->db->get('port_business');
        $rows = $query->result_array();
        return $rows;
    }

    public function getIncSectorNames($id) {
        $cond = "id IN ($id)";
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $this->db->select("*");
        $this->db->where('parent_id', 0);
        $this->db->where('pitch', $pitch_id);
        $this->db->where($cond);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function vifExportData($inv_id, $fyear) {
        $this->db->where('status', '1');
        if ($fyear != '') {
            $end_year = $fyear + 1;
            $start_date = $fyear . "-03-31 00:00:00";
            $end_date = $end_year . "-04-01 00:00:00";
            $cond = "month > '$start_date' and month < '$end_date'";
            $this->db->where($cond);
        }
        if ($inv_id != '') {
            $this->db->where('inv_id', $inv_id);
        }

        $this->db->select('*');
        $query = $this->db->get('port_vif_funding');
        $rows = $query->result_array();
        return $rows;
    }

    public function vifPlanExportData($inv_id, $fyear) {
        $this->db->where('status !=', '3');
        if ($fyear != '') {
            $end_year = $fyear + 1;
            $start_date = $fyear . "-03-31 00:00:00";
            $end_date = $end_year . "-04-01 00:00:00";
            $cond = "disburse_date > '$start_date' and disburse_date < '$end_date'";
            $this->db->where($cond);
        }
        if ($inv_id != '') {
            $this->db->where('inv_id', $inv_id);
        }

        $this->db->select('*');

        $query = $this->db->get('plan_vif_funding');
        $rows = $query->result_array();
        return $rows;
    }

    public function tapExportData($inv_id, $fyear, $type) {
        $this->db->where('status', '1');
        if ($type == 'q1') {
            $ns_date = $fyear . "-03-31 00:00:00";
            $ne_date = $fyear . "-07-01 00:00:00";
            $typecond = "need_by > '$ns_date' and need_by < '$ne_date'";
            $this->db->where($typecond);
        } else if ($type == 'q2') {
            $ns_date = $fyear . "-06-30 00:00:00";
            $ne_date = $fyear . "-10-01 00:00:00";
            $typecond = "need_by > '$ns_date' and need_by < '$ne_date'";
            $this->db->where($typecond);
        } else if ($type == 'q3') {
            $ns_date = $fyear . "-09-30 00:00:00";
            $ne_date = $fyear . "-12-31 23:59:59";
            $typecond = "need_by > '$ns_date' and need_by < '$ne_date'";
            $this->db->where($typecond);
        } else if ($type == 'q4') {
            $end_year = $fyear + 1;
            $ns_date = $fyear . "-12-31 00:00:00";
            $ne_date = $end_year . "-04-01 00:00:00";
            $typecond = "need_by > '$ns_date' and need_by < '$ne_date'";
            $this->db->where($typecond);
        }
        if ($inv_id != '') {
            $this->db->where('inv_id', $inv_id);
        }

        $this->db->select('*');

        $query = $this->db->get('port_ttm_tap');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMultiSector($condition) {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $this->db->where($condition);
        $this->db->select('id,sector');
        $this->db->where(array('status' => '1', 'parent_id' => '0', 'pitch' => $pitch_id));
        $this->db->order_by('sector', 'asc');
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getMentorList($branch = '') {
        $data = array();
        if ($branch != '') {
            $this->db->where('partner_id', $branch);
        }

        $this->db->where('emp_type', '9');
        $this->db->select("id as emp_number,CONCAT_WS(' ',emp_first_name,emp_last_name) as emp_name", false);
        $this->db->group_by("id");
        $this->db->order_by("emp_first_name", "asc");
        $query = $this->db->get('hr_user_profile');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getPlanInv() {
        $data = array();
//        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from (select inv_id from plan_board_meetings union all "
        . "select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all "
        . "select inv_id from plan_fundraise union all select inv_id from plan_impact union all "
        . "select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all "
        . "select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all "
        . "select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

//    public function getPendingExistInv($f_year) {
//
//        $data = array();
//        $lmonth = date('n') - 1;
////        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
//        $query = "select GROUP_CONCAT(DISTINCT a.inv_id SEPARATOR ',') as innovation from (select inv_id from plan_board_meetings t where EXISTS( SELECT
//        1
//        FROM
//        plan_board_meetings s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_channel t where EXISTS( SELECT
//        1
//        FROM
//        plan_channel s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_dp t where EXISTS( SELECT
//        1
//        FROM
//        plan_dp s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_fundraise t where EXISTS( SELECT
//        1
//        FROM
//        plan_fundraise s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_loans t where EXISTS( SELECT
//        1
//        FROM
//        plan_loans s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_mentor t where EXISTS( SELECT
//        1
//        FROM
//        plan_mentor s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_pipeline t where EXISTS( SELECT
//        1
//        FROM
//        plan_pipeline s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_sales t where EXISTS( SELECT
//        1
//        FROM
//        plan_sales s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_team_hiring t where EXISTS( SELECT
//        1
//        FROM
//        plan_team_hiring s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_updates t where EXISTS( SELECT
//        1
//        FROM
//        plan_updates s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_finance t where EXISTS( SELECT
//        1
//        FROM
//        plan_finance s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_impact t where EXISTS( SELECT
//        1
//        FROM
//        plan_impact s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_partnerships t where EXISTS( SELECT
//        1
//        FROM
//        plan_partnerships s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all select inv_id from plan_tap t where EXISTS( SELECT
//        1
//        FROM
//        plan_tap s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3) union all "
//                . "select inv_id from plan_vif_funding t where EXISTS( SELECT
//        1
//        FROM
//        plan_vif_funding s
//        WHERE s.id = t.id and
//        s.month = '$lmonth' and s.financial_year = '$f_year' and s.status != 3)) a ";
//        $result = $this->db->query($query);
//        foreach ($result->result_array() as $row) {
//            $data[] = $row;
//        }
//        return $data;
//    }

    public function getPendingTablescnt($tables, $f_year) {
        $query = "select inv_id, financial_year, month from $tables t where t.financial_year = '$f_year' and t.status != 3 group by t.month,t.financial_year,t.inv_id";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getCompanyInvs($inv_id = '') {
        if ($inv_id != '') {
            $cond = "where inv_id NOT IN ($inv_id)";
        }
        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from port_company_data $cond";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPendingExistInv($f_year) {

        $data = array();
        $lmonth = date('n') - 1;
//        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
        $query = "select a.cnt_id, a.inv_id, a.financial_year, a.month from (select  inv_id, financial_year, month from plan_board_meetings t where t.financial_year = '2019' and t.status != 3 group by t.month,t.financial_year,t.inv_id union all "
        . "select inv_id, financial_year, month from plan_channel t where t.financial_year = '2019' and t.status != 3 group by t.month,t.financial_year,t.inv_id union all select inv_id, financial_year, month from plan_dp t where t.financial_year = '2019' and t.status != 3 group by t.month,t.financial_year,t.inv_id union all "
        . "select inv_id, financial_year, month from plan_fundraise t where EXISTS( SELECT
        1
        FROM
        plan_fundraise s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all select inv_id, financial_year, month from plan_loans t where EXISTS( SELECT
        1
        FROM
        plan_loans s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all select inv_id, financial_year, month from plan_mentor t where EXISTS( SELECT
        1
        FROM
        plan_mentor s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all "
        . "select inv_id, financial_year, month from plan_pipeline t where EXISTS( SELECT
        1
        FROM
        plan_pipeline s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all select inv_id, financial_year, month from plan_sales t where EXISTS( SELECT
        1
        FROM
        plan_sales s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all "
        . "select inv_id, financial_year, month from plan_team_hiring t where EXISTS( SELECT
        1
        FROM
        plan_team_hiring s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all select inv_id, financial_year, month from plan_updates t where EXISTS( SELECT
        1
        FROM
        plan_updates s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all "
        . "select inv_id, financial_year, month from plan_finance t where EXISTS( SELECT
        1
        FROM
        plan_finance s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all select inv_id, financial_year, month from plan_impact t where EXISTS( SELECT
        1
        FROM
        plan_impact s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all "
        . "select inv_id, financial_year, month from plan_partnerships t where EXISTS( SELECT
        1
        FROM
        plan_partnerships s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all select inv_id, financial_year, month from plan_tap t where EXISTS( SELECT
        1
        FROM
        plan_tap s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id) union all "
        . "select inv_id, financial_year, month from plan_vif_funding t where EXISTS( SELECT
        1
        FROM
        plan_vif_funding s
        WHERE s.id = t.id and s.financial_year = '$f_year' and s.status != 3 group by s.month,s.financial_year,s.inv_id)) a ";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPendingPlansInv($f_year, $inv_exist) {

        $data = array();
        $lmonth = date('n') - 1;
//        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
        $query = "select GROUP_CONCAT(DISTINCT a.inv_id SEPARATOR ',') as innovation from (select inv_id from plan_board_meetings where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_channel where inv_id NOT IN($inv_exist) union all select inv_id from plan_dp where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_fundraise where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_loans where inv_id NOT IN($inv_exist) union all select inv_id from plan_mentor where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_pipeline where inv_id NOT IN($inv_exist) union all select inv_id from plan_sales where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_team_hiring where inv_id NOT IN($inv_exist) union all select inv_id from plan_updates where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_finance where inv_id NOT IN($inv_exist) union all select inv_id from plan_impact where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_partnerships where inv_id NOT IN($inv_exist) union all select inv_id from plan_tap where inv_id NOT IN($inv_exist) union all "
        . "select inv_id from plan_vif_funding where inv_id NOT IN($inv_exist)) a ";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getFilledPlansInv() {

        $data = array();
        $lmonth = date('n') - 1;
//        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
        $query = "select GROUP_CONCAT(DISTINCT a.inv_id SEPARATOR ',') as innovation from (select inv_id from plan_board_meetings  union all "
        . "select inv_id from plan_channel  union all select inv_id from plan_dp  union all "
        . "select inv_id from plan_fundraise  union all "
        . "select inv_id from plan_loans  union all select inv_id from plan_mentor  union all "
        . "select inv_id from plan_pipeline  union all select inv_id from plan_sales  union all "
        . "select inv_id from plan_team_hiring  union all select inv_id from plan_updates  union all "
        . "select inv_id from plan_finance  union all select inv_id from plan_impact  union all "
        . "select inv_id from plan_partnerships  union all select inv_id from plan_tap  union all "
        . "select inv_id from plan_vif_funding ) a ";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPendingAppInv() {
        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from port_config_approval where config_approval = 2";
//        $this->db->select("GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation");
//        $this->db->where('config_approval', 2);
        $result = $this->db->query($query);
        $rows = $result->result_array();
        return $rows;
    }

    public function getSecEmpId($inv_id) {
        $this->db->select("A.sector, B.employee_id");
        $this->db->join('assign_sector_lead B', 'B.sector_id = A.sector', 'left');
        $this->db->where('A.inv_id', $inv_id);
        $query = $this->db->get('port_business A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getSecEmployee_DD($inv_id) {
        $app_id = "INV$inv_id";
        $this->db->select("A.sector, B.employee_id");
        $this->db->join('assign_sector_lead B', 'B.sector_id = A.sector', 'left');
        $this->db->where('A.innovation_id', $app_id);
        $query = $this->db->get('company_master_data A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getSecEmployee_app($inv_id) {
        $this->db->select("A.sector, B.employee_id");
        $this->db->join('assign_sector_lead B', 'B.sector_id = A.sector', 'left');
        $this->db->where('A.id', $inv_id);
        $query = $this->db->get('innovation_pool A');
        $rows = $query->result_array();
        return $rows;
    }

    public function getOnboardInv() {

        $data = array();
//        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
        $query = "select GROUP_CONCAT(DISTINCT a.inv_id SEPARATOR ',') as innovation from (select inv_id from port_company_data where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_company_data.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_business where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_business.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_management where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_management.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_governance where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_governance.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_villgro_relation where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_villgro_relation.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_incubation_relation where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_incubation_relation.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_cap_table where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_cap_table.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_other_interest where EXISTS( SELECT
        1
        FROM
        port_config_approval
        WHERE
        port_config_approval.inv_id = port_other_interest.inv_id and port_config_approval.config_approval = 3) union all "
        . "select inv_id from port_config_approval where config_approval = 3) a ";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

//    public function getOnboardInv() {
//
//        $data = array();
////        $query = "select GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as innovation from ( select inv_id from plan_board_meetings union all select inv_id from plan_channel union all select inv_id from plan_dp union all select inv_id from plan_finance union all select inv_id from plan_fundraise union all select inv_id from plan_impact union all select inv_id from plan_loans union all select inv_id from plan_mentor union all select inv_id from plan_partnerships union all select inv_id from plan_pipeline union all select inv_id from plan_sales union all select inv_id from plan_tap union all select inv_id from plan_team_hiring union all select inv_id from plan_updates union all select inv_id from plan_vif_funding ) a";
//        $query = "select GROUP_CONCAT(DISTINCT a.inv_id SEPARATOR ',') as innovation from (select inv_id from port_company_data where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_company_data.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_business where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_business.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_management where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_management.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_governance where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_governance.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_villgro_relation where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_villgro_relation.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_incubation_relation where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_incubation_relation.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_cap_table where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_cap_table.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_other_interest where EXISTS( SELECT
//        1
//        FROM
//        port_config_approval
//        WHERE
//        port_config_approval.inv_id = port_other_interest.inv_id and port_config_approval.config_approval != 3) union all "
//                . "select inv_id from port_config_approval where config_approval != 3) a ";
//        $result = $this->db->query($query);
//        foreach ($result->result_array() as $row) {
//            $data[] = $row;
//        }
//        return $data;
//    }

    public function getConApprovalData() {
        $this->db->select("GROUP_CONCAT(DISTINCT inv_id SEPARATOR ',') as inv_id");
        $this->db->where('config_approval !=', 3);
        $query = $this->db->get('port_config_approval');
        $rows = $query->result_array();
        return $rows;
    }

    public function getPendingInputList($num, $offset, $search_value, $inv, $status) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name,CD.company_status, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month");
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by("CD.id", "desc");

        $partner_id = $this->session->userdata('partner_id');

        if ($inv != '') {
            $invcond = "and AP.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }

        $cond = "(CD.partner_id = $partner_id $invcond)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTPendingInputList($num, $offset, $search_value, $inv, $status, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name,CD.company_status, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month");
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($inv != '') {
            $invcond = "and AP.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $cond = "(CD.partner_id = $partner_id $invcond)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }
        if ($num != '' && $offset != '') {
            $this->db->limit($num, $offset);
        }
        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTPendingCount($search_value, $inv, $status, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name,CD.company_status, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month");
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($inv != '') {
            $invcond = "and AP.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $cond = "(CD.partner_id = $partner_id $invcond)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $query = $this->db->get('port_company_data CD');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTPendingApprovalList($num, $offset, $sector, $search_value, $inv, $status, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name");
        $this->db->select("GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp_id", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  CD.inv_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($this->session->userdata('user_type') != 'admin' && $sector != "") {
            $sectorcond = "and BN.sector IN($sector)";
        } else {
            $sectorcond = '';
        }

        if ($inv != '') {
            $invcond = "and AP.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $cond = "(CD.partner_id = $partner_id and CD.status = 0 and CD.company_status != 2 $sectorcond $invcond and AA.status = 1)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where('AP.config_approval', 2);

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTPendingAppCount($sector, $search_value, $inv, $status, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name");
        $this->db->select("GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp_id", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  CD.inv_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        if ($this->session->userdata('user_type') != 'admin' && $sector != "") {
            $sectorcond = "and BN.sector IN($sector)";
        } else {
            $sectorcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $cond = "(CD.partner_id = $partner_id and CD.status = 0 and CD.company_status != 2 $sectorcond and AA.status = 1)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where('AP.config_approval', 2);

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $query = $this->db->get('port_company_data CD');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getJoinDetails($num, $offset, $sector, $search_value, $inv, $status) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name,CD.company_status, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month");
        $this->db->select("GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp_id", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  CD.inv_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
        $this->db->order_by("CD.id", "desc");

        if ($this->session->userdata('user_type') != 'admin' && $sector != "") {
            $sectorcond = "and BN.sector IN($sector)";
        } else {
            $sectorcond = '';
        }

        if ($inv != '') {
            $invcond = "and CD.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $cond = "(CD.partner_id = $partner_id and CD.status = 0 $sectorcond $invcond)";
//        $cond = "(CD.partner_id = $partner_id and CD.status = 0 $sectorcond)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTJoinDetails($num, $offset, $sector, $search_value, $inv, $status, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name,CD.company_status, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month");
        $this->db->select("GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp_id", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  CD.inv_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
//        $this->db->join('port_config_approval AP', 'AP.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
//        $this->db->order_by("CD.id", "desc");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        if ($this->session->userdata('user_type') != 'admin' && $sector != "") {
            $sectorcond = "and BN.sector IN($sector)";
        } else {
            $sectorcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $user_type = $this->session->userdata["user_type"];
        if ($user_type != 'superadmin') {
            $partnercond = "CD.partner_id = $partner_id and";
        } else {
            $partnercond = "";
        }

        if ($inv != '') {
            $invcond = "and CD.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }
//        $cond = "(CD.partner_id = $partner_id and CD.status = 0 $sectorcond and AP.inv_id IN ($inv))";
        $cond = "($partnercond CD.status = 0 $sectorcond $invcond)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }

        $this->db->where($cond);
        $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");

        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTJoinCount($sector, $search_value, $inv, $status, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("CD.inv_id, IP.*, CD.innovation_id, CD.name, IP.stage, SC.sector as sector_name,CD.company_status, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month");
        $this->db->select("GROUP_CONCAT(DISTINCT AA.associate_employee SEPARATOR ',') as emp_id", false);
        $this->db->join('assign_associate AA', 'AA.innovation =  CD.inv_id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  BN.sector', 'left');
        $this->db->join('innovation_pool IP', 'IP.id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by("CD.inv_id");
//        $this->db->order_by("CD.id", "desc");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        if ($this->session->userdata('user_type') != 'admin' && $sector != "") {
            $sectorcond = "and BN.sector IN($sector)";
        } else {
            $sectorcond = '';
        }

        $partner_id = $this->session->userdata('partner_id');
        $user_type = $this->session->userdata["user_type"];
        if ($user_type != 'superadmin') {
            $partnercond = "CD.partner_id = $partner_id and";
        } else {
            $partnercond = "";
        }

        if ($inv != '') {
            $invcond = "and CD.inv_id IN ($inv)";
        } else {
            $invcond = '';
        }
//        $cond = "(CD.partner_id = $partner_id and CD.status = 0 $sectorcond and AP.inv_id IN ($inv))";
        $cond = "($partnercond CD.status = 0 $sectorcond $invcond)";

        if ($status == '3') {
            $this->db->where('IP.status !=', $status);
        }


        if (isset($search_value) && $search_value != '') {
            $this->db->where('CD.innovation_id', $search_value);
        }

        $this->db->where($cond);
        $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");
        $query = $this->db->get('port_company_data CD');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getListingDetails($table, $condition = '', $status = '', $orderby = '') {
        if ($status == '3') {
            $this->db->where('status !=', $status);
        } else {
            $this->db->where('status', $status);
        }

        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($orderby != '') {
            $this->db->order_by('id', $orderby);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getArrayListingDetails($table, $condition = '', $status = '', $orderby = '') {
        if ($status == '3') {
            $this->db->where('status !=', $status);
        } else {
            $this->db->where('status', $status);
        }

        if ($condition != '') {
            $this->db->where_in('innovation', $condition);
        }

        if ($orderby != '') {
            $this->db->order_by('id', $orderby);
        } else {
            $this->db->order_by('id', 'desc');
        }
        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getBranchDetails() {
        $this->db->select("id, partner_name as branch_name");
        $this->db->where('status', '1');
        $query = $this->db->get('hr_partner_type');
        $rows = $query->result_array();
        return $rows;
    }

    public function getPartnerDetails($accessto, $partnerid) {
        $this->db->select("id, partner_name as branch_name");
        if ($accessto != '') {
            $cond = "(id IN ($accessto) OR id = $partnerid)";
        } else {
            $cond = "(id = $partnerid)";
        }
        $this->db->where($cond);
        $this->db->where('status', '1');
        $query = $this->db->get('hr_partner_type');
        $rows = $query->result_array();
        return $rows;
    }

    public function getSalesMaster($table, $condition = '', $f_year = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }
        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        $this->db->order_by('id', 'asc');

        $this->db->select('id, inv_id, financial_year, product_name, unit, value');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getSalesInput($table, $condition = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        $this->db->select('volume, value');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getChannelMaster($table, $condition = '', $f_year = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }
        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        $this->db->order_by('id', 'asc');

        $this->db->select('id, inv_id, financial_year, channel_name, data');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getChannelInput($table, $condition = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        $this->db->select('channel_data');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getConfigMentorsInput($id, $fyear, $month) {
        if ($condition != '') {
            $this->db->where($condition);
        }

        $this->db->where(array('t1.inv_id' => $id, 't1.financial_year' => $fyear, 't1.status' => 1));
        // $this->db->where(array('t1.inv_id' => $id, 't1.status' => 1));

        if ($month < 4) {
            $fin_year = $fyear + 1;
        } else {
            $fin_year = $fyear;
        }

        $current_date = date('d');
        $get_month = date("m", mktime(0, 0, 0, $month, 10));

        $start_date = $fin_year . '-' . $get_month;
        $to_date = $fin_year . '-' . $get_month . '-' . $current_date;

        $end_date = date('Y-m-t', strtotime($to_date));
        // $date_cond = "DATE_FORMAT(t2.start_date, '%Y-%m') <= '$start_date' AND DATE_FORMAT(t2.end_date, '%Y-%m') >= '$start_date'";
        $date_cond = "YEAR(t2.start_date) <= '$fin_year' AND YEAR(t2.end_date) >= '$fin_year'";
        $this->db->where($date_cond);

        $this->db->select('t1.id, t1.inv_id, t1.financial_year, t1.master_id, t1.mentor_id');
        $this->db->join('port_villgro_relation_mentor t2', 't2.id =  t1.master_id', 'left');
        $query = $this->db->get('port_config_mentor t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getMentorsInput($table, $condition = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getVifInput($table, $condition = '', $status = '', $order = '', $add_cond = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        if ($add_cond != '') {
            $this->db->where('month_engaged !=', '0000-00-00');
        }

        if ($order != '') {
            $this->db->order_by('id', 'desc');
        }

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getImpactMetricInput($condition = '', $f_year = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('t1.status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('t1.status', $status);
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }
        $this->db->order_by('t1.id', 'desc');
        $this->db->select('t1.*, t2.*,t1.id as plan_id');
        $this->db->join('port_impact_master t2', 't2.id =  t1.iris_code', 'left');
        $query = $this->db->get('port_impact_metric t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getApprovalDetails($table, $condition = '', $status = '', $financial = '') {
        if ($status != '' && $status == '0') {
            $this->db->where('status', $status);
        }
        if ($financial != '') {
            $this->db->where('financial_year', $financial);
        }
        if ($condition != '') {
            $this->db->where($condition);
        }

        $this->db->order_by('financial_year', 'ASC');
        $this->db->group_by('financial_year, status');

        $this->db->select('*');

        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getConfigApprovalDetails($table, $condition = '', $field = '') {
        $this->db->where($condition);
        $this->db->where($field, '2');
        $this->db->order_by('financial_year', 'ASC');
        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    // public function getProjectApprovalDetails($table, $condition = '', $status = '', $financial = '') {
    //     if ($status != '' && $status == '0') {
    //         $this->db->where('status', $status);
    //     }
    //     if ($financial != '') {
    //         $this->db->where('financial_year', $financial);
    //     }
    //     if ($condition != '') {
    //         $this->db->where($condition);
    //     }
    //     $this->db->order_by('financial_year', 'ASC');
    //     $this->db->group_by('financial_year, status');
    //     $this->db->select('*');
    //     $query = $this->db->get($table);
    //     $rows = $query->result_array();
    //     return $rows;
    // }

    public function getProjectApprovalDetails($table, $condition = '', $status = '', $financial = '') {
        if ($status != '' && $status == '0') {
            $this->db->where('t1.status', $status);
        }
        if ($financial != '') {
            $this->db->where('t1.financial_year', $financial);
        }
        if ($condition != '') {
            $this->db->where('t1.inv_id', $condition);
            $this->db->where('t2.project_approval', '2');
        }

        $this->db->order_by('t1.financial_year', 'ASC');
        $this->db->group_by('t1.financial_year, status');
        $this->db->select('*');
        $this->db->join('port_config_approval t2', 't2.inv_id = t1.inv_id and t2.financial_year = t1.financial_year', 'left');

        $query = $this->db->get("$table t1");
        $rows = $query->result_array();
        return $rows;
    }

    public function approvalCompany($table, $condition, $fields, $status = '') {
        $this->db->set($fields);
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function configApprovalUpdate($table, $condition) {
        $result = '';
        if ($condition != '') {
            $this->db->where($condition);
        }
        $this->db->select('id, product_approval, sales_approval, channel_approval, pipeline_approval, revenue_approval, netprofit_approval, vif_approval, fundraise_approval, mentor_approval, tap_approval, nontap_approval, dp_approval, board_approval, team_approval, impact_approval, project_approval');
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

    public function getAssignIncharge($id) {
        $this->db->select("associate_employee");
        $this->db->where(array('innovation' => $id, 'status' => '1'));
        $this->db->group_by('associate_employee');
        $query = $this->db->get('assign_associate');
        $data = $query->result_array();
        foreach ($data as $a) {
            $query = "SELECT id as emp_number, emp_first_name as emp_firstname, emp_last_name as emp_lastname FROM hr_user_profile where id = '" . $a['associate_employee'] . "'";
            $q = $this->db->query($query);
            $name = $q->result_array();
            $emp_name[] = $name[0]['emp_number'];
        }

        sort($emp_name);
        $assign_to = implode(', ', $emp_name);
        return $assign_to;
    }

    public function getAssociateInnovation($emp_number = '') {
        $data = array();
        $condition = '';
        if ($emp_number != '') {
            $condition = "associate_employee IN($emp_number)";
        }
        $this->db->select("associate_employee, count(innovation) as tot_count");
        $this->db->where($condition);
        $this->db->where('status', '1');
        $this->db->group_by('associate_employee');
        $this->db->order_by("tot_count", "asc");
        $query = $this->db->get('assign_associate');
        $rows = $query->result_array();
        return $rows;
    }

    public function getEmpDetails($partner_id) {
        $this->db->select("UP.id as employee_id, UP.emp_first_name as emp_firstname, UP.emp_last_name as emp_lastname, UL.emp_id as emp_number");
        $this->db->join("hr_user_login UL", "UL.emp_id = UP.id");
        $this->db->where(array('UP.partner_id' => $partner_id));
        $this->db->group_by("UP.id");
        $this->db->order_by("UP.emp_first_name", "asc");
        $query = $this->db->get('hr_user_profile UP');
        $rows = $query->result_array();
        return $rows;
    }

    public function getEmpDetailsById($empid) {
        $this->db->select("GROUP_CONCAT(CONCAT_WS(' ', emp_first_name, emp_last_name) SEPARATOR ',') as emp_names", false);
        if ($empid != '') {
            $cond = "(id IN ($empid))";
            $this->db->where($cond);
        }
        $query = $this->db->get('hr_user_profile');
        $rows = $query->result_array();
        return $rows;
    }

    public function sectorAssignedFor($id = '', $partner_id = '') {
        $rows = array();
        if ($partner_id != '') {
            $this->db->where('partner_id', $partner_id);
        }
        if ($id != '') {
            $this->db->select("employee_id, count(id) as tot_count");
            $this->db->where('sector_id', $id);
            $this->db->where('status', '1');
            $this->db->group_by('sector_id');
            $this->db->order_by("tot_count", "asc");
            $query = $this->db->get('assign_sector_lead');
            $rows = $query->result_array();
        }
        return $rows;
    }

    public function getCommonData($table, $condition = '', $field = '', $status = '', $partner_id = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($status != '') {
            $this->db->where('status !=', $status);
        }
        if ($field != '') {
            $this->db->order_by($field, "asc");
        }
        if ($partner_id != '') {
            $this->db->where('partner_id', $partner_id);
        }
        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getLabelname($table, $condition = '', $id = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($id != '') {
            $this->db->where('id !=', $id);
        }
        if ($status != '') {
            $this->db->where('status !=', $status);
        }
        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getMilestonename($table, $condition = '', $id = '', $status = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($id != '') {
            $this->db->where('id !=', $id);
        }
        if ($status != '') {
            $this->db->where('status !=', $status);
        }
        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function updatePortfolioDetail($table, $data, $condition) {
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table, $data);
        return $result;
    }

    public function insertPortfolioDetail($table, $data) {
        $last_inserted = $this->db->insert($table, $data);
        return $last_inserted;
    }

    public function getAllDeals($num, $offset, $search_value, $employee_id = '') {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("IP.*, pitch.pitch_id");
        $this->db->select("INV.submitted_date");
        $this->db->select("pitch.submitted_date as pitch_submitted_date");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');

        $this->db->distinct();
        $this->db->order_by("id", "desc");

        $partner_id_1 = $this->session->userdata('partner_id');
        $partner_id_2 = '0' . $this->session->userdata('partner_id');
        $cond = "((IP.partner_id = $partner_id_1 or IP.partner_id = $partner_id_2) and IP.stage = '9' and IP.status = '20' and AA.status = 1 )";
//        $cond = "(IP.stage IN ('9') and AA.status = 1)";

        $this->db->where($cond);

        $search_inv = explode("_", $search_value);
        if (isset($search_value) && $search_value != '') {
            $this->db->where('IP.id', $search_inv[0]);
            $this->db->where('IP.partner_id', $search_inv[1]);
            $this->db->where('IP.partner_count', $search_inv[2]);
        }
        if ($employee_id != '') {
            $this->db->where('AA.associate_employee', $employee_id);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('innovation_pool IP');
        $rows = $query->result_array();
        return $rows;
    }

    public function dealsCount($search_value, $employee_id = '') {
        $this->db->select('*');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');

        $this->db->distinct();
        $this->db->order_by("IP.id", "desc");

        $partner_id_1 = $this->session->userdata('partner_id');
        $partner_id_2 = '0' . $this->session->userdata('partner_id');
        $cond = "((IP.partner_id = $partner_id_1 or IP.partner_id = $partner_id_2) and IP.stage = '9' and IP.status = '20' and AA.status = 1)";
//        $cond = "(IP.stage IN ('9'))";

        $search_inv = explode("_", $search_value);
        if (isset($search_value) && $search_value != '') {
            $this->db->where('IP.id', $search_inv[0]);
            $this->db->where('IP.partner_id', $search_inv[1]);
            $this->db->where('IP.partner_count', $search_inv[2]);
        }

        if ($employee_id != '') {
            $this->db->where('AA.associate_employee', $employee_id);
        }

        $this->db->where($cond);
        $query = $this->db->get('innovation_pool IP');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTAllDeals($num, $offset, $search_value, $employee_id = '', $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("IP.*, pitch.pitch_id");
        $this->db->select("INV.submitted_date,sd.submitted_date as seed_date, eir.date_submitted as eir_date");
        $this->db->select("pitch.submitted_date as pitch_submitted_date");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('seed_step1 sd', 'sd.inno_id = IP.innovation_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');

        $this->db->distinct();
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $partner_id_1 = $this->session->userdata('partner_id');
        $partner_id_2 = '0' . $this->session->userdata('partner_id');
        $cond = "((IP.partner_id = $partner_id_1 or IP.partner_id = $partner_id_2) and IP.stage = '9' and IP.status = '20' and AA.status = 1 )";
//        $cond = "(IP.stage IN ('9') and AA.status = 1)";

        $this->db->where($cond);


        if (isset($search_value) && $search_value != '') {
            $search_inv = explode("_", $search_value);
            $this->db->where('IP.id', $search_inv[0]);
            $this->db->where('IP.partner_id', $search_inv[1]);
            $this->db->where('IP.partner_count', $search_inv[2]);
        }
        if ($employee_id != '') {
            $this->db->where('AA.associate_employee', $employee_id);
        }

        $this->db->limit($num, $offset);
        $query = $this->db->get('innovation_pool IP');
        $rows = $query->result_array();
        return $rows;
    }

    public function DTdealsCount($search_value, $employee_id = '', $columns, $requestData) {
        $this->db->select('*');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');

        $this->db->distinct();
        $this->db->order_by($columns[$requestData['order'][0]['column']], $columns[$requestData['order'][0]['dir']]);

        $partner_id_1 = $this->session->userdata('partner_id');
        $partner_id_2 = '0' . $this->session->userdata('partner_id');
        $cond = "((IP.partner_id = $partner_id_1 or IP.partner_id = $partner_id_2) and IP.stage = '9' and IP.status = '20' and AA.status = 1)";
//        $cond = "(IP.stage IN ('9'))";


        if (isset($search_value) && $search_value != '') {
            $search_inv = explode("_", $search_value);
            $this->db->where('IP.id', $search_inv[0]);
            $this->db->where('IP.partner_id', $search_inv[1]);
            $this->db->where('IP.partner_count', $search_inv[2]);
        }

        if ($employee_id != '') {
            $this->db->where('AA.associate_employee', $employee_id);
        }

        $this->db->where($cond);
        $query = $this->db->get('innovation_pool IP');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTDealsCount($options, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;

        $this->db->select("IP.id,IP.copy_id,IP.partner_id,IP.partner_count,IP.copy_partner_id,pitch.lang_code,IP.name_of_enterprise,IP.name_of_entrepreneur");
        $this->db->select("IP.created_by,IP.created_date,IP.source,IP.sourceType,IP.sector,IP.program,IP.stage,IP.status,IP.state,IP.city,EC.city_name,IP.email_id,IP.mobile_no");
        $this->db->select("IP.copied_date,IP.copy_partner_from,SM.source_name,pitch.pitch_id,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("INV.submitted_date,pitch.submitted_date as pitch_submitted_date,eir.date_submitted as eir_submitted_date");
        $this->db->select("(select partner_name from hr_partner_type where id = IP.partner_id) as branch_name", false);
        $this->db->select("award_share.doc1 as pitch_doc1, award_share.doc2 as pitch_doc2");
        $this->db->select("INV_INFO.business_plan as inc_doc1, INV_INFO.add_info as inc_doc2");
        $this->db->select("IFNULL(IFNULL(pitch.submitted_date, INV.submitted_date),eir.date_submitted) AS dsubmitted");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_ent_info iet', 'iet.inv_user_id = INV.id', 'left');
        $this->db->join('inv_additional_info INV_INFO', 'INV_INFO.inv_user_id = INV.id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('award_share', 'award_share.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
        $this->db->join('pitch_step1_info PS1', 'PS1.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_city EC', 'EC.id = PS1.city_id', 'left');
        $this->db->join('shortlist_comments ISC', 'ISC.inv_id = IP.id', 'left');
        $this->db->group_by('IP.id');
        $this->db->order_by('dsubmitted', 'desc');
        $this->db->distinct();

        $searchArray[] = "IP.copy_status != '4'";

        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . implode("','", $options['associate']) . "')";
        }

        $copypartner = $options['copy_id'];
        $copyid = explode("_", $copypartner);
        if ($copypartner != "") {
            $searchArray[] = "(IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch_name'] . "') and IP.partner_count ='" . $copyid[2] . "'";
        } else {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        }

        if ($copypartner != "") {
            $searchArray[] = "IP.copy_id ='" . $copyid[0] . "'";
        }

        $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
        if (!empty($options['name_of_entrepreneur'])) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
        }

        if (isset($options['source_type']) && $options['source_type'] == '0') {
            $searchArray[] = "IP.source IN (0,101,103,123,124,126,127,128,129,130) and (IP.created_by = 0 or IP.created_by IS NULL)";
        } else if (isset($options['source_type']) && $options['source_type'] == '1') {
            $searchArray[] = "IP.source NOT IN (0,101,103,123,124,126,127,128,129,130) and IP.created_by > 0 and IP.created_by IS NOT NULL";
        } else if (isset($options['source_type']) && $options['source_type'] == '2') {
            $searchArray[] = "IP.source IN (124,126)";
        }

        if (!empty($options['sector'])) {
            $searchArray[] = "SC.id = '" . $options['sector'] . "'";
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_sector = $this->session->userdata['sectorAccess'];
				if($customt_sector!=''){
					 $searchArray[] = "SC.id IN(" . $customt_sector . ")";
				}
            }
        }
		

        if (isset($options['program']) && $options['program'] != "") {
            if ($options['program'] == 0) {
                if ($this->session->userdata['role_id'] == '4') {
                    $searchArray[] = "IP.program = 0";
                } else {
                    $searchArray[] = "(IP.program = 0 or IP.program = 4)";
                }
            } else {
                $searchArray[] = "IP.program = '" . $options['program'] . "'";
            }
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_program = $this->session->userdata['programAccess'];
                $searchArray[] = "IP.program IN(" . $customt_program . ")";
            }
        }

        if (isset($options['stage']) && $options['stage'] != "") {
            $searchArray[] = "IP.stage='" . $options['stage'] . "'";
        }

        if (isset($options['status']) && $options['status'] != "") {
            $split_status = explode(',', $options['status']);
            $merge_status = "'" . implode("','", $split_status) . "'";
            if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == '1') {
                $searchArray[] = "(ISC.current_app_status IN(" . $merge_status . ") AND ISC.created_by = " . $this->session->userdata('emp_number') . ")";
            } else {
                $searchArray[] = "IP.status IN(" . $merge_status . ")";
            }
        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
        }

        if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
            $cond_subFrom = $enter_fromDate = date('Y-m-d', strtotime($options['submitted_date']));
            $cond_subTo = $enter_toDate = date('Y-m-d', strtotime($options['submitted_date_to']));
            if ($this->session->userdata('role_id') == '4') {
                $define_fromDate = $this->session->userdata('dealsFrom');
                $define_toDate = $this->session->userdata('dealsTo');
                if ($define_fromDate >= $enter_fromDate) {
                    $cond_subFrom = $define_fromDate;
                } else {
                    $cond_subFrom = $enter_fromDate;
                }
                if ($define_toDate <= $enter_toDate) {
                    $cond_subTo = $define_toDate;
                } else {
                    $cond_subTo = $enter_toDate;
                }
            }
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $cond_subFrom . "' AND INV.submitted_date <='" . $cond_subTo . "') or (pitch.submitted_date >='" . $cond_subFrom . "' and  pitch.submitted_date <='" . $cond_subTo . "'))";
        }

        if (!empty($options['geography'])) {
            $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
        }

        if (!empty($options['city'])) {
            $searchArray[] = "(IP.city like '%" . $options['city'] . "%' OR EC.city_name like '%" . $options['city'] . "%')";
        }

        if (isset($options['lis']) && $options['lis'] != '') {
            $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
        }

        if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
            $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
        }

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
            $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
            $searchArray[] = "AA.status = 1";
        }

        if (!empty($options['email'])) {
            $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
        }

        if (!empty($options['mobile'])) {
            $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
        }

        if ($options['deals_tab'] == 'mydeals') {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 5;
            else
                $check_count = 3;
        } else {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 4;
            else
                $check_count = 2;
        }

        if ($this->session->userdata('role_id') == '4' && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date && $default_toDate!='0000-00-00') {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ((count($searchArray) == $check_count && $this->session->userdata('role_id') != '4') && empty($options['created_date']) && empty($options['created_date']) && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ($options['status'] == "") {
            $searchArray[] = "IP.status NOT IN('4','10','11')";
        }

        if (!empty($options['opertaion_stage'])) {
            $searchArray[] = "(iet.stage_product LIKE '%" . $options['opertaion_stage'] . "%' OR pitch_step2.operation_stage LIKE '%" . $options['opertaion_stage'] . "%')";
        }

        if (!empty($options['enterprise_stage'])) {
            $searchArray[] = "(INV.ent_type LIKE '%" . $options['enterprise_stage'] . "%' OR PS1.ent_type LIKE '%" . $options['enterprise_stage'] . "%')";
        }

        if (count($searchArray) > 0) {
            $whereQuery = implode(' and ', $searchArray);
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }
		if($this->session->userdata('emp_number') =='516'){
			//debug_last_query();die;
		}
		
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTDealsDetails($num, $offset, $options, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("IP.id,IP.copy_id,IP.partner_id,IP.partner_count,IP.copy_partner_id,pitch.lang_code,IP.name_of_enterprise,IP.name_of_entrepreneur");
        $this->db->select("IP.created_by,IP.created_date,IP.source,IP.sourceType,IP.sector,IP.program,IP.stage,IP.status,IP.state,IP.city,EC.city_name,IP.email_id,IP.mobile_no");
        $this->db->select("IP.copied_date,IP.copy_partner_from,SM.source_name,pitch.pitch_id,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("INV.submitted_date,pitch.submitted_date as pitch_submitted_date,eir.date_submitted as eir_submitted_date, SubCat.sector as Sub_Sector");
        $this->db->select("(select partner_name from hr_partner_type where id = IP.partner_id) as branch_name", false);
        $this->db->select("award_share.doc1 as pitch_doc1, award_share.doc2 as pitch_doc2");
        $this->db->select("iet.city as inv_city,INV_INFO.business_plan as inc_doc1, INV_INFO.add_info as inc_doc2, INV_INFO.inc_cert as inc_doc3");
        $this->db->select("IFNULL(IFNULL(pitch.submitted_date, INV.submitted_date),eir.date_submitted) AS dsubmitted, pitch_step2.operation_stage as Stage_of_operation");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_ent_info iet', 'iet.inv_user_id = INV.id', 'left');
        $this->db->join('inv_additional_info INV_INFO', 'INV_INFO.inv_user_id = INV.id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('sector_category SubCat', 'SubCat.id =  pitch_step2.sub_sector', 'left');
        $this->db->join('award_share', 'award_share.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
        $this->db->join('pitch_step1_info PS1', 'PS1.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_city EC', 'EC.id = PS1.city_id', 'left');
        $this->db->join('shortlist_comments ISC', 'ISC.inv_id = IP.id', 'left');
        $this->db->group_by('IP.id');
        $this->db->order_by('dsubmitted', 'desc');
        $this->db->distinct();

        $searchArray[] = "IP.copy_status != '4'";

        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . implode("','", $options['associate']) . "')";
        }

        $copypartner = $options['copy_id'];
        $copyid = explode("_", $copypartner);
        if ($copypartner != "") {
            $searchArray[] = "(IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch_name'] . "') and IP.partner_count ='" . $copyid[2] . "'";
        } else {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        }

        if ($copypartner != "") {
            $searchArray[] = "IP.copy_id ='" . $copyid[0] . "'";
        }

        $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
        if (!empty($options['name_of_entrepreneur'])) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
        }

        if (isset($options['source_type']) && $options['source_type'] == '0') {
            $searchArray[] = "IP.source IN (0,101,103,123,124,126,127,128,129,130) and (IP.created_by = 0 or IP.created_by IS NULL)";
        } else if (isset($options['source_type']) && $options['source_type'] == '1') {
            $searchArray[] = "IP.source NOT IN (0,101,103,123,124,126,127,128,129,130) and IP.created_by > 0 and IP.created_by IS NOT NULL";
        } else if (isset($options['source_type']) && $options['source_type'] == '2') {
            $searchArray[] = "IP.source IN (124,126)";
        }

        if (!empty($options['sector'])) {
            $searchArray[] = "SC.id = '" . $options['sector'] . "'";
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_sector = $this->session->userdata['sectorAccess'];
				if($customt_sector!=''){
					$searchArray[] = "SC.id IN(" . $customt_sector . ")";
				}
            }
        }

        if (isset($options['program']) && $options['program'] != "") {
            if ($options['program'] == 0) {
                if ($this->session->userdata['role_id'] == '4') {
                    $searchArray[] = "IP.program = 0";
                } else {
                    $searchArray[] = "(IP.program = 0 or IP.program = 4)";
                }
            } else {
                $searchArray[] = "IP.program = '" . $options['program'] . "'";
            }
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_program = $this->session->userdata['programAccess'];
                $searchArray[] = "IP.program IN(" . $customt_program . ")";
            }
        }

        if (isset($options['stage']) && $options['stage'] != "") {
            $searchArray[] = "IP.stage='" . $options['stage'] . "'";
        }

        if (isset($options['status']) && $options['status'] != "") {
            $split_status = explode(',', $options['status']);
            $merge_status = "'" . implode("','", $split_status) . "'";
            if ($this->session->userdata['role_id'] == '4' && $this->session->userdata('independent_shortlist') == 1) {
                $searchArray[] = "(ISC.current_app_status IN(" . $merge_status . ") AND ISC.created_by = " . $this->session->userdata('emp_number') . ")";
            } else {
                $searchArray[] = "IP.status IN(" . $merge_status . ")";
            }
        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
        }

        if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
            $cond_subFrom = $enter_fromDate = date('Y-m-d', strtotime($options['submitted_date']));
            $cond_subTo = $enter_toDate = date('Y-m-d', strtotime($options['submitted_date_to']));
            if ($this->session->userdata('role_id') == '4') {
                $define_fromDate = $this->session->userdata('dealsFrom');
                $define_toDate = $this->session->userdata('dealsTo');
                if ($define_fromDate >= $enter_fromDate) {
                    $cond_subFrom = $define_fromDate;
                } else {
                    $cond_subFrom = $enter_fromDate;
                }
                if ($define_toDate <= $enter_toDate) {
                    $cond_subTo = $define_toDate;
                } else {
                    $cond_subTo = $enter_toDate;
                }
            }
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $cond_subFrom . "' AND INV.submitted_date <='" . $cond_subTo . "') or (pitch.submitted_date >='" . $cond_subFrom . "' and  pitch.submitted_date <='" . $cond_subTo . "'))";
        }



        if (!empty($options['geography'])) {
            $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
        }

        if (!empty($options['city'])) {
            $searchArray[] = "(IP.city like '%" . $options['city'] . "%' OR EC.city_name like '%" . $options['city'] . "%')";
        }

        if (isset($options['lis']) && $options['lis'] != '') {
            $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
        }

        if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
            $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
        }

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
            $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
            $searchArray[] = "AA.status = 1";
        }

        if (!empty($options['email'])) {
            $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
        }

        if (!empty($options['mobile'])) {
            $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
        }

        if ($options['deals_tab'] == 'mydeals') {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 5;
            else
                $check_count = 3;
        } else {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 4;
            else
                $check_count = 2;
        }

        if ($this->session->userdata('role_id') == '4' && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {

                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date && $default_toDate!='0000-00-00') {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
				 if($this->session->userdata('emp_number') =='516'){
					# echo $default_toDate;die;
						#echo'<pre>';print_r($this->session->all_userdata());die;
					
				}
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ((count($searchArray) == $check_count && $this->session->userdata('role_id') != '4') && empty($options['created_date']) && empty($options['created_date']) && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
				
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ($options['status'] == "") {
            $searchArray[] = "IP.status NOT IN('4','10','11')";
        }

        if (!empty($options['opertaion_stage'])) {
            $searchArray[] = "(iet.stage_product LIKE '%" . $options['opertaion_stage'] . "%' OR pitch_step2.operation_stage LIKE '%" . $options['opertaion_stage'] . "%')";
        }

        if (!empty($options['enterprise_stage'])) {
            $searchArray[] = "(INV.ent_type LIKE '%" . $options['enterprise_stage'] . "%' OR PS1.ent_type LIKE '%" . $options['enterprise_stage'] . "%')";
        }

        if($num != '-1')
            $this->db->limit($num, $offset);

        if (count($searchArray) > 0) {
            $whereQuery = implode(' and ', $searchArray);
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

       if($this->session->userdata('emp_number') =='516'){
				//submitted_date
			//debug_last_query();die;
		}

        $rows = $query->result_array();
        return $rows;
    }

    public function getSearchDeals($options) {
        $this->db->select("IP.id,IP.copy_id,IP.partner_id,IP.partner_count,IP.copy_partner_id,IP.name_of_enterprise,IP.name_of_entrepreneur");
        $this->db->select("IP.created_by,IP.created_date,IP.source,IP.sourceType,IP.sector,IP.program,IP.stage,IP.status,IP.state,IP.city,EC.city_name,IP.email_id,IP.mobile_no");
        $this->db->select("IP.copied_date,IP.copy_partner_from,SM.source_name,pitch.pitch_id,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("INV.submitted_date,pitch.submitted_date as pitch_submitted_date,eir.date_submitted as eir_submitted_date");
        $this->db->select("(select partner_name from hr_partner_type where id = IP.partner_id) as branch_name", false);
        $this->db->select("award_share.doc1 as pitch_doc1, award_share.doc2 as pitch_doc2");
        $this->db->select("INV_INFO.business_plan as inc_doc1, INV_INFO.add_info as inc_doc2");
        $this->db->select("IFNULL(IFNULL(pitch.submitted_date, INV.submitted_date),eir.date_submitted) AS dsubmitted");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_ent_info iet', 'iet.inv_user_id = INV.id', 'left');
        $this->db->join('inv_additional_info INV_INFO', 'INV_INFO.inv_user_id = INV.id', 'left');
        $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('award_share', 'award_share.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
        $this->db->join('pitch_step1_info PS1', 'PS1.pitch_id = pitch.pitch_id', 'left');
        $this->db->join('eir_city as EC', 'EC.id = PS1.city_id', 'left');
        $this->db->join('shortlist_comments ISC', 'ISC.inv_id = IP.id', 'left');
        $this->db->group_by('IP.id');
        $this->db->order_by('dsubmitted', 'desc');
        $this->db->distinct();

        $searchArray[] = "IP.copy_status != '4'";

        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . implode("','", $options['associate']) . "')";
        }

        $copypartner = $options['copy_id'];
        $copyid = explode("_", $copypartner);
        if ($copypartner != "") {
            $searchArray[] = "IP.copy_id ='" . $copyid[0] . "' and (IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch_name'] . "') and IP.partner_count ='" . $copyid[2] . "'";
        } else {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        }

        $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
        if (!empty($options['name_of_entrepreneur'])) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
        }

        if (isset($options['source_type']) && $options['source_type'] == '0') {
            $searchArray[] = "IP.source IN (0,101,103,123,124,126,127,128,129,130) and (IP.created_by = 0 or IP.created_by IS NULL)";
        } else if (isset($options['source_type']) && $options['source_type'] == '1') {
            $searchArray[] = "IP.source NOT IN (0,101,103,123,124,126,127,128,129,130) and IP.created_by > 0 and IP.created_by IS NOT NULL";
        } else if (isset($options['source_type']) && $options['source_type'] == '2') {
            $searchArray[] = "IP.source IN (124,126)";
        }

        if (!empty($options['sector'])) {
            $searchArray[] = "SC.id = '" . $options['sector'] . "'";
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_sector = $this->session->userdata['sectorAccess'];
                $searchArray[] = "SC.id IN(" . $customt_sector . ")";
            }
        }

        if (isset($options['program']) && $options['program'] != "") {
            if ($options['program'] == 0) {
                if ($this->session->userdata['role_id'] == '4') {
                    $searchArray[] = "IP.program = 0";
                } else {
                    $searchArray[] = "(IP.program = 0 or IP.program = 4)";
                }
            } else {
                $searchArray[] = "IP.program = '" . $options['program'] . "'";
            }
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_program = $this->session->userdata['programAccess'];
                $searchArray[] = "IP.program IN(" . $customt_program . ")";
            }
        }

        if (isset($options['stage']) && $options['stage'] != "") {
            $searchArray[] = "IP.stage='" . $options['stage'] . "'";
        }

        if (!isset($options['independent_shortlister']) && $options['independent_shortlister'] != 1) {
            if (isset($options['status']) && $options['status'] != "null") {
                $split_status = explode(',', $options['status']);
                $merge_status = "'" . implode("','", $split_status) . "'";
                if (isset($options['independent_shortlister']) && $options['independent_shortlister'] == 1) {
                    $searchArray[] = "(ISC.current_app_status IN(" . $merge_status . ") AND ISC.created_by = " . $options['assigned_incharge'] . ") AND IP.status IN(" . $merge_status . ")";
                } else {
                    $searchArray[] = "IP.status IN(" . $merge_status . ")";
                }
            } else {
                $searchArray[] = "IP.status NOT IN('4','10','11')";
            }
        } else {
            $split_status = explode(',', $options['status']);
            if (!in_array(12, $split_status)) {
                $merge_status = "'" . implode("','", $split_status) . "'";
                $searchArray[] = "(ISC.current_app_status IN(" . $merge_status . ") AND ISC.created_by = " . $options['assigned_incharge'] . ")";
            } else {
                if (isset($options['shortinv']) && $options['shortinv'] != '') {
                    $searchArray[] = "IP.id NOT IN (" . $options['shortinv'] . ")";
                }
            }
            $searchArray[] = "IP.status NOT IN('4','10','11')";
        }

//        if (isset($options['status']) && $options['status'] != 'null') {
//            $split_status = explode(',', $options['status']);
//            $merge_status = "'" . implode("','", $split_status) . "'";
//            $searchArray[] = "IP.status IN(" . $merge_status . ")";
//        } else {
//            $searchArray[] = "IP.status NOT IN('4','10','11')";
//        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
        }

        if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
            $cond_subFrom = $enter_fromDate = date('Y-m-d', strtotime($options['submitted_date']));
            $cond_subTo = $enter_toDate = date('Y-m-d', strtotime($options['submitted_date_to']));
            if ($this->session->userdata('role_id') == '4') {
                $define_fromDate = $this->session->userdata('dealsFrom');
                $define_toDate = $this->session->userdata('dealsTo');
                if ($define_fromDate >= $enter_fromDate) {
                    $cond_subFrom = $define_fromDate;
                } else {
                    $cond_subFrom = $enter_fromDate;
                }
                if ($define_toDate <= $enter_toDate) {
                    $cond_subTo = $define_toDate;
                } else {
                    $cond_subTo = $enter_toDate;
                }
            }
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $cond_subFrom . "' AND INV.submitted_date <='" . $cond_subTo . "') or (pitch.submitted_date >='" . $cond_subFrom . "' and  pitch.submitted_date <='" . $cond_subTo . "'))";
        }

        if (!empty($options['geography'])) {
            $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
        }

        if (!empty($options['city'])) {
            $searchArray[] = "(IP.city like '%" . $options['city'] . "%' OR EC.city_name like '%" . $options['city'] . "%')";
        }

        if (isset($options['lis']) && $options['lis'] != '') {
            $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
        }

        if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
            $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
        }

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
            if (isset($options['independent_shortlister']) && $options['independent_shortlister'] == 0) {
                $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
                $searchArray[] = "AA.status = 1";
            }
        }

        if (!empty($options['email'])) {
            $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
        }

        if (!empty($options['mobile'])) {
            $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
        }

        if ($options['deals_tab'] == 'mydeals') {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 6;
            else
                $check_count = 4;
        } else {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 5;
            else
                $check_count = 3;
        }

        if ((count($searchArray) == $check_count || $this->session->userdata('role_id') == '4') && empty($options['created_date']) && empty($options['created_date']) && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if (!empty($options['opertaion_stage'])) {
            $searchArray[] = "(iet.stage_product LIKE '%" . $options['opertaion_stage'] . "%' OR pitch_step2.operation_stage LIKE '%" . $options['opertaion_stage'] . "%')";
        }

        if (!empty($options['enterprise_stage'])) {
            $searchArray[] = "(INV.ent_type LIKE '%" . $options['enterprise_stage'] . "%' OR PS1.ent_type LIKE '%" . $options['enterprise_stage'] . "%')";
        }

        if (count($searchArray) > 0) {
            $whereQuery = implode(' and ', $searchArray);
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        $rows = $query->result_array();
        return $rows;
    }

    public function getCustomSectorCompany($sector_access, $fy) {
		
		$sel_fy = $fy.'-12-31';
        $partner_id = $this->session->userdata('partner_id');
        $program_access = $this->session->userdata['programAccess'];
        $deals_from = $this->session->userdata['dealsFrom'];
        $deals_to = $this->session->userdata['dealsTo'];

        if ($sector_access != '') {
            $sector_val = "PB.sector IN ($sector_access)";
            $this->db->where($sector_val);
            $this->db->join('port_business PB', 'PB.inv_id = IP.id', 'left');
        }

        if ($program_access != '') {
            $program_val = "IP.program IN ($program_access)";
            $this->db->where($program_val);
        }

        if ($deals_from != '' && $deals_to != '') {
            $submited_val = "((INV.submitted_date >='" . $deals_from . "' AND INV.submitted_date <='" . $deals_to . "') or (pitch.submitted_date >='" . $deals_from . "' and  pitch.submitted_date <='" . $deals_to . "'))";
            $this->db->where($submited_val);
            $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
            $this->db->join('pitch_user pitch', 'pitch.inno_id = IP.innovation_id', 'left');
        }

        $this->db->where(array('CD.partner_id' => (int) $partner_id, 'IP.stage' => '12', 'IP.status !=' => '3', 'IP.status !=' => '11'));
        if ($fy != '') {
			$this->db->where("`IR`.initial_signed_on <= '$sel_fy'");
            $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");
            $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        }

        $this->db->select('IP.id, CD.name, CD.name as name_of_enterprise,(`CD`.`name`+0 > 0) boolNum,CD.company_status,CD.created_by as emp_id, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month');
        $this->db->join('port_company_data CD', 'CD.inv_id =  IP.id', 'left');
        $this->db->order_by("CD.name ASC,boolNum DESC, CD.company_status ", 'ASC');
        $this->db->group_by('CD.inv_id');
        $query = $this->db->get('innovation_pool IP');

        $rows = $query->result_array();
        return $rows;
    }

    public function deletePortfolioDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', 3);
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteHiringDetail($table, $condition) {
        $this->db->set('status', 3);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteExitInvDetail($table, $condition) {
        $this->db->set('status', 2);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteHiringAchievement($table, $condition, $option) {
        $this->db->set('status', 3);
        $delete_ids = "id IN($option)";
        $this->db->where($delete_ids);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function permanentDelete($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', 3);
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->delete($table);
        return $result;
    }

    public function deletePlanDetail($table, $condition, $fields) {
        $option = "$fields IN($condition)";
        $this->db->set('status', 3);
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteTempPortfolioDetail($table, $field, $condition) {
        $option = "$field IN($condition)";
        $this->db->set('status', 3);
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteMentorDetail($table, $condition, $column) {
        $option = "$column IN($condition)";
        $this->db->set('status', 3);
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteMentorDoc($table, $condition, $field_name) {
        $this->db->set($field_name, '');
        $this->db->where($condition);
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteUploads($table, $inv_id) {
        if ($table == 'port_company_data') {
            $cond['inv_id'] = $inv_id;
            $this->db->set('document', '');
        } else if ($table == 'plan_board_meetings' || $table == 'plan_dp') {
            $cond['inv_id'] = $inv_id;
            $cond['financial_year'] = $this->input->post('year');
            $cond['month'] = $this->input->post('month');
            $this->db->set('document', '');
        } else if ($table == 'port_incubation_relation') {
            $data['purpose'] = $this->input->post('purpose');
            $data['sign'] = $this->input->post('date');
            $data['link'] = '';
            $update_data = json_encode($data);
            $cond['inv_id'] = $inv_id;
            $update_column = $this->input->post('update_column');
            $this->db->set($update_column, $update_data);
        } else if ($table == 'plan_meeting_notes') {
            $cond['inv_id'] = $inv_id;
            $cond['id'] = $this->input->post('note_id');
            $this->db->set('document', '');
        } else {
            $data['type'] = $this->input->post('ctype');
            $data['purpose'] = $this->input->post('purpose');
            $data['sign'] = $this->input->post('date');
            $data['link'] = '';
            $update_data = json_encode($data);
            $relid = $this->input->post('relid');
            if (isset($relid) && $relid != '') {
                // $cond['id'] = $inv_id;
                $cond['id'] = $relid;
            }

            // $update_column = $this->input->post('update_column');
            $this->db->set('data', $update_data);
        }
        $this->db->where($cond);
        $result = $this->db->update($table);
        return $result;
    }

    public function getAllFinancialYear($partner_id) {
        $this->ais->select("fin.*, SUBSTRING_INDEX(SUBSTRING_INDEX(fin.from, ' ', 2), ' ', -1) AS fin_year", FALSE);
        $this->ais->where('fin.partner_id', $partner_id);
        $this->ais->order_by("fin_year", "desc");
        $query = $this->ais->get('financial_year fin');

        $rows = $query->result_array();
        return $rows;
    }

    public function getFinancialYearMonth($partner_id) {
        $this->ais->select("SUBSTRING_INDEX(SUBSTRING_INDEX(fin.from, ' ', 1), ' ', -1) AS fin_from_month,SUBSTRING_INDEX(SUBSTRING_INDEX(fin.to, ' ', 1), ' ', -1) AS fin_to_month,SUBSTRING_INDEX(SUBSTRING_INDEX(fin.from, ' ', 2), ' ', -1) AS fin_from_year,SUBSTRING_INDEX(SUBSTRING_INDEX(fin.to, ' ', 2), ' ', -1) AS fin_to_year", FALSE);
        $this->ais->where(array('fin.partner_id' => $partner_id, 'fin.status' => '1'));
        $this->ais->order_by("fin.id", "desc");
        $query = $this->ais->get('financial_year fin');
        $rows = $query->result_array();
		$rowsResult = $query->result_array();
		//if($this->session->userdata('emp_number') =='275'){
		  if($rowsResult[0]['fin_from_month']=='April' && $rowsResult[0]['fin_to_month']=='March' && $rowsResult[0]['fin_to_year']== date('Y') && date('m') <=3){
			   $rows[0]['fin_to_year'] = $rows[0]['fin_to_year']+1;
		  }
		//}
        return $rows;
    }

    public function getFYtoYear($partner_id, $from_year, $p = '') {
        $this->ais->select("SUBSTRING_INDEX(SUBSTRING_INDEX(fin.from, ' ', 2), ' ', -1) AS fin_from_year, SUBSTRING_INDEX(SUBSTRING_INDEX(fin.to, ' ', 2), ' ', -1) AS fin_to_year", FALSE);
        $this->ais->where(array('fin.partner_id' => $partner_id));
        $this->ais->where("fin.from LIKE '%$from_year%'");
        $this->ais->order_by("fin.id", "desc");
        $query = $this->ais->get('financial_year fin');
        if ($p != '') {
//            echo $this->ais->last_query();
//            exit;
        }

        $rows = $query->result_array();
        return $rows;
    }

    public function getDonorList($partner_id) {
        $option = array('partner_id' => $partner_id, 'master_type' => 'Donor', 'status' => '1');
        $this->ais->select("master_id, master_name");
        $this->ais->where($option);
        $this->ais->order_by("master_name", "asc");
        $query = $this->ais->get('master_settings');
        $rows = $query->result_array();
        return $rows;
    }

    public function deleteConfigDetails($table, $condition, $fields) {
        $this->db->set($fields);
        if ($condition != '') {
            $this->db->where('id', $condition);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteTempConfigDetails($table, $condition, $fields) {
        $this->db->set($fields);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteImpactdetails($table, $data, $condition, $field_column = '') {
        $this->db->set($data);
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($field_column != '') {
            $this->db->where($field_column);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function getPlanDetails($table, $condition = '', $month = '', $f_year = '', $status = '', $limit = '', $field = '', $sort = 'asc') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($month != '') {
            $this->db->where('MONTH(created_at)', $month);
        }
        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }

        if ($limit != '') {
            $this->db->limit($limit);
        }
        if ($field != '') {
            $this->db->order_by($field, $sort);
        } else {
            $this->db->order_by('id', 'desc');
        }

        $query = $this->db->get($table);
        // if($this->session->userdata['emp_number'] == '275') {
        //     debug_last_query();die;
        // }
        $rows = $query->result_array();
        return $rows;
    }

    public function getFinanceDetails($table, $condition = '', $month = '', $f_year = '', $status = '', $type = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        $start_year = date('Y-m-d', strtotime("$f_year-04-01"));

        if ($month < '4') {
            $fin_year = $f_year + 1;
        } else {
            $fin_year = $f_year;
        }
        $ytd_month = $month - 1;
        $end_year = date("Y-m-t", strtotime("$fin_year-$ytd_month"));
        $nowend_year = date("Y-m-t", strtotime("$fin_year-$month"));

        if ($type == 'last') {
            if ($month == '4') {
                $this->db->where('MONTH(fy_date)', $month);
            } else {
                $this->db->where("fy_date >= '$start_year' AND fy_date < '$end_year'");
            }
        } else if ($type == 'now') {
            if ($month == '4') {
                $this->db->where('MONTH(fy_date)', $month);
            } else {
                $this->db->where("fy_date >= '$start_year' AND fy_date <= '$nowend_year'");
            }
        } else {
            $this->db->where('MONTH(fy_date)', $month);
        }

        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }

        if ($status != '' && $status == '3') {
            $this->db->where('status !=', $status);
        } else if ($status != '' && $status == '1') {
            $this->db->where('status', $status);
        }
        if ($group != '') {
            $this->db->group_by('month');
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getMeetingCount($table, $condition = '', $f_year = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($f_year != '') {
            $nxtfin_year = $f_year + 1;
            $this->db->where("fy_date >= '$f_year-04-01 00:00:00' AND fy_date <= '$nxtfin_year-03-31 23:59:59'");
        }
        $this->db->select('count(id) as meet_count');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getFundraiseDetails($table, $condition = '', $f_year = '', $status = '', $type = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($type != '') {
            $this->db->where('fund_type', $type);
        }
        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }
        if ($status != '') {
            $this->db->where('status !=', $status);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getHiringJobs($table, $condition = '', $f_year = '', $status = '', $field = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($f_year != '') {
            $this->db->where('financial_year', $f_year);
        }
        if ($status != '') {
            $this->db->where('status !=', $status);
        }
        if ($field != '') {
            $this->db->where('field_type', $field);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function updatePendingFundraise($table, $data, $condition, $type = '') {
        $this->db->set($data);
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($type != '') {
            $this->db->where('fund_type', $type);
        }
        $this->db->where('status !=', 3);
        $result = $this->db->update($table);
        return $result;
    }

    public function getUpdatesCount($table, $id = '', $value = '', $year = '') {
        if ($value != '') {
            $condition = "month IN($value)";
            $this->db->where($condition);
        }
        if ($id != '') {
            $this->db->where('inv_id', $id);
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
            $this->db->where('inv_id', $id);
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

    public function getPlanChart($where = '') {

        if ($where != null) {
            $whereArray[] = $where;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $query_cond = " and " . $whereCond;
        }

        $query = "SELECT count(pb.id) as count_id, pu.quarter as pu_quarter, pp.quarter as pp_quarter FROM port_business as pb
        LEFT JOIN plan_updates as pu ON pu.inv_id = pb.inv_id AND pu.status != 3
        LEFT JOIN plan_pipeline as pp ON pp.inv_id = pb.inv_id AND pp.status != 3
        WHERE pb.status !=3 AND pb.sector=3 $query_cond
        GROUP BY pu.quarter,pp.quarter";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPlanSetupID($inv_id) {

        $data = array();
        $query = "select COUNT(a.inv_id) as innovation from (select inv_id from port_dp_board_meetings t where EXISTS( SELECT 1
        FROM port_dp_board_meetings s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_channel_data t where EXISTS( SELECT 1
        FROM port_channel_data s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_finance_fundraise t where EXISTS( SELECT 1
        FROM port_finance_fundraise s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_ttm_mentor_master t where EXISTS( SELECT 1
        FROM port_ttm_mentor_master s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_pipeline_data t where EXISTS( SELECT 1
        FROM port_pipeline_data s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all select inv_id from port_sales_data t where EXISTS( SELECT 1
        FROM port_sales_data s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_impact t where EXISTS( SELECT 1
        FROM port_impact s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_ttm_partnership t where EXISTS( SELECT 1
        FROM port_ttm_partnership s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all select inv_id from port_ttm_tap t where EXISTS( SELECT 1
        FROM port_ttm_tap s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_project_milestone t where EXISTS( SELECT 1
        FROM port_project_milestone s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3) union all "
        . "select inv_id from port_vif_funding t where EXISTS( SELECT 1
        FROM port_vif_funding s WHERE s.id = t.id and s.inv_id = '$inv_id' and s.status != 3)) a ";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getDashboardMaster($partner_id = '', $year = '', $sector_id = '') {
        if ($partner_id != '') {
            $this->db->where('partner_id', $partner_id);
        }
        if ($year != '') {
            $this->db->where('financial_year', $year);
        }
        if ($sector_id != '') {
            $this->db->where('sector', $sector_id);
        }
        $this->db->where(array('status' => '1'));
        $query = $this->db->get('port_dashboard_master');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTotalCompanyMonth($cond = '', $month = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "CD.created_at > '$start_date' and CD.created_at < '$end_date'";
            $this->db->where($cond);
        }
        if ($month != '') {
            $this->db->where($month);
        }
        if ($status != '') {
            $this->db->where('CD.company_status', $status);
        }
        $this->db->where(array('CD.status !=' => '3', 'BN.sector' => '3'));
        $this->db->select('Month(CD.created_at) as month, count(Month(CD.created_at)) as count');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->group_by("Month(CD.created_at)");

        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTotalCompany($cond = '', $f_year = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();

        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }

        if ($f_year != '') {
            $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $f_year);
            $nxt_year = $get_end_year[0]['fin_to_year'];
            // $fy_cond = "CD.created_at BETWEEN '$f_year-04-01' AND '$nxt_year-03-31'";
            // $this->db->where($fy_cond);
        }

        $sign_date = $f_year . '-' . date('m');
        // $exit_fyear = $nxtye . '-' . $month . '-01 00:00:00';
        // $nda_cond = "CD.created_at BETWEEN '$current_date' AND '$next_fyear'";
        $nda_cond = "DATE_FORMAT(IR.initial_signed_on, '%Y-%m') <= '$sign_date' AND (DATE_FORMAT(IR.exit_date, '%Y-%m') > '$sign_date' OR (YEAR(IR.exit_date) = 0000) OR (IR.exit_date = '0000-00-00'))";
        $this->db->where($nda_cond);

        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.stage' => '12', 'CD.company_status' => '1', 'CD.status !=' => '3'));
        $this->db->select("count(CASE WHEN MONTH(CD.created_at) BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as q1,
            count(CASE WHEN MONTH(CD.created_at) BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as q2,
            count(CASE WHEN MONTH(CD.created_at) BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as q3,
            count(CASE WHEN MONTH(CD.created_at) BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as q4,
            count(CASE WHEN MONTH(CD.created_at) BETWEEN 1 AND 12 THEN 1 END) as annual");
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');

        $query = $this->db->get('port_company_data CD');
        $rows = $query->result_array();
        return $rows;
    }

    public function getExitCompany($cond = '', $fy = '') {
        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }
        // $c_status_cond = "(CD.company_status = 2 or CD.company_status = 3)";
        // $this->db->where($c_status_cond);
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('CD.partner_id' => (int) $partner_id, 'IP.stage' => '12', 'IP.status !=' => '3'));
        if ($fy != '') {
            $this->db->where("IF(CD.company_status = 3, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), IF(CD.company_status = 2, IF(DATE_FORMAT(`IR`.`exit_date`, '%Y-%m-%d') != '0000-00-00 00:00:00', 1, 0), CD.company_status = 1))");
            $this->db->join('port_incubation_relation IR', 'IR.inv_id =  IP.id', 'left');
        }
//        $this->db->select('IP.id, IP.name_of_enterprise,(`IP`.`name_of_enterprise`+0 > 0) boolNum,CD.company_status,CD.created_by as emp_id');
        $this->db->select('IP.id, CD.name, CD.name as name_of_enterprise,(`CD`.`name`+0 > 0) boolNum,CD.company_status,CD.created_by as emp_id, YEAR(IR.exit_date) as exit_year, MONTH(IR.exit_date) as exit_month');
        $this->db->join('port_company_data CD', 'CD.inv_id =  IP.id', 'left');
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->order_by("boolNum DESC, CD.company_status ASC, IP.name_of_enterprise", 'ASC');
        $this->db->group_by('CD.inv_id');
        $query = $this->db->get('innovation_pool IP');
        $rows = $query->result_array();
        return $rows;
    }

    public function getNewCompany($cond = '', $f_year = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();

        if ($cond != null && $cond != '') {
            $whereArray[] = $cond;

            $whereCond = implode(' and ', $whereArray);
            if ($whereCond != '') {
                $this->db->where($whereCond);
            }
        }
        $partner_id = $this->session->userdata('partner_id');

        if ($f_year != '') {
            $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $f_year);
            $nxt_year = $get_end_year[0]['fin_to_year'];
            $fy_cond = "CD.created_at BETWEEN '$f_year-04-01' AND '$nxt_year-03-31'";
            $this->db->where($fy_cond);

            $current_date = $f_year . '-04-01 00:00:00';
            $nda_cond = "IR.initial_signed_on >= '$current_date'";
            $this->db->where($nda_cond);
        }


        $this->db->where(array("IP.partner_id" => (int) $partner_id, 'IP.stage' => '12', 'CD.company_status' => '1', 'CD.status !=' => '3'));
        $this->db->select("count(CASE WHEN MONTH(IR.initial_signed_on) BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as q1,
            count(CASE WHEN MONTH(IR.initial_signed_on) BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as q2,
            count(CASE WHEN MONTH(IR.initial_signed_on) BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as q3,
            count(CASE WHEN MONTH(IR.initial_signed_on) BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as q4,
            count(CASE WHEN MONTH(IR.initial_signed_on) BETWEEN 1 AND 12 THEN 1 END) as annual");
        $this->db->join('port_business BN', 'BN.inv_id =  CD.inv_id', 'left');
        $this->db->join('port_incubation_relation IR', 'IR.inv_id =  CD.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id = CD.inv_id', 'left');

        $query = $this->db->get('port_company_data CD');
        // debug_last_query();
        // die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getSectorInucbs($sector = '') {
        if ($sector != '') {
            $this->db->where('t1.sector', $sector);
        }
        $this->db->select('t1.inv_id, t1.sector, t3.name');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('port_business t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetSales($cond = '', $sales_id = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        if ($sales_id != '') {
            $this->db->where('t1.id', $sales_id);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.volume, t1.value, t1.id, t1.product_name');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('port_sales_data t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualSales($cond = '', $sales_id = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        if ($sales_id != '') {
            $this->db->where('t1.product_id', $sales_id);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.financial_year, t1.month, t1.volume, t1.value, t1.product_id');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->order_by('t1.month', 'asc');
        $result = $this->db->get('plan_sales t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetRevenue($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.finance_id' => '1', 't1.status' => '1'));
        $this->db->select('t1.inv_id,t3.name,t1.financial_year, t1.data');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('port_finance_fundraise t1');

        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualRevenue($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.inv_id,t3.name,t1.financial_year, t1.month, t1.revenue');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->order_by('t1.month', 't1.asc');
        $result = $this->db->get('plan_finance t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetProfit($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.finance_id' => '2', 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.data');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('port_finance_fundraise t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualProfit($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.financial_year, t1.month, t1.net_profit');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->order_by('t1.month', 't1.asc');
        $result = $this->db->get('plan_finance t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetEndbeneficiaries($cond = '', $field_type) {
        if ($cond != '') {
            $this->db->where($cond);
        }
        if ($field_type != '') {
            $this->db->where($field_type);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.*, t4.name as iris_name');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->join('port_impact_master t4', 't4.id =  t1.iris_code', 'left');
        $result = $this->db->get('port_impact_metric t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualEndbeneficiaries($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.*');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->order_by('t1.month', 't1.asc');
        $result = $this->db->get('plan_impact t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualMetric($cond = '', $planid = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($planid != '') {
            $this->db->where(array('t1.plan_id' => $planid));
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.*');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->order_by('t1.month', 't1.asc');
        $result = $this->db->get('plan_impact_metric t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetCapital($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.finance_id' => '3', 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.data');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('port_finance_fundraise t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualCapital($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.financial_year, t1.month, t1.fund_type, t1.equity_total, t1.grand_total, t1.short_total, t1.long_total, SUM(t1.value) as total_value');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.inv_id, t1.financial_year, t1.month");
        $result = $this->db->get('plan_fundraise t1');

        if ($this->session->userdata['emp_number'] == '275') {
            // debug_last_query();
            // die;
        }
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetSeedFund($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.amount, MONTH(t1.month) as month, YEAR(t1.month) as year');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('port_vif_funding t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualSeedFund($cond = '') {
        if ($cond != '') {
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.financial_year, MONTH(t1.disburse_date) as month, YEAR(t1.disburse_date) as year, t1.disburse_amount');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $result = $this->db->get('plan_vif_funding t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetMentorNumber($cond = '', $startDate = '', $year = '', $status = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t4.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select("count(CASE WHEN MONTH(t3.start_date) BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as start_q1,
            count(CASE WHEN MONTH(t3.start_date) BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as start_q2,
            count(CASE WHEN MONTH(t3.start_date) BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as start_q3,
            count(CASE WHEN MONTH(t3.start_date) BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as start_q4,
            count(CASE WHEN MONTH(t3.start_date) BETWEEN 1 AND 12 THEN 1 END) as start_annual,
            count(CASE WHEN MONTH(t3.end_date) BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as end_q1,
            count(CASE WHEN MONTH(t3.end_date) BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as end_q2,
            count(CASE WHEN MONTH(t3.end_date) BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as end_q3,
            count(CASE WHEN MONTH(t3.end_date) BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as end_q4,
            count(CASE WHEN MONTH(t3.end_date) BETWEEN 1 AND 12 THEN 1 END) as end_annual");
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_villgro_relation_mentor t3', 't3.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t4', 't4.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('port_ttm_mentor_master t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMentorNumber($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }
        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-03-31";
            $end_date = $end_year . "-04-01";
            $cond = "t3.start_date > '$start_date' and t3.end_date < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t4.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.inv_id, t3.name as mentor_id, t3.start_date, t3.end_date');
        $this->db->join('port_ttm_mentor_master t1', 't1.inv_id =  t3.inv_id', 'left');
        $this->db->join('port_business t2', 't2.inv_id =  t3.inv_id', 'left');
        $this->db->join('port_company_data t4', 't4.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('port_villgro_relation_mentor t3');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualMentorNumber($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t4.partner_id' => (int) $partner_id, 't1.hours_spent !=' => '', 't1.hours_spent !=' => 0, 't1.status !=' => '3'));
        $this->db->select('t1.id,t1.inv_id,t1.financial_year, t1.month, t1.fy_date, t1.assigned_to, t1.created_at');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        // $this->db->join('port_config_mentor t3', 't3.id =  t1.config_id', 'left');
        $this->db->join('port_company_data t4', 't4.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('plan_mentor t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualMentorNumberMonthly($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
//            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $cond = "t1.financial_year = '$year'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.hours_spent !=' => '', 't1.status !=' => '3'));
        $this->db->select("t1.assigned_to, t1.month, count(CASE WHEN t1.month = 4 THEN 1 END) as apr,
            count(CASE WHEN t1.month = 5 THEN 1 END) as may,
            count(CASE WHEN t1.month = 6 THEN 1 END) as jun,
            count(CASE WHEN t1.month = 7 THEN 1 END) as jul,
            count(CASE WHEN t1.month = 8 THEN 1 END) as aug,
            count(CASE WHEN t1.month = 9 THEN 1 END) as sep,
            count(CASE WHEN t1.month = 10 THEN 1 END) as oct,
            count(CASE WHEN t1.month = 11 THEN 1 END) as nov,
            count(CASE WHEN t1.month = 12 THEN 1 END) as 'dec',
            count(CASE WHEN t1.month = 1 THEN 1 END) as jan,
            count(CASE WHEN t1.month = 2 THEN 1 END) as feb,
            count(CASE WHEN t1.month = 3 THEN 1 END) as mar");
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.id");
        $query = $this->db->get('plan_mentor t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTargetMentorHours($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
//            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $cond = "t1.financial_year = '$year'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.financial_year, SUM(t1.quarter_one + 0) as q1, SUM(t1.quarter_two + 0) as q2, SUM(t1.quarter_three + 0) as q3, SUM(t1.quarter_four + 0) as q4, SUM(t1.mentor_qone + 0) as mentorq1, SUM(t1.mentor_qtwo + 0) as mentorq2, SUM(t1.mentor_qthree + 0) as mentorq3, SUM(t1.mentor_qfour + 0) as mentorq4');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.financial_year");
        $query = $this->db->get('port_ttm_mentor_master t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function getNoOfMentors($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
//            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $cond = "t1.financial_year = '$year'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t2.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('SUM(t1.mentor_qone + 0) as q1, SUM(t1.mentor_qtwo + 0) as q2, SUM(t1.mentor_qthree + 0) as q3, SUM(t1.mentor_qfour + 0) as q4');
        $this->db->join('port_company_data t2', 't2.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('port_ttm_mentor_master t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualMentorHours($cond = '', $startDate = '', $year = '', $status = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t4.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select("SUM(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN t1.hours_spent END) as q1,
            SUM(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN t1.hours_spent END) as q2,
            SUM(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN t1.hours_spent END) as q3,
            SUM(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN t1.hours_spent END) as q4");
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        // $this->db->join('port_config_mentor t3', 't3.id =  t1.config_id', 'left');
        $this->db->join('port_company_data t4', 't4.inv_id = t1.inv_id', 'left');
//        $this->db->group_by("t2.id");
        $query = $this->db->get('plan_mentor t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMonthlyActualMentorHours($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t4.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.month, SUM(t1.hours_spent) as hours, t1.financial_year');
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        // $this->db->join('port_config_mentor t3', 't3.id =  t1.config_id', 'left');
        $this->db->join('port_company_data t4', 't4.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.month,t1.financial_year");
        $query = $this->db->get('plan_mentor t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualMentorHoursMonthly($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
//            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $cond = "t1.financial_year = '$year'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t4.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select("t1.assigned_to,SUM(CASE WHEN t1.month = 4 THEN t1.hours_spent END) as apr,
            SUM(CASE WHEN t1.month = 5 THEN t1.hours_spent END) as may,
            SUM(CASE WHEN t1.month = 6 THEN t1.hours_spent END) as jun,
            SUM(CASE WHEN t1.month = 7 THEN t1.hours_spent END) as jul,
            SUM(CASE WHEN t1.month = 8 THEN t1.hours_spent END) as aug,
            SUM(CASE WHEN t1.month = 9 THEN t1.hours_spent END) as sep,
            SUM(CASE WHEN t1.month = 10 THEN t1.hours_spent END) as oct,
            SUM(CASE WHEN t1.month = 11 THEN t1.hours_spent END) as nov,
            SUM(CASE WHEN t1.month = 12 THEN t1.hours_spent END) as 'dec',
            SUM(CASE WHEN t1.month = 1 THEN t1.hours_spent END) as jan,
            SUM(CASE WHEN t1.month = 2 THEN t1.hours_spent END) as feb,
            SUM(CASE WHEN t1.month = 3 THEN t1.hours_spent END) as mar");
        $this->db->join('port_business t2', 't2.inv_id =  t1.inv_id', 'left');
        // $this->db->join('port_config_mentor t3', 't3.id =  t1.config_id', 'left');
        $this->db->join('port_company_data t4', 't4.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.assigned_to");
        $query = $this->db->get('plan_mentor t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualSalesMonthly($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t2.partner_id' => (int) $partner_id, 't1.financial_year' => $year, 't1.status !=' => '3'));
        $this->db->select('*');
        $this->db->join('port_company_data t2', 't2.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('plan_sales t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTargetTap($cond = '', $year = '', $dates = '') {
        if ($cond != 'null') {
            $whereArray[] = $cond;
        }
        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        $this->db->where('t1.status', '1');

        if ($year != '') {
            $this->db->where('t1.financial_year', $year);
        }

        if ($dates != '') {
            $this->db->where($dates);
        }

        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id));
        $this->db->select("t1.id, t1.inv_id, t1.financial_year,count(CASE WHEN MONTH(t1.need_by) = 4 THEN 1 END) as apr,
            count(CASE WHEN MONTH(t1.need_by) = 5 THEN 1 END) as may,
            count(CASE WHEN MONTH(t1.need_by) = 6 THEN 1 END) as jun,
            count(CASE WHEN MONTH(t1.need_by) = 7 THEN 1 END) as jul,
            count(CASE WHEN MONTH(t1.need_by) = 8 THEN 1 END) as aug,
            count(CASE WHEN MONTH(t1.need_by) = 9 THEN 1 END) as sep,
            count(CASE WHEN MONTH(t1.need_by) = 10 THEN 1 END) as oct,
            count(CASE WHEN MONTH(t1.need_by) = 11 THEN 1 END) as nov,
            count(CASE WHEN MONTH(t1.need_by) = 12 THEN 1 END) as 'dec',
            count(CASE WHEN MONTH(t1.need_by) = 1 THEN 1 END) as jan,
            count(CASE WHEN MONTH(t1.need_by) = 2 THEN 1 END) as feb,
            count(CASE WHEN MONTH(t1.need_by) = 3 THEN 1 END) as mar");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
//        $this->db->group_by("t1.financial_year");
        $result = $this->db->get('port_ttm_tap t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualTap($cond = '', $year = '', $dates = '') {
        if ($cond != 'null') {
            $whereArray[] = $cond;
        }
        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        $this->db->where(array('t1.focus_area !=' => 0,'t1.contract_amount !=' => '','t1.status !=' => '3', 't1.financial_year' => $year, 't1.month_engaged !=' => '0000-00-00'));
        if ($dates != '') {
            $this->db->where($dates);
        }

        $partner_id = $this->session->userdata('partner_id');
//        $this->db->where(array('t1.finance_id' => '3', 't1.status' => '1'));
        $this->db->where(array('t3.partner_id' => (int) $partner_id));
        $this->db->select('t1.id,t1.financial_year, MONTH(t1.month_engaged) as month');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.port_tap_id,t1.port_tap_id,t1.requirement, t1.firm_engaged");
		//$this->db->distinct("t1.id");
        $result = $this->db->get('plan_tap t1');
		//debug_last_query();die;
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetPartnerships($cond = '', $year = '', $dates = '') {
        if ($cond != 'null') {
            $whereArray[] = $cond;
        }
        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        $this->db->where('t1.status', '1');

        if ($year != '') {
            $this->db->where('t1.financial_year', $year);
        }

        if ($dates != '') {
            $this->db->where($dates);
        }

        $partner_id = $this->session->userdata('partner_id');
//        $this->db->where(array('t1.finance_id' => '3', 't1.status' => '1'));
        $this->db->where(array('t3.partner_id' => (int) $partner_id));
        $this->db->select("t1.financial_year, YEAR(t1.need_by) as need_yr, count(CASE WHEN MONTH(t1.need_by) = 4 THEN 1 END) as apr,
            count(CASE WHEN MONTH(t1.need_by) = 5 THEN 1 END) as may,
            count(CASE WHEN MONTH(t1.need_by) = 6 THEN 1 END) as jun,
            count(CASE WHEN MONTH(t1.need_by) = 7 THEN 1 END) as jul,
            count(CASE WHEN MONTH(t1.need_by) = 8 THEN 1 END) as aug,
            count(CASE WHEN MONTH(t1.need_by) = 9 THEN 1 END) as sep,
            count(CASE WHEN MONTH(t1.need_by) = 10 THEN 1 END) as oct,
            count(CASE WHEN MONTH(t1.need_by) = 11 THEN 1 END) as nov,
            count(CASE WHEN MONTH(t1.need_by) = 12 THEN 1 END) as 'dec',
            count(CASE WHEN MONTH(t1.need_by) = 1 THEN 1 END) as jan,
            count(CASE WHEN MONTH(t1.need_by) = 2 THEN 1 END) as feb,
            count(CASE WHEN MONTH(t1.need_by) = 3 THEN 1 END) as mar");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
//        $this->db->group_by("t1.financial_year");
        $result = $this->db->get('port_ttm_partnership t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getActualPartnerships($cond = '', $year = '', $dates = '') {
        if ($cond != 'null') {
            $whereArray[] = $cond;
        }
        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        $this->db->where(array('t1.status !=' => '3', 't1.financial_year' => $year, 't1.need_by !=' => 0));
        if ($dates != '') {
            $this->db->where($dates);
        }

        $partner_id = $this->session->userdata('partner_id');
//        $this->db->where(array('t1.finance_id' => '3', 't1.status' => '1'));
        $this->db->where(array('t3.partner_id' => (int) $partner_id));
        $this->db->select("t1.financial_year, count(CASE WHEN MONTH(t1.need_by) = 4 THEN 1 END) as apr,
            count(CASE WHEN MONTH(t1.need_by) = 5 THEN 1 END) as may,
            count(CASE WHEN MONTH(t1.need_by) = 6 THEN 1 END) as jun,
            count(CASE WHEN MONTH(t1.need_by) = 7 THEN 1 END) as jul,
            count(CASE WHEN MONTH(t1.need_by) = 8 THEN 1 END) as aug,
            count(CASE WHEN MONTH(t1.need_by) = 9 THEN 1 END) as sep,
            count(CASE WHEN MONTH(t1.need_by) = 10 THEN 1 END) as oct,
            count(CASE WHEN MONTH(t1.need_by) = 11 THEN 1 END) as nov,
            count(CASE WHEN MONTH(t1.need_by) = 12 THEN 1 END) as 'dec',
            count(CASE WHEN MONTH(t1.need_by) = 1 THEN 1 END) as jan,
            count(CASE WHEN MONTH(t1.need_by) = 2 THEN 1 END) as feb,
            count(CASE WHEN MONTH(t1.need_by) = 3 THEN 1 END) as mar");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.financial_year");
        $result = $this->db->get('plan_partnerships t1');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getTargetDpMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.dp_plan');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('port_diagnostic_panels t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTargetDpExMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.dp_external');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('port_diagnostic_panels t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMonthlyActualDpExMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.purpose !=' => '', 't1.status !=' => '3'));
        $this->db->select('t1.month, t1.financial_year, count(t1.month) as dps, external_attendees');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.month,t1.financial_year");
        $query = $this->db->get('plan_dp t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMonthlyActualDpMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.purpose !=' => '', 't1.status !=' => '3'));
        $this->db->select('t1.month, t1.financial_year, count(t1.month) as dps');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.month,t1.financial_year");
        $query = $this->db->get('plan_dp t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualDpMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }

        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.purpose !=' => '', 't1.status !=' => '3'));
        $this->db->select("count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as q1,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as q2,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as q3,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as q4,
            count(CASE WHEN t1.month BETWEEN 1 AND 12 THEN 1 END) as annual");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('plan_dp t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTargetTeamHiring($cond = '', $startDate = '', $year = '', $status = '', $column_name = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select("t1.id, t1.financial_year,t1.$column_name");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->distinct();
        $query = $this->db->get('port_team t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMonthlyActualTeamHiring($cond = '', $startDate = '', $year = '', $status = '', $field_type = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }
        if ($field_type != '') {
            $this->db->where('field_type', $field_type);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t1.month, t1.financial_year, count(t1.month) as t_count');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.month,t1.financial_year");
        $query = $this->db->get('plan_team t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualTeamHiring($cond = '', $startDate = '', $year = '', $status = '', $field_type = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }
        if ($field_type != '') {
            $this->db->where('field_type', $field_type);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }

        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select("count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as q1,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as q2,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as q3,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as q4,
            count(CASE WHEN t1.month BETWEEN 1 AND 12 THEN 1 END) as annual");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        // $this->db->group_by("t2.inv_id");
        $query = $this->db->get('plan_team t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getTargetBoardMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.status' => '1'));
        $this->db->select('t1.financial_year, t1.meeting_plan');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('port_board_meetings t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getMonthlyActualBoardMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.meeting_type !=' => '', 't1.status !=' => '3'));
        $this->db->select('t1.month, t1.financial_year, count(t1.month) as board');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.month,t1.financial_year");
        $query = $this->db->get('plan_board_meetings t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualBoardMeeting($cond = '', $startDate = '', $year = '', $status = '') {
        $get_month_list = $this->month();
        $get_actual_month = $this->getActualMonthNumber();
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-04-01";
            $end_date = $end_year . "-04-01";
            $cond = "t1.created_at > '$start_date' and t1.created_at < '$end_date'";
            $this->db->where($cond);
        }

        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('t3.partner_id' => (int) $partner_id, 't1.meeting_type !=' => '', 't1.status !=' => '3'));
        $this->db->select("count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[0]] . " AND " . $get_actual_month[$get_month_list[2]] . " THEN 1 END) as q1,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[3]] . " AND " . $get_actual_month[$get_month_list[5]] . " THEN 1 END) as q2,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[6]] . " AND " . $get_actual_month[$get_month_list[8]] . " THEN 1 END) as q3,
            count(CASE WHEN t1.month BETWEEN " . $get_actual_month[$get_month_list[9]] . " AND " . $get_actual_month[$get_month_list[11]] . " THEN 1 END) as q4,
            count(CASE WHEN t1.month BETWEEN 1 AND 12 THEN 1 END) as annual");
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('port_company_data t3', 't3.inv_id = t1.inv_id', 'left');
        $query = $this->db->get('plan_board_meetings t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getActualTapMonthly($cond = '', $startDate = '', $year = '', $status = '') {
        if ($cond != null) {
            $whereArray[] = $cond;
        }

        $whereCond = implode(' and ', $whereArray);
        if ($whereCond != '') {
            $this->db->where($whereCond);
        }

        if ($startDate == '' && $year != '') {
            $end_year = $year + 1;
            $start_date = $year . "-03-31";
            $end_date = $end_year . "-04-01";
            $cond = "t1.month_engaged > '$start_date' and t1.month_engaged < '$end_date'";
            $this->db->where($cond);
        }
        $partner_id = $this->session->userdata('partner_id');

        $this->db->where(array('t2.partner_id' => (int) $partner_id, 't1.status !=' => '3', 't1.month_engaged !=' => '0000-00-00'));
        $this->db->select("count(CASE WHEN MONTH(t1.month_engaged) = 4 THEN 1 END) as apr,
            count(CASE WHEN MONTH(t1.month_engaged) = 5 THEN 1 END) as may,
            count(CASE WHEN MONTH(t1.month_engaged) = 6 THEN 1 END) as jun,
            count(CASE WHEN MONTH(t1.month_engaged) = 7 THEN 1 END) as jul,
            count(CASE WHEN MONTH(t1.month_engaged) = 8 THEN 1 END) as aug,
            count(CASE WHEN MONTH(t1.month_engaged) = 9 THEN 1 END) as sep,
            count(CASE WHEN MONTH(t1.month_engaged) = 10 THEN 1 END) as oct,
            count(CASE WHEN MONTH(t1.month_engaged) = 11 THEN 1 END) as nov,
            count(CASE WHEN MONTH(t1.month_engaged) = 12 THEN 1 END) as 'dec',
            count(CASE WHEN MONTH(t1.month_engaged) = 1 THEN 1 END) as jan,
            count(CASE WHEN MONTH(t1.month_engaged) = 2 THEN 1 END) as feb,
            count(CASE WHEN MONTH(t1.month_engaged) = 3 THEN 1 END) as mar");
        $this->db->join('port_company_data t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->group_by("t1.requirement, t1.firm_engaged");
        $query = $this->db->get('plan_tap t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getAssignedSectorDetails($emp_id = '') {
        if ($emp_id != '') {
            $this->db->where(array('AA.associate_employee' => $emp_id, 'AA.status' => '1'));
        }
        $partner_id = $this->session->userdata('partner_id');
        $this->db->where(array('IP.partner_id' => (int) $partner_id, 't1.status !=' => '3'));
        $this->db->select('t2.sector');
        $this->db->join('port_business t2', 't2.inv_id = t1.inv_id', 'left');
        $this->db->join('assign_associate AA', 'AA.innovation = t1.inv_id', 'left');
        $this->db->join('innovation_pool IP', 'IP.id = t1.inv_id', 'left');
        $this->db->group_by("t2.sector");
        $query = $this->db->get('port_company_data t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getSummary_SectorName($id) {
        $this->db->select("sector");
        $this->db->where('id', $id);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getConversationDetails($condition = '', $sector_id = '', $quarter = '') {
        if ($condition != '') {
            $this->db->where($condition);
        }

        if ($sector_id != '') {
            $sec_cond = "(sector_id = $sector_id or sector_id = 0)";
            $this->db->where($sec_cond);
        }

        if ($quarter != '') {
            $this->db->where($quarter);
        }

        $this->db->select('emp_name, comments, created_at');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('port_chart_conversation');
        $rows = $query->result_array();
        return $rows;
    }

    public function graphLabelOption($status, $emp_number) {
        $data['graph_label'] = $status;
        $this->db->where('emp_id', $emp_number);
        $result = $this->db->update('hr_user_login', $data);
        return $result;
    }

    /* new chart changes */

    public function getQualitativeChart($table, $condition, $selects, $status) {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($status != '') {
            $this->db->where(array('status' => $status));
        }
        // $expld = explode(', ', $selects);
        // $expld[] = 'created_at';
        // $fields = implode(', ', $expld);

        $this->db->select($selects);
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getQualitativeActualChart($table, $fields, $condition, $months, $status) {
        if ($condition != '') {
            $this->db->where($condition);
        }
        if ($months != '') {
            $this->db->where($months);
        }
        if ($status == 3) {
            $this->db->where(array('status !=' => $status));
        } else if ($status != '') {
            $this->db->where(array('status' => $status));
        }

        $this->db->select($fields);
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getIRIScode($inv_id, $f_year, $field, $gender, $partner) {
        if ($field != '') {
            $this->db->where('field_type', $field);
        }
        if ($gender != '') {
            $this->db->where('gender', $gender);
        }
        $this->db->where(array('inv_id' => $inv_id, 'financial_year' => $f_year, 't1.status' => '1'));
        $this->db->select('t2.name');
        $this->db->join('port_impact_master t2', 't2.id = t1.iris_code', 'left');
        $query = $this->db->get('port_impact_metric t1');
        $rows = $query->result_array();
        return $rows[0];
    }

    public function getShortlistStatus($emp_id, $inv_id) {
        $this->db->where(array('inv_id' => $inv_id, 'created_by' => $emp_id, 'status' => '1'));
        $this->db->select('application_status');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('shortlist_comments');
        $rows = $query->result_array();
        return $rows[0];
    }

    public function getShortlistfilter($emp_id, $stat = '') {
        if ($stat != '') {
            $split_status = explode(', ', $stat);
            $merge_status = "'" . implode("','", $split_status) . "'";

            $app_stats = "application_status NOT IN($merge_status)";
            $curr_stats = "current_app_status NOT IN($merge_status)";
            $this->db->where($app_stats);
            $this->db->where($curr_stats);
        }
        $this->db->where(array('created_by' => $emp_id));
        $this->db->select("GROUP_CONCAT(DISTINCT inv_id SEPARATOR ', ') as invid", false);
        $this->db->distinct();
        // $this->db->order_by('id', 'desc');
        // $this->db->limit(1);
        $query = $this->db->get('shortlist_comments');
        // debug_last_query();die;
        $rows = $query->result_array();
        return $rows;
    }

    public function getIncWebsite($id) {
        $this->db->select('INV.website as inc_website, PS.website as pitch_website');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user PU', 'PU.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2 PS', 'PS.pitch_id = PU.pitch_id', 'left');
        $this->db->from('innovation_pool IP');
        $this->db->where(array("IP.id" => "$id"));
        $query = $this->db->get();
        $rows = $query->result_array();
        return $rows;
    }

    public function get_appStatus($id) {
        $this->db->select('status');
        $this->db->where('id', $id);
        $query = $this->db->get('innovation_pool');
        return $query->result_array();
    }

}
