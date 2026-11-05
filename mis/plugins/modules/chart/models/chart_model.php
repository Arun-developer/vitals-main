<?php

class Chart_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getSectorCount($from_date, $to_date, $sub_start_date, $sub_end_date) {
        $this->db->select('IU.ent_sector, count(*)');
        $this->db->from('inv_user IU');
        $this->db->where('IU.ent_sector REGEXP "^[0-9]+$"');
        $this->db->join('innovation_pool IP', 'IP.innovation_id = IU.inv_no');
        $where = '(IP.status="3" or IP.status = "12")';
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->where($where);

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d", strtotime($sub_start_date));
            $to = date("Y-m-d", strtotime($sub_end_date));
            $this->db->where('IU.submitted_date >=', $from);
            $this->db->where('IU.submitted_date <=', $to);
        }
        $this->db->group_by('IU.ent_sector');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getPitchSector($from_date, $to_date, $sub_start_date, $sub_end_date) {
        $this->db->select('PS.sector, count(*)');
        $this->db->from('pitch_step2 PS');
//        $this->db->where('PS.sector REGEXP "^[0-9]+$"');
        $this->db->join('pitch_user PU', 'PU.pitch_id = PS.pitch_id');
        $this->db->join('innovation_pool IP', 'IP.innovation_id = PU.inno_id');
        $where = '(IP.status="3" or IP.status = "12")';
        $this->db->where($where);
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));

        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('PU.submitted_date >=', $last_three_months);
            $this->db->where('PU.submitted_date <=', $curDate);
        }

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($sub_start_date));
            $to = date("Y-m-d 23:59:59", strtotime($sub_end_date));
            $this->db->where('PU.submitted_date >=', $from);
            $this->db->where('PU.submitted_date <=', $to);
        }
        $this->db->group_by('PS.sector');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getDonor($from_date, $to_date, $sub_start_date, $sub_end_date) {
        $this->db->select('GF.donor_fit, count(*) as count');
        $this->db->from('grading_feedback GF');
        $this->db->where('GF.donor_fit != ""');
        $this->db->join('innovation_pool IP', 'IP.id = GF.innovation_id');
        $this->db->join('inv_user IU', 'IU.inv_no = IP.innovation_id');
        $where = '(IP.status="3" or IP.status = "12" or IP.status = "13" or IP.status = "14")';
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->where($where);
        $this->db->where($where);

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d", strtotime($sub_start_date));
            $to = date("Y-m-d", strtotime($sub_end_date));
            $this->db->where('IU.submitted_date >=', $from);
            $this->db->where('IU.submitted_date <=', $to);
        }
        $this->db->group_by('GF.donor_fit');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getPitchDonor($from_date, $to_date, $sub_start_date, $sub_end_date) {
        $this->db->select('GF.donor_fit, count(*) as count');
        $this->db->from('grading_feedback GF');
        $this->db->where('GF.donor_fit != ""');
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->join('innovation_pool IP', 'IP.id = GF.innovation_id');
        $this->db->join('pitch_user PU', 'PU.inno_id = IP.innovation_id');
        $where = '(IP.status="3" or IP.status = "12" or IP.status = "13" or IP.status = "14")';
        $this->db->where($where);

        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('PU.submitted_date >=', $last_three_months);
            $this->db->where('PU.submitted_date <=', $curDate);
        }

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($sub_start_date));
            $to = date("Y-m-d 23:59:59", strtotime($sub_end_date));
            $this->db->where('PU.submitted_date >=', $from);
            $this->db->where('PU.submitted_date <=', $to);
        }

        $this->db->group_by('GF.donor_fit');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getCityCount($from_date, $to_date, $sub_start_date, $sub_end_date) {
        $this->db->select('PU.city,PS.sector, count(*) as all_count');
        $this->db->from('pitch_step2 PS');
        // $this->db->where('PS.sector REGEXP "^[0-9]+$"');
        $this->db->join('pitch_user PU', 'PU.pitch_id = PS.pitch_id');
        $this->db->where('PU.city != ""');
        $this->db->join('innovation_pool IP', 'IP.innovation_id = PU.inno_id');
        $where = '(IP.status="3" or IP.status = "12")';
        $this->db->where($where);
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));

        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('PU.submitted_date >=', $last_three_months);
            $this->db->where('PU.submitted_date <=', $curDate);
        }

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($sub_start_date));
            $to = date("Y-m-d 23:59:59", strtotime($sub_end_date));
            $this->db->where('PU.submitted_date >=', $from);
            $this->db->where('PU.submitted_date <=', $to);
        }
        $this->db->group_by('PS.sector');
        $this->db->group_by('PU.city');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getCity() {
        $this->db->select('PU.city');
        $this->db->from('pitch_user PU');
        $this->db->join('pitch_step2 PS', 'PS.pitch_id = PU.pitch_id');
        // $this->db->where('PS.sector REGEXP "^[0-9]+$"');
        $this->db->where('PU.city != ""');
        $this->db->group_by('PU.city');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getInchargeStatus($from_date, $to_date, $sub_start_date, $sub_end_date, $stage) {
        $this->db->select("AA.associate_employee as Emp_id, count(AA.id) as All_count, SUM(CASE WHEN INV.status = '12' THEN 1 ELSE 0 END) as Open_count,SUM(CASE WHEN INV.status = '3' THEN 1 ELSE 0 END) as Close_count,SUM(CASE WHEN INV.status = '13' THEN 1 ELSE 0 END) as Open_IIC,SUM(CASE WHEN INV.status = '14' THEN 1 ELSE 0 END) as Close_IIC", false);
        $this->db->from('innovation_pool INV');
        $this->db->join('assign_associate AA', 'AA.innovation = INV.id');
        $this->db->join('inv_user IU', 'IU.inv_no = INV.innovation_id');
        $this->db->where('INV.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->where('AA.associate_employee > 0');

        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('IU.submitted_date >=', $last_three_months);
            $this->db->where('IU.submitted_date <=', $curDate);
        }

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('INV.created_date >=', $from);
            $this->db->where('INV.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($sub_start_date));
            $to = date("Y-m-d 23:59:59", strtotime($sub_end_date));
            $this->db->where('IU.submitted_date >=', $from);
            $this->db->where('IU.submitted_date <=', $to);
        }
        if ($stage != '') {
            $this->db->where('INV.stage =', $stage);
        }

        $status = "INV.status IN('3','12','13','14')";

        $this->db->where('AA.status', 1);
        $this->db->where($status);
        $this->db->group_by('AA.associate_employee');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getInchargeStatus_Pitch($from_date, $to_date, $sub_start_date, $sub_end_date, $stage) {
        $this->db->select("AA.associate_employee as Emp_id, count(AA.associate_employee) as All_count, SUM(CASE WHEN INV.status = '12' THEN 1 ELSE 0 END) as Open_count,SUM(CASE WHEN INV.status = '3' THEN 1 ELSE 0 END) as Close_count,SUM(CASE WHEN INV.status = '13' THEN 1 ELSE 0 END) as Open_IIC,SUM(CASE WHEN INV.status = '14' THEN 1 ELSE 0 END) as Close_IIC", false);
        $this->db->from('innovation_pool INV');
        $this->db->join('pitch_user PU', 'PU.inno_id = INV.innovation_id');
        $this->db->join('assign_associate AA', 'AA.innovation = INV.id');

        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('PU.submitted_date >=', $last_three_months);
            $this->db->where('PU.submitted_date <=', $curDate);
        }

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('INV.created_date >=', $from);
            $this->db->where('INV.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($sub_start_date));
            $to = date("Y-m-d 23:59:59", strtotime($sub_end_date));
            $this->db->where('PU.submitted_date >=', $from);
            $this->db->where('PU.submitted_date <=', $to);
        }
        if ($stage != '') {
            $this->db->where('INV.stage =', $stage);
        }

        $status = "INV.status IN('3','12','13','14')";

        $this->db->where('AA.status', 1);
        $this->db->where('INV.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->where($status);
        $this->db->group_by('AA.associate_employee');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getStageSectorCount($from_date, $to_date, $sub_start_date, $sub_end_date) {

        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $sfrom = date("Y-m-d 00:00:00", strtotime($sub_start_date));
            $sto = date("Y-m-d 23:59:59", strtotime($sub_end_date));
            $this->db->where('IU.submitted_date >=', $sfrom);
            $this->db->where('IU.submitted_date <=', $sto);
        }
        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('IU.submitted_date >=', $last_three_months);
            $this->db->where('IU.submitted_date <=', $curDate);
        }

        $data = array();
        $this->db->select("IP.stage,IU.ent_sector as sector, count(*) as all_count, SUM(CASE WHEN IP.status = '12' THEN 1 ELSE 0 END) as Open_count, SUM(CASE WHEN IP.status = '3' THEN 1 ELSE 0 END) as Close_count,SUM(CASE WHEN IP.status = '13' THEN 1 ELSE 0 END) as Open_IIC,SUM(CASE WHEN IP.status = '14' THEN 1 ELSE 0 END) as Close_IIC", false);
        $this->db->from('innovation_pool IP');
        $this->db->join('inv_user IU', 'IU.inv_no = IP.innovation_id');
        $this->db->where('IU.ent_sector REGEXP "^[0-9]+$"');
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->group_by('IP.stage');
        $this->db->group_by('IU.ent_sector');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function getStageSectorCount_Pitch($from_date, $to_date, $sub_start_date, $sub_end_date) {
        if ($from_date != '' && $to_date != '') {
            $from = date("Y-m-d 00:00:00", strtotime($from_date));
            $to = date("Y-m-d 23:59:59", strtotime($to_date));
            $this->db->where('IP.created_date >=', $from);
            $this->db->where('IP.created_date <=', $to);
        }
        if ($sub_start_date != '' && $sub_end_date != '') {
            $sfrom = date("Y-m-d", strtotime($sub_start_date));
            $sto = date("Y-m-d", strtotime($sub_end_date));
            $this->db->where('PU.submitted_date >=', $sfrom . ' 00:00:00');
            $this->db->where('PU.submitted_date <=', $sto . ' 23:59:59');
        }
        if ($from_date == '' && $to_date == '' && $sub_start_date == '' && $sub_end_date == '') {
            $curDate = date("Y-m-d 23:59:59");
            $last_three_months = date("Y-m-d 00:00:00", strtotime("-2 months"));
            $this->db->where('PU.submitted_date >=', $last_three_months);
            $this->db->where('PU.submitted_date <=', $curDate);
        }

        $data = array();
        $this->db->select("IP.stage,PS.sector, count(*) as all_count, SUM(CASE WHEN IP.status = '12' THEN 1 ELSE 0 END) as Open_count, SUM(CASE WHEN IP.status = '3' THEN 1 ELSE 0 END) as Close_count,SUM(CASE WHEN IP.status = '13' THEN 1 ELSE 0 END) as Open_IIC,SUM(CASE WHEN IP.status = '14' THEN 1 ELSE 0 END) as Close_IIC", false);
        $this->db->from('innovation_pool IP');
        $this->db->join('pitch_user PU', 'PU.inno_id = IP.innovation_id');
        $this->db->join('pitch_step2 PS', 'PS.pitch_id = PU.pitch_id');
//        $this->db->where('PS.sector REGEXP "^[0-9]+$"');
        $this->db->where('IP.partner_id', (int) $this->session->userdata('partner_id'));
        $this->db->group_by('IP.stage');
        $this->db->group_by('PS.sector');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

}
